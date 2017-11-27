<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sqlcommands_set extends base_set {
	protected $table_name = 'oracle_commands';
	protected $id_name = 'cid';

}
?>
