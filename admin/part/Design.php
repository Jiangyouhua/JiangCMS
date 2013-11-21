<?php
class Admin_Part_Design extends Part{
	
	protected function init(){
		$this->style='page';
	}
	
	protected function getHtml(){
		
		$tabs=array("page","layout","unit");
		$planes=array();
		$planes[]=$this->forPage();
		$planes[]=$this->forLayout();
		$planes[]=$this->forUnit();
		
		$tab=new Part_Tab();
		$tab->setTab($tabs);
		$tab->setArray($planes);
		$this->html->add($tab);
	}
	
	protected function forPage(){
		$page=new Admin_Part_Page();
		return $page->format();
	}
	
	protected function forLayout(){
		$layout=new Admin_Part_Layout();
		return $layout->format();
	}
	
	protected function forUnit(){
		
	}
	
}