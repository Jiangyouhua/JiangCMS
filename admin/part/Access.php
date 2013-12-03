<?php
class Admin_Part_Menu extends Part {
	protected function init() {
		$this->style = 'access';
	}
	protected function getHtml() {
		$db = new DbSelect ( 'unit' );
		$db->setWhere ( "layout>0 AND part IN ('Navbar','Menu')" );
		$db->setOrder ( 'part DESC' );
		$re = $db->fetchAll ();
		
		$tab = new Part_Tab ();
		$tab->setTab ( $re );
		$array = $this->planes ( $re );
		if ($array) {
			$tab->setArray ( $array );
		}
		$this->html->add ( $tab );
	}
	protected function planes() {
		return null;
	}
	protected function forPage() {
		$page = new Admin_Part_Page ();
		return $page->format ();
	}
	protected function forLayout() {
		$layout = new Admin_Part_Layout ();
		return $layout->format ();
	}
}