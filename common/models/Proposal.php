<?php

namespace common\models;

class Proposal extends \yii\db\ActiveRecord {

	public static function findIdentity($id) {
		return static::findOne(['id' => $id]);
	}

	public static function getUserProposals($id) {
		return static::findOne(['id' => $id]);
	}

	public static function tableName() {
		return 'proposals';
	}
}