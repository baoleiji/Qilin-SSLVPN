<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class logs_set extends base_set {
	protected $table_name = 'log';
	protected $id_name = 'id';
}