<?php
class Admin_Part_Design extends Part {
	protected function init() {
		$this->style = 'view';
	}
	protected function getHtml() {
		
		$tabs =  array (
				'view',
				'menu',
				'unit',
				'show',
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
		$page = new Admin_Part_view ();
		return $page->format ();
	}
	protected function layout() {
		$view = new Admin_Part_layout ();
		return $view->format ();
	}
	protected function menu() {
		$page = new Admin_Part_Menu ();
		return $page->format ();
	}
	protected function unit() {
		$view = new Admin_Part_Unit ();
		return $view->format ();
	}
	protected function show() {
		$show = new Admin_Part_Show ();
		return $show->format ();
	}
	
}