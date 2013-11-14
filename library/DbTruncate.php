<?php
class DbTruncate extends Db {

	protected function forStatement(){
		return "TRUNCATE TABLE $this->name";
	}
}
?>
