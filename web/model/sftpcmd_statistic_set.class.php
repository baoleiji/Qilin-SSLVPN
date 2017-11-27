<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sftpcmd_statistic_set extends base_set {
	protected $table_name = 'sftpreport_day';
	protected $id_name = 'sid';

}
?>
