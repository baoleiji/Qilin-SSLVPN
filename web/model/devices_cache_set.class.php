<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class devices_cache_set extends base_set {
	protected $table_name = 'devices_cache';
	protected $id_name = 'id';

}
?>