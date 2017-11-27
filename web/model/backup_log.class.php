<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class backup_setting extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'seq' => 0,
				'ip' => '',
				'dblog' => 0,
				'filelog' => 0,
				'starttime' => '',
				'endtime' => ''
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
