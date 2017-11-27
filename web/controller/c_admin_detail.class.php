<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}
class c_admin_detail extends c_base {

	function index(){
		$ip = get_request('ip', 0, 1);
		if ($_SESSION['ADMIN_LEVEL'] == 0) {
			 $sql = "SELECT devicesid FROM " . $this->luser_set->get_table_name();
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= " WHERE memberid=" . $_SESSION['ADMIN_UID'];
			}
			$sql .= " UNION SELECT devicesid FROM " . $this->lgroup_set->get_table_name();
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= " WHERE groupid=" . $_SESSION['ADMIN_GROUP'];
			}
			$sql .= " UNION SELECT devicesid FROM " . $this->resgroup_set->get_table_name() . " WHERE groupname IN (SELECT b.groupname FROM " . $this->luser_resourcegrp_set->get_table_name() . " a LEFT JOIN " . $this->resgroup_set->get_table_name() . " b ON a.resourceid=b.id ";
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= "WHERE  a.memberid=" . $_SESSION['ADMIN_UID'];
			}
			$sql .= ")";
			$sql .= " UNION SELECT devicesid FROM " . $this->resgroup_set->get_table_name() . " WHERE groupname IN (SELECT b.groupname FROM " . $this->lgroup_resourcegrp_set->get_table_name() . " a LEFT JOIN " . $this->resgroup_set->get_table_name() . " b ON a.resourceid=b.id ";
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= "WHERE a.groupid=" . $_SESSION['ADMIN_GROUP'];
			}
			$sql .= ")";
			$alldevid = $this->member_set->base_select($sql);
			for ($i = 0; $i < count($alldevid); $i++) {
				$alldevsid[] = $alldevid[$i]['devicesid'];
			}
			if (empty($alldevsid)) {
				$alldevsid[] = 0;
			}
			if($this->devpass_set->select_count("id IN(" . implode(",", $alldevsid) . ") AND device_ip='".$ip."'")<=0){
				alert_and_close('没有权限');
				exit;
			}
        }
		$this->assign("ip", $ip);
		$this->display("host.tpl");
	}

	function hostleftmenu(){
		$ip = get_request('ip', 0, 1);		
		$snmpstatus = $this->snmp_status_set->select_all("device_ip='$ip' and type='disk'");//var_dump($snmpstatus);
		$sql = "SELECT a.*,a.time value,'tcpport' AS type,b.port_monitor_time highvalue, 0 AS lowvalue FROM ".$this->tcp_port_value_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.ip=b.device_ip where a.ip='$ip'";
		$tcpport = $this->tcp_port_value_set->base_select($sql);	
		$server = $this->server_set->select_all("device_ip='$ip'");
		$snmpstatus = $this->snmp_status_set->select_all("device_ip='$ip' and type='disk'");		
		$memory = $this->snmp_status_set->select_all("device_ip='$ip' and type='memory'");
		$cpu = $this->snmp_status_set->select_all("device_ip='$ip' and type='cpu'");
		if($server[0]['device_type']==2){
			$cpuio = $this->snmp_status_set->select_all("device_ip='$ip' and type='cpu_io'");
			$this->assign("cpuio", $cpuio[0]);
		}
		$localport = $this->snmp_check_port_set->select_all("device_ip='$ip'");
		$localprocess = $this->snmp_check_process_set->select_all("device_ip='$ip'");
		$apps = $this->snmp_app_set->base_select("SELECT * FROM app_config WHERE device_ip='$ip'");
		$appdetail = $this->snmp_app_set->select_all("device_ip='$ip'");
		$appdnsdetail = $this->dns_monitor_set->select_all("device_ip='$ip'");
		$this->assign("memory", $memory[0]);
		$this->assign("cpu", $cpu[0]);
		$this->assign("snmpstatus", $snmpstatus);
		$this->assign("localport", $localport);
		$this->assign("localprocess", $localprocess);
		$this->assign("ip", $ip);
		$this->assign("apps", $apps);
		$this->assign("appdetail", $appdetail);
		$this->assign("appdnsdetail", $appdnsdetail);
		$this->assign("os", ($server[0]['device_type']==4||$server[0]['device_type']==20) ? 'windows' : 'linux');
		$this->assign("tcpport", $tcpport);
		$this->assign("server", $server[0]);
		$this->display("leftmenu.tpl");
	}

	function hostview(){
		$ip = get_request('ip', 0, 1);
		$serverinfo = $this->server_set->select_all("device_ip='$ip'");
		$device_type = $this->tem_set->select_by_id($serverinfo[0]['device_type']);
		$serverinfo[0]['device_type']=$device_type['device_type'];
		$snmpstatus = $this->snmp_status_set->select_all("device_ip='$ip'");
		$eth0 = explode(":", $_SERVER["HTTP_HOST"]);
		$localhost = $eth0[0];
		$where = "servers.device_ip='$ip'";
		for($i=0; $i<count($snmpstatus); $i++){
			if($snmpstatus[$i]['type']!='disk'){
				$hoststatus[$snmpstatus[$i]['type']]=$snmpstatus[$i];
			}else{
				$hoststatus[$snmpstatus[$i]['type']][]=$snmpstatus[$i];
			}
		}
		$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'].($force_fit ? " AND devicesid IN(select d.id  FROM devices d left join servers s ON d.device_ip=s.device_ip where s.id=".$serverinfo[0][id].") " : " AND 1 ");
		$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'].($force_fit ? " AND devicesid IN(select d.id FROM devices d left join servers s ON d.device_ip=s.device_ip where s.id=".$serverinfo[0][id]."))  " : " AND 1 ");
		$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." AND ".($force_fit ? "a.resourceid IN(".implode(',', $resources_arr).")" : '1=1').")";
		$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." AND ".($force_fit ? "a.resourceid IN(".implode(',', $resources_arr).")" : '1=1').")";
		$alldevid = $this->member_set->base_select($sql);
		$alldevsid = array();
		for($i=0; $i<count($alldevid); $i++){
			$alldevsid[]=$alldevid[$i]['devicesid'];
		}
		if(empty($alldevsid)){
			$alldevsid[]=0;
		}
		$where .=" AND devices.id IN(".implode(',', $alldevsid).")";
		$alltem = $this->tem_set->select_all();
		$alldev = $this->server_set->select_limit_ex1(0, 1000,$_SESSION['ADMIN_UID'].'--'.$_SESSION['ADMIN_GROUP'], $where,  $orderby1, $orderby2, $groupby);				
		$row_num = count($alldev);
		for($i=0;$i<$row_num;$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
			}
		}

		$micro = $serverinfo[0]['snmptime']%1000;
		$seconds = ($serverinfo[0]['snmptime']-$micro)/1000;
		$time = time();
		$start = new DateTime(date('Y-m-d H:i:s', $time-$seconds));
		$end = new DateTime(date('Y-m-d H:i:s', $time));
		$diff = $end->diff($start);
		$serverinfo[0]['snmptime_diff'] =  $diff->format('%d').'天'.' '.$diff->format('%h').':'.$diff->format('%i').':'.$diff->format('%s');
		
		$this->assign("localip",$localhost);
		$this->assign("alldev", $alldev);
		$this->assign("hoststatus", $hoststatus);
		$this->assign("serverinfo", $serverinfo[0]);
		$this->assign("ip", $ip);
		$this->display("hostview.tpl");
	}

	function dev_login(){
		$id = get_request('id');
		if ($_SESSION['ADMIN_LEVEL'] == 0) {
			 $sql = "SELECT devicesid FROM " . $this->luser_set->get_table_name();
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= " WHERE memberid=" . $_SESSION['ADMIN_UID'];
			}
			$sql .= " UNION SELECT devicesid FROM " . $this->lgroup_set->get_table_name();
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= " WHERE groupid=" . $_SESSION['ADMIN_GROUP'];
			}
			$sql .= " UNION SELECT devicesid FROM " . $this->resgroup_set->get_table_name() . " WHERE groupname IN (SELECT b.groupname FROM " . $this->luser_resourcegrp_set->get_table_name() . " a LEFT JOIN " . $this->resgroup_set->get_table_name() . " b ON a.resourceid=b.id ";
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= "WHERE  a.memberid=" . $_SESSION['ADMIN_UID'];
			}
			$sql .= ")";
			$sql .= " UNION SELECT devicesid FROM " . $this->resgroup_set->get_table_name() . " WHERE groupname IN (SELECT b.groupname FROM " . $this->lgroup_resourcegrp_set->get_table_name() . " a LEFT JOIN " . $this->resgroup_set->get_table_name() . " b ON a.resourceid=b.id ";
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= "WHERE a.groupid=" . $_SESSION['ADMIN_GROUP'];
			}
			$sql .= ")";
			$alldevid = $this->member_set->base_select($sql);
			for ($i = 0; $i < count($alldevid); $i++) {
				$alldevsid[] = $alldevid[$i]['devicesid'];
			}
			if (empty($alldevsid)) {
				$alldevsid[] = 0;
			}
			if(!in_array($id, $alldevsid)){
				alert_and_close('没有权限');
				exit;
			}
        }
		$auditroot =  dirname(__FILE__).'/../';
		require_once $auditroot.'controller/c_admin_pro.class.php';		
		$smarty = new Smarty(); 
		$smarty->template_dir = $auditroot. "./template/admin";
		$smarty->compile_dir = $auditroot . "./template_c/admin";
		$smarty->cache_dir = $auditroot.'./template_cache/admin';
		$smarty->left_delimiter = "{{"; 
		$smarty->right_delimiter = "}}";
		$smarty->caching = 0;
		$smarty->assign('template_root', $auditroot.'./template/admin');

		$pro = new c_admin_pro();
		$pro->init($smarty, $_CONFIG);
		$pro->dev_login();
	}

	function hostbytype(){
		$ip = get_request('ip', 0, 1);
		$type = get_request('type', 0, 1);
		$id = get_request('id', 0, 1);
		$type = empty($type) ? 'cpu' : $type;
		switch($type){
			case 'cpu':
				$typename= 'CPU';
			break;
			case 'cpu_io':
				$typename= 'CPU IO';
			break;
			case 'memory':
				$typename= '内存';
			break;
			case 'disk':
				$typename= '存储';
			break;
			case 'swap':
				$typename= '交换空间';
			break;
			case 'tcpport':
				$typename= 'TCP端口:';
			break;

		}
		
		if($type=='localport'){
			$where = " device_ip='$ip' ";
			if($id){
				$where .= " AND seq='$id'";
			}
			$snmpstatus = $this->snmp_check_port_set->select_all($where);	//	var_dump($snmpstatus);
			for($i=0; $i<count($snmpstatus); $i++){
				$snmpstatus[$i]['type']='localport';
			}
			$this->assign("status", $snmpstatus);
		}elseif($type=='localprocess'){
			$where = " device_ip='$ip' ";
			if($id){
				$where .= " AND seq='$id'";
			}
			$snmpstatus = $this->snmp_check_process_set->select_all($where);	//	var_dump($snmpstatus);	
			for($i=0; $i<count($snmpstatus); $i++){
				$snmpstatus[$i]['type']='localprocess';
			}
			$this->assign("status", $snmpstatus);
		}elseif($type!='tcpport'){
			$where = "device_ip='$ip' and type='$type'";
			if($id){
				$where .= " AND seq='$id'";
			}
			$snmpstatus = $this->snmp_status_set->select_all($where);	//	var_dump($snmpstatus);	
			$this->assign("status", $snmpstatus);
		}else{
			$where = " device_ip='$ip' ";
			if($id){
				$where .= " and seq='$id'";
			}
			$tcppv = $this->tcp_port_value_set->base_select("SELECT a.*,a.time value,'tcpport' AS type,b.port_monitor_time highvalue, 0 AS lowvalue FROM ".$this->tcp_port_value_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.ip=b.device_ip WHERE ".$where);	
			$this->assign("status", $tcppv);
		}
		$this->assign("typename", $typename);
		$this->assign("type", $type);
		$this->assign("ip", $ip);
		$this->assign("mktime", time());
		$this->display("hostcpu.tpl");
	}

	function appbytype(){
		$id = get_request('id');
		$type = get_request('type', 0, 1);
		if($type=='dns'){
			$detail = $this->dns_monitor_set->select_by_id($id);
		}else{
			$detail = $this->snmp_app_set->select_by_id($id);
		}
		$this->assign("status", $detail);
		$this->assign("type", $type);
		$this->display("appbytype.tpl");
	}

	function tcp_port_value_delete(){
		$id = get_request('id', 0, 1);
		$ip = get_request('ip', 0, 1);
		$this->tcp_port_value_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_detail&ip='.$ip,0,1);
	}

	function eventlogs(){
		$ip = get_request('ip', 0, 1);	
		$eventlogs = $this->eventlogs_set->select_all("host='$ip'");	
		$this->assign("ip", $ip);	
		$this->assign("eventlogs", $eventlogs);
		$this->display("eventlogs.tpl");
	}

	function ciscoindex(){
		$ip = get_request('ip', 0, 1);		
		$server = $this->server_set->select_all("device_ip='$ip'");
		$this->assign("server", $server[0]);
		$this->assign("ip", $ip);
		$this->display("cisco.tpl");
	}

	function ciscoleftmenu(){
		$ip = get_request('ip', 0, 1);
		$server = $this->server_set->select_all("device_ip='$ip'");
		$memory = $this->snmp_status_set->select_all("device_ip='$ip' and type='memory'");
		$cpu = $this->snmp_status_set->select_all("device_ip='$ip' and type='cpu'");
		$this->assign("memory", $memory[0]);
		$this->assign("cpu", $cpu[0]);
		$this->assign("server", $server[0]);
		$this->assign("ip", $ip);
		$this->display("ciscoleft.tpl");
	}

	function ciscoview(){
		$ip = get_request('ip', 0, 1);
		$serverinfo = $this->server_set->select_all("device_ip='$ip'");
		$device_type = $this->tem_set->select_by_id($serverinfo[0]['device_type']);
		$serverinfo[0]['device_type']=$device_type['device_type'];
		$snmpstatus = $this->snmp_status_set->select_all("device_ip='$ip'");
		$eth0 = explode(":", $_SERVER["HTTP_HOST"]);
		$localhost = $eth0[0];
		$where = "servers.device_ip='$ip'";
		$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'].($force_fit ? " AND devicesid IN(select d.id  FROM devices d left join servers s ON d.device_ip=s.device_ip where s.id=".$serverinfo[0][id].") " : " AND 1 ");
		$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'].($force_fit ? " AND devicesid IN(select d.id FROM devices d left join servers s ON d.device_ip=s.device_ip where s.id=".$serverinfo[0][id]."))  " : " AND 1 ");
		$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." AND ".($force_fit ? "a.resourceid IN(".implode(',', $resources_arr).")" : '1=1').")";
		$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." AND ".($force_fit ? "a.resourceid IN(".implode(',', $resources_arr).")" : '1=1').")";
		$alldevid = $this->member_set->base_select($sql);
		$alldevsid = array();
		for($i=0; $i<count($alldevid); $i++){
			$alldevsid[]=$alldevid[$i]['devicesid'];
		}
		if(empty($alldevsid)){
			$alldevsid[]=0;
		}
		$where .=" AND devices.id IN(".implode(',', $alldevsid).")";
		$alltem = $this->tem_set->select_all();
		$alldev = $this->server_set->select_limit_ex1(0, 1000,$_SESSION['ADMIN_UID'].'--'.$_SESSION['ADMIN_GROUP'], $where,  $orderby1, $orderby2, $groupby);				
		$row_num = count($alldev);
		for($i=0;$i<$row_num;$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
			}
		}

		for($i=0; $i<count($snmpstatus); $i++){
			$hoststatus[$snmpstatus[$i]['type']]=$snmpstatus[$i];
		}
		$micro = $serverinfo[0]['snmptime']%1000;
		$seconds = ($serverinfo[0]['snmptime']-$micro)/1000;
		$time = time();
		$start = new DateTime(date('Y-m-d H:i:s', $time-$seconds));
		$end = new DateTime(date('Y-m-d H:i:s', $time));
		$diff = $end->diff($start);
		$serverinfo[0]['snmptime_diff'] = $diff->format('%d').'天'.' '.$diff->format('%h').':'.$diff->format('%i').':'.$diff->format('%s');
		$this->assign("localip",$localhost);
		$this->assign("alldev", $alldev);
		$this->assign("hoststatus", $hoststatus);
		$this->assign("serverinfo", $serverinfo[0]);
		$this->assign("ip", $ip);
		$this->display("ciscoview.tpl");
	}

	function ciscobytype(){
		$ip = get_request('ip', 0, 1);
		$type = get_request('type', 0, 1);
		$type = empty($type) ? 'cpu' : $type;
		switch($type){
			case 'cpu':
				$typename= 'CPU';
			break;
			case 'memory':
				$typename= '内存';
			break;
			case 'disk':
				$typename= '存储';
			break;
			case 'swap':
				$typename= '交换空间';
			break;

		}
		$snmpstatus = $this->snmp_status_set->select_all("device_ip='$ip' and type='$type'");	
		$this->assign("typename", $typename);
		$this->assign("ip", $ip);
		$this->assign("mktime", time());
		$this->assign("status", $snmpstatus);
		$this->display("ciscostatus_bytype.tpl");
	}

	function cisco_interface(){
		$ip = get_request('ip', 0, 1);
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		if(empty($orderby1)){
			$orderby1 = 'port_describe';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$interfaces = $this->snmp_interface_set->select_all("device_ip='$ip'",$orderby1, $orderby2);	
		$server = $this->server_set->select_all("device_ip='$ip'");
		$this->assign("server", $server[0]);
		$this->assign("ip", $ip);
		$this->assign("interfaces", $interfaces);
		$this->display("cisco_interface.tpl");
	}

	function ping(){
		$ip = get_request('ip', 0, 1);
		exec("ping $ip -c 3", $out, $return);
		$time = explode("/", substr($out[count($out)-1], strpos($out[count($out)-1],"=")+1));
		$unit = substr($time[3],strpos($time[3]," ")+1);
		echo "<script>window.opener.document.getElementById('pingReport').innerHTML='".trim($time[1]).$unit."';self.close();</script>";
	}

	function parameters(){
		$ip = get_request('ip', 0, 1);
		$server = $this->server_set->select_all("device_ip='$ip'");
		$this->assign("server", $server[0]);
		$this->assign("ip", $ip);
		$this->display("parameters.tpl");
	}

	function status_backup(){
		$ip = get_request('ip', 0, 1);
		$server = $this->server_set->select_all("device_ip='$ip'");
		$this->assign("server", $server[0]);
		$this->assign("ip", $ip);
		$this->display("status_backup.tpl");
	}

	function status_autorun(){
		$ip = get_request('ip', 0, 1);
		$server = $this->server_set->select_all("device_ip='$ip'");
		$this->assign("server", $server[0]);
		$this->assign("ip", $ip);
		$this->display("status_autorun.tpl");
	}

}
?>
