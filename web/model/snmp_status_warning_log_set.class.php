<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class snmp_status_warning_log_set extends base_set {
	protected $table_name = 'snmp_status_warning_log';
	protected $id_name = 'id';

}