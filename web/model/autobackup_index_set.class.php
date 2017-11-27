<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class autobackup_index_set extends base_set {
	protected $table_name = 'autobackup_index';
	protected $id_name = 'id';

}
?>
