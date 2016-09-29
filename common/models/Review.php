<?php

namespace common\models;

class Review extends \yii\db\ActiveRecord {
	
	public static $PAGE_MIN_SIZE = 5;
	
	public $user;
	public $project;
	
	public static function findIdentity($id) {
		return static::findOne(['id' => $id]);
	}

	public static function getByMaster($id, $page = 1) {
		if ($page == null) $page = 1;
		$reviews = static::find()
			->where(['masterId' => $id])
			->limit(static::$PAGE_MIN_SIZE)
			->offset(($page-1)*static::$PAGE_MIN_SIZE)
			->all();
		
		foreach ($reviews as $review){
			$review->user = User::findIdentity($review->userId);
			$review->project = Project::findIdentity($review->projectId);
			if ($review->date != null){
				$review->date = strtotime ($review->date);
				$review->date = date ('d.m.Y', $review->date);
			}
		}
		
		return $reviews;
	}

    public static function countMasterReviews($masterId, $value = null) {
    	$query = static::find();
    	if ($masterId != null){
    		$query = $query->where(['masterId' => $masterId]);
	    	if ($value != null){
	    		$query = $query->andWhere(['value' => $value]);
	    	}
    	}
    	return $query->count();
    }

	public static function tableName() {
		return 'reviews';
	}
}