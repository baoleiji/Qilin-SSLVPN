<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_config extends c_base {
	function index() {
		$this->edit();
	}

	function get_config_by_name($content, $name) {
		$p1 = strpos($content,"\n$name = \"");
		if($p1 === false) {
			return '';
		}
		$p1 += strlen($name) + 4;
		$p2 = strpos($content, "\"", $p1 + 1);
		while($content[$p2 + 1] == '"') {
			$p2 = strpos($content, "\"", $p2 + 2);
		}
		return substr($content, $p1 + 1, $p2 - $p1 - 1);
	}
	
	function server_edit() {
		$filename = $this->config['site']['SERVER_CONF'];
		if(!file_exists($filename)) {
			die("$filename 不存在");
		}

		if(!($filecontent = file_get_contents($filename))) {
			die("$filename 无法打开");
		}
		$filecontent = "\n" . $filecontent;
		$server_config = array();
		$server_config['bind'] = $this->get_config_by_name($filecontent, 'bind');
		$server_config['mysql_host'] = $this->get_config_by_name($filecontent, 'mysql_host');
		$server_config['mysql_user'] = $this->get_config_by_name($filecontent, 'mysql_user');
		$server_config['mysql_pass'] = $this->get_config_by_name($filecontent, 'mysql_pass');
		$server_config['mysql_data'] = $this->get_config_by_name($filecontent, 'mysql_data');
		$server_config['mysql_sock'] = $this->get_config_by_name($filecontent, 'mysql_sock');
		$server_config['sql_start_session'] = $this->get_config_by_name($filecontent, 'sql_start_session');
		$server_config['sql_user'] = $this->get_config_by_name($filecontent, 'sql_user');
		$server_config['sql_end_session'] = $this->get_config_by_name($filecontent, 'sql_end_session');
		$server_config['sql_command'] = $this->get_config_by_name($filecontent, 'sql_command');
		$server_config['sql_luser'] = $this->get_config_by_name($filecontent, 'sql_luser');
		$this->assign('config', $server_config);
		$this->display("server_config.tpl");	
	}

	function server_save() {
		$server_config = array();
		$server_config['bind'] = $_POST['bind'];
		$server_config['mysql_host'] = $_POST['mysql_host'];
		$server_config['mysql_user'] = $_POST['mysql_user'];
		$server_config['mysql_pass'] = $_POST['mysql_pass'];
		$server_config['mysql_data'] = $_POST['mysql_data'];
		$server_config['mysql_sock'] = $_POST['mysql_sock'];
		$server_config['sql_start_session'] = $_POST['sql_start_session'];
		$server_config['sql_user'] = $_POST['sql_user'];
		$server_config['sql_end_session'] = $_POST['sql_end_session'];
		$server_config['sql_command'] = $_POST['sql_command'];
		$server_config['sql_luser'] = $_POST['sql_luser'];
		$file_content = '';
		while(list($key, $value) = each($server_config)) {
			$file_content .= "$key = \"$value\"\n";
		}
		//var_dump($file_content);
		
		$filename = $this->config['site']['SERVER_CONF'];
		if(!file_put_contents($filename, $file_content)) {
			alert_and_back("保存失败");
		}
		else {
			alert_and_back("保存成功", "admin.php?controller=admin_config&action=server_edit");
		}
	}
	function login_times(){
		global $_CONFIG;
		$config = $this->setting_set->select_all(" sname='password_policy'");
		
		$filename = $_CONFIG['FREESVR_UDF'];
		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "encrypt"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['encrypt'] = trim($tmp[1]);
				}
				if(strstr(strtolower($lines[$ii]), "debug"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['debug'] = trim($tmp[1]);
				}
				if(strstr(strtolower($lines[$ii]), "nr_minute"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['nr_minute'] = trim($tmp[1]);
				}
			}
		}
		else
		{
			alert_and_back('配置文件不存在');
			exit;
		}
		unset($lines);

		$this->assign("loginsetting", unserialize($config[0]['svalue']));
		$this->assign("sid", $config[0]['sid']);
		$this->assign("udf", $network);
		$this->display('config_login.tpl');
	}
	function login_save(){
		global $_CONFIG;
		$id = get_request('id',1,1);
		$times = get_request('login_times',1,0);
		$login_times_last = get_request('login_times_last',1,0);
		$length = get_request('login_pwd_length',1,0);
		$logintimeout = get_request('logintimeout',1,0);
		$oldpassnumber = get_request('oldpassnumber',1,0);
		$repeatnumber = get_request('repeatnumber',1,0);
		$pwdautolength = get_request('pwdautolength',1,0);
		$pwdstrong1 = get_request('pwdstrong1',1,0);
		$pwdstrong2 = get_request('pwdstrong2',1,0);
		$pwdstrong3 = get_request('pwdstrong3',1,0);
		$pwdstrong4 = get_request('pwdstrong4',1,0);
		$pwdexpired = get_request('pwdexpired',1,0);
		$pwdahead = get_request('pwdahead',1,0);
		$onlinecountmax = get_request('onlinecountmax',1,0);

		$filename = $_CONFIG['FREESVR_UDF'];
		$encrypt = get_request('encrypt',1,1);
		$encrypt2 = get_request('encrypt2',1,1);
		$debug = get_request('debug',1,1);
		$nr_minute = get_request('nr_minute',1,0);
			
		
		if(!ctype_digit($logintimeout)|| $logintimeout <1){
			alert_and_back('时间请输入大于1的整数');
			exit;
		}
		if(!ctype_digit($times)|| $times <1 ){
			alert_and_back("次数输入大于1的整数");
			exit;
		}
		if(!ctype_digit($login_times_last)|| $login_times_last <1 ){
			alert_and_back("错误锁定时间输入大于1的整数");
			exit;
		}
		if(!ctype_digit($length) || ($length <1 )  ){
			alert_and_back("密码最小长度输入大于1的整数");
			exit;
		}
		if(!ctype_digit($pwdautolength)){
			alert_and_back('自动长度请输入整数');
			exit;
		}		
		if(!ctype_digit($oldpassnumber)|| $oldpassnumber <1){
			alert_and_back('记忆旧密码次数请输入大于1的整数');
			exit;
		}
		if(!ctype_digit($repeatnumber)|| $repeatnumber <0){
			alert_and_back('记忆密码最大重复字符请输入非负整数');
			exit;
		}
		if(!ctype_digit($pwdexpired)|| $pwdexpired <1){
			alert_and_back('密码有效期请输入大于1的整数');
			exit;
		}
		if(!ctype_digit($pwdahead)){
			alert_and_back('提前天数请输入整数');
			exit;
		}
		if(!ctype_digit($onlinecountmax)|| $onlinecountmax <1){
			alert_and_back('相同用户允许同时登录的最大值请输入大于1的整数');
			exit;
		}
		if(!ctype_digit($pwdstrong1)|| $pwdstrong1 <0||!ctype_digit($pwdstrong2)|| $pwdstrong2 <0||!ctype_digit($pwdstrong3)|| $pwdstrong3 <0||!ctype_digit($pwdstrong4)|| $pwdstrong4 <0){
			alert_and_back('密码强度请输入大于等于0的整数');
			exit;
		}
		if(!ctype_digit($pwdahead)|| $pwdahead <0){
			alert_and_back('密码有效期,提前通知的天数大于等于0');
			exit;
		}
		$pwd['login_times']=$times;$pwd['login_times_last']=$login_times_last;$pwd['login_pwd_length']=$length;$pwd['logintimeout']=$logintimeout;$pwd['pwdautolength']=$pwdautolength;
		$pwd['pwdstrong1']=$pwdstrong1;$pwd['pwdstrong2']=$pwdstrong2;$pwd['pwdstrong3']=$pwdstrong3;$pwd['pwdstrong4']=$pwdstrong4;
		$pwd['pwdexpired']=$pwdexpired;$pwd['pwdahead']=$pwdahead;$pwd['onlinecountmax']=$onlinecountmax;$pwd['oldpassnumber']=$oldpassnumber;$pwd['repeatnumber']=$repeatnumber;
		//print_r($pwd);
		$newsetting = new setting();
		$newsetting->set_data('sid', $id);
		$newsetting->set_data('svalue', serialize($pwd));		
		$this->setting_set->edit($newsetting);

		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "encrypt"))
				{
					//$tmp = preg_split("/[\s]+/", $lines[$ii]);
					//$lines[$ii] = str_replace($tmp[1], $encrypt, $lines[$ii]);
				}
				if(strstr(strtolower($lines[$ii]), "debug"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $debug, $lines[$ii]);
				}
				if(strstr(strtolower($lines[$ii]), "nr_minute"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $nr_minute, $lines[$ii]);
				}
			}
			
		}
		else
		{
			echo ('配置文件不存在或没有权限');
			exit;
		}
		if($encrypt!=$encrypt2){
			if($encrypt=='no'){
				$this->setting_set->query("UPDATE member set `password`=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? 'udf_decrypt(password)' : "AES_DECRYPT(password,'".$_CONFIG['PASSWORD_KEY']."')"));
				$this->setting_set->query("UPDATE devices set `cur_password`=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? 'udf_decrypt(cur_password)' : "AES_DECRYPT(cur_password,'".$_CONFIG['PASSWORD_KEY']."')").", `old_password`=".($_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? 'udf_decrypt(old_password)' : "AES_DECRYPT(old_password,'".$_CONFIG['PASSWORD_KEY']."')"));
			}
		}
		$this->Array2File($lines,$filename);
		if($encrypt!=$encrypt2){
			if($encrypt=='yes'){
				$this->setting_set->query("UPDATE member set `password`=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? 'udf_encrypt(password)' : "AES_ENCRYPT(password,'".$_CONFIG['PASSWORD_KEY']."')"));
				$this->setting_set->query("UPDATE devices set `cur_password`=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? 'udf_encrypt(cur_password)' : "AES_ENCRYPT(cur_password,'".$_CONFIG['PASSWORD_KEY']."')").", `old_password`=".($_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? 'udf_encrypt(old_password)' : "AES_ENCRYPT(old_password,'".$_CONFIG['PASSWORD_KEY']."')"));
			}
		}
		alert_and_back('设置成功','admin.php?controller=admin_config&action=login_times');
		
	}
	
	function prompts_edit() {
		$config = $this->prompts_set->select_all();
		$this->assign('config', $config);
		$this->display("prompts_config.tpl");
	}	

	function prompts_add() {
		$new_ip = $_POST['new_ip'];
		$new_start = $_POST['new_start'];
		$new_end1 = $_POST['new_end1'];
		$new_end2 = $_POST['new_end2'];
		$new_end3 = $_POST['new_end3'];
		$new_end4 = $_POST['new_end4'];
		$new_end5 = $_POST['new_end5'];

		if($new_ip == '' && $new_start == '' && $new_end1 == '' && $new_end2 == '' && $new_end3 == '' && $new_end4 == '' & $new_end5 == '') {
			alert_and_back("标记不能都为空，添加失败", "admin.php?controller=admin_config&action=prompts_edit");
		}
		else {
			if($this->prompts_set->select_count("ip = '$new_ip' AND start = '$new_start' AND end1 = '$new_end1' AND end2 = '$new_end2' AND end3 = '$new_end3' AND end4 = '$new_end4' AND end5 = '$new_end5'") > 0) {
				alert_and_back("相同的标记已存在，添加失败", "admin.php?controller=admin_config&action=prompts_edit");
			}
			else {
				$prompt = new prompts();
				$prompt->set_data("ip", $new_ip);
				$prompt->set_data("start", $new_start);
				$prompt->set_data("end1", $new_end1);
				$prompt->set_data("end2", $new_end2);
				$prompt->set_data("end3", $new_end3);
				$prompt->set_data("end4", $new_end4);
				$prompt->set_data("end5", $new_end5);
				$this->prompts_set->add($prompt);
				alert_and_back("添加成功", "admin.php?controller=admin_config&action=prompts_edit");
			}
		}
	}
	
	function prompts_save() {
		$id = $_POST['id'];
		$ip = $_POST['ip'];
		$start = $_POST['start'];
		$end1 = $_POST['end1'];
		$end2 = $_POST['end2'];
		$end3 = $_POST['end3'];
		$end4 = $_POST['end4'];
		$end5 = $_POST['end5'];

		for($i = 0; $i < count($start); $i++) {
			if($ip[$i] == '' && $start[$i] == '' && $end1[$i] == '' && $end2[$i] == '' && $end3[$i] == '' && $end4[$i] == '' && $end5[$i] == '') {
				$this->prompts_set->delete($id[$i]);
			}
			else {
				if($this->prompts_set->select_count("ip='".$ip[$i]."' and id<>".$id[$i]) > 0)
				{
	                alert_and_back($ip[$i]."已经存在,保存失败","admin.php?controller=admin_config&action=prompts_edit");
				}
				$prompt = new prompts();
				$prompt->set_data("id", $id[$i]);
				$prompt->set_data("ip", $ip[$i]);
				$prompt->set_data("start", $start[$i]);
				$prompt->set_data("end1", $end1[$i]);
				$prompt->set_data("end2", $end2[$i]);
				$prompt->set_data("end3", $end3[$i]);
				$prompt->set_data("end4", $end4[$i]);
				$prompt->set_data("end5", $end5[$i]);
				$this->prompts_set->edit($prompt);
			}
		}
		alert_and_back("保存成功", "admin.php?controller=admin_config&action=prompts_edit");

	}
	
	function ip_list() {
		$ips = $this->ip_set->select_all();
		$this->assign('ip',$ips);
		$this->assign('ipcount',count($ips));	
		$this->display('ip_list.tpl');	
	}	
	
	function add_ip() {
		if(get_request('newip',1 ,1) == '') {
			alert_and_back("错误的输入", "admin.php?controller=admin_config&action=ip_list");
			exit();		
		}
		$tip = get_request('newip',1 ,1);
		if($this->ip_set->select_count() == 10) {
			alert_and_back("ip数最多10个", "admin.php?controller=admin_config&action=ip_list");
			exit();
		}
		elseif($this->ip_set->select_count("ip = '$tip'")) {
			alert_and_back("此ip已在列表中", "admin.php?controller=admin_config&action=ip_list");
			exit();
		}
		else {
			$newip = new ip();
			$newip->set_data('ip',$tip);			
			if($newip->get_errnum() == 0) {
				$this->ip_set->add($newip);
				alert_and_back("添加成功", "admin.php?controller=admin_config&action=ip_list");			
			}
			else {
				alert_and_back($newip->get_firsterr(), NULL, 1);
				exit();
			}			
		}
		
	}

	function delete_ip() {
		if(get_request('id') == '') {
			alert_and_back("错误的输入", "admin.php?controller=admin_config&action=ip_list");
			exit();
		}		
		$this->ip_set->delete(get_request('id'));
		alert_and_back("删除成功", "admin.php?controller=admin_config&action=ip_list");
		exit();
	}

	function delete_all_ip() {
		$id = get_request('chk_ip', 1, 1);
		$this->ip_set->delete($id);
		alert_and_back('成功删除所选ip');
	}
	
	function proxyip_list() {
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'source';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		$where = '1=1';
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION['QUERY_STRING']);
		$row_num = $this->proxyip_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$ips = $this->proxyip_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);		
		
		//$ips = $this->proxyip_set->select_all('1=1','id','ASC');
		$this->assign('ip',$ips);
		$this->assign('ipcount',count($ips));	
		$this->display('proxyip_list.tpl');	
	}	
	
	function proxyip_save() {
		$id = get_request("id", 1, 0);
		$source = get_request("source", 1, 1);
		$network = get_request("network", 1, 1);
		$proxyip = get_request("proxyip", 1, 1);
		if(!is_ip($source) || !is_ip($network) || !is_ip($proxyip)) {
			alert_and_back("错误的输入", "admin.php?controller=admin_config&action=proxyip_list");
			exit();		
		}
		if($this->proxyip_set->select_count("source = '$source' AND id!='$id'")) {
			alert_and_back("此来源地址已在列表中", "admin.php?controller=admin_config&action=proxyip_list");
			exit();
		}
		else {
			$newproxyip = new proxyip();
			$newproxyip->set_data('source',$source);
			$newproxyip->set_data('network',$network);
			$newproxyip->set_data('proxyip',$proxyip);			
			if($newproxyip->get_errnum() == 0) {
				if(empty($id)){
					$this->proxyip_set->add($newproxyip);
					alert_and_back("添加成功", "admin.php?controller=admin_config&action=proxyip_list");	
					exit();	
				}else{
					$newproxyip->set_data('id',$id);
					$this->proxyip_set->edit($newproxyip);
					alert_and_back("修改成功", "admin.php?controller=admin_config&action=proxyip_list");	
					exit();
				}
			} else {
				alert_and_back($newproxyip->get_firsterr(), NULL, 1);
				exit();
			}
		}
	}
	function proxyip_delete() {
		$id = get_request('id');
		$this->proxyip_set->delete($id);
		alert_and_back('成功删除所选ip');
	}
	
	function proxyip_edit() {
		$id = get_request('id');
		$p = $this->proxyip_set->select_by_id($id);
		$this->assign("p", $p);
		$this->display('proxyip_edit.tpl');	
	}

	function appserver_list() {
		global $_CONFIG;
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		exec("sudo /opt/freesvr/audit/sbin/license-print", $out, $return);
		$_o = explode(' ', $out[0]);
		$_p = explode('-', $_o[3]);
		if(empty($_p[4])){
			alert_and_back("Licenses不包含应用发布");
			exit;
		}
		if(empty($orderby1)){
			$orderby1 = 'name';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = '1=1';
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND appserverip IN ('".implode("','", $alltmpip)."')";
			}
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION['QUERY_STRING']);
		$row_num = $this->appserver_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$ips = $this->appserver_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);		
		
		$this->assign('apppub',$ips);
		$this->assign('appcount',count($apppub));	
		$this->display('appserver_list.tpl');	
	}	
	
	function appserver_save() {
		global $_CONFIG;
		$id = get_request("id", 1, 0);
		$name = get_request("name", 1, 1);
		$appserverip = get_request("appserverip", 1, 1);
		$description = get_request("description", 1, 1);
		if(empty($name) || !is_ip($appserverip)) {
			alert_and_back("错误的输入");
			exit();		
		}
		if($this->appserver_set->select_count("appserverip = '$appserverip' AND id!='$id'")) {
			alert_and_back("此路径已在列表中");
			exit();
		}
		else {
			$newappserver = new appserver();
			$newappserver->set_data('name',$name);
			$newappserver->set_data('appserverip',$appserverip);
			$newappserver->set_data('description',$description);
			$iptablefile = $_CONFIG['IPTABLES'];
			$lines = @file($iptablefile);
			$endline=0;
			for($ii=0; $ii<count($lines); $ii++)
			{
				if(empty($endline)){
					if(strstr(strtolower($lines[$ii]), "#app config start"))
					{
						$foundoppositeip=1;
						$startapp = 1;
					}
					if(!empty($startapp)&&empty($endapp)){
						$tmp = preg_split("/[\s]+/", $lines[$ii]);//var_dump($tmp);
						if($tmp[3]==$appserverip){
							$lines[$ii]="-A  RH-Firewall-1-INPUT -s  $appserverip  -j ACCEPT\n";
							$foundip = 1;
						}
					}								
					if(strstr(strtolower($lines[$ii]), "#app config end"))
					{
						$endapp = 1;
						$linenum = $ii;
					}				

					if(strstr(strtolower($lines[$ii]), "state --state established,related")){
						$endline = $ii;
					}
				}
			}
			$copy_line = count($lines);
			if(empty($foundip)){
				if($endapp){
					while(!empty($linenum)&&$copy_line>=$linenum){
						$lines[$copy_line--]=$lines[$copy_line];
					}
					$lines[$linenum]="-A  RH-Firewall-1-INPUT -s  $appserverip  -j ACCEPT\n";
				}
				else{
					$copy_line--;
					$lines[$copy_line+1]="\n";
					$lines[$copy_line+2]="\n";
					$lines[$copy_line+3]="\n";
					while(!empty($endline)&&$copy_line>=$endline){
						$lines[$copy_line+3]=$lines[$copy_line];
						$copy_line--;
					}
					$lines[$endline-3]="#app config start\n";
					$lines[$endline-2]="-A  RH-Firewall-1-INPUT -s  $appserverip  -j ACCEPT\n";
					$lines[$endline-1]="#app config end\n";
				}
			}
			$this->Array2File($lines,$iptablefile);
			unset($lines);
			if($_CONFIG['SYSTEMVERSION_IPTABLES']==7){
				exec("sudo /usr/bin/systemctl restart iptables");
			}else{
				exec("sudo /etc/init.d/iptables restart");
			}
			if($newappserver->get_errnum() == 0) {
				if(empty($id)){
					$this->appserver_set->add($newappserver);
					if($this->server_set->select_count("device_ip='$appserverip'")<=0){
						$this->server_set->query("INSERT INTO `servers`(`device_ip`,`login_method`,`hostname`,`device_type`,`week`,`month`,`user_define`,`groupid`,`asset_id`,`ipv6`,`snmpnet`,`port`,`superpassword`,`transport`,`sshport`,`telnetport`,`ftpport`,`snmpkey`,`monitor`,`port_monitor_time`,`port_monitor`,`rdpport`,`vncport`,`x11port`,`asset_name`,`asset_specification`,`asset_department`,`asset_location`,`asset_company`,`asset_start`,`asset_usedtime`,`asset_warrantdate`,`asset_status`,`oracle_name`) VALUES('$appserverip','0','$name','4','0','1','0','0','0','0','0','0','','0','22','23','21','','0','0','','3389','5900','3389','','','','','','','','','','')");
						$this->server_set->query("INSERT INTO `devices`(`device_ip`,`hostname`,`port`,`username`,`old_password`,`cur_password`,`last_update_time`,`device_type`,`enable`,`limit_time`,`automodify`,`luser`,`commanduser`,`login_method`,`mode`,`lgroup`,`logincommit`,`autosu`,`radiususer`,`master_user`,`sftp`,`entrust_password`,`entrust_username`,`publickey_auth`,`encoding`) VALUES('$appserverip','$name','3389','','','','0000-00-00','4','1','9999-00-00','0',',','15','26','0',',','0','0','0','0','0','1','1','0','0')");

					}elseif($this->devpass_set->select_count("device_ip='$appserverip'")<=0){
						$this->server_set->query("INSERT INTO `devices`(`device_ip`,`hostname`,`port`,`username`,`old_password`,`cur_password`,`last_update_time`,`device_type`,`enable`,`limit_time`,`automodify`,`luser`,`commanduser`,`login_method`,`mode`,`lgroup`,`logincommit`,`autosu`,`radiususer`,`master_user`,`sftp`,`entrust_password`,`entrust_username`,`publickey_auth`,`encoding`) VALUES('$appserverip','$name','3389','','','','0000-00-00','4','1','9999-00-00','0',',','15','26','0',',','0','0','0','0','0','1','1','0','0')");
					}
					alert_and_back("添加成功", "admin.php?controller=admin_config&action=appserver_list");	
					exit();	
				}else{
					$oldapp = $this->appserver_set->select_by_id($id);
					$newappserver->set_data('id',$id);
					$this->appserver_set->edit($newappserver);
					alert_and_back("修改成功", "admin.php?controller=admin_config&action=appserver_list");	
					exit();
				}
			} else {
				alert_and_back($newappserver->get_firsterr(), NULL, 1);
				exit();
			}
		}
	}
	function appserver_delete() {
		$id = get_request('id');	
		$users=$this->apppub_set->select_count('appserverip IN (SELECT appserverip FROM apppserver WHERE id IN ('.$id.'))');
		if($users>0){
			alert_and_back('该应用已经绑定用户,请先删除用户');
			exit;
		}
		
		$this->appmember_set->delete_all(" appdeviceid IN(SELECT id FROM apppub WHERE appserverip=(SELECT appserverip FROM apppserver WHERE id=$id))");
		$this->appgroup_set->delete_all(" appdeviceid IN(SELECT id FROM apppub WHERE appserverip=(SELECT appserverip FROM apppserver WHERE id=$id))");
		$this->apppub_set->delete_all('appserverip IN (SELECT appserverip FROM apppserver WHERE id IN ('.$id.'))');
		$this->appresgroup_set->delete_all(" appdevicesid IN (SELECT id FROM apppub WHERE appserverip=(SELECT appserverip FROM apppserver WHERE id=$id))");
		$this->luser_appresourcegrp_set->delete_all(" appresourceid NOT IN (SELECT id FROM appresourcegroup )");
		$this->lgroup_appresourcegrp_set->delete_all(" appresourceid NOT IN (SELECT id FROM appresourcegroup)");
		$this->appserver_set->delete($id);
		alert_and_back('成功删除');
	}
	
	function appserver_edit() {
		$id = get_request('id');
		$p = $this->appserver_set->select_by_id($id);
		$pserver = $this->devpass_set->base_select("SELECT distinct device_ip FROM ".$this->devpass_set->get_table_name()." WHERE login_method=26");
		$this->assign("p", $p);
		$this->assign("pserver", $pserver);
		$this->display('appserver_edit.tpl');	
	}
	
	function apppub_list() {
		global $_CONFIG;
		$page_num = get_request('page');
		$appserverip = get_request('ip', 0, 1);
		$device_ip = get_request('device_ip', 0, 1);
		$hostname = get_request('hostname', 0, 1);
		$program = get_request('program', 0, 1);
		$device_ip = get_request('device_ip', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'name';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = "1";
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION['QUERY_STRING']);

		if($appserverip){
			$where .= " AND appserverip='".$appserverip."'";
		}
		if($device_ip){
			$where .= " AND s.device_ip like '%".$device_ip."%'";
		}		
		if($hostname){
			$where .= " AND s.hostname like '%".$hostname."%'";
		}
		if($program){
			$where .= " AND appprogramname like '%".$program."%'";
		}
		
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			$alltmpip = array(0);
			if($_SESSION['ADMIN_MSERVERGROUP']){
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
				for($i=0; $i<count($allips); $i++){
					$alltmpip[]=$allips[$i]['device_ip'];
				}
			}
			$where .= " AND s.device_ip IN ('".implode("','", $alltmpip)."')";
		}
		
		$row_num = $this->apppub_set->base_select("SELECT count(*) ct FROM apppub a LEFT JOIN appdevices b ON a.id=b.apppubid LEFT JOIN ".$this->server_set->get_table_name()." s ON b.device_ip=s.device_ip WHERE b.id IS NOT NULL AND $where");
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		//$ips = $this->apppub_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$ips = $this->apppub_set->base_select("SELECT a.*,b.device_ip,b.username,b.id appdevicesid FROM apppub a LEFT JOIN appdevices b ON a.id=b.apppubid LEFT JOIN ".$this->server_set->get_table_name()." s ON b.device_ip=s.device_ip WHERE b.id IS NOT NULL AND $where ORDER BY $orderby1 $orderby2  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);		
		
		$this->assign('apppub',$ips);
		$this->assign('appserverip',$appserverip);
		$this->assign('appcount',count($apppub));	
		$this->display('apppub_list.tpl');	
	}	
	
	function apppub_save() {//var_dump($_POST);
		//var_dump(mysql_query("UPDATE `apppub` SET `name` = 'httpd',`path` = 'C:\\Program Files\\Internet Explorer\\iexplore.exe',`description` = '',`appserverip` = '127.0.0.1',`appprogramname` = 'IE',`autologinflag` = '3',`url` = 'https://172.16.212.171/dep/admin.php?controller=admin_index&action=login' WHERE id = '124'"));exit;
		$appserverip = get_request('appserverip', 0, 1);
		if(empty($appserverip)){
			$appserverip = get_request('appserverip', 1, 1);
		}
		$id = get_request("id", 0, 1);
		$name = get_request("name", 1, 1);
		$path = get_request("path", 1, 1);
		$url = get_request("url", 1, 1);
		$autologinflag = get_request("autologinflag", 1, 1);
		$description = get_request("description", 1, 1);
		if(empty($name) || empty($path)) {
			alert_and_back("请输入名称和路径", "admin.php?controller=admin_config&action=apppub_edit&id=$id&appserverip=$appserverip&device_ip=".get_request('device_ip', 0, 1));
			exit();		
		}
		
		else {
			$appprogram = $this->appprogram_set->select_by_id($autologinflag);
			$newapppub = new apppub();
			$newapppub->set_data('name',$name);
			$newapppub->set_data('appserverip',$appserverip);
			$newapppub->set_data('path',html_entity_decode($path));
			$newapppub->set_data('appprogramname',$appprogram['name']);
			$newapppub->set_data('description',$description);	
			$newapppub->set_data('autologinflag',$appprogram['autologin']);
			$newapppub->set_data('url',html_entity_decode($url));	

			if(!($apppubexist = $this->devpass_set->select_all("device_ip='$appserverip' AND login_method=26"))){
				alert_and_back("设备".$appserverip."没有应用发布账号", "admin.php?controller=admin_config&action=apppub_list&device_ip=".get_request('device_ip', 0, 1));
				exit();	
			}
			
		
			if($newapppub->get_errnum() == 0) {
				if(empty($id)){
					$this->apppub_set->add($newapppub);
					$this->appdevice_save(mysql_insert_id(), $apppubexist);
					//alert_and_back("添加成功", "admin.php?controller=admin_config&action=apppub_list&ip=$appserverip");	
					exit();	
				}else{
					$newapppub->set_data('id',$id);
					$this->apppub_set->edit($newapppub);
					$this->appdevice_save($id, $apppubexist);
					//alert_and_back("修改成功", "admin.php?controller=admin_config&action=apppub_list&ip=$appserverip");	
					exit();
				}
			} else {
				alert_and_back($newapppub->get_firsterr(), NULL, 1);
				exit();
			}
		}
	}
	function apppub_delete() {
		$id = array(get_request('id'));
		if($_POST['chk_member']){
			$id = $_POST['chk_member'];
		}
		$users=$this->appdevice_set->select_count('apppubid IN('.implode(',',$id).')');
		if($users>0){
			//alert_and_back('该应用已经绑定用户,请先删除用户');
			//exit;
		}
		$this->appresgroup_set->delete_all(' appdevicesid IN (SELECT id FROM appdevices WHERE apppubid IN ('.implode(',',$id).'))');
		$this->luser_appresourcegrp_set->delete_all(" appresourceid NOT IN (SELECT id FROM appresourcegroup )");
		$this->lgroup_appresourcegrp_set->delete_all(" appresourceid NOT IN (SELECT id FROM appresourcegroup )");
		$this->apppub_set->delete($id);
		$this->appdevice_delete($id);
		alert_and_back('成功删除');
	}
	
	function apppub_edit() {
		global $_CONFIG;
		$appserverip = get_request('appserverip', 0, 1);
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$p = $this->apppub_set->select_by_id($id);
		//$allmem = $this->member_set->select_all('level = 0','username','ASC');
		$appprogram = $this->appprogram_set->select_all('1', 'name', 'asc');


		$allmem = $this->member_set->select_all("level!=11 AND uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''),'username','ASC');
		
		$this->assign("pp", $p);
		$this->assign('id',$id);
		$this->assign("appprogram", $appprogram);
		$this->assign("appserverip", $appserverip);
		$this->assign("allmem", $allmem);
		$this->assign("usergroup", $usergroup);		
		$this->assign('sessionluser', $sessionluser);
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->assign('fromapp', $from);
		//$this->display('apppub_edit.tpl');	
		$appdevice = $this->appdevice_set->select_all("apppubid=".$id, 'device_ip', 'asc');
		if($appdevice){
			$appdeviceid = $appdevice[0]['id'];
		}else{
			$appdeviceid = 0;
		}

		$this->assign("appserverips", $this->appserver_set->select_all('1', 'appserverip', 'asc'));
		$this->appdevice_edit($appserverip, $id,$appdeviceid);
	}

	function apppubexport(){
		global $_CONFIG;
		$ip = get_request('appserverip', 0, 1);
		$where = '1=1';
		if($ip){
			$where .= " AND appserverip='$ip'";
		}
		$result = $this->apppub_set->base_select("SELECT a.username,a.device_ip,c.groupid,AES_ENCRYPT(a.cur_password,'".$_CONFIG['PASSWORD_KEY']."') password,b.name,b.path,b.appprogramname,b.url,b.description FROM ".$this->appdevice_set->get_table_name()." a LEFT JOIN ".$this->apppub_set->get_table_name()." b ON a.apppubid=b.id LEFT JOIN ".$this->server_set->get_table_name()." c ON a.device_ip=c.device_ip WHERE $where");
		//$handle = @fopen('/tmp/member.xls', 'w');
		
		
		$str = language("应用名称").",";
		$str .= language("用户名").",";
		$str .= language("密码").",";
		$str .= language("服务器IP").",";
		$str .= language("设备组").",";
		$str .= language("程序名称").",";
		$str .= language("URL").",";
		$str .= language("描述");
		$str .= "\n";
		$row = 1;
		for($i=0; $i<count($result); $i++){
			$result[$i]['groupname']='';
			if($result[$i]['groupid']){
				$_groups = $this->sgroup_set->select_all("groupname=(select groupname from ".$this->sgroup_set->get_table_name()." WHERE id=".$result[$i]['groupid'].")");
				if(count($_groups)>1){
					$result[$i]['groupname']=$_groups[0]['groupname'].'(('.$result[$i]['groupid'].'))';
				}elseif($_groups){
					$result[$i]['groupname']=$_groups[0]['groupname'];
				}
			}
			$str .= $result[$i]['name'].",".$result[$i]['username'].",".$result[$i]['password'].",".$result[$i]['device_ip'].",".$result[$i]['groupname'].",".$result[$i]['appprogramname'].",".$result[$i]['url'].",".$result[$i]['description']."\n";
		}
		$str = mb_convert_encoding($str, "GB2312", "UTF-8");
		
		//fclose($handle);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=audit-apppub-".date('Ymd').".csv"); 
		echo $str;
		exit;
	}

	function apppubimport(){
		$appserverip = get_request('appserverip', 0, 1);
		$this->assign("appserverip", $appserverip);
		$this->display("importapppub.tpl");
	}
	
	function doapppubimport(){
		global $_CONFIG;
		$appserverip = get_request('appserverip', 0, 1);
		$device_ip = get_request('device_ip', 0, 1);
		if($_FILES['apppub']['error']==1 or $_FILES['apppub']['error']==2){
			alert_and_back("上传得文件超过系统限制");
			exit;
		}
		if(!is_uploaded_file($_FILES['apppub']['tmp_name']))
		{
			alert_and_back("请上传文件");
			exit;
		}
		
		$lines = file($_FILES['apppub']['tmp_name']);	
		$importfile = $_CONFIG['IMPORTFILEPATH'].'/'.time().'.'.$_FILES['apppub']['name'];
		if(move_uploaded_file($_FILES['apppub']['tmp_name'], $importfile)){
			$importlog = new importlog();
			$importlog->set_data('file', $importfile);
			$importlog->set_data('type', 'apppub');
			$this->importlog_set->add($importlog);
		}else{
			//echo '<script>导入文件备份失败，请联系管理员</script>';
		}
		for($i=1; $i<count($lines); $i++){
			$lines[$i] = iconv("GBK", "UTF-8", $lines[$i]);

			if(trim($lines[$i])==""){
				continue;
			}
			$linearr = explode (",",trim($lines[$i]));
			if(empty($linearr[0])){
				continue;
			}
			$groupname=$linearr[4];
			if(strpos($groupname,'((')===false){
				if($this->sgroup_set->select_count("groupname='".$groupname."'")>1){
					$error[]=$linearr[0].' '.$groupname.' '.':'.'有重复组请输入组ID';
					continue;
				}
				$_group = $this->sgroup_set->select_all("groupname='".$groupname."'");
				$groupid=$_group[0]['id'];
			}else{				
				$groupid=substr($groupname, strpos($groupname,'((')+2, strpos($groupname,'))')-strpos($groupname,'((')-2);
			}
			if(empty($groupid)){
				$error[]=$linearr[0].' '.$groupname.' '.':'.'组不存在';
				continue;
			}
			$insertservers = "INSERT INTO ".$this->server_set->get_table_name()."(device_ip,hostname,groupid) values";
			$insertserverslen = strlen($insertservers);

			$server = $this->server_set->select_all("device_ip='".$linearr[3]."'");
			if(empty($server)){
				$insertservers .= "('".$linearr[3]."','".$linearr[3]."','".$groupid."'),";
			}else{
				$new_dev = new server();
				$new_dev->set_data('id',$server[0]['id']);
				$new_dev->set_data('groupid',$groupid);
				//$new_dev->set_data('superpassword', $this->member_set->udf_encrypt(addslashes($current_password)));
				$this->server_set->edit($new_dev);
			}
			if(strlen($insertservers)>$insertserverslen){
				//echo substr($insertservers,0,strlen($insertservers)-1);
				$this->server_set->query(substr($insertservers,0,strlen($insertservers)-1));
			}

			$appprogram = $this->appprogram_set->select_all("name='".$linearr[5]."'" );
			
			if($info=$this->apppub_set->select_all("name='".$linearr[0]."' AND appserverip='$appserverip'" )){
				//$keyexists[]=$linearr[0]."\n";
				for($info_i=0; $info_i<count($info); $info_i++){
					$insertstr = "UPDATE ".$this->apppub_set->get_table_name()." set appprogramname='".$linearr[5]."',path='".addslashes($appprogram[0]['path'])."',url='$linearr[6]',description='$linearr[7]' where id=".$info[$info_i]['id'];
					$this->apppub_set->query($insertstr);
					$linearr[2]=$this->apppub_set->udf_encrypt($linearr[2]);
					$insertstr1 = "UPDATE ".$this->appdevice_set->get_table_name()." set username='$linearr[1]',cur_password='$linearr[2]',device_ip='$linearr[3]' where apppubid=".$info[$info_i]['id'];
					$this->apppub_set->query($insertstr1);
				}
				continue;
			}	
			if(empty($appprogram)){
				$error[]=$linearr[5]."应用程序不存在";
				continue;
			}				
			
			$insertstr = "INSERT INTO ".$this->apppub_set->get_table_name()."(name,appserverip,appprogramname,path,url,description) values('$linearr[0]','$appserverip','$linearr[5]','".addslashes($appprogram[0]['path'])."','$linearr[6]','$linearr[7]')";
			$this->apppub_set->query($insertstr);
			$apppubid = mysql_insert_id();
			if($apppubid){
				$linearr[2]=$this->apppub_set->udf_encrypt($linearr[2]);
				$insertstr1 = "INSERT INTO ".$this->appdevice_set->get_table_name()."(apppubid,username,cur_password,device_ip) values('$apppubid','$linearr[1]','$linearr[2]','$linearr[3]')";
				$this->apppub_set->query($insertstr1);
				$apppubid=0;
			}
		}
		//echo $insertstr;var_dump($j);var_dump($keyexists);exit;
		if($error){
			alert_and_back('导入失败:'.implode('\n', $error));
			exit;
		}
		alert_and_back('导入成功', "admin.php?controller=admin_config&action=apppub_list&ip=$appserverip&device_ip=".$device_ip);
	}


	function appprogram_list() {
		exec("sudo /opt/freesvr/audit/sbin/license-print", $out, $return);
		$_o = explode(' ', $out[0]);
		$_p = explode('-', $_o[3]);
		if(empty($_p[4])){
			alert_and_back("Licenses不包含应用发布");
			exit;
		}
		$page_num = get_request('page');
		$appserverip = get_request('ip', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'name';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = "1=1";
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION['QUERY_STRING']);
		$row_num = $this->appprogram_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$appprogram = $this->appprogram_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);		
		
		$this->assign('appprogram',$appprogram);
		$this->assign('appcount',count($appprogram));	
		$this->display('appprogram_list.tpl');	
	}	

	function appprogramexport($where='1'){
		$result = $this->appprogram_set->select_all();
		//$handle = @fopen('/tmp/member.xls', 'w');
		
		
		$str = language("应用名称").",";
		$str .= language("程序地址").",";
		$str .= language("自动登录").",";
		$str .= language("描述");
		$str .= "\n";
		$row = 1;
		for($i=0; $i<count($result); $i++){
			$str .= $result[$i]['name'].",".$result[$i]['path'].",".$result[$i]['autologin'].",".$result[$i]['description']."\n";
		}
		$str = mb_convert_encoding($str, "GB2312", "UTF-8");
		
		//fclose($handle);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=audit-appprogram-".date('Ymd').".csv"); 
		echo $str;
		exit;
	}

	function appprogramimport(){
		$this->display("importappprogram.tpl");
	}
	
	function doappprogramimport(){
		global $_CONFIG;
		if($_FILES['appprogram']['error']==1 or $_FILES['appprogram']['error']==2){
			alert_and_back("上传得文件超过系统限制");
			exit;
		}
		if(!is_uploaded_file($_FILES['appprogram']['tmp_name']))
		{
			alert_and_back("请上传文件");
			exit;
		}
		$lines = file($_FILES['appprogram']['tmp_name']);	
		$importfile = $_CONFIG['IMPORTFILEPATH'].'/'.time().'.'.$_FILES['appprogram']['name'];
		if(move_uploaded_file($_FILES['appprogram']['tmp_name'], $importfile)){
			$importlog = new importlog();
			$importlog->set_data('file', $importfile);
			$importlog->set_data('type', 'appprogram');
			$this->importlog_set->add($importlog);
		}else{
			//echo '<script>导入文件备份失败，请联系管理员</script>';
		}	
		$insertstr = "INSERT INTO ".$this->appprogram_set->get_table_name()."(name,path,autologin,description) values";
		for($i=1; $i<count($lines); $i++){
			$lines[$i] = iconv("GBK", "UTF-8", $lines[$i]);
			if(trim($lines[$i])==""){
				continue;
			}

			$linearr = explode (",",trim($lines[$i]));
			if(empty($linearr[0])||empty($linearr[1])){
				continue;
			}
			if($this->appprogram_set->select_count("name='".$linearr[0]."'") > 0){
				$keyexists[]=$linearr[0]."";
				continue;
			}
			if($j!=0){
				$insertstr .=",";
			}
			$j++;
			$insertstr .= "('$linearr[0]','".addslashes($linearr[1])."','$linearr[2]','$linearr[3]')";
		}
		//echo $insertstr;var_dump($j);var_dump($keyexists);exit;
		if($j&&$this->usbkey_set->query($insertstr)){
			alert_and_back('导入成功', "admin.php?controller=admin_config&action=appprogram_list");
		}else{
			alert_and_back('导入失败,请检查文件, 重复的key:\n'.(is_array($keyexists) ? implode('\n', $keyexists) : ''));
		}
	}

	function appprogram_save() {//var_dump($_POST);
		$id = get_request("id", 0, 1);
		$name = get_request("name", 1, 1);
		$path = get_request("path", 1, 1);
		$icon = get_request("icon", 1, 1);
		$autologin = get_request("autologin", 1, 0);
		$description = get_request("description", 1, 1);
		if(empty($name) || empty($path)) {
			alert_and_back("请输入名称和路径", "admin.php?controller=admin_config&action=appprogram_list");
			exit();		
		}
		
		else {
			$appprogram = new appprogram();
			$appprogram->set_data('name',$name);
			$appprogram->set_data('path',html_entity_decode($path));
			$appprogram->set_data('autologin',$autologin);
			$appprogram->set_data('description',$description);	
			$appprogram->set_data('icon',$icon);
		
			if($appprogram->get_errnum() == 0) {
				
				if(empty($id)){
					$this->appprogram_set->add($appprogram);
					
				}else{
					$old = $this->appprogram_set->select_by_id($id);
					$appprogram->set_data('id',$id);
					$this->appprogram_set->edit($appprogram);	
					if($old['autologin']!=$autologin){
						$this->appprogram_set->query("UPDATE apppub set autologinflag='".$autologin."' where autologinflag='".$old['autologin']."'");
					}
					alert_and_back("修改成功", "admin.php?controller=admin_config&action=appprogram_list&ip=$appserverip");	
					
				}
			} 
			$this->appprogram_set->query("UPDATE apppub SET path=(select path from appprogram where name='".$name."') where appprogramname='".$name."'");
			alert_and_back("添加成功", "admin.php?controller=admin_config&action=appprogram_list&ip=$appserverip");
		}
	}
	function appprogram_delete() {
		$id = array(get_request('id'));
		if($_POST['chk_member']){
			$id = $_POST['chk_member'];
		}
		$this->appprogram_set->delete($id);
		alert_and_back('成功删除');
	}
	
	function appprogram_edit() {
		global $_CONFIG;
		$appserverip = get_request('appserverip', 0, 1);
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$p = $this->appprogram_set->select_by_id($id);
		$icon = $this->appicon_set->select_all();
		$this->assign("p", $p);
		$this->assign('id',$id);
		$this->assign("appserverip", $appserverip);
		$this->assign("allmem", $allmem);
		$this->assign("usergroup", $usergroup);		
		$this->assign('sessionluser', $sessionluser);
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->assign('icon', $icon);
		$this->assign('fromapp', $from);
		$this->display('appprogram_edit.tpl');	
	}

	function appicon_list() {
		exec("sudo /opt/freesvr/audit/sbin/license-print", $out, $return);
		$_o = explode(' ', $out[0]);
		$_p = explode('-', $_o[3]);
		if(empty($_p[4])){
			alert_and_back("Licenses不包含应用发布");
			exit;
		}
		$page_num = get_request('page');
		$appserverip = get_request('ip', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'name';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = "1=1";
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION['QUERY_STRING']);
		$row_num = $this->appicon_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$appicon = $this->appicon_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);		
		
		$this->assign('appicon',$appicon);
		$this->assign('appcount',count($appicon));	
		$this->display('appicon_list.tpl');	
	}	
	
	function appicon_save() {//var_dump($_POST);
		$id = get_request("id", 0, 1);
		$name = get_request("name", 1, 1);
		if(empty($name)) {
			alert_and_back("请输入名称", "admin.php?controller=admin_config&action=appicon_list");
			exit();		
		}
		
		else {
			$appicon = new appicon();
			if(is_uploaded_file($_FILES['path']['tmp_name'])){
				if(move_uploaded_file($_FILES['path']['tmp_name'], ROOT.'/upload/'.$_FILES['path']['name'])){
					$appicon->set_data('path',$_FILES['path']['name']);
				}else{
					alert_and_back("上传文件失败");	
					exit;
				}
			}			
			$appicon->set_data('name',$name);	
			if($appicon->get_errnum() == 0) {
				if(empty($id)){
					$this->appicon_set->add($appicon);
					alert_and_back("添加成功", "admin.php?controller=admin_config&action=appicon_list&ip=$appserverip");	
					exit();	
				}else{
					$appicon->set_data('id',$id);
					$this->appicon_set->edit($appicon);	
					alert_and_back("修改成功", "admin.php?controller=admin_config&action=appicon_list&ip=$appserverip");	
					exit();
				}
			} 
		}
	}
	function appicon_delete() {
		$id = array(get_request('id'));
		if($_POST['chk_member']){
			$id = $_POST['chk_member'];
		}
		$this->appicon_set->delete($id);
		alert_and_back('成功删除');
	}
	
	function appicon_edit() {
		global $_CONFIG;
		$appserverip = get_request('appserverip', 0, 1);
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$p = $this->appicon_set->select_by_id($id);
		$this->assign("p", $p);
		$this->assign('id',$id);
		$this->assign("appserverip", $appserverip);
		$this->assign("allmem", $allmem);
		$this->assign("usergroup", $usergroup);		
		$this->assign('sessionluser', $sessionluser);
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->assign('fromapp', $from);
		$this->display('appicon_edit.tpl');	
	}

	function appdevice_list() {
		$page_num = get_request('page');
		$apppubid = get_request('apppubid', 0, 1);
		$serverip = get_request('serverip', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$where = "1=1";
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);		

		if($serverip){
			$where .= " AND device_ip ='$serverip'";
		}
		if($apppubid){
			$where .= " AND apppubid = $apppubid ";
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		$apppub = $this->apppub_set->select_by_id($apppubid);
		$row_num = $this->appdevice_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql = "SELECT a.*,b.name apppubname,b.description apppubdesc FROM ".$this->appdevice_set->get_table_name()." a LEFT JOIN ".$this->apppub_set->get_table_name()." b ON a.apppubid=b.id WHERE $where ORDER BY a.$orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage ";
		$appdevices = $this->appdevice_set->base_select($sql);
		
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		
		$this->assign('appdevices',$appdevices);
		$this->assign('apppub',$apppub);
		$this->assign('serverip',$serverip);
		$this->assign('apppubid',$apppubid);
		$this->assign('appdevicesct',count($appdevices));	
		$this->display('appdevice_list.tpl');	
	}	

	
	function appdevice_edit( $serverip, $apppubid, $appdeviceid) {
		global $_CONFIG;
		$webuser = get_request('webuser',0,1);
		$webgroup = get_request('webgroup',0,1);
		//$apppubid = intval(get_request('apppubid', 0, 1));
		//$serverip = get_request('serverip', 0, 1);
		//$appdeviceid = intval(get_request('id'));
		$sessionluser = 'APPPUBEDIT_LUSER';
		$sessionlgroup = 'APPPUBEDIT_LGROUP';
		unset($_SESSION[$sessionluser]);
		unset($_SESSION[$sessionlgroup]);
		
		$ldapid1 = get_request('ldapid1',0,1);
		$ldapid2 = get_request('ldapid2',0,1);		
		$servergroup = get_request('servergroup',0,1);

		require_once('./include/select_sgroup_ajax.inc.php');
		if($ori_g_id){
			$_tmpgid = $this->sgroup_set->select_all("id IN(".(is_array($ori_g_id)?implode(',', $ori_g_id): $ori_g_id).")");
			$__tmpgid = $ori_g_id;
			for($i=0; $i<count($_tmpgid); $i++){
				$__tmpgid .= ','.$_tmpgid[$i]['child'];
			}
			$wheremember = ' AND groupid IN('.$__tmpgid.')';
			$wheregroup = ' AND id IN('.$__tmpgid.')';
		}

		if($appdeviceid){
			$_SESSION[$sessionluser] = $this->appmember_set->select_all('appdeviceid='.$appdeviceid);
			$_SESSION[$sessionlgroup] = $this->appgroup_set->select_all('appdeviceid='.$appdeviceid);
			$p = $this->appdevice_set->select_by_id($appdeviceid);
			$p['old_password'] = $this->member_set->udf_decrypt($p['old_password']);
			$p['cur_password'] = $this->member_set->udf_decrypt($p['cur_password']);
		}
		
		$allmem = $this->member_set->select_all("level!=11".(empty($webuser) ? '' : " AND username like '%$webuser%' " )." ".$wheremember." ".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''),'username','ASC');
		$usergroup = $this->usergroup_set->select_all((empty($webgroup) ? '' : " groupname like '%$webgroup%' AND " ).'(select count(0) FROM '.$this->member_set->get_table_name().' where groupid='.$this->usergroup_set->get_table_name().'.id) >0 and 1=1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : '').$wheregroup,'GroupName', 'ASC');		$this->assign('usergroup', $usergroup);

		
		for($i=0; $i<count($allmem); $i++){
			for($j=0; $j<count($_SESSION[$sessionluser]); $j++){
				if($allmem[$i]['uid']==$_SESSION[$sessionluser][$j]['memberid']){
					$allmem[$i]['check'] = 'checked';
				}
			}
		}
		for($i=0; $i<count($usergroup); $i++){
			for($j=0; $j<count($_SESSION[$sessionlgroup]); $j++){
				if($usergroup[$i]['id']==$_SESSION[$sessionlgroup][$j]['groupid']){
					$usergroup[$i]['check'] = 'checked';
				}
			}
		}
		$servers = $this->server_set->select_all('1'.($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? " AND  groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")" : '').$wheremember, 'device_ip', 'asc');
		if(empty($p)){
			$p['enable']=1;
		}
		//$p['device_ip']=$serverip;
		$apppub = $this->apppub_set->select_by_id($apppubid);
		$this->assign("apppub", $apppub);
		$apppubs = $this->apppub_set->select_all();
		for($i=0; $i<count($apppubs); $i++){
			$found = 0;
			for($j=0; $j<count($apppubss); $j++){
				if($apppubss[$j]['ip']==$apppubs[$i]['appserverip']){
					$apppubss[$j]['apps'][]=$apppubs[$i];
					$found=1;
				}
			}
			if($found==0){
				$ct = count($apppubss);
				$apppubss[$ct]['ip']=$apppubs[$i]['appserverip'];
				$apppubss[$ct]['apps'][]=$apppubs[$i];
			}
		}
		
		$this->assign("apppubs", $apppubss);
		$this->assign("p", $p);
		$this->assign('id',$id);
		$this->assign('apppubid',$apppubid);
		$this->assign("appserverip", $serverip);
		$this->assign("servers", $servers);
		$this->assign("allmem", $allmem);
		$this->assign("usergroup", $usergroup);		
		$this->assign('sessionluser', $sessionluser);
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->display('appdevice_edit.tpl');	
	}

	function appdevice_save($apppubid, $apppubdevices) {
		global $_CONFIG;
		$appserverip = get_request('appserverip', 0, 1);
		$sessionluser = get_request('sessionluser', 1, 1);
		$device_ip = get_request('device_ip', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		//$id = get_request("id", 1, 0);
		//$apppubid = get_request("apppubid", 1, 1);
		$username = addslashes(get_request("username", 1, 1));
		$password = htmlspecialchars_decode(get_request("password", 1, 1));
		$repassword = htmlspecialchars_decode(get_request("repassword", 1, 1));
		$oracle_auth = get_request("oracle_auth", 1, 1);
		$change_password = get_request("change_password", 1, 0);
		$entrust_password = get_request("entrust_password", 1, 1);
		$oracle_name = get_request("oracle_name", 1, 1);
		$navicat_port = get_request("navicat_port", 1, 1);
		$enable = get_request("enable", 1, 0);
		$id = $this->appdevice_set->select_all('apppubid='.$apppubid);
		if($id){
			$id = $id[0]['id'];
		}else{
			$id = 0;
		}
		/*if(empty($username)) {
			alert_and_back("请输入用户名");
			exit();		
		}elseif($this->appdevice_set->select_count('apppubid='.$apppubid." and username='".$username."' and id!=$id")!=0){
			alert_and_back("用户名已经存在");
			exit();	
		}else*/if($password!=$repassword){
			alert_and_back("两次输入的密码不一致","admin.php?controller=admin_config&action=apppub_edit&id=$apppubid&appserverip=$appserverip&device_ip=".get_request('device_ip', 0, 1));
			exit();	
		}
		else {
			$apppub = $this->apppub_set->select_by_id($apppubid);
			$newappdeviceid = new appdevice();
			$newappdeviceid->set_data('username',$username);
			if($password){
				if($id){
					$old=$this->appdevice_set->select_by_id($id);
					$newappdeviceid->set_data('old_password',$old['cur_password']);
				}
				$newappdeviceid->set_data('cur_password',$this->member_set->udf_encrypt($password));
			}
			$servers = $this->server_set->select_all("device_ip='".$device_ip."'");
			$newappdeviceid->set_data('change_password',$change_password);
			$newappdeviceid->set_data('enable',$enable);	
			$newappdeviceid->set_data('oracle_auth',$oracle_auth);	
			$newappdeviceid->set_data('apppubid', $apppubid);
			$newappdeviceid->set_data('oracle_name', $oracle_name);
			$newappdeviceid->set_data('navicat_port', $navicat_port);
			$newappdeviceid->set_data('entrust_password', $entrust_password);
			$newappdeviceid->set_data('device_ip', empty($device_ip) ? '' : $device_ip);
		
			if($newappdeviceid->get_errnum() == 0) {
				if(empty($id)){
					$this->appdevice_set->add($newappdeviceid);
					$appdeviceidid = mysql_insert_id();
					for($i=0; $i<count($_POST['member']); $i++){						
						$member = $this->member_set->select_by_id($_POST['member'][$i]);
						$where = "devices.id=".$apppubdevices[0]['id']." AND member.uid=".$_POST['member'][$i];
						$sql  = "select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,luser.devicesid,devices.device_ip,devices.username,devices.login_method,luser.forbidden_commands_groups,luser.weektime,luser.sourceip,luser.autosu,luser.syslogalert,luser.mailalert,luser.loginlock from luser left join member on luser.memberid=member.uid left join devices on luser.devicesid=devices.id where member.uid and luser.devicesid AND $where";		
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.devicesid,devices.device_ip,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0) t on a.resourceid=t.id left join member on a.memberid=member.uid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,devices.id devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,lgroup.devicesid,devices.device_ip,devices.username,devices.login_method,lgroup.forbidden_commands_groups,lgroup.weektime,lgroup.sourceip,lgroup.autosu,lgroup.syslogalert,lgroup.mailalert,lgroup.loginlock from lgroup left join member on lgroup.groupid=member.groupid left join devices on lgroup.devicesid=devices.id where member.uid and lgroup.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.devicesid,devices.device_ip,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceip,member.sourceipv6,devices.id devicesid,devices.device_ip,devices.hostname,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where ";
						$row_num = $this->server_set->base_select("select count(0) ct FROM ($sql)t");
						$row_num = $row_num[0]['ct'];
						if($row_num<=0){
							$_luser = new luser();
							$_luser->set_data('memberid', $_POST['member'][$i]);
							$_luser->set_data('devicesid', $apppubdevices[0]['id']);
							$this->luser_set->add($_luser);
						}
						$appmember = new appmember();
						$appmember->set_data('memberid', $_POST['member'][$i]);
						//$appmember->set_data('appdeviceid', $apppubid);
						$appmember->set_data('appdeviceid', $appdeviceidid);
						for($ii=0; $ii<count($_SESSION[$sessionluser]); $ii++){
							if($_SESSION[$sessionluser][$ii]['memberid']==$_POST['member'][$i]){
								//$appmember->set_data('username', $_SESSION[$sessionluser][$ii]['username']);
								//$appmember->set_data('password', $this->member_set->udf_encrypt($_SESSION[$sessionluser][$ii]['password']));
							}
						}
						$this->appmember_set->add($appmember);
						$adminlog = new admin_log();
						$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
						$adminlog->set_data('luser', $member['username']);
						$adminlog->set_data('action', language('应用发布绑定运维用户'));
						$adminlog->set_data('resource', $apppub['name']);
						$adminlog->set_data('type', 7);
						$this->admin_log_set->add($adminlog);
						unset($adminlog);
						if($_POST['member'][$i])
							$this->usergroup_set->query("UPDATE member set cachechange=1 where uid=".$_POST['member'][$i]);
					}
					for($i=0; $i<count($_POST['group']); $i++){
						$ugroup = $this->usergroup_set->select_by_id($_POST['group'][$i]);
						$where = "devicesid=".$apppubdevices[0]['id']." AND a.groupid=".$_POST['group'][$i];
						$sql = " select distinct devicesid from lgroup a where a.devicesid AND $where";
						$sql .= " union select distinct devicesid from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 ) t on a.resourceid=t.id where t.id and t.devicesid AND $where";
						$where = "devices.id=".$apppubdevices[0]['id']." AND a.groupid=".$_SESSION[$sessionlgroup][$i]['groupid'];
						$sql .= " union select distinct devices.id from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where ";
						$row_num = $this->server_set->base_select("select count(0) ct FROM ($sql)t");
						$row_num = $row_num[0]['ct'];
						if($row_num<=0){
							$_luser = new lgroup();
							$_luser->set_data('groupid', $_POST['group'][$i]);
							$_luser->set_data('devicesid', $apppubdevices[0]['id']);
							$this->lgroup_set->add($_luser);
						}

						$appgroup = new appgroup();
						$appgroup->set_data('groupid', $_POST['group'][$i]);
						//$appgroup->set_data('appdeviceid', $apppubid);
						$appgroup->set_data('appdeviceid', $appdeviceidid);
						for($ii=0; $ii<count($_SESSION[$sessionlgroup]); $ii++){
							if($_SESSION[$sessionlgroup][$ii]['groupid']==$_POST['group'][$i]){
								//$appgroup->set_data('username', $_SESSION[$sessionlgroup][$ii]['username']);
								//$appgroup->set_data('password', $this->member_set->udf_encrypt($_SESSION[$sessionlgroup][$ii]['password']));
							}
						}
						$this->appgroup_set->add($appgroup);

						
						$adminlog = new admin_log();
						$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
						$adminlog->set_data('lgroup', $ugroup['groupname']);
						$adminlog->set_data('action', language('应用发布绑定资源组'));
						$adminlog->set_data('resource',$apppub['name']);
						$adminlog->set_data('type', 8);
						$this->admin_log_set->add($adminlog);
						unset($adminlog);
						if($_POST['group'][$i])
							$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid=".$_POST['group'][$i]);
					}
					unset($_SESSION[$sessionluser]);
					unset($_SESSION[$sessionlgroup]);
					alert_and_back("添加成功", "admin.php?controller=admin_config&action=apppub_list&ip=$appserverip&device_ip=".get_request('device_ip', 0, 1));	
					exit();	
				}else{
					$newappdeviceid->set_data('id',$id);
					$newuser=$_POST['member'];
					$newgroup=$_POST['group'];
					$allusers = $this->appmember_set->select_all("appdeviceid='$id'");
					for($i=0; $i<count($allusers); $i++){
						$alluserid[] = $allusers[$i]['memberid'];
					}
					$added = $newuser;
					if($alluserid&&$newuser){
						$added = array_diff($newuser, $alluserid);
						$removed = array_diff($alluserid, $newuser);
					}
					if(empty($newgroup)){
						$removed = $alluserid;
					}
					if($added)
					foreach($added AS $k=>$v){
						$member = $this->member_set->select_by_id($v);
						$adminlog = new admin_log();
						$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
						$adminlog->set_data('luser', $member['username']);
						$adminlog->set_data('action', language('应用发布绑定运维用户'));
						$adminlog->set_data('resource', $apppub['name']);
						$adminlog->set_data('type', 7);
						$this->admin_log_set->add($adminlog);
						unset($adminlog);
						if($v)
							$this->usergroup_set->query("UPDATE member set cachechange=1 where uid=".$v);
					}
					if($removed)
					foreach($removed AS $k=>$v){
						$member = $this->member_set->select_by_id($v);
						$adminlog = new admin_log();
						$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
						$adminlog->set_data('luser', $member['username']);
						$adminlog->set_data('action', language('应用发布解绑运维用户'));
						$adminlog->set_data('resource', $apppub['name']);
						$adminlog->set_data('type', 7);
						$this->admin_log_set->add($adminlog);
						unset($adminlog);
						if($v)
							$this->usergroup_set->query("UPDATE member set cachechange=1 where uid=".$v);
					}
					$allgroups = $this->appgroup_set->select_all("appdeviceid='$id'");
					for($i=0; $i<count($allgroups); $i++){
						$allgroupid[] = $allgroups[$i]['groupid'];
					}
					$added = $newgroup;
					if($allgroupid&&$newgroup){
						$added = array_diff($newgroup, $allgroupid);
						$removed = array_diff($allgroupid, $newgroup);
					}
					if(empty($newgroup)){
						$removed = $allgroupid;
					}
					if($added)
					foreach($added AS $k=>$v){
						$ugroup = $this->usergroup_set->select_by_id($v);
						$adminlog = new admin_log();
						$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
						$adminlog->set_data('lgroup', $ugroup['groupname']);
						$adminlog->set_data('action', language('应用发布绑定资源组'));
						$adminlog->set_data('resource', $apppub['name']);
						$adminlog->set_data('type', 8);
						$this->admin_log_set->add($adminlog);
						unset($adminlog);
						if($ugroup)
							$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid=".$ugroup['id']);
					}
					if($removed)
					foreach($removed AS $k=>$v){
						$ugroup = $this->usergroup_set->select_by_id($v);
						$adminlog = new admin_log();
						$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
						$adminlog->set_data('lgroup', $ugroup['groupname']);
						$adminlog->set_data('action', language('应用发布解绑资源组'));
						$adminlog->set_data('resource', $apppub['name']);
						$adminlog->set_data('type', 8);
						$this->admin_log_set->add($adminlog);
						unset($adminlog);
						if($ugroup)
							$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid=".$ugroup['id']);
					}



					$this->appgroup_set->delete_all('appdeviceid='.$id);
					$this->appmember_set->delete_all('appdeviceid='.$id);
					$this->appdevice_set->edit($newappdeviceid);
					for($i=0; $i<count($_POST['member']); $i++){
						$where = "devices.id=".$apppubdevices[0]['id']." AND member.uid=".$_POST['member'][$i];
						$sql  = "select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,luser.devicesid,devices.device_ip,devices.username,devices.login_method,luser.forbidden_commands_groups,luser.weektime,luser.sourceip,luser.autosu,luser.syslogalert,luser.mailalert,luser.loginlock from luser left join member on luser.memberid=member.uid left join devices on luser.devicesid=devices.id where member.uid and luser.devicesid AND $where";		
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.devicesid,devices.device_ip,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,lgroup.devicesid,devices.device_ip,devices.username,devices.login_method,lgroup.forbidden_commands_groups,lgroup.weektime,lgroup.sourceip,lgroup.autosu,lgroup.syslogalert,lgroup.mailalert,lgroup.loginlock from lgroup left join member on lgroup.groupid=member.groupid left join devices on lgroup.devicesid=devices.id where member.uid and lgroup.devicesid AND $where";
						$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.devicesid,devices.device_ip,devices.username,devices.login_method,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
						$row_num = $this->server_set->base_select("select count(0) ct FROM ($sql)t");
						$row_num = $row_num[0]['ct'];
						if($row_num<=0){
							$_luser = new luser();
							$_luser->set_data('memberid', $_POST['member'][$i]);
							$_luser->set_data('devicesid', $apppubdevices[0]['id']);
							$this->luser_set->add($_luser);
						}

						$appmember = new appmember();
						$appmember->set_data('memberid', $_POST['member'][$i]);
						//$appmember->set_data('apppubid', $apppubid);
						$appmember->set_data('appdeviceid', $id);
						for($ii=0; $ii<count($_SESSION[$sessionluser]); $ii++){
							if($_SESSION[$sessionluser][$ii]['memberid']==$_POST['member'][$i]){
								//$appmember->set_data('username', $_SESSION[$sessionluser][$ii]['username']);
								//$appmember->set_data('password', $this->member_set->udf_encrypt($_SESSION[$sessionluser][$ii]['password']));
							}
						}
						$this->appmember_set->add($appmember);

						
					}
					for($i=0; $i<count($_POST['group']); $i++){
						$where = "devicesid=".$apppubdevices[0]['id']." AND a.groupid=".$_POST['group'][$i];
						$sql = " select distinct devicesid from lgroup a where a.devicesid AND $where";
						$sql .= " union select distinct devicesid from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 ) t on a.resourceid=t.id where t.id and t.devicesid AND $where";
						$row_num = $this->server_set->base_select("select count(0) ct FROM ($sql)t");
						$row_num = $row_num[0]['ct'];
						if($row_num<=0){
							$_luser = new lgroup();
							$_luser->set_data('groupid', $_POST['group'][$i]);
							$_luser->set_data('devicesid', $apppubdevices[0]['id']);
							$this->lgroup_set->add($_luser);
						}

						$appgroup = new appgroup();
						$appgroup->set_data('groupid', $_POST['group'][$i]);
						//$appgroup->set_data('apppubid', $apppubid);
						$appgroup->set_data('appdeviceid', $id);
						for($ii=0; $ii<count($_SESSION[$sessionlgroup]); $ii++){
							if($_SESSION[$sessionlgroup][$ii]['groupid']==$_POST['group'][$i]){
								//$appgroup->set_data('username', $_SESSION[$sessionlgroup][$ii]['username']);
								//$appgroup->set_data('password', $this->member_set->udf_encrypt($_SESSION[$sessionlgroup][$ii]['password']));
							}
						}
						$this->appgroup_set->add($appgroup);

						
					}
					unset($_SESSION[$sessionluser]);
					unset($_SESSION[$sessionlgroup]);
					alert_and_back("修改成功", "admin.php?controller=admin_config&action=apppub_list&ip=$appserverip&device_ip=".get_request('device_ip', 0, 1));	
					exit();
				}
			} else {
				alert_and_back($newapppub->get_firsterr(), NULL, 1);
				exit();
			}
		}
	}

	function appdevice_delete($id) {
		/*$id = get_request('id');
		if($_POST['chk_member']){
			$id = $_POST['chk_member'];
		}*/
		$this->appmember_set->delete_all(" appdeviceid IN(SELECT id FROM appdevices WHERE apppubid IN (".(is_array($id) ? implode(',',$id) : $id)."))");
		$this->appgroup_set->delete_all(" appdeviceid IN(SELECT id FROM appdevices WHERE apppubid IN (".(is_array($id) ? implode(',',$id) : $id)."))");
		$this->appresgroup_set->delete_all(" appdevicesid IN (SELECT id FROM appdevices WHERE apppubid IN (".(is_array($id) ? implode(',',$id) : $id)."))");
		$this->luser_appresourcegrp_set->delete_all(" appresourceid NOT IN (SELECT id FROM appresourcegroup )");
		$this->lgroup_appresourcegrp_set->delete_all(" appresourceid NOT IN (SELECT id FROM appresourcegroup )");
		$this->appdevice_set->delete_all("apppubid IN (".(is_array($id) ? implode(',',$id) : $id).")");
		alert_and_back('成功删除');
	}
	

	function apppubedit_seluser(){
		$appdeviceid = get_request('appdeviceid');
		$memberid = get_request('memberid');
		$sessionluser= get_request('sessionluser', 0, 1);
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
				if($_SESSION[$sessionluser][$i]['memberid']==$memberid&&$_SESSION[$sessionluser][$i]['apppubid']==$apppubid){
					$luser[0] = $_SESSION[$sessionluser][$i];	
					break;
				}
			}
		if(empty($luser)){
			$luser = $this->appmember_set->select_all('memberid='.$memberid.' AND appdeviceid='.$appdeviceid);
		}

		$this->assign('title', language('设置'));
		$this->assign("appmember", $luser[0]);
		$this->assign("memberid", $memberid);
		$this->assign("apppubid", $apppubid);
		$this->assign('sessionluser', $sessionluser);
		$this->display('apppubedit_seluser.tpl');
	}

	function apppubedit_seluser_save(){
		$appdeviceid = get_request('appdeviceid', 1, 0);
		$memberid = get_request('memberid', 1, 0);
		$id = get_request('id', 1, 0);
		$username = get_request('username', 1, 1);
		$password = get_request('password', 1, 1);
		$sessionluser = get_request('sessionluser', 1, 1);		
		$repassword = get_request('repassword', 1, 1);
		if($password!=$repassword){
			alert_and_back('两次输入的密码不一致', 'admin.php?controller=admin_config&action=apppubedit_seluser&memberid='.$memberid.'&appdeviceid='.$appdeviceid.'&sessionluser='.$sessionluser);
			exit;
		}

		if($id)
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if($_SESSION[$sessionluser][$i]['id']==$id){
				$_SESSION[$sessionluser][$i]['username'] = $username;
				$_SESSION[$sessionluser][$i]['password'] = $password;				
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
				if($_SESSION[$sessionluser][$i]['memberid']==$memberid&&$_SESSION[$sessionluser][$i]['appdeviceid']==$apppubid){
					$_SESSION[$sessionluser][$i]['memberid'] = $memberid;
					$_SESSION[$sessionluser][$i]['appdeviceid'] = $appdeviceid;
					$_SESSION[$sessionluser][$i]['username'] = $username;
					$_SESSION[$sessionluser][$i]['password'] = $password;	
					$found = 1;
				}
			}
			if($found==0){
				$_SESSION[$sessionluser][$i]['memberid'] = $memberid;
				$_SESSION[$sessionluser][$i]['appdeviceid'] = $appdeviceid;
				$_SESSION[$sessionluser][$i]['username'] = $username;
				$_SESSION[$sessionluser][$i]['password'] = $password;					
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionluser]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION[$sessionluser]);
	}

	function apppubedit_selgroup(){
		$id = get_request('id');
		$appdeviceid = get_request('appdeviceid');
		$gid = get_request('gid');
		$sessionlgroup= get_request('sessionlgroup', 0, 1);
		
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['appdeviceid']==$apppubid){
					$lgroup[0] = $_SESSION[$sessionlgroup][$i];	
					break;
				}
			}
		if(empty($lgroup)){
			$lgroup = $this->appgroup_set->select_all('groupid='.$gid.' AND appdeviceid='.$apppubid);
		}
		$this->assign('title', language('设置'));
		$this->assign("appgroup", $lgroup[0]);
		$this->assign("gid", $gid);
		$this->assign("appdeviceid", $appdeviceid);		
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->display('apppubedit_selgroup.tpl');
	}

	function apppubedit_selgroup_save(){
		$appdeviceid = get_request('appdeviceid', 1, 0);
		$gid = get_request('gid', 1, 0);
		$id = get_request('id', 1, 0);
		$username = get_request('username', 1, 1);
		$password = get_request('password', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);		

		if($id)
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if($_SESSION[$sessionlgroup][$i]['id']==$id){
				$_SESSION[$sessionlgroup][$i]['username'] = $username;
				$_SESSION[$sessionlgroup][$i]['password'] = $password;				
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['appdeviceid']==$apppubid){
					$_SESSION[$sessionlgroup][$i]['appdeviceid'] = $appdeviceid;
					$_SESSION[$sessionlgroup][$i]['groupid'] = $gid;
					$_SESSION[$sessionlgroup][$i]['username'] = $username;
					$_SESSION[$sessionlgroup][$i]['password'] = $password;	
					$found = 1;
				}
			}
			if($found==0){
				$_SESSION[$sessionlgroup][$i]['appdeviceid'] = $appdeviceid;
				$_SESSION[$sessionlgroup][$i]['groupid'] = $gid;
				$_SESSION[$sessionlgroup][$i]['username'] = $username;
				$_SESSION[$sessionlgroup][$i]['password'] = $password;					
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionlgroup]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION[$sessionlgroup]);
	}	
	
	function ha()
	{
		//$filename = './controller/global.cfg';
		global $_CONFIG;
		$filename = $_CONFIG['HACF'];
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "virtual_ipaddress"))
				{
					$network['virtual_ipaddress'] = trim($lines[$ii+1]);
				}
				if(strstr(strtolower(trim($lines[$ii])), "state "))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);//var_dump($tmp);
					$network['state'] = trim($tmp[2]);
				}
				if(strstr(strtolower(trim($lines[$ii])), "priority "))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['priority'] = trim($tmp[2]);
				}
			}
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限','',1);
			exit;
		}

		$iptablefile = $_CONFIG['IPTABLES'];
		$lines = @file($iptablefile);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "#ha config start"))
				{
					$tmp = preg_split("/[\s]+/", $lines[++$ii]);//var_dump($tmp);
					$network['oppositeip'] = trim($tmp[3]);
				}
				
			}
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限','',1);
			exit;
		}
		
		unset($lines);
		
			
		$cmd = "ip add show | grep ".$network['virtual_ipaddress'];
		exec($cmd, $out1);
		if(empty($out1)){
			$network['state']='BACKUP';
		}else{
			$network['state']='MASTER';
		}

		$cmd = "uname -n";
		exec($cmd, $out1);
		$hostname = trim($out1[0]);
		$cmd = "sudo ps -ef | grep keepalived | grep -v grep";
		exec($cmd, $out);
		if(strstr(strtolower($out[0]), "keepalived"))
		{
			$network['start']=1;
		}
		$slaveip = $this->setting_set->query("show slave status");
		$slaveip = mysql_fetch_array($slaveip);//var_dump($slaveip);
		$network['slave_ip'] = $slaveip['Master_Host'];
		$this->assign("ha", $network);
		$this->display('ha.tpl');
	}

	function ha_save()
	{
		//$filename = './controller/global.cfg';
		global $_CONFIG;		
		$virtual_ipaddress = get_request('virtual_ipaddress',1,1);	
		$master = get_request('state',1,1);
		$slave_ip = get_request('slave_ip',1,1);
		
		if($slaveip&&!is_ip($slaveip)){
			alert_and_back('请输入正确的IP','',1);
			exit;
		}
		
		$filename = $_CONFIG['HACF'];
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "virtual_ipaddress"))
				{
					$lines[++$ii] = "".$virtual_ipaddress."\n";
					$ii++;
				}
				if(strstr(strtolower($lines[$ii]), "state "))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = "".'state '.$master."\n";
				}
				if(strstr(strtolower($lines[$ii]), "priority"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					if(strtolower($master)=='master'){
						$lines[$ii] = "".' priority 100'."\n";
					}else{
						$lines[$ii] = "".' priority 10'."\n";
					}
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限','',1);
			exit;
		}
		
		$this->Array2File($lines,$filename);
		unset($lines);

		/*对端IP
		$iptablefile = $_CONFIG['IPTABLES'];
		$lines = @file($iptablefile);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "#ha config start"))
				{
					$foundoppositeip = 1;
					$tmp = preg_split("/[\s]+/", $lines[++$ii]);//var_dump($tmp);
					if(empty($oppositeip)){
						$lines[$ii-1] = "";
						$lines[$ii] = "";
						$lines[$ii+1] = "";
					}else{
						$lines[$ii] = "-A  RH-Firewall-1-INPUT -s  $oppositeip  -j ACCEPT\n";
					}
				}
				if(strstr(strtolower($lines[$ii]), "state --state established,related")){
					$endline = $ii;
				}
				
			}
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限','',1);
			exit;
		}
		if(!$foundoppositeip){
			$copy_line = count($lines)-1;
			$lines[$copy_line+1]="\n";
			$lines[$copy_line+2]="\n";
			$lines[$copy_line+3]="\n";
			while(!empty($endline)&&$copy_line>=$endline){
				$lines[$copy_line+3]=$lines[$copy_line];
				$copy_line--;
			}
			$lines[$endline++]="#ha config start\n";
			$lines[$endline++]="-A  RH-Firewall-1-INPUT -s  $oppositeip  -j ACCEPT\n";
			$lines[$endline++]="#ha config end\n";
		}
		//echo '<pre>';var_dump($lines);echo '</pre>';
		$this->Array2File($lines,$iptablefile);*/
		unset($lines);
		//exit;
		ob_start();
		$b = @system('sudo killall -9 keepalived ',$out);
		$b = @system('sudo /usr/local/sbin/keepalived ',$out);
		ob_get_clean();

		$this->setting_set->query("UPDATE setting set svalue='".$slave_ip."' where sname='ha_slave_ip'");
		exec("sudo /home/wuxiaolong/mysql_keepalived/mysql_keepalived.pl ".$slave_ip." ".$virtual_ipaddress);
		alert_and_back('配置成功','admin.php?controller=admin_config&action=ha');
	}

	function ha_config(){
		$this->display('ha_config.tpl');
	}

	function haconfig_save(){
		$slaveip = get_request('slaveip', 1, 1);
		$virtual_ipaddress = get_request('virtual_ipaddress', 1, 1);
		exec('sudo /home/wuxiaolong/mysql_keepalived/mysql_keepalived.pl '.$slaveip.' '.$virtual_ipaddress);
		alert_and_close('配置成功','admin.php?controller=admin_config&action=ha');
	}
	
	function ha_synchronized(){
		$ip = get_request('ip',0,1);
		if(empty($ip)){
			alert_and_back('从服务器ip为空,同步取消','admin.php?controller=admin_config&action=ha');
			exit;
		}
		$cmd = '/opt/freesvr/sql/bin/mysqldump -u freesvr -pfreesvr --opt audit_sec alarm defaultpolicy device device_html  devices forbidden_commands forbidden_commands_groups forbidden_commands_user forbidden_groups lgroup lgroup_devgrp loadbalance login_tab luser luser_devgrp member password_rules prompts radcheck radgroupcheck radgroupreply radhuntcheck radhuntgroup radhuntgroupcheck radhuntreply radkey radreply radsourcecheck radsourcegroup radsourcegroupcheck radsourcereply servergroup servers setting sourceip sourceiplist strategy usergroup weektime | mysql -u freesvr -pfreesvr -h '.$ip.' audit_sec';
		$a = system($cmd,$out);

		alert_and_back('执行成功','admin.php?controller=admin_config&action=ha');
	}


	function loadbalance(){
		$page_num = get_request('page');
		$ac = get_request('ac', 1, 1);
		$add = get_request('add', 1, 1);
		$delete = get_request('delete', 1, 1);
		$ip = get_request('ip', 1, 1);
		$hostname = get_request('hostname', 1, 1);
		$id = get_request('chk_sid', 1, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$delete = get_request('delete');
		if(empty($orderby1)){
			$orderby1 = 'ip';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		if($ac=='new'){
			if(!is_ip($ip)){
				alert_and_back("ip格式不正确");
				exit;
			}
			if(empty($hostname)){
				alert_and_back("主机名不能为空");
				exit;
			}
			$sql = "INSERT INTO  loadbalance SET ip='".$ip."', hostname='".$hostname."'";
			$this->loadbalance_set->query($sql);
			alert_and_back('添加成功','admin.php?controller=admin_config&action=loadbalance');
			exit;
		}elseif($ac=='modify'){
			$id=get_request('id', 1, 0);
			if(!is_ip($ip)){
				alert_and_back("ip格式不正确");
				exit;
			}
			if(empty($hostname)){
				alert_and_back("主机名不能为空");
				exit;
			}
			$sql = "UPDATE loadbalance SET ip='".$ip."', hostname='".$hostname."' WHERE sid=$id";
			$this->loadbalance_set->query($sql);
			alert_and_back('修改成功','admin.php?controller=admin_config&action=loadbalance');
			exit;
		}
		if($delete || $ac=='delete'){
			if($ac=='delete'){
				$delete = $_POST['chk_sid'];
			}
			$this->loadbalance_set->delete($delete);
			alert_and_back('删除成功');
			exit;
		}
		$row_num = $this->loadbalance_set->select_count("1 = 1");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$ha = $this->loadbalance_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, '1=1', $orderby1, $orderby2);
		$this->assign("lb", $ha);
		$this->assign("title", '负载均衡');
		$this->display('loadbalance.tpl');
	}

	function loadbalance_edit(){
		$id = get_request("id");
		$lb = $this->loadbalance_set->select_by_id($id);
		$this->assign("p", $lb);
		$this->display("loadbalance_edit.tpl");
	}

	
	/*function radius(){
		$config = $this->setting_set->select_all(" sname='radius_on' or sname='radius_server' or sname='radius_key'");
		for($i=0; $i<count($config); $i++){
			$radius[$config[$i]['sname']]=$config[$i]['svalue'];
		}
		$this->assign("radius", $radius);
		$this->display('config_radius.tpl');
	}
	
	function radius_save(){
		$on = get_request('radius_on',1,1);
		$server = get_request('radius_server',1,1);
		$key = get_request('radius_key',1,1);				
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$on."' where sname='radius_on'");
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$server."' where sname='radius_server'");
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$key."' where sname='radius_key'");
		
		alert_and_back('设置成功','admin.php?controller=admin_config&action=radius');
		
	}*/
	
	function syslog_mail_alarm(){
		$ac = get_request('ac', 1, 1);
		$Mail_Alarm = get_request('Mail_Alarm', 1, 0);
		$Mailserver = get_request('Mailserver', 1, 1);
		$account = get_request('account', 1, 1);
		$password = get_request('password', 1, 1);
		$syslog_alarm = get_request('syslog_alarm', 1, 0);
		$mailport = get_request('mailport', 1, 0);
		$sslmail = get_request('sslmail', 1, 0);
		$mailalarm = get_request('mailalarm', 1, 1);
		$syslogserver = get_request('syslogserver', 1, 1);
		$syslogport = get_request('syslogport', 1, 1);
		$syslog_facility = get_request('syslog_facility', 1, 1);		
		$filename = '/opt/freesvr/audit/authd/etc/freesvr_authd_config';
		if($ac){
			$sql = ($ac != 'new' ? 'UPDATE' : 'INSERT INTO ')." alarm SET Mail_Alarm='".$Mail_Alarm."',Mailserver='".$Mailserver."', account='".$account."', password='".$password."',syslog_alarm='".$syslog_alarm."', syslogserver='".$syslogserver."', syslogport='".$syslogport."',syslog_facility='".$syslog_facility."',mailport='".$mailport."',sslmail='".$sslmail."'";
			$this->config_set->query($sql);
			$lines = @file($filename);
			if(!empty($lines))
			{
				
				for($ii=0; $ii<count($lines); $ii++)
				{
					if(strstr($lines[$ii], "SendMail"))
					{
						$tmp = preg_split("/[\s]+/", $lines[$ii]);
						$lines[$ii] = str_replace($tmp[1], $mailalarm, $lines[$ii]);
					}
				}
			}
			$this->Array2File($lines,$filename);
			alert_and_back('修改成功');
		}

		$ha = $this->config_set->base_select("SELECT * FROM alarm LIMIT 1");
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "SendMail"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$ha[0]['mailalarm'] = (strtolower(trim($tmp[1]))=='yes' ? 1 : 0);
				}
			}
		}
		$this->assign("alarm", $ha[0]);
		$this->assign("title", '告警设置');
		$this->display('syslog_mail_alarm.tpl');
	}

	function status_warning(){
		$ac = get_request('ac', 1, 1);
		$cpu_highvalue = get_request('cpu_highvalue', 1, 0);
		$cpu_lowvalue = get_request('cpu_lowvalue', 1, 0);
		$cpu_mail_alarm = get_request('cpu_mail_alarm', 1, 0);
		$cpu_sms_alarm = get_request('cpu_sms_alarm', 1, 0);
		$cpu_send_interval = get_request('cpu_send_interval', 1, 0);
		$memory_highvalue = get_request('memory_highvalue', 1, 0);
		$memory_lowvalue = get_request('memory_lowvalue', 1, 0);
		$memory_mail_alarm = get_request('memory_mail_alarm', 1, 0);
		$memory_sms_alarm = get_request('memory_sms_alarm', 1, 0);
		$memory_send_interval = get_request('memory_send_interval', 1, 0);
		$swap_highvalue = get_request('swap_highvalue', 1, 0);
		$swap_lowvalue = get_request('swap_lowvalue', 1, 0);
		$swap_mail_alarm = get_request('swap_mail_alarm', 1, 0);
		$swap_sms_alarm = get_request('swap_sms_alarm', 1, 0);
		$swap_send_interval = get_request('swap_send_interval', 1, 0);
		$disk_highvalue = get_request('disk_highvalue', 1, 0);
		$disk_lowvalue = get_request('disk_lowvalue', 1, 0);
		$disk_mail_alarm = get_request('disk_mail_alarm', 1, 0);
		$disk_sms_alarm = get_request('disk_sms_alarm', 1, 0);
		$disk_send_interval = get_request('disk_send_interval', 1, 0);
		$ssh_highvalue = get_request('ssh_highvalue', 1, 0);
		$ssh_lowvalue = get_request('ssh_lowvalue', 1, 0);
		$ssh_mail_alarm = get_request('ssh_mail_alarm', 1, 0);
		$ssh_sms_alarm = get_request('ssh_sms_alarm', 1, 0);
		$ssh_send_interval = get_request('ssh_send_interval', 1, 0);
		$telnet_highvalue = get_request('telnet_highvalue', 1, 0);
		$telnet_lowvalue = get_request('telnet_lowvalue', 1, 0);
		$telnet_mail_alarm = get_request('telnet_mail_alarm', 1, 0);
		$telnet_sms_alarm = get_request('telnet_sms_alarm', 1, 0);
		$telnet_send_interval = get_request('telnet_send_interval', 1, 0);
		$rdp_highvalue = get_request('rdp_highvalue', 1, 0);
		$rdp_lowvalue = get_request('rdp_lowvalue', 1, 0);
		$rdp_mail_alarm = get_request('rdp_mail_alarm', 1, 0);
		$rdp_sms_alarm = get_request('rdp_sms_alarm', 1, 0);
		$rdp_send_interval = get_request('rdp_send_interval', 1, 0);
		$ftp_highvalue = get_request('ftp_highvalue', 1, 0);
		$ftp_lowvalue = get_request('ftp_lowvalue', 1, 0);
		$ftp_mail_alarm = get_request('ftp_mail_alarm', 1, 0);
		$ftp_sms_alarm = get_request('ftp_sms_alarm', 1, 0);
		$ftp_send_interval = get_request('ftp_send_interval', 1, 0);
		$db_highvalue = get_request('db_highvalue', 1, 0);
		$db_lowvalue = get_request('db_lowvalue', 1, 0);
		$db_mail_alarm = get_request('db_mail_alarm', 1, 0);
		$db_sms_alarm = get_request('db_sms_alarm', 1, 0);
		$db_send_interval = get_request('db_send_interval', 1, 0);
		$graph_highvalue = get_request('graph_highvalue', 1, 0);
		$graph_lowvalue = get_request('graph_lowvalue', 1, 0);
		$graph_mail_alarm = get_request('graph_mail_alarm', 1, 0);
		$graph_sms_alarm = get_request('graph_sms_alarm', 1, 0);
		$graph_send_interval = get_request('graph_send_interval', 1, 0);
		$mysql_highvalue = get_request('mysql_highvalue', 1, 0);
		$mysql_lowvalue = get_request('mysql_lowvalue', 1, 0);
		$mysql_mail_alarm = get_request('mysql_mail_alarm', 1, 0);
		$mysql_sms_alarm = get_request('mysql_sms_alarm', 1, 0);
		$mysql_send_interval = get_request('mysql_send_interval', 1, 0);
		$http_highvalue = get_request('http_highvalue', 1, 0);
		$http_lowvalue = get_request('http_lowvalue', 1, 0);
		$http_mail_alarm = get_request('http_mail_alarm', 1, 0);
		$http_sms_alarm = get_request('http_sms_alarm', 1, 0);
		$http_send_interval = get_request('http_send_interval', 1, 0);
		$tcp_highvalue = get_request('tcp_highvalue', 1, 0);
		$tcp_lowvalue = get_request('tcp_lowvalue', 1, 0);
		$tcp_mail_alarm = get_request('tcp_mail_alarm', 1, 0);
		$tcp_sms_alarm = get_request('tcp_sms_alarm', 1, 0);
		$tcp_send_interval = get_request('tcp_send_interval', 1, 0);
		$eth0in_highvalue = get_request('eth0in_highvalue', 1, 0);
		$eth0in_lowvalue = get_request('eth0in_lowvalue', 1, 0);
		$eth0in_mail_alarm = get_request('eth0in_mail_alarm', 1, 0);
		$eth0in_sms_alarm = get_request('eth0in_sms_alarm', 1, 0);
		$eth0in_send_interval = get_request('eth0in_send_interval', 1, 0);
		$eth0out_highvalue = get_request('eth0out_highvalue', 1, 0);
		$eth0out_lowvalue = get_request('eth0out_lowvalue', 1, 0);
		$eth0out_mail_alarm = get_request('eth0out_mail_alarm', 1, 0);
		$eth0out_sms_alarm = get_request('eth0out_sms_alarm', 1, 0);
		$eth0out_send_interval = get_request('eth0out_send_interval', 1, 0);
		$eth1in_highvalue = get_request('eth1in_highvalue', 1, 0);
		$eth1in_lowvalue = get_request('eth1in_lowvalue', 1, 0);
		$eth1in_mail_alarm = get_request('eth1in_mail_alarm', 1, 0);
		$eth1in_sms_alarm = get_request('eth1in_sms_alarm', 1, 0);
		$eth1in_send_interval = get_request('eth1in_send_interval', 1, 0);
		$eth1out_highvalue = get_request('eth1out_highvalue', 1, 0);
		$eth1out_lowvalue = get_request('eth1out_lowvalue', 1, 0);
		$eth1out_mail_alarm = get_request('eth1out_mail_alarm', 1, 0);
		$eth1out_sms_alarm = get_request('eth1out_sms_alarm', 1, 0);
		$eth1out_send_interval = get_request('eth1out_send_interval', 1, 0);

		if($ac){
			$sql = "UPDATE local_status SET highvalue='".$cpu_highvalue."',lowvalue='".$cpu_lowvalue."',mail_alarm='".$cpu_mail_alarm."',sms_alarm='".$cpu_sms_alarm."',send_interval='".$cpu_send_interval."' where type='cpu'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$memory_highvalue."',lowvalue='".$memory_lowvalue."',mail_alarm='".$memory_mail_alarm."',sms_alarm='".$memory_sms_alarm."',send_interval='".$memory_send_interval."' where type='memory'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$swap_highvalue."',lowvalue='".$swap_lowvalue."',mail_alarm='".$swap_mail_alarm."',sms_alarm='".$swap_sms_alarm."',send_interval='".$swap_send_interval."' where type='swap'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$disk_highvalue."',lowvalue='".$disk_lowvalue."',mail_alarm='".$disk_mail_alarm."',sms_alarm='".$disk_sms_alarm."',send_interval='".$disk_send_interval."' where type='disk'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$ssh_highvalue."',lowvalue='".$ssh_lowvalue."',mail_alarm='".$ssh_mail_alarm."',sms_alarm='".$ssh_sms_alarm."',send_interval='".$ssh_send_interval."' where type='ssh并发数'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$telnet_highvalue."',lowvalue='".$telnet_lowvalue."',mail_alarm='".$telnet_mail_alarm."',sms_alarm='".$telnet_sms_alarm."',send_interval='".$telnet_send_interval."' where type='telnet并发数'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$ftp_highvalue."',lowvalue='".$ftp_lowvalue."',mail_alarm='".$ftp_mail_alarm."',sms_alarm='".$ftp_sms_alarm."',send_interval='".$ftp_send_interval."' where type='ftp连接数'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$db_highvalue."',lowvalue='".$db_lowvalue."',mail_alarm='".$db_mail_alarm."',sms_alarm='".$db_sms_alarm."',send_interval='".$db_send_interval."' where type='数据库并发数'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$graph_highvalue."',lowvalue='".$graph_lowvalue."',mail_alarm='".$graph_mail_alarm."',sms_alarm='".$graph_sms_alarm."',send_interval='".$graph_send_interval."' where type='图形会话并发数'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$mysql_highvalue."',lowvalue='".$mysql_lowvalue."',mail_alarm='".$mysql_mail_alarm."',sms_alarm='".$mysql_sms_alarm."',send_interval='".$mysql_send_interval."' where type='mysql连接数'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$http_highvalue."',lowvalue='".$http_lowvalue."',mail_alarm='".$http_mail_alarm."',sms_alarm='".$http_sms_alarm."',send_interval='".$http_send_interval."' where type='http连接数'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$tcp_highvalue."',lowvalue='".$tcp_lowvalue."',mail_alarm='".$tcp_mail_alarm."',sms_alarm='".$tcp_sms_alarm."',send_interval='".$tcp_send_interval."' where type='tcp连接数'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$eth0in_highvalue."',lowvalue='".$eth0in_lowvalue."',mail_alarm='".$eth0in_mail_alarm."',sms_alarm='".$eth0in_sms_alarm."',send_interval='".$eth0in_send_interval."' where type='eth0_in_bitRate'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$eth0out_highvalue."',lowvalue='".$eth0out_lowvalue."',mail_alarm='".$eth0out_mail_alarm."',sms_alarm='".$eth0out_sms_alarm."',send_interval='".$eth0out_send_interval."' where type='eth0_out_bitRate'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$eth1in_highvalue."',lowvalue='".$eth1in_lowvalue."',mail_alarm='".$eth1in_mail_alarm."',sms_alarm='".$eth1in_sms_alarm."',send_interval='".$eth1in_send_interval."' where type='eth1_in_bitRate'";
			$this->config_set->query($sql);
			$sql = "UPDATE local_status SET highvalue='".$eth1out_highvalue."',lowvalue='".$eth1out_lowvalue."',mail_alarm='".$eth1out_mail_alarm."',sms_alarm='".$eth1out_sms_alarm."',send_interval='".$eth1out_send_interval."' where type='eth1_out_bitRate'";
			$this->config_set->query($sql);

			alert_and_back('修改成功');
		}
		$ha = $this->config_set->base_select("select *  from local_status");
		for($i=0; $i<count($ha); $i++){
			if($ha[$i]['type']=='cpu'){
				$ha['cpu_highvalue']=$ha[$i]['highvalue'];
				$ha['cpu_lowvalue']=$ha[$i]['lowvalue'];
				$ha['cpu_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['cpu_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['cpu_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='memory'){
				$ha['memory_highvalue']=$ha[$i]['highvalue'];
				$ha['memory_lowvalue']=$ha[$i]['lowvalue'];
				$ha['memory_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['memory_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['memory_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='disk'){
				$ha['disk_highvalue']=$ha[$i]['highvalue'];
				$ha['disk_lowvalue']=$ha[$i]['lowvalue'];
				$ha['disk_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['disk_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['disk_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='swap'){
				$ha['swap_highvalue']=$ha[$i]['highvalue'];
				$ha['swap_lowvalue']=$ha[$i]['lowvalue'];
				$ha['swap_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['swap_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['swap_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='ftp连接数'){
				$ha['ftp_highvalue']=$ha[$i]['highvalue'];
				$ha['ftp_lowvalue']=$ha[$i]['lowvalue'];
				$ha['ftp_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['ftp_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['ftp_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='ssh并发数'){
				$ha['ssh_highvalue']=$ha[$i]['highvalue'];
				$ha['ssh_lowvalue']=$ha[$i]['lowvalue'];
				$ha['ssh_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['ssh_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['ssh_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='telnet并发数'){
				$ha['telnet_highvalue']=$ha[$i]['highvalue'];
				$ha['telnet_lowvalue']=$ha[$i]['lowvalue'];
				$ha['telnet_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['telnet_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['telnet_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='图形会话并发数'){
				$ha['graph_highvalue']=$ha[$i]['highvalue'];
				$ha['graph_lowvalue']=$ha[$i]['lowvalue'];
				$ha['graph_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['graph_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['graph_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='数据库并发数'){
				$ha['db_highvalue']=$ha[$i]['highvalue'];
				$ha['db_lowvalue']=$ha[$i]['lowvalue'];
				$ha['db_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['db_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['db_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='mysql连接数'){
				$ha['mysql_highvalue']=$ha[$i]['highvalue'];
				$ha['mysql_lowvalue']=$ha[$i]['lowvalue'];
				$ha['mysql_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['mysql_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['mysql_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='http连接数'){
				$ha['http_highvalue']=$ha[$i]['highvalue'];
				$ha['http_lowvalue']=$ha[$i]['lowvalue'];
				$ha['http_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['http_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['http_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='tcp连接数'){
				$ha['tcp_highvalue']=$ha[$i]['highvalue'];
				$ha['tcp_lowvalue']=$ha[$i]['lowvalue'];
				$ha['tcp_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['tcp_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['tcp_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='eth0_in_bitRate'){
				$ha['eth0in_highvalue']=$ha[$i]['highvalue'];
				$ha['eth0in_lowvalue']=$ha[$i]['lowvalue'];
				$ha['eth0in_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['eth0in_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['eth0in_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='eth0_out_bitRate'){
				$ha['eth0out_highvalue']=$ha[$i]['highvalue'];
				$ha['eth0out_lowvalue']=$ha[$i]['lowvalue'];
				$ha['eth0out_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['eth0out_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['eth0out_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='eth1_in_bitRate'){
				$ha['eth1in_highvalue']=$ha[$i]['highvalue'];
				$ha['eth1in_lowvalue']=$ha[$i]['lowvalue'];
				$ha['eth1in_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['eth1in_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['eth1in_send_interval']=$ha[$i]['send_interval'];
			}elseif($ha[$i]['type']=='eth1_out_bitRate'){
				$ha['eth1out_highvalue']=$ha[$i]['highvalue'];
				$ha['eth1out_lowvalue']=$ha[$i]['lowvalue'];
				$ha['eth1out_mail_alarm']=$ha[$i]['mail_alarm'];
				$ha['eth1out_sms_alarm']=$ha[$i]['sms_alarm'];
				$ha['eth1out_send_interval']=$ha[$i]['send_interval'];
			}
		}
		$this->assign("alarm", $ha);
		$this->assign("title", '告警设置');
		$this->display('status_warning.tpl');
	}
	
	
	function default_policy(){
		$ac = get_request('ac', 1, 1);
		$id = get_request('id', 1, 0);
		$autosu = get_request('autosu', 1, 1);
		$syslogalert = get_request('syslogalert', 1, 1);
		$mailalert = get_request('mailalert', 1, 1);
		$loginlock = get_request('loginlock', 1, 1);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$forbidden_commands_groups = get_request('forbidden_commands_groups', 1, 1);
		$netdisksize = get_request('netdisksize', 1, 1);
		$default_control = get_request('default_control', 1, 1);
		$entrust_password = get_request('entrust_password', 1, 1);
		$rdpclipauth_up = get_request('rdpclipauth_up', 1, 1);
		$rdpdiskauth_up = get_request('rdpdiskauth_up', 1, 1);
		$rdpclipauth_down = get_request('rdpclipauth_down', 1, 1);
		$rdpdiskauth_down = get_request('rdpdiskauth_down', 1, 1);
		$ipv6enable = get_request('ipv6enable', 1, 1);
		if($autosu == 'on') {
			$autosu = 1;
		}
		else {
			$autosu = 0;
		}
		if($syslogalert == 'on') {
			$syslogalert = 1;
		}
		else {
			$syslogalert = 0;
		}
		if($mailalert == 'on') {
			$mailalert = 1;
		}
		else {
			$mailalert = 0;
		}
		if($loginlock == 'on') {
			$loginlock = 1;
		}
		else {
			$loginlock = 0;
		}
		if($entrust_password == 'on') {
			$entrust_password = 1;
		}
		else {
			$entrust_password = 0;
		}
		if($rdpclipauth_up == 'on') {
			$rdpclipauth_up = 1;
		}
		else {
			$rdpclipauth_up = 0;
		}
		if($rdpdiskauth_up == 'on') {
			$rdpdiskauth_up = 1;
		}
		else {
			$rdpdiskauth_up = 0;
		}

		if($rdpclipauth_down == 'on') {
			$rdpclipauth_down = 1;
		}
		else {
			$rdpclipauth_down = 0;
		}
		if($rdpdiskauth_down == 'on') {
			$rdpdiskauth_down = 1;
		}
		else {
			$rdpdiskauth_down = 0;
		}
		if($ipv6enable == 'on') {
			$ipv6enable = 1;
		}
		else {
			$ipv6enable = 0;
		}
		if($ac){
			$sql = ($ac != 'new' ? 'UPDATE' : 'INSERT INTO ')." defaultpolicy SET autosu='".(empty($autosu) ? 0 : $autosu)."',syslogalert='".(empty($syslogalert) ? 0 : $syslogalert)."', mailalert='".(empty($mailalert) ? 0 : $mailalert)."', loginlock='".(empty($loginlock) ? 0 : $loginlock)."',weektime='".$weektime."', sourceip='".$sourceip."', forbidden_commands_groups='".$forbidden_commands_groups."'".", netdisksize='".$netdisksize."'".", default_control='".$default_control."'".", entrust_password='".$entrust_password."', rdpclipauth_up='".$rdpclipauth_up."', rdpclipauth_down='".$rdpclipauth_down."',  rdpdiskauth_up='".$rdpdiskauth_up."',  rdpdiskauth_down='".$rdpdiskauth_down."',  ipv6enable='".$ipv6enable."'";
			$this->config_set->query($sql);
			$this->config_set->query("UPDATE member set netdisksize='".$netdisksize."'");
			alert_and_back('修改成功');
		}
		$ha = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$weektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1', 'black_or_white','asc');
		$this->assign("weektime", $weektime);
		$this->assign("allforbiddengroup", $allforbiddengroup);
		$this->assign("sourceip", $sourceip);
				
		$this->assign("defaultp", $ha[0]);
		$this->assign("title", language('默认策略'));
		$this->display('default_policy.tpl');
	}

	function autochange_pwd(){
		$ac = get_request('ac', 1, 1);
		$id = get_request('id', 1, 0);
		$minlen = get_request('minlen', 1, 1);
		$minalpha = get_request('minalpha', 1, 1);
		$minother = get_request('minother', 1, 1);
		$mindiff = get_request('mindiff', 1, 1);
		$maxrepeats = get_request('maxrepeats', 1, 1);
		$histexpire = get_request('histexpire', 1, 1);
		$histsize = get_request('histsize', 1, 1);
		
		
		if($ac){
			if(!ctype_digit($minlen)|| $minlen <0){
				alert_and_back('最小长度输入大于等于0的整数');
				exit;
			}
			if(!ctype_digit($minalpha)|| $minalpha <0){
				alert_and_back('最小字母数输入大于等于0的整数');
				exit;
			}
			if(!ctype_digit($minother)|| $minother <0){
				alert_and_back('最少其他字符数输入大于等于0的整数');
				exit;
			}
			if(!ctype_digit($mindiff)|| $mindiff <0){
				alert_and_back('与旧口令最少不同数输入大于等于0的整数');
				exit;
			}
			if(!ctype_digit($maxrepeats)|| $maxrepeats <0){
				alert_and_back('密码最大重复字符数输入大于等于0的整数');
				exit;
			}
			if(!ctype_digit($histexpire)|| $histexpire <1){
				alert_and_back('记录旧密码时间输入大于0的整数');
				exit;
			}
			if(!ctype_digit($histsize)|| $histsize <0){
				alert_and_back('记录旧密码次数输入大于等于0的整数');
				exit;
			}

			$sql = ($ac != 'new' ? 'UPDATE' : 'INSERT INTO ')." password_policy SET minlen='".$minlen."', minalpha='".$minalpha."', minother='".$minother."'".", mindiff='".$mindiff."'".", maxrepeats='".$maxrepeats."'".", histexpire='".$histexpire."'".", histsize='".$histsize."'";
			$this->config_set->query($sql);
			alert_and_back('修改成功');
		}
		$ha = $this->config_set->base_select("SELECT * FROM password_policy LIMIT 1");
				
		$this->assign("defaultp", $ha[0]);
		$this->assign("title", language('默认策略'));
		$this->display('autochange_pwd.tpl');
	}

	function addldapserver(){
		$this->display("addldapserver.tpl");
	}

	function doaddldapserver(){
		global $_CONFIG;
		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$config = unserialize($setting[0]['svalue']);
		if(!empty($_POST['newip'])){
			if($_POST['type']=='ldap'){
				$config['ldapconfig'][]=array('address'=>$_POST['newip'], 'port'=>$_POST['newport'], 'domain'=>$_POST['newdomain'], 'transpant'=>$_POST['transpant']);
				if($_POST['transpant']){
					$filename = $_CONFIG['CONFIGFILE']['SSH'];
					$lines = @file($filename);
					if(!empty($lines))
					{
						for($ii=0; $ii<count($lines); $ii++)
						{
											
							if(strstr(strtolower($lines[$ii]), "ldapserveraddress"))
							{
								$lines[$ii++] = "LDAPServerAddress\t\t".$_POST['newip']."\n";
							}
							if(strstr(strtolower($lines[$ii]), "ldapserverport"))
							{
								$lines[$ii++] = "LDAPServerpORT\t\t".$_POST['newport']."\n";
							}
						}
						
					}
					else
					{
						alert_and_back('配置文件不存在或没有权限','',1);
						exit;
					}
					
					$this->Array2File($lines,$filename);
					unset($lines);
				}
			}else{
				$config['adconfig'][]=array('address'=>$_POST['newip'], 'port'=>$_POST['newport'], 'domain'=>$_POST['newdomain']);
			}
		}
		$this->setting_set->query("UPDATE setting SET svalue='".serialize($config)."' WHERE sname='loginconfig'");
		alert_and_back('修改成功','admin.php?controller=admin_config&action=config_ssh');
	}
	
	function config_ssh()
	{
		
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SSH'];
		//$filename = './controller/freesvr-ssh-proxy_config.config';
		
		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "MasterRadiusServerAddress"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['address'] = trim($tmp[1]);
				}
				if(strstr($lines[$ii], "MasterRadiusServerPort"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['port'] = trim($tmp[1]);
				}
				if(strstr($lines[$ii], "MasterRadiusServerSecret"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['secret'] = trim($tmp[1]);
				}
				if(strstr($lines[$ii], "SlaveRadiusServerAddress"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['slaveaddress'] = trim($tmp[1]);
				}
				if(strstr($lines[$ii], "SlaveRadiusServerPort"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['slaveport'] = trim($tmp[1]);
				}
				if(strstr($lines[$ii], "SlaveRadiusServerSecret"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['slavesecret'] = trim($tmp[1]);
				}
				if(strstr($lines[$ii], "RadiusAuth"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['radiusauth'] = trim($tmp[1]);
				}
			}
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限','',1);
			exit;
		}
		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$pwdconfig = unserialize($setting[0]['svalue']);
		$this->assign("ldaps", $pwdconfig['ldapconfig']);
		$this->assign("ads", $pwdconfig['adconfig']);
		$this->assign("sshconfig", $network);
		$this->display('config_ssh.tpl');
	}

	function ssh_save()
	{
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SSH'];
		//$filename = './controller/freesvr-ssh-proxy_config.config';
		$new_address = get_request('address',1,1);
		$new_port = get_request('port',1,1);
		$new_secret = get_request('secret',1,1);
		$new_slaveaddress = get_request('slaveaddress',1,1);
		$new_slaveport = get_request('slaveport',1,1);
		$new_slavesecret = get_request('slavesecret',1,1);
		$new_radiusauth = get_request('radiusauth',1,1);
		$ldapip = get_request('ldapip',1,1);
		$ldapport = get_request('ldapport',1,1);
		$ldapdc = get_request('ldapdc',1,1);
		$adip = get_request('adip',1,1);
		$adport = get_request('adport',1,1);
		$addomain = get_request('addomain',1,1);
		$adusername = get_request('adusername', 1, 1);
		$adpassword = get_request('adpassword', 1, 1);
		for($i=0; $i<count($_POST['ldapip']); $i++){
			if(!empty($_POST['ldapip'][$i])){
				if($_POST['transpant'][$i]){
					$filename = $_CONFIG['CONFIGFILE']['SSH'];
					$lines = @file($filename);
					if(!empty($lines))
					{
						for($ii=0; $ii<count($lines); $ii++)
						{
											
							if(strstr(strtolower($lines[$ii]), "ldapserveraddress"))
							{
								$lines[$ii++] = "LDAPServerAddress\t\t".$_POST['ldapip'][$i]."\n";
							}
							if(strstr(strtolower($lines[$ii]), "ldapserverport"))
							{
								$lines[$ii++] = "LDAPServerpORT\t\t".$_POST['ldapport'][$i]."\n";
							}
						}
						
					}
					else
					{
						alert_and_back('配置文件不存在或没有权限','',1);
						exit;
					}
					
					$this->Array2File($lines,$filename);
					unset($lines);
				}
				$config['ldapconfig'][]=array('address'=>$_POST['ldapip'][$i], 'port'=>$_POST['ldapport'][$i], 'domain'=>$_POST['ldapdomain'][$i], 'transpant'=>$_POST['transpant'][$i]);
			}
		}
		for($i=0; $i<count($_POST['adip']); $i++){
			if(!empty($_POST['adip'][$i]))
			$config['adconfig'][]=array('address'=>$_POST['adip'][$i], 'port'=>$_POST['adport'][$i], 'domain'=>$_POST['addomain'][$i]);
		}
		
		$this->setting_set->query("UPDATE setting SET svalue='".serialize($config)."' WHERE sname='loginconfig'");

		if(!is_ip($new_address)){
			alert_and_back('集中授权管理服务器地址格式不正确 ');
			exit;
		}
		if(!is_ip($new_slaveaddress)){
			alert_and_back('集中授权管理从服务器地址格式不正确 ');
			exit;
		}
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "MasterRadiusServerAddress"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $new_address, $lines[$ii]);
				}
				if(strstr($lines[$ii], "MasterRadiusServerPort"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $new_port, $lines[$ii]);
				}
				if(strstr($lines[$ii], "MasterRadiusServerSecret"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $new_secret, $lines[$ii]);
				}
				if(strstr($lines[$ii], "SlaveRadiusServerAddress"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $new_slaveaddress, $lines[$ii]);
				}
				if(strstr($lines[$ii], "SlaveRadiusServerPort"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $new_slaveport, $lines[$ii]);
				}
				if(strstr($lines[$ii], "SlaveRadiusServerSecret"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $new_slavesecret, $lines[$ii]);
				}
				if(strstr($lines[$ii], "RadiusAuth"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $new_radiusauth, $lines[$ii]);
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
	
		$this->Array2File($lines,$filename);
		//system('sudo /opt/freesvr/audit/sbin/manageprocess freesvr-authd reload',$out);
		system('sudo /opt/freesvr/audit/sbin/manageprocess freesvr-authd stop',$out);
		system('sudo /opt/freesvr/audit/sbin/manageprocess freesvr-authd start',$out);
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ssh');
	}
	
	function config_ftp()
	{
		//$filename = './controller/freesvr-ftp-audit.conf';
		global $_CONFIG;

		$filename = $_CONFIG['CONFIGFILE']['NGINX'];
		$network['snmp']=0;
		exec('ps -ef  |  grep  snmp',$o);
		for($i=0; $i<count($o); $i++){
			if(strstr($o[$i],'/usr/sbin/snmpd')){
				$network['snmp']=1;
			}
		}
		
		$filename = $_CONFIG['IPTABLES'];		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], " -p icmp "))
				{
					if(substr(trim($lines[$ii]),0,1)=='#'){
						$network['ping'] = 0;
					}else{
						$network['ping'] = 1;
					}
				}
			}
		}
		else
		{
			alert_and_back($filename.'配置文件不存在或没有权限');
			exit;
		}
		unset($lines);

		$filename = $_CONFIG['NTPNAGIOS'];		
		$lines = file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(substr(trim($lines[$ii]),0,1)!='#'&&strstr($lines[$ii], "ntpdate "))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);//var_dump($tmp);
					for($i=count($tmp)-1; $i>=0; $i--){
						if($tmp[$i]){
							$network['ntpserver'] = trim($tmp[$i]);
							break;
						}
					}
					break;
				}
			}
		}

		$filename = $_CONFIG['SNMP'];		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "com2sec notConfigUser"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					for($i=count($tmp)-1; $i<count($tmp); $i--){
						if(!empty($tmp[$i])){
							$network['community'] = trim($tmp[$i]);
							break;
						}
					}
				}
			}
		}
		else
		{
			alert_and_back($filename.'配置文件不存在或没有权限');
			exit;
		}
		unset($lines);

		$priority_cache = $this->setting_set->select_all("sname='priority_cache'");
		$priority_cache = $priority_cache[0]['svalue'];
		$blankuser = $this->setting_set->select_all("sname='blankuser'");
		$blankuser = $blankuser[0]['svalue'];
		$autodelcycle = $this->setting_set->select_all("sname='autodelete'");
		$autodelcycle = $autodelcycle[0]['svalue'];
		$ldap = $this->setting_set->select_all("sname='ldap'");
		$ldap = $ldap[0]['svalue'];
		$Certificate = $this->setting_set->select_all("sname='Certificate'");
		$Certificate = $Certificate[0]['svalue'];
		$Async = $this->setting_set->select_all("sname='Async'");
		$Async = $Async[0]['svalue'];
		$RdpInput = $this->setting_set->select_all("sname='RdpInput'");
		$RdpInput = $RdpInput[0]['svalue'];
		$DpwdTime = $this->setting_set->select_all("sname='DpwdTime'");
		$DpwdTime = $DpwdTime[0]['svalue'];
		$RdpRunning = $this->setting_set->select_all("sname='RdpRunning'");
		$RdpRunning = $RdpRunning[0]['svalue'];
		$LoginAuthType = $this->setting_set->select_all("sname='LoginAuthType'");
		$LoginAuthType = $LoginAuthType[0]['svalue'];
		$RdpToLocal = $this->setting_set->select_all("sname='RdpToLocal'");
		$RdpToLocal = $RdpToLocal[0]['svalue'];
		$rdpauthtips = $this->setting_set->select_all("sname='rdpauthtips'");
		$rdpauthtips = $rdpauthtips[0]['svalue'];
		$loginwrongtips = $this->setting_set->select_all("sname='loginwrongtips'");
		$loginwrongtips = $loginwrongtips[0]['svalue'];
		$AsyncoutPass = $this->setting_set->select_all("sname='AsyncoutPass'");
		$AsyncoutPass = $AsyncoutPass[0]['svalue'];
		$PasswordKey = $this->setting_set->select_all("sname='PasswordKey'");
		$PasswordKey = $PasswordKey[0]['svalue'];
		$ACCEPT = $this->setting_set->select_all("sname='ACCEPT'");
		$ACCEPT = $ACCEPT[0]['svalue'];
		$RDPPLAYIP = $this->setting_set->select_all("sname='RDPPLAYIP'");
		$RDPPLAYIP = $RDPPLAYIP[0]['svalue'];
		$chap = $this->setting_set->select_all("sname='CHAP'");
		$chap = $chap[0]['svalue'];
		$network['year'] = date("Y");
		$network['month'] = date("m");
		$network['day'] = date("d");
		$network['hour'] = date("H");
		$network['minute'] = date("i");
		$network['second'] = date("s");
		$this->assign("sshconfig", $network);
		$this->assign("current_time", date('y-m-d H:i:s'));
		$eth0 = explode(":", $_SERVER["HTTP_HOST"]);
		$this->assign("eth0", $eth0[0]);
		$this->assign("autodelcycle", $autodelcycle);
		$this->assign("logintype", $logintype);
		$this->assign("priority_cache", $priority_cache);
		$this->assign("blankuser", $blankuser);
		$this->assign("ldap", $ldap);
		$this->assign("Certificate", $Certificate);
		$this->assign("Async", $Async);
		$this->assign("rdpinput", $RdpInput);
		$this->assign("diskfull", $DiskFull);
		$this->assign("dpwdtime", $DpwdTime);
		$this->assign("rdprunning", $RdpRunning);
		$this->assign("loginauthtype", $LoginAuthType);
		$this->assign("radiustolocal", $RdpToLocal);
		$this->assign("rdpauthtips", $rdpauthtips);
		$this->assign("loginwrongtips", $loginwrongtips);
		$this->assign("passwordkey", $PasswordKey);
		$this->assign("accept", $ACCEPT);
		$this->assign("rdpplayip", $RDPPLAYIP);
		$this->assign("fingersecserver", $fingersecserver);
		$this->assign("chap", intval($chap));
		$allmem = $this->member_set->select_all(" level!=11 ".(empty($webuser) ? '' : " AND username like '%$webuser%' " )." ".$wheremember." AND uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''),'username','ASC');
		for($i=0; $i<count($_CONFIG['WorkFlowAdmin']); $i++){
			$this->assign("member".($i+1), $_CONFIG['WorkFlowAdmin'][$i]);
		}
		$this->assign("allmem", $allmem);

		$this->display('config_ftp.tpl');
	}

	

	function ntpset(){
		global $_CONFIG;
		$filename = $_CONFIG['NTPKEYS'];		
		$ntpkey = get_request('ntpkey',1,1);	
		$ntpserver = get_request('ntpserver',1,1);

		$filename = $_CONFIG['NTPNAGIOS'];		
		//$ntpserver = get_request('ntpserver',1,1);		
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
				if(strstr($lines[$ii], "ntpdate "))
				{
					if($ntpserver){
						$lines[$ii] = "1 1 * * * /usr/bin/sudo -u root /usr/sbin/ntpdate $ntpserver\n";
						$found=1;
					}else{
						$lines[$ii] = '';
					}
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		if(!$found&&$ntpserver){
			$lines[$ii] = "1 1 * * * /usr/bin/sudo -u /usr/sbin/ntpdate $ntpserver\n";
		}
		$this->Array2File($lines,$filename);		
		exec("/usr/bin/sudo /sbin/service  ntpd stop");
		if(empty($ntpkey)){
			exec("/usr/bin/sudo -u root  /usr/sbin/ntpdate $ntpserver");
		}else{
			exec("/usr/bin/sudo -u root  /usr/sbin/ntpdate -a 65535 $ntpserver");
		}
		exec("/usr/bin/sudo /sbin/service ntpd start");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function threepripwd(){
		$this->display('threepripwd.tpl');
	}

	function dothreepripwd(){
		$password = get_request('password', 1, 1);
		$repassword = get_request('repassword', 1, 1);
		if($password!=$repassword){
			echo '<script>alert("两次输入的密码不一样");</script>';
			exit;
		}elseif(strlen($password)!=9){
			echo '<script>alert("输入的密码长度应该为9");</script>';
			exit;
		}
		$_SESSION['THREE_PRI_PASSWORD']=$password;
		echo "<script>window.parent.closeWindow();window.parent.loadurl('admin.php?controller=admin_config&action=threepripwd_twopwd');</script>";
		exit;
	}

	function threepripwd_twopwd(){
		$this->display('threepripwd_twopwd.tpl');
	}

	function dothreepripwd_twopwd(){
		global $_CONFIG;
		$auditpassword = get_request('auditpassword', 1, 1);
		$passwordpassword = get_request('passwordpassword', 1, 1);
		if(empty($_SESSION['THREE_PRI_PASSWORD'])){
			echo '<script>alert("系统错误请重新打开");</script>';
			exit;
		}
		if($this->member_set->select_count("username='audit' and password=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? "udf_encrypt('".($auditpassword)."')" : "AES_ENCRYPT('".($auditpassword)."','".$_CONFIG['PASSWORD_KEY']."')"))<=0){
			echo '<script>alert("audit用户密码不正确");</script>';
			exit;
		}
		if($this->member_set->select_count("username='password' and password=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? "udf_encrypt('".($passwordpassword)."')" : "AES_ENCRYPT('".($passwordpassword)."','".$_CONFIG['PASSWORD_KEY']."')"))<=0){
			echo '<script>alert("password用户密码不正确");</script>';
			exit;
		}
		$newpwdcrypt = new password_crypt();
		$newpwdcrypt->set_data('password', $this->member_set->udf_encrypt($_SESSION['THREE_PRI_PASSWORD']));
		$this->password_crypt_set->add($newpwdcrypt);
		echo "<script>alert('操作成功');window.parent.closeWindow();</script>";
		exit;
	}

	function viewthreepripwd_twopwd(){
		$this->display('viewthreepripwd_twopwd.tpl');
	}

	function doviewthreepripwd_twopwd(){
		global $_CONFIG;
		$auditpassword = get_request('auditpassword', 1, 1);
		$passwordpassword = get_request('passwordpassword', 1, 1);
		if($this->member_set->select_count("username='audit' and password=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? "udf_encrypt('".($auditpassword)."')" : "AES_ENCRYPT('".($auditpassword)."','".$_CONFIG['PASSWORD_KEY']."')"))<=0){
			echo '<script>alert("audit用户密码不正确");</script>';
			exit;
		}
		if($this->member_set->select_count("username='password' and password=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? "udf_encrypt('".($passwordpassword)."')" : "AES_ENCRYPT('".($passwordpassword)."','".$_CONFIG['PASSWORD_KEY']."')"))<=0){
			echo '<script>alert("password用户密码不正确");</script>';
			exit;
		}
		$allpwd = $this->password_crypt_set->select_all('1', 'date', 'asc');
		for($i=0; $i<count($allpwd); $i++){
			$allpwd[$i]['password'] = $this->password_crypt_set->udf_decrypt($allpwd[$i]['password']);
		}
		$this->assign("allpwd", $allpwd);
		$this->display("doviewthreepwd.tpl");
	}

	function ping_save(){
		global $_CONFIG;
		$filename = $_CONFIG['IPTABLES'];		
		$ping = get_request('ping',1,1);		
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], " -p icmp "))
				{
					if(empty($ping)){
						$lines[$ii] = "#-A RH-Firewall-1-INPUT -p icmp -j ACCEPT\n";
					}else{
						$lines[$ii] = "-A RH-Firewall-1-INPUT -p icmp -j ACCEPT\n";
					}
					//$lines[$ii] = $tmp[0].' '.$sftpbackupsize."\n";
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->Array2File($lines,$filename);
		unset($lines);
		ob_start();	
		//system('sudo /sbin/service iptables restart');
		if($_CONFIG['SYSTEMVERSION_IPTABLES']==7){
			exec("sudo systemctl restart iptables");
		}else{
			exec("sudo /etc/init.d/iptables restart");
		}
		ob_get_clean();
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	} 

	function snmp_save(){
		global $_CONFIG;
		$filename = $_CONFIG['IPTABLES'];		
		$snmp = get_request('snmp',1,1);		
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], " --dport 161 "))
				{
					if(empty($snmp)){
						$lines[$ii] = "#-A RH-Firewall-1-INPUT -p udp -m udp --dport 161 -j ACCEPT\n";
					}else{
						$lines[$ii] = "-A RH-Firewall-1-INPUT -p udp -m udp --dport 161 -j ACCEPT\n";
					}
					//$lines[$ii] = $tmp[0].' '.$sftpbackupsize."\n";
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->Array2File($lines,$filename);
		unset($lines);
		ob_start();
		//system('sudo /sbin/service iptables restart');
		if($_CONFIG['SYSTEMVERSION_IPTABLES']==7){
			exec("sudo /usr/bin/systemctl restart iptables");
		}else{
			exec("sudo /etc/init.d/iptables restart");
		}
		ob_get_clean();
		if(empty($snmp)){
			exec("sudo /usr/bin/systemctl  disable snmpd");
			exec("sudo /usr/bin/systemctl  stop snmpd");
		}else{
			exec("sudo /usr/bin/systemctl  enable snmpd");
			exec("sudo /usr/bin/systemctl  start snmpd");
		}
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	} 


	function snmpcommunity_save(){
		global $_CONFIG;
		$filename = $_CONFIG['SNMP'];		
		$community = get_request('community',1,1);		
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "com2sec notConfigUser"))
				{
					$lines[$ii] = "com2sec notConfigUser   default         ".$community."\n";
					//$lines[$ii] = $tmp[0].' '.$sftpbackupsize."\n";
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->Array2File($lines,$filename);
		unset($lines);
		ob_start();
		system('sudo /usr/bin/systemctl restart snmpd');
		ob_get_clean();
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	} 

	function autodelete_save(){
		$autodelete = get_request('autodelete', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$autodelete."' WHERE sname='autodelete'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function priority_cache_save(){
		$priority_cache = get_request('priority_cache', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$priority_cache."' WHERE sname='priority_cache'");
		$this->member_set->query("UPDATE ".$this->member_set->get_table_name()." SET searchcache='".$priority_cache."'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function blankuser_save(){
		$priority_cache = get_request('blankuser', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$priority_cache."' WHERE sname='blankuser'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function ldap_save(){
		$ldap = get_request('ldap', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$ldap."' WHERE sname='ldap'");
		alert_and_back('配置成功','admin.php?controller=admin_index&actions=config_ftp', 0, 1);
	}

	function Async_save(){
		$Async = get_request('Async', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$Async."' WHERE sname='Async'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function rdpinput_save(){
		$rdpinput = get_request('rdpinput', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$rdpinput."' WHERE sname='RdpInput'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function diskfull_save(){
		$diskfull = get_request('diskfull', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$diskfull."' WHERE sname='DiskFull'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function dpwdtime_save(){
		$dpwdtime = get_request('dpwdtime', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$dpwdtime."' WHERE sname='DpwdTime'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function rdprunning_save(){
		$rdprunning = get_request('rdprunning', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$rdprunning."' WHERE sname='RdpRunning'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function loginauthtype_save(){
		$loginauthtype = get_request('loginauthtype', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$loginauthtype."' WHERE sname='LoginAuthType'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function radiustolocal_save(){
		$radiustolocal = get_request('radiustolocal', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$radiustolocal."' WHERE sname='RdpToLocal'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function rrdpauthtips_save(){
		$rdpauthtips = get_request('rdpauthtips', 1, 1);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$rdpauthtips."' WHERE sname='rdpauthtips'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}
	
	function loginwrongtips_save(){
		$loginwrongtips = get_request('loginwrongtips', 1, 1);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$loginwrongtips."' WHERE sname='loginwrongtips'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function asyncoutpass_save(){
		$asyncoutpass = get_request('asyncoutpass', 1, 1);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$asyncoutpass."' WHERE sname='AsyncoutPass'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}
	
	function passwordkey_save(){
		$passwordkey = get_request('passwordkey', 1, 1);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$passwordkey."' WHERE sname='PasswordKey'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function accept_save(){
		$accept = get_request('accept', 1, 1);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$accept."' WHERE sname='accept'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function rdpplayip_save(){
		$rdpplayip = get_request('rdpplayip', 1, 1);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$rdpplayip."' WHERE sname='RDPPLAYIP'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function fingersecserver_save(){
		$fingersecserver = get_request('fingersecserver', 1, 1);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$fingersecserver."' WHERE sname='FingerSecServer'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function chap_save(){
		$chap = get_request('chap', 1, 0);
		$_chap = $this->setting_set->select_all("sname='CHAP'");
		$_chap = $_chap[0]['svalue'];

		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$chap."' WHERE sname='CHAP'");
		if($chap!=$_chap){
			if($chap){
				$this->setting_set->query("DELETE FROM radcheck WHERE Attribute='User-Password'");
				$members = $this->member_set->select_all("level=11");
				for($i=0; $i<count($members); $i++){
					$this->setting_set->query("DELETE FROM radcheck WHERE Attribute='Crypt-Password' and username='".$members[$i]['username']."'");
					$this->setting_set->query("DELETE FROM radcheck WHERE Attribute='User-Password' and username='".$members[$i]['username']."'");
					$this->setting_set->query("UPDATE member set password=aes_decrypt(password,(select udf_decrypt(svalue) from setting where sname='PasswordKey')) WHERE username='".$members[$i]['username']."'");
					$new_radius = new radius();						
					$new_radius->set_data("UserName",$members[$i]['username']);
					$new_radius->set_data("Attribute",'User-Password');
					$new_radius->set_data("email",$members[$i]['email']);
					$new_radius->set_data("Value",$this->member_set->udf_decrypt($members[$i]['password']));
					$this->radius_set->add($new_radius);
				}
			}else{
				$members = $this->member_set->select_all("level=11");
				for($i=0; $i<count($members); $i++){
					$this->setting_set->query("DELETE FROM radcheck WHERE Attribute='Crypt-Password' and username='".$members[$i]['username']."'");
					$this->setting_set->query("DELETE FROM radcheck WHERE Attribute='User-Password' and username='".$members[$i]['username']."'");
					$this->setting_set->query("UPDATE member set password=aes_encrypt(password,(select udf_decrypt(svalue) from setting where sname='PasswordKey')) WHERE username='".$members[$i]['username']."'");
					$new_radius = new radius();						
					$new_radius->set_data("UserName",$members[$i]['username']);
					$new_radius->set_data("Attribute",'Crypt-Password');
					$new_radius->set_data("email",$members[$i]['email']);
					$new_radius->set_data("Value",crypt($members[$i]['password'],"\$1\$qY9g/6K4"));
					$this->radius_set->add($new_radius);
				}
			}
		}
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function workflowadmin_save(){
		for($i=1; $i<=5; $i++){
			if($_POST['memberselect'.$i])
				$member[]=$_POST['memberselect'.$i];
		}
		if(empty($member)){
			alert_and_back('请选择用户','admin.php?controller=admin_config&action=config_ftp');
			exit;
		}
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".implode(',', $member)."' WHERE sname='WorkFlowAdmin'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function certificate_save(){
		$Certificate = get_request('Certificate', 1, 0);
		$filename = "/opt/freesvr/web/conf/extra/httpd-ssl.conf";
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{		
				if(strstr($lines[$ii], "SSLVerifyClient require"))
				{
					$lines[$ii] = (empty($Certificate) ? '#' :'')."SSLVerifyClient require"."\n";
				}
				if(strstr($lines[$ii], "SSLVerifyDepth 1"))
				{
					$lines[$ii] = (empty($Certificate) ? '#' :'')."SSLVerifyDepth 1"."\n";
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->Array2File($lines,$filename);
		unset($lines);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$Certificate."' WHERE sname='Certificate'");
		system('sudo /etc/init.d/httpd graceful');
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function ftp_save()
	{
		//$filename = './controller/freesvr-ftp-audit.conf';
		global $_CONFIG;
		$reset = get_request('reset',1,1);
		$shutdown = get_request('shutdown',1,1);
		$clearaccount = get_request('clearaccount',1,1);
		$correctdata = get_request('correctdata',1,1);
		$settime = get_request('settime',1,1);
		$keyedit = get_request('keyedit',1,1);
		if($reset){
			$this->resetsystem();
			exit;
		}elseif($shutdown){
			$this->shutdown();
			exit;
		}elseif($clearaccount){
			$this->clearaccount();
			exit;
		}elseif($correctdata){
			$this->correctdata();
			exit;
		}elseif($settime){
			$this->settime();
			exit;
		}elseif($keyedit){
			$this->keyedit($eth0);
			exit;
		}
		
		$filename = $_CONFIG['CONFIGFILE']['FTP'];		
		$ftpbackupsize = get_request('ftpbackupsize',1,1);
		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "FtpBackupSize"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$lines[$ii] = str_replace($tmp[1], $ftpbackupsize, $lines[$ii]);
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->Array2File($lines,$filename);
		unset($lines);
		/*$filename = $_CONFIG['CONFIGFILE']['SFTP'];		
		$sftpbackupsize = get_request('sftpbackupsize',1,1);		
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "SftpBackupSize"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					//$lines[$ii] = str_replace($tmp[1], $sftpbackupsize, $lines[$ii]);
					$lines[$ii] = $tmp[0].' '.$sftpbackupsize."\n";
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->Array2File($lines,$filename);
		unset($lines);*/
		ob_start();		
		system('sudo /opt/freesvr/audit/sbin/manageprocess ftp-audit stop ',$out);
		system('sudo /opt/freesvr/audit/sbin/manageprocess ftp-audit start ',$out);

		ob_get_clean();

		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function resetsystem(){
		$adminlog = new admin_log();	
		$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
		$adminlog->set_data('action', language('系统重新启动'));
		$adminlog->set_data('result', language('已记录'));
		$this->admin_log_set->add($adminlog);		
		
		system('sudo /sbin/init 6 ',$out);

		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function shutdown(){
		$adminlog = new admin_log();	
		$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
		$adminlog->set_data('action', language('系统关闭'));
		$adminlog->set_data('result', language('已记录'));
		$this->admin_log_set->add($adminlog);	

		system('sudo /sbin/init 0 ',$out);
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}
	function settime(){
		$year = get_request('year', 1, 1);
		$month = get_request('month', 1, 1);
		$day = get_request('day', 1, 1);
		$hour = get_request('hour', 1, 1);
		$minute = get_request('minute', 1, 1);
		$second = get_request('second', 1, 1);

		$adminlog = new admin_log();	
		$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
		$adminlog->set_data('action', language('修改系统时间为:'."$year$month$day $hour:$minute:$second"));
		$adminlog->set_data('result', language('已记录'));
		$this->admin_log_set->add($adminlog);				

		system("sudo date -s '$year$month$day $hour:$minute:$second'",$out);
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function clearaccount(){
		$this->apppub_set->query("Delete from member where level not in(1, 2, 10) and username!='test' ");
		$this->apppub_set->query("Delete from radcheck where UserName not in(SELECT username FROM member where level in(1, 2, 10) ) and UserName!='test'");
		$this->apppub_set->query("Delete from radreply where UserName not in(SELECT username FROM member where level in(1, 2, 10) ) and UserName!='test'");
		$this->apppub_set->query("delete from luser");
		$this->apppub_set->query("delete from lgroup");
		$this->apppub_set->query("delete from devices where device_ip!='127.0.0.1'");
		$this->apppub_set->query("delete from servers where device_ip!='127.0.0.1'");
		$this->apppub_set->query("delete from apppub");
		$this->apppub_set->query("delete from resourcegroup");
		$this->apppub_set->query("delete from appdevices");
		$this->apppub_set->query("delete from apppserver");
		$this->apppub_set->query("delete from appmember");
		$this->apppub_set->query("delete from appgroup");
		$this->apppub_set->query("delete from sessions");
		$this->apppub_set->query("delete from commands");
		$this->apppub_set->query("delete from sftpsessions");
		$this->apppub_set->query("delete from sftpcomm");
		$this->apppub_set->query("delete from ftpsessions");
		$this->apppub_set->query("delete from ftpcomm");
		$this->apppub_set->query("delete from rdpsessions");
		$this->apppub_set->query("delete from rdpinput");
		$this->apppub_set->query("delete from rdpmouse");
		$this->apppub_set->query("delete from vncsessions");
		$this->apppub_set->query("delete from admin_log");
		$this->apppub_set->query("delete from account_linuxusers");
		$this->apppub_set->query("delete from account_record");
		$this->apppub_set->query("delete from appcomm");
		$this->apppub_set->query("delete from alarmtab");
		$this->apppub_set->query("delete from local_status_warning_log");
		$this->apppub_set->query("delete from loginacct");
		$this->apppub_set->query("delete from radacct");
		$this->apppub_set->query("delete from rdp");
		$this->apppub_set->query("delete from rdpsessions");
		$this->apppub_set->query("delete from vpn_log");
		$this->apppub_set->query("delete from dev");
		$this->apppub_set->query("delete from usergroup");
		$this->apppub_set->query("delete from servergroup where id not in(select groupid from member where level in(1,2,10))");
		$this->apppub_set->query("delete from logincommit");
		$this->apppub_set->query("delete from login4approve");
		$this->apppub_set->query("delete from backup_err_log");
		$this->apppub_set->query("delete from backup_log");
		$this->apppub_set->query("delete from passwordlog");
		$this->apppub_set->query("delete from admin_log");
		$this->apppub_set->query("delete from login4approve");
		$this->apppub_set->query("delete from appresourcegroup");
		$this->apppub_set->query("delete from sourceip");
		$this->apppub_set->query("delete from weektime");
		$this->apppub_set->query("delete from forbidden_groups");
		$this->apppub_set->query("delete from forbidden_commands");
		$this->apppub_set->query("delete from forbidden_commands_groups");
		$this->apppub_set->query("delete from restrictacl");
		$this->apppub_set->query("delete from restrictpolicy");
		$this->apppub_set->query("delete from passwordkey");
		$this->apppub_set->query("delete from loadbalance");
		$this->apppub_set->query("delete from backup_setting");
		$this->apppub_set->query("delete from vpn_log");
		$this->apppub_set->query("delete from luser_resourcegrp");
		$this->apppub_set->query("delete from lgroup_resourcegrp");
		$this->apppub_set->query("delete from lgroup_devgrp");
		$this->apppub_set->query("delete from luser_devgrp");
		$this->apppub_set->query("delete from crontab_report_file");
		$this->apppub_set->query("delete from aduser_log");
		$this->apppub_set->query("delete from mail_sender");
		$this->apppub_set->query("delete from app_navicat_sql_log");
		$this->apppub_set->query("delete from app_plsqlhistory_log");
  



		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function correctdata(){
		$this->apppub_set->query("create table if not exists t(id int(11) )");
		//整理系统用户组
		$this->apppub_set->query("delete from resourcegroup where groupname is null or groupname=''");
		$this->apppub_set->query("truncate t");
		$this->apppub_set->query("insert into t select id from resourcegroup where groupname not in(select groupname from resourcegroup where groupname in(select groupname from resourcegroup group by groupname) and devicesid=0)");
		$this->apppub_set->query("delete from resourcegroup where id in(select id from t)");
		//整理权限表
		$this->apppub_set->query("delete from luser_resourcegrp where resourceid not in(select id from resourcegroup where devicesid=0)");
		$this->apppub_set->query("delete from lgroup_resourcegrp where resourceid not in(select id from resourcegroup where devicesid=0)");
		$this->apppub_set->query("insert into t select min(id) from lgroup_resourcegrp group by groupid,resourceid");
		$this->apppub_set->query("delete from lgroup_resourcegrp where id not in(select id from t)");
		$this->apppub_set->query("truncate t");
		$this->apppub_set->query("insert into t select min(id) from luser_resourcegrp group by memberid,resourceid");
		$this->apppub_set->query("delete from luser_resourcegrp where id not in(select id from t)");
		$this->apppub_set->query("truncate t");
		$this->apppub_set->query("insert into t select min(id) from luser group by memberid,devicesid");
		$this->apppub_set->query("delete from luser where id not in(select id from t)");
		$this->apppub_set->query("truncate t");
		$this->apppub_set->query("insert into t select min(id) from lgroup group by groupid,devicesid");
		$this->apppub_set->query("delete from lgroup where id not in(select id from t)");
		//整理资源组
		$this->apppub_set->query("update servergroup set ldapid=0 where id=ldapid");
		$this->apppub_set->query("truncate t");
		$this->apppub_set->query("insert into t select id from servergroup where locate(concat(',',ldapid,','), child) or right(child,LENGTH(ldapid)+1)=concat(',',ldapid) or left(child,LENGTH(ldapid)+1)=concat(ldapid,',')");
		$this->apppub_set->query("update servergroup set ldapid=0 where id in(select id from t)");
		$this->apppub_set->query("truncate t");
		$this->apppub_set->query("insert into t select b.id from servergroup a left join servergroup b ON a.ldapid=b.id where a.id=b.id");
		$this->apppub_set->query("update servergroup set ldapid=0 where id in(select id from t)");
		$this->apppub_set->query("truncate t");
		$this->apppub_set->query("insert into t select id from servergroup where ldapid not in(select id from servergroup)");
		$this->apppub_set->query("update servergroup set ldapid=0 where id in(select id from t)");
		$this->apppub_set->query("delete from member where username is null or username=''");
		$this->apppub_set->query("delete from servers where device_ip is null or device_ip=''");
		$this->apppub_set->query("update member set groupid=0 where groupid not in(select groupid from servergroup) and groupid >0");
		$this->apppub_set->query("update servers set groupid=0 where groupid not in(select groupid from servergroup) and groupid >0");
		$this->apppub_set->query("drop table t");
		alert_and_back('整理完毕','admin.php?controller=admin_config&action=config_ftp');
	}

	function keyedit(){		
		$eth0 = explode(":", $_SERVER["HTTP_HOST"]);
		system("sudo /home/wuxiaolong/install/CAinstall.pl ".$eth0[0],$out);
		//system("sudo killall -9 httpd",$out);
		system('sudo /opt/freesvr/nginx/sbin/nginx  -s reload -c /opt/freesvr/nginx/conf/nginx.conf');
		alert_and_back('操作成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function logintype(){
		$radiusauth = get_request('radiusauth', 1, 0);
		$adauth = get_request('adauth', 1, 0);
		$ldapauth = get_request('ldapauth', 1, 0);
		$fingersecauth = get_request('fingersecauth', 1, 0);
		$localfingersecauth = get_request('localfingersecauth', 1, 0);
		$this->apppub_set->query("UPDATE setting SET svalue='".serialize(array('radiusauth'=>$radiusauth,'ldapauth'=>$ldapauth,'adauth'=>$adauth,'fingersecauth'=>$fingersecauth,'localfingersecauth'=>$localfingersecauth))."' WHERE sname='logintype'");
		system('sudo /etc/init.d/httpd graceful');
		alert_and_back('修改完成','admin.php?controller=admin_config&action=config_ftp');
	}
	
	function config_sftp()
	{
		//$filename = './controller/global.cfg';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SFTP'];
		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "SftpBackupSize"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['sftpbackupsize'] = trim($tmp[1]);
				}
			}
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->assign("sshconfig", $network);
		$this->display('config_sftp.tpl');
	}

	function sftp_save()
	{
		//$filename = './controller/global.cfg';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SFTP'];
		
		$sftpbackupsize = get_request('sftpbackupsize',1,1);
		
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "SftpBackupSize"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					//$lines[$ii] = str_replace($tmp[1], $sftpbackupsize, $lines[$ii]);
					$lines[$ii] = $tmp[0].' '.$sftpbackupsize."\n";
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->Array2File($lines,$filename);
		system('sudo /opt/freesvr/audit/sbin/manageprocess ssh-audit stop');
		system('sudo /opt/freesvr/audit/sbin/manageprocess ssh-audit start');
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}
	
	function config_telnet()
	{
		//$filename = './controller/global.cfg';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['TELNET'];
		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "run-radius"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$network['runradius'] = trim($tmp[1]);
				}
				if(strstr(strtolower($lines[$ii]), "global-server"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$network['globalserver'] = trim($tmp[1]);
				}
				if(strstr(strtolower($lines[$ii]), "backup-server"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$network['backupserver'] = trim($tmp[1]);
				}
			}
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->assign("sshconfig", $network);
		$this->display('config_telnet.tpl');
	}

	function telnet_save()
	{
		//$filename = './controller/global.cfg';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['TELNET'];
		
		$new_switch = get_request('switch',1,1);
		$new_ipaddr = get_request('ipaddr',1,1);
		$new_ipaddr_slave = get_request('ipaddr_slave',1,1);
		
		
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "run-radius"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$lines[$ii] = $tmp[0].'='.$new_switch."\n";
				}
				if(strstr(strtolower($lines[$ii]), "global-server"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$lines[$ii] = $tmp[0].'='.$new_ipaddr."\n";
				}
				if(strstr(strtolower($lines[$ii]), "backup-server"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$lines[$ii] = $tmp[0].'='.$new_ipaddr_slave."\n";
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->Array2File($lines,$filename);
		//system('sudo /opt/freesvr/audit/sbin/manageprocess tcpproxy restart ',$out);
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_telnet');
	}
	
	function config_rdp()
	{
		//$filename = './controller/global.cfg';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['RDP'];
		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "run-radius"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$network['runradius'] = trim($tmp[1]);
				}
				if(strstr(strtolower($lines[$ii]), "global-server"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$network['globalserver'] = trim($tmp[1]);
				}
				if(strstr(strtolower($lines[$ii]), "backup-server"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$network['backupserver'] = trim($tmp[1]);
				}
			}
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->assign("sshconfig", $network);
		$this->display('config_rdp.tpl');
	}

	function rdp_save()
	{
		//$filename = './controller/global.cfg';
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['RDP'];
		
		$new_switch = get_request('switch',1,1);
		$new_ipaddr = get_request('ipaddr',1,1);
		$new_ipaddr_slave = get_request('ipaddr_slave',1,1);
		
		$lines = @file($filename);
		if(!empty($lines))
		{
		
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "run-radius"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$lines[$ii] = $tmp[0].'='.$new_switch."\n";
				}
				if(strstr(strtolower($lines[$ii]), "global-server"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$lines[$ii] = $tmp[0].'='.$new_ipaddr."\n";
				}
				if(strstr(strtolower($lines[$ii]), "backup-server"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$lines[$ii] = $tmp[0].'='.$new_ipaddr_slave."\n";
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
		}
		$this->Array2File($lines,$filename);
		system('sudo /opt/freesvr/audit/sbin/manageprocess Freesvr_RDP stop ',$out);
		system('sudo /opt/freesvr/audit/sbin/manageprocess Freesvr_RDP start ',$out);
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_rdp');
	}
	
	function show_radius() {
		//$filename = '/opt/vpn/etc/rad.conf';
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
		$this->assign('addr',$R_addr);
		$this->assign('key',$R_key);
		$this->display('show_radius.tpl');
	}

	function radius_save() {
		$new_addr = get_request('addr',1,1);
		$new_key = get_request('key',1,1);
		if(!is_ip($new_addr)){
			alert_and_back('请输入正确的IP或掩码地址格式');
			exit;
		}
		global $_CONFIG;
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
		
		alert_and_back('修改成功','admin.php?controller=admin_config&action=show_radius');
	}	


	
	function adusers_check(){
		$_SESSION['ADUSERS_OU']=null;
		$_SESSION['ADUSERS_USERS']=null;
		$_SESSION['ADUSERS_PWD']=null;
		$_SESSION['ADUSERS_OU'] = array();

		$domain = $_SESSION['AD_domain'];
		$address = $_SESSION['AD_address'];
		$adusername = $_SESSION['AD_adusername'];
		$adpassword = $_SESSION['AD_adpassword'];
		$groupname = get_request('groupname', 0, 1);
		$ouname = get_request('ouname', 0, 1);
		$dn = get_request('dn', 0, 1);
		$pid = get_request('pid', 0, 1);
		
		$groupname = unescape($groupname);//
		$ouname = unescape($ouname);
		$dn = unescape($dn);
		//var_dump($groupname);
		//var_dump($ouname);
		//var_dump($dn);
		include (ROOT . "/include/adLDAP/adLDAP.php");
		try {
			$options['account_suffix'] = '@'.$domain;
			$options['domain_controllers'] = array($address);				
			$_domain = explode('.', $domain);
			$sdomain = '';			
			for($i=0; $i<count($_domain); $i++){
				$sdomain .= "dc=".$_domain[$i].',';
			}
			$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
			$options['base_dn'] = $sdomain;

			$adldap = new adLDAP($options);
		}
		catch (adLDAPException $e) {
			alert_and_back('连接失败');
			exit();   
		}
		$result = $adldap->authenticate($adusername, $adpassword);
		if(!$result){
			echo('账号或密码错误');
		}
		
		$password = $_POST['password'];
		$confirm_password = $password;	
		if(!empty($password)){			
			$config = $this->setting_set->select_all(" sname='password_policy'");
			$pwdconfig = unserialize($config[0]['svalue']);
			$reg = '';			
			$pwdmsg = '';
			$pwdmsgl = null;
			$pwdmsg2 = null;
			$pwdmsgn = null;
			if($pwdconfig['repeatnumber']>0){
				$pwdrepeatc = array();
				for($ci=0; $ci<strlen($password); $ci++){
					if(empty($pwdrepeatc[$password[$ci]])) 
						$pwdrepeatc[$password[$ci]]=1;
					elseif($pwdrepeatc[$password[$ci]]>=$pwdconfig['repeatnumber']){
						$pwdmsg3 .= '密码中重复字符数不能超过'.$pwdconfig['repeatnumber']."\\n";
						break;
					}else{
						$pwdrepeatc[$password[$ci]]++;
					}
				}
			}
			if(intval($pwdconfig['pwdstrong1'])>preg_match_all('/[0-9]/', $password1, $matches)){
				//alert_and_back('密码中需要包含数字');
				//exit;
				$pwdmsg .= '数字'." ";
			}
			if(intval($pwdconfig['pwdstrong2'])>preg_match_all('/[a-z]/', $password1, $matches)){
				//alert_and_back('密码中需要包含小写字母');
				//exit;
				$pwdmsg .= '小写字母'." ";
			}
			if(intval($pwdconfig['pwdstrong3'])>preg_match_all('/[A-Z]/', $password1, $matches)){
				//alert_and_back('密码中需要包含小写字母');
				//exit;
				$pwdmsg .= '大写字母'." ";
			}
			$pwd_replace = preg_replace('/[0-9a-zA-Z]/','', $password1);
			if(intval($pwdconfig['pwdstrong4'])>strlen($pwd_replace)){
				//alert_and_back('密码中需要包含特殊字符');
				//exit;
				$pwdmsg .= '特殊字符'." ";
			}
			
			if(strlen($password) < $pwdconfig['login_pwd_length']){
				$pwdmsgl = language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 '.',';
			}

			
			$pwd_ban_word_arr = explode('1', str_replace(' ', '空格', $_CONFIG['PASSWORD_BAN_WORD']));			
			if($pwd_ban_word_arr){
				$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
			}			
			if(!empty($pwd_ban_word_arr[0]))
			for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
				if(strpos($password1, $pwd_ban_word_arr[$pi])!==false){
					$pwdmsg2='密码中不能包含以下字符:'.addslashes($pwd_ban_word_str).'';
					break;
				}
			}
			$pwdmsgs=null;
			if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2) || !empty($pwdmsg3)){
				$pwdmsgs .= $pwdmsg3;
				if($pwdconfig['pwdstrong1'] || $pwdconfig['pwdstrong2'] || $pwdconfig['pwdstrong3'] || $pwdconfig['pwdstrong4']){
					$pwdmsgs .= '密码中需要包含:' .  ($pwdconfig['pwdstrong1'] ? $pwdconfig['pwdstrong1'].'个数字' : '').($pwdconfig['pwdstrong2'] ? $pwdconfig['pwdstrong2'].'个小写字母' : '').($pwdconfig['pwdstrong3'] ? $pwdconfig['pwdstrong3'].'个大写字母' : '').($pwdconfig['pwdstrong4'] ? $pwdconfig['pwdstrong4'].'个特殊字符' : ''). "\\n";
				}
				$pwdmsgs .= language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 ';
				if(count($pwd_ban_word_str)>0){
					$pwdmsgs .= '密码中不能包含以下字符:'.addslashes($pwd_ban_word_str);
				}
				$error[]=$username.':'.$pwdmsgs.'\n';
				//alert_and_back($pwdmsgs);
				//exit;
			}
		}else{
			$error[]=$username.':'.'没有输入密码'.'\n';
			continue;
		}
		
		$_SESSION['ADUSERS_PWD']=$password;

		for($i=0; $i<count($_POST['username']); $i++){
			$newmember = new member();
			$username = $_POST['username'][$i];
			$level = 0;
			if(empty($username)){
				continue;
			}
					
			$mobilenum = $_POST['mobilenum'][$i];
			$company = $_POST['company'][$i];
			$workcompany = $_POST['workcompany'][$i];
			$workdepartment = $_POST['workdepartment'][$i];
			$email = $_POST['email'][$i];
			$realname = $_POST['username'][$i];
			$vpn = $_POST['vpn'][$i];
			$vpnip = $_POST['vpnip'][$i];
			$usbkey = $_POST['usbkey'][$i];
			if(preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $level)||preg_match("/[\\r\\n]/", $password)||preg_match("/[\\r\\n]/", $confirm_password)||preg_match("/[\\r\\n]/", $mobilenum)||preg_match("/[\\r\\n]/", $company)||preg_match("/[\\r\\n]/", $email)||preg_match("/[\\r\\n]/", $realname)||preg_match("/[\\r\\n]/", $vpn)||preg_match("/[\\r\\n]/", $vpnip)||preg_match("/[\\r\\n]/", $usbkey)){
				$error[]=$username.':'.'用户信息中含有回车符'.'\n';
				continue;
			}
			$vpnipexist = $this->member_set->select_all("vpnip='".$vpnip."' and username!='$username'");
			if($network['server1']==$vpnip&&count($vpnipexist)==0){
				$vpnip = $vpnip;
			}else{
				$vnpip = $oldmember['vpnip'];
			}

			if(!preg_match('/^[a-zA-Z_]+[a-zA-Z._\-0-9@]*$/', $username)){
				$error[]=$username.':'.'用户名以字母和下划线开头包含大小写字母、数字、下划线、小数点'.'\n';
				continue;
			}
			
			$dn=$adldap->user()->dn($username);
			$_pos = strpos($dn,"OU=")+3;
			$_ou = substr($dn,$_pos,strpos($dn,",",$_pos)-$_pos);//var_dump($_ou);
			if(!in_array($_ou,$_SESSION['ADUSERS_OU'])){
				$_SESSION['ADUSERS_OU'][]=$_ou;
			}
			$_SESSION['ADUSERS_USERS'][]=$username;
			//if(!in_array($ous, )){
			//}
		}
		if($error)
		echo "<script>alert(\"".'不符合规则用户:\n'.(is_array($error) ? implode('\n',$error) : '').'\n'."\")</script>";
	}

	function adusers(){
		global $_CONFIG;
		$id = get_request('id');
		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$pwdconfig = unserialize($setting[0]['svalue']);
		//$this->assign("ldaps", $pwdconfig['ldapconfig']);
		if(is_numeric($_GET['id'])&&$id>=0&&is_array($pwdconfig['adconfig'][$id])){
			unset($_SESSION['AD_address']);
			unset($_SESSION['AD_domain']);
			unset($_SESSION['AD_adusername']);
			unset($_SESSION['AD_adpassword']);
			unset($_SESSION['AD_dn']);
		}

		if($_POST['address']||($_SESSION['AD_address']&&$_SESSION['AD_domain']&&$_SESSION['AD_adusername']&&$_SESSION['AD_adpassword'])){
			if($_POST['address']){
				$_SESSION['AD_address']=$_POST['address'];
				$_SESSION['AD_domain']=$_POST['domain'];
				$_SESSION['AD_adusername']=$_POST['adusername'];
				$_SESSION['AD_adpassword']=$_POST['adpassword'];
				$_SESSION['AD_dn']=$_POST['ou'];
			}
			include (ROOT . "/include/adLDAP/adLDAP.php");
			try {
				$options['account_suffix'] = '@'.$_SESSION['AD_domain'];
				$options['domain_controllers'] = array($_SESSION['AD_address']);
				$_domain = explode('.', $_SESSION['AD_domain']);
				$sdomain = '';
				for($i=0; $i<count($_domain); $i++){
					$sdomain .= "dc=".$_domain[$i].',';
				}
				$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
				$options['base_dn'] = $_SESSION['AD_dn'];

				$adldap = new adLDAP($options);
			}
			catch (adLDAPException $e) {
				$_SESSION['AD_address']=null;
				$_SESSION['AD_domain']=null;
				$_SESSION['AD_adusername']=null;
				$_SESSION['AD_adpassword']=null;
				alert_and_back('连接失败');
				exit();   
			}
			
			$result = $adldap->authenticate($_SESSION['AD_adusername'], $_SESSION['AD_adpassword']);
			if(!$result){
				$_SESSION['AD_address']=null;
				$_SESSION['AD_domain']=null;
				$_SESSION['AD_adusername']=null;
				$_SESSION['AD_adpassword']=null;
				alert_and_back('账号或密码错误');
				exit;
			}
			$ous = array();
			$cns = array();

			$allusers = array();

			$cname = substr($options['base_dn'],0,strpos($options['base_dn'],','));
			if(strtolower(substr($cname,0,strpos($cname, '=')))=='cn'){
				$cname = substr($cname,strpos($cname,'=')+1);
				$cnameinfo = $adldap->group()->info($cname);
				if($cnameinfo[0]['member']['count']){
					for($i=0; $i<$cnameinfo[0]['member']['count']; $i++){
						$username=substr($cnameinfo[0]['member'][$i],0,strpos($cnameinfo[0]['member'][$i],','));
						$username=substr($username,strpos($username,'=')+1);
						$allusers[]=array('username'=>$username,'dn'=>$options['base_dn'],'ingroup'=>1,'exists'=>($this->member_set->select_count("username='".$username."'")));
					}
				}
			}

			$r = $adldap->folder()->listing($options['base_dn'],adLDAP::ADLDAP_FOLDER,true,'folder');
			
			if($r['count']>0)
			for($i=0; $i<$r['count']; $i++){
				$distinguishedname = substr($r[$i]['distinguishedname'][0],strpos($r[$i]['distinguishedname'][0],',')+1);
				//
				//echo '<pre>';var_dump($r[$i]['samaccountname'][0]);echo '</pre>';
				if(strtolower($distinguishedname)==strtolower($options['base_dn'])){//echo '<pre>';var_dump($r[$i]);echo '</pre>';echo '------------------------------------------------';
					if($r[$i]['ou'][0]) $ous[] = array('name'=>$r[$i]['ou'][0],'usercount'=>0,'dn'=>$r[$i]['distinguishedname'][0]);
					else $cns[] = array('name'=>$r[$i]['cn'][0],'usercount'=>0,'dn'=>$r[$i]['distinguishedname'][0]);
				}
			}
			
			foreach($adldap->user()->all() as $val)
			{
				$_distinguishedname=$adldap->user()->dn($val);
				$_groupstmp = $adldap->user()->groups($val);
				$distinguishedname = substr($_distinguishedname,strpos($_distinguishedname,',')+1);
				if(strtolower($distinguishedname)==strtolower($options['base_dn'])){
					$allusers[]=array('username'=>$val,'dn'=>$_distinguishedname);
				}else if($cname&&in_array($cname, $_groupstmp)){
					$allusers[]=array('username'=>$val,'dn'=>$options['base_dn'],'ingroup'=>1);
				}
				for($j=0; $j<count($ous); $j++){
					if(strstr($distinguishedname, $ous[$j]['dn'])){
						$ous[$j]['usercount']++;
					}
				}
				for($j=0; $j<count($cns); $j++){
					if(strstr($distinguishedname, $cns[$j]['dn'])||in_array($cns[$j]['name'],$_groupstmp)){
						$cns[$j]['usercount']++;
					}
				}
			}
			for($i=0; $i<count($allusers); $i++){
				if(!in_array($allusers[$i], $_CONFIG['AD_USERS'])){
					$_allusers[]=$allusers[$i];
				}
			}
			if($_allusers)
			$allusers = $_allusers;
			$_allusers = null;

			$groupusers = array();
			$groups = array();
			//echo '<pre>';var_dump($adldap->group()->all());echo '</pre>';echo 'netmwd';
//	echo '<pre>';var_dump($adldap->group()->members('ceshi3g'));echo '</pre>';
			foreach($adldap->group()->all() as $val)
			{	
				$groupinfo=$adldap->group()->info($val);
				$distinguishedname = substr($groupinfo[0]['distinguishedname'][0],strpos($groupinfo[0]['distinguishedname'][0],',')+1);
				if(strtolower($distinguishedname)==strtolower($options['base_dn'])){				
					$users = $adldap->group()->members($val);//var_dump($users);
					$_users = array();
					for($i=0; $i<count($users); $i++){
						if(in_array($users[$i], $allusers)){							
							$_users[]=array('username'=>$users[$i]);
						}
					}//var_dump($_users);
					if(count($_users)>0){
						sort($_users);
						$groups[] = array('groupname'=>$val, 'users'=>$_users, 'usercount'=>count($_users)+$groupinfo[0]['member']['count']);
						//$groupusers = array_merge($groupusers, $_users);
					}
					$users = null;
				}
			}
			$nogroupusers = array();
			for($i=0; $i<count($allusers); $i++){
				if(!in_array($allusers[$i]['username'], $groupusers)){
					$allusers[$i]['exists']=$this->member_set->select_count("username='".$allusers[$i]['username']."'");
					$nogroupusers[]=$allusers[$i];
				}
			}
			sort($nogroupusers);
			
			/*
			$groups = array();
			for($i=0; $i<300; $i++){
				$groups[] = array('groupname'=>'组'.$i, 'users'=>array(), 'usercount'=>50);
			}
			$nogroupusers = array();
			for($i=0; $i<500; $i++){
				$nogroupusers[] = 'user_'.$i;
			}
			*/
			//echo '<pre>';var_dump($groups);echo '</pre>';
			//echo '<pre>';var_dump($nogroupusers);echo '</pre>';
			
/*
			$server = $_POST['address'];
			$domain = $_POST['domain'];
			$username = $_POST['adusername'];
			$password = $_POST['adpassword'];

			$conn = ldap_connect($server);
			if($conn){
				//设置参数
				ldap_set_option ( $conn, LDAP_OPT_PROTOCOL_VERSION, 3 );
				ldap_set_option ( $conn, LDAP_OPT_REFERRALS, 0 ); // Binding to ldap server
				//echo $user.'/'.$pswd;
				$bd = @ldap_bind($conn, $username.'@'.$domain, $password);
				if($bd){
					 //指定需要获取的用户属性
					$dcs = explode('.', $domain);
					$basedn = "CN=Users";
					for($i=0; $i<count($dcs); $i++){
						$basedn .= ",DC=".$dcs[$i];
					}
					//指定需要获取的用户属性 
					$attrs = array("displayname","cn"); 
					//指定需查询的用户范围 
					$filter = "(objectclass=*)"; 
					$sr = ldap_search($conn, $basedn, $filter, $attrs,0,0,0) or die (ldap_error($conn)); 
					//var_dump($sr);
					$info = ldap_get_entries($conn, $sr);
					for($i=0; $i<count($info); $i++){
						if(!empty($info[$i]['cn'][0])&&!in_array($info[$i]['cn'][0], $_CONFIG['AD_USERS'])){
							$member[]=array('username'=>$info[$i]['cn'][0]);
							$_member[]=$info[$i]['cn'][0];
						}
					}
				}else{
					alert_and_back('账号或密码错误');
				}
*/
			$this->assign("domain", $_POST['domain']);
			$this->assign("step", 1);
			$this->assign("ous", $ous);
			$this->assign("cns", $cns);
			$this->assign("groups", $groups);
			$this->assign("dn", $options['base_dn']);
			$this->assign("nogroupusers", $nogroupusers);
		}else{
			$_domain = explode('.', $pwdconfig['adconfig'][$id]['domain']);
			$sdomain = '';
			for($i=0; $i<count($_domain); $i++){
				$sdomain .= "dc=".$_domain[$i].',';
			}
			$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
			$pwdconfig['adconfig'][$id]['ou']=$sdomain;
		}
		if($cname){
			$this->assign("count", count($nogroupusers));
		}
		$this->assign("dn", $_SESSION['AD_dn']);
		require_once('./include/select_sgroup_ajax.inc.php');
		$this->display('adusers_tree.tpl');
	}

	function adusersbygroup(){
		global $_CONFIG;
		header("Content-Type:text/html;charset=UTF-8");
		$domain = $_SESSION['AD_domain'];
		$address = $_SESSION['AD_address'];
		$adusername = $_SESSION['AD_adusername'];
		$adpassword = $_SESSION['AD_adpassword'];
		$groupname = get_request('groupname', 0, 1);
		$ouname = get_request('ouname', 0, 1);
		$cname = get_request('cname', 0, 1);
		$dn = get_request('dn', 0, 1);
		$pid = get_request('pid', 0, 1);
		
		$groupname = unescape($groupname);//
		$ouname = unescape($ouname);
		$dn = unescape($dn);
		//var_dump($groupname);
		//var_dump($ouname);
		//var_dump($dn);
		include (ROOT . "/include/adLDAP/adLDAP.php");
		try {
			$options['account_suffix'] = '@'.$domain;
			$options['domain_controllers'] = array($address);
			/*
			$_domain = explode('.', $domain);
			$sdomain = '';			
			for($i=0; $i<count($_domain); $i++){
				$sdomain .= "dc=".$_domain[$i].',';
			}
			$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
			$options['base_dn'] = $sdomain;
			*/
			$options['base_dn'] = $dn;
			if($cname) $options['base_dn'] = 'cn='.$cname.','.$options['base_dn'];
			else if($groupname) $options['base_dn'] = 'cn='.$groupname.','.$options['base_dn'];
			else $options['base_dn'] = 'ou='.$ouname.','.$options['base_dn'];

			$adldap = new adLDAP($options);
		}
		catch (adLDAPException $e) {
			alert_and_back('连接失败');
			exit();   
		}
		$result = $adldap->authenticate($adusername, $adpassword);
		if(!$result){
			echo('账号或密码错误');
		}
		if($groupname){
			$allusers = array();
			$cnameinfo = $adldap->group()->info($groupname);
			if($cnameinfo[0]['member']['count']){
				for($i=0; $i<$cnameinfo[0]['member']['count']; $i++){
					$username=substr($cnameinfo[0]['member'][$i],0,strpos($cnameinfo[0]['member'][$i],','));
					$username=substr($username,strpos($username,'=')+1);
					$allusers[]=array('username'=>$username.'|'.$options['base_dn'],'dn'=>$options['base_dn'],'ingroup'=>1,'exists'=>($this->member_set->select_count("username='".$username."'")));
				}
			}
			$alluserstmp = $adldap->group()->members($groupname);//var_dump($alluserstmp);
			if($alluserstmp)
			foreach( $alluserstmp as $val1)
			{
				$allusers[]=array('username'=>$val1.'|'.$options['base_dn'],'dn'=>$options['base_dn'],'ingroup'=>1,'exists'=>($this->member_set->select_count("username='".$val1."'")));
			}
			for($i=0; $i<count($allusers); $i++){
				if(!in_array($allusers[$i], $_CONFIG['AD_USERS'])){
					$_allusers[]=$allusers[$i];
				}
			}
			if($_allusers)
			$allusers = $_allusers;
			$_allusers = null;
			sort($allusers);
			echo json_encode(array('dn'=>$options['base_dn'],'pid'=>$pid,'cns'=>array(),'ous'=>array(),'groups'=>array(),'users'=>$allusers));
			/*
			for($i=0; $i<count($allusers); $i++){
				echo $allusers[$i].","."0\r\n";
			}*/
		}else{

			
			$ous = array();
			$cns = array();
			$r = $adldap->folder()->listing($options['base_dn'],adLDAP::ADLDAP_FOLDER,true,'folder');
			if($r['count']>0)
			for($i=0; $i<$r['count']; $i++){
				$distinguishedname = substr($r[$i]['distinguishedname'][0],strpos($r[$i]['distinguishedname'][0],',')+1);
				if($r[$i]['objectclass'][1]!='person'&&strtolower($distinguishedname)==strtolower($options['base_dn'])){//echo '<pre>';var_dump($r[$i]);echo '</pre>';echo '----------------------------------------------';
					//$ous[] = $r[$i]['ou'][0];
					if($r[$i]['ou'][0]) $ous[] = array('name'=>$r[$i]['ou'][0],'usercount'=>0,'dn'=>$r[$i]['distinguishedname'][0]);
					else $cns[] = array('name'=>$r[$i]['cn'][0],'usercount'=>0,'dn'=>$r[$i]['distinguishedname'][0]);
				}
			}

			$allusers = array();
			foreach($adldap->user()->all() as $val)
			{
				$_distinguishedname=$adldap->user()->dn($val);
				$distinguishedname = substr($_distinguishedname,strpos($_distinguishedname,',')+1);
				if(strtolower($distinguishedname)==strtolower($options['base_dn'])){
					$allusers[]=array('username'=>$val,'dn'=>$adldap->user()->dn($val));
				}else if($cname&&in_array($cname,$adldap->user()->groups($val))){
					$allusers[]=array('username'=>$val.'|'.$options['base_dn'],'dn'=>$options['base_dn'],'ingroup'=>1);
				}
				for($j=0; $j<count($ous); $j++){
					//var_dump($distinguishedname);var_dump($ous[$j]['dn']);var_dump(strstr($distinguishedname, $ous[$j]['dn']));
					if(strstr($distinguishedname, $ous[$j]['dn'])){
						$ous[$j]['usercount']++;
					}
				}
				for($j=0; $j<count($cns); $j++){
					if(strstr($distinguishedname, $cns[$j]['dn'])||in_array($cns[$j]['name'],$adldap->user()->groups($val))){
						$cns[$j]['usercount']++;
					}
				}
			}
		
			for($i=0; $i<count($allusers); $i++){
				if(!in_array($allusers[$i], $_CONFIG['AD_USERS'])){
					$_allusers[]=$allusers[$i];
				}
			}
			if($_allusers)
			$allusers = $_allusers;
			$_allusers = null;

			$groupusers = array();
			$groups = array();
		//echo '<pre>';var_dump($adldap->group()->all());echo '</pre>';echo 'netmwd';
			//	echo '<pre>';var_dump($adldap->group()->members('ceshi3g'));echo '</pre>';
			foreach($adldap->group()->all() as $val)
			{
				//echo '<pre>';var_dump($adldap->group()->info($val));echo '</pre>';echo 'netmwd';		
				$groupinfo=$adldap->group()->info($val);
				$distinguishedname = substr($groupinfo[0]['distinguishedname'][0],strpos($groupinfo[0]['distinguishedname'][0],',')+1);
				//var_dump($val);var_dump($distinguishedname);echo '<br>';
				if(strtolower($distinguishedname)==strtolower($options['base_dn'])){
					
					if(!in_array($val, $cns)){
						$users = $adldap->group()->members($val);//var_dump($users);
						$_users = array();
						for($i=0; $i<count($users); $i++){
							if(in_array($users[$i], $allusers)){		
								$_users[]=array('username'=>$users[$i]);
							}
						}//var_dump($_users);
						if(count($_users)>0||$groupinfo[0]['member']['count']){
							sort($_users);
							$groups[] = array('groupname'=>$val,'usercount'=>count($_users)+$groupinfo[0]['member']['count']);
							//$groupusers = array_merge($groupusers, $_users);
						}
					}
					$users = null;
				}
			}
			$nogroupusers = array();
			for($i=0; $i<count($allusers); $i++){
				if(!in_array($allusers[$i]['username'], $groupusers)){
					$allusers[$i]['exists']=$this->member_set->select_count("username='".$allusers[$i]['username']."'");
					$nogroupusers[]=$allusers[$i];
				}
			}
			sort($nogroupusers);
			echo json_encode(array('dn'=>$options['base_dn'],'pid'=>$pid,'ous'=>$ous,'cns'=>$cns,'groups'=>$groups,'users'=>$nogroupusers));
		}
		
		/*for($i=0; $i<1000; $i++){
			echo "user_".$i.","."0\r\n";
		}*/
	}



	function adusers_save(){
		global $_CONFIG;
		$domain = $_SESSION['AD_domain'];
		$address = $_SESSION['AD_address'];
		$adusername = $_SESSION['AD_adusername'];
		$adpassword = $_SESSION['AD_adpassword'];
		$adauth = $_POST['adauth'];
		$radiusauth = $_POST['radiusauth'];
		include (ROOT . "/include/adLDAP/adLDAP.php");
		try {
			$options['account_suffix'] = '@'.$domain;
			$options['domain_controllers'] = array($address);				
			$_domain = explode('.', $domain);
			$sdomain = '';			
			for($i=0; $i<count($_domain); $i++){
				$sdomain .= "dc=".$_domain[$i].',';
			}
			$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
			$options['base_dn'] = $sdomain;

			$adldap = new adLDAP($options);
		}
		catch (adLDAPException $e) {
			alert_and_back('连接失败');
			exit();   
		}
		$result = $adldap->authenticate($adusername, $adpassword);
		if(!$result){
			echo('账号或密码错误');
		}

		for($i=0; $i<count($_POST['username']); $i++){			
			$newmember = new member();
			$username = $_POST['username'][$i];
			$level = 0;
			if(empty($username)){
				continue;
			}
			$ingroup=0;
			if(strpos($username,'|')){
				$u = explode('|', $username);
				$username = $u[0];
				$distinguishedname='cn='.$username.','.$u[1];
				$ingroup=1;
			}

			$password = $_POST['password'];
			$confirm_password = $password;			
			$mobilenum = $_POST['mobilenum'][$i];
			$company = $_POST['company'][$i];
			$workcompany = $_POST['workcompany'][$i];
			$workdepartment = $_POST['workdepartment'][$i];
			$email = $_POST['email'][$i];
			$realname = $_POST['username'][$i];
			$vpn = $_POST['vpn'][$i];
			$vpnip = $_POST['vpnip'][$i];
			$usbkey = $_POST['usbkey'][$i];
			if(preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $level)||preg_match("/[\\r\\n]/", $password)||preg_match("/[\\r\\n]/", $confirm_password)||preg_match("/[\\r\\n]/", $mobilenum)||preg_match("/[\\r\\n]/", $company)||preg_match("/[\\r\\n]/", $email)||preg_match("/[\\r\\n]/", $realname)||preg_match("/[\\r\\n]/", $vpn)||preg_match("/[\\r\\n]/", $vpnip)||preg_match("/[\\r\\n]/", $usbkey)){
				$error[]=$username.':'.'用户信息中含有回车符'.'\n';
				continue;
			}
			$vpnipexist = $this->member_set->select_all("vpnip='".$vpnip."' and username!='$username'");
			if($network['server1']==$vpnip&&count($vpnipexist)==0){
				$vpnip = $vpnip;
			}else{
				$vnpip = $oldmember['vpnip'];
			}

			$u=$adldap->user()->info($username);
			$newmember->set_data('realname', $u[0]['cn'][0] ? $u[0]['cn'][0]:$username);
			$newmember->set_data('workcompany', $u[0]['department'][0]);
			$newmember->set_data('netdisksize', $netdisksize);
			$newmember->set_data('allowchange',0);
			$newmember->set_data('default_control', $default_control);
			$newmember->set_data('start_time', date('Y-m-d H:i:s'));
			$newmember->set_data('end_time', '2037:1:1 0:0:0');
			$newmember->set_data('mobilenum', $mobilenum);
			$newmember->set_data('workdepartment', $workdepartment);
			$newmember->set_data('workcompany', $workcompany);
			$newmember->set_data('email', $email);
			$newmember->set_data('vpn', $vpn);
			$newmember->set_data('vpnip', $vpnip);
			$newmember->set_data('usbkey', $usbkey);
			$newmember->set_data('adauth', $adauth);
			$newmember->set_data('radiusauth', $radiusauth);
			$newmember->set_data('adou', $u[0]['dn']);

			if(!preg_match('/^[a-zA-Z_]+[a-zA-Z._\-0-9@]*$/', $username)){
				$error[]=$username.':'.'用户名以字母和下划线开头包含大小写字母、数字、下划线、小数点'.'\n';
				continue;
			}
			if(!empty($password)){			
				$config = $this->setting_set->select_all(" sname='password_policy'");
				$pwdconfig = unserialize($config[0]['svalue']);
				$reg = '';			
				$pwdmsg = '';
				$pwdmsgl = null;
				$pwdmsg2 = null;
				$pwdmsgn = null;
				if($pwdconfig['repeatnumber']>0){
					$pwdrepeatc = array();
					for($ci=0; $ci<strlen($password); $ci++){
						if(empty($pwdrepeatc[$password[$ci]])) 
							$pwdrepeatc[$password[$ci]]=1;
						elseif($pwdrepeatc[$password[$ci]]>=$pwdconfig['repeatnumber']){
							$pwdmsg3 .= '密码中重复字符数不能超过'.$pwdconfig['repeatnumber']."\\n";
							break;
						}else{
							$pwdrepeatc[$password[$ci]]++;
						}
					}
				}
				if(intval($pwdconfig['pwdstrong1'])>preg_match_all('/[0-9]/', $password, $matches)){
					//alert_and_back('密码中需要包含数字');
					//exit;
					$pwdmsg .= '数字'." ";
				}
				if(intval($pwdconfig['pwdstrong2'])>preg_match_all('/[a-z]/', $password, $matches)){
					//alert_and_back('密码中需要包含小写字母');
					//exit;
					$pwdmsg .= '小写字母'." ";
				}
				if(intval($pwdconfig['pwdstrong3'])>preg_match_all('/[A-Z]/', $password, $matches)){
					//alert_and_back('密码中需要包含小写字母');
					//exit;
					$pwdmsg .= '大写字母'." ";
				}
				$pwd_replace = preg_replace('/[0-9a-zA-Z]/','', $password);
				if(intval($pwdconfig['pwdstrong4'])>strlen($pwd_replace)){
					//alert_and_back('密码中需要包含特殊字符');
					//exit;
					$pwdmsg .= '特殊字符'." ";
				}
				
				if(strlen($password) < $pwdconfig['login_pwd_length']){
					$pwdmsgl = language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 '.',';
				}
				
				$pwd_ban_word_arr = explode('1', str_replace(' ', '空格', $_CONFIG['PASSWORD_BAN_WORD']));			
				if($pwd_ban_word_arr){
					$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
				}			
				if(!empty($pwd_ban_word_arr[0]))
				for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
					if(strpos($password1, $pwd_ban_word_arr[$pi])!==false){
						$pwdmsg2='密码中不能包含以下字符:'.addslashes($pwd_ban_word_str).'';
						break;
					}
				}
				$pwdmsgs=null;
				if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2) || !empty($pwdmsg3)){
					$pwdmsgs .= $pwdmsg3;
					if($pwdconfig['pwdstrong1'] || $pwdconfig['pwdstrong2'] || $pwdconfig['pwdstrong3'] || $pwdconfig['pwdstrong4']){
						$pwdmsgs .= '密码中需要包含:' .  ($pwdconfig['pwdstrong1'] ? $pwdconfig['pwdstrong1'].'个数字' : '').($pwdconfig['pwdstrong2'] ? $pwdconfig['pwdstrong2'].'个小写字母' : '').($pwdconfig['pwdstrong3'] ? $pwdconfig['pwdstrong3'].'个大写字母' : '').($pwdconfig['pwdstrong4'] ? $pwdconfig['pwdstrong4'].'个特殊字符' : ''). "\\n";
					}
					$pwdmsgs .= language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 ';
					if(count($pwd_ban_word_str)>0){
						$pwdmsgs .= '密码中不能包含以下字符:'.addslashes($pwd_ban_word_str);
					}
					$error[]=$username.':'.$pwdmsgs.'\n';
					//alert_and_back($pwdmsgs);
					//exit;
					continue;
				}
			}else{
				$error[]=$username.':'.'没有输入密码'.'\n';
				continue;
			}

			
			if($password == $confirm_password) {
				$newmember->set_data('password', $this->member_set->udf_encrypt($password));
			}
			else {
				//alert_and_back('两次输入的密码不一致');
				$error[]=$username.':两次输入的密码不一致\n';
				continue;
			}
			if($this->member_set->select_count("username='" . $username . "'")>0 ) {
				$error[]=$username.":该用户\'$realname\'已经存在".'\n';
				continue;
			}
			if($this->member_set->select_count("username!='" . $username . "' and realname = '" . $newmember->get_data('realname') . "' AND level!=11")>0 ) {
				$error[]=$username.":真实名\'$realname\'已经存在".'\n';
				continue;
			}
			$newmember->set_data('username', $username);
			
			$newmember->set_data('level', $level);
			
			
			/*只有普通用户才有Radius用户,系统用户和密码托管用户*/
			//if($newmember->get_data('level') == 0) {
			$new_radius = new radius();	
			$new_radius->set_data("UserName",$newmember->get_data('username'));
			$new_radius->set_data("Attribute",'Crypt-Password');
			$new_radius->set_data("email",$newmember->get_data('email'));
			
			$new_radius->set_data("Value",crypt($this->member_set->udf_decrypt($newmember->get_data('password')),"\$1\$qY9g/6K4"));
			//var_dump($this->member_set->udf_decrypt($newmember->get_data('password')));exit;
			
			if(($user=$this->member_set->select_all("username = '" . $newmember->get_data('username') . "'")) != NULL){
				//$error[]=$username.':帐户已经存在\n';
				$radiususer = $this->radius_set->select_all("UserName = '" . $newmember->get_data('username') . "'");
				$new_radius->set_data("id",$radiususer[0]['id']);
				$this->radius_set->edit($new_radius);
				$newmember->set_data('uid', $user[0]['uid']);
				$this->member_set->edit($newmember);
				$modified[]=$newmember->get_data('username');
				continue;
			}
			$this->radius_set->add($new_radius);

			$dbuser = $this->member_set->base_select("SELECT * FROM ".DBAUDIT_DBNAME.".member where username='".$newmember->get_data('username')."'");
			if(empty($dbuser)){
				if($db_priority>=0){
					$sql = "INSERT INTO ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',level='".$newmember->get_data('level')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."'";
					$this->member_set->query($sql);
					
				}
			}else{
				$sql = "UPDATE ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."',level='".$newmember->get_data('level')."' where uid = '".$dbuser[0]['uid']."'";
				$this->member_set->query($sql);
			}
			$loguser = $this->member_set->base_select("SELECT * FROM ".LOG_DBNAME.".log_user where username='".$newmember->get_data('username')."'");
			if(empty($loguser)){
				if($log_priority>=0){
					$sql = "INSERT INTO ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."'";
					$this->member_set->query($sql);
				}
			}else{
				$sql = "UPDATE ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."' WHERE  userid='".$loguser[0]['userid']."'";
				$this->member_set->query($sql);
			}
			if(empty($ingroup)){
				$distinguishedname=$adldap->user()->dn($newmember->get_data('username'));
			}
			$distinguishedname = explode(',', $distinguishedname);
			array_shift($distinguishedname);
			$distinguishedname = array_reverse($distinguishedname);
			$head_str = "";
			$p = 0;
			for($j=0; $j<count($distinguishedname); $j++){
				$head_array = explode('=', $distinguishedname[$j]);
				if(strtolower($head_array[0])=='dc'){
					$head_str=$head_array[1].".".$head_str;
					$p++;
					continue;
				}
				$distinguishedname[$j]=$head_array[1];
			}
			$distinguishedname[$p-1]=substr($head_str, 0, strlen($head_str)-1);
			for($j=0; $j<$p-1; $j++){
				array_shift($distinguishedname);
			}
			$groupparentid=0;//var_dump($distinguishedname);
			for($j=0; $j<count($distinguishedname); $j++){
				$_group = $distinguishedname[$j];
				$where = null;
				if(!empty($groupparentid)){
					$where .= " AND ldapid=".$groupparentid." ";
				}
				$__group = $this->sgroup_set->select_all("groupname='".$_group."'".$where);
				if(empty($__group)){
					$newsgroup = new sgroup();
					$newsgroup->set_data('groupname', $_group);
					$newsgroup->set_data('count', 0);
					$newsgroup->set_data('ldapid', $groupparentid);
					$newsgroup->set_data('child', '');
					$this->sgroup_set->add($newsgroup);
					$groupid = mysql_insert_id();
					$newsgroup = null;
					$newsgroup = new sgroup();
					$newsgroup->set_data('child', $groupid);
					$newsgroup->set_data('id', $id);
					$this->sgroup_set->edit($newsgroup);
				}
				$__group = $this->sgroup_set->select_all("groupname='".$_group."'".$where);
				$groupid=$groupparentid = $__group[0]['id'];
			}
			if($_POST['groupid']){
				$groupid=$_POST['groupid'];
			}
			$newmember->set_data("groupid", $groupid);
			
			if($_SESSION['ADMIN_LEVEL']==3){
				$newmember->set_data("level", 0);
				$newmember->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
			}

			$this->member_set->add($newmember);
			$added[]=$newmember->get_data('username');

			$passwordlog = new passwordlog();
			$passwordlog->set_data('uid', mysql_insert_id());
			$passwordlog->set_data('password', md5($password1));
			$passwordlog->set_data('time', time());
			$this->passwordlog_set->add($passwordlog);
			//记录日志
			$adminlog = new admin_log();
			$adminlog->set_data('luser', $newmember->get_data('username'));
			$adminlog->set_data('action', language('添加运维用户'));
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('type', 11);
			$this->admin_log_set->add($adminlog);			
		}

		if($added || $modified){
			if(empty($error)){
				$msg = '全部操作成功';
			}else{
				if($added){
					$msg = '成功添加用户:'.implode(',',$added).'\n';
				}
				if($modified){
					$msg .= '成功修改用户:'.implode(',',$modified).'\n';
				}
				if($error){
					$msg .= '\n添加失败的用户:\n'.implode('\n',$error).'\n';
				}
			}
			alert_and_back($msg);
		}else{
			if($error)
			alert_and_back('添加失败:\n'.(is_array($error) ? implode('\n',$error) : '').'\n');
		}
	}

	function adimportconfig(){
		global $_CONFIG;
		$id = get_request('id');		
		$adserverindex = get_request('adserverindex');		
		$configs = $this->adimportconfig_set->select_all("ldap=0", "title", "asc");
		$config = $configs[0];
		if($id){
			$config = $this->adimportconfig_set->select_by_id($id);
		}
		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$pwdconfig = unserialize($setting[0]['svalue']);
		$adservers = $pwdconfig['adconfig'];
		$this->assign("adservers", $adservers);
		$this->assign("configs", $configs);
		$this->assign("adconfig", $config);
		$this->assign("adserverindex", $adserverindex);
		$this->display("adimportconfig.tpl");
	}

	function adimportconfig_save(){
		global $_CONFIG;
		$id = get_request('id');	
		$title = get_request('title',1,1);
		$ip = get_request('ip',1,1);
		$adusername = get_request('adusername',1,1);
		$adpassword = get_request('adpassword',1,1);
		$readpassword = get_request('readpassword',1,1);
		$aduserpwd = get_request('aduserpwd',1,1);
		$readuserpwd = get_request('readuserpwd',1,1);
		$path = get_request('path',1,1);
		$filteruser = get_request('filteruser',1,1);
		$filterusergroup = get_request('filterusergroup',1,1);
		if(empty($title)){
			alert_and_back('请填写名称');
			exit;
		}
		if(empty($ip)){
			alert_and_back('请选择IP');
			exit;
		}
		if(empty($path)){
			alert_and_back('请选择路径');
			exit;
		}
		if(empty($adpassword)){
			alert_and_back('请输入AD密码');
			exit;
		}
		if($adpassword!=$readpassword){
			alert_and_back('两次输入的密码不一致');
			exit;
		}
		if(empty($aduserpwd)){
			alert_and_back('请输入AD用户密码');
			exit;
		}
		if($aduserpwd!=$readuserpwd){
			alert_and_back('两次输入的AD用户密码不一致');
			exit;
		}
		if(!empty($aduserpwd)){			
			$config = $this->setting_set->select_all(" sname='password_policy'");
			$pwdconfig = unserialize($config[0]['svalue']);
			$reg = '';			
			$pwdmsg = '';
			$pwdmsgl = null;
			$pwdmsg2 = null;
			$pwdmsgn = null;
			if($pwdconfig['repeatnumber']>0){
				$pwdrepeatc = array();
				for($ci=0; $ci<strlen($aduserpwd); $ci++){
					if(empty($pwdrepeatc[$aduserpwd[$ci]])) 
						$pwdrepeatc[$aduserpwd[$ci]]=1;
					elseif($pwdrepeatc[$aduserpwd[$ci]]>=$pwdconfig['repeatnumber']){
						$pwdmsg3 .= '密码中重复字符数不能超过'.$pwdconfig['repeatnumber']."\\n";
						break;
					}else{
						$pwdrepeatc[$aduserpwd[$ci]]++;
					}
				}
			}
			if(intval($pwdconfig['pwdstrong1'])>preg_match_all('/[0-9]/', $aduserpwd, $matches)){
				//alert_and_back('密码中需要包含数字');
				//exit;
				$pwdmsg .= '数字'." ";
			}
			if(intval($pwdconfig['pwdstrong2'])>preg_match_all('/[a-z]/', $aduserpwd, $matches)){
				//alert_and_back('密码中需要包含小写字母');
				//exit;
				$pwdmsg .= '小写字母'." ";
			}
			if(intval($pwdconfig['pwdstrong3'])>preg_match_all('/[A-Z]/', $aduserpwd, $matches)){
				//alert_and_back('密码中需要包含小写字母');
				//exit;
				$pwdmsg .= '大写字母'." ";
			}
			$pwd_replace = preg_replace('/[0-9a-zA-Z]/','', $aduserpwd);
			if(intval($pwdconfig['pwdstrong4'])>strlen($pwd_replace)){
				//alert_and_back('密码中需要包含特殊字符');
				//exit;
				$pwdmsg .= '特殊字符'." ";
			}
			
			if(strlen($aduserpwd) < $pwdconfig['login_pwd_length']){
				$pwdmsgl = language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 '.',';
			}

			
			$pwd_ban_word_arr = explode('1', str_replace(' ', '空格', $_CONFIG['PASSWORD_BAN_WORD']));			
			if($pwd_ban_word_arr){
				$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
			}			
			if(!empty($pwd_ban_word_arr[0]))
			for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
				if(strpos($aduserpwd, $pwd_ban_word_arr[$pi])!==false){
					$pwdmsg2='密码中不能包含以下字符:'.addslashes($pwd_ban_word_str).'';
					break;
				}
			}
			$pwdmsgs=null;
			if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2) || !empty($pwdmsg3)){
				$pwdmsgs .= $pwdmsg3;
				if($pwdconfig['pwdstrong1'] || $pwdconfig['pwdstrong2'] || $pwdconfig['pwdstrong3'] || $pwdconfig['pwdstrong4']){
					$pwdmsgs .= '密码中需要包含:' .  ($pwdconfig['pwdstrong1'] ? $pwdconfig['pwdstrong1'].'个数字' : '').($pwdconfig['pwdstrong2'] ? $pwdconfig['pwdstrong2'].'个小写字母' : '').($pwdconfig['pwdstrong3'] ? $pwdconfig['pwdstrong3'].'个大写字母' : '').($pwdconfig['pwdstrong4'] ? $pwdconfig['pwdstrong4'].'个特殊字符' : ''). "\\n";
				}
				$pwdmsgs .= language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 ';
				if(count($pwd_ban_word_str)>0){
					$pwdmsgs .= '密码中不能包含以下字符:'.addslashes($pwd_ban_word_str);
				}
				//$error[]=$username.':'.$pwdmsgs.'\n';
				alert_and_back($pwdmsgs);
				exit;
			}
		}

		$adimportconfig = new adimportconfig();
		$adimportconfig->set_data("title", $title);
		$adimportconfig->set_data("server", $ip);
		$adimportconfig->set_data("adusername", $adusername);
		$adimportconfig->set_data("adpassword", $adpassword);
		$adimportconfig->set_data("aduserpwd", $aduserpwd);
		$adimportconfig->set_data("path", $path);
		$adimportconfig->set_data("filteruser", $filteruser);
		$adimportconfig->set_data("filterusergroup", $filterusergroup);
		if($id){
			$adimportconfig->set_data("id", $id);
			$this->adimportconfig_set->edit($adimportconfig);
		}else{
			$this->adimportconfig_set->add($adimportconfig);
			$id = mysql_insert_id();
		}
		if(get_request('submit',1,1)=='同步'){
			$this->synchronization_ad_users($id);
		}
	    alert_and_back('操作成功','admin.php?controller=admin_config&action=adimportconfig&id='.$id);
	}

	function synchronization_ad_ou($ou){
	}

	function synchronization_ad_users($id=null){
		global $_CONFIG;
		if(empty($id)){
			$id = get_request('id');
		}
		$config = $this->adimportconfig_set->select_by_id($id);	
		if(empty($config)){			
			alert_and_back('没有相应的规则:'.$id);
			exit;
		}
		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$pwdconfig = unserialize($setting[0]['svalue']);
		$adservers = $pwdconfig['adconfig'];
		for($i=0; $i<count($adservers); $i++){
			if($adservers[$i]['address']==$config['server']){
				$adserver = $adservers[$i];
				break;
			}
		}
		if(empty($adserver)){
			alert_and_back('AD服务器信息丢失，请检查');
			exit;
		}
		$domain = $adserver['domain'];
		$address = $adserver['address'];
		include (ROOT . "/include/adLDAP/adLDAP.php");
		try {
			$options['account_suffix'] = '@'.$domain;
			$options['domain_controllers'] = array($address);				
			$_domain = explode('.', $domain);
			$sdomain = '';			
			for($i=0; $i<count($_domain); $i++){
				$sdomain .= "dc=".$_domain[$i].',';
			}
			$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
			$options['base_dn'] = $sdomain;

			$adldap = new adLDAP($options);
		}
		catch (adLDAPException $e) {
			alert_and_back('连接失败');
			exit();   
		}
		$result = $adldap->authenticate($config['adusername'], $config['adpassword']);
		if(!$result){
			echo('账号或密码错误');
			exit;
		}
		$allusers = array();
		$pathlen = strlen($config['path']);
		foreach($adldap->user()->all() as $val)
		{
			if($_CONFIG['DB_DEBUG']){
				var_dump($distinguishedname);
			}
			$distinguishedname=$adldap->user()->dn($val);//var_dump($distinguishedname);
			$distinguishedname = substr($distinguishedname,strpos($distinguishedname,',')+1);
			$dnlen = strlen($distinguishedname);
			if($dnlen>=$pathlen&&strtolower(substr($distinguishedname,$dnlen-$pathlen))==strtolower($config['path'])){
				$allusers[]=$val;
			}
		}
		if($_CONFIG['DB_DEBUG']){
			var_dump($allusers);
		}
		$addeltegroup = $this->sgroup_set->select_all("lower(groupname)='ad_delete'");
		$addeltegroupid = $addeltegroup[0]['id'];
		if(empty($addeltegroup)){
			$newsgroup = new sgroup();
			$newsgroup->set_data('groupname', strtoupper('ad_delete'));
			$newsgroup->set_data('count', 0);
			$newsgroup->set_data('ldapid', 0);
			$newsgroup->set_data('child', '');
			$this->sgroup_set->add($newsgroup);
			$addeltegroupid = mysql_insert_id();
			$newsgroup = null;
			$newsgroup = new sgroup();
			$newsgroup->set_data('child', $addeltegroupid);
			$newsgroup->set_data('id', $addeltegroupid);
			$this->sgroup_set->edit($newsgroup);
		}
		if($allusers){

			//$this->member_set->query("UPDATE ".$this->member_set->get_table_name()." SET enable=0 where username NOT IN('".implode("','", $allusers)."') AND (adou!='' or adou is not null) and level=0");		
			$disabledusers = $this->member_set->select_all("adou!='' and level=0 and enable=1 and username NOT IN('".implode("','", $allusers)."')");
			for($i=0; $i<count($disabledusers); $i++){
				$m = new member();
				$m->set_data('uid', $disabledusers[$i]['uid']);
				$m->set_data('enable', 0);
				$m->set_data('groupid', $addeltegroupid);
				$this->member_set->edit($m);
				//记录日志
				$adminlog = new admin_log();
				$adminlog->set_data('luser', $disabledusers[$i]['username']);
				$adminlog->set_data('action', language('禁用运维用户'));
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('type', 11);
				$this->admin_log_set->add($adminlog);

				$aduserlog = new aduser_log();
				$aduserlog->set_data('username', $disabledusers[$i]['username']);
				if(unserialize($disabledusers[$i]['adou']))
				$aduserlog->set_data('ad', '/'.implode('/', unserialize($disabledusers[$i]['adou'])));
				$aduserlog->set_data('ldap', 'ad_delete');
				$aduserlog->set_data('action', '删除');
				
				$aduserlog->set_data('configid', $config['id']);
				$aduserlog->set_data('configname', $config['title']);
				$aduserlog->set_data('ip', $config['server']);
				$this->aduser_log_set->add($aduserlog);
				$disabled[]=$disabledusers[$i]['username'];
			}
		}

		$password=$config['aduserpwd'];
		$confirm_password = $password;	
		$groupid = 0;
		for($i=0; $i<count($allusers); $i++){			
			$newmember = new member();
			$username = $allusers[$i];
			$level = 0;
			if(empty($username)){
				continue;
			}
			if(preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $level)||preg_match("/[\\r\\n]/", $password)||preg_match("/[\\r\\n]/", $confirm_password)||preg_match("/[\\r\\n]/", $mobilenum)||preg_match("/[\\r\\n]/", $company)||preg_match("/[\\r\\n]/", $email)||preg_match("/[\\r\\n]/", $realname)||preg_match("/[\\r\\n]/", $vpn)||preg_match("/[\\r\\n]/", $vpnip)||preg_match("/[\\r\\n]/", $usbkey)){
				$error[]=$username.':'.'用户信息中含有回车符'.'\n';
				continue;
			}
			$vpnipexist = $this->member_set->select_all("vpnip='".$vpnip."' and username!='$username'");
			if($network['server1']==$vpnip&&count($vpnipexist)==0){
				$vpnip = $vpnip;
			}else{
				$vnpip = $oldmember['vpnip'];
			}
			
			$newmember->set_data('allowchange',0);
			$newmember->set_data('start_time', date('Y-m-d H:i:s'));
			$newmember->set_data('end_time', '2037:1:1 0:0:0');
			$newmember->set_data('password', $this->member_set->udf_encrypt($password));
			$newmember->set_data('adauth', 1);
			$newmember->set_data('enable', 1);
			$newmember->set_data('groupid', 0);
			if(!preg_match('/^[a-zA-Z_]+[a-zA-Z._\-0-9@]*$/', $username)){
				$error[]=$username.':'.'用户名以字母和下划线开头包含大小写字母、数字、下划线、小数点'.'\n';
				continue;
			}
			$newmember->set_data('username', $username);
			$u=$adldap->user()->info($username);
			$newmember->set_data('realname', $u[0]['cn'][0]);
			$newmember->set_data('workcompany', $u[0]['department'][0]);
			$newmember->set_data('level', $level);
			if($_SESSION['ADMIN_LEVEL']==3){
				$newmember->set_data("level", 0);
				$newmember->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
			}
			/*只有普通用户才有Radius用户,系统用户和密码托管用户*/
			//if($newmember->get_data('level') == 0) {
			$new_radius = new radius();	
			$new_radius->set_data("UserName",$newmember->get_data('username'));
			$new_radius->set_data("Attribute",'Crypt-Password');
			$new_radius->set_data("email",$newmember->get_data('email'));
			
			$new_radius->set_data("Value",crypt($this->member_set->udf_decrypt($newmember->get_data('password')),"\$1\$qY9g/6K4"));
			//var_dump($this->member_set->udf_decrypt($newmember->get_data('password')));exit;
			$distinguishedname=$adldap->user()->dn($newmember->get_data('username'));//var_dump($distinguishedname);
			$distinguishedname = explode(',', $distinguishedname);
			array_shift($distinguishedname);
			$distinguishedname = array_reverse($distinguishedname);
			$head_str = "";
			$p = 0;
			for($j=0; $j<count($distinguishedname); $j++){
				$head_array = explode('=', $distinguishedname[$j]);
				if(strtolower($head_array[0])=='dc'){
					$head_str=$head_array[1].".".$head_str;
					$p++;
					continue;
				}
				$distinguishedname[$j]=$head_array[1];
			}
			$distinguishedname[$p-1]=substr($head_str, 0, strlen($head_str)-1);
			for($j=0; $j<$p-1; $j++){
				array_shift($distinguishedname);
			}
			$groupparentid=0;//var_dump($distinguishedname);
			for($j=0; $j<count($distinguishedname); $j++){
				$_group = $distinguishedname[$j];
				$where = null;
				if(!empty($groupparentid)){
					$where .= " AND ldapid=".$groupparentid." ";
				}
				$__group = $this->sgroup_set->select_all("groupname='".$_group."'".$where);
				if(empty($__group)){
					$newsgroup = new sgroup();
					$newsgroup->set_data('groupname', $_group);
					$newsgroup->set_data('count', 0);
					$newsgroup->set_data('ldapid', $groupparentid);
					$newsgroup->set_data('child', '');
					$this->sgroup_set->add($newsgroup);
					$groupid = mysql_insert_id();
					$newsgroup = null;
					$newsgroup = new sgroup();
					$newsgroup->set_data('child', $groupid);
					$newsgroup->set_data('id', $id);
					$this->sgroup_set->edit($newsgroup);
				}
				$__group = $this->sgroup_set->select_all("groupname='".$_group."'".$where);
				$groupid=$groupparentid = $__group[0]['id'];
			}
			$newmember->set_data("groupid", $groupid);
			//$_group = $distinguishedname[count($distinguishedname)-1];
			/*
			$__group = $this->sgroup_set->select_all("groupname='".$_group."'");
			if($__group){
				$newmember->set_data("groupid", $__group[0]['id']);
			}else{
				$newsgroup = new sgroup();
				$newsgroup->set_data('groupname', $_group);
				$newsgroup->set_data('count', 0);
				$newsgroup->set_data('child', '');
				$this->sgroup_set->add($newsgroup);
				$newmember->set_data("groupid", mysql_insert_id());
			}*/
			if($_SESSION['ADMIN_LEVEL']==3){
				$newmember->set_data("level", 0);
				$newmember->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
			}
			$distinguishedname = serialize($distinguishedname);
			$newmember->set_data('adou', $distinguishedname);
			
			if(($user=$this->member_set->select_all("username = '" . $newmember->get_data('username') . "' or realname= '" . $newmember->get_data('username') . "'")) != NULL){
				//$error[]=$username.':帐户已经存在\n';
				if($user[0]['adou']!=$newmember->get_data('adou')){					
					$newmember->set_data('adou', $user[0]['adou']);			
					//$newmember->set_data('groupid', $user[0]['groupid']);
					//记录日志
					$adminlog = new admin_log();
					$adminlog->set_data('luser', $user[0]['username']);
					$adminlog->set_data('action', language('AD用户添加出现OU不一致'));
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
					$this->admin_log_set->add($adminlog);
				}
				if($user[0]['groupid']!=$groupid){
					$agroup=$this->sgroup_set->select_by_id($user[0]['groupid']);
					$ogroup = $agroup['groupname'];
					while($agroup['ldapid']){
						$agroup=$this->sgroup_set->select_by_id($agroup['ldapid']);
						$ogroup = $agroup['groupname'].'/'.$ogroup;
					}
					$aduserlog = new aduser_log();
					$aduserlog->set_data('username', $user[0]['username']);
					$aduserlog->set_data('ad', implode('/', unserialize($distinguishedname)));
					$aduserlog->set_data('ldap', $ogroup);
					$aduserlog->set_data('action', '移动');
					$aduserlog->set_data('configid', $config['id']);
					$aduserlog->set_data('configname', $config['title']);
					$aduserlog->set_data('ip', $config['server']);
					$this->aduser_log_set->add($aduserlog);
				}
				$radiususer = $this->radius_set->select_all("UserName = '" . $newmember->get_data('username') . "'");
				$new_radius->set_data("id",$radiususer[0]['id']);
				$this->radius_set->edit($new_radius);
				$newmember->set_data('uid', $user[0]['uid']);
				$this->member_set->edit($newmember);
				$modified[]=$newmember->get_data('username');
				continue;
			}
			$this->radius_set->add($new_radius);

			$dbuser = $this->member_set->base_select("SELECT * FROM ".DBAUDIT_DBNAME.".member where username='".$newmember->get_data('username')."'");
			if(empty($dbuser)){
				if($db_priority>=0){
					$sql = "INSERT INTO ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',level='".$newmember->get_data('level')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."'";
					$this->member_set->query($sql);
					
				}
			}else{
				$sql = "UPDATE ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."',level='".$newmember->get_data('level')."' where uid = '".$dbuser[0]['uid']."'";
				$this->member_set->query($sql);
			}
			$loguser = $this->member_set->base_select("SELECT * FROM ".LOG_DBNAME.".log_user where username='".$newmember->get_data('username')."'");
			if(empty($loguser)){
				if($log_priority>=0){
					$sql = "INSERT INTO ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."'";
					$this->member_set->query($sql);
				}
			}else{
				$sql = "UPDATE ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."' WHERE  userid='".$loguser[0]['userid']."'";
				$this->member_set->query($sql);
			}
			
			$this->member_set->add($newmember);
			$added[]=$newmember->get_data('username');

			$passwordlog = new passwordlog();
			$passwordlog->set_data('uid', mysql_insert_id());
			$passwordlog->set_data('password', md5($password1));
			$passwordlog->set_data('time', time());
			$this->passwordlog_set->add($passwordlog);
			
			$aduserlog = new aduser_log();
			$aduserlog->set_data('username', $newmember->get_data('username'));
			$aduserlog->set_data('ad', implode('/', unserialize($distinguishedname)));
			$aduserlog->set_data('ldap', implode('/', unserialize($distinguishedname)));
			$aduserlog->set_data('action', '创建');		
			$aduserlog->set_data('configid', $config['id']);
			$aduserlog->set_data('configname', $config['title']);
			$aduserlog->set_data('ip', $config['server']);
			$this->aduser_log_set->add($aduserlog);
			//记录日志
			$adminlog = new admin_log();
			$adminlog->set_data('luser', $newmember->get_data('username'));
			$adminlog->set_data('action', language('添加运维用户'));
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('type', 11);
			$this->admin_log_set->add($adminlog);			
		}
		$this->sgroup_set->updatechild();
		echo '<script>window.opener.location="admin.php?controller=admin_index&action=menu&actions=member</script>';
		if($added || $modified || $disabled){
			if(empty($error)&&!($modified || $disabled)){
				$msg = '全部操作成功';
			}else{
				if($added){
					$msg = '成功添加用户:'.implode(',',$added).'\n';
				}
				if($modified){
					$msg .= '成功修改用户:'.implode(',',$modified).'\n';
				}
				if($disabled){
					$msg .= '成功禁用用户:'.implode(',',$disabled).'\n';
				}
				if($error){
					$msg .= '\n添加失败的用户:\n'.implode('\n',$error).'\n';
				}
			}
			alert_and_back($msg);
		}else{
			alert_and_back('添加失败:\n'.(is_array($error) ? implode('\n',$error) : '').'\n');
		}

	}
	
	
	
	
	
	
	/*
	
	
	function ldapusers(){
		global $_CONFIG;
		$id = get_request('id');
		
		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$pwdconfig = unserialize($setting[0]['svalue']);
		//$this->assign("ldaps", $pwdconfig['ldapconfig']);
		$this->assign("adconfig", $pwdconfig['ldapconfig'][$id]);

		if($_POST['address']){
			$addr_port = explode(':', $_POST['address']);
			$ldapconn = ldap_connect($addr_port[0], $addr_port[1]);			 
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

			if ($ldapconn) {

				$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
				$ldapbind = ldap_bind($ldapconn, $_POST['adusername'], $_POST['adpassword']);

				// verify binding
				if ($ldapbind) {
					$basedn = $_POST['ou'];
					$justthese = array("uid","cn","sn","dn","name","mail");
					$sr=ldap_search($ldapconn, $basedn, "(&(objectClass=person))",$justthese , 0, 0, 0);
					$info = ldap_get_entries($ldapconn, $sr);
					$nogroupusers = array();
					for($i=0; $i<$info['count']; $i++){
						$username=trim($info[$i]['uid'][0]);
						$realname=trim($info[$i]['cn'][0]);
						$_name = explode('(', $info[$i]['name'][0]);
						//$username = strtolower(trim(substr($info[$i]['mail'][0],0,strpos($info[$i]['mail'][0],'@'))));
						//var_dump($_name);
						//$realname = substr($_name[1], 0, strpos($_name[1], ")"));
						//var_dump($username);
						//var_dump($realname);
						if(!empty($username)){
							if($this->member_set->select_count("username='".trim($username)."'")==0){
								$nogroupusers[]=array('name'=>trim($realname), 'username'=>trim($username), 'dn'=>trim($info[$i]['dn']));
							}else{
								$nogroupusers[]=array('name'=>trim($realname), 'username'=>trim($username), 'dn'=>trim($info[$i]['dn']),'checked'=>1);							
							}
						}
					}
					//echo '<pre>';var_dump($info);echo '</pre>';

					sort($nogroupusers);//var_dump($nogroupusers);
					ldap_close($ldapconn);
				}else{
					alert_and_back('账号或密码错误');
					exit;
				}
			}else{
				alert_and_back('连接服务器失败');
				exit;
			}
			$this->assign('ct', count($nogroupusers));
			$this->assign("domain", $_POST['ou']);
			$this->assign("step", 1);
		}
		$this->assign("nogroupusers", $nogroupusers);
		$this->display('ldapusers_tree.tpl');
			
	}

	function ldapusers_save(){
		global $_CONFIG;
		
		for($i=0; $i<count($_POST['username']); $i++){			
			$newmember = new member();
			$level = 0;
			$u = explode('|', $_POST['username'][$i]);
			if(!empty($u[1])){
				$username = $u[0];
				$realname = $u[1];
				$dn = $u[2];
			}else{
				$username = $u[0];
				$realname = $username;
			}
			if(empty($username)){
				continue;
			}
			$password = $_POST['password'];
			$confirm_password = $password;			
			$mobilenum = $_POST['mobilenum'][$i];
			$company = $_POST['company'][$i];
			$workcompany = $_POST['workcompany'][$i];
			$workdepartment = $_POST['workdepartment'][$i];
			$email = $_POST['email'][$i];
			$vpn = $_POST['vpn'][$i];
			$vpnip = $_POST['vpnip'][$i];
			$usbkey = $_POST['usbkey'][$i];
			if(preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $level)||preg_match("/[\\r\\n]/", $password)||preg_match("/[\\r\\n]/", $confirm_password)||preg_match("/[\\r\\n]/", $mobilenum)||preg_match("/[\\r\\n]/", $company)||preg_match("/[\\r\\n]/", $email)||preg_match("/[\\r\\n]/", $realname)||preg_match("/[\\r\\n]/", $vpn)||preg_match("/[\\r\\n]/", $vpnip)||preg_match("/[\\r\\n]/", $usbkey)){
				$error[]=$username.':'.'用户信息中含有回车符'.'\n';
				continue;
			}
			$vpnipexist = $this->member_set->select_all("vpnip='".$vpnip."' and username!='$username'");
			if($network['server1']==$vpnip&&count($vpnipexist)==0){
				$vpnip = $vpnip;
			}else{
				$vnpip = $oldmember['vpnip'];
			}
			$newmember->set_data('netdisksize', $netdisksize);
			$newmember->set_data('allowchange',0);
			$newmember->set_data('default_control', $default_control);
			$newmember->set_data('start_time', date('Y-m-d H:i:s'));
			$newmember->set_data('end_time', '2037:1:1 0:0:0');
			$newmember->set_data('mobilenum', $mobilenum);
			$newmember->set_data('workdepartment', $workdepartment);
			$newmember->set_data('workcompany', $workcompany);
			$newmember->set_data('email', $email);
			$newmember->set_data('realname', $realname);
			$newmember->set_data('adou', $dn);
			$newmember->set_data('vpn', $vpn);
			$newmember->set_data('vpnip', $vpnip);
			$newmember->set_data('usbkey', $usbkey);
			$newmember->set_data('radiusauth', $_POST['radiusauth'] ? 1 : 0);
			$newmember->set_data('ldapauth', $_POST['ldapauth'] ? 1 : 0);

			if(!preg_match('/^[a-zA-Z_]+[a-zA-Z._\-0-9@]*$/', $username)){
				$error[]=$username.':'.'用户名以字母和下划线开头包含大小写字母、数字、下划线、小数点'.'\n';
				continue;
			}
			if(!empty($password)){			
				$config = $this->setting_set->select_all(" sname='password_policy'");
				$pwdconfig = unserialize($config[0]['svalue']);
				$reg = '';			
				$pwdmsg = '';
				$pwdmsgl = null;
				$pwdmsg2 = null;
				$pwdmsgn = null;
				if($pwdconfig['repeatnumber']>0){
					$pwdrepeatc = array();
					for($ci=0; $ci<strlen($password1); $ci++){
						if(empty($pwdrepeatc[$password1[$ci]])) 
							$pwdrepeatc[$password1[$ci]]=1;
						elseif($pwdrepeatc[$password1[$ci]]>=$pwdconfig['repeatnumber']){
							$pwdmsg3 .= '密码中重复字符数不能超过'.$pwdconfig['repeatnumber']."\\n";
							break;
						}else{
							$pwdrepeatc[$password1[$ci]]++;
						}
					}
				}
				if(intval($pwdconfig['pwdstrong1'])>preg_match_all('/[0-9]/', $password1, $matches)){
					//alert_and_back('密码中需要包含数字');
					//exit;
					$pwdmsg .= '数字'." ";
				}
				if(intval($pwdconfig['pwdstrong2'])>preg_match_all('/[a-z]/', $password1, $matches)){
					//alert_and_back('密码中需要包含小写字母');
					//exit;
					$pwdmsg .= '小写字母'." ";
				}
				if(intval($pwdconfig['pwdstrong3'])>preg_match_all('/[A-Z]/', $password1, $matches)){
					//alert_and_back('密码中需要包含小写字母');
					//exit;
					$pwdmsg .= '大写字母'." ";
				}
				$pwd_replace = preg_replace('/[0-9a-zA-Z]/','', $password1);
				if(intval($pwdconfig['pwdstrong4'])>strlen($pwd_replace)){
					//alert_and_back('密码中需要包含特殊字符');
					//exit;
					$pwdmsg .= '特殊字符'." ";
				}
				
				if(strlen($password) < $pwdconfig['login_pwd_length']){
					$pwdmsgl = language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 '.',';
				}

				
				$pwd_ban_word_arr = explode('1', str_replace(' ', '空格', $_CONFIG['PASSWORD_BAN_WORD']));			
				if($pwd_ban_word_arr){
					$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
				}			
				if(!empty($pwd_ban_word_arr[0]))
				for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
					if(strpos($password1, $pwd_ban_word_arr[$pi])!==false){
						$pwdmsg2='密码中不能包含以下字符:'.addslashes($pwd_ban_word_str).'';
						break;
					}
				}
				$pwdmsgs=null;
				if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2) || !empty($pwdmsg3)){
					$pwdmsgs .= $pwdmsg3;
					if($pwdconfig['pwdstrong1'] || $pwdconfig['pwdstrong2'] || $pwdconfig['pwdstrong3'] || $pwdconfig['pwdstrong4']){
						$pwdmsgs .= '密码中需要包含:' .  ($pwdconfig['pwdstrong1'] ? $pwdconfig['pwdstrong1'].'个数字' : '').($pwdconfig['pwdstrong2'] ? $pwdconfig['pwdstrong2'].'个小写字母' : '').($pwdconfig['pwdstrong3'] ? $pwdconfig['pwdstrong3'].'个大写字母' : '').($pwdconfig['pwdstrong4'] ? $pwdconfig['pwdstrong4'].'个特殊字符' : ''). "\\n";
					}
					$pwdmsgs .= language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 ';
					if(count($pwd_ban_word_str)>0){
						$pwdmsgs .= '密码中不能包含以下字符:'.addslashes($pwd_ban_word_str);
					}
					$error[]=$username.':'.$pwdmsgs.'\n';
					//alert_and_back($pwdmsgs);
					//exit;
					continue;
				}
			}else{
				$error[]=$username.':'.'没有输入密码'.'\n';
				continue;
			}

			
			if($password == $confirm_password) {
				$newmember->set_data('password', $this->member_set->udf_encrypt($password));
			}
			else {
				//alert_and_back('两次输入的密码不一致');
				$error[]=$username.':两次输入的密码不一致\n';
				continue;
			}
			if($this->member_set->select_count("username='" . $username . "'")>0 ) {
				//$error[]=$username.":该用户\'$realname\'已经存在".'\n';
				//continue;
			}
			if($this->member_set->select_count("username!='" . $username . "' and realname = '" . $newmember->get_data('realname') . "' AND level!=11")>0 ) {
				//$error[]=$username.":真实名\'$realname\'已经存在".'\n';
				//continue;
			}
			$newmember->set_data('username', $username);
			$newmember->set_data('enable', 1);
			
			$newmember->set_data('level', $level);
			if(isset($_POST['groupid'][$i])){
				$newmember->set_data("groupid", $_POST['groupid'][$i]);
			}
			if($_SESSION['ADMIN_LEVEL']==3){
				$newmember->set_data("level", 0);
				$newmember->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
			}
			//只有普通用户才有Radius用户,系统用户和密码托管用户
			//if($newmember->get_data('level') == 0) {
			$new_radius = new radius();						
			$new_radius->set_data("UserName",$newmember->get_data('username'));
			$new_radius->set_data("Attribute",'Crypt-Password');
			$new_radius->set_data("email",$newmember->get_data('email'));
			
			$new_radius->set_data("Value",crypt($this->member_set->udf_decrypt($newmember->get_data('password')),"\$1\$qY9g/6K4"));
			//var_dump($this->member_set->udf_decrypt($newmember->get_data('password')));exit;
			
			if(($user=$this->member_set->select_all("username = '" . $newmember->get_data('username') . "'")) != NULL){
				//$error[]=$username.':帐户已经存在\n';
				$radiususer = $this->radius_set->select_all("UserName = '" . $newmember->get_data('username') . "'");
				$new_radius->set_data("id",$radiususer[0]['id']);
				$this->radius_set->edit($new_radius);
				$newmember->set_data('uid', $user[0]['uid']);
				$this->member_set->edit($newmember);
				$modified[]=$newmember->get_data('username');
				$all_ids[]=$user[0]['uid'];
				continue;
			}
			$this->radius_set->add($new_radius);

			$dbuser = $this->member_set->base_select("SELECT * FROM ".DBAUDIT_DBNAME.".member where username='".$newmember->get_data('username')."'");
			if(empty($dbuser)){
				if($db_priority>=0){
					$sql = "INSERT INTO ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',level='".$newmember->get_data('level')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."'";
					$this->member_set->query($sql);
					
				}
			}else{
				$sql = "UPDATE ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."',level='".$newmember->get_data('level')."' where uid = '".$dbuser[0]['uid']."'";
				$this->member_set->query($sql);
			}
			$loguser = $this->member_set->base_select("SELECT * FROM ".LOG_DBNAME.".log_user where username='".$newmember->get_data('username')."'");
			if(empty($loguser)){
				if($log_priority>=0){
					$sql = "INSERT INTO ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."'";
					$this->member_set->query($sql);
				}
			}else{
				$sql = "UPDATE ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."' WHERE  userid='".$loguser[0]['userid']."'";
				$this->member_set->query($sql);
			}

			$this->member_set->add($newmember);
			$all_ids[]=mysql_insert_id();
			$added[]=$newmember->get_data('username');

			$passwordlog = new passwordlog();
			$passwordlog->set_data('uid', mysql_insert_id());
			$passwordlog->set_data('password', md5($password1));
			$passwordlog->set_data('time', time());
			$this->passwordlog_set->add($passwordlog);
			//记录日志
			$adminlog = new admin_log();
			$adminlog->set_data('luser', $newmember->get_data('username'));
			$adminlog->set_data('action', language('添加运维用户'));
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('type', 11);
			$this->admin_log_set->add($adminlog);			
		}

		if($added || $modified){
			if(empty($error)){
				$msg = '全部操作成功';
			}else{
				if($added){
					$msg = '成功添加用户:'.implode(',',$added).'\n';
				}
				if($modified){
					$msg .= '成功修改用户:'.implode(',',$modified).'\n';
				}
				if($error){
					$msg .= '\n添加失败的用户:\n'.implode('\n',$error).'\n';
				}
			}
			if(is_array($all_ids))
			$this->member_set->query("UPDATE member set enable=0 where uid NOT IN(".implode(',', $all_ids).") and level=0");
			alert_and_close($msg);
		}else{
			alert_and_close('添加失败:\n'.(is_array($error) ? implode('\n',$error) : '').'\n');
		}
	}
	*/
	
	
	function ldapusers(){
		global $_CONFIG;
		$id = get_request('id');
		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$pwdconfig = unserialize($setting[0]['svalue']);
		//$this->assign("ldaps", $pwdconfig['ldapconfig']);
		$addr_port1 = explode(':', $_SESSION['ldapaddress']);
		if(is_numeric($_GET['id'])&&$id>=0&&is_array($pwdconfig['ldapconfig'][$id])){
			unset($_SESSION['ldapaddress']);
			unset($_SESSION['ldapbasedn']);
			unset($_SESSION['ldapusername']);
			unset($_SESSION['ldappassword']);
		}
		$pwdconfig['ldapconfig'][$id]['adusername']=$_SESSION['ldapusername'];
		$pwdconfig['ldapconfig'][$id]['ou']=$_SESSION['ldapbasedn'];

		if($_POST['address']){
			$addr_port = explode(':', $_POST['address']);
			$ldapconn = @ldap_connect($addr_port[0], $addr_port[1]);	
			if(!$ldapconn){
				alert_and_back("连接LDAP失败");
				exit;
			}
			$_SESSION['ldapaddress']=$_POST['address'];
			$_SESSION['ldapbasedn']=$_POST['ou'];
			$_SESSION['ldapusername']=$_POST['adusername'];
			$_SESSION['ldappassword']=$_POST['adpassword'];
			$_SESSION['ldapusernamemap']=$_POST['usernamemap'];
			$_SESSION['ldaprealnamemap']=$_POST['realnamemap'];
		}else{
			$_domain = explode('.', $pwdconfig['ldapconfig'][$id]['domain']);
			$sdomain = '';
			for($i=0; $i<count($_domain); $i++){
				$sdomain .= "dc=".$_domain[$i].',';
			}
			$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
			$pwdconfig['ldapconfig'][$id]['ou']=$sdomain;
		}
		if(!$ldapconn&&$_SESSION['ldapaddress']){
			$addr_port = explode(':', $_SESSION['ldapaddress']);
			$ldapconn = @ldap_connect($addr_port[0], $addr_port[1]);	
			if(!$ldapconn){
				alert_and_back("连接LDAP失败");
				exit;
			}
		}
		if ($ldapconn) {
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
			$ldapbind = @ldap_bind($ldapconn, $_SESSION['ldapusername'], $_SESSION['ldappassword']);
			if(!$ldapbind){
				alert_and_back("密码错误",'admin.php?controller=admin_config&action=ldapusers&id='.$id);
				exit;
			}
			$basedn = $_SESSION['ldapbasedn'];
			$ous = array();
			$cns = array();
			$allusers = array();
			if(substr($basedn,0,strpos($basedn,'='))=='cn'){
				$sr = @ldap_search($ldapconn, substr($basedn,strpos($basedn,',')+1), '(&(objectClass=posixGroup)('.substr($basedn,0,strpos($basedn,',')).'))', array('objectclass', 'dn', 'samaccountname','OU','CN','memberUid'),0,0);
				$groupinfo = @ldap_get_entries($ldapconn, $sr);
				$ct  = $groupinfo[0]['memberuid']['count'] ? $groupinfo[0]['memberuid']['count'] : 0;
				if($ct)
				for($i=0; $i<$ct; $i++){
					$username = $groupinfo[0]['memberuid'][$i];
					$filter = "|(cn=".$username.")(uid=".$username.")(sn=".$username.")".($_SESSION['LDAP_USER_PREFIX'] ? '('.$_SESSION['LDAP_USER_PREFIX'].'='.$username.')' : '');
					$filter = "(&(objectClass=person)({$filter}))";
					$fields = array("dn","cn","sn","uid","samaccountname","mail","memberof","department","displayname","telephonenumber","primarygroupid","objectsid","objectsid"); 
					
					$realname = $username;
					$sr = @ldap_search($ldapconn, substr($basedn,strpos($basedn,'dc=')), $filter, $fields,0,0);
					$u = @ldap_get_entries($ldapconn, $sr);
					$_u = substr($u[0]['dn'],0,strpos($u[0]['dn'],','));
					$_u = explode('=', $_u);
					$username=trim($_u[1]);
					$realname=trim($_u[1]);
					if($_SESSION['ldapusernamemap']){
						if($_SESSION['ldapusernamemap']=='mail'){
							$username = substr($u[0]['mail'][0],0,strpos($u[0]['mail'][0],'@'));
						}else{
							$username = $u[0][$_SESSION['ldapusernamemap']][0];
						}
					}
					if($_SESSION['ldaprealnamemap']){
						$realname = $u[0][$_SESSION['ldaprealnamemap']][0];
					}

					$allusers[]=array('username'=>$username,'dn'=>$basedn,'exists'=>($this->member_set->select_count("username='".$username."'")),'ingroup'=>1);
				}
				$this->assign("groupnumber", $ct);
			}

			$sr = @ldap_search($ldapconn, $basedn, '(&(objectClass=organizationalUnit))', array('objectclass', 'dn', 'samaccountname','OU','CN'),0,0);
			$r = @ldap_get_entries($ldapconn, $sr);
			//echo '<pre>';var_dump($r);echo '</pre>';
			//$r = $adldap->folder()->listing(null,adLDAP::ADLDAP_FOLDER,true,null);

			if($r['count']>0)
			for($i=0; $i<$r['count']; $i++){
				$distinguishedname = substr($r[$i]['dn'],strpos($r[$i]['dn'],',')+1);
				//echo '<pre>';var_dump($r[$i]['samaccountname'][0]);echo '</pre>';
				if(strtolower($distinguishedname)==strtolower($basedn)){//echo '<pre>';var_dump($r[$i]);echo '</pre>';echo '------------------------------------------------';
					if($r[$i]['ou'][0]) $ous[] = array('name'=>$r[$i]['ou'][0], 'dn'=>$r[$i]['dn'],'count'=>0);
					else $cns[] = $r[$i]['cn'][0];
				}
			}
			$groups = array();
			$sr = @ldap_search($ldapconn, $basedn, '(&(objectClass=posixGroup))', array('objectclass', 'dn', 'samaccountname','OU','CN','memberUid'),0,0);
			$r = @ldap_get_entries($ldapconn, $sr);
			//echo '<pre>';var_dump($r);echo '</pre>';	
			if($r['count']>0)
			for($i=0; $i<$r['count']; $i++){
				//echo '<pre>';var_dump($adldap->group()->info($val));echo '</pre>';echo 'netmwd';		
				$distinguishedname=$r[$i]['dn'];
				for($j=0; $j<count($ous); $j++){
					if(strstr($distinguishedname, $ous[$j]['dn'])){
						$ous[$j]['count']+=$r[$i]['memberuid']['count']?$r[$i]['memberuid']['count']:0;
					}
				}
				$distinguishedname = substr($distinguishedname,strpos($distinguishedname,',')+1);
				if(strtolower($distinguishedname)==strtolower($basedn)){
					$groups[] = array('groupname'=>$r[$i]['cn'], 'usercount'=>($r[$i]['memberuid']['count']?$r[$i]['memberuid']['count']:0));
				}
			}
/*$pageSize = 100;

     $cookie = '';
     do {
         ldap_control_paged_result($ds, $pageSize, true, $cookie);

         $sr = ldap_search($ldapconn, $basedn, $filter, $fields,0,10000);
    	$entries = @ldap_get_entries($ldapconn, $sr);
             
         foreach ($entries as $e) {
             echo $e['dn'] . PHP_EOL;
         }

         ldap_control_paged_result_response($ds, $result, $cookie);
       
     } while($cookie !== null && $cookie != '');
     
     exit;*/			
			$filter = "(&(objectClass=person))";
			$fields = array("uid","cn","sn","dn","name","mail","samaccountname","displayname");
			$sr = @ldap_search($ldapconn, $basedn, $filter, $fields,0,0);
			$info = @ldap_get_entries($ldapconn, $sr);
			
			//echo '<pre>';var_dump($info);echo '</pre>';exit;
			for($i=0; $i<$info['count']; $i++){
				$_u = substr($info[$i]['dn'],0,strpos($info[$i]['dn'],','));
				$_u = explode('=', $_u);
				$username=trim($_u[1]);
				$realname=trim($_u[1]);
				if($_SESSION['ldapusernamemap']){
					if($_SESSION['ldapusernamemap']=='mail'){
						$username = substr($info[$i]['mail'][0],0,strpos($info[$i]['mail'][0],'@'));
					}else{
						$username =$info[$i][$_SESSION['ldapusernamemap']][0];
					}
				}
				if($_SESSION['ldaprealnamemap']){
					$realname = $info[$i][$_SESSION['ldaprealnamemap']][0];
				}

				$distinguishedname=trim($info[$i]['dn']);
				$_name = explode('(', $info[$i]['name'][0]);
				//$username = strtolower(trim(substr($info[$i]['mail'][0],0,strpos($info[$i]['mail'][0],'@'))));
				//var_dump($_name);
				//$realname = substr($_name[1], 0, strpos($_name[1], ")"));
				//var_dump($realname);

				if(!empty($username)){
					for($j=0; $j<count($ous); $j++){
						if(strstr($distinguishedname, $ous[$j]['dn'])){
							$ous[$j]['count']++;
						}
					}
					$distinguishedname = substr($distinguishedname,strpos($distinguishedname,',')+1);
					if(strtolower($distinguishedname)==strtolower($basedn)){
						$allusers[]=array('username'=>$username);
					}
				}
			}
			if($info['count']>0){
				$_SESSION['LDAP_USER_PREFIX']=explode('=', $info[$i]['dn']);
				$_SESSION['LDAP_USER_PREFIX']=$_SESSION['LDAP_USER_PREFIX'][0];
			}
			//echo '<pre>';var_dump($allusers);echo '</pre>';exit;
			$users = $this->member_set->select_all("username IN('".implode("','", $allusers)."')");
			$_users = array();
			for($i=0; $i<count($users); $i++){
				$_users[]=$users[$i]['username'];
			}
			if($_allusers)
			$allusers = $_allusers;
			$_allusers = null;

			$nogroupusers = array();
			for($i=0; $i<count($allusers); $i++){
				if($users&&in_array($allusers[$i]['username'], $users)){
					$allusers[$i]['exists']=1;
				}
				$nogroupusers[]=$allusers[$i];
				
			}
			sort($nogroupusers);
			
			//echo '<pre>';var_dump($groups);echo '</pre>';
			//echo '<pre>';var_dump($nogroupusers);echo '</pre>';
		
			$this->assign("step", 1);
			$this->assign("ous", $ous);
			$this->assign("cns", $cns);
			$this->assign("groups", $groups);

			$this->assign("nogroupusers", $nogroupusers);
		}
		$this->assign("dn", $basedn);
		$this->assign("adconfig", $pwdconfig['ldapconfig'][$id]);
		require_once('./include/select_sgroup_ajax.inc.php');
		$this->display('ldapusers_tree.tpl');
	
	}

	function ldapusersbygroup(){
		global $_CONFIG;
		header("Content-Type:text/html;charset=UTF-8");
		$ldapaddress = $_SESSION['ldapaddress'];
		$adusername = $_SESSION['ldapusername'];
		$adpassword = $_SESSION['ldappassword'];
		$groupname = get_request('groupname', 0, 1);
		$ouname = get_request('ouname', 0, 1);
		$cname = get_request('cname', 0, 1);
		$dn = get_request('dn', 0, 1);
		$pid = get_request('pid', 0, 1);
		
		$groupname = unescape($groupname);//
		$ouname = unescape($ouname);
		$dn = unescape($dn);
		$basedn = $dn;
		//var_dump($groupname);
		//var_dump($ouname);
		//var_dump($dn);
				
		$addr_port = explode(':', $ldapaddress);
		$ldapconn = @ldap_connect($addr_port[0], $addr_port[1]);			 
		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
		
		if (!$ldapconn) {
			echo '连接失败';
			exit;
		}
				
		$ldapbind = @ldap_bind($ldapconn, $adusername, $adpassword);
		if(!$ldapbind){
			echo '用户名密码错误';
			exit;
		}
				
		if($groupname){
			$allusers = array();
			$sr = @ldap_search($ldapconn, $basedn, '(&(objectClass=posixGroup)(cn='.$groupname.'))', array('objectclass', 'dn', 'samaccountname','OU','CN','memberUid'),0,0);
			$groupinfo = @ldap_get_entries($ldapconn, $sr);
			for($i=0; $i<$groupinfo[0]['memberuid']['count']; $i++){
				$username = $groupinfo[0]['memberuid'][$i];
				$filter = "|(cn=".$username.")(uid=".$username.")(sn=".$username.")".($_SESSION['LDAP_USER_PREFIX'] ? '('.$_SESSION['LDAP_USER_PREFIX'].'='.$username.')' : '');
				$filter = "(&(objectClass=person)({$filter}))";
				$fields = array("dn","cn","sn","uid","samaccountname","mail","memberof","department","displayname","telephonenumber","primarygroupid","objectsid","objectsid"); 
				
				$realname = $username;
				$sr = @ldap_search($ldapconn, substr($basedn,strpos($basedn,'dc=')), $filter, $fields,0,0);
				$u = @ldap_get_entries($ldapconn, $sr);
				$_u = substr($u[0]['dn'],0,strpos($u[0]['dn'],','));
				$_u = explode('=', $_u);
				$username=trim($_u[1]);
				$realname=trim($_u[1]);
				if($_SESSION['ldapusernamemap']){
					if($_SESSION['ldapusernamemap']=='mail'){
						$username = substr($u[0]['mail'][0],0,strpos($u[0]['mail'][0],'@'));
					}else{
						$username = $u[0][$_SESSION['ldapusernamemap']][0];
					}
				}
				if($_SESSION['ldaprealnamemap']){
					$realname = $u[0][$_SESSION['ldaprealnamemap']][0];
				}
				$allusers[]=array('username'=>$username.'|'.'cn='.$groupname.','.$basedn,'dn'=>'cn='.$groupname.','.$basedn,'exists'=>($this->member_set->select_count("username='".$username."'")));
			}
			$basedn = 'cn='.$cname.','.$basedn;
			$groups = array();
			$groupusers = array();
			$sr = @ldap_search($ldapconn, $basedn, '(&(objectClass=posixGroup))', array('objectclass', 'dn', 'samaccountname','OU','CN','memberUid'),0,0);
			$r  = @ldap_get_entries($ldapconn, $sr);
			//echo '<pre>';var_dump($r);echo '</pre>';
			if($r['count']>0)
			for($i=0; $i<$r['count']; $i++){
				//echo '<pre>';var_dump($adldap->group()->info($val));echo '</pre>';echo 'netmwd';		$users = $this->member_set->select_all("username IN('".implode("','", $allusers)."')");
				$distinguishedname=$r[$i]['dn'];
				$distinguishedname = substr($distinguishedname,strpos($distinguishedname,',')+1);
				if(strtolower($distinguishedname)==strtolower($basedn)){
					$groups[] = array('groupname'=>$r[$i]['cn'][0], 'usercount'=>($r[$i]['memberuid']['count']?$r[$i]['memberuid']['count']:0));
				}
			}

			$filter = "(&(objectClass=person))";
    		$fields = array("uid","cn","sn","dn","name","mail","samaccountname","displayname");
    		$sr = @ldap_search($ldapconn, $basedn, $filter, $fields,0,0);
    		$info = @ldap_get_entries($ldapconn, $sr);

			//echo '<pre>';var_dump($info);echo '</pre>';
			
			for($i=0; $i<$info['count']; $i++){
				//$username=trim($info[$i]['uid'][0]);
				//$realname=trim($info[$i]['cn'][0]);
				$_u = substr($info[$i]['dn'],0,strpos($info[$i]['dn'],','));
				$_u = explode('=', $_u);
				$username=trim($_u[1]);
				$realname=trim($_u[1]);
				if($_SESSION['ldapusernamemap']){
					if($_SESSION['ldapusernamemap']=='mail'){
						$username = substr($info[$i]['mail'][0],0,strpos($info[$i]['mail'][0],'@'));
					}else{
						$username = $info[$i][$_SESSION['ldapusernamemap']][0];
					}
				}
				if($_SESSION['ldaprealnamemap']){
					$realname = $info[$i][$_SESSION['ldaprealnamemap']][0];
				}
				$distinguishedname=trim($info[$i]['dn']);
				$_name = explode('(', $info[$i]['name'][0]);
				//$username = strtolower(trim(substr($info[$i]['mail'][0],0,strpos($info[$i]['mail'][0],'@'))));
				//var_dump($_name);
				//$realname = substr($_name[1], 0, strpos($_name[1], ")"));
				//var_dump($username);
				//var_dump($realname);
				if(!empty($username)){
					for($j=0; $j<count($ous); $j++){
						//var_dump($distinguishedname);var_dump($ous[$j]['dn']);
						if(strstr($distinguishedname, $ous[$j]['dn'])){
							$ous[$j]['count']++;
						}
					}
					$distinguishedname = substr($distinguishedname,strpos($distinguishedname,',')+1);
					if(strtolower($distinguishedname)==strtolower($basedn)){
						$allusers[]=array('username'=>$username,'exists'=>($this->member_set->select_count("username='".$username."'")));
					}
				}
			}
			if($info['count']>0){
				$_SESSION['LDAP_USER_PREFIX']=explode('=', $info[$i]['dn']);
				$_SESSION['LDAP_USER_PREFIX']=$_SESSION['LDAP_USER_PREFIX'][0];
			}

			$users = $this->member_set->select_all("username IN('".implode("','", $allusers)."')");
			$_users = array();
			for($i=0; $i<count($users); $i++){
				$_users[]=$users[$i]['username'];
			}
			if($_allusers)
			$allusers = $_allusers;
			$_allusers = null;
			sort($allusers);
			echo json_encode(array('dn'=>$basedn,'pid'=>$pid,'ous'=>array(),'cns'=>array(),'groups'=>array(),'users'=>$allusers));
			/*
			for($i=0; $i<count($allusers); $i++){
				echo $allusers[$i].","."0\r\n";
			}*/
		}else{
			if($cname) $basedn = 'cn='.$cname.','.$basedn;
			else $basedn = 'ou='.$ouname.','.$basedn;
			
			$ous = array();
			$cns = array();
			
			$sr = @ldap_search($ldapconn, $basedn, '(&(objectClass=organizationalUnit))', array('objectclass', 'dn', 'samaccountname','OU','CN'),0,0);
        	$r = @ldap_get_entries($ldapconn, $sr);
        	//echo '<pre>';var_dump($r);echo '</pre>';
			//$r = $adldap->folder()->listing(null,adLDAP::ADLDAP_FOLDER,true,null);
			if($r['count']>0)
			for($i=0; $i<$r['count']; $i++){
				$distinguishedname = substr($r[$i]['dn'],strpos($r[$i]['dn'],',')+1);
				//
				//echo '<pre>';var_dump($r[$i]['samaccountname'][0]);echo '</pre>';
				if(strtolower($distinguishedname)==strtolower($basedn)){//echo '<pre>';var_dump($r[$i]);echo '</pre>';echo '------------------------------------------------';
					if($r[$i]['ou'][0]) $ous[] = array('name'=>$r[$i]['ou'][0], 'dn'=>$r[$i]['dn'], 'count'=>0);
					else $cns[] = $r[$i]['cn'][0];
				}
			}
			
			$filter = "(&(objectClass=person))";
    		$fields = array("uid","cn","sn","dn","name","mail","samaccountname","displayname");
    		$sr = @ldap_search($ldapconn, $basedn, $filter, $fields,0,0);
    		$info = @ldap_get_entries($ldapconn, $sr);

			//echo '<pre>';var_dump($info);echo '</pre>';
			$allusers = array();
			for($i=0; $i<$info['count']; $i++){
				//$username=trim($info[$i]['uid'][0]);
				//$realname=trim($info[$i]['cn'][0]);
				$_u = substr($info[$i]['dn'],0,strpos($info[$i]['dn'],','));
				$_u = explode('=', $_u);
				$username=trim($_u[1]);
				$realname=trim($_u[1]);
				if($_SESSION['ldapusernamemap']){
					if($_SESSION['ldapusernamemap']=='mail'){
						$username = substr($info[$i]['mail'][0],0,strpos($info[$i]['mail'][0],'@'));
					}else{
						$username = $info[$i][$_SESSION['ldapusernamemap']][0];
					}
				}
				if($_SESSION['ldaprealnamemap']){
					$realname = $info[$i][$_SESSION['ldaprealnamemap']][0];
				}
				$distinguishedname=trim($info[$i]['dn']);
				$_name = explode('(', $info[$i]['name'][0]);
				//$username = strtolower(trim(substr($info[$i]['mail'][0],0,strpos($info[$i]['mail'][0],'@'))));
				//var_dump($_name);
				//$realname = substr($_name[1], 0, strpos($_name[1], ")"));
				//var_dump($username);
				//var_dump($realname);
				if(!empty($username)){
					for($j=0; $j<count($ous); $j++){
						//var_dump($distinguishedname);var_dump($ous[$j]['dn']);
						if(strstr($distinguishedname, $ous[$j]['dn'])){
							$ous[$j]['count']++;
						}
					}
					$distinguishedname = substr($distinguishedname,strpos($distinguishedname,',')+1);
					if(strtolower($distinguishedname)==strtolower($basedn)){
						$allusers[]=$username;
					}
				}
			}
			if($info['count']>0){
				$_SESSION['LDAP_USER_PREFIX']=explode('=', $info[$i]['dn']);
				$_SESSION['LDAP_USER_PREFIX']=$_SESSION['LDAP_USER_PREFIX'][0];
			}
			//echo '<pre>';var_dump($allusers);echo '</pre>';exit;
			$users = $this->member_set->select_all("username IN('".implode("','", $allusers)."')");
			$_users = array();
			for($i=0; $i<count($users); $i++){
				$_users[]=$users[$i]['username'];
			}
			for($i=0; $i<count($allusers); $i++){
				if(!in_array($allusers[$i], $_CONFIG['AD_USERS'])){
					$_allusers[]=$allusers[$i];
				}
			}
			if($_allusers)
			$allusers = $_allusers;
			$_allusers = null;

			$groups = array();
			$groupusers = array();
			$sr = @ldap_search($ldapconn, $basedn, '(&(objectClass=posixGroup))', array('objectclass', 'dn', 'samaccountname','OU','CN','memberUid'),0,0);
			$r = @ldap_get_entries($ldapconn, $sr);
			//echo '<pre>';var_dump($r);echo '</pre>';	
			if($r['count']>0)
			for($i=0; $i<$r['count']; $i++){
				//echo '<pre>';var_dump($adldap->group()->info($val));echo '</pre>';echo 'netmwd';		
				$distinguishedname=$r[$i]['dn'];
				$distinguishedname = substr($distinguishedname,strpos($distinguishedname,',')+1);
				if(strtolower($distinguishedname)==strtolower($basedn)){
					$groups[] = array('groupname'=>$r[$i]['cn'][0], 'usercount'=>($r[$i]['memberuid']['count']?$r[$i]['memberuid']['count']:0));
				}
			}

			$nogroupusers = array();
			for($i=0; $i<count($allusers); $i++){
				if(!in_array($allusers[$i], $groupusers)){
					$nogroupusers[]=array('username'=>$allusers[$i],'exists'=>(in_array($allusers[$i], $_users) ? 1 : 0));
				}
			}
			sort($nogroupusers);
			echo json_encode(array('dn'=>$basedn,'pid'=>$pid,'ous'=>$ous,'cns'=>$cns,'groups'=>$groups,'users'=>$nogroupusers));
		}
		
		/*for($i=0; $i<1000; $i++){
			echo "user_".$i.","."0\r\n";
		}*/
	}



	function ldapusers_save(){
		global $_CONFIG;
		$ldapauth = get_request('ldapauth', 1, 0);
		$radiusauth = get_request('radiusauth', 1, 0);
		$basedn = $_SESSION['ldapbasedn'];
		$ldapaddress = $_SESSION['ldapaddress'];
		$adusername = $_SESSION['ldapusername'];
		$adpassword = $_SESSION['ldappassword'];
		$addr_port = explode(':', $ldapaddress);
		$ldapconn = @ldap_connect($addr_port[0], $addr_port[1]);			 
		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
		ldap_set_option($ldapconn, LDAP_OPT_SIZELIMIT, 100000);
		
		if (!$ldapconn) {
			echo '连接失败';
			exit;
		}
				
		$ldapbind = @ldap_bind($ldapconn, $adusername, $adpassword);
		if(!$ldapbind){
			echo '用户名密码错误';
			exit;
		}
		$addeltegroup = $this->sgroup_set->select_all("lower(groupname)='ad_delete'");
		$addeltegroupid = $addeltegroup[0]['id'];
		if(empty($addeltegroup)){
			$newsgroup = new sgroup();
			$newsgroup->set_data('groupname', strtoupper('ad_delete'));
			$newsgroup->set_data('count', 0);
			$newsgroup->set_data('ldapid', 0);
			$newsgroup->set_data('child', '');
			$this->sgroup_set->add($newsgroup);
			$addeltegroupid = mysql_insert_id();
			$newsgroup = null;
			$newsgroup = new sgroup();
			$newsgroup->set_data('child', $addeltegroupid);
			$newsgroup->set_data('id', $addeltegroupid);
			$this->sgroup_set->edit($newsgroup);
		}
		
		if($allusers){

			//$this->member_set->query("UPDATE ".$this->member_set->get_table_name()." SET enable=0 where username NOT IN('".implode("','", $allusers)."') AND (adou!='' or adou is not null) and level=0");		
			//$disabledusers = $this->member_set->select_all("adou!='' and level=0 and enable=1 and username NOT IN('".implode("','", $allusers)."')");
			for($i=0; $i<count($disabledusers); $i++){
				$m = new member();
				$m->set_data('uid', $disabledusers[$i]['uid']);
				$m->set_data('enable', 0);
				$m->set_data('groupid', $addeltegroupid);
				$this->member_set->edit($m);
				//记录日志
				$adminlog = new admin_log();
				$adminlog->set_data('luser', $disabledusers[$i]['username']);
				$adminlog->set_data('action', language('禁用运维用户'));
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('type', 11);
				$this->admin_log_set->add($adminlog);

				$aduserlog = new aduser_log();
				$aduserlog->set_data('username', $disabledusers[$i]['username']);
				if(unserialize($disabledusers[$i]['adou']))
				$aduserlog->set_data('ad', '/'.implode('/', unserialize($disabledusers[$i]['adou'])));
				$aduserlog->set_data('ldap', 'ad_delete');
				$aduserlog->set_data('action', '删除');
				$aduserlog->set_data('configid', $config['id']);
				$aduserlog->set_data('configname', '前台手工导入');
				$aduserlog->set_data('ip', $addr_port[0]);
				$this->aduser_log_set->add($aduserlog);
				$disabled[]=$disabledusers[$i]['username'];
			}
		}

		if(empty($_POST['username'])){
			alert_and_back('请选择用户');
			exit;
		}


		for($i=0; $i<count($_POST['username']); $i++){			
			$newmember = new member();
			$username = $_POST['username'][$i];
			$level = 0;
			if(empty($username)){
				continue;
			}

			$password = $_POST['password'];
			$confirm_password = $password;			
			$mobilenum = $_POST['mobilenum'][$i];
			$company = $_POST['company'][$i];
			$workcompany = $_POST['workcompany'][$i];
			$workdepartment = $_POST['workdepartment'][$i];
			$email = $_POST['email'][$i];
			$realname = $_POST['username'][$i];
			$vpn = $_POST['vpn'][$i];
			$vpnip = $_POST['vpnip'][$i];
			$usbkey = $_POST['usbkey'][$i];
			
			$ingroup=0;
			if(strpos($username,'|')){
				$u = explode('|', $username);
				$username = $u[0];
				$distinguishedname='cn='.$username.','.$u[1];
				$ingroup=1;
			}
			$filter = "|(cn=".$username.")(uid=".$username.")(sn=".$username.")".($_SESSION['LDAP_USER_PREFIX'] ? '('.$_SESSION['LDAP_USER_PREFIX'].'='.$username.')' : '').($_SESSION['ldapusernamemap'] ? '('.$_SESSION['ldapusernamemap'].'='.$username .'@*)' : '');
			$filter = "(&(objectClass=person)({$filter}))";
			$fields = array("dn","cn","sn","uid","samaccountname","mail","memberof","department","displayname","telephonenumber","primarygroupid","objectsid","objectsid"); 
			
			$realname = $username;
			$sr = @ldap_search($ldapconn, $ingroup ? substr($basedn,strpos($basedn,'dc=')) : $basedn, $filter, $fields,0,0);
			$u = @ldap_get_entries($ldapconn, $sr);
			//var_dump($u);exit;
			$_u = substr($u[0]['dn'],0,strpos($u[0]['dn'],','));
			$_u = explode('=', $_u);
			$username=trim($_u[1]);
			$realname=trim($_u[1]);
			if(empty($ingroup)){
				$distinguishedname = $u[0]['dn'];
			}
			if($_SESSION['ldapusernamemap']){
				if($_SESSION['ldapusernamemap']=='mail'){
					$username = substr($u[0]['mail'][0],0,strpos($u[0]['mail'][0],'@'));
				}else{
					$username = $u[0][$_SESSION['ldapusernamemap']][0];
				}
			}
			if($_SESSION['ldaprealnamemap']){
				$realname = $u[0][$_SESSION['ldaprealnamemap']][0];
			}
			if(preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $level)||preg_match("/[\\r\\n]/", $password)||preg_match("/[\\r\\n]/", $confirm_password)||preg_match("/[\\r\\n]/", $mobilenum)||preg_match("/[\\r\\n]/", $company)||preg_match("/[\\r\\n]/", $email)||preg_match("/[\\r\\n]/", $realname)||preg_match("/[\\r\\n]/", $vpn)||preg_match("/[\\r\\n]/", $vpnip)||preg_match("/[\\r\\n]/", $usbkey)){
				$error[]=$username.':'.'用户信息中含有回车符'.'\n';
				continue;
			}
			//echo '<pre>';var_dump($username);var_dump($realname);echo '</pre>';exit;
			$newmember->set_data('realname', $realname);
			$vpnipexist = $this->member_set->select_all("vpnip='".$vpnip."' and username!='$username'");
			if($network['server1']==$vpnip&&count($vpnipexist)==0){
				$vpnip = $vpnip;
			}else{
				$vnpip = $oldmember['vpnip'];
			}
			$newmember->set_data('workcompany', $u[0]['department'][0]);
			$newmember->set_data('netdisksize', $netdisksize);
			$newmember->set_data('allowchange',0);
			$newmember->set_data('default_control', $default_control);
			$newmember->set_data('start_time', date('Y-m-d H:i:s'));
			$newmember->set_data('end_time', '2037:1:1 0:0:0');
			$newmember->set_data('mobilenum', $mobilenum);
			$newmember->set_data('workdepartment', $workdepartment);
			$newmember->set_data('workcompany', $workcompany);
			$newmember->set_data('email', $u[0]['mail'][0]);
			$newmember->set_data('vpn', $vpn);
			$newmember->set_data('vpnip', $vpnip);
			$newmember->set_data('usbkey', $usbkey);
			$newmember->set_data('ldapauth', $ldapauth);
			$newmember->set_data('radiusauth', $radiusauth);
			$newmember->set_data('adou', $u[0]['dn']);
			if($ldapauth){
				$newmember->set_data('tranportauth', 3);
			}else{
				$newmember->set_data('tranportauth', 2);
			}

			if(!preg_match('/^[a-zA-Z_]+[a-zA-Z._\-0-9@]*$/', $username)){
				$error[]=$username.':'.'用户名以字母和下划线开头包含大小写字母、数字、下划线、小数点'.'\n';
				continue;
			}
			if(!empty($password)){			
				$config = $this->setting_set->select_all(" sname='password_policy'");
				$pwdconfig = unserialize($config[0]['svalue']);
				$reg = '';			
				$pwdmsg = '';
				$pwdmsgl = null;
				$pwdmsg2 = null;
				$pwdmsgn = null;
				if($pwdconfig['repeatnumber']>0){
					$pwdrepeatc = array();
					for($ci=0; $ci<strlen($password); $ci++){
						if(empty($pwdrepeatc[$password[$ci]])) 
							$pwdrepeatc[$password[$ci]]=1;
						elseif($pwdrepeatc[$password[$ci]]>=$pwdconfig['repeatnumber']){
							$pwdmsg3 .= '密码中重复字符数不能超过'.$pwdconfig['repeatnumber']."\\n";
							break;
						}else{
							$pwdrepeatc[$password[$ci]]++;
						}
					}
				}
				if(intval($pwdconfig['pwdstrong1'])>preg_match_all('/[0-9]/', $password, $matches)){
					//alert_and_back('密码中需要包含数字');
					//exit;
					$pwdmsg .= '数字'." ";
				}
				if(intval($pwdconfig['pwdstrong2'])>preg_match_all('/[a-z]/', $password, $matches)){
					//alert_and_back('密码中需要包含小写字母');
					//exit;
					$pwdmsg .= '小写字母'." ";
				}
				if(intval($pwdconfig['pwdstrong3'])>preg_match_all('/[A-Z]/', $password, $matches)){
					//alert_and_back('密码中需要包含小写字母');
					//exit;
					$pwdmsg .= '大写字母'." ";
				}
				$pwd_replace = preg_replace('/[0-9a-zA-Z]/','', $password);
				if(intval($pwdconfig['pwdstrong4'])>strlen($pwd_replace)){
					//alert_and_back('密码中需要包含特殊字符');
					//exit;
					$pwdmsg .= '特殊字符'." ";
				}
				
				if(strlen($password) < $pwdconfig['login_pwd_length']){
					$pwdmsgl = language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 '.',';
				}
				
				$pwd_ban_word_arr = explode('1', str_replace(' ', '空格', $_CONFIG['PASSWORD_BAN_WORD']));			
				if($pwd_ban_word_arr){
					$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
				}			
				if(!empty($pwd_ban_word_arr[0]))
				for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
					if(strpos($password1, $pwd_ban_word_arr[$pi])!==false){
						$pwdmsg2='密码中不能包含以下字符:'.addslashes($pwd_ban_word_str).'';
						break;
					}
				}
				$pwdmsgs=null;
				if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2) || !empty($pwdmsg3)){
					$pwdmsgs .= $pwdmsg3;
					if($pwdconfig['pwdstrong1'] || $pwdconfig['pwdstrong2'] || $pwdconfig['pwdstrong3'] || $pwdconfig['pwdstrong4']){
						$pwdmsgs .= '密码中需要包含:' .  ($pwdconfig['pwdstrong1'] ? $pwdconfig['pwdstrong1'].'个数字' : '').($pwdconfig['pwdstrong2'] ? $pwdconfig['pwdstrong2'].'个小写字母' : '').($pwdconfig['pwdstrong3'] ? $pwdconfig['pwdstrong3'].'个大写字母' : '').($pwdconfig['pwdstrong4'] ? $pwdconfig['pwdstrong4'].'个特殊字符' : ''). "\\n";
					}
					$pwdmsgs .= language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 ';
					if(count($pwd_ban_word_str)>0){
						$pwdmsgs .= '密码中不能包含以下字符:'.addslashes($pwd_ban_word_str);
					}
					$error[]=$username.':'.$pwdmsgs.'\n';
					//alert_and_back($pwdmsgs);
					//exit;
					continue;
				}
			}else{
				$error[]=$username.':'.'没有输入密码'.'\n';
				continue;
			}

			
			if($password == $confirm_password) {
				$newmember->set_data('password', $this->member_set->udf_encrypt($password));
			}
			else {
				//alert_and_back('两次输入的密码不一致');
				$error[]=$username.':两次输入的密码不一致\n';
				continue;
			}
			if($this->member_set->select_count("username='" . $username . "'")>0 ) {
				//$error[]=$username.":该用户\'$realname\'已经存在".'\n';
				//continue;
			}
			if($this->member_set->select_count("username!='" . $username . "' and realname = '" . $newmember->get_data('realname') . "' AND level!=11")>0 ) {
				//$error[]=$username.":真实名\'$realname\'已经存在".'\n';
				//continue;
			}
			$newmember->set_data('username', $username);
			
			$distinguishedname = explode(',', $distinguishedname);
			array_shift($distinguishedname);
			$distinguishedname = array_reverse($distinguishedname);
			$head_str = "";
			$p = 0;
			for($j=0; $j<count($distinguishedname); $j++){
				$head_array = explode('=', $distinguishedname[$j]);
				if(strtolower($head_array[0])=='dc'){
					$head_str=$head_array[1].".".$head_str;
					$p++;
					continue;
				}
				$distinguishedname[$j]=$head_array[1];
			}
			$distinguishedname[$p-1]=substr($head_str, 0, strlen($head_str)-1);
			for($j=0; $j<$p-1; $j++){
				array_shift($distinguishedname);
			}

			$newmember->set_data('level', $level);
			if($_POST['groupid']){
				$groupid = $_POST['groupid'];
			}else{
				
				$groupparentid=0;//var_dump($distinguishedname);
				for($j=0; $j<count($distinguishedname); $j++){
					$_group = $distinguishedname[$j];
					$where = null;
					if(!empty($groupparentid)){
						$where .= " AND ldapid=".$groupparentid." ";
					}
					$__group = $this->sgroup_set->select_all("groupname='".$_group."'".$where);
					if(empty($__group)){
						$newsgroup = new sgroup();
						$newsgroup->set_data('groupname', $_group);
						$newsgroup->set_data('count', 0);
						$newsgroup->set_data('ldapid', $groupparentid);
						$newsgroup->set_data('child', '');
						$this->sgroup_set->add($newsgroup);
						$groupid = mysql_insert_id();
						$newsgroup = null;
						$newsgroup = new sgroup();
						$newsgroup->set_data('child', $groupid);
						$newsgroup->set_data('id', $id);
						$this->sgroup_set->edit($newsgroup);
					}
					$__group = $this->sgroup_set->select_all("groupname='".$_group."'".$where);
					$groupid=$groupparentid = $__group[0]['id'];
				}
			}
			$newmember->set_data("groupid", $groupid);
			if($_SESSION['ADMIN_LEVEL']==3){
				$newmember->set_data("level", 0);
				$newmember->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
			}
			$distinguishedname = serialize($distinguishedname);
			
			/*只有普通用户才有Radius用户,系统用户和密码托管用户*/
			//if($newmember->get_data('level') == 0) {
			$new_radius = new radius();	
			$new_radius->set_data("UserName",$newmember->get_data('username'));
			$new_radius->set_data("Attribute",'Crypt-Password');
			$new_radius->set_data("email",$newmember->get_data('email'));
			
			$new_radius->set_data("Value",crypt($this->member_set->udf_decrypt($newmember->get_data('password')),"\$1\$qY9g/6K4"));
			//var_dump($this->member_set->udf_decrypt($newmember->get_data('password')));exit;
			
			if(($user=$this->member_set->select_all("username = '" . $newmember->get_data('username') . "'")) != NULL){
				//$error[]=$username.':帐户已经存在\n';
				if($user[0]['adou']!=$newmember->get_data('adou')){					
					//$newmember->set_data('adou', $user[0]['adou']);			
					//$newmember->set_data('groupid', $user[0]['groupid']);
					//记录日志
					$adminlog = new admin_log();
					$adminlog->set_data('luser', $user[0]['username']);
					$adminlog->set_data('action', language('AD用户添加出现OU不一致'));
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
					$this->admin_log_set->add($adminlog);
				}
				if($user[0]['groupid']!=$groupid){
					$agroup=$this->sgroup_set->select_by_id($user[0]['groupid']);
					$ogroup = $agroup['groupname'];
					while($agroup['ldapid']){
						$agroup=$this->sgroup_set->select_by_id($agroup['ldapid']);
						$ogroup = $agroup['groupname'].'/'.$ogroup;
					}
					$aduserlog = new aduser_log();
					$aduserlog->set_data('username', $user[0]['username']);
					$aduserlog->set_data('ad', $ogroup);
					$aduserlog->set_data('ldap', implode('/', unserialize($distinguishedname)));
					$aduserlog->set_data('action', '移动');
					$aduserlog->set_data('configid', $config['id']);
					$aduserlog->set_data('configname', '前台手工导入');
					$aduserlog->set_data('ip', $addr_port[0]);
					$this->aduser_log_set->add($aduserlog);
				}
				$radiususer = $this->radius_set->select_all("UserName = '" . $newmember->get_data('username') . "'");
				$new_radius->set_data("id",$radiususer[0]['id']);
				$this->radius_set->edit($new_radius);
				$newmember->set_data('uid', $user[0]['uid']);
				$this->member_set->edit($newmember);
				$modified[]=$newmember->get_data('username');
				continue;
			}
			$this->radius_set->add($new_radius);

			$dbuser = $this->member_set->base_select("SELECT * FROM ".DBAUDIT_DBNAME.".member where username='".$newmember->get_data('username')."'");
			if(empty($dbuser)){
				if($db_priority>=0){
					$sql = "INSERT INTO ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',level='".$newmember->get_data('level')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."'";
					$this->member_set->query($sql);
					
				}
			}else{
				$sql = "UPDATE ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."',level='".$newmember->get_data('level')."' where uid = '".$dbuser[0]['uid']."'";
				$this->member_set->query($sql);
			}
			$loguser = $this->member_set->base_select("SELECT * FROM ".LOG_DBNAME.".log_user where username='".$newmember->get_data('username')."'");
			if(empty($loguser)){
				if($log_priority>=0){
					$sql = "INSERT INTO ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."'";
					$this->member_set->query($sql);
				}
			}else{
				$sql = "UPDATE ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."' WHERE  userid='".$loguser[0]['userid']."'";
				$this->member_set->query($sql);
			}
			
			
        
			
			$this->member_set->add($newmember);
			$added[]=$newmember->get_data('username');

			$passwordlog = new passwordlog();
			$passwordlog->set_data('uid', mysql_insert_id());
			$passwordlog->set_data('password', md5($password1));
			$passwordlog->set_data('time', time());
			$this->passwordlog_set->add($passwordlog);
			//记录日志
			$adminlog = new admin_log();
			$adminlog->set_data('luser', $newmember->get_data('username'));
			$adminlog->set_data('action', language('添加运维用户'));
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('type', 11);
			$this->admin_log_set->add($adminlog);		
			
			$aduserlog = new aduser_log();
			$aduserlog->set_data('username', $newmember->get_data('username'));
			$aduserlog->set_data('ldap', implode('/', unserialize($distinguishedname)));
			$aduserlog->set_data('action', '创建');
			$aduserlog->set_data('configid', $config['id']);
			$aduserlog->set_data('configname', '前台手工导入');
			$aduserlog->set_data('ip', $addr_port[0]);
			$this->aduser_log_set->add($aduserlog);	
		}
		if($ldapauth){
			exec('sudo  /opt/freesvr/audit/sbin/manageprocess.pl freesvr-authd stop');
			exec('sudo  /opt/freesvr/audit/sbin/manageprocess.pl freesvr-authd start');
		}
		if($added || $modified){
			$this->server_set->query("call upgroups(".$_SESSION['ADMIN_UID'].")");
			echo '<script>window.opener.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=ldap&'.time().'"</script>';
		
			if(empty($error)){
				$msg = '全部操作成功';
			}else{
				if($added){
					$msg = '成功添加用户:'.implode(',',$added).'\n';
				}
				if($modified){
					$msg .= '成功修改用户:'.implode(',',$modified).'\n';
				}
				if($error){
					$msg .= '\n添加失败的用户:\n'.implode('\n',$error).'\n';
				}
			}
			alert_and_back($msg);
		}else{
			if($error)
			alert_and_back('添加失败:\n'.(is_array($error) ? implode('\n',$error) : '').'\n');
		}
	}

	function ldapimportconfig(){
		global $_CONFIG;
		$id = get_request('id');		
		$adserverindex = get_request('adserverindex');		
		$configs = $this->adimportconfig_set->select_all("ldap=1", "title", "asc");
		$config = $configs[0];
		if($id){
			$config = $this->adimportconfig_set->select_by_id($id);
		}
		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$pwdconfig = unserialize($setting[0]['svalue']);
		$adservers = $pwdconfig['ldapconfig'];
		$this->assign("adservers", $adservers);
		$this->assign("configs", $configs);
		$this->assign("adconfig", $config);
		$this->assign("adserverindex", $adserverindex);
		$this->display("ldapimportconfig.tpl");
	}

	function ldapimportconfig_save(){
		global $_CONFIG;
		$id = get_request('id');	
		$title = get_request('title',1,1);
		$ip = get_request('ip',1,1);
		$adusername = get_request('adusername',1,1);
		$adpassword = get_request('adpassword',1,1);
		$readpassword = get_request('readpassword',1,1);
		$aduserpwd = get_request('aduserpwd',1,1);
		$readuserpwd = get_request('readuserpwd',1,1);
		$path = get_request('path',1,1);
		$filteruser = get_request('filteruser',1,1);
		$filterusergroup = get_request('filterusergroup',1,1);
		if(empty($title)){
			alert_and_back('请填写名称');
			exit;
		}
		if(empty($ip)){
			alert_and_back('请选择IP');
			exit;
		}
		if(empty($path)){
			alert_and_back('请选择路径');
			exit;
		}
		if(empty($adpassword)){
			alert_and_back('请输入AD密码');
			exit;
		}
		if(empty($aduserpwd)){
			alert_and_back('请输入AD用户密码');
			exit;
		}
		if($aduserpwd!=$readuserpwd){
			alert_and_back('两次输入的AD用户密码不一致');
			exit;
		}
		if(!empty($aduserpwd)){			
			$config = $this->setting_set->select_all(" sname='password_policy'");
			$pwdconfig = unserialize($config[0]['svalue']);
			$reg = '';			
			$pwdmsg = '';
			$pwdmsgl = null;
			$pwdmsg2 = null;
			$pwdmsgn = null;
			if($pwdconfig['repeatnumber']>0){
				$pwdrepeatc = array();
				for($ci=0; $ci<strlen($aduserpwd); $ci++){
					if(empty($pwdrepeatc[$aduserpwd[$ci]])) 
						$pwdrepeatc[$aduserpwd[$ci]]=1;
					elseif($pwdrepeatc[$aduserpwd[$ci]]>=$pwdconfig['repeatnumber']){
						$pwdmsg3 .= '密码中重复字符数不能超过'.$pwdconfig['repeatnumber']."\\n";
						break;
					}else{
						$pwdrepeatc[$aduserpwd[$ci]]++;
					}
				}
			}
			if(intval($pwdconfig['pwdstrong1'])>preg_match_all('/[0-9]/', $aduserpwd, $matches)){
				//alert_and_back('密码中需要包含数字');
				//exit;
				$pwdmsg .= '数字'." ";
			}
			if(intval($pwdconfig['pwdstrong2'])>preg_match_all('/[a-z]/', $aduserpwd, $matches)){
				//alert_and_back('密码中需要包含小写字母');
				//exit;
				$pwdmsg .= '小写字母'." ";
			}
			if(intval($pwdconfig['pwdstrong3'])>preg_match_all('/[A-Z]/', $aduserpwd, $matches)){
				//alert_and_back('密码中需要包含小写字母');
				//exit;
				$pwdmsg .= '大写字母'." ";
			}
			$pwd_replace = preg_replace('/[0-9a-zA-Z]/','', $aduserpwd);
			if(intval($pwdconfig['pwdstrong4'])>strlen($pwd_replace)){
				//alert_and_back('密码中需要包含特殊字符');
				//exit;
				$pwdmsg .= '特殊字符'." ";
			}
			
			if(strlen($aduserpwd) < $pwdconfig['login_pwd_length']){
				$pwdmsgl = language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 '.',';
			}

			
			$pwd_ban_word_arr = explode('1', str_replace(' ', '空格', $_CONFIG['PASSWORD_BAN_WORD']));			
			if($pwd_ban_word_arr){
				$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
			}			
			if(!empty($pwd_ban_word_arr[0]))
			for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
				if(strpos($aduserpwd, $pwd_ban_word_arr[$pi])!==false){
					$pwdmsg2='密码中不能包含以下字符:'.addslashes($pwd_ban_word_str).'';
					break;
				}
			}
			$pwdmsgs=null;
			if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2) || !empty($pwdmsg3)){
				$pwdmsgs .= $pwdmsg3;
				if($pwdconfig['pwdstrong1'] || $pwdconfig['pwdstrong2'] || $pwdconfig['pwdstrong3'] || $pwdconfig['pwdstrong4']){
					$pwdmsgs .= '密码中需要包含:' .  ($pwdconfig['pwdstrong1'] ? $pwdconfig['pwdstrong1'].'个数字' : '').($pwdconfig['pwdstrong2'] ? $pwdconfig['pwdstrong2'].'个小写字母' : '').($pwdconfig['pwdstrong3'] ? $pwdconfig['pwdstrong3'].'个大写字母' : '').($pwdconfig['pwdstrong4'] ? $pwdconfig['pwdstrong4'].'个特殊字符' : ''). "\\n";
				}
				$pwdmsgs .= language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 ';
				if(count($pwd_ban_word_str)>0){
					$pwdmsgs .= '密码中不能包含以下字符:'.addslashes($pwd_ban_word_str);
				}
				//$error[]=$username.':'.$pwdmsgs.'\n';
				alert_and_back($pwdmsgs);
				exit;
			}
		}

		$adimportconfig = new adimportconfig();
		$adimportconfig->set_data("ldap", 1);
		$adimportconfig->set_data("title", $title);
		$adimportconfig->set_data("server", $ip);
		$adimportconfig->set_data("adusername", $adusername);
		$adimportconfig->set_data("adpassword", $adpassword);
		$adimportconfig->set_data("aduserpwd", $aduserpwd);
		$adimportconfig->set_data("path", $path);
		$adimportconfig->set_data("filteruser", $filteruser);
		$adimportconfig->set_data("filterusergroup", $filterusergroup);
		if($id){
			$adimportconfig->set_data("id", $id);
			$this->adimportconfig_set->edit($adimportconfig);
		}else{
			$this->adimportconfig_set->add($adimportconfig);
			$id = mysql_insert_id();
		}
		if(get_request('submit',1,1)=='同步'){
			$this->synchronization_ldap_users($id);
		}
	    alert_and_back('操作成功','admin.php?controller=admin_config&action=ldimportconfig&id='.$id);
	}

	function synchronization_ldap_users($id=null){
		global $_CONFIG;
		if(empty($id)){
			$id = get_request('id');
		}
		$config = $this->adimportconfig_set->select_by_id($id);	
		if(empty($config)){			
			alert_and_back('没有相应的规则:'.$id);
			exit;
		}
		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$pwdconfig = unserialize($setting[0]['svalue']);
		$adservers = $pwdconfig['ldapconfig'];
		for($i=0; $i<count($adservers); $i++){
			if($adservers[$i]['address']==$config['server']){
				$adserver = $adservers[$i];
				break;
			}
		}
		if(empty($adserver)){
			alert_and_back('AD服务器信息丢失，请检查');
			exit;
		}
		$ldapaddress = $adserver['address'];
		$ldapport = $adserver['port'];
		$basedn = $config['path'];
		$adusername = $config['adusername'];
		$adpassword = $config['adpassword']; 
		$ldapconn = @ldap_connect($ldapaddress, $ldapport);			 
		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
		ldap_set_option($ldapconn, LDAP_OPT_SIZELIMIT, 100000);
		
		if (!$ldapconn) {
			echo '连接失败';
			exit;
		}
		$ldapbind = @ldap_bind($ldapconn, $adusername, $adpassword);
		if(!$ldapbind){
			echo '用户名密码错误';
			exit;
		}

		$allusers = array();
		$pathlen = strlen($config['path']);
		$filter = "(&(objectClass=person))";
		$fields = array("uid","cn","sn","dn","name","mail","samaccountname","displayname");
		$sr = @ldap_search($ldapconn, $basedn, $filter, $fields,0,0);
		$info = @ldap_get_entries($ldapconn, $sr);
		$allusers = array();
		//echo '<pre>';var_dump($info);echo '</pre>';exit;
		for($i=0; $i<$info['count']; $i++)
		{
			$distinguishedname=trim($info[$i]['dn']);//var_dump($distinguishedname);
			if($_CONFIG['DB_DEBUG']){
				var_dump($distinguishedname);
			}
			$distinguishedname = substr($distinguishedname,strpos($distinguishedname,',')+1);
			$dnlen = strlen($distinguishedname);
			if($dnlen>=$pathlen&&strtolower(substr($distinguishedname,$dnlen-$pathlen))==strtolower($config['path'])){
				$allusers[]=$info[$i]['uid'][0];
			}
		}
		if($_CONFIG['DB_DEBUG']){
			var_dump($allusers);
		}
		$addeltegroup = $this->sgroup_set->select_all("lower(groupname)='ad_delete'");
		$addeltegroupid = $addeltegroup[0]['id'];
		if(empty($addeltegroup)){
			$newsgroup = new sgroup();
			$newsgroup->set_data('groupname', strtoupper('ad_delete'));
			$newsgroup->set_data('count', 0);
			$newsgroup->set_data('ldapid', 0);
			$newsgroup->set_data('child', '');
			$this->sgroup_set->add($newsgroup);
			$addeltegroupid = mysql_insert_id();
			$newsgroup = null;
			$newsgroup = new sgroup();
			$newsgroup->set_data('child', $addeltegroupid);
			$newsgroup->set_data('id', $addeltegroupid);
			$this->sgroup_set->edit($newsgroup);
		}
		if($allusers){

			//$this->member_set->query("UPDATE ".$this->member_set->get_table_name()." SET enable=0 where username NOT IN('".implode("','", $allusers)."') AND (adou!='' or adou is not null) and level=0");		
			$disabledusers = $this->member_set->select_all("adou!='' and level=0 and enable=1 and username NOT IN('".implode("','", $allusers)."')");
			for($i=0; $i<count($disabledusers); $i++){
				$m = new member();
				$m->set_data('uid', $disabledusers[$i]['uid']);
				$m->set_data('enable', 0);
				$m->set_data('groupid', $addeltegroupid);
				$this->member_set->edit($m);
				//记录日志
				$adminlog = new admin_log();
				$adminlog->set_data('luser', $disabledusers[$i]['username']);
				$adminlog->set_data('action', language('禁用运维用户'));
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('type', 11);
				$this->admin_log_set->add($adminlog);

				$aduserlog = new aduser_log();
				$aduserlog->set_data('username', $disabledusers[$i]['username']);
				if(unserialize($disabledusers[$i]['adou']))
				$aduserlog->set_data('ad', '/'.implode('/', unserialize($disabledusers[$i]['adou'])));
				$aduserlog->set_data('ldap', 'ad_delete');
				$aduserlog->set_data('action', '删除');
				$aduserlog->set_data('configid', $config['id']);
				$aduserlog->set_data('configname', $config['title']);
				$aduserlog->set_data('ip', $config['server']);
				$this->aduser_log_set->add($aduserlog);
				$disabled[]=$disabledusers[$i]['username'];
			}
		}

		$password=$config['aduserpwd'];
		$confirm_password = $password;	
		$groupid = 0;
		for($i=0; $i<count($allusers); $i++){			
			$newmember = new member();
			$username = $allusers[$i];
			$level = 0;
			if(empty($username)){
				continue;
			}
			if(preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $level)||preg_match("/[\\r\\n]/", $password)||preg_match("/[\\r\\n]/", $confirm_password)||preg_match("/[\\r\\n]/", $mobilenum)||preg_match("/[\\r\\n]/", $company)||preg_match("/[\\r\\n]/", $email)||preg_match("/[\\r\\n]/", $realname)||preg_match("/[\\r\\n]/", $vpn)||preg_match("/[\\r\\n]/", $vpnip)||preg_match("/[\\r\\n]/", $usbkey)){
				$error[]=$username.':'.'用户信息中含有回车符'.'\n';
				continue;
			}
			$vpnipexist = $this->member_set->select_all("vpnip='".$vpnip."' and username!='$username'");
			if($network['server1']==$vpnip&&count($vpnipexist)==0){
				$vpnip = $vpnip;
			}else{
				$vnpip = $oldmember['vpnip'];
			}
			
			$newmember->set_data('allowchange',0);
			$newmember->set_data('start_time', date('Y-m-d H:i:s'));
			$newmember->set_data('end_time', '2037:1:1 0:0:0');
			$newmember->set_data('password', $this->member_set->udf_encrypt($password));
			$newmember->set_data('ldapauth', 1);
			$newmember->set_data('enable', 1);
			$newmember->set_data('groupid', 0);
			if(!preg_match('/^[a-zA-Z_]+[a-zA-Z._\-0-9@]*$/', $username)){
				$error[]=$username.':'.'用户名以字母和下划线开头包含大小写字母、数字、下划线、小数点'.'\n';
				continue;
			}
			$newmember->set_data('username', $username);
			$filter = "|(cn=".$username.")(uid=".$username.")(sn=".$username.")";
			$filter = "(&(objectClass=person)({$filter}))";
	        $fields = array("cn","samaccountname","mail","memberof","department","displayname","telephonenumber","primarygroupid","objectsid","objectsid"); 

	        $sr = @ldap_search($ldapconn, $basedn, $filter, $fields,0,0);
	        $u = @ldap_get_entries($ldapconn, $sr);
			$newmember->set_data('realname', $u[0]['cn'][0]);
			$newmember->set_data('workcompany', $u[0]['department'][0]);
			$newmember->set_data('level', $level);
			if($_SESSION['ADMIN_LEVEL']==3){
				$newmember->set_data("level", 0);
				$newmember->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
			}
			/*只有普通用户才有Radius用户,系统用户和密码托管用户*/
			//if($newmember->get_data('level') == 0) {
			$new_radius = new radius();	
			$new_radius->set_data("UserName",$newmember->get_data('username'));
			$new_radius->set_data("Attribute",'Crypt-Password');
			$new_radius->set_data("email",$newmember->get_data('email'));
			
			$new_radius->set_data("Value",crypt($this->member_set->udf_decrypt($newmember->get_data('password')),"\$1\$qY9g/6K4"));
			//var_dump($this->member_set->udf_decrypt($newmember->get_data('password')));exit;
			
	        $distinguishedname = $u[0]['dn'];
			$newmember->set_data('adou', $distinguishedname);
	        $distinguishedname = explode(',', $distinguishedname);
			array_shift($distinguishedname);
			$distinguishedname = array_reverse($distinguishedname);
			$head_str = "";
			$p = 0;
			for($j=0; $j<count($distinguishedname); $j++){
				$head_array = explode('=', $distinguishedname[$j]);
				if(strtolower($head_array[0])=='dc'){
					$head_str=$head_array[1].".".$head_str;
					$p++;
					continue;
				}
				$distinguishedname[$j]=$head_array[1];
			}
			$distinguishedname[$p-1]=substr($head_str, 0, strlen($head_str)-1);
			for($j=0; $j<$p-1; $j++){
				array_shift($distinguishedname);
			}
			$groupparentid=0;//var_dump($distinguishedname);
			for($j=0; $j<count($distinguishedname); $j++){
				$_group = $distinguishedname[$j];
				$where = null;
				if(!empty($groupparentid)){
					$where .= " AND ldapid=".$groupparentid." ";
				}
				$__group = $this->sgroup_set->select_all("groupname='".$_group."'".$where);
				if(empty($__group)){
					$newsgroup = new sgroup();
					$newsgroup->set_data('groupname', $_group);
					$newsgroup->set_data('count', 0);
					$newsgroup->set_data('ldapid', $groupparentid);
					$newsgroup->set_data('child', '');
					$this->sgroup_set->add($newsgroup);
					$groupid = mysql_insert_id();
					$newsgroup = null;
					$newsgroup = new sgroup();
					$newsgroup->set_data('child', $groupid);
					$newsgroup->set_data('id', $id);
					$this->sgroup_set->edit($newsgroup);
				}
				$__group = $this->sgroup_set->select_all("groupname='".$_group."'".$where);
				$groupid=$groupparentid = $__group[0]['id'];
			}
			$newmember->set_data("groupid", $groupid);
			//$_group = $distinguishedname[count($distinguishedname)-1];
			/*
			$__group = $this->sgroup_set->select_all("groupname='".$_group."'");
			if($__group){
				$newmember->set_data("groupid", $__group[0]['id']);
			}else{
				$newsgroup = new sgroup();
				$newsgroup->set_data('groupname', $_group);
				$newsgroup->set_data('count', 0);
				$newsgroup->set_data('child', '');
				$this->sgroup_set->add($newsgroup);
				$newmember->set_data("groupid", mysql_insert_id());
			}*/
			if($_SESSION['ADMIN_LEVEL']==3){
				$newmember->set_data("level", 0);
				$newmember->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
			}
			$distinguishedname = serialize($distinguishedname);
			
			if(($user=$this->member_set->select_all("username = '" . $newmember->get_data('username') . "' or realname= '" . $newmember->get_data('username') . "'")) != NULL){
				//$error[]=$username.':帐户已经存在\n';
				if($user[0]['adou']!=$newmember->get_data('adou')){					
					$newmember->set_data('adou', $user[0]['adou']);			
					//$newmember->set_data('groupid', $user[0]['groupid']);
					//记录日志
					$adminlog = new admin_log();
					$adminlog->set_data('luser', $user[0]['username']);
					$adminlog->set_data('action', language('AD用户添加出现OU不一致'));
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
					$this->admin_log_set->add($adminlog);
				}
				if($user[0]['groupid']!=$groupid){
					$agroup=$this->sgroup_set->select_by_id($user[0]['groupid']);
					$ogroup = $agroup['groupname'];
					while($agroup['ldapid']){
						$agroup=$this->sgroup_set->select_by_id($agroup['ldapid']);
						$ogroup = $agroup['groupname'].'/'.$ogroup;
					}
					$aduserlog = new aduser_log();
					$aduserlog->set_data('username', $user[0]['username']);
					$aduserlog->set_data('ad', implode('/', unserialize($distinguishedname)));
					$aduserlog->set_data('ldap', $ogroup);
					$aduserlog->set_data('action', '移动');
					$aduserlog->set_data('configid', $config['id']);
					$aduserlog->set_data('configname', $config['title']);
					$aduserlog->set_data('ip', $config['server']);
					$this->aduser_log_set->add($aduserlog);
				}
				$radiususer = $this->radius_set->select_all("UserName = '" . $newmember->get_data('username') . "'");
				$new_radius->set_data("id",$radiususer[0]['id']);
				$this->radius_set->edit($new_radius);
				$newmember->set_data('uid', $user[0]['uid']);
				$this->member_set->edit($newmember);
				$modified[]=$newmember->get_data('username');
				continue;
			}
			$this->radius_set->add($new_radius);

			$dbuser = $this->member_set->base_select("SELECT * FROM ".DBAUDIT_DBNAME.".member where username='".$newmember->get_data('username')."'");
			if(empty($dbuser)){
				if($db_priority>=0){
					$sql = "INSERT INTO ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',level='".$newmember->get_data('level')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."'";
					$this->member_set->query($sql);
					
				}
			}else{
				$sql = "UPDATE ".DBAUDIT_DBNAME.".member set username='".$newmember->get_data('username')."',password='".$newmember->get_data('password')."',realname='".$newmember->get_data('realname')."',email='".$newmember->get_data('email')."',usbkey='".$newmember->get_data('usbkey')."',default_control='".$newmember->get_data('default_control')."',common_user_pri='".$newmember->get_data('common_user_pri')."',start_time='".$newmember->get_data('start_time')."',end_time='".$newmember->get_data('limit_time')."',level='".$newmember->get_data('level')."' where uid = '".$dbuser[0]['uid']."'";
				$this->member_set->query($sql);
			}
			$loguser = $this->member_set->base_select("SELECT * FROM ".LOG_DBNAME.".log_user where username='".$newmember->get_data('username')."'");
			if(empty($loguser)){
				if($log_priority>=0){
					$sql = "INSERT INTO ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."'";
					$this->member_set->query($sql);
				}
			}else{
				$sql = "UPDATE ".LOG_DBNAME.".log_user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."' WHERE  userid='".$loguser[0]['userid']."'";
				$this->member_set->query($sql);
			}
			
			$this->member_set->add($newmember);
			$added[]=$newmember->get_data('username');

			$passwordlog = new passwordlog();
			$passwordlog->set_data('uid', mysql_insert_id());
			$passwordlog->set_data('password', md5($password1));
			$passwordlog->set_data('time', time());
			$this->passwordlog_set->add($passwordlog);
			
			$aduserlog = new aduser_log();
			$aduserlog->set_data('username', $newmember->get_data('username'));
			$aduserlog->set_data('ad', implode('/', unserialize($distinguishedname)));
			$aduserlog->set_data('ldap', implode('/', unserialize($distinguishedname)));
			$aduserlog->set_data('action', '创建');
			$aduserlog->set_data('configid', $config['id']);
			$aduserlog->set_data('configname', $config['title']);
			$aduserlog->set_data('ip', $config['server']);
			$this->aduser_log_set->add($aduserlog);
			//记录日志
			$adminlog = new admin_log();
			$adminlog->set_data('luser', $newmember->get_data('username'));
			$adminlog->set_data('action', language('添加运维用户'));
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('type', 11);
			$this->admin_log_set->add($adminlog);			
		}
		if($added || $modified || $disabled){
			$this->server_set->query("call upgroups(".$_SESSION['ADMIN_UID'].")");
			echo '<script>window.opener.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=ldap&'.time().'"</script>';
		
			if(empty($error)&&!($modified || $disabled)){
				$msg = '全部操作成功';
			}else{
				if($added){
					$msg = '成功添加用户:'.implode(',',$added).'\n';
				}
				if($modified){
					$msg .= '成功修改用户:'.implode(',',$modified).'\n';
				}
				if($disabled){
					$msg .= '成功禁用用户:'.implode(',',$disabled).'\n';
				}
				if($error){
					$msg .= '\n添加失败的用户:\n'.implode('\n',$error).'\n';
				}
			}
			alert_and_back($msg);
		}else{
			alert_and_back('添加失败:\n'.(is_array($error) ? implode('\n',$error) : '').'\n');
		}

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	function notice() {
		global $_CONFIG;
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'a.id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		$where = '1=1';
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				//$where .= " AND appserverip IN ('".implode("','", $alltmpip)."')";
			}
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION['QUERY_STRING']);
		$sql = "";
		$row_num = $this->notice_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql = "SELECT a.*,group_concat(distinct servergroup.groupname order by convert(servergroup.groupname using gbk) ASC) gname,group_concat(distinct member.username order by member.username asc) uname FROM ".$this->notice_set->get_table_name()." a LEFT JOIN servergroup ON LOCATE(concat(',',servergroup.id,','),a.groups)  LEFT JOIN member ON LOCATE(concat(',',member.uid,','),a.members) group by a.id ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$notices = $this->notice_set->base_select($sql);
		//$notices = $this->notice_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);		
		
		$this->assign('notices',$notices);
		$this->assign('appcount',count($notices));	
		$this->display('notice.tpl');	
	}

	function notice_edit(){
		global $_CONFIG;
		$id = get_request('id');
		$groupid=$g_id = get_request('g_id',0,1);
		$webuser = get_request('webuser',0,1);
		$webgroup = get_request('webgroup',0,1);	
		require_once('./include/select_sgroup_ajax.inc.php');
		$noticeinfo = $this->notice_set->select_by_id($id);
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$wheremember = ' AND groupid IN('.$_tmpgid['child'].')';
			$wheregroup = ' AND id IN('.$_tmpgid['child'].')';
		}
		$allmem = $this->member_set->select_all(" level!=11 ".(empty($webuser) ? '' : " AND username like '%$webuser%' " )." ".$wheremember." AND uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''),'username','ASC');
		$usergroup = $this->usergroup_set->select_all((empty($webgroup) ? '' : " groupname like '%$webgroup%' AND " ).'(select count(0) FROM '.$this->member_set->get_table_name().' where groupid='.$this->usergroup_set->get_table_name().'.id) >0 AND level=0 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : '').$wheregroup,'GroupName', 'ASC');		
		
		if(!$noticeinfo['all']){
			$groups = explode(',', substr($noticeinfo['groups'], 1, strlen($noticeinfo['groups'])-2));			
			$members = explode(',', substr($noticeinfo['members'], 1, strlen($noticeinfo['members'])-2));

			if($groups)
			for($i=0; $i<count($usergroup); $i++){
				if(in_array($usergroup[$i]['id'], $groups)){
					$usergroup[$i]['check']='checked';
				}
			}
			if($members)
			for($i=0; $i<count($allmem); $i++){
				if(in_array($allmem[$i]['uid'], $members)){
					$allmem[$i]['check']='checked';
				}
			}
		}
		$this->assign('usergroup', $usergroup);
		$this->assign('allmem',$allmem);
		$this->assign('noticeinfo',$noticeinfo);
		$this->display("notice_edit.tpl");
	}

	function notice_save(){		
		global $_CONFIG;
		$page_num = get_request('page');
		$id = get_request('id');
		$content = get_request('content', 1, 1);
		$expiretime = get_request('expiretime', 1, 1);
		$all = get_request('all', 1, 0);
		$enable = get_request('enable', 1, 0);
		$notice = new notice();
		$notice->set_data('content', $content);
		$notice->set_data('expiretime', $expiretime);
		$notice->set_data('all', $all);
		$notice->set_data('enable', $enable);
		$notice->set_data('groups', ','.($_POST['Group'] ? implode(',', $_POST['Group']) : '').',');
		$notice->set_data('members', ','.($_POST['Check'] ? implode(',', $_POST['Check']) : '').',');
		if($id){
			$notice->set_data('id', $id);
			$this->notice_set->edit($notice);
		}else{
			$this->notice_set->add($notice);
		}
		alert_and_back('操作成功', 'admin.php?controller=admin_config&action=notice');
	}

	function notice_del(){
		$id = get_request('id');
		if(empty($id)){
			$id = $_POST['chk_member'];
		}
		$this->notice_set->delete($id);
		alert_and_back('操作成功');
	}

	function certs(){
		$filename = '/etc/pki/tls/sec.cnf';
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
				if(strstr($lines[$ii], " alt_names "))
				{
					$found = 1;
				}elseif($found&&substr(trim($lines[$ii]), 0, 1)=='[')
				{
					break;
				}
				if($found){
					$tmp = explode('=', $lines[$ii]);
					if(count($tmp)==2){
						if(substr(trim($lines[$ii]), 0, 3)=='IP.'){
							$ip[]=trim($tmp[1]);
						}elseif($found&&substr(trim($lines[$ii]), 0, 4)=='DNS.'){
							$dns[]=trim($tmp[1]);
						}
					}
				}
			}
		}
		$Certificate = $this->setting_set->select_all("sname='Certificate'");
		$Certificate = $Certificate[0]['svalue'];
		$this->assign("ip", $ip);
		$this->assign("dns", $dns);
		$this->assign("Certificate", $Certificate);
		$this->display('certs.tpl');
	}

	function certs_edit(){
		$filename = '/etc/pki/tls/sec.cnf';
		$lines = @file($filename);
		$ip = urldecode(get_request('ip', 0, 1));
		$dns = urldecode(get_request('dns', 0, 1));
		if($ip){
			$this->assign("ip", $ip);
		}elseif($dns){
			$this->assign("dns", $dns);
		}
		$this->display('certs_edit.tpl');
	}

	function certs_save(){
		$oldip = get_request('oldip', 1, 1);
		$olddns = get_request('olddns', 1, 1);
		$_ip = get_request('ip', 1, 1);
		$type = get_request('type', 1, 0);
		$filename = '/etc/pki/tls/sec.cnf';
		$lines = @file($filename);

		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], " alt_names "))
				{
					$lines_before[] = $lines[$ii];
					$found = 1;
					continue;
				}elseif($found&&substr(trim($lines[$ii]), 0, 1)=='[')
				{
					$found = 2;
				}
				if($found==1){
					$tmp = explode('=', $lines[$ii]);
					if(count($tmp)==2){
						if(substr(trim($lines[$ii]), 0, 3)=='IP.'){
							if($oldip==trim($tmp[1]))
								$ip[]=$_ip;
							else
								$ip[]=$tmp[1];
						}elseif($found&&substr(trim($lines[$ii]), 0, 4)=='DNS.'){
							if($olddns==trim($tmp[1]))
								$dns[]=$_ip;
							else
								$dns[]=$tmp[1];
						}
					}else{
						$lines_after[] = $lines[$ii];
					}
				}elseif($found==2){
					$lines_after[] = $lines[$ii];
				}else{
					$lines_before[] = $lines[$ii];
				}
			}
		}
		if(empty($oldip)&&empty($olddns)){
			if($type==0){
				$ip[]=$_ip;
			}else
				$dns[]=$_ip;
		}
		$_lines = array();
		for($i=0; $i<count($lines_before); $i++){
			$_lines[]=$lines_before[$i];
		}

		for($i=0; $i<count($ip); $i++){
			$_lines[]="IP.".($i+1)."=".$ip[$i]."\n";
		}
		for($i=0; $i<count($dns); $i++){
			$_lines[]="DNS.".($i+1)."=".$dns[$i]."\n";
		}
		for($i=0; $i<count($lines_after); $i++){
			$_lines[]=$lines_after[$i];
		}
		//echo '<pre>';var_dump($_lines);echo '</pre>';
		$this->Array2File($_lines, $filename);
		alert_and_back('操作成功', 'admin.php?controller=admin_config&action=certs');
	}

	function certs_del(){
		$_ip = get_request('ip', 0, 1);
		$_dns = get_request('dns', 0, 1);
		$filename = '/etc/pki/tls/sec.cnf';
		$lines = @file($filename);

		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], " alt_names "))
				{
					$found = 1;
					continue;
				}elseif($found&&substr(trim($lines[$ii]), 0, 1)=='[')
				{
					$found = 2;
				}
				if($found==1){
					$tmp = explode('=', $lines[$ii]);
					if(count($tmp)==2){
						if(substr(trim($lines[$ii]), 0, 3)=='IP.'){
							if($_ip==trim($tmp[1]))
								$lines[$ii]="";
						}elseif($found&&substr(trim($lines[$ii]), 0, 4)=='DNS.'){
							if($_dns==trim($tmp[1]))
								$lines[$ii]="";
						}
					}
				}
			}
		}
		//echo '<pre>';var_dump($lines);echo '</pre>';
		$this->Array2File($lines, $filename);
		alert_and_back('操作成功', 'admin.php?controller=admin_config&action=certs');
	}

	function certsreset(){

		exec('sudo /usr/bin/python /opt/freesvr/audit/bin/openssl_CA.py');
		//echo "sudo /home/wuxiaolong/CACreate/ca.pl gongyouzhengshu@".$eth0[0]." 12345678";
		system("sudo /home/wuxiaolong/CACreate/ca.pl gongyouzhengshu@".$eth0[0]." 12345678");
		exec('sudo /usr/bin/cp /opt/freesvr/web/CA/gongyouzhengshu.pfx /opt/freesvr/audit/softdown/gongyouzhengshu.pfx');
		//unlink(filename)
		//alert_and_back('操作成功', 'admin.php?controller=admin_config&action=certs');
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
	     alert_and_back('写入文件失败,请检查文件权限');
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
