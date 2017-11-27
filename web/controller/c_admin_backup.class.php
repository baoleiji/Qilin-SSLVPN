<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_backup extends c_base {
	
	function index() {
		$this->display('backup.tpl');
	}
	function backup(){
		global $dbname,$dbuser,$dbpwd,$dbhost;
//loading_start();
		$file = "/tmp/$dbname.sql";
		$cmd = "mysqldump -h$dbhost -u$dbuser -p". _encrypt($dbpwd, 'D', 'freesvr' )."  -B $dbname --tables admin_log alarm alert_mailsms appdevices appgroup appmember appprogram apppserver apppub appresourcegroup appurl dangerscmds defaultpolicy dev device device_html devices devices_password forbidden_commands forbidden_commands_groups forbidden_commands_user forbidden_groups ip lgroup lgroup_appresourcegrp lgroup_devgrp lgroup_resourcegrp login_tab login_template loginacctcode luser luser_appresourcegrp luser_devgrp luser_resourcegrp member password_cache password_policy password_rules passwordkey prompts proxyip radcheck radgroupcheck radgroupreply radhuntcheck radhuntgroup radhuntgroupcheck radhuntreply radkey radreply radsourcecheck radsourcegroup radsourcegroupcheck radsourcereply radwmkey random rdptoapp resourcegroup restrictacl restrictpolicy servergroup servers setting sourceip sourceiplist sshkey sshkeyname sshprivatekey sshpublickey strategy weektime > $file";
		if(file_exists($file)){
			@unlink($file);
		}
		if(file_exists($file.".gz")){
			@unlink($file.".gz");
		}
		if(file_exists("tmp/bkzipphp.php")){
			@unlink("tmp/bkzipphp.php");
		}
		if(file_exists("tmp/".$dbname.".sql.gz")){
			@unlink("tmp/".$dbname.".sql.gz");
		}
		exec($cmd, $r);

		exec("gzip -f $file");
		//exec("cp $file".".gz tmp/");
//loading_end();
		/*$phpstr = "<?php\r\nsession_start();\r\nHeader('Cache-Control: private, must-revalidate, max-age=0');\r\tHeader(\"Content-type: application/octet-stream\"); \r\tHeader(\"Content-Disposition: attachment; filename=$dbname.sql.gz\"); \r\t\$f=fopen(\"$file.gz\",'rb'); \r\t	if(\$f!=false){\r\t		\$contents = \"\";\r\t		do {\r\t		    \$data = fread(\$f, 8192);\r\t		    if (strlen(\$data) == 0) {\r\t			break;\r\t		    }\r\t		    \$contents .= \$data;\r\t		} while(true);\r\t		fclose(\$f); \r\t		echo \$contents;\r\t}\r\tif(file_exists(\"$file.gz\")){\r\t	@unlink(\"$file.gz\");\r\t}\r\tif(file_exists(\"$file\")){\r\t	@unlink(\"$file\");\r\t}\r\n?>\r\n";
			if(!file_exists("tmp/bkzipphp.php"))
				$this->Array2File(array($phpstr), "tmp/bkzipphp.php");
			echo "tmp/bkzipphp.php";*/
			//echo "tmp/".$dbname.".sql.gz";
			//go_url("tmp/".$dbname.".sql.gz");

		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=" . $dbname.".sql.gz"); 
		$f=fopen($file.".gz",'rb'); 
			if($f!=false){
				$contents = "";
				do {
				    $data = fread($f, 8192);
				    if (strlen($data) == 0) {
				        break;
				    }
				    $contents .= $data;
				} while(true);
				fclose($f); 
				echo $contents;
		}else{
			alert_and_back("打开文件失败");
			exit;
		}
		if(file_exists($file.".gz")){ 
			@unlink($file.".gz");
		}
		if(file_exists($file)){
			@unlink($file);
		}
		exit();

		//print_r($out);
	}
	
	function recover(){
		global $dbname,$dbuser,$dbpwd,$dbhost;
		if($_FILES['backup_file']['error']==1 or $_FILES['backup_file']['error']==2){
			alert_and_back("上传得文件超过系统限制", 'admin.php?controller=admin_backup');
			exit;
		}
		if(!is_uploaded_file($_FILES['backup_file']['tmp_name']))
		{
			alert_and_back("请上传文件", 'admin.php?controller=admin_backup');
			exit;
		}	
		if(substr($_FILES['backup_file']['name'],strlen($_FILES['backup_file']['name'])-3)!='.gz')
		{
			alert_and_back("文件格式不符合要求", 'admin.php?controller=admin_backup');
			exit;
		}	
		$newname = 'new'.$_FILES['backup_file']['name'];
		move_uploaded_file($_FILES['backup_file']['tmp_name'], dirname(__FILE__)."/../tmp/$newname");
		if(file_exists(dirname(__FILE__)."/../tmp/$newname")){
			exec("gzip -lf ".dirname(__FILE__)."/../tmp/$newname", $output);
			
			$name = preg_split("/[\s]+/", $output[1]);
			exec("gzip -df ".dirname(__FILE__)."/../tmp/$newname", $output);
			$handle = @fopen($name[4], "r");
			$found = 0;
			if ($handle) {
				while (($buffer = fgets($handle, 4096)) !== false) {
					if(strpos($buffer, "CREATE TABLE `AS400_commands")>=0){
						$found = 1;
						break;
					}
				}
				fclose($handle);
			}
			if($found==0){
				alert_and_back("文件内容不符合要求", 'admin.php?controller=admin_backup');
				exit;
			}
			$cmd = "cat $name[4] | mysql -h$dbhost -ufreesvr -pfreesvr  $dbname  ";
			exec($cmd, $out, $return);
			//unlink(dirname(__FILE__)."/../tmp/$newname");
			if(file_exists(dirname(__FILE__)."/../tmp/".substr($newname,0,strlen($newname)-3))){
				@unlink(dirname(__FILE__)."/../tmp/".substr($newname,0,strlen($newname)-3));
			}
			alert_and_back("恢复成功",'admin.php?controller=admin_backup');
		}else{
			
			alert_and_back('移动文件失败,请检查文件权限');
		}
	}
	
	function to_sql($result, $table_name) {
		foreach($result as $data) {
			$keys = array_keys($data);
			$keys = array_map('addslashes', $keys);
			$keys = join('`,`', $keys);
			$keys = "`$keys`";
			$vals = array_values($data);
			$vals = array_map('addslashes', $vals);
			$vals = join("','", $vals);
			$vals = "'$vals'";
			$query .= "INSERT INTO `$table_name`($keys) VALUES($vals);\n";
		}
		//echo $query;
		return $query;
	}

	function refresh_dev() {
		$result = $this->dev_set->select_all('1', 'device_ip', 'asc');
		if(!empty($result))
		foreach($result as $t) {
			$olddev[] = $t['ip'];
		}
		$dev = $this->sessions_set->base_select("SELECT distinct `device_ip` FROM `" . $this->devpass_set->get_table_name() . "` ");
		if(!empty($dev))
		foreach($dev as $t) {
			$addr = $t['device_ip'];
			if(is_ip($addr)) {
				if($olddev == NULL || !in_array($addr, $olddev)) {
					$newdev = new dev();
					$newdev->set_data('ip', $addr);
					$this->dev_set->add($newdev);
				}
			}
		}
		$this->dev_set->query("DELETE FROM `dev` WHERE ip = ''");
		$this->assign("title", "更新设备表");
		$this->assign("content",  "更新成功");
		$this->display("error.tpl");
		//echo '更新成功!';
		//var_dump($dev);
	}

	function backup_policy(){
		$ac = get_request('ac', 1, 1);
		$backuptime = get_request('backuptime', 1, 1);
		$backup_delete = get_request('backup_delete', 1, 1);
		$backup_server = get_request('backup_server', 1, 1);
		$backup_username = get_request('backup_username', 1, 1);
		$backup_password = get_request('backup_password', 1, 1);
		$backup_protocol = get_request('backup_protocol', 1, 1);
		$backup_path = get_request('backup_path', 1, 1);
		if($ac){
			$sql = ($ac != 'new' ? 'UPDATE' : 'INSERT INTO ')." alarm SET backuptime='".$backuptime."',backup_delete='".$backup_delete."', backup_server='".$backup_server."', backup_username='".$backup_username."',backup_password='".$backup_password."', backup_path='".$backup_path."', backup_protocol='".$backup_protocol."'";
			$this->config_set->query($sql);
			alert_and_back('修改成功');
		}
		$ha = $this->config_set->base_select("SELECT * FROM alarm LIMIT 1");
		$this->assign("alarm", $ha[0]);
		$this->assign("title", '告警设置');
		$this->display('backup_policy.tpl');
	}


	function backup_manual(){
		global $_CONFIG;
		$ac = get_request('ac', 1, 1);
		$backuptime = get_request('backuptime', 1, 1);
		$isupload = get_request('isupload', 1, 0);
		if($ac){
			$cmd = $_CONFIG['BACKUP_SCRIPT'].' '.$backuptime;
			if(!is_numeric($backuptime)){
				alert_and_back('时间请输入数字');
				exit;
			}
			if(empty($isupload)){
				$cmd .= " 0";
			}
			//echo $cmd;exit;
			exec($cmd);
			alert_and_back('执行成功');
		}
		$this->assign("title", '告警设置');
		$this->display('backup_manual.tpl');
	}


	function backup_setting() {
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		global $_CONFIG;
		$page_num = get_request('page');
		$gid = get_request('gid');
		$h_user = get_request('h_user',1,1);
		$ip = get_request('ip',0,1);
		$session_flag = get_request('session_flag',0,1);
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$logintype = get_request('logintype',0,1);
		$derive = get_request('derive');
		$where = '1';		
		
		if($gid != 0) {
			$where .= " AND groupid = $gid";
		}

		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND ip LIKE '%$ip%'";
		}

		if(is_numeric($session_flag)){
			$where .= " AND session_flag=$session_flag";
		}
		if(empty($orderby1)){
			$orderby1 = 'ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		
		$row_num = $this->backup_setting_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->backup_setting_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby1,$orderby2);

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('alldev', $alldev);
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('session_flag', $session_flag);
		$this->assign('ip', $ip);
		$this->display('backup_setting.tpl');
	}

	function backup_setting_edit(){
		global $_CONFIG;
		$seq = get_request('id');
		$bs = $this->backup_setting_set->select_by_id($seq);
		$bs['passwd'] = $this->backup_setting_set->udf_decrypt($bs['passwd']);
		$bs['mysqlpasswd'] = $this->backup_setting_set->udf_decrypt($bs['mysqlpasswd']);
		$this->assign("bs", $bs);
		$this->display('backup_setting_edit.tpl');
	}

	function backup_setting_save() {
		global $_CONFIG;
		$id = get_request('id');
		$ip = get_request('ip',1,1);
		$port = get_request('port',1,1);
		$dbactive = get_request('dbactive',1,0);
		$fileactive = get_request('fileactive',1,0);
		$user = get_request('user',1,1);
		$passwd = get_request('passwd',1,1);
		$passwdc = get_request('passwdc',1,1);
		$mysqluser = get_request('mysqluser',1,1);
		$mysqlpasswd = get_request('mysqlpasswd',1,1);
		$mysqlpasswdc = get_request('mysqlpasswdc',1,1);
		$path = get_request('path',1,1);
		$dbname = get_request('dbname',1,1);
		$desc = get_request('desc',1,1);
		$session_flag = get_request('session_flag',1,1);		
		$protocol = get_request('protocol',1,1);
		$id = get_request('id');
		if($_POST['submit']=='手动同步'){
			if(intval($session_flag)==2){
				exec('sudo /home/wuxiaolong/5_backup/backup_passwd.pl', $out, $re);
			}elseif(intval($session_flag)==0){
				exec('sudo /home/wuxiaolong/5_backup/backup.pl', $out, $re);
			}elseif(intval($session_flag)==1){
				exec('sudo /home/wuxiaolong/5_backup/backup_session.pl', $out, $re);
			}elseif(intval($session_flag)==100){
				exec('sudo /home/wuxiaolong/5_backup/backup_cvs.pl', $out, $re);
			}
			
			//var_dump($out);var_dump($re);exit;
			alert_and_back('手工同步已经在后台运行');
		}else{
			if(!is_ip($ip)){
				alert_and_back('请输入正确的IP地址格式');
				exit;
			}
			if($passwd!=$passwdc){
				alert_and_back('系统用户两次输入的密码不一致');
				exit;
			}
			if($mysqlpasswd!=$mysqlpasswdc){
				alert_and_back('数据库用户两次输入的密码不一致');
				exit;
			}
			/*if($this->backup_setting_set->select_count("ip = '$ip' and seq != '$id'")>0) {
				alert_and_back('该ip已经存在');
				exit;
			}elseif($this->backup_setting_set->select_count("ip = '$ip' and path = '$path' and seq != '$id'")>0) {
				alert_and_back('该目录'.$path.'已经存在');
				exit;
			}elseif($this->backup_setting_set->select_count("ip = '$ip' and dbname = '$dbname' and seq != '$id'")>0) {
				alert_and_back('该数据库'.$dbname.'已经存在');
				exit;
			}*/
			$backup_setting = new backup_setting();
			$backup_setting->set_data('ip',$ip);
			$backup_setting->set_data('port',$port);
			$backup_setting->set_data('desc',$desc);
			$backup_setting->set_data('session_flag',$session_flag);
			$backup_setting->set_data('protocol',$protocol);
			$backup_setting->set_data('dbactive',$dbactive);
			$backup_setting->set_data('fileactive',$fileactive);
			$backup_setting->set_data('user',$user);
			$backup_setting->set_data('passwd',$this->backup_setting_set->udf_encrypt($passwd));
			$backup_setting->set_data('mysqluser',$mysqluser);
			$backup_setting->set_data('mysqlpasswd',$this->backup_setting_set->udf_encrypt($mysqlpasswd));
			$backup_setting->set_data('path',$path);
			$backup_setting->set_data('dbname',$dbname);
			if($id != 0 ) {
				$backup_setting->set_data('seq', $id);
				$this->backup_setting_set->edit($backup_setting);
			}else{
				$this->backup_setting_set->add($backup_setting);
			}
		}

		alert_and_back('操作成功','admin.php?controller=admin_backup&action=backup_setting');
	}

	function backup_setting_del() {
		$id = get_request('id');
		$chk_member = get_request('chk_member',1,1);
		if(empty($id)){
			$id = $chk_member;
		}
		$this->backup_setting_set->delete($id);
		alert_and_back('删除成功','admin.php?controller=admin_backup&action=backup_setting');
	}

	function backup_setting_forpassword() {
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		global $_CONFIG;
		$page_num = get_request('page');
		$gid = get_request('gid');
		$h_user = get_request('h_user',1,1);
		$ip = get_request('ip',0,1);
		$hostname = get_request('hostname',0,1);
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$logintype = get_request('logintype',0,1);
		$derive = get_request('derive');
		$where = 'session_flag=2';
		
		
		if($gid != 0) {
			$where .= " AND groupid = $gid";
		}

		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND ip LIKE '%$ip%'";
		}
		
		if(empty($orderby1)){
			$orderby1 = 'ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		
		$row_num = $this->backup_setting_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->backup_setting_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('alldev', $alldev);
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('backup_setting_forpassword1.tpl');
	}

	function backup_setting_forpassword_edit(){
		global $_CONFIG;
		$seq = get_request('id');
		$bs = $this->backup_setting_set->select_by_id($seq);
		$bs['passwd'] = $this->backup_setting_set->udf_decrypt($bs['passwd']);
		$bs['mysqlpasswd'] = $this->backup_setting_set->udf_decrypt($bs['mysqlpasswd']);
		$this->assign("bs", $bs);
		$this->display('backup_setting_forpassword_edit1.tpl');
	}

	function backup_setting_forpassword_save() {
		global $_CONFIG;
		$id = get_request('id');
		$desc = get_request('desc',1,1);
		$ip = get_request('ip',1,1);
		$port = get_request('port',1,1);
		$dbactive = get_request('dbactive',1,0);
		$fileactive = get_request('fileactive',1,0);
		$user = get_request('user',1,1);
		$passwd = get_request('passwd',1,1);
		$protocol = get_request('protocol',1,1);
		$passwdc = get_request('passwdc',1,1);
		$mysqluser = get_request('mysqluser',1,1);
		$mysqlpasswd = get_request('mysqlpasswd',1,1);
		$mysqlpasswdc = get_request('mysqlpasswdc',1,1);
		$path = get_request('path',1,1);
		$dbname = get_request('dbname',1,1);
		$id = get_request('id');
		if($_POST['submit']=='手动同步'){
			exec('/home/wuxiaolong/5_backup/backup_passwd.pl');
			alert_and_back('手工同步已经在后台运行');
		}else{
			if(!is_ip($ip)){
				alert_and_back('请输入正确的IP地址格式');
				exit;
			}
			if($passwd!=$passwdc){
				alert_and_back('系统用户两次输入的密码不一致');
				exit;
			}
			if($mysqlpasswd!=$mysqlpasswdc){
				alert_and_back('数据库用户两次输入的密码不一致');
				exit;
			}
			/*if($this->backup_setting_set->select_count("ip = '$ip' and seq != '$id'")>0) {
				alert_and_back('该ip已经存在');
				exit;
			}else*/if($this->backup_setting_set->select_count("ip = '$ip' and path = '$path' and seq != '$id'")>0) {
				alert_and_back('该目录'.$path.'已经存在');
				exit;
			}elseif($this->backup_setting_set->select_count("ip = '$ip' and dbname = '$dbname' and seq != '$id'")>0) {
				alert_and_back('该数据库'.$dbname.'已经存在');
				exit;
			}
			$backup_setting = new backup_setting();
			$backup_setting->set_data('ip',$ip);
			$backup_setting->set_data('port',$port);
			$backup_setting->set_data('desc',$desc);
			$backup_setting->set_data('protocol',$protocol);
			$backup_setting->set_data('dbactive',$dbactive);
			$backup_setting->set_data('fileactive',$fileactive);
			$backup_setting->set_data('user',$user);
			$backup_setting->set_data('passwd',$this->backup_setting_set->udf_encrypt($passwd));
			$backup_setting->set_data('mysqluser',$mysqluser);
			$backup_setting->set_data('mysqlpasswd',$this->backup_setting_set->udf_encrypt($mysqlpasswd));
			$backup_setting->set_data('path',$path);
			$backup_setting->set_data('dbname',$dbname);
			$backup_setting->set_data('session_flag',2);
			if($id != 0 ) {
				$backup_setting->set_data('seq', $id);
				$this->backup_setting_set->edit($backup_setting);
			}else{
				$this->backup_setting_set->add($backup_setting);
			}
		}

		alert_and_back('操作成功','admin.php?controller=admin_backup&action=backup_setting_forpassword');
	}

	function backup_setting_forpassword_del() {
		$id = get_request('id');
		$chk_member = get_request('chk_member',1,1);
		if(empty($id)){
			$id = $chk_member;
		}
		$this->backup_setting_set->delete($id);
		alert_and_back('删除成功','admin.php?controller=admin_backup&action=backup_setting_forpassword');
	}


	function backup_log() {
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		global $_CONFIG;
		$page_num = get_request('page');
		$gid = get_request('gid');
		$h_user = get_request('h_user',1,1);
		$ip = get_request('ip',0,1);
		$hostname = get_request('hostname',0,1);
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$logintype = get_request('logintype',0,1);
		$derive = get_request('derive');
		$where = '1=1';
		
		
		if($gid != 0) {
			$where .= " AND groupid = $gid";
		}

		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND ip LIKE '%$ip%'";
		}
		
		if(empty($orderby1)){
			$orderby1 = 'ip';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$row_num = $this->backup_log_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->backup_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('alldev', $alldev);
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('backup_log.tpl');
	}

	function backup_log_del() {
		$id = get_request('id');
		$chk_member = get_request('chk_member',1,1);
		if(empty($id)){
			$id = $chk_member;
		}
		$this->backup_log_set->delete($id);
		alert_and_back('删除成功','admin.php?controller=admin_backup&action=backup_log');
	}

	function backup_passwd_log() {
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		global $_CONFIG;
		$page_num = get_request('page');
		$gid = get_request('gid');
		$h_user = get_request('h_user',1,1);
		$ip = get_request('host',0,1);
		$hostname = get_request('hostname',0,1);
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$logintype = get_request('logintype',0,1);
		$derive = get_request('derive');
		$where = 'host="'.$ip.'"';
		
		
		if($gid != 0) {
			$where .= " AND groupid = $gid";
		}

		
		if(empty($orderby1)){
			$orderby1 = 'datetime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$row_num = $this->backup_passwd_log_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->backup_passwd_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('alldev', $alldev);
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('backup_passwd_log.tpl');
	}

	function backup_passwd_log_del() {
		$id = get_request('id');
		$chk_member = get_request('chk_member',1,1);
		if(empty($id)){
			$id = $chk_member;
		}
		$this->backup_passwd_log_set->delete($id);
		alert_and_back('删除成功','admin.php?controller=admin_backup&action=backup_passwd_log');
	}

	function runupload(){
		exec(($_SESSION['ADMIN_LEVEL']==1 ? 'sudo ':'').'/home/wuxiaolong/5_backup/backup_csv.pl', $out);
		alert_and_back('操作成功');
	}

	function runchangepwd(){
		exec(($_SESSION['ADMIN_LEVEL']==1 ? 'sudo ':'').'/opt/freesvr/audit/passwd/sbin/freesvr-passwd', $out);
		alert_and_back('操作成功');
	}

	function runtongbu(){
		exec(($_SESSION['ADMIN_LEVEL']==1 ? 'sudo ':'').'/opt/freesvr/audit/sbin/listacct', $out);
		alert_and_back('操作成功');
	}

	function upgrade() {
		$this->display('upgrade.tpl');
	}
	function doupgrade(){
		global $dbname,$dbuser,$dbpwd,$dbhost;
		$upgradefile = $_FILES['upgradefile'];
		if($upgradefile['error']==1 or $upgradefile['error']==2){
			alert_and_back("上传得文件超过系统限制", 'admin.php?controller=admin_backup&action=upgrade');
			exit;
		}
		if(!is_uploaded_file($upgradefile['tmp_name']))
		{
			alert_and_back("请上传文件", 'admin.php?controller=admin_backup&action=upgrade');
			exit;
		}	
		if(substr($upgradefile['name'],strlen($upgradefile['name'])-3)!='.gz')
		{
			alert_and_back("文件格式不符合要求", 'admin.php?controller=admin_backup&action=upgrade');
			exit;
		}
		exec("rm -rf /tmp/update", $out);
		exec("mkdir /tmp/update", $out);
		exec("chmod -R 777 /tmp/update", $out);
		if(move_uploaded_file($upgradefile['tmp_name'], '/tmp/update/'.$upgradefile['name'])){
			exec("tar -zxvf /tmp/update/".$upgradefile['name'].' -C /tmp/update/', $out);
			exec("sudo /tmp/update/install.sh", $out);
			alert_and_back("升级成功",'admin.php?controller=admin_backup&action=upgrade');
		}else{
			alert_and_back("移动文件失败",'admin.php?controller=admin_backup&action=upgrade');
		}
	}

	function cronjob(){
		global $_CONFIG;
		$chpwdservice = get_request('chpwdservice', 1, 1);
		$accountservice = get_request('accountservice', 1, 1);
		$uploadservice = get_request('uploadservice', 1, 1);
		$pwduploadservice = get_request('pwduploadservice', 1, 1);
		$ac = get_request('ac', 1, 1);
		$backup = 0;
		$backupsession = 0;
		$autodelete = 0;

		if($ac == 'doit'){		
			$minute = get_request('minute', 1, 1);
			$hour = get_request('hour', 1, 1);
			$day = get_request('day', 1, 1);
			$week = get_request('week', 1, 1);
			$uminute = get_request('uminute', 1, 1);
			$uhour = get_request('uhour', 1, 1);
			$uday = get_request('uday', 1, 1);
			$uweek = get_request('uweek', 1, 1);
			$pminute = get_request('pminute', 1, 1);
			$phour = get_request('phour', 1, 1);
			$pday = get_request('pday', 1, 1);
			$pweek = get_request('pweek', 1, 1);
			//
			$linestmp = @file($_CONFIG['NTPNAGIOS']);//echo '<pre>';print_r($linestmp);echo '</pre>';
			for($ii=0; $ii<count($linestmp); $ii++)
			{				
				if(strlen(trim($linestmp[$ii]))==0)
				{
					continue;
				}
				if(strstr(strtolower($linestmp[$ii]), "/home/wuxiaolong/5_backup/backup.pl"))
				{
					$backup = 1;
					if($chpwdservice){
						$linestmp[$ii]="$minute $hour $day * $week /usr/bin/sudo -u root /home/wuxiaolong/5_backup/backup.pl\n";
					}else{
						$linestmp[$ii]="#$minute $hour $day * $week /usr/bin/sudo -u root /home/wuxiaolong/5_backup/backup.pl\n";
					}
				}
				if(strstr(strtolower($linestmp[$ii]), "/home/wuxiaolong/5_backup/backup_session.pl"))
				{
					$backupsession = 1;
					if($accountservice){
						$linestmp[$ii]="$uminute $uhour $uday * $uweek /usr/bin/sudo -u root /home/wuxiaolong/5_backup/backup_session.pl\n";
					}else{
						$linestmp[$ii]="#$uminute $uhour $uday * $uweek /usr/bin/sudo -u root /home/wuxiaolong/5_backup/backup_session.pl\n";
					}
				}
				if(strstr(strtolower($linestmp[$ii]), "/home/wuxiaolong/auto_delete.pl"))
				{
					$autodelete = 1;
					if($uploadservice){
						$linestmp[$ii]="$pminute $phour $pday * $pweek /usr/bin/sudo -u root /home/wuxiaolong/auto_delete.pl\n";
					}else{
						$linestmp[$ii]="#$pminute $phour $pday * $pweek /usr/bin/sudo -u root /home/wuxiaolong/auto_delete.pl\n";
					}
				}
				//echo $linestmp[$ii];echo '<br>';
			}
			if($backup==0){
				if($chpwdservice){
					$linestmp[$ii++]="$minute $hour $day * $week /usr/bin/sudo -u root /home/wuxiaolong/5_backup/backup.pl\n";
				}else{
					$linestmp[$ii++]="#$minute $hour $day * $week /usr/bin/sudo -u root /home/wuxiaolong/5_backup/backup.pl\n";
				}
			}
			if($backupsession==0){
				if($accountservice){
					$linestmp[$ii++]="$uminute $uhour $uday * $uweek /usr/bin/sudo -u root /home/wuxiaolong/5_backup/backup_session.pl\n";
				}else{
					$linestmp[$ii++]="#$uminute $uhour $uday * $uweek /usr/bin/sudo -u root /home/wuxiaolong/5_backup/backup_session.pl\n";
				}
			}
			if($autodelete==0){
				if($uploadservice){
					$linestmp[$ii++]="$pminute $phour $pday * $pweek /usr/bin/sudo -u root /home/wuxiaolong/auto_delete.pl\n";
				}else{
					$linestmp[$ii++]="#$pminute $phour $pday * $pweek /usr/bin/sudo -u root /home/wuxiaolong/auto_delete.pl\n";
				}
			}
			$this->Array2File($linestmp,$_CONFIG['NTPNAGIOS']);
			alert_and_back('修改成功', 'admin.php?controller=admin_backup&action=cronjob');
		}

		
		$linestmp = @file($_CONFIG['NTPNAGIOS']);		
		//echo '<pre>';print_r($linestmp);echo '</pre>';
		for($ii=0; $ii<count($linestmp); $ii++)
		{			
			if(strlen(trim($linestmp[$ii]))==0)
			{
				continue;
			}
			if(strstr(strtolower($linestmp[$ii]), "/home/wuxiaolong/5_backup/backup.pl")){
				if(substr($linestmp[$ii], 0, 1)=="#"){
					$chpwdservice = 0;
				}else{
					$chpwdservice = 1;
					$linestmp[$ii]=trim($linestmp[$ii]);
					$tmp = preg_split("/[\s]+/", $linestmp[$ii]);
					$this->assign("minute", $tmp[0]);
					$this->assign("hour", $tmp[1]);
					$this->assign("day", $tmp[2]);
					$this->assign("week", $tmp[4]);
				}
			}elseif(strstr(strtolower($linestmp[$ii]), "/home/wuxiaolong/5_backup/backup_session.pl")){
				if(substr($linestmp[$ii], 0, 1)=="#"){
					$accountservice = 0;
				}else{
					$accountservice = 1;
					$linestmp[$ii]=trim($linestmp[$ii]);
					$tmp = preg_split("/[\s]+/", $linestmp[$ii]);
					$this->assign("uminute", $tmp[0]);
					$this->assign("uhour", $tmp[1]);
					$this->assign("uday", $tmp[2]);
					$this->assign("uweek", $tmp[4]);
				}
			}elseif(strstr(strtolower($linestmp[$ii]), "/home/wuxiaolong/auto_delete.pl")){
				if(substr($linestmp[$ii], 0, 1)=="#"){
					$uploadservice = 0;
				}else{
					$uploadservice = 1;
					$linestmp[$ii]=trim($linestmp[$ii]);
					$tmp = preg_split("/[\s]+/", $linestmp[$ii]);
					$this->assign("pminute", $tmp[0]);
					$this->assign("phour", $tmp[1]);
					$this->assign("pday", $tmp[2]);
					$this->assign("pweek", $tmp[4]);
				}
			}
			$jj++;
		}
		$this->assign("uploadservice", $uploadservice);
		$this->assign("accountservice", $accountservice);
		$this->assign("chpwdservice", $chpwdservice);
		$this->display('cronjob2.tpl');
	}


	function cronjob_audit(){
		exec("sudo /home/wuxiaolong/5_backup/backup.pl", $out);
		echo '1';
		exit;
	}
	function cronjob_mastslav(){
		exec("sudo /home/wuxiaolong/5_backup/backup_session.pl", $out);
		echo '1';
		exit;
	}
	function cronjob_autodelete(){
		exec("sudo /home/wuxiaolong/auto_delete.pl", $out);
		echo '1';
		exit;
	}

	function String2File($sIn, $sFileOut) {
	  $rc = false;
	  do {
	   if (!($f = @fopen($sFileOut, "wa+"))) {
	     $rc = 1; 
	     alert_and_back('打开文件失败,请检查文件权限');
	     break;
	   }
	   if (fwrite($f, $sIn)===false) {
	     $rc = 2; 
	     alert_and_back('打开文件失败,请检查文件权限');
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
