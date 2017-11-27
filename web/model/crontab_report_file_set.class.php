<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class crontab_report_file_set extends base_set {
	protected $table_name = 'crontab_report_file';
	protected $id_name = 'id';

}
?>
