<?php

namespace common\models;

class Place extends \yii\db\ActiveRecord {
	
	public static function findIdentity($id) {
		return static::findOne(['place_id' => $id]);
	}
	
    public static function tableName() {
    	return 'place';
    }
    
    public function toJson(){
    	return json_encode($this->getAttributes(array('place_id','name')));
    }
}
