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
				'port' => 0,
				'dbactive' => 0,
				'fileactive' => 0,
				'user' => '',
				'mysqluser' => '',
				'passwd' => '',
				'mysqlpasswd' => ''
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
