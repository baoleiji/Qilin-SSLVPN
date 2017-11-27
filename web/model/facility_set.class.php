<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class facility_set extends base_set {
	protected $table_name = 'facility';
	protected $id_name = 'fid';

}
?>
