<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sftpcmd_set extends base_set {
	protected $table_name = 'sftpcomm';
	protected $id_name = 'cid';

}
?>
