<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class detail_config_set extends base_set {
	protected $table_name = 'autorun_detail_config';
	protected $id_name = 'id';
}