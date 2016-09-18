<?php

namespace common\models;

class Review extends \yii\db\ActiveRecord {
		
	public static function findIdentity($id) {
		return static::findOne(['id' => $id]);
	}

	public static function findByMaster($masterId) {
		
		return static::findBySql($sql, ['orderId' => $orderId])->all();
	}

	public static function tableName() {
		return 'reviews';
	}
}