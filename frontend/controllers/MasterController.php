<?php
namespace frontend\controllers;

use \Yii;
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

	public function actionIndex($id, $page = null) {
		if (Yii::$app->request->isPjax) {
			Yii::info('isPjax=true');
			$progects = Project::getByMaster($id, $page);
			return $this->renderAjax('_projects', [
					'progects' => $progects,
					'count' => Project::countMasterProjects($master->id),
					'page' => $page,
					'masteId' => $id,
			]);
		} else {
			Yii::info('isPjax=false');
			$master = User::findIdentityMaster($id);
			if ($master != null) {
				$progects = Project::getByMaster($id, $page);
				return $this->render('index', [
						'master' => $master,
						'progects' => $progects,
						'count' => Project::countMasterProjects($master->id),
						'page' => $page,
				]);
			}
		}
        return $this->goHome();
	}

	public function actionIndex1($id, $page = null) {
		$progects = Project::getByMaster($id, $page);
			return $this->renderAjax('_projects', [
					'progects' => $progects,
					'count' => Project::countMasterProjects($id),
					'page' => $page,
					'masteId' => $id,
			]);
        return $this->goHome();
	}
}