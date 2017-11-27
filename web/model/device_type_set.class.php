<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class device_type_set extends base_set {
	protected $table_name = 'device_type';
	protected $id_name = 'id';

}