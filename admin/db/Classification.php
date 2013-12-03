<?php
class Admin_Db_Classification {
	static protected $metadata="metadata<2";
	static function getAll() {
		$where = self::$metadata;
		return self::select ( $where );
	}
	static function getTop() {
		$where = self::$metadata.' AND item=0';
		return self::select ( $where );
	}
	static function getSub($id) {
		$where = self::$metadata." AND item=$id";
		return self::select ( $where );
	}
	static function getIt($id) {
		$where = "id=$id";
		return self::select ( $where );
	}
	static function getMenu($id) {
		$re = self::getIt ( $id );
		if (! $re) {
			return null;
		}
		$where="item=$id";
		if ($item = $re ['item']) {
			$level = $re ['level'] . '%';
			$where = "item=$item AND level LIKE '$level'";
		}
		return self::select($where);
	}
	static protected function select($where = null) {
		$db = new DbSelect ( 'classification' );
		$order = 'item,level';
		$db->setWhere ( $where );
		$db->setOrder ( $order );
		return $db->fetchAll ();
	}
}