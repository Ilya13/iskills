<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use common\widgets\Footer;
use common\widgets\SimpleHeader;
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
<body class="base">
<?php $this->beginBody() ?>

<div class="wrap">
	<?php echo SimpleHeader::widget(); ?>
	<div class="container">
		<?= $content ?>
	</div>
	<?php echo Footer::widget(); ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
