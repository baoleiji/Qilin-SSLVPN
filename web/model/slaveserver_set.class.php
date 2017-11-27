<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class slaveserver_set extends base_set {
	protected $table_name = 'log_slaveserver';
	protected $id_name = 'sid';

}

?>
