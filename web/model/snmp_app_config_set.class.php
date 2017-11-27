<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class snmp_app_config_set extends base_set {
	protected $table_name = 'app_config';
	protected $id_name = 'seq';

}
?>
