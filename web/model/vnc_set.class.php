<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class vnc_set extends base_set {
	protected $table_name = 'vncsessions';
	protected $id_name = 'sid';

}
?>
