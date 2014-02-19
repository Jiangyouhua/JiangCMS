<?php
/*自动加载类*/
class Load {
	public static function autoload($className) {
		$str = stripos ( $className, "_" ) ? str_ireplace ( "_", "/", $className ) : "library/" . $className;
		$path = DIR . "/" . $str . ".php";
		if (file_exists ( $path )) {
			return include ($path);
		} else {
			return false;
		}
	}
}

spl_autoload_register ( array (
		'Load',
		'autoLoad' 
) );
?>