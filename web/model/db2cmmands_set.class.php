<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class db2cmmands_set extends base_set {
	protected $table_name = 'db2_commands';
	protected $id_name = 'cid';

}
?>
