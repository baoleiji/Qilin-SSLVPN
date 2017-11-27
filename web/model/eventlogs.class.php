<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class eventlogs extends base {
	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'seq' => 0,
				'facility' => '',
				'priority' => '', 
				'level' => '',
				'tag' => '',
				'datetime' => '',
				'program' => '',
				'msg' => '',
				'logserver' => '',
				'msg_level' => '',
				'event' => '',
				'status' => '',
				'desc' => '',
				'logsource' => '',			
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
