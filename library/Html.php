<?php
class Html implements IFormat {
	protected $contents = array ();
	protected $attr = array ();
	protected $tag;
	protected $single = array ();
	protected $tagcontent = array ();
	function __construct($tag = 'div') {
		$this->tag = $tag;
		$this->single = array (
				"input",
				"img",
				"hr",
				"meta",
				"link",
				"br",
				"param" 
		);
	}
	function __set($name, $value) {
		if ($name == "class") {
			if (empty ( $this->attr ["class"] ) || ! in_array ( $value, $this->attr ["class"] )) {
				$this->attr ["class"] [] = $value;
			}
		} else {
			$this->attr [$name] = $value;
		}
	}
	function set($name, $value) {
		if ($name == "class") {
			if (empty ( $this->attr ["class"] ) || ! in_array ( $value, $this->attr ["class"] )) {
				$this->attr ["class"] [] = $value;
			}
		} else {
			$this->attr [$name] = $value;
		}
	}
	function __get($name) {
		return $this->attr [$name];
	}
	function get($name) {
		return $this->attr [$name];
	}
	function addTagcontent($string) {
		$this->tagcontent [] = $string;
	}
	function add($content) {
		$this->contents [] = $content;
	}
	function getContent() {
		return $this->contents;
	}
	protected function forAttr() {
		if (empty ( $this->attr )) {
			return null;
		}
		$attr = "";
		foreach ( $this->attr as $key => $value ) {
			$value = ($key == "class") ? $key . '="' . implode ( $value, " " ) . '"' : $key . '="' . $value . '"';
			$attr .= $value . " ";
		}
		return $attr;
	}
	function forTagcontent() {
		if (empty ( $this->tagcontent )) {
			return null;
		}
		return implode ( " ", $this->tagcontent );
	}
	function forContent() {
		if (empty ( $this->contents )) {
			return null;
		}
		$string = null;
		foreach ( $this->contents as $content ) {
			if (is_array ( $content )) {
				foreach ( $content as $value ) {
					$string .= is_a ( $value, "IFormat" ) ? $value->format () : $value;
				}
			} else {
				$string .= is_a ( $content, "IFormat" ) ? $content->format () : $content;
			}
		}
		return $string;
	}
	function format() {
		$attr = $this->forAttr ();
		$tagcontent = $this->forTagcontent ();
		$content = $this->forContent ();
		$end = in_array ( $this->tag, $this->single ) ? "" : "{$content}</{$this->tag}>";
		return "<{$this->tag} {$attr} {$tagcontent}>{$end}";
	}
}