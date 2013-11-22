<?php
class Page implements IFormat{

	protected $html;
	protected $head;
	protected $meta;
	protected $title;
	protected $css;
	protected $js;
	protected $icon;
	protected $body;

	function __construct(){
		$this->html=new Html('html');
		$this->head=new Html('head');
		$this->title=new Html('title');
		$this->body=new Html('body');
		$this->html->xmlns='http://www.w3.org/1999/xhtml';
	}
	
	function __set($name,$value){
		$this->body->$name=$value;
	}
	
	function setTitle($title){
		$this->title->add($title);
	}
	
	function addMeta(array $value){
		$meta=new Html('meta');
		foreach ($value as $key=>$it){
			$meta->$key=$it;
		}
		$this->meta[]=$meta;
	}
	
	function addCSS($content,$link=true){
		if($link){
			$css=new Html('link');
			$css->rel="stylesheet";
			$css->href=$content;
		}else{
			$css=new Html('style');
			$css->add($content);
		}
		$css->type="text/css";
		$this->css[]=$css;
	}
	
	function addJS($content,$link=true){
		$js=new Html('script');
		$js->type="text/javascript";
		if($link){
			$js->src=$content;
		}else{
			$js->add($content);
		}
		$this->js[]=$js;
	}

	function addIcon($link){
		$this->icon=new Html('link');
		$this->icon->rel="shortcut icon";
		$this->icon->type="image/x-icon";
		$this->icon->href=$link;
	}
	
	function addHead($string){
		$this->head->add($string);
	}
	
	function add($content){
		$this->body->add($content);
	}
	
	function format(){
		$i='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';

		$this->head->add($this->title);
		$this->head->add($this->meta);
		$this->head->add($this->css);
		$this->head->add($this->js);
		$this->head->add($this->icon);
		$this->html->add($this->head);
		$this->html->add($this->body);
		return $i.$this->html->format();
	}
}