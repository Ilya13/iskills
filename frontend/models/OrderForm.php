<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Order;
use common\utils\ImageUtil;

/**
 * Order form
 */
class OrderForm extends Model {
	
    public $project;
	public $name;
	public $size;
	public $materials;
	public $rangeMin;
	public $rangeMax;
	public $imageFiles;
	public $details;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['imageFiles', 'each', 'rule' => ['string']],
            ['details', 'string', 'length' => [0, 2000]],
            ['name', 'string', 'length' => [0, 255]],
            ['size', 'string', 'length' => [0, 250]],
            ['materials', 'string', 'length' => [0, 250]],
            ['rangeMin', 'number'],
            ['rangeMax', 'number'],
            ['details', 'string', 'length' => [0, 250]],
        ];
    }

    public function order() {
        if ($this->validate()) {
            $order = new Order();
            $order->userId = Yii::$app->user->getId();
            $order->categoryId = $this->project->categoryId;
            $order->projectId = $this->project->id;
            $order->name = $this->project->name;
            $order->masterId = $this->project->masterId;
            $order->details = $this->details;
            
            if ($order->save()){
            	ImageUtil::saveOrderFiles($order->id, $this->imageFiles);
            	return $order;
            }
        }
		return null;
    }
    
    public function edit($id) {
    	if ($this->validate()) {
    		$order = Order::findIdentity($id);
    		if ($order->userId == Yii::$app->user->getId()){
    			$order->name = $this->name;
    			$order->size = $this->size;
    			$order->materials = $this->materials;
    			$order->rangeMin = $this->rangeMin;
    			$order->rangeMax = $this->rangeMax;
    			$order->details = $this->details;
    			
    			if ($order->save()){
    				ImageUtil::saveOrderFiles($order->id, $this->imageFiles);
    				return $order;
    			}
    		}
    	}
    	return null;
    }
    
    public function attributeLabels()
    {
    	return ['imageFiles' => 'Фотографии', 'details' => 'Описание заказа'];
    }
}
