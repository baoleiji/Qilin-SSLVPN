<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class compare extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'id' => 0,
				'conn_type' => 0,
				'dev_type'	=> '',
				'ip' => '',
				'port' => 22,
				'user_username'	=>	'',
				'user_pass' => '',
				'enable_pass' => '',
				'template' => 0,
				'diff' => 0,
				'detail' => '',
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
