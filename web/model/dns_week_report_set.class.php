<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class dns_week_report_set extends base_set {
	protected $table_name = 'dns_week_report';
	protected $id_name = 'id';

}