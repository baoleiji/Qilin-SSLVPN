<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class login_statistic_set extends base_set {
	protected $table_name = 'logintimes_day';
	protected $id_name = 'sid';

}
?>
