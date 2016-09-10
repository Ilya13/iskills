<?php

namespace common\models;

use common\utils\ImageUtil;

class Proposal extends \yii\db\ActiveRecord {
	
	public $avatar;
	public $firstName;
	public $lastName;
	public $shop;
	public $placeName;
	
	public static function findIdentity($id) {
		return static::findOne(['id' => $id]);
	}

	public static function findByOrder($orderId) {
		$sql = 'select t1.*, t2.firstName, t2.lastName '
				.'from '.static::tableName().' t1, '.User::tableName().' t2 '
			   .'where 	   t1.masterId = t2.id '
					 .'and t1.orderId = :orderId '
			.'order by t1.id';
		
		return static::findBySql($sql, ['orderId' => $orderId])->all();
	}

	public static function findByOrderAndMaster($orderId, $masterId) {
		$sql = 'select t1.*, t2.firstName, t2.lastName, t2.shop, t3.name placeName '
				.'from '.static::tableName().' t1, '.User::tableName().' t2, '.Place::tableName().' t3 '
			   .'where 	   t1.masterId = t2.id '
					 .'and t2.placeId = t3.place_id '
					 .'and t1.orderId = :orderId '
					 .'and t1.masterId = :masterId '
			.'order by t1.id';
		
		return static::findBySql($sql, ['orderId' => $orderId, 'masterId' => $masterId])->one();
	}
		
    public function afterFind() {
    	parent::afterFind();
    	$this->avatar = ImageUtil::getUserAvatar($this->masterId);
    }
    
    public function fields() {
    	$fields = parent::fields();
    	$fields['avatar'] = 'avatar';
    	$fields['firstName'] = 'firstName';
    	$fields['lastName'] = 'lastName';
    	$fields['shop'] = 'shop';
    	$fields['placeName'] = 'placeName';
    
    	return $fields;
    }
    
    public function toJson(){
    	return json_encode($this->getAttributes(array('id','orderId','masterId','estimated','schedules','price','firstName','lastName','avatar','shop','placeName')));
    }

	public static function tableName() {
		return 'proposals';
	}
}