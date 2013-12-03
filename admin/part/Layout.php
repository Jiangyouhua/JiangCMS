<?php
class Admin_Part_Layout extends Admin_Part_Plane {
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
		$div->add ( Lang::to ( 'tool' ) );
		return $div;
	}
	protected function edit() {
		/* page */
		$div = new Html ();
		$re = Web::getLayout ();
		$form = new Form ( 'select', 'layout' );
		$form->setArray ( $re );
		$div->add ( $form );
		
		$button = new Html ( 'button' );
		$button->type = 'button';
		$button->class = 'submit';
		$button->onclick = "load_page('$this->handle','$this->model','load')";
		$button->add ( Lang::to ( 'apply' ) );
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
		$label->add ( Lang::to ( 'block' ) );
		$div->add ( $label );
		$button = $this->drag ( $array, 'span' );
		$div->add ( $button );
		return $div;
	}
	protected function unit() {
		/* part */
		$div = new Html ();
		$label = new Html ( 'label' );
		$label->add ( Lang::to ( 'part' ) );
		$div->add ( $label );
		$re = Admin_Db_Unit::getAll ();
		if ($re) {
			$button = $this->drag ( $re, 'unit' );
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
			$button = new Form ( 'button', null, 'button' );
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
		$title->add ( Lang::to ( 'layout' ) );
		$span->add ( $title );
		
		/* button */
		$button = new Html ( 'button' );
		$button->type = 'button';
		$button->class = 'submit right';
		$button->onclick = "save_page('$this->handle','$this->model','save')";
		$button->add ( Lang::to ( 'Save' ) );
		$title->add ( $button );
		
		/* layout */
		$layout = new Html ();
		$layout->id = 'jcms_editarea';
		$span->add ( $layout );
		return $span;
	}
}