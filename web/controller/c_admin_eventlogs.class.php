<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_eventlogs extends c_base {
	function index() {
		$hostname = $this->getInput('hostname');
		$event = $this->getInput('event');
		$msg = $this->getInput('msg');
		$datetime = $this->getInput('f_rangeStart');
		$query = ' 1=1';
		if($hostname){
			$query .= " and `host`='$hostname'";
		}
		if($event){
			$query .= " and `event`='$event'";
		}
		if($msg){
			$query .= " and `msg`='$msg'";
		}
		if($datetime){
			$query .= " and DATE_FORMAT(datetime,'%Y-%m-%d %H:%i')='$datetime'";
		}
	//	echo $query;
		$page_num = $this->getInput('page');
		$row_num = $this->eventlogs_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->eventlogs_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query,'datetime','desc');
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

		$this->display('log_eventlogs.tpl');
	}

	function get_applog_table_list() {
		global $dbname;
		$result = $this->logs_set->base_select("SHOW TABLES LIKE 'applog%'");
		$table_list = array();
		if($result)
		foreach($result as $table_name) {
			if(is_numeric(substr($table_name["Tables_in_$dbname (applog%)"], 6)) || (substr($table_name["Tables_in_$dbname (applog%)"], 0, 6)=='applog'&&strlen($table_name["Tables_in_$dbname (applog%)"])==6))
			$table_list[] = $table_name["Tables_in_$dbname (applog%)"];
		}
		return $table_list;	
	}

	function applogs() {
		global $log_dbhost, $log_dbuser, $log_dbpwd, $log_dbname, $log_dbcharset;
		$link = mysql_connect($log_dbhost, $log_dbuser, _encrypt($log_dbpwd, 'D', 'freesvr' )) or die(mysql_error());

		mysql_select_db($log_dbname) or die(mysql_error());
		mysql_query("SET character_set_connection=$log_dbcharset, character_set_results=$log_dbcharset, character_set_client=binary");
		$hostname = $this->getInput('hostname');
		$event = $this->getInput('event');
		$msg = $this->getInput('msg');
		$tablename = $this->getInput('tablename');
		$start = $this->getInput('f_rangeStart');
		$end = $this->getInput('f_rangeEnd');
		$query = ' 1=1';
		if($hostname){
			$query .= " and `host` like '%$hostname%'";
		}
		if($event){
			$query .= " and `event` like '%$event%'";
		}
		if($msg){
			$query .= " and `msg` like '%$msg%'";
		}
		if($start){
			$query .= " and datetime>='$start'";
		}
		if($end){
			$query .= " and datetime<='$end'";
		}
	//	echo $query;
		$tablelist = $this->get_applog_table_list();
		if($tablename){
			$this->applog_set->set_table_name($tablename);
		}
		$page_num = $this->getInput('page');
		$row_num = $this->applog_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->applog_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query,'datetime','desc');
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
		$this->assign('table_list', $tablelist);
		$this->assign('tablename', $tablename);
		$this->display('applogs.tpl');
	}
	
	function eventconfig() {
		$host = $this->getInput('hostname');
		$query = ' 1=1';
		if($host){
			$query = " eventmsg='$host'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->eventconfig_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->eventconfig_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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

		$this->display('eventconfig.tpl');
	}
	
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];
		$idName = 'seq';

		$this->eventlogs_set->base_delete_all($table,$idName,$seq);
		alert_and_back('成功删除记录');
	}
	
	function edit(){
	
		$id = $_GET['id'];
		$table= $_GET['t'];

		$setName =$table.'_set';
		$tplName =$table.'_edit.tpl';
		
		$result = $this->$setName->select_by_id($id);

		$this->assign("id", $id);
		$this->assign("result", $result);
		$this->display($tplName);
	}
	
	function save() {
		$table= $_GET['t'];
		$field= $_GET['f'];
		if($table=='eventlogs'){

			$seq=  $_GET['id'];
			$desc =  $_POST['desc'];

			if($field=='desc') {
				$query = "UPDATE `eventlogs` SET `desc`='$desc' WHERE `seq`=$seq";
				$this->eventlogs_set->query($query);
			//	alert_and_back('编辑成功!' );
				echo "<script language='javascript'>alert('编辑成功');window.opener.location.href='admin.php?controller=admin_eventlogs';window.close();</script>";
				
				
			}else{
				$query = "UPDATE `eventlogs` SET `status`=1 WHERE `seq`=$seq";
				$this->eventlogs_set->query($query);
			//	alert_and_back('处理成功!' );
				echo "<script language='javascript'>alert('处理成功');window.opener.location.href='admin.php?controller=admin_eventlogs';window.close();</script>";
			}	

			
			
		}//host
		else if($table=='eventconfig'){
			$eventconfig = new eventconfig();
			$id=  $_POST['id'];
			if($id) {
				$eventconfig->set_data('seq', $id);
			}

			$eventmsg =  $_POST['eventmsg'];
			$event =  $_POST['event'];
			$logsource =  $_POST['logsource'];
			$msg_level =  $_POST['msg_level'];
			$desc =  $_POST['desc'];
		
			$eventconfig->set_data('eventmsg', $eventmsg);
			$eventconfig->set_data('event', $event);
			$eventconfig->set_data('logsource', $logsource);
			$eventconfig->set_data('msg_level', $msg_level);
			$eventconfig->set_data('desc', $desc);
		
			if($id) {
				if($id != '') {
					$this->eventconfig_set->edit($eventconfig);
					alert_and_back('编辑成功!', 'admin.php?controller=admin_eventlogs&a=eventconfig');
				}
				
			}else  {

							$this->eventconfig_set->add($eventconfig);
							alert_and_back('添加成功!', 'admin.php?controller=admin_eventlogs&a=eventconfig');

			}			
			
		}
	}
	
function detail() {
		
		$table= $_GET['t'];
		$id= $_GET['id'];
		
		
		$tplName = 'eventlogs_detail.tpl';
		
		$result =  $this->eventlogs_set->base_select("SELECT t.* FROM `eventlogs` t   WHERE t.seq = '$id' ");

		$this->assign("detail", $result[0]);
		$this->assign("id", $id);

		$this->display($tplName);

	}
	
	
	function import(){
		$this->display('importEventConfig.tpl');
	}
	
	function do_import(){
	
	//	require_once(ROOT ."./controller/".$controller.".class.php");
		
		if($_FILES['upload']['name'] != '') {

			if($_FILES['upload']['type']=='application/vnd.ms-excel'){
				$dir=dirname(__FILE__);       //获取当前脚本的绝对路径
   			 	$dir=str_replace("//","/",$dir);
   			 	$dir = substr( $dir, 0, strrpos($dir, '/') ) . '/template/tmp/';
    			$filename='uploadFile.xls'; //可以定义一个上传后的文件名称			
    			$result=move_uploaded_file($_FILES['upload']['tmp_name'],$dir.$filename);
				if($result){		
				 require_once(ROOT ."./phpExcelReader/Excel/reader.php");
			     $data = new Spreadsheet_Excel_Reader();
			     $data->setOutputEncoding('utf-8');//设置在页面中输出的编码方式,而不是utf8
			 
			      //该方法会自动判断上传的文件格式，不符合要求会显示错误提示信息(错误提示信息在该方法内部)。
			     $data->read($dir.$filename);  //读取上传到当前目录下名叫$filename的文件
			 
			     error_reporting(E_ALL ^ E_NOTICE);
	//如果excel表带标题，则从$i=2开始，去掉excel表中的标题部分
					 for ($i = 2; $i <$data->sheets[0]['numRows']; $i++)
					     {
 						$sql = "INSERT INTO eventconfig (`".eventmsg."`,`".event."`,`".msg_level."`,`".status."`,`".desc."`,`".logsource."`) VALUES('".

					      $data->sheets[0]['cells'][$i][1]."','".   
					      $data->sheets[0]['cells'][$i][2]."','".  
					      $data->sheets[0]['cells'][$i][3]."','".  
					      $data->sheets[0]['cells'][$i][4]."','".  
					 //     $data->sheets[0]['cells'][$i][5]."','".   
					      $data->sheets[0]['cells'][$i][6]."','".  
					  //    $data->sheets[0]['cells'][$i][7]."','".  
					      $data->sheets[0]['cells'][$i][7]."')";  

						  $this->systemNew_set->query($sql);

						}
						 $totalNums=$data->sheets[0]['numRows']-2;//求出导入的总数据条数		     
    					@unlink($dir.$filename); 
    					 $msg = '导入成功'.strval($totalNums).'条记录';
    					echo "<script>alert('$msg');</script>";
    					go_url("admin.php?c=admin_eventlogs&a=eventconfig");
				}	
			}else{
				echo "<script>alert('请上传xls类型文件');history.back(-1);</script>";
			}

		}else{
			echo "<script>alert('请上传文件');history.back(-1);</script>";
		}
	}
	
	function export(){
		 include(ROOT ."./phpExcelReader/Excel/PHPExcel.php");
		// include(ROOT ."./phpExcelReader/Excel/PHPExcel/IOFactory.php");
		 $objPHPExcel = new PHPExcel();  //创建PHPExcel实例
		
		 
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM eventconfig" ;
		$results =  $this->systemNew_set->query($query);
		$data = "";
		$fields = mysql_num_fields($results);
		 $objPHPExcel->setActiveSheetIndex(0);
		 $j='A'; 
		for ($i = 0; $i < $fields; $i++) {
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($j."1",  mysql_field_name($results, $i));
			 $j++;
		}
		$i=2; 
		while ($row = mysql_fetch_row($results)) {
			$j='A';
			foreach ($row as $value) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$i, "$value");  
				$j++; 
			}
			$i++;
		}
	// 设置 worksheet 名字  
		$objPHPExcel->getActiveSheet()->setTitle('数据');  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="eventconfig.xls"');		
		header('Cache-Control: max-age=0');				 		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');		
		$objWriter->save('php://output');		
		exit;		
	}
	
	
	
	function eventlogbyip(){
		$os = get_request('os', 0, 1);
		$ip = get_request('ip', 0, 1);
		$event = $this->getInput('event');
		$msg = $this->getInput('msg');
		$datetime = $this->getInput('f_rangeStart');
		$query = ' 1=1';
		if($ip){
			$query .= " and `host`='$ip'";
		}
		if($event){
			$query .= " and `event`='$event'";
		}
		if($msg){
			$query .= " and `msg`='$msg'";
		}
		if($datetime){
			$query .= " and DATE_FORMAT(datetime,'%Y-%m-%d %H:%i')='$datetime'";
		}
	//	echo $query;
		$page_num = $this->getInput('page');
		$row_num = $this->eventlogs_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->eventlogs_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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

		$this->display('eventlogbyip.tpl');
	}
	
	
	
	
	
	
}
?>
