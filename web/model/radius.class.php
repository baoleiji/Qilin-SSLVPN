<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class radius extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'id' => 0,
				'UserName' => '',
				'Attribute' => '', 
				'op' => ':=',
				'Value' => '',
				'email' => 0,
				'day' => 0,
				'enable' => 1,
				'logintime' => 0,
				'lastdate' => '0000-00-00'
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
