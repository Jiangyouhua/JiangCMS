<?php
class Form implements IFormat {
	protected $element;
	protected $name;
	protected $type;
	protected $label;
	protected $attr;
	protected $value;
	protected $array;
	protected $root;
	function __construct($element = null, $name = null, $type = null,$label=null) {
		$this->element = $element;
		$this->name = $name;
		$this->type = $type;
		$this->label=$label;
	}
	
	/* 表单元素属性 */
	function __set($key, $value) {
		if ($key == 'class') {
			$this->attr ['class'] = empty ( $this->attr ['class'] ) ? $value : $this->attr ['class'] . ' ' . $value;
		}
		$this->attr [$key] = $value;
	}
	function setElement($element, $name, $type = null) {
		$this->element = $element;
		$this->name = $name;
		$this->type = $type;
	}
	function setLabel($label) {
		$this->label = $label;
	}
	function setValue($value) {
		$this->value = $value;
	}
	function setArray(array $array) {
		$this->array = $array;
	}
	function setRoot($root='root'){
		$this->root=$root;
	}
	function format() {
		$div = null;
		$lable = null;
		if ($this->label) {
			$lable = $this->label ()->format ();
		}
		$method = "get$this->element";
		$div = $this->$method ();
		$html = null;
		if (is_array ( $div )) {
			foreach ( $div as $value ) {
				$html .= $value->format ();
			}
		} else {
			$html = $div->format ();
		}
		return $lable . $html;
	}
	protected function label() {
		$label = new Html ( 'label' );
		$label->add ( Lang::to ( $this->label ) );
		return $label;
	}
	/* input */
	protected function getInput() {
		if ($this->type == 'radio'){
			if(!$this->array){
				$this->array=array('no','yse');
			}
			return $this->otherInput ();
		}
		if($this->type == 'checkbox') {
			return $this->otherInput ();
		}
		if (! $this->type) {
			$this->type = 'text';
		}
		$input = $this->getElement ();
		if ($this->value) {
			$input->value = $this->value;
		}
		return $input;
	}
	protected function otherInput() {
		if (! $this->array) {
			return;
		}
		$this->name = $this->name . '[]';
		$spans = null;
		foreach ( $this->array as $key => $value ) {
			$array = null;
			if (! is_array ( $value )) {
				$array ['id'] = $key;
				$array ['name'] = $value;
			} else {
				$array = $value;
			}
			$span = new Html ( 'span' );
			$input = $this->getElement ();
			$input->value = $value ['id'];
			if ($this->value == $array ['id']) {
				$input->checked = 'checked';
			}
			$span->add ( $input );
			$span->add ( Lang::to ( $array ['name'] ) );
			$spans [] = $span;
		}
		return $spans;
	}
	
	/* select */
	protected function getSelect() {
		$select = $this->getElement ();
		if($this->root){
			$select->add($this->root());
		}
		if ($this->array) {
			foreach ( $this->array as $key => $value ) {
				$array = null;
				$prefix=null;
				if (! is_array ( $value )) {
					$array ['id'] = $key;
					$array ['name'] = $value;
				} else {
					$array = $value;
				}
				if(!empty($array['level'])){
					$prefix=str_repeat('--', substr_count($array['level'],'.'));
				}
				$option = new Html ( 'option' );
				$option->value = $array ['id'];
				if ($array ['id'] = $this->value) {
					$option->selected = 'selected';
				}
				$option->add($prefix);
				$option->add ( Lang::to ( $array ['name'] ) );
				$select->add ( $option );
			}
		}
		return $select;
	}
	
	/* button */
	protected function getButton() {
		$button = $this->getElement ();
		if (! $this->value) {
			$this->value = $this->type;
		}
		$button->add ( Lang::to ( $this->value ) );
		return $button;
	}
	
	/* textarea */
	protected function getTextarea() {
		$Textarea = $this->getElement ();
		$Textarea->add ( $this->value );
		return $Textarea;
	}
	protected function getRole(){
		$this->element='select';
		$this->name='role';
		$this->array=Admin_Db_Role::getAll();
		$role=$this->getSelect();
		return $role;
	}
	protected function getElement() {
		$element = new Html ( $this->element );
		if ($this->name) {
			$element->name = $this->name;
		}
		if ($this->type) {
			$element->type = $this->type;
		}
		if ($this->attr) {
			foreach ( $this->attr as $key => $value ) {
				$element->$key = $value;
			}
		}
		return $element;
	}
	
	protected function root(){
		$option = new Html ( 'option' );
		$option->value = 0;
		$option->add ( Lang::to ( 'root' ) );
		return $option;
	}
}