<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class snmp_server_policy_set extends base_set {
	protected $table_name = 'snmp_server_policy';
	protected $id_name = 'id';

	
}