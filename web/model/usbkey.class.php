<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class usbkey extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'id' => 0,
				'keyid' => 0,
				'isused' => 0,
				'limittime' => '',
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
				$this->set_err('usbkeyid应该是数字');
				$flag = false;
			}
		}
	}

}

?>
