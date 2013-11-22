<?php
class Admin_Model_Layout extends Model {
	protected static $page;
	protected $symbol;
	protected $placeholder;
	protected function init() {
		$this->symbol = array (
				'<?php Go::to',
				' ?>' 
		);
		$this->placeholder = '*';
	}
	protected function post() {
		if ($this->post ['jcms_title'] == 'page') {
			$this->page ();
		}
		if ($this->post ['jcms_title'] == 'layout') {
			$this->layout ();
		}
	}
	
	/*从页面读取组件*/
	protected function page() {
		if (empty ( self::$page [$this->post ['page']] ['body'] )) {
			$this->forPage ();
		}
		$body = self::$page [$this->post ['page']] ['body'];
		$str = str_ireplace ( $this->symbol [0], $this->placeholder, $body );
		$this->back = str_ireplace ( $this->symbol [1], $this->placeholder, $str );
	}
	/*将组件格式化为页面*/
	protected function layout() {
		if (empty ( self::$page [$this->post ['page']]['head'] )) {
			$this->forPage ();
		}
		$this->unit($this->post['str']);
		$str=str_ireplace (  $this->placeholder.'(',$this->symbol [0].'(', $this->post['str'] );
		$body=str_ireplace (  ')'.$this->placeholder,')'.$this->symbol [1],$str);
		$page=self::$page[$this->post['page']]['head']."<body>$body</body>";
		
		$file = DIR . "/" . $this->post ['page'] . ".php";
		if (! $handle = fopen ( $file, 'w' )) {
			return ;
		}
		
		if (! fwrite ( $handle, $page )) {
			return ;
		}
		fclose ( $handle );
		$this->back = true;
	}
	protected function forPage() {
		$file = DIR . "/" . $this->post ['page'] . ".php";
		$string = file_get_contents ( $file );
		$start = stripos ( $string, '<body>' );
		$end = stripos ( $string, '</body>' );
		self::$page [$this->post ['page']] ['head'] = substr ( $string, 0, $start );
		self::$page [$this->post ['page']] ['body'] = substr ( $string, $start + 6, $end - $start - 6 );
	}
	/*存储unit*/
	protected function unit($str){
		
		$array=array();
		$page=$this->post['page'].'.php';
		while ($n=stripos($str,'*(')){
			$str=substr($str, $n);
			$num=stripos($str,')*');
			$s=substr($str,2,$num-2);
			$str=substr($str,$num);
			$arr=explode(",", $s);
			$db=new DbSelect('unit');
			$name=str_ireplace("'", "", $arr[0]);
			$db->setWhere("page='$page' AND name='$name'");
			$re=$db->fetch();
			if(!$re){
				$db=new DbInsert('unit');
				$db->setData(array('page'=>$page,'name'=>$name));
				$db->exec();
			}
			$array[]=$arr[0];
		}
		$db=new DbDelete('unit');
		$where="page='$page' AND name NOT IN (".implode(",", $array).")";
		$db->setWhere($where);
		$db->exec();
	}
}