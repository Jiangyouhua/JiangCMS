<?php

class DbCreate extends Db {
	protected $column;
	function setColumn($column,$Parameter=null){
		$this->column[]="$column $Parameter";
	}
	function format(){
	
		if(!$this->column){
			return false;
		}
		$this->sql[]="CREATE TABLE $this->table(".implode(",", $this->column).")";
	}
}
?>
