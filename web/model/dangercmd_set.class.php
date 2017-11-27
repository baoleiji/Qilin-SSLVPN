<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class dangercmd_set extends base_set {
	protected $table_name = 'dangerscmds';
	protected $id_name = 'id';

}
?>
