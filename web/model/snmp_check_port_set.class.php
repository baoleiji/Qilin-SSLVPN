<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class snmp_check_port_set extends base_set {
	protected $table_name = 'snmp_check_port';
	protected $id_name = 'seq';

}