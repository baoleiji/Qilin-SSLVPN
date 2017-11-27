<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_relationlog extends c_base {
	function index() {
		$hostname = $this->getInput('hostname');
		$query = ' 1=1';
		if($hostname){
			$query = " t.idsip='$hostname'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->relationlog_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		
		$all = $this->relationlog_set->base_select("SELECT t.*,t2.desc FROM `relationlog` t left join `relation` t2 on(t.relationid=t2.seq) WHERE $query ORDER BY `seq` desc LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
			//	print_r($all);
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

		$this->display('relationlog.tpl');
	}
	
	function relationidslog() {
		$host = $this->getInput('hostname');
		$query = ' 1=1';
		if($host){
			$query = " t.idsip='$host'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->relationidslog_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');

		$all = $this->relationidslog_set->base_select("SELECT t.*,t2.desc FROM `relationidslog` t left join `relation` t2 on(t.relationid=t2.seq) WHERE $query ORDER BY `seq` desc LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		
		
		
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

		$this->display('relationidslog.tpl');
	}
	
	
	function relationserverlog() {
		$host = $this->getInput('hostname');
		$query = ' 1=1';
		if($host){
			$query = " t.serverip='$host'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->relationserverlog_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		
		$all = $this->relationserverlog_set->base_select("SELECT t.*,t2.desc FROM `relationserverlog` t left join `relation` t2 on(t.relationid=t2.seq) WHERE $query ORDER BY `seq` desc LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		
		
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

		$this->display('relationserverlog.tpl');
	}
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];
		$idName = 'seq';

		$this->relationlog_set->base_delete_all($table,$idName,$seq);
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
	

	function detail() {
		
		$table= $_GET['t'];
		$id= $_GET['id'];
		
		
		$tplName = 'relationlog_detail.tpl';
		
		$result =  $this->linux_login_set->base_select("SELECT t.*,t2.desc FROM `relationlog` t left join `relation` t2 on (t.relationid=t2.seq) WHERE t.seq = '$id' ");

		$this->assign("detail", $result[0]);

		$this->display($tplName);

	}
}
?>
