<?php
class Chat{
	
	static protected $map;
	protected $post;
	protected $online;
	
	function __construct(){
		self::$map=Init::getMap('user');
		$ini=new Ini(ONLINE);
		$this->online=$ini->read();
	}
	
	function run($post){
		$this->post=$post;
		if(empty($post['info'])){
			return $this->get();
		}
		return $this->set();
	}

	protected function get(){
		if(!isset($this->post['bool'])){
			return $this->update();
		}
		$re=$this->select();
		if(!$re){
			return null;
		}
		return $this->string($re);
	}

	protected function select(){
		$where=true;
		
		if(!empty($_SESSION['chat']) && !empty($this->post['bool'])){
			$where= "id > {$_SESSION['chat']['id']}";
		}
		
		$db=new Select('chat');
		$user="(user={$this->post['user']} AND user1={$_SESSION['id']})
		OR (user1={$this->post['user']} AND user={$_SESSION['id']})";
		if($this->post['user']==$_SESSION['id']){
			$user="user={$_SESSION['id']} OR user1={$_SESSION['id']}";
		}
		$db->setWhere("($user) AND menu={$this->post['menu']} AND $where AND status=1");
		return $db->fetchAll();
	}

	protected  function string($re){
		$string=null;
		$_SESSION['chat']=end($re);
		foreach ($re as $key=>$value){
			$user=self::$map[$value['user1']];
			$div=new Html();
			$div->class="chat_all{$value['user1']}";
			$span=new Html('span');
			$span->class="chat_user{$value['user1']}";
			if($value['user1']!=$_SESSION['id']){
				$a=new Html('a');
				$a->href="#";
				$a->onclick="chatuser({$value['user1']},'$user')";
				$icon=new Html('span');
				$icon->class="icon-user";
				$a->add($icon);
				if(in_array($user, $this->online)){
					$a->class='online';
				}
				$a->add($user);
				$span->add($a);
			}else{
				$span->add($user);
				$div->class='me';
			}
			$span->add("&nbsp;");
			$span->add($value['date']);
			$div->add($span);
				
			$span=new Html('span');
			$span->class="chat_info{$value['user1']}";
			$span->add($value['info']);
			$div->add($span);
			$string[]=$div->format();
		}
		$span=new Html('span');
		$span->class="chat_end";
		$span->add("<br><br><br>");
		$string[]=$span->format();
		
		return implode("", $string);
	}
	
	protected function set(){
		$db=new Insert('chat');
		$data=array(
				"menu"=>$this->post['menu'],
				"user"=>$this->post['user'],
				"user1"=>$_SESSION['id'],
				"info"=>$this->post['info'],
				'date'=>date("Y-m-d H:i:s"),
				'status'=>1
		);
		$db->setData($data);
		return $db->exec();
	}
	
	protected function update(){
		$db=new update("chat");
		$where="(user={$this->post['user']} AND user1={$_SESSION['id']}) 
		OR (user1={$this->post['user']} AND user={$_SESSION['id']})";
		$db->setWhere("menu={$this->post['menu']} AND $where AND status=1");
		$db->setSet("status=0");
		return $db->exec();
	}
}