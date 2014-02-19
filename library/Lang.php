<?php
class Lang {
	protected static $default;
	protected static $array;
	static function to($key = null, $name = null) {
		$lang = null;
		
		/* 加载默认 */
		if (! self::$default) {
			self::getDefault ();
		}
		
		/* 如果未指定加载文件名 */
		if (! $name) {
			$lang = self::$default;
			self::re ( $lang, $key );
		}
		
		/* 加载指定 */
		if (empty ( self::$array [$name] )) {
			self::getByName ( $name );
		}
		
		if (empty(self::$default)) {
			$lang = self::$array [$name];
			return self::re ( $lang, $key );
		}
		if (empty( self::$array [$name])) {
			$lang = self::$default;
			return self::re ( $lang, $key );
		}
		
		$lang = array_merge ( self::$default, self::$array ['$name'] );
		return self::re ( $lang, $key );
	}
	protected static function getDefault() {
		$file = DIR . "\\lauguage\\" . LANG . "\\default.ini";
		$ini = new FileIni ( $file );
		self::$default = $ini->read ();
	}
	protected static function getByName($name) {
		$file = DIR . "\\lauguage\\" . LANG . "\\$name.ini";
		$ini = new FileIni ( $file );
		self::$array [$name] = $ini->read ();
	}
	protected static function re($lang, $key = null) {
		if (! $key) {
			return $lang;
		}
		if (empty ( $lang [$key] )) {
			return $key;
		}
		return $lang [$key];
	}
}