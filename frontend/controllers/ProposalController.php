<?php
namespace frontend\controllers;

use yii\web\Controller;

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

    public function actionAgree() {
    	Yii::$app->response->format = Response::FORMAT_JSON;
    	 
    	if (Yii::$app->user->isGuest) {
    		return null;
    	}
    	$request = Yii::$app->request;
    	$id = $request->get('id');
    	 
    	$proposal = Proposal::findIdentity($id);
    	if($proposal !== null){
    		$order = Order::findIdentity($proposal->orderId);
    		if ($order !== null && $order->userId === Yii::$app->user->getId()){
    			if ($order->status === Order::STATUS_ACTIVE) {
    				if ($order->masterId === null) {
    					$order->masterId = $proposal->masterId;
    					$order->save();
    					return $proposal;
    				} else {
    					throw new \yii\web\HttpException(400, 'На этот заказ уже назначен Мастер.');
    				}
    			} else {
    				throw new \yii\web\HttpException(400, 'Заказ должен быть активирован.');
    			}
    		} else {
    			throw new \yii\web\HttpException(400, 'Заказ данного предложения не найден.');
    		}
    	} else {
    		throw new \yii\web\HttpException(400, 'Предложение не найдено.');
    	}
    	return null;
    }
}