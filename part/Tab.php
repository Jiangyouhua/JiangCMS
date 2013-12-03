<?php
class Part_Tab extends Part{
	
	protected $tab;
	function setTab(array $array){
		$this->tab=$array;
	}
	
	protected function init(){
		$this->style="tab";
	}
	
	protected function getHtml(){
		if(!$this->tab){
			parent::getHtml();
			return;
		}
		$this->forTab();
		if(!$this->array){
			return;
		}
		$this->forHtml();
	}
	
	protected function forTab(){
		$ul=new Html('ul');
		$ul->class='tabs';
		foreach ($this->tab as $key=>$value){
			$li=new Html('li');
			$a=new Html('a');
			$array=null;
			if (! is_array ( $value )) {
				$array ['id'] = $key;
				$array ['name'] = $value;
			} else {
				$array = $value;
			}
			if($key==0){
				$a->class='active';
			}
			$a->href="#tab_{$array ['id']}";
			$a->class="tab_item";
			$a->add(Lang::to($array['name']));
			$li->add($a);
			$ul->add($li);
		}
		$this->html->add($ul);
	}
	
	protected function forHtml(){
		foreach($this->array as $key=>$value){
			$div=new Html();
			$div->class='plane';
			$div->id="tab_$key";
			if($key>0){
				$div->class="hidden";
			}
			$div->add($value);
			$this->html->add($div);
		}
	}
}