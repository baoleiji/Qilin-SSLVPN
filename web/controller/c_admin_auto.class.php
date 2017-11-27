<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_auto extends c_base {

	function net_index() {
		$page_num = get_request('page');
		$uid = $uid = $_SESSION['ADMIN_UID'];
		$row_num = $this->netacl_set->select_count("uid = $uid");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('row_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$alluser =  $this->netacl_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"uid = $uid");

		
		$this->assign("alluser",$alluser);
		$this->display("alnet_list.tpl");

	}

	function aluser_edit() {
		$uid = $_SESSION['ADMIN_UID'];
		if($this->useracl_set->select_count("uid = $uid") > 0){
			$aluser = $this->useracl_set->select_all("uid = $uid");
			$aluser[0]['password'] = $aluser[0]['password'];
			$this->assign('aluser',$aluser[0]);
		}
		$this->display("aluser_edit.tpl");
		
	}

	function user_save() {
		$uid = $_SESSION['ADMIN_UID'];
		$username = get_request('remoteuser',1,1);
		$password = get_request('password',1,1);
		$newuser = new useracl();
		$newuser->set_data('remoteuser',$username);
		$newuser->set_data('password',$password);

		if($this->useracl_set->select_count("uid = $uid") > 0){
			$olduser = $this->useracl_set->select_all("uid = $uid");
			$newuser->set_data('id',$olduser[0]['id']);
			$this->useracl_set->edit($newuser);
		}
		else {
			$newuser->set_data('uid',$uid);
			$this->useracl_set->add($newuser);
		}
		alert_and_back("编辑成功","admin.php?controller=admin_member&action=edit_self");
	}

	function alnet_edit() {
		$ntype = get_request("ntype",0,1);
		$id = get_request("id");
		if($ntype == 'new') {
			;
		}
		else {
			$aluser = $this->netacl_set->select_by_id($id);
			$aluser['password'] = $aluser['password'];
			$this->assign('aluser',$aluser);
		}
		$this->assign('ntype',$ntype);
		$this->display("alnet_edit.tpl");
		
	}

	function alnet_del() {
		$id = get_request("id");
		$aluser = $this->netacl_set->delete($id);
		alert_and_back("删除成功","admin.php?controller=admin_auto&action=net_index");
		
	}

	function net_save() {
		$uid = $_SESSION['ADMIN_UID'];
		$username = get_request('remoteuser',1,1);
		$password = get_request('password',1,1);
		$ip = get_request('ip',1,1);
		$netmask = get_request('netmask',1,0);

		$newuser = new netacl();
		$newuser->set_data('remoteuser',$username);
		$newuser->set_data('ip',$ip);
		$newuser->set_data('netmask',$netmask);
		$newuser->set_data('password',$password);
		$ntype = get_request("ntype",0,1);
		$id = get_request("id");
		if($ntype == 'new') {
			$newuser->set_data('uid',$uid);
			$this->netacl_set->add($newuser);
		}
		else {
			$newuser->set_data('id',$id);
			$this->netacl_set->edit($newuser);

		}
		alert_and_back("编辑成功","admin.php?controller=admin_auto&action=net_index");
	}

	function encryp($code) {
		$chars = preg_split('//', $code, -1, PREG_SPLIT_NO_EMPTY);
		$i=10;
		$result = array();
		foreach($chars as $char) {
			
			$result[] = ord($char) ^ $i;
			$i++;
		}
		$string = '';
		foreach($result as $char) {
			$string.= chr($char);
		}
		return $string;
	}

}

