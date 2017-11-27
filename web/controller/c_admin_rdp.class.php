<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_rdp extends c_base {
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
		$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
		//$table_name = get_request('table_name', 0, 1);
		//if($table_name) {
		//	$this->session_set->set_table_name($table_name);
		//}
		//else {
		//	$table_name = $this->session_set->get_table_name();
		//}
		$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			$this->assign('member', $member);
		
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$rdpdown = get_request('rdpdown');
		$mstsc = get_request('mstsc');
		$activex = get_request('activex');
		$sid = get_request('sid');
		$where = "(LOGIN_TEMPLATE=8 or LOGIN_TEMPLATE=22 or LOGIN_TEMPLATE=0)";
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$sid1 = get_request('sid1', 0, 1);
		$sid2 = get_request('sid2', 0, 1);
		$addr = get_request('addr', 0, 1);
		$type = get_request('type', 0, 1);
		$user = get_request('user', 0, 1);
		$luser = get_request('luser', 0, 1);
		$realname = get_request('realname', 0, 1);
		$addr = get_request('addr', 0, 1);
		$start1 = get_request('start1', 0, 1);
		$end1 = get_request('end1', 0, 1);
		$start2 = get_request('start2', 0, 1);
		$end2 = get_request('end2', 0, 1);
		$time = get_request('time', 0, 1);
		$command = get_request('command', 0, 1);
		$srcaddr = get_request('srcaddr', 0, 1);
        $usergroup  = get_request('usergroup', 0, 1);
		
		//if(!($orderby1 && $orderby2)){
		if(empty($orderby1)){
			$orderby1 = 'sid';
		}
		if (strcasecmp($orderby2, 'asc') != 0) {
			$orderby2 = 'desc';
		} else {
			$orderby2 = 'asc';
		}
        $this->assign("orderby2", $orderby2=='desc' ? 'asc' : 'desc');

		if($addr) {
			$where .= " AND addr LIKE '%$addr%'";
		}
		
		if($srcaddr) {
			$where .= " AND cli_addr LIKE '$srcaddr%'";
		}
		
		if($type) {
			if($type != 'all') {
				$where .= " AND type = '$type'";
			}
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
			$where .= " AND  LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN (SELECT device_ip FROM ".$this->devpass_set->get_table_name()." WHERE id IN (".implode(",",$alldevsid).")) and luser='".$_SESSION['ADMIN_USERNAME']."'";
		}
		elseif($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			//$oldmem = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			//$where .= " AND addr IN (SELECT device_ip FROM servers WHERE groupid = ".$oldmem['mservergroup']." )";
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				
					if($alltmpip)
					$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
				}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND luser IN ('".implode("','", $alltmpuser)."')";
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
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
		}

		if($user) {
			$where .= " AND user like '$user%'";
		}

		if($usergroup){
			$where .= " AND m.groupid='$usergroup'";
		}

		if($luser) {
			$where .= " AND luser like '$luser%'";
		}

		if($realname) {
			$where .= " AND realname like '$realname%'";
		}
		
		if($sid1 !== NULL && $sid2 !== NULL) {
			$where .= " AND (sid >= $sid1 AND sid <= $sid2)";
		}

		if($start1 ) {
			$where .= " AND (start >= '$start1') ";
		}

		if($start2 ) {
			$where .= " AND (start <= '$start2') ";
		}

		if ($end2) {
            $where .= " AND (end <= '$end2') ";
        }
		
		if($end1 && $end2) {
			$where .= " AND (end >= '$end1' AND end <= '$end2')";
		}

		if($time) {
			//$where .= " AND (start <= '$time' AND end >= '$time')";
			$where .= " AND (start <= '$time')";
		}

		if($command) {
			$where .= " AND (SELECT COUNT(*) FROM `commands` WHERE cmd LIKE '%$command%' AND commands.sid = rdp_sessions.sid) > 0";
		}

		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete($where);
			}
			else {
				die('æ²¡ææé');
			}
		}
		else if($rdpdown){
			$this->rdpdown($sid);
			
		}else if($mstsc){
			$this->mstsc($sid);
			
		}else if($activex){
			$this->activex($sid);
		}
		else {		
			//$table_list = $this->get_table_list();

			$curr_url = $_SERVER['PHP_SELF'] . "?";
			if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
				$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
			}
			else {
				$curr_url .= $_SERVER['QUERY_STRING'];
			
			}
			//echo $curr_url;
			$select = "SELECT s.*,m.realname ";
			$sqltotal = "FROM ".$this->rdp_set->get_table_name()." s WHERE $where";
			$sql = "FROM ".$this->rdp_set->get_table_name()." s LEFT JOIN member m ON s.luser=m.username  WHERE $where";
			if($usergroup) $sqltotal = $sql;
			$row_num = $this->rdp_set->base_select("select count(0) ct $sqltotal");
			$row_num = $row_num[0]['ct'];
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$allsessions = $this->rdp_set->base_select($select.$sql." ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
			if($interface) return $allsessions;
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('allsession', $allsessions);
			$this->assign('rdpinput', $_CONFIG['rdpinput']);

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			global $_CONFIG;	
			$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
			if(($msiepos=strpos($_SERVER['HTTP_USER_AGENT'], "Windows NT"))>0){
				$this->assign("windows_version", floatval(substr($_SERVER['HTTP_USER_AGENT'], $msiepos+10, strpos($_SERVER['HTTP_USER_AGENT'], ";", $msiepos+1)-$msiepos-10)));
			}
			$usergroup = $this->usergroup_set->select_all(" level=0 and attribute!=1".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'groupname', 'asc');
			$this->assign('usergroup', $usergroup);
			$this->assign('allgroup', $usergroup);
			$this->display("rdpsession_list.tpl");
		}
	}
	
	

	function search() {
		//$table_list = $this->get_table_list();
		//$this->assign('table_list', $table_list);
		if($_SESSION['ADMIN_LEVEL'] != 1) {
			 $allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") order by device_ip asc");
            $this->assign('alldev', $allips);
		}
		else {
			$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
		}
		$member = $this->member_set->select_all('1', 'username', 'asc');
		$this->assign('member', $member);
		$this->display("rdp_search.tpl");
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
		$method = get_request('method', 0, 1);
		$replaystime = get_request('replaystime', 0, 1);
		if($_SESSION['ADMIN_LEVEL']==0){
			if($method=='apppub'){
				if($row=$this->appcomm_set->select_all("sid=".$sid)){
					if($row[0]['memberid']!=$_SESSION['ADMIN_UID']){
						echo('alert("您没有权限查看");');
						exit;
					}
				}
			}else{
				if($row=$this->rdp_set->select_by_id($sid)){
					if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
						echo('alert("您没有权限查看");');
						exit;
					}
				}
			}
		}
		$this->assign("activex_version", $_CONFIG['ACTIVEX_VERSION']);
		$app_act = get_request('app_act', 0, 1);
		$this->assign("app_act",$app_act);
		$this->assign("sid", $sid);
		//echo '<a href="tmp/rdpfile.rdp">编号:'.$sid.'右键另存为</a>';
		$s = $this->rdp_set->select_by_id($sid);
		if(!file_exists($s['replayfile'])){
			echo('alert("回放文件不存在");');
			exit;
		}
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
		$this->assign("session", $s);
		$this->assign("stime", $replaystime);
		$this->assign("rdpclientversion", $_CONFIG['RdpClientVersion']);
		$this->display("mstsc.tpl");
		exit();
	}
	
	function activex($sid){
		if($_SESSION['ADMIN_LEVEL']==0){
			if($method=='apppub'){
				if($row=$this->appcomm_set->select_by_id($sid)){
					if($row['memberid']!=$_SESSION['ADMIN_UID']){
						alert_and_close('您没有权限查看');
						exit;
					}
				}
			}else{
				if($row=$this->rdp_set->select_by_id($sid)){
					if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
						alert_and_close('您没有权限查看');
						exit;
					}
				}
			}
		}
		$session = $this->rdp_set->select_by_id($sid);
		if(!file_exists(str_replace("\"", "", $session['replayfile']))){
			alert_and_back('回放文件不存在');
			exit;
		}
		$serveraddr = $_SERVER['SERVER_NAME'];
		$port = '3390';
		$guestaddr = ip2long($_SERVER['REMOTE_ADDR']);
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
		$this->assign('port',$port);
		$this->assign("session", $session);
		$this->assign("proxy_addr", $eth0);
		$this->assign('ip',$serveraddr);
		$this->assign('username',$sid);
		$window = explode("--", $session['window_size']);
		$this->assign("resWidth", $window[0]);
		$this->assign("resHeight", $window[1]);
		switch ($window[0]){
			case "640":
				$this->assign("screen", 2);
				break;
			case "800":
				$this->assign("screen", 3);
				break;
			case "1024":
				$this->assign("screen", 4);
				break;
			case "1280":
				$this->assign("screen", 5);
				break;
			case "1600":
				$this->assign("screen", 6);
				break;
			default:
				$this->assign("screen", 3);
				break;
		}
		$this->display('rdpreplay_activex.tpl');
		
	}
	
	function derive2($where) {
		$result = $this->rdpinput_set->select_limit(0, 10000, $where);
		$handle = fopen(ROOT . '/tmp/sessions.xls', 'w');
		fwrite($handle, "ID\t");
		fwrite($handle, "SID\t");
		fwrite($handle, language("时间")."\t");
		fwrite($handle, language("内容")."\t");
		$row = 1;
		foreach($result as $info) {
			$col = 0;
			foreach($info as $t) {
				fwrite($handle, "$t\t");
				$col++;
			}
			fwrite($handle, "\n");
			$row++;
		}
		fclose($handle);
		go_url("tmp/sessions.xls?c=" . rand());
	}
	function view() {
		$sid = get_request('sid');
		$where = "sid = '$sid'";
		$page_num = get_request('page');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->rdp_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}

		$row_num = $this->commands_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->commands_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, '', 'asc');
		for($j = 0; $j < count($allcommand); $j++) {
			$tc = '';
			for($i = 0; $i < strlen($allcommand[$j]['cmd']); $i++) {
				$t = $allcommand[$j]['cmd'][$i];
				$v = ord($t);
				if($v == 9) {
					$tc .= '[TAB]';
				}
				elseif($v == 127) {
					$tc .= '[Backspace]';
				}
				elseif($v <=26 && $v >=1 ) {
					$tc .= '[Ctrl+' . chr($v + 64) . ']';	
				}
				elseif($v <= 30 || $v >= 127) {
					$tc .= '\\' . $v;
				}
				else {
					$tc .= $t;
				}
			}
			$tc = str_replace('\27[A', "â", $tc);
			$tc = str_replace('\27[B', "â", $tc);
			$tc = str_replace('\27[D', "â", $tc);
			$tc = str_replace('\27[C', "â", $tc);
			$allcommand[$j]['cmd'] = $tc;
		}
		$this->assign('allcommand', $allcommand);
		$this->assign('sid', $sid);
		$this->display('session_view.tpl');
	}

	function rdpmouse($interface=false) {
		global $_CONFIG;
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->rdp_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$where = "sid = '$sid'";
		$page_num = get_request('page');
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

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}

		$row_num = $this->rdpmouse_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$allcommand =  $this->rdpmouse_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, '', 'asc');
		for($i=0; $i<count($allcommand); $i++){
			$ymdtime = trim($allcommand[$i]['clicktime']);
			$ymd = substr($ymdtime, 0, 10);
			$time = substr($ymdtime, 11, 8);//var_dump($ymd);var_dump($time);
			$ymd = explode('-', $ymd);
			$time = explode(':', $time);
			$allcommand[$i]['uclicktime'] = mktime(intval($time[0]),intval($time[1]),intval($time[2]),intval($ymd[1]),intval($ymd[2]),intval($ymd[0]));
		}
		if($interface) return $allcommand;
		$this->assign('allcommand', $allcommand);		
		$this->assign('sid', $sid);		
		$this->assign('curr_url', $curr_url);
		$this->display('rdp_mouse.tpl');
	}

	function del_session() {
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->rdp_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限');
					exit;
				}
			}
		}
		$result=mysql_query("select logfile from " . $this->rdp_set->get_table_name() . " WHERE sid=$sid");
		if($result)
		while ($row = mysql_fetch_assoc($result))
        {
            if(file_exists($row["logfile"]))
            {
                unlink($row["logfile"]);
                unlink($row["logfile"]."onlight");
            }
        }
		$this->rdp_set->delete($sid);
		$this->commands_set->query("DELETE FROM `" . $this->commands_set->get_table_name() . "` WHERE sid = '$sid'");
		alert_and_back('删除成功');
	}
	
	function inputview(){
		header("Content-Type:text/html;charset=UTF-8");
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->rdp_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$start_page=$_GET["start_page"];
		if(!defined($sid))
		{
			$sid=$_GET["sid"];			
		}
		$sessions = $this->rdp_set->select_by_id($sid);
		$logfile = $sessions['keydir'];
		if(!file_exists(str_replace("\"", "", $sessions['keydir']))){
			alert_and_back('键盘回放文件不存在');
			exit;
		}
		if(empty($logfile)){
			echo language('键盘记录如下').':<br />';
			echo '';
		}else{
			$curr_url = $_SERVER['PHP_SELF'] . "?";
			if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
				$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
			}
			else {
				$curr_url .= $_SERVER['QUERY_STRING'];
			}
			echo "<a href='admin.php?controller=admin_rdp&action=downloadplayfile&sid=$sid'>录相文件下载</a><br />";
			echo ' <select  class="wbk"  id="app_act" style="display:none"><option value="applet" '.($_SESSION['ADMIN_DEFAULT_CONTROL']=='applet' ? 'selected' : '').'>applet</option><option value="activeX" '.($_SESSION['ADMIN_DEFAULT_CONTROL']=='activeX' ? 'selected' : '').'>activeX</option></select><br /><br />';
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
				print "<a href=\"admin.php?controller=admin_rdp&action=inputview&sid=$sid&start_page=$pre_page\">pre page<br></a>";
			}

			if(count($buffer_array)==500)
			{
				print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_rdp&action=inputview&sid=$sid&start_page=$next_page\">next page</a><br>";
			}
			echo language('键盘记录如下').':<br />';
			$i=1;
			foreach($buffer_array as $tmp)
			{
				$ymdtime = substr(trim($tmp), 0, 19);
				$ymd = substr($ymdtime, 0, 10);
				$time = substr($ymdtime, 11, 8);//var_dump($ymd);var_dump($time);
				$ymd = explode('-', $ymd);
				$time = explode(':', $time);
				$replaystime = mktime(intval($time[0]),intval($time[1]),intval($time[2]),intval($ymd[1]),intval($ymd[2]),intval($ymd[0]));
				echo htmlspecialchars($tmp)."\t\t\t\t\t\t\t\t".(checkdate(intval($ymd[1]), intval($ymd[2]), intval($ymd[0])) ? '<a  id="p_'.$i.'" onClick="return go(\'admin.php?controller=admin_rdp&mstsc=1&sid='.$sid.'&replaystime='.$replaystime.'\',\'p_'.$i.'\')" href="#" target="hide">回放</a>' : '')." <br>";
				$i++;
			}
			$this->display("mstsc_bottom.tpl");
		}
	}

	function downloadplayfile(){
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->rdp_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$sessions = $this->rdp_set->select_by_id($sid);
		if(!file_exists(str_replace("\"", "", $sessions['replayfile']))){
			alert_and_back('录像文件不存在');
			exit;
		}
		$sessions['replayfile']=str_replace("\"", "", $sessions['replayfile']);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		header("Content-Disposition: attachment; filename=".$sessions['replayfile']);
		echo file_get_contents($sessions['replayfile']);
		exit();
	}

	function downloadfile(){
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->rdp_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$sessions = $this->rdp_set->select_by_id($sid);
		$sessions['keydir']=str_replace("\"", "", $sessions['keydir']);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		header("Content-Disposition: attachment; filename=".$sessions['keydir']);
		echo file_get_contents($sessions['keydir']);
		exit();
	}

	function clipboard(){
		header("Content-Type:text/html;charset=UTF-8");
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->rdp_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$start_page=$_GET["start_page"];
		if(!defined($sid))
		{
			$sid=$_GET["sid"];			
		}
		$sessions = $this->rdp_set->select_by_id($sid);
		$logfile = $sessions['clipboarddir'];
		
		if(!file_exists(str_replace("\"", "", $sessions['clipboarddir']))){
			alert_and_back('剪贴板文件不存在');
			exit;
		}
		if(empty($logfile)){
			echo language('剪贴板记录如下').':<br />';
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
				print "<a href=\"admin.php?controller=admin_rdp&action=inputview&sid=$sid&start_page=$pre_page\">pre page<br></a>";
			}

			if(count($buffer_array)==500)
			{
				print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_rdp&action=inputview&sid=$sid&start_page=$next_page\">next page</a><br>";
			}
			echo language('剪贴板记录如下').':<br />';
			$first = 1;
			foreach($buffer_array as $tmp)
			{
				
				if(preg_match('/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}-[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}/' , $tmp)){
					if(!$first){
						echo '<br><br>';
					}
					if($pos=strpos($tmp, 'upload')){
						echo '<font color="red">'.str_replace('upload', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;运行:上行', substr($tmp,0,$pos+6))."</font> <br>";
						echo substr($tmp, $pos+6)." <br>";
					}elseif($pos=strpos($tmp, 'download')){
						echo '<font color="red">'.str_replace('download', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;运行:下行', substr($tmp,0,$pos+8))."</font> <br>";
						echo substr($tmp, $pos+8)." <br>";
					}
					$first = 0;
				}else{
					echo htmlspecialchars($tmp)." <br>";
				}
			}
		}
	}	

	function download()
    {
        header("Content-Type:text/html;charset=GB2312");
        $sid        = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->rdp_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$command = get_request('command',0,1);
        $start_page = $_GET["start_page"];
        if (!defined($sid)) {
            $sid = $_GET["sid"];
        }
        $sessions   = $this->rdp_set->select_by_id($sid);
        $logfile    = $sessions['logfile'];
        $replayfile = $sessions['replayfile'];
		$backupdb_id = get_request('backupdb_id');
		if(!empty($backupdb_id)){
			$backupdb_info = $this->backup_setting_set->select_by_id($backupdb_id);
			header("Content-type: text/html; charset=utf-8");
			echo '录像文件位置:'.$backupdb_info['path'].'/'.$sessions['replayfile']."<br />";
			echo '键盘记录位置:'.$backupdb_info['path'].'/'.$sessions['keydir']."<br />";
			exit;
		}
        $tarname    = substr($sessions['end'], 0, 7) . ".tar.gz";
        if (!$sessions) {
            //echo("log file backuped,please look up for it in the backup tar package<br>
            //logfile name:$logfile<br>
            //backup tar package:$tarname<br>");
            //die();
        }
        if ($logfile == NULL) {
            echo ("no logfile<br>");
            die();
            
        }
        if (!file_exists($logfile)) {
            echo ("no found logfile name:$logfile<br>");
            die();
        }
        
        
        //$value   =   file($logfile);
        
        $maxline   = count($value);
        $next_page = $start_page + 500;
        $pre_page  = $start_page - 500;
        if (empty($start_page)) {
            $start_page = 1;
            $pre_page   = 1;
        }
        $buffer_array = array();
        $total_line   = array();
        $buffer_array = getFileLines($logfile, $start_page, $next_page - 1);
        //$tmp1 = exec("sed -n '$start_page,$next_page p' $logfile",$buffer_array,$return);
        //$tmp2 = exec("cat $logfile | wc -l",$total_line,$return);
        //print "<font color=red size=4px>Replay file run: display -s  $replayfile</font><br>";
        //print "<font color=blue size=4px>From line $start_page To line $next_page &nbsp &nbsp Totally $total_line[0] lines<br>Logfilename: $logfile</font><br><br>";
        if ($start_page > 500) {
            print "<a href=\"admin.php?controller=admin_rdp&action=download&sid=$sid&start_page=$pre_page\">pre page<br></a>";
        }
        
        if (count($buffer_array) == 500) {
            print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_rdp&action=download&sid=$sid&start_page=$next_page\">next page</a><br>";
        }
        
        foreach ($buffer_array as $tmp) {
			if($command)
				$tmp = preg_replace("/($command)/i", "<font color='red'>\$1</font>", htmlspecialchars($tmp));
			else
				$tmp = htmlspecialchars($tmp);
            echo  $tmp. " <br>";
        }
		 if ($start_page > 500) {
            print "<a href=\"admin.php?controller=admin_rdp&action=download&sid=$sid&start_page=$pre_page\">pre page<br></a>";
        }
    }
}
?>
