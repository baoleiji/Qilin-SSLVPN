<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class forbiddencmds_set extends base_set {
	protected $table_name = 'forbidden_commands';
	protected $id_name = 'cid';

}
?>
