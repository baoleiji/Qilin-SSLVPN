<?php
function dump($a){
	echo '<pre>';var_dump($a);echo '</pre>';
}

function is_email($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

function is_ip($ip) {
	return (!strcmp(long2ip(sprintf("%u",ip2long($ip))),$ip));
}

function is_domain($domain) {
	return preg_match("/^[\w\-]+(\.\w+)+$/", $domain);
}

function validateIPv6($IP) 
{ 
	return preg_match('/\A 
		(?: 
		(?: 
		(?:[a-f0-9]{1,4}:){6} 
		| 
		::(?:[a-f0-9]{1,4}:){5} 
		| 
		(?:[a-f0-9]{1,4})?::(?:[a-f0-9]{1,4}:){4} 
		| 
		(?:(?:[a-f0-9]{1,4}:){0,1}[a-f0-9]{1,4})?::(?:[a-f0-9]{1,4}:){3} 
		| 
		(?:(?:[a-f0-9]{1,4}:){0,2}[a-f0-9]{1,4})?::(?:[a-f0-9]{1,4}:){2} 
		| 
		(?:(?:[a-f0-9]{1,4}:){0,3}[a-f0-9]{1,4})?::[a-f0-9]{1,4}: 
		| 
		(?:(?:[a-f0-9]{1,4}:){0,4}[a-f0-9]{1,4})?:: 
		) 
		(?: 
		[a-f0-9]{1,4}:[a-f0-9]{1,4} 
		| 
		(?:(?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\.){3} 
		(?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5]) 
		) 
		| 
		(?: 
		(?:(?:[a-f0-9]{1,4}:){0,5}[a-f0-9]{1,4})?::[a-f0-9]{1,4} 
		| 
		(?:(?:[a-f0-9]{1,4}:){0,6}[a-f0-9]{1,4})?:: 
		) 
		)\Z/ix', 
		$IP 
	); 
} 

function is_mobile($mobile) {
	return strlen($mobile) == 11 && preg_match("/^1[0-9]{10}$/", $mobile);
}


function get_sess_username( $data, $name = 'ADMIN_USERNAME', $vtype = 's' )
{
    if(  strlen( $data) == 0)
    {
        return '';
    }
    $name_pos = strpos($data,$name);
	if($name_pos===false){
		return '';
	}
	if($vtype=='i'){
		$aftername1 = strpos($data, ':', $name_pos)+1;
		$aftername2 = strpos($data, ';', $aftername1);
		return substr($data, $aftername1, $aftername2-$aftername1);		
	}else{
		$aftername1 = strpos($data, '"', $name_pos)+1;
		$aftername2 = strpos($data, '"', $aftername1);
		return substr($data, $aftername1, $aftername2-$aftername1);
	}
   
}

function get_online_number_by_users($username, $max_online_time){
	$session_path = ini_get('session.save_path');
	if(empty($session_path)){
		$session_path = '/tmp';
	}
	$exist_count = 0;
	if ($handle = opendir($session_path)) {
		while (false !== ($file = readdir($handle))) {
			if (substr($file,0,4)=='sess') {
				$sess_content = @file_get_contents($session_path.'/'.$file);
				$uname = get_sess_username($sess_content);
				$online_time = get_sess_username($sess_content,"startonlinetime", 'i');
				//var_dump($online_time);
				//var_dump($uname);
				if($uname==$username&&(time()-$online_time < $max_online_time)){
					$exist_count++;
				}else if($uname==$username){
					//@unlink($session_path.'/'.$file);
				}
			}
		}
		closedir($handle);
	}
	return $exist_count;
}

function get_online_users($username, $max_online_time){
	$session_path = ini_get('session.save_path');
	if(empty($session_path)){
		$session_path = '/tmp';
	}
	$exist_count = 0;
	$user = array();
	/*if($username==$_SESSION['ADMIN_USERNAME']){
		$user[$exist_count]['ssid'] = session_id();
		$user[$exist_count]['ip'] = $_SESSION["ADMIN_IP"];
		$user[$exist_count]['username'] = $_SESSION['ADMIN_USERNAME'];
		$user[$exist_count]['logindate'] = $_SESSION["ADMIN_LOGINDATE"];
		$user[$exist_count]['lastactime'] = date('Y-m-d H:i:s', time());
		$exist_count++;
	}*/
	if ($handle = opendir($session_path)) {
		while (false !== ($file = readdir($handle))) {
			if (substr($file,0,4)=='sess'/*&&substr($file,5)!=session_id()*/) {
				$sess_content = @file_get_contents($session_path.'/'.$file);
				$uname = get_sess_username($sess_content);
				$online_time = get_sess_username($sess_content,"startonlinetime", 'i');
				$testusername = ($uname!="")&&($username=="" ? 1 : $uname==$username);
				if($testusername&&(time()-$online_time < $max_online_time)){
					$user[$exist_count]['ssid'] = substr($file,5);
					$user[$exist_count]['ip'] = get_sess_username($sess_content,"ADMIN_IP");
					$user[$exist_count]['username'] = get_sess_username($sess_content,"ADMIN_USERNAME");
					$user[$exist_count]['level'] = get_sess_username($sess_content,"ADMIN_LEVEL");
					$user[$exist_count]['logindate'] = get_sess_username($sess_content,"ADMIN_LOGINDATE");
					$user[$exist_count]['lastactime'] = date('Y-m-d H:i:s',$online_time);
					$exist_count++;
				}else if($uname==$username){
					//@unlink($session_path.'/'.$file);
				}
			}
		}
		closedir($handle);
	}
	return $user;
}

function offline_user($ssid){
	$session_path = ini_get('session.save_path');
	if(empty($session_path)){
		$session_path = '/tmp';
	}
	return unlink($session_path.'/sess_'.$ssid);
}

function genRandomPassword($len)
{
    $chars = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", 
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", 
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", 
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", 
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", 
        "3", "4", "5", "6", "7", "8", "9" ,"!", "@", "#", "$", "%",
		"^", "&", "*", "(", ")"
    );
    $charsLen = count($chars) - 1;
 
    shuffle($chars);    // 将数组打乱
    
    $output = "";
    for ($i=0; $i<$len; $i++)
    {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
 
    return $output;
 
} 

function genRandomString($len)
{
    $chars = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", 
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", 
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", 
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", 
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", 
        "3", "4", "5", "6", "7", "8", "9"
    );
    $charsLen = count($chars) - 1;
 
    shuffle($chars);    // 将数组打乱
    
    $output = "";
    for ($i=0; $i<$len; $i++)
    {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
 
    return $output;
 
} 

function genRandomDigitalString($len)
{
    $chars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $charsLen = count($chars) - 1;
 
    shuffle($chars);    // 将数组打乱
    
    $output = "";
    for ($i=0; $i<$len; $i++)
    {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
 
    return $output;
 
} 

function language($msg){	
	global $en,$cn;
	$newmsg = $msg;
	if(LANGUAGE == 'cn'){
		return $msg;
	}
	$num = count($cn);
	if($num){
		foreach($cn AS $key => $value){		
			if($value == $msg){
				$newmsg = $en[$key];
			}
		}
	}
	return $newmsg;
} 

function alert_and_back($msg, $url = NULL, $type = 0, $parent=0, $opener=0) {
	if($url == NULL) $url=strip_tags(preg_replace('/<script[^>]*?>.*?<\/script>/si','', preg_replace('/alert\(.*?\)/si','', preg_replace('/prompt\(.*?\)/si','', preg_replace('/confirm\(.*?\)/si','', preg_replace('/(document|window|DOCUMENT|WINDOW)\.[a-zA-Z]+/si','', preg_replace('/(document|window|DOCUMENT|WINDOW)\.[a-zA-Z]+\(.*?\)/si','', $_SERVER['HTTP_REFERER'])))))));
	if(strpos($url,'?'))
	$url .= '&back=1';
	$msg = language($msg);
	if($type == 0) {
		if($parent)
			echo "<script language='javascript'>alert('$msg');window.parent.location.href='$url';</script>";
		elseif($opener)
			echo "<script language='javascript'>alert('$msg');window.opener.location.reload();</script>";
		else
			echo "<script language='javascript'>alert('$msg');location.href='$url';</script>";
	}
	else {
		echo "<script language='javascript'>alert('$msg');history.go(-1);</script>";
	}
}

function prompt($msg, $accurl = NULL, $refuurl= NULL, $returnjs=NULL)
{
	$msg = language($msg);
	if($returnjs){
		echo "if(confirm('".$msg."')) window.loadurl('".$accurl."');else window.loadurl('".$refuurl."')";
		return ;
	}
	echo "<script>if(confirm('".$msg."')) location.href='".$accurl."';else location.href='".$refuurl."'</script>";
}

function alert_and_close($msg, $opener=0) {
	$msg = language($msg);
	if($opener)
		echo "<script language='javascript'>alert('$msg');window.opener.location.reload();window.close();</script>";
	else
		echo "<script language='javascript'>alert('$msg');window.close();</script>";
}

function go_url($url = NULL, $parent=0) {
	if($url == NULL) $url = strip_tags(preg_replace('/<script[^>]*?>.*?<\/script>/si','', preg_replace('/alert\(.*?\)/si','', preg_replace('/prompt\(.*?\)/si','', preg_replace('/confirm\(.*?\)/si','', preg_replace('/(document|window|DOCUMENT|WINDOW)\.[a-zA-Z]+/si','', preg_replace('/(document|window|DOCUMENT|WINDOW)\.[a-zA-Z]+\(.*?\)/si','', $_SERVER['HTTP_REFERER'])))))));;
	if($parent==0)
		echo "<script language='javascript'>location.href='$url';</script>";
	else 
		echo "<script language='javascript'>window.parent.parent.location.href='$url';</script>";
}

function sort_cat($allcat) {
	if(empty($allcat)) return;
	$i = 0;
	while (list($key, $val) = each($allcat)) {
		if($val['parentid'] == 0) {
			for($j = 0, $k = 1; $j < count($allcat); $j++) {
				if($allcat[$j]['parentid'] == $val['catid']) {
					$newcat[$i][$k]['catid'] = $allcat[$j]['catid'];
					$newcat[$i][$k++]['catname'] = $allcat[$j]['catname'];
				}
			}
			$newcat[$i][0]['catid'] = $val['catid'];
			$newcat[$i][0]['catname'] = $val['catname'];
			$i++;
		}
	}
	return $newcat;
}

function daddslashes($string, $force = 0) {
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = htmlspecialchars(addslashes($string));
		}
	}
	return ($string);
}

function get_request($data, $from = 0, $type = 0, $default = NULL) {
	switch($from) {
		case 0: $_from = &$_GET;break;
		case 1; $_from = &$_POST;break;
		case 2; $_from = &$_COOKIE;break;
	}
	
	if(isset($_from[$data])) {
		$return_data = daddslashes($_from[$data]);	
	}
	else {
		$return_data = NULL;
	}
	
	if($type == 0 && !is_numeric($return_data)) {
		return $default == NULL ? 0 : $default;
	}
	else {
		return $return_data == NULL ? $default : $return_data;
	}
}

function is_admin() {
	if(!isset($_SESSION['ADMIN_LEVEL']) || $_SESSION['ADMIN_LEVEL'] != 1) {
		return false;
	}
	else {
		return true;
	}
}

function analyse_from_templet($templet) {
	/*
	$tmp = explode("\n", $templet);
	$config_file_count = $tmp[0];
	$result['config_file_list'] = array();
	$result['state_list'] = array();
	for($i = 1; $i <= $config_file_count; $i++) {
		array_push($result['config_file_list'], $tmp[$i]);
	}
	if(isset($tmp[$tmp[0] + 1])) {
		$state_count = $tmp[$tmp[0] + 1];
	}
	else {
		$state_count = 0;
	}

	for($i = $tmp[0] + 2; $i <= $state_count; $i++) {
		array_push($result['state_list'], $tmp[$i]);
	}
	*/
	//var_dump($templet);
	return unserialize($templet);
}

function analyse_to_templet($config_file_list, $state_list = null) {
	global $_CONFIG;
	$result = array();
	$result['config_file_list'] = array();
	for($i = 0; $i < count($config_file_list); $i++) {
		if(trim($config_file_list[$i]) != '') {
			array_push($result['config_file_list'], $config_file_list[$i]);
		}
	}
	$result['config_file_list'] = array_unique($result['config_file_list']);
	if($state_list != null) {
		$result['state_list'] = array();
		for($i = 0; $i < count($state_list); $i++) {
			if(is_numeric($state_list[$i])) {
				if(array_key_exists($state_list[$i], $_CONFIG['states'])) {
					array_push($result['state_list'], $_CONFIG['states'][$state_list[$i]]['name']);
				}
			}
			else {
				array_push($result['state_list'], $state_list[$i]);
			}
		}
		
		$result['state_list'] = array_unique($result['state_list']);
	}
	return serialize($result);
}

function diff($old, $new) 
{
   # split the source text into arrays of lines
   $t1 = explode("\n", $old);
   $x = array_pop($t1); 
   if ($x > '') $t1[] = "$x\n\\ No newline at end of file";
   $t2 = explode("\n", $new);
   $x = array_pop($t2); 
   if ($x > '') $t2[] = "$x\n\\ No newline at end of file";

   $t1_start = 0; $t1_end = count($t1);
   $t2_start = 0; $t2_end = count($t2);

   # stop with a common ending
   while ($t1_start < $t1_end && $t2_start < $t2_end 
          && $t1[$t1_end-1] == $t2[$t2_end-1]) { $t1_end--; $t2_end--; }

   # skip over any common beginning
   while ($t1_start < $t1_end && $t2_start < $t2_end 
          && $t1[$t1_start] == $t2[$t2_start]) { $t1_start++; $t2_start++; }

   # build a reverse-index array using the line as key and line number as value
   # don't store blank lines, so they won't be targets of the shortest distance
   # search
   for($i = $t1_start; $i < $t1_end; $i++) if ($t1[$i]>'') $r1[$t1[$i]][] = $i;
   for($i = $t2_start; $i < $t2_end; $i++) if ($t2[$i]>'') $r2[$t2[$i]][] = $i;

   $a1 = $t1_start; $a2 = $t2_start;   # start at beginning of each list
   $actions = array();

   # walk this loop until we reach the end of one of the lists
   while ($a1 < $t1_end && $a2 < $t2_end) {
     # if we have a common element, save it and go to the next
     if ($t1[$a1] == $t2[$a2]) { $actions[] = 4; $a1++; $a2++; continue; } 

     # otherwise, find the shortest move (Manhattan-distance) from the
     # current location
     $best1 = $t1_end; $best2 = $t2_end;
     $s1 = $a1; $s2 = $a2;
     while(($s1 + $s2 - $a1 - $a2) < ($best1 + $best2 - $a1 - $a2)) {
       $d = -1;
       foreach((array)@$r1[$t2[$s2]] as $n) 
         if ($n >= $s1) { $d = $n; break; }
       if ($d >= $s1 && ($d + $s2 - $a1 - $a2) < ($best1 + $best2 - $a1 - $a2))
         { $best1 = $d; $best2 = $s2; }
       $d = -1;
       foreach((array)@$r2[$t1[$s1]] as $n) 
         if ($n >= $s2) { $d = $n; break; }
       if ($d >= $s2 && ($s1 + $d - $a1 - $a2) < ($best1 + $best2 - $a1 - $a2))
         { $best1 = $s1; $best2 = $d; }
       $s1++; $s2++;
     }
     while ($a1 < $best1) { $actions[] = 1; $a1++; }  # deleted elements
     while ($a2 < $best2) { $actions[] = 2; $a2++; }  # added elements
  }

  # we've reached the end of one list, now walk to the end of the other
  while($a1 < $t1_end) { $actions[] = 1; $a1++; }  # deleted elements
  while($a2 < $t2_end) { $actions[] = 2; $a2++; }  # added elements

  # and this marks our ending point
  $actions[] = 8;

  # now, let's follow the path we just took and report the added/deleted
  # elements into $out.
  $op = 0;
  $x0 = $x1 = $t1_start; $y0 = $y1 = $t2_start;
  $out = array();
  foreach($actions as $act) {
    if ($act == 1) { $op |= $act; $x1++; continue; }
    if ($act == 2) { $op |= $act; $y1++; continue; }
    if ($op > 0) {
      $xstr = ($x1 == ($x0+1)) ? $x1 : ($x0+1) . ",$x1";
      $ystr = ($y1 == ($y0+1)) ? $y1 : ($y0+1) . ",$y1";
      if ($op == 1) $out[] = "{$xstr}d{$y1}";
      elseif ($op == 3) $out[] = "{$xstr}c{$ystr}";
      while ($x0 < $x1) { $out[] = '< ' . $t1[$x0]; $x0++; }   # deleted elems
      if ($op == 2) $out[] = "{$x1}a{$ystr}";
      elseif ($op == 3) $out[] = '---';
      while ($y0 < $y1) { $out[] = '> '.$t2[$y0]; $y0++; }   # added elems
    }
    $x1++; $x0 = $x1;
    $y1++; $y0 = $y1;
    $op = 0;
  }
  $out[] = '';
  return join("\n",$out);
}

function rsync($ip, $port, $username, $password, $remote_path, $locale_path, &$out) {
	//$cmd = "/usr/bin/sudo /usr/bin/rsync -t --timeout=5 -e 'ssh -p $port' '$username@'$ip:$remote_path $locale_path";
	$cmd = "./do_config/rsync.pl \"$port\" \"$username\" \"$password\" $ip \"$remote_path\" \"$locale_path\"";
	//echo $cmd . '<br/>';
	//die();
	//return;
	$descriptorspec = array(
				0 => array('pipe', 'r'),
				1 => array('pipe', 'w'),
				2 => array('pipe', 'w')
			);

	$process = proc_open($cmd, $descriptorspec, $pipes);
	$return = 0;
	if(is_resource($process)) {
		//fwrite($pipes[0], 'ys');
		//fwrite($pipes[0], $password);
		//fclose($pipes[0]);	
		while(!feof($pipes[2])) {
			$out .= fgets($pipes[2]);
		}
		fclose($pipes[2]);
		
		while(!feof($pipes[1])) {
			$out .= fgets($pipes[1]);
		}
		fclose($pipes[1]);
		$return = proc_close($process);
	}
	else {
		$out = '无法执行命令!';
		$return = -1;
	}
	return $return;
}

function get_by_snmpwalk($ip, $community, $state, &$out, $flag = false) {
	$config = get_config_type_by_name($state);
	if($config) {
		$oid = $config['oid'];
		//@$ret = snmprealwalk($ip, $community, $oid);
		@$ret = my_snmpwalk($ip, $community, $oid, $flag);
		if($ret === false) {
			$out = "无法获取 $state ，服务器没有响应!";
			return -1;
		}
		else {
			$out = $ret;
			return 0;
		}
	}
	else {
		$out = "没有找到 $state 的定义!";
		return -1;
	}
}

function my_snmpwalk($ip, $community, $oid, $flag = false) {
	if($flag == false) {
		$cmd = "snmpwalk -c $community -v 1 $ip $oid -O v 2>&1";
	}
	else {
		$cmd = "snmpwalk -c $community -v 1 $ip $oid 2>&1";
	}
	/*
	$handle = popen($cmd, 'r');
	while(!feof($handle)) {
		$result .= fgets($handle, 4096);
	}
	pclose($handle);
	*/
	$ret = command($cmd, $result);
	if($ret != 0) {	
		return false;
	}
	else {
		return $result;
	}
}

function rm($path) {
	$src = str_replace('..', '', $src);
	$dest = str_replace('..', '', $dest);
	//echo("rm -rf " . DATA_PATH ."$path" . '<br/>');
	system("rm -rf " . DATA_PATH ."$path");
}

function cp($src, $dest) {
	$src = str_replace('..', '', $src);
	$dest = str_replace('..', '', $dest);
	//echo("cp " . DATA_PATH . $src . " " . DATA_PATH . $dest . '<br/>');
	system("cp -f " . DATA_PATH . $src . " " . DATA_PATH . $dest);
}

function type2id($type) {
	if($type == 'snmp') {
		return 1;
	}
	else if($type == 'rsync') {
		return 2;
	}
	else {
		return 0;
	}
}


function get_config_type_by_name($name) {
	global $_CONFIG;
	foreach($_CONFIG['config_type'] as $config_type) {
		if($config_type['name'] == $name) {
			return $config_type;
		}
	}
	return null;
}

function config2name($templet) {
	if(isset($templet['path'])) {
		return base64_encode($templet['name']) . '@'. base64_encode($templet['path']);
	}
	else {
		return base64_encode($templet['name']); 
	}
}

function name2config($filename) {
	if(($pos = strpos($filename, '@')) !== false) {
		$name = substr($filename, 0, $pos);
		$path = substr($filename, $pos + 1);
		return array(
					'name' => base64_decode($name),
					'path' => base64_decode($path),
				);
	}
	else {
		return array(
				'name' => base64_decode($filename),
				);
	}
}


function command($cmd, &$out) {
	$descriptorspec = array(
				0 => array('pipe', 'r'),
				1 => array('pipe', 'w'),
				2 => array('pipe', 'w'),
				3 => array('pipe', 'w')
			);
	//echo "$cmd\n";
	$cmd =  "( $cmd ) 3>/dev/null; echo \$? >&3\n";
	$process = proc_open($cmd, $descriptorspec, $pipes);
	$return = 0;
	$out = '';
	if(is_resource($process)) {
		$return = (int) str_replace("\n","",stream_get_contents($pipes[3]));
		while(!feof($pipes[2])) {
			$out .= fgets($pipes[2]);
		}
		fclose($pipes[2]);
		
		while(!feof($pipes[1])) {
			$out .= fgets($pipes[1]);
		}
		fclose($pipes[1]);
		fclose($pipes[0]);
		fclose($pipes[3]);
		proc_close($process);

	}
	else {
		$out = '无法执行命令!';
		$return = -1;
	}
	return $return;
}



function encrypt($encrypt,$key="DESS") { 
		$iv = mcrypt_create_iv ( mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ), MCRYPT_RAND ); 
		$passcrypt = mcrypt_encrypt ( MCRYPT_RIJNDAEL_256, $key, $encrypt, MCRYPT_MODE_ECB, $iv ); 
		$encode = base64_encode ( $passcrypt ); 
		return $encode; 
	} 

	function ipMatch($network, $ip){
	list ($net, $mask) = explode ('/', $network);
	if (is_numeric($mask)) {
		$result = (ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == ip2long($net);
	}else{     
		$result = (ip2long($ip) & ip2long($mask)) == (ip2long($net) & ip2long($mask));
    } 
	return $result;
}


//返回文件从X行到Y行的内容(支持php5、php4)
function getFileLines($filename, $startLine = 1, $endLine=50, $search=null, $method='rb') 
{
	$content = array();
	$count = $endLine - $startLine;
	if(version_compare(PHP_VERSION, '5.1.0', '>=')){// 判断php版本（因为要用到SplFileObject，PHP>=5.1.0）       
		$fp = new SplFileObject($filename, $method);       
		$fp->seek($startLine-1);// 转到第N行, seek方法参数从0开始计数               
		for($i = 0; $i <= $count; ++$i) {         
			$content[]=$fp->current();// current()获取当前行内容                    
			if(!empty($search)&&strpos($content[count($content)-1], $search)!==false) return true;
			$fp->next();// 下一行 
		}
	}else{//PHP<5.1
		$fp = fopen($filename, $method);
		if(!$fp) return 'error:can not read file';
		for ($i=1;$i<$startLine;++$i) {// 跳过前$startLine行
			fgets($fp);
		}
		for($i;$i<=$endLine;++$i){
			$content[]=fgets($fp);// 读取文件行内容                
			if(!empty($search)&&strpos($content[count($content)-1], $search)!==false) return true;
		}
		fclose($fp);
	}
	return array_filter($content); // array_filter过滤：false,null,''
}

function rfts( $strFileName, $intLines = 0, $intBytes = 4096, $booErrorRep = true ) {
	$strFile = "";
	$intCurLine = 1;
  
	if( file_exists( $strFileName ) ) {
		if( $fd = fopen( $strFileName, 'r' ) ) {
			while( !feof( $fd ) ) {
				$strFile .= fgets( $fd, $intBytes );
				if( $intLines <= $intCurLine && $intLines != 0 ) {
					break;
				} else {
					$intCurLine++;
				}
			}
			fclose( $fd );
		} else {
			return "ERROR";
		}
	} else {
		return "ERROR";
	}
	
	return $strFile;
}

function uptime( $intTimestamp,$_text="" ) {
	$strUptime = '';
    
	$intMin = $intTimestamp / 60;
	$intHours = $intMin / 60;
	$intDays = floor( $intHours / 24 );
	$intHours = floor( $intHours - ( $intDays * 24 ) );
	$intMin = floor( $intMin - ( $intDays * 60 * 24 ) - ( $intHours * 60 ) );
	
	if( $intDays != 0 ) {
		$strUptime .= $intDays. "&nbsp;天&nbsp;";
	}
	if( $intHours != 0 ) {
		$strUptime .= $intHours . "&nbsp;小时&nbsp;";
	}
	$strUptime .= $intMin . "&nbsp;分钟";
	
	return $strUptime;
}

 /**
 *
 * @统计文件行数
 * @param string filepath 
 * @return int
 * @edit www.jbxue.com
 */
 function countLines($filepath) 
 {
    /*** open the file for reading ***/
    $handle = fopen( $filepath, "r" );
    /*** set a counter ***/
    $count = 0;
    /*** loop over the file ***/
    while( fgets($handle) ) 
    {
        /*** increment the counter ***/
        $count++;
    }
    /*** close the file ***/
    fclose($handle);
    /*** show the total ***/
    return $count;
 }

 function validateDate($date, $format = 'Y-m-d H:i:s')
 {
     $d = DateTime::createFromFormat($format, $date);
     return $d && $d->format($format) == $date;
 }

 function asyncAccount($asyncCommand)
{
	//echo("客户端发送命令: " . $asyncCommand . "<br/>"); 
	$serverIP;//服务端IP
	$serverPort;//服务端端口
	$commandArray=explode(" ",$asyncCommand);//命令参数拆分到数组中，用于获取IP和端口
	$commandArrayLength=count($commandArray); //命令参数长度
	if($commandArrayLength<2 ||$commandArrayLength>5||$commandArray[0]!=="async" || $commandArray[2]!=8888){
		//echo "参数非法!\n";
		return -1;
	}
	else 
	{
		set_time_limit(0); //无超时限制，可以自定义修改
		$serverIP=$commandArray[1];
		$serverPort=$commandArray[2];
		//建一个Socket 
		$socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>20, "usec"=>0));
		socket_set_option($socket,SOL_SOCKET, SO_SNDTIMEO, array("sec"=>20, "usec"=>0));
		if(!$socket){
			//echo '创建失败';
			return -2;
		}
		//建立一个连接
		$connection = @socket_connect($socket, $serverIP, $serverPort);   
		if(!$connection){
			//echo '连接失败';
			return -3;
		}
		//数据传送  向服务器发送消息  
		@socket_write($socket, $asyncCommand) ;  

		
		//接收来自服务器的反馈
		$buffer = @socket_read($socket, 1024);
		//echo("服务端执行结果: " . $buffer . "<br/>"); 
		//关闭socket
		@socket_shutdown($socket);
		@socket_close($socket);
	}
	return $buffer;
}

function subUTF8($string, $length = 80, $etc = '..')
{
	$strcut = '';
	$strLength = 0;
	$width  = 0;
	if(strlen($string) > $length) {
	  //将$length换算成实际UTF8格式编码下字符串的长度
	  for($i = 0; $i = strlen($string);$i++){
	   if ( $width>=$length){
		break;
	   }
	   //当检测到一个中文字符时
	   if( ord($string[$strLength]) > 127 ){
		$strLength += 3;
		$width     += 2;              //大概按一个汉字宽度相当于两个英文字符的宽度
	   }
	   else{
		$strLength += 1;
		$width     += 1;
	   }
	  }
	  return substr($string, 0, $strLength).$etc;
	} else {
	  return $string;
	}
}

function netMatch($IP, $CIDR) {  
  list ($net, $mask) = explode('/', $CIDR);  
  $mask = (empty($mask) ? 32 : $mask);
  return ( ip2long($IP) & ~((1<<(32-$mask))-1))== ip2long($net);  
}


if(!function_exists(strifSize)){
	function strifSize($value){
		if($value < 1000){
			$value=round($value,2);
		}
		if($value>1000 && $value < 1000*1000){
			$value=round(($value/1000),2).'k';
		}
		if($value>1000*1000 && $value < 1000*1000*1000){
			$value=round(($value/(1000*1000)),2).'M';
		}
		if($value>1000*1000*1000 && $value < 1000*1000*1000*1000){
			$value=round(($value/(1000*1000*1000)),2).'G';
		}
		return $value;
	}
}

function unescape($str) 
{ 
    $ret = ''; 
    $len = strlen($str); 
    for ($i = 0; $i < $len; $i ++) 
    { 
        if ($str[$i] == '%' && $str[$i + 1] == 'u') 
        { 
            $val = hexdec(substr($str, $i + 2, 4)); 
            if ($val < 0x7f) 
                $ret .= chr($val); 
            else  
                if ($val < 0x800) 
                    $ret .= chr(0xc0 | ($val >> 6)) . 
                     chr(0x80 | ($val & 0x3f)); 
                else 
                    $ret .= chr(0xe0 | ($val >> 12)) . 
                     chr(0x80 | (($val >> 6) & 0x3f)) . 
                     chr(0x80 | ($val & 0x3f)); 
            $i += 5; 
        } else  
            if ($str[$i] == '%') 
            { 
                $ret .= urldecode(substr($str, $i, 3)); 
                $i += 2; 
            } else 
                $ret .= $str[$i]; 
    } 
    return $ret; 
}


function InitialFile($root='.',$ext='')
{//var_dump($root);var_dump($ext);
	if(!is_dir($root)) return ;
	$files = array();
	if(!$handle=opendir($root)){
		echo 'read failed';
		return ;
	}
	while($file=readdir($handle)){
		if($file=='.'||$file=='..') continue;
		if(is_dir($root.'/'.$file)){
			$tmpfile=InitialFile($root.'/'.$file,$ext);
			for($i=0; $i<count($tmpfile); $i++){
				$files[] = $tmpfile[$i];
			}
			continue;
		}//var_dump($file);var_dump(substr($file, strrpos($file, '.')+1));var_dump($ext);var_dump(substr($file, strrpos($file, '.')+1)==$ext);
		if($ext&&substr($file, strrpos($file, '.')+1)==$ext){
			$files[] = $root.'/'.$file;
		}elseif(empty($ext)){
			$files[] = $root.'/'.$file;
		}
	}
	return $files;
}

function _encrypt($string,$operation,$key=''){ 
    $key=md5($key); 
    $key_length=strlen($key); 
      $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string; 
    $string_length=strlen($string); 
    $rndkey=$box=array(); 
    $result=''; 
    for($i=0;$i<=255;$i++){ 
           $rndkey[$i]=ord($key[$i%$key_length]); 
        $box[$i]=$i; 
    }
    for($j=$i=0;$i<256;$i++){
        $j=($j+$box[$i]+$rndkey[$i])%256; 
        $tmp=$box[$i]; 
        $box[$i]=$box[$j]; 
        $box[$j]=$tmp; 
    }
    for($a=$j=$i=0;$i<$string_length;$i++){ 
        $a=($a+1)%256; 
        $j=($j+$box[$a])%256; 
        $tmp=$box[$a]; 
        $box[$a]=$box[$j]; 
        $box[$j]=$tmp; 
        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256])); 
    }
    if($operation=='D'){ 
        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){ 
            return substr($result,8); 
        }else{ 
            return''; 
        }
    }else{ 
        return str_replace('=','',base64_encode($result)); 
    }
}

function getBrowser(){
	$agent=$_SERVER["HTTP_USER_AGENT"];
	if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
		return "ie";
	else if(strpos($agent,'Firefox')!==false)
		return "firefox";
	else if(strpos($agent,'Chrome')!==false)
		return "chrome";
	else if(strpos($agent,'Opera')!==false)
		return 'opera';
	else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
		return 'safari';
	else
		return 'unknown';
}

function getBrowserVer(){
	if (empty($_SERVER['HTTP_USER_AGENT'])){    //当浏览器没有发送访问者的信息的时候
		return 'unknow';
	}
	$agent= $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))
		return $regs[1];
		elseif (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))
		return $regs[1];
		elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs))
		return $regs[1];
		elseif (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))
		return $regs[1];
		elseif ((strpos($agent,'Chrome')==false)&&preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs))
		return $regs[1];
		else
			return 'unknow';
}


function loading_start(){
echo <<<HTML
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="./template/admin/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./template/admin/cssjs/jquery-1.10.2.min.js"></script>

<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script type="text/javascript">
var isIe=(document.all)?true:false;
function closeWindow()
{
	if(document.getElementById('back')!=null)
	{
		document.getElementById('back').parentNode.removeChild(document.getElementById('back'));
	}
	if(document.getElementById('mesWindow')!=null)
	{
		document.getElementById('mesWindow').parentNode.removeChild(document.getElementById('mesWindow'));
	}
	document.getElementById('fade').style.display='none';
}

function showImg(wTitle, c, width)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=400;
	var wHeight=120;
	var bWidth=parseInt(w=window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth);

	var bHeight=parseInt(window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight)+20;
	bHeight=700+20;
	var back=document.createElement("div");
	back.id="back";
	var styleStr="top:0px;left:0px;position:absolute;width:"+bWidth+"px;height:"+bHeight+"px;z-index:1002;overflow-x: hidden; overflow-y: hidden; ";
	//styleStr+=(isIe)?"filter:alpha(opacity=0);":"opacity:0;";
	back.style.cssText=styleStr;
	document.body.appendChild(back);
	var mesW=document.createElement("div");
	mesW.id="mesWindow";
	mesW.className="mesWindow";
	mesW.innerHTML='<div id="light" class="white_content" style="overflow-x: hidden; overflow-y: hidden;height:120px;width:'+width+'px"><img src="./template/admin/images/loading2.gif" /></div>';
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
	
	document.getElementById('fade').style.display='block'
	return false;
}

</script>
</head>

<body>
<div id="fade" class="black_overlay"></div> 
<script >
	showImg('','',300);
</script>
HTML;
	flush();
}

function loading_end(){
echo <<<HTML
<script >
	closeWindow()
</script>
HTML;

}

?>