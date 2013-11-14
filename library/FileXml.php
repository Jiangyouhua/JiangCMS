<?php
class Xml{

	protected $file;

	function __construct($xmlfile){
		$this->file=$xmlfile;
	}

	function read(){
		if(!file_exists($this->file)){
			return null;
		}
		$xml=new XMLReader();
		$xml->open($this->file);
		return $this->toData($xml);
	}

	protected function toData($xml) {
		$tree = null;
		while($xml->read())
			switch ($xml->nodeType) {
				case XMLReader::END_ELEMENT:
					return $tree;
				case XMLReader::ELEMENT:
					$tag=$xml->name;
					if(!$xml->isEmptyElement){
						$tree[$tag]['value'] = $this->toData($xml);
					}
					if($xml->hasAttributes){
						while($xml->moveToNextAttribute()){
							$tree[$tag]['attr'][$xml->name] = $xml->value;
						}
					}
					break;
				case XMLReader::TEXT:
				case XMLReader::CDATA:
					$tree = $xml->value;
		}
		return $tree;
	}

	function write(array $array){
		$xml=new XMLWriter();
		$xml->openUri($xml);
		$xml->setIndentString('  ');
		$xml->setIndent(true);
		$xml->startDocument('1.0', 'UTF-8');
		$this->doData ($xml,$array);
		$xml->flush();
	}
	private function doData($data){
		foreach ($data as $key=>$vlaue){
			$xml->startElement($key);
			if(is_array($vlaue)){
				$this->wirteData($vlaue);
			}else{
				$xml->text($vlaue);
			}
			$xml->endElement();
		}
	}
}
?>
