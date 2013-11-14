<?php
/**
 * 1.实现数据库连接
 * 2.实现输入参数格式SQL
 * 3.实现数据库表操作
 * 4.实现多条SQL语句操作数据表
 * */
abstract class DB {

	protected $sql;
	protected $table;
	protected $query;
	protected $re;
	protected $id;

	function __construct($table=null){
		$this->table=$table;
	}

	function setTable($table){
		$this->table="`".$table."`";
	}
	
	function getRe(){
		if(!$this->re){
			$this->run();
		}
		return $this->re;
	}

	function addSql($sql){
		if(is_string($sql)){
			$this->sql[]=$sql;
		}
	}

	function addDb($db){
		if(is_a($db,"Db")){
			$this->sql[]=$db->format();
		}
	}

	function exec(){
		return $this->run();
	}

	protected function run($mode=null){

		$re=null;
		$query=null;

		if($this->table){
			$this->sql[]=$this->format();
		}

		if(!$this->sql){
			return null;
		}

		try{
			$con=Connect::getInstance();
			$con->beginTransaction();
			foreach ($this->sql as $sql){
				if(preg_match("/^SELECT |DESCRIBE |SHOW/",$sql)){
					$query=$con->query($sql);
					if($query){
						switch ($mode){
							case 1:
								$re[]=$query->fetch(PDO::FETCH_ASSOC);
								break;
							case 2:
								$re[]=$query->rowCount();
								break;
							default:
								$re[]=$query->fetchAll(PDO::FETCH_ASSOC);
								break;
						}
					}
				}else{
					$this->re[]=$con->exec($sql);
					if($str=="INSERT"){
						$this->id=$con->lastInsertId();
					}
				}
			}
			$con->commit();
		} catch (Exception $e){
			$con->rollBack();
		}

		$this->query=$query;
		$this->re=$re;
		return end($re);
	}

	abstract protected function format();
}
?>
