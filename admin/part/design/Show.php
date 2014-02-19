<?php
class Admin_Part_Design_Show extends Part {
	protected function getHtml() {
		
		$form = null;
		$re = Admin_Db_Unit::getAll ();
		$select = new Form ( 'unit','select');
		if ($re) {
			$select->setArray($re);
		}
		$form[]=$select;
		
		$re=Admin_Db_Classification::getAll();
		$checkbox=new Form('menu','input','checkbox');
		$checkbox->setArray($re);
		$form[]=$checkbox;
		
		$part=new Part_Form();
		$part->setTitle('show');
		$part->setArray($form);
		$this->html->add($part);
		
	}
}