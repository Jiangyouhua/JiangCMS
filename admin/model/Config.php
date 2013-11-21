<?php
class Admin_Model_Config extends Model {
	
	protected function post(){		
		$name="Admin_Config_".$this->post['jcms_name'];
		$file = DIR."/admin/config/".$this->post['jcms_name'].".php";
		$str [] = "<?php";
		$str [] = "class $name{";
		foreach ( $this->post as $key => $value ) {
			if (preg_match('/^jcms_/', $key)) {
				continue;
			}
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