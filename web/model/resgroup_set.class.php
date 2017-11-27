<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class resgroup_set extends base_set {
	protected $table_name = 'resourcegroup';
	protected $id_name = 'id';

}