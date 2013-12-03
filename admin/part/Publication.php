<?php
class Admin_Part_Publication extends Part {
	protected function init() {
		$this->style = 'publication';
	}
	protected function getHtml() {
		
		$tabs =  array (
				'classify',
				'content',
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
	protected function classify() {
		$page = new Admin_Part_Classify ();
		return $page->format ();
	}
	protected function content() {
		$view = new Admin_Part_content ();
		return $view->format ();
	}	
}