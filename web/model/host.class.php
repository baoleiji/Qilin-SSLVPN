<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class host extends base {
	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'hid' => 0,
				'hname' => '',
				'hostname' => '', 
				'system' => '',
				'group' => '',
				'support_company' => '',
				'asset_start' => '',
				'asset_usedtime' => '',
				'asset_warrantdate' => '',
				'asset_sn' => '',
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
