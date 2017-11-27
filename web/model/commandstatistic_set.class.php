<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class commandstatistic_set extends base_set {
	protected $table_name = 'commandstatistic_day';
	protected $id_name = 'sid';

}
?>
