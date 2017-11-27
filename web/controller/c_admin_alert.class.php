<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_alert extends c_base {
	function index() {
		$allalert = $this->alert_set->select_all();
		$config = $this->setting_set->select_all("sname = 'alert_interval' OR sname = 'alert_mail_title' OR sname = 'alert_mail_content' OR sname = 'mailserver' OR sname = 'user' OR sname = 'password'", 'sname');		
		//var_dump($config);
	//	print_r($config);
	//	exit;
		$this->assign('config', $config);
		$this->assign('allalert', $allalert);
		$this->display('alert.tpl');
		
	}

	function config() {
		$mailserver = $_POST['mailserver'];
		$user = $_POST['user'];
		$password = $_POST['password'];
		
		$alert_interval = $_POST['alert_interval'];
		$alert_mail_title = $_POST['alert_mail_title'];
		$alert_mail_content = $_POST['alert_mail_content'];
		
//		echo '1:'.$mailserver.'<br>';
//		echo '2:'.$user.'<br>';
//		echo '3:'.$password.'<br>';
//		echo '3:'.$alert_interval.'<br>';
		
		$this->setting_set->update("svalue", $mailserver, "sname = 'mailserver'");
		$this->setting_set->update("svalue", $user, "sname = 'user'");
		$this->setting_set->update("svalue", $password, "sname = 'password'");
		
		$this->setting_set->update("svalue", $alert_interval, "sname = 'alert_interval'");
		$this->setting_set->update("svalue", $alert_mail_title, "sname = 'alert_mail_title'");
		$this->setting_set->update("svalue", $alert_mail_content, "sname = 'alert_mail_content'");
		alert_and_back('修改告警配置成功!', 'admin.php?controller=admin_alert');
	}
	function save() {
		$type = get_request('type', 0, 1);
		$alert = new alert();
		if($type == 'edit') {
			$aid = get_request('aid', 1);
			$alert->set_data('aid', $aid);
		}
		$atype = get_request('atype', 1, 1);
		$avalue = get_request('avalue', 1, 1);
		$alert->set_data('atype', $atype);
		$alert->set_data('avalue', $avalue);
		//var_dump($alert);
		if($type == 'edit') {
			if($avalue == '') {
				$this->alert_set->delete($aid);
				alert_and_back('删除成功!', 'admin.php?controller=admin_alert');
			}
			else {
				$this->alert_set->edit($alert);
				alert_and_back('编辑成功!', 'admin.php?controller=admin_alert');
			}
		}
		else if($type == 'add') {
			if($avalue == '') {
				alert_and_back('告警内容不能为空!');
				exit();
			}
			else {
				$this->alert_set->add($alert);
				alert_and_back('添加成功!', 'admin.php?controller=admin_alert');
			}
		}
	}
}
?>
