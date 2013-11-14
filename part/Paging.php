<?php
/*分页组件*/
class Part_Paging extends Part{

	protected function init(){
		$this->style="paging";
		$this->url=true;
		$this->html=new Html('ul');
	}

	protected function getHtml(){
		$pages=ceil($this->array['count']/$this->array['num']);

		$n=($pages>5)?6:$pages+1;
		$m=0;
		for($i=0; $i<=$n; $i++){
			$li=new Html('li');
			$a=new Html('a');
			if($i==0){
				$str=new Html('span');
				$str->class="icon-step-backward";
				$m=1;
			}elseif($i>0 && $i<$n){
				if($pages==$n-1 || $this->page<=3){
					$str=$i;
				}elseif($n-$this->page<3){
					$str=$n-($n-$i);
				}else{
					$str=($this->page-2)+$i;
				}
				$m=$str;
			}else{
				$str=new Html('span');
				$str->class="icon-step-forward";
				$m=$n-1;
			}
			$id=empty($_GET['id'])?0:empty($_GET['id']);
			$url=URL::out($id,array("p=$m"));
			$a->href=$url;
			$a->add($str);
			$li->add($a);
			$this->html->add($li);
		}
	}
}

?>