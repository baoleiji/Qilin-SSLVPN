<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_autorunlog extends c_base {
	function index($where = NULL) {
		global $_CONFIG;
		$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
		$page_num = get_request('page');
		$type = get_request('type',0,1);
		$derive = get_request('derive');
		$delete = get_request('delete');
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
		$where = "name='$name'";
		
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
			if($type=='run'){
				$row_num = $this->autorun_log_set->select_count($where);
			}else{
				$row_num = $this->autobackup_log_set->select_count($where);
			}
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
					
			if($type=='run'){
				$this->assign('allsession', $this->autorun_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));
			}else{
				$this->assign('allsession', $this->autobackup_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));
			}
			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			if($type=='run'){
				$this->display("autorunlog_list.tpl");
			}else{
				$this->display("autobackuplog_list.tpl");
			}
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

	function delete(){
		$sid = get_request('sid');
		$type = get_request('type', 0, 1);
		if($type=='run'){
			$this->autorun_log_set->delete($sid);
		}else{
			$this->autobackup_log_set->delete($sid);
		}
		alert_and_back('删除成功');
	}

	function viewfile() {
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
			die('no logfile');

		}
		if(!file_exists($logfile)) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			die('file not exists');
		}
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
			print "<a href=\"admin.php?controller=admin_autorunlog&action=viewfile&sid=$sid&start_page=$pre_page\">pre page<br></a>";
		}

		if(count($buffer_array)==500)
		{
			print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_autorunlog&action=viewfile&sid=$sid&start_page=$next_page\">next page</a><br>";
		}
		
		foreach($buffer_array as $tmp)
		{
			echo $tmp." <br>";
		}
	}

	function download() {
		header("Content-Type:text/html;charset=GB2312");
		$sid = get_request('sid');
		$type = get_request('type', 0, 1);
		$start_page=$_GET["start_page"];
		if(!defined($sid))
		{
			$sid=$_GET["sid"];
		}
		if($type=='run'){
			$sessions = $this->autorun_log_set->select_by_id($sid);
			$logfile = $sessions['logpath'];
		}else{
			$sessions = $this->autobackup_log_set->select_by_id($sid);
			$logfile = $sessions['recordpath'];
		}
		//$str = file_get_contents($logfile);
		//var_dump($sessions);exit;
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=".substr($logfile,strrpos($logfile,'/'))); 
		$handle = @fopen($logfile, "r");
		if ($handle) {
			while (!feof($handle)) {
				$buffer = fgets($handle, 4096);
				echo $buffer;
			}
			fclose($handle);
		}
		exit();
	}

	
}
?>
