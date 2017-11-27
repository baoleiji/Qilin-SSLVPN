<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class user extends base {
	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'userid' => 0,
				'username' => '',
				'password' => '',
				'email' => '',
				'level' => 0,
				'desc' => '',
				'hostlist' => '',
			);
		}
		else {
			$this->data = $data;
		}
	}
	
	function set_data($data_index, $data_data) {
		$flag = false;
		if($data_index == 'username') {
			if(strlen($data_data) < 2) {
				$this->set_err('用户名过短');
			}
			else if(strlen($data_data) > 32) {
				$this->set_err('用户名过长');
			}
			else {
				$flag = true;
			}
		}
		else if($data_index == 'password') {
		
			$flag = true;
		}
		else if($data_index == 'email') {
			if(!is_email($data_data)) {
				$this->set_err('E-Mail格式不正确');
			}
			else {
				$flag = true;
			}
		}
		else if($data_index == 'userid' || $data_index == 'level') {
			if(is_numeric($data_data)) {
				$flag = true;
			}
		}
		else if($data_index == 'hostlist') {
			$flag = true;

		}else if($data_index == 'desc') {
			$flag = true;

		}
		
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
