<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class luser_set extends base_set {
	protected $table_name = 'luser';
	protected $id_name = 'id';

}
?>
