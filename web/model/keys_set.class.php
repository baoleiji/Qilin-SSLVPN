<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class keys_set extends base_set {
	protected $table_name = 'device';
	protected $id_name = 'id';

}
?>