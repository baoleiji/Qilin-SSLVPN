<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sessionsrun_set extends base_set {
	protected $table_name = 'sessionsrun';
	protected $id_name = 'sid';

}
?>
