<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class backup_setting_set extends base_set {
	protected $table_name = 'backup_setting';
	protected $id_name = 'seq';

}
?>