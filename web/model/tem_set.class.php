<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class tem_set extends base_set {
	protected $table_name = 'login_template';
	protected $id_name = 'id';

}