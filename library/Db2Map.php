<?php
class Db2Map{

	private static $map;

	private function __construct(){
	}
	public static function getMap($table,$refresh=false,$key="id",$value="name",$where=null){
		if($refresh || empty(self::$map[$table])){
			$array=null;
			$db=new Select($table);
			if($where){
				$where="status=1 AND $where";
			}else{
				$where="status=1";
			}
			$db->setWhere($where);
			$re=$db->fetchAll();
			foreach ($re as $v){
				$k1=$v[$key];
				$v1=$v[$value];
				$array[$k1]=$v1;
			}
			self::$map[$table]=$array;
		}
		return self::$map[$table];
	}
}