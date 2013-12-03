<?php
class Admin_Part_Menu extends Admin_Part_Plane {
	protected function left() {
		$span = new Html ( 'span' );
		$form [] = new Form ( 'input', 'name', 'text', 'name' );
		$form[]=$this->select();
		$form [] = new Form ( 'input', 'href', 'text', 'href' );
		$form [] = new Form ( 'input', 'status', 'radio', 'status' );
		$form [] = new Form ( 'role', 'role', 0, 'role' );
		
		$part = new Part_Form ();
		$part->setTitle('Item');
		$part->setArray ( $form );
		return $part;
	}
	protected function right() {
		$span = new Html ( 'span' );
		$re = Admin_Db_Classification::getAll ();
		
		$list = new Part_List ();
		$list->setTitle ( 'Menu' );
		$list->setPrefix ();
		$list->setEdit(0,1,1);
		$list->setColumn(array('name','level','status'));
		$list->setArray ( $re );
		$span->add ( $list );
		return $list;
	}
	protected function select() {
		$re = Admin_Db_Classification::getAll ();
		$select = new Form ( 'select', 'item', 0, 'item' );
		$select->setRoot();
		if ($re) {
			$select->setArray ( $re );
		}
		return $select;
	}
}