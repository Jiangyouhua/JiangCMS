<?php
class Form implements IFormat {
	protected $element;
	protected $name;
	protected $type;
	protected $label;
	protected $attr;
	protected $value;
	protected $k;
	protected $v;
	protected $array;
	protected $iskey;
	protected $root;
	function __construct($name, $element, $type = null, $label = 1) {
		$this->name = $name;
		$this->element = $element;
		$this->type = $type;
		$this->label = $label;
		if ($label == 1) {
			$this->label = $name;
		}
	}
	
	/* 表单元素属性 */
	function __set($key, $value) {
		if ($key == 'class') {
			$this->attr ['class'] = empty ( $this->attr ['class'] ) ? $value : $this->attr ['class'] . ' ' . $value;
		}
		if($key=='multiple' && $value=='multiple'){
			$this->name.='[]';
		}
		$this->attr [$key] = $value;
	}
	function setLabel($label) {
		$this->label = $label;
	}
	function setValue($value) {
		$this->value = $value;
	}
	function setArray(array $array, $k='id',$v='name') {
		$this->array = $array;
		$this->k = $k;
		$this->v=$v;
	}
	function setRoot($root = 'root') {
		$this->root = $root;
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
		$label->class = 'label';
		$label->add ( $this->label );
		return $label;
	}
	/* input */
	protected function getInput() {
		if ($this->type == 'radio') {
			if (! $this->array) {
				$this->array = array (
						'no',
						'yse' 
				);
			}
			return $this->otherInput ();
		}
		if ($this->type == 'checkbox') {
			$this->name .= '[]';
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
		$spans = null;
		foreach ( $this->array as $key => $value ) {
			$array = $this->forValue ( $key, $value );
			$span = new Html ( 'span' );
			$input = $this->getElement ();
			$input->value = $value [$this->k];
			$span->add ( $input );
			if (!empty($array [$this->k])  && $this->value == $array [$this->k]) {
				$input->checked = 'checked';
				$span->add ( $array [$this->v] );
			}
			$spans [] = $span;
		}
		return $spans;
	}
	
	/* select */
	protected function getSelect() {
		$select = $this->getElement ();
		if ($this->root) {
			$select->add ( $this->root () );
		}
		if ($this->array) {
			foreach ( $this->array as $key => $value ) {
				$prefix = null;
				$array = $this->forValue ( $key, $value );
				if (! empty ( $array ['level'] )) {
					$prefix = str_repeat ( '--', substr_count ( $array ['level'], '.' ) );
				}
				$option = new Html ( 'option' );
				$option->value = $array [$this->k];
				if ($array [$this->k] == $this->value) {
					$option->selected = 'selected';
				}
				$option->add ( $prefix );
				$option->add ( $array [$this->v] );
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
		$button->add ( $this->value );
		return $button;
	}
	
	/* textarea */
	protected function getTextarea() {
		$Textarea = $this->getElement ();
		$Textarea->add ( $this->value );
		return $Textarea;
	}
	protected function getEditor() {
		$div = new Html ();
		$div->id = "editor";
		return $div;
	}
	protected function getFile() {
		$this->element = 'input';
		$this->type = 'file';
		$file = $this->getInput ();
		$file->id = 'file';
		return $file;
	}
	protected function getCaptcha() {
		$span = null;
		$this->element = 'input';
		$span [] = $this->getInput ();
		$captcha = new Plug_Captcha_Captcha ();
		$a = new Html ( 'a' );
		$a->title = Lang::to ( 'captchainof' );
		$a->class = 'captcha';
		$a->href = '#';
		$a->onclick = "new_captcha()";
		$img = new Html ( 'img' );
		$img->src = $captcha->CreateImage ();
		$a->add ( $img );
		$span [] = $a;
		return $span;
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
	protected function forValue($key, $value) {
		$array = null;
		if (! is_array ( $value )) {
			$array ['id'] = $key;
			$array ['name'] = $value;
		} else {
			$array = $value;
		}
		return $array;
	}
	protected function root() {
		$option = new Html ( 'option' );
		$option->value = 0;
		$option->add ( 'root' );
		return $option;
	}
}