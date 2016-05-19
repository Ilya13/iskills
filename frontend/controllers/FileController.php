<?php
namespace frontend\controllers;

use common\models\FileForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class FileController extends Controller {
	
	public function actions() {
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
	
	public function actionUpload() {
		if (Yii::$app->request->isAjax) {
			$model = new FileForm();
			$model->projectId = Yii::$app->request->post('projectId');
			$model->orderId = Yii::$app->request->post('orderId');
			$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			$paths = $model->uploadTemp();

			Yii::$app->response->format = Response::FORMAT_JSON;
			return ['paths' => $paths];
		}
	}
	
	public function actionUploads() {
		if (Yii::$app->request->isAjax) {
			$model = new FileForm();
			$model->projectId = Yii::$app->request->get('projectId');
			$model->orderId = Yii::$app->request->get('orderId');
			$paths = $model->getAllUploads();

			Yii::$app->response->format = Response::FORMAT_JSON;
			return ['paths' => $paths];
		}
	}
	
	public function actionRemove() {
		if (Yii::$app->request->isAjax) {
			$model = new FileForm();
			$model->projectId = Yii::$app->request->get('projectId');
			$model->name = Yii::$app->request->get('name');
			$result = $model->remove();

			Yii::$app->response->format = Response::FORMAT_JSON;
			return ['result' => $result];
		}
	}
}
