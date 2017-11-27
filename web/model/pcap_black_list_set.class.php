<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class pcap_black_list_set extends base_set {
	protected $table_name = 'pcap_black_list';
	protected $id_name = 'id';

}
?>
