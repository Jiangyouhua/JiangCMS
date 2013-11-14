<?php
class Part_Select extends Part{

	protected function init(){
		$this->style="select";
		$this->html=new Html('Select');
	}

	protected function getHtml(){
		$prefix=null;
		foreach ($this->data as $value){
				
			/*显示级别差异*/
			if(!empty($value[$this->level])){
				$prefix=$this->level2prefix($value[$this->level]);
			}
			$option=new Html('option');
			$option->value=$value['id'];
			$option->add($prefix.$this->language->to($value['name']));
			$this->html->add($option);
		}
	}
}