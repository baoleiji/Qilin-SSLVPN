<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class loginacctcode_set extends base_set {
	protected $table_name = 'loginacctcode';
	protected $id_name = 'id';
}