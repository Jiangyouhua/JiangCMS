<?php
class Admin_Db_Classification extends DbMode {
	protected static $table = 'classification';
	protected static $order = 'level';
	static function getTop() {
		$where = "metadata<2 AND level NOT LIKE '%.%'";
		$order = 'level';
		return self::select ( $where,0,0,$order );
	}
	static function getSub($id) {
		$where = "metadata<2 AND level LIKE '$id.%'";
		$order = 'level';
		return self::select ( $where,0,0,$order );
	}
	static function getSubLast($level){
		$where = "metadata<2 AND level LIKE '$level.%'";
		$order='level DESC';
		return self::select ( $where,1,0,$order );
	}
	static function getMenu($id) {
		$re = self::getIt ( $id );
		if (! $re) {
			return null;
		}
		$where = "metadata<2 AND level LIKE '$level'";
		$order = 'level';
		return self::select ( $where,0,0,$order );
	}
	static function formSelect($where = 1, $a = 0, $column = null, $order = null, $limit = null, $join = null, $on = null) {
		$re=self::select($where = 1, $a = 0, $column = null, $order = null, $limit = null, $join = null, $on = null);
		$form=new Form(self::$table, 'select');
		$form->setArray($re);
		return $form;
	}
	
}