<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sshkeyname_set extends base_set {
	protected $table_name = 'sshkeyname';
	protected $id_name = 'id';

}
?>
