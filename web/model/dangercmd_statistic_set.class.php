<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class dangercmd_statistic_set extends base_set {
	protected $table_name = 'dangercmdreport_day';
	protected $id_name = 'sid';

}
?>
