<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class devpass extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'id' => 0,
				'device_ip' => '',
				'hostname' => '',
				'port' => 0,
				'username' => '',
				'old_password' => '',
				'cur_password' => '',
				'last_update_time' => '0000-00-00',
				'device_type' => 0,
				'enable' => 0,
				'limit_time' => '0000-00-00',
				'automodify' => 0,
				'luser' => ',',
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
			$this->flag[$data_index] = true;
			return true;
		}
		else {
			return false;
		}

		if($data_index == 'keyid') {
			if(!is_Numeric($data_data)) {
				$this->set_err('wmkeyid应该是数字');
				$flag = false;
			}
		}
	}

}

?>
