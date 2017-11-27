<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class linux_login_set extends base_set {
	protected $table_name = 'log_linux_login';
	protected $id_name = 'id';

}

?>
