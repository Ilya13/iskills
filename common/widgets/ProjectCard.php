<?php
namespace common\widgets;

use common\utils\ImageUtil;
use yii\helpers\Html;
use yii\helpers\Url;

class ProjectCard extends \yii\base\Widget {
	public $html;
	public $project;
	
	public function init(){
		parent::init();
		$this->html = '<div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">'
                    .'<a class="mdl-card__media" href="'.Url::toRoute(['site/project', 'id' => $this->project->id]).'" style="background-image: url(\''.ImageUtil::getAvatar('/project/'.$this->project->id).'\')"></a>'
                    .'<div class="mdl-card__supporting-text meta meta--fill mdl-color-text--grey-600">'
		              .'<div>'
		              	.'<strong>'
					    	.Html::a($this->project->name, ['site/project', 'id' => $this->project->id])
		              	.'</strong>'
		                .Html::a($this->project->master->lastName.' '.$this->project->master->firstName, ['site/index'])
		                .'<span>'
					      .'от '.$this->project->price.' руб.'
					    .'</span>'
		                .'<a class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored" href="'.Url::toRoute(['site/project', 'id' => $this->project->id]).'">'
                    		.'<i class="material-icons">shopping_cart</i>'
                    	.'</a>'
		              .'</div>'
		            .'</div>'
                .'</div>';
	}
	
	public function run(){
		return $this->html;
	}
}
?>
