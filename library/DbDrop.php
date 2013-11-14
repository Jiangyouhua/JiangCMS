<?php
class DbDrop extends Db {

	function format(){
		$this->sql[]="DROP TABLE $this->table";
	}
}
?>
