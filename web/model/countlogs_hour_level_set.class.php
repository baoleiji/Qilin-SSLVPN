<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class countlogs_hour_level_set extends base_set {
	protected $table_name = 'log_countlogs_hour_level';
	protected $id_name = 'seq';

}

?>
