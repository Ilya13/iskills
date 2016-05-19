<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;

?>
  <?php 
  $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'login card-square mdl-card mdl-shadow--2dp'],
        'fieldConfig' => [
            'template' => '<div class="mdl-textfield mdl-js-textfield">{input}{label}{error}</div>',
            'labelOptions' => ['class' => 'mdl-textfield__label'],
            'inputOptions' => ['class' => 'mdl-textfield__input'],
        ],
    ]); 
    ?>
    
    <div class="mdl-card__title mdl-card--expand mdl-color--accent">
      <h2 class="mdl-card__title-text">Авторизация</h2>
    </div>
    
    <div class="mdl-card__supporting-text">
      	<?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => '{beginLabel}{input}<span class="mdl-checkbox__label">{labelTitle}</span>{endLabel}',
        	'labelOptions' => ['class' => 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect'],
        	'label' => 'Запомнить меня',
        	'class' => 'mdl-checkbox__input',
        ]) ?>
        
        <?= Html::submitButton('Войти', ['class' => 'submit-button mdl-button mdl-js-button mdl-button--raised mdl-button--colored', 'name' => 'login-button']) ?>
    </div>
    
    <div class="mdl-card__actions mdl-card--border">
      <?= Html::a('Регистрация', ['/site/signup']) ?>
      <?= Html::a('Забыли пароль?', ['/site/remember'], ['style'=>'float: right;']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>