<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class mysql_set extends base_set {
	protected $table_name = 'mysql_sessions';
	protected $id_name = 'sid';

}
?>
