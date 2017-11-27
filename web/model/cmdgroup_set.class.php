<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class cmdgroup_set extends base_set {
	protected $table_name = 'commandgroup';
	protected $id_name = 'id';

}
?>
