<?php
class Admin_Db_Content extends DbMode{
	static protected $table='content';
	static function getOther() {
		$where = "classification='0'";
		return self::select ( $where );
	}
	static function getByClass($id) {
		$where = "FIND_IN_SET('$id',classification)";
		return self::select ( $where );
	}
	static function formSelect($key = 'other') {
		$method = "get$key";
		$re = self::$method ();
		$form = new Form ( 'select', 'content', 0, 'content' );
		if ($re) {
			$form->setArray ( $re );
		}
		$form->multiple = 'multiple';
		return $form;
	}
}