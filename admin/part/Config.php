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
		$tab = new Part_Tab ();
		$tab->setTab ( $files );
		$tab->setArray ( $array );
		$this->html->add($tab);
	}
	
	protected function Plane($files) {
		
		$array=null;
		foreach ( $files as $value ) {
			
			/*get class static val*/
			$reflector = new ReflectionClass ("Admin_Config_".$value );
			$properties = $reflector->getStaticProperties ();
			
			$planes = array ();
			foreach ( $properties as $k => $v ) {
				$form = new Form ('input',$k,'text');
				$form->setLabel($k);
				$form->setValue ( $v );
				$planes [$value] [$k] = $form;
			}
			
			$array[] = $this->forPlane ( $planes );
		}
		return $array;
	}
	
	protected function forPlane($planes) {
		$array = null;
		foreach ( $planes as $key => $value ) {
			$form = new Part_Form ();
			$form->setTitle ( $key );
			$form->setModel('config');
			$form->setArray ( $value );
			$array [] = $form;
		}
		return $array;
	}
}