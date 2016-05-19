<?php
namespace common\widgets;

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\models\LoginForm;

class LoginDialog extends \yii\base\Widget {
	public $html;

	public function init(){
		parent::init();
		$this->html = '<dialog id="login_dialog" class="mdl-dialog">'
					    .'<h4 class="mdl-dialog__title">Войти</h4>'
					    .'<div class="mdl-dialog__content">';

		$model = new LoginForm();
					    
		$form = ActiveForm::begin([
				'id' => 'login-form',
				'options' => ['class' => 'login card-square mdl-card mdl-shadow--2dp'],
				'fieldConfig' => [
					'template' => '<div class="mdl-textfield mdl-js-textfield">{input}{label}{error}</div>',
					'labelOptions' => ['class' => 'mdl-textfield__label'],
					'inputOptions' => ['class' => 'mdl-textfield__input'],
				],
		]);
		$this->html .= $form->field($model, 'email');
		$this->html .= $form->field($model, 'password')->passwordInput();
		$this->html .= $form->field($model, 'rememberMe')->checkbox([
				'template' => '{beginLabel}{input}<span class="mdl-checkbox__label">{labelTitle}</span>{endLabel}',
		        'labelOptions' => ['class' => 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect'],
		        'label' => 'Запомнить меня',
		        'class' => 'mdl-checkbox__input',
		]);
		
		ActiveForm::end();
    
		$this->html .= '</div>'
					    .'<div class="mdl-dialog__actions">'
					      .'<button type="button" class="mdl-button">Agree</button>'
					      .'<button type="button" class="mdl-button close">Disagree</button>'
					    .'</div>'
					  .'</dialog>';
	}

	public function run(){
		return $this->html;
	}
}
?>
