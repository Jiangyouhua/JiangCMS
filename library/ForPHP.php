<?php
class Design {
	protected static $symbol = array (
			'<?php Go::to',
			' ?>' 
	);
	protected static $placeholder = '*';
	protected static $head;
	protected static $body;
	protected static $unit;
	
	/* 更改数据库Layout */
	static function setLayout(array $array) {
		$id = null;
		if ($id = $array ['id']) {
			self::removeFile ( $id );
			$db = new DbUpdate ( 'layout' );
			$db->setWhere ( 'id='.$array ['id'] );
			$db->setSet($array);
			$db->exec ();
		} else {
			$db = new DbInsert ( 'layout' );
			$db->setData ( $array );
			$db->exec ();
			$id = $db->lastId ();
		}
		self::$layout [$array ['id']] = $array;
		self::$head [$array ['id']] = null;
		self::setPage ( $id );
		return true;
	}
	
	/*从数据库得到unit*/
	static function getUnit($layout){
		if(empty(self::$unit[$layout])){
			$db=new DbSelect('unit');
			$db->setWhere("layout=$layout");
			$db->setOrder('part');
			self::$unit[$layout]=$db->fetchAll();
		}
		return self::$unit[$layout];
	}
	
	static function setUnit($unit){
		
	}
	/* 从数据库获取Layout */
	static function getLayout($layout = null) {
		if (empty ( self::$layout [$layout] )) {
			$db = new DbSelect ( 'layout' );
			if ($layout) {
				$db->setWhere ( is_numeric ( $layout ) ? "id=$layout" : "name='$layout'" );
				$re = $db->fetch ();
			} else {
				$re = $db->fetchAll ();
			}
			self::$layout [$layout] = $re;
		}
		return self::$layout [$layout];
	}
	static function delLayout($id) {
		self::removeFile ( $id );
		$db = new DbDelete ( 'layout' );
		$db->setWhere ( "id=$id" );
		$db->exec ();
		$db = new DbDelete ( 'unii' );
		$db->setWhere ( "layout=$id" );
		$db->exec ();
		return true;
	}
	
	/* 格式化头文件 */
	static protected function setHead($layout) {
		if (empty ( self::$head [$layout] )) {
			$head = null;
			/* 设置标题 */
			$title = new Html ( 'title' );
			$title->add ( lang::to ( $layout ) );
			$title->add ( '<?php echo $_GET["name"]?>' );
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
			$array = self::getUi ( $layout );
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
		}
		self::$head [$layout] = $head;
	}
	/* 将layout设计形成的字符串中获取part值保存到数据库并，更新body */
	static function setBody($layout, $string = null) {
		if (! $string) {
			return;
		}
		$array = array ();
		$str = str_ireplace ( self::$placeholder . '(', self::$symbol [0] . '(', $string );
		self::$body [$layout] = str_ireplace ( ')' . self::$placeholder, ')' . self::$symbol [1], $str );
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
	static function getHead($layout) {
		if (empty ( self::$head [$layout] )) {
			self::getPage ( $layout );
		}
		return self::$head [$layout];
	}
	static function getBody($layout) {
		if (empty ( self::$body [$layout] )) {
			self::getPage ( $layout );
		}
		return self::$body [$layout];
	}
	/* 从布局文件中得到body */
	static function getPage($layout) {
		$re = self::getLayout ( $layout );
		$file = DIR . "/" . $re ['name'] . ".php";
		$string = file_get_contents ( $file );
		$start = stripos ( $string, '<body' );
		$end = stripos ( $string, '</body>' );
		self::$head [$layout] = substr ( $string, 0, $start );
		$body=substr ( $string, $start , $end - $start );
		$body=str_ireplace(self::$symbol[0], self::$placeholder, $body);
		$body=str_ireplace(self::$symbol[1], self::$placeholder, $body);
		self::$body [$layout] = substr ( $body, stripos ( $body, '>' )+1);
	}
	/* 输出布局页面 */
	static function setPage($layout, $string = null) {
		$page = new Page ();
		if (empty ( self::$head [$layout] )) {
			self::setHead ( $layout );
		}
		if (empty ( self::$body [$layout] )) {
			self::setBody ( $layout, $string );
		}
		$page->addHead ( self::$head [$layout] );
		$page->addBody ( self::$body [$layout] );
		
		/* 输出文件 */
		$re = self::getLayout ( $layout );
		$file = DIR . "/" . $re ['name'] . ".php";
		if (! $handle = fopen ( $file, 'w' )) {
			return;
		}
		
		if (! fwrite ( $handle, $page->format() )) {
			return;
		}
		fclose ( $handle );
		return true;
	}
	/* 加载相应的UI */
	static protected function getUi($layout) {
		$re = self::getLayout ( $layout );
		$ui = $re ['ui'];
		$dir = DIR . '/ui/' . $ui;
		
		$ini = new FileIni ( $dir . '/ui.ini' );
		$array = $ini->read ( 1 );
		
		if (empty ( $array ['css'] )) {
			$array ['css'] [] = "/$ui.css";
		}
		
		if (empty ( $array ['js'] )) {
			$array ['js'] [] = "/" . $re ['lang'] . ".js";
			$array ['js'] [] = "/$ui.js";
		} else {
			$array ['js'] [] = "/" . $re ['lang'] . ".js";
		}
		return $array;
	}
	static function removeFile($id) {
		$re = self::getLayout ( $id );
		$filename = DIR . "\\" . $re ['name'] . ".php";
		if (file_exists ( $filename )) {
			return unlink ( $filename );
		}
	}
}