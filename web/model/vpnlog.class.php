<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class vpnlog extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'id' => 0,
				'ip' => '',
				'user' => '',
				'src_ip' => '',
				'in_time' => '0000-00-00 00:00:00',
				'out_time' => '0000-00-00 00:00:00',
				'isactive' => 1,
				);
		}
		else {
			$this->data = $data;
		}
	}


	function set_data($data_index, $data_data) {
		$flag = true;

		if($data_index == 'ip') {
			if(!is_ip($data_data)) {
				$this->set_err('IP地址不合法');
				$flag = false;
			}
		}

		if($flag) {
			$this->data[$data_index] = $data_data;
			$this->flag[$data_index] = true;
			return true;
		}
		else {
			return false;
		}
	}

}

?>
