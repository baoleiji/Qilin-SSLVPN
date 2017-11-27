<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class backupsession_set extends base_set {
	protected $table_name = 'backup_session_log';
	protected $id_name = 'id';

}
?>
