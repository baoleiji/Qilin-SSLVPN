<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class server_set extends base_set {
	protected $table_name = 'servers';
	protected $id_name = 'id';

	function select_limit_ex($begin, $end, $where = '1=1', $orderby1 = '', $orderby2 = 'DESC') {
		if($orderby1 == '') {
			$orderby1 = $this->id_name;
		}
		if($orderby2 == '') {
			$orderby2 = 'DESC';
		}
		
		return $result = $this->base_select("SELECT servers.*,login_template.device_type,login_template.login_method FROM `servers`, `login_template` WHERE $where and servers.template_id = login_template.id ORDER BY servers.id $orderby2 LIMIT $begin, $end");
	}

	function select_limit_ex1($begin, $end, $uid, $where = '1=1', $orderby1 = '', $orderby2 = 'DESC',$groupby='',$select = "devices.*") {
		if($orderby1 == '') {
			$orderby1 = $this->id_name;
		}
		if($orderby2 == '') {
			$orderby2 = 'DESC';
		}
		$result = $this->base_select("SELECT $select FROM `devices` LEFT JOIN servers ON devices.device_ip=servers.device_ip AND devices.hostname=servers.hostname WHERE $where $groupby ORDER BY devices.$orderby1 $orderby2  LIMIT $begin, $end");
		return $result;
	}

	function select_ex_by_id($id) {
			 $result = $this->base_select("SELECT devices.*,devices.id as did,login_template.device_type,login_template.login_method FROM `devices`, `login_template` WHERE devices.template_id = login_template.id  AND devices.id = $id");
			return $result[0];
	}
	function select_count_ex($uid,$where = '1=1', $groupby='') {
		$query = "SELECT COUNT(*) AS row_num FROM `devices` LEFT JOIN servers ON devices.device_ip=servers.device_ip AND devices.hostname=servers.hostname WHERE $where  $groupby";
		$result = $this->query($query);
		if (!$result) {
			return NULL;
		}
		else if(mysql_num_rows($result) == 0) {
			return NULL;
		}elseif(mysql_num_rows($result) > 1){
			return mysql_num_rows($result);
		}
		else {
			$row = mysql_fetch_assoc($result);
			
			return $row['row_num'];
		}
	}
}