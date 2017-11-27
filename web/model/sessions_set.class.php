<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sessions_set extends base_set {
	protected $table_name = 'sessions';
	protected $id_name = 'sid';

}
?>
