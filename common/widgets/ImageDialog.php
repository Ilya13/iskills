<?php
namespace common\widgets;

use yii\helpers\Html;
use yii\web\View;
use Yii;

class ImageDialog extends \yii\base\Widget {
	public $html;
	public $skipInit;
	
	public function init(){
		parent::init();
		$this->html = '<dialog class="gallery-dialog mdl-dialog">'
					.Html::img('', ['id' => 'gallery_dialog_image'])
					.'<button class="dialog-close mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored" id="dialog_close">'
						.'<i class="material-icons">close_circle</i>'
					.'</button>'
				.'</dialog>';
		
		$view = Yii::$app->getView();
		if ($this->skipInit !== true){
			$view->registerJs('initImageDialog();');
		}
		$view->registerJs($this->getJs(), View::POS_END);
	}
	
	public function run(){
		return $this->html;
	}
	
	private function getJs() {
		return
		'var initImageDialog = function () {'
			.'var dialogImage = $("#gallery_dialog_image");'
			.'var close = $("#dialog_close");'
    		.'var dialog = document.querySelector("dialog.gallery-dialog");'
			.'if (!dialog.showModal) {'
				.'dialogPolyfill.registerDialog(dialog);'
		    .'}'
		    .'dialogImage.click(function(event) {'
				.'event.stopPropagation();'
			.'});'
			.'dialog.onclick = function() {'
    			.'dialog.close();'
			.'}'
		.'};'
		.'var showImageDialog = function(src){'
			.'if (src.indexOf("url") > -1) {'
				.'src = src.substring(4, src.length-1);'
			.'}'
			.'var dialog = document.querySelector("dialog.gallery-dialog");'
			.'var dialogImage = $("#gallery_dialog_image");'
			.'dialogImage.attr("src", src);'
			.'var wHeight = $(window).height()-108;'
			.'var wWidth = $(window).width()-108;'
			.'if (dialogImage.get(0).naturalWidth > wWidth || dialogImage.get(0).naturalHeight > wHeight){'
				.'var ratio = dialogImage.get(0).naturalWidth/dialogImage.get(0).naturalHeight;'
				.'var w = wWidth;'
				.'var h = w/ratio;'
				.'if (h > wHeight){'
					.'h = wHeight;'
					.'w = h*ratio;'
				.'}'
				.'dialog.style.width = w+"px";'
				.'dialog.style.height = h+"px";'
			.'}'	
			.'dialog.showModal();'
		.'}';
	}
}
?>
