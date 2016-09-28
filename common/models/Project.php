<?php

namespace common\models;

class Project extends \yii\db\ActiveRecord {

	public static $PAGE_SIZE = 60;
	public static $PAGE_MIN_SIZE = 20;
	
	public $master;
	public $category;
	
	public static function findIdentity($id) {
		return static::findOne(['id' => $id]);
	}
	
    public static function getAll() {
        $projects = static::find()->limit(static::$PAGE_SIZE)->orderBy(['orderCount' => SORT_DESC])->all();
        
        foreach ($projects as $project){
        	$project->master = User::findIdentity($project->masterId);
        }
        
        return $projects;
    }
	
    public static function getByCategory($id, $page = 0) {
        $projects = static::find()
        	->where(['categoryId' => $id])
        	->limit(static::$PAGE_SIZE)
        	->offset($page*static::$PAGE_SIZE)
        	->orderBy(['orderCount' => SORT_DESC])
        	->all();
        
        foreach ($projects as $project){
        	$project->master = User::findIdentity($project->masterId);
        }
        
        return $projects;
    }

    public static function countCategoryProjects($categoryId) {
    	$query = static::find();
    	if ($categoryId != null){
    		$query = $query->where(['categoryId' => $categoryId]);
    	}
        
    	return $query->count();
    }
	
    public static function getByMaster($id, $page = 1) {
    	if ($page == null) $page = 1;
        $projects = static::find()
        	->where(['masterId' => $id])
        	->limit(static::$PAGE_MIN_SIZE)
        	->offset(($page-1)*static::$PAGE_MIN_SIZE)
        	->orderBy(['orderCount' => SORT_DESC])
        	->all();
        
        foreach ($projects as $project){
        	$project->category = Category::findIdentity($project->categoryId);
        }
		
        return $projects;
    }

    public static function countMasterProjects($masterId) {
    	$query = static::find();
    	if ($masterId != null){
    		$query = $query->where(['masterId' => $masterId]);
    	}
    	return $query->count();
    }
    
    public static function tableName() {
    	return 'projects';
    }
}
