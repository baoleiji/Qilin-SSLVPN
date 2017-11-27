<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class dns_monitor_set extends base_set {
	protected $table_name = 'dns_status';
	protected $id_name = 'id';

}