<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class loginacct_statistic_set extends base_set {
	protected $table_name = 'loginacct_day';
	protected $id_name = 'sid';

}
?>
