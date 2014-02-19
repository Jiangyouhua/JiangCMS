<?php
class Part_Form extends Part {
	protected $action;
	protected $method;
	protected $function;
	protected $title;
	protected $model;
	protected $edit;
	protected $key;
	protected function init() {
		$this->html = new Html ( 'form' );
		$this->method = 'post';
		$this->model = 'default';
		$this->action = 'handle.php';
		$this->edit = array (
				1,
				1 
		);
		$this->key='default';
	}
	function setAction($url) {
		$this->action = $url;
	}
	function setModel($model) {
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
	function setKey($key){
		$this->key=$key;
	}
	function reMethod() {
		$this->method = "get";
	}
	protected function getHtml() {
		$this->html->action = $this->action;
		$this->html->method = $this->method;
		$this->html->id=$this->key;
		
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
		$div = new Html ();
		$div->class = 'elements';
		$div->add ( $this->array );
		return $div;
	}
	protected function submit() {
		$button = new Form ( 0, 'button', 'submit' );
		if (empty ( $this->edit [0] )) {
			$button->disabled = 'disabled';
		}
		return $button;
	}
	protected function reset() {
		$button = new Form ( 0, 'button', 'reset' );
		if (empty ( $this->edit [1] )) {
			$button->disabled = 'disabled';
		}
		return $button;
	}
	protected function hidden() {
		/* 设置处理类 */
		$array = null;
		$input = new Form ( 'jcms_model', 'input', 'hidden',0 );
		$input->setValue ( $this->model );
		$array [] = $input;
		
		/* 设置处理函数 */
		$input = new Form ( 'jcms_function', 'input', 'hidden',0 );
		$input->setValue ( $this->function );
		$array [] = $input;
		
		/* 保存所属版块 */
		$input = new Form ( 'jcms_title', 'input', 'hidden',0 );
		$input->setValue ( $this->title );
		$array [] = $input;
		
		/* 保存处理id */
		$input = new Form ( 'id', 'input', 'hidden',0 );
		$array [] = $input;
		return $array;
	}
}