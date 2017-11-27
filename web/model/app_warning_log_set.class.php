<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class app_warning_log_set extends base_set {
	protected $table_name = 'app_warning_log';
	protected $id_name = 'id';

}