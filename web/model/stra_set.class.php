<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class stra_set extends base_set {
	protected $table_name = 'strategy';
	protected $id_name = 'id';

		function select_limit_ex($begin, $end, $where = '1=1', $orderby1 = '', $orderby2 = 'DESC') {
		if($orderby1 == '') {
			$orderby1 = $this->id_name;
		}
		if($orderby2 == '') {
			$orderby2 = 'DESC';
		}
		
		return $result = $this->base_select("SELECT servers.*,login_template.device_type,login_template.login_method,strategy.*,strategy.id as sid,servers.id as did FROM `servers`, `login_template`,`strategy` WHERE $where and servers.template_id = login_template.id and strategy.device_ip = servers.device_ip ORDER BY servers.id $orderby2 LIMIT $begin, $end");


	}
}