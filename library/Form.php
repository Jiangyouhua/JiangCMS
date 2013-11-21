<?php
class Form implements IFormat {
	protected $element;
	protected $attr;
	protected $value;
	protected $name;
	protected $lable;
	protected $option;
	
	/* 表单元素名称 */
	function setElemenu($element) {
		$this->element = $element;
	}
	
	/* 表单元素属性 */
	function addAttr($key, $value) {
		$this->attr [$key] = $value;
	}
	
	/* 表单元素保存值 */
	function setValue($value) {
		$this->value = $value;
	}
	function setName($name) {
		$this->name = $name;
	}
	function setLable($lable) {
		$this->lable = $lable;
	}
	
	/* 表彰元素备选项 */
	function setOption(array $value, $iskey = false) {
		$this->option ['value'] = $value;
		$this->option ['iskey'] = $iskey;
	}
	function format() {
		$method = "get$this->element";
		if ($this->lable || ! $this->name) {
			$this->name = $this->lable;
		}
		if ($this->name || ! $this->lable) {
			$this->lable = $this->name;
		}
		$html = $this->$method ();
		if ($this->lable) {
			$span = new Html ( 'span' );
			$lable = new Html ( 'lable' );
			$lable->add ( Lang::to ( $this->lable ) );
			$span->add ( $lable );
			$span->add ( $html );
			return $span->format ();
		}
		return $html->format ();
	}
	
	/* input */
	protected function getInput() {
		$html = null;
		if (! empty ( $this->attr ['type'] ) && ($this->attr ['type'] == 'checkbox' || $this->attr ['type'] == 'radio')) {
			$html = new Html ( 'ul' );
			$ul->class = $this->element;
			foreach ( $this->option ['value'] as $key => $value ) {
				$li = new Html ( 'li' );
				$element = $this->forElement ();
				if ($this->option ['iskey']) {
					$element->value = $value;
				} else {
					$element->value = $key;
				}
				$element->name = $this->name . '[]';
				if ($key == $this->value) {
					$element->checked = 'checked';
				}
				$li->add ( $element );
				$li->add ( $value );
				$ul->add ( $li );
			}
		} else {
			$html = $this->forElement ();
			$html->value = $this->value;
			$html->name = $this->name;
		}
		return $html;
	}
	
	/* select */
	protected function getSelect() {
		$select = $this->forElement ();
		$select->name = $this->name;
		foreach ( $this->option ['value'] as $key => $value ) {
			$option = new Html ( 'option' );
			if ($this->option ['iskey']) {
				$option->value = $value;
			} else {
				$option->value = $key;
			}
			$option->add ( $value );
			if ($key == $this->value) {
				$option->seleted = 'seleted';
			}
			$select->add ( $option );
		}
		return $select;
	}
	
	/* button */
	protected function getButton() {
		$button = $this->forElement ();
		$button->add ( $this->value );
		return $button;
	}
	
	/* textarea */
	protected function getTextarea() {
		$Textarea = $this->forElement ();
		$Textarea->name = $this->name;
		$Textarea->add ( $this->value );
		return $Textarea;
	}
	protected function forElement() {
		$element = new Html ( $this->element );
		if ($this->attr) {
			foreach ( $this->attr as $key => $value ) {
				$element->$key = $value;
			}
		}
		return $element;
	}
}