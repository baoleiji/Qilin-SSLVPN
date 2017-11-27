<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class backup extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'id' => 0,
				'device_id' => 0,
				'file_path' => '', 
				'is_modified' => 0,
				'last_modified_time' => '0000-00-00 00:00:00',
				'mail_id' => 0
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
