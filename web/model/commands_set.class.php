<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class commands_set extends base_set {
	protected $table_name = 'commands';
	protected $id_name = 'cid';

}
?>
