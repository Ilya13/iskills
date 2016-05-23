<?php
namespace common\models;

use common\utils\ImageUtil;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class FileForm extends Model
{
	/**
	 * @var UploadedFile[]
	 */
	public $imageFiles;
	public $projectId;
	public $orderId;
	public $name;

	public function rules()
	{
		return [
				[['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
		];
	}

	public function uploadTemp() {
		if (!$this->validate()) return null;
		return ImageUtil::uploadTemp($this->imageFiles);
	}
	
	public function getAllUploads() {
		$links = array();
		\Yii::info('orderId='.$this->orderId);
		\Yii::info('projectId='.$this->projectId);
		if ($this->orderId !== null) {
			if ($this->projectId !== null) {
				$projectImages = ImageUtil::getAvatar('/project/'.$this->projectId);
				if ($projectImages !== null) {
					array_push($links, $projectImages);
				}
			}
			$orderImages = ImageUtil::getImages('/order/'.$this->orderId);
			if ($orderImages !== null) {
				$links = array_merge($links, $orderImages);
			}
		} else if ($this->projectId !== null) {
			$projectImages = ImageUtil::getAvatar('/project/'.$this->projectId);
			if ($projectImages !== null) {
				$links = array_merge($links, $projectImages);
			}
		}
		return $links;
	}
	
	public function remove() {
		if (!isset($this->name) || $this->name === null) return false;
		
		$path = Yii::getAlias('@frontend').'/web/img';
		$baseLink = '/temp';

		if (!is_dir($path.$baseLink)) {
			return false;
		}
		$baseLink .= '/'.$this->projectId;
		if (!is_dir($path.$baseLink)) {
			return false;
		}
		
		if (is_file($path.$baseLink.'/'.$this->name)) {
			unlink($path.$baseLink.'/'.$this->name);
			return true;
		}
		return false;
	}
	
}