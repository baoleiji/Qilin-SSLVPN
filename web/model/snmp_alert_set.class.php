<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class snmp_alert_set extends base_set {
	protected $table_name = 'snmp_alert';
	protected $id_name = 'seq';

}