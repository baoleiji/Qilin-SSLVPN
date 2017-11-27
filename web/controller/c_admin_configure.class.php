<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}
class c_admin_configure extends c_base {

	function index(){
		$this->snmp_interface();
	}

	function snmp_interface(){
		$ip = get_request('ip', 0, 1);
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND device_ip LIKE '%$ip%'";
		}
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$total_page = $this->snmp_interface_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$tholdlist = $this->snmp_interface_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby1,$orderby2);

		$this->assign('title', language('资产列表'));
		$this->assign("tholdlist", $tholdlist);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total_page);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);		
		$this->display('snmp_interface.tpl');
	}

	function snmp_interface_edit(){
		$id = get_request('id');
		$interface = $this->snmp_interface_set->select_by_id($id);
		$servers = $this->server_set->select_all();
		$this->assign("interface", $interface);
		$this->assign("servers", $servers);
		$this->display('snmp_interface_edit.tpl');
	}

	function snmp_interface_save(){
		$id = get_request('id');
		$connectdevice = get_request('connectdevice', 1, 0);
		$connectdeviceport = get_request('connectdeviceport', 1, 1);
		$connectport = get_request('connectport', 1, 1);
		$connectdesc = get_request('connectdesc', 1, 1);
		$snmp_interface = new snmp_interface();
		$snmp_interface->set_data('id', $id);
		$snmp_interface->set_data('connectdevice', $connectdevice);
		$snmp_interface->set_data('connectdeviceport', $connectdeviceport);
		$snmp_interface->set_data('connectport', $connectport);
		$snmp_interface->set_data('connectdesc', $connectdesc);
		if($id){
			$this->snmp_interface_set->edit($snmp_interface);
		}else{
		}
		alert_and_back('操作成功','admin.php?controller=admin_configure&action=snmp_interface');
	}

	function snmp_interface_del(){
		$id = get_request('id');
		$interface = $this->snmp_interface_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_configure&action=snmp_interface');
	}

}
?>
