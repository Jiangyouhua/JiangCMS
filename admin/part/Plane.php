
<?php
class Admin_Part_Plane extends Part {
	protected function init() {
		$this->style = 'planes';
	}
	protected function getHtml() {
		$left=$this->left();
		$left->class='span_left';
		$right=$this->right();
		$right->class='span_right';
		$this->html->add($left);
		$this->html->add($right);
	}
	protected function left() {
		$div=new Html();
		$div->add(Lang::to('left'));
	}
	protected function right() {
		$div=new Html();
		$div->add(Lang::to('left'));
	}
}