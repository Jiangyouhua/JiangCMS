<?php
abstract class Model {
	protected $back;
	protected $post;
	protected $get;
	function __construct() {
		$this->back = false;
		$this->init ();
	}
	
	protected function init() {
	}
	
	function handle() {
		if ($_POST) {
			$this->post = $_POST;
			$this->post();
		}
		if ($_GET) {
			$this->get = $_GET;
			$this->get();
		}
	}
	
	protected function get() {
		return ;
	}
	
	protected function post(){
		return;
	}
	
	function back() {
		return $this->back;
	}
}