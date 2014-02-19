<?php
class DbMode {
	protected static $table = null;
	/* 增 */
	static function insert($data) {
		$db = new DbInsert ( static::$table );
		$db->setData ( $data );
		$db->exec ();
		return $db->lastId ();
	}
	
	/* 删 */
	static function delById($id) {
		$where = "id=$id";
		return self::delete ( $where );
	}
	static function delByName($name, $where = 1) {
		$where = "name='$name' AND $where";
		return self::delete ( $where );
	}
	protected static function delete($where) {
		$db = new DbDelete ( static::$table );
		$db->setWhere ( $where );
		return $db->exec ();
	}
	
	/* 改 */
	static function update($data, $where = null) {
		$db = new DbUpdate ( static::$table );
		if ($where) {
			$db->setWhere ( $where );
		} else {
			if (! empty ( $data ['id'] )) {
				$db->setWhere ( "id={$data['id']}" );
			}
		}
		$db->setSet ( $data );
		return $db->exec ();
	}
	static function replace($row, $old, $new) {
		$data = "$row = REPLACE ($row,'$old','$new)";
		return static::update ( $data );
	}
	
	/* 查 */
	static function getAll() {
		return self::select ();
	}
	static function getById($id) {
		$where = "id=$id";
		return self::select ( $where, 1 );
	}
	static function getByName($name, $where = 1) {
		$where = "name='$name' AND $where";
		return self::select ( $where, 1 );
	}
	static function nameById($id = null) {
		if (! $id) {
			return;
		}
		$re = self::getById ( $id );
		if (! $re) {
			return null;
		}
		return $re ['name'];
	}
	static protected function select($where = 1, $a = 0, $column = null, $order = null, $limit = null, $join = null, $on = null) {
		if (! static::$table) {
			return;
		}
		$db = new DbSelect ( static::$table );
		if ($column) {
			$db->setSelect ( $column );
		}
		if ($where)
			$db->setWhere ( $where );
		if ($join && $on) {
			$db->setJoin ( $join, $on );
		}
		if ($order) {
			$db->setOrder ( $order );
		}
		if ($limit) {
			$db->setLimit ( $limit );
		}
		if ($a) {
			return $db->fetch ();
		}
		return $db->fetchAll ();
	}
}