<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class cmdcache_set extends base_set {
	protected $table_name = 'cmdcache';
	protected $id_name = 'id';

}
?>