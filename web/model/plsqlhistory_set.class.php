<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class plsqlhistory_set extends base_set {
	protected $table_name = 'app_plsqlhistory_log';
	protected $id_name = 'id';

}