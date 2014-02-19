<?php
class Go {
	static function to($name) {
		
		/*获取*/
		$re = Admin_Db_Unit::getByName($name);
		if (! $re) {
			return;
		}
		$name=self::part($re ['part']);
		$part = Factory::getInstance ( $name );
		if (! $part) {
			return;
		}
		$data = new Data ( $re );
		$array = $data->get ( 1, 1 );
		if (! $array) {
			return;
		}
		$part->setUnit ( $re );
		if (is_array($array)){
			$part->setArray ( $array );
		}
		echo $part->format ();
	}
	static protected function part($part){
		if(!stripos($part,'_')){
			return "Part_$part";
		}
		return $part;
	}
}