<?php

namespace common\models;

class Project extends \yii\db\ActiveRecord {

	public static $PAGE_SIZE = 60;
	
	public $master;
	
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

    public static function countProjects($categoryId = null) {
    	$query = static::find();
    	if ($categoryId != null){
    		$query = $query->where(['categoryId' => $categoryId]);
    	}
    	return $query->count();
    }
    
    public static function tableName() {
    	return 'projects';
    }
}
