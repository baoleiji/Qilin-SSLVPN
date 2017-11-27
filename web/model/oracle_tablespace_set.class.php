<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class oracle_tablespace_set extends base_set {
	protected $table_name = 'oracle_tablespace';
	protected $id_name = 'id';

}