<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class config_set extends base_set {
	protected $table_name = 'config';
	protected $id_name = 'cid';

}
?>
