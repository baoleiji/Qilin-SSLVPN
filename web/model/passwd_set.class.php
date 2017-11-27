<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class passwd_set extends base_set {
	protected $table_name = 'passwd';
	protected $id_name = 'uid';

}
?>
