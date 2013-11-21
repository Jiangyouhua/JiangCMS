<?php
class Part_Ad extends Part {
	protected function init() {
		$this->style = "ad";
	}
	protected function getHtml() {
		if (! $this->array) {
			parent::getHtml ();
			return;
		}
		foreach ($this->array as $key=>$value){
			$span=new Html('span');
			if($key>0){
				$span->class='hidden';
			}
			$img=new Html('img');
			$img->src=$value;
			$span->add($img);
			$this->html->add($span);
		}
	}
}