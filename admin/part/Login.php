<?php
class Admin_Part_Login extends Part {
	protected function init() {
		$this->style = 'Login';
	}
	protected function getHtml() {
		$form=null;
		$form[]=new Form('name','input');
		$form[]=new Form('password','input','password');
		$form[]=new Form('captcha','captcha');
		$part=new Part_Form();
		$part->setTitle('adminLogin');
		$part->setmodel('Login');
		$part->setArray($form);
		$this->html->add($part);
	}
}