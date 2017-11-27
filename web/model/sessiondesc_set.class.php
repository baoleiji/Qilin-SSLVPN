<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sessiondesc_set extends base_set {
	protected $table_name = 'sessiondesc';
	protected $id_name = 'id';

}
?>
