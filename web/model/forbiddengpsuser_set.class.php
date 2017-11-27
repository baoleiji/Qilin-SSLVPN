<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class forbiddengpsuser_set extends base_set {
	protected $table_name = 'forbidden_commands_user';
	protected $id_name = 'id';

}
?>
