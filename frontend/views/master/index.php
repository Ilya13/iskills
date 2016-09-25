<?php

use yii\web\View;
use common\utils\ImageUtil;
use common\widgets\StarsRating;
use common\widgets\SimpleHeader;

$this->title = $master->lastName.' '.$master->firstName;
$this->params['containerClass'] = '';
$this->params['headerType'] = SimpleHeader::TYPE_SCROLL;

$this->registerJs(
		'var layout = $(".mdl-layout");'
		.'var tabBarTop = $(".mdl-tabs__tab-bar").position().top + $(".mdl-layout__header").outerHeight();'
		.'layout.scroll(function() {'
			.'if ($(".mdl-layout").scrollTop() >= tabBarTop){'
				.'$(".mdl-tabs__tab-bar").addClass("fixed");'
			.'} else {'
				.'$(".mdl-tabs__tab-bar").removeClass("fixed");'
			.'}'
			.'console.log(getVisiblePanel());'
		.'});'
		.'var header = $(".mdl-layout__header");'
		.'var tabBar = $(".mdl-tabs__tab-bar");'
		.'var tabs = $(".mdl-tabs__tab");'
		.'tabs.click(function() {'
			.'var tab = $(this);'
			.'var panel = $(tab.attr("href"));'
			.'if (panel != null){'
	  			.'layout.animate({'
					.'scrollTop: panel.position().top + header.outerHeight() - tabBar.outerHeight()'
				.'}, 300);'
			.'}'
		.'});'
		.'var panels = $(".mdl-tabs__panel");'
		.'var getVisiblePanel = function(){'
			.'var result = null;'
			.'panels.each(function(index, value) {'
				.'var panel = $(this);'
				.'if (layout.scrollTop() + tabBar.outerHeight() < panel.position().top + panel.outerHeight() + header.outerHeight()){'
					.'result = panel.attr("id");'
					.'return false;'
				.'}'
			.'});'
			.'return result;'
		.'}', View::POS_READY);
?>
<div class="master-view">
	<div class="master-info-section mdl-color--grey-100">
		<div class="section-container">
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
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
	  <div class="tab-bar-container">
		  <div class="mdl-tabs__tab-bar mdl-color--grey-100">
		      <a href="#listings-panel" class="mdl-tabs__tab">Товары</a>
		      <a href="#about-panel" class="mdl-tabs__tab">Информация</a>
		      <a href="#policies-panel" class="mdl-tabs__tab">Доставка</a>
		      <a href="#reviews-panel" class="mdl-tabs__tab">Отзывы</a>
		      <a href="#videos-panel" class="mdl-tabs__tab">Видео</a>
		  </div>
	  </div>
	  <div class="mdl-tabs__panel mdl-color--white" id="listings-panel">
	  	<div class="section-container">
			<ul>
		      <li>Eddard</li>
		      <li>Catelyn</li>
		      <li>Robb</li>
		      <li>Sansa</li>
		      <li>Brandon</li>
		      <li>Arya</li>
		      <li>Rickon</li>
		    </ul>
		</div>
	  </div>
	  <div class="mdl-tabs__panel mdl-color--grey-100" id="about-panel">
	  	<div class="section-container">
		    <ul>
		      <li>Tywin</li>
		      <li>Cersei</li>
		      <li>Jamie</li>
		      <li>Tyrion</li>
		    </ul>
		</div>
	  </div>
	  <div class="mdl-tabs__panel mdl-color--white" id="policies-panel">
	  	<div class="section-container">
		    <ul>
		      <li>Viserys</li>
		      <li>Daenerys</li>
		    </ul>
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
