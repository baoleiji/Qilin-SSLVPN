<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_user extends c_base {
	function index() {
		
		$username = $this->getInput('username');		
		$query = ' 1=1';
		if($username){
			$query = " username='$username'";
		}
		$page_num = $this->getInput('page');
		$row_num = $this->user_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->user_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('all', $all);

		$this->display('user.tpl');
	}
	
	function add(){
		
		$allgroup = $this->servergroup_set->select_all();
		$this->assign('allgroup', $allgroup);
		$this->display('user_add.tpl');
	}
	
	function edit(){
		$userid = $_GET['userid'];
		$user = $this->user_set->select_all("userid = '$userid'");
		$user = $user[0];

		$user['hostlist'] = explode('||', $user['hostlist']);

		$temp = $user['hostlist'];	
		
		$allgroup = $this->servergroup_set->select_all();

		$n=count($temp);//
		if($n>0){//记录数大于0
			for($i=0;$i<$n;$i++){
				for($j=0;$j<count($allgroup);$j++){
					if($temp[$i]==$allgroup[$j]['id']){//id匹配
						$allgroup[$j]['tag'] = 1;
						break;
					}						
				}			
			}//for			
		}//if
	//	print_r($allgroup);
		//exit;
		//var_dump($user);
		$alluser = $this->user_set->select_all();
		$this->assign('allgroup', $allgroup);
		$this->assign('alluser', $alluser);
		$this->assign('user', $user);
		$this->display('user_edit.tpl');
	}
	
	function password() {
		$username = $_SESSION['ADMIN_USERNAME'];
		$olduser = $this->user_set->select_all("username = '$username'");
		$olduser = $olduser[0];
		$email = $olduser['email'];

		$this->assign('username', $username);
		$this->assign('email', $email);
		$this->display('password.tpl');
	}
	
	function savepass() {
		$newuser = new user();
		$username = get_request('username', 1, 1);
		$password1 = get_request('password1', 1, 1);
		$password2 = get_request('password2', 1, 1);
		$newuser->set_data('email', get_request('email', 1, 1));
		$newuser->set_data('username', $username);
		$olduser = $this->user_set->select_all("username = '$username'");
			if(!$olduser) {
				alert_and_back('该用户不存在!');
				exit();
			}
			$olduser = $olduser[0];

			if($password1 == "" && $password2 == "") {
				$newuser->set_data('password', $olduser['password']);
			}
			else {
				if($password1 == $password2) {
					$newuser->set_data('password', md5($password1));
				}
				else {
					alert_and_back('两次输入的密码不一致');
					exit();
				}
			}
			$newuser->set_data('userid', $olduser['userid']);
			$this->user_set->edit($newuser);
			alert_and_back('修改成功');
	}

	function save() {
		
		$type = get_request('type', 0, 1);
		$newuser = new user();
		$password1 = get_request('password1', 1, 1);
		$password2 = get_request('password2', 1, 1);
		if($type == 'edit') {
			$username = get_request('username', 1, 1);
			$newuser->set_data('username', $username);
			$olduser = $this->user_set->select_all("username = '$username'");
			if(!$olduser) {
				alert_and_back('该用户不存在!');
				exit();
			}
			$olduser = $olduser[0];

			if($password1 == "" && $password2 == "") {
				$newuser->set_data('password', $olduser['password']);
			}
			else {
				if($password1 == $password2) {
					$newuser->set_data('password', md5($password1));
				}
				else {
					alert_and_back('两次输入的密码不一致');
					exit();
				}
			}
			$newuser->set_data('userid', $olduser['userid']);
		}
		else {
			if($password1 == $password2) {
				$newuser->set_data('password', md5($password1));
			}
			else {
				alert_and_back('两次输入的密码不一致');
				exit();
			}
			$newuser->set_data('username', get_request('username', 1, 1));
		}

		$newuser->set_data('email', get_request('email', 1, 1));
		$newuser->set_data('level', get_request('level', 1));
		$newuser->set_data('desc', get_request('desc', 1,1));
		$grouplist = get_request('group', 1, 1);
		if($grouplist){
			
			$grouplist = array_unique($grouplist);
			for($i = 0; $i < count($grouplist); $i++) {
				if($grouplist[$i] == '') {
					unset($grouplist[$i]);
				}
			}
		
			$hostlist = implode('||', $grouplist);
			$newuser->set_data('hostlist', $hostlist);
		}
		
		
		if($newuser->get_errnum() == 0) {
			if($type == 'add') {
				if($this->user_set->select_all("username = '" . $newuser->get_data('username') . "'") == NULL) {
					$this->user_set->add($newuser);
				//	exit;
					alert_and_back('成功添加用户', 'admin.php?c=admin_user');
				}
				else {
					alert_and_back('该用户已存在!', NULL, 1);
					exit();
				}
			}
			else {
				$this->user_set->edit($newuser);
				alert_and_back('成功编辑用户', 'admin.php?c=admin_user');
			}
		}
		else {
			alert_and_back($newuser->get_firsterr(), NULL, 1);
			exit();
		}
	}

	function delete() {
		$userid = get_request('userid', 1);
		$this->user_set->delete($userid);
		alert_and_back('成功删除用户!');
	}
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);

		$idName = 'userid';
	
		$this->user_set->base_delete_all('user',$idName,$seq);
		alert_and_back('成功删除记录');
		
//		$userid = get_request('chk_user', 1, 1);
//		$this->user_set->delete($userid);
//		alert_and_back('成功删除所选用户!');
	}
}
?>
