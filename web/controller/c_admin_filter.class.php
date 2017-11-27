<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_filter extends c_base {
	function index() {
		$allfilter = $this->filter_set->select_all();
		$this->assign('allfilter', $allfilter);

		$this->display('filter.tpl');
	}

	function save() {
		$type = get_request('type', 0, 1);
		$filter = new filter();
		if($type == 'edit') {
			$fid = get_request('fid', 1);
			$filter->set_data('fid', $fid);
		}
		$ftype = get_request('ftype', 1, 1);
		$fvalue = get_request('fvalue', 1, 1);
		$filter->set_data('ftype', $ftype);
		$filter->set_data('fvalue', $fvalue);
		//var_dump($filter);
		if($type == 'edit') {
			if($fvalue == '') {
				$this->filter_set->delete($fid);
				alert_and_back('删除成功!', 'admin.php?c=admin_filter');
			}
			else {
				$this->filter_set->edit($filter);
				alert_and_back('编辑成功!', 'admin.php?c=admin_filter');
			}
		}
		else if($type == 'add') {
			if($fvalue == '') {
				alert_and_back('过滤内容不能为空!');
				exit();
			}
			else {
				$this->filter_set->add($filter);
				alert_and_back('添加成功!', 'admin.php?c=admin_filter');
			}
		}
	}
}
?>
