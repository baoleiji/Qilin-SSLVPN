<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class admin_log_statistic_set extends base_set {
	protected $table_name = 'admin_log_day';
	protected $id_name = 'id';

}
?>
