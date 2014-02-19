<?php
class Part_Checkbox extends Part{

	protected function init(){
		$this->style="checkbox";
		$this->html=new Html('ul');
	}

	protected function getHtml(){
		if(!$this->array){
			parent::getHtml();
			return;
		}
		$prefix=null;
		foreach ($this->array as $value){
				
			/*显示级别差异*/
			if(!empty($value[$this->level])){
				$prefix=$this->level2prefix($value[$this->level]);
			}
			$li=new Html('li');
			$this->html->add($li);
			$input=new Html('input');
			$input->type="checkbox";
			$input->value=$value['id'];
			$li->add($input);
			$li->add($prefix.$this->lang($value['name']));
		}
	}
}