<?php
class Part_Copyright extends Part{
	protected function init(){
		$this->html=new Html("span");
	}
	protected function getHtml(){
		if(!$this->array){
			parent::getHtml();
			return;
		}
		$this->html->add("Copyright © 2013 Jiang youhua.");
	}
}