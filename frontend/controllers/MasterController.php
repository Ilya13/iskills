<?php
namespace frontend\controllers;

use \Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Project;
use common\models\Review;

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
		$master = User::findIdentityMaster($id);
		if ($master != null) {
			$progects = Project::getByMaster($id, $page);
			$reviews = Review::getByMaster($id, $page);
			return $this->render('index', [
					'master' => $master,
					'progects' => $progects,
					'reviews' => $reviews,
					'progectsCount' => Project::countMasterProjects($master->id),
					'reviewsCount' => Review::countMasterReviews($id),
					'reviews1Count' => Review::countMasterReviews($id, 1),
					'reviews2Count' => Review::countMasterReviews($id, 2),
					'reviews3Count' => Review::countMasterReviews($id, 3),
					'reviews4Count' => Review::countMasterReviews($id, 4),
					'reviews5Count' => Review::countMasterReviews($id, 5),
					'page' => $page,
			]);
		}
        return $this->goHome();
	}

	public function actionProjects($id, $page = null) {
		$progects = Project::getByMaster($id, $page);
		return $this->renderAjax('_projects', [
				'progects' => $progects,
				'count' => Project::countMasterProjects($id),
				'page' => $page,
				'masterId' => $id,
		]);
        return $this->goHome();
	}

	public function actionReviews($id, $page = null) {
		$reviews = Review::getByMaster($id, $page);
		return $this->renderAjax('_reviews', [
				'reviews' => $reviews,
				'count' => Review::countMasterReviews($id),
				'page' => $page,
				'masterId' => $id,
		]);
        return $this->goHome();
	}
}