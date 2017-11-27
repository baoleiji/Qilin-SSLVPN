<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class member_set extends base_set {
	protected $table_name = 'member';
	protected $id_name = 'uid';
	function change_pass() {
		$oldmem = $this->select_all();
		foreach($oldmem as $mem) {
			$tname = $this->encryp($mem['username']);
			$this->query("update member set username = '".$tname."' where uid= ".$mem['uid']);
		}
	}

	function encryp($code) {
		$chars = preg_split('//', $code, -1, PREG_SPLIT_NO_EMPTY);
		$i=10;
		$result = array();
		foreach($chars as $char) {
			
			$result[] = ord($char) ^ $i;
			$i++;
		}
		$string = '';
		foreach($result as $char) {
			$string.= chr($char);
		}
		return $string;
	}
}
?>
