<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class mail_sender_set extends base_set {
	protected $table_name = 'mail_sender';
	protected $id_name = 'id';

	
}