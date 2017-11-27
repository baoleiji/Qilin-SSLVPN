<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class db2_set extends base_set {
	protected $table_name = 'db2_sessions';
	protected $id_name = 'sid';

}
?>
