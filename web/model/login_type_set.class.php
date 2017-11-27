<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class login_type_set extends base_set {
	protected $table_name = 'login_type';
	protected $id_name = 'id';

}