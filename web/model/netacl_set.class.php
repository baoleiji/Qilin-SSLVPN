<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class netacl_set extends base_set {
	protected $table_name = 'autologin_network';
	protected $id_name = 'id';

	
}