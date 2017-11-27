<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_sftp extends c_base {
	function index($where = NULL, $interface=false) {
		global $_CONFIG;
		//$table_name = get_request('table_name', 0, 1);
		//if($table_name) {
		//	$this->session_set->set_table_name($table_name);
		//}
		//else {
		//	$table_name = $this->session_set->get_table_name();
		//}
		$back = get_request('back');
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
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}

		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$download = get_request('download');
		$where = "1=1";

		$cid = get_request('cid');
		$cliaddr = get_request('cliaddr', 0, 1);
		$svraddr = get_request('svraddr', 0 ,1);
		$user = get_request('user', 0, 1);
		$sftp_user = get_request('sftp_user', 0, 1);
		$radius_user = get_request('radius_user', 0, 1);
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
        $usergroup  = get_request('usergroup', 0, 1);
		$filter = get_request('filter');
		if($filter){
			$where .= " AND total_cmd>0 ";
		}
		$this->assign("filter", $filter);

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
			$where .= " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN (SELECT device_ip FROM ".$this->devpass_set->get_table_name()." WHERE id IN (".implode(",",$alldevsid).")) and radius_user='".$_SESSION['ADMIN_USERNAME']."'";
		}
		elseif($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$alltmpip = array(0);
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
					//$oldmem = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
					//$where .= " AND svraddr IN (SELECT device_ip FROM servers WHERE groupid = ".$oldmem['mservergroup']." )";
					$where .= " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')";
				}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND radius_user IN ('".implode("','", $alltmpuser)."')";
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
			$where .= " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')";
		}

		if($cliaddr) {
			if(is_ip($cliaddr)) {
				$where .= " AND cliaddr LIKE '$cliaddr'";
			}
			else {
				$where .= " AND cliaddr LIKE '%$cliaddr%'";
			}
		}

		if($svraddr) {
			if(is_ip($svraddr)) {
				$where .= " AND svraddr LIKE '$svraddr'";
			}
			else {
				$where .= " AND svraddr LIKE '%$svraddr%'";
			}
		}

		if($user) {
			$where .= " AND radius_user like '%$user%'";
		}
		if($usergroup){
			$where .= " AND m.groupid='$usergroup'";
		}

		if($luser) {
			$where .= " AND radius_user like '%$luser%'";
		}
		
		if($sftp_user) {
			$where .= " AND sftp_user like '%$sftp_user%'";
		}

		if($realname) {
			$where .= " AND realname like '%$realname%'";
		}

		if($radius_user) {
			$where .= " AND radius_user like '%$radius_user%'";
		}

		if(empty($orderby1)){
			$orderby1 = 'sid';
		}
		if (strcasecmp($orderby2, 'asc') != 0) {
			$orderby2 = 'desc';
		} else {
			$orderby2 = 'asc';
		}
        $this->assign("orderby2", $orderby2=='desc' ? 'asc' : 'desc');

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

		if($command) {
			$where .= " AND (SELECT COUNT(*) FROM `sftpcomm` WHERE comm LIKE '%$command%' AND sftpcomm.sid = sftpsessions.sid) > 0";
		}

		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete($where);
			}
			else {
				die('æ²¡ææé');
			}
		}else if($download){
			$this->download($cid);
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
			$select = "SELECT sftpsessions.*,m.realname ";
			$sqltotal = " FROM ".$this->sftpsession_set->get_table_name()." WHERE $where";
			$sql = " FROM ".$this->sftpsession_set->get_table_name()." LEFT JOIN member m ON sftpsessions.radius_user=m.username  WHERE $where";
			if($usergroup) $sqltotal = $sql;
			$row_num = $this->sftpsession_set->base_select("select count(0) ct $sqltotal");
			$row_num = $row_num[0]['ct'];
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$allsessions = $this->sftpsession_set->base_select($select.$sql." ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
			if($interface) return $allsessions;
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('command', $comm);
			$this->assign('allsession', $allsessions);

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$usergroup = $this->usergroup_set->select_all(" level=0  and attribute!=1".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'groupname', 'asc');
			$this->assign('usergroup', $usergroup);
			$this->assign('allgroup', $usergroup);
			$this->display("sftpsession_list.tpl");
		}
	}
	function download($cid=0){
	global $_CONFIG;
	if(empty($cid)){
		$cid = get_request('cid');
	}
	$comm = $this->sftpcmd_set->select_by_id($cid);
	$session = $this->sftpsession_set->select_by_id($comm['sid']);
	if($_SESSION['ADMIN_LEVEL']==0){
		if($row=$this->sftpsession_set->select_by_id($comm['sid'])){
			if($row['radius_user']!=$_SESSION['ADMIN_USERNAME']){
				alert_and_close('您没有权限查看');
				exit;
			}
		}
	}
	$backupdb_id = get_request('backupdb_id');
	if(!empty($backupdb_id)){//var_dump($this->backup_setting_set->get_table_name());
		$backupdb_info = $this->backup_setting_set->select_by_id($backupdb_id);
		header("Content-type: text/html; charset=utf-8");
		echo '文件位置:'.$backupdb_info['path'].'/'.$comm['filename']."<br />";
		exit;
	}
	$file = $comm[filename];
	$session[auditaddr]=trim($session[auditaddr]);
	if($_CONFIG['DEVLOGIN_FORTIP']!=$session[auditaddr]){
		$pos = strlen($_CONFIG['FTP_DOWNLOAD_PREFIX']);
		$file=substr($file, 0, $pos) . $session[auditaddr] .'/'. substr($file, $pos);
	}
$filename = substr($file, strrpos($file, '/')+1);
Header('Cache-Control: private, must-revalidate, max-age=0');
Header("Content-type: application/octet-stream;charset=UTF-8"); 
//Header("Content-type: application/octet-stream"); 
Header("Content-Disposition: attachment; filename=" . iconv("UTF-8", "GB2312", $filename)); 
$f=fopen($file,'rb'); 
	if($f!=false){
		$contents = "";
		do {
		    $data = fread($f, 8192);
		    if (strlen($data) == 0) {
		        break;
		    }
		    $contents .= $data;
		} while(true);
		fclose($f); 
		echo $contents;
}else{
	alert_and_back('打开文件失败');
}
		exit();
	}
	function search() {
		//$table_list = $this->get_table_list();
		//$this->assign('table_list', $table_list);
		$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
		$member = $this->member_set->select_all('1', 'username', 'asc');
		$this->assign('member', $member);
		$this->display("sftp_search.tpl");
	}

	

	
	function view($interface=false) {
		global $_CONFIG;
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
		if($row=$this->sftpsession_set->select_by_id($comm['sid'])){
			if($row['radius_user']!=$_SESSION['ADMIN_USERNAME']){
				alert_and_close('您没有权限查看');
				exit;
			}
		}
	}
		$where = "sid = '$sid'";
		$page_num = get_request('page');
		$command = get_request('command', 0, 1);
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

		$row_num = $this->sftpcmd_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->sftpcmd_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, '', 'asc');
		if($interface) return $allcommand;
		for($j = 0; $j < count($allcommand); $j++) {

		if(strtolower(substr(trim($allcommand[$j]['comm']),0,3))=='put' or strtolower(substr(trim($allcommand[$j]['comm']),0,3))=='get'){
				$allcommand[$j]['downloadallow'] = true;
			}
			
			if($command){
				$allcommand[$j]['comm'] = preg_replace("/($command)/i","<font color='red'>\$1</font>", $allcommand[$j]['comm']);
			}
		}
		//echo '<pre>';print_r($allcommand);echo '</pre>';
		$this->assign('allcommand', $allcommand);
		$this->assign('sid', $sid);
		$this->display('sftpsession_view.tpl');
	}

	function del_command() {
		$cid = get_request('cid');
		$s = $this->ftpcmd_set->select_by_id($cid);
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sftpsession_set->select_by_id($s['sid'])){
				if($row['radius_user']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限');
					exit;
				}
			}
		}

		$this->ftpcmd_set->delete($cid);
		alert_and_back('æåå é¤æä»¤!');
	}
	
	function del_session() {
		global $_CONFIG;
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($sid)){
				if($row['radius_user']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
		$session = $this->sftpsession_set->select_by_id($sid);
		$logfile = str_replace("'","",$_CONFIG['FTP_LOG_PATH_PREFIX'].$session['replayfile']);
		//echo "logfile = '".str_replace('\'','\\\'',$session['logfile'])."'";
		if ($this->sftpsession_set->select_count("replayfile = '".str_replace('\'','\\\'',$session['replayfile'])."'") == 1 ) {
			if(file_exists($logfile)) {
				unlink($logfile);
		//		echo $logfile;
			}
		}
		$this->sftpsession_set->delete($sid);
		$this->sftpcmd_set->query("DELETE FROM `" . $this->sftpcmd_set->get_table_name() . "` WHERE sid = '$sid'");
		alert_and_back('删除成功');
	}

	function delete($where) {
		$this->sftpcmd_set->query("DELETE FROM `" . $this->sftpcmd_set->get_table_name() . "` WHERE `sid` IN (SELECT `sid` FROM `sessions` WHERE $where)");
		$this->sftpsession_set->query("DELETE FROM `" . $this->sftpsession_set->get_table_name() . "` WHERE $where");
		alert_and_back('æåå é¤æå®ä¼è¯');
	}
}
?>
