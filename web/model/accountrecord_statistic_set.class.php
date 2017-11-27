<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class accountrecord_statistic_set extends base_set {
	protected $table_name = 'accountrecord_day';
	protected $id_name = 'id';

}
?>
