<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class applog_warning_set extends base_set {
	protected $table_name = 'applog_warning';
	protected $id_name = 'id';
}