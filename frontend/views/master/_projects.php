<?php

use common\models\Project;
use common\widgets\Pagination;
use common\widgets\ProjectCard;
use yii\widgets\Pjax;

?>
<div class="mdl-grid projects-grid">
	<?php
	foreach ($progects as $project){
		echo ProjectCard::widget(['project' => $project]);
	}
	?>
</div>
<?php 
if ($count > Project::$PAGE_MIN_SIZE) {
	echo '<div class="text-center"><nav><ul class="pagination">';
}
echo Pagination::widget([
		'page' => $page,
		'pageCount' => ceil($count / Project::$PAGE_MIN_SIZE),
		'href' => ['master/projects', 'id' => $masteId],
]);
?>