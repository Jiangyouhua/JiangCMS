<?php
class Part_List extends Part {
	protected $edit;
	protected $handle;
	protected $model;
	protected $function;
	protected $icon;
	protected $column;
	protected $prefix;
	protected $check;
	protected $caption;
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
		$this->caption = true;
	}
	function setHandle($handle) {
		$this->handle = $handle;
	}
	function setModel($model) {
		$this->model = $model;
	}
	function setFunction($function) {
		$this->function = $function;
	}
	function setEdit($open = true, $modify = true, $delete = true) {
		$this->edit ['open'] = $open;
		$this->edit ['modify'] = $modify;
		$this->edit ['delete'] = $delete;
	}
	function setColumn(array $column) {
		$this->column = $column;
	}
	function noCaption() {
		$this->caption = false;
	}
	function reCheck($checkbox = true) {
		$this->check = 'radio';
		if ($checkbox) {
			$this->check = 'checkbox';
		}
	}
	function setPrefix($prefix = '-') {
		$this->prefix = $prefix;
	}
	protected function getHtml() {
		if (! $this->array) {
			parent::getHtml ();
			return;
		}
		$ul = new Html ( 'ol' );
		$array = null;
		foreach ( $this->array as $key => $value ) {
			if (! is_array ( $value )) {
				$id = $key;
				$array ['name'] = $value;
			} else {
				$array = $value;
				$id = empty ( $value ['id'] ) ? $key : $value ['id'];
			}
			$li = new Html ( 'li' );
			$ul->add ( $li );
			$li->id = "li$id";
			/* edit */
			$metadata = empty ( $array ['metadata'] ) ? null : $array ['metadata'];
			$li->add ( $this->edit ( $id, $array ['name'], $metadata ) );
			$this->element ( $li, $array, $value );
		}
		if ($this->caption) {
			$this->caption (  $array  );
		}
		$this->html->add ( $ul );
	}
	protected function caption($array) {
		$ul = new Html ( 'ul' );
		$ul->class='caption';
		$li = new Html ( 'li' );
		$ul->add ( $li );
		/* edit */
		$span = new Html ( 'span' );
		$span->class = 'edit';
		$span->add ( Lang::to ( 'edit' ) );
		$li->add ( $span );
		
		foreach ( $array as $key => $value ) {
			if(!in_array ( $key, $this->column )){
				continue;
			}
			$span = new Html ( 'span' );
			$span->class = $key;
			$span->add ( Lang::to ( $key ) );
			$li->add ( $span );
		}
		$this->html->add ( $ul );
	}
	protected function element($li, $array, $value) {
		foreach ( $array as $k => $v ) {
			$span = new Html ( 'span' );
			$span->class = $k;
			if ($k == 'name') {
				$prefix = null;
				if (! empty ( $value ['level'] )) {
					$prefix = $this->prefix ( $value ['level'] );
				}
				$check = $this->check ( $value ['id'] );
				$span->add ( $prefix );
				$span->add ( $check );
			}
			if($k=='status'){
				$v='x';
				if($v){
					$v='√';
				}
			}
			if (! in_array ( $k, $this->column )) {
				$span->class = 'hidden';
			}
			$span->add ( $v );
			$li->add ( $span );
		}
	}
	protected function edit($id, $name, $metadata = null) {
		$b = null;
		foreach ( $this->edit as $key => $value ) {
			if (! $value) {
				continue;
			}
			$onclick = null;
			if ($key == 'open') {
				$url = $_SERVER ['PHP_SELF'];
				$menu = empty ( $_GET ['menu'] ) ? 0 : $_GET ['menu'];
				$onclick = "edit_open($id,'$url','$menu')";
			}
			if ($key == 'delete' && ! $metadata) {
				$onclick = "edit_delete($id,'$this->handle','$this->model','$this->function')";
			}
			if ($key == 'modify') {
				$onclick = "edit_$key($id,'$name')";
			}
			
			if (! $onclick) {
				continue;
			}
			
			$a = new Html ( 'a' );
			$span = new Html ( 'span' );
			$span->class = "icon-" . $this->icon [$key];
			$a->href = '#';
			$a->onclick = $onclick;
			$a->class = "edit_$key";
			$a->add ( $span );
			$b [] = $a;
			
			if ($b) {
				$span = new Html ( 'span' );
				$span->class = 'edit';
				$span->add ( $b );
				return $span;
			}
			return;
		}
	}
	protected function prefix($level) {
		if ($this->prefix) {
			$prefix = str_repeat ( $this->prefix, substr_count ( $level, '.' ) * 2 );
		}
		return $prefix;
	}
	protected function check($id) {
		if ($this->check) {
			$check = new Html ( 'input' );
			$check->type = $this->check;
			$name = $this->title;
			if ($this->check == 'checkbox') {
				$name .= '[]';
			}
			$check->name = $name;
			$check->value = $id;
			return $check;
		}
	}
}