<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class forbiddengps_set extends base_set {
	protected $table_name = 'forbidden_groups';
	protected $id_name = 'gid';

}
?>
