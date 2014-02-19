<?php
class Page implements IFormat {
	protected $html;
	protected $head;
	protected $body;
	protected $include;
	protected $lang;
	protected $name;
	function __construct() {
		$this->html = new Html ( 'html' );
		$this->head = new Html ( 'head' );
		$this->body = new Html ( 'body' );
		$this->html->xmlns = 'http://www.w3.org/1999/xhtml';
	}
	function __set($name, $value) {
		$this->body->$name = $value;
	}
	function addInclude($include) {
		$this->include [] = $include;
	}
	function addHead($content) {
		$this->head->add ( $content );
	}
	function addBody($content) {
		$this->body->add ( $content );
	}
	function setWidth($width = null) {
		if ($width) {
			$width = intval ( $width );
			if ($width <= 100) {
				$width .= '%';
			}
			$this->body->style = "width:$width";
		}
	}
	function format() {
		$p = null;
		if ($this->include) {
			$p = '<?php';
			foreach ( $this->include as $value ) {
				$p .= " include ('$value');";
			}
			$p .= " ?>";
		}
		$i = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		$this->html->add ( $this->head );
		$this->html->add ( $this->body );
		return $p . $i . $this->html->format ();
	}
}