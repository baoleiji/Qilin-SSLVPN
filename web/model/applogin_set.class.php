<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class applogin_set extends base_set {
	protected $table_name = 'applogin';
	protected $id_name = 'uid';

}
?>