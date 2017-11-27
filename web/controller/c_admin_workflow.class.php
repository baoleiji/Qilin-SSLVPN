<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_workflow extends c_base {
	function workflow_contant(){
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'status';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$where = '1';

		$row_num = $this->workflow_contant_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$s = $this->workflow_contant_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$this->assign('title', language('来源IP列表'));
		$this->assign('s', $s);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('workflow_contant.tpl');
	}
	
	function workflow_contant_edit(){
		$sid = get_request("sid");
		$sip = $this->workflow_contant_set->select_by_id($sid);
		$this->assign("title", language('添加来源IP组'));
		$this->assign("sip", $sip);
		$this->display('workflow_contant_edit.tpl');
	}
	
	function workflow_contant_delete(){
		$error = array();
		for($i=0; $i<count($_POST['chk_gid']); $i++){
			$sid = $_POST['chk_gid'][$i];
			$a = $this->workflow_contant_set->base_select("select count(*) b FROM (SELECT * FROM ".$this->workflow_set->get_table_name()." WHERE sid=".$sid.") t");
			if($a[0]['b']>0){
				$error[] = $groupname.":该组已有绑定,不能删除";
				continue;
			}
			$this->workflow_contant_set->query("DELETE FROM ".$this->workflow_contant_set->get_table_name()." WHERE sid='$sid'");
		}
		if($error){
			alert_and_back('删除失败:\n'.implode('\n', $error),'admin.php?controller=admin_workflow&action=workflow_contant');
			exit;
		}
		alert_and_back('删除成功','admin.php?controller=admin_workflow&action=workflow_contant');
	}
	
	function workflow_contant_save(){
		$sid = get_request("sid");
		$name = get_request("name", 1, 1);
		$desc = get_request("desc", 1, 1);
		if(empty($name)){
			alert_and_back('请填写组名');
			exit;
		}
		$allgp = $this->workflow_contant_set->select_all('name="'.$name.'" AND sid!='.$sid);
		if(!empty($allgp)){
			alert_and_back('该组名已经存在');
			exit;
		}
		$workflow_contant = new workflow_contant();
		$workflow_contant->set_data('name', $name);
		$workflow_contant->set_data('desc', $desc);
		if($sid){
			$workflow_contant->set_data("sid", $sid);
			$this->workflow_contant_set->edit($workflow_contant);
			alert_and_back('修改成功','admin.php?controller=admin_workflow&action=workflow_contant');
			exit;
		}
		$this->workflow_contant_set->add($workflow_contant);
		alert_and_back('添加成功','admin.php?controller=admin_workflow&action=workflow_contant');
	}
		
	function workflow(){
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'dateline';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		$where = '1';
		if($_SESSION['ADMIN_LEVEL']==0){
			$where .= " AND (memberid=".$_SESSION['ADMIN_UID']." or operator=".$_SESSION['ADMIN_UID'].")";
		}

		$row_num = $this->workflow_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$s = $this->workflow_set->base_select("SELECT devices.device_ip,devices.username,login_template.login_method,workflow_contant.name,workflow.*,devices.enable FROM ".$this->workflow_set->get_table_name()." LEFT JOIN ".$this->devpass_set->get_table_name()." ON ".$this->workflow_set->get_table_name().".devicesid=".$this->devpass_set->get_table_name().".id LEFT JOIN ".$this->workflow_contant_set->get_table_name()." ON ".$this->workflow_contant_set->get_table_name().".sid=".$this->workflow_set->get_table_name().".contant LEFT JOIN ".$this->tem_set->get_table_name()." ON ".$this->tem_set->get_table_name().".id=".$this->devpass_set->get_table_name().".login_method WHERE $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		$lb = $this->loadbalance_set->select_all();
		$localhost = $this->get_eth0_ip();
		$localhost = $localhost['eth0'];
		$this->assign("localip",$localhost);
		$this->assign("lb",$lb);
		$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
		$this->assign('title', language('来源IP列表'));
		$this->assign('s', $s);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('workflow.tpl');
	}
	
	function workflow_edit(){
		global $_CONFIG;
		$sid = get_request("sid");
		$ldapidname = 'ldapid';
		$groupidname = 'groupid';
		require('./include/select_sgroup_ajax.inc.php');

		$wfcontant = $this->workflow_contant_set->select_all();
		$where = $this->workflow_set->get_table_name().".sid=".$sid;
		$wfcontant = $this->workflow_contant_set->select_all('1', 'status', 'ASC');
		$sip = $this->workflow_set->base_select("SELECT devices.device_ip,devices.username,login_template.login_method,workflow_contant.name,workflow.* FROM ".$this->workflow_set->get_table_name()." LEFT JOIN ".$this->devpass_set->get_table_name()." ON ".$this->workflow_set->get_table_name().".devicesid=".$this->devpass_set->get_table_name().".id LEFT JOIN ".$this->workflow_contant_set->get_table_name()." ON ".$this->workflow_contant_set->get_table_name().".sid=".$this->workflow_set->get_table_name().".contant LEFT JOIN ".$this->tem_set->get_table_name()." ON ".$this->tem_set->get_table_name().".id=".$this->devpass_set->get_table_name().".login_method WHERE $where ");

		$where = "member.uid=".$_SESSION['ADMIN_UID']." AND workflow=1";

		$sql  = "select distinct devices.id,devices.device_ip,devices.username,login_template.login_method,sg1.id groupid,sg1.groupname,sg1.count,sg1.level grouplevel,sg1.ldapid groupldapid,sg2.id pgroupid,sg2.groupname pgroupname,sg2.level pgrouplevel,sg2.ldapid pgroupldapid,sg3.id ppgroupid,sg3.groupname ppgroupname,sg3.level ppgrouplevel,sg3.ldapid ppgroupldapid from luser left join member on luser.memberid=member.uid left join devices on luser.devicesid=devices.id left join login_template on devices.login_method=login_template.id LEFT JOIN servers ON devices.device_ip=servers.device_ip LEFT JOIN servergroup sg1 ON servers.groupid=sg1.id LEFT JOIN servergroup sg2 ON sg1.ldapid=sg2.id LEFT JOIN servergroup sg3 ON sg2.ldapid=sg3.id where member.uid and luser.devicesid AND $where";		
		$sql .= " union select distinct devices.id,devices.device_ip,devices.username,login_template.login_method,sg1.id groupid,sg1.groupname,sg1.count,sg1.level grouplevel,sg1.ldapid groupldapid,sg2.id pgroupid,sg2.groupname pgroupname,sg2.level pgrouplevel,sg2.ldapid pgroupldapid,sg3.id ppgroupid,sg3.groupname ppgroupname,sg3.level ppgrouplevel,sg3.ldapid ppgroupldapid from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join devices on t.devicesid=devices.id left join login_template on devices.login_method=login_template.id LEFT JOIN servers ON devices.device_ip=servers.device_ip LEFT JOIN servergroup sg1 ON servers.groupid=sg1.id LEFT JOIN servergroup sg2 ON sg1.ldapid=sg2.id LEFT JOIN servergroup sg3 ON sg2.ldapid=sg3.id where t.id and member.uid and t.devicesid AND $where";
		$sql .= " union select distinct devices.id,devices.device_ip,devices.username,login_template.login_method,sg1.id groupid,sg1.groupname,sg1.count,sg1.level grouplevel,sg1.ldapid groupldapid,sg2.id pgroupid,sg2.groupname pgroupname,sg2.level pgrouplevel,sg2.ldapid pgroupldapid,sg3.id ppgroupid,sg3.groupname ppgroupname,sg3.level ppgrouplevel,sg3.ldapid ppgroupldapid from lgroup left join member on lgroup.groupid=member.groupid left join devices on lgroup.devicesid=devices.id left join login_template on devices.login_method=login_template.id LEFT JOIN servers ON devices.device_ip=servers.device_ip LEFT JOIN servergroup sg1 ON servers.groupid=sg1.id LEFT JOIN servergroup sg2 ON sg1.ldapid=sg2.id LEFT JOIN servergroup sg3 ON sg2.ldapid=sg3.id where member.uid and lgroup.devicesid AND $where";
		$sql .= " union select distinct devices.id,devices.device_ip,devices.username,login_template.login_method,sg1.id groupid,sg1.groupname,sg1.count,sg1.level grouplevel,sg1.ldapid groupldapid,sg2.id pgroupid,sg2.groupname pgroupname,sg2.level pgrouplevel,sg2.ldapid pgroupldapid,sg3.id ppgroupid,sg3.groupname ppgroupname,sg3.level ppgrouplevel,sg3.ldapid ppgroupldapid from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join devices on t.devicesid=devices.id left join login_template on devices.login_method=login_template.id LEFT JOIN servers ON devices.device_ip=servers.device_ip LEFT JOIN servergroup sg1 ON servers.groupid=sg1.id LEFT JOIN servergroup sg2 ON sg1.ldapid=sg2.id LEFT JOIN servergroup sg3 ON sg2.ldapid=sg3.id where t.id and member.uid and t.devicesid AND $where ORDER BY device_ip ASC,login_method ASC ";

		$userpriority = $this->workflow_set->base_select($sql);
		$servers = array();
		$allsgroup = array();
		for($i=0; $i<count($userpriority); $i++){
			if(!in_array($userpriority[$i]['device_ip'], $servers)){
				$servers[] = $userpriority[$i]['device_ip'];
			}
			$found1 = false;
			$found2 = false;
			$found3 = false;
			for($j=0; $j<count($allsgroup); $j++){
				if($allsgroup[$j]['id']==$userpriority[$i]['groupid']){
					$found1=true;
				}
				if($allsgroup[$j]['id']==$userpriority[$i]['pgroupid']){
					$found2=true;
				}
				if($allsgroup[$j]['id']==$userpriority[$i]['ppgroupid']){
					$found3=true;
				}
			}
			if(!$found1&&$userpriority[$i]['groupid']){
				$allsgroup[] = array('id'=>$userpriority[$i]['groupid'],'groupname'=>$userpriority[$i]['groupname'],'count'=>$userpriority[$i]['count'],'ldapid'=>$userpriority[$i]['groupldapid'],'level'=>$userpriority[$i]['grouplevel']);
			}
			if(!$found2&&$userpriority[$i]['pgroupid']){
				$allsgroup[] = array('id'=>$userpriority[$i]['pgroupid'],'groupname'=>$userpriority[$i]['pgroupname'],'count'=>$userpriority[$i]['count'],'ldapid'=>$userpriority[$i]['pgroupldapid'],'level'=>$userpriority[$i]['pgrouplevel']);
			}
			if(!$found3&&$userpriority[$i]['ppgroupid']){
				$allsgroup[] = array('id'=>$userpriority[$i]['ppgroupid'],'groupname'=>$userpriority[$i]['ppgroupname'],'count'=>$userpriority[$i]['count'],'ldapid'=>$userpriority[$i]['ppgroupldapid'],'level'=>$userpriority[$i]['ppgrouplevel']);
			}
			if($sip[0]['device_ip']==$userpriority[$i]['device_ip']){
				$sip[0]['info']=$userpriority[$i];
			}
			//var_dump($userpriority[$i]);
			//echo '<pre>';var_dump($allsgroup);echo '</pre>';
		}

		
		/*
		$servers = array();
		for($i=0; $i<count($userpriority); $i++){
			$foundserver = false;
			for($j=0; $j<count($servers); $j++){
				if($servers[$j]['device_ip']==$userpriority[$i]['device_ip']){
					$founduser = false;
					for($m=0; $m<count($servers[$j]['users']); $m++){
						if($servers[$j]['users'][$m]['username']==$userpriority[$i]['username']){

						}
					}
					if(empty($foundserver)){
						$servers[$j]['users'][] = array('username'=>$userpriority[$i]['username'], 'devices'=>array($userpriority[$i]));
					}
				}
			}
			if(empty($foundserver)){
				$servers[] = array('device_ip'=>$userpriority[$i]['device_ip'], 'users'=> array('username'=>$userpriority[$i]['username'], 'devices'=>array($userpriority[$i])));
			}
		}*/

		$this->assign("title", language('添加来源IP组'));
		$this->assign("sip", $sip[0]);;
		$this->assign("servers", $servers);
		$this->assign("allsgroup", $allsgroup);
		$this->assign("userpriority", $userpriority);
		$this->assign("wfcontant", $wfcontant);
		$this->assign("_config", $_CONFIG);
		$this->assign("logined_user_level", 1);
		$this->display('workflow_edit.tpl');
	}

	function workflow_new(){
		global $_CONFIG;
		if($id){
			$sip = $this->workflow_set->select_by_id($id);
			$dev = $this->devpass_set->select_by_id($sip['devicesid']);
			$this->assign("sip", $sip);
			$this->assign("dev", $dev);
		}
		$wfcontant = $this->workflow_contant_set->select_all();
		$where .= " login_method IN('ssh','RDP','telnet','ftp','ssh1','vnc','x11','rlogin','apppub')";
		$methods =  $this->tem_set->select_all($where,'','ASC');	
		$this->assign("methods", $methods);
		$this->assign("wfcontant", $wfcontant);
		$this->display("workflow_new.tpl");
	}

	function workflow_new_save(){
		global $_CONFIG;
		$sid = get_request('sid');
		$device_ip = get_request('device_ip', 1, 1);
		$username = get_request('username', 1, 1);
		$login_method = get_request('login_method', 1, 1);
		$port = get_request('port', 1, 1);
		$wfcontant = get_request('wfcontant', 1, 1);
		$deadline = get_request('deadline', 1, 1);
		$desc = get_request('desc', 1, 1);
		
		
		$dev = $this->devpass_set->select_all("device_ip='".$device_ip."' and username='".$username."' and port='".$port."' and login_method='".$login_method."'");
		if(empty($dev)){
			alert_and_back('设备用户不存在 ');
			exit;
		}

		$workflow = new workflow();
		$workflow->set_data('devicesid', $dev[0]['id']);
		$workflow->set_data('contant', $wfcontant);
		$workflow->set_data('memberid', $_SESSION['ADMIN_UID']);
		$workflow->set_data('desc', $desc);
		$workflow->set_data('type', 1);
		$workflow->set_data('dateline', date('Y-m-d H:i:s'));
		$workflow->set_data('deadline', $deadline);

		if($this->workflow_set->select_count("memberid=".$_SESSION['ADMIN_UID']." AND devicesid=".$dev[0]['id']." AND `status`<4")){
			alert_and_back('已经提交过申请,请等待审批结束');
			exit;
		}
		if($sid){
			$s = $this->workflow_set->select_by_id($sid);
			$workflow->set_data("sid", $sid);
			$workflow->set_data("status", 0);
			$this->workflow_set->edit($workflow);
			if($s['status']!=2){
				alert_and_back('修改成功','admin.php?controller=admin_workflow&action=workflow');
				exit;
			}
			$this->workflow_set->query("delete from workflow_log where wid=".$sid);
		}else{
			$this->workflow_set->add($workflow);
			$sid = mysql_insert_id();
		}
		for($i=0; $i<count($_CONFIG['WorkFlowAdmin']); $i++){
			if(empty($_CONFIG['WorkFlowAdmin'][$i])) break;
			$workflow_log = new workflow_log();
			$workflow_log->set_data("wid", $sid);
			$workflow_log->set_data("member", $_CONFIG['WorkFlowAdmin'][$i]);
			$workflow_log->set_data("apply_status", 0);
			$this->workflow_log_set->add($workflow_log);
		}
		alert_and_back('操作成功','admin.php?controller=admin_workflow&action=workflow');
	}

	function show_workflow_log(){
		$wid = get_request('wid');
		$logs = $this->workflow_log_set->base_select("SELECT member.username,wf.apply_status,wf.apply_date,wf.desc FROM workflow_log wf LEFT JOIN member ON wf.member=member.uid WHERE wid=$wid ORDER BY wf.sid ASC");
		$this->assign("logs", $logs);
		$this->display("workflow_log.tpl");
	}

	function approvedesc(){
		$wid = get_request('wid');
		$status = get_request('status');
		$wf = $this->workflow_set->select_by_id($wid);
		$members = $this->member_set->select_all('1', 'username', 'asc');
		$logs = $this->workflow_log_set->base_select("SELECT member.username,wf.apply_status,wf.apply_date,wf.desc FROM workflow_log wf LEFT JOIN member ON wf.member=member.uid WHERE wid=$wid ORDER BY wf.sid ASC");
		if($logs[count($logs)-1]['username']==$_SESSION['ADMIN_USERNAME'] && $wf['contant']!=2&&empty($wf['type'])){
			$this->assign("last", 1);
		}
		$this->assign("wid", $wid);
		$this->assign("status", $status);
		$this->assign("members", $members);
		$this->assign("wf", $wf);
		$this->display("workflow_approve_desc.tpl");
	}
	
	function workflow_delete(){
		$error = array();
		$id = get_request('id');
		if($id){
			$_POST['chk_gid'][]=$id;
		}
		for($i=0; $i<count($_POST['chk_gid']); $i++){
			$sid = $_POST['chk_gid'][$i];
			/*$old_wf = $this->workflow_set->select_by_id($sid);
			$oldmember = $this->member_set->select_by_id($old_wf['memberid']);
			$a = $this->workflow_set->base_select("select count(*) b FROM (SELECT * FROM ".$this->workflow_set->get_table_name()." WHERE sid=".$sid." AND status>1) t");
			if($a[0]['b']>0){
				$error[] = $oldmember['username'].":该流程已经启用,不能删除";
				continue;
			}*/
			$this->workflow_set->query("DELETE FROM ".$this->workflow_set->get_table_name()." WHERE sid='$sid'");
			$this->workflow_set->query("DELETE FROM ".$this->workflow_log_set->get_table_name()." WHERE wid='$sid'");
		}
		if($error){
			alert_and_back('删除失败:\n'.implode('\n', $error));
			exit;
		}
		alert_and_back('删除成功');
	}

	function search_sessions(){
		$wid = get_request('wid');
		$start = get_request('start', 0, 1);
		$end = get_request('end', 0, 1);
		if($start || $end){
			$wf = $this->workflow_set->select_by_id($wid);
			$device = $this->devpass_set->select_by_id($wf['devicesid']);
			$where = " luser='".$_SESSION['ADMIN_USERNAME']."' AND user='".$device['username']."'".($start ? " AND start > '".$start."'" : '').($end ? " AND end < '".$end."'" : '');
			
			//var_dump($wf);
			switch($device['login_method']){
				case 3://ssh/telnet
					$where = $where." AND type='ssh'";
					$row_num = $this->sessions_set->select_count($where);
					$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
					$this->assign('page_list', $newpager->showSerialList());
					$this->assign('total', $row_num);
					$this->assign('curr_page', $newpager->intCurrentPageNumber);
					$this->assign('total_page', $newpager->intTotalPageCount);
					$this->assign('items_per_page', $newpager->intItemsPerPage);
					$s = $this->sessions_set->select_all($where);
					$this->assign('allsession', $s);
					break;
				case 5://ssh/telnet
					$where = $where." AND type='telnet'";
					$row_num = $this->sessions_set->select_count($where);
					$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
					$this->assign('page_list', $newpager->showSerialList());
					$this->assign('total', $row_num);
					$this->assign('curr_page', $newpager->intCurrentPageNumber);
					$this->assign('total_page', $newpager->intTotalPageCount);
					$this->assign('items_per_page', $newpager->intItemsPerPage);
					$s = $this->sessions_set->select_all($where);
					$this->assign('allsession', $s);
					break;
				case 6://ftp
					$row_num = $this->ftpsession_set->select_count($where);
					$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
					$this->assign('page_list', $newpager->showSerialList());
					$this->assign('total', $row_num);
					$this->assign('curr_page', $newpager->intCurrentPageNumber);
					$this->assign('total_page', $newpager->intTotalPageCount);
					$this->assign('items_per_page', $newpager->intItemsPerPage);
					$s = $this->ftpsession_set->select_all($where);
					$this->assign('allsession', $s);
					break;
				case 7://sftp
					$row_num = $this->sftpsession_set->select_count($where);
					$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
					$this->assign('page_list', $newpager->showSerialList());
					$this->assign('total', $row_num);
					$this->assign('curr_page', $newpager->intCurrentPageNumber);
					$this->assign('total_page', $newpager->intTotalPageCount);
					$this->assign('items_per_page', $newpager->intItemsPerPage);
					$s = $this->sftpsession_set->select_all($where);
					$this->assign('allsession', $s);
					break;
				case 8://rdp
					$where .= " AND (LOGIN_TEMPLATE=8 or LOGIN_TEMPLATE=22 or LOGIN_TEMPLATE=0)";
					$row_num = $this->rdp_set->select_count($where);
					$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
					$this->assign('page_list', $newpager->showSerialList());
					$this->assign('total', $row_num);
					$this->assign('curr_page', $newpager->intCurrentPageNumber);
					$this->assign('total_page', $newpager->intTotalPageCount);
					$this->assign('items_per_page', $newpager->intItemsPerPage);
					$s = $this->rdp_set->select_all($where);
					$this->assign('allsession', $s);
					break;
				case 21://x11
					$where .= " AND (LOGIN_TEMPLATE=21)";
					$row_num = $this->rdp_set->select_count($where);
					$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
					$this->assign('page_list', $newpager->showSerialList());
					$this->assign('total', $row_num);
					$this->assign('curr_page', $newpager->intCurrentPageNumber);
					$this->assign('total_page', $newpager->intTotalPageCount);
					$this->assign('items_per_page', $newpager->intItemsPerPage);
					$s = $this->rdp_set->select_all($where);
					$this->assign('allsession', $s);
					break; 
				case 22://x11
					$where .= " AND (LOGIN_TEMPLATE=22)";
					$row_num = $this->rdp_set->select_count($where);
					$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
					$this->assign('page_list', $newpager->showSerialList());
					$this->assign('total', $row_num);
					$this->assign('curr_page', $newpager->intCurrentPageNumber);
					$this->assign('total_page', $newpager->intTotalPageCount);
					$this->assign('items_per_page', $newpager->intItemsPerPage);
					$s = $this->rdp_set->select_all($where);
					$this->assign('allsession', $s);
					break; 
				default:
					break;
			}
		}
		$this->assign("wid", $wid);
		$this->display("wolk_flow_session_search.tpl");
	}

	function workflow_close(){
		$sessionid = get_request('sessionid', 1, 0);
		$wid = get_request('wid', 0, 1);
		$workflow = new workflow();
		$workflow->set_data('status', 1);
		$workflow->set_data('sessionid', $sessionid);
		$workflow->set_data('sid', $wid);
		$this->workflow_set->edit($workflow);
		alert_and_back('操作成功');
	}
	
	function workflow_save(){
		$sid = get_request("sid");
		$devicesid = get_request("devicesid", 1, 1);
		$wfcontant = get_request("wfcontant", 1, 1);
		$desc = get_request("desc", 1, 1);
		$workflow = new workflow();
		$workflow->set_data('devicesid', $devicesid);
		$workflow->set_data('contant', $wfcontant);
		$workflow->set_data('memberid', $_SESSION['ADMIN_UID']);
		$workflow->set_data('desc', $desc);
		$workflow->set_data('dateline', date('Y-m-d H:i:s'));
		if(empty($devicesid)){
			alert_and_back('请选择设备');
			exit;
		}
		
		if($this->workflow_set->select_count("memberid=".$_SESSION['ADMIN_UID']." AND devicesid=$devicesid AND `status`>2 AND `status`<4")){
			alert_and_back('已经提交过申请,请等待审批结束');
			exit;
		}
		if($sid){
			$s = $this->workflow_set->select_by_id($sid);
			$workflow->set_data("sid", $sid);
			$workflow->set_data("status", 0);
			$this->workflow_set->edit($workflow);
			if($s['status']!=2){
				alert_and_back('修改成功','admin.php?controller=admin_workflow&action=workflow');
				exit;
			}
			$this->workflow_set->query("delete from workflow_log where wid=".$sid);
		}else{
			$this->workflow_set->add($workflow);
			$sid = mysql_insert_id();
		}
		if($row=$this->luser_set->select_all("memberid=".$_SESSION['ADMIN_UID']." AND devicesid=$devicesid")){
		}elseif($row=$this->luser_resourcegrp_set->base_select("SELECT luser_resourcegrp.* FROM luser_resourcegrp LEFT JOIN (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=$devicesid ) t ON luser_resourcegrp.resourceid=t.id WHERE memberid=".$_SESSION['ADMIN_UID'])){
		}elseif($row=$this->lgroup_set->select_all("groupid'".$_SESSION['ADMIN_GROUP']."' AND devicesid=$devicesid")){
		}elseif($row=$this->lgroup_resourcegrp_set->base_select("SELECT lgroup_resourcegrp.* FROM lgroup_resourcegrp LEFT JOIN (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=$devicesid ) t ON lgroup_resourcegrp.resourceid=t.id WHERE groupid=".$_SESSION['ADMIN_GROUP'])){
		}
		$i=1;
		while($i<5){//var_dump($row[0]['wf_user'.$i]);
			if(empty($row[0]['wf_user'.$i])) break;
			$workflow_log = new workflow_log();
			$workflow_log->set_data("wid", $sid);
			$workflow_log->set_data("member", $row[0]['wf_user'.$i]);
			$workflow_log->set_data("apply_status", 0);
			$this->workflow_log_set->add($workflow_log);
			$i++;
		}
		alert_and_back('操作成功','admin.php?controller=admin_workflow&action=workflow');
	}

	function workflow_approve(){
		global $_CONFIG;
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'sid';
		}
		if (strcasecmp($orderby2, 'asc') != 0) {
			$orderby2 = 'desc';
		} else {
			$orderby2 = 'asc';
		}
        $this->assign("orderby2", $orderby2=='desc' ? 'asc' : 'desc');
		if($_SESSION['ADMIN_LEVEL']==0){
			$where .= " AND memberid=".$_SESSION['ADMIN_UID'];
		}
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			$alltmpip = array(0);
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
					if($alltmpip)
					$where .= " AND LEFT(devices.device_ip,IF(LOCATE(':',devices.device_ip)>0,LOCATE(':',devices.device_ip)-1,LENGTH(devices.device_ip))) IN ('".implode("','", $alltmpip)."')";
				}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND m.username IN ('".implode("','", $alltmpuser)."')";
				}
			}
        }
		$sql = "SELECT workflow.*,m.username muname,wflog.members,wflog.apply_status,wflog.max_apply_status,devices.device_ip,devices.username,login_template.login_method,workflow_contant.name FROM workflow LEFT JOIN (SELECT wid,GROUP_CONCAT(member order by sid ASC) members, GROUP_CONCAT(apply_status order by sid ASC) apply_status,Max(apply_status) max_apply_status FROM workflow_log GROUP BY wid) wflog ON workflow.sid=wflog.wid LEFT JOIN devices ON workflow.devicesid=devices.id LEFT JOIN login_template ON devices.login_method=login_template.id LEFT JOIN workflow_contant ON workflow.contant=workflow_contant.sid LEFT JOIN member m ON workflow.memberid=m.uid WHERE locate('".$_SESSION['ADMIN_UID'].",',wflog.members)>0 OR locate(',".$_SESSION['ADMIN_UID']."',wflog.members)>0 OR locate(',".$_SESSION['ADMIN_UID'].",',wflog.members)>0 OR ".$_SESSION['ADMIN_UID']."=wflog.members";
		$sql .= " UNION SELECT workflow.*,m.username muname,wflog.members,wflog.apply_status,wflog.max_apply_status,devices.device_ip,devices.username,login_template.login_method,workflow_contant.name FROM workflow LEFT JOIN (SELECT wid,GROUP_CONCAT(member order by sid ASC) members, GROUP_CONCAT(apply_status order by sid ASC) apply_status,Max(apply_status) max_apply_status FROM workflow_log GROUP BY wid) wflog ON workflow.sid=wflog.wid LEFT JOIN devices ON workflow.devicesid=devices.id LEFT JOIN login_template ON devices.login_method=login_template.id LEFT JOIN workflow_contant ON workflow.contant=workflow_contant.sid LEFT JOIN member m ON workflow.memberid=m.uid WHERE locate('".$_SESSION['ADMIN_UID'].",',wflog.members)>0 OR locate(',".$_SESSION['ADMIN_UID']."',wflog.members)>0 OR locate(',".$_SESSION['ADMIN_UID'].",',wflog.members)>0 OR ".$_SESSION['ADMIN_UID']."=wflog.members $where";
		$row_num = $this->workflow_set->base_select("SELECT COUNT(*) AS row_num FROM ($sql) t");
		$row_num = $row_num[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage ";
		$s = $this->workflow_set->base_select($sql);
		for($i=0; $i<count($s); $i++){
			if($s[$i]['type']){
				$s[$i]['approved']=$s[$i]['max_apply_status'];
				if($s[$i]['approved']==0) $s[$i]['apply_status_priority']=1;
				continue;
			}
			$wfuser_arr = explode(',', $s[$i]['members']);
			$wflog = "";
			$found = 0;
			for($j=0; $j<count($wfuser_arr); $j++){
				if($wfuser_arr[$j]==$_SESSION['ADMIN_UID']){
					$found = 1;
					break;
				}
				$wflog .= "1,";
			}
			if(empty($found)) continue;			
			if(substr($s[$i]['apply_status'], 0, strlen($wflog)+3)==$wflog.'1,0'){
				$s[$i]['apply_status_reject'] = 1;
			}
			$wstatus = $this->workflow_log_set->select_all("wid=".$s[$i]['sid']." AND member=".$_SESSION['ADMIN_UID']);
			if($wstatus[0]['apply_status']){
				$s[$i]['approved'] = $wstatus[0]['apply_status'];
				continue;
			}

			$wflog = substr($wflog, 0, strlen($wflog)-1)."";//var_dump($found);var_dump($j==0);
			if($found&&$j==0 || substr($s[$i]['apply_status'], 0, strlen($wflog))==$wflog){
				$s[$i]['apply_status_priority'] = 1;
			}

		}
		//echo '<pre>';var_dump($s);echo '</pre>';
		$members = $this->member_set->select_all('1', 'username', 'asc');
		$this->assign('title', language('来源IP列表'));
		$this->assign('s', $s);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('members', $members);
		$this->display('workflow_approve.tpl');
	}

	function do_workflow_approve(){
		$wid = get_request('wid');
		$status = get_request('status');
		$desc = get_request('description', 1, 1);
		$operator = get_request("username", 1, 0);
		$this->workflow_log_set->query("UPDATE ".$this->workflow_log_set->get_table_name()." SET apply_date=NOW(),apply_status=".$status.",`desc`='".$desc."' WHERE wid=".$wid." AND member=".$_SESSION['ADMIN_UID']);		
		$winfo = $this->workflow_set->select_by_id($wid);
		$wf = $this->workflow_log_set->base_select("SELECT member FROM ".$this->workflow_log_set->get_table_name()." WHERE wid=$wid order by sid asc ");
		if($status==1){
			if(empty($winfo['type'])&&$wf[0]['member']==$_SESSION['ADMIN_UID']&&count($wf)>1)
				$this->workflow_log_set->query("UPDATE ".$this->workflow_set->get_table_name()." SET status=3 WHERE sid=$wid");
			else if($wf[count($wf)-1]['member']==$_SESSION['ADMIN_UID']||$winfo['type']){
				$uid = $winfo['memberid'];
				if($operator){
					$uid=$operator;
				}
				$m = $this->member_set->select_by_id($uid);
				$devicesid = $winfo['devicesid'];
				if($row=$this->luser_set->select_all("memberid=".$m['uid']." AND devicesid=$devicesid")){
				}elseif($row=$this->luser_resourcegrp_set->base_select("SELECT luser_resourcegrp.* FROM luser_resourcegrp LEFT JOIN (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=$devicesid ) t ON luser_resourcegrp.resourceid=t.id WHERE memberid=".$m['uid'])){
				}else if($row = $this->luser_set->base_select("select a.* from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.memberid=".$m['uid']." AND devices.id=".$devicesid."")){
				}elseif($row=$this->lgroup_set->select_all("groupid='".$m['groupid']."' AND devicesid=$devicesid")){
				}elseif($row=$this->lgroup_resourcegrp_set->base_select("SELECT lgroup_resourcegrp.* FROM lgroup_resourcegrp LEFT JOIN (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=$devicesid ) t ON lgroup_resourcegrp.resourceid=t.id WHERE groupid=".$m['groupid'])){
				}else if($_row = $this->luser_set->base_select("select a.* from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$m['groupid']." AND devices.id=".$devicesid."")){
				}
				if(empty($row)){
					$this->luser_set->query("INSERT INTO luser SET devicesid=".$devicesid.", memberid=".$uid);
				}
				$this->workflow_log_set->query("UPDATE ".$this->workflow_set->get_table_name()." SET status=4".(empty($operator) ? '' : ',operator='.$operator)." WHERE sid=$wid");
			}
		}elseif($status==2){
			$this->workflow_log_set->query("UPDATE ".$this->workflow_set->get_table_name()." SET status=2 WHERE sid=$wid");
		}
		alert_and_back('操作成功');
	}

	function check_userpriority(){
		$devicesid = get_request('devicesid');
		$uid = get_request('uid');
		$m = $this->member_set->select_by_id($uid);

		if($row=$this->luser_set->select_all("memberid=".$m['uid']." AND devicesid=$devicesid")){
		}elseif($row=$this->luser_resourcegrp_set->base_select("SELECT luser_resourcegrp.* FROM luser_resourcegrp LEFT JOIN (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=$devicesid ) t ON luser_resourcegrp.resourceid=t.id WHERE memberid=".$m['uid'])){
		}elseif($row=$this->lgroup_set->select_all("groupid='".$m['groupid']."' AND devicesid=$devicesid")){
		}elseif($row=$this->lgroup_resourcegrp_set->base_select("SELECT lgroup_resourcegrp.* FROM lgroup_resourcegrp LEFT JOIN (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=$devicesid ) t ON lgroup_resourcegrp.resourceid=t.id WHERE groupid=".$m['groupid'])){
		}//var_dump($row);
		if(empty($row)){
			echo '0';
			exit;
		}
		echo '1';
	}

	function String2File($sIn, $sFileOut) {
	  $rc = false;
	  do {
	   if (!($f = @fopen($sFileOut, "wa+"))) {
	     $rc = 1; 
	     alert_and_back('打开文件失败,请检查文件权限');
	     break;
	   }
	   if (!@fwrite($f, $sIn)) {
	     $rc = 2; 
	     alert_and_back('打开文件失败,请检查文件权限');
	     break;
	   }
	   $rc = true;
	  } while (0);
	  if ($f) {
	   fclose($f);
	  }
	  return ($rc);
	}

	function get_eth0_ip() {
		global $_CONFIG;
		$eth0 = explode(":", $_SERVER["HTTP_HOST"]);
		return array('eth0'=>$eth0[0]);
		$filename = $_CONFIG['CONFIGFILE']['IFGETH0'];
		
		$return=array();
		if(file_exists($filename))
		{
			$lines = file($filename);
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtoupper($lines[$ii]), "IPADDR"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['IPADDR']['value'] = $tmp[1];
					$network['IPADDR']['file'] = $filename;
				}
			}
		}
		else
		{
			//alert_and_back('配置文件不存在');
		}
	
		$return['eth0'] = trim($network['IPADDR']['value']);
		return $return;
	}

	function Array2File($aIn, $sFileOut) {
	  return ($this->String2File(implode("", $aIn), $sFileOut));
	}
}
?>
