<?php

namespace common\utils;

use Yii;
use yii\helpers\Url;

class ImageUtil {
		
	public static function getAvatar($dir) {
		$dir = Yii::getAlias('@web').'/img'.$dir;
		$files = scandir(Yii::getAlias('@root').$dir);
		if (count($files) < 2) return null;
		
		foreach ($files as $file){
			if (strpos($file, 'avatar') !== false){
				return $dir.'/'.$file;
			}
		}
		
		return $dir.'/'.$files[2];
	}
	
	public static function getImages($dir){
		$dir = Yii::getAlias('@web').'/img'.$dir;
		$path = Yii::getAlias('@root').$dir;
		if (is_dir($path) === false) return null;
		$files = scandir($path);
		if (count($files) < 2) return null;
		
		$result = array();
		
		foreach ($files as $file){
			try {
				if (@is_array(getimagesize($path.'/'.$file))) {
					array_push($result, $dir.'/'.$file);
				}
			} catch (Exception $e) {}
		}
		return $result;
	}

	public function uploadTemp($files) {
		$path = Yii::getAlias('@frontend').'/web/img';
		$baseLink = '/temp';
		
		if (!is_dir($path.$baseLink)) {
			mkdir($path.$baseLink);
		}
		$baseLink .= '/'.date("md");
		if (!is_dir($path.$baseLink)) {
			mkdir($path.$baseLink);
		}
			
		$links = array();
		
		$j = 0;
		for ($i = 0; $i < sizeof($files); $i++){
			$file = $files[$i];
			$link = $baseLink.'/'.$j.'.'.$file->extension;
		
			while (is_file($path.$link)){
				$j++;
				$link = $baseLink.'/'.$j.'.'.$file->extension;
			}
		
			$file->saveAs($path.$link);
			$links[$i] = Url::base().'/img'.$link;
			$j++;
		}
		return $links;
	}
	
	public static function saveOrderFiles($orderId, $files) {
		$path = Yii::getAlias('@frontend').'/web/img';
		$baseLink = '/order';
		
		if (!is_dir($path.$baseLink)) {
			mkdir($path.$baseLink);
		}
		$baseLink .= '/'.$orderId;
		if (!is_dir($path.$baseLink)) {
			mkdir($path.$baseLink);
		}
		
		if ($files === null || count($files) == 0){
			$files = glob($path.$baseLink.'/*');
			foreach($files as $file){
				if(is_file($file))
					unlink($file);
			}
			rmdir($path.$baseLink);
		} else {
			foreach ($files as $file) {
				if (strpos($file, 'order') !== false) continue;
				$link = str_replace(Url::base().'/img', '', $file);
				if (is_file($path.$link)){
					$arr = split('/', $file);
					$name = $arr[sizeof($arr)-1];
					copy($path.$link, $path.$baseLink.'/'.$name);
					unlink($path.$link);
				}
			}
		}
	}
	
	public function drawImages($images) {
		$html = '';
		foreach ($images as $image){
			$html .= '';
		}
		return $html;
	}
}