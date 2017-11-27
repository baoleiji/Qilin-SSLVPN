<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class company_set extends base_set {
	protected $table_name = 'log_company';
	protected $id_name = 'id';

}

?>
