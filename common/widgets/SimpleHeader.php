<?php
namespace common\widgets;

use common\models\Category;
use Yii;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

class SimpleHeader extends \yii\base\Widget {
	public $html;
	public $search;
	public $links;
	public $tabs;

	public function init(){
		parent::init();
		$this->html = '<div class="mdl-layout__header mdl-layout__header--waterfall site-header__main">'
						    .'<div class="mdl-layout__header-row">'
						      .'<a class="mdl-layout-title" href="'.Url::to(['/site/index']).'">Мастерская</a>'
						      .'<div class="mdl-layout-spacer"></div>';
		
		if (isset($this->search) && $this->search){
			$this->html .= '<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable'
						                  .'mdl-textfield--floating-label mdl-textfield--align-right">'
						        .'<label class="mdl-button mdl-js-button mdl-button--icon"'
						               .'for="waterfall-exp">'
						          .'<i class="material-icons">search</i>'
						        .'</label>'
						        .'<div class="mdl-textfield__expandable-holder">'
						          .'<input class="mdl-textfield__input" type="text" name="sample"'
						                 .'id="waterfall-exp">'
						        .'</div>'
						      .'</div>';
		}
		
		if (isset($this->links)){
			if (Yii::$app->user->isGuest) {
				$this->html .= '<nav class="mdl-navigation">'
								.'<a class="mdl-button mdl-js-button mdl-js-ripple-effect" href="'.Url::to(['/site/login']).'">'
								  .'Войти'
								.'</a>'
								.'<a class="mdl-button mdl-js-button mdl-js-ripple-effect" href="'.Url::to(['/site/signup']).'">'
								  .'Регистрация'
								.'</a>'
						        .'<a class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-js-ripple-effect" style="box-shadow: none;" href="">'
						        	.'Мастер'
						        .'</a>'
						        .'</nav>';
			}
		}
	    $this->html .= '</div>';
	    
	    if (isset($this->tabs)){
	    	$this->html .= '<div class="mdl-layout__header-row">'
	    			.'<nav class="mdl-navigation">';
	    	foreach (Category::getAll() as $tab){
	    		$this->html .= Html::a($tab->name, ['site/category', 'id' => $tab->id], ['class' => 'mdl-navigation__link']);
	    	}
	    	$this->html .= '</nav></div>';
	    }
		
	    $this->html .= '</div>';

	    if (!Yii::$app->user->isGuest) {
	    	$this->html .= '<div class="mdl-layout__drawer">'
	    					.'<div class="mdl-layout-background">'
	    						.'<i class="material-icons">account_circle</i>'
						    	.'<span class="mdl-layout-title">'
						    			.Yii::$app->user->identity->lastName
						    			.' '
						    			.Yii::$app->user->identity->firstName
						    	.'</span>'
	    					.'</div>'
						    .'<nav class="mdl-navigation">'
						      .Html::a('Заказы', ['user/orders'], ['class' => 'mdl-navigation__link'])
						      .Html::a('Отзывы', ['site/'], ['class' => 'mdl-navigation__link'])
						      .Html::a('Настройки', ['site/'], ['class' => 'mdl-navigation__link'])
						      .Html::a('Выйти', ['site/logout'], ['class' => 'mdl-navigation__link', 'data' => ['method' => 'post']])
						    .'</nav>'
						  .'</div>';
	    }
	}

	public function run(){
		return $this->html;
	}
}
?>
