<?php
class PcDir {
	protected $dir;
	protected $file = array ();
	protected $folder = array ();
	protected $condition;
	function __construct($dir) {
		$this->dir = $dir;
		$this->condition ['file'] = array (
				'suffix' => null,
				'filter' => null 
		);
		$this->condition ['folder'] = array (
				'filter' => null 
		);
	}
	protected function get() {
		$handle = opendir ( $this->dir );
		$files=$this->condition['file'];
		$folders = $this->condition ['folder'];
		
		while ( false !== ($file = readdir ( $handle )) ) {
			if (! trim ( $file, "." )) {
				continue;
			}
			if (is_dir ( $this->dir . '/' . $file )) {
				if (!$folders ['filter'] || !in_array ( $file, $folders ['filter'] )) {
					$this->folder [] = iconv ( 'gb2312', 'utf-8', $file );
				}
			} else {
				if (!preg_match ( '/^\./', $file ) && 
				(!$files['filter'] || !in_array($file, $files['filter']))) {
					$f = iconv ( 'gb2312', 'utf-8', $file );
					if($files['suffix']){
						$s=$files['suffix'];
						$f=preg_replace("/$s$/", '', $f);
					}
					$this->file []=$f;
				}
			}
		}
	}
	
	function getFile($suffix = null, array $filter = null) {
		if ($this->file && $this->condition ['file'] ['suffix'] == $suffix && $this->condition ['file'] ['filter'] == $filter) {
			return $this->file;
		}
		$this->condition ['file'] ['suffix'] = $suffix;
		$this->condition ['file'] ['filter'] = $filter;
		
		$this->get ();
		return $this->file;
	}
	
	function getFolder(array $filter = null) {
		if ($this->folder && $this->condition ['folder'] ['filter'] == $filter) {
			return $this->folder;
		}
		$this->condition ['folder'] ['filter'] == $filter;
		$this->get ();
		return $this->folder;
	}
}