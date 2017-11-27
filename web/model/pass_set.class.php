<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class pass_set extends base_set {
	protected $table_name = 'passes';
	protected $id_name = 'id';
}