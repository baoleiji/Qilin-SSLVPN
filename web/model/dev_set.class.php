<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class dev_set extends base_set {
	protected $table_name = 'servers';
	protected $id_name = 'id';

}
?>
