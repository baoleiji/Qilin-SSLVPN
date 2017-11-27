<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class version_set extends base_set {
	protected $table_name = 'version';
	protected $id_name = 'id';

}
?>
