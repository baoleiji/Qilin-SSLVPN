<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class appmember_set extends base_set {
	protected $table_name = 'appmember';
	protected $id_name = 'id';

}
?>
