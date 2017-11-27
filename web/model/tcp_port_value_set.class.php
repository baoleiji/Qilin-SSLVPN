<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class tcp_port_value_set extends base_set {
	protected $table_name = 'tcp_port_value';
	protected $id_name = 'seq';

}