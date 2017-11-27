<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class autodelete_set extends base_set {
	protected $table_name = 'autodelete';
	protected $id_name = 'seq';

}
?>