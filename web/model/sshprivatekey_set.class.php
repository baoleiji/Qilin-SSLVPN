<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sshprivatekey_set extends base_set {
	protected $table_name = 'sshkey';
	protected $id_name = 'id';

}
?>
