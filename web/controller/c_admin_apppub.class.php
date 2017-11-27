<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_apppub extends c_base {
	function index($where = NULL, $interface=false) {
		global $_CONFIG;
		
		$backupdb_id = get_request('backupdb_id');
		if(!empty($backupdb_id)){
			$backupdb = $this->backup_setting_set->select_by_id($backupdb_id);
			$dbhost = $backupdb['ip'];
			$dbuser = $backupdb['mysqluser'];
			$dbpwd = $this->backup_setting_set->udf_decrypt($backupdb['mysqlpasswd']);
			$dbname = $backupdb['dbname'];
			$dbcharset = 'utf8';
			$link = mysql_connect($dbhost, $dbuser, $dbpwd) ;
			if(empty($link)){
				alert_and_close('目标服务器无法访问');
				exit;
			}
			$rs = mysql_select_db($dbname);
			if(empty($rs)){
				alert_and_close('目标服务器没有数据库');
				exit;
			}
			mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary");
			$this->assign("backupdb_id", $backupdb_id);
		}
		//$table_name = get_request('table_name', 0, 1);
		//if($table_name) {
		//	$this->session_set->set_table_name($table_name);
		//}
		//else {
		//	$table_name = $this->session_set->get_table_name();
		//}
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$this->assign('member', $member);
		

		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$mstsc = get_request('mstsc');
		$where = " WHERE httpurl=0 and d.id is not null and d.id>0 ";

		
		$s_addr = get_request('s_addr', 0, 1);
		$appserverip = get_request('appserverip', 0, 1);
		$addr = get_request('addr', 0, 1);
		$appname = get_request('appname', 0, 1);
		$apppath = get_request('apppath', 0, 1);
		$sqltext = get_request('sqltext', 0, 1);
		$luser = get_request('luser', 0, 1);
		$user = get_request('user', 0, 1);
		$username = get_request('username', 0, 1);
		$realname = get_request('realname', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$sid1 = get_request('sid1', 0, 1);
		$sid2 = get_request('sid2', 0, 1);
		$start1 = get_request('start1', 0, 1);
		$end1 = get_request('end1', 0, 1);
		$start2 = get_request('start2', 0, 1);
		$end2 = get_request('end2', 0, 1);
		$command = get_request('command', 0, 1);
		$serverip = get_request('serverip', 0, 1);
		$sid = get_request('sid', 0, 1);
		
		if($s_addr) {
			if(is_ip($serverip)) {
				$where .= " AND d.cli_addr = '$s_addr'";
			}
			else {
				$where .= " AND d.cli_addr LIKE '%$s_addr%'";
			}
		}

		if($addr) {
			if(is_ip($addr)) {
				$where .= " AND a.addr = '$addr'";
			}
			else {
				$where .= " AND a.addr LIKE '%$addr%'";
			}
		}
	
		if($username){
			$where .= " AND a.memberid='".$username."'";
		}

		if($sqltext){
			$where .= " AND exists(select * from ".$this->plsqlhistory_set->get_table_name()." where appcommids=a.id AND sqltext like '%".$sqltext."%')";
		}

		if($realname){
			$where .= " AND m.realname='".$realname."'";
		}

		if($user){
			$where .= " AND m.username='".$user."'";
		}

		if($appname){
			$where .= " AND a.appname like '%".$appname."%'";
		}

		if($serverip){
			$where .= " AND a.serverip like '%".$serverip."%'";
		}

		if($apppath){
			$where .= " AND a.apppath like '%".$apppath."%'";
		}


		$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
		$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
		$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID'];
		$sql .= ")";
		$sql .= " union select distinct devices.id devicesid from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and  a.memberid=" . $_SESSION['ADMIN_UID'];
		$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP'];
		$sql .= ")";
		$sql .= " union select distinct devices.id devicesid from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=" . $_SESSION['ADMIN_GROUP'];
		$alldevid = $this->member_set->base_select($sql);
		for($i=0; $i<count($alldevid); $i++){
			$alldevsid[]=$alldevid[$i]['devicesid'];
		}

		if(empty($alldevsid)){
			$alldevsid[] = 0;
		}
		if($_SESSION['ADMIN_LEVEL'] == 0 ) {
			//$where .= " AND  LEFT(a.addr,IF(LOCATE(':',a.addr)>0,LOCATE(':',a.addr)-1,LENGTH(a.addr))) IN (SELECT device_ip FROM ".$this->devpass_set->get_table_name()." WHERE id IN (".implode(",",$alldevsid).")) and luser='".$_SESSION['ADMIN_USERNAME']."'";
			$where .= " AND memberid='".$_SESSION['ADMIN_UID']."'";
		}
		elseif($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			//$oldmem = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			//$where .= " AND d_addr IN (SELECT device_ip FROM servers WHERE groupid = ".$oldmem['mservergroup']." )";
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
					if($alltmpip)
					$where .= " AND LEFT(d.addr,IF(LOCATE(':',d.addr)>0,LOCATE(':',d.addr)-1,LENGTH(d.addr))) IN ('".implode("','", $alltmpip)."')";
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
		$multipleselect=1;
		require_once('./include/select_sgroup_ajax.inc.php');

		if($g_id){
			$alltmpip = array(0);
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$alltmpip[]=$allips[$i]['device_ip'];
			}
			if($alltmpip)
			$where .= " AND LEFT(a.addr,IF(LOCATE(':',a.addr)>0,LOCATE(':',a.addr)-1,LENGTH(a.addr))) IN ('".implode("','", $alltmpip)."')";
		}

		if(empty($orderby1)){
			$orderby1 = 'start';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($sid1 !== NULL && $sid2 !== NULL) {
			$where .= " AND (sid >= $sid1 AND sid <= $sid2)";
		}

		if($start1 ) {
			$where .= " AND (a.start >= '$start1') ";
		}



		if($start2 ) {
			$where .= " AND (a.start <= '$start2') ";
		}

		if ($end2) {
            $where .= " AND (end <= '$end2') ";
        }

		if($end1 && $end2) {
			$where .= " AND (a.end >= '$end1' AND a.end <= '$end2')";
		}

		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete($where);
			}
			else {
				die('æ²¡ææé');
			}
		}else if($mstsc){
			$this->mstsc($sid);
			
		}
		else {		
			//$table_list = $this->get_table_list();

			$curr_url = $_SERVER['PHP_SELF'] . "?";
			if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
				$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
			}
			else {
				$curr_url .= $_SERVER['QUERY_STRING'];
			
			}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			//echo $curr_url;
			
			$row_num = $this->appcomm_set->base_select("SELECT count(*) ct FROM ".$this->appcomm_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." m ON a.memberid=m.uid LEFT JOIN ".$this->apprecord_set->get_table_name()." d ON a.sid=d.id $where and a.sid > 0");
			$row_num = $row_num[0]['ct']; //LEFT JOIN ".$this->plsqlhistory_set->get_table_name()." e ON a.id=e.appcommids
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$allsession=$this->appcomm_set->base_select("SELECT a.*,m.username,m.realname,d.replayname FROM ".$this->appcomm_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." m ON a.memberid=m.uid LEFT JOIN ".$this->apprecord_set->get_table_name()." d ON a.sid=d.id $where and a.sid > 0  ORDER BY $orderby1 $orderby2  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage ");
			if($interface) return $allsession;
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('allsession', $allsession);

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			global $_CONFIG;		
			$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
			if(($msiepos=strpos($_SERVER['HTTP_USER_AGENT'], "Windows NT"))>0){
				$this->assign("windows_version", floatval(substr($_SERVER['HTTP_USER_AGENT'], $msiepos+10, strpos($_SERVER['HTTP_USER_AGENT'], ";", $msiepos+1)-$msiepos-10)));
			}
			$usergroup = $this->usergroup_set->select_all(" level=0 and attribute!=1".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).') ') : ''), 'groupname', 'asc');
			$this->assign('usergroup', $usergroup);
			$this->assign('allgroup', $usergroup);
			$this->display("apppubsession_list.tpl");
		}
	}

	function view($interface=false) {
		$sid = get_request('sid');
		$addr = get_request('addr', 0, 1);
		$luser = get_request('luser', 0, 1);
		$url = get_request('url', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$where = "where httpurl=1 ";
		if($sid) $where .= " and a.sid = '$sid' ";
		$page_num = get_request('page');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->appcomm_set->select_all("sid=".$sid)){
				if($row[0]['memberid']!=$_SESSION['ADMIN_UID']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}		
		if($addr){
			$where .= " and d.addr like '%$addr%'";
		}
		if($luser){
			$where .= " and m.username like '%$luser%'";
		}
		if($url){
			$where .= " and a.url like '%$url%'";
		}
		if(empty($orderby1)){
			$orderby1 = 'start';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		
		$row_num = $this->appcomm_set->base_select("SELECT count(*) ct FROM ".$this->appcomm_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." m ON a.memberid=m.uid $where and a.sid > 0");
		$row_num = $row_num[0]['ct']; //LEFT JOIN ".$this->plsqlhistory_set->get_table_name()." e ON a.id=e.appcommids
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$allcommand=$this->appcomm_set->base_select("SELECT a.*,m.username,m.realname FROM ".$this->appcomm_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." m ON a.memberid=m.uid LEFT JOIN ".$this->apprecord_set->get_table_name()." d ON a.sid=d.id $where and a.sid > 0  ORDER BY $orderby1 $orderby2  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage ");
		if($interface) return $allcommand;
		for($i = 0; $i < count($allcommand); $i++) {
			$ymdtime = trim($allcommand[$i]['start']);
			$ymd = substr($ymdtime, 0, 10);
			$time = substr($ymdtime, 11, 8);//var_dump($ymd);var_dump($time);
			$ymd = explode('-', $ymd);
			$time = explode(':', $time);
			$allcommand[$i]['ustart'] = mktime(intval($time[0]),intval($time[1]),intval($time[2]),intval($ymd[1]),intval($ymd[2]),intval($ymd[0]));
		}
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);

		$this->assign('allcommand', $allcommand);
		$this->assign('sid', $sid);

		$this->display('apppubsession_view.tpl');
	}

	function sqlview($interface=false) {
		$sid = get_request('sid');
		$addr = get_request('addr', 0, 1);
		$luser = get_request('luser', 0, 1);
		$url = get_request('url', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$where = "where 11 ";
		if($sid) $where .= " and appcommids = '$sid' ";
		$page_num = get_request('page');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->appcomm_set->select_all("sid=".$sid)){
				if($row[0]['memberid']!=$_SESSION['ADMIN_UID']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}		
		if($addr){
			$where .= " and d.addr like '%$addr%'";
		}
		if($luser){
			$where .= " and m.username like '%$luser%'";
		}
		if($url){
			$where .= " and a.url like '%$url%'";
		}
		if(empty($orderby1)){
			$orderby1 = 'excutetime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		
		$row_num = $this->app_navicat_sql_log_set->base_select("SELECT count(*) ct FROM ".$this->app_navicat_sql_log_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." m ON a.memberid=m.uid $where and a.id > 0");
		$row_num = $row_num[0]['ct']; //LEFT JOIN ".$this->plsqlhistory_set->get_table_name()." e ON a.id=e.appcommids
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$allcommand=$this->app_navicat_sql_log_set->base_select("SELECT a.*,m.username,m.realname FROM ".$this->app_navicat_sql_log_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." m ON a.memberid=m.uid  $where and a.id > 0  ORDER BY $orderby1 $orderby2  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage ");
		if($interface) return $allcommand;
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);

		$this->assign('allcommand', $allcommand);
		$this->assign('sid', $sid);

		$this->display('apppubsql_view.tpl');
	}
	
	function downloadplayfile(){
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->appcomm_set->select_all("sid=".$sid)){
				if($row[0]['memberid']!=$_SESSION['ADMIN_UID']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$sessions = $this->apprecord_set->select_by_id($sid);
		if(!file_exists(str_replace("\"", "", $sessions['replayname']))){
			alert_and_back('录像文件不存在');
			exit;
		}
		$sessions['replayname']=str_replace("\"", "", $sessions['replayname']);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$sessions['replayname']);
		echo file_get_contents($sessions['replayname']);
		exit();
	}

	function search() {
		//$table_list = $this->get_table_list();
		//$this->assign('table_list', $table_list);
		$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
		$alltmpip = array(-1);
		$alltmpuser = array(-1);
		for($i=0; $i<count($allips); $i++){
			$alltmpip[]=$allips[$i]['device_ip'];
		}
		$appserverips = $this->appserver_set->select_all("1".(($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) ? ' AND appserverip IN("'.implode('","', $alltmpip).'")' : ''), 'appserverip', 'asc');
		$apppub = $this->apppub_set->select_all("1", 'name', 'asc');

		$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
		for($i=0; $i<count($allusers); $i++){
			$alltmpuser[]=$allusers[$i]['username'];
		}
		$members = $this->member_set->select_all("1".(($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) ? ' AND username IN("'.implode('","', $alltmpuser).'")' : ''), 'username', 'asc');
		$usernames = $this->appdevice_set->select_all("1", 'username', 'asc');
		$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
		$this->assign("appservers", $appserverips);
		$this->assign("apppub", $apppub);
		$this->assign("members", $members);
		$this->assign("usernames", $usernames);
		$this->display("apppub_search.tpl");
	}
	
	function get_eth0_ip($method='rdp') {
	
		global $_CONFIG;
		$eth0 = explode(":", $_SERVER["HTTP_HOST"]);
		if(!empty($_CONFIG['RDPPLAYIP'])){
			$eth0[0]=$_CONFIG['RDPPLAYIP'];
		}
		return array('eth0'=>$eth0[0]);
		$filename = $_CONFIG['CONFIGFILE']['IFGETH0'];
		//$filename = 'controller/ifcfg-eth0';
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
	
	function mstsc($sid){
		global $_CONFIG;
		$replaystime = get_request('replaystime', 0, 1);
		$row=$this->appcomm_set->select_all("sid=".$sid);
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row){
				if($row[0]['memberid']!=$_SESSION['ADMIN_UID']){
					echo('alert("您没有权限查看");');
					exit;
				}
			}
		}
		//echo '<a href="tmp/rdpfile.rdp">编号:'.$sid.'右键另存为</a>';
		$s = $row[0];
		
		$proxyips = $this->proxyip_set->select_all("source!='0.0.0.0'");
		$outip = $this->proxyip_set->select_all("source='0.0.0.0'");
		$eth0 = $outip[0]['proxyip'];
		$guestaddr = ip2long($_SERVER['REMOTE_ADDR']);
		for($i=0; $i<count($proxyips); $i++){
			//long2ip(ip2long('192.168.1.2')&ip2long('255.255.255.0'))
			if(long2ip($guestaddr&ip2long($proxyips[$i]['network']))==$proxyips[$i]['source']){
				$eth0 = $proxyips[$i]['proxyip'];
			}
		}
		$a = $this->get_eth0_ip();
		if(empty($eth0)){
			$eth0 = $a['eth0'];
		}
		$s['proxy_addr'] = $eth0;
		$r = $this->apprecord_set->select_by_id($s['sid']);
		$user = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$user['password']=$this->member_set->udf_decrypt($user['password']);
		$this->assign('autorun',urlencode(('"'.$s['serverip'].'" "'.$user['username'].'" "'.$user['password'].'" "C:\\Program Files\\SECLOUDTEC\\SecloudAppServer\\Agent\\SAS\\EasyPlayer\\easyplayer.exe" '.' "\"'.$r['replayname'].'\""')));
		$this->assign("session", $s);
		$this->assign("stime", $replaystime);
		
		$this->assign('host', $s['serverip']);
		$this->assign('port',5000);
		$this->assign('username', $user['username']);
		$this->assign('password', $user['password']);
		$this->assign('path', urlencode(addslashes("C:\\Program Files\\SECLOUDTEC\\SecloudAppServer\\Agent\\SAS\\EasyPlayer\\easyplayer.exe")));
		$this->assign('param', urlencode($r['replayname']));
		
		$this->display("apppubreplay.tpl");
		exit();
	}

	function urlsearch() {
		//$table_list = $this->get_table_list();
		//$this->assign('table_list', $table_list);
		$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
		$alltmpip = array(-1);
		$alltmpuser = array(-1);
		for($i=0; $i<count($allips); $i++){
			$alltmpip[]=$allips[$i]['device_ip'];
		}
		$appserverips = $this->appserver_set->select_all("1".(($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) ? ' AND appserverip IN("'.implode('","', $alltmpip).'")' : ''), 'appserverip', 'asc');
		$apppub = $this->apppub_set->select_all("1", 'name', 'asc');

		$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
		for($i=0; $i<count($allusers); $i++){
			$alltmpuser[]=$allusers[$i]['username'];
		}
		$members = $this->member_set->select_all("1".(($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) ? ' AND username IN("'.implode('","', $alltmpuser).'")' : ''), 'username', 'asc');
		$usernames = $this->appdevice_set->select_all("1", 'username', 'asc');
		$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
		$this->assign("appservers", $appserverips);
		$this->assign("apppub", $apppub);
		$this->assign("member", $members);
		$this->assign("usernames", $usernames);
		$this->display("apppuburl_search.tpl");
	}

	function plsql_search(){
		$appserverips = $this->appserver_set->select_all("1", 'appserverip', 'asc');
		$this->assign("appservers", $appserverips);
		$this->display("plsql_search.tpl");
	}

	function plsqlhistory(){
		$id = get_request('id');
		$sid = get_request('sid');
		$query = ' appcommids='.$id;
		$username = get_request('username',0,1);
		$dbname = get_request('dbname',0,1);
		$start1 = get_request('start1',0,1);
		$start2 = get_request('start2',0,1);

		if($username){
			$query .= " AND username like '%".$username."%'";
		}
		if($dbname){
			$query .= " AND dbname like '%".$dbname."%'";
		}
		if($start1){
			$query .= " AND excutetime>='".$start1."'";
		}
		if($start2){
			$query .= " AND excutetime<='".$start2."'";
		}
		$page_num = $this->getInput('page');
		$row_num = $this->plsqlhistory_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $this->plsqlhistory_set->base_select("select a.*,b.username webuser,unix_timestamp(a.excutetime) uexcutetime from ".$this->plsqlhistory_set->get_table_name()." a left join ".$this->member_set->get_table_name()."  b on b.uid=a.memberid where $query LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
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
		$this->assign('allsession', $alllogs);
		$this->assign('sid', $sid);

		$this->display('plsqlhistory.tpl');
	}
	
	function del_session() {
		global $_CONFIG;
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->appcomm_set->select_by_id($sid)){
				if($row['memberid']!=$_SESSION['ADMIN_UID']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$this->appcomm_set->delete($sid);
		alert_and_back('删除成功');
	}

	function inputview(){
		header("Content-Type:text/html;charset=UTF-8");
		$sid = get_request('sid');
		$start_page=$_GET["start_page"];
		if(!defined($sid))
		{
			$sid=$_GET["sid"];			
		}
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->appcomm_set->select_by_id($sid)){
				if($row['memberid']!=$_SESSION['ADMIN_UID']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$sessions = $this->rdp_set->select_by_id($sid);
		$logfile = $sessions['keydir'];
		
		
		if(empty($logfile)){
			echo language('键盘记录如下').':<br />';
			echo '';
		}else{
			$next_page=$start_page+500;
			$pre_page=$start_page-500;
			if(empty($start_page)){
				$start_page = 1;
				$pre_page = 1;
			}
			$buffer_array=array();
			$total_line=array();
			$buffer_array = getFileLines($logfile, $start_page, $next_page-1) ;
			//$tmp1 = exec("sed -n '$start_page,$next_page p' $logfile",$buffer_array,$return);
			//$tmp2 = exec("cat $logfile | wc -l",$total_line,$return);
			//print "<font color=red size=4px>Replay file run: display -s  $replayfile</font><br>";
			//print "<font color=blue size=4px>From line $start_page To line $next_page &nbsp &nbsp Totally $total_line[0] lines<br>Logfilename: $logfile</font><br><br>";
			if($start_page>500)
			{
				print "<a href=\"admin.php?controller=admin_apppub&action=inputview&sid=$sid&start_page=$pre_page\">pre page<br></a>";
			}

			if(count($buffer_array)==500)
			{
				print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_apppub&action=inputview&sid=$sid&start_page=$next_page\">next page</a><br>";
			}
			echo language('键盘记录如下').':<br />';
			foreach($buffer_array as $tmp)
			{
				echo htmlspecialchars($tmp)." <br>";
			}
		}
	}

}
?>
