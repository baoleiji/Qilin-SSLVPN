<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class account_linuxusers_set extends base_set {
	protected $table_name = 'account_linuxusers';
	protected $id_name = 'id';

}
?>