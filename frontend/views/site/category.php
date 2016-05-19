<?php

/* @var $this yii\web\View */

use common\models\Project;
use common\widgets\ProjectCard;
use common\widgets\Pagination;
use yii\base\Widget;

$this->title = $category->name;
?>
<div class="site-index">
    <div class="body-content">
		<div class="mdl-grid projects-grid">
			<?php
			foreach (Project::getByCategory($category->id) as $project){
				echo ProjectCard::widget(['project' => $project]);
			}
			?>
		</div>
		<?php
		if ($count > Project::$PAGE_SIZE) {
			echo '<div class="text-center"><nav><ul class="pagination">';
		}
		echo Pagination::widget([
				'page' => $page,
				'pageCount' => ceil($count / Project::$PAGE_SIZE),
				'href' => ['site/category', 'id' => $category->id],
		]);
		?>
    </div>
</div>
