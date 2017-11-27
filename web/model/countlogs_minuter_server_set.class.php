<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class countlogs_minuter_server_set extends base_set {
	protected $table_name = 'log_countlogs_minuter_server';
	protected $id_name = 'seq';

}

?>
