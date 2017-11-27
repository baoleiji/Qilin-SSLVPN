<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class restrictpolicy_set extends base_set {
	protected $table_name = 'restrictpolicy';
	protected $id_name = 'id';

}
?>
