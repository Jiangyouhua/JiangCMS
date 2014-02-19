<?php
class Admin_Db_User extends DbMode {
	protected static $table = 'user';
	protected static $where = 'metadata<2';
	protected static $order = 'belong';
	static function getBelong($belong) {
		$where = "metadata<2 AND belong = $belong";
		$order = 'belong';
		return self::select ( $where, 0, 0, $order );
	}
	static function login($name, $password) {
		$where = "name='$name' AND password='$password' AND status=1";
		$order = 'belong';
		return self::select ( $where, 0, 0, $order );
	}
}