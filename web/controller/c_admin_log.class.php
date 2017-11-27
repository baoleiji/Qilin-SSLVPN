<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_log extends c_base {
	function list_login($where = NULL) {
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$id1 = get_request('id1', 0, 1);
		$id2 = get_request('id2', 0, 1);
		$host = get_request('host', 0, 1);
		$from = get_request('from', 0, 1);
		$username = get_request('username', 0, 1);
		$time1 = get_request('time1', 0, 1);
		$time2 = get_request('time2', 0, 1);

		if(strcasecmp($orderby2, 'asc') != 0 && strcasecmp($orderby2, 'desc') != 0) {
			$orderby2 = 'DESC';
		}
		
		if($from) {
			if(is_ip($from)) {
				$where .= " AND `from` = '$from'";
			}
			else {
				$where .= " AND `from` LIKE '$from%'";
			}
		}

		if($host) {
			if(is_ip($host)) {
				$where .= " AND host = '$host'";
			}
			else {
				$where .= " AND host LIKE '$host%'";
			}
		}
		
		
		if($id1 !== NULL && $id2 !== NULL) {
			$where .= " AND (id >= $id1 AND id <= $id2)";
		}

		if($time1 && $time2) {
			$where .= " AND (time >= '$time1' AND time <= '$time2')";
		}

		if($username) {
			$where .= " AND (username LIKE '%$username%')";
		}
		
		if($_SESSION['ADMIN_LEVEL'] != 1) {
			$where .= " AND host IN (" . implode(",", $this->get_user_flist()) . ")";
		}

		//$table_list = $this->get_table_list();

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		
		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete_loginlog($where);
			}
			else {
				die(language('没有权限'));
			}
		}
		else if($derive) {
			$this->derive_loginlog($where);
		}
		else {
			$row_num = $this->loginlog_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('log_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('alllog', $this->loginlog_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));
			$this->display("loginlog_list.tpl");
		}
	}
	
	function list_crontab($where = NULL) {
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$id1 = get_request('id1', 0, 1);
		$id2 = get_request('id2', 0, 1);
		$host = get_request('host', 0, 1);
		$cmd = get_request('cmd', 0, 1);
		$time1 = get_request('time1', 0, 1);
		$time2 = get_request('time2', 0, 1);

		if(strcasecmp($orderby2, 'asc') != 0 && strcasecmp($orderby2, 'desc') != 0) {
			$orderby2 = 'DESC';
		}
		
		if($host) {
			if(is_ip($host)) {
				$where .= " AND host = '$host'";
			}
			else {
				$where .= " AND host LIKE '$host%'";
			}
		}
		
		if($id1 !== NULL && $id2 !== NULL) {
			$where .= " AND (id >= $id1 AND id <= $id2)";
		}

		if($time1 && $time2) {
			$where .= " AND (time >= '$time1' AND time <= '$time2')";
		}
		
		if($_SESSION['ADMIN_LEVEL'] != 1) {
			$where .= " AND host IN (" . implode(",", $this->get_user_flist()) . ")";
		}

		if($cmd) {
			$where .= " AND (cmd LIKE '%$cmd%')";
		}


		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		
		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete_crontablog($where);
			}
			else {
				die(language('没有权限'));
			}
		}
		else if($derive) {
			$this->derive_crontablog($where);
		}
		else {
			$row_num = $this->crontablog_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('log_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('alllog', $this->crontablog_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));
			$this->display("crontablog_list.tpl");
		}
	}

	function search_login() {
		$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
		$this->assign('allmethod', $this->tem_set->select_all());
		$this->display("loginlog_search.tpl");
	}
	
	function search_crontab() {
		$this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
		$this->display("crontablog_search.tpl");
	}
	
	function derive_loginlog($where) {
		$result = $this->loginlog_set->select_limit(0, 10000, $where);
		$handle = fopen(ROOT . '/tmp/loginlog.xls', 'w');
		fwrite($handle, "ID\t");
		fwrite($handle, language("设备地址")."\t");
		fwrite($handle, language("会话类型")."\t");
		fwrite($handle, language("用户名")."\t");
		fwrite($handle, language("开始时间")."\t");
		fwrite($handle, language("结束时间")."\t\n");
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
		go_url("tmp/loginlog.xls?c=" . rand());
	}

	function derive_crontablog($where) {
		$result = $this->crontablog_set->select_limit(0, 10000, $where);
		$handle = fopen(ROOT . '/tmp/crontablog.xls', 'w');
		fwrite($handle, "ID\t");
		fwrite($handle, language("主机地址")."\t");
		fwrite($handle, language("执行时间")."\t");
		fwrite($handle, language("命令行")."\t");
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
		go_url("tmp/crontablog.xls?c=" . rand());
	}
	function delete_loginlog($where) {
		$this->loginlog_set->query("DELETE FROM `loginlog` WHERE $where");
		alert_and_back('成功删除指定日志');
	}
	
	function delete_crontablog($where) {
		$this->crontablog_set->query("DELETE FROM `crontablog` WHERE $where");
		alert_and_back('成功删除指定日志');
	}
	
	function adminlog() {
		global $_CONFIG;
		$type = array(
				 1=>'系统用户组绑定或解绑用户',
				 2=>'系统用户组绑定或解绑组',
				 3=>'应用用户组绑定或解绑用户',
				 4=>'应用用户组绑定或解绑组',
				 5=>'设备用户绑定或解绑用户',
				 6=>'设备用户绑定或解绑组',
				 7=>'应用发布绑定或解绑用户',
				 8=>'应用发布绑定或解绑组',
				 9=>'',
				10=>'',
				11=>'添加删除修改密码运维用户',
				12=>'添加删除编辑组',
				13=>'添加删除编辑系统用户修改系统用户密码',
				14=>'添加修改删除设备',
				15=>'批量删除日志'
		);
		$page_num = get_request('page');
		$luser = get_request('luser', 0, 1);
		$lgroup = get_request('lgroup', 0, 1);
		$operation = get_request('operation', 0, 1);
		$administrator = get_request('administrator', 0, 1);
		$start = get_request('start', 0, 1);
		$end = get_request('end', 0, 1);
		$resource_user = get_request('resource_user', 0, 1);
		$resource = get_request('resource', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'optime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		$where = '1=1';
		$groupid = $lgroup;
		require_once('./include/select_sgroup_ajax.inc.php');
		if($luser){
			$where .= " AND luser='$luser'" ;
		}
		if($lgroup){
			$where .= " AND lgroup=(select groupname from ".$this->sgroup_set->get_table_name()." where id ='$lgroup' limit 1)" ;
		}
		if($operation){
			$where .= " AND action='$operation'" ;
		}
		if($administrator){
			$where .= " AND administrator='$administrator'" ;
		}
		if ($start) {
            $where .= " AND optime >= '$start' ";
        }        
        if ($end) {
            $where .= " AND optime <= '$end' ";
        }
		if ($resource_user) {
            $where .= " AND resource_user like '%$resource_user%' ";
        }
		if ($resource) {
            $where .= " AND resource like '%$resource%' ";
        }
		$row_num = $this->admin_log_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$allmember = $this->admin_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where, $orderby1, $orderby2);
		
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);

		$out = $allmember;

		for($i=0;$i<count($out);$i++) {
			$out[$i]['username'] = $allmember[$i]['username'];
		}
		$this->assign('allmember', $out);
		$this->display('adminlog_list.tpl');
	}

	function delete_adminlog() {
		$uid = get_request('chk_member', 1, 1);
		$this->admin_log_set->delete($uid);		
		alert_and_back('成功删除用户');
	}

	function logs_warning() {
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$id1 = get_request('id1', 0, 1);
		$id2 = get_request('id2', 0, 1);
		$host = get_request('host', 0, 1);
		$from = get_request('from', 0, 1);
		$username = get_request('username', 0, 1);
		$time1 = get_request('time1', 0, 1);
		$time2 = get_request('time2', 0, 1);

		if(strcasecmp($orderby2, 'asc') != 0 && strcasecmp($orderby2, 'desc') != 0) {
			$orderby2 = 'DESC';
		}
		
		if($from) {
			if(is_ip($from)) {
				$where .= " AND `from` = '$from'";
			}
			else {
				$where .= " AND `from` LIKE '$from%'";
			}
		}

		if($host) {
			if(is_ip($host)) {
				$where .= " AND host = '$host'";
			}
			else {
				$where .= " AND host LIKE '$host%'";
			}
		}
		
		
		if($id1 !== NULL && $id2 !== NULL) {
			$where .= " AND (id >= $id1 AND id <= $id2)";
		}

		if($time1 && $time2) {
			$where .= " AND (time >= '$time1' AND time <= '$time2')";
		}

		if($username) {
			$where .= " AND (username LIKE '%$username%')";
		}
		
		if($_SESSION['ADMIN_LEVEL'] != 1) {
			$where .= " AND host IN (" . implode(",", $this->get_user_flist()) . ")";
		}

		//$table_list = $this->get_table_list();

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		
		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete_loginlog($where);
			}
			else {
				die(language('没有权限'));
			}
		}
		else if($derive) {
			$reports = $this->logs_warning_set->select_all($where);
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .= language("序号")."\t".language("主机")."\t".language("设备")."\t".language("级别")."\t".language("等级")."\t".language("时间")." \t".language("程序")." \t".language("标识")."\t".language("日志内容")."\t".language("探针")."\t".language("邮件发送")."\t".language("短信发送")."\t\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['host']."\t".$report['facility']."\t".$report['priority']."\t".$report['level']."\t".$report['datetime']."\t".$report['program']."\t".$report['tag']."\t".$report['msg']."\t".$report['logserver']."\t".($report['mail_status']==1 ? '成功' : '失败')."\t".($report['sms_status']==1 ? '成功' : '失败');
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=log_warning.csv"); 
			echo iconv("UTF-8", "GBK", $str);
			exit();
		}
		else {
			$row_num = $this->logs_warning_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('log_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('result_array', $this->logs_warning_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));
			$this->display("logs_warning.tpl");
		}
	}

	function logs_warning_detail(){
		$seq = get_request('seq');
		$log = $this->logs_warning_set->select_by_id($seq);
		$this->assign("detail", $log);
		$this->display("logs_warning_detail.tpl");
	}

	function applog_warning() {
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$id1 = get_request('id1', 0, 1);
		$id2 = get_request('id2', 0, 1);
		$host = get_request('host', 0, 1);
		$from = get_request('from', 0, 1);
		$username = get_request('username', 0, 1);
		$time1 = get_request('time1', 0, 1);
		$time2 = get_request('time2', 0, 1);

		if(strcasecmp($orderby2, 'asc') != 0 && strcasecmp($orderby2, 'desc') != 0) {
			$orderby2 = 'DESC';
		}
		
		if($from) {
			if(is_ip($from)) {
				$where .= " AND `from` = '$from'";
			}
			else {
				$where .= " AND `from` LIKE '$from%'";
			}
		}

		if($host) {
			if(is_ip($host)) {
				$where .= " AND host = '$host'";
			}
			else {
				$where .= " AND host LIKE '$host%'";
			}
		}
		
		
		if($id1 !== NULL && $id2 !== NULL) {
			$where .= " AND (id >= $id1 AND id <= $id2)";
		}

		if($time1 && $time2) {
			$where .= " AND (time >= '$time1' AND time <= '$time2')";
		}

		if($username) {
			$where .= " AND (username LIKE '%$username%')";
		}
		
		if($_SESSION['ADMIN_LEVEL'] != 1) {
			$where .= " AND host IN (" . implode(",", $this->get_user_flist()) . ")";
		}

		//$table_list = $this->get_table_list();

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		
		if($delete) {
			
		}
		else if($derive) {
			$reports = $this->applog_warning_set->select_all($where);
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .= language("序号")."\t".language("主机")."\t".language("时间")."\t".language("日志内容")."\t".language("邮件发送")."\t".language("短信发送")."\t\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['host']."\t".$report['datetime']."\t".$report['msg']."\t".($report['mail_status']==1 ? '成功' : '失败')."\t".($report['sms_status']==1 ? '成功' : '失败');
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=log_warning.csv"); 
			echo iconv("UTF-8", "GBK", $str);
			exit();
		}
		else {
			$row_num = $this->applog_warning_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('log_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('result_array', $this->applog_warning_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));
			$this->display("applog_warning.tpl");
		}
	}

	function applog_warning_detail(){
		$seq = get_request('seq');
		$log = $this->applog_warning_set->select_by_id($seq);
		$this->assign("detail", $log);
		$this->display("applog_warning_detail.tpl");
	}

	function downuploaded(){
		$page_num = get_request('page');
		$delete = get_request('delete');
		$user = get_request('user',0,1);
		$type = get_request('type',0,1);
		$where = "1=1";
		//$table_list = $this->get_table_list();

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}

		if($user){
			$where .= " AND user='".$user."'";
		}
		if($type){
			$where .= " AND type='".$type."'";
		}
		
		if($delete) {
			$id = get_request('id');
			$s = $this->importlog_set->select_by_id($id);
			@unlink($s['file']);
			$this->importlog_set->delete($id);
			alert_and_back('成功删除');
			exit;
		}
		else {
			$row_num = $this->importlog_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('log_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('importlog', $this->importlog_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));
			$this->display("importlog.tpl");
		}
	}

	function downloadfile(){
		$id = get_request('id');
		$s = $this->importlog_set->select_by_id($id);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=".basename($s['file'])); 
		echo file_get_contents($s['file']);
		exit();
	}
}
?>
