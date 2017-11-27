<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class importlog_set extends base_set {
	protected $table_name = 'importlog';
	protected $id_name = 'id';

	
}