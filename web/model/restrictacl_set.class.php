<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class restrictacl_set extends base_set {
	protected $table_name = 'restrictacl';
	protected $id_name = 'id';

}
?>
