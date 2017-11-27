<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class devlogin_statistic_set extends base_set {
	protected $table_name = 'devlogin_day';
	protected $id_name = 'sid';

}
?>
