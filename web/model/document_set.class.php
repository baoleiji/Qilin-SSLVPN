<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class document_set extends base_set {
	protected $table_name = 'snmp_doc';
	protected $id_name = 'id';

	
}