<?php
class Admin_Model_View extends Model {
	protected $page;
	protected function init() {
		
	}
	function modify() {
		$array=array_diff_key($this->data,$this->jcms);
		$this->back=Web::setLayout($array);
	}
	
	function delete() {
		$this->back=Web::delLayout($this->data['id']);
	}
}