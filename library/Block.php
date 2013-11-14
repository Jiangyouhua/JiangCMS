<?php
class Block{
	static function format($id, $name=null){
		
		$array=null;
		if(!$id){
			$re['name']="unit_$name";
			self::html($re,$array,$name);
			return;
		}

		$unit=Config::$sql_prefix."_unit";
		$classification=$table=Config::$sql_prefix."_classification";
		$content=$table=Config::$sql_prefix."_content";

		/*从unit得到数据*/
		$db=new DbSelect();
		$db->setTable($unit);
		$db->setWhere("id = $id AND status = 1");
		$re=$db->fetch();

		if(!$re){
			self::html($re,$array,$name);
			return;
		}

		/*1. 按内容ID读取具体的数据*/
		$ids=$re['isurl']?(empty($_GET['id'])?0:$_GET['id']):$re['content'];
		if($ids){
			$db=new DbSelect();
			$db->setTable($content);
			$db->setWhere("id IN ($ids) AND status = 1");
			$array=$db->fetchAll();
			self::html($re,$array,$name);
			return;
		}

		$ids=$re['isurl']?(empty($_GET['menu'])?0:$_GET['menu']):$re['classification'];
		if(!$ids){
			self::html($re,null,$name);
			return;
		}

		/*2. 读取数据本身*/

		if(stripos($name,'menu') || stripos($name,'navbar')){
			$db=new DbSelect();
			$sql="SELECT @item:=item, @level:=level From $classification where id=$ids and status = 1";
			$db->addSql($sql);
			$sql="SELECT * From $classification where (item=@item OR item=1) AND level LIKE CONCAT(@level,'.%') AND id<>$ids AND status = 1 ORDER BY level";
			$db->addSql($sql);
			$array=$db->fetchAll();
			self::html($re,$array,$name);
			return;
		}

		/*3. 读取所属内容*/
		$db=new DbSelect();
		$sql="SELECT @item:=item, @level:=level From $classification where id=$ids and status = 1";
		$db->addSql($sql);
		$sql="SELECT * FROM $content Where classification IN (
		SELECT classification From $classification where (item=@item OR item=1) AND level LIKE CONCAT(@level,'.%') AND id<>$ids AND status = 1)
		AND status = 1";
		$db->addSql($sql);
		$array=$db->fetchAll();
		self::html($re,$array,$name);
		return;
	}

	static protected function html($re,$array=null,$name){
		
		$part=Factory::getInstance($name);
		if(!$part){
			return;
		}
		$part->setUnit($re);
		if($array){
			$part->setArray($array);
		}
		echo $part->format();
	}
}