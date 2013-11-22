<?php
class Go {
	static $page;
	
	static function to($name, $part = null) {
		$array = null;
		
		$self=$_SERVER['PHP_SELF'];
		if(!self::$page){
			$url=explode("/", strtolower($self));
			$dir=explode('\\',strtolower(DIR));
			self::$page=implode('/', array_diff($url, $dir,array(null)));
		}
		
		$unit = "unit";
		$classification ="classification";
		$content = "content";
		
		/* 从unit得到数据 */
		$db = new DbSelect ();
		$db->setTable ( $unit );
		$where[]="name='$name' AND page='".self::$page."'";
		
		$menu=empty($_GET['menu'])?0:$_GET['menu'];
		$where[]="(FIND_IN_SET($menu,menu) OR menu='0')";
		
		$item=empty($_GET['item'])?0:1;
		$where[]="(item = $item OR item = 2)";
		
		$where[]='status=1';
		$db->setWhere ( implode(" AND ", $where) );
		$re = $db->fetch ();
		
		if (! $re) {
			return;
		}
		
		/* 1. 按内容ID读取具体的数据 */
		$ids = $re ['isurl'] ? (empty ( $_GET ['id'] ) ? 0 : $_GET ['id']) : $re ['content'];
		if ($ids) {
			$db = new DbSelect ();
			$db->setTable ( $content );
			$db->setWhere ( "id IN ($ids) AND status = 1" );
			$array = $db->fetchAll ();
			self::html ( $re, $array, $part );
			return;
		}
		
		$ids = $re ['isurl'] ? (empty ( $_GET ['menu'] ) ? 0 : $_GET ['menu']) : $re ['classification'];
		if (! $ids) {
			self::html ( $re, null, $part );
			return;
		}
		
		/* 2. 读取数据本身 */
		
		if (stripos ( $part, 'menu' ) || stripos ( $part, 'navbar' )) {
			$db = new DbSelect ();
			$sql = "SELECT @item:=item, @level:=level From ".db::table('classification')." where id=$ids and status = 1";
			$db->addSql ( $sql );
			$sql = "SELECT * From ".db::table('classification')." where (item=@item OR item=1) AND level LIKE CONCAT(@level,'.%') AND id<>$ids AND status = 1 ORDER BY level";
			$db->addSql ( $sql );
			$array = $db->fetchAll ();
			self::html ( $re, $array, $part );
			return;
		}
		
		/* 3. 读取所属内容 */
		$db = new DbSelect ();
		$sql = "SELECT @item:=item, @level:=level From ".db::table('classification')." where id=$ids and status = 1";
		$db->addSql ( $sql );
		$sql = "SELECT * FROM ".db::table('content')." Where classification IN (
		SELECT classification From ".db::table('classification')." where (item=@item OR item=1) AND level LIKE CONCAT(@level,'.%') AND id<>$ids AND status = 1)
		AND status = 1";
		$db->addSql ( $sql );
		$array = $db->fetchAll ();
		self::html ( $re, $array, $part );
		return;
	}
	
	static protected function html($re, $array = null, $part) {
		if(!stripos($part, "_")){
			$part="Part_$part";
		}
		$part = Factory::getInstance ( $part );
		if (! $part) {
			return;
		}
		if ($re) {
			$part->setUnit ( $re );
		}
		if ($array) {
			$part->setArray ( $array );
		}
		echo $part->format ();
	}
	
}