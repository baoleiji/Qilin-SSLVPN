<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class config extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'cid' => 0,
				'fid' => 0,
				'interface' => '',
				'name' => '',
				'default' => '',
				'attributes' => '',
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

		 if($data_index == 'name') {
			if(strlen($data_data) < 2) {
				$this->set_err('设备名过短');
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
