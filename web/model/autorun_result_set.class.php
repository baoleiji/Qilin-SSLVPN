<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class autorun_result_set extends base_set {
	protected $table_name = 'autorun_result';
	protected $id_name = 'id';
}