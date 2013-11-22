<?php
class Admin_Model_Page extends Model {
	protected $page;
	protected function init() {
		$this->page = new Page ();
		$this->page->addJS ( DIR . '/ui/jquery-1.10.2.min.js' );
		$this->page->addMeta ( array (
				'name' => 'description',
				'content' => 'Jiang CMS' 
		) );
		$this->page->addMeta ( array (
				'http-equiv' => 'Content-Type',
				'content' => 'text/html; charset=utf-8' 
		) );
		$this->page->addMeta ( array (
				'name' => 'author',
				'content' => 'Jiang youhua' 
		) );
		$this->page->addMeta ( array (
				'name' => 'Copyright',
				'content' => 'Copyright © Jiang youhua All Rights Reserved.' 
		) );
	}
	function post() {
		$name = $this->post ['name'];
		/* 修改 */
		if (! empty ( $this->post ['jcms_name'] )) {
			$oldname = DIR . '/' . $this->post ['jcms_name'] . '.php';
			$newname = DIR . '/' . $name . '.php';
			$this->back = rename ( $oldname, $newname );
			$db = new DbUpdate ( 'unit' );
			$db->setWhere ( "page=$oldname" );
			$db->setSet ( "page=newname" );
			$db->exec ();
			return;
		}
		
		$this->page->setTitle ( Lang::to ( $name, null, $this->post ['lang'] ) );
		$this->ui ();
		$this->head ();
		
		/* write file */
		$file = DIR . "/" . $name . ".php";
		if (! $handle = fopen ( $file, 'w' )) {
			return false;
		}
		
		if (! fwrite ( $handle, $this->page->format () )) {
			return false;
		}
		fclose ( $handle );
		$this->back = true;
	}
	protected function ui() {
		$ui = $this->post ['ui'];
		$dir = DIR . '/ui/' . $ui;
		
		$ini = new FileIni ( $dir . '/ui.ini' );
		$array = $ini->read ( 1 );
		
		if (empty ( $array ['css'] )) {
			$array ['css'] [] = "/$ui.css";
		}
		foreach ( $array ['css'] as $value ) {
			$this->page->addCSS ( $dir . $value );
		}
		
		if (empty ( $array ['js'] )) {
			$array ['js'] [] = "/" . $this->post ['lang'] . ".js";
			$array ['js'] [] = "/$ui.js";
		} else {
			$array ['js'] [] = "/" . $this->post ['lang'] . ".js";
		}
		foreach ( $array ['js'] as $value ) {
			$this->page->addJS ( $dir . $value );
		}
	}
	protected function head() {
		$lang = "<?php include('" . DIR . "/autoload.php'); defined('LANG') || define('LANG', '" . $this->post ['lang'] . "');?>";
		$this->page->addHead ( $lang );
	}
	protected function get() {
		if (empty ( $this->get ['jcms_edit'] ) || $this->get ['jcms_edit'] != 'delete') {
			return;
		}
		
		$file = DIR . '/' . $this->get ['name'] . '.php';
		$this->back = unlink ( $file );
	}
}