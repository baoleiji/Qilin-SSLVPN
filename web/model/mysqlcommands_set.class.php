<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class mysqlcommands_set extends base_set {
	protected $table_name = 'mysql_commands';
	protected $id_name = 'cid';

}
?>
