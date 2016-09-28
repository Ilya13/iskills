<?php

namespace common\models;

class Master extends \yii\db\ActiveRecord {
	
	public static function findIdentity($id) {
		return static::findOne(['userid' => $id]);
	}
	
    public static function tableName() {
    	return 'masters';
    }
    
    public function toJson(){
    	return json_encode($this->getAttributes(array('userid','about','shipping','rating')));
    }
}
