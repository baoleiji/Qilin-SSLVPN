<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class eventlogs_set extends base_set {
	protected $table_name = 'eventlogs';
	protected $id_name = 'seq';

}
?>