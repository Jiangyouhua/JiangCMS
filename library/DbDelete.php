<?php

class DbDelete extends Db {

	protected $where; //表的操作条件
	protected $join; //select操作列的内容
	protected $on; //select操作join的内容

	//$where string 条件(含？问号通配符，插入后面$value值)，$value string、int、array,
	function setWhere($where){
		$this->where=$where;
	}
	
	function setJoin($table){
		$this->join[]=$table;
	}
	
	function setOn($on){
		$this->on[]=$on;
	}
	
	protected function format(){
		$table=null;
		$join=null;
		if(!empty($this->join)){
			$table=$this->table;
			$count=count($this->join);
			for($i=0;$i<$count;$i++){
				$join.="JOIN `{$this->join[$i]}`";
				$table.=",`{$this->join[$i]}`";
				if(!empty($this->on)){
					$join.=" ON {$this->on[$i]} ";
				}
			}
		}
		return "DELETE $table FROM $this->table $join WHERE $this->where";
	}
}
?>
