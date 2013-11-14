<?php
class Factory{
	static function getInstance(){
		$class=func_get_arg(0);
		$a=func_get_args();
		array_shift($a);
		$a0=empty($a[0])?null:$a[0];
		$a1=empty($a[1])?null:$a[1];
		$a2=empty($a[2])?null:$a[2];
		$a3=empty($a[3])?null:$a[3];
		$a4=empty($a[4])?null:$a[4];
		$a5=empty($a[5])?null:$a[5];
		$a6=empty($a[6])?null:$a[6];
		$a7=empty($a[7])?null:$a[7];
		$a8=empty($a[8])?null:$a[8];
		$a9=empty($a[9])?null:$a[9];
		$name="library/$class";
		if(stripos($class, '_')){
			$name=str_replace("_", "/", $class);
		}
		$name=DIR."/$name.php";
		if(!file_exists($name)){
			return null;
		}
		return new $class($a0,$a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$a9);
	}
}
?>