<?php
/**
 * 1.实现数据库连接
 * 2.实现输入参数格式SQL
 * 3.实现数据库表操作
 * 4.实现多条SQL语句操作数据表
 * */
abstract class Db {
	protected $sql;
	protected $table;
	protected $query;
	protected $re;
	protected $id;
	protected $prefix;
	function __construct($table = null) {
		if ($table) {
			$this->setTable ( $table );
		}
	}
	static function table($table) {
		$prefix = null;
		if (! empty ( Admin_Config_Sql::$prefix )) {
			$prefix = Admin_Config_Sql::$prefix . "_";
		}
		return "`$prefix$table`";
	}
	function setTable($table) {
		$prefix = null;
		if (! empty ( Admin_Config_Sql::$prefix )) {
			$prefix = Admin_Config_Sql::$prefix . "_";
		}
		$this->table = "`$prefix$table`";
	}
	function getRe() {
		if (! $this->re) {
			$this->run ();
		}
		return $this->re;
	}
	function addSql($sql) {
		if (is_string ( $sql )) {
			$this->sql [] = $sql;
		}
	}
	function addDb($db) {
		if (is_a ( $db, "Db" )) {
			$this->sql [] = $db->format ();
		}
	}
	function exec() {
		return $this->run ();
	}
	protected function run($mode = null) {
		$re = null;
		$query = null;
		
		if ($this->table) {
			$this->sql [] = $this->format ();
		}
		
		if (! $this->sql) {
			return null;
		}
		
		try {
			$con = Connect::getInstance ();
			$con->beginTransaction ();
			foreach ( $this->sql as $sql ) {
				if (preg_match ( "/^SELECT |DESCRIBE |SHOW/", $sql )) {
					$re = $con->query ( $sql );
					$this->query [] = $re;
				} else {
					$re = $con->exec ( $sql );
					$this->re [] = $re;
					if (preg_match ( "/^INSERT/", $sql )) {
						$this->id = $con->lastInsertId ();
					}
				}
			}
			$con->commit ();
		} catch ( Exception $e ) {
			$con->rollBack ();
		}
		return $re;
	}
	abstract protected function format();
}
?>
