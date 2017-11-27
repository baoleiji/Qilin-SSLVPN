<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class facility extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'fid' => 0,
				'name' => '',
				'describe' => '', 
				'ip' => '',
				'port' => '',
				'community' => '',
				'type' => 0,
				'addtime' => '',
				'updatetime' => '',
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
		else if($data_index == 'name') {
			if(strlen($data_data) < 2) {
				$this->set_err('设备名过短');
				$flag = false;
			}
		}
		else if($data_index == 'port') {
			if(!is_numeric($data_data)) {
				//$this->set_err('端口必须为数字');
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
