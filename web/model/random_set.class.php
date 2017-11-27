<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class random_set extends base_set {
	protected $table_name = 'random';
	protected $id_name = 'id';

}
?>
