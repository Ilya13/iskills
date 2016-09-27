<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Project;

class MasterController extends Controller
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

	public function actionIndex($id) {
		$master = User::findIdentityMaster($id);
		if ($master != null) {
			$progects = Project::getByMaster($master->id);
			return $this->render('index', [
					'master' => $master, 
					'progects' => $progects,
					'count' => Project::countMasterProjects($master->id),
        			'page' => null,
			]);
		}
        return $this->goHome();
	}
}