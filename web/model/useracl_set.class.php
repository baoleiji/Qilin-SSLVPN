<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class useracl_set extends base_set {
	protected $table_name = 'autologin_users';
	protected $id_name = 'id';

	
}