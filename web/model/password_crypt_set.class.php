<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class password_crypt_set extends base_set {
	protected $table_name = 'password_crypt';
	protected $id_name = 'id';

	
}