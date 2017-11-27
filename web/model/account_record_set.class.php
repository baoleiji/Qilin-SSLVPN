<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class account_record_set extends base_set {
	protected $table_name = 'account_record';
	protected $id_name = 'ip';

	
}