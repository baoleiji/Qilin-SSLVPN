<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class appserver_set extends base_set {
	protected $table_name = 'apppserver';
	protected $id_name = 'id';

}
?>
