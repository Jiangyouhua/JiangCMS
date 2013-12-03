<?php
class Admin_Part_Classify extends Admin_Part_Plane{
	protected function left(){
		$re=Admin_Db_Unit::get();
		$forms=null;
		$forms[]=new Form('input','name','text');
		$
		$list=new Part_List();
		$list->setEdit(0,1,0);
		$list->setColumn(array('name','part'));
		$list->setArray($re);
		$list->setTitle('menu');
		return $list;
	}
	protected function right(){
		$span=new Html('span');
		$re=Admin_Db_Classification::get();
		
		$list=new Part_List();
		$list->setTitle('classification');
		$list->setPrefix();
		$list->reCheck(0);
		$list->setArray($re);
		$span->add($list);
		return $list;
	}
}