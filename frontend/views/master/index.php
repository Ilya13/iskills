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
			.'moreLink: "<div class=\"readmore-link\"><button class=\"mdl-button mdl-js-button mdl-button--icon\"><i class=\"material-icons\">keyboard_arrow_down</i></button>Читать дальше<div>",'
			.'lessLink: "<div class=\"readmore-link\"><button class=\"mdl-button mdl-js-button mdl-button--icon\"><i class=\"material-icons\">keyboard_arrow_up</i></button>Скрыть<div>"'
		.'});', View::POS_READY);
?>
<div class="master-view">
	<div class="master-info-section mdl-color--white">
		<div class="section container">
			<a class="avatar" style="background-image: url('<?php echo ImageUtil::getUserAvatar($master->id)?>');"></a>
			<div class="mdl-typography--title"><?php echo $master->lastName.' '.$master->firstName?></div>
			<div class="mdl-typography--title mdl-typography--font-thin"><span><?php echo $master->shop.' / '?></span><a><?php echo $master->place->name?></a></div>
			<?php echo StarsRating::widget([
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
					<a class="avatar" style="background-image: url('<?php echo ImageUtil::getUserAvatar($master->id)?>');"></a>
					<div class="mdl-typography--title mdl-typography--font-thin"><?php echo $master->lastName.' '.$master->firstName?></div>
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
				<div class="mdl-typography--title">Проекты (<?=$count?>)</div>
					<?php Pjax::begin(['enablePushState' => false]); ?>
						<?=$this->render('_projects', [
								'progects' => $progects,
								'count' => $count,
	        					'page' => $page,
								'masteId' => $master->id,
						])?> 
					<?php Pjax::end(); ?>
			</div>
		</div>
		<div class="mdl-tabs__panel mdl-color--grey-100" id="about-panel">
			<div class="section container">
				<div class="mdl-typography--title">О себе</div>
				<div class="mdl-typography--title mdl-typography--font-thin"><p><?=$master->getInfo()->about ?></p></div>
			</div>
		</div>
		<div class="mdl-tabs__panel mdl-color--white" id="policies-panel">
			<div class="section container">
				<div class="mdl-typography--title">Доставка и Гарантии</div>
				<div class="mdl-typography--title mdl-typography--font-thin">
					<?=$master->getInfo()->shipping !== null ?  '<h6>Оплата</h6><p>'.$master->getInfo()->payment.'</p>' : ''?>
					<?=$master->getInfo()->shipping !== null ?  '<h6>Доставка</h6><p>'.$master->getInfo()->shipping.'</p>' : ''?>
					<?=$master->getInfo()->policies !== null ?  '<h6>Возврат и обмен</h6><p>'.$master->getInfo()->policies.'</p>' : ''?>
					<?=$master->getInfo()->shipping !== null ?  '<h6>Дополнительные правила и Справка</h6><p>'.$master->getInfo()->additional.'</p>' : ''?>
				</div>
			</div>
		</div>
		<div class="mdl-tabs__panel mdl-color--grey-100" id="reviews-panel">
			<div class="section-container">
				<ul>
					<li>Viserys</li>
					<li>Daenerys</li>
				</ul>
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
