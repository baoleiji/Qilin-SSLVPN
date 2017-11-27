<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class crontablog_set extends base_set {
	protected $table_name = 'crontablog';
	protected $id_name = 'id';

}
?>
