<?php
class Part_Full extends Part{
	protected function init(){
		$this->style="list";
		$this->url=true;
		$this->html=new Html('ol');
	}
}