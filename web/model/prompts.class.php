<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class prompts extends base {

	function __construct($data = NULL) {
		parent::__construct();
		if($data == NULL) {
			$this->data = array (
				'id'	=> 0,
				'ip'	=> '',
				'start' => '', 
				'end1'	=> '',
				'end2'	=> '',
				'end3'	=> '',
				'end4'	=> '',
				'end5'	=> '',
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
	function base_select($sql)
	{
		$this->base_select($sql);
	}
}

?>
