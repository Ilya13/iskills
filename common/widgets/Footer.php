<?php
namespace common\widgets;

use yii\helpers\Html;

class Footer extends \yii\base\Widget {
	public $html;

	public function init(){
		parent::init();
		$this->html = '<footer class="mdl-mini-footer">'
							  .'<div class="mdl-mini-footer__left-section">'
							    .'<div class="mdl-logo">Title</div>'
							    .'<ul class="mdl-mini-footer__link-list">'
							      .'<li><a href="#">Help</a></li>'
							      .'<li><a href="#">Privacy & Terms</a></li>'
							    .'</ul>'
							  .'</div>'
							.'</footer>';
	}

	public function run(){
		return $this->html;
	}
}
?>
