<?php
class Page implements IFormat{

	protected $html;
	protected $head;
	protected $meta=array();
	protected $title;
	protected $link=array();
	protected $scriptLink=array();
	protected $script=array();
	protected $onload;
	protected $body;

	private function __construct(){
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
	function addScript($script,$lang='javascript'){
			$this->script[$lang][]=$script;
	}
	function addLoad($script){
		$this->onload=$script;
	}
	function addMeta(array $value){
		$meta=new Html('meta');
		foreach ($value as $key=>$it){
			$meta->$key=$it;
		}
		$this->meta[]=$meta;
	}
	function addLink($link,$type='css'){
		$alink = new Html('link');
		$alink->type="text/css";
		switch($type){
			case 'less':
				$alink->rel="stylesheet/less";
				break;
			case 'css':
				$alink->rel="stylesheet";
				break;
		}
		$alink->href=$link;
		$this->link[]=$alink;
	}
	function addScriptLink($scriptLink,$lang="javascript"){
		$script=new Html("script");
		switch ($lang){
			case 'javascript':
				$script->type="text/javascript";
				break;
		}
		$script->src=$scriptLink;
		$this->scriptLink[]=$script;
	}
	function add($content){
		$this->body->add($content);
	}
	function format(){
		$i='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';

		$this->head->add($this->title);
		$this->head->add($this->meta);
		$this->head->add($this->scriptLink);
		$this->head->add($this->link);
		$this->head->add($this->forScript());
		$this->head->add($this->onload);
		$this->html->add($this->head);
		$this->html->add($this->body);
		return $i.$this->html->format();
	}
	protected function forScript(){
		$string=null;
		foreach ($this->script as $key=>$value){
			$script=new Html('script');
			switch ($key){
				case 'javascript':
					$script->type="text/javascript";
					break;
			}
			$script->add(implode(";", $value));
			$string.=$script->format();
		}
		return $string;
	}
}