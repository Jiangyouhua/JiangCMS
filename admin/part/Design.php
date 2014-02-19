<?php
class Admin_Part_Design extends Part {
	protected function init() {
		$this->style = 'view';
	}
	protected function getHtml() {
		
		$tabs =  array (
				'menu',
				'item',
				'unit',
				'binding',
				'view',
				'layout'
		);
		$layoutes = array ();
		foreach ($tabs as $value){
			$layoutes [] = $this->$value ();
		}
		
		$tab = new Part_Tab ();
		$tab->setTab ( $tabs );
		$tab->setArray ( $layoutes );
		$this->html->add ( $tab );
	}
	protected function view() {
		$page = new Admin_Part_Design_view ();
		return $page->format ();
	}
	protected function layout() {
		$view = new Admin_Part_Design_layout ();
		return $view->format ();
	}
	protected function menu() {
		$page = new Admin_Part_Design_Menu ();
		return $page->format ();
	}
	protected function item() {
		$page = new Admin_Part_Design_Menu ();
		return $page->format ();
	}
	protected function unit() {
		$view = new Admin_Part_Design_Unit ();
		return $view->format ();
	}
	protected function binding() {
		$show = new Admin_Part_Design_Show ();
		return $show->format ();
	}
	
}