<?php

class Lang {
	
	static protected $array;
	
	static function to($key,$name=null){
		if(!$name){
			$name="default";
		}
		
		$lang="cn_ZH";
		if(LANG){
			$lang=LANG;
		}
		
		if(empty(self::$array[$name])){
			$file=DIR."/lauguage/$lang/$name.ini";
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