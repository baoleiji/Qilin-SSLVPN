<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_about extends c_base {
	function index() {
		$this->display('about.tpl');
	}	
}
?>
