<?php
class Admin_Model_Config extends Model {
	
	function handle(){		
		$name="Admin_Config_".$this->data['jcms_title'];
		$file = DIR."/admin/config/".$this->data['jcms_title'].".php";
		$str [] = "<?php";
		$str [] = "class $name{";
		foreach ( $this->array as $key => $value ) {
			$v=htmlspecialchars($value);
			$str [] = "	public static $$key='$v';";
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