<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class servers_nmap_set extends base_set {
	protected $table_name = 'servers_nmap';
	protected $id_name = 'id';
}