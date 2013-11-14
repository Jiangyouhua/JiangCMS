<?php
class DbPrefix extends Db{
	static function setPrefix($prefix){
		if(!is_string($prefix)){
			return false;
		}
		if(preg_match("/^[A-Za-Z]+$/g", $prefix)){
			return false;
		}
		$db=new DbSelect();
		$db->addSql("show Tables");
		$re=$db->exec();
		foreach ($re as $value){
			$name=preg_replace("/^[A-Za-z]+_", $prefix, $value);
			$db->addSql("ALTER TABLE $value RENAME TO $name");
			$db->exec();
		}
	}
}