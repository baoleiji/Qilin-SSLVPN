<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sybasecommands_set extends base_set {
	protected $table_name = 'sybase_commands';
	protected $id_name = 'cid';

}
?>
