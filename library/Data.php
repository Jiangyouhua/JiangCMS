<?php
class Data {
	protected $name;
	protected $part;
	protected $layout;
	protected $unit;
	function __construct($name = null, $part = null, $layout = null) {
		$this->name = $name;
		$this->part = $part;
		$this->layout = $layout;
	}
	function setName($name) {
		$this->name = $name;
	}
	function setPart($part) {
		$this->part = $part;
	}
	function setLayout($layout) {
		$this->layout = $layout;
	}
	protected function role() {
		return true;
	}
	protected function menu() {
		$menu = empty ( $_GET ['menu'] ) ? 0 : $_GET ['menu'];
		return "(FIND_IN_SET($menu,menu) OR menu='0')";
	}
	protected function item() {
		$item = empty ( $_GET ['item'] ) ? 0 : 1;
		return "(item = $item OR item = 2)";
	}
	function getUnit($menu = false, $item = false) {
		if (! $this->unit) {
			$db = new DbSelect ('unit');
			$where =null;
			if ($this->name) {
				$where [] = "name='$this->name'";
			}
			if ($this->part) {
				$where [] = "part='$this->part'";
			}
			if ($this->layout) {
				$where [] = "layout=$this->layout";
			}
			if ($menu) {
				$where [] = $this->menu ();
			}
			if ($item) {
				$where [] = $this->item ();
			}
			$where [] = $this->role ();
			$db->setWhere ( implode ( " AND ", $where ) );
			$this->unit [0] = $db->fetchAll ();
			$this->unit [1] = true;
		}
		return $this->unit [0];
	}
	function get($menu = false, $item = false) {
		if (! $this->unit) {
			$this->getUnit ( $menu, $item );
		}
		
		if (empty ( $this->unit [0] )) {
			return null;
		}
		
		$array = null;
		foreach ( $this->unit [0] as $key=> $re ) {
			
			/* 1. 通过ID指定了具体内容 */
			$id = $re ['content'];
			if ($re ['isurl'] && ! empty ( $_GET ['id'] )) {
				$id = $_GET ['id'];
			}
			if ($id) {
				$array[$key]=$this->get4Id ( $ids );
			}
			
			/*2.通过分类指定具体内容*/
			$menu=$re ['classification'];
			if ($re ['isurl'] && ! empty ( $_GET ['menu'] )) {
				$menu = $_GET ['menu'];
			}
			if ($menu) {
				$array[$key]=$this->get4Menu($menu,$re['part']);
			}
		}
		return $array;
	}
	protected function get4Id($id) {
		$db = new DbSelect ( 'content' );
		$db->setWhere ( "id IN ($id) AND status = 1" );
		return $db->fetchAll ();
	}
	protected function get4Menu($menu,$part){
		/* 2. 从分类表读取导航、菜单数据 */
		if (strtolower ( $part ) == 'menu' || strtolower ( $part ) == 'navbar') {
			$db = new DbSelect ();
			$sql = "SELECT @item:=item, @level:=level From " . db::table ( 'classification' ) . " where id=$menu and status = 1";
			$db->addSql ( $sql );
			$sql = "SELECT * From " . db::table ( 'classification' ) . " where (item=@item OR item=1) AND level LIKE CONCAT(@level,'.%') AND id<>$menu AND status = 1 ORDER BY level";
			$db->addSql ( $sql );
			return $db->fetchAll ();
		}
			
		/* 3. 读取所属内容 */
		$db = new DbSelect ();
		$sql = "SELECT @item:=item, @level:=level From " . db::table ( 'classification' ) . " where id=$menu and status = 1";
		$db->addSql ( $sql );
		$sql = "SELECT * FROM " . db::table ( 'content' ) . " Where classification IN (
		SELECT classification From " . db::table ( 'classification' ) . " where (item=@item OR item=1) AND level LIKE CONCAT(@level,'.%') AND id<>$menu AND status = 1)
				AND status = 1";
				$db->addSql ( $sql );
				return $db->fetchAll ();
	}
}