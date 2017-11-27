<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class app_report_day_set extends base_set {
	protected $table_name = 'app_day_report';
	protected $id_name = 'id';

}