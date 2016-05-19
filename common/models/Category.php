<?php

namespace common\models;

class Category extends \yii\db\ActiveRecord {
	
	public static function findIdentity($id) {
		return static::findOne(['id' => $id]);
	}
	
    public static function getAll() {
        return static::find()->orderBy('ordn')->all();
    }
    
    public static function tableName() {
    	return 'categories';
    }
}
