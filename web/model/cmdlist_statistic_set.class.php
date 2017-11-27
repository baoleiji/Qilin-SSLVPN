<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class cmdlist_statistic_set extends base_set {
	protected $table_name = 'cmdlist_day';
	protected $id_name = 'sid';

}
?>
