<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class notice_set extends base_set {
	protected $table_name = 'notice';
	protected $id_name = 'id';
}