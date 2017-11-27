<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class winservers_set extends base_set {
	protected $table_name = 'winservers';
	protected $id_name = 'id';

}
?>
