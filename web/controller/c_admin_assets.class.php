<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_assets extends c_base {
	function index() {
		$page_num = get_request('page');
		$ip = get_request('ip',0,1);
		$number = get_request('number',0,1);
		$specification = get_request('specification',0,1);
		$department = get_request('department',0,1);
		$type = get_request('type',0,1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		$where ="1=1";
		if($number){
			$where .= " AND number like '%$number%'";
		}
		if($type){
			$where .= " AND type like '%$type%'";
		}
		if($specification){
			$where .= " AND specification like '%$specification%'";
		}
		if($department){
			$where .= " AND department like '%$department%'";
		}
		$total_page = $this->assets_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$alldev = $this->assets_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);

		$this->assign('title', language('资产列表'));
		$this->assign("alldev", $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('assets_index.tpl');
	}

	

	function edit() {
		$serverip = get_request('serverip',0,1);
		$id = get_request('id');
		$ip = get_request('ip',0,1);
		$g_id = get_request('g_id');
		$type = get_request('type', 0, 1);
		if($ip == '') {
			$ip = get_request('ip',1,1);
		}
		$assets = $this->assets_set->select_by_id($id);		
		$this->assign('title',language('绑定托管用户'));
		$this->assign('serverip',$serverip);
		$this->assign('server',$server);
		$this->assign('id',$id);
		$this->assign('assets', $assets);
		$this->display('assets_edit.tpl');
	}

	function save() {
		global $_CONFIG;
		$id = get_request('id');
		$serverip = get_request('serverip', 0, 1);
		$number = get_request('number', 1, 1);
		$type = get_request('type', 1, 1);
		$specification = get_request('specification', 1, 1);
		$department = get_request('department', 1, 1);
		$location = get_request('location', 1, 1);
		$start = get_request('start', 1, 1);
		$usedtime = get_request('usedtime', 1, 1);
		$status = get_request('status', 1, 1);
		$newassets = new assets();
		$newassets->set_data("id", $id);
		$newassets->set_data("number", $number);
		$newassets->set_data("type", $type);
		$newassets->set_data("specification", $specification);
		$newassets->set_data("department", $department);
		$newassets->set_data("location", $location);
		$newassets->set_data("device_ip", $serverip);
		$newassets->set_data("start", $start);
		$newassets->set_data("usedtime", $usedtime);
		$newassets->set_data("status", $status);
		if($id){
			$this->assets_set->edit($newassets);
		}else{
			$this->assets_set->add($newassets);
			$id = mysql_insert_id();

			$this->assets_set->query("UPDATE servers SET asset_id='$id' WHERE device_ip='$serverip'");
		}
		
		alert_and_back('操作成功',"admin.php?controller=admin_assets");
	}

	function del() {
		global $_CONFIG;
		$id = get_request('id');
		$this->assets_set->delete($id);
		
		alert_and_back('操作成功',"admin.php?controller=admin_assets");
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
