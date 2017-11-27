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
		$times = get_request('login_times',1,1);
		$login_times_last = get_request('login_times_last',1,0);
		$length = get_request('login_pwd_length',1,1);
		$logintimeout = get_request('logintimeout',1,1);
		$oldpassnumber = get_request('oldpassnumber',1,1);
		$pwdautolength = get_request('pwdautolength',1,1);
		$pwdstrong1 = get_request('pwdstrong1',1,1);
		$pwdstrong2 = get_request('pwdstrong2',1,1);
		$pwdstrong3 = get_request('pwdstrong3',1,1);
		$pwdstrong4 = get_request('pwdstrong4',1,1);
		$pwdexpired = get_request('pwdexpired',1,1);
		$pwdahead = get_request('pwdahead',1,1);
		$onlinecountmax = get_request('onlinecountmax',1,1);

		$filename = $_CONFIG['FREESVR_UDF'];
		$encrypt = get_request('encrypt',1,1);
		$encrypt2 = get_request('encrypt2',1,1);
		$debug = get_request('debug',1,1);
		$nr_minute = get_request('nr_minute',1,1);
		
		
		
		
		if(!is_numeric($logintimeout)){
			alert_and_back('时间请输入数字');
			exit;
		}
		if(!is_numeric($times)|| $times <1 ){
			alert_and_back("次数输入不正确");
			exit;
		}
		if(!is_numeric($login_times_last)|| $login_times_last <1 ){
			alert_and_back("错误锁定时间输入不正确");
			exit;
		}
		if(!is_numeric($length) || ($length <1 )  ){
			alert_and_back("密码最小长度 输入不正确");
			exit;
		}
		if(!is_numeric($pwdautolength)){
			alert_and_back('自动长度请输入数字');
			exit;
		}
		if(!is_numeric($pwdexpired)){
			alert_and_back('密码有效期请输入数字');
			exit;
		}
		if(!is_numeric($pwdahead)){
			alert_and_back('提前天数请输入数字');
			exit;
		}
		if(!is_numeric($onlinecountmax)){
			alert_and_back('同时现在数量请输入数字');
			exit;
		}
		$pwd['login_times']=$times;$pwd['login_times_last']=$login_times_last;$pwd['login_pwd_length']=$length;$pwd['logintimeout']=$logintimeout;$pwd['pwdautolength']=$pwdautolength;
		$pwd['pwdstrong1']=$pwdstrong1;$pwd['pwdstrong2']=$pwdstrong2;$pwd['pwdstrong3']=$pwdstrong3;$pwd['pwdstrong4']=$pwdstrong4;
		$pwd['pwdexpired']=$pwdexpired;$pwd['pwdahead']=$pwdahead;$pwd['onlinecountmax']=$onlinecountmax;$pwd['oldpassnumber']=$oldpassnumber;
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
				$this->setting_set->query("UPDATE member set `password`=udf_decrypt(`password`)");
				$this->setting_set->query("UPDATE devices set `cur_password`=udf_decrypt(`cur_password`), `old_password`=udf_decrypt(`old_password`)");
			}
		}
		$this->Array2File($lines,$filename);
		if($encrypt!=$encrypt2){
			if($encrypt=='yes'){
				$this->setting_set->query("UPDATE member set `password`=udf_encrypt(`password`)");
				$this->setting_set->query("UPDATE devices set `cur_password`=udf_encrypt(`cur_password`), `old_password`=udf_encrypt(`old_password`)");
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
		$page_num = get_request('page');
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

		$where = '1=1';
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION['QUERY_STRING']);
		if($_SESSION['ADMIN_LEVEL']==3){
			$where .= " AND appserverip IN(SELECT device_ip FROM ".$this->server_set->get_table_name()." WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP']."))";
		}
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
			exec("sudo /etc/init.d/iptables restart");
			if($newappserver->get_errnum() == 0) {
				if(empty($id)){
					$this->appserver_set->add($newappserver);	
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
		$this->assign("p", $p);
		$this->display('appserver_edit.tpl');	
	}
	
	function apppub_list() {
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

		$where = "appserverip='".$appserverip."'";
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION['QUERY_STRING']);
		$row_num = $this->apppub_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		//$ips = $this->apppub_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$ips = $this->apppub_set->base_select("SELECT a.*,b.device_ip,b.username FROM apppub a LEFT JOIN appdevices b ON a.id=b.apppubid WHERE b.id IS NOT NULL AND $where ORDER BY $orderby1 $orderby2  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		
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
		$appserverip = get_request('appserverip', 0, 1);
		$id = get_request("id", 0, 1);
		$name = get_request("name", 1, 1);
		$path = get_request("path", 1, 1);
		$url = get_request("url", 1, 1);
		$autologinflag = get_request("autologinflag", 1, 1);
		$description = get_request("description", 1, 1);
		if(empty($name) || empty($path)) {
			alert_and_back("请输入名称和路径", "admin.php?controller=admin_config&action=apppub_list");
			exit();		
		}
		
		else {
			$appprogram = $this->appprogram_set->select_by_id($autologinflag);
			$newapppub = new apppub();
			$newapppub->set_data('name',$name);
			$newapppub->set_data('appserverip',$appserverip);
			$newapppub->set_data('path',$path);
			$newapppub->set_data('appprogramname',$appprogram['name']);
			$newapppub->set_data('description',$description);	
			$newapppub->set_data('autologinflag',$appprogram['autologin']);
			$newapppub->set_data('url',$url);	
		
			if($newapppub->get_errnum() == 0) {
				if(empty($id)){
					$this->apppub_set->add($newapppub);
					$this->appdevice_save(mysql_insert_id());
					//alert_and_back("添加成功", "admin.php?controller=admin_config&action=apppub_list&ip=$appserverip");	
					exit();	
				}else{
					$newapppub->set_data('id',$id);
					$this->apppub_set->edit($newapppub);	
					$this->appdevice_save($id);
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
		if($id)
		$users=$this->appdevice_set->select_count('apppubid IN('.implode(',',$id).')');
		if($users>0){
			//alert_and_back('该应用已经绑定用户,请先删除用户');
			//exit;
		}
		if($id)
		$this->appresgroup_set->delete_all(' appdevicesid IN (SELECT id FROM appdevices WHERE apppubid IN ('.implode(',',$id).'))');
		$this->luser_appresourcegrp_set->delete_all(" appresourceid NOT IN (SELECT id FROM appresourcegroup )");
		$this->lgroup_appresourcegrp_set->delete_all(" appresourceid NOT IN (SELECT id FROM appresourcegroup )");
		$this->apppub_set->delete($id);
		$this->appdevice_delete($id);
		//alert_and_back('成功删除');
	}
	
	function apppub_edit() {
		global $_CONFIG;
		$appserverip = get_request('appserverip', 0, 1);
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$p = $this->apppub_set->select_by_id($id);
		//$allmem = $this->member_set->select_all('level = 0','username','ASC');
		$appprogram = $this->appprogram_set->select_all('1', 'name', 'asc');

		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)",'username','ASC');
		
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
		$this->appdevice_edit($appserverip, $id,$appdeviceid);
	}

	function apppubexport(){
		$ip = get_request('appserverip', 0, 1);
		$where = '1=1';
		if($ip){
			$where .= " AND appserverip='$ip'";
		}
		$result = $this->apppub_set->base_select("SELECT a.username,a.device_ip,udf_decrypt(a.cur_password) password,b.name,b.path,b.appprogramname,b.url,b.description FROM ".$this->appdevice_set->get_table_name()." a LEFT JOIN ".$this->apppub_set->get_table_name()." b ON a.apppubid=b.id WHERE $where");
		//$handle = @fopen('/tmp/member.xls', 'w');
		
		
		$str = language("应用名称").",";
		$str .= language("用户名").",";
		$str .= language("密码").",";
		$str .= language("服务器IP").",";
		$str .= language("程序名称").",";
		$str .= language("程序地址").",";
		$str .= language("URL").",";
		$str .= language("描述");
		$str .= "\n";
		$row = 1;
		for($i=0; $i<count($result); $i++){
			$str .= $result[$i]['name'].",".$result[$i]['username'].",".$result[$i]['password'].",".$result[$i]['device_ip'].",".$result[$i]['appprogramname'].",".$result[$i]['path'].",".$result[$i]['url'].",".$result[$i]['description']."\n";
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
		$appserverip = get_request('appserverip', 0, 1);
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
		for($i=1; $i<count($lines); $i++){
			if(trim($lines[$i])==""){
				continue;
			}
			$linearr = explode (",",trim($lines[$i]));
			if(empty($linearr[0])){
				continue;
			}
			if($this->apppub_set->select_count("name='".$linearr[0]."' AND appserverip='$appserverip'" ) > 0){
				$keyexists[]=$linearr[0]."\n";
				continue;
			}		
			$insertstr = "INSERT INTO ".$this->apppub_set->get_table_name()."(name,appserverip,appprogramname,path,url,description) values('$linearr[0]','$appserverip','$linearr[4]','$linearr[5]','$linearr[6]','$linearr[7]')";
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
		alert_and_back('导入成功', "admin.php?controller=admin_config&action=apppub_list&ip=$appserverip");
	}


	function appprogram_list() {
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
		$insertstr = "INSERT INTO ".$this->appprogram_set->get_table_name()."(name,path,autologin,description) values";
		for($i=1; $i<count($lines); $i++){
			if(trim($lines[$i])==""){
				continue;
			}

			$linearr = explode (",",trim($lines[$i]));
			if(empty($linearr[0])||empty($linearr[1])){
				continue;
			}
			if($this->appprogram_set->select_count("name='".$linearr[0]."'") > 0){
				$keyexists[]=$linearr[0]."\n";
				continue;
			}
			if($j!=0){
				$insertstr .=",";
			}
			$j++;
			$insertstr .= "('$linearr[0]','$linearr[1]','$linearr[2]','$linearr[3]')";
		}
		//echo $insertstr;var_dump($j);var_dump($keyexists);exit;
		if($j&&$this->usbkey_set->query($insertstr)){
			alert_and_back('导入成功', "admin.php?controller=admin_config&action=appprogram_list");
		}else{
			alert_and_back('导入失败,请检查文件, 重复的key:\n'.implode("", $keyexists));
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
			$appprogram->set_data('path',$path);
			$appprogram->set_data('autologin',$autologin);
			$appprogram->set_data('description',$description);	
			$appprogram->set_data('autologin',$autologin);
			$appprogram->set_data('icon',$icon);
		
			if($appprogram->get_errnum() == 0) {
				if(empty($id)){
					$this->appprogram_set->add($appprogram);
					alert_and_back("添加成功", "admin.php?controller=admin_config&action=appprogram_list&ip=$appserverip");	
					exit();	
				}else{
					$appprogram->set_data('id',$id);
					$this->appprogram_set->edit($appprogram);	
					alert_and_back("修改成功", "admin.php?controller=admin_config&action=appprogram_list&ip=$appserverip");	
					exit();
				}
			} 
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
		//$apppubid = intval(get_request('apppubid', 0, 1));
		//$serverip = get_request('serverip', 0, 1);
		//$appdeviceid = intval(get_request('id'));
		$sessionluser = 'APPPUBEDIT_LUSER';
		$sessionlgroup = 'APPPUBEDIT_LGROUP';
		unset($_SESSION[$sessionluser]);
		unset($_SESSION[$sessionlgroup]);
		if($appdeviceid){
			$_SESSION[$sessionluser] = $this->appmember_set->select_all('appdeviceid='.$appdeviceid);
			$_SESSION[$sessionlgroup] = $this->appgroup_set->select_all('appdeviceid='.$appdeviceid);
			$p = $this->appdevice_set->select_by_id($appdeviceid);
			$p['old_password'] = $this->member_set->udf_decrypt($p['old_password']);
			$p['cur_password'] = $this->member_set->udf_decrypt($p['cur_password']);
		}
		
		$allmem = $this->member_set->select_all("level!=11",'username','ASC');
		$usergroup = $this->usergroup_set->select_all('1=1','GroupName', 'ASC');
		
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
		$servers = $this->server_set->select_all('1', 'device_ip', 'asc');
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

	function appdevice_save($apppubid) {
		$appserverip = get_request('appserverip', 0, 1);
		$sessionluser = get_request('sessionluser', 1, 1);
		$device_ip = get_request('device_ip', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		//$id = get_request("id", 1, 0);
		//$apppubid = get_request("apppubid", 1, 1);
		$username = get_request("username", 1, 1);
		$password = get_request("password", 1, 1);
		$repassword = get_request("repassword", 1, 1);
		$oracle_auth = get_request("oracle_auth", 1, 1);
		$change_password = get_request("change_password", 1, 0);
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
			alert_and_back("两次输入的密码不一致");
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
			$newappdeviceid->set_data('oracle_name', $servers[0]['oracle_name']);
			$newappdeviceid->set_data('device_ip', empty($device_ip) ? '' : $device_ip);
		
			if($newappdeviceid->get_errnum() == 0) {
				if(empty($id)){
					$this->appdevice_set->add($newappdeviceid);
					$appdeviceidid = mysql_insert_id();
					for($i=0; $i<count($_POST['member']); $i++){
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
						$member = $this->member_set->select_by_id($_POST['member'][$i]);
						$adminlog = new admin_log();
						$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
						$adminlog->set_data('luser', $member['username']);
						$adminlog->set_data('action', language('绑定'));
						$adminlog->set_data('resource', $apppub['name']);
						$this->admin_log_set->add($adminlog);
						unset($adminlog);
					}
					for($i=0; $i<count($_POST['group']); $i++){
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

						$ugroup = $this->usergroup_set->select_by_id($_POST['group'][$i]);
						$adminlog = new admin_log();
						$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
						$adminlog->set_data('lgroup', $ugroup['groupname']);
						$adminlog->set_data('action', language('绑定'));
						$adminlog->set_data('resource',$apppub['name']);
						$this->admin_log_set->add($adminlog);
						unset($adminlog);
					}
					unset($_SESSION[$sessionluser]);
					unset($_SESSION[$sessionlgroup]);
					alert_and_back("添加成功", "admin.php?controller=admin_config&action=apppub_list&ip=$appserverip");	
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
		for($i=0; $i<count($added); $i++){
			$member = $this->member_set->select_by_id($added[$i]);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('luser', $member['username']);
			$adminlog->set_data('action', language('绑定'));
			$adminlog->set_data('resource', $apppub['name']);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
		}
		for($i=0; $i<count($removed); $i++){
			$member = $this->member_set->select_by_id($removed[$i]);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('luser', $member['username']);
			$adminlog->set_data('action', language('解绑'));
			$adminlog->set_data('resource', $apppub['name']);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
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
		for($i=0; $i<count($added); $i++){
			$ugroup = $this->usergroup_set->select_by_id($added[$i]);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('lgroup', $ugroup['groupname']);
			$adminlog->set_data('action', language('绑定'));
			$adminlog->set_data('resource', $apppub['name']);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
		}
		for($i=0; $i<count($removed); $i++){
			$ugroup = $this->usergroup_set->select_by_id($removed[$i]);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('lgroup', $ugroup['groupname']);
			$adminlog->set_data('action', language('解绑'));
			$adminlog->set_data('resource', $apppub['name']);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
		}



					$this->appgroup_set->delete_all('appdeviceid='.$id);
					$this->appmember_set->delete_all('appdeviceid='.$id);
					$this->appdevice_set->edit($newappdeviceid);
					for($i=0; $i<count($_POST['member']); $i++){
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
					alert_and_back("修改成功", "admin.php?controller=admin_config&action=apppub_list&ip=$appserverip");	
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
		$cmd = "uname -n";
		exec($cmd, $out1);
		$hostname = trim($out1[0]);
		$cmd = "sudo ps -ef | grep keepalived | grep -v grep";
		exec($cmd, $out);
		if(strstr(strtolower($out[0]), "keepalived"))
		{
			$network['start']=1;
		}
		$slaveip = $this->setting_set->select_all("sname='ha_slave_ip'");
		$network['slave_ip'] = $slaveip[0]['svalue'];
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
		$mailalarm = get_request('mailalarm', 1, 1);
		$syslogserver = get_request('syslogserver', 1, 1);
		$syslogport = get_request('syslogport', 1, 1);
		$syslog_facility = get_request('syslog_facility', 1, 1);		
		$filename = '/opt/freesvr/audit/authd/etc/freesvr_authd_config';
		if($ac){
			$sql = ($ac != 'new' ? 'UPDATE' : 'INSERT INTO ')." alarm SET Mail_Alarm='".$Mail_Alarm."',Mailserver='".$Mailserver."', account='".$account."', password='".$password."',syslog_alarm='".$syslog_alarm."', syslogserver='".$syslogserver."', syslogport='".$syslogport."',syslog_facility='".$syslog_facility."'";
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
		if($ac){
			$sql = ($ac != 'new' ? 'UPDATE' : 'INSERT INTO ')." defaultpolicy SET autosu='".(empty($autosu) ? 0 : $autosu)."',syslogalert='".(empty($syslogalert) ? 0 : $syslogalert)."', mailalert='".(empty($mailalert) ? 0 : $mailalert)."', loginlock='".(empty($loginlock) ? 0 : $loginlock)."',weektime='".$weektime."', sourceip='".$sourceip."', forbidden_commands_groups='".$forbidden_commands_groups."'".", netdisksize='".$netdisksize."'".", default_control='".$default_control."'".", entrust_password='".$entrust_password."', rdpclipauth_up='".$rdpclipauth_up."', rdpclipauth_down='".$rdpclipauth_down."',  rdpdiskauth_up='".$rdpdiskauth_up."',  rdpdiskauth_down='".$rdpdiskauth_down."'";
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

		$setting = $this->setting_set->select_all(" sname='loginconfig'");
		$config = unserialize($setting[0]['svalue']);
		if(!empty($_POST['newip'])){
			if($_POST['type']=='ldap'){
				$config['ldapconfig'][]=array('address'=>$_POST['newip'], 'port'=>$_POST['newport'], 'domain'=>$_POST['newdomain']);
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
			if(!empty($_POST['ldapip'][$i]))
			$config['ldapconfig'][]=array('address'=>$_POST['ldapip'][$i], 'port'=>$_POST['ldapport'][$i], 'domain'=>$_POST['ldapdomain'][$i]);
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
		$filename = $_CONFIG['CONFIGFILE']['FTP'];
		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], "FtpBackupSize"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['ftpbackupsize'] = trim($tmp[1]);
				}
			}
		}
		else
		{
			alert_and_back('配置文件不存在');
			exit;
		}
		unset($lines);
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
		unset($lines);
		$filename = $_CONFIG['NTPKEYS'];		
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(substr(trim($lines[$ii]),0,1)!='#'&&strstr($lines[$ii], "65535"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['ntpkey'] = trim($tmp[2]);
				}
			}
		}
		else
		{
			alert_and_back($filename.'配置文件不存在或没有权限');
			exit;
		}
		unset($lines);
		$filename = $_CONFIG['NTPNAGIOS2'];		
		$lines = file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(substr(trim($lines[$ii]),0,1)!='#'&&strstr($lines[$ii], "server "))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);//var_dump($tmp);
					for($i=0; $i<count($tmp); $i++){
						if(is_ip($tmp[$i])){
							$network['ntpserver'] = trim($tmp[$i]);
							break;
						}
					}
					break;
				}
			}
		}
		else
		{
			alert_and_back($filename.'配置文件不存在或没有权限');
			exit;
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
				if(strstr($lines[$ii], " --dport 161 "))
				{
					if(substr(trim($lines[$ii]),0,1)=='#'){
						$network['snmp'] = 0;
					}else{
						$network['snmp'] = 1;
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

		

		$autodelcycle = $this->setting_set->select_all("sname='autodelete'");
		$autodelcycle = $autodelcycle[0]['svalue'];
		$logintype = $this->setting_set->select_all("sname='logintype'");
		$logintype = unserialize($logintype[0]['svalue']);
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
		$this->display('config_ftp.tpl');
	}

	function ntpset(){
		global $_CONFIG;
		$filename = $_CONFIG['NTPKEYS'];		
		$ntpkey = get_request('ntpkey',1,1);		
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(substr(trim($lines[$ii]),0,1)!='#'&&strstr($lines[$ii], "65535"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					if(empty($ntpkey)){
						$lines[$ii] = "65535	M	\n";
					}else{
						$lines[$ii] = "65535	M	$ntpkey\n";
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

		$filename = $_CONFIG['NTPNAGIOS2'];		
		$ntpserver = get_request('ntpserver',1,1);		
		$lines = @file($filename);
		if(!empty($lines))
		{
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(substr(trim($lines[$ii]),0,1)!='#'&&strstr($lines[$ii], "server "))
				{
					$lines[$ii] = "server $ntpserver"."\n";
				}
			}
			
		}
		else
		{
			alert_and_back('配置文件不存在或没有权限');
			exit;
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
		system('sudo /sbin/service iptables restart');
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
		system('sudo /sbin/service iptables restart');
		ob_get_clean();
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
		system('sudo /sbin/service snmpd  restart');
		ob_get_clean();
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	} 

	function autodelete_save(){
		$autodelete = get_request('autodelete', 1, 0);
		$this->setting_set->query("UPDATE ".$this->setting_set->get_table_name()." SET svalue='".$autodelete."' WHERE sname='autodelete'");
		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function ftp_save()
	{
		//$filename = './controller/freesvr-ftp-audit.conf';
		global $_CONFIG;
		$reset = get_request('reset',1,1);
		$shutdown = get_request('shutdown',1,1);
		$clearaccount = get_request('clearaccount',1,1);
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
		$this->apppub_set->query("Delete from member where level not in(1, 2, 10) ");
		$this->apppub_set->query("Delete from radcheck where UserName not in(SELECT username FROM member where level in(1, 2, 10) )");
		$this->apppub_set->query("delete from luser");
		$this->apppub_set->query("delete from lgroup");
		$this->apppub_set->query("delete from devices");
		$this->apppub_set->query("delete from servers");
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
		$this->apppub_set->query("delete from member where uid>100");
		$this->apppub_set->query("delete from radcheck where id>300");
		$this->apppub_set->query("delete from usergroup");
		$this->apppub_set->query("delete from servergroup");
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

		alert_and_back('配置成功','admin.php?controller=admin_config&action=config_ftp');
	}

	function keyedit(){		
		$eth0 = get_request('eth0',1,1);
		system("sudo /home/wuxiaolong/install/CAinstall.pl ".$eth0,$out);
		//system("sudo killall -9 httpd",$out);
		system("sudo services httpd restart",$out);
		alert_and_back('修改完成','admin.php?controller=admin_config&action=config_ftp');
	}

	function logintype(){
		$radiusauth = get_request('radiusauth', 1, 0);
		$adauth = get_request('adauth', 1, 0);
		$ldapauth = get_request('ldapauth', 1, 0);
		$this->apppub_set->query("UPDATE setting SET svalue='".serialize(array('radiusauth'=>$radiusauth,'ldapauth'=>$ldapauth,'adauth'=>$adauth))."' WHERE sname='logintype'");
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

	function ldapusers(){
		global $_CONFIG;
		if($_POST['address']){
			$ldapconn = ldap_connect($_POST['address'], 389);			 
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

			if ($ldapconn) {

				// binding to ldap server
				$_domain = explode('.', $_POST['domain']);
				$sdomain = '';
				for($i=0; $i<count($_domain); $i++){
					$sdomain .= "dc=".$_domain[$i].',';
				}
				$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
				$ldapbind = ldap_bind($ldapconn, $_POST['adusername'].','.$sdomain, $_POST['adpassword']);

				// verify binding
				if ($ldapbind) {
					$basedn = "ou=网络技术部,ou=信息技术中心,ou=东方地球物理公司,ou=北京区域中心,DC=cnpc,DC=com,DC=cn";
					$justthese = array("ou","cn","samaccountname");
					$sr=ldap_search($ldapconn, $basedn, "(&(objectCategory=user)(cn=*))",$justthese , 0, 0, 0);
					$info = ldap_get_entries($ldapconn, $sr);
					$nogroupusers = array();
					for($i=0; $i<$info['count']; $i++){
						$info[$i]['samaccountname'][0]=trim($info[$i]['samaccountname'][0]);
						if(!empty($info[$i]['samaccountname'][0])&&$this->member_set->select_count("username='".trim($info[$i]['samaccountname'][0])."'")==0)
						$nogroupusers[]=array('name'=>trim($info[$i]['cn'][0]), 'username'=>trim($info[$i]['samaccountname'][0]));
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
			$this->assign("domain", $_POST['domain']);
			$this->assign("step", 1);
		}
		$this->assign("nogroupusers", $nogroupusers);
		$this->display('ldapusers_tree.tpl');
			
	}

	function ldapusers_save(){
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
			$newmember->set_data('vpn', $vpn);
			$newmember->set_data('vpnip', $vpnip);
			$newmember->set_data('usbkey', $usbkey);

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

				
				$pwd_ban_word_arr = explode('1', $_CONFIG['PASSWORD_BAN_WORD']);			
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
				if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2)){
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
			if(isset($_POST['groupid'][$i])){
				$newmember->set_data("groupid", $_POST['groupid'][$i]);
			}
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
			$loguser = $this->member_set->base_select("SELECT * FROM ".LOG_DBNAME.".user where username='".$newmember->get_data('username')."'");
			if(empty($loguser)){
				if($log_priority>=0){
					$sql = "INSERT INTO ".LOG_DBNAME.".user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."'";
					$this->member_set->query($sql);
				}
			}else{
				$sql = "UPDATE ".LOG_DBNAME.".user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."' WHERE  userid='".$loguser[0]['userid']."'";
				$this->member_set->query($sql);
			}

			$this->member_set->add($newmember);
			$added[]=$newmember->get_data('username');

			$passwordlog = new passwordlog();
			$passwordlog->set_data('uid', mysql_insert_id());
			$passwordlog->set_data('password', md5($password1));
			$passwordlog->set_data('time', mktime());
			$this->passwordlog_set->add($passwordlog);
			//记录日志
			$adminlog = new admin_log();
			$adminlog->set_data('luser', $newmember->get_data('username'));
			$adminlog->set_data('action', language('添加'));
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
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
			alert_and_close($msg);
		}else{
			alert_and_close('添加失败:\n'.(is_array($error) ? implode('\n',$error) : '').'\n');
		}
	}

	function adusers(){
		global $_CONFIG;

		if($_POST['address']){
			$_SESSION['AD_address']=$_POST['address'];
			$_SESSION['AD_domain']=$_POST['domain'];
			$_SESSION['AD_adusername']=$_POST['adusername'];
			$_SESSION['AD_adpassword']=$_POST['adpassword'];
			include (ROOT . "/include/adLDAP/adLDAP.php");
			try {
				$options['account_suffix'] = '@'.$_POST['domain'];
				$options['domain_controllers'] = array($_POST['address']);
				$_domain = explode('.', $_POST['domain']);
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
			$result = $adldap->authenticate($_POST['adusername'], $_POST['adpassword']);
			if(!$result){
				alert_and_back('账号或密码错误');
			}
			$allusers = array();
			foreach($adldap->user()->all() as $val)
			{
				$allusers[]=$val;
			}
			$users = $this->member_set->select_all("username IN('".implode("','", $allusers)."')");
			$_users = array();
			for($i=0; $i<count($users); $i++){
				$_users[]=$users[$i]['username'];
			}
			for($i=0; $i<count($allusers); $i++){
				if(!in_array($allusers[$i], $_users)&&!in_array($allusers[$i], $_CONFIG['AD_USERS'])){
					$_allusers[]=$allusers[$i];
				}
			}
			if($_allusers)
			$allusers = $_allusers;
			$_allusers = null;

			$groupusers = array();
			$groups = array();
			foreach($adldap->group()->all() as $val)
			{
				$users = $adldap->group()->members($val);
				$_users = array();
				for($i=0; $i<count($users); $i++){
					if(in_array($users[$i], $allusers)){
						$_users[]=$users[$i];
					}
				}//var_dump($_users);
				if(count($_users)>0){
					sort($_users);
					$groups[] = array('groupname'=>$val, 'users'=>$_users, 'usercount'=>count($_users));
					$groupusers = array_merge($groupusers, $_users);
				}
				$users = null;
			}
			$nogroupusers = array();
			for($i=0; $i<count($allusers); $i++){
				if(!in_array($allusers[$i], $groupusers)){
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
		}
		$this->assign("groups", $groups);
		$this->assign("nogroupusers", $nogroupusers);
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
		$groupname = urldecode($groupname);//var_dump($groupname);
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
		$allusers = array();
		$alluserstmp = $adldap->group()->members($groupname);//var_dump($alluserstmp);
		foreach( $alluserstmp as $val1)
		{
			$allusers[]=$val1;
		}
		$users = $this->member_set->select_all("username IN('".implode("','", $allusers)."')");
		$_users = array();
		for($i=0; $i<count($users); $i++){
			$_users[]=$users[$i]['username'];
		}
		for($i=0; $i<count($allusers); $i++){
			if(!in_array($allusers[$i], $_users)&&!in_array($allusers[$i], $_CONFIG['AD_USERS'])){
				$_allusers[]=$allusers[$i];
			}
		}
		if($_allusers)
		$allusers = $_allusers;
		$_allusers = null;
		sort($allusers);
		for($i=0; $i<count($allusers); $i++){
			echo $allusers[$i].","."0\r\n";
		}
		/*for($i=0; $i<1000; $i++){
			echo "user_".$i.","."0\r\n";
		}*/
	}

	function adusers_save(){
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
			$newmember->set_data('vpn', $vpn);
			$newmember->set_data('vpnip', $vpnip);
			$newmember->set_data('usbkey', $usbkey);

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

				
				$pwd_ban_word_arr = explode('1', $_CONFIG['PASSWORD_BAN_WORD']);			
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
				if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2)){
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
			if(isset($_POST['groupid'][$i])){
				$newmember->set_data("groupid", $_POST['groupid'][$i]);
			}
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
			$loguser = $this->member_set->base_select("SELECT * FROM ".LOG_DBNAME.".user where username='".$newmember->get_data('username')."'");
			if(empty($loguser)){
				if($log_priority>=0){
					$sql = "INSERT INTO ".LOG_DBNAME.".user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."'";
					$this->member_set->query($sql);
				}
			}else{
				$sql = "UPDATE ".LOG_DBNAME.".user set username='".$newmember->get_data('username')."',password=md5('".$this->member_set->udf_decrypt($newmember->get_data('password'))."'),email='".$newmember->get_data('email')."',level='".$newmember->get_data('level')."' WHERE  userid='".$loguser[0]['userid']."'";
				$this->member_set->query($sql);
			}

			$this->member_set->add($newmember);
			$added[]=$newmember->get_data('username');

			$passwordlog = new passwordlog();
			$passwordlog->set_data('uid', mysql_insert_id());
			$passwordlog->set_data('password', md5($password1));
			$passwordlog->set_data('time', mktime());
			$this->passwordlog_set->add($passwordlog);
			//记录日志
			$adminlog = new admin_log();
			$adminlog->set_data('luser', $newmember->get_data('username'));
			$adminlog->set_data('action', language('添加'));
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
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
			alert_and_close($msg);
		}else{
			alert_and_close('添加失败:\n'.(is_array($error) ? implode('\n',$error) : '').'\n');
		}
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
