<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_systemNew extends c_base {
	function index() {
		$host = $this->getInput('host');
		$query = ' 1=1';
		if($host){
			$query = " facility='$host'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->systemNew_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $this->systemNew_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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
		$this->assign('allsystemNew', $alllogs);

		$this->display('systemNew.tpl');
		
	}
	
	function applog_config(){
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1";
		
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->applog_config_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->applog_config_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where, $orderby1, $orderby2);		
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("applog_config.tpl");
	}

	function applog_config_edit(){
		$id = get_request('id');
		$status = $this->applog_config_set->select_by_id($id);
		$this->assign("status", $status);
		$this->display("applog_config_edit.tpl");
	}

	function write_applog_config_to_file(){
		$hosts = $this->applog_config_set->select_all('1', 'id', 'asc');
		for($i=0; $i<count($hosts); $i++){
			$c[]=$hosts[$i]['msg']."\n";
		}
		$this->Array2File($c,'/home/wuxiaolong/template.pl');
	}

	function applog_config_delete(){
		$id = get_request('id');
		$this->applog_config_set->delete($id);
		$this->write_applog_config_to_file();
		alert_and_back('操作成功','admin.php?controller=admin_systemNew&action=applog_config');		
	}

	function applog_config_save(){
		$id = get_request('id');
		$mail_alarm = get_request('mail_alarm',1,0);
		$sms_alarm = get_request('sms_alarm',1,0);
		$instruction = get_request('instruction',1,1);
		$msg = get_request('msg',1,1);
		$app = new applog_config();
		$app->set_data('mail_alarm', $mail_alarm);
		$app->set_data('sms_alarm', $sms_alarm);
		$app->set_data('msg', $msg);
		$app->set_data('instruction', $instruction);
		if($id){
			$app->set_data('id', $id);
			$status = $this->applog_config_set->edit($app);
		}else{
			$status = $this->applog_config_set->add($app);
		}
		$this->write_applog_config_to_file();
		alert_and_back('操作成功','admin.php?controller=admin_systemNew&action=applog_config');
	}

	
	function facility() {
		$host = $this->getInput('host');
		$query = ' 1=1';
		if($host){
			$query = " name='$host'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->facility_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $this->facility_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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
		$this->assign('all', $alllogs);

		$this->display('facility.tpl');
		
	}
	
	function delete(){
		$sid = get_request('sid', 0, 1);
		if($sid != '') {
				$this->systemNew_set->delete($sid);
				alert_and_back('删除成功!', 'admin.php?controller=admin_systemNew');
			}
	}
	

	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];
		$idName = 'sid';
		if($table=="facility")
			$idName = 'seq';

	
		$this->systemNew_set->base_delete_all($table,$idName,$seq);
		alert_and_back('成功删除记录');
	}
	
	function import(){
		if($_GET['t']){
			$this->display('importFacility.tpl');
		}else{
			$this->display('importForm.tpl');
		}
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
 						$sql = "INSERT INTO syslog (`".msg."`,`".level."`,`".priority."`,`".desc."`,`".facility."`,`".process."`,`".realtime."`,`".host."`) VALUES('".

					      $data->sheets[0]['cells'][$i][2]."','".   
					      $data->sheets[0]['cells'][$i][3]."','".  
					      $data->sheets[0]['cells'][$i][4]."','".  
					      $data->sheets[0]['cells'][$i][5]."','".  
					      $data->sheets[0]['cells'][$i][6]."','".   
					      $data->sheets[0]['cells'][$i][7]."','".  
					      $data->sheets[0]['cells'][$i][8]."','".  
					      $data->sheets[0]['cells'][$i][9]."')";  

						  $this->systemNew_set->query($sql);

						}
						 $totalNums=$data->sheets[0]['numRows']-2;//求出导入的总数据条数		     
    					@unlink($dir.$filename); 
    					 $msg = '导入成功'.strval($totalNums).'条记录';
    					echo "<script>alert('$msg');</script>";
    					go_url("admin.php?controller=admin_systemNew");
				}	
			}else{
				echo "<script>alert('请上传xls类型文件');history.back(-1);</script>";
			}

		}else{
			echo "<script>alert('请上传文件');history.back(-1);</script>";
		}
	}
	
	
function do_importFac(){
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
 						$sql = "INSERT INTO facility (`".name."`,`".desc."`) VALUES('".

					      $data->sheets[0]['cells'][$i][1]."','".    
					      $data->sheets[0]['cells'][$i][2]."')";  

						  $this->systemNew_set->query($sql);

						}
						 $totalNums=$data->sheets[0]['numRows']-2;//求出导入的总数据条数		     
    					@unlink($dir.$filename); 
    					 $msg = '导入成功'.strval($totalNums).'条记录';
    					echo "<script>alert('$msg');</script>";
    					go_url("admin.php?controller=admin_systemNew&a=facility");
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
		
		$table = 'log_syslog';
		if($_GET['t']){
			$table = $_GET['t'];
		}
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM $table" ;
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
		header('Content-Disposition: attachment;filename="'.$table.'.xls"');		
		header('Cache-Control: max-age=0');				 		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');		
		$objWriter->save('php://output');		
		exit;		
	}
	
	function facility_edit(){
		$seq = get_request("seq");

		$facility = $this->facility_set->select_by_id($seq);
		$this->assign("facility", $facility);
		$this->assign("seq", $seq);
		$this->display("facility_edit.tpl");
	}
	
	function systemNew_edit(){
		$sid = get_request("sid");

		$systemNew = $this->systemNew_set->select_by_id($sid);
		$facilitys = $this->facility_set->select_all();
		$this->assign("facilitys", $facilitys);
		$this->assign("sid", $sid);
		$this->assign("systemNew", $systemNew);
		$this->display("systemNew_edit.tpl");
	}
	
	function save() {
		$systemNew = new systemNew();
		$sid = get_request('sid', 1);
		if($sid) {
			$sid = get_request('sid', 1);
			$systemNew->set_data('sid', $sid);
		}
		$msg = get_request('msg', 1, 1);
		$level = get_request('level', 1, 1);
		$tablename = get_request('tablename', 1, 1);
		$priority = get_request('priority', 1, 1);
		$desc = get_request('desc', 1, 1);
		$program = get_request('program', 1, 1);
		
		$process = get_request('process', 1, 1);
		$host = get_request('host', 1, 1);
		$realtime = get_request('realtime', 1, 1);
		$facility = get_request('facility', 1, 1);
		$instruction = get_request('instruction', 1, 1);
	
		$systemNew->set_data('msg', $msg);
		$systemNew->set_data('level', $level);
		$systemNew->set_data('facility', $facility);
		$systemNew->set_data('instruction', $instruction);
	
	//	$systemNew->set_data('tablename', $tablename);
		$systemNew->set_data('priority', $priority);
		$systemNew->set_data('desc', $desc);
		$systemNew->set_data('program', $program);
		
		$systemNew->set_data('process', $process);
		$systemNew->set_data('host', $host);
		$systemNew->set_data('realtime', $realtime);
		$systemNew->set_data('facility', $facility);
		//var_dump($alert);
		if($sid) {
			if($sid != '') {
				$this->systemNew_set->edit($systemNew);
				alert_and_back('编辑成功!', 'admin.php?controller=admin_systemNew');
			}
			
		}else  {

						$this->systemNew_set->add($systemNew);
						alert_and_back('添加成功!', 'admin.php?controller=admin_systemNew');
			
		}
		
	}
	
	function saveFacility() {
		$facility = new facility();
		$seq = get_request('seq', 1);
		if($seq) {
			$seq = get_request('seq', 1);
			$facility->set_data('seq', $seq);
		}
		$name = get_request('name', 1, 1);
		$desc = get_request('desc', 1, 1);
	
		$facility->set_data('name', $name);
		$facility->set_data('desc', $desc);
	
		//var_dump($alert);
		if($seq) {
			if($seq != '') {
				$this->facility_set->edit($facility);
				alert_and_back('编辑成功!', 'admin.php?controller=admin_systemNew&a=facility');
			}
			
		}else  {
					if($name == '') {
						alert_and_back('设备名不能为空!');
						exit();
					}elseif($this->existFac($name)){
						alert_and_back('该设备名已存在!', 'admin.php?controller=admin_systemNew&a=facility_edit');
						
					}
					else {
						$this->facility_set->add($facility);
						alert_and_back('添加成功!', 'admin.php?controller=admin_systemNew&a=facility');
					}
		}
		
	}
	
	
	
	function  existFac($name){
		$where = " where `name` ='$name'  ";
		$result = $this->facility_set->base_select_count('facility',$where);
	    
	    if($result>0){
	    	return true;//'存在'
	    }else{
	    	return false;//'不存在'
	    }
	}

	function String2File($sIn, $sFileOut) {
	  $rc = false;
	  do {
	   if (!($f = @fopen($sFileOut, "wa+"))) {
	     $rc = 1; 
	     alert_and_back('打开文件失败,请检查文件权限');
	     break;
	   }
	   if (!@fwrite($f, $sIn)) {
	     $rc = 2; 
	     alert_and_back('打开文件失败,请检查文件权限');
	     break;
	   }
	   $rc = true;
	  } while (0);
	  if ($f) {
	   fclose($f);
	  }
	  return ($rc);
	}

	function Array2File($aIn, $sFileOut) {
	  return ($this->String2File(implode("", $aIn), $sFileOut));
	}
}
?>
