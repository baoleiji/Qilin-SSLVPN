<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class account_set extends base_set {
	protected $table_name = 'radacct';
	protected $id_name = 'RadAcctId';

}
?>