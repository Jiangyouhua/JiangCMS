<?php
class Admin_Part_View extends Admin_Part_Plane{
	
	protected function init(){
		$this->style='layout';
	}
	
	protected function left(){
		$array=null;
		
		$form=new Form('input','name','text');
		$form->setLabel('name');
		$array[]=$form;
		
		/*multi lauguage*/
		$dir=new PcDir(DIR."/lauguage");
		$lang=$dir->getFolder();
		$form=new Form('select','lang');
		$form->setLabel('lang');
		$form->setArray($lang);
		$array[]=$form;
		
		/*multi template*/
		$dir=new PcDir(DIR."/ui");
		$ui=$dir->getFolder();
		$form=new Form('select','ui');
		$form->setLabel('ui');
		$form->setArray($ui);
		$array[]=$form;
		
		/*widht*/
		$form=new Form('input','width');
		$form->setLabel('width');
		$array[]=$form;
		
		$form=new Part_Form();
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
		$re=Web::getLayout();
		
		$span=new Html('span');
		$list=new Part_List();
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