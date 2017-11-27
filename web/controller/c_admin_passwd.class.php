<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_passwd extends c_base {
	function index() {
		$this->update_user();				
		$page_num = get_request('page');
		
		$row_num = $this->passwd_set->select_count();
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$allmember = $this->passwd_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);

		$this->assign('allmember', $allmember);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('passwd_list.tpl');
	}
	
	function add() {
		$this->display('passwd_add.tpl');
	}

	function edit() {
		$member = $this->passwd_set->select_by_id(get_request('uid'));
		$this->assign('member', $member);
		$this->assign('action', 'edit');
		$this->display('passwd_edit.tpl');
	}
	

	function save() {
		$allpasswd = $this->update_user();
		$type = get_request('type', 0, 1);
		$newmember = new passwd();
		$password1 = get_request('password1', 1, 1);
		$password2 = get_request('password2', 1, 1);
		$password = '';

		if($type == 'edit') {
			$uid = get_request('uid');
			$oldmember = $this->passwd_set->select_by_id($uid);
			$newmember->set_data('username', $oldmember['username']);
			$newmember->set_data('uid',$uid);
					
			if(!($password1 == "" && $password2 == "")) {
				if($password1 == $password2) {
					$password = $password1;
				}
				else {
					alert_and_back('两次输入的密码不一致');
					exit();
				}
			}
		}
		else {
			if($password1 == $password2) {
				$password = $password1;
			}
			else {
				alert_and_back('两次输入的密码不一致');
				exit();
			}
			$newmember->set_data('username', get_request('username', 1, 1));
		}



		if($newmember->get_errnum() == 0) {
			if($type == 'add') {
				if($this->passwd_set->select_all("username = '" . $newmember->get_data('username') . "'") == NULL && !in_array($newmember->get_data('username'), $allpasswd)) {
					$this->passwd_set->add($newmember);
					$out = '';
					command("sudo /usr/sbin/useradd ". $newmember->get_data('username'), $out);	
					command("echo \"$password\" | sudo passwd --stdin " . $newmember->get_data('username'), $out);	
					alert_and_back('成功添加用户', 'admin.php?controller=admin_passwd');
				}
				else {
					alert_and_back('该用户已存在', NULL, 1);
					exit();
				}
			}
			else {
				command("echo \"$password\" | sudo passwd --stdin " . $newmember->get_data('username'), $out);	
				alert_and_back('成功修改用户密码', 'admin.php?controller=admin_passwd');
			}
		}
		else {
			alert_and_back($newmember->get_firsterr(), NULL, 1);
			exit();
		}
	}

	function delete() {
		$this->update_user();
		$uid = get_request('uid');
		$member = $this->passwd_set->select_by_id($uid);
		$this->passwd_set->delete($uid);
		command("sudo /usr/sbin/userdel -r " . $member['username'], $out);	
		alert_and_back('成功删除用户');
	}
	
	function update_user() {
		$allmember = $this->passwd_set->select_all();
		$out = '';
		command("cat /etc/passwd |cut -f 1 -d :", $out);
		$allpasswd = explode("\n", $out);
		if($allmember) {
			foreach($allmember as $member) {
				if(!in_array($member['username'], $allpasswd)) {
					$this->passwd_set->delete($member['uid']);
				}
			}
		}
		return $allpasswd;
		
	}

	function delete_all() {
		$uids = get_request('chk_member', 1, 1);
		foreach($uids as $uid) {	
			$member = $this->passwd_set->select_by_id($uid);
			$this->passwd_set->delete($uid);
			command("sudo /usr/sbin/userdel -r " . $member['username'], $out);	
		}
		alert_and_back('成功删除所选用户');
	}
}
?>
