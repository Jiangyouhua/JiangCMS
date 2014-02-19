<?php
class View {
	protected $layout;
	function setLayout($layout){
		$this->layout=$layout;
	}
	function randering() {
		$this->href ();
		if(!role::layout($this->layout)){
			return;
		}
		$this->html();
	}
	
	protected function href() {
		if (! Admin_Config_Admin::$linkhtml) {
			return;
		}
		$array = null;
		$string = $_SERVER ['QUERY_STRING'];
		$array = explode ( "/", $string );
		if(!$this->layout){
			$this->layout=array_shift ( $array );
		}
		$_GET ['layout'] = $this->layout;
		$_GET ['menu'] = array_shift ( $array );
		$_GET ['item'] = array_shift ( $array );
		$k = null;
		$v = null;
		foreach ( $array as $key => $value ) {
			if (! $key % 2) {
				$k = $value;
			} else {
				$v = $value;
			}
			$_GET [$k] = $v;
		}
	}
	protected function html(){
		
	}
	
}