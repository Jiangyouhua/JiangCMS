<?php
class Part_Copyright extends Part{
	protected function init(){
		$this->html=new Html("span");
	}
	protected function getHtml(){
		$this->html->add($this->lang('copyright'));
	}
}