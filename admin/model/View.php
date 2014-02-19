<?php
class Admin_Model_View extends Model {
	protected $page;
	protected $design;
	protected function init() {
		$this->design = new Design ();
	}
	function modify() {
		/*缺省加载页面*/
		if ($this->data ['id'] == 1) {
			$this->data ['name'] = 'index';
		}
		/*检查非空*/
		if (Check::Is ( $this->data, array (
				'name' 
		) )) {
			$this->back = false;
			return;
		}
		/*检查重复命名*/
		$re = Admin_Db_Layout::getByName ( $this->data ['name'] );
		if ($re) {
			$this->back = false;
			return;
		}
		
		if (empty ( $this->array ['id'] )) {
			$this->back = $this->design->newLayout ( $this->array );
			if ($this->back) {
				$this->back = Admin_Db_Layout::insert ( $this->array );
			}
			return;
		}
		$this->back = $this->design->upHead ( $this->array );
		if ($this->back) {
			$this->back = Admin_Db_Layout::update ( $this->array );
		}
	}
	function delete() {
		$this->back = $this->design->delLayout ( $this->data ['id'] );
		if ($this->back) {
			$this->back = Admin_Db_Layout::delById ( $this->data ['id'] );
		}
	}
}