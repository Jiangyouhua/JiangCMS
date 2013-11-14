<?php

if(!isset($_SESSION)){
	session_start();
}

defined("DIR") || define("DIR",__DIR__);

class Load{
	public static function autoload($className){
		$str=stripos($className,"_")?str_ireplace("_", "/", $className):"library/".$className;
		$path=__DIR__."/".$str.".php";
		if(file_exists($path)){
			return include($path);
		}else{
			return false;
		}
	}
}

spl_autoload_register(array('Load','autoLoad'));
?>