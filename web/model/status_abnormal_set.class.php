<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class status_abnormal_set extends base_set {
	protected $table_name = 'local_status_warning_log';
	protected $id_name = 'seq';

	
}