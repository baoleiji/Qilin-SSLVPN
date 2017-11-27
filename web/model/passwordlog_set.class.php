<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class passwordlog_set extends base_set {
	protected $table_name = 'passwordlog';
	protected $id_name = 'uid';

}
?>
