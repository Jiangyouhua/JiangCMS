<?php
class Data {
	protected $unit;
	function __construct($unit) {
		$this->unit = $unit;
	}
	protected function menu() {
		/* unit['menu']为假表示始终呈现 */
		if (! $this->unit ['menu']) {
			return true;
		}
		$array = explode ( ',', $this->unit ['menu'] );
		$menu = empty ( $_GET ['menu'] ) ? 0 : $_GET ['menu'];
		if (in_array ( $menu, $array )) {
			return true;
		}
		$re = Admin_Db_Classification::getSub ( $menu );
		foreach ( $re as $value ) {
			if (in_array ( $value ['id'], $array )) {
				return true;
			}
		}
		return false;
	}
	protected function item() {
		if ($this->unit ['item'] == 2) {
			return true;
		}
		$item = empty ( $_GET ['item'] ) ? 0 : 1;
		return "$this->unit['item'] ==$item ";
	}
	function get($menu = false, $item = false) {
		if (! $this->unit) {
			return null;
		}
		if(!Role::unit($this->unit['role'])){
			return null;
		}
		/*是否匹配当前url*/
		if($item && !$this->item()){
			return null;
		}
		if($menu && !$this->menu()){
			return null;
		}
		
		$array = true;
		$re = $this->unit;
		/* 1. 通过ID指定了具体内容 */
		$id = $re ['content'];
		if ($re ['isurl'] && ! empty ( $_GET ['id'] )) {
			$id = $_GET ['id'];
		}
		if ($id) {
			$re  = $this->get4Id ( $ids );
			if($re){
				$array=$re;
			}
		}
		
		/* 2.通过分类指定具体内容 */
		$menu = $re ['classification'];
		if ($re ['isurl'] && ! empty ( $_GET ['menu'] )) {
			$menu = $_GET ['menu'];
		}
		if ($menu) {
			$re = $this->get4Menu ( $menu, $re ['part'] );
			if($re){
				$array=$re;
			}
		}
		return $array;
	}
	protected function get4Id($id) {
		$db = new DbSelect ( 'content' );
		$db->setWhere ( "id IN ($id) AND status = 1" );
		return $db->fetchAll ();
	}
	protected function get4Menu($menu, $part) {
		/* 2. 从分类表读取导航、菜单数据 */
		if (strtolower ( $part ) == 'menu' || strtolower ( $part ) == 'navbar') {
			$db = new DbSelect ();
			$sql = "SELECT @level:=level From " . db::table ( 'classification' ) . " where id=$menu and status = 1";
			$db->addSql ( $sql );
			$sql = "SELECT * From " . db::table ( 'classification' ) . " where  level LIKE CONCAT(@level,'.%') AND id<>$menu AND status = 1 ORDER BY level";
			$db->addSql ( $sql );
			return $db->fetchAll ();
		}
		
		/* 3. 读取所属内容 */
		$db = new DbSelect ();
		$sql = "SELECT @level:=level From " . db::table ( 'classification' ) . " where id=$menu and status = 1";
		$db->addSql ( $sql );
		$sql = "SELECT * FROM " . db::table ( 'content' ) . " Where classification IN (
		SELECT classification From " . db::table ( 'classification' ) . " where level LIKE CONCAT(@level,'.%') AND id<>$menu AND status = 1)
				AND status = 1";
		$db->addSql ( $sql );
		return $db->fetchAll ();
	}
}