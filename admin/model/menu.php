<?php
class Admin_Model_Menu extends Model {
	function modify() {
		/* 默认数据（原数据） */
		if ($this->data ['id'] == 6) {
			$this->data ['name'] = 'main';
		}
		/* 非空检查 */
		if (! Check::Is ( $this->array, array (
				'name' 
		) )) {
			$this->back = false;
			return;
		}
		/* 根项的设定 */
		$associate = $this->array ['associate'];
		$option = $this->array ['option'];
		if (! $associate && $option) {
			$option = 0;
		}
		unset ( $this->array ['associate'] );
		unset ( $this->array ['option'] );
		
		/* 插入与更改 */
		$this->back = $this->insert ( $associate, $option );
		if ($this->data ['id']) {
			$this->back = $this->update ( $this->data ['id'] );
		}
	}
	function delete() {
		$item = $this->parentSub (0,0, $this->data ['id'] );
		$max = $this->rangeEnd ( $item ['parent'] );
		$re = Admin_Db_Classification::delById ( $this->data ['id'] );
		if ($re && $item ['parent']) {
			$this->batchMinus ( $item ['parent'], $item ['sub'], $max );
		}
	}
	
	/* 修改树状列 */
	protected function update($id) {
		$item = $this->parentSub ( 0, 0, $id );
		$end = $this->rangeEnd ( $item ['parent'] );
		$re = Admin_Db_Classification::delById ( $id );
		if ($re) {
			$this->back = $this->batchMinus ( $item ['parent'], $item ['sub'], $end );
		}
	}
	
	/* 插入树状列 */
	protected function insert($associate = 0, $option = 0) {
		$item = $this->parentSub ( $associate, $option );
		if ($item ['parent']) {
			$end = $this->rangeEnd ( $item ['parent'] );
			if ($option) {
				$this->batchAdd ( $item ['parent'], $item ['sub'], $end );
				$this->array ['level'] = $this->forLevel($item ['parent'] ,$item ['sub']);
			}else{
				$this->array['level']=$this->forLevel($item['parent'], $end+1);
			}
		}
		$re = Admin_Db_Classification::insert ( $this->array );
		if (! $item ['parent']) {
			/* 插入根类别 */
			$array ['level'] = $re;
			$array ['id'] = $re;
			$re = Admin_Db_Classification::update ( $array );
		}
		$this->back = $re;
	}
	
	/* 求树枝项变动范围，父项、插入位置 */
	protected function parentSub($associate = 0, $option = 0, $id = 0) {
		$item ['parent'] = 0; // 父项
		$item ['sub'] = 0; // 变动开始，即插入位置
		
		/* 从id获取父子数据 */
		if ($id) {
			$re = Admin_Db_Classification::getById ( $id );
			$associate = $re ['level'];
			$option = 1;
		}
		/* 如果是根目录则没有需要改变的 */
		if (! $associate) {
			return $item;
		}
		
		/* 如果是子项 */
		if (! $option) {
			$re = Admin_Db_Classification::getSubLast ( $associate );
			$associate = $re ['level'];
			$option = 2;
		}
		
		$array = explode ( '.', $associate );
		$start = array_pop ( $array );
		$item ['sub'] = $option == 2 ? $start ++ : $start;
		$item ['parent'] = implode ( '.', $array );
		return $item;
	}
	
	/* 求变更范围止 */
	protected function rangeEnd($parent) {
		$re = Admin_Db_Classification::getSubLast ( $parent );
		$arr = explode ( '.', $re ['level'] );
		return end ( $arr );
	}
	
	/* 项批下移处理 */
	protected function batchAdd($parent, $min, $max) {
		$re = 0;
		for($max; $max >= $min; $max --) {
			$old = "$parent.$start";
			$new = $this->forLevel ( $perent, $start + 1 );
			$re = Admin_Db_Classification::replace ( 'level', $old, $new );
		}
		return $re;
	}
	
	/* 项批上移处理 */
	protected function batchMinus($parent, $min, $max) {
		$re = 0;
		for($min; $min < $max; $min ++) {
			$new = "$parent.$start";
			$old = $this->forLevel ( $perent, $start + 1 );
			$re = Admin_Db_Classification::replace ( 'level', $old, $new );
		}
		return $re;
	}
	/* level,补零,让每一层级百以内排列05排10前，不然10排在5前 */
	protected function forLevel($perent, $sub) {
		$level = str_pad ( $sub, 2, '0' ,STR_PAD_LEFT);
		return "$perent.$level";
	}
}