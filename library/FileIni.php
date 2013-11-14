<?php
class FileIni{
	protected $file;
	function __construct($file){
		$this->file=$file;
	}

	function read($multi=false){
		if(file_exists($this->file)){
			return parse_ini_file($this->file,$multi);
		}else{
			return null;
		}
	}
	
	function write(array $array) {
		$str=array();
		foreach ($array as $key=>$value) {
			if(is_array($value)){
				$str[] = "[$key]";
				foreach ($value as $k => $v){
					$str[]="$k='$v'";
				}
			}else{
				$str[]="$key='$value'";
			}
		}
	
		if (!$handle = fopen($this->file, 'w')) {
			return false;
		}
		if (!fwrite($handle, implode("\n", $str))) {
			return false;
		}
		fclose($handle);
		return true;
	}
}