<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class countlogs_day_detailed extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'seq' => 0,
				'host' => '',
				'date' => '', 
				'debug' => '',
				'info' => '',
				'notice' => '',
				'warning' => '',
				'err' => '',
				'crit' => '',
				'alert' => '',
				'emerg' => '',
				'actionlog' => '',
				'alllog' => '',
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
