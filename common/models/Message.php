<?php

namespace common\models;

use Yii;
use common\utils\ImageUtil;
use common\models\User;

class Message extends \yii\db\ActiveRecord {
	
	public $avatar;
	public $interlocutor;
	public $dateStr;
	
	public function getInterlocutor() {
		$id = Yii::$app->user->identity->master ? 'userId' : 'masterId';
		return $this->hasOne(User::className(), ['id' => $id]);
	}
	
	public static function findIdentity($id) {
		return static::findOne(['id' => $id]);
	}
	
    public static function getAll($orderId) {
        return static::find()->where(['orderId' => $orderId])->orderBy('date')->all();
    }
	
    public static function getLast($orderId) {
		$userId = Yii::$app->user->identity->master ? 'userId' : 'masterId';
    	$sql = 'select t1.*, concat(t3.firstName, " ", t3.lastName) as interlocutor '
    			.'from '.static::tableName().' t1, '
    		 	      .'(select orderId, max(date) date '
    			 	  	 .'from '.static::tableName().' '
    			 	  	.'where orderId=:orderId group by masterId) t2, '
    			 	  .User::tableName().' t3 '
			   .'where t1.orderId = t2.orderId '
			   	 .'and t1.date = t2.date '
			   	 .'and t1.'.$userId.' = t3.id';
        return static::findBySql($sql, [':orderId' => $orderId])->all();
    }
	
    public static function getDialog($orderId, $interlocutor) {
        return static::find()->where([
        		'orderId' => $orderId, 
        		Yii::$app->user->identity->master?'userId':'masterId' => $interlocutor
        ])->orderBy('date')->all();
    }
    
    public static function tableName() {
    	return 'messages';
    }
    
    public function afterFind() {
    	parent::afterFind();
    	$this->avatar = ImageUtil::getUserAvatar($this->author);
    	$dateTime = strtotime($this->date);
    	$now = time();
    	Yii::info('date1: '.($now-(60*60*24)).', date2:'.$dateTime);
    	if (($now-(60*60*24)) < $dateTime){
    		$this->dateStr = date('H:i', $dateTime);
    	} else if (($now-(60*60*24*2)) < $dateTime){
    		$this->dateStr = 'вчера';
    	} else {
    		$this->dateStr = date('d.m.Y', $dateTime);
    	}
    }
    
    public function fields() {
    	$fields = parent::fields();
    	$fields['avatar'] = 'avatar';
    	$fields['interlocutor'] = 'interlocutor';
    	$fields['dateStr'] = 'dateStr';
    
    	return $fields;
    }
    
    public function toJson(){
    	return json_encode($this->getAttributes(array('id','userId','masterId','orderId','text','date','author','interlocutor','avatar','dateStr')));
    }
}
