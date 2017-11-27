<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class assets_set extends base_set {
	protected $table_name = 'assets';
	protected $id_name = 'id';
}