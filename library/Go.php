<?php
class Go {
	static $layout;
	static function to($name, $partname) {
		$self = $_SERVER ['PHP_SELF'];
		if (! self::$layout) {
			$url = explode ( "/", strtolower ( $self ) );
			$dir = explode ( '\\', strtolower ( DIR ) );
			$layout = implode ( '/', array_diff ( $url, $dir, array (
					null 
			) ) );
			/* 后台页面处理 */
			if ($layout == 'admin/index.php') {
				self::$layout = 0;
			} else {
				$arr = explode ( '.', $layout );
				$re = Web::getLayout ( $arr [0] );
				self::$layout = $re ['id'];
			}
		}
		
		$data = new Data ( $name, $partname, self::$layout );
		$array = $data->get ( 1, 1 );
		$unit = $data->getUnit ( 1, 1 );
		
		if ($unit) {
			if (! stripos ( $partname, "_" )) {
				$partname = "Part_$partname";
			}
			$part = Factory::getInstance ( $partname );
			if ($part) {
				$part->setUnit ( $unit [0] );
				if ($array) {
					$part->setArray ( $array [0] );
				}
				echo $part->format ();
			}
		}
	}
}