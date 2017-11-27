<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class pro_set extends base_set {
	protected $table_name = 'protect';
	protected $id_name = 'id';

}
?>
