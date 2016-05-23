<?php
namespace common\widgets;

use yii\helpers\Html;
use common\utils\ImageUtil;
use yii\helpers\Url;

class OrderSection extends \yii\base\Widget {
	public $html;
	public $order;
	
	public function init(){
		parent::init();
		
		$img = ImageUtil::getAvatar('/order/'.$this->order->id);
		if ($img === null){
			if ($this->order->projectId !== null){
				$img = ImageUtil::getAvatar('/project/'.$this->order->projectId);
			} else {
				// TODO добавить стандартные иконки категорий
			}
		}
		
		$this->html = '<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">'
            .'<header class="mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone mdl-color--teal-100 mdl-color-text--white">'
              .'<a href='.Url::toRoute(['user/order', 'id' => $this->order->id]).' style="background-image: url(\''.$img.'\')"></a>'
            .'</header>'
            .'<div class="mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone">'
              .'<div class="mdl-card__supporting-text">'
                .'<h4>'.$this->order->name.'</h4>'
              .'</div>'
              .'<div class="mdl-card__actions">'
                .'<a href="#" class="mdl-button">Закрыть проект</a>'
              .'</div>'
            .'</div>'
            .'<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btn1" data-upgraded=",MaterialButton,MaterialRipple">'
              .'<i class="material-icons">more_vert</i>'
            .'<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></button>'
            .'<div class="mdl-menu__container is-upgraded"><div class="mdl-menu__outline mdl-menu--bottom-right"></div><ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right" for="btn1" data-upgraded=",MaterialMenu">'
              .'<li class="mdl-menu__item" tabindex="-1">Lorem</li>'
              .'<li class="mdl-menu__item" disabled="" tabindex="-1">Ipsum</li>'
              .'<li class="mdl-menu__item" tabindex="-1">Dolor</li>'
            .'</ul></div>'
          .'</section>';
	}
	
	public function run(){
		return $this->html;
	}
}
?>
