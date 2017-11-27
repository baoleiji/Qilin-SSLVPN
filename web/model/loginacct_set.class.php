<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class loginacct_set extends base_set {
	protected $table_name = 'loginacct';
	protected $id_name = 'sid';
}