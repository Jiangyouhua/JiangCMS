<?php
class Design {
	protected $symbol = array (
			'<?php Go::to',
			' ?>' 
	);
	protected $placeholder = '*';
	protected $page;
	protected $name;
	protected $id;
	protected $width;
	protected $head;
	protected $body;
	function __construct() {
		$this->page = new Page ();
		$this->page->addInclude ( '/library/Include.php' );
	}
	
	/* 新建layout */
	function newLayout($array) {
		$this->strHead ( $array );
		$this->width = $array ['width'];
		return $this->writeLayout ( $array ['name'] );
	}
	
	/* 删除layout */
	function delLayout($id) {
		$re = Admin_Db_Layout::getById ( $id );
		if (! $re) {
			return false;
		}
		return $this->removeFile ( $re ['name'] );
	}
	
	/* 更新layout头信息 */
	function upHead($array) {
		$this->strHead ( $array );
		$this->readLayout ( $array ['name'] );
		$this->page->addBody ( $this->body );
		$this->width = $array ['width'];
		return $this->writeLayout ( $array ['name'] );
	}
	
	/* 更新layout体信息 */
	function upBody($array) {
		$re = Admin_Db_Layout::getById ( $array ['id'] );
		$this->strHead ( $re );
		$this->width = $re ['width'];
		$this->strBody ();
		return $this->writeLayout ( $array ['name'] );
	}
	
	/* 将数据转为head字符串 */
	protected function strHead($array) {
		$head = null;
		/* 设置标题 */
		$title = new Html ( 'title' );
		$title->add ( lang::to ( $array ['name'] ) );
		$title->add ( ' <?php echo lang::to(Admin_Db_Classification::nameById(@$_GET["menu"]))?>' );
		$head [] = $title;
		
		/* meta */
		$meta = new Html ( 'meta' );
		$meta->set ( 'http-equiv', 'Content-Type' );
		$meta->set ( 'content', 'text/html' );
		$meta->set ( 'charset', 'UTF-8' );
		$head [] = $meta;
		
		$meta = new Html ( 'meta' );
		$meta->set ( 'name', 'author' );
		$meta->set ( 'content', 'Jiang Youhua' );
		$head [] = $meta;
		
		$meta = new Html ( 'meta' );
		$meta->set ( 'name', 'Copyright' );
		$meta->set ( 'content', 'Copyright © Jiang youhua All Rights Reserved.' );
		$head [] = $meta;
		
		/* meta */
		$script = new Html ( 'script' );
		$script->set ( 'type', 'text/javascript' );
		$script->set ( 'src', DIR . '/ui/jquery-1.10.2.min.js' );
		$head [] = $script;
		
		/* 加载ui指定的js,css */
		$array = $this->headUi ( $array ['ui'], $array ['lang'] );
		foreach ( $array ['js'] as $value ) {
			$script = new Html ( 'script' );
			$script->set ( 'type', 'text/javascript' );
			$script->set ( 'src', DIR . $value );
			$head [] = $script;
		}
		foreach ( $array ['css'] as $value ) {
			$link = new Html ( 'link' );
			$link->set ( 'type', 'text/css' );
			$link->set ( 'href', DIR . $value );
			$head [] = $link;
		}
		$this->page->addHead ( $head );
	}
	
	/* 将数据转为body字符串 */
	protected function strBody($string) {
		$array = array ();
		$str = str_ireplace ( $this->placeholder . '(', $this->symbol [0] . '(', $string );
		$this->body [$layout] = str_ireplace ( ')' . $this->placeholder, ')' . $this->symbol [1], $str );
		while ( $n = stripos ( $string, '*(' ) ) {
			$string = substr ( $string, $n );
			$num = stripos ( $string, ')*' );
			$s = substr ( $string, 2, $num - 2 );
			$string = substr ( $string, $num );
			$arr = explode ( ",", $s );
			$db = new DbSelect ( 'unit' );
			$name = str_ireplace ( "'", "", $arr [0] );
			$part = str_ireplace ( "'", "", $arr [1] );
			$db->setWhere ( "layout='$layout' AND name='$name'" );
			$re = $db->fetch ();
			if (! $re) {
				$db = new DbInsert ( 'unit' );
				$db->setData ( array (
						'layout' => $layout,
						'name' => $name,
						'part' => $part 
				) );
				$db->exec ();
			}
			$array [] = $arr [0];
		}
		$db = new DbDelete ( 'unit' );
		$where = "layout='$layout' AND name NOT IN (" . implode ( ",", $array ) . ")";
		$db->setWhere ( $where );
		return $db->exec ();
	}
	
	/* 读layout文件 */
	protected function readLayout($name) {
		if (! $name && $this->id) {
			$re = Admin_Db_Layout::getById ( $this->id );
			$name = $re ['name'];
		}
		
		if (! $name) {
			return;
		}
		
		$file = DIR . "/" . $name . ".php";
		if (! file_exists ( $file )) {
			return;
		}
		$string = file_get_contents ( $file );
		
		/* 分离出Head,Body */
		$body1 = stripos ( $string, '<div' );
		if (! $body1) {
			return;
		}
		$body2 = strripos ( $string, '</div>' ) + 6;
		if (! $body2) {
			return;
		}
		$this->body = substr ( $string, $body1, $body2 - $body1 );
	}
	
	/* 写layout文件 */
	protected function writeLayout($name) {
		$this->page->setWidth ( $this->width );
		$file = DIR . "/" . $name . ".php";
		if (! $handle = fopen ( $file, 'w' )) {
			return;
		}
		
		if (! fwrite ( $handle, $this->page->format () )) {
			return;
		}
		fclose ( $handle );
		return true;
	}
	
	/* 加载相应的UI */
	protected function headUi($ui, $lang) {
		$dir = DIR . '/ui/' . $ui;
		
		$ini = new FileIni ( $dir . '/ui.ini' );
		$array = $ini->read ( 1 );
		
		if (empty ( $array ['css'] )) {
			$array ['css'] [] = "/$ui.css";
		}
		
		if (empty ( $array ['js'] )) {
			$array ['js'] [] = "/$ui.js";
		}
		$array ['js'] [] = "/" . $lang . ".js";
		return $array;
	}
	protected function removeFile($name) {
		$filename = DIR . $name . ".php";
		if (file_exists ( $filename )) {
			return unlink ( $filename );
		}
		return false;
	}
}