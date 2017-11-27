<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class loginapproved_statistic_set extends base_set {
	protected $table_name = 'loginapproved_day';
	protected $id_name = 'sid';

}
?>
