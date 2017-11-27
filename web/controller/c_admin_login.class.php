<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_login extends c_base {
	function index() {
		$derive = $this->getInput('derive');
		$host = $this->getInput('host');
		$sourceip = $this->getInput('sourceip');
		$user = $this->getInput('user');
		$status = $this->getInput('status');
		$f_rangeStart = $this->getInput('f_rangeStart');
		$f_rangeEnd = $this->getInput('f_rangeEnd');
		$query = ' 1=1';
		if($host){
			$query .= " and host like '%$host%'";
		}
		if($status){
			$query .= " and active =".($status%2);
		}
		if($sourceip){
			$query .= " and srchost like '%$sourceip%'";
		}
		if($user){
			$query .=  " and user like '%$user%'";
		}
		if($f_rangeStart){
			$query .=  " and starttime >= '$f_rangeStart'";
		}
		if($f_rangeEnd){
			$query .=  " and starttime <= '$f_rangeEnd'";
		}
		if($derive==1){
			$reports = $this->windows_login_set->select_all($query);
			$str .= language("序号")."\t".language("来源")."\t".language("主机")."\t".language("用户名")." \t".language("登录时间")." \t".language("退出时间")." \t".language("状态")." \t".language("探针")."\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['srchost']."\t".$report['host']."\t".$report['user']."\t".$report['starttime']."\t".$report['endtime']."\t".($report['active'] ? '成功' : '失败')."\t".$report['logserver'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=WindowsLogin.xls"); 
			echo iconv("UTF-8", "GBK", $str);
			exit();
		}
		$page_num = $this->getInput('page');
		$row_num = $this->windows_login_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $this->windows_login_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('alllogs', $alllogs);

		$this->display('windowslogin.tpl');
	}


	function linux() {
		$derive = $this->getInput('derive');
		$host = $this->getInput('host');
		$sourceip = $this->getInput('sourceip');
		$user = $this->getInput('user');
		$status = $this->getInput('status');
		$f_rangeStart = $this->getInput('f_rangeStart');
		$f_rangeEnd = $this->getInput('f_rangeEnd');
		$query = ' 1=1';
		if($host){
			$query .= " and host like '%$host%'";
		}
		if($status){
			$query .= " and active =".($status%2);
		}
		if($sourceip){
			$query .= " and srchost like '%$sourceip%'";
		}
		if($user){
			$query .=  " and user like '%$user%'";
		}
		if($f_rangeStart){
			$query .=  " and starttime >= '$f_rangeStart'";
		}
		if($f_rangeEnd){
			$query .=  " and starttime <= '$f_rangeEnd'";
		}
		if($derive==1){
			$reports = $this->windows_login_set->select_all($query);
			$str .= language("序号")."\t".language("来源")."\t".language("主机")."\t".language("用户名")." \t".language("登录时间")." \t".language("退出时间")." \t".language("状态")." \t".language("探针")."\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['srchost']."\t".$report['host']."\t".$report['user']."\t".$report['starttime']."\t".$report['endtime']."\t".($report['active'] ? '成功' : '失败')."\t".$report['logserver'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=WindowsLogin.xls"); 
			echo iconv("UTF-8", "GBK", $str);
			exit();
		}
		$page_num = $this->getInput('page');
		$row_num = $this->linux_login_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $this->linux_login_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('alllogs', $alllogs);

		$this->display('linuxlogin.tpl');
	}
	
	function search(){
		$this->display("login_search.tpl");	
	}
	
	function search_result() {
		$host = $_POST['host'];
		$table = $_POST['table'];		
		$logserver = $_POST['logserver'];
		$srchost = $_POST['srchost'];		
		$user = $_POST['user'];
		$starttime1 = $_POST['starttime1'];	
		$starttime2 = $_POST['starttime2'];		
		$endtime = $_POST['endtime'];
		$active = $_POST['active'];	

		if($table=="windows_login"){
			$setName = 'windows_login_set';
			$tplName = 'windowslogin.tpl';
		}else{
			$setName = 'linux_login_set';
			$tplName = 'linuxlogin.tpl';
		}

		$query = ' 1=1';
		if($host){
			$query = $query." and host='$host'";
		}
		
		if($logserver){
			$query = $query." and logserver='$logserver'";
		}
		if($srchost){
			$query = $query." and srchost='$srchost'";
		}
		if($user){
			$query = $query." and user='$user'";
		}
		
		if($starttime1){
			$query = $query." and  date_format(starttime,'%Y-%m-%d %H:%i')='$starttime1'";
	//	echo $query;
	//	exit;
		}
//		if($starttime2){
//			$query = $query." and  date_format(starttime,'%Y-%m-%d')<='$starttime2'";
//		}
		if($endtime){
			$query = $query." and date_format(endtime,'%Y-%m-%d')='$endtime'";
		}
		
		if($active){
			if($active=='a'){
				$active = 0;
			}elseif($active=='b'){
				$active = 1;
			}else{
				$active = -1;
			}
			$query = $query." and active='$active'";
		}

		//$query = $query." and active='$active'";

//		echo $setName;
//		echo $query;
		$page_num = get_request('page');
		$row_num = $this->$setName->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $this->$setName->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('alllogs', $alllogs);

		$this->display($tplName);
	}
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];
		$idName = 'id';
	
		$this->linux_login_set->base_delete_all($table,$idName,$seq);
		alert_and_back('成功删除记录');
	}
	
	function detail() {
		
		$table= $_GET['t'];
		$id= $_GET['id'];
		
		$idName = 'id';		
		$tplName = $table.'_detail.tpl';
		
		$result =  $this->linux_login_set->base_select("SELECT * FROM `log_$table` WHERE $idName = '$id' ");

		$this->assign("detail", $result[0]);

		$this->display($tplName);

	}
	
	function winlinlogin(){
		$os = get_request('os', 0, 1);
		$ip = get_request('ip', 0, 1);
		$query = ' 1=1';
		if($ip){
			$query = " host='$ip'";
		}
		if($os=='windows'){
			$model = $this->windows_login_set;
		}else{
			$model = $this->linux_login_set;
		}
		
		$page_num = $this->getInput('page');
		$row_num = $model->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $model->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('alllogs', $alllogs);
		$this->assign('os', $os);
		$this->assign('ip', $ip);
		$this->display('winlinlogin.tpl');
	}

}
?>
