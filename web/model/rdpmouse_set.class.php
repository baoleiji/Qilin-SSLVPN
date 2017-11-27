<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class rdpmouse_set extends base_set {
	protected $table_name = 'rdpmouse';
	protected $id_name = 'sid';

}
?>