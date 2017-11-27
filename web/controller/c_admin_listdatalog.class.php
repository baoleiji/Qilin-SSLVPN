<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_listdatalog extends c_base {
	function index() {
		$host = $this->getInput('host');
		$query = ' 1=1';
		if($host){
			$query = " ip='$host'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->listdata_log_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllogs = $this->listdata_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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

		$this->display('listdatalog.tpl');
	}

	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table='listdata_log';

		$this->listdata_log_set->base_delete_all($table,'id',$seq);
		alert_and_back('成功删除记录');
	}
}
?>
