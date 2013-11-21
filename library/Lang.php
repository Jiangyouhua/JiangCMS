<?php

class Lang {
	
	static protected $array;
	
	static function to($key,$name=null,$lang=null){
		if(!$name){
			$name="default";
		}
		
		$lan="cn_ZH";
		if(defined('LANG')){
			$lan=LANG;
		}
		if($lang){
			$lan=$lang;
		}
		
		if(empty(self::$array[$name])){
			$file=DIR."/lauguage/$lan/$name.ini";
			$ini=new FileIni($file);
			$arr=$ini->read();
			self::$array[$name]=$ini->read();
		}
		if(empty(self::$array[$name][$key])){
			return $key;
		}
		return self::$array[$name][$key];
	}
}