<?php
namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use Yii;

class FileAttachment extends \yii\base\Widget {
	public $html;
	public $projectId;
	public $orderId;
	public $mainForm;
	public $imageFiles;
	
	public function init(){
		parent::init();
		$this->html = '<a id="upload" onclick="onUploadClick()" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">Прикрепить фото</a>'.
				'<input id="uploader" class="fileuploader" type="file" size="28" onchange="onUploadFile();" multiple accept="image/*" name="FileForm[imageFiles][]">';
		
		if ($this->imageFiles != null){
			$this->html .= '<div id="attachments_wrap" class="mdl-grid">'
							.'<div class="attachments_container">'
								.'<ul id="attachments" class="attachments">';
			foreach ($this->imageFiles as $file) {
				$arr = split('/', $file);
				$name = str_replace('.', '_', $arr[sizeof($arr)-1]);
				$this->html .= '<li>';
				$this->html .= '<a src="#" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onclick="removeUpload(this,\''.$name.'\')"><i class="material-icons">remove_circle</i></a><img src='.$file.' alt="">';
				$this->html .= '<input id='.$name.' type="text" name="'.$this->mainForm.'[imageFiles][]" class="attachment-form-control" value='.$file.'>';
				$this->html .= '</li>';
			}
			$this->html .= '</ul></div></div>';
		}
		
		$view = Yii::$app->getView();
		$view->registerJs($this->getJs(), View::POS_END);
	}
	
	public function run(){
		return $this->html;
	}
	
	private function getJs() {
		return
		'var attacheImages = function(data) {'
			.'var attachments = $("#attachments");'
			.'var mainForm = $("#'.$this->mainForm.'");'
			.'if (!attachments.length){'
				.'var upload = $("#upload").parent();'
				.'upload.append(\'<div id="attachments_wrap" class="mdl-grid">\'+'
								.'\'<div class="attachments_container">\'+'
									.'\'<ul id="attachments" class="attachments"></ul>\'+'
								.'\'</div>\'+'
							.'\'</div>\');'
				.'attachments = $("#attachments");'
			.'}'
			.'$.each(data.paths, function(index, value) {'
				.'var arr = value.split("/");'
				.'var name = arr[arr.length-1].replace(".","_");'
				.'attachments.append(\'<li>'
						.'<a src="#" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onclick="removeUpload(this,\\\'\'+name+\'\\\')">'
						  .'<i class="material-icons">remove_circle</i>'
						  .'</a>'
						  .'<img src="\'+value+\'" alt="">'
						  .'<input id="\'+name+\'" type="text" name="'.$this->mainForm.'[imageFiles][]" class="attachment-form-control" value="\'+value+\'">'
						  .'</li>\');'
			.'});'
		.'};'
		.'var onUploadFile = function() {'
			.'var input = $("#uploader");'
			.'var fd = new FormData();'
		    .'$.each(input.prop("files"), function(key, value) {'
		    	.'fd.append(input.prop("name"), value);'
		    .'});'
		    .'input.val("");'
		    .(($this->projectId != null)?'fd.append("projectId", '.$this->projectId.');':'')
		    .(($this->orderId != null)?'fd.append("orderId", '.$this->orderId.');':'')
		    .'$.ajax({'
		        .'url: "'.Url::toRoute(["file/upload"]).'",'
		        .'type: "POST",'
		        .'cache: false,'
		        .'data: fd,'
		        .'processData: false,'
		        .'contentType: false,'
		        .'success: function (data) {'
		        	.'attacheImages(data);'
		        .'},'
		        .'error: function () {'
		            .'alert("ERROR in upload");'
		        .'}'
		    .'});'
		.'};'
		.'var getAllUploads = function(){'
			.'$.ajax({'
		        .($this->projectId!=null?'url: "'.Url::toRoute(["file/uploads", "projectId" => $this->projectId]).'",':'')
		        .($this->orderId!=null?'url: "'.Url::toRoute(["file/uploads", "orderId" => $this->orderId]).'",':'')
		        .'type: "GET",'
		        .'cache: false,'
		        .'processData: false,'
		        .'contentType: false,'
		        .'success: function (data) {'
		        	.'attacheImages(data);'
		        .'},'
		        .'error: function () {'
		            .'alert("ERROR in upload");'
		        .'}'
		    .'});'
		.'};'
		.'var removeUpload = function(element, name) {'
			.'element.parentNode.remove();'
			.'$("#"+name).remove();'
		.'};'
		.'var onUploadClick = function() {'
			.'$("#uploader").click();'
		.'};';
	}
}
?>
