<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class passwordkey_set extends base_set {
	protected $table_name = 'passwordkey';
	protected $id_name = 'id';

}
?>
