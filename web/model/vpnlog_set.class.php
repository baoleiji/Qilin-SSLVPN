<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class vpnlog_set extends base_set {
	protected $table_name = 'vpn_log';
	protected $id_name = 'id';

}
?>
