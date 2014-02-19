<?php
class Check {
	static function Is($array, $rows) {
		$arr = null;
		foreach ( $array as $key => $value ) {
			if(!in_array($key,$rows)){
				continue;
			}
			if(!$value){
				return false;
			}
			$re = null;
			switch ($key) {
				case 'name' :
				case 'password' :
					$re = self::length ( $value, 4, 255 );
					break;
				case 'captcha' :
					$re = self::length ( $value, 4, 8 );
					$re = self::letter ( $value, $re );
					break;
				default :
					$re = true;
					break;
			}
			if (! $re) {
				return false;
			}
			$arr [$key] = htmlspecialchars ( $value );
		}
		return $arr;
	}
	
	/* 长度 */
	static protected function length($value, $start, $end) {
		$len = strlen ( $value );
		if ($len < $start || $len > $end) {
			return false;
		}
		return true;
	}
	
	/* 字母 */
	static protected function letter($value, $re) {
		if (! $re) {
			return false;
		}
		return preg_match ( "/\w/", $value );
	}
	
	/* 邮箱 */
	static protected function mail($value, $re) {
		if (! $re) {
			return false;
		}
		return preg_match ( "/[-.\w]*@\w+(\.[a-z]{2,4})+/i", $value );
	}
}