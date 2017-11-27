<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_as400 extends c_base {
	function index($where = NULL, $interface=false) {
		global $_CONFIG;
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
		$where = "1=1";
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$sid1 = get_request('sid1', 0, 1);
		$sid2 = get_request('sid2', 0, 1);
		$addr = get_request('addr', 0, 1);
		$type = get_request('type', 0, 1);
		$user = get_request('user', 0, 1);
		$addr = get_request('addr', 0, 1);
		$start1 = get_request('start1', 0, 1);
		$end1 = get_request('end1', 0, 1);
		$start2 = get_request('start2', 0, 1);
		$end2 = get_request('end2', 0, 1);
		$time = get_request('time', 0, 1);
		$srcaddr = get_request('srcaddr', 0, 1);
		$command = get_request('command', 0, 1);
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
			if(is_ip($addr)) {
				$where .= " AND addr = '$addr'";
			}
			else {
				$where .= " AND addr LIKE '%$addr%'";
			}
		}

		if($srcaddr) {
			if(is_ip($srcaddr)) {
				$where .= " AND cli_addr = '$srcaddr'";
			}
			else {
				$where .= " AND cli_addr LIKE '%$srcaddr%'";
			}
		}

		if($type) {
			if($type != 'all') {
				$where .= " AND type = '$type'";
			}
		}

		if($_SESSION['ADMIN_LEVEL'] == 0 ) {
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN (SELECT device_ip FROM ".$this->server_set->get_table_name()." WHERE id IN ($_SESSION[DEVS]))";
		}

		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101){
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
					$where .= " AND user IN ('".implode("','", $alltmpuser)."')";
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
			$where .= " AND user like '%$user%'";
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

		if($usergroup){
			$where .= " AND user IN(SELECT username FROM ".$this->member_set->get_table_name()." WHERE groupid='$usergroup')";
		}

		if($end1 && $end2) {
			$where .= " AND (end >= '$end1' AND end <= '$end2')";
		}

		if($time) {
			//$where .= " AND (start <= '$time' AND end >= '$time')";
			$where .= " AND (start <= '$time')";
		}
		if($command) {
			$where .= " AND (SELECT COUNT(*) FROM `AS400_commands` WHERE cmd LIKE '%$command%' AND AS400_commands.sid = AS400_sessions.sid) > 0";
		}

		
		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete($where);
			}
			else {
				die('æ²¡ææé');
			}
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
				
			$row_num = $this->AS400_sessions_set->select_count($where);
			$allsession=$this->AS400_sessions_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
			if($interface) return $allsession;
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('command', $command);
			$this->assign('allsession', $allsession);

			$usergroup = $this->usergroup_set->select_all(" level=0 and attribute!=1".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'groupname', 'asc');
			$this->assign('usergroup', $usergroup);
			$this->assign('allgroup', $usergroup);
			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$this->display("as400session_list.tpl");
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
		$this->display("as400session_search.tpl");
	}

	function delete($where) {

		/*===============lwm===============*/
		//        print "select logfile from " . $this->AS400_sessions_set->get_table_name() . " WHERE $where";
		$result=mysql_query("select logfile from " . $this->AS400_sessions_set->get_table_name() . " WHERE $where");
		while ($row = mysql_fetch_assoc($result))
		{
			if(file_exists($row["logfile"]))
			{
				unlink($row["logfile"]);
			}
		}
		/*==============lwm================*/

		$this->AS400_sessions_set->query("DELETE FROM `" . $this->AS400_sessions_set->get_table_name() . "` WHERE $where");
		alert_and_back('删除成功');
	}


	function download() {
		//header("Content-Type:text/html;charset=GB2312");
		$sid = get_request('sid');
		$start_page=$_GET["start_page"];
		if(!defined($sid))
		{
			$sid=$_GET["sid"];
		}
		$sessions = $this->AS400_sessions_set->select_by_id($sid);
		$logfile = $sessions['logfile'];
		$replayfile=$sessions['replayfile'];
		$tarname=substr($sessions['end'],0,7).".tar.gz";
		if(!$sessions) {
			echo("log file backuped,please look up for it in the backup tar package<br>
			logfile name:$logfile<br>
			backup tar package:$tarname<br>");
			die();
		}
		if($logfile == NULL) {
			echo("log file backuped,please look up for it in the backup tar package<br>
			logfile name:$logfile<br>
			backup tar package:$tarname<br>");
			die();

		}
		if(!file_exists($logfile)) {
			echo("log file backuped,please look up for it in the backup tar package<br>
			logfile name:$logfile<br>
			backup tar package:$tarname<br>");
			die();
		}
		$value   =   file($logfile);
		$maxline=count($value);
		$next_page=$start_page+500;
		$pre_page=$start_page-500;
		$buffer_array=array();
		$total_line=array();
		$tmp1 = exec("sed -n '$start_page,$next_page p' $logfile",$buffer_array,$return);
		$tmp2 = exec("cat $logfile | wc -l",$total_line,$return);
		print "<font color=red size=4px>Replay file run: display -s  $replayfile</font><br>";
		print "<font color=blue size=4px>From line $start_page To line $next_page &nbsp &nbsp Totally $total_line[0] lines<br>Logfilename: $logfile</font><br><br>";
		if($pre_page>0)
		{
			print "<a href=\"admin.php?controller=admin_as400&action=download&sid=$sid&start_page=$pre_page\">pre page<br></a>";
		}

		if($next_page<$maxline)
		{
			print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_as400&action=download&sid=$sid&start_page=$next_page\">next page</a><br>";
		}

		foreach($buffer_array as $tmp)
		{
			echo $tmp."<br>";
		}
	}


	function replay() {
		global $_CONFIG;
		$sid = get_request('sid');
		$tool = get_request('tool',0,1);
		$cid = get_request('cid');
		$this->assign("sid", $sid);
		$session = $this->AS400_sessions_set->select_by_id($sid);
		if($cid){
			
			$guestaddr = ip2long($_SERVER['REMOTE_ADDR']);
			$proxyips = $this->proxyip_set->select_all("source!='0.0.0.0'");
			$outip = $this->proxyip_set->select_all("source='0.0.0.0'");
			$eth0 = $outip[0]['proxyip'];
			for($i=0; $i<count($proxyips); $i++){
				//long2ip(ip2long('192.168.1.2')&ip2long('255.255.255.0'))
				if(long2ip($guestaddr&ip2long($proxyips[$i]['network']))==$proxyips[$i]['source']){
					$eth0 = $proxyips[$i]['proxyip'];
				}
			}
			//$session['host']=$eth0;
			$this->assign("s", $session);
			$this->assign("tool", $tool);
			$this->assign("proxy_addr", $eth0);
			$this->assign("monitorport", $_CONFIG['MONITORPORT']);
			$this->assign("monitoruser", 'monitor1');
			$this->assign("monitorpassword", $_CONFIG['MONITORPASSWORD']);
			$this->display('replay.tpl');
			exit;
		}elseif($tool){
			$guestaddr = ip2long($_SERVER['REMOTE_ADDR']);
			$proxyips = $this->proxyip_set->select_all("source!='0.0.0.0'");
			$outip = $this->proxyip_set->select_all("source='0.0.0.0'");
			$eth0 = $outip[0]['proxyip'];
			for($i=0; $i<count($proxyips); $i++){
				//long2ip(ip2long('192.168.1.2')&ip2long('255.255.255.0'))
				if(long2ip($guestaddr&ip2long($proxyips[$i]['network']))==$proxyips[$i]['source']){
					$eth0 = $proxyips[$i]['proxyip'];
				}
			}
			$this->assign("s", $session);
			$this->assign("tool", $tool);
			$this->assign("proxy_addr", $eth0);
			$this->assign("cid", 'as400');
			$this->assign("monitorport", $_CONFIG['MONITORPORT']);
			$this->assign("monitoruser", 'monitor1');
			$this->assign("monitorpassword", $_CONFIG['MONITORPASSWORD']);
			$this->display('replay.tpl');
			exit;
		}

		$this->assign('serveradd',$_SERVER['SERVER_NAME'] );
		$this->assign('serverport', $_SERVER[SERVER_PORT]);
		//		$this->assign('filename',str_replace('"','\''," -S ".strtotime($time)." ".$session['replayfile']));
		$this->assign('filename',str_replace('"','',$session['replayfile']));

		$this->display('replays.tpl');
	}
	
	function view() {
		global $_CONFIG;
		$sid = get_request('sid');
		$where = "sid = '$sid'";
		$page_num = get_request('page');
		$command = get_request('command', 0, 1);
		$backupdb_id = get_request('backupdb_id');
		if(!empty($backupdb_id)){
			$backupdb = $this->backup_setting_set->select_by_id($backupdb_id);
			$dbhost = $backupdb['ip'];
			$dbuser = $backupdb['mysqluser'];
			$dbpwd = $this->backup_setting_set->udf_decrypt($backupdb['mysqlpasswd']);
			$dbname = $backupdb['dbname'];		$dbcharset = 'utf8';
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

		$row_num = $this->AS400_commands_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);

		$allcommand =  $this->AS400_commands_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, '', 'asc');
		for($j = 0; $j < count($allcommand); $j++) {
			if($command){
				$allcommand[$j]['cmd'] = preg_replace("/($command)/i","<font color='red'>\$1</font>", $allcommand[$j]['cmd']);
			}
		}
		$this->assign('allcommand', $allcommand);
		$this->assign('sid', $sid);
		$this->display('as400_view.tpl');
	}
	
function del_session() {
		global $_CONFIG;
		$sid = get_request('sid');
		$session = $this->AS400_sessions_set->select_by_id($sid);
		$logfile = str_replace("'","",$_CONFIG['FTP_LOG_PATH_PREFIX'].$session['replayfile']);
		//echo "logfile = '".str_replace('\'','\\\'',$session['logfile'])."'";
		if ($this->AS400_sessions_set->select_count("replayfile = '".str_replace('\'','\\\'',$session['replayfile'])."'") == 1 ) {
			if(file_exists($logfile)) {
				unlink($logfile);
		//		echo $logfile;
			}
		}
		$this->AS400_sessions_set->delete($sid);
		$this->AS400_commands_set->query("DELETE FROM `" . $this->AS400_commands_set->get_table_name() . "` WHERE sid = '$sid'");
		alert_and_back('删除成功');
	}

	function del_command() {
		$cid = get_request('cid');
		$this->AS400_commands_set->delete($cid);
		alert_and_back('删除成功');
	}
	
}
?>
