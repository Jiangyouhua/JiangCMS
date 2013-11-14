<?php
class Part_Logo extends Part{
	protected function init(){
		$this->style="logo";
		$this->html=new Html('span');
	}
	
	protected function getHtml(){
		if(!$this->array){
			return parent::getHtml();
		}
		$this->html->class="textlogo";
		$this->html->add("JCMS");
	}
}