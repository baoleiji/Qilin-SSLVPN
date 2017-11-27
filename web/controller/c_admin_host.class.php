<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_host extends c_base {
	function index() {
		$hostname = $this->getInput('hostname');
		$hname = $this->getInput('hname');
		$group = $this->getInput('group');
		$query = ' 1=1';
		if($hostname){
			$query =$query. " and hostname='$hostname'";
		}
		if($hname){
			$query =$query. " and hname='$hname'";
		}
		if($group){
			$query =$query. " and `group`='$group'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->host_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
	//	$all = $this->host_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
		
		$all = $this->host_set->base_select("SELECT t.*,t2.groupname FROM `host` t left join `servergroup` t2 on(t.group=t2.id) WHERE $query ORDER BY `hid` desc LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		
		
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		$allgroup = $this->servergroup_set->select_all();
		$this->assign('allgroup', $allgroup);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('all', $all);

		$this->display('host.tpl');
	}
	
	function company() {
		$company = $this->getInput('company');
		$query = ' 1=1';
		if($company){
			$query = " company='$company'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->company_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->company_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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

		$this->display('company.tpl');
	}
	
	
	function system() {
		$system = $this->getInput('system');
		$query = ' 1=1';
		if($system){
			$query = " system='$system'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->system_template_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->system_template_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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

		$this->display('system_template.tpl');
	}
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];
		$idName = 'id';
		if($table=="host")
			$idName = 'hid';

	
		$this->host_set->base_delete_all($table,$idName,$seq);
		alert_and_back('成功删除记录');
	}
	
	function edit(){
	
		$id = $_GET['id'];
		$table= $_GET['t'];

		$setName =$table.'_set';
		$tplName =$table.'_edit.tpl';
		
		$result = $this->$setName->select_by_id($id);
		
		$system = $this->system_template_set->select_all();
		$group = $this->servergroup_set->select_all();
		$company = $this->company_set->select_all();
			
		$this->assign("system", $system);
		$this->assign("group", $group);
		$this->assign("company", $company);

		$this->assign("id", $id);
		$this->assign("result", $result);
		$this->display($tplName);
	}
	
	function save() {
		$table= $_GET['t'];
		if($table=='host'){
			$host = new host();
			$hid =  $_POST['hid'];
			if($hid) {
				$host->set_data('hid', $hid);
			}
			
			$hname =  $_POST['hname'];
			$hostname =  $_POST['hostname'];
			$system =  $_POST['system'];
			$group =  $_POST['group'];
			$support_company =  $_POST['support_company'];
			$asset_start =  $_POST['asset_start'];
			$asset_usedtime =  $_POST['asset_usedtime'];
			$asset_warrantdate =  $_POST['asset_warrantdate'];
			$asset_sn =  $_POST['asset_sn'];
			
			$host->set_data('hname', $hname);
			$host->set_data('hostname', $hostname);
			$host->set_data('system', $system);
			$host->set_data('group', $group);
			$host->set_data('support_company', $support_company);
			$host->set_data('asset_start', $asset_start);
			$host->set_data('asset_usedtime', $asset_usedtime);
			$host->set_data('asset_warrantdate', $asset_warrantdate);
			$host->set_data('asset_sn', $asset_sn);
					
			if($hid) {
				if($hid != '') {
					$this->host_set->edit($host);
					alert_and_back('编辑成功!', 'admin.php?c=admin_host');
				}
				
			}else  {
						if($hname == '') {
							alert_and_back('ip地址不能为空!');
							exit();
						}
						else {
							$this->host_set->add($host);
							alert_and_back('添加成功!', 'admin.php?c=admin_host');
						}
			}			
			
		}//host
		else if($table=='company'){
			$company = new company();
			$id =  $_POST['id'];
				
			if($id) {
				$company->set_data('id', $id);
			}

			$company2 =  $_POST['company'];
			$telephone =  $_POST['telephone'];
			$address =  $_POST['address'];
			$connecter =  $_POST['connecter'];
			$desc =  $_POST['desc'];

		
			$company->set_data('company', $company2);
			$company->set_data('telephone', $telephone);
			$company->set_data('address', $address);
			$company->set_data('connecter', $connecter);
			$company->set_data('desc', $desc);
	

					
			if($id) {
				if($id != '') {
					$this->company_set->edit($company);
					alert_and_back('编辑成功!', 'admin.php?c=admin_host&a=company');
				}
				
			}else  {
						if($company == '') {
							alert_and_back('公司名称不能为空!');
							exit();
						}
						else {
							$this->company_set->add($company);
							alert_and_back('添加成功!', 'admin.php?c=admin_host&a=company');
						}
			}			
			
		}//company
		else if($table=='system_template'){
			$system_template = new system_template();
			$id =  $_POST['id'];
			if($id) {
				$system_template->set_data('id', $id);
			}
			
			$system =  $_POST['system'];
			$desc =  $_POST['desc'];
		
			$system_template->set_data('system', $system);
			$system_template->set_data('desc', $desc);
		
	

					
			if($id) {
				if($id != '') {
					$this->system_template_set->edit($system_template);
					alert_and_back('编辑成功!', 'admin.php?c=admin_host&a=system');
				}
				
			}else  {
						if($system == '') {
							alert_and_back('操作系统名称不能为空!');
							exit();
						}
						else {
							$this->system_template_set->add($system_template);
							alert_and_back('添加成功!', 'admin.php?c=admin_host&a=system');
						}
			}			
			
		}//system		
	}
	
	
	
	
	function import(){
		$this->display('importHost.tpl');
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
 						$sql = "INSERT INTO host (`".hname."`,`".hostname."`,`".system."`,`".support_company."`,`".asset_start."`,`".asset_usedtime."`,`".asset_warrantdate."`,`".asset_sn."`) VALUES('".

					      $data->sheets[0]['cells'][$i][2]."','".   
					      $data->sheets[0]['cells'][$i][3]."','".  
					      $data->sheets[0]['cells'][$i][4]."','".  
					      $data->sheets[0]['cells'][$i][5]."','".  
					      $data->sheets[0]['cells'][$i][6]."','".   
					      $data->sheets[0]['cells'][$i][7]."','".  
					      $data->sheets[0]['cells'][$i][8]."','".  
					      $data->sheets[0]['cells'][$i][9]."')";  

						  $this->host_set->query($sql);

						}
						 $totalNums=$data->sheets[0]['numRows']-2;//求出导入的总数据条数		     
    					@unlink($dir.$filename); 
    					 $msg = '导入成功'.strval($totalNums).'条记录';
    					echo "<script>alert('$msg');</script>";
    					go_url("admin.php?c=admin_host");
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
		
		 
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM host" ;
		$results =  $this->host_set->query($query);
		$data = "";
		$fields = mysql_num_fields($results);
		 $objPHPExcel->setActiveSheetIndex(0);
		 $index=0;//用于记录group字段索引，此字段不导出
		 $j='A'; 
		for ($i = 0; $i < $fields; $i++) {
			if(mysql_field_name($results, $i)=='group'){
				$index = $i;
			}else{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j."1",  mysql_field_name($results, $i));
				 $j++;
			}
			
			 
		}
		$i=2; 
		while ($row = mysql_fetch_row($results)) {
			$j='A';
			$n=0;
			foreach ($row as $value) {
				if($n!=$index){//非group列
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($j.$i, "$value");  
					$j++; 
				}
				
				$n++; 
			}
			$i++;
		}
	// 设置 worksheet 名字  
		$objPHPExcel->getActiveSheet()->setTitle('数据');  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="host.xls"');		
		header('Cache-Control: max-age=0');				 		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');		
		$objWriter->save('php://output');		
		exit;		
	}
	
	
	
	
	
	
}
?>
