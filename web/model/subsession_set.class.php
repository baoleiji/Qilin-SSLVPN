<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class subsession_set extends base_set {
	protected $table_name = 'sub_sessions';
	protected $id_name = 'sub_sid';
}
?>