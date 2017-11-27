<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sftpsession_set extends base_set {
	protected $table_name = 'sftpsessions';
	protected $id_name = 'sid';

}
?>
