<?php
namespace common\widgets;

use yii\helpers\Html;

class MiniSection extends \yii\base\Widget {
	public $html;

	public function init(){
		parent::init();
		$this->html = '<div class="jumbotron minisection__hero">'
		      .'<div class="container">'
		      	.'<div class="block">'
		      		.'<h2>Заказ</h2>'
		      		.'<p>Выберите из готовых проектов</p>'
		      		.'<button id="hero__fab" class="mdl-button mdl-js-button mdl-button--icon">'
						.'<i class="material-icons">&#xE313;</i>'
				 	.'</button>'
		      	.'</div>'
		      	.'<div class="or">'
		      		.'<div><p>или</p></div>'
		      	.'</div>'
		        .'<div class="block">'
		      		.'<h2>Создайте свой</h2>'
		      		.'<a class="hero__btn mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Опишите вашу идею</a>'
		        	.'<p>или <a class="hero__btn mdl-button mdl-js-button">загрузите фотографию</a></p>'
		      	.'</div>'
		      .'</div>'
		    .'</div>';
	}

	public function run(){
		return $this->html;
	}
}
?>
