<?php
class Part implements IFormat{
	
	protected $html;
	protected $array;
	protected $unit;
	protected $style;
	
	function __construct(){
		$this->init();
	}
	
	protected function init(){
		
	}
	
	function setUnit(array $unit){
		$this->unit=$unit;
	}
	
	function getUnit(){
		return $this->unit;
	}
	
	function setArray(array $array){
		$this->array=$array;
	}
	
	function getArray(){
		return $this->array;
	}
	
	protected function getHtml(){
		$this->html->add(Lang::to(get_class($this)));
	}
	
	function format(){
		if(!$this->html){
			$this->html=new html();
		}
		if($this->unit && empty($this->unit['name']) && $this->unit['class']){
			$this->html->id=$this->unit['name'];
			$this->html->class=$this->unit['class'];
		}
		if($this->style){
			$this->html->class=$this->style;
		}
		$this->getHtml();
		return $this->html->format();
	}
}