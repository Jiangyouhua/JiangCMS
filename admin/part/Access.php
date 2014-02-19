<?php
class Admin_Part_Access extends Part {
	protected function init() {
		$this->style = 'access';
	}
	protected function getHtml() {
		$tabs=array('user','role');
		$access = array ();
		foreach ($tabs as $value){
			$access [] = $this->$value ();
		}
		
		$tab = new Part_Tab ();
		$tab->setTab ( $tabs );
		$tab->setArray ( $access );
		$this->html->add ( $tab );
	}
	protected function user() {
		$user = new Admin_Part_Access_User ();
		return $user->format ();
	}
	protected function role() {
		$role = new Admin_Part_Access_Role ();
		return $role->format ();
	}
}