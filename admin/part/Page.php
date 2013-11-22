<?php
class Admin_Part_Page extends Part{
	
	protected function init(){
		$this->style='page';
	}
	
	protected function getHtml(){
		$form=$this->form();
		$this->html->add($form);
		$list=$this->lists();
		$this->html->add($list);
	}
	
	protected function form(){
		$array=null;
		
		$form=new Form();
		$form->setElemenu('input');
		$form->setLable('name');
		$form->setName('name');
		$array[]=$form;
		
		/*multi lauguage*/
		$form=new Form();
		$form->setElemenu('select');
		$form->setLable('lang');
		$form->setName('lang');
		$dir=new PcDir(DIR."/lauguage");
		$lang=$dir->getFolder();
		$form->setOption($lang,1);
		$array[]=$form;
		
		/*multi template*/
		$form=new Form();
		$form->setElemenu('select');
		$form->setLable('ui');
		$form->setName('ui');
		$dir=new PcDir(DIR."/ui");
		$ui=$dir->getFolder();
		$form->setOption($ui);
		$array[]=$form;
		
		$form=new Part_Form();
		$form->setTitle('Form');
		$form->setModel('page');
		$form->setArray($array);
		
		$span=new Html('span');
		$span->class='span_left';
		$span->add($form);
		
		return $span;
	}
	
	protected function lists(){
		$dir=new PcDir(DIR);
		$pages=$dir->getFile('.php',array('Autoload.php'));
		
		$span=new Html('span');
		$list=new Part_List();
		$list->setEdit($open=false);
		$list->setTitle('Pages');
		$list->setModel('page');
		$list->setArray($pages);
		$span->class='span_right';
		$span->add($list);
		return $span;
	}
}