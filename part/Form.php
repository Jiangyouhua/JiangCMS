<?php
class Part_Form extends Part{
	
	protected $action;
	protected $method;
	
	function setAction($url){
		$this->action=$url;
	}
	
	function reMethod(){
		$this->method="get";
	}
	
	protected function init(){
		$this->method='post';
	}
	
	protected function getHtml(){
		$form=new Html('form');
		$form->action=$this->action;
		$form->methed=$this->method;
		$ul=new Html('ul');
		$form->add($ul);
		foreach ($this->array as $key => $value){
			$li=new Html('li');
			$label=new Html('lable');
			$label->add(Lang::to($key));
			$li->add($label);
			if(!is_a($value,'form')){
				return ;
			}
			$li->add($value);
			$ul->add($li);
		}
		$li=new Html();
		$li->class='event';
		$li->add($this->submit());
		$li->add($this->reset());
		$ul->add($li);
		$this->html->add($form);
	}
	
	protected function submit(){
		$button=new Html('button');
		$button->type='submit';
		$button->class="submit";
		$button->add(Lang::to('submit'));
		return $button;
	}
	
	protected function reset(){
		$button=new Html('button');
		$button->type='reset';
		$button->class='reset';
		$button->add(Lang::to('reset'));
		return $button;
	}
}