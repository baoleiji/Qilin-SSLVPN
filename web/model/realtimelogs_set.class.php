<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class realtimelogs_set extends base_set {
	protected $table_name = 'log_realtimelogs';
	protected $id_name = 'seq';

}

?>
