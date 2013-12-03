<?php
class Admin_Model_Config extends Model {
	
	function handle(){		
		$name="Admin_Config_".$this->post['jcms_title'];
		$file = DIR."/admin/config/".$this->post['jcms_title'].".php";
		$str [] = "<?php";
		$str [] = "class $name{";
		$array=array_diff_key($this->data, $this->diff);
		foreach ( $array as $key => $value ) {
			$str [] = "	public static $$key='$value';";
		}
		$str [] = "}";
		
		if (! $handle = fopen ( $file, 'w' )) {
			return false;
		}
		
		if (! fwrite ( $handle, implode ( "\n", $str ) )) {
			return false;
		}
		fclose ( $handle );
		$this->back=true;
	}
}