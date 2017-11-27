<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class loginfailed_statistic_set extends base_set {
	protected $table_name = 'loginfailed_day';
	protected $id_name = 'sid';

}
?>
