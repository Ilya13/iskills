<?php

/* @var $this yii\web\View */

use common\models\Project;
use common\widgets\ProjectCard;

$this->title = 'Мастерская';
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
