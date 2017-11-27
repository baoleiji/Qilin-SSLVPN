<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class snmp_interface_log_set extends base_set {
	protected $table_name = 'snmp_interface_log';
	protected $id_name = 'id';

}