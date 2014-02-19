<?php
class Admin_Part_Access_Role extends Admin_Part_Plane {
	protected function left() {
		$span = new Html ( 'span' );
		$form [] = new Form ( 'name', 'input');
		$form[]=$this->select();
		$form [] = new Form (  'status', 'input','radio');
		
		$part = new Part_Form ();
		$part->setTitle('Item');
		$part->setArray ( $form );
		return $part;
	}
	protected function right() {
		$span = new Html ( 'span' );
		$re = Admin_Db_Role::getAll ();
		
		$list = new Part_List ();
		$list->setTitle ( 'Role' );
		$list->setPrefix ();
		$list->setEdit(0,1,1);
		$list->setColumn(array('name','level','status'));
		$list->setArray ( $re );
		$span->add ( $list );
		return $list;
	}
	protected function select() {
		$re = Admin_Db_Role::getAll ();
		$select = new Form ( 'item','select');
		$select->setRoot();
		if ($re) {
			$select->setArray ( $re );
		}
		return $select;
	}
}