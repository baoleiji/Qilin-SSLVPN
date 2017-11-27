<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_ccontrol extends c_base {
	function net_index() {

		$page_num = get_request('page');
		//$row_num = $this->acnetwork_set->select_count("1 = 1");
		$alluser = $this->acnetwork_set->select_all('1=1','groupname');
		$allgroup = array();
		$groupname = '';
		foreach($alluser as $acgroup) {
			if($acgroup['groupname'] != $groupname) {
				$groupname = $acgroup['groupname'];
				$allgroup[] = $acgroup;
			}
		}

		$row_num = count($allgroup);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('row_num', $row_num);
		$outuser = array_slice($allgroup,$newpager->intStartPosition,$newpager->intItemsPerPage);
/*
		$server = '/etc/freesvr/telnet_ssh.conf';
		if(file_exists($server)) {
			$source = file_get_contents($server);
			$lines = explode("\n",$source);
			
			foreach($lines as $line) {
				if(preg_match("/^autologin/",$line)) {
					$status = substr($line,strpos($line,'=')+1);
					break;
				}
			}
			if ($status == '1') {
				$status = '开启';
			}
			else {
				$status = '关闭';
			}
			
		}
		else {
			$status = "配置文件不存在";
		}
		$this->assign('status',$status);
		*/
		
		$this->assign("alluser",$outuser);
		$this->display("acgroup_list.tpl");

	}


	function net_detail() {
		$groupname = get_request("groupname",0,1);

		$page_num = get_request('page');
		$row_num = $this->acnetwork_set->select_count("groupname = '$groupname'");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('row_num', $row_num);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$alluser =  $this->acnetwork_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"groupname = '$groupname'");
		
		$this->assign("alluser",$alluser);
		$this->display("acgroup_detail.tpl");

	}

	function net_edit() {
		$type = get_request('type',0,1);
		$this->assign('type',$type);
		if ($type == 'new') {
			$this->assign('title',"添加新的网段");
			$this->assign('netmask',32);
			$groupname = get_request("groupname",0,1);
			$this->assign('groupname',$groupname);

		}
		else {
			$id = get_request('id');
			$this->assign('id',$id);
			$user = $this->acnetwork_set->select_by_id($id);
			$this->assign('addr',$user['ip']);
			$this->assign('groupname',$user['groupname']);
			$this->assign('netmask',$user['netmask']);
			$this->assign('title',"编辑网段信息");
		}
		$this->display('acgroup_edit.tpl');
	
	}

	function net_save() {
		$ntype = get_request('type',0,1);
		$addr = get_request('addr',1,1);
		$groupname = get_request('groupname',1,1);
		$netmask = get_request('netmask',1,0);

		$user = new acnetwork();
		$user->set_data('ip',$addr);
		$user->set_data('netmask',$netmask);
		$user->set_data('groupname',$groupname);

		if ($ntype == 'new') {
			if($this->acnetwork_set->select_count("groupname = '$groupname' and ip ='$addr'") == 0 ){
				$this->acnetwork_set->add($user);
				alert_and_back("添加成功",'admin.php?controller=admin_ccontrol&action=net_index');
			}
			else {
				alert_and_back("该组中已有此地址",'admin.php?controller=admin_ccontrol&action=net_index');
			}

		}
		else 	{
			$id= get_request('id');
			$user->set_data('id',$id);
			if($_SESSION['ADMIN_LEVEL'] == 0) {
				$old = $this->acnetwork_set->select_by_id($id);
					$user->set_data('ip',$old['ip']);
					$user->set_data('type',$old['type']);
					$user->set_data('netmask',$old['netmask']);
					$user->set_data('localuser',$old['localuser']);
			}
			$this->acnetwork_set->edit($user);
			alert_and_back("编辑成功",'admin.php?controller=admin_ccontrol&action=net_index');

		}
	}

	function net_del() {
		$id = get_request('id');
		$group = $this->acnetwork_set->select_by_id($id);
		if($this->acnetwork_set->select_count("groupname ='".$group['groupname']."'") == 1) {
			alert_and_back('还有用户属于此组,删除失败','admin.php?controller=admin_ccontrol&action=net_index');
		}
		else 
		{
			$type = get_request('type',0,1);
			if($type == 'group') {
				alert_and_back('本组还有成员,不能删除','admin.php?controller=admin_ccontrol&action=net_index');
			}
			else {
				$this->acnetwork_set->delete($id);
				alert_and_back('删除成功','admin.php?controller=admin_ccontrol&action=net_index');
			}
		}

	}

	function status() {
		$server = '/etc/freesvr/telnet_ssh.cfg';
		if(file_exists($server)) {
			$source = file_get_contents($server);
			$lines = explode("\n",$source);
			foreach($lines as $line) {
				if(preg_match("/^autologin/",$line)) {
					$status = substr($line,strpos($line,'=')+1);
					break;
				}
			}
			if ($status == '1') {
				$source = str_replace('autologin=1','autologin=0',$source);
				file_put_contents($server,$source);
				alert_and_back("该功能已关闭",'admin.php?controller=admin_ccontrol&action=net_index');

			}
			else {
				$source = str_replace('autologin=0','autologin=1',$source);
				file_put_contents($server,$source);
				alert_and_back("该功能已开启",'admin.php?controller=admin_ccontrol&action=net_index');

			}
			
		}
		else {
			alert_and_back("配置文件不存在",'admin.php?controller=admin_ccontrol&action=net_index');
		}
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

