<?php
class Part_Form extends Part {
	protected $action;
	protected $method;
	protected $title;
	protected $modle;
	function setAction($url) {
		$this->action = $url;
	}
	protected function init() {
		$this->html = new Html ( 'form' );
		$this->method = 'post';
		$this->modle = 'default';
		$this->action = 'handle.php';
	}
	function setModle($modle) {
		$this->modle = $modle;
	}
	function reMethod() {
		$this->method = "get";
	}
	protected function getHtml() {
		$this->html->action = $this->action;
		$this->html->method = $this->method;
		
		$ul = new Html ( 'ul' );
		$this->html->add ( $ul );
		
		$ul->add ( $this->edit () );
		foreach ( $this->array as $value ) {
			if (! is_a ( $value, 'form' )) {
				return;
			}
			$li = new Html ( 'li' );
			$li->add ( $value );
			$ul->add ( $li );
		}
	}
	protected function edit() {
		$li = new Html ();
		$li->class = 'edit';
		$li->add ( $this->submit () );
		$li->add ( $this->reset () );
		
		/* 设置处理类 */
		$input = new Html ( 'input' );
		$input->type = 'hidden';
		$input->name = 'jcms_modle';
		$input->value = $this->modle;
		$li->add ( $input );
		
		/* 保存单元标题 */
		if ($this->title) {
			$input = new Html ( 'input' );
			$input->type = 'hidden';
			$input->name = 'jcms_name';
			$input->value = $this->title;
			$li->add ( $input );
		}
		
		/* 保存单元名称 */
		if (! empty ( $this->unit ['name'] )) {
			$input = new Html ( 'input' );
			$input->type = 'hidden';
			$input->name = 'jcms_unit';
			$input->value = $this->$this->unit ['name'];
			$li->add ( $input );
		}
		
		/* 保存条目ID */
		$input = new Html ( 'input' );
		$input->type = 'hidden';
		$input->name = 'jcms_id';
		$li->add ( $input );
		
		/* 保存条目名称 */
		$input = new Html ( 'input' );
		$input->type = 'hidden';
		$input->name = 'jcms_name';
		$li->add ( $input );
		return $li;
	}
	protected function submit() {
		$button = new Html ( 'button' );
		$button->type = 'submit';
		$button->class = "submit";
		$button->add ( Lang::to ( 'submit' ) );
		return $button;
	}
	protected function reset() {
		$button = new Html ( 'button' );
		$button->type = 'reset';
		$button->class = 'reset';
		$button->add ( Lang::to ( 'reset' ) );
		return $button;
	}
}