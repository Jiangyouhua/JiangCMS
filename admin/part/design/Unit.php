<?php
class Admin_Part_Design_Unit extends Admin_Part_Plane {

	protected function left() {
		$span = new Html ( 'span' );
		
		$forms = null;
		$forms [] = new Form('name', 'input');
		$forms [] = $this->part ();
		$forms [] = $this->item ();
		$menu = new Form('ismenu', 'select');
		$menu->setArray(array('No','Yes'));
		$forms[]=$menu;
		$forms [] = $this->classification ();
		$forms [] = $this->content ();
		$forms [] = new Form('href', 'input');
		$forms [] = new Form('class', 'input');
		$forms [] = Admin_Db_Role::formSelect();
		
		$form = new Part_Form ();
		$form->setKey('unit');
		$form->setTitle ( $this->lang ( 'form' ) );
		$form->setAction ( 'handle.php' );
		$form->setArray ( $forms );
		$span->add ( $form );
		return $span;
	}
	protected function right() {
		$span=new Html('span');
		$re=Admin_Db_Unit::getUnit();
		$list=new Part_List();
		$list->setKey('unit');
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
		$select = new Form('part','select');
		$select->setArray($array);
		return $select;
	}
	protected function item() {
		$div=new Html();
		$form = new Form ( 'item','select');
		$form->setLabel('item');
		$form->setArray ( array (
				'No',
				'Yse',
				'Both' 
		) );
		$div->add($form);
		return $div;
	}
	protected function classification() {
		$div=new Html();
		$form = new Form ('classification' , 'select' );
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
		$form = new Form ('content' , 'select' );
		$form->setLabel('content');
		$form->multiple='multiple';
		$array = Admin_Db_Content::getAll();
		if ($array) {
			$form->setArray ( $array );
		}
		$div->add($form);
		return $div;
	}
}