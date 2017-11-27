<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class filter extends base {
	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'fid' => 0,
				'ftype' => '',
				'fvalue' => '',
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
