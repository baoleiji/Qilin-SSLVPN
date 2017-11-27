<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class setting_set extends base_set {
	protected $table_name = 'setting';
	protected $id_name = 'sid';

}
?>
