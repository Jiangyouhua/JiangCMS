<?php
class Part_Rotation extends Part{
	protected function init(){
		$this->style="rotation";
		$this->url=true;
		$this->html=new Html('ul');
	}
}