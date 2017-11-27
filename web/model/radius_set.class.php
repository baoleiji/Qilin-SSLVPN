<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class radius_set extends base_set {
	protected $table_name = 'radcheck';
	protected $id_name = 'id';

}
?>
