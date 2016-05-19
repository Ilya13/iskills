<?php

use common\models\Order;
use common\widgets\OrderSection;
use yii\base\Widget;

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

$userId = Yii::$app->user->getId();
$active = Order::getActiveOrders($userId);
$closed = Order::getClosedOrders($userId);
$finished = Order::getFinishedOrders($userId);

echo '<div class="orders-view">';

if (($active == null || count($active) == 0) && 
		($closed == null || count($closed) == 0) && 
		($finished == null || count($finished) == 0)){
	echo '<p class="mdl-color-text--grey-500">Вы еще не делали заказы.</p>';
} else {	
	echo '<div class="mdl-layout__tab-panel is-active">';
	echo '<div class="section-title mdl-typography--display-1-color-contrast">Активные</div>';
	if ($active == null || count($active) == 0){
		echo '<p class="section--center mdl-grid mdl-color-text--grey-500">У вас еще нет активных проектов.</p>';
	} else {
		foreach ($active as $order){
			echo OrderSection::widget(['order' => $order]);
		}
	}
	echo '<div class="divider"></div>';
	echo '<div class="section-title mdl-typography--display-1-color-contrast">Закрытые</div>';
	if ($closed == null || count($closed) == 0){
		echo '<p class="section--center mdl-grid mdl-color-text--grey-500">У вас нет закрытых проектов.</p>';
	} else {
		foreach ($closed as $order){
			echo OrderSection::widget(['order' => $order]);
		}
	}
	echo '<div class="divider"></div>';
	echo '<div class="section-title mdl-typography--display-1-color-contrast">Завершенные</div>';
	if ($finished == null || count($finished) == 0){
		echo '<p class="section--center mdl-grid mdl-color-text--grey-500">У вас нет завершенных проектов.</p>';
	} else {
		foreach ($finished as $order){
			echo OrderSection::widget(['order' => $order]);
		}
	}
	echo '</div>';
}
echo '</div>';
	
?>