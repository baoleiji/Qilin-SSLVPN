<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class countlogs_set extends base_set {
	protected $table_name = 'log_countlogs';
	protected $id_name = 'seq';

}

?>
