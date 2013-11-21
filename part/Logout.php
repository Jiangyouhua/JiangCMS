<?php
class Part_Logout extends Part{
	
	protected function init(){
		$this->style="logout";
		$this->html=new Html('span');
	}
	
	protected function getHtml(){
		$a=new Html('a');
		$a->add(Lang::to('logout',$this->unit['name']));
		$this->html->add($a);
	}
}