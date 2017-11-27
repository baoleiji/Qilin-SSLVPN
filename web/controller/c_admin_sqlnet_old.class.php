<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_sqlnet_old extends c_base {
	function index($where = NULL) {
		//$table_name = get_request('table_name', 0, 1);
		//if($table_name) {
		//	$this->session_set->set_table_name($table_name);
		//}
		//else {
		//	$table_name = $this->session_set->get_table_name();
		//}
		

		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";

		
		$s_addr = get_request('s_addr', 0, 1);
		$d_addr = get_request('d_addr', 0 ,1);
		$user = get_request('user', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$sid1 = get_request('sid1', 0, 1);
		$sid2 = get_request('sid2', 0, 1);
		$start1 = get_request('start1', 0, 1);
		$end1 = get_request('end1', 0, 1);
		$start2 = get_request('start2', 0, 1);
		$end2 = get_request('end2', 0, 1);
		$command = get_request('command', 0, 1);
		$s_addr = get_request('srcaddr', 0, 1);

		if($_SESSION['ADMIN_LEVEL'] == 0) {
			$where .= " AND d_addr IN (SELECT device_ip FROM devices WHERE luser like '%,".$_SESSION['ADMIN_UID'].",%' )";
		}
		elseif($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			//$oldmem = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			//$where .= " AND d_addr IN (SELECT device_ip FROM servers WHERE groupid = ".$oldmem['mservergroup']." )";
			$where .= " AND d_addr IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
		}

		if($s_addr) {
			if(is_ip($s_addr)) {
				$where .= " AND s_addr = '$s_addr'";
			}
			else {
				$where .= " AND s_addr LIKE '$s_addr%'";
			}
		}
		

		if($d_addr) {
			if(is_ip($d_addr)) {
				$where .= " AND d_addr = '$d_addr'";
			}
			else {
				$where .= " AND d_addr LIKE '$d_addr%'";
			}
		}

		if($user) {
			$where .= " AND user = '$user'";
		}

		if(strcasecmp($orderby2, 'asc') != 0 && strcasecmp($orderby2, 'desc') != 0) {
			$orderby2 = 'DESC';
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


/*

		$type = get_request('type', 0, 1);
		$addr = get_request('addr', 0, 1);
		$time = get_request('time', 0, 1);


		if($addr) {
			if(is_ip($addr)) {
				$where .= " AND addr = '$addr'";
			}
			else {
				$where .= " AND addr LIKE '$addr%'";
			}
		}
		
		if($type) {
			if($type != 'all') {
				$where .= " AND type = '$type'";
			}
		}

		if($_SESSION['ADMIN_LEVEL'] != 1) {
			//$luser = $_SESSION['ADMIN_USERNAME'];	
			//$where .= " AND luser = '$luser'";
			$where .= " AND addr IN (" . implode(",", $this->get_user_flist()) . ")";
		}

		

		if($time) {
			//$where .= " AND (start <= '$time' AND end >= '$time')";
			$where .= " AND (start <= '$time')";
		}
*/
		if($command) {
			$where .= " AND (SELECT COUNT(*) FROM `oracle_commands` WHERE cmd LIKE '%$command%' AND oracle_commands.sid = oracle_sessions.sid) > 0";
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
			
			}
			//echo $curr_url;
			
			$row_num = $this->sqlnet_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('allsession', $this->sqlnet_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$this->display("sqlnetsession_list_old.tpl");
		}
	}

	function search() {
		//$table_list = $this->get_table_list();
		//$this->assign('table_list', $table_list);
		$this->assign('alldev', $this->dev_set->select_all());
		$this->display("sqlnet_search.tpl");
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
		$result = $this->sqlnet_set->select_limit(0, 10000, $where);
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

		$row_num = $this->sqlcommands_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->sqlcommands_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, '', 'asc');
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
		
		$this->display('sqlsession_view.tpl');
	}

	function del_command() {
		$cid = get_request('cid');
		$this->sqlcommands_set->delete($cid);
		alert_and_back('æåå é¤æä»¤!');
	}
	
	function del_session() {
		global $_CONFIG;
		$sid = get_request('sid');
		$session = $this->sqlnet_set->select_by_id($sid);
		if ($this->sqlnet_set->select_count("logfile = '".str_replace('\'','\\\'',$session['logfile'])."'") == 1 ) {
			if(file_exists($_CONFIG['ORACLE_LOG_PATH_PREFIX'].$session['logfile'])) {
				unlink($_CONFIG['ORACLE_LOG_PATH_PREFIX'].$session['logfile']);
			}
		}
		$this->sqlnet_set->delete($sid);
		$this->sqlcommands_set->query("DELETE FROM `" . $this->sqlcommands_set->get_table_name() . "` WHERE sid = '$sid'");
		alert_and_back('删除成功!');
	}

	function delete($where) {

        /*===============lwm===============
//        print "select logfile from " . $this->sqlnet_set->get_table_name() . " WHERE $where";
        $result=mysql_query("select logfile from " . $this->sqlnet_set->get_table_name() . " WHERE $where");
        while ($row = mysql_fetch_assoc($result))
        {
			if(file_exists($row["logfile"]))
			{
	           	unlink($row["logfile"]);
    	        unlink($row["logfile"]."onlight");
			}
        }
        ==============lwm================*/

		$this->sqlcommands_set->query("DELETE FROM `" . $this->sqlcommands_set->get_table_name() . "` WHERE `sid` IN (SELECT `sid` FROM `sessions` WHERE $where)");
		$this->sqlnet_set->query("DELETE FROM `" . $this->sqlnet_set->get_table_name() . "` WHERE $where");
		alert_and_back('æåå é¤æå®ä¼è¯');
	}

	function derive_command() {
		$sid = get_request('sid');
		$result = $this->sqlcommands_set->select_limit(0, 10000, "sid = '$sid'");
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
		global $_CONFIG;
		$sid = get_request('sid');
		if(!defined($sid))
		{
			$sid=$_GET["sid"];			
		}
		$sessions = $this->sqlnet_set->select_by_id($sid);
		$logfile = str_replace("\'","",$_CONFIG['ORACLE_LOG_PATH_PREFIX'].$sessions['logfile']);
		$fname = explode('/',$sessions['logfile']);
		if(!$sessions) {
			echo ("会话读取失败");
			die();
		}
		if($logfile == NULL) {
            echo ("日志文件有问题");	
			die();

		}
		if(!file_exists($logfile)) {
			echo ($_CONFIG['ORACLE_LOG_PATH_PREFIX'].$sessions['logfile']);
            echo ("日志文件不存在");
			die();
		}
		$file = file_get_contents($logfile);
		echo $file;
	}
}
?>
