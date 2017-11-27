<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class mails_set extends base_set {
	protected $table_name = 'mail';
	protected $id_name = 'sid';

}
?>
