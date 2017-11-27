<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_dev extends c_base {
	function index() {
		$uid = get_request('uid');
		$devtype = get_request('devtype',0,1);
		if($devtype == '') {
			$where = '1 = 1';
		}
		else {
			$where = "devtype = '$devtype'";
		}
/*
		$page_num = get_request('page');
		$row_num = $this->dev_set->select_count($where);

		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		*/
		
		$alldevice =  $this->dev_set->select_all('1', 'device_ip', 'asc');

		$out = array();
		$member = $this->member_set->select_by_id($uid);

		foreach($alldevice as $device) {
			$out[] = $device;
			if(strpos($member['devs'],','.$device['did'].',') === false) {
				$out[count($out)-1]['occupied'] = 0;
			}
			else {
				$out[count($out)-1]['occupied'] = 1;
			}
		}

		$this->assign("uid",$uid);
		$this->assign("alldev",$out);

		$this->display("usrdev_list.tpl");
	}


	function update_all() {
		$this->update_dev('session');
		$this->update_dev('ftp');
		$this->update_dev('rdp');
		$this->update_dev('sftp');
		$this->update_dev('vnc');
		$this->update_dev('http');
		$this->update_dev('as400');
		alert_and_back("更新成功");
	}

	function update_dev($type) {
		$where = " WHERE 1=1 ";
		switch($type) {
			case 'session':
				$modelset = $this->sessions_set;
				$data = 'addr';
				break;		
			case 'ftp':
				$modelset = $this->ftpsession_set;
				$data = 'svraddr';
				break; 
			case 'rdp':
				$modelset = $this->rdp_set;
				$data = 'addr';
				break;
			case 'sftp':
				$modelset = $this->sftpsession_set;
				$data = 'svraddr';
				break;
			case 'vnc':
				$modelset = $this->rdp_set;
				$where .= ' AND login_template=21';
				$data = 'addr';
				break;
			case 'http':
				$modelset = $this->rdp_set;
				$where .= ' AND login_template=14';
				$data = 'addr';
				break;
			case 'as400':
				$modelset = $this->AS400_sessions_set;
				$data = 'addr';
				break;
			default :
				printf('type error!!');
				return ;
		}

		$this->dev_set->delete2("devtype = '$type' ");
		$sql = "INSERT IGNORE INTO ".$this->dev_set->get_table_name()." (ip, devtype) SELECT $data, '$type' FROM ".$modelset->get_table_name()." ".$where." GROUP BY $data";
		$this->dev_set->query($sql);
		/*
		$page = 0;
		while(1){
			$sources = $modelset->select_limit($page*10000,10000,'1 = 1', $data);
			$ip = '';
			if(!empty($sources))
			foreach($sources as $source) {
				if($source[$data] == $ip) {
					continue;	
				}
				else {
					$ip = $source[$data];
					$newdev = new dev();
					$newdev->set_data('ip',$ip);
					$newdev->set_data('devtype',$type);
					$this->dev_set->add($newdev);
				}
			}
			else{
				break;
			}
			$page++;
		}
		*/
		
	}

	function modify($id) {

	}

	function modify_all() {
		$uid = get_request('uid');
		$dids = get_request('chk_member',1,1);
		$newmember = new member();
		$newmember->set_data('uid',$uid);
		if($dids)
		$newmember->set_data('devs',','.implode(',',$dids).',');
		$this->member_set->edit($newmember);
		alert_and_back('修改成功',"admin.php?controller=admin_dev&uid=$uid");
	}


}


?>