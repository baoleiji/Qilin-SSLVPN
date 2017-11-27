<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class autobackup_log_set extends base_set {
	protected $table_name = 'autobackup_log';
	protected $id_name = 'id';

}
?>
