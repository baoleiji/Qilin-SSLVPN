<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_realtime extends c_base {
	function index() {
		$host = $this->getInput('host');
		$query = ' 1=1';
		if($host){
			$query = $query." and host='$host'";
		}
		
		$page_num = $this->getInput('page');
		
		if($_SESSION['ADMIN_LEVEL'] != 1) {
			$user = $this->user_set->select_all("username = '" . $_SESSION['ADMIN_USERNAME'] ."'");
			$hostlist = $user[0]['hostlist'];
			if($hostlist != '') {
				$hostlist = explode('||', $hostlist);
				$query2 = " `group` in ('".implode("','", $hostlist)."')";
				$allhost = $this->host_set->select_all($query2);
				$str ='';
				for ($i= 0;$i< count($allhost); $i++){
				  $tmp = $allhost[$i]['hname'];
				  $str =$str."'". $tmp."',";
		
			 	}
			 	$param =' ('.substr($str,0,-1).')';
			 	if(substr($str,0,-1)){
			 		$query = $query." and host in $param";
			 	}else{
			 		$query = $query." and host in ('xx')";
			 	}
			}
		}
		
		 $row_num = $this->realtimelogs_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $this->realtimelogs_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
		
		$curr_url = $_SERVER['PHP_SELF'] . "?";

		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
	//			echo $curr_url.'yyyy<br>';
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('alllogs', $alllogs);
		$this->display('realtimelogs.tpl');
	}

	function countlogs() {
	$host = $_POST['host'];
		$query = ' 1=1';
		if($host){
			$query = " host='$host'";
		}
		
		$page_num = get_request('page');
		$row_num = $this->countlogs_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $this->countlogs_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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

		$this->display('countlog.tpl');
	}

	function countlogs_minuter() {
		$f_rangeStart = $_POST['f_rangeStart'];
		$contentType = $_POST['contentType'];
		if($_POST['contentType']){
			$setName = 'countlogs_minuter_'.$contentType.'_set';
			$tplName = 'countlogs_minuter_'.$contentType.'.tpl';
		}
		else{
			$setName = 'countlogs_minuter_detailed_set';
			$tplName = 'countlogs_minuter_detailed.tpl';
		}

		$curr_time = $_POST['curr_time'];
		$curr_num = $_GET['curr_num'];
	
		if(!$curr_num){
			$curr_num = 1;	
		}
	//	echo date_default_timezone_get();
	//	date_default_timezone_set(date_default_timezone_get()); 
		if($curr_time){
			$dist = 60*($curr_num-1)*5;
			$time =  date('Y-m-d H:i',strtotime($curr_time)-$dist); 

		}else{
		
			if($f_rangeStart){
				
				$current_date = getdate(strtotime($f_rangeStart));
				$minute = $current_date[minutes];
				$dist = 60*($minute%5);
				$curr_time =  date('Y-m-d H:i',strtotime($f_rangeStart)-$dist); 
				$time = $curr_time;
				
			}else{
					$current_date = getdate();
					$minute = $current_date[minutes];
					$dist = 60*($minute%5);
					$curr_time =  date('Y-m-d H:i',time()-$dist);
					$time = $curr_time	;	
			}
		}

		$query = ' 1=1';
		if($time){
			$query =$query. " and DATE_FORMAT(date,'%Y-%m-%d %H:%i')='$time'";
		}
	//	echo $query;
		
		$page_num = get_request('page');
		
		
		
		if($_SESSION['ADMIN_LEVEL'] != 1) {
			$user = $this->user_set->select_all("username = '" . $_SESSION['ADMIN_USERNAME'] ."'");
			$hostlist = $user[0]['hostlist'];
			if($hostlist != '') {
				$hostlist = explode('||', $hostlist);
				$query2 = " `group` in ('".implode("','", $hostlist)."')";
				$allhost = $this->host_set->select_all($query2);
				$str ='';
				for ($i= 0;$i< count($allhost); $i++){
				  $tmp = $allhost[$i]['hname'];
				  $str =$str."'". $tmp."',";
		
			 	}
			 	$param =' ('.substr($str,0,-1).')';
			 	$query = $query." and host in $param";
			}
		}
		
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
		
		$this->assign('curr_time', $curr_time);
		$this->assign('curr_num', $curr_num);
		$this->assign('contentType', $contentType);
		$this->assign('f_rangeStart', $f_rangeStart);
		$this->display($tplName);
	}
	
	
	function countlogs_hour() {
		$f_rangeStart = $_POST['f_rangeStart'];
		$contentType = $_POST['contentType'];
		if($_POST['contentType']){
			$setName = 'countlogs_hour_'.$contentType.'_set';
			$tplName = 'countlogs_hour_'.$contentType.'.tpl';
		}
		else{
			$setName = 'countlogs_hour_detailed_set';
			$tplName = 'countlogs_hour_detailed.tpl';
		}
	

		$curr_time = $_POST['curr_time'];
		$curr_num = $_GET['curr_num'];
	
		if(!$curr_num){
			$curr_num = 1;	
		}

		if($curr_time){
		
			$dist = 60*60*($curr_num-1)*1;
			$time =  date('Y-m-d H',strtotime($curr_time)-$dist); 


		}else{
			
			if($f_rangeStart){
				$time =  date('Y-m-d H',strtotime($f_rangeStart)); 
				$curr_time = $f_rangeStart;
			}else{
				$curr_time =  date('Y-m-d H',time());	
				$time = $curr_time;
				$curr_time = $curr_time.':00';
			}

		} 

		$query = ' 1=1';
		if($time){
			$query = $query." and DATE_FORMAT(date,'%Y-%m-%d %H')='$time'";
		}
	
			if($_SESSION['ADMIN_LEVEL'] != 1) {
			$user = $this->user_set->select_all("username = '" . $_SESSION['ADMIN_USERNAME'] ."'");
			$hostlist = $user[0]['hostlist'];
			if($hostlist != '') {
				$hostlist = explode('||', $hostlist);
				$query2 = " `group` in ('".implode("','", $hostlist)."')";
				$allhost = $this->host_set->select_all($query2);
				$str ='';
				for ($i= 0;$i< count($allhost); $i++){
				  $tmp = $allhost[$i]['hname'];
				  $str =$str."'". $tmp."',";
		
			 	}
			 	$param =' ('.substr($str,0,-1).')';
			 	$query = $query." and host in $param";
			}
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
		
		$this->assign('f_rangeStart', $f_rangeStart);
		$this->assign('curr_time', $curr_time);
		$this->assign('curr_num', $curr_num);
		$this->assign('contentType', $contentType);
		

		$this->display($tplName);
	}
	
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];

		$this->countlogs_set->base_delete_all($table,'seq',$seq);
		alert_and_back('成功删除记录');
	}

}
?>
