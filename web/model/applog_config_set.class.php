<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class applog_config_set extends base_set {
	protected $table_name = 'applog_config';
	protected $id_name = 'id';

	
}