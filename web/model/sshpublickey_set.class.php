<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sshpublickey_set extends base_set {
	protected $table_name = 'sshpublickey';
	protected $id_name = 'id';

}
?>
