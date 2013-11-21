<?php
class Admin_Model_Page extends Model {
	protected $page;
	protected function init() {
		$this->page = new Page ();
	}
	function post() {
		$name = $this->post ['name'];
		/*修改*/
		if(!empty($this->post['jcms_name'])){
			$oldname=DIR.'/'.$this->post['jcms_name'].'.php';
			$newname=DIR.'/'.$name.'.php';
			$this->back=rename($oldname, $newname);
			return;
		}
		
		
		$this->page->setTitle ( Lang::to ( $name, null, $this->post ['lang'] ) );
		$this->ui ();
		$this->body ();
		
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
		if (empty ( $array ['js'] )) {
			$array ['js'] [] = "/$ui.js";
		}
		
		foreach ( $array ['css'] as $value ) {
			$this->page->addCSS ( $dir . $value );
		}
		
		foreach ( $array ['css'] as $value ) {
			$this->page->addCSS ( $dir . $value );
		}
		
		foreach ( $array ['js'] as $value ) {
			$this->page->addJS ( $dir . $value );
		}
	}
	protected function body() {
		$lang = "<?php include('" . DIR . "/autoload.php'); defined('LANG') || define('LANG', '" . $this->post ['lang'] . "');?>";
		$placeholder = new Html ( 'Placeholder' );
		$this->page->add ( $lang );
		$this->page->add ( $placeholder );
	}
	protected function get() {
		if (empty ( $this->get ['jcms_edit'] ) || $this->get ['jcms_edit']!='delete') {
			return;
		}
		
		$file = DIR . '/' . $this->get ['name'] . '.php';
		$this->back=unlink($file);
	}
}