<?php
class Form  implements  IFormat{

	protected $element;
	protected $attr;
	protected $value;
	protected $option;

	/*表单元素名称*/
	function setElemenu($element){
		$this->element=$element;
	}

	/*表单元素属性*/
	function addAttr($key,$value){
		$this->attr[$key]=$value;
	}

	/*表单元素保存值*/
	function setValue($value){
		$this->value=$value;
	}

	/*表彰元素备选项*/
	function setOption(array $option){
		$this->option=$option;
	}

	function format(){
		$method="get$this->element";
		$html = $this->$method();
		return $html->format();
	}

	/*input*/
	protected function getInput(){
		$html=null;
		if(!empty($this->attr['type']) &&
				($this->attr['type']=='checkbox' || $this->attr['type']=='radio')){
			$html=new Html('ul');
			$ul->class=$this->element;
			foreach($this->option as $key => $value){
				$li=new Html('li');
				$element=$this->forElement();
				$element->value=$key;
				if($key==$this->value){
					$element->checked='checked';
				}
				$li->add($element);
				$li->add($value);
				$ul->add($li);
			}
		}else {
			$html=$this->forElement();
			$html->value=$this->value;
		}
		return $html;
	}

	/*select*/
	protected function getSelect(){
		$select=$this->forElement();
		foreach($this->option as $key => $value){
			$option=new Html('option');
			$option->value=$key;
			$option->add($value);
			if($key==$this->value){
				$option->seleted='seleted';
			}
			$select->add($option);
		}
		return $select;
	}

	/*button*/
	protected function getButton(){
		$button=$this->forElement();
		$button->add($this->value);
		return $button;
	}

	/*textarea*/
	protected function getTextarea(){
		$Textarea=$this->forElement();
		$Textarea->add($this->value);
		return $Textarea;
	}

	protected function forElement(){
		$element=new Html($this->element);
		if($this->attr){
			foreach ($this->attr as $key => $value){
				$element->$key=$value;
			}
		}
		return $element;
	}

}