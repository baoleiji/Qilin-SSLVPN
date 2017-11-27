<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class ftpsession_set extends base_set {
	protected $table_name = 'ftpsessions';
	protected $id_name = 'sid';

}
?>
