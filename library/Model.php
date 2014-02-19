<?php
class Model {
	
	protected $back;
	protected $data;
	protected $array;
	protected $keys;
	
	function __construct() {
		$this->back = false;
		$this->init ();
		if ($_POST) {
			$this->data = $_POST;
		}
		if ($_GET) {
			$this->data = $_GET;
		}
		$diff = array (
				'jcms_model' => true,
				'jcms_function' => true,
				'jcms_title' => true 
		);
		$array = array_diff_key ( $this->data, $diff );
		if (empty ( $array ['id'] )) {
			unset ( $array ['id'] );
		}
		$this->array = $array;
	}
	
	protected function init() {
	}
	
	function handle() {
		return ;
		 
	}
	
	function setKeys() {
		if (is_string ( $this->keys )) {
			$this->keys = explode ( ',', $this->keys );
		}
		if (is_array ( $this->keys )) {
			$this->keys = $array;
		}
	}
	function back() {
		header ( "location:{$_SESSION['pre']}" );
	}
}