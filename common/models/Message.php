<?php

namespace common\models;

use Yii;
use common\utils\ImageUtil;
use common\models\User;

class Message extends \yii\db\ActiveRecord {
	
	public $avatar;
	public $interlocutorId;
	public $interlocutor;
	public $dateStr;
	public $timeStr;
	
	public static function findIdentity($id) {
		return static::findOne(['id' => $id]);
	}
	
    public static function getAll($orderId) {
        return static::find()->where(['orderId' => $orderId])->orderBy('date')->all();
    }
	
    public static function getLast($orderId, $last) {
		$userId = Yii::$app->user->identity->master ? 'userId' : 'masterId';
    	$sql = 'select t1.*, t3.id interlocutorId, concat(t3.firstName, " ", t3.lastName) as interlocutor '
    			.'from '.static::tableName().' t1, '
    		 	      .'(select orderId, max(date) date '
    			 	  	 .'from '.static::tableName().' '
    			 	  	.'where orderId=:orderId group by masterId) t2, '
    			 	  .User::tableName().' t3 '
			   .'where t1.orderId = t2.orderId '
			   	 .'and t1.date = t2.date '
			   	 .'and t1.'.$userId.' = t3.id '
			   	 .((isset($last)&&$last!=null)?'and t1.id > :last ':'')
			   .'order by t1.date desc';
    	$params = [':orderId' => $orderId];
    	if (isset($last) && $last != null) {
    		$params[':last'] = $last;
    	}
        return static::findBySql($sql, $params)->all();
    }
	
    public static function getDialog($orderId, $interlocutor, $last) {
        $query = static::find()->where(['orderId' => $orderId, 
        		Yii::$app->user->identity->master?'userId':'masterId' => $interlocutor]);
        if (isset($last) && $last != null){
        	$query = $query->andWhere(['>', 'id', $last]);
        }
    	return $query->orderBy('date')->all();
    }
    
    public static function tableName() {
    	return 'messages';
    }
    
    public function afterFind() {
    	parent::afterFind();
    	$this->avatar = ImageUtil::getUserAvatar(Yii::$app->user->identity->master?$this->userId:$this->masterId);
    	$dateTime = strtotime($this->date);
    	$now = strtotime('today midnight');
    	Yii::info('date1: '.$now.', date2:'.$dateTime);
    	if ($now <= $dateTime) {
    		$this->dateStr = 'сегодня';
    	} else if (($now-(60*60*24)) <= $dateTime){
    		$this->dateStr = 'вчера';
    	} else {
    		$this->dateStr = date('d.m.Y', $dateTime);
    	}
    	$this->timeStr = date('H:i', $dateTime);
    }
    
    public function fields() {
    	$fields = parent::fields();
    	$fields['avatar'] = 'avatar';
    	$fields['interlocutor'] = 'interlocutor';
    	$fields['interlocutorId'] = 'interlocutorId';
    	$fields['dateStr'] = 'dateStr';
    	$fields['timeStr'] = 'timeStr';
    
    	return $fields;
    }
    
    public function toJson(){
    	return json_encode($this->getAttributes(array('id','userId','masterId','orderId','text','date','author','interlocutor','interlocutorId','avatar','dateStr','timeStr')));
    }
}
