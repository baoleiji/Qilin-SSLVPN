<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class ftpcmd_statistic_set extends base_set {
	protected $table_name = 'ftpreport_day';
	protected $id_name = 'sid';

}
?>
