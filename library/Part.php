<?php
class Part implements IFormat {
	
	protected $html;   //root Html object
	protected $array;  //array for show
	protected $unit;   //unit's info
	protected $style;  //block style
	protected $class;
	protected $title;
	
	function __construct() {
		$this->init ();
	}
	
	protected function init() {
	}
	
	function setUnit(array $unit) {
		$this->unit = $unit;
	}
	
	function getUnit() {
		return $this->unit;
	}
	
	function setArray(array $array) {
		$this->array = $array;
	}
	
	function setTitle($title){
		$this->title=$title;
	}
	
	function addClass($class){
		$c=null;
		if(in_array($class)){
			$c=implode(" ", $class);
		}else{
			$c=$class;
		}
		$this->class[]=$c;
	}
	
	function getArray() {
		return $this->array;
	}
	
	protected function getTitle(){
		$div=new Html();
		$div->class='title';
		$div->add(Lang::to($this->title));
		$this->html->add($div);
	}
	
	protected function getHtml() {
		$this->html->add ( Lang::to ( get_class ( $this ) ) );
	}
	
	function format() {
		
		if (! $this->html) {
			$this->html = new html ();
		}
		if ($this->unit) {
			if ($this->unit ['name']) {
				$this->html->id = $this->unit ['name'];
			}
			if ($this->unit ['class']) {
				$this->html->class = $this->unit ['class'];
			}
		}
		if ($this->style) {
			$this->html->class = $this->style;
		}
		if($this->class){
			$this->html->class=$this->class;
		}
		if($this->title){
			$this->getTitle();
		}
		
		$this->getHtml ();
		return $this->html->format ();
	}
}