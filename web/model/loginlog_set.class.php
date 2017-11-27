<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class loginlog_set extends base_set {
	protected $table_name = 'loginlog';
	protected $id_name = 'id';

}
?>
