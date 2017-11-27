<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_servergroup extends c_base {
	
	function index() {
		$groupname = $this->getInput('groupname');
		$query = ' 1=1';
		if($groupname){
			$query = " groupname='$groupname'";
		}

		$page_num = $this->getInput('page');
		$row_num = $this->servergroup_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		
		$all = $this->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
		
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

		$this->display('servergroup.tpl');
	}
	
	public function select_limit($begin, $end, $where = '1=1', $orderby = '') {
		$sql = "SELECT  t1.*,count(t2.hid) num from  servergroup t1 left join host t2 on(t1.id=t2.group) where ".$where." group by groupname LIMIT $begin, $end";
		return $result = $this->servergroup_set->base_select($sql);
	}

	function delete_all() {
		$seq = get_request('chk_member', 1, 1);

		$idName = 'id';
	
		$this->servergroup_set->base_delete_all('servergroup',$idName,$seq);
		alert_and_back('成功删除记录');
	}
	
	function edit(){
	
		$id = $_GET['id'];
		$table= 'servergroup';

		$setName =$table.'_set';
		$tplName =$table.'_edit.tpl';
		
		$result = $this->$setName->select_by_id($id);

		$this->assign("id", $id);
		$this->assign("result", $result);
		$this->display($tplName);
	}
	
	function save() {
			$table= $_GET['t'];
			$servergroup = new servergroup();
			$id =  $_POST['id'];
			if($id) {
				$servergroup->set_data('id', $id);
			}
			
			$groupname =  $_POST['groupname'];
			$description =  $_POST['description'];

			
			$servergroup->set_data('groupname', $groupname);
			$servergroup->set_data('description', $description);

	
			if($id) {
				if($id != '') {
					$this->servergroup_set->edit($servergroup);
					alert_and_back('编辑成功!', 'admin.php?c=admin_servergroup');
				}
				
			}else  {
						if($groupname == '') {
							alert_and_back('组名称不能为空!');
							exit();
						}
						else {
							$this->servergroup_set->add($servergroup);
							alert_and_back('添加成功!', 'admin.php?c=admin_servergroup');
						}
			}			

	}
}
?>
