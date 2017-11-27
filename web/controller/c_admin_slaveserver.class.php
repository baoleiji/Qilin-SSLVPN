<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_slaveserver extends c_base {
	function index() {
		$hostname = $this->getInput('host');
		$query = ' 1=1';
		if($hostname){
			$query = " hostname='$hostname'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->slaveserver_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->slaveserver_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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

		$this->display('slaveserver.tpl');
	}
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= 'log_slaveserver';
		$idName = 'sid';
	
		$this->slaveserver_set->base_delete_all($table,$idName,$seq);
		alert_and_back('成功删除记录');
	}
	
	function edit(){
		$id = $_GET['id'];
		$table= $_GET['t'];
		
		$result = $this->slaveserver_set->select_by_id($id);
		
		$this->assign("id", $id);
		$this->assign("result", $result);
		$this->display('slaveserver_edit.tpl');
	}
	
	
function save() {
	
			$slaveserver = new slaveserver();
			$sid =  $_POST['sid'];
			if($sid) {
				$slaveserver->set_data('sid', $sid);
			}
			
	
			$hostname =  $_POST['hostname'];
			$ip =  $_POST['ip'];
			$desc =  $_POST['desc'];
			$datetime =  $_POST['datetime'];
		
		//	echo $hostname;

			$slaveserver->set_data('hostname', $hostname);
			$slaveserver->set_data('ip', $ip);
			$slaveserver->set_data('desc', $desc);
			$slaveserver->set_data('datetime', $datetime);

					
			if($sid) {
				if($sid != '') {
					$this->slaveserver_set->edit($slaveserver);
					alert_and_back('编辑成功!', 'admin.php?controller=admin_slaveserver');
				}
				
			}else  {
		
						$this->slaveserver_set->add($slaveserver);
						alert_and_back('添加成功!', 'admin.php?controller=admin_slaveserver');
		
			}			

		
		
		
	}
	
}
?>
