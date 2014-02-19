<?php
class Admin_Part_Config extends Part {
	protected function init() {
		$this->style = 'config';
	}
	protected function getHtml() {
		
		/* Get data from config file */
		$dir = new PcDir ( DIR . '/admin/config' );
		$files = $dir->getFile ( '.php' );
		
		$array = $this->Plane ( $files );
		array_push($array, $this->update());
		$tab = new Part_Tab ();
		array_push($files, 'update');
		$tab->setTab ( $files );
		$tab->setArray ( $array );
		$this->html->add ( $tab );
	}
	protected function Plane($files) {
		$array = null;
		foreach ( $files as $value ) {
			
			/* get class static val */
			$reflector = new ReflectionClass ( "Admin_Config_" . $value );
			$properties = $reflector->getStaticProperties ();
			
			$planes = array ();
			foreach ( $properties as $k => $v ) {
				switch ($k) {
					case 'lang' :
						$form = $this->forlang ( $k, $v );
						break;
					case 'ui' :
						$form = $this->forui ( $k, $v );
						break;
					default :
						$form = $this->forinput ( $k, $v );
						break;
				}
				
				$planes [$value] [$k] = $form;
			}
			
			$array [] = $this->forPlane ( $planes );
		}
		return $array;
	}
	protected function forPlane($planes) {
		$array = null;
		foreach ( $planes as $key => $value ) {
			$form = new Part_Form ();
			$form->setTitle ( $key );
			$form->setModel ( 'config' );
			$form->setArray ( $value );
			$array [] = $form;
		}
		return $array;
	}
	protected function forui($k, $v) {
		$dir=new PcDir(DIR."/ui");
		$ui=$dir->getFolder();
		$form=new Form($k,'select');
		$form->setValue ( $v );
		$form->setArray($ui,'name');
		return $form;
	}
	protected function forlang($k, $v) {
		$dir = new PcDir ( DIR . "/lauguage" );
		$lang = $dir->getFolder ();
		$form = new Form ( $k, 'select' );
		$form->setValue ( $v );
		$form->setArray ( $lang,'name');
		return $form;
	}
	protected function forinput($k, $v) {
		$form = new Form ( $k, 'input' );
		$form->setLabel ( $k );
		$form->setValue ( $v );
		return $form;
	}
	protected function update(){
		$array=array('ui','lang','part');
	}
}