<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_app extends c_base {
	
	function app_group() {
		global $_CONFIG;
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$groupname = get_request('groupname', 0, 1);
		$username = get_request('username', 0, 1);
		$groupid = get_request('group', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'appgroupname';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$where = 'appdevicesid=0';
		$this->appresgroup_set->query("delete from luser_appresourcegrp where appresourceid not in(select id from appresourcegroup where appdevicesid=0)");
		$this->appresgroup_set->query("delete from lgroup_appresourcegrp where appresourceid not in(select id from appresourcegroup where appdevicesid=0)");
		$groupidname = 'agroupid';
		require_once('./include/select_sgroup_ajax.inc.php');

		$tmpgroup = $this->appresgroup_set->select_all($where);
		for($i=0; $i<count($tmpgroup); $i++){
			$_tmpgroup[] = $tmpgroup[$i]['appgroupname'];
		}
		if($_tmpgroup){
			$this->appresgroup_set->delete_all(" appgroupname NOT IN('".implode("','", $_tmpgroup)."')");
		}

		if($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			$where .= ' AND user IN(SELECT username FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))';
		}
		if($username){
			$where .= ' AND id IN(select appresourceid FROM '.$this->luser_appresourcegrp_set->get_table_name().' WHERE memberid='.$username.' union select appresourceid FROM '.$this->lgroup_appresourcegrp_set->get_table_name().' WHERE groupid=(select groupid from '.$this->member_set->get_table_name().' where uid='.intval($username).'))';
		}elseif($groupid){
			$where .= ' AND id IN(select appresourceid FROM '.$this->lgroup_appresourcegrp_set->get_table_name().' WHERE groupid IN('.$groupid.'))';
		}
		$row_num = $this->appresgroup_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->appresgroup_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$groups = $this->sgroup_set->select_all("attribute!=2", 'groupname', 'asc');
		$users = $this->member_set->select_all("1", 'username', 'asc');
		$this->assign('groups', $groups);
		$this->assign('users', $users);
		$this->assign('title', language('资源组列表'));
		$this->assign('alldev', $alldev);
		$this->assign('username', $username);
		$this->assign('group', $group);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('app_group_index.tpl');
	}
	
	function userapp_group() {
		$page_num = get_request('page');
		$where = 'appdevicesid=0 AND id IN(SELECT appresourceid FROM '.$this->luser_appresourcegrp_set->get_table_name().' WHERE memberid='.$_SESSION['ADMIN_UID'].' )';
	
		$row_num = $this->appresgroup_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->appresgroup_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where);

		$this->assign('title', language('资源组组列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('userapp_group_index.tpl');
	}
	
	function app_group_edit() {
		global $_CONFIG;
		$gid = get_request('id');
		$appserverip = get_request('appserverip', 0, 1);
		$gname = get_request('gname',0,1);
		$desc = get_request('desc',0,1);
		$hostname = get_request('hostname',0,1);
		$username = get_request('username',0,1);
		$groupid = get_request('groupid');
		$ip = get_request('ip', 0, 1);
		if($appserverip){
			$where = " AND appserverip='$appserverip'";
		}
		if($ip){
			$where .= " AND s.device_ip like '%$ip%'";
		}
		if($hostname){
			$where .= " AND s.hostname like '%$hostname%'";
		}if($username){
			$where .= " AND d.username like '%$username%'";
		}
		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$where .= ' AND s.groupid IN('.$_tmpgid['child'].')';
		}
		$ginfo = $this->appresgroup_set->select_by_id($gid);
		//$res = $this->resgroup_set->select_all("groupname='$gname' and appdevicesid!=0");
		require_once('./include/select_sgroup_ajax.inc.php');
		
		$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
		$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
		$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." )";
		$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." )";	
		$appservers = $this->appmember_set->base_select("SELECT device_ip appserverip,hostname FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ($sql) dd ON d.id=dd.devicesid  WHERE dd.devicesid IS NOT NULL AND login_method=26 GROUP BY device_ip", 'hostname', 'asc');
		$_appservers = array(0);
		for($i=0; $i<count($appservers); $i++){
			$_appservers[]=$appservers[$i]['appserverip'];
		}
		$whereappserver = implode("','", $_appservers);

		//$resources = $this->appdevice_set->base_select("SELECT d.*,a.name apppubname, a.appserverip  FROM appdevices d LEFT JOIN apppub a ON d.apppubid=a.id WHERE a.id IS NOT NULL AND d.id NOT IN(SELECT appdevicesid FROM ".$this->appresgroup_set->get_table_name()." WHERE appgroupname='".$ginfo['appgroupname']."' and appdevicesid!=0) ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND appserverip IN(SELECT device_ip FROM servers WHERE 1 '. ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid='.$_SESSION['ADMIN_MSERVERGROUP'].' or groupid IN(SELECT id FROM '.$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].'))))' : '')." $where ORDER BY appserverip");
		
		//$res = $this->appdevice_set->base_select("SELECT d.*,a.name apppubname, a.appserverip  FROM appdevices d LEFT JOIN apppub a ON d.apppubid=a.id  WHERE a.id IS NOT NULL AND d.id IN(SELECT appdevicesid FROM ".$this->appresgroup_set->get_table_name()." WHERE appgroupname='".$ginfo['appgroupname']."' and appdevicesid!=0) ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND appserverip IN(SELECT device_ip FROM servers WHERE 1 '. ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid='.$_SESSION['ADMIN_MSERVERGROUP'].' or groupid IN(SELECT id FROM '.$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].'))))' : '')."  ORDER BY appserverip");

		//$appserver = $this->appserver_set->select_all('1'.($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND appserverip IN(SELECT device_ip FROM servers WHERE 1 '. ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid='.$_SESSION['ADMIN_MSERVERGROUP'].' or groupid IN(SELECT id FROM '.$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].'))))' : ''), 'appserverip', 'asc');


		
		
		$res = $this->appdevice_set->base_select("SELECT d.*,a.name apppubname, a.appserverip,a.appprogramname  FROM appdevices d LEFT JOIN apppub a ON d.apppubid=a.id  WHERE a.id IS NOT NULL AND d.id IN(SELECT appdevicesid FROM ".$this->appresgroup_set->get_table_name()." WHERE appgroupname='".$ginfo['appgroupname']."' and appdevicesid!=0) ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND appserverip IN(\''.$whereappserver.'\')' : '')."  ORDER BY appserverip");

		$res2 = $this->devpass_set->base_select("SELECT a.groupid,a.username,b.groupname FROM ".$this->appresgroup_set->get_table_name()." a left join ".$this->sgroup_set->get_table_name()." b ON a.groupid=b.id WHERE a.appgroupname='".$ginfo['appgroupname']."' and appdevicesid=-1 ORDER BY convert(b.groupname using gbk) ASC");

		$resources = $this->appdevice_set->base_select("SELECT d.*,a.name apppubname, a.appserverip,a.appprogramname  FROM appdevices d LEFT JOIN apppub a ON d.apppubid=a.id  LEFT JOIN (SELECT * FROM servers WHERE 1 ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).'))' : '').")s ON d.device_ip=s.device_ip  WHERE a.id IS NOT NULL AND d.id NOT IN(SELECT appdevicesid FROM ".$this->appresgroup_set->get_table_name()." WHERE appgroupname='".$ginfo['appgroupname']."' and appdevicesid!=0 and appdevicesid is not null) ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND appserverip IN(\''.$whereappserver.'\')' : '')." $where AND NOT EXISTS(SELECT id FROM ".$this->appresgroup_set->get_table_name()." WHERE groupid=s.groupid AND IF(username='0', 1, username=d.username) AND appgroupname='".$ginfo['appgroupname']."' and appdevicesid=-1) $where ORDER BY appserverip");

		$appserver = $this->appserver_set->select_all('1'.($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND appserverip IN(\''.$whereappserver.'\')' : ''), 'appserverip', 'asc');
//		echo '<pre>';print_r($resources);echo '</pre>';echo '<pre>';print_r($res);echo '</pre>';
		if($gname) $ginfo['appgroupname']=$gname;
		if($desc) $ginfo['desc']=$desc;
		$this->assign("res", $res);
		$this->assign("res2", $res2);
		$this->assign("resource", $resources);
		$this->assign("lm", $login_method);
		$this->assign("ginfo", $ginfo);
		$this->assign("ip", $ip);
		$this->assign("username", $username);
		$this->assign("hostname", $hostname);
		$this->assign("appserver", $appserver);
		$this->assign("_config", $_CONFIG);
		$this->appresourcegroup_bind(1);
		$this->display('app_group_edit.tpl');
	}
	
	
	function app_group_save() {
		$gname = get_request('gname', 1, 1);
		$desc = get_request('desc', 1, 1);
		$oldgname = get_request('oldgname', 1, 1);
		$createuser = get_request('createuser', 1, 1);
		$id = get_request("id");
		$selected = get_request('secend', 1, 1);
		$sessionluser = get_request('sessionluser', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		if($gname==""){
			alert_and_back("组名不能为空");
			exit;
		}elseif($this->appresgroup_set->select_count("appgroupname='$gname' and id!=$id and appdevicesid=0") >0){
			alert_and_back("组名已经存在");
			exit;
		}elseif(empty($id)){
			$resourcegroup = new appresgroup();
			$resourcegroup->set_data('appgroupname',$gname);
			$resourcegroup->set_data('desc',$desc);
			$resourcegroup->set_data('appdevicesid',0);
			$resourcegroup->set_data('user',($_SESSION['ADMIN_LEVEL']==1 ? $createuser : $_SESSION['ADMIN_USERNAME']));
			$this->appresgroup_set->add($resourcegroup);
			$id = mysql_insert_id();
			for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
				$_SESSION[$sessionluser][$i]['appresourceid']=$id;
			}
			for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				$_SESSION[$sessionlgroup][$i]['appresourceid']=$id;
			}
			unset($resourcegroup);
		}
		if($id){
			$_ct=$this->appresgroup_set->select_count("appgroupname='$oldgname' and appdevicesid!=0");
			if($_ct!=count($selected)){
				$changed = 1;
			}
			$this->appresgroup_set->delete_all("appgroupname='$oldgname' and appdevicesid!=0");
			$resourcegroup = new appresgroup();
			$resourcegroup->set_data('id',$id);
			$resourcegroup->set_data('appgroupname',$gname);
			$resourcegroup->set_data('user',($_SESSION['ADMIN_LEVEL']==1 ? $createuser : $_SESSION['ADMIN_USERNAME']));
			$resourcegroup->set_data('desc',$desc);
			$this->appresgroup_set->edit($resourcegroup);
			unset($resourcegroup);
		}
		$sgroup_arr = array();
		$insertsql = "INSERT INTO appresourcegroup(appgroupname,appdevicesid,username,user,groupid) values ";
		$insertsql_len = strlen($insertsql);
		for($i=0; $i<count($selected); $i++){

			$selected_arr = explode('_', $selected[$i]);
			if($selected_arr[0]=='groupid'){
				$sgroup_arr[]=$selected_arr[1];
				$insertsql .= "('".$gname."',-1,'0','".($_SESSION['ADMIN_LEVEL']==1 ? $createuser : $_SESSION['ADMIN_USERNAME'])."',".$selected_arr[1]."),";
			}else{
				$insertsql .= "('".$gname."',".$selected[$i].",'0','".($_SESSION['ADMIN_LEVEL']==1 ? $createuser : $_SESSION['ADMIN_USERNAME'])."',0),";
				//$resourcegroup->set_data('appdevicesid',$selected[$i]);
			}
			if($i%1000==0){
				if(strlen($insertsql)!=$insertsql_len){
					$this->resgroup_set->query(substr($insertsql,0,strlen($insertsql)-1));
					$insertsql = "INSERT INTO appresourcegroup(appgroupname,appdevicesid,username,user,groupid) values ";
					
				}
			}
		}
		if(strlen($insertsql)!=$insertsql_len){
			$this->resgroup_set->query(substr($insertsql,0,strlen($insertsql)-1));
		}
		
		if($sgroup_arr){
			$this->resgroup_set->query("INSERT INTO appresourcegroup(appgroupname,appdevicesid,username,user,groupid) select '".$gname."',-1,'0','".($_SESSION['ADMIN_LEVEL']==1 ? $createuser : $_SESSION['ADMIN_USERNAME'])."',id from servergroup sg1 where locate(concat(',',id,','), (select concat(',',group_concat(ifnull(child,0)),',') from servergroup where id IN(".implode(',',$sgroup_arr)."))) and not exists(select * from appresourcegroup where appgroupname='".$gname."' and groupid=sg1.id and appdevicesid=-1)");
			$sql = "select d.id from appdevices d left join servers s on d.device_ip=s.device_ip left join servergroup sg on s.groupid=sg.id where sg.id IN(".implode(',',$sgroup_arr).")";
			$this->resgroup_set->query("delete from ".$this->appresgroup_set->get_table_name()." where appdevicesid IN(".$sql.") and appgroupname='".$gname."'");
			if(mysql_affected_rows()>0){
				$msg = "，并合并重复的权限项";
			}
		}
		$this->appresourcegroup_bindsave($id, $changed);
		alert_and_back("操作成功".$msg,'admin.php?controller=admin_app&action=app_group_edit&id='.$id);
	}

	function app_group_del() {
		$gname = get_request('gname', 0, 1);
		$ginfo = $this->appresgroup_set->select_all("appgroupname='$gname' and appdevicesid=0");
		$this->luser_appresourcegrp_set->delete_all("appresourceid=".$ginfo[0]['id']);
		$this->lgroup_appresourcegrp_set->delete_all("appresourceid=".$ginfo[0]['id']);
		$this->appresgroup_set->delete_all("appgroupname='$gname'");

		alert_and_back("操作成功",'admin.php?controller=admin_app&action=app_group');
	}

	function appresourcegrp_seluser(){
		$sid = get_request('sid');
		$uid = get_request('uid');
		$sessionluser= get_request('sessionluser', 0, 1);
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
				if($_SESSION[$sessionluser][$i]['memberid']==$uid&&$_SESSION[$sessionluser][$i]['appresourceid']==$sid){
					$luser[0] = $_SESSION[$sessionluser][$i];	
					break;
				}
			}
		if(empty($luser)){
			$luser = $this->luser_appresourcegrp_set->select_all('memberid='.$uid.' AND appresourceid='.$sid);
		}
		if(empty($luser)){
			$luser = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all(($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : '1'));
		$sourceip = $this->sourceip_set->select_all(" sourceip=''".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''));
		$this->assign('title', language('设置'));
		$this->assign("luser", $luser[0]);
		$this->assign("weektime", $weektime);
		$this->assign("sourceip", $sourceip);
		$this->assign("uid", $uid);
		$this->assign("sid", $sid);
		$this->assign('sessionluser', $sessionluser);
		$this->display('appresourcegrp_seluser.tpl');
	}

	function appresourcegrp_seluser_save(){
		$sid = get_request('sid', 1, 0);
		$uid = get_request('uid', 1, 0);
		$id = get_request('id', 1, 0);
		$loginlock = get_request('loginlock', 1, 1);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$sessionluser = get_request('sessionluser', 1, 1);
		if($loginlock == 'on') {
			$loginlock = 1;
		}
		else {
			$loginlock = 0;
		}

		if($id)
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if($_SESSION[$sessionluser][$i]['id']==$id){
				$_SESSION[$sessionluser][$i]['loginlock'] = $loginlock;
				$_SESSION[$sessionluser][$i]['weektime'] = $weektime;
				$_SESSION[$sessionluser][$i]['sourceip'] = $sourceip;
				$luser = new luser_appresourcegrp();
				$luser->set_data('loginlock', $_SESSION[$sessionluser][$i]['loginlock']);
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);
				$luser->set_data('sourceip', $_SESSION[$sessionluser][$i]['sourceip']);
				$luser->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
				$luser->set_data('appresourceid', $_SESSION[$sessionluser][$i]['appresourceid']);
				$luser->set_data('id', $_SESSION[$sessionluser][$i]['id']);
				$this->luser_appresourcegrp_set->edit($luser);
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
				if($_SESSION[$sessionluser][$i]['memberid']==$uid&&$_SESSION[$sessionluser][$i]['appresourceid']==$sid){
					$_SESSION[$sessionluser][$i]['loginlock'] = $loginlock;
					$_SESSION[$sessionluser][$i]['weektime'] = $weektime;
					$_SESSION[$sessionluser][$i]['sourceip'] = $sourceip;
					$_SESSION[$sessionluser][$i]['memberid'] = $uid;
					$_SESSION[$sessionluser][$i]['appresourceid'] = $sid;
					
					$found = 1;
				}
			}
			if($found==0){
				$len = count($_SESSION[$sessionluser]);
				$_SESSION[$sessionluser][$len]['memberid'] = $uid;
				$_SESSION[$sessionluser][$len]['appresourceid'] = $sid;
				$_SESSION[$sessionluser][$len]['loginlock'] = $loginlock;
				$_SESSION[$sessionluser][$len]['weektime'] = $weektime;
				$_SESSION[$sessionluser][$len]['sourceip'] = $sourceip;
				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionluser]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}

	function appresourcegrp_selgroup(){
		$sid = get_request('sid');
		$gid = get_request('gid');
		$sessionlgroup= get_request('sessionlgroup', 0, 1);
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['appresourceid']==$sid){
					$lgroup[0] = $_SESSION[$sessionlgroup][$i];	
					break;
				}
			}
		if(empty($lgroup)){
			$lgroup = $this->lgroup_appresourcegrp_set->select_all('groupid='.$gid.' AND appresourceid='.$sid);
		}
		if(empty($lgroup)){
			$lgroup = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all(($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : '1'));
		$sourceip = $this->sourceip_set->select_all(" sourceip=''".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''));
		$this->assign('title', language('设置'));
		$this->assign("lgroup", $lgroup[0]);
		$this->assign("weektime", $weektime);
		$this->assign("sourceip", $sourceip);
		$this->assign("gid", $gid);
		$this->assign("sid", $sid);		
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->display('appresourcegrp_selgroup.tpl');
	}

	function appresourcegrp_selgroup_save(){
		$sid = get_request('sid', 1, 0);
		$gid = get_request('gid', 1, 0);
		$id = get_request('id', 1, 0);
		$loginlock = get_request('loginlock', 1, 1);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		if($loginlock == 'on') {
			$loginlock = 1;
		}
		else {
			$loginlock = 0;
		}
		if($id)
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if($_SESSION[$sessionlgroup][$i]['id']==$id){
				$_SESSION[$sessionlgroup][$i]['loginlock'] = $loginlock;
				$_SESSION[$sessionlgroup][$i]['weektime'] = $weektime;
				$_SESSION[$sessionlgroup][$i]['sourceip'] = $sourceip;
				$lgroup = new lgroup_appresourcegrp();
				$lgroup->set_data('loginlock', $_SESSION[$sessionlgroup][$i]['loginlock']);
				$lgroup->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
				$lgroup->set_data('sourceip', $_SESSION[$sessionlgroup][$i]['sourceip']);
				$lgroup->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
				$lgroup->set_data('appresourceid',$_SESSION[$sessionlgroup][$i]['appresourceid']);
				$lgroup->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
				$this->lgroup_appresourcegrp_set->edit($lgroup);
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['appresourceid']==$sid){
					$_SESSION[$sessionlgroup][$i]['loginlock'] = $loginlock;
					$_SESSION[$sessionlgroup][$i]['weektime'] = $weektime;
					$_SESSION[$sessionlgroup][$i]['sourceip'] = $sourceip;
					$_SESSION[$sessionlgroup][$i]['groupid'] = $gid;
					$_SESSION[$sessionlgroup][$i]['appresourceid'] = $sid;
					
					$found = 1;
				}
			}
			if($found==0){
				$len = count($_SESSION[$sessionlgroup]);
				$_SESSION[$sessionlgroup][$len]['groupid'] = $gid;
				$_SESSION[$sessionlgroup][$len]['appresourceid'] = $sid;
				$_SESSION[$sessionlgroup][$len]['loginlock'] = $loginlock;
				$_SESSION[$sessionlgroup][$len]['weektime'] = $weektime;
				$_SESSION[$sessionlgroup][$len]['sourceip'] = $sourceip;				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionlgroup]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}

	function appresourcegroup_bind($fromedit=null){
		global $_CONFIG;
		$webuser = get_request('webuser',0,1);
		$webgroup = get_request('webgroup',0,1);
		$id = get_request("id");
		$from = get_request('from', 0, 1);
		$sessionluser = 'APPRESOURCEGROUP_USER';
		$sessionlgroup = 'APPRESOURCEGROUP_GROUP';
		if(empty($id)&&$sid){
			}
		
		$ldapid1 = get_request('ldapid1',0,1);
		$ldapid2 = get_request('ldapid2',0,1);		
		$servergroup = get_request('servergroup',0,1);

		require_once('./include/select_sgroup_ajax.inc.php');
		if($ori_g_id){
			$_tmpgid = $this->sgroup_set->select_all("id IN(".(is_array($ori_g_id)?implode(',', $ori_g_id): $ori_g_id).")");
			$__tmpgid = $ori_g_id;
			for($i=0; $i<count($_tmpgid); $i++){
				$__tmpgid .= ','.$_tmpgid[$i]['child'];
			}
			$wheremember = ' AND groupid IN('.$__tmpgid.')';
			$wheregroup = ' AND id IN('.$__tmpgid.')';
		}

		$usergroup = $this->usergroup_set->select_all((empty($webgroup) ? '' : " groupname like '%$webgroup%' AND " ).'(select count(0) FROM '.$this->member_set->get_table_name().' where groupid='.$this->usergroup_set->get_table_name().'.id) >0 and 1=1 AND level=0 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).') ') : '').$wheregroup,'GroupName', 'ASC');		$this->assign('usergroup', $usergroup);

		$ginfo = $this->appresgroup_set->select_by_id($id);
		$allmem = $this->member_set->select_all("level!=11 ".(empty($webuser) ? '' : " AND username like '%$webuser%' " )." ".$wheremember." AND uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).')' : ''),'username','ASC');
		$_SESSION[$sessionluser] = $this->luser_appresourcegrp_set->select_all('appresourceid='.$id);
		$_SESSION[$sessionlgroup] = $this->lgroup_appresourcegrp_set->select_all('appresourceid='.$id);
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			$allbind[$i] = $_SESSION[$sessionluser][$i]['memberid'];
		}
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			$allgroup[$i] = $_SESSION[$sessionlgroup][$i]['groupid'];
		}
		$num = count($allmem);
		for($i=0;$i<$num;$i++) {
			if(count($allbind)==0) {
				break;
			}
			for($j=0;$j<count($allbind);$j++) {
				if($allmem[$i]['uid'] == $allbind[$j] ) {
					//array_shift($allbind);
					$allmem[$i]['check'] = 'checked';
					break;
				}
			}
		}
		//$allgroup = explode(',',trim($old_pass['lgroup'],','));
		$groupnum = count($usergroup);
		for($i=0;$i<$groupnum;$i++) {
			if(count($allgroup)==0) {
				break;
			}
			for($j=0;$j<count($allgroup);$j++) {
				if($usergroup[$i]['id'] == $allgroup[$j] ) {
					//array_shift($allgroup);
					$usergroup[$i]['check'] = 'checked';
					break;
				}
			}
		}
		$ginfo['devicesct']=count($allmem)+count($usergroup);
		$this->assign("id", $id);
		$this->assign("sessionlgroup", $sessionlgroup);
		$this->assign("sessionluser", $sessionluser);
		$this->assign("allmem", $allmem);
		$this->assign("ginfo", $ginfo);
		$this->assign("usergroup", $usergroup);
		$this->assign('allgroup', $usergroup);
		$this->assign('fromapp', $from);
		if(empty($fromedit))
		$this->display('appresourcegroup_bind.tpl');
	}

	function appresourcegroup_bindsave($id=null, $change=false){
		$sid = get_request("id");
		if(empty($sid)) $sid=$id;
		$sessionluser = get_request('sessionluser', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);

		$passcount = $this->member_set->select_count('1 = 1');
		$new_user = ',';
		$j = 0;
		for($i = 0;$i<$passcount;$i++) {
			if(0 != get_request("Check$i",1,0)) {
				$new_userid[] = get_request("Check$i",1,0);
				$j++;
			}
		}
		
		$new_group = ',';
		$j = 0;
		$gcount = $this->usergroup_set->select_count();
		for($i = 0;$i<$gcount;$i++) {
			if(0 != get_request("Group$i",1,0)) {
				$new_groupid[] = get_request("Group$i",1,0);
				$j++;
			}
		}
		if($change){
			if($new_userid)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where uid IN(".implode(',', $new_userid).")");
			if($new_groupid)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid IN(".implode(',', $new_groupid).")");
		}
		$this->appresourcegroup_luser_group_save($sessionluser, $sessionlgroup, $sid, $new_userid, $new_groupid);

		if(empty($id))
		alert_and_back('操作成功','admin.php?controller=admin_app&action=app_group');
	}

	private function appresourcegroup_luser_group_save($sessionluser, $sessionlgroup, $sid, $newuser, $newgroup){
		$user[]=0;
		$group[]=0;


		$appresgrp = $this->appresgroup_set->select_by_id($sid);

		$allusers = $this->luser_appresourcegrp_set->select_all("appresourceid='$sid'");
		for($i=0; $i<count($allusers); $i++){
			$alluserid[] = $allusers[$i]['memberid'];
		}
		$added = $newuser;
		if($alluserid&&$newuser){
			$added = array_diff($newuser, $alluserid);
			$removed = array_diff($alluserid, $newuser);
		}
		if(empty($newuser)){
			$removed = $alluserid;
		}

		if($added)
		foreach($added AS $k=>$v){
			$member = $this->member_set->select_by_id($v);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('luser', $member['username']);
			$adminlog->set_data('action', language('应用用户组绑定运维用户'));
			$adminlog->set_data('resource', $appresgrp['appgroupname']);
			$adminlog->set_data('type', 3);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
			if($member)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where uid=".$member['uid']);
		}

		if($removed)
		foreach($removed AS $k=>$v){
			$member = $this->member_set->select_by_id($v);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('luser', $member['username']);
			$adminlog->set_data('action', language('应用用户组解绑运维用户'));
			$adminlog->set_data('resource', $appresgrp['appgroupname']);
			$adminlog->set_data('type', 3);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
			if($member)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where uid=".$member['uid']);
		}
		$allgroups = $this->lgroup_appresourcegrp_set->select_all("appresourceid='$sid'");
		for($i=0; $i<count($allgroups); $i++){
			$allgroupid[] = $allgroups[$i]['groupid'];
		}
		$added = $newgroup;
		if($allgroupid&&$newgroup){
			$added = array_diff($newgroup, $allgroupid);
			$removed = array_diff($allgroupid, $newgroup);
		}
		if(empty($newgroup)){
			$removed = $allgroupid;
		}
		if($added)
		foreach($added AS $k=>$v){
			$ugroup = $this->usergroup_set->select_by_id($v);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('lgroup', $ugroup['groupname']);
			$adminlog->set_data('action', language('应用用户组绑定资源组'));
			$adminlog->set_data('resource', $appresgrp['appgroupname']);
			$adminlog->set_data('type', 4);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
			if($ugroup)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid=".$ugroup['id']);
		}
		if($removed)
		foreach($removed AS $k=>$v){
			$ugroup = $this->usergroup_set->select_by_id($v);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('lgroup', $ugroup['groupname']);
			$adminlog->set_data('action', language('应用用户组解绑资源组'));
			$adminlog->set_data('resource', $appresgrp['appgroupname']);
			$adminlog->set_data('type', 4);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
			if($ugroup)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid=".$ugroup['id']);
		}

		if(empty($newuser)){
			$newuser[0]=0;
		}		
		if(empty($newgroup)){
			$newgroup[0]=0;
		}

		$this->luser_appresourcegrp_set->query("DELETE FROM ".$this->luser_appresourcegrp_set->get_table_name()." WHERE memberid NOT IN(".implode(',', $newuser).") AND appresourceid=$sid");
		$this->lgroup_appresourcegrp_set->query("DELETE FROM ".$this->lgroup_appresourcegrp_set->get_table_name()." WHERE groupid NOT IN(".implode(',', $newgroup).") AND appresourceid=$sid");

		
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if(in_array($_SESSION[$sessionluser][$i]['memberid'], $newuser)){
				$appserverips = $this->luser_appresourcegrp_set->base_select("SELECT distinct appserverip FROM ".$this->appdevice_set->get_table_name()." a LEFT JOIN ".$this->apppub_set->get_table_name()." b ON a.apppubid=b.id WHERE a.id IS NOT NULL AND b.id IS NOT NULL AND a.id IN(select b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and a.id=".$_SESSION[$sessionluser][$i]['appresourceid']." union select appdevices.id from appresourcegroup c left join appresourcegroup d on c.appgroupname=d.appgroupname left join servers s on s.groupid=d.groupid left join appdevices on s.device_ip=appdevices.device_ip where c.appdevicesid=0 and d.appdevicesid=-1 and c.id=".$_SESSION[$sessionluser][$i]['appresourceid']." and d.id and appdevices.id and d.groupid AND IF(d.username='0', 1, d.username=appdevices.username))");
				for($ii=0; $ii<count($appserverips); $ii++){
					$apppubdevices = null;
					$apppubdevices = $this->devpass_set->select_all("device_ip='".$appserverips[$ii]['appserverip']."' AND login_method=26");
					if($apppubdevices) {
						$where = "devices.id=".$apppubdevices[0]['id']." AND member.uid=".$_SESSION[$sessionluser][$i]['memberid'];
						$sql  = "select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,luser.devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,luser.forbidden_commands_groups,luser.weektime,luser.autosu,luser.syslogalert,luser.mailalert,luser.loginlock from luser left join member on luser.memberid=member.uid left join devices on luser.devicesid=devices.id where member.uid and luser.devicesid AND $where";		
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,t.devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,devices.id devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,lgroup.devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,lgroup.forbidden_commands_groups,lgroup.weektime,lgroup.autosu,lgroup.syslogalert,lgroup.mailalert,lgroup.loginlock from lgroup left join member on lgroup.groupid=member.groupid left join devices on lgroup.devicesid=devices.id where member.uid and lgroup.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,t.devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,devices.id devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where ";
						$row_num = $this->server_set->base_select("select count(0) ct FROM ($sql)t");
						$row_num = $row_num[0]['ct'];
						if($row_num<=0){
							$_luser = new luser();
							$_luser->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
							$_luser->set_data('devicesid', $apppubdevices[0]['id']);
							$this->luser_set->add($_luser);
						}
					}
				}
				$luser = new luser_appresourcegrp();
				$luser->set_data('loginlock', $_SESSION[$sessionluser][$i]['loginlock']);
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);
				$luser->set_data('sourceip', $_SESSION[$sessionluser][$i]['sourceip']);
				$luser->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
				$luser->set_data('appresourceid', $_SESSION[$sessionluser][$i]['appresourceid']);
				if($_SESSION[$sessionluser][$i]['id']){
					$luser->set_data('id', $_SESSION[$sessionluser][$i]['id']);
					$this->luser_appresourcegrp_set->edit($luser);
				}else{
					$this->luser_appresourcegrp_set->add($luser);
				}
				$user[] = $_SESSION[$sessionluser][$i]['memberid'];
			}
		}
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if(in_array($_SESSION[$sessionlgroup][$i]['groupid'], $newgroup)){
				$appserverips = $this->luser_appresourcegrp_set->base_select("SELECT distinct appserverip FROM ".$this->appdevice_set->get_table_name()." a LEFT JOIN ".$this->apppub_set->get_table_name()." b ON a.apppubid=b.id WHERE a.id IS NOT NULL AND b.id IS NOT NULL AND a.id IN(select d.appdevicesid from appresourcegroup c left join appresourcegroup d on c.appgroupname=d.appgroupname where c.appdevicesid=0 and c.id=".$_SESSION[$sessionlgroup][$i]['appresourceid']." union select appdevices.id from appresourcegroup c left join appresourcegroup d on c.appgroupname=d.appgroupname left join servers s on s.groupid=d.groupid left join appdevices on s.device_ip=appdevices.device_ip where c.appdevicesid=0 and d.appdevicesid=-1 and c.id=".$_SESSION[$sessionlgroup][$i]['appresourceid']." and d.id and appdevices.id and d.groupid AND IF(d.username='0', 1, d.username=appdevices.username))");
				for($ii=0; $ii<count($appserverips); $ii++){
					$apppubdevices = null;
					$apppubdevices = $this->devpass_set->select_all("device_ip='".$appserverips[$ii]['appserverip']."' AND login_method=26");
					if($apppubdevices) {
						$where = "t.devicesid=".$apppubdevices[0]['id']." AND t.groupid=".$_SESSION[$sessionlgroup][$i]['groupid'];
						$sql = " select distinct devicesid from lgroup t where t.devicesid AND $where";					
						$where = "t.devicesid=".$apppubdevices[0]['id']." AND a.groupid=".$_SESSION[$sessionlgroup][$i]['groupid'];
						$sql .= " union select distinct devicesid from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0) t on a.resourceid=t.id where t.id and t.devicesid AND $where";						
						$where = "devices.id=".$apppubdevices[0]['id']." AND a.groupid=".$_SESSION[$sessionlgroup][$i]['groupid'];
						$sql .= " union select distinct devices.id from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where ";
						$row_num = $this->server_set->base_select("select count(0) ct FROM ($sql)t");
						$row_num = $row_num[0]['ct'];
						if($row_num<=0){
							$_luser = new lgroup();
							$_luser->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
							$_luser->set_data('devicesid', $apppubdevices[0]['id']);
							$this->lgroup_set->add($_luser);
						}
					}
				}
				$lgroup = new lgroup_appresourcegrp();
				$lgroup->set_data('loginlock', $_SESSION[$sessionlgroup][$i]['loginlock']);
				$lgroup->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
				$lgroup->set_data('sourceip', $_SESSION[$sessionlgroup][$i]['sourceip']);
				$lgroup->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
				$lgroup->set_data('appresourceid',$_SESSION[$sessionlgroup][$i]['appresourceid']);	
				
				if($_SESSION[$sessionlgroup][$i]['id']){
					$lgroup->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
					$this->lgroup_appresourcegrp_set->edit($lgroup);
				}else{
					$this->lgroup_appresourcegrp_set->add($lgroup);
				}
				$group[] = $_SESSION[$sessionlgroup][$i]['groupid'];
			}
		}
		if($newuser)
		$u = array_diff($newuser, $user);
		if($newgroup)
		$g = array_diff($newgroup, $group);
		
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		
		if($u)
		foreach($u AS $key => $value){
			$appserverips = $this->luser_appresourcegrp_set->base_select("SELECT distinct appserverip FROM ".$this->appdevice_set->get_table_name()." a LEFT JOIN ".$this->apppub_set->get_table_name()." b ON a.apppubid=b.id WHERE a.id IS NOT NULL AND b.id IS NOT NULL AND a.id IN(select d.appdevicesid from appresourcegroup c left join appresourcegroup d on c.appgroupname=d.appgroupname where c.appdevicesid=0 and d.appdevicesid>0 and c.id=".$sid." union select appdevices.id from appresourcegroup c left join appresourcegroup d on c.appgroupname=d.appgroupname left join servers s on s.groupid=d.groupid left join appdevices on s.device_ip=appdevices.device_ip where c.appdevicesid=0 and d.appdevicesid=-1 and c.id=".$sid." and d.id and appdevices.id and d.groupid AND IF(d.username='0', 1, d.username=appdevices.username) )");
				for($ii=0; $ii<count($appserverips); $ii++){
					$apppubdevices = null;
					$apppubdevices = $this->devpass_set->select_all("device_ip='".$appserverips[$ii]['appserverip']."' AND login_method=26");
					if($apppubdevices){
						$where = "devices.id=".$apppubdevices[0]['id']." AND member.uid=".$value;
						$sql  = "select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,luser.devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,luser.forbidden_commands_groups,luser.weektime,luser.autosu,luser.syslogalert,luser.mailalert,luser.loginlock from luser left join member on luser.memberid=member.uid left join devices on luser.devicesid=devices.id where member.uid and luser.devicesid AND $where";		
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,t.devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,devices.id devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,lgroup.devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,lgroup.forbidden_commands_groups,lgroup.weektime,lgroup.autosu,lgroup.syslogalert,lgroup.mailalert,lgroup.loginlock from lgroup left join member on lgroup.groupid=member.groupid left join devices on lgroup.devicesid=devices.id where member.uid and lgroup.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,t.devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,devices.id devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where ";
						$row_num = $this->server_set->base_select("select count(0) ct FROM ($sql)t");
						$row_num = $row_num[0]['ct'];
						if($row_num<=0){
							$_luser = new luser();
							$_luser->set_data('memberid', $value);
							$_luser->set_data('devicesid', $apppubdevices[0]['id']);
							$this->luser_set->add($_luser);
						}	
					}
				}
			$luser = new luser_appresourcegrp();
			$luser->set_data('loginlock', $dp['loginlock']);
			$luser->set_data('weektime', $dp['weektime']);
			$luser->set_data('sourceip', $dp['sourceip']);
			$luser->set_data('memberid', $value);
			$luser->set_data('appresourceid', $sid);
			$this->luser_appresourcegrp_set->add($luser);

		}
		if($g)
		foreach($g AS $key => $value){
			$appserverips = $this->luser_appresourcegrp_set->base_select("SELECT distinct appserverip FROM ".$this->appdevice_set->get_table_name()." a LEFT JOIN ".$this->apppub_set->get_table_name()." b ON a.apppubid=b.id WHERE a.id IS NOT NULL AND b.id IS NOT NULL AND a.id IN(select b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and a.id=".$sid." union select appdevices.id from appresourcegroup c left join appresourcegroup d on c.appgroupname=d.appgroupname left join servers s on s.groupid=d.groupid left join appdevices on s.device_ip=appdevices.device_ip where c.appdevicesid=0 and d.appdevicesid=-1 and c.id=".$sid." and d.id and appdevices.id and d.groupid AND IF(d.username='0', 1, d.username=appdevices.username))");
				for($ii=0; $ii<count($appserverips); $ii++){
					$apppubdevices = null;
					$apppubdevices = $this->devpass_set->select_all("device_ip='".$appserverips[$ii]['appserverip']."' AND login_method=26");
					if($apppubdevices){
						$where = "t.devicesid=".$apppubdevices[0]['id']." AND t.groupid=".$value;
						$sql = " select distinct devicesid from lgroup t where t.devicesid AND $where";						
						$where = "t.devicesid=".$apppubdevices[0]['id']." AND a.groupid=".$value;
						$sql .= " union select distinct devicesid from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 ) t on a.resourceid=t.id where t.id and t.devicesid AND $where";
						$where = "devices.id=".$apppubdevices[0]['id']." AND a.groupid=".$value;
						$sql .= " union select distinct devices.id from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where ";
						$row_num = $this->server_set->base_select("select count(0) ct FROM ($sql)t");
						$row_num = $row_num[0]['ct'];
						if($row_num<=0){
							$_luser = new lgroup();
							$_luser->set_data('groupid', $value);
							$_luser->set_data('devicesid', $apppubdevices[0]['id']);
							$this->lgroup_set->add($_luser);
						}
					}
				}
			$lgroup = new lgroup_appresourcegrp();
			$lgroup->set_data('loginlock', $dp['loginlock']);
			$lgroup->set_data('weektime', $dp['weektime']);
			$lgroup->set_data('sourceip', $dp['sourceip']);
			$lgroup->set_data('groupid', $value);
			$lgroup->set_data('appresourceid', $sid);
			$this->lgroup_appresourcegrp_set->add($lgroup);
		}

		unset($_SESSION[$sessionluser]);
		unset($_SESSION[$sessionlgroup]);
	} 

	function applogin(){
		$id = get_request('id');
		$appserverip = get_request('appserverip', 0, 1);
		$p = $this->applogin_set->select_all("appdeviceid=".$id);
		$this->assign("p", $p[0]);
		$this->assign("appserverip", $appserverip);
		$this->assign("appdeviceid", $id);
		$this->display('applogin_edit.tpl');
	}

	function applogin_save(){
		$ip = get_request('ip', 0, 1);
		$device_ip = get_request('device_ip', 0, 1);
		$appdeviceid = get_request('appdeviceid', 0, 1);
		$title = get_request('title', 1, 1);
		$cTagname = get_request('cTagname', 1, 1);
		$cTagAttributeType = get_request('cTagAttributeType', 1, 1);
		$cTagAttributeValue = get_request('cTagAttributeValue', 1, 1);
		$uTagname = get_request('uTagname', 1, 1);
		$uTagAttributeType = get_request('uTagAttributeType', 1, 1);
		$uTagAttributeValue = get_request('uTagAttributeValue', 1, 1);
		$pTagname = get_request('pTagname', 1, 1);
		$pTagAttributeType = get_request('pTagAttributeType', 1, 1);
		$pTagAttributeValue = get_request('pTagAttributeValue', 1, 1);
		$id = get_request('id', 1, 1);
		$applogin = new applogin();
		$applogin->set_data('title', $title);
		$applogin->set_data('appdeviceID', $appdeviceid);
		$applogin->set_data('cTagname', $cTagname);
		$applogin->set_data('cTagAttributeType', $cTagAttributeType);
		$applogin->set_data('cTagAttributeValue', $cTagAttributeValue);
		$applogin->set_data('uTagname', $uTagname);
		$applogin->set_data('uTagAttributeType', $uTagAttributeType);
		$applogin->set_data('uTagAttributeValue', $uTagAttributeValue);
		$applogin->set_data('pTagname', $pTagname);
		$applogin->set_data('pTagAttributeType', $pTagAttributeType);
		$applogin->set_data('pTagAttributeValue', $pTagAttributeValue);
		if($id){
			$applogin->set_data('uid', $id);
			$this->applogin_set->edit($applogin);
		}else{
			$this->applogin_set->add($applogin);
		}
		
		alert_and_back('操作成功','admin.php?controller=admin_config&action=apppub_list&ip='.$ip."&device_ip=".$device_ip);
	}

	function recopyhtml(){
		$appserverip =  get_request('appserverip', 0, 1);
		$this->assign("appserverip", $appserverip);
		$this->display("recopyhtml.tpl");
	}

	function recopy(){
		$newappserverip = get_request('newappserverip', 1, 1);
		$newappserverhostname = get_request('newappserverhostname', 1, 1);
		$description = get_request('description', 1, 1);
		$appserverip = get_request('appserverip', 0, 1);
		$apppubexist = $this->devpass_set->select_all("device_ip='$appserverip' AND login_method=26");
		$appserveripexist = $this->appserver_set->select_all("appserverip='$newappserverip'");
		if(empty($appserveripexist)){
			$newappserver = new appserver();
			$newappserver->set_data('name', $newappserverhostname);
			$newappserver->set_data('appserverip', $newappserverip);
			$newappserver->set_data('description', $description);
			$this->appserver_set->add($newappserver);
		}
		$serveripexist = $this->server_set->select_all("device_ip='$newappserverip'");
		if(empty($serveripexist)){
			$newserver = new server();
			$newserver->set_data('device_ip', $newappserverip);
			$newserver->set_data('hostname', $newappserverhostname);
			$this->server_set->add($newserver);
		}else{
			$newappserverhostname=$serveripexist[0]['hostname'];
		}
		$newapppubexist = $this->devpass_set->select_all("device_ip='$newappserverip' AND login_method=26");
		$deviceid = $newapppubexist[0]['id'];
		if(!($newapppubexist)&&$apppubexist){
			$this->devpass_set->query("INSERT devices(device_ip,login_method,hostname,username,old_password,cur_password,last_update_time,port,device_type,enable,limit_time,automodify,luser,master_user,log_tab,passwordtry,changesure,lgroup,autosu,entrust_password,change_password,entrust_username,publickey_auth,radiususer,encoding,sshprivatekey,sshpublickey,sftp,first_prompt,logincommit,commanduser,x11,`desc`,mode,new_password,active_change,su_passwd,restrictweb,timeout,ipv6,ipv6enable,key_input,fastpath_input,fastpath_output,su_password) select '".$newappserverip."',login_method,'".$newappserverhostname."',username,old_password,cur_password,last_update_time,port,device_type,enable,limit_time,automodify,luser,master_user,log_tab,passwordtry,changesure,lgroup,autosu,entrust_password,change_password,entrust_username,publickey_auth,radiususer,encoding,sshprivatekey,sshpublickey,sftp,first_prompt,logincommit,commanduser,x11,`desc`,mode,new_password,active_change,su_passwd,restrictweb,timeout,ipv6,ipv6enable,key_input,fastpath_input,fastpath_output,su_password from devices where id=".$apppubexist[0]['id']." limit 1");
			$deviceid = mysql_insert_id();
			if(empty($deviceid)) {
				echo '<script>alert("操作失败");window.parent.location.reload();</script>';
				return ;
			}	
		}
		$this->luser_set->query("INSERT INTO luser(memberid,devicesid,autosu,weektime,sourceip,forbidden_commands_groups,syslogalert,mailalert,loginlock,rdpdiskauth_up,rdpclipauth_up,twoauth,rdpdiskauth_down,rdpclipauth_down,workflow,wf_user1,wf_user2,wf_user3,wf_user4,wf_user5,smsalert) SELECT memberid,$deviceid,autosu,weektime,sourceip,forbidden_commands_groups,syslogalert,mailalert,loginlock,rdpdiskauth_up,rdpclipauth_up,twoauth,rdpdiskauth_down,rdpclipauth_down,workflow,wf_user1,wf_user2,wf_user3,wf_user4,wf_user5,smsalert FROM luser a WHERE devicesid=".$apppubexist[0]['id']." and not exists(select * from luser where devicesid=$deviceid and memberid=a.memberid)");
		$this->lgroup_set->query("INSERT INTO lgroup(groupid,devicesid,autosu,weektime,sourceip,forbidden_commands_groups,syslogalert,mailalert,loginlock,rdpdiskauth_up,rdpclipauth_up,twoauth,rdpdiskauth_down,rdpclipauth_down,workflow,wf_user1,wf_user2,wf_user3,wf_user4,wf_user5,smsalert) SELECT groupid,$deviceid,autosu,weektime,sourceip,forbidden_commands_groups,syslogalert,mailalert,loginlock,rdpdiskauth_up,rdpclipauth_up,twoauth,rdpdiskauth_down,rdpclipauth_down,workflow,wf_user1,wf_user2,wf_user3,wf_user4,wf_user5,smsalert FROM lgroup a WHERE devicesid=".$apppubexist[0]['id']." and not exists(select * from lgroup where devicesid=$deviceid and groupid=a.groupid)");
		$this->resgroup_set->query("INSERT INTO resourcegroup(groupname,devicesid,user,`desc`,groupid,username) SELECT groupname,$deviceid,user,`desc`,groupid,username FROM resourcegroup a WHERE devicesid=".$apppubexist[0]['id']." and not exists(select * from resourcegroup where devicesid=$deviceid and groupname=a.groupname)");

		$appubs = $this->apppub_set->select_all("appserverip='$appserverip'");
		for($i=0; $i<count($appubs); $i++){
			$appdevice = $this->appdevice_set->select_all("apppubid=".$appubs[$i]['id']);
			$newapppub = new apppub();
			$newapppub->set_data('name', $appubs[$i]['name']);
			$newapppub->set_data('appserverip', $newappserverip);
			$newapppub->set_data('path', addslashes($appubs[$i]['path']));
			$newapppub->set_data('appprogramname', $appubs[$i]['appprogramname']);
			$newapppub->set_data('description', $appubs[$i]['description']);	
			$newapppub->set_data('autologinflag', $appubs[$i]['autologinflag']);
			$newapppub->set_data('url', $appubs[$i]['url']);	
			$newapppub->set_data('dynamicFlag', $appubs[$i]['dynamicFlag']);
			$this->apppub_set->add($newapppub);
			$appubid = mysql_insert_id();
			if(empty($appubid)) {
				echo '<script>alert("操作失败");window.parent.location.reload();</script>';
				return ;
			}
			
			$newappdeviceid = new appdevice();
			$newappdeviceid->set_data('apppubid', $appubid);
			$newappdeviceid->set_data('device_ip', $appdevice[0]['device_ip']);
			$newappdeviceid->set_data('username', $appdevice[0]['username']);
			$newappdeviceid->set_data('old_password', $appdevice[0]['old_password']);
			$newappdeviceid->set_data('cur_password', $appdevice[0]['cur_password']);
			$newappdeviceid->set_data('last_update_time', $appdevice[0]['last_update_time']);
			$newappdeviceid->set_data('change_password',$appdevice[0]['change_password']);
			$newappdeviceid->set_data('enable',$appdevice[0]['enable']);	
			$newappdeviceid->set_data('oracle_auth',$appdevice[0]['oracle_auth']);
			$newappdeviceid->set_data('oracle_db', $appdevice[0]['oracle_db']);
			$newappdeviceid->set_data('oracle_name', $appdevice[0]['oracle_name']);
			$newappdeviceid->set_data('entrust_password', $appdevice[0]['entrust_password']);
			$this->appdevice_set->add($newappdeviceid);
			$appdeviceid = mysql_insert_id();
			if(empty($appdeviceid)) {
				echo '<script>alert("操作失败");window.parent.location.reload();</script>';
				return ;
			}

			$this->appmember_set->query("INSERT INTO appmember(memberid,appdeviceid) SELECT memberid, $appdeviceid FROM appmember WHERE appdeviceid=".$appdevice[0]['id']);
			$this->appmember_set->query("INSERT INTO appgroup(groupid,appdeviceid,workflow,wf_user1,wf_user2,wf_user3,wf_user4,wf_user5) SELECT groupid, $appdeviceid,workflow,wf_user1,wf_user2,wf_user3,wf_user4,wf_user5 FROM appgroup WHERE appdeviceid=".$appdevice[0]['id']);
			$this->appmember_set->query("INSERT INTO appresourcegroup(appdevicesid,appgroupname,user,`desc`,groupid,username) SELECT $appdeviceid,appgroupname,user,`desc`,groupid,username FROM appresourcegroup WHERE appdevicesid=".$appdevice[0]['id']);

			/*$appmember  = $this->appmember_set->select_all("appdeviceid=".$appdevice[0]['id']);
			for($i=0; $i<count($appmember); $i++){
				$newappmember = new appmember();
				$newappmember->set_data('memberid', $appmember[$i]['memberid']);
				$newappmember->set_data('appdeviceid', $appdeviceid);
				$this->appmember_set->add($newappmember);
			}
			$appgroup   = $this->appgroup_set->select_all("appdeviceid=".$appdevice[0]['id']);
			for($i=0; $i<count($appgroup); $i++){
				$newappgroup = new appgroup();
				$newappgroup->set_data('groupid', $appgroup[$i]['groupid']);
				$newappgroup->set_data('workflow', $appgroup[$i]['workflow']);
				$newappgroup->set_data('wf_user1', $appgroup[$i]['wf_user1']);
				$newappgroup->set_data('wf_user2', $appgroup[$i]['wf_user2']);
				$newappgroup->set_data('wf_user3', $appgroup[$i]['wf_user3']);
				$newappgroup->set_data('wf_user4', $appgroup[$i]['wf_user4']);
				$newappgroup->set_data('wf_user5', $appgroup[$i]['wf_user5']);
				$newappgroup->set_data('appdeviceid', $appdeviceid);
				$this->appgroup_set->add($newappgroup);
			}
			$appresouce = $this->appresgroup_set->select_all("appdeviceid=".$appdevice[0]['id']);
			for($i=0; $i<count($appresouce); $i++){
				$newappgroup = new appresgroup();
				$newappgroup->set_data('appgroupname', $appresgroup[$i]['appgroupname']);
				$newappgroup->set_data('user', $appresgroup[$i]['user']);
				$newappgroup->set_data('desc', $appresgroup[$i]['desc']);
				$newappgroup->set_data('groupid', $appresgroup[$i]['groupid']);
				$newappgroup->set_data('username', $appresgroup[$i]['username']);
				$newappgroup->set_data('appdevicesid', $appdeviceid);
				$this->appresgroup_set->add($newappgroup);
			}*/
		}
		echo '<script>alert("操作成功");window.parent.location.reload();</script>';
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

	function Array2File($aIn, $sFileOut) {
	  return ($this->String2File(implode("", $aIn), $sFileOut));
	}
}
?>
