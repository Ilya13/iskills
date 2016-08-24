<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Order;
use common\models\User;
use common\models\Message;
use yii\web\Response;
use frontend\models\OrderForm;

/**
 * User controller
 */
class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
    	Yii::$app->response->format = Response::FORMAT_JSON;
    	 
    	if (Yii::$app->user->isGuest) {
    		return null;
    	}
    	$request = Yii::$app->request;
    	$id = $request->get('id');
    	 
    	$order = Order::findIdentity($id);
    	if($order !== null && $order->userId === Yii::$app->user->getId()){
    		return $order;
    	}
    	return null;
    }
    
    public function actionStatus() {
    	Yii::$app->response->format = Response::FORMAT_JSON;
    	
    	if (Yii::$app->user->isGuest) {
    		return null;
    	}
    	$request = Yii::$app->request;
    	$id = $request->get('id');
    	$status = $request->get('status');
    	
    	$order = Order::findIdentity($id);
    	if($order !== null && $order->userId === Yii::$app->user->getId()){
    		if ($status == Order::STATUS_CLOSED ||
    				$status == Order::STATUS_ACTIVE ||
    				$status == Order::STATUS_FINISHED) {
    			$order->status = $status;
    			if ($status == Order::STATUS_CLOSED){
    				$order->closeDate = date("Y-m-d H:i:s");
    			}
    			$order->save();
    			$order->afterFind();
    			return $order;
    		}
    	}
        return null;
    }
    
    public function actionEdit($id) {
    	Yii::$app->response->format = Response::FORMAT_JSON;
    	 
    	if (Yii::$app->user->isGuest) {
    		return null;
    	}
    	$request = Yii::$app->request;
    	
    	$model = new OrderForm();
    	if ($model->load($request->post())) {
    		$order = $model->edit($id);
    		if ($order){
    			return $order;
    		}
    	}
        return null;
    }
    
    public function actionDialogs() {
    	Yii::$app->response->format = Response::FORMAT_JSON;
    	 
    	if (Yii::$app->user->isGuest) {
    		return null;
    	}
    	$request = Yii::$app->request;
    	$id = $request->get('id');
    	
		return Message::getLast($id);
    }
    
    public function actionMessages() {
    	Yii::$app->response->format = Response::FORMAT_JSON;
    	 
    	if (Yii::$app->user->isGuest) {
    		return null;
    	}
    	$request = Yii::$app->request;
    	$id = $request->get('id');
    	$userId = $request->get('userId');
    	$masterId = $request->get('masterId');
    	
		$result = (object) array('messages' => null, 'interlocutor' => null);
		if ($userId != null || $masterId != null){
			$interlocutorId = $userId!=null?$userId:$masterId;
			$result->messages = Message::getDialog($id, $interlocutorId);
			$interlocutor = User::findIdentity($interlocutorId);
			$result->interlocutor = (object) array('id' => $interlocutor->id, 'firstName' => $interlocutor->firstName, 'lastName' => $interlocutor->lastName);
		}
    	return $result;
    }
    
    public function actionMessage($id) {
    	Yii::$app->response->format = Response::FORMAT_JSON;
    	 
    	if (Yii::$app->user->isGuest) {
    		return null;
    	}
    	$request = Yii::$app->request;
    	$text = $request->post('MessageForm')['message'];
    	$interlocutor = $request->post('MessageForm')['interlocutor'];
    	
    	if ($text != null && trim($text) != '') {
    		$order = Order::findIdentity($id);
    		if ($order != null) {
    			$message = new Message();
    			if (Yii::$app->user->identity->master) {
    				$message->userId = $interlocutor;
    				$message->masterId = $message->author = Yii::$app->user->getId();
    			} else {
    				$message->userId = $message->author = Yii::$app->user->getId();
    				$message->masterId = $interlocutor;
    			}
    			$message->orderId = $id;
    			$message->text = $text;
    			$message->date = date("Y-m-d H:i:s");
    			
    			$message->save();
    			$message->afterFind();
    			return $message;
    		}
    	}
        return null;
    }
}
