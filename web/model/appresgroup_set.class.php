<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class appresgroup_set extends base_set {
	protected $table_name = 'appresourcegroup';
	protected $id_name = 'id';

}