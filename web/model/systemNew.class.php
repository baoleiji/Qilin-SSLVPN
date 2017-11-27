<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class systemNew extends base {
	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'sid' => 0,
				'msg' => null,
				'level' => null,
				'priority' => '',
				'desc' => '',

			'process' => '',
			'realtime' => '',
			'facility' => '',
			'host' => '',
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
	}

}

?>
