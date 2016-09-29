<?php
namespace common\widgets;

use yii\helpers\Html;

class StarsRating extends \yii\base\Widget {
	public $html;
	public $rating;
	public $reviews;
	public $isSmall = false;
	public $reviewsLink;

	public function init(){
		parent::init();
		$stars = round($this->rating);
		$stars = max(0, $stars);
		$stars = min($stars, 5);
		$this->html = '<div class="star_rating'.($this->isSmall?'_small':'').'">'
						.'<div class="star_value star_'.$stars.'0"></div>'
						.($this->reviews === null || $this->reviews <= 0 ? '' : 
							'<div class="num_reviews">'
								.'(<a href="'.$this->reviewsLink.'">'.$this->reviews.'</a>)'
							.'</div>')
					.'</div>';
	}

	public function run(){
		return $this->html;
	}
}
?>
