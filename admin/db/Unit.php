<?php
class Admin_Db_Unit{
	static function getAll() {
		$where="layout != 0";
		return self::select ( $where );
	}
	static function getMenu(){
		$where="layout != 0 AND part IN ('Navbar','Menu')";
		return self::select ( $where );
	}
	static function getUnit(){
		$where="layout != 0 AND part NOT IN ('Navbar','Menu')";
		return self::select ( $where );
	}
	static function getByLayout($layout) {
		$where = "layout != 0 AND layout=$layout";
		return self::select ( $where );
	}
	static function getByPart($part) {
		$where = "layout != 0 AND part=$part";
		return self::select ( $where );
	}
	static function getIt($id) {
		$where = "id=$id";
		return self::select ( $where );
	}
	static protected function select($where=null) {
		$db=new DbSelect ( 'unit' );
		$order="part DESC";
		$db->setOrder($order);
		$db->setWhere ( $where );
		return $db->fetchAll ();
	}
}