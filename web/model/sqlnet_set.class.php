<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sqlnet_set extends base_set {
	protected $table_name = 'oracle_sessions';
	protected $id_name = 'sid';

}
?>
