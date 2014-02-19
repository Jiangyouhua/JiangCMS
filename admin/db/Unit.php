<?php
class Admin_Db_Unit extends DbMode {
	static protected  $table = 'unit';
	static function getByPart($part) {
		$where = "part='$part'";
		return self::select ( $where );
	}
	static function getMenu(){
		$where="part IN ('Navbar','Menu')";
		return self::select ( $where );
	}
	static function getUnit(){
		$where="part NOT IN ('Navbar','Menu')";
		return self::select ( $where );
	}	
}