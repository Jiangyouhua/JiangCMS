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
	protected $key;
	
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
		$this->key='default';
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
	function setKey($key){
		$this->key=$key;
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
		$table = new Html ( 'table' );
		$array = null;
		foreach ( $this->array as $key => $value ) {
			if (! is_array ( $value )) {
				$id = $key;
				$array ['name'] = $value;
			} else {
				$array = $value;
				$id = empty ( $value ['id'] ) ? $key : $value ['id'];
			}
			if($key==0){
				$this->caption ($table, $array );
			}
			$tr = new Html ( 'tr' );
			$table->add ( $tr );
			$tr->id = "li$id";
			$td=new Html('td');
			$td->class='li';
			$td->add($key);
			$tr->add($td);
			/* edit */
			$metadata = empty ( $array ['metadata'] ) ? null : $array ['metadata'];
			$tr->add ( $this->edit ( $id, $array ['name'], $metadata ) );
			$this->element ( $tr, $array, $value );
		}
		$this->html->add ( $table );
	}
	protected function caption($table,$array) {
		$tr = new Html ( 'tr' );

		/* edit */
		$edit=false;
		$th = new Html ( 'th' );
		$th->class = 'li';
		$th->add ( $this->lang ( 'li' ) );
		$tr->add ( $th );
		foreach ($this->edit as $value){
			if($value){
				$edit=true;
			}
		}
		if($edit){
			$th = new Html ( 'th' );
			$th->class = 'edit';
			$th->add ( $this->lang ( 'edit' ) );
			$tr->add ( $th );
		}
		
		foreach ( $array as $key => $value ) {
			if (! in_array ( $key, $this->column )) {
				continue;
			}
			$th = new Html ( 'th' );
			$th->class = $key;
			$th->add ( $this->lang ( $key ) );
			$tr->add ( $th );
		}
		$table->add ( $tr );
	}
	protected function element($tr, $array, $value) {
		foreach ( $array as $k => $v ) {
			$td = new Html ( 'td' );
			$td->class = $k;
			if ($k == 'name') {
				$prefix = null;
				if (! empty ( $value ['level'] )) {
					$prefix = $this->prefix ( $value ['level'] );
				}
				$check = $this->check ( $value ['id'] );
				$td->add ( $prefix );
				$td->add ( $check );
			}
			$input=$this->hideInput($k, $v);
			if ($k == 'status') {
				if ($v) {
					$v = '√';
				}else{
					$v = 'x';
				}
			}
			if (! in_array ( $k, $this->column )) {
				$td->class = 'hidden';
			}
			$td->add ( $v );
			$td->add($input);
			$tr->add ( $td );
		}
	}
	protected function hideInput($name,$value){
		$input=new Html('input');
		$input->type='hidden';
		$input->name=$name;
		$input->value=$value;
		return $input;
	}
	protected function edit($id, $name, $metadata = null) {
		$td=null;
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
				$onclick = "edit_$key($id,'$name','$this->key',this)";
			}
			
			if (! $onclick) {
				continue;
			}
			if(!$td){
				$td=new Html('td');
				$td->class='edit';
			}
			$a = new Html ( 'a' );
			$span = new Html ( 'span' );
			$span->class = "icon-" . $this->icon [$key];
			$a->href = '#';
			$a->onclick = $onclick;
			$a->class = "edit_$key";
			$a->add ( $span );
			$td->add($a);
		}
		return $td;
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