<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class login_month_count extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'seq' => 0,
				'date_start' => '', 
				'date_end' => '', 
				'server' => '',
				'user' => '',
				'srcip' => '',
				'protocol' => '',
				'status' => '',
				'count' => '',
			);
		}
		else {
			$this->data = $data;
		}
	}


	function set_data($data_index, $data_data) {
		$flag = true;

		if($flag) {
			$this->data[$data_index] = $data_data;
			return true;
		}
		else {
			return false;
		}
	}

}

?>
