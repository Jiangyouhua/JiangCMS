<?php
abstract class Model {
	
	protected $back;
	protected $data;
	protected $jcms;
	protected $diff;
	
	function __construct() {
		$this->back = false;
		$this->init ();
		$this->jcms=array('jcms_model'=>true,'jcms_function'=>true,'jcms_title'=>true);
		$this->diff=array('jcms_model'=>true,'jcms_function'=>true,'jcms_title'=>true,'id'=>true);
		if ($_POST) {
			$this->data = $_POST;
		}
		if ($_GET) {
			$this->data = $_GET;
		}
	}
	
	protected function init() {
	}
	
	function handle() {
	}
	
	function back() {
		return $this->back;
	}
}