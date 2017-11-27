<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class db_forbiddencmds_set extends base_set {
	protected $table_name = 'db_forbidden_commands';
	protected $id_name = 'cid';

}
?>
