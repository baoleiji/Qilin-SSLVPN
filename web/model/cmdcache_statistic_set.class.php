<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class cmdcache_statistic_set extends base_set {
	protected $table_name = 'cmdcache_day';
	protected $id_name = 'sid';

}
?>
