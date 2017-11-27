<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_sqlnet extends c_base {
	function index($where = NULL) {
		//$table_name = get_request('table_name', 0, 1);
		//if($table_name) {
		//	$this->session_set->set_table_name($table_name);
		//}
		//else {
		//	$table_name = $this->session_set->get_table_name();
		//}
		global $_CONFIG;
		$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);

		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";
	
		$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$this->assign('member', $member);

		$s_addr = get_request('s_addr', 0, 1);
		$d_addr = get_request('d_addr', 0 ,1);
		$s_mac = get_request('s_mac', 0, 1);
		$d_mac = get_request('d_mac', 0 ,1);
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
			$where .= " AND  LEFT(d_addr,IF(LOCATE(':',d_addr)>0,LOCATE(':',d_addr)-1,LENGTH(d_addr))) IN (SELECT device_ip FROM ".$this->devpass_set->get_table_name()." WHERE id IN (".implode(",",$alldevsid).")) ";
		}
		elseif($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			//$oldmem = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			//$where .= " AND d_addr IN (SELECT device_ip FROM servers WHERE groupid = ".$oldmem['mservergroup']." )";
			$where .= " AND LEFT(d_addr,IF(LOCATE(':',d_addr)>0,LOCATE(':',d_addr)-1,LENGTH(d_addr))) IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
		}

		if($s_addr) {
			if(is_ip($s_addr)) {
				$where .= " AND s_addr = '$s_addr'";
			}
			else {
				$where .= " AND s_addr LIKE '%$s_addr%'";
			}
		}
		

		if($d_addr) {
			if(is_ip($d_addr)) {
				$where .= " AND d_addr = '$d_addr'";
			}
			else {
				$where .= " AND d_addr LIKE '%$d_addr%'";
			}
		}

		if($s_mac) {
			if(is_ip($d_addr)) {
				$where .= " AND s_mac = '$s_mac'";
			}
			else {
				$where .= " AND s_mac LIKE '$s_mac%'";
			}
		}

		if($d_mac) {
			if(is_ip($d_addr)) {
				$where .= " AND d_mac = '$d_mac'";
			}
			else {
				$where .= " AND d_mac LIKE '$d_mac%'";
			}
		}

		if($user) {
			$where .= " AND user like '%$user%'";
		}

		if($luser) {
			$where .= " AND user like '%$luser%'";
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
		
		if($end1 && $end2) {
			$where .= " AND (end >= '$end1' AND end <= '$end2')";
		}



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
			$this->assign('command', $command);
			$this->assign('allsession', $this->sqlnet_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$this->display("sqlnetsession_list.tpl");
		}
	}

	function search() {
		//$table_list = $this->get_table_list();
		//$this->assign('table_list', $table_list);
		$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
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
		$command = get_request('command', 0, 1);	
		

		$row_num = $this->sqlcommands_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->sqlcommands_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, '', 'asc');

		for($j = 0; $j < count($allcommand); $j++) {
			if($command){
				$allcommand[$j]['cmd'] = preg_replace("/($command)/i","<font color='red'>\$1</font>", $allcommand[$j]['cmd']);
			}
		}
		$this->assign('allcommand', $allcommand);
		
		$this->display('sqlsession_view.tpl');
	}

	function del_command() {
		$cid = get_request('cid');
		$this->sqlcommands_set->delete($cid);
		alert_and_back('删除成功');
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
		alert_and_back('删除成功');
	}

	function delete($where) {


		$this->sqlcommands_set->query("DELETE FROM `" . $this->sqlcommands_set->get_table_name() . "` WHERE `sid` IN (SELECT `sid` FROM `sessions` WHERE $where)");
		$this->sqlnet_set->query("DELETE FROM `" . $this->sqlnet_set->get_table_name() . "` WHERE $where");
		alert_and_back('æåå é¤æå®ä¼è¯');
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
			echo language("会话读取失败");
			die();
		}
		if($logfile == NULL) {
            echo language("日志文件有问题");	
			die();

		}
		if(!file_exists($logfile)) {
			echo ($_CONFIG['ORACLE_LOG_PATH_PREFIX'].$sessions['logfile']);
            echo language("日志文件不存在");
			die();
		}
		$file = file_get_contents($logfile);
		echo $file;
	}

	function replay() {
		global $_CONFIG;
		$this->assign("activex_version", $_CONFIG['ACTIVEX_VERSION']);
		$sid = get_request('sid');
		$cid = get_request('cid');
		$tool = get_request('tool',0,1);
		$app_act = get_request('app_act', 0, 1);
		$a = $this->get_eth0_ip();
		$this->assign("sid", $sid);
		$this->assign("cid", $cid);
		$this->assign("app_act",$app_act);
	
		$session = $this->sqlnet_set->select_by_id($sid);
		
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
			if(empty($eth0)){
				$eth0 = $a['eth0'];
			}
				
			//$session['host']=$eth0;
			$this->assign("s", $session);
			$this->assign("tool", $tool);
			$this->assign("proxy_addr", $eth0);
			$this->assign("monitorport", $_CONFIG['MONITORPORT']);
			$this->assign("monitoruser", $_CONFIG['MONITORUSER']);
			$this->assign("monitorpassword", $_CONFIG['MONITORPASSWORD']);
			
			$str = genRandomString(8);
			$random = new random();
			$random->set_data('device_ip', '127.0.0.1');
			$random->set_data('username', $_CONFIG['MONITORUSER']);
			$random->set_data('luser', $_CONFIG['MONITORUSER'].'--database--oracle--'.$sid.'--'.$cid.'--2');
			$random->set_data('time', date('Y-m-d H:i:s'));
			$random->set_data('code', $str);
			$this->random_set->add($random);
		
			$this->assign('random', $str);
			$this->assign("dbtype", "oracle");		
			$this->display('dbreplay.tpl');
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
			if(empty($eth0)){
				$eth0 = $a['eth0'];
			}
			$this->assign("s", $session);
			$this->assign("tool", $tool);
			$this->assign("proxy_addr", $eth0);
			$this->assign("cid", 0);
			$this->assign("monitorport", $_CONFIG['MONITORPORT']);
			$this->assign("monitoruser", $_CONFIG['MONITORUSER']);
			$this->assign("monitorpassword", $_CONFIG['MONITORPASSWORD']);
			
			$str = genRandomString(8);
			$random = new random();
			$random->set_data('device_ip', '127.0.0.1');
			$random->set_data('username', $_CONFIG['MONITORUSER']);
			$random->set_data('luser', $_CONFIG['MONITORUSER'].'--database--oracle--'.$sid.'--'.$cid.'--2');
			$random->set_data('time', date('Y-m-d H:i:s'));
			$random->set_data('code', $str);
			$this->random_set->add($random);
			$this->assign('random', $str);
			$this->assign("dbtype", "oracle");		
			$this->display('dbreplay.tpl');
			exit;
		}

		$this->assign('serveradd',$_SERVER['SERVER_NAME'] );
		$this->assign('serverport', $_SERVER[SERVER_PORT]);
		//		$this->assign('filename',str_replace('"','\''," -S ".strtotime($time)." ".$session['replayfile']));
		$this->assign('filename',str_replace('"','',$session['replayfile']));

		$this->display('replays.tpl');
	}

	function get_eth0_ip() {

		global $_CONFIG;
		$eth0 = explode(":", $_SERVER["HTTP_HOST"]);
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
}
?>
