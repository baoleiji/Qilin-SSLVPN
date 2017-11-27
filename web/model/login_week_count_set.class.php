<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class login_week_count_set extends base_set {
	protected $table_name = 'log_login_week_count';
	protected $id_name = 'seq';

}

?>
