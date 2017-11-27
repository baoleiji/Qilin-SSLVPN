<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class servergroup_set extends base_set {
	protected $table_name = 'log_servergroup';
	protected $id_name = 'id';

}

?>
