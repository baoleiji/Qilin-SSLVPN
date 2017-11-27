<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class usbkey_set extends base_set {
	protected $table_name = 'radkey';
	protected $id_name = 'id';

	public function used($id) {
		$query = "UPDATE `$this->table_name` SET isused = 1 WHERE id = $id ";
		$this->query($query);

	}

	public function release($id) {
		$query = "UPDATE `$this->table_name` SET isused = 0 WHERE id = $id ";
		$this->query($query);
	}
	
	public function remove($id) {
		$query = "UPDATE device SET pc_id = 0 WHERE pc_id = $id";
		$this->query($query);
	}

	public function add_key($name,$kid) {
		$query = "UPDATE device SET pc_id = $kid WHERE UserName = '$name'";
		$this->query($query);
	}
}
?>