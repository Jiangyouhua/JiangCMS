<?php
/***
 * 数据库连接
 * */
class Connect{
    private static $instance;

    private function __construct(){}

    public static function getInstance(){
        if(empty(self::$instance)){
			$host=Config::$sql_server;
			$dbname=Config::$sql_database;
			$uid=Config::$sql_uid;
			$pwd=Config::$sql_pwd;
            try{
            self::$instance = new PDO("mysql:host=$host;dbname=$dbname","$uid","$pwd",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));          
            }catch(PDOException $e){          	
            	throw $e;
            }
        }
      return self::$instance;
    }
}
?>