<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class countlogs_hour_detailed_set extends base_set {
	protected $table_name = 'log_countlogs_hour_detailed';
	protected $id_name = 'seq';

}

?>
