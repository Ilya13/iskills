<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Footer;
use common\widgets\Header;
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
			<div class="page-content">
				<div class="container">
					<?= $content ?>
				</div>
			</div>
			<?php echo Footer::widget(); ?>
		</div>
	</div>
</div>
<dialog id="info_dialog" class="confirm-dialog mdl-dialog">
	<div class="mdl-dialog__content"><p></p></div>
	<div class="mdl-dialog__actions">
		<button id="dialog_ok" type="button" class="mdl-button">Ok</button>
	</div>
</dialog>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
