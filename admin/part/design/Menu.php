<?php
class Admin_Part_Design_Menu extends Admin_Part_Plane {
	protected function left() {
		$span = new Html ( 'span' );
		$form [] = new Form ( 'name','input');
		$form[]=$this->associate();
		$form[]=$this->itemOption();
		$form [] = new Form ( 'href','input');
		$form [] = Admin_Db_Role::formSelect();
		$form[]=$this->status();
		
		$part = new Part_Form ();
		$part->setKey('menu');
		$part->setTitle('Item');
		$part->setModel('menu');
		$part->setFunction('modify');
		$part->setArray ( $form );
		return $part;
	}
	
	protected function right() {
		$span = new Html ( 'span' );
		$re = Admin_Db_Classification::getAll ();
		
		$list = new Part_List ();
		$list->setKey('menu');
		$list->setTitle ( 'Menu' );
		$list->setModel('menu');
		$list->setFunction('delete');
		$list->setPrefix ();
		$list->setEdit(0,1,1);
		$list->setColumn(array('name','level','status'));
		$list->setArray ( $re );
		$span->add ( $list );
		return $list;
	}
	
	protected function associate() {
		$form=null;
		$re = Admin_Db_Classification::getAll ();
		$select = new Form ( 'associate','select');
		$select->setRoot();
		if ($re) {
			$select->setArray ( $re ,'level');
		}
		return $select;
	}
	
	protected function itemOption(){
		$select=new Form('option', 'select');
		$select->setArray(array('sub','before','after'));
		return $select;
	}
	
	protected function status(){
		$select = new Form ( 'status','select');
		$select->setArray(array('No','Yes'));
		return $select;
	}
}