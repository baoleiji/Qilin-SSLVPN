<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class admin_log_set extends base_set {
	protected $table_name = 'admin_log';
	protected $id_name = 'id';

}
?>
