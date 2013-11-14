<?php
class Db2Ini{

	protected $table;
	protected $main;
	protected $key;
	protected $value;

	function __construct($file){
		$this->file=$file;
		$this->main=null;
		$this->key='id';
		$this->value='name';
	}

	function setKey($key,$value,$main=null){
		$this->main=$main;
		$this->key=$key;
		$this->value=$value;
	}

	function write($table){
		$select=new Select($table);
		$array=$select->fetchAll();
		$arr=null;
		foreach ($array as $value){
			if(empty($value[$this->key]) || empty($value[$this->value]))
			{
				continue;
			}
			if(empty($this->main)){
				$arr[$value[$this->key]]=$value[$this->value];
			}else{
				if(empty($value[$this->main])){
					continue;
				}
				$arr[$value[$this->main]][$value[$this->key]]=$value[$this->value];
			}
		}
		$ini=new Ini($this->file);
		$ini->write($arr);
		return $arr;
	}
}