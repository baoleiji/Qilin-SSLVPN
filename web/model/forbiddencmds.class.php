<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class forbiddencmds extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'cid' => 0,
				'addr' => '',
				'cmd' => '', 
				'radius_user' => 0,
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
