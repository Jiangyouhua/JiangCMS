<?php
class Admin_Part_Design_Layout extends Admin_Part_Plane {
	protected $handle;
	protected $model;
	protected function init() {
		$this->style = 'layout';
		$this->handle = 'handle.php';
		$this->model = 'layout';
	}
	protected function left() {
		$span = new Html ( 'span' );
		$span->class = 'tool';
		$array = array (
				'title',
				'edit',
				'block',
				'unit' 
		);
		foreach ( $array as $value ) {
			$div = $this->$value ();
			$span->add ( $div );
		}
		return $span;
	}
	protected function title() {
		$div = new Html ();
		$div->class = 'title';
		$div->add ( $this->lang ( 'tool' ) );
		return $div;
	}
	protected function edit() {
		/* page */
		$div = new Html ();
		$re=Admin_Db_Layout::getAll();
		$form = new Form ( 'layout', 'select' );
		$form->setArray ( $re );
		$div->add ( $form );
		
		$button = new Html ( 'button' );
		$button->type = 'button';
		$button->class = 'submit';
		$button->onclick = "load_page('$this->handle','$this->model','load')";
		$button->add ( $this->lang ( 'apply' ) );
		$div->add ( $button );
		return $div;
	}
	protected function block() {
		/* block */
		$div = new Html ();
		$array = array (
				"12",
				"3_9",
				'3_6_3',
				'4_8',
				'4_4_4',
				'3_3_3_3',
				'2_8_2',
				'2_4_4_2',
				'2_2_2_2_2_2' 
		);
		$label = new Html ( 'label' );
		$label->add ( $this->lang ( 'block' ) );
		$div->add ( $label );
		$button = $this->drag ( $array, 'span' );
		$div->add ( $button );
		return $div;
	}
	protected function unit() {
		/* part */
		$div = new Html ();
		$label = new Html ( 'label' );
		$label->add ( $this->lang ( 'part' ) );
		$div->add ( $label );
		$file =new PcDir(DIR.'part');
		$re=$file->getFile('.php');
		if ($re) {
			$button = $this->drag ( $re, 'part' );
			$div->add ( $button );
		}
		return $div;
	}
	protected function drag($array, $key) {
		$b = null;
		foreach ( $array as $value ) {
			$val=null;
			if(is_array($value)){
				$val=$value['name'];
			}else{
				$val=$value;
			}
			$button = new Form (0, 'button','button' );
			$button->class = "drag";
			$button->id = $key . '_' . $val;
			$button->setValue ( $val );
			$b [] = $button;
		}
		return $b;
	}
	protected function right() {
		$span = new Html ( 'span' );
		/* title */
		$title = new Html ();
		$title->class = 'title';
		$title->add ( $this->lang ( 'layout' ) );
		$span->add ( $title );
		
		/* button */
		$button = new Html ( 'button' );
		$button->type = 'button';
		$button->class = 'submit right';
		$button->onclick = "save_page('$this->handle','$this->model','save')";
		$button->add ( $this->lang ( 'Save' ) );
		$title->add ( $button );
		
		/* layout */
		$layout = new Html ();
		$layout->id = 'jcms_editarea';
		$span->add ( $layout );
		return $span;
	}
}