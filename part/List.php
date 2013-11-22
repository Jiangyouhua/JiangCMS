<?php
class Part_List extends Part {
	protected $edit;
	protected $handle;
	protected $model;
	protected $icon;
	protected $column;
	protected function init() {
		$this->edit = array (
				"open" => false,
				"modify" => false,
				"delete" => false 
		);
		$this->icon = array (
				'open' => 'eye-open',
				'modify' => 'pencil',
				'delete' => 'remove' 
		);
		$this->handle = 'handle.php';
		$this->model = 'defualt';
		$this->column = array (
				'name' 
		);
		$this->style = 'list';
	}
	function setHandle($handle) {
		$this->handle = $handle;
	}
	function setModel($model) {
		$this->model = $model;
	}
	function setEdit($open = true, $modify = true, $delete = true) {
		$this->edit ['open'] = $open;
		$this->edit ['modify'] = $modify;
		$this->edit ['delete'] = $delete;
	}
	protected function getHtml() {
		if (! $this->array) {
			parent::getHtml ();
			return;
		}
		$ul = new Html ( 'ol' );
		$this->html->add ( $ul );
		foreach ( $this->array as $key => $value ) {
			$array = null;
			$li = new Html ( 'li' );
			$ul->add ( $li );
			if (! is_array ( $value )) {
				$id = $key;
				$array ['name'] = $value;
			} else {
				$array = $value;
				$id = empty ( $value ['id'] ) ? $key : $value ['id'];
			}
			
			$li->id="li$id";
			
			/* edit */
			$li->add ( $this->edit ( $id, $array ['name'] ) );
			
			foreach ( $array as $k => $v ) {
				$span = new Html ( 'span' );
				if (! in_array ( $k, $this->column )) {
					$span->class = 'hidden';
				}
				$span->class = $k;
				$span->add ( $v );
				$li->add ( $span );
			}
		}
	}
	protected function edit($id, $name) {
		$b = null;
		foreach ( $this->edit as $key => $value ) {
			if ($value) {
				$a = new Html ( 'a' );
				$span = new Html ( 'span' );
				$span->class = "icon-" . $this->icon [$key];
				if ($key == 'delete') {
					$a->href = $this->handle . "?id=$id&name=$name&jcms_edit=$key&jcms_model=$this->model";
				}else{
					$a->href="#";
					$a->onclick="edit_$key($id,'".$name."')";
				}
				$a->class = "edit_$key";
				$a->add ( $span );
				$b [] = $a;
			}
		}
		if ($b) {
			$span = new Html ( 'span' );
			$span->class = 'edit';
			$span->add ( $b );
			return $span;
		}
		return;
	}
}