<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class template_set extends base_set {
	protected $table_name = 'config_audit_templates';
	protected $id_name = 'id';

	
}