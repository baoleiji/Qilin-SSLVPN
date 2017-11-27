<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sqlserver_set extends base_set {
	protected $table_name = 'sqlserver_sessions';
	protected $id_name = 'sid';

}
?>
