<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class snmp_status_set extends base_set {
	protected $table_name = 'snmp_status';
	protected $id_name = 'seq';

}