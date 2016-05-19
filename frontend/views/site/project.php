<?php

use common\utils\StringUtil;
use common\widgets\FileAttachment;
use common\widgets\Gallery;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = $project->name;
?>

<div class="mdl-grid project-view">

	<div class="mdl-cell mdl-cell--7-col">
		<div class="mdl-cell mdl-cell--7-col mdl-cell--12-col-desktop">
			<?php echo Gallery::widget(['project' => $project])?>
		</div>
		<div class="demo-separator mdl-cell--1-col"></div>
		<div class="mdl-cell mdl-cell--7-col mdl-cell--12-col-desktop">
			<p class="about_detail">
				<?php
				echo nl2br($project->description);
				if ($project->features !== null){
					echo '<br><br>ХАРАКТЕРИСТИКИ';
					echo '<br>'.nl2br($project->features);
				}
				if ($project->shipping !== null){
					echo '<br><br>ДОСТАВКА';
					echo '<br>'.nl2br($project->shipping);
				}
				if ($project->ordering !== null){
					echo '<br><br>ИНФОРМАЦИЯ ДЛЯ ЗАКАЗА';
					echo '<br>'.nl2br($project->ordering);
				}
				?>
			</p>
		</div>
	</div>
	
	<div class="mdl-cell mdl-cell--5-col mdl-cell--7-col-tablet mdl-grid mdl-grid--no-spacing">
		<div class="mdl-cell mdl-cell--5-col mdl-cell--5-col-tablet mdl-cell--12-col-desktop">
			<div class="project_header">
				<h2 class="project_name">
					<?php echo $project->name; ?>
				</h2>
				<span class="project_price">
					<?php echo 'от '.$project->price.' руб.'; ?>
				</span>
				<?php
				if ($project->ships !== null){
					echo '<span class="project_shipping">';
					echo ' / Доставка за '.StringUtil::shipsToString($project->ships);
					echo '</span>';
				}
				?>
			</div>
			<?php
			$form = ActiveForm::begin([
					'action' => Url::to(['/site/order', 'id' => $project->id]),
					'options' => [
							'enctype' => 'multipart/form-data',
							'class' => 'order-form',
							'id' => 'OrderForm',
					]]);
			
			echo $form->field($model, 'details', [
					'template' => '<div class="mdl-textfield mdl-js-textfield">{input}{label}</div>',
					'labelOptions' => ['class' => 'mdl-textfield__label'],
			])->textArea([
					'rows' => '2',
					'class' => 'mdl-textfield__input',
			]);
			
			echo '<div class="form-group field-orderform-customize has-success">';
			echo FileAttachment::widget(['projectId' => $project->id, 'mainForm' => 'OrderForm', 'imageFiles' => $model->imageFiles]);
			echo '</div>';
			echo Html::submitButton('Отправить запрос', ['class' => 'mdl-button mdl-js-button mdl-button--raised mdl-button--colored submit-button', 'name' => 'order-button', 'id' => 'order_button']);
			
			ActiveForm::end();
			?>
		</div>
		<div class="demo-separator mdl-cell--1-col"></div>
		<div class="mdl-cell mdl-cell--5-col mdl-cell--5-col-tablet mdl-cell--12-col-desktop">
			
		</div>
	</div>

</div>
