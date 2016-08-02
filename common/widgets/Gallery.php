<?php
namespace common\widgets;

use common\utils\ImageUtil;
use yii\helpers\Html;
use yii\web\View;
use Yii;
use yii\base\Widget;

class Gallery extends \yii\base\Widget {
	public $html;
	public $project;
	
	public function init(){
		parent::init();
		$this->html = '<div id="slideshow_listing_wrap">'
				.'<div id="slideshow_listing">';
		
		$avatar = ImageUtil::getProjectAvatar($this->project->id);
		$this->html .= '<a href="#" id="hero_image_link" class="hero_image">'
							.Html::img($avatar, ['id' => 'hero_image_element'])
						.'</a>';
		
		$this->html .= '</div>'
						.'<div id="thumbnails_wrap" class="mdl-grid">'
						.'<div id="toolbar" class="thumbnails_container">'
						.'<ul id="thumbnails" class="thumbnails">';
		
		foreach (ImageUtil::getImages('/project/'.$this->project->id) as $image){
			$this->html .= ($avatar === $image?'<li class="active">':'<li>')
								.'<a class="thumb" data-original="'.$image.'">'
									.Html::img($image)
								.'</a>'
							.'</li>';
		}
		$this->html .= '</ul></div></div></div>';
		$this->html .= ImageDialog::widget();
		
		$view = Yii::$app->getView();
		$view->registerJs('initGallery();');
		$view->registerJs($this->getJs(), View::POS_END);
	}
	
	public function run(){
		return $this->html;
	}
	
	private function getJs() {
		return
		'var initGallery = function () {'
			.'var thumbnails = $("#thumbnails");'
			.'if (thumbnails == null) return;'
			
			.'var thumbs = thumbnails.find(".thumb");'
			.'if (thumbs == null) return;'
			
			.'var image = $("#hero_image_link");'
			.'if (image == null) return;'
			
			.'var close = $("#dialog_close");'
			.'if (close == null) return;'
					
			.'thumbs.each(function() {'
				.'$(this).click(function (){'
					.'if ($(this).parent().hasClass("active"))' 
						.'return;'
					
					.'image.find("img").attr("src", $(this).attr("data-original"));'
					.'thumbnails.find(".active").removeClass("active");'
					.'$(this).parent().addClass("active");'
				.'});'
			.'});'
			
    		.'var dialog = document.querySelector("dialog");'
			.'if (!dialog.showModal) {'
				.'dialogPolyfill.registerDialog(dialog);'
		    .'}'
			.'image.click(function() {'
				.'showImageDialog($(this).find("#hero_image_element").attr("src"));'
			.'});'
		.'};';
	}
}
?>
