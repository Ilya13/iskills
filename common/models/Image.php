<?php

namespace common\models;

class Image extends \yii\db\ActiveRecord {
	
	public static function getUserImage($project) {
		return static::findOne(['userId' => $project->userId, 'projectId' => $project->id]);
	}
	
    public static function getProjectImages($project) {
        return static::find()->where(['userId' => $project->userId, 'projectId' => $project->id])->all();
    }
    
    public static function tableName() {
    	return 'images';
    }
}
