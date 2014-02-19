<?php
class Admin_Part_Publication_Content extends Part{
	protected function getHtml(){
		$array=null;
		$span=new Html('span');
		$span->class='span_left tool';
		$form=null;
		$form[]=new Form('name','input','text','title');
		$form[]=new Form('subtitle','input');
		$form[]=new Form('author','input');
		$form[]=new Form('explanation','input');
		$form[]=new Form('start','input');
		$form[]=new Form('end','input');
		$span->add($form);
		$array[]=$span;
		
		$span=new Html('span');
		$span->class='span_right';
		$form=null;
		$form[]=new Form('file','file',0,0);
		$form[]=new Form('content','editor',0,0);
		$span->add($form);
		$array[]=$span;
		
		$part=new Part_Form();
		$part->setTitle('content');
		$part->setArray($array);
		$this->html->add($part);
	}
}