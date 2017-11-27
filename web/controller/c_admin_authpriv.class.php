<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_authpriv extends c_base {
	function index() {
		$derive = $this->getInput('derive');
		$host = $this->getInput('host');
		$event = $this->getInput('event');
		$user = $this->getInput('user');
		$usergroup = $this->getInput('usergroup');
		$f_rangeStart = $this->getInput('f_rangeStart');
		$f_rangeEnd = $this->getInput('f_rangeEnd');
		$query = ' 1=1';
		if($host){
			$query .= " and ip like '%$host%'";
		}
		if($event){
			$query .= " and event like '%$event%'";
		}
		if($user){
			$query .=  " and username like '%$user%'";
		}
		if($usergroup){
			$query .=  " and groupname like '%$usergroup%'";
		}
		if($f_rangeStart){
			$query .=  " and datetime >= '$f_rangeStart'";
		}
		if($f_rangeEnd){
			$query .=  " and datetime <= '$f_rangeEnd'";
		}
		if($derive==1){
			$reports = $this->windows_authpriv_set->select_all($query);
			$str .= language("序号")."\t".language("主机")."\t".language("时间")."\t".language("操作")."\t".language("用户名")." \t".language("组名")." \t".language("日志信息")."\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['host']."\t".$report['datetime']."\t".$report['event']."\t".$report['username']."\t".$report['groupname']."\t".$report['loginfo'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=WindowsLogin.xls"); 
			echo iconv("UTF-8", "GBK", $str);
			exit();
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->windows_authpriv_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->windows_authpriv_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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
		$this->assign('all', $all);

		$this->display('windowsauthpriv.tpl');
	}


	function linux() {
		$derive = $this->getInput('derive');
		$host = $this->getInput('host');
		$event = $this->getInput('event');
		$user = $this->getInput('user');
		$usergroup = $this->getInput('usergroup');
		$f_rangeStart = $this->getInput('f_rangeStart');
		$f_rangeEnd = $this->getInput('f_rangeEnd');
		$query = ' 1=1';
		if($host){
			$query .= " and ip like '%$host%'";
		}
		if($event){
			$query .= " and event like '%$event%'";
		}
		if($user){
			$query .=  " and username like '%$user%'";
		}
		if($usergroup){
			$query .=  " and groupname like '%$usergroup%'";
		}
		if($f_rangeStart){
			$query .=  " and datetime >= '$f_rangeStart'";
		}
		if($f_rangeEnd){
			$query .=  " and datetime <= '$f_rangeEnd'";
		}
		if($derive==1){
			$reports = $this->windows_authpriv_set->select_all($query);
			$str .= language("序号")."\t".language("主机")."\t".language("时间")."\t".language("操作")."\t".language("用户名")." \t".language("组名")." \t".language("日志信息")."\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['host']."\t".$report['datetime']."\t".$report['event']."\t".$report['username']."\t".$report['groupname']."\t".$report['loginfo'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=WindowsLogin.xls"); 
			echo iconv("UTF-8", "GBK", $str);
			exit();
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->linux_authpriv_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->linux_authpriv_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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
		$this->assign('all', $all);

		$this->display('linuxauthpriv.tpl');
	}
	
	function search(){
		$this->display("authpriv_search.tpl");	
	}
	
	function search_result() {
 		$table = $_POST['table'];		
		$event = $_POST['event'];
		$host = $_POST['host'];
	 
 
		if($table=="windows_authpriv"){
			$setName = 'windows_authpriv_set';
			$tplName = 'windowsauthpriv.tpl';
		}else{
			$setName = 'linux_authpriv_set';
			$tplName = 'linuxauthpriv.tpl';
		}

		$query = ' 1=1';
		if($host){
			$query = $query." and ip='$host'";
		}
		
		if($event){
			$query = $query." and event='$event'";
		}

		$page_num = get_request('page');
		$row_num = $this->$setName->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->$setName->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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
		$this->assign('all', $all);

		$this->display($tplName);
	}
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];
		$idName = 'id';
	
		$this->linux_authpriv_set->base_delete_all($table,$idName,$seq);
		alert_and_back('成功删除记录');
	}
	
	function detail() {
		
		$table= $_GET['t'];
		$id= $_GET['id'];
		
		$idName = 'id';		
		$tplName = $table.'_detail.tpl';
		
		$result =  $this->linux_authpriv_set->base_select("SELECT * FROM `$table` WHERE $idName = '$id' ");

		$this->assign("detail", $result[0]);

		$this->display($tplName);

	}
	
	function winlinauthpriv() {
		$os = get_request('os', 0, 1);
		$ip = get_request('ip', 0, 1);
		$query = ' 1=1';
		if($ip){
			$query = " ip='$ip'";
		}
		if($os=='windows'){
			$model = $this->windows_authpriv_set;
		}else{
			$model = $this->linux_authpriv_set;
		}
		
		$page_num = $this->getInput('page');
		$row_num = $model->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $model->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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
		$this->assign('all', $all);
		$this->assign('os', $os);
		$this->assign('ip', $ip);

		$this->display('winlinauthpriv.tpl');
	}

}
?>
