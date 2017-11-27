<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class asset_set extends base_set {
	protected $table_name = 'log_asset';
	protected $id_name = 'hid';

}

?>
