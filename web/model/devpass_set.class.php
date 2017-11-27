<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class devpass_set extends base_set {
	protected $table_name = 'devices';
	protected $id_name = 'id';

	function bind_user($uid,$pass) {
		if(0 != count($pass)) {
			$tid = $uid.',';
			$tpass = implode(',',$pass);
			$this->query("UPDATE $this->table_name SET luser = concat(luser,'$tid') WHERE id IN ($tpass)");
		}
	}

	function remove_bind($uid,$pid,$old_arr) {
		$old_arr = explode(',',$old_arr);
		echo $uid.'<br>';
		unset($old_arr[array_search($uid,$old_arr)]);
		$old_arr = implode(',',$old_arr);
		$this->query("UPDATE $this->table_name SET luser = '$old_arr' WHERE id = $pid");
	}

	function update_server($dev, $old_dev=null) {
		$old_hostname = $old_dev['hostname'];
		$old_device_type = $old_dev['device_type'];
		$hostname = $dev->get_data('hostname');
		//$login_method = $dev->get_data('login_method');
		$ip = $dev->get_data('device_ip');
		$device_type = $dev->get_data('device_type');
		//$port = $dev->get_data('port');
		$this->query("UPDATE $this->table_name SET hostname = '$hostname' , device_type = $device_type WHERE device_ip = '$ip' and hostname='$old_hostname' and device_type='$old_device_type'");
	}
}