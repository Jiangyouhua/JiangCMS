<?php
class Admin_Part_Show extends Part {
	protected function getHtml() {
		
		$form = null;
		$re = Admin_Db_Unit::getAll ();
		$select = new Form ( 'select', 'unit', 0, 'unit' );
		if ($re) {
			$select->setArray($re);
		}
		$form[]=$select;
		
		$re=Admin_Db_Classification::getAll();
		$checkbox=new Form('input','menu','checkbox','menu');
		$checkbox->setArray($re);
		$form[]=$checkbox;
		
		$part=new Part_Form();
		$part->setTitle('show');
		$part->setArray($form);
		$this->html->add($part);
		
	}
}