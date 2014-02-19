<?php
class Admin_Part_Access_User extends Admin_Part_Plane {
	protected function left() {
		$form [] = new Form ( 'name', 'input' );
		$form [] = new Form ( 'password', 'input', 'password' );
		$form [] = new Form ( 'password1', 'input', 'password' );
		$form [] = new Form ( 'email', 'input' );
		$form [] = Admin_Db_Role::formSelect ( 'all', 'belong', 'belong' );
		$form [] = Admin_Db_Role::formSelect ();
		$form [] = new Form ( 'status','input',  'radio' );
		$part = new Part_Form ();
		$part->setTitle ( 'user' );
		$part->setArray ( $form );
		return $part;
	}
	protected function right() {
		$re = Admin_Db_User::getAll ();
		$part = new Part_List ();
		$part->setTitle ( 'user' );
		if ($re) {
			$part->setArray ( $re );
		}
		$part->setEdit ( 0, 1, 1 );
		return $part;
	}
}