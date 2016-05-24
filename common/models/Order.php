<?php

namespace common\models;

class Order extends \yii\db\ActiveRecord {

	const STATUS_CLOSED = 0;
	const STATUS_ACTIVE = 10;
	const STATUS_FINISHED = 20;
	
	public $statusName;
	
	public function rules(){
		return [
				['status', 'default', 'value' => self::STATUS_ACTIVE],
				['status', 'in', 'range' => [self::STATUS_FINISHED, self::STATUS_ACTIVE, self::STATUS_CLOSED]],
		];
	}
	
	public function afterFind() {
		if ($this->createDate != null){
			$this->createDate = strtotime ($this->createDate);
			$this->createDate = date ('d.m.Y', $this->createDate);
		}
		if ($this->closeDate != null){
			$this->closeDate = strtotime ($this->closeDate);
			$this->closeDate = date ('d.m.Y', $this->closeDate);
		}
		
		if ($this->status == static::STATUS_ACTIVE){
			$this->statusName = 'Активен';
		} else if ($this->status == static::STATUS_CLOSED){
			$this->statusName = 'Закрыт';
		} else if ($this->status == static::STATUS_FINISHED){
			$this->statusName = 'Завершен';
		}
		
		parent::afterFind();
	}
	
	public function beforeValidate() {
		if ($this->createDate != null){
			$this->createDate = strtotime($this->createDate);
			$this->createDate = date('Y-m-d', $this->createDate);
		}
		if ($this->closeDate != null){
			$this->closeDate = strtotime($this->closeDate);
			$this->closeDate = date('Y-m-d', $this->closeDate);
		}
		
		return parent::beforeValidate();
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
    	return json_encode($this->getAttributes(array('id','projectId','name','size','materials','details','status','statusName','createDate','closeDate','rangeMin','rangeMax')));
    }
}
