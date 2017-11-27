<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class oracle_disk_set extends base_set {
	protected $table_name = 'oracle_disk';
	protected $id_name = 'id';

}