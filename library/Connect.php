<?php
/***
 * 数据库连接
 * */
class Connect{
    private static $instance;

    private function __construct(){}

    public static function getInstance(){
        if(empty(self::$instance)){
			$host=Admin_Config_Sql::$server;
			$dbname=Admin_Config_Sql::$database;
			$uid=Admin_Config_Sql::$uid;
			$pwd=Admin_Config_Sql::$pwd;
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