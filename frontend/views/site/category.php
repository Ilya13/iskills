<?php

/* @var $this yii\web\View */

use yii\web\View;
use common\models\Project;
use common\widgets\ProjectCard;
use common\widgets\Pagination;
use yii\base\Widget;

$this->title = $category->name;

$this->registerJs(
		'$("#hero__fab").click(function (){'
			.'$(".mdl-layout__content").animate({'
				.'scrollTop: $(".jumbotron").outerHeight()'
			.'}, 300);'
		.'});'
			.'console.log("click");', View::POS_READY);
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
