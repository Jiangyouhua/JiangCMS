<?php
class Admin_Db_Content {
	static function getAll() {
		return self::select (  );
	}
	static function getOther() {
		$where = "classification='0'";
		return self::select ( $where );
	}
	static function getByClass($id) {
		$where = "FIND_IN_SET('$id',classification)";
		return self::select ( $where );
	}
	static function getIt($id) {
		$where = "id=$id";
		return self::select ( $where );
	}
	static protected function select($where=null) {
		$db = new DbSelect ( 'content' );
		$db->setWhere ( $where );
		return $db->fetchAll ();
	}
}