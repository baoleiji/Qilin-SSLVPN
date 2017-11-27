<?php
$server = "localhost";
$user="root";
$pwd="";
$db="audit_sec";



$link = mysql_connect($server, $user,$pwd) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("set names utf8") or die(mysql_error());

while(1)
{
	$username =  substr(getcwd(),6);

	$sql = "SELECT * FROM devices d WHERE INSTR( luser, ( SELECT concat( ',', m.uid, ',' ) FROM member m WHERE m.username = '$username' ) ) AND login_method IN (SELECT id FROM login_template WHERE (login_method='ssh' or login_method='telnet') AND device_type='') GROUP BY d.device_ip";
	$rs = mysql_query($sql,$link);
	while($row=mysql_fetch_array($rs)) $data1[]=$row;
	
	print 'Server List'."\n";
	if(empty($data1)) echo 'Has no any server!'."\n";
	for($i=0; $i<count($data1); $i++){
		print "\t".'[ '.$i.' ]';
		print $data1[$i][device_ip];
		print "\n";
	}
	print 'Choose your ip:';
	$fh = fopen('php://stdin','r'); 
	echo $choice=trim(fgets($fh)); 
	fclose($fh); 
	$selectedip=$data1[$choice][device_ip];
	
	$sql2 = "SELECT d.username,l.login_method,d.port FROM devices d LEFT JOIN login_template l ON d.login_method=l.id WHERE (l.login_method='ssh' or l.login_method='telnet') AND l.device_type='' AND device_ip='".$selectedip."'";
	$rs2 = mysql_query($sql2,$link);
	while($row=mysql_fetch_array($rs2)) $data2[]=$row;
	print ':'."\n";
	for($j=0; $j<count($data2); $j++){
		print "\t".'[ '.$j.' ]';
		print $data2[$j][username];
		for($i=20-strlen($data2[$j][username]); $i>0; $i--)
		print " ";
		print $data2[$j][login_method];
		print "\n";
	}
	print 'Account:';
if(empty($data2)) echo 'has no account'."\n";
	$fh = fopen('php://stdin','r'); 
	$choice=trim(fgets($fh)); 
	fclose($fh);
	
	$loginname = $data2[$choice][username];
	$login_method = $data2[$choice][login_method];
	$port  = $data2[$choice][port];
/*
	$sql3 = "SELECT lt.login_method,d.port  FROM devices d LEFT JOIN login_template lt ON d.login_method=lt.id WHERE device_ip='".$selectedip."' GROUP BY lt.login_method";
	$rs3 = mysql_query($sql3,$link);
	while($row=mysql_fetch_array($rs3)) $data3[]=$row;
	$login_method = $data3[0][login_method];
	$port  = $data3[0][port];
	if(mysql_num_rows($rs3)>1){
		
		print 'Login method:'."\n";
		for($j=0; $j<count($data3); $j++){
			print "\t".'[ '.$j.' ]';
			print $data3[$j][username];
			print "\n";
		}
		print 'Choose method:';
		$fh = fopen('php://stdin','r'); 
		$choice=trim(fgets($fh)); 
		fclose($fh);
		$login_method = $data3[$choice][login_method];
		$port  = $data3[$choice][port];
	}
	*/
	if($login_method=='telnet'){
//		print "Command:telnet ".$selectedip."  ".$port." -l ".$loginname."\n";
		system("telnet ".$selectedip."  ".$port." -l ".$loginname);
	}elseif ($login_method=='ssh'){
//		print "Command:ssh -l ".$loginname ."  ".$selectedip." -p ".$port."\n";
		system("ssh -l ".$loginname ."  ".$selectedip." -p ".$port);
	}
	unset($data1);
	unset($data2);
}
?>
