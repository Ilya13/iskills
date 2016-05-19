<?php
namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\Url;

class Pagination extends \yii\base\Widget {
	private static $BUTTONS_COUNT = 5;
	private static $MOD = 2;
	
	public $html;
	public $page;
	public $pageCount;
	public $href;

	public function init(){
		parent::init();
		if ($this->pageCount < 2){
			$this->html = '';
			return;
		}
		
		if (!isset($this->page) || $this->page === null){
			$this->page = 1;
		}
		
		$this->html = '<div class="text-center"><nav><ul class="pagination">';
		
		if ($this->page > 1){
			$this->html .= '<li>'
						      .'<a href="'.Url::to(array_merge($this->href, ['page' => $this->page - 1])).'" aria-label="Предыдущая">'
						        .'<span aria-hidden="true">&laquo;</span>'
						      .'</a>'
						    .'</li>';
		}
		
		$first = min($this->page - static::$MOD, $this->pageCount - static::$BUTTONS_COUNT + 1);
		$first = max(1, $first);
		$last = min($this->pageCount, $first + static::$BUTTONS_COUNT - 1);
		
		for ($i = $first; $i <= $last; $i++){
			$this->html .= '<li';
			if ($i == $this->page){
				$this->html .= ' class="active"';
			}
			$this->html .= '><a href="';
			
			if ($i > 1) {
				$this->html .= Url::to(array_merge($this->href, ['page' => $i]));
			} else {
				$this->html .= Url::to($this->href);
			}
			
			$this->html .= '">'.$i.'</a></li>';
		}
		
		if ($this->page < $this->pageCount) {
			$this->html .= '<li>'
								.'<a href="'.Url::to(array_merge($this->href, ['page' => $this->page + 1])).'" aria-label="Следующая">'
									.'<span aria-hidden="true">&raquo;</span>'
								.'</a>'
							.'</li>';
		}
		
		$this->html .= '</ul></nav></div>';
	}

	public function run(){
		return $this->html;
	}
}
?>
