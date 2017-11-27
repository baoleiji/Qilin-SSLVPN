<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class subfile_set extends base_set {
	protected $table_name = 'sub_template';
	protected $id_name = 'stid';

}
?>
