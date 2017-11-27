<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class cronreport_set extends base_set {
	protected $table_name = 'cronreports';
	protected $id_name = 'id';

}
?>
