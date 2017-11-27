<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class linuxfile_set extends base_set {
	protected $table_name = 'config_audit_template_files';
	protected $id_name = 'tid';

}
?>
