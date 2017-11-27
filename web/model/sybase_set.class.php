<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sybase_set extends base_set {
	protected $table_name = 'sybase_sessions';
	protected $id_name = 'sid';

}
?>
