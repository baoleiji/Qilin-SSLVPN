<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class proxyip_set extends base_set {
	protected $table_name = 'proxyip';
	protected $id_name = 'id';

}
?>
