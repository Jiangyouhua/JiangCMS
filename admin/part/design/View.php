<?php
class Admin_Part_Design_View extends Admin_Part_Plane{
	
	protected function init(){
		$this->style='layout';
	}
	
	protected function left(){
		$array=null;
		
		$array[]=new Form('name','input');
		
		/*multi lauguage*/
		$dir=new PcDir(DIR."/lauguage");
		$lang=$dir->getFolder();
		$form=new Form('lang','select');
		$form->setArray($lang,'name');
		$array[]=$form;
		
		/*multi template*/
		$dir=new PcDir(DIR."/ui");
		$ui=$dir->getFolder();
		$form=new Form('ui','select');
		$form->setArray($ui,'name');
		$array[]=$form;
		
		/*widht*/
		$array[]=new Form('width','input');
		
		$form=new Part_Form();
		$form->setKey('view');
		$form->setTitle('Form');
		$form->setFunction('modify');
		$form->setModel('view');
		$form->setArray($array);
		
		$span=new Html('span');
		$span->class='span_left';
		$span->add($form);
		
		return $span;
	}
	
	protected function right(){
		$re=Admin_Db_Layout::getAll();
		
		$span=new Html('span');
		$list=new Part_List();
		$list->setKey('view');
		$list->setEdit($open=false);
		$list->setFunction('delete');
		$list->setTitle('Pages');
		$list->setModel('view');
		$list->setArray($re);
		$span->class='span_right';
		$span->add($list);
		return $span;
	}
}