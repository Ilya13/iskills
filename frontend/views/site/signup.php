<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>
  <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'signup card-square mdl-card mdl-shadow--2dp'],
        'fieldConfig' => [
            'template' => '<div class="mdl-textfield mdl-js-textfield">{input}{label}{error}</div>',
            'labelOptions' => ['class' => 'mdl-textfield__label'],
            'inputOptions' => ['class' => 'mdl-textfield__input'],
        ],
    ]); ?>
    
    <div class="mdl-card__title mdl-card--expand mdl-color--accent">
      <h2 class="mdl-card__title-text">Регистрация</h2>
    </div>
    
    <div class="mdl-card__supporting-text">
      	<?= $form->field($model, 'firstName') ?>
      	<?= $form->field($model, 'lastName') ?>
      	<?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'confirm')->passwordInput() ?>
		<?= Html::submitButton('Зарегистрироваться', ['class' => 'submit-button mdl-button mdl-js-button mdl-button--raised mdl-button--colored', 'name' => 'signup-button']) ?>
    </div>
   
    <?php ActiveForm::end(); ?>