<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class autorun_result_detail_set extends base_set {
	protected $table_name = 'autorun_result_detail';
	protected $id_name = 'id';
}