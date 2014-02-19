<?php
class Part_Navbar extends Part {
	protected $index;
	protected function init() {
		$this->html = new Html ( 'ul' );
		$this->style = 'navbar';
		$this->index = true;
	}
	protected function getHtml() {
		if (! $this->array) {
			parent::getHtml ();
			return;
		}
		
		if (empty ( $this->array [0] ['level'] )) {
			return;
		}
		
		$old = 0;
		$new = 0;
		$ul [0] = $this->html;
		if ($this->index) {
			$li = new Html ( 'li' );
			$a = new Html ( 'a' );
			$a->add ( $this->lang ( 'index' ) );
			$a->href = ROOT;
			$li->add ( $a );
			$ul [0]->add ( $li );
		}
		foreach ( $this->array as $key => $value ) {
			
			/* 显示级别差异 */
			$new = substr_count ( $value ['level'], '.' );
			if ($new > $old) {
				if ($key == 0) {
					$ul [$new] = $this->html;
				} else {
					$ul [$new] = new Html ( 'ul' );
					$li->add ( $ul [$new] );
				}
				$old = $new;
			}
			$li = new Html ( 'li' );
			$li->id = $this->unit ['name'] . $value ['id'];
			$ul [$new]->add ( $li );
			
			/* 添加链接 */
			
			$a = new Html ( 'a' );
			$a->href = $this->forHref ( $value ['id'], $value ['href'] );
			$li->add ( $a );
			$a->add ( $this->lang ( $value ['name']));
		}
	}
	protected function forHref($id, $href = null) {
		if ($href) {
			return $href;
		}
		if (! empty ( $this->unit ['href'] )) {
			return $this->unit ['href'] . "&id=$id";
		}
		return Url::out ( array (
				'menu' => $id 
		) );
	}
}