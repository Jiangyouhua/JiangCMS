<?php
class Part_Menu extends Part_Navbar{
	protected function init(){
		$this->html=new Html('ul');
		$this->style="menu";
	}
}