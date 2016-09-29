<?php

use yii\web\View;
use yii\widgets\Pjax;
use common\utils\ImageUtil;
use common\widgets\StarsRating;
use common\widgets\SimpleHeader;

$this->title = $master->lastName.' '.$master->firstName;
$this->params['containerClass'] = '';
$this->params['headerType'] = SimpleHeader::TYPE_SCROLL;

$this->registerJs(
		'var animation = false;'
		.'var activeTab = null;'
		.'var layout = $(".mdl-layout");'
		.'var tabBarTop = $(".mdl-tabs__tab-bar").position().top + $(".mdl-layout__header").outerHeight();'
		.'layout.scroll(function() {'
			.'if ($(".mdl-layout").scrollTop() >= tabBarTop){'
				.'$(".tab-bar").addClass("fixed");'
			.'} else {'
				.'$(".tab-bar").removeClass("fixed");'
			.'}'
			.'if (!animation) {'
				.'var visiblePanel = getVisiblePanel();'
				.'if (visiblePanel == null) {'
					.'if (activeTab != null) {'
						.'activeTab.removeClass("is-active");'
						.'activeTab = null;'
					.'}'
				.'} else {'
					.'if (activeTab == null) {'
						.'activeTab = $("a[href=\"#"+visiblePanel+"\"]");'
						.'activeTab.addClass("is-active");'
					.'}'
					.'if (activeTab.attr("href") != "#"+visiblePanel) {'
						.'activeTab.removeClass("is-active");'
						.'activeTab = $("a[href=\"#"+visiblePanel+"\"]");'
						.'activeTab.addClass("is-active");'
					.'}'
				.'}'
			.'}'
		.'});'
		.'$(".master").click(function() {'
			.'layout.animate({'
				.'scrollTop: 0'
			.'}, 300);'
		.'});'
		.'var header = $(".mdl-layout__header");'
		.'var tabBar = $(".mdl-tabs__tab-bar");'
		.'var tabs = $(".mdl-tabs__tab");'
		.'tabs.click(function() {'
			.'activeTab = $(this);'
			.'var panel = $(activeTab.attr("href"));'
			.'if (panel != null){'
				.'animation = true;'
	  			.'layout.animate({'
					.'scrollTop: panel.position().top + header.outerHeight() - tabBar.outerHeight()'
				.'}, 300, function(){animation = false;});'
			.'}'
		.'});'
		.'var panels = $(".mdl-tabs__panel");'
		.'var getVisiblePanel = function(){'
			.'var result = null;'
			.'var scrollTop = layout.scrollTop() + tabBar.outerHeight();'
			.'panels.each(function(index, value) {'
				.'var panel = $(this);'
				.'var panelTop = panel.position().top + header.outerHeight();'
				.'if (scrollTop >= panelTop && scrollTop < panelTop + panel.outerHeight()){'
					.'result = panel.attr("id");'
					.'return false;'
				.'}'
			.'});'
			.'return result;'
		.'};'
		.'$(".section.container .mdl-typography--title.mdl-typography--font-thin").readmore({'
			.'moreLink: "<div class=\"readmore-link mdl-color-text--grey-600\"><button class=\"mdl-button mdl-js-button mdl-button--icon\"><i class=\"material-icons\">keyboard_arrow_down</i></button>Читать дальше<div>",'
			.'lessLink: "<div class=\"readmore-link mdl-color-text--grey-600\"><button class=\"mdl-button mdl-js-button mdl-button--icon\"><i class=\"material-icons\">keyboard_arrow_up</i></button>Скрыть<div>"'
		.'});'
		.'$("#p1").on("mdl-componentupgraded", function() {'
			.'this.MaterialProgress.setProgress('.($reviews1Count/$reviewsCount*100).');'
		.'});'
		.'$("#p2").on("mdl-componentupgraded", function() {'
			.'this.MaterialProgress.setProgress('.($reviews2Count/$reviewsCount*100).');'
		.'});'
		.'$("#p3").on("mdl-componentupgraded", function() {'
			.'this.MaterialProgress.setProgress('.($reviews3Count/$reviewsCount*100).');'
		.'});'
		.'$("#p4").on("mdl-componentupgraded", function() {'
			.'this.MaterialProgress.setProgress('.($reviews4Count/$reviewsCount*100).');'
		.'});'
		.'$("#p5").on("mdl-componentupgraded", function() {'
			.'this.MaterialProgress.setProgress('.($reviews5Count/$reviewsCount*100).');'
		.'});', View::POS_READY);
?>
<div class="master-view">
	<div class="master-info-section mdl-color--white">
		<div class="section container">
			<a class="avatar" style="background-image: url('<?= ImageUtil::getUserAvatar($master->id)?>');"></a>
			<div class="mdl-typography--title"><?= $master->lastName.' '.$master->firstName?></div>
			<div class="mdl-typography--title mdl-typography--font-thin"><span><?= $master->shop.' / '?></span><a><?= $master->place->name?></a></div>
			<?= StarsRating::widget([
					'rating' => 4,
					'reviews' => 10,
					'isSmall' => true,
			])?>
		</div>
	</div>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect mdl-color--white">
		<div class="tab-bar mdl-color--white">
			<div class="container">
				<div class="master">
					<a class="avatar" style="background-image: url('<?= ImageUtil::getUserAvatar($master->id)?>');"></a>
					<div class="mdl-typography--title mdl-typography--font-thin"><?= $master->lastName.' '.$master->firstName?></div>
				</div>
				<div class="mdl-tabs__tab-bar">
					<a href="#listings-panel" class="mdl-tabs__tab">Проекты</a>
				    <a href="#about-panel" class="mdl-tabs__tab">Информация</a>
					<a href="#policies-panel" class="mdl-tabs__tab">Доставка</a>
					<a href="#reviews-panel" class="mdl-tabs__tab">Отзывы</a>
					<a href="#videos-panel" class="mdl-tabs__tab">Видео</a>	
				</div>	
			</div>
		</div>
		<div class="mdl-tabs__panel mdl-color--white" id="listings-panel">
			<div class="section container">
				<div class="mdl-typography--title">Проекты (<?=$progectsCount?>)</div>
					<?php Pjax::begin(['enablePushState' => false]); ?>
						<?=$this->render('_projects', [
								'progects' => $progects,
								'count' => $progectsCount,
	        					'page' => $page,
								'masterId' => $master->id,
						])?> 
					<?php Pjax::end(); ?>
			</div>
		</div>
		<div class="mdl-tabs__panel mdl-color--grey-100" id="about-panel">
			<div class="section container">
				<div class="mdl-typography--title">О себе</div>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--9-col">
						<div class="mdl-typography--title mdl-typography--font-thin"><p><?=$master->getInfo()->about ?></p></div>
					</div>
					<div class="reg-info mdl-cell mdl-cell--3-col">
						<div class="mdl-typography--title mdl-typography--font-thin"><p>Зарегистрирован с:</p></div>
						<div class="reg-date mdl-typography--title mdl-typography--font-thin"><i class="material-icons">date_range</i><p><?= date ('d.m.Y', $master->created_at)?></p></div>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-tabs__panel mdl-color--white" id="policies-panel">
			<div class="section container">
				<div class="mdl-typography--title">Доставка и Гарантии</div>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--9-col">
						<div class="mdl-typography--title mdl-typography--font-thin">
							<?=$master->getInfo()->shipping !== null ?  '<h6>Оплата</h6><p>'.$master->getInfo()->payment.'</p>' : ''?>
							<?=$master->getInfo()->shipping !== null ?  '<h6>Доставка</h6><p>'.$master->getInfo()->shipping.'</p>' : ''?>
							<?=$master->getInfo()->policies !== null ?  '<h6>Возврат и обмен</h6><p>'.$master->getInfo()->policies.'</p>' : ''?>
							<?=$master->getInfo()->shipping !== null ?  '<h6>Дополнительные правила и Справка</h6><p>'.$master->getInfo()->additional.'</p>' : ''?>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--3-col"></div>
				</div>
			</div>
		</div>
		<div class="mdl-tabs__panel mdl-color--grey-100" id="reviews-panel">
			<div class="section container">
				<div class="mdl-typography--title">
					<span>Отзывы</span>
					<?= StarsRating::widget(['rating' => 4, 'isSmall' => true, 'reviews' => $reviewsCount])?>	
				</div>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--8-col">
						<?php Pjax::begin(['enablePushState' => false]); ?>
							<?=$this->render('_reviews', [
									'reviews' => $reviews,
									'count' => $reviewsCount,
			        				'page' => $page,
									'masterId' => $master->id,
							])?> 
						<?php Pjax::end(); ?>
					</div>
					<div class="reviews-details mdl-cell mdl-cell--4-col">
						<div class="mdl-typography--title mdl-typography--font-thin"><p>Всего отзывов <?= $reviewsCount?></p></div>
						<ul class="rate-list-item mdl-list mdl-typography--font-thin">
            				<li class="mdl-list__item">
                				<p class="mdl-list__item-primary-content">
				                	<span class="r-title">5 звезд</span>
				                	<span id="p5" class="mdl-progress mdl-js-progress"></span>
				                </p>
								<p class="mdl-list__item-secondary-action">
									<span class="mdl-chip">
									    <span class="mdl-chip__text"><?= $reviews5Count?></span>
									</span>
								</p>
				            </li>
				            <li class="mdl-list__item">
				                <p class="mdl-list__item-primary-content">
				                	<span class="r-title">4 звезды</span>
				                	<span id="p4" class="mdl-progress mdl-js-progress"></span>
				                </p>
								<p class="mdl-list__item-secondary-action">
									<span class="mdl-chip">
									    <span class="mdl-chip__text"><?= $reviews4Count?></span>
									</span>
								</p>
				            </li>
				            <li class="mdl-list__item">
				                <p class="mdl-list__item-primary-content">
				                	<span class="r-title">3 звезды</span>
				                	<span id="p3" class="mdl-progress mdl-js-progress"></span>
				                </p>
								<p class="mdl-list__item-secondary-action">
									<span class="mdl-chip">
									    <span class="mdl-chip__text"><?= $reviews3Count?></span>
									</span>
								</p>
				            </li>
				            <li class="mdl-list__item">
				                <p class="mdl-list__item-primary-content">
				                	<span class="r-title">2 звезды</span>
				                	<span id="p2" class="mdl-progress mdl-js-progress"></span>
				                </p>
								<p class="mdl-list__item-secondary-action">
									<span class="mdl-chip">
									    <span class="mdl-chip__text"><?= $reviews2Count?></span>
									</span>
								</p>
				            </li>
				            <li class="mdl-list__item">
				                <p class="mdl-list__item-primary-content">
				                	<span class="r-title">1 звезда</span>
				                	<span id="p1" class="mdl-progress mdl-js-progress"></span>
				                </p>
								<p class="mdl-list__item-secondary-action">
									<span class="mdl-chip">
									    <span class="mdl-chip__text"><?= $reviews1Count?></span>
									</span>
								</p>
				            </li>
        				</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-tabs__panel mdl-color--white" id="videos-panel">
			<div class="section-container">
				<ul>
					<li>Viserys</li>
					<li>Daenerys</li>
				</ul>
			</div>
		</div>
	</div>
</div>
