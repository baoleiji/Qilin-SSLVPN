<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class rdp_set extends base_set {
	protected $table_name = 'rdpsessions';
	protected $id_name = 'sid';

}
?>
