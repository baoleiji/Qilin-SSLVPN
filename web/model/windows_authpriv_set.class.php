<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class windows_authpriv_set extends base_set {
	protected $table_name = 'log_windows_authpriv';
	protected $id_name = 'id';

}

?>
