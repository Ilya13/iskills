<?php

namespace common\models;

class Order extends \yii\db\ActiveRecord {

	const STATUS_CLOSED = 0;
	const STATUS_ACTIVE = 10;
	const STATUS_FINISHED = 20;
	
	public function rules(){
		return [
				['status', 'default', 'value' => self::STATUS_ACTIVE],
				['status', 'in', 'range' => [self::STATUS_FINISHED, self::STATUS_ACTIVE, self::STATUS_CLOSED]],
		];
	}
	
	public static function findIdentity($id) {
		return static::findOne(['id' => $id]);
	}
    
	public static function getActiveOrders($userId){
		return static::getOrdersByStatus($userId, static::STATUS_ACTIVE);
	}

	public static function getClosedOrders($userId){
		return static::getOrdersByStatus($userId, static::STATUS_CLOSED);
	}

	public static function getFinishedOrders($userId){
		return static::getOrdersByStatus($userId, static::STATUS_FINISHED);
	}

	public static function getOrdersByStatus($userId, $status){
		return static::findAll(['userId' => $userId, 'status' => $status]);
	}
	
    public static function tableName() {
    	return 'orders';
    }
    
    public function toJson(){
    	return json_encode($this->getAttributes(array('id','projectId','name','size','materials','details','status','createDate','closeDate','rangeMin','rangeMax')));
    }
}
