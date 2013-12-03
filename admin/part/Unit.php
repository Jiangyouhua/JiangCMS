<?php
class Admin_Part_Unit extends Admin_Part_Plane {

	protected function left() {
		$span = new Html ( 'span' );
		
		$forms = null;
		$forms [] = $this->name ();
		$forms [] = $this->part ();
		$forms [] = $this->item ();
		$forms [] = $this->isurl ();
		$forms [] = $this->classification ();
		$forms [] = $this->content ();
		$forms [] = $this->href ();
		$forms [] = $this->classes ();
		$forms [] = $this->role ();
		
		$form = new Part_Form ();
		$form->setTitle ( Lang::to ( 'form' ) );
		$form->setAction ( 'handle.php' );
		$form->setArray ( $forms );
		$span->add ( $form );
		return $span;
	}
	protected function right() {
		$span=new Html('span');
		$re=Admin_Db_Unit::getUnit();
		$list=new Part_List();
		$list->setEdit(0,1,0);
		$list->setColumn(array('name','part','status'));
		$list->setArray($re);
		$list->setTitle('menu');
		return $list;
	}
	protected function part() {
		/* part */
		$dir = new PcDir ( DIR . "/part" );
		$array = $dir->getFile ( '.php' );
		$select = new Form('select','part',0,'part');
		$select->setArray($array);
		return $select;
	}
	protected function name() {
		$div=new Html();
		$form = new Form ( 'input', 'name', 'text' );
		$form->setLabel('name');
		$div->add($form);
		return $div;
	}
	protected function item() {
		$div=new Html();
		$form = new Form ( 'input', 'item', 'radio' );
		$form->setLabel('item');
		$form->setArray ( array (
				'No',
				'Yse',
				'Both' 
		) );
		$div->add($form);
		return $div;
	}
	protected function isurl() {
		$div=new Html();
		$form = new Form ( 'input', 'isurl', 'text' );
		$form->setLabel('isurl');
		$div->add($form);
		return $div;
	}
	protected function classification() {
		$div=new Html();
		$form = new Form ( 'select', 'classification' );
		$form->setLabel('classification');
		$array = Admin_Db_Classification::getAll();
		if ($array) {
			$form->setArray ( $array );
		}
		$div->add($form);
		return $div;
	}
	protected function content() {
		$div=new Html();
		$form = new Form ( 'select', 'content' );
		$form->setLabel('content');
		$form->multiple='multiple';
		$array = Admin_Db_Content::getAll();
		if ($array) {
			$form->setArray ( $array );
		}
		$div->add($form);
		return $div;
	}
	protected function href() {
		$div=new Html();
		$form = new Form ( 'input', 'href', 'text' );
		$form->setLabel('href');
		$div->add($form);
		return $div;
	}
	protected function classes() {
		$div=new Html();
		$form = new Form ( 'input', 'class', 'text' );
		$form->setLabel('class');
		$div->add($form);
		return $div;
	}
	protected function role() {
		$div=new Html();
		$form = new Form ( 'select', 'role' );
		$form->setLabel('role');
		$form->multiple='multiple';
		$db = new DbSelect ( 'role' );
		$db->setWhere ( 'id > 1' );
		$array = $db->fetchAll ();
		if ($array) {
			$form->setArray ( $array );
		}
		$div->add($form);
		return $div;
	}
}