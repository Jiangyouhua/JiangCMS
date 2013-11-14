<?php
class DbUpdate extends Db {

	protected $data; //表的数据
	protected $where; //表的操作条件

	function setSet($data){
		if(is_array($data)){
			if(is_int(key($data))){
				$this->data=implode(",", $data);
			}else{
				$arr=null;
				foreach ($data as $key => $value){
					$arr[]="`$key`='$value'";
				}
			}
			$this->data=implode(",", $arr);
		}else{
			$this->data=$data;
		}
	}

	function setWhere($where){
		$this->where=$where;
	}

	protected function format(){
		return "UPDATE $this->table SET $this->data WHERE $this->where";
	}
}
?>
