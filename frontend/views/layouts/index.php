<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Footer;
use common\widgets\Header;
use common\widgets\Section;
use frontend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
		
	<div class="main-layout-waterfall mdl-layout mdl-js-layout">
	  <?php echo Header::widget(); ?>
	  <div class="mdl-layout__content mdl-color--grey-100">
	  	<?php echo Section::widget(); ?>
	    <div class="page-content">
			<div class="container">
		        <?= $content ?>
		    </div>
		</div>
		<?php echo Footer::widget(); ?>
	  </main>
	</div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
