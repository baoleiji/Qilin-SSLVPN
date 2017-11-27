<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class snmp_report_interface_policy_set extends base_set {
	protected $table_name = 'snmp_report_interface_policy';
	protected $id_name = 'id';

}
?>