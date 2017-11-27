<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sourceip_set extends base_set {
	protected $table_name = 'sourceip';
	protected $id_name = 'sid';

}
?>
