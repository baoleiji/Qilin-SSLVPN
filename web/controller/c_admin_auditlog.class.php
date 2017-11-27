<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_auditlog extends c_base {
	function index($where = NULL) {
		global $_CONFIG;
		$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";
		$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$this->assign('member', $member);

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$servername = get_request('servername', 0, 1);
		$name = get_request('name', 0, 1);
		$addr = get_request('addr', 0, 1);
		$time = get_request('time', 0, 1);
		$message = get_request('message', 0, 1);
		$status = get_request('status', 0, 1);
		$start1 = get_request('start1', 0, 1);
		$start2 = get_request('start2', 0, 1);
		
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		

		if($addr) {
			if(is_ip($addr)) {
				$where .= " AND serverip = '$addr'";
			}
			else {
				$where .= " AND serverip LIKE '$addr%'";
			}
		}

		if($servername) {
			$where .= " AND servername like '%$servername%'";
		}

		if($name) {
			$where .= " AND name like '%$name%'";
		}

		if($message) {
			$where .= " AND message LIKE '$message%'";
		}

		if($time) {
			$where .= " AND backuptime = '$time'";
		}

		if(is_numeric($status)) {
			$where .= " AND statuts = '$status'";
		}

		if($start1 ) {
			$where .= " AND (start >= '$start1') ";
		}

		if($start2 ) {
			$where .= " AND (start <= '$start2') ";
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
			}
			//echo $curr_url;
				
			$row_num = $this->autobackup_log_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
					
		
			$this->assign('allsession', $this->autobackup_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$this->display("auditlog_list.tpl");
		}
	}

	function runlist($where = NULL) {
		global $_CONFIG;
		$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";
		$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$this->assign('member', $member);

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$name = get_request('name', 0, 1);
		$servername = get_request('servername', 0, 1);
		$addr = get_request('addr', 0, 1);
		$time = get_request('time', 0, 1);
		$message = get_request('message', 0, 1);
		$status = get_request('status', 0, 1);
		$start1 = get_request('start1', 0, 1);
		$start2 = get_request('start2', 0, 1);
		
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		

		if($addr) {
			if(is_ip($addr)) {
				$where .= " AND serverip = '$addr'";
			}
			else {
				$where .= " AND serverip LIKE '$addr%'";
			}
		}

		if($servername) {
			$where .= " AND servername like '%$servername%'";
		}

		if($name) {
			$where .= " AND name like '%$name%'";
		}

		if($message) {
			$where .= " AND message LIKE '$message%'";
		}

		if($time) {
			$where .= " AND backuptime = '$time'";
		}

		if(is_numeric($status)) {
			$where .= " AND statuts = '$status'";
		}

		if($start1 ) {
			$where .= " AND (checktime >= '$start1') ";
		}

		if($start2 ) {
			$where .= " AND (checktime <= '$start2') ";
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
			}
			//echo $curr_url;
				
			$row_num = $this->autorun_log_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
					
		
			$this->assign('allsession', $this->autorun_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$this->display("auditlogrun_list.tpl");
		}
	}

	function del_session() {
		$sid = get_request('sid');
		$result=mysql_query("select logfile from " . $this->sessions_set->get_table_name() . " WHERE sid=$sid");
		while ($row = mysql_fetch_assoc($result))
		{
			if(file_exists($row["logfile"]))
			{
				unlink($row["logfile"]);
				unlink($row["logfile"]."onlight");
			}
		}
		$this->sessions_set->delete($sid);
		$this->commands_set->query("DELETE FROM `" . $this->commands_set->get_table_name() . "` WHERE sid = '$sid'");
		alert_and_back('删除成功');
	}

	function download() {
		header("Content-Type:text/html;charset=GB2312");
		$sid = get_request('sid');
		$start_page=$_GET["start_page"];
		if(!defined($sid))
		{
			$sid=$_GET["sid"];
		}
		$sessions = $this->autobackup_log_set->select_by_id($sid);
		$logfile = $sessions['logpath'];
		$tarname=substr($sessions['backuptime'],0,7).".tar.gz";
		if(!$sessions) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			//die();
		}
		if($logfile == NULL) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			die();

		}
		if(!file_exists($logfile)) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
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
		//print "<font color=red size=4px>Replay file run: display -s  $replayfile</font><br>";
		//print "<font color=blue size=4px>From line $start_page To line $next_page &nbsp &nbsp Totally $total_line[0] lines<br>Logfilename: $logfile</font><br><br>";
		if($pre_page>0)
		{
			print "<a href=\"admin.php?controller=admin_session&action=download&sid=$sid&start_page=$pre_page\">pre page<br></a>";
		}

		if($next_page<$maxline)
		{
			print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_session&action=download&sid=$sid&start_page=$next_page\">next page</a><br>";
		}

		foreach($buffer_array as $tmp)
		{
			echo $tmp."<br>";
		}
	}

	function download2() {
		header("Content-Type:text/html;charset=GB2312");
		$sid = get_request('sid');
		$start_page=$_GET["start_page"];
		if(!defined($sid))
		{
			$sid=$_GET["sid"];
		}
		$sessions = $this->autorun_log_set->select_by_id($sid);
		$logfile = $sessions['localfile'];
		$tarname=substr($sessions['backuptime'],0,7).".tar.gz";
		if(!$sessions) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			//die();
		}
		if($logfile == NULL) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			die();

		}
		if(!file_exists($logfile)) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			die();
		}
		$value   =   file($logfile);
		$maxline=count($value);
		$next_page=$start_page+500;
		$pre_page=$start_page-500;
		$buffer_array=array();
		$total_line=array();
	
		echo "sed -n '$start_page,$next_page p' $logfile";
		$tmp1 = exec("sed -n '$start_page,$next_page p' $logfile",$buffer_array,$return);
		$tmp2 = exec("cat $logfile | wc -l",$total_line,$return);
		//print "<font color=red size=4px>Replay file run: display -s  $replayfile</font><br>";
		//print "<font color=blue size=4px>From line $start_page To line $next_page &nbsp &nbsp Totally $total_line[0] lines<br>Logfilename: $logfile</font><br><br>";
		if($pre_page>0)
		{
			print "<a href=\"admin.php?controller=admin_session&action=download&sid=$sid&start_page=$pre_page\">pre page<br></a>";
		}

		if($next_page<$maxline)
		{
			print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_session&action=download&sid=$sid&start_page=$next_page\">next page</a><br>";
		}

		foreach($buffer_array as $tmp)
		{
			echo $tmp."<br>";
		}
	}

	
}
?>
