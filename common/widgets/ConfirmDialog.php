<?php
namespace common\widgets;

use yii\helpers\Html;
use yii\web\View;
use Yii;

class ConfirmDialog extends \yii\base\Widget {
	public $html;
	public $id;
	public $title;
	public $skipInit;
	
	public function init(){
		parent::init();
		$this->html = '<dialog id="'.$this->id.'" class="confirm-dialog mdl-dialog">'
						.'<div class="mdl-dialog__content">'
					      .'<p>'.$this->title.'</p>'
					    .'</div>'
					    .'<div class="mdl-dialog__actions">'
					      .'<button id="dialog_yes" type="button" class="mdl-button">Да</button>'
					      .'<button id="dialog_no" type="button" class="mdl-button close">Нет</button>'
					    .'</div>'
					.'</dialog>';
		$view = Yii::$app->getView();
		if ($this->skipInit !== true){
			$view->registerJs('initConfirmDialog();');
		}
		$view->registerJs($this->getJs(), View::POS_END);
	}
	
	public function run(){
		return $this->html;
	}
	
	private function getJs() {
		return
		'var initConfirmDialog = function (id) {'
			.'var yes = $("#dialog_yes");'
			.'var no = $("#dialog_no");'
    		.'var dialog = document.querySelector(id==null?"dialog.confirm-dialog":"#"+id);'
			.'if (!dialog.showModal) {'
				.'dialogPolyfill.registerDialog(dialog);'
		    .'}'
			.'yes.click(function() {'
    			.'dialog.close();'
			.'});'
			.'no.click(function() {'
    			.'dialog.close();'
			.'});'
		.'};'
		.'var showConfirmDialog = function(id, onConfirm){'
			.'var dialog = document.querySelector(id==null?"dialog.confirm-dialog":"#"+id);'
			.'if (onConfirm) {'
				.'var yes = $("#dialog_yes");'
				.'yes.off("click");'
				.'yes.click(function() {'
	    			.'onConfirm();'
    				.'dialog.close();'
				.'});'
			.'}'
			.'dialog.showModal();'
		.'}';
	}
}
?>
