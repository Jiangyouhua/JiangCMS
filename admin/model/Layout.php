<?php
class Admin_Model_Layout extends Model {
	/*从页面读取组件*/
	function load() {
		$this->back = Web::getBody($this->data['id']);
	}
	/*将组件格式化为页面*/
	function save() {
		$this->back=web::setPage($this->data['id'],$this->data['str']);
	}
}