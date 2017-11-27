<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class httpsession_set extends base_set {
	protected $table_name = 'http_session';
	protected $id_name = 'sid';

}
?>
