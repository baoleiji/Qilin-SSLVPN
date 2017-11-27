<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class scpsession_set extends base_set {
	protected $table_name = 'scpcomm';
	protected $id_name = 'cid';

}
?>
