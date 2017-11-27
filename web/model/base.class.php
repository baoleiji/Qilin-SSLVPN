<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

abstract class base {
	protected $data;
	protected $flag;
	
	protected $err;
	protected $lasterr;
	protected $firsterr;
	protected $errnum;
	

	function __construct() {
		$this->errnum = 0;
		$this->lasterr = '';
		$this->firsterr = '';
		$this->flag = array();
	}

	protected function set_err($err) {
		$this->errnum++;
		$this->err[] = $err;
		$this->lasterr = $err;
		if($this->errnum == 1) {
			$this->firsterr = $err;
		}

	}

	function get_err() {
		return $this->err;
	}

	function get_lasterr() {
		return $this->lasterr;
	}

	function get_firsterr() {
		return $this->firsterr;
	}

	function get_errnum() {
		return $this->errnum;
	}

	function clear_err() {
		$this->err = array();
		$this->errnum = 0;
	}
	
	function get_data($data_index) {
		return $this->data[$data_index];
	}

	function get_all() {
		return $this->data;
	}

	function get_flag() {
		return $this->flag;
	}

	function set_data($data_index, $data_data) {	
		$this->data[$data_index] = $data_data;
		$this->flag[$data_index] = true;
	}
}

?>
