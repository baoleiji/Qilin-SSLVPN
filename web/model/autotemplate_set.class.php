<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class autotemplate_set extends base_set {
	protected $table_name = 'autorun_template';
	protected $id_name = 'id';
}