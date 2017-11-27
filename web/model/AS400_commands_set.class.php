<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class AS400_commands_set extends base_set {
	protected $table_name = 'AS400_commands';
	protected $id_name = 'sid';

}
?>
