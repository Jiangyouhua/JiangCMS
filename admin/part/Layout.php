<?php
class Admin_Part_Layout extends Part {
	protected function init() {
		$this->style = 'layout';
	}
	protected function getHtml() {
		$tool = $this->tool ();
		$this->html->add ( $tool );
		$layout = $this->layout ();
		$this->html->add ( $layout );
	}
	protected function tool() {
		$ul = new Html ('span');
		$ul->class = 'span_left tool';
		
		/*title*/
		$title=new Html();
		$title->class='title';
		$title->add(Lang::to('tool'));
		$ul->add($title);
		
		/* page */
		$li = new Html ();
		$ul->add ( $li );
		$form = new Form ();
		$form->setElemenu ( 'select' );
		$form->setLable ( 'page' );
		$form->setName ( 'page' );
		$dir = new PcDir ( DIR );
		$pages = $dir->getFile ( '.php', array (
				'Autoload.php' 
		) );
		$form->setOption ( $pages, 1 );
		$li->add ( $form );
		
		$button = new Html ( 'button' );
		$button->type = 'button';
		$button->class='submit';
		$button->onclick="load_page()";
		$button->add ( Lang::to ( 'apply' ) );
		$li->add ( $button );
		
		/* block */
		$li = new Html ();
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
		$ul->add ( $li );
		$label = new Html ( 'lable' );
		$label->add ( Lang::to ( 'block' ) );
		$li->add ( $label );
		$this->drag($li, $array,'span');
	
		/* part */
		$li = new Html ();
		$ul->add ( $li );
		$label = new Html ( 'lable' );
		$label->add ( Lang::to ( 'part' ) );
		$li->add ( $label );
		$dir = new PcDir ( DIR . "/part" );
		$array = $dir->getFile ( '.php' );
		$this->drag($li, $array,'part');
		
		return $ul;
	}
	
	protected function drag($li,$array,$key){
		foreach ( $array as $value ) {
			$button = new Html ( 'button' );
			$button->class="drag";
			$button->id=$key.'_'.$value;
			$button->type = 'button';
			$button->add ( Lang::to ( $value ) );
			$li->add ( $button );
		}
	}
	
	protected function layout() {
		$span = new Html ( 'span' );
		$span->class = 'span_right';
		
		/*title*/
		$title=new Html();
		$title->class='title';
		$title->add ( Lang::to ( 'layout' ) );
		$span->add($title);
		
		/*layout*/
		$layout=new Html();
		$layout->id='jcms_editarea';
		$span->add($layout);
		return $span;
	}
}