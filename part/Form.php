<?php
class Part_Form extends Part {
	protected $action;
	protected $method;
	protected $function;
	protected $title;
	protected $model;
	protected $edit;
	protected function init() {
		$this->html = new Html ( 'form' );
		$this->method = 'post';
		$this->model = 'default';
		$this->action = 'handle.php';
		$this->edit = array (
				1,
				1
		);
	}
	function setAction($url) {
		$this->action = $url;
	}
	
	function setmodel($model) {
		$this->model = $model;
	}
	function setFunction($function) {
		$this->function = $function;
	}
	function setEdit($submit = true, $reset = true) {
		$this->edit = array (
				$submit,
				$reset 
		);
	}
	function reMethod() {
		$this->method = "get";
	}
	protected function getHtml() {
		$this->html->action = $this->action;
		$this->html->method = $this->method;
		
		$edit = $this->edit ();
		$element = $this->element ();
		
		$this->html->add ( $edit );
		$this->html->add ( $element );
	}
	protected function edit() {
		$div = new Html ();
		$div->class = 'edit';
		$div->add ( $this->submit () );
		$div->add ( $this->reset () );
		$div->add ( $this->hidden () );
		return $div;
	}
	protected function element() {
		$div=new Html();
		$div->class='elements';
		$div->add($this->array);
		return $div;
	}
	protected function submit() {
		$button = new Form ( 'button', null, 'submit' );
		if (empty ( $this->edit [0] )) {
			$button->disabled = 'disabled';
		}
		return $button;
	}
	protected function reset() {
		$button = new Form ( 'button', null, 'reset' );
		if (empty ( $this->edit [1] )) {
			$button->disabled = 'disabled';
		}
		return $button;
	}
	protected function hidden() {
		/* 设置处理类 */
		$array = null;
		$input = new Form ( 'input', 'jcms_model', 'hidden' );
		$input->setValue($this->model);
		$array [] = $input;
		
		/* 设置处理函数 */
		$input = new Form ( 'input', 'jcms_function', 'hidden' );
		$input->setValue($this->function);
		$array [] = $input;
		
		/* 保存所属版块 */
		$input = new Form ( 'input', 'jcms_title', 'hidden' );
		$input->setValue($this->title);
		$array [] = $input;
		
		/* 保存处理id */
		$input = new Form ( 'input', 'id', 'hidden' );
		$array [] = $input;
		return $array;
	}
}