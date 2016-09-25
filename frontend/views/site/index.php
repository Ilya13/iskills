<?php

/* @var $this yii\web\View */

use yii\web\View;
use common\models\Project;
use common\widgets\ProjectCard;

$this->title = 'Мастерская';

$this->registerJs(
		'$("#hero__fab").click(function (){'
			.'$(".mdl-layout__content").animate({'
				.'scrollTop: $(".section__hero").outerHeight()'
			.'}, 300);'
		.'});', View::POS_READY);
?>
<div class="site-index">
    <div class="body-content">
		<div class="mdl-grid projects-grid">
			<?php 
			foreach (Project::getAll() as $project){
				echo ProjectCard::widget(['project' => $project]);
			}
			?>
		</div>
    </div>
</div>
