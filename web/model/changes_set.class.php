<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class changes_set extends base_set {
	protected $table_name = 'changes';
	protected $id_name = 'chid';

}
?>
