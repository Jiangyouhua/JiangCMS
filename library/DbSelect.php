<?php
class DbSelect extends Db {
	protected $select; // 表的操作条件
	protected $join; // select操作列的内容
	protected $on; // select操作join的内容
	protected $where; // select操作order的内容
	protected $order; // select操作limit的内容
	protected $limit;
	function setSelect($column) {
		if (is_array ( $column )) {
			$this->select = implode ( ",", $column );
		} else {
			$this->select = $column;
		}
	}
	function setJoin($table, $type = 'LEFT') {
		$this->prefix = null;
		if (! empty ( Admin_Config_Sql::$prefix )) {
			$this->prefix = Admin_Config_Sql::$prefix . "_";
		}
		$this->join ['table'] [] = "`$this->prefix$table`";
		$this->join ['type'] [] = $type;
	}
	function setOn($on) {
		$this->on [] = $on;
	}
	function setWhere($where) {
		$this->where = $where;
	}
	function setOrder($order) {
		$this->order = $order;
	}
	function setLimit($limit) {
		$this->limit = $limit;
	}
	function getQuery() {
		if (! $this->query) {
			$this->run ();
		}
		return $this->query;
	}
	protected function format() {
		$select = empty ( $this->select ) ? "SELECT *" : "SELECT $this->select";
		$join = null;
		if (! empty ( $this->join )) {
			$count = count ( $this->join );
			for($i = 0; $i < $count; $i ++) {
				$join .= "{$this->join['type'][$i]} JOIN {$this->join['table'][$i]}";
				if (! empty ( $this->on )) {
					$join .= " ON {$this->on[$i]} ";
				}
			}
		}
		$where = empty ( $this->where ) ? null : "WHERE $this->where";
		$order = empty ( $this->order ) ? null : "ORDER BY $this->order";
		$limit = empty ( $this->limit ) ? null : "LIMIT $this->limit";
		return trim ( "$select FROM $this->table $join $where $order $limit" );
	}
	function fetchAll() {
		$query = null;
		if ($this->query) {
			$query = end ( $this->query );
		} else {
			$query= $this->run ();
		}
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	function fetch() {
		$query = null;
		if ($this->query) {
			$query = end ( $this->query );
		} else {
			$query= $this->run ();
		}
		return $query->fetch ( PDO::FETCH_ASSOC );
	}
	function rowConut() {
		$query = null;
		if ($this->query) {
			$query = end ( $this->query );
		} else {
			$query= $this->run ();
		}
		return $query->rowCount ();
	}
}
?>
