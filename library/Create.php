<?php
/*
 * 接收数据生成页面
 * */
class Create{
	
	protected $array;
	protected $page;
	
	function __construct(){
		$this->page=new Page();
		$this->page->addLink("ui/jquery/css/jquery-ui-1.10.3.css");
		$this->page->addLlnk("ui/jquery/css/layout.css");
		$this->page->addScriptLink("ui/jquery/js/jquery-1.9.1.js");
		$this->page->addScriptLink("ui/jquery/js/jquery-ui-1.10.3.js");
	}
	
	function setTitle($title){
		$this->page->setTitle($title);
	}
	
	function setArray($array){
		$this->array=$array;
	}
	
	function format(){
		
	}
}