<?php
class Role{
	static function layout(){
		$role=0;
		if(PAGE=='admin/admin'){
			$role=3;
		}
		if(PAGE=='admin/index'){
			$role=0;
		}
		$re=Admin_Db_Layout::getByName(PAGE);
		$role=$re['role'];
		return self::check($role);
		
	}
	static function unit($role){
		return  self::check($role);
	}
	static protected function check($role){
		$array=explode(',', $role);
		foreach ($array as $value){
				if(in_array($value,$_SESSION['role'])){
					return true;
				}
		}
		return false;
	}
}