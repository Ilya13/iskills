<?php

use common\models\Project;
use common\widgets\Pagination;
use common\widgets\ProjectCard;

?>
<div class="mdl-grid projects-grid">
	<?php
	foreach ($progects as $project){
		echo ProjectCard::widget(['project' => $project]);
	}
	?>
</div>
<?php 
echo Pagination::widget([
		'page' => $page,
		'pageCount' => ceil($count / Project::$PAGE_MIN_SIZE),
		'href' => ['master/projects', 'id' => $masterId],
]);
?>