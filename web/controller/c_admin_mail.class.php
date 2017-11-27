<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_mail extends c_base {
	function index($where = NULL) {
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
		$command = get_request('command', 0, 1);
		$srcaddr = get_request('srcaddr', 0, 1);

		if(empty($orderby1)){
			$orderby1 = 'sid';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

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
			$where .= " AND addr IN (SELECT device_ip FROM devices WHERE luser like '%,".$_SESSION['ADMIN_UID'].",%' )";
		}
	
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101 ){
			$where .= " AND addr IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
		}

		if($user) {
			$where .= " AND user like '%$user%'";
		}
		
		if($sid1 !== NULL && $sid2 !== NULL) {
			$where .= " AND (sid >= $sid1 AND sid <= $sid2)";
		}

		if($start1 && $start2) {
			$where .= " AND (start >= '$start1' AND start <= '$start2')";
		}
		
		if($end1 && $end2) {
			$where .= " AND (end >= '$end1' AND end <= '$end2')";
		}

		if($time) {
			//$where .= " AND (start <= '$time' AND end >= '$time')";
			$where .= " AND (start <= '$time')";
		}

		if($command) {
			$where .= " AND (SELECT COUNT(*) FROM `commands` WHERE cmd LIKE '%$command%' AND commands.sid = sessions.sid) > 0";
		}

		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete($where);
			}
			else {
				die('æ²¡ææé');
			}
		}
		else if($derive) {
			$this->derive($where);
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
			
			$row_num = $this->mails_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('allsession', $this->mails_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$this->display("mail_list.tpl");
		}
	}

	function search() {
		//$table_list = $this->get_table_list();
		//$this->assign('table_list', $table_list);
		if($_SESSION['ADMIN_LEVEL'] != 1) {
			$devs = $_SESSION['DEVS'];
			$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
		}
		else {
			$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
		}
		$this->display("session_search.tpl");
	}

	//function get_table_list() {
	//	$result = $this->info_set->base_select("SHOW TABLES LIKE 'info%'");
	//	$table_list = array();
	//	foreach($result as $table_name) {
	//		$table_list[] = $table_name['Tables_in_log (info%)'];
	//	}
	//	return $table_list;	
	//}

	function derive($where) {
		$result = $this->mails_set->select_limit(0, 10000, $where);
		$handle = fopen(ROOT . '/tmp/sessions.xls', 'w');
		fwrite($handle, "ID\t");
		fwrite($handle, "è®¾å¤å°å\t");
		fwrite($handle, "ä¼è¯ç±»å\t");
		fwrite($handle, "ç¨æ·å\t");
		fwrite($handle, "å¼å§æ¶é´\t");
		fwrite($handle, "ç»ææ¶é´\t\n");
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
		
		$this->display('session_view.tpl');
	}

	function del_command() {
		$cid = get_request('cid');
		$this->commands_set->delete($cid);
		alert_and_back('æåå é¤æä»¤!');
	}
	
	function del_session() {
		$sid = get_request('sid');
		
		$this->mails_set->delete($sid);
		$this->commands_set->query("DELETE FROM `" . $this->commands_set->get_table_name() . "` WHERE sid = '$sid'");
		alert_and_back('æåå é¤ä¼è¯!');
	}

	function delete($where) {

        /*===============lwm===============*/
//        print "select logfile from " . $this->mails_set->get_table_name() . " WHERE $where";
        $result=mysql_query("select logfile from " . $this->mails_set->get_table_name() . " WHERE $where");
        while ($row = mysql_fetch_assoc($result))
        {
			if(file_exists($row["logfile"]))
			{
	           	unlink($row["logfile"]);
    	        unlink($row["logfile"]."onlight");
			}
        }
        /*==============lwm================*/

		$this->commands_set->query("DELETE FROM `" . $this->commands_set->get_table_name() . "` WHERE `sid` IN (SELECT `sid` FROM `sessions` WHERE $where)");
		$this->mails_set->query("DELETE FROM `" . $this->mails_set->get_table_name() . "` WHERE $where");
		alert_and_back('æåå é¤æå®ä¼è¯');
	}

	function derive_command() {
		$sid = get_request('sid');
		$result = $this->commands_set->select_limit(0, 10000, "sid = '$sid'");
		$handle = fopen(ROOT . "/tmp/commands.xls", 'w');
		fwrite($handle, "id\t");
		fwrite($handle, "æ§è¡æ¶é´\t");
		fwrite($handle, "å½ä»¤\t\n");
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
		go_url("tmp/commands.xls?c=" . rand());
		
	}

	function download() {
		header("Content-Type:text/html;charset=GB2312");
		$sid = get_request('sid');
		$start_page=$_GET["start_page"];
		if(!defined($sid))
		{
			$sid=$_GET["sid"];			
		}
		$sessions = $this->mails_set->select_by_id($sid);
		$logfile = $sessions['logfile']."onlight";
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
			print "<a href=\"admin.php?controller=admin_mail&action=download&sid=$sid&start_page=$pre_page\">pre page<br></a>";
		}

		if(count($buffer_array)==500)
		{
			print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_mail&action=download&sid=$sid&start_page=$next_page\">next page</a><br>";
		}
		
		foreach($buffer_array as $tmp)
		{
			echo $tmp." <br>";
		}
	}

		function dangerlist() {
		$page_num = get_request('page');

		$row_num = $this->dangercmd_set->select_count("1 = 1");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->dangercmd_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);

		$this->assign("allcommand",$allcommand);

		$this->display("dangercmd_list.tpl");
	}
	
	
}
?>
