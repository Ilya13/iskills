<?php
namespace common\widgets;

use yii\helpers\Html;

class Section extends \yii\base\Widget {
	public $html;

	public function init(){
		parent::init();
		$this->html = '<div class="jumbotron section__hero">'
		      .'<div class="container">'
		        .'<p><a class="hero__btn mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Опишите вашу идею</a></p>'
		        .'<p>или</p>'
		        .'<p><a class="hero__btn mdl-button mdl-js-button">Загрузите фотографию</a></p>'
		      .'</div>'
			  .'<button id="hero__fab" class="hero__fab mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-shadow--4dp">'
			    .'<i class="material-icons">&#xE313;</i>'
		 	  .'</button>'
		    .'</div>';
	}

	public function run(){
		return $this->html;
	}
}
?>
