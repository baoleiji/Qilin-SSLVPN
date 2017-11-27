<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_vpnlog extends c_base {
	function index($where = NULL) {
	

		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1";

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$sid1 = get_request('sid1', 0, 1);
		$sid2 = get_request('sid2', 0, 1);
		$addr = get_request('addr', 0, 1);
		$type = get_request('type', 0, 1);
		
		$addr = get_request('addr', 0, 1);
		$start1 = get_request('start1', 0, 1);
		$end1 = get_request('end1', 0, 1);
		$start2 = get_request('start2', 0, 1);
		$end2 = get_request('end2', 0, 1);
		$time = get_request('time', 0, 1);
		$command = get_request('command', 0, 1);

		$fromip =  get_request('fromip', 0, 1);
		$toip =  get_request('toip', 0, 1);
		$user = get_request('user', 0, 1);
		$f_rangeStart =  get_request('f_rangeStart', 0, 1);
		$f_rangeEnd =  get_request('f_rangeEnd', 0, 1);

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'in_time';
		}

		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($fromip) {
			if(is_ip($fromip)) {
				$where .= " AND src_ip like '$fromip%'";
			}
			else {
				$where .= " AND src_ip LIKE '$fromip%'";
			}
		}


		if($toip) {
			if(is_ip($toip)) {
				$where .= " AND ip like '$toip%'";
			}
			else {
				$where .= " AND ip LIKE '$toip%'";
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
			//$where .= " AND addr IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
			if($_CONFIG['DEPART_ADMIN']){
					$alltmpip = array(0);
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				
					$where .= " AND addr IN ('".implode("','", $alltmpip)."')";
				}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND luser IN ('".implode("','", $alltmpuser)."')";
				}
		}

		if($user) {
			$where .= " AND user like '%$user%'";
		}
		
		if($sid1 !== NULL && $sid2 !== NULL) {
			$where .= " AND (sid >= $sid1 AND sid <= $sid2)";
		}

		if($f_rangeStart) {
			$where .= " AND in_time >= '$f_rangeStart'";
		}
		
		if($f_rangeEnd) {
			$where .= " AND out_time >= '$f_rangeEnd' ";
		}

		if($time) {
			//$where .= " AND (start <= '$time' AND end >= '$time')";
			$where .= " AND (start <= '$time')";
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
			
			$row_num = $this->vpnlog_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('allsession', $this->vpnlog_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$this->display("vpnlog_list.tpl");
		}
	}
	
	function delete($where) {
		$this->vpnlog_set->query("DELETE FROM `" . $this->vpnlog_set->get_table_name() . "` WHERE $where");
		
      	alert_and_back('删除成功');
	}
	
	function del() {
		$id = get_request("id", 0, 0);
		$this->vpnlog_set->delete($id);
      	alert_and_back('删除成功');
	}

	function delon() {
		$id = get_request("id", 0, 0);
		$this->vpnlog_set->query("UPDATE ".$this->vpnlog_set->get_table_name()." SET out_time=NOW() WHERE id=".$id);
      	alert_and_back('删除成功');
	}

	function derive($where) {
		global $_CONFIG;
		$file = $_CONFIG['CONFIGFILE']['OPENVPGLOG'];
		$lines = file($file);
		for($i=0; $i<count($lines); $i++){
			if(strpos(strtolower($lines[$i]), "common name")===0){
				$start = 1;
				continue;
			}
			if(strpos(strtolower($lines[$i]), strtolower("ROUTING TABLE"))!==false){
				$start = 0;
				continue;
			}
			if($start){
				$tmp=explode(',', $lines[$i]);
				$t = $tmp[2];
				$tmp[2]=$tmp[4];
				$tmp[4]=$t;
				$result[]=$tmp;
			}
		}
		//$result = $this->vpnlog_set->select_limit(0, 10000, $where);
		$handle = fopen(ROOT . '/tmp/vpnlog.xls', 'w');
		fwrite($handle, "ID\t");
		fwrite($handle, language("用户")."\t");
		fwrite($handle, language("来源IP")."\t");
		fwrite($handle, language("连接时间")."\t");
		fwrite($handle, language("发送字节")."\t");
		fwrite($handle, language("接收字节")."\t\n");
		$row = 1;
		if($result)
		foreach($result as $info) {
			$col = 0;
			fwrite($handle, ($col++)."\t");
			foreach($info as $t) {
				fwrite($handle, "$t\t");
				$col++;
			}
			fwrite($handle, "\n");
			$row++;
		}
		fclose($handle);
		go_url("tmp/vpnlog.xls?c=" . rand());
	}
	
	function online(){
		global $_CONFIG;
		$derive = get_request('derive');
		$delete = get_request('delete');
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
		}else{
			$file = $_CONFIG['CONFIGFILE']['OPENVPGLOG'];
			$lines = file($file);
			for($i=0; $i<count($lines); $i++){
				if(strpos(strtolower($lines[$i]), "common name")===0){
					$start = 1;
					continue;
				}
				if(strpos(strtolower($lines[$i]), strtolower("ROUTING TABLE"))!==false){
					$start = 0;
					continue;
				}
				if($start){
					$tmp=explode(',', $lines[$i]);
					$t = $tmp[2];
					$tmp[2]=$tmp[4];
					$tmp[4]=$t;
					$allsessions[]=$tmp;
				}
			}
			$curr_url = $_SERVER['PHP_SELF'] . "?";
			if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
				$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
			}
			else {
				$curr_url .= $_SERVER['QUERY_STRING'];
			}
			$this->assign("allsession", $allsessions);
			$this->assign('curr_url', $curr_url);
			$this->display("vpnlogonline_list.tpl");
		}
	}
	
	function cut(){
		global $_CONFIG;
		$username= get_request('username', 0, 1);
		$cmd = $_CONFIG['CONFIGFILE']['VPNCUT']." ".$username;
		$a = exec($cmd, $o, $r);
		if($r==0){
			$this->member_set->query("UPDATE member set vpn=0 where username='".$username."'");
			alert_and_back('操作成功');
			return ;
		}
		alert_and_back('操作失败');
	}

	function online_bak(){
		$this->assign("online", 1);
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = " (select count(*) FROM ".$this->member_set->get_table_name()." WHERE used=1 and vpn_log.user=username and out_time IS NULL)";

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$sid1 = get_request('sid1', 0, 1);
		$sid2 = get_request('sid2', 0, 1);
		$addr = get_request('addr', 0, 1);
		$type = get_request('type', 0, 1);
		
		$addr = get_request('addr', 0, 1);
		$start1 = get_request('start1', 0, 1);
		$end1 = get_request('end1', 0, 1);
		$start2 = get_request('start2', 0, 1);
		$end2 = get_request('end2', 0, 1);
		$time = get_request('time', 0, 1);
		$command = get_request('command', 0, 1);

		$fromip =  get_request('fromip', 0, 1);
		$toip =  get_request('toip', 0, 1);
		$user = get_request('user', 0, 1);
		$f_rangeStart =  get_request('f_rangeStart', 0, 1);
		$f_rangeEnd =  get_request('f_rangeEnd', 0, 1);

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'in_time';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($fromip) {
			if(is_ip($fromip)) {
				$where .= " AND src_ip like '$fromip%'";
			}
			else {
				$where .= " AND src_ip LIKE '$fromip%'";
			}
		}


		if($toip) {
			if(is_ip($toip)) {
				$where .= " AND ip like '$toip%'";
			}
			else {
				$where .= " AND ip LIKE '$toip%'";
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
	
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101){
			$where .= " AND addr IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
		}

		if($user) {
			$where .= " AND user like '%$user%'";
		}
		
		if($sid1 !== NULL && $sid2 !== NULL) {
			$where .= " AND (sid >= $sid1 AND sid <= $sid2)";
		}

		if($f_rangeStart) {
			$where .= " AND in_time >= '$f_rangeStart'";
		}
		
		if($f_rangeEnd) {
			$where .= " AND out_time >= '$f_rangeEnd' ";
		}

		if($time) {
			//$where .= " AND (start <= '$time' AND end >= '$time')";
			$where .= " AND (start <= '$time')";
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
			
			$row_num = $this->vpnlog_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('allsession', $this->vpnlog_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));

			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$this->display("vpnlogonline_list.tpl");
		}
	}
	
}
?>
