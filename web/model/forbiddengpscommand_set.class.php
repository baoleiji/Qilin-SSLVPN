<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class forbiddengpscommand_set extends base_set {
	protected $table_name = 'forbidden_commands_groups';
	protected $id_name = 'cid';

}
?>
