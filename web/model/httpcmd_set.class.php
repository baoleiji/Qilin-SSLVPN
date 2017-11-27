<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class httpcmd_set extends base_set {
	protected $table_name = 'http_command';
	protected $id_name = 'sid';

}
?>
