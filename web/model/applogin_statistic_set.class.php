<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class applogin_statistic_set extends base_set {
	protected $table_name = 'applogin_day';
	protected $id_name = 'sid';

}
?>
