<?php
class DbInsert extends Db {

	protected $column;
	protected $value;

	function setColumn($column){
		if(is_array($column)){
			$str=implode("`,`", $column);
			$this->column="(`$str`)";
		}else{
			$this->column="(`".str_ireplace(',','`,`',$column)."`)";
		}
	}

	function setValue($value){
		if(is_array($value)){
			if(is_array(current($value))){
				$arr=null;
				foreach ($value as $v){
					$str=implode("','", $v);
					$arr[]="('$str')";
				}
				$this->value=implode(",", $arr);
			}else{
				$str=implode("','", $value);
				$this->value="('$str')";
			}
		}else{
			$this->value="($value)";
		}
	}

	function setData(array $data){
		$column=array_keys($data);
		$this->setColumn($column);
		$this->setValue($data);
	}

	protected function format(){
		$value="VALUES $this->value";
		return "INSERT INTO $this->table $this->column $value";
	}
	
	function lastId(){
		return $this->lastid;
	}
}
?>
