<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class linux_authpriv_set extends base_set {
	protected $table_name = 'log_linux_authpriv';
	protected $id_name = 'id';

}

?>
