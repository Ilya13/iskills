<?php

use yii\web\View;
use common\models\Review;
use common\utils\ImageUtil;
use common\widgets\StarsRating;
use common\widgets\Pagination;

$this->registerJs(
		'$(".review-list-three .review-text").readmore({'
			.'collapsedHeight: 50,'
			.'moreLink: "<div class=\"readmore-link mdl-color-text--grey-600\"><button class=\"mdl-button mdl-js-button mdl-button--icon\"><i class=\"material-icons\">keyboard_arrow_down</i></button>Читать дальше<div>",'
			.'lessLink: "<div class=\"readmore-link mdl-color-text--grey-600\"><button class=\"mdl-button mdl-js-button mdl-button--icon\"><i class=\"material-icons\">keyboard_arrow_up</i></button>Скрыть<div>"'
		.'});', View::POS_READY);
?>
<ul class="review-list-three mdl-list">
	<?php 
	foreach ($reviews as $review){?>
	
	<div class="review-item">
		<li class="mdl-list__item mdl-list__item--three-line">
			<div class="mdl-list__item-primary-content">
				<a class="mdl-list__item-avatar" style="background-image: url('<?= ImageUtil::getUserAvatar($review->userId)?>');"></a>
				<span><?= $review->user->lastName.' '.$review->user->firstName?></span>
				<div class="mdl-list__item-text-body">
					<div><?= $review->project->name?></div>
					<?= StarsRating::widget(['rating' => $review->value, 'isSmall' => true,])?>
				</div>
			</div>
			<span class="mdl-list__item-secondary-content">
				<span class="mdl-list__item-secondary-action"><?= $review->date?></span>
			</span>
		</li>
		<div class="review-text"><?= $review->text?></div>
	</div>
		
	<?php }?>
</ul>
<?php 
echo Pagination::widget([
		'page' => $page,
		'pageCount' => ceil($count / Review::$PAGE_MIN_SIZE),
		'href' => ['master/reviews', 'id' => $masterId],
]);
?>