#!/usr/bin/php
<?php
function get_ran_radkey($username)
{
	$conn = mysql_connect("localhost", "root", "");
	if(!$conn)
	{   
		echo "Unable to connect to DB: " . mysql_error();
	}   
	if (!mysql_select_db("testr"))
	{
		echo "Unable to select testr".mysql_error();
	}
	$sql = "select pc_index from radkey where id = (select pc_id from device where username='".$username."');";

	$result = mysql_query($sql);
	if(!$result)
	{
		echo "Could not successfully run query ($sql) from DB: " . mysql_error();
		exit;
	}

	if(mysql_num_rows($result) == 0)
	{
		echo "$username not in DB\n";
		exit;
	}
	
	$pc_index;
	while ($row = mysql_fetch_assoc($result)) {
		$pc_index = $row["pc_index"];
	}
	mysql_free_result($result);

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

print get_ran_radkey("qi")."\n";
?>
