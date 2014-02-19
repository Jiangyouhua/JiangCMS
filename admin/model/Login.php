<?php
class Admin_Model_Login extends Model {
	function handle() {
		$this->loginNum ();
		if ($this->data ['captcha'] != $_SESSION ['captcha']) {
			$this->back = false;
			return;
		}
		$re = Admin_Db_User::login ( $this->data ['name'], $this->data ['password'] );
		if (! $re) {
			$this->back = false;
			return;
		}
		/*写入session*/
		$this->session($re[0]);
		/*写入日志*/
		$this->log($re[0]);
		$this->back = true;
		return;
	}
	protected function loginNum() {
		if (empty ( $_SESSION ['login'] )) {
			$_SESSION ['login'] = 0;
		}
		$_SESSION ['login'] ++;
	}
	protected function session($re){
		$_SESSION['id']=$re['id'];
		$_SESSION['name']=$re['name'];
		$_SESSION['belong']=$re['belong'];
	}
	protected function log(){
		
	}
	function back() {
		if ($this->back) {
			$root = ROOT;
			header ( "location:{$root}admin/admin.php" );
		}else{
			parent::back();
		}
	}
}