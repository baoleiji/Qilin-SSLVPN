<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class compare_set extends base_set {
	protected $table_name = 'config_audit_dev';
	protected $id_name = 'id';

}
?>
