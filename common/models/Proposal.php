<?php

namespace common\models;

class Proposal extends \yii\db\ActiveRecord {

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

	public static function tableName() {
		return 'proposals';
	}
}