<?php
class PcDir{
	protected $file=array();
	protected $folder=array();
	function __construct($dir){
		$handle = opendir($dir);
		while (false !== ($file = readdir($handle))) {
			if(!trim($file,".")){
				continue;
			}
			if (is_dir($dir.'/'.$file)) {
					$this->folder[]= iconv('gb2312', 'utf-8', $file);
			}else{
				$this->file[]= iconv('gb2312', 'utf-8', $file);
			}
		}
	}
	function getFile(){
		return $this->file;
	}
	function getFolder(){
		return $this->folder;
	}
}