<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sqlservercommands_set extends base_set {
	protected $table_name = 'sqlserver_commands';
	protected $id_name = 'cid';

}
?>
