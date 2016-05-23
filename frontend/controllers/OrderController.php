<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Order;
use common\models\User;
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
}
