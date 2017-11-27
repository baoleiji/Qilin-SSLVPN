<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class command_statistic_set extends base_set {
	protected $table_name = 'commandstatistic_day';
	protected $id_name = 'sid';

}
?>
