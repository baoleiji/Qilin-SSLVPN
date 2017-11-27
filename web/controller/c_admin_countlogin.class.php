<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_countlogin  extends c_base {
	function index() {

		$f_rangeStart = $this->getInput('f_rangeStart');
		
		$setName = 'login_day_count_set';
		$tplName = 'login_day_count.tpl';
		$query = ' 1=1';
		if($f_rangeStart){
			$query = " date='$f_rangeStart'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->$setName->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->$setName->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query,'status', desc);
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
		$this->display($tplName);
	}
	
	function week() {
		$f_rangeStart = $this->getInput('f_rangeStart');
		$setName = 'login_week_count_set';
		$tplName = 'login_week_count.tpl';
		$query = ' 1=1';
		if($f_rangeStart){
			$query = " week_num= DATE_FORMAT('$f_rangeStart','%v') and TIMESTAMPDIFF(DAY,date_start,'$f_rangeStart')<7 ";
		}
		

		
		$page_num = $this->getInput('page');
		$row_num = $this->$setName->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->$setName->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
	//	print_r($all);
	//	exit;
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
			$this->assign('f_rangeStart', $f_rangeStart);
		$this->assign('all', $all);
		
		$this->display($tplName);
	}
		
	function month() {
		$f_rangeStart = $this->getInput('f_rangeStart');
		$setName = 'login_month_count_set';
		$tplName = 'login_month_count.tpl';
		$query = ' 1=1';
		if($f_rangeStart){
			$query = " MONTH(date_start) = MONTH('$f_rangeStart')  ";
		}

		
		$page_num = $this->getInput('page');
		$row_num = $this->$setName->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->$setName->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
	//	print_r($all);
	//	exit;
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
		$this->display($tplName);
	}
	
	function delete_all() {

		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];
		$idName = 'seq';

		$this->login_day_count_set->base_delete_all($table,$idName,$seq);
		alert_and_back('成功删除记录');
	}
	

	function export(){

		$table = $_GET['table'];
			$f_rangeStart = $this->getInput('f_rangeStart');
		
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM $table" ;
		
		if($f_rangeStart){
			
			if(strpos($table,'week')){
				$query = $query." where week_num= DATE_FORMAT('$f_rangeStart','%v') and TIMESTAMPDIFF(DAY,date_start,'$f_rangeStart')<7 ";
			
			}elseif(strpos($table,'month')){
				$query = $query." where MONTH('$f_rangeStart')= MONTH(date_start)";
			}else{
				$query =$query. " where date='$f_rangeStart'";
			}
		}
	//	echo $query;
		$results =  $this->login_day_count_set->query($query);
		$data = "";
		$fields = mysql_num_fields($results);
		for ($i = 0; $i < $fields; $i++) {
			$header .= mysql_field_name($results, $i) . "\t";
		}

		while ($row = mysql_fetch_row($results)) {
			$line = '';
			foreach ($row as $value) {
				if ((!isset($value)) || ($value == "")) {
					$value = "\t";
				} else {
					$value = str_replace('"', '""', $value);
					$value = '"' . $value . '"' . "\t";
				}
				$line .= $value;
			}
			$data .= trim($line) . "\n";
		}
		$data = str_replace("\r", "", $data);
		header("Content-type: application/vnd.ms-excel;");
		header("Content-Disposition: attachment; filename=login_count.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$str = "$header\n$data";
		$str = mb_convert_encoding($str, "GB2312", "UTF-8");
		echo $str;
	}
	
	function derivetoHTML(){

		$table = $_GET['table'];

			$f_rangeStart = $this->getInput('f_rangeStart');
		
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM $table" ;
		
		if($f_rangeStart){
			
			if(strpos($table,'week')){
				$query = $query." where week_num= DATE_FORMAT('$f_rangeStart','%v') and TIMESTAMPDIFF(DAY,date_start,'$f_rangeStart')<7 ";
			
			}elseif(strpos($table,'month')){
				$query = $query." where MONTH('$f_rangeStart')= MONTH(date_start)";
			}else{
				$query =$query. " where date='$f_rangeStart'";
			}
		}

		$results =  $this->login_day_count_set->query($query);
		$fields = mysql_num_fields($results);
		for ($i = 0; $i < $fields; $i++) {
			$head[] =  mysql_field_name($results, $i) . "\t";
		}
		while($row = mysql_fetch_assoc($results)) {
				$data[] = $row;
		}
		ob_start();
		
//		print_r($head);
//		echo '<br>';
//		echo '<br>';
//		echo '<br>';
//		print_r($data);
		
		$this->assign('table', $table);
		$this->assign('all', $data);
		$this->assign('head', $head);
		$this->display('html_for_login_count.tpl');
		$str = ob_get_clean();

		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=login_count.html"); 
		echo $str;
		exit();
	}
}
?>
