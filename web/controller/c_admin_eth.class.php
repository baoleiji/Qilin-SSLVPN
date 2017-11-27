<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_eth extends c_base {

	function index() {
		//$filename = '/opt/vpn/etc/server.conf';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];
		
		$lines = @file($filename);
		$new_port = 1111;
		$new_proto = 'proto';
		$new_dev = 'dev';
		if(!$lines) {
			alert_and_back("文件不存在或没有权限");
			exit;
		}
		foreach ($lines as $line_num => $line) {
    			echo "Line #<b>{$line_num}</b> : " . $line . "<br>\n";
		}
		$port = explode(' ',$lines[0]);
		$proto = explode(' ',$lines[1]);
		$dev = explode(' ',$lines[2]);
		$ctoc = $lines[3];
		$server = explode('=',$lines[8]);
		$default_route = explode('=',$lines[10]);
		$dns_t = explode('"',$lines[11]);
		$wins_t = explode('"',$lines[12]);
		$dns = explode(' ',$dns_t[1]);
		$$wins = explode(' ',$wins_t[1]);

		$port[1] = $new_port."\n";
		$proto[1] = $new_proto."\n";
		$dev[1] = $new_dev."\n";

		$pos = strrpos($ctoc, ";");
		if ($pos === false) {
			$ctoc = ';'.$ctoc;
		}
		else {
			$ctoc = substr($ctoc, 1);
		}

		$lines[0] = implode(' ',$port);
		$lines[1] = implode(' ',$proto);
		$lines[2] = implode(' ',$dev);
		$lines[3] = $ctoc;

		$this->Array2File($lines,$filename);

	}

	function route_list() {
			
			global $_CONFIG;
			$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];
			//$filename = './controller/server.conf';
		
			$lines = @file($filename);
			if(!$lines) {
				alert_and_back("配置文件不存在或没有权限",'admin.php?controller=admin_index',1);
				exit;
			}
			$routes = array();
			$i = 0;
			$key1 = array();
			$key2 = array();
			foreach($lines as $line){
				if(preg_match("/\"route /",$line)==1) {
					$t_route = explode('"',$line); 
					$route = explode(' ',$t_route[1]);
					$routes[$i]['id']= $i;
					$routes[$i]['ip']= $route[1];
					$routes[$i]['netmask']= $route[2];
					$key1[]=$route[1];
					$key2[]=$route[2];
					$i++;
				}
			}
			array_multisort($key1,SORT_ASC,$key2,SORT_ASC,$routes);
			$this->assign('routes',$routes);
			$this->display('routes_list.tpl');
	}

	function route_edit(){
		$this->display("routes_edit.tpl");
	}

	function route_add() {
		$ip = get_request('ip',1,1);
		$netmask = get_request('netmask',1,1);
		//$filename = '/opt/vpn/etc/server.conf';

		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];
		//$filename = './controller/server.conf';
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back('配置文件不存在或没有权限','admin.php?controller=admin_index',1);
			exit;
		}
		if(!is_ip($ip)||!is_ip($netmask)){
			alert_and_back('请输入正确的IP或掩码地址格式');
			exit;
		}
		$newline = "push \"route $ip $netmask\"\n";
		for($i = count($lines);$i > 0;$i--) {
			if(preg_match("/\"route /",$lines[$i])==1) {
				break;
			}
		}
		array_splice ($lines, $i+1, 0, $newline);
		$this->Array2File($lines,$filename);
		$out = '';
		system('sudo /opt/freesvr/audit/sbin/manageprocess.pl vpn stop ',$out);
		system('sudo /opt/freesvr/audit/sbin/manageprocess.pl vpn start ',$out);
		alert_and_back('添加成功','admin.php?controller=admin_eth&action=route_list');	
	}

	function route_delete() {
		$id = get_request('id');
		//$filename = '/opt/vpn/etc/server.conf';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];
		//$filename = './controller/server.conf';
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back('配置文件不存在或没有权限','admin.php?controller=admin_index',1);
			exit;
		}
		$offset = 0;
		for($i=0;$i<count($lines);$i++){
			if(preg_match("/\"route /",$lines[$i])==1) {
				if($offset==$id) {
					array_splice ($lines, $i, 1);
					break;
				}
				$offset++;
			}
		}
		
		$this->Array2File($lines,$filename);
		$out = '';
		system('sudo /opt/freesvr/audit/sbin/manageprocess.pl vpn stop',$out);
		system('sudo /opt/freesvr/audit/sbin/manageprocess.pl vpn start',$out);
		alert_and_back('删除成功','admin.php?controller=admin_eth&action=route_list');
	
	}


	function vpn_list() {
			
			global $_CONFIG;
			$filename = $_CONFIG['IPTABLES'];
			//$filename = './controller/server.conf';
		
			$lines = @file($filename);
			if(!$lines) {
				alert_and_back("配置文件不存在或没有权限",'admin.php?controller=admin_index',1);
				exit;
			}
			$i = 0;
			$found = false;
			$j=0;
			foreach($lines as $line){
				if(empty($line)){
					continue;
				}elseif(preg_match("/#Firewall-start/",$line)==1) {
					$found=true;
				}elseif(preg_match("/#Firewall-end/",$line)==1){
					break;
				}elseif($found){					
					$all = preg_split("/\-/", $line);
					if(count($all)>2){
						for($i=0; $i<count($all); $i++){
							if(substr($all[$i],0,1)=='s'){
								$s[$j][s_addr] = trim(substr($all[$i],1));
							}elseif(substr($all[$i],0,1)=='d'){
								$s[$j][d_addr] = trim(substr($all[$i],1));
							}elseif(substr($all[$i],0,2)=='to'){
								$s[$j][p_addr] = trim(substr($all[$i],2));
							}
						}
						$j++;
					}
				}
			}
			
			$this->assign('routes',$s);
			$this->display('vpn_list.tpl');
	}

	function vpn_edit(){
		global $_CONFIG;
		$p_addr = get_request('p_addr', 0, 1);
		$filename = $_CONFIG['IPTABLES'];
		//$filename = './controller/server.conf';
	
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back("配置文件不存在或没有权限",'admin.php?controller=admin_index',1);
			exit;
		}
		$i = 0;
		$found = false;
		$j=0;
		if($p_addr)
		foreach($lines as $line){
			if(empty($line)){
				continue;
			}elseif(preg_match("/#Firewall-start/",$line)==1) {
				$found=true;
			}elseif(preg_match("/#Firewall-end/",$line)==1){
				break;
			}elseif($found){
				
				$all = preg_split("/\-/", $line);
				for($i=0; $i<count($all); $i++){
					if(substr($all[$i],0,1)=='s'){
						$s[$j][s_addr] = trim(substr($all[$i],1));
					}elseif(substr($all[$i],0,1)=='d'){
						$s[$j][d_addr] = trim(substr($all[$i],1));
					}elseif(substr($all[$i],0,2)=='to'){
						$s[$j][p_addr] = trim(substr($all[$i],2));
					}
				}
				if($s[$j][p_addr]==$p_addr){					
					$this->assign('p',$s[$j]);
					break;
				}
				$j++;
			}
		}
		$this->display("vpn_edit.tpl");
	}

	function vpn_add() {
		global $_CONFIG;
		$p_addr = get_request('p_addr', 1, 1);
		$s_addr = get_request('s_addr', 1, 1);
		$d_addr = get_request('d_addr', 1, 1);
		$filename = $_CONFIG['IPTABLES'];
		//$filename = './controller/server.conf';
	
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back("配置文件不存在或没有权限",'admin.php?controller=admin_index',1);
			exit;
		}
		$m = 0;
		$found = false;
		$foundp= false;
		$endline = 0;
		$j=0;
		foreach($lines as $line){
			
			if(preg_match("/#Firewall-start/",$line)==1) {
				$found=true;
			}elseif(preg_match("/#Firewall-end/",$line)==1){
				$endline=$m;
			}elseif($found){
				
				$all = preg_split("/\-/", $line);
				for($i=0; $i<count($all); $i++){
					if(substr($all[$i],0,1)=='s'){
						$s[s_addr] = trim(substr($all[$i],1));
					}elseif(substr($all[$i],0,1)=='d'){
						$s[d_addr] = trim(substr($all[$i],1));
					}elseif(substr($all[$i],0,2)=='to'){
						$s[p_addr] = trim(substr($all[$i],2));
					}
				}
				if($s[p_addr]==$p_addr){					
					$lines[$m]="-A POSTROUTING -s ".$s_addr." -d ".$d_addr." -o eth0  -j SNAT --to ".$p_addr."\n";
					$foundp = true;
					break;
				}
				$j++;
			}
			$m++;
		}
		if(!$foundp){
			$lines[$endline-1].="-A POSTROUTING -s ".$s_addr." -d ".$d_addr." -o eth0  -j SNAT --to ".$p_addr."\n";
		}
		//echo '<pre>';var_dump($_POST);echo '</pre>';
		$this->Array2File($lines,$filename);
		exec("sudo /usr/bin/systemctl restart iptables");
		alert_and_back('添加成功','admin.php?controller=admin_eth&action=vpn_list');	
	}

	function vpn_delete() {
		$p_addr = array(urldecode(get_request('p_addr',0,1)));
		global $_CONFIG;
		$filename = $_CONFIG['IPTABLES'];
		//$filename = './controller/server.conf';
		if($_POST['chk_gid']){
			$p_addr = $_POST['chk_gid'];
		}
	
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back("配置文件不存在或没有权限",'admin.php?controller=admin_index',1);
			exit;
		}
		$i = 0;
		$found = false;
		$j=0;
		$ips = array();
		foreach($lines as $line){
			if(empty($line)){
				$ips[]=$line;
				continue;
			}elseif(preg_match("/#Firewall-start/",$line)==1) {
				$ips[]=$line;
				$found=true;
			}elseif(preg_match("/#Firewall-end/",$line)==1){
				$ips[]=$line;
				$found=false;
			}elseif($found){					
				$all = preg_split("/\-/", $line);
				if(count($all)>2){
					for($i=0; $i<count($all); $i++){
						if(substr($all[$i],0,1)=='s'){
							$s[$j][s_addr] = trim(substr($all[$i],1));
						}elseif(substr($all[$i],0,1)=='d'){
							$s[$j][d_addr] = trim(substr($all[$i],1));
						}elseif(substr($all[$i],0,2)=='to'){
							$s[$j][p_addr] = trim(substr($all[$i],2));
						}
					}
					if(!in_array($s[$j][p_addr],$p_addr)){
						$ips[]=$line;
					}
					$j++;
				}
			}else{
				$ips[]=$line;
			}
		}
		//echo '<pre>';var_dump($ips);echo '</pre>';
		$this->Array2File($ips,$filename);
		exec("sudo /usr/bin/systemctl restart iptables");
		alert_and_back('删除成功','admin.php?controller=admin_eth&action=vpn_list');
	
	}
	
	

	
	function vpnconfig(){
		global $_CONFIG;		

		$filename = $_CONFIG['CONFIGFILE']['RADCONF'];
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$R_addr = '';
		foreach($lines as $line){
				if(preg_match("/name=/",$line)==1) {
					$templine = explode('=',$line);
					$R_addr = $templine[1];
				}
				if(preg_match("/sharedsecret=/",$line)==1) {
					$templine = explode('=',$line);
					$R_key = $templine[1];
				}
		}

		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "port"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['port'] = trim($tmp[1]);
				}
				if(strstr(strtolower($lines[$ii]), "server "))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['server1'] = trim($tmp[1]);
					$network['server2'] = trim($tmp[2]);
				}
				if(strstr(strtolower($lines[$ii]), "keepalive"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['keepalive1'] = trim($tmp[1]);
					$network['keepalive2'] = trim($tmp[2]);
				}
				if(strstr(strtolower($lines[$ii]), "max-clients"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['max_clients'] = trim($tmp[1]);
				}
				if(strstr(strtolower($lines[$ii]), "comp-lzo"))
				{					
					$network['comp_lzo'] = substr(trim($lines[$ii]),0,1)==';' ? '0' : '1';
				}
				if(strstr(strtolower($lines[$ii]), "client-to-client"))
				{
					$network['client_to_client'] = substr(trim($lines[$ii]),0,1)==';' ? '0' : '1';
				}
			}
		}
		else
		{
			alert_and_back('配置文件不存在');
			exit;
		}
		unset($lines);

		$this->assign("vpnconfig", $network);		
		$this->assign('addr',$R_addr);
		$this->assign('key',$R_key);
		$this->display('vpnconfig.tpl');
	}

	function vpnconfig_save(){
		global $_CONFIG;
		$port = get_request('port',1,1);
		$server1 = get_request('server1',1,1);
		$server2 = get_request('server2',1,1);
		$oldport = get_request('oldport',1,1);
		$oldserver1 = get_request('oldserver1',1,1);
		$oldserver2 = get_request('oldserver2',1,1);
		$keepalive1 = get_request('keepalive1',1,1);
		$keepalive2 = get_request('keepalive2',1,1);
		$max_clients = get_request('max_clients',1,1);
		$comp_lzo = get_request('comp_lzo',1,1);
		$client_to_client = get_request('client_to_client',1,1);
		$new_addr = get_request('addr',1,1);
		$new_key = get_request('key',1,1);
		
		if(!is_numeric($port)){
			alert_and_back('端口请输入数字');
			exit;
		}
		if(!is_numeric($keepalive1)){
			alert_and_back('连接监测请输入数字');
			exit;
		}
		if(!is_numeric($keepalive2)){
			alert_and_back('连接监测请输入数字');
			exit;
		}
		if(!is_numeric($max_clients)){
			alert_and_back('最大连接请输入数字');
			exit;
		}
		if(!is_ip($server1)||!is_ip($server2)){
			alert_and_back('IP地址池请输入正确的格式');
			exit;
		}
		$filename = $_CONFIG['CONFIGFILE']['RADCONF'];
		//$filename = '/opt/vpn/etc/rad.conf';
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		
		for($ii=0; $ii<count($lines); $ii++){
				if(preg_match("/name=/",$lines[$ii])==1) {
					$tmp = preg_split("/=/", $lines[$ii]);
					$lines[$ii] = $tmp[0].'='.$new_addr."\n";
				}
				if(preg_match("/sharedsecret=/",$lines[$ii])==1) {
					$tmp = preg_split("/=/", $lines[$ii]);
					$lines[$ii] = $tmp[0].'='.$new_key."\n";
				}
		}
		
		$this->Array2File($lines,$filename);
		unset($lines);

		
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
				if(strstr(strtolower($lines[$ii]), "port"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $port, $lines[$ii]);
				}
				if(strstr(strtolower($lines[$ii]), "server "))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $server1, $lines[$ii]);
					$lines[$ii] = str_replace($tmp[2], $server2, $lines[$ii]);
				}
				if(strstr(strtolower($lines[$ii]), "keepalive"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $keepalive1, $lines[$ii]);
					$lines[$ii] = str_replace($tmp[2], $keepalive2, $lines[$ii]);
				}
				if(strstr(strtolower($lines[$ii]), "max-clients"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $max_clients, $lines[$ii]);
				}
				if(strstr(strtolower($lines[$ii]), "comp-lzo"))
				{					
					if($comp_lzo=='yes'){
						$lines[$ii] = 'comp-lzo'."\n";
					}else{
						$lines[$ii] = ';comp-lzo'."\n";
					}
					
				}
				if(strstr(strtolower($lines[$ii]), "client-to-client"))
				{
					if($client_to_client=='yes'){
						$lines[$ii] = 'client-to-client'."\n";
					}else{
						$lines[$ii] = ';client-to-client'."\n";
					}
				}
			}
			
		}
		else
		{
			echo ('配置文件不存在或没有权限');
			exit;
		}
		//var_dump($lines);
		$this->Array2File($lines,$filename);

		$lines = @file('/etc/sysconfig/iptables');
		if(!$lines) {
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}

		
		for($ii=0; $ii<count($lines); $ii++){
			if($oldport!=$port&&preg_match("/ $oldport /",$lines[$ii])==1) {
				$lines[$ii] = str_replace(" $oldport ", " $port ", $lines[$ii]);
			}
			if(($oldserver1!=$server1||$oldserver2!=$server2)&&preg_match("/ $oldserver1\/$oldserver2 /",$lines[$ii])==1) {
				$lines[$ii] = str_replace(" $oldserver1/$oldserver2 ", " $server1/$server2 ", $lines[$ii]);
				//var_dump($lines[$ii]);
			}
		}
		$this->Array2File($lines,'/etc/sysconfig/iptables');
		exec("sudo /usr/bin/systemctl restart iptables");
		alert_and_back('设置成功','admin.php?controller=admin_eth&action=vpnconfig');
	}

	function database_blacklist() {
		//$filename = '/opt/vpn/etc/server.conf';
		$page_num = get_request('page');
		$ac = get_request('ac', 1, 1);
		$id = get_request('id', 1, 0);
		$ip = get_request('ip', 1, 1);
		$mask = get_request('mask', 1, 1);
		$oldip = get_request('oldip', 1, 1);
		$oldmask = get_request('oldmask', 1, 1);
		$delete = get_request('delete', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if(($ip&&!is_ip($ip))){
			alert_and_back("IP地址格式不正确",'',1);
			exit;
		}
		if(($mask&&!is_ip($ip)&&!is_numeric($mask))){
			alert_and_back("掩码应该为数字",'',1);
			exit;
		}
		$where = '1=1';
			

		if($ac=='new'){
			$newpcap_black_list = new pcap_black_list();
			$newpcap_black_list->set_data("device_ip", $ip);
			$newpcap_black_list->set_data("netmask", $mask);
			$this->pcap_black_list_set->add($newpcap_black_list);
			alert_and_back("操作成功","admin.php?controller=admin_eth&action=database_blacklist");
		}else if($ac=='modify') {
			$newpcap_black_list = new pcap_black_list();
			$newpcap_black_list->set_data("id", $id);
			$newpcap_black_list->set_data("device_ip", $ip);
			$newpcap_black_list->set_data("netmask", $mask);
			$this->pcap_black_list_set->edit($newpcap_black_list);			
			alert_and_back("操作成功","admin.php?controller=admin_eth&action=database_blacklist");
		}else if($delete){
			$this->pcap_black_list_set->delete($delete);
			alert_and_back("操作成功","admin.php?controller=admin_eth&action=database_blacklist");
		}

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];		
		}
		
		$row_num = $this->pcap_black_list_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$routes =  $this->pcap_black_list_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);

		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		
		$this->assign('routes',$routes);
		$this->display('database_blacklist.tpl');
	}

	function dbbalcklist_edit(){
		$id = get_request('id');
		$p = $this->pcap_black_list_set->select_by_id($id);
		$this->assign('p',$p);
		$this->display("dbblacklist_edit.tpl");
	}

	function status() {
		global $_CONFIG;
		$fp = popen ("ps -ef | grep vpn", "r");
		$read = fread($fp, 200);
		if(preg_match("/vpn --config /",$read)==1) {
			//$filename = '/opt/vpn/etc/openvpn-status.log';
			$filename = $_CONFIG['CONFIGFILE']['OPENVPGLOG'];
			$lines = @file($filename);
			if(!$lines) {
				alert_and_back("系统已运行,但状态文件错误");
				exit;
			}
			$time = explode(',',$lines[1]);
			$this->assign('result',language("系统正常,启动日期为").":".$time[1]);
		}
		else {
			$this->assign('result','<font color="red">'.language('系统未运行').'</font>');
		}
		pclose($fp);
		$this->display('sys_status.tpl');
	}

	function ifcfgeth(){
		global $_CONFIG;
		$systemversion = intval($_CONFIG['SYSTEMVERSION']);
		$j=0;
		/*$cmd = "sudo ls -l /etc/sysconfig/network-scripts/ifcfg-*";
		exec($cmd, $out, $return);
		for($i=0; $i<count($out); $i++){
			$out_ = preg_split("/\s+/", $out[$i]);
			$file=$out_[count($out_)-1];
			$filename=substr($out_[count($out_)-1], strrpos( $out_[count($out_)-1],'/')+1);
			if(strpos($filename, '.backup')||strpos($filename, '.bak')){
				$backupname[]=strtoupper(substr($filename,strpos($filename,'-')+1,strrpos($filename,'.')-strpos($filename,'-')-1));
				$files[$i]['backupfile']='1';
				//continue;
			}
			$files[$j]['name']=strtoupper(substr($filename,strpos($filename,'-')+1));			
			$files[$j]['file']=$file;
			$files[$j]['filename']=$filename;
			if(strpos($files[$j]['name'],'LO')!==false){
				$files[$j]['lo']='1';
			}*/
		$i=0;
		while(1){
			if($_CONFIG['CONFIGFILE']['IFGETH'.$i]){
				if(file_exists($_CONFIG['CONFIGFILE']['IFGETH'.$i])){
					$out[]=$_CONFIG['CONFIGFILE']['IFGETH'.$i];
				}
			}else{
				break;
			}
			$i++;
		}
		$i=0;
		while(1){
			if($_CONFIG['CONFIGFILE']['IFGBR'.$i]){
				if(file_exists($_CONFIG['CONFIGFILE']['IFGBR'.$i])){
					$out[]=$_CONFIG['CONFIGFILE']['IFGBR'.$i];
				}
			}else{
				break;
			}
			$i++;
		}
		for($i=0; $i<count($out); $i++){
			$file = $out[$i];
			$filename=substr($out[$i], strrpos($out[$i],'/')+1);			
			$files[$j]['name']=strtoupper(substr($filename,strpos($filename,'-')+1));			
			$files[$j]['file']=$file;
			$files[$j]['filename']=$filename;
			if(file_exists($file))
			{
				$lines = @file($file);
				for($ii=0; $ii<count($lines); $ii++)
				{

					if($systemversion==7){
						if(strstr(strtoupper($lines[$ii]), "IPADDR0"))
						{
							$tmp = explode("=", $lines[$ii]);
							$files[$j]['IPADDR0'] = $tmp[1];
						}
						if(strstr(strtoupper($lines[$ii]), "IPADDR1"))
						{
							$tmp = explode("=", $lines[$ii]);
							$files[$j]['IPADDR1'] = $tmp[1];
						}
						if(strstr(strtoupper($lines[$ii]), "IPADDR2"))
						{
							$tmp = explode("=", $lines[$ii]);
							$files[$j]['IPADDR2'] = $tmp[1];
						}

						if(strstr(strtoupper($lines[$ii]), "PREFIX0"))
						{
							$tmp = explode("=", $lines[$ii]);
							$files[$j]['NETMASK0'] = $tmp[1];
						}
						if(strstr(strtoupper($lines[$ii]), "PREFIX1"))
						{
							$tmp = explode("=", $lines[$ii]);
							$files[$j]['NETMASK1'] = $tmp[1];
						}
						if(strstr(strtoupper($lines[$ii]), "PREFIX2"))
						{
							$tmp = explode("=", $lines[$ii]);
							$files[$j]['NETMASK2'] = $tmp[1];
						}
					}else{
						
						//echo $linestmp[$ii].':'.strlen($linestmp[$ii])."<br />";
						if(strstr(strtoupper($lines[$ii]), "IPADDR"))
						{
							$tmp = explode("=", $lines[$ii]);
							if(strtoupper(trim($tmp[0]))=='IPADDR')
								$files[$j]['IPADDR'] = $tmp[1];
						}
						if(strstr(strtoupper($lines[$ii]), "NETMASK"))
						{
							$tmp = explode("=", $lines[$ii]);
							$files[$j]['NETMASK'] = $tmp[1];
						}
						
						
					}
					if(strstr(strtoupper($lines[$ii]), "DEVICE"))
					{
						$tmp = explode("=", $lines[$ii]);
						$files[$j]['DEVICE'] = $tmp[1];
					}
					if(strstr(strtoupper($lines[$ii]), "GATEWAY"))
					{
						$tmp = explode("=", $lines[$ii]);
						$files[$j]['GATEWAY'] = $tmp[1];
					}
					if(strstr(strtoupper($lines[$ii]), "ONBOOT"))
					{
						$tmp = explode("=", $lines[$ii]);
						$files[$j]['ONBOOT'] = (strtolower(trim($tmp[1]))=='yes' ? '1' : '0');
					}
					if(strstr(strtoupper($lines[$ii]), "BRIDGE"))
					{
						$tmp = explode("=", $lines[$ii]);
						if(strtolower(trim($tmp[1]))=='br0'){
							$files[$j]['br0']=1;
							break;
						}
					}
				}
			}
			
			exec("sudo /sbin/ethtool ".$files[$j]['DEVICE']." | grep 'Link detected'", $out1);
			//echo "sudo /sbin/ethtool ".$files[$j]['DEVICE']." | grep 'Link detected'";var_dump($out1);
			for($ii=0; $ii<count($out1); $ii++){
				if(strpos($out1[$ii], "Link detected")!==false){
					$tmp = explode(":", $out1[$ii]);
					$files[$j]['STATUS'] = trim($tmp[1]);
				}
			}
			$out1=null;
			$j++;
		}//var_dump($backupname);
		if(is_array($backupname))
		for($i=0; $i<count($files); $i++){
			if(in_array($files[$i]['name'],$backupname)){
				$files[$i]['backup']='1';
			}
		}
		//echo '<pre>';var_dump($files);echo '</pre>';
		$this->assign("files", $files);
		$this->assign("systemversion", $systemversion);
		$this->display("ifgeth.tpl");
	}

	function eth_del(){
		$ethfile = urldecode(get_request('file',0,1));
		//var_dump($ethfile);
		exec("sudo rm -f ".$ethfile);//unlink($ethfile);
		alert_and_back("操作成功");
		exit;
	}

	function config_eth() {
		//var_dump(PHP_EOL);echo strlen('\r\n');
		//$filename = '/etc/sysconfig/network-scripts/ifcfg-eth0';
		//$filename = './controller/ifcfg-eth0';	
		//$networkfile = './controller/network';	
		global $_CONFIG;		
		$systemversion = intval($_CONFIG['SYSTEMVERSION']);
		$ethfile = urldecode(get_request('file',0,1));
		$name = get_request('name',0,1);
		$networkfile = $_CONFIG['CONFIGFILE']['NETWORK'];

		if(file_exists($networkfile))
		{
			$lines = @file($networkfile);
			for($ii=0; $ii<count($lines); $ii++)
			{
				if(strstr(strtoupper($lines[$ii]), "GATEWAY"))
				{
						$tmp = explode("=", $lines[$ii]);
						$network['GATEWAY']['value'] = $tmp[1];
						$network['GATEWAY']['file'] = $networkfile;
				}
			}
		}

		if(file_exists($ethfile))
		{
			$lines = @file($ethfile);
			for($ii=0; $ii<count($lines); $ii++)
			{
				if($systemversion==7){
					if(strstr(strtoupper($lines[$ii]), "IPADDR0"))
					{
						$tmp = explode("=", $lines[$ii]);
						$network['IPADDR0']['value'] = $tmp[1];
					}
					if(strstr(strtoupper($lines[$ii]), "IPADDR1"))
					{
						$tmp = explode("=", $lines[$ii]);
						$network['IPADDR1']['value'] = $tmp[1];
					}
					if(strstr(strtoupper($lines[$ii]), "IPADDR2"))
					{
						$tmp = explode("=", $lines[$ii]);
						$network['IPADDR2']['value'] = $tmp[1];
					}

					if(strstr(strtoupper($lines[$ii]), "PREFIX0"))
					{
						$tmp = explode("=", $lines[$ii]);
						$network['NETMASK0']['value'] = $tmp[1];
					}
					if(strstr(strtoupper($lines[$ii]), "PREFIX1"))
					{
						$tmp = explode("=", $lines[$ii]);
						$network['NETMASK1']['value'] = $tmp[1];
					}
					if(strstr(strtoupper($lines[$ii]), "PREFIX2"))
					{
						$tmp = explode("=", $lines[$ii]);
						$network['NETMASK2']['value'] = $tmp[1];
					}
				}else{
					
					//echo $linestmp[$ii].':'.strlen($linestmp[$ii])."<br />";
					if(strstr(strtoupper($lines[$ii]), "IPADDR"))
					{
						$tmp = explode("=", $lines[$ii]);
						if(strtoupper(trim($tmp[0]))=='IPADDR')
							$network['IPADDR']['value'] = $tmp[1];
					}
					if(strstr(strtoupper($lines[$ii]), "NETMASK"))
					{
						$tmp = explode("=", $lines[$ii]);
						$network['NETMASK']['value'] = $tmp[1];
					}
				}
				if(strstr(strtoupper($lines[$ii]), "GATEWAY"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['GATEWAY']['value'] = $tmp[1];
					$network['GATEWAY']['file'] = $ethfile;
				}
				if(strstr(strtoupper($lines[$ii]), "ONBOOT"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['ONBOOT']['value'] = strtolower(trim($tmp[1]));
					$network['ONBOOT']['file'] = $ethfile;
				}
				if(strstr(strtoupper($lines[$ii]), "IPV6INIT"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['IPV6INIT']['value'] = strtolower(trim($tmp[1]));
					$network['IPV6INIT']['file'] = $ethfile;
				}
				if(strstr(strtoupper($lines[$ii]), "IPV6ADDR"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['IPV6ADDR']['value'] = strtolower(trim($tmp[1]));
					$network['IPV6ADDR']['file'] = $ethfile;
				}
				if(strstr(strtoupper($lines[$ii]), "IPV6DEFAULTGW"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['IPV6DEFAULTGW']['value'] = strtolower(trim($tmp[1]));
					$network['IPV6DEFAULTGW']['file'] = $ethfile;
				}
			}
		}
		else
		{
			alert_and_back("IFCFG配置文件不存在或没有权限",'admin.php?controller=admin_index',1);
			exit;
		}
		
		$filename = $_CONFIG['CONFIGFILE']['DNS'];
		//$filename = './controller/resolv.conf';
		if(file_exists($filename))
		{
			$lines = @file($filename);
			$jj=0;
			for($ii=0; $ii<count($lines); $ii++)
			{								
				if(strstr(strtolower($lines[$ii]), "nameserver")&&substr($lines[$ii], 0, 1)!='#')
				{
					$tmp = preg_split("/ /", $lines[$ii]);
					$jj = $jj + 1;
					$network['nameserver'.$jj] = trim($tmp[1]);
				}
			}
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}

		$_filename = get_request('filename', 0, 1);
		$cmd = "sudo ls -l ".$_CONFIG['IFCFG-BR-DIR']."/ifcfg-*";
		exec($cmd, $out, $return);
		$j=0;
		for($i=0; $i<count($out); $i++){
			$out_ = preg_split("/\s+/", $out[$i]);
			$file=$out_[count($out_)-1];
			$filename=substr($out_[count($out_)-1], strrpos( $out_[count($out_)-1],'/')+1);
			$_name = strtoupper(substr($filename,strpos($filename,'-')+1));
			if(strpos($filename, '.backup')||strpos($filename, '.bak')||substr($_name, 0,2)=='LO'||substr($_name, 0,2)=='BR'){
				continue;
			}
			$files[$j]['name']=	$_name;	
			$files[$j]['file']=$file;
			$files[$j]['filename']=$filename;
			if(file_exists($file))
			{
				$lines = @file($file);
				for($ii=0; $ii<count($lines); $ii++)
				{
					if(strstr(strtoupper($lines[$ii]), "BRIDGE"))
					{
						$tmp = explode("=", $lines[$ii]);
						if(strtolower(trim($tmp[1]))=='br0'){
							$files[$j]['br0']=1;
							break;
						}
					}
				}
			}
			$j++;
		}

		$this->assign("sshconfig", $network);
		$this->assign("file", $ethfile);
		$this->assign("eths", $files);
		$this->assign('netmask',$network['NETMASK']['value']);
		$this->assign('ipaddr',$network['IPADDR']['value']);
		$this->assign('netmask0',$network['NETMASK0']['value']);
		$this->assign('ipaddr0',$network['IPADDR0']['value']);
		$this->assign('netmask1',$network['NETMASK1']['value']);
		$this->assign('ipaddr1',$network['IPADDR1']['value']);
		$this->assign('netmask2',$network['NETMASK2']['value']);
		$this->assign('ipaddr2',$network['IPADDR2']['value']);
		$this->assign("num", $_CONFIG['CONFIGFILE']['IFGETH_NUMBER']);
		$this->assign('gateway',$network['GATEWAY']['value']);
		$this->assign('onboot',$network['ONBOOT']['value']);
		$this->assign('ipv6init',$network['IPV6INIT']['value']);
		$this->assign('ipv6addr',$network['IPV6ADDR']['value']);
		$this->assign('ipv6gateway',$network['IPV6DEFAULTGW']['value']);
		$this->assign("name", $name);
		$this->assign("systemversion", $systemversion);
		$this->display('eth.tpl');
	}

	function eth_save() {
		global $_CONFIG;		
		$systemversion = intval($_CONFIG['SYSTEMVERSION']);
		$new_netmask = get_request('netmask',1,1);
		$new_ipaddr = get_request('ipaddr',1,1);
		$new_netmask0 = get_request('netmask0',1,1);
		$new_ipaddr0 = get_request('ipaddr0',1,1);
		$new_netmask1 = get_request('netmask1',1,1);
		$new_ipaddr1 = get_request('ipaddr1',1,1);
		$new_netmask2 = get_request('netmask2',1,1);
		$new_ipaddr2 = get_request('ipaddr2',1,1);
		$new_gateway = get_request('gateway',1,1);
		$nameserver1 = get_request('nameserver1',1,1);
		$nameserver2 = get_request('nameserver2',1,1);
		$onboot = get_request('onboot',1,1);
		$name = get_request('name',0,1);
		$wins = get_request("wins", 1, 1);
		$ipv6init = get_request('ipv6init',1,1);
		$ipv6addr = get_request('ipv6addr',1,1);
		$ipv6gateway = get_request('ipv6gateway',1,1);
		$filename = $_CONFIG['CONFIGFILE']['IFGETH0'];
		$filename=substr($filename, strrpos($filename,'/')+1);
		$eth0 = strtoupper(substr($filename,strpos($filename,'-')+1));

		if($systemversion==7){
			if(!is_ip($new_ipaddr0)){
				alert_and_back('IP地址1格式不正确 ');
				exit;
			}
			if(!($new_netmask0>=1 && $new_netmask0<=32)){
				alert_and_back('掩码1格式不正确 ');
				exit;
			}
			if($new_ipaddr1&&!is_ip($new_ipaddr1)){
				alert_and_back('IP地址2格式不正确 ');
				exit;
			}
			if($new_netmask1&&!($new_netmask1>=1 && $new_netmask1<=32)){
				alert_and_back('掩码2格式不正确 ');
				exit;
			}
			if($new_ipaddr2&&!is_ip($new_ipaddr2)){
				alert_and_back('IP地址3格式不正确 ');
				exit;
			}
			if($new_netmask2&&!($new_netmask2>=1 && $new_netmask2<=32)){
				alert_and_back('掩码3格式不正确 ');
				exit;
			}
		}else{
			if(!is_ip($new_ipaddr)){
				alert_and_back('IP地址格式不正确 ');
				exit;
			}
			if(!is_ip($new_netmask)){
				alert_and_back('掩码格式不正确 ');
				exit;
			}
		}
		if($ipv6init=='yes'){
			if(!validateIPv6($ipv6addr)){
				alert_and_back('IPv6地址格式不正确 ');
				exit;
			}
			if(!validateIPv6($ipv6gateway)){
				alert_and_back('IPv6网关地址格式不正确 ');
				exit;
			}
		}
		if($name==$eth0||$name=='BR0'){
			if(!is_ip($new_gateway)){
				alert_and_back('网关输入不正确 ');
				exit;
			}
			//if($name=='ETH0'){
				if($nameserver1&&!is_ip($nameserver1)){
					alert_and_back('域名服务器1输入不正确 ');
					exit;
				}
				if($nameserver2&&!is_ip($nameserver2)){
					alert_and_back('域名服务器2输入不正确 ');
					exit;
				}
			//}
		}

		$filename = $filename = get_request('file',0,1);
		$linestmp = @file($filename);
		if(!$linestmp) {
			alert_and_back("文件不存在或没有权限");
			exit;
		}
		$ipaddr = 0;
		$netmask = 0;
		$ipaddr0 = 0;
		$netmask0 = 0;
		$ipaddr1 = 0;
		$netmask1 = 0;
		$ipaddr2 = 0;
		$netmask2 = 0;
		$gateway = 0;
		$_onboot = 0;
		$_ipv6init = 0;
		$_ipv6address = 0;
		$_ipv6gateway = 0;
		$jj=0;
		//echo '<pre>';print_r($linestmp);echo '</pre>';
		for($ii=0; $ii<count($linestmp); $ii++)
		{
			
			if(strlen(trim($linestmp[$ii]))==0)
			{
				continue;
			}
			//echo $linestmp[$ii].':'.strlen($linestmp[$ii])."<br />";
			$lines[$jj] = str_replace("\r\n","\n",$linestmp[$ii]);
			if($systemversion==7){
				if(strstr(strtoupper($lines[$jj]), "IPADDR0"))
				{
					$lines[$jj] = "IPADDR0=$new_ipaddr0\n";
					$ipaddr = 1;
				}
				if(strstr(strtoupper($lines[$ii]), "IPADDR0"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['ipaddr0'] = $tmp[1];
				}
				if(strstr(strtoupper($lines[$ii]), "IPADDR1"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['ipaddr1'] = $tmp[1];
				}
				if(strstr(strtoupper($lines[$ii]), "IPADDR2"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['ipaddr2'] = $tmp[1];
				}

				if(strstr(strtoupper($lines[$ii]), "PREFIX0"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['prefix0'] = $tmp[1];
				}
				if(strstr(strtoupper($lines[$ii]), "PREFIX1"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['prefix1'] = $tmp[1];
				}
				if(strstr(strtoupper($lines[$ii]), "PREFIX2"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['prefix2'] = $tmp[1];
				}
			}else{
				if(strstr(strtoupper($lines[$jj]), "IPADDR"))
				{
					$lines[$jj] = "IPADDR=$new_ipaddr\n";
					$ipaddr = 1;
				}
				if(strstr(strtoupper($lines[$jj]), "NETMASK"))
				{
					$lines[$jj] = "NETMASK=$new_netmask\n";
					$netmask = 1;
				}
			}
			if(strstr(strtoupper($lines[$jj]), "ONBOOT"))
			{
				$lines[$jj]="ONBOOT=".$onboot."\n";
				$_onboot = 1;
			}
			if($name==$eth0||$name=='BR0'){
				if(strstr(strtoupper($lines[$jj]), "GATEWAY"))
				{
					$lines[$jj] = "GATEWAY=$new_gateway\n";
					$gateway = 1;
				}
				//if($name=='ETH0'){
					if(strstr(strtoupper($lines[$jj]), "BOOTPROTO"))
					{
						$lines[$jj] = "BOOTPROTO=static\n";
					}
					if(strstr(strtoupper($lines[$jj]), "BROADCAST"))
					{
						$lines[$jj]="";
					}
					if(strstr(strtoupper($lines[$jj]), "NETWORK"))
					{
						$lines[$jj]="";
					}
				//}
				
			}
			if(strstr(strtoupper($lines[$jj]), "IPV6INIT"))
			{
				$lines[$jj]="IPV6INIT=".$ipv6init."\n";
				$_ipv6init = 1;
			}
			if(strstr(strtoupper($lines[$jj]), "IPV6ADDR"))
			{
				$lines[$jj]="IPV6ADDR=".$ipv6addr."\n";
				$_ipv6addr = 1;
			}
			if(strstr(strtoupper($lines[$jj]), "IPV6DEFAULTGW"))
			{
				$lines[$jj]="IPV6DEFAULTGW=".$ipv6gateway."\n";
				$_ipv6gateway = 1;
			}
			$jj++;
		}
		if(strstr($lines[count($lines)-1],"\n"))
				$lines[count($lines)-1] = str_replace("\n","",$lines[count($lines)-1]);
		if($systemversion==7){
			if(!$ipaddr0)
			{
				$lines[count($lines)] = "\nIPADDR0=$new_ipaddr0";
			}
			if(!$netmask0)
			{
				$lines[count($lines)] = "\nPREFIX0=$new_netmask0";
			}
			if(!$ipaddr1)
			{
				$lines[count($lines)] = "\nIPADDR1=$new_ipaddr1";
			}
			if(!$netmask1)
			{
				$lines[count($lines)] = "\nPREFIX1=$new_netmask1";
			}
			if(!$ipaddr2)
			{
				$lines[count($lines)] = "\nIPADDR2=$new_ipaddr2";
			}
			if(!$netmask2)
			{
				$lines[count($lines)] = "\nPREFIX2=$new_netmask2";
			}

		}else{
			if(!$ipaddr)
			{
				$lines[count($lines)] = "\nIPADDR=$new_ipaddr";
			}
			if(!$netmask)
			{
				$lines[count($lines)] = "\nNETMASK=$new_netmask";
			}
		}
		if(!$_onboot)
		{
			$lines[count($lines)] = "\nONBOOT=$_onboot";
		}
		if($name==$eth0||$name=='BR0'){
			if(!$gateway)
			{
				$lines[count($lines)] = "\nGATEWAY=$new_gateway";
			}
		}
		if(!$_ipv6init)
		{
			$lines[count($lines)] = "\nIPV6INIT=$ipv6init";
		}
		if(!$_ipv6addr)
		{
			$lines[count($lines)] = "\nIPV6ADDR=$ipv6addr";
		}
		if(!$_ipv6gateway)
		{
			$lines[count($lines)] = "\nIPV6DEFAULTGW=$ipv6gateway";
		}
		//copy($filename,"/tmp/".substr($filename,strrpos($filename, '/')+1));
		$this->Array2File($lines,$filename);
		if($name==$eth0||$name=='BR0'){
			$filename = $_CONFIG['CONFIGFILE']['DNS'];
			//$filename = './controller/resolv.conf';

			$boolnameserver1 = 0;
			$boolnameserver2 = 0;
			$jj=0;
			if(file_exists($filename))
			{
				$lines = @file($filename);
				for($ii=0; $ii<count($lines); $ii++)
				{
									
					if(strstr(strtolower($lines[$ii]), "nameserver"))
					{
						$jj = $jj + 1;
						$tmp = preg_split("/ /", $lines[$ii]);
						$lines[$ii] = $tmp[0].' '.${'nameserver'.$jj}."\n";
						${'boolnameserver'.$jj} = 1;
					}
				}
				
			}
			else
			{
				alert_and_back('配置文件不存在或没有权限');
				exit;
			}
			if(!$boolnameserver1&&$nameserver1)
			{
				$lines[count($lines)] = "\nnameserver ".$nameserver1."\n";;
			}
			if(!$boolnameserver2&&$nameserver2)
			{
				$lines[count($lines)] = "\nnameserver ".$nameserver2."\n";;
			}
			//copy($filename,"/tmp/".substr($filename,strrpos($filename, '/')+1));
			$this->Array2File($lines,$filename);
			unset($lines);
			$networkfile = $_CONFIG['CONFIGFILE']['NETWORK'];
			
			if(file_exists($networkfile))
			{
				$lines = @file($networkfile);
				for($ii=0; $ii<count($lines); $ii++)
				{
					if(strstr(strtoupper($lines[$ii]), "GATEWAY"))
					{
							$lines[$ii]="\n";
					}
					if(strstr(strtoupper($lines[$ii]), "BROADCAST"))
					{
						$lines[$ii]="";
					}
					if(strstr(strtoupper($lines[$ii]), "NETWORK"))
					{
						$lines[$ii]="";
					}
				}
			}//var_dump($lines);
			//copy($networkfile,"/tmp/".substr($networkfile,strrpos($networkfile, '/')+1));
			$this->Array2File($lines,$networkfile);
		}
		$ac = get_request('ac', 1, 1);
		if($ac=='网卡绑定'){
			$cmd = "sudo ls -l ".$_CONFIG['IFCFG-BR-DIR']."/ifcfg-eth*";
			exec($cmd, $out, $return);
			$j=0;
			for($i=0; $i<count($out); $i++){
				$out_ = preg_split("/\s+/", $out[$i]);
				$file=$out_[count($out_)-1];
				$filename=substr($out_[count($out_)-1], strrpos( $out_[count($out_)-1],'/')+1);
				if(strpos($filename, '.backup')){
					continue;
				}
				$files[$j]['name']=strtoupper(substr($filename,strpos($filename,'-')+1));			
				$files[$j]['file']=$file;
				$files[$j]['filename']=$filename;
				$found=0;
				for($mm=0; $mm<count($_POST['eths']); $mm++){
					if($_POST['eths'][$mm]==$file){
						$found = 1;
						break;
					}
				}
				if(file_exists($file))
				{
					$lines = @file($file);
					$foundbr0 = 0;
					for($ii=0; $ii<count($lines); $ii++)
					{
										
						if(strstr(strtoupper($lines[$ii]), "BRIDGE"))
						{
							$tmp = explode("=", $lines[$ii]);
							if(strtolower(trim($tmp[1]))=='br0'){
								$foundbr0=1;
								if(!$found){
									$lines[$ii]='';
								}
								break;
							}
						}
					}
					if($found&&!$foundbr0){
						$s = trim($lines[count($lines)-1]);
						$lines[]=(!empty($s) ? "\n" : "")."BRIDGE=br0\n";
					}		
					$this->Array2File($lines,$file);
				}
			}
			
		}
		prompt("修改成功,网络将重新启动,确定重启吗?",'admin.php?controller=admin_eth&action=network_restart','admin.php?controller=admin_eth&action=ifcfgeth');
		
		//alert_and_back('修改成功','admin.php?controller=admin_eth&action=config_eth');
	}

	function ifcfg_br(){
		global $_CONFIG;
		$_filename = get_request('filename', 0, 1);
		$cmd = "sudo ls -l ".$_CONFIG['IFCFG-BR-DIR']."/ifcfg-eth*";
		exec($cmd, $out, $return);
		$j=0;
		for($i=0; $i<count($out); $i++){
			$out_ = preg_split("/\s+/", $out[$i]);
			$file=$out_[count($out_)-1];
			$filename=substr($out_[count($out_)-1], strrpos( $out_[count($out_)-1],'/')+1);
			if(strpos($filename, '.backup')){
				continue;
			}
			$files[$j]['name']=strtoupper(substr($filename,strpos($filename,'-')+1));			
			$files[$j]['file']=$file;
			$files[$j]['filename']=$filename;
			if(file_exists($file))
			{
				$lines = @file($file);
				for($ii=0; $ii<count($lines); $ii++)
				{
									
					if(strstr(strtoupper($lines[$ii]), "BRIDGE"))
					{
						$tmp = explode("=", $lines[$ii]);
						if(strtolower(trim($tmp[1]))=='br0'){
							$files[$j]['br0']=1;
							break;
						}
					}
				}
			}
			$j++;
		}
		$brfile = $_CONFIG['IFCFG-BR-DIR'].'/ifcfg-br0';
		if(file_exists($brfile))
		{
			$lines = @file($brfile);
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtoupper($lines[$ii]), "IPADDR"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['IPADDR']['value'] = $tmp[1];
					$network['IPADDR']['file'] = $ethfile;
				}
				if(strstr(strtoupper($lines[$ii]), "NETMASK"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['NETMASK']['value'] = $tmp[1];
					$network['NETMASK']['file'] = $ethfile;
				}
				if(strstr(strtoupper($lines[$ii]), "GATEWAY"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['GATEWAY']['value'] = $tmp[1];
					$network['GATEWAY']['file'] = $ethfile;
				}
				if(strstr(strtoupper($lines[$ii]), "ONBOOT"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['ONBOOT']['value'] = strtolower(trim($tmp[1]));
					$network['ONBOOT']['file'] = $ethfile;
				}
			}
		}
		else
		{
			alert_and_back("IFCFG配置文件不存在或没有权限",'admin.php?controller=admin_index',1);
			exit;
		}
		$this->assign("eths", $files);
		$this->assign("filename", $_filename);
		$this->assign('netmask',$network['NETMASK']['value']);
		$this->assign('ipaddr',$network['IPADDR']['value']);
		$this->assign('gateway',$network['GATEWAY']['value']);
		$this->assign('onboot',$network['ONBOOT']['value']);
		$this->display('br0.tpl');
	}

	function br0_save(){
		global $_CONFIG;
		$new_netmask = get_request('netmask',1,1);
		$new_ipaddr = get_request('ipaddr',1,1);
		$new_gateway = get_request('gateway',1,1);
		$nameserver1 = get_request('nameserver1',1,1);
		$nameserver2 = get_request('nameserver2',1,1);
		$onboot = get_request('onboot',1,1);
		$name = get_request('name',0,1);
		$wins = get_request("wins", 1, 1);
		if(!is_ip($new_ipaddr)){
			alert_and_back('IP地址格式不正确 ');
			exit;
		}
		if(!is_ip($new_netmask)){
			alert_and_back('掩码格式不正确 ');
			exit;
		}
		
		$filename = $_CONFIG['IFCFG-BR-DIR'].'/ifcfg-br0';
		$linestmp = @file($filename);
		if(!$linestmp) {
			alert_and_back("文件不存在或没有权限");
			exit;
		}
		$ipaddr = 0;
		$netmask = 0;
		$gateway = 0;
		$_onboot = 0;
		$jj=0;
		//echo '<pre>';print_r($linestmp);echo '</pre>';
		for($ii=0; $ii<count($linestmp); $ii++)
		{
			
			if(strlen(trim($linestmp[$ii]))==0)
			{
				continue;
			}
			//echo $linestmp[$ii].':'.strlen($linestmp[$ii])."<br />";
			$lines[$jj] = str_replace("\r\n","\n",$linestmp[$ii]);
			if(strstr(strtoupper($lines[$jj]), "IPADDR"))
			{
				$lines[$jj] = "IPADDR=$new_ipaddr\n";
				$ipaddr = 1;
			}
			if(strstr(strtoupper($lines[$jj]), "NETMASK"))
			{
				$lines[$jj] = "NETMASK=$new_netmask\n";
				$netmask = 1;
			}
			if(strstr(strtoupper($lines[$jj]), "ONBOOT"))
			{
				$lines[$jj]="ONBOOT=".$onboot."\n";
				$_onboot = 1;
			}
			$jj++;
		}
		if(strstr($lines[count($lines)-1],"\n"))
				$lines[count($lines)-1] = str_replace("\n","",$lines[count($lines)-1]);
		if(!$ipaddr)
		{
			$lines[count($lines)] = "\nIPADDR=$new_ipaddr";
		}
		if(!$netmask)
		{
			$lines[count($lines)] = "\nNETMASK=$new_netmask";
		}
		if(!$_onboot)
		{
			$lines[count($lines)] = "\nONBOOT=$_onboot";
		}
		if($name=='ETH0'){
			if(!$gateway)
			{
				$lines[count($lines)] = "\nGATEWAY=$new_gateway";
			}
		}
		copy($filename,"/tmp/".substr($filename,strrpos($filename, '/')+1));
		$this->Array2File($lines,$filename);
		$lines = array();
		$linestmp = array();
		$file = $_CONFIG['IFCFG-BR-DIR'].'/'.get_request('filename', 0, 1);
		$found = 0;
		if(file_exists($file))
		{
			$linestmp = @file($file);
			for($ii=0; $ii<count($linestmp); $ii++)
			{
				if(strstr(strtoupper($linestmp[$ii]), "BRIDGE"))
				{				
					$found = 1;
					if($_POST['eths'][0]){
						$lines[]="\nBRIDGE=br0\n";	
					}
				}else{
					$lines[]=$linestmp[$ii];
				}
			}
		}else{
			alert_and_back("文件'".$file."'不存在或没有权限");
			exit;
		}
		if($found==0&&$_POST['eths'][0]){
			$lines[]="\nBRIDGE=br0\n";
		}		
		$this->Array2File($lines,$file);
		
		alert_and_back("操作成功", 'admin.php?controller=admin_eth&action=ifcfgeth');
	}

	function network_restart(){
		exec("sudo service network restart");
		alert_and_back("操作成功", "admin.php?controller=admin_eth&action=ifcfgeth");
		exit;
	}
	
	function config_ethx(){
		$number = get_request('number');
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['IFGETH'.$number];
		//$filename = './controller/ifcfg-eth'.$number;
		$linestmp = @file($filename);
		if(!$linestmp) {
			alert_and_back("文件不存在或没有权限");
			exit;
		}
		$ipaddr = 0;
		$netmask = 0;
		$gateway = 0;
		$jj=0;
		//echo '<pre>';print_r($linestmp);echo '</pre>';
		for($ii=0; $ii<count($linestmp); $ii++)
			{
				
				if(strlen(trim($linestmp[$ii]))==0)
				{
					continue;
				}
				//echo $linestmp[$ii].':'.strlen($linestmp[$ii])."<br />";
				if(strstr(strtoupper($linestmp[$ii]), "IPADDR"))
				{
					$tmp = explode("=", $linestmp[$ii]);
					$network['ipaddr'] = $tmp[1];
				}
				if(strstr(strtoupper($linestmp[$ii]), "NETMASK"))
				{
					$tmp = explode("=", $linestmp[$ii]);
					$network['netmask'] = $tmp[1];
				}
				if(strstr(strtoupper($linestmp[$ii]), "ONBOOT"))
				{
					$tmp = explode("=", $linestmp[$ii]);
					$network['onboot'] = strtolower($tmp[1]);
				}
				$jj++;
			}
	
		$this->assign("number", $number);	
		$this->assign("network", $network);
		$this->assign("num", $_CONFIG['CONFIGFILE']['IFGETH_NUMBER']);
		$this->display('ethx.tpl');
	}
	
	function ethx_save(){
		$number = get_request('number');
		$new_netmask = get_request('netmask',1,1);
		$new_ipaddr = get_request('ipaddr',1,1);
		$new_onboot = get_request('onboot',1,1);
		
		if($new_ipaddr&&!is_ip($new_ipaddr)){
			alert_and_back('IP地址格式不正确 ');
			exit;
		}
		if($new_netmask&&!is_ip($new_netmask)){
			alert_and_back('子网掩码格式不正确 ');
			exit;
		}

		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['IFGETH'.$number];
		$linestmp = @file($filename);
		if(!$linestmp) {
			alert_and_back("文件不存在或没有权限");
			exit;
		}
		$ipaddr = 0;
		$netmask = 0;
		$jj=0;
		//echo '<pre>';print_r($linestmp);echo '</pre>';
		for($ii=0; $ii<count($linestmp); $ii++)
		{
				
			if(strlen(trim($linestmp[$ii]))==0)
			{
				continue;
			}
			//echo $linestmp[$ii].':'.strlen($linestmp[$ii])."<br />";
			$lines[$jj] = str_replace("\r\n","\n",$linestmp[$ii]);
			if(strstr(strtoupper($lines[$jj]), "IPADDR"))
			{
				$lines[$jj] = "IPADDR=$new_ipaddr\n";
				$ipaddr = 1;
			}
			if(strstr(strtoupper($lines[$jj]), "NETMASK"))
			{
				$lines[$jj] = "NETMASK=$new_netmask\n";
				$netmask = 1;
			}
			if(strstr(strtoupper($lines[$jj]), "ONBOOT"))
			{
				$lines[$jj] = "ONBOOT=$new_onboot\n";
				$onboot =1;
			}
			if(strstr(strtoupper($lines[$jj]), "BOOTPROTO"))
			{
				$lines[$jj] = "BOOTPROTO=static\n";
			}
			$jj++;
		}
		if(strstr($lines[count($lines)-1],"\n"))
		{
				$lines[count($lines)-1] = str_replace("\n","",$lines[count($lines)-1]);
		}
		if(!$ipaddr)
		{
			$lines[count($lines)] = "\nIPADDR=$new_ipaddr";
		}
		if(!$onboot)
		{
			$lines[count($lines)] = "\nONBOOT=$onboot";
		}
		if(!$netmask)
		{
			$lines[count($lines)] = "\nNETMASK=$new_netmask";
		}
		
		$this->Array2File($lines,$filename);
		alert_and_back("修改成功",'admin.php?controller=admin_eth&action=config_ethx&number='.$number);
	}
	
	function config_route()
	{
		global $_CONFIG;
		//$filename = './controller/rc.local';
		$filename = $_CONFIG['CONFIGFILE']['RCLOCAL'];
		if(file_exists($filename))
		{
			$lines = @file($filename);
			$jj=0;
			for($ii=0; $ii<count($lines); $ii++)
			{
				if(strstr(strtolower($lines[$ii]), "route add "))
				{
					$tmp = preg_split ("/\s{1,}/",$lines[$ii]);
					$route[$jj++]= $tmp;
				}
			}
		}
		//var_dump($route);
		for($i=0; $i<count($route); $i++){
			$route[$i]['section']=$route[$i][3];
			$route[$i]['netmask']=$route[$i][5];
			$route[$i]['gateway']=$route[$i][7];
		}
		$this->assign("route", $route);
		$this->assign("num", $_CONFIG['CONFIGFILE']['IFGETH_NUMBER']);
		$this->display('route.tpl');
	}
	
	function route_save()
	{
		$sectionold = get_request('sectionold',1,1);
		$netmaskold = get_request('netmaskold',1,1);
		$gatewayold = get_request('gatewayold',1,1);
		$section = get_request('section',1,1);
		$netmask = get_request('netmask',1,1);
		$gateway = get_request('gateway',1,1);
		$delete = get_request('delete', 1, 1);
		$modify = get_request('modify', 1, 1);
		//$filename = './controller/rc.local';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['RCLOCAL'];
		if(file_exists($filename))
		{
			$linestmp = @file($filename);
			if(!$linestmp) {
				alert_and_back("文件不存在或没有权限");
				exit;
			}
			for($ii=0; $ii<count($linestmp); $ii++)
			{
				if(strstr(strtolower($linestmp[$ii]), "route add ") && strstr(strtolower($linestmp[$ii]), $sectionold) && strstr(strtolower($linestmp[$ii]), $netmaskold) && strstr(strtolower($linestmp[$ii]), $gatewayold))
				{
					if($delete){
						exec("sudo route del -net ".$section." netmask ".$netmask." gw ".$gateway);
						continue;
					}else {
						$lines[]= "route add -net ".$section." netmask ".$netmask." gw ".$gateway."\n";
						exec("sudo route add -net ".$section." netmask ".$netmask." gw ".$gateway);						
						exec("sudo route del -net ".$sectionold." netmask ".$netmaskold." gw ".$gatewayold);
					}
				}else{
					$lines[] = $linestmp[$ii];
				}
			}
			if(count($lines) > 0 && !strstr($lines[count($lines)-1],"\n"))
				$lines[count($lines)-1] .= "\n";
		}
		if(!empty($lines))
		$lines = implode("", $lines);
		
		$this->String2File($lines, $filename);
		//prompt("修改成功,系统将重新启动,确定重启吗?",'admin.php?controller=admin_eth&action=system_init_6','admin.php?controller=admin_eth&action=config_route');
		alert_and_back('修改成功','admin.php?controller=admin_eth&action=config_route');
		//echo $route.':'.strlen($route)."<br />";
		//var_dump(strstr($route,"\n"));
	}
	
	
	function route_add2(){
		$section = get_request('section',1,1);
		$netmask = get_request('netmask',1,1);
		$gateway = get_request('gateway',1,1);
		//$filename = './controller/rc.local';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['RCLOCAL'];
		$found = 0;
		if(!is_ip($section)){
			alert_and_back('网段输入不正确');
			exit;
		}
		if(!is_ip($netmask)){
			alert_and_back('掩码输入不正确');
			exit;
		}
		if(!is_ip($gateway)){
			alert_and_back('网关输入不正确');
			exit;
		}
		if(file_exists($filename))
		{
			$linestmp = @file($filename);
			for($ii=0; $ii<count($linestmp); $ii++)
			{
				if(strstr(strtolower($linestmp[$ii]), "route add ") && strstr(strtolower($linestmp[$ii]), $section) && strstr(strtolower($linestmp[$ii]), $gateway))
				{
						$found = 1;
				}
			}
			if(count($linestmp) > 0 && !strstr($linestmp[count($linestmp)-1],"\n"))
				$linestmp[count($linestmp)-1] .= "\n";
		}
		
		if($found==0){
			$linestmp[count($linestmp)] .= "route add -net ".$section." netmask ".$netmask." gw ".$gateway."\n";
			exec("sudo route add -net ".$section." netmask ".$netmask." gw ".$gateway);
		}
		$linestmp = implode("", $linestmp);
		$this->String2File($linestmp, $filename);
		//prompt("修改成功,系统将重新启动,确定重启吗?",'admin.php?controller=admin_eth&action=system_init_6','admin.php?controller=admin_eth&action=config_route');
		alert_and_back('修改成功','admin.php?controller=admin_eth&action=config_route');
		//echo $route.':'.strlen($route)."<br />";
		//var_dump(strstr($route,"\n"));
	}
	
	function system_init_6()
	{
		system('sudo /sbin/init 6',$out);
	}
	
	
	
	function config_sys() {
		//$filename = '/opt/vpn/etc/server.conf';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$port = explode(' ',$lines[0]);
		$proto = explode(' ',$lines[1]);
		$dev = explode(' ',$lines[2]);
		$ctoc = $lines[3];
		$this->assign('port',trim($port[1]));
		$this->assign('proto',trim($proto[1]));
		$this->assign('dev',trim($dev[1]));

		$this->assign('ctoc',$this->is_enable($ctoc));

		$this->display('sys.tpl');
	}

	function sys_save() {
		$new_port = get_request('port',1,1);
		$new_proto = get_request('proto',1,1);
		$new_dev = get_request('dev',1,1);
		$new_ctoc = get_request('ctoc',1,1);
		//$filename = '/opt/vpn/etc/server.conf';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$port = explode(' ',$lines[0]);
		$proto = explode(' ',$lines[1]);
		$dev = explode(' ',$lines[2]);
		$ctoc = $lines[3];

		$ctoc  = $this->value_enable($ctoc,$new_ctoc);
		$port[1] = $new_port."\n";
		$proto[1] = $new_proto."\n";
		$dev[1] = $new_dev."\n";

		$lines[0] = implode(' ',$port);
		$lines[1] = implode(' ',$proto);
		$lines[2] = implode(' ',$dev);
		$lines[3] = $ctoc;

		$this->Array2File($lines,$filename);

		alert_and_back('修改成功','admin.php?controller=admin_eth&action=config_sys');
	}

	function config_net() {
		//$filename = '/opt/vpn/etc/server.conf';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$addr = explode(' ',$lines[8]);
		$default_route = $lines[10];
		$dns = $lines[11];
		$wins = $lines[12];
		$t_dns = explode('"',$dns);
		$t_wins = explode('"',$wins);
		$dns_addr = explode(' ',$t_dns[1]);
		$wins_addr = explode(' ',$t_wins[1]);

		$this->assign('ip',trim($addr[1]));
		$this->assign('netmask',trim($addr[2]));
		$this->assign('default_route',$this->is_enable($default_route));
		$this->assign('dns',$this->is_enable($dns));
		$this->assign('wins',$this->is_enable($wins));
		$this->assign('dns_addr',trim($dns_addr[2]));
		$this->assign('wins_addr',trim($wins_addr[2]));

		$this->display('network.tpl');
	}

	function net_save() {
		$new_ip = get_request('ip',1,1);
		$new_netmask = get_request('netmask',1,1);
		$new_route = get_request('default_route',1,1);
		$new_dns = get_request('dns',1,1);
		$new_wins = get_request('wins',1,1);
		$new_dnsaddr = get_request('dns_addr',1,1);
		$new_winsaddr = get_request('wins_addr',1,1);

		//$filename = '/opt/vpn/etc/server.conf';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];
		$lines = @file($filename);
		if(!$lines) {
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}

		$addr = explode(' ',$lines[8]);
		$default_route = $lines[10];
		$dns = $lines[11];
		$wins = $lines[12];
		$t_dns = explode('"',$dns);
		$t_wins = explode('"',$wins);
		$dns_addr = explode(' ',$t_dns[1]);
		$wins_addr = explode(' ',$t_wins[1]);

		$addr[1] = $new_ip;
		$addr[2] = $new_netmask."\n";
		$default_route = $this->value_enable($default_route,$new_route);
		$dns_addr[2] = $new_dnsaddr;
		$wins_addr[2] = $new_winsaddr;


		$lines[8] = implode(' ',$addr);
		$lines[10] = $default_route;
		$t_dns[1] = implode(' ',$dns_addr);
		$t_wins[1] =  implode(' ',$wins_addr);
		$dns = implode('"',$t_dns);
		$wins = implode('"',$t_wins);

		$dns = $this->value_enable($dns,$new_dns);
		$wins = $this->value_enable($wins,$new_wins);

		$lines[11] = $dns;
		$lines[12] = $wins;

		$this->Array2File($lines,$filename);

		alert_and_back('修改成功','admin.php?controller=admin_eth&action=config_net');

	}



	
	
	function is_enable($value) {
		$pos = strpos($value,';');
		if($pos === false) {
			return 1;
		}
		else {
			return 0;
		}
	}

	function value_enable($source,$value) {
		$pos = strpos($source, ';');
		if($value != 'on') {
			if ($pos === false) {
				$source = ';'.$source;
			}
		}
		else {
			if ($pos === 0) {
				$source = substr($source,1);
			}
		}
		return $source;
	}
	
	function serverstatus(){
		global $_CONFIG;
		$sname = get_request("sname", 0, 1);
		$action = get_request("ac", 0, 1);
		$serverArr = array(
						array('name'=>'vpn服务','sname'=>'vpn', 'desc'=>'系统SSL VPN服务'),
						//array('name'=>'telnet','sname'=>'tcpproxy'),						
						//array('name'=>'ftp','sname'=>'ftp-audit', 'desc'=>'系统ftp 审计服务'),
						//array('name'=>'ssh','sname'=>'ssh-audit', 'desc'=>'系统ssh 审计服务'),
						//array('name'=>'rdp','sname'=>'Freesvr_RDP', 'desc'=>'系统rdp 审计服务'),
						//array('name'=>'authd','sname'=>'freesvr-authd', 'desc'=>'系统认证授权服务'),
						array('name'=>'认证服务','sname'=>'radiusd', 'desc'=>'系统radius 服务')
						//array('name'=>'monitor','sname'=>'Freesvr_MONITOR', 'desc'=>'系统实时监控服务'),
						//array('name'=>'play','sname'=>'rdp-monitord', 'desc'=>'系统回放服务'),
						//array('name'=>'ha','sname'=>'keepalived', 'desc'=>'双机服务'),
						//array('name'=>'db-audit','sname'=>'tcpreassembly', 'desc'=>'系统数据库审计服务')
					);
		
		if($sname && $action){
			if(!in_array($action,array('restart','start','stop'))){
				alert_and_back('没有此命令','admin.php?controller=admin_eth&action=serverstatus');
				exit;
			}
			if(!in_array($sname,array('vpn','tcpproxy','ftp-audit','ssh-audit','Freesvr_RDP','rdp-monitord','freesvr-authd','radiusd','Freesvr_MONITOR','tcpreassembly','keepalived'))){
				alert_and_back('没有此服务','admin.php?controller=admin_eth&action=serverstatus');
				exit;
			}
			ob_start();
			/*
			if($action!='restart'){
				$cmd= 'sudo  /opt/freesvr/audit/sbin/manageprocess.pl '.$sname.' '.$action;
				exec($cmd, $out1,$return);
			}else{
				$cmd= 'sudo  /opt/freesvr/audit/sbin/manageprocess.pl '.$sname.' stop';
				exec($cmd, $out1,$return);
				$cmd= 'sudo  /opt/freesvr/audit/sbin/manageprocess.pl '.$sname.' start';
				exec($cmd, $out1,$return);
			}
			//echo '<br >';
			*/
			$cmd= 'sudo  /opt/freesvr/audit/sbin/manageprocess.pl '.$sname.' '.$action;
			exec($cmd, $out1,$return);
			$cmd = 'sudo  /opt/freesvr/audit/sbin/manageprocess.pl '.$sname.' status';
			exec($cmd, $out2, $return);
			ob_get_clean();
			for($i=0; $i<count($serverArr); $i++){
				if($sname==$serverArr[$i]['sname']){
					$sname_desc = $serverArr[$i]['desc'];
				}
			}
			if((($action=='start' || $action=='restart' )&&$return==1 )|| ($action=='stop'&&$return==0)){
					$adminlog = new admin_log();
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
					$adminlog->set_data('action', '系统服务"'.$sname.'" '.($action=='restart' ? '重启' : ($action=='start' ? '启动' : '停止')));
					$adminlog->set_data('resource', $sname_desc);
					$this->admin_log_set->add($adminlog);
					unset($adminlog);

				alert_and_back('修改成功','admin.php?controller=admin_eth&action=serverstatus');
			}else{
					$adminlog = new admin_log();
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
					$adminlog->set_data('action', '系统服务"'.$sname.'" '.($action=='restart' ? '重启' : ($action=='start' ? '启动' : '停止')));
					$adminlog->set_data('resource', $sname_desc);
					$adminlog->set_data('result', '失败');
					$this->admin_log_set->add($adminlog);
					unset($adminlog);
				alert_and_back('修改失败','admin.php?controller=admin_eth&action=serverstatus');
			}
			exit;
		}
		$versions = $this->version_set->select_all('1=1');
		for($i=0; $i<count($versions); $i++){
			$versionarr[strtolower($versions[$i]['service'])]=$versions[$i];
		}
		//echo '<pre>';print_r($versionarr);echo '</pre>';
		ob_start();
		for($i=0; $i<count($serverArr); $i++){
			
			//echo $serverArr[$i]['name'];
			
			$cmd = 'sudo  /opt/freesvr/audit/sbin/manageprocess.pl '.$serverArr[$i]['sname'].' status';
			system($cmd, $out2);
			
			//echo $versionarr[$serverArr[$i]['sname']]['version'];
			$serverArr[$i]['version']=$versionarr[$serverArr[$i]['name']]['version'];
			$serverArr[$i]['start']=$versionarr[$serverArr[$i]['name']]['start'];
			//var_dump($out2);
			switch ($out2){
				case 1:
					$serverArr[$i]['status'] = 1;
					break;
				case 255:
					$serverArr[$i]['status'] = 0;
					break;
				default:
					$serverArr[$i]['status'] = 0;
					break;
			}
			
		}
		ob_get_clean();
		$this->assign("allcommand", $serverArr);
		$this->display("serverstatus.tpl");
	}
	
	function upgradeServerStatus(){
		$versions = $this->version_set->select_all('1=1');
		for($i=0; $i<count($versions); $i++){
			$versionarr[strtolower($versions[$i]['service'])]=$versions[$i];
		}
		$this->assign("version", $versionarr);
		$this->display("upgradeserver.tpl");		
	}
	
	function upgradeServerStatusSave(){
		//print_r($_FILES);
		$stype = get_request("stype", 1, 1);
		$serverArr = array(
						array('name'=>'vpn','sname'=>'vpn'),
						array('name'=>'telnet','sname'=>'tcpproxy'),
						array('name'=>'ftp','sname'=>'ftp-audit'),
						array('name'=>'ssh','sname'=>'ssh-audit'),
						array('name'=>'rdp','sname'=>'Freesvr_RDP'),
						array('name'=>'authd','sname'=>'freesvr-authd'),
						array('name'=>'radius','sname'=>'radiusd'),
						array('name'=>'monitor','sname'=>'Freesvr_MONITOR'),
						array('name'=>'play','sname'=>'Freesvr_PLAY')
					);
		if($_FILES['file']['error']==1 or $_FILES['file']['error']==2){
			alert_and_back("上传得文件超过系统限制", 'admin.php?controller=admin_eth&action=upgradeServerStatus');
			exit;
		}
		if(!is_uploaded_file($_FILES['file']['tmp_name']))
		{
			alert_and_back("请上传文件", 'admin.php?controller=admin_eth&action=upgradeServerStatus');
			exit;
		}
		//var_dump(is_dir('/opt/freesvr/audit/update'));
		if(!is_dir('/opt/freesvr/audit/update')){
			mkdir("/opt/freesvr/audit/update");
		}
		if(!is_dir('/opt/freesvr/audit/update/new')){
			mkdir("/opt/freesvr/audit/update/new");
		}
		if(!is_dir('/opt/freesvr/audit/update/old')){
			mkdir("/opt/freesvr/audit/update/old");
		}
		for($i=0; $i<count($serverArr); $i++){
			if($stype==$serverArr[$i]['name']){
				$sname = $serverArr[$i]['sname'];
				break;
			}
		}
		
		move_uploaded_file($_FILES['file']['tmp_name'], "/opt/freesvr/audit/update/new/$sname");
		chmod("/opt/freesvr/audit/update/new/$sname", 0755);
		
		$cmd= 'sudo /opt/freesvr/audit/sbin/manageprocess.pl '.$sname.' stop';		
		//echo '<br >';
		system($cmd, $out1);
		cp("/opt/freesvr/audit/sbin/$sname", "/opt/freesvr/audit/update/old/$sname.bak");
		cp("/opt/freesvr/audit/update/new/$sname", "/opt/freesvr/audit/sbin/$sname");
		
		$cmd= 'sudo /opt/freesvr/audit/sbin/manageprocess.pl '.$sname.' start';
		//echo '<br >';

		system($cmd, $out1);
		//var_dump($out1);
		if(trim($out1)==1){
			alert_and_back("升级成功", 'admin.php?controller=admin_eth&action=upgradeServerStatus');
			exit;
		}else{
			//cp("/opt/freesvr/audit/update/old/$sname.bak", "/opt/freesvr/audit/sbin/$sname");
			//alert_and_back("升级失败", 'admin.php?controller=admin_eth&action=upgradeServerStatus');
			prompt("升级失败,回退?","admin.php?controller=admin_eth&action=upgradeServerBack&sname=$sname","admin.php?controller=admin_eth&action=upgradeServerStatus");
			exit;
		}
	}
	
	function upgradeServer(){
		$versions = $this->version_set->select_all('1=1');
		for($i=0; $i<count($versions); $i++){
			$versionarr[strtolower($versions[$i]['service'])]=$versions[$i];
		}
		$this->assign("version", $versionarr);
		$this->display("upgradeserver2.tpl");		
	}
	
	function upgradeServerSave(){
		global $dbhost, $dbuser, $dbpwd, $dbname;
		if($_FILES['file']['error']==1 or $_FILES['file']['error']==2){
			alert_and_back("上传得文件超过系统限制", 'admin.php?controller=admin_eth&action=upgradeServer');
			exit;
		}
		if(!@is_uploaded_file($_FILES['file']['tmp_name']))
		{
			alert_and_back("请上传文件", 'admin.php?controller=admin_eth&action=upgradeServerStatus');
			exit;
		}
		@move_uploaded_file($_FILES['file']['tmp_name'], '/tmp/upgradeServer.tar');
		$cmd = 'sudo  /opt/freesvr/audit/upgrade/update /tmp/upgradeServer.tar '.$dbhost.' '.$dbuser.' \''.$dbpwd.'\' '.$dbname;
		exec($cmd, $output, $return);
		if($return == 1){
			alert_and_back("操作成功");
			exit;
		}else{
			alert_and_back(language("操作失败").$output[0]." ".$output[1]);
			exit;
		}
	}
	
	function upgradeServerBack(){
		echo $sname = get_request("sname", 0, 1);
		cp("/opt/freesvr/audit/update/old/$sname.bak", "/opt/freesvr/audit/sbin/$sname");
		$cmd= 'sudo  /opt/freesvr/audit/sbin/manageprocess.pl '.$sname.' start';
		@unlink("/opt/freesvr/audit/update/old/$sname.bak");
		if(trim($out1)==1){
			//alert_and_back("回退成功", 'admin.php?controller=admin_eth&action=upgradeServerStatus');
			exit;
		}else{
			//alert_and_back("回退失败", 'admin.php?controller=admin_eth&action=upgradeServerStatus');
			exit;
		}
	}

	function downloadlog(){
		
		$root = 'tmp/log/';
		exec("rm -rf ".$root);
		if(!is_dir($root)){
			$cmd = "mkdir -p ".$root;
			exec($cmd);
		}
		exec("sudo cp /opt/freesvr/audit/authd/log/freesvr-authd.log ".$root);
		exec("sudo cp /opt/freesvr/sql/data/Audit.err ".$root);
		//copy("/opt/freesvr/audit/authd/log/freesvr-authd.log", $root.'freesvr-authd.log');
		//copy("/var/log/mysqld.log", $root.'mysqld.log');
		exec("rm -f $root/log.zip");
		//exec("zip -q -r -D tmp/".$_SESSION['ADMIN_USERNAME'].".zip ".$root);

		$phpstr = "<?php\r\nsession_start();\r\nexec(\"sudo zip log.zip freesvr-authd.log mysqld.log\");\r\nHeader('Location: log.zip');\r\nexit();\r\n?>\r\n";
		if(!file_exists("$root/zipphp.php"))
			$this->Array2File(array($phpstr), "$root/zipphp.php");
		/*
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=rdcman.rdg"); 
		echo $str;
		*/
		
		go_url("$root/zipphp.php");
	}

	function ping(){
		$ip = get_request("ip", 0, 1);
loading_start();
		if($ip){
			if(!is_ip($ip)&&!is_domain($ip)){
				alert_and_back('请输入合法的IP和域名');
				exit;
			}
			$cmd = "sudo /usr/bin/ping -c 4 ".$ip;
			exec($cmd, $o, $r);
			if(empty($o)){
				$oo[] = "Network is unreachable";
			}else
			for($i=0; $i<count($o); $i++){
				$o[$i] = (str_replace("\n", "", $o[$i]));
				if(!empty($o[$i]))
				$oo[]=$o[$i];
			}
			$this->assign("pinginfo", $oo);
			$this->assign("ip", $ip);
		}
loading_end();
		$this->display("ping.tpl");
	}

	function tracepath(){
		$ip = get_request("ip", 0, 1);
loading_start();
		if($ip){
			if(!is_ip($ip)&&!is_domain($ip)){
				alert_and_back('请输入合法的IP和域名');
				exit;
			}
			exec("sudo /usr/bin/traceroute ".$ip, $o, $r);
			if(empty($o)){
				$oo[] = "Network is unreachable";
			}else
			for($i=0; $i<count($o); $i++){
				$o[$i] = (str_replace("\n", "", $o[$i]));
				if(!empty($o[$i]))
				$oo[]=$o[$i];
			}
			$this->assign("traceinfo", $oo);
			$this->assign("ip", $ip);
		}
loading_end();
		$this->display("trace.tpl");
	}

	function String2File($sIn, $sFileOut) {
	  $rc = false;
	  do {
	   if (!($f = @fopen($sFileOut, "wa+"))) {
	     $rc = 1; 
	     alert_and_back('打开文件失败,请检查文件权限');
	     break;
	   }
	   if (!@fwrite($f, $sIn)) {
	     $rc = 2; 
	     //alert_and_back('写入文件失败,请检查文件权限');
	     break;
	   }
	   $rc = true;
	  } while (0);
	  if ($f) {
	   fclose($f);
	  }
	  return ($rc);
	}

	function Array2File($aIn, $sFileOut) {
	  return ($this->String2File(implode("", $aIn), $sFileOut));
	}
}
?>
