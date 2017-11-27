<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class ftpcmd_set extends base_set {
	protected $table_name = 'ftpcomm';
	protected $id_name = 'cid';

}
?>
