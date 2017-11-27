<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class workflow_log_set extends base_set {
	protected $table_name = 'workflow_log';
	protected $id_name = 'sid';

}
?>
