<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class slaveserver extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'sid' => 0,
				'ip' => '',
				'hostname' => '', 
				'desc' => '',
				'datetime' => '',
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
