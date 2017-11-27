<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class logs_warning_set extends base_set {
	protected $table_name = 'log_logs_warning';
	protected $id_name = 'seq';
}