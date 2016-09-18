<?php

use common\utils\ImageUtil;

$this->title = $master->lastName.' '.$master->firstName;
$this->params['containerClass'] = '';
?>
<div class="master-view">
	<div class="master-info-section mdl-color--grey-100">
		<div class="section-container">
			<a class="avatar" style="background-image: url('<?php echo ImageUtil::getUserAvatar($master->id)?>');"></a>
			<div class="mdl-typography--title"><?php echo $master->lastName.' '.$master->firstName?></div>
			<div class="mdl-typography--title mdl-typography--font-thin"><?php echo $master->shop.' / '.$master->place->name?></div>
		</div>
	</div>
	<div class="master-listings-section mdl-color--white">
		<div class="section-container">
			
		</div>
	</div>
	<div class="master-about-section mdl-color--grey-100">
		<div class="section-container">
		</div>
	</div>
	<div class="master-policies-section mdl-color--white">
		<div class="section-container">
		</div>
	</div>
	<div class="master-reviews-section mdl-color--grey-100">
		<div class="section-container">
		</div>
	</div>
	<div class="master-videos-section mdl-color--white">
		<div class="section-container">
		</div>
	</div>
</div>
