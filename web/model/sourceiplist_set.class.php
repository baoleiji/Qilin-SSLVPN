<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sourceiplist_set extends base_set {
	protected $table_name = 'sourceiplist';
	protected $id_name = 'sid';

}
?>
