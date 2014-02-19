<?php
class Admin_Model_Layout extends Model {
	/*从页面读取组件*/
	function load() {
		$this->back = Design::getBody($this->data['id']);
	}
	/*将组件格式化为页面*/
	function save() {
		$this->back=Design::setBody($this->data['id'],$this->data['str']);
	}
}