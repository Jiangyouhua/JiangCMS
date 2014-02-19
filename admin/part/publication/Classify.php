<?php
class Admin_Part_Publication_Classify extends Admin_Part_Plane{
	protected function left(){
		$re=Admin_Db_Classification::getAll();
	
		$list=new Part_List();
		$list->setTitle('menu');
		$list->setPrefix();
		$list->reCheck(0);
		$list->setArray($re);
		return $list;
	}
	protected function right(){
		$re=Admin_Db_Content::getOther();
		$forms=null;
		$forms[]=new Form('name','input');
		$list=new Part_List();
		$list->setEdit(0,1,0);
		$list->setColumn(array('name','part'));
		$list->setArray($re);
		$list->setTitle('content');
		return $list;
	}
	
}