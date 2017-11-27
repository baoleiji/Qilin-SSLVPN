<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_relation extends c_base {
	function index() {
		$hostname = $this->getInput('hostname');
		$query = ' 1=1';
		if($hostname){
			$query = " idsip='$hostname'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->relation_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->relation_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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

		$this->display('relation.tpl');
	}
	
	function relationids() {
		$host = $this->getInput('hostname');
		$query = ' 1=1';
		if($host){
			$query = " idsip='$host'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->relationids_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->relationids_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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

		$this->display('relationids.tpl');
	}
	
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];
		$idName = 'seq';

		$this->host_set->base_delete_all($table,$idName,$seq);
		alert_and_back('成功删除记录');
	}
	
	function edit(){
	
		$id = $_GET['id'];
		$table= $_GET['t'];

		$setName =$table.'_set';
		$tplName =$table.'_edit.tpl';
		
		$result = $this->$setName->select_by_id($id);
		
		$relationids = $this->relationids_set->select_all();
		$host = $this->host_set->select_all();
		$system = $this->system_template_set->select_all();
			
		$this->assign("relationids", $relationids);
		$this->assign("host", $host);
		$this->assign("system", $system);

		$this->assign("id", $id);
		$this->assign("result", $result);
		$this->display($tplName);
	}
	
	function save() {
		$table= $_GET['t'];
		if($table=='relation'){
			$relation = new relation();
			$seq=  $_POST['seq'];
			if($seq) {
				$relation->set_data('seq', $seq);
			}
			
			$idsip =  $_POST['idsip'];
			$idsmsg =  $_POST['idsmsg'];
			$idsserverip =  $_POST['idsserverip'];
			$devicesip =  $_POST['devicesip'];
			$devicesmsg =  $_POST['devicesmsg'];
			$level =  $_POST['level'];
			
			$relation->set_data('idsip', $idsip);
			$relation->set_data('idsmsg', $idsmsg);
			$relation->set_data('idsserverip', $idsserverip);
			$relation->set_data('devicesip', $devicesip);
			$relation->set_data('devicesmsg', $devicesmsg);
			$relation->set_data('level', $level);

			if($seq) {
				if($seq != '') {
					$this->relation_set->edit($relation);
					alert_and_back('编辑成功!', 'admin.php?c=admin_relation');
				}
				
			}else  {

						$this->relation_set->add($relation);
						alert_and_back('添加成功!', 'admin.php?c=admin_relation');

			}			
			
		}//host
		else if($table=='relationids'){
			$relationids = new relationids();
			$seq=  $_POST['seq'];
			if($seq) {
				$relationids->set_data('seq', $seq);
			}

			$idsip =  $_POST['idsip'];
			$system =  $_POST['system'];
			$desc =  $_POST['desc'];
		
			$relationids->set_data('idsip', $idsip);
			$relationids->set_data('system', $system);
			$relationids->set_data('desc', $desc);
		
			if($seq) {
				if($seq != '') {
					$this->relationids_set->edit($relationids);
					alert_and_back('编辑成功!', 'admin.php?c=admin_relation&a=relationids');
				}
				
			}else  {

							$this->relationids_set->add($relationids);
							alert_and_back('添加成功!', 'admin.php?c=admin_relation&a=relationids');

			}			
			
		}
	}
	
	
	function import(){
		$this->display('importRelation.tpl');
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
 						$sql = "INSERT INTO relation (`".idsip."`,`".idsmsg."`,`".devicesip."`,`".devicesmsg."`,`".level."`,`".desc."`,`".idsserverip."`) VALUES('".

					      $data->sheets[0]['cells'][$i][1]."','".   
					      $data->sheets[0]['cells'][$i][2]."','".  
					      $data->sheets[0]['cells'][$i][3]."','".  
					      $data->sheets[0]['cells'][$i][4]."','".  
					      $data->sheets[0]['cells'][$i][5]."','".   
					      $data->sheets[0]['cells'][$i][6]."','".  
					  //    $data->sheets[0]['cells'][$i][7]."','".  
					      $data->sheets[0]['cells'][$i][8]."')";  

						  $this->systemNew_set->query($sql);

						}
						 $totalNums=$data->sheets[0]['numRows']-2;//求出导入的总数据条数		     
    					@unlink($dir.$filename); 
    					 $msg = '导入成功'.strval($totalNums).'条记录';
    
    					go_url("admin.php?c=admin_relation");
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
		
		 
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM relation" ;
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
		header('Content-Disposition: attachment;filename="relation.xls"');		
		header('Cache-Control: max-age=0');				 		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');		
		$objWriter->save('php://output');		
		exit;		
	}
}
?>
