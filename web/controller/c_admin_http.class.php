<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_http extends c_base {
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
		$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$this->assign('member', $member);

		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "login_template=14";

		
		$s_addr = get_request('s_addr', 0, 1);
		$d_addr = get_request('d_addr', 0 ,1);
		$user = get_request('user', 0, 1);
		$luser = get_request('luser', 0, 1);
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


		$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
		$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
		$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID'];
		$sql .= ")";
		$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP'];
		$sql .= ")";
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
		elseif($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			//$oldmem = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			//$where .= " AND d_addr IN (SELECT device_ip FROM servers WHERE groupid = ".$oldmem['mservergroup']." )";
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN (SELECT device_ip FROM ".$this->server_set->get_table_name()." WHERE id IN ($_SESSION[DEVS]))";
		}

		if($s_addr) {
			if(is_ip($s_addr)) {
				$where .= " AND cli_addr = '$s_addr'";
			}
			else {
				$where .= " AND cli_addr LIKE '%$s_addr%'";
			}
		}

		if($d_addr) {
			if(is_ip($d_addr)) {
				$where .= " AND addr = '$d_addr'";
			}
			else {
				$where .= " AND addr LIKE '%$d_addr%'";
			}
		}

		if(empty($orderby1)){
			$orderby1 = 'sid';
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
			$where .= " AND (start >= '$start1') ";
		}

		if($start2 ) {
			$where .= " AND (start <= '$start2') ";
		}

		if($user) {
			$where .= " AND user like '%$user%'";
		}

		if($luser) {
			$where .= " AND luser like '$luser%'";
		}
		
		if($end1 && $end2) {
			$where .= " AND (end >= '$end1' AND end <= '$end2')";
		}


		if($command) {
			$where .= " AND (SELECT COUNT(*) FROM `http_command` WHERE cmd LIKE '%$command%' AND http_command.sid = http_session.sid) > 0";
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
			
			$row_num = $this->rdp_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('allsession', $this->rdp_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			global $_CONFIG;	
			$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
			$this->display("httpsession_list.tpl");
		}
	}

	function search() {
		//$table_list = $this->get_table_list();
		//$this->assign('table_list', $table_list);
		$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
		$this->display("http_search.tpl");
	}

	

	function view() {
		$sid = get_request('sid');
		$where = "sid = '$sid'";
		$page_num = get_request('page');

		$row_num = $this->httpcmd_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->httpcmd_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, '', 'asc');
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
		
		$this->display('httpsession_view.tpl');
	}

	function del_command() {
		$cid = get_request('cid');
		$this->httpcmd_set->delete($cid);
		alert_and_back('æåå é¤æä»¤!');
	}
	
	function del_session() {
		global $_CONFIG;
		$sid = get_request('sid');
		$session = $this->rdp_set->select_by_id($sid);
		$logfile = str_replace("'","",$_CONFIG['HTTP_LOG_PATH_PREFIX'].$session['logfile']);
		if ($this->rdp_set->select_count("logfile = '".str_replace('\'','\\\'',$session['logfile'])."'") == 1 ) {
			if (file_exists($logfile)) {
				unlink($logfile);
			}
		}
		$this->rdp_set->delete($sid);
		$this->httpcmd_set->query("DELETE FROM `" . $this->httpcmd_set->get_table_name() . "` WHERE sid = '$sid'");
		alert_and_back('删除成功');
	}

	function delete($where) {


		$this->httpcmd_set->query("DELETE FROM `" . $this->httpcmd_set->get_table_name() . "` WHERE `sid` IN (SELECT `sid` FROM `sessions` WHERE $where)");
		$this->rdp_set->query("DELETE FROM `" . $this->rdp_set->get_table_name() . "` WHERE $where");
		alert_and_back('删除成功');
	}


	function download() {
		$sid = get_request('sid');
		if(!defined($sid))
		{
			$sid=$_GET["sid"];			
		}
		$sessions = $this->rdp_set->select_by_id($sid);
		$logfile = str_replace("'","",$_CONFIG['HTTP_LOG_PATH_PREFIX'].$sessions['logfile']);
		$fname = explode('/',$sessions['logfile']);
		if(!$sessions) {
			echo (language("会话读取失败"));
			die();
		}
		if($logfile == NULL) {
            echo language("日志文件有问题");	
			die();
		}
		if(!file_exists($logfile)) {
			echo $logfile;
//			echo ("/httplog/backup/".$sessions['logfile']);
            echo language("日志文件不存在");
			die();
		}
		$file = file_get_contents($logfile);
		echo nl2br(htmlspecialchars($file));
	}

	function detail() {
		$cid = get_request('cid');
		$sid = get_request('sid');
		$cmd = $this->httpcmd_set->select_all("sid = $sid and cid >= $cid");
		$page = '';
		for($i=0;$i<count($cmd);$i++) {
			if($cmd[$i]['session_desc'] == "client receive data") {
				$page .= $cmd[$i]['content'];
			}
			else {
				break;
			}
		}
		echo $page;
	}
}
?>
