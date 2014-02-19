<?php
class DbSelect extends Db {
	protected $select; // 表的操作条件
	protected $join; // select操作列的内容
	protected $on; // select操作join的内容
	protected $where; // select操作order的内容
	protected $order; // select操作limit的内容
	protected $limit;
	
	/*查询的列*/
function setSelect($column) {
		if (is_array ( $column )) {
			/*多表查询时，按表分组*/
			$array=null;
			foreach ($column as $key=>$value){
				if(is_int($key)){
					$array=$column;
					break ;
				}
				$var=array();
				if(is_string($value)){
					$var=explode(',', $value);
				}else{
					$var=$value;
				}
				if(is_array($value)){
					$array[]="$this->prefix$key.".implode(",$this->prefix$key.", $value);
				}
			}
			$this->select = implode(',', $array) ;
		} else {
			$this->select = $column;
		}
	}
	/*联接查询*/
	function setJoin($table, $on, $type = 'LEFT') {
		$this->prefix = null;
		if (! empty ( Admin_Config_Sql::$prefix )) {
			$this->prefix = Admin_Config_Sql::$prefix . "_";
		}
		$join ['table'] = "`$this->prefix$table`";
		$join ['on']=$on;
		$join ['type'] = $type;
		$this->join[]=$join;
	}
	/*条件*/
	function setWhere($where) {
		$this->where = $where;
	}
	/*排序*/
	function setOrder($order) {
		$this->order = $order;
	}
	/*分段*/
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
			foreach ($this->join as $value) {
				$join .= " {$value['type']} JOIN {$value['table']} ON {$value['on']} ";
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
