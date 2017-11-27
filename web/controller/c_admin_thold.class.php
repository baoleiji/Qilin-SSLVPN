<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}
class c_admin_thold extends c_base {

	function index(){
		$this->snmp_server_policy();
	}

	function snmp_server_policy(){
		$ip = get_request('ip', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		
		if(empty($orderby1)){
			$orderby1 = 'name';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$total_page = $this->snmp_server_policy_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->snmp_server_policy_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby1,$orderby2);

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);		
		$this->display('snmp_server_policy.tpl');
	}

	function snmp_server_policy_del(){
		$id = get_request('id');
		$this->snmp_server_policy_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=snmp_server_policy');
	}

	function snmp_server_policy_edit(){
		$id = get_request('id');
		$thold = $this->snmp_server_policy_set->select_by_id($id);
		$this->assign("thold", $thold);
		$this->display('snmp_server_policy_edit.tpl');
	}

	function snmp_server_policy_save(){
		$id = get_request('id');
		$name = get_request('name', 1, 1);
		$cpurrd = get_request('cpurrd', 1, 0);
		$cpuiorrd = get_request('cpuiorrd', 1, 0);
		$mail_alarm = get_request('mail_alarm', 1, 0);
		$sms_alarm = get_request('sms_alarm', 1, 0);
		$memoryrrd = get_request('memoryrrd', 1, 0);
		$swaprrd = get_request('swaprrd', 1, 0);
		$diskrrd = get_request('diskrrd', 1, 0);
		$cpuhigh = get_request('cpuhigh', 1, 1);
		$cpulow = get_request('cpulow', 1, 1);
		$cpuiohigh = get_request('cpuiohigh', 1, 1);
		$cpuiolow = get_request('cpuiolow', 1, 1);
		$memoryhigh = get_request('memoryhigh', 1, 1);
		$memorylow = get_request('memorylow', 1, 1);
		$swaphigh = get_request('swaphigh', 1, 1);
		$swaplow = get_request('swaplow', 1, 1);
		$diskhigh = get_request('diskhigh', 1, 1);
		$disklow = get_request('disklow', 1, 1);
		$snmp_server_policy = new snmp_server_policy();
		$snmp_server_policy->set_data('id', $id);
		$snmp_server_policy->set_data('name', $name);
		$snmp_server_policy->set_data('cpurrd', $cpurrd);
		$snmp_server_policy->set_data('cpuiorrd', $cpuiorrd);
		$snmp_server_policy->set_data('mail_alarm', $mail_alarm);
		$snmp_server_policy->set_data('sms_alarm', $sms_alarm);
		$snmp_server_policy->set_data('memoryrrd', $memoryrrd);
		$snmp_server_policy->set_data('swaprrd', $swaprrd);
		$snmp_server_policy->set_data('diskrrd', $diskrrd);
		$snmp_server_policy->set_data('cpuhigh', $cpuhigh);
		$snmp_server_policy->set_data('cpulow', $cpulow);
		$snmp_server_policy->set_data('cpuiohigh', $cpuiohigh);
		$snmp_server_policy->set_data('cpuiolow', $cpuiolow);
		$snmp_server_policy->set_data('memoryhigh', $memoryhigh);
		$snmp_server_policy->set_data('memorylow', $memorylow);
		$snmp_server_policy->set_data('swaphigh', $swaphigh);
		$snmp_server_policy->set_data('swaplow', $swaplow);
		$snmp_server_policy->set_data('diskhigh', $diskhigh);
		$snmp_server_policy->set_data('disklow', $disklow);
		if($id){
			$this->snmp_server_policy_set->edit($snmp_server_policy);
		}else{
			$this->snmp_server_policy_set->add($snmp_server_policy);
		}
		
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=snmp_server_policy');
	}

	function snmp_server_policy_set(){
		$id = get_request('id');
		$thold = $this->snmp_server_policy_set->select_by_id($id);
		$servergroup = $this->sgroup_set->select_all();
		$this->assign("thold", $thold);
		$this->assign("servergroup", $servergroup);
		$this->display('snmp_server_policy_set.tpl');
	}

	function snmp_server_policy_set_save(){
		$id = get_request('id');
		$thold = $this->snmp_server_policy_set->select_by_id($id);//var_dump($_POST['Group']);
		if(!empty($_POST['Group'])){
			$sql = "UPDATE ".$this->snmp_status_set->get_table_name()." SET highvalue='".$thold['cpuhigh']."',lowvalue='".$thold['cpulow']."',`enable`='".$thold['cpurrd']."' WHERE type='cpu' AND device_ip IN(SELECT device_ip FROM ".$this->server_set->get_table_name()." WHERE groupid IN(".implode(',',$_POST['Group'])."))";
			$this->server_set->query($sql);
			$sql = "UPDATE ".$this->snmp_status_set->get_table_name()." SET highvalue='".$thold['cpuiohigh']."',lowvalue='".$thold['cpuiolow']."',`enable`='".$thold['cpuiorrd']."' WHERE type='cpu_io' AND device_ip IN(SELECT device_ip FROM ".$this->server_set->get_table_name()." WHERE groupid IN(".implode(',',$_POST['Group'])."))";
			$this->server_set->query($sql);
			$sql = "UPDATE ".$this->snmp_status_set->get_table_name()." SET highvalue='".$thold['memoryhigh']."',lowvalue='".$thold['memorylow']."',`enable`='".$thold['memoryrrd']."' WHERE type='memory' AND device_ip IN(SELECT device_ip FROM ".$this->server_set->get_table_name()." WHERE groupid IN(".implode(',',$_POST['Group'])."))";
			$this->server_set->query($sql);
			$sql = "UPDATE ".$this->snmp_status_set->get_table_name()." SET highvalue='".$thold['swaphigh']."',lowvalue='".$thold['swaplow']."',`enable`='".$thold['swaprrd']."' WHERE type='swap' AND device_ip IN(SELECT device_ip FROM ".$this->server_set->get_table_name()." WHERE groupid IN(".implode(',',$_POST['Group'])."))";
			$this->server_set->query($sql);
			$sql = "UPDATE ".$this->snmp_status_set->get_table_name()." SET highvalue='".$thold['diskhigh']."',lowvalue='".$thold['disklow']."',`enable`='".$thold['diskrrd']."' WHERE type='disk' AND device_ip IN(SELECT device_ip FROM ".$this->server_set->get_table_name()." WHERE groupid IN(".implode(',',$_POST['Group'])."))";
			$this->server_set->query($sql);
			//echo "UPDATE ".$this->snmp_status_set->get_table_name()." SET alarm=(SELECT alarm FROM ".$this->snmp_server_policy_set->get_table_name()." WHERE id='".$id."' limit 1) WHERE device_ip IN(select device_ip FROM ".$this->server_set->get_table_name()." WHERE groupid IN(".implode(',',$_POST['Group'])."))";
			$this->snmp_server_policy_set->query("UPDATE ".$this->snmp_status_set->get_table_name()." SET sms_alarm=(SELECT sms_alarm FROM ".$this->snmp_server_policy_set->get_table_name()." WHERE id='".$id."' limit 1),mail_alarm=(SELECT mail_alarm FROM ".$this->snmp_server_policy_set->get_table_name()." WHERE id='".$id."' limit 1) WHERE device_ip IN(select device_ip FROM ".$this->server_set->get_table_name()." WHERE groupid IN(".implode(',',$_POST['Group'])."))");
		}
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=snmp_server_policy');
	}


	function snmp_interface_policy(){
		$ip = get_request('ip', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		
		if(empty($orderby1)){
			$orderby1 = 'name';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$total_page = $this->snmp_interface_policy_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->snmp_interface_policy_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby1,$orderby2);

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);		
		$this->display('snmp_interface_policy.tpl');
	}

	function snmp_interface_policy_del(){
		$id = get_request('id');
		$this->snmp_interface_policy_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=snmp_interface_policy');
	}

	function snmp_interface_policy_edit(){
		$id = get_request('id');
		$thold = $this->snmp_interface_policy_set->select_by_id($id);
		$this->assign("thold", $thold);
		$this->display('snmp_interface_policy_edit.tpl');
	}

	function snmp_interface_policy_save(){
		$id = get_request('id');
		$name = get_request('name', 1, 1);		
		$mail_alarm = get_request('mail_alarm', 1, 0);
		$sms_alarm = get_request('sms_alarm', 1, 0);
		$enable = get_request('enable', 1, 0);
		$trfficrrd = get_request('trfficrrd', 1, 0);
		$packetrrd = get_request('packetrrd', 1, 0);
		$errorrrd = get_request('errorrrd', 1, 0);
		$trfficinhigh = get_request('trfficinhigh', 1, 1);
		$trfficinlow = get_request('trfficinlow', 1, 1);
		$trfficouthigh = get_request('trfficouthigh', 1, 1);
		$trfficoutlow = get_request('trfficoutlow', 1, 1);
		$packetinhigh = get_request('packetinhigh', 1, 1);
		$packetinlow = get_request('packetinlow', 1, 1);
		$packetouthigh = get_request('packetouthigh', 1, 1);
		$packetoutlow = get_request('packetoutlow', 1, 1);
		$errorinhigh = get_request('errorinhigh', 1, 1);
		$errorinlow = get_request('errorinlow', 1, 1);
		$errorouthigh = get_request('errorouthigh', 1, 1);
		$erroroutlow = get_request('erroroutlow', 1, 1);
		$snmp_interface_policy = new snmp_interface_policy();
		$snmp_interface_policy->set_data('id', $id);
		$snmp_interface_policy->set_data('name', $name);
		$snmp_interface_policy->set_data('mail_alarm', $mail_alarm);
		$snmp_interface_policy->set_data('sms_alarm', $sms_alarm);
		$snmp_interface_policy->set_data('enable', $enable);
		$snmp_interface_policy->set_data('trfficrrd', $trfficrrd);
		$snmp_interface_policy->set_data('packetrrd', $packetrrd);
		$snmp_interface_policy->set_data('errorrrd', $errorrrd);
		$snmp_interface_policy->set_data('trfficinhigh', $trfficinhigh);
		$snmp_interface_policy->set_data('trfficinlow', $trfficinlow);
		$snmp_interface_policy->set_data('trfficouthigh', $trfficouthigh);
		$snmp_interface_policy->set_data('trfficoutlow', $trfficoutlow);
		$snmp_interface_policy->set_data('packetinhigh', $packetinhigh);
		$snmp_interface_policy->set_data('packetinlow', $packetinlow);
		$snmp_interface_policy->set_data('packetouthigh', $packetouthigh);
		$snmp_interface_policy->set_data('packetoutlow', $packetoutlow);
		$snmp_interface_policy->set_data('errorinhigh', $errorinhigh);
		$snmp_interface_policy->set_data('errorinlow', $errorinlow);
		$snmp_interface_policy->set_data('errorouthigh', $errorouthigh);
		$snmp_interface_policy->set_data('erroroutlow', $erroroutlow);
		if($id){
			$this->snmp_interface_policy_set->edit($snmp_interface_policy);
		}else{
			$this->snmp_interface_policy_set->add($snmp_interface_policy);
		}
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=snmp_interface_policy');
	}

	function snmp_interface_policy_set(){
		$id = get_request('id');
		$thold = $this->snmp_interface_policy_set->select_by_id($id);
		$servergroup = $this->sgroup_set->select_all();
		$this->assign("thold", $thold);
		$this->assign("servergroup", $servergroup);
		$this->display('snmp_interface_policy_set.tpl');
	}

	function snmp_interface_policy_set_save(){
		$id = get_request('id');
		$thold = $this->snmp_interface_policy_set->select_by_id($id);//var_dump($_POST['Group']);
		if(!empty($_POST['Group'])){
			$sql = "UPDATE ".$this->snmp_interface_set->get_table_name()." SET `mail_alarm`='".$thold['mail_alarm']."',`sms_alarm`='".$thold['sms_alarm']."',`traffic_RRD`='".$thold['trfficrrd']."',`packet_RRD`='".$thold['packetrrd']."',`err_packet_RRD`='".$thold['errorrrd']."',traffic_in_lowvalue='".$thold['trfficinlow']."',traffic_in_highvalue='".$thold['trfficinhigh']."',traffic_out_lowvalue='".$thold['trfficoutlow']."',traffic_out_highvalue='".$thold['trfficouthigh']."' ,packet_in_lowvalue='".$thold['packetinlow']."',packet_in_highvalue='".$thold['packetinhigh']."',packet_out_lowvalue='".$thold['packetoutlow']."',packet_out_highvalue='".$thold['packetouthigh']."',err_packet_in_lowvalue='".$thold['errorinlow']."',err_packet_in_highvalue='".$thold['errorinhigh']."',err_packet_out_lowvalue='".$thold['erroroutlow']."',err_packet_out_highvalue='".$thold['errorouthigh']."' WHERE device_ip IN(SELECT device_ip FROM ".$this->server_set->get_table_name()." WHERE groupid IN(".implode(',',$_POST['Group'])."))";
			$this->server_set->query($sql);
		}
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=snmp_interface_policy');
	}

	function status_thold(){
		$ip = get_request('ip', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		if($ip == '') {
			if($ip != '') {
				$where .= " AND device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND device_ip LIKE '%$ip%'";
		}
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		if($_POST['edit']=='修改'){//echo '<pre>';var_dump($_POST);echo '</pre>';
			for($i=0; $i<count($_POST['seq']); $i++){
				$system_status = new snmp_status();
				$system_status->set_data('seq',  $_POST['seq'][$i]);
				$system_status->set_data('enable', intval($_POST['enable'.$_POST['seq'][$i]]));
				$system_status->set_data('lowvalue', $_POST['lowvalue'][$i]);
				$system_status->set_data('highvalue', $_POST['highvalue'][$i]);
				$this->snmp_status_set->edit($system_status);
				$system_status=null;
				//$sql = "UPDATE ".$this->snmp_status_set->get_table_name()." SET enable='".$_POST['enable'][$i]."',lowvalue='".$_POST['lowvalue'][$i]."',highvalue='".$_POST['highvalue'][$i]."'";
			}
			alert_and_back('操作成功');
			exit;
		}

		$total_page = $this->snmp_status_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->snmp_status_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby1,$orderby2);

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("ip", $ip);
		$this->display('status_thold.tpl');
	}

	function status_thold_edit(){
		$id = get_request('id');
		$ip = get_request('ip', 0, 1);
		$thold = $this->snmp_status_set->select_by_id($id);
		$this->assign('thold', $thold);
		$this->assign('ip', $ip);
		$this->display('status_thold_edit.tpl');
	}

	function status_thold_save(){
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$ip = get_request('ip', 0, 1);
		$mail_alarm = get_request('mail_alarm', 1, 1);
		$sms_alarm = get_request('sms_alarm', 1, 1);
		$type = get_request('type', 1, 1);
		$value = get_request('value', 1, 1);
		$disk = get_request('disk', 1, 1);
		$enable = get_request('enable', 1, 1);
		$rrdfile = get_request('rrdfile', 1, 1);
		$send_interval = get_request('send_interval', 1, 1);
		$lowvalue = get_request('lowvalue', 1, 1);
		$highvalue = get_request('highvalue', 1, 1);
		$system_status = new snmp_status();
		$system_status->set_data('seq', $id);
		$system_status->set_data('enable', $enable);
		$system_status->set_data('lowvalue', $lowvalue);
		$system_status->set_data('highvalue', $highvalue);
		$system_status->set_data('mail_alarm', $mail_alarm);
		$system_status->set_data('sms_alarm', $sms_alarm);
		$system_status->set_data('type', $type);
		$system_status->set_data('value', $value);
		$system_status->set_data('disk', $disk);
		$system_status->set_data('enable', $enable);
		$system_status->set_data('rrdfile', $rrdfile);
		$system_status->set_data('send_interval', $send_interval);
		$this->snmp_status_set->edit($system_status);
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=status_thold&from='.$from.'&ip='.$ip);
	}

	function status_thold_delete(){
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$ip = get_request('ip', 0, 1);
		if(empty($id)){
			$id= $_POST['chk_member'];
		}
		$thold = $this->snmp_status_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=status_thold&from='.$from.'&ip='.$ip);
	}

	function interface_thold(){
		$ip = get_request('ip', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		if($ip == '') {
			if($ip != '') {
				$where .= " AND device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND device_ip LIKE '%$ip%'";
		}
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		if($_POST['edit']=='修改'){//echo '<pre>';var_dump($_POST);echo '</pre>';
			for($i=0; $i<count($_POST['seq']); $i++){
				$snmp_interface = new snmp_interface();
				$snmp_interface->set_data('id',  $_POST['seq'][$i]);
				$snmp_interface->set_data('enable', intval($_POST['enable'.$_POST['seq'][$i]]));
				$snmp_interface->set_data('traffic_in_lowvalue', $_POST['traffic_in_lowvalue'][$i]);
				$snmp_interface->set_data('traffic_in_highvalue', $_POST['traffic_in_highvalue'][$i]);
				$snmp_interface->set_data('traffic_out_lowvalue', $_POST['traffic_out_lowvalue'][$i]);
				$snmp_interface->set_data('traffic_out_highvalue', $_POST['traffic_out_highvalue'][$i]);
				$snmp_interface->set_data('packet_in_lowvalue', $_POST['packet_in_lowvalue'][$i]);
				$snmp_interface->set_data('packet_in_highvalue', $_POST['packet_in_highvalue'][$i]);
				$snmp_interface->set_data('packet_out_lowvalue', $_POST['packet_out_lowvalue'][$i]);
				$snmp_interface->set_data('packet_out_highvalue', $_POST['packet_out_highvalue'][$i]);
				$snmp_interface->set_data('err_packet_in_lowvalue', $_POST['err_packet_in_lowvalue'][$i]);
				$snmp_interface->set_data('err_packet_in_highvalue', $_POST['err_packet_in_highvalue'][$i]);
				$snmp_interface->set_data('err_packet_out_lowvalue', $_POST['err_packet_out_lowvalue'][$i]);
				$snmp_interface->set_data('err_packet_out_highvalue', $_POST['err_packet_out_highvalue'][$i]);
				$snmp_interface->set_data('traffic_RRD', intval($_POST['traffic_RRD'.$_POST['seq'][$i]]));
				$snmp_interface->set_data('packet_RRD', intval($_POST['packet_RRD'.$_POST['seq'][$i]]));
				$snmp_interface->set_data('err_packet_RRD', intval($_POST['err_packet_RRD'.$_POST['seq'][$i]]));
				$this->snmp_interface_set->edit($snmp_interface);
				$snmp_interface=null;
				//$sql = "UPDATE ".$this->snmp_status_set->get_table_name()." SET enable='".$_POST['enable'][$i]."',lowvalue='".$_POST['lowvalue'][$i]."',highvalue='".$_POST['highvalue'][$i]."'";
			}
			alert_and_back('操作成功');
			exit;
		}

		$total_page = $this->snmp_interface_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->snmp_interface_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby1,$orderby2);

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('interface_thold.tpl');
	}

	function interface_thold_edit(){
		$id = get_request('id');
		$thold = $this->snmp_interface_set->select_by_id($id);
		$this->assign('thold', $thold);
		$this->display('interface_thold_edit.tpl');
	}

	function interface_thold_save(){
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$mail_alarm = get_request('mail_alarm', 1, 1);
		$sms_alarm = get_request('sms_alarm', 1, 1);
		$port_index = get_request('port_index', 1, 1);
		$port_describe = get_request('port_describe', 1, 1);
		$port_type = get_request('port_type', 1, 1);
		$port_speed = get_request('port_speed', 1, 1);
		$normal_status = get_request('normal_status', 1, 1);
		$cur_status = get_request('cur_status', 1, 1);
		$connectdevice = get_request('connectdevice', 1, 1);
		$connectdeviceport = get_request('connectdeviceport', 1, 1);
		$connectport = get_request('connectport', 1, 1);
		$traffic_in_lowvalue = get_request('traffic_in_lowvalue', 1, 1);
		$traffic_in_highvalue = get_request('traffic_in_highvalue', 1, 1);
		$traffic_out_lowvalue = get_request('traffic_out_lowvalue', 1, 1);
		$traffic_out_highvalue = get_request('traffic_out_highvalue', 1, 1);
		$packet_in_lowvalue = get_request('packet_in_lowvalue', 1, 1);
		$packet_in_highvalue = get_request('packet_in_highvalue', 1, 1);
		$packet_out_lowvalue = get_request('packet_out_lowvalue', 1, 1);
		$packet_out_highvalue = get_request('packet_out_highvalue', 1, 1);
		$err_packet_in_lowvalue = get_request('err_packet_in_lowvalue', 1, 1);
		$err_packet_in_highvalue = get_request('err_packet_in_highvalue', 1, 1);
		$err_packet_out_lowvalue = get_request('err_packet_out_lowvalue', 1, 1);
		$err_packet_out_highvalue = get_request('err_packet_out_highvalue', 1, 1);
		$traffic_RRD = get_request('traffic_RRD', 1, 1);
		$packet_RRD = get_request('packet_RRD', 1, 1);
		$err_packet_RRD = get_request('err_packet_RRD', 1, 1);
		$trafffic_rrdfile = get_request('trafffic_rrdfile', 1, 1);
		$packet_rrdfile = get_request('packet_rrdfile', 1, 1);
		$err_packet_rrdfile = get_request('err_packet_rrdfile', 1, 1);
		$enable = get_request('enable', 1, 1);


		$snmp_interface = new snmp_interface();
		$snmp_interface->set_data('id', $id);
		$snmp_interface->set_data('enable', $enable);
		$snmp_interface->set_data('port_describe', $port_describe);
		$snmp_interface->set_data('port_index', $port_index);
		$snmp_interface->set_data('port_type', $port_type);
		$snmp_interface->set_data('port_speed', $port_speed);
		$snmp_interface->set_data('normal_status', $normal_status);
		$snmp_interface->set_data('cur_status', $cur_status);
		$snmp_interface->set_data('connectdevice', $connectdevice);
		$snmp_interface->set_data('connectdeviceport', $connectdeviceport);
		$snmp_interface->set_data('connectport', $connectport);
		$snmp_interface->set_data('traffic_in_lowvalue', $traffic_in_lowvalue);
		$snmp_interface->set_data('traffic_in_highvalue', $traffic_in_highvalue);
		$snmp_interface->set_data('traffic_out_lowvalue', $traffic_out_lowvalue);
		$snmp_interface->set_data('traffic_out_highvalue', $traffic_out_highvalue);
		$snmp_interface->set_data('packet_in_lowvalue', $packet_in_lowvalue);
		$snmp_interface->set_data('packet_in_highvalue', $packet_in_highvalue);
		$snmp_interface->set_data('packet_out_lowvalue', $packet_out_lowvalue);
		$snmp_interface->set_data('packet_out_highvalue', $packet_out_highvalue);
		$snmp_interface->set_data('err_packet_in_lowvalue', $err_packet_in_lowvalue);
		$snmp_interface->set_data('err_packet_in_highvalue', $err_packet_in_highvalue);
		$snmp_interface->set_data('err_packet_out_lowvalue', $err_packet_out_lowvalue);
		$snmp_interface->set_data('err_packet_out_highvalue', $err_packet_out_highvalue);
		$snmp_interface->set_data('traffic_RRD', $traffic_RRD);
		$snmp_interface->set_data('packet_RRD', $packet_RRD);
		$snmp_interface->set_data('err_packet_RRD', $err_packet_RRD);
		$snmp_interface->set_data('trafffic_rrdfile', $trafffic_rrdfile);
		$snmp_interface->set_data('packet_rrdfile', $packet_rrdfile);
		$snmp_interface->set_data('err_packet_rrdfile', $err_packet_rrdfile);
		$snmp_interface->set_data('mail_alarm', $mail_alarm);
		$snmp_interface->set_data('sms_alarm', $sms_alarm);
		$this->snmp_interface_set->edit($snmp_interface);
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=interface_thold&from='.$from);
	}

	function interface_thold_delete(){
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		if(empty($id)){
			$id= $_POST['chk_member'];
		}
		$thold = $this->snmp_interface_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=interface_thold&from='.$from);
	}

	function app_thold(){
		$ip = get_request('ip', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		if($ip == '') {
			if($ip != '') {
				$where .= " AND device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND device_ip LIKE '%$ip%'";
		}
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		if($_POST['edit']=='修改'){//echo '<pre>';var_dump($_POST);echo '</pre>';
			for($i=0; $i<count($_POST['seq']); $i++){
				$system_status = new app_status();
				$system_status->set_data('seq',  $_POST['seq'][$i]);
				$system_status->set_data('enable', intval($_POST['enable'.$_POST['seq'][$i]]));
				$system_status->set_data('lowvalue', $_POST['lowvalue'][$i]);
				$system_status->set_data('highvalue', $_POST['highvalue'][$i]);
				$this->app_status_set->edit($system_status);
				$system_status=null;
				//$sql = "UPDATE ".$this->snmp_status_set->get_table_name()." SET enable='".$_POST['enable'][$i]."',lowvalue='".$_POST['lowvalue'][$i]."',highvalue='".$_POST['highvalue'][$i]."'";
			}
			alert_and_back('操作成功');
			exit;
		}

		$total_page = $this->app_status_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->app_status_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby1,$orderby2);

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('app_thold.tpl');
	}

	function app_thold_edit(){
		$id = get_request('id');
		$thold = $this->app_status_set->select_by_id($id);
		$this->assign('thold', $thold);
		$this->display('app_thold_edit.tpl');
	}

	function app_thold_save(){
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$mail_alarm = get_request('mail_alarm', 1, 1);
		$sms_alarm = get_request('sms_alarm', 1, 1);
		$app_type = get_request('app_type', 1, 1);
		$value = get_request('value', 1, 1);
		$app_name = get_request('app_name', 1, 1);
		$enable = get_request('enable', 1, 1);
		$rrdfile = get_request('rrdfile', 1, 1);
		$lowvalue = get_request('lowvalue', 1, 1);
		$highvalue = get_request('highvalue', 1, 1);
		$system_status = new app_status();
		$system_status->set_data('seq', $id);
		$system_status->set_data('enable', $enable);
		$system_status->set_data('lowvalue', $lowvalue);
		$system_status->set_data('highvalue', $highvalue);
		$system_status->set_data('mail_alarm', $mail_alarm);
		$system_status->set_data('sms_alarm', $sms_alarm);
		$system_status->set_data('app_type', $app_type);
		$system_status->set_data('value', $value);
		$system_status->set_data('app_name', $app_name);
		$system_status->set_data('enable', $enable);
		$system_status->set_data('rrdfile', $rrdfile);
		$this->app_status_set->edit($system_status);
		$thold = $this->app_status_set->select_by_id($id);
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=app_thold&from='.$from.($from=='hostview' ? '&ip='.$thold['device_ip'] : ''));
	}

	function dns_thold(){
		$ip = get_request('ip', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		if($ip == '') {
			if($ip != '') {
				$where .= " AND device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND device_ip LIKE '%$ip%'";
		}
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		if($_POST['edit']=='修改'){//echo '<pre>';var_dump($_POST);echo '</pre>';
			for($i=0; $i<count($_POST['seq']); $i++){
				$system_status = new dns_monitor();
				$system_status->set_data('id',  $_POST['seq'][$i]);
				$system_status->set_data('enable', intval($_POST['enable'.$_POST['seq'][$i]]));
				$system_status->set_data('lowvalue', $_POST['lowvalue'][$i]);
				$system_status->set_data('highvalue', $_POST['highvalue'][$i]);
				$this->dns_monitor_set->edit($system_status);
				$system_status=null;
				//$sql = "UPDATE ".$this->snmp_status_set->get_table_name()." SET enable='".$_POST['enable'][$i]."',lowvalue='".$_POST['lowvalue'][$i]."',highvalue='".$_POST['highvalue'][$i]."'";
			}
			alert_and_back('操作成功');
			exit;
		}

		$total_page = $this->dns_monitor_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->dns_monitor_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby1,$orderby2);
		for($i=0; $i<count($tholdlist); $i++){
			$tholdlist[$i]['delayvalue']="<a href=\"#\" onclick=\"return showImg('".$tholdlist[$i]['device_ip'].' '.$tholdlist[$i]['type']."',event,".$tholdlist[$i]['id'].");return false;\" >".$tholdlist[$i]['delayvalue'].'</a>';
		}

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('dns_thold.tpl');
	}

	function dns_thold_edit(){
		$id = get_request('id');
		$thold = $this->dns_monitor_set->select_by_id($id);
		$this->assign('thold', $thold);
		$this->display('dns_thold_edit.tpl');
	}

	function dns_thold_save(){
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$mail_alarm = get_request('mail_alarm', 1, 1);
		$sms_alarm = get_request('sms_alarm', 1, 1);
		$app_type = get_request('app_type', 1, 1);
		$value = get_request('value', 1, 1);
		$app_name = get_request('app_name', 1, 1);
		$enable = get_request('enable', 1, 1);
		$rrdfile = get_request('rrdfile', 1, 1);
		$lowvalue = get_request('lowvalue', 1, 1);
		$highvalue = get_request('highvalue', 1, 1);
		$system_status = new dns_monitor();
		$system_status->set_data('id', $id);
		$system_status->set_data('enable', $enable);
		$system_status->set_data('lowvalue', $lowvalue);
		$system_status->set_data('highvalue', $highvalue);
		$system_status->set_data('mail_alarm', $mail_alarm);
		$system_status->set_data('sms_alarm', $sms_alarm);
		$system_status->set_data('delayvalue', $value);
		$system_status->set_data('enable', $enable);
		$system_status->set_data('rrdfile', $rrdfile);
		$this->dns_monitor_set->edit($system_status);
		$thold = $this->dns_monitor_set->select_by_id($id);
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=dns_thold&from='.$from.($from=='hostview' ? '&ip='.$thold['device_ip'] : ''));
	}

	function snmp_alert(){
		$ip = get_request('ip', 0, 1);
		$name = get_request('name', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		
		if(empty($orderby1)){
			$orderby1 = 'name';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		if($name){
			$where .= " AND name like '%$name%'";
		}

		$total_page = $this->snmp_alert_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->snmp_alert_set->base_select("SELECT a.*,c.groupname FROM ".$this->snmp_alert_set->get_table_name()." a  LEFT JOIN ".$this->sgroup_set->get_table_name()." c ON a.groupid=c.id WHERE $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);		
		$this->display('snmp_alert.tpl');
	}

	function snmp_alert_edit(){
		$id = get_request('id');
		$alert = $this->snmp_alert_set->select_by_id($id);
		$allmem = $this->member_set->select_all(' level!=11', 'username', 'asc');
		$group = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		$banduser = $this->snmp_alert_user_set->select_all("snmp_alert_id='$id'");
		for($i=0; $i<count($allmem); $i++){
			for($j=0; $j<count($banduser); $j++){
				if($allmem[$i]['uid']==$banduser[$j]['memberid']){
					$allmem[$i]['check']=true;
				}
			}
		}
		$this->assign('alert', $alert);
		$this->assign('allmem',$allmem);
		$this->assign("group", $group);		
		$this->display('snmp_alert_edit.tpl');
	}

	function snmp_alert_save(){
		$id = get_request('id');
		$name = get_request('name', 1, 1);
	    $alertitem = get_request('alertitem', 1, 1);
		$groupid = get_request('groupid', 1, 0);
		$mail_alarm = get_request('mail_alarm', 1, 0);
		$sms_alarm = get_request('sms_alarm', 1, 0);
		$enable = get_request('enable', 1, 0);
		$period = get_request('period', 1, 0);
		$snmp_alert = new snmp_alert();
		$snmp_alert->set_data('seq', $id);
		$snmp_alert->set_data('name', $name);
		$snmp_alert->set_data('groupid', $groupid);
		$snmp_alert->set_data('mail_alarm', $mail_alarm);
		$snmp_alert->set_data('sms_alarm', $sms_alarm);
		$snmp_alert->set_data('enable', $enable);
		$snmp_alert->set_data('period', $period);
		$snmp_alert->set_data('alarmitem', $alertitem);
		if($id){
			$this->snmp_alert_user_set->delete_all("snmp_alert_id='$id'");
			
			$this->snmp_alert_set->edit($snmp_alert);
		}else{
			$this->snmp_alert_set->add($snmp_alert);
			$id = mysql_insert_id();
		}

		for($i=0; $i<count($_POST['memberid']); $i++){
			$newuser = new snmp_alert_user();
			$newuser->set_data('snmp_alert_id', $id);
			$newuser->set_data('memberid', $_POST['memberid'][$i]);
			$this->snmp_alert_user_set->add($newuser);
		}
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=snmp_alert');
	}

	function snmp_alert_del(){
		$id = get_request('id');
		$this->snmp_alert_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=snmp_alert');
	}

	function snmp_enabled(){
		$id = get_request('id');
		$this->snmp_alert_set->query("UPDATE ".$this->snmp_alert_set->get_table_name()." SET enable=IF(`enable`=1,0,1) WHERE seq='$id'");
		alert_and_back('操作成功','admin.php?controller=admin_thold&action=snmp_alert');
	}

	
	function snmp_status_warning_log(){
		$ip = get_request('ip', 0, 1);
		$name = get_request('name', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		
		if(empty($orderby1)){
			$orderby1 = 'datetime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($name){
			$where .= " AND device_ip like '%$name%'";
		}
		if($ip){
			$where .= " AND device_ip like '%$ip%'";
		}

		$total_page = $this->snmp_status_warning_log_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->snmp_status_warning_log_set->base_select("SELECT a.* FROM ".$this->snmp_status_warning_log_set->get_table_name()." a  WHERE $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);		
		$this->display('snmp_status_warning_log.tpl');
	}

	function snmp_interface_log(){
		$ip = get_request('ip', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		
		if(empty($orderby1)){
			$orderby1 = 'datetime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($ip){
			$where .= " AND device_ip like '%$ip%'";
		}

		$total_page = $this->snmp_interface_log_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->snmp_interface_log_set->base_select("SELECT a.* FROM ".$this->snmp_interface_log_set->get_table_name()." a  WHERE $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);		
		$this->display('snmp_interface_log.tpl');
	}

	function app_warning_log(){
		$ip = get_request('ip', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		
		if(empty($orderby1)){
			$orderby1 = 'datetime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($ip){
			$where .= " AND device_ip like '%$ip%'";
		}

		$total_page = $this->app_warning_log_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->app_warning_log_set->base_select("SELECT a.* FROM ".$this->app_warning_log_set->get_table_name()." a  WHERE $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);		
		$this->display('app_warning_log.tpl');
	}
}
?>
