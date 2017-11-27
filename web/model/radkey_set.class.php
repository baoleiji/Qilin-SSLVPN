<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class radkey_set extends base_set {
	protected $table_name = 'radkey';
	protected $id_name = 'id';
	
	
function get_ran_radkey($username)
	{
		$where = " id = (select pc_id from device where username='".$username."') ";
		//$sql = "select pc_index from radkey where id = (select pc_id from device where username='".$username."');";
		$rs = $this->select_all($where);
		if(!empty($rs) || $rs[0][pc_index] > 0){
			$pc_index = $rs[0][pc_index];
		}else{
			return '';
		}
		
	
		$time = date("YmdHi");
		$sec = date("s");
	
		if($sec<20)
		{
			$sec = "00";
		}
		else if($sec < 40)
		{
			$sec = "20";
		}
		else
		{
			$sec = "40";
		}
		$time = $time.$sec;
		/*
		print $time."\n";
		print $pc_index."\n";
		print substr($pc_index,0,-4)."\n";
		print substr($pc_index,0,-4).$time."\n";
		*/
		$pc_index_utf16 = substr(mb_convert_encoding(substr($pc_index,0,-4),"UTF-16","ASCII"),1);
		$time_utf16 = substr(mb_convert_encoding($time,"UTF-16","ASCII"),1);
		$pc_index_utf16.="\0";
		$time_utf16.="\0";
	#	print $pc_index_utf16."\n";
	#	print $time_utf16."\n";
		return substr(strtolower(md5($pc_index_utf16.$time_utf16)),0,6);
	}
}
?>
