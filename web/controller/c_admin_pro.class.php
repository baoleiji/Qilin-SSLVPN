<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_pro extends c_base {
	function dev_index($interface=false) {
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
		$from = get_request('from',0,1);
		$derive = get_request('derive');
		$where = '1=1';
		
		
		if($gid != 0) {
			$_tmpgid = $this->sgroup_set->select_by_id($gid);
			$where .= " AND (servers.groupid = $gid OR servers.groupid IN(".$_tmpgid['child'].") )";
		}

		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND servers.device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND servers.device_ip LIKE '%$ip%'";
		}

		if($hostname != '') {
			$where .= " AND hostname like '%$hostname%'";
		}

		if($_SESSION['ADMIN_LEVEL'] == 10 && $_CONFIG['PASSWORDUSER']==1) {
			$this->assign("showsystemuser","1");
		}
		
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				alert_and_back('没有可管理的组','admin.php?controller=admin_session');
				exit;
			}
			//$oldmem = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			//$where .= " AND svraddr IN (SELECT device_ip FROM servers WHERE groupid = ".$oldmem['mservergroup']." )";
			//$where .= " AND device_ip IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
			$where .= ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0 ' : '')." AND (servers.groupid>0 AND servers.groupid = (SELECT mservergroup FROM ".$this->member_set->get_table_name()." WHERE uid=".$_SESSION['ADMIN_UID'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")) ";


		}
		if(empty($orderby1)){
			$orderby1 = 'INET_ATON(servers.device_ip)';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		
		$sql = "SELECT servers.*,".($interface ? "NULL superpassword," : "")."(UNIX_TIMESTAMP(servers.asset_warrantdate)-UNIX_TIMESTAMP())/(60*60*24) warrantdays,dd.userct,dda.appuserct,ddapp.appct,
					(SELECT COUNT(is_modified) FROM ".$this->backup_set->get_table_name()." b 
						WHERE b.device_id IN (
							SELECT id FROM ".$this->devpass_set->get_table_name()." d 
								WHERE d.device_ip=servers.device_ip 
							) AND b.is_modified=1
					) ct FROM ".$this->server_set->get_table_name()." servers LEFT JOIN (SELECT COUNT(*) AS userct, device_ip FROM ".$this->devpass_set->get_table_name()." GROUP BY device_ip) dd ON servers.device_ip=dd.device_ip LEFT JOIN (SELECT COUNT(*) AS appct, device_ip FROM ".$this->appdevice_set->get_table_name()." GROUP BY device_ip) ddapp ON servers.device_ip=ddapp.device_ip LEFT JOIN (SELECT COUNT(*) AS appuserct, ip FROM ".$this->account_linuxusers_set->get_table_name()." GROUP BY ip) dda ON servers.device_ip=dda.ip 
						WHERE $where ORDER BY ".$orderby1." $orderby2";
		if($derive==1){	
			$this->derive($sql);
			exit;
		}elseif($derive==3){
			$this->export_pass($where);
			exit;
		}
		$tem = $this->tem_set->select_by_id($dev['template_id']);
		$this->assign('login_method',$tem['device_type'].'/'.$tem['login_method']);

		$row_num = $this->server_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		//$alldev = $this->server_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);
		
		
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$alldev = $this->server_set->base_select($sql);
		$alltem = $this->tem_set->select_all();
		$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');

		for($i=0;$i<count($alldev);$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
				elseif($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}
			}
			if($allgroup)
			foreach($allgroup as $groupt){
				if($groupt[id]==$alldev[$i][groupid]){
					$alldev[$i][groupname]=$groupt[groupname];
					break;
				}
			}
			if($alldev[$i]['month']  != '') {
				$alldev[$i]['method']  = language('每月').$alldev[$i]['month'].language('日');
			}
			elseif($alldev[$i]['week']  != '') {
				$alldev[$i]['method']  = language('每星期').$alldev[$i]['week'] ;
			}
			elseif($alldev[$i]['user_define']  != '') {
				$alldev[$i]['method']  = language('每隔').$alldev[$i]['user_define'] .language('天');
			}
		}
		if($interface){
			return $alldev;
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('nowseconds', time());
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('gid', $gid);
		$this->assign('from', $from);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('dev_index.tpl');
	}

	function devbatchdel() {
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
		$username = get_request('username',0,1);
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$logintype = get_request('logintype',0,1);
		$derive = get_request('derive');
		$where = '1=1';
		
		
		if($gid != 0) {
			$where .= " AND servers.groupid = $gid";
		}

		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND servers.device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND servers.device_ip LIKE '%$ip%'";
		}

		if($hostname != '') {
			$where .= " AND hostname like '%$hostname%'";
		}

		if($username != '') {
			$where .= " AND servers.device_ip IN(select device_ip FROM ".$this->devpass_set->get_table_name()." WHERE username like '%$username%')";
		}

		if($_SESSION['ADMIN_LEVEL'] == 10 && $_CONFIG['PASSWORDUSER']==1) {
			$this->assign("showsystemuser","1");
		}
		
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				alert_and_back('没有可管理的组','admin.php?controller=admin_session');
				exit;
			}
			//$oldmem = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			//$where .= " AND svraddr IN (SELECT device_ip FROM servers WHERE groupid = ".$oldmem['mservergroup']." )";
			//$where .= " AND device_ip IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
			
			$where .= ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0 ' : '')." AND (servers.groupid>0 AND servers.groupid = (SELECT mservergroup FROM ".$this->member_set->get_table_name()." WHERE uid=".$_SESSION['ADMIN_UID'].") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=(SELECT mservergroup FROM ".$this->member_set->get_table_name()." WHERE uid=".$_SESSION['ADMIN_UID'].")) or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=(SELECT mservergroup FROM ".$this->member_set->get_table_name()." WHERE uid=".$_SESSION['ADMIN_UID'].")))) ";
		}
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$sql = "SELECT servers.*,(UNIX_TIMESTAMP(servers.asset_warrantdate)-UNIX_TIMESTAMP())/(60*60*24) warrantdays,dd.userct,dda.appuserct,
					(SELECT COUNT(is_modified) FROM ".$this->backup_set->get_table_name()." b 
						WHERE b.device_id IN (
							SELECT id FROM ".$this->devpass_set->get_table_name()." d 
								WHERE d.device_ip=servers.device_ip 
							) AND b.is_modified=1
					) ct FROM ".$this->server_set->get_table_name()." servers LEFT JOIN (SELECT COUNT(*) AS userct, device_ip FROM ".$this->devpass_set->get_table_name()." GROUP BY device_ip) dd ON servers.device_ip=dd.device_ip  LEFT JOIN (SELECT COUNT(*) AS appuserct, ip FROM ".$this->account_linuxusers_set->get_table_name()." GROUP BY ip) dda ON servers.device_ip=dda.ip 
						WHERE $where ORDER BY ".$orderby1." $orderby2";
	
		$tem = $this->tem_set->select_by_id($dev['template_id']);
		$this->assign('login_method',$tem['device_type'].'/'.$tem['login_method']);

		$row_num = $this->server_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		//$alldev = $this->server_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$alldev = $this->server_set->base_select($sql);
		
		$alltem = $this->tem_set->select_all();
		$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		

		for($i=0;$i<$row_num;$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
				elseif($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}
			}
			if($allgroup)
			foreach($allgroup as $groupt){
				if($groupt[id]==$alldev[$i][groupid]){
					$alldev[$i][groupname]=$groupt[groupname];
					break;
				}
			}
			if($alldev[$i]['month']  != '') {
				$alldev[$i]['method']  = language('每月').$alldev[$i]['month'].language('日');
			}
			elseif($alldev[$i]['week']  != '') {
				$alldev[$i]['method']  = language('每星期').$alldev[$i]['week'] ;
			}
			elseif($alldev[$i]['user_define']  != '') {
				$alldev[$i]['method']  = language('每隔').$alldev[$i]['user_define'] .language('天');
			}
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('nowseconds', time());
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('gid', $gid);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("ip", $ip);
		$this->assign("hostname", $hostname);
		$this->assign("username", $username);
		$this->display('devbatchdel.tpl');
	}

	function dodevbatchdel(){
		$this->luser_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".implode("','", $_POST['chk_member'])."'))");
		$this->lgroup_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".implode("','", $_POST['chk_member'])."'))");
		$this->resgroup_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".implode("','", $_POST['chk_member'])."'))");
		$this->devpass_set->delete_all("device_ip IN('".implode("','", $_POST['chk_member'])."')");
		$this->server_set->delete_all("device_ip IN('".implode("','", $_POST['chk_member'])."')");
		$this->sshkey_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".implode("','", $_POST['chk_member'])."'))");
		alert_and_back('操作成功');
	}

	function dodevbatchremove(){
		$ips = get_request('ips', 0, 1);
		$ip = explode(',', $ips);
		$this->luser_set->query("UPDATE ".$this->server_set->get_table_name()." SET groupid=0 WHERE device_ip IN('".implode("','", $ip)."')");
		alert_and_back('操作成功');
	}

	function derive($sql){
		$allsession = $this->server_set->base_select($sql);
		$str = language("服务器地址")."\t".language("主机名")."\t".language("系统")."\t".language("设备组")."\t".language("修改策略")." \t". language("透明审计")."\t\n";
		@unlink(ROOT.'tmp/ReportList.xls');
		$handle = @fopen(ROOT . 'tmp/ReportList.xls', 'w');
		if(!$handle){
			alert_and_back('写入文件出错,请检查文件权限');
			exit;
		}
		$id=1;
		if($allsession){
			$alltem = $this->tem_set->select_all();
			foreach ($allsession AS $report){	
				for($i=0;$i<count($allsession);$i++) {
					foreach($alltem as $tem) {
						if($report['login_method'] == $tem['id']) {
							$report['login_method'] = $tem['login_method'];
						}
						elseif($report['device_type'] == $tem['id']) {
							$report['device_type'] = $tem['device_type'];
						}
					}
					$_groups = $this->sgroup_set->select_all("groupname=(select groupname from ".$this->sgroup_set->get_table_name()." WHERE id=".$report['groupid'].")");
					if(count($_groups)>1){
						$report['groupname']=$_groups[0]['groupname'].'('.$report['groupid'].')';
					}elseif($_groups){
						$report['groupname']=$_groups[0]['groupname'];
					}
					if($report['month']  != '') {
						$report['method']  = language('每月').$report['month'].language('日');
					}
					elseif($report['week']  != '') {
						$report['method']  = language('每星期').$report['week'] ;
					}
					elseif($report['user_define']  != '') {
						$report['method']  = language('每隔').$report['user_define'] .language('天');
					}
				}
				
				$str .= $report['device_ip']."\t".$report['hostname']."\t".$report['device_type']."\t".$report['groupname']."\t".$report['method']."\t".($report['transport'] ? '打开':'关闭');
				$str .= "\n";
			}
				
		}
		$str = mb_convert_encoding($str, "GBK", "UTF-8");
		fwrite($handle, $str);
		fclose($handle);
		go_url("tmp/ReportList.xls?c=" . rand());
		exit;
	}
	
	function groupadddev(){
		$gid = get_request("gid");
		$ip = get_request("ip", 0, 1);
		$from = get_request("from", 0, 1);
		$hostname = get_request("hostname", 0, 1);
		$where = ' id NOT IN (SELECT id FROM '.$this->server_set->get_table_name().' WHERE groupid='.$gid.')';
		if($ip){
			$where .= " AND device_ip like '%$ip%'";
		}
		if($hostname){
			$where .= " AND hostname like '%$hostname%'";
		}
		$alldev = $this->server_set->select_all($where, 'device_ip', 'asc');
		$this->assign("gid", $gid);
		$this->assign("title", language("增加设备"));
		$this->assign("alldev", $alldev);
		$this->assign("from", $from);
		$this->assign('groupinfo', $this->sgroup_set->select_by_id($gid));
		$this->display('groupadddev.tpl');
	}
	
	function groupadddev_save(){
		$gid = get_request("gid");
		if($_POST['id'])
		$this->server_set->query("UPDATE ".$this->server_set->get_table_name()." SET groupid=".$gid." WHERE id IN (".implode(',', $_POST['id']).")");
		echo '<script language=\'javascript\'>window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
			//exit;
		//alert_and_back('添加成功','admin.php?controller=admin_pro&action=dev_index&gid='.$gid);
	}

	function profilebackup() {
		$page_num = get_request('page');
		$ip = get_request('ip',0,1);
		$orderby = get_request('orderby',0,1);
		$devs = $this->devpass_set->select_all(' device_ip=\''.$ip.'\' and master_user=1');
		if(empty($devs)){
			alert_and_back("该设备没有管理账号");
			exit;
		}
		$where = '  device_id=('.$devs[0]['id'].')';

		$row_num = $this->backup_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->backup_set->base_select("SELECT b.*,d.device_ip FROM `backup` b LEFT JOIN devices d ON b.device_id=d.id where $where AND d.device_ip IS NOT NULL LIMIT ".$newpager->intStartPosition." ,". $newpager->intItemsPerPage);

		$this->assign('title', language('文件列表'));
		$this->assign("alldev", $alldev);
		$this->assign("device_id", $devs[0]['id']);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('profilebackup.tpl');
	}
	
	function profilebackup_delete() {
		$id = get_request('id',1,1);
		if(empty($id)){
			$id = get_request('id');
		}
		$alltype = $this->backup_set->delete($id);			
		alert_and_back("操作成功");
	}
	
	
	function profilebackup_edit() {
		$device_id = get_request('device_id',0,1);
		$alltype = $this->tem_set->select_all("login_method = ''");
		$deviceinfo = $this->devpass_set->select_by_id($device_id);
		for($i=0; $i<count($alltype); $i++){
			if($alltype[$i]['id']==$deviceinfo['device_type']){
				$this->smarty->assign("device_type", strtolower($alltype[$i]['device_type']));
			}
		}
		$this->assign('alltype',$alltype);
		$this->assign('title',language("配置文件收集"));
		$this->assign("device_id", $device_id);
		$this->display('profilebackup_edit.tpl');
	}

	function profilebackup_update() {
		global $_CONFIG;
		$id = get_request('id');
		$bfile = $this->backup_set->select_by_id($id);
		if($bfile['is_modified']){
			$cmd = "sudo python ".$_CONFIG['site']['probackup']."update.py -i ".$bfile['device_id']." -f ".$bfile['file_path'];
			system($cmd,$out);
			//var_dump($out);
			if(trim($out)==1){
				//echo "更新成功";				
				$backup = new backup();
				$backup->set_data("id", $id);
				$backup->set_data("is_modified", 0);
				$this->backup_set->edit($backup);
				alert_and_back("更新成功");
				exit;
			}else{
				//echo "配置文件不能下载";
				alert_and_back("配置文件不能下载");
				exit;
			}
		}else{
			//echo "不需要更新";
			alert_and_back("不需要更新");
			exit;
		}
	}
	
	function profilebackup_save() {	
		global $_CONFIG;	
		$device_id = get_request('device_id', 1, 0);
		$configfile = get_request('configfile', 1, 1);
		$deviceinfo = $this->devpass_set->select_by_id($device_id);
		if(empty($configfile)){
			alert_and_back('文件名不能为空');
			exit;
		}
		if($configfile == 'run' or $configfile == 'start'){
			$cmd = "sudo python ".$_CONFIG['site']['probackup']."save.py -i ".$device_id." -f ".$configfile;
			system($cmd,$out);
			//var_dump($out);
			if(trim($out)==1){
				$backup = new backup();
				$backup->set_data("device_id", $device_id);
				$backup->set_data("file_path", $configfile);
				$backup->set_data("is_modified", 0);
				$backup->set_data("last_modified_time", date('y-m-d H:i:s'));
				$backup->set_data("mail_id", $_SESSION['ADMIN_UID']);
				$this->backup_set->add($backup);
				//echo "操作成功!";
				alert_and_back("操作成功","admin.php?controller=admin_pro&action=profilebackup&ip=$deviceinfo[device_ip]&device_id=$device_id");
				exit;
			}else{
				//echo "配置文件不能下载";
				alert_and_back("配置文件不能下载");
				exit;
			}
		}elseif (!empty($configfile)){
			$cmd = "sudo python ".$_CONFIG['site']['probackup']."/save.py -i ".$device_id." -f ".$configfile;
			system($cmd,$out);
			//var_dump($out);
			if(trim($out)==1){
				$backup = new backup();
				$backup->set_data("device_id", $device_id);
				$backup->set_data("file_path", $configfile);
				$backup->set_data("is_modified", 0);
				$backup->set_data("last_modified_time", date('y-m-d H:i:s'));
				$backup->set_data("mail_id", $_SESSION['ADMIN_UID']);
				$this->backup_set->add($backup);	
				//echo "操作成功!";
				alert_and_back("操作成功","admin.php?controller=admin_pro&action=profilebackup&ip=$deviceinfo[device_ip]&device_id=$device_id");
				exit;
			}else{
				//echo "配置文件不能下载";
				alert_and_back("配置文件不能下载");
				exit;
			}
		}
	}

	function dev_edit() {
		global $_CONFIG;
		$page_num = get_request('page');
		$id = get_request('id');
		$gid = get_request('gid');
		$tab = get_request('tab');
		$appconfigedit = get_request('appconfigedit');
		$appconfigid = get_request('appconfigid');

		$allmethod =  $this->tem_set->select_all("device_type = ''");
		$alltype = $this->tem_set->select_all("login_method = ''", 'device_type', 'asc');
		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)",'username','ASC');
		
		$old_dev = $this->server_set->select_by_id($id);
		if($_SESSION['ADDDEV']){
			$old_dev = $_SESSION['ADDDEV'];
		}//var_dump($old_dev);
		$num = count($allmem);
		for($i=0;$i<$num;$i++) {
			$allmem[$i]['username'] = ($allmem[$i]['username']);
		}
		if($id&&$tab!=4){
		$_SESSION['dev_edit_appconfig']=$this->snmp_app_config_set->select_all("device_ip='".$old_dev['device_ip']."'", "app_name", "ASC");
		}

		if($appconfigid){
			for($i=0; $i<count($_SESSION['dev_edit_appconfig']); $i++){
				if($_SESSION['dev_edit_appconfig'][$i]['seq']==$appconfigid){
					$appconfig = $_SESSION['dev_edit_appconfig'][$i];
				}
			}
			//$appconfig = $this->snmp_app_config_set->select_by_id($appconfigid);
			$this->assign("appconfig1", $appconfig);
		}
		$this->assign("logined_user_level", 1);
		$logined_user_level=1;
		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			$adminsgroup = $this->sgroup_set->select_by_id($_SESSION['ADMIN_MSERVERGROUP']);
			$adminsgroup['level']=($adminsgroup['level']==0 ? 6 : $adminsgroup['level']);
			$this->assign("logined_user_level", $adminsgroup['level']);
			$logined_user_level=$adminsgroup['level'];
		}
		$groupid = $old_dev['groupid'];
		require('./include/select_sgroup_ajax.inc.php');


		if($id != 0 || $old_dev) {
			$this->assign('id',$id);
			
			if($old_dev['groupid']){
				$sgroup = $this->sgroup_set->select_by_id($old_dev['groupid']);		
				$this->assign('sgroup',$sgroup);
			}
			$_SERVER['QUERY_STRING'] .= "&tab=0";
			$where = "ip='".$old_dev['device_ip']."'";
			$row_num = $this->account_linuxusers_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$alldev = $this->account_linuxusers_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, 'ip','asc');
			$alltem = $this->tem_set->select_all();
			for($i=0;$i<$row_num;$i++) {
				foreach($alltem as $tem) {
					if($alldev[$i]['device_type'] == $tem['id']) {
						$alldev[$i]['device_type'] = $tem['device_type'];
					}elseif($alldev[$i]['login_method'] == $tem['id']) {
						$alldev[$i]['login_method'] = $tem['login_method'];
					}
				}
				if($alldev[$i]['radiususer']){
					$alldev[$i]['radiususer_is_in_member'] = $this->member_set->select_count("username='".$alldev[$i]['username']."'");
				}
			}
			$curr_url = $_SERVER['PHP_SELF'] . "?";
			if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
				$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
			}
			else {
				$curr_url .= $_SERVER['QUERY_STRING'];
			}
			$this->assign('curr_url', $curr_url);
			$this->assign('ip',$ip);
			$this->assign('gid', $gid);
			$this->assign('serverid', $id);
			$this->assign('server', $old_dev);
			$this->assign('alldev', $alldev);
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('total', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);

			$this->assign('IP',$old_dev['device_ip']);
			$this->assign('type_id',$old_dev['device_type']);
			$this->assign('ipv6',$old_dev['ipv6']);
			$this->assign('l_id',$old_dev['login_method']);
			$this->assign('hostname',$old_dev['hostname']);
			$this->assign('g_id',$old_dev['groupid']);
			$this->assign('monitor',$old_dev['monitor']);
			$this->assign('snmpkey',$old_dev['snmpkey']);
			$this->assign('asset_id',$old_dev['asset_id']);
			$this->assign('snmpnet',$old_dev['snmpnet']);
			$this->assign('port',$old_dev['port']);
			$this->assign('port_monitor',$old_dev['port_monitor']);
			$this->assign('port_monitor_time',$old_dev['port_monitor_time']);
			$this->assign('transport',$old_dev['transport']);
			$this->assign('sshport',$old_dev['sshport'] ? $old_dev['sshport'] : '22');
			$this->assign('telnetport',$old_dev['telnetport']? $old_dev['telnetport'] : '23');
			$this->assign('ftpport',$old_dev['ftpport']? $old_dev['ftpport'] : '21');
			$this->assign('rdpport',$old_dev['rdpport']? $old_dev['rdpport'] : '3389');
			$this->assign('vncport',$old_dev['vncport']? $old_dev['vncport'] : '5900');
			$this->assign('x11port',$old_dev['x11port']? $old_dev['x11port'] : '3389');
			$this->assign('asset_name',$old_dev['asset_name']);
			$this->assign('asset_specification',$old_dev['asset_specification']);
			$this->assign('asset_department',$old_dev['asset_department']);
			$this->assign('asset_location',$old_dev['asset_location']);
			$this->assign('asset_company',$old_dev['asset_company']);
			$this->assign('asset_start',$old_dev['asset_start']);
			$this->assign('asset_usedtime',$old_dev['asset_usedtime']);
			$this->assign('asset_warrantdate',$old_dev['asset_warrantdate']);
			$this->assign('asset_status',$old_dev['asset_status']);
			$this->assign('oracle_name', $old_dev['oracle_name']);
			$this->assign('loadbalance', $old_dev['loadbalance']);
			$this->assign('superpassword',$this->member_set->udf_decrypt($old_dev['superpassword']));
			$users = explode(',',$old_dev['luser']);
			for($i=1;$i<6;$i++) {
				$this->assign("user$i",$users[$i]);
			}
			if($old_dev['month']  != '') {
				$this->assign('method','mon');
				$this->assign('freq',$old_dev['month']);
			}
			elseif($old_dev['week']  != '') {
				$this->assign('method','week');
				$this->assign('freq',$old_dev['week']);
			}
			elseif($old_dev['user_define']  != '') {
				$this->assign('method','user');
				$this->assign('freq',$old_dev['user_define']);
			}
		}
		else {
			foreach($alltype as $type) {
				if($type['default'] == 1) {
					$this->assign('type_id',$type['id']);
				}
			}
		}
		$loadbalanceips = $this->loadbalance_set->select_all('1', 'ip', 'asc');		
		$this->assign('tab',($tab=='') ? 1 : $tab);
		$this->assign('appconfigedit',$appconfigedit);
		$this->assign('appconfigid',$_SESSION['dev_edit_appconfig']);
		$this->assign('allmethod',$allmethod);
		$this->assign('allpasses',$allmem);
		$this->assign('alltype',$alltype);
		$this->assign('alldev',$alldev);
		$this->assign('gid',$gid);
		$this->assign('caction',$_CONFIG['CACTI_ON']);
		$this->assign('loadbalanceips',$loadbalanceips);
		$this->assign('appconfig', $_SESSION['dev_edit_appconfig']);
		$this->assign('title',language("管理设备"));
		$this->assign('_config',$_CONFIG);
		$this->display('dev_edit.tpl');
	}

	function dev_save($interface=false) {
		global $_CONFIG;
		/*$new_ip = get_request('IP',1,1);
		$new_hostname = get_request('hostname',1,1);
		$new_method = get_request('l_id',1,0);
		$new_devtype = get_request('type_id',1,0);
		$ipv6 = get_request('ipv6',1,1);
		$new_type = get_request('stra_type',1,1);
		$new_freq = get_request('freq',1,1);
		$new_port = get_request('port',1,0);
		$asset_id = get_request('asset_id',1,0);
		$transport = get_request('transport',1,0);
		$snmpnet = get_request('snmpnet',1,0);
		$new_sshport = get_request('sshport',1,0);
		$new_telnetport = get_request('telnetport',1,0);
		$new_ftpport = get_request('ftpport',1,0);
		$new_rdpport = get_request('rdpport',1,0);
		$new_vncport = get_request('vncport',1,0);
		$new_x11port = get_request('x11port',1,0);
		$port_monitor = get_request('port_monitor',1,1);
		$port_monitor_time = get_request('port_monitor_time',1,0);
		$oracle_name = get_request('oracle_name',1,1);
		$monitor = get_request('monitor',1,0);
		$snmpkey = get_request('snmpkey',1,1);
		$superpassword = htmlspecialchars_decode(get_request('superpassword',1,1));
		$superpassword2 = htmlspecialchars_decode(get_request('superpassword2',1,1));
		$asset_name = get_request('asset_name',1,1);
		$asset_specification = get_request('asset_specification',1,1);
		$asset_department = get_request('asset_department',1,1);
		$asset_location = get_request('asset_location',1,1);
		$asset_company = get_request('asset_company',1,1);
		$asset_start = get_request('asset_start',1,1);
		$asset_usedtime = get_request('asset_usedtime',1,1);
		$asset_warrantdate = get_request('asset_warrantdate',1,1);
		$asset_status = get_request('asset_status',1,1);
		$doappconfigedit = get_request('doappconfigedit',1,1);
		$app_name = get_request('app_name',1,1);
		$appport = get_request('appport',1,0);
		$desc = get_request('desc',1,1);
		$app_get = get_request('app_get',1,1);
		$apache_type = get_request('apache_type',1,1);
		$mysql_type = get_request('mysql_type',1,1);
		$username = get_request('username',1,1);
		$password = htmlspecialchars_decode(get_request('password',1,1));
		$repassword = htmlspecialchars_decode(get_request('repassword',1,1));
		$enable = get_request('enable',1,1);
		$gid = get_request('gid');*/
		
		$new_devtype = $_SESSION['ADDDEV']['device_type'] = get_request('type_id',1,0);
		$new_ip = $_SESSION['ADDDEV']['device_ip'] =get_request('IP',1,1);
		$new_hostname = $_SESSION['ADDDEV']['hostname']=get_request('hostname',1,1);
		$new_method = $_SESSION['ADDDEV']['login_method']=get_request('l_id',1,0);
		$ipv6 = $_SESSION['ADDDEV']['ipv6']=get_request('ipv6',1,1);
		$new_type = $_SESSION['ADDDEV']['stra_type']=get_request('stra_type',1,1);
		$new_freq = $_SESSION['ADDDEV']['freq']=get_request('freq',1,1);
		switch($new_type) {
			case 'mon' :
				$_SESSION['ADDDEV']['month']=$new_freq;
				$_SESSION['ADDDEV']['week']='';
				$_SESSION['ADDDEV']['user_define']='';
				break;
			case 'week':
				$_SESSION['ADDDEV']['month']='';
				$_SESSION['ADDDEV']['week']=$new_freq;
				$_SESSION['ADDDEV']['user_define']='';
				break;
			case 'custom':
				$_SESSION['ADDDEV']['month']='';
				$_SESSION['ADDDEV']['week']='';
				$_SESSION['ADDDEV']['user_define']=$new_freq;
			default:
		}
		$new_port = $_SESSION['ADDDEV']['port']=get_request('port',1,0);
		$asset_id = $_SESSION['ADDDEV']['asset_id']=get_request('asset_id',1,0);
		$transport = $_SESSION['ADDDEV']['transport']=get_request('transport',1,0);
		$snmpnet = $_SESSION['ADDDEV']['snmpnet']=get_request('snmpnet',1,0);
		$new_sshport = $_SESSION['ADDDEV']['sshport']=get_request('sshport',1,0);
		$new_telnetport = $_SESSION['ADDDEV']['telnetport']=get_request('telnetport',1,0);
		$new_ftpport = $_SESSION['ADDDEV']['ftpport']=get_request('ftpport',1,0);
		$new_rdpport = $_SESSION['ADDDEV']['rdpport']=get_request('rdpport',1,0);
		$new_vncport = $_SESSION['ADDDEV']['vncport']=get_request('vncport',1,0);
		$new_x11port = get_request('x11port',1,0);
		$port_monitor = $_SESSION['ADDDEV']['port_monitor']=get_request('port_monitor',1,1);
		$port_monitor_time = $_SESSION['ADDDEV']['port_monitor_time']=get_request('port_monitor_time',1,0);
		$oracle_name = $_SESSION['ADDDEV']['oracle_name']=get_request('oracle_name',1,1);
		$monitor = $_SESSION['ADDDEV']['monitor']=get_request('monitor',1,0);
		$snmpkey = $_SESSION['ADDDEV']['snmpkey']=get_request('snmpkey',1,1);
		$superpassword = (htmlspecialchars_decode($_SESSION['ADDDEV']['superpassword']=get_request('superpassword',1,1)));
		$superpassword2 = (htmlspecialchars_decode(get_request('superpassword2',1,1)));
		$asset_name = $_SESSION['ADDDEV']['asset_name']=get_request('asset_name',1,1);
		$asset_specification = $_SESSION['ADDDEV']['asset_specification']=get_request('asset_specification',1,1);
		$asset_department = $_SESSION['ADDDEV']['asset_department']=get_request('asset_department',1,1);
		$asset_location = $_SESSION['ADDDEV']['asset_location']=get_request('asset_location',1,1);
		$asset_company = $_SESSION['ADDDEV']['asset_company']=get_request('asset_company',1,1);
		$asset_start = $_SESSION['ADDDEV']['asset_start']=get_request('asset_start',1,1);
		$asset_usedtime = $_SESSION['ADDDEV']['asset_usedtime']=get_request('asset_usedtime',1,1);
		$asset_warrantdate = $_SESSION['ADDDEV']['asset_warrantdate']=get_request('asset_warrantdate',1,1);
		$asset_status = $_SESSION['ADDDEV']['asset_status']=get_request('asset_status',1,1);
		$doappconfigedit = $_SESSION['ADDDEV']['doappconfigedit']=get_request('doappconfigedit',1,1);
		$app_name = $_SESSION['ADDDEV']['app_name']=get_request('app_name',1,1);
		$appport = $_SESSION['ADDDEV']['appport']=get_request('appport',1,0);
		$desc = $_SESSION['ADDDEV']['desc']=get_request('desc',1,1);
		$app_get = $_SESSION['ADDDEV']['app_get']=get_request('app_get',1,1);
		$apache_type = $_SESSION['ADDDEV']['apache_type']=get_request('apache_type',1,1);
		$mysql_type = $_SESSION['ADDDEV']['mysql_type']=get_request('mysql_type',1,1);
		$username = $_SESSION['ADDDEV']['username']=get_request('username',1,1);
		$password = htmlspecialchars_decode($_SESSION['ADDDEV']['password']=get_request('password',1,1));
		$repassword = htmlspecialchars_decode($_SESSION['ADDDEV']['repassword']=get_request('repassword',1,1));
		$enable = $_SESSION['ADDDEV']['enable']=get_request('enable',1,1);
		$gid = $_SESSION['ADDDEV']['gid']=get_request('gid');
		
		/*
		$new_user = ',';
		for($i=1;$i<6;$i++) {
			$new_user .= get_request("user$i",1,0).',';
		}
		*/
		
		$_SESSION['ADDDEV']['groupid']=$new_group = $_POST['groupid'];
		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			if(!in_array($new_group, $_SESSION['ADMIN_MSERVERGROUP_IDS'])){
				alert_and_back("请选择管理权限范围内的组");
				return;
			}
		}
		
		$id = get_request('id');
		$apcid = get_request('appconfigid');
		if($doappconfigedit){
			
			$_old_dev = $this->server_set->select_by_id($id);
			if($password!=$repassword&&$app_name!='dns'){
				alert_and_back("两次输入的密码不一样");
				return;
			}
			$found = 0;
			for($i=0; $i<count($_SESSION['dev_edit_appconfig']); $i++){
				if($_SESSION['dev_edit_appconfig'][$i]['seq']==$apcid || $_SESSION['dev_edit_appconfig'][$i]['app_name'] == $app_name){					
					$_SESSION['dev_edit_appconfig'][$i]['app_get'] = $app_get;
					$_SESSION['dev_edit_appconfig'][$i]['app_type'] = ${$app_name.'_type'};
					$_SESSION['dev_edit_appconfig'][$i]['username'] = $username;
					$_SESSION['dev_edit_appconfig'][$i]['password'] = $password;
					$_SESSION['dev_edit_appconfig'][$i]['enable'] = $enable;
					$_SESSION['dev_edit_appconfig'][$i]['desc'] = $desc;
					$_SESSION['dev_edit_appconfig'][$i]['port'] = $appport;
					$found = 1;
					if($apcid){
						$appconfig = new snmp_app_config();
						$appconfig->set_data('app_name', $_SESSION['dev_edit_appconfig'][$i]['app_name']);
						$appconfig->set_data('username', $_SESSION['dev_edit_appconfig'][$i]['username']);
						$appconfig->set_data('password', $_SESSION['dev_edit_appconfig'][$i]['password']);
						$appconfig->set_data('enable', $_SESSION['dev_edit_appconfig'][$i]['enable']);
						$appconfig->set_data('desc', $_SESSION['dev_edit_appconfig'][$i]['desc']);
						$appconfig->set_data('port', $_SESSION['dev_edit_appconfig'][$i]['port']);
						$appconfig->set_data('seq', $_SESSION['dev_edit_appconfig'][$i]['seq']);
						$this->snmp_app_config_set->edit($appconfig);
					}
				}
			}
			if($found==0){
				$len = count($_SESSION['dev_edit_appconfig']);
				$_SESSION['dev_edit_appconfig'][$len]['app_name'] = $app_name;
				$_SESSION['dev_edit_appconfig'][$len]['app_get'] = $app_get;
				$_SESSION['dev_edit_appconfig'][$len]['app_type'] = ${$app_name.'_type'};
				$_SESSION['dev_edit_appconfig'][$len]['username'] = $username;
				$_SESSION['dev_edit_appconfig'][$len]['password'] = $password;
				$_SESSION['dev_edit_appconfig'][$len]['enable'] = $enable;
				$_SESSION['dev_edit_appconfig'][$len]['desc'] = $desc;		
				$_SESSION['dev_edit_appconfig'][$len]['port'] = $appport;
				$appconfig = new snmp_app_config();
				$appconfig->set_data('device_ip', $_old_dev['device_ip']);
				$appconfig->set_data('app_name', $_SESSION['dev_edit_appconfig'][$len]['app_name']);
				$appconfig->set_data('username', $_SESSION['dev_edit_appconfig'][$len]['username']);
				$appconfig->set_data('password', $_SESSION['dev_edit_appconfig'][$len]['password']);
				$appconfig->set_data('enable', $_SESSION['dev_edit_appconfig'][$len]['enable']);
				$appconfig->set_data('desc', $_SESSION['dev_edit_appconfig'][$len]['desc']);
				$appconfig->set_data('port', $_SESSION['dev_edit_appconfig'][$len]['port']);
				$this->snmp_app_config_set->add($appconfig);	
				$_SESSION['dev_edit_appconfig'][$len]['seq'] = mysql_insert_id();
			}
			alert_and_back('已记录','admin.php?controller=admin_pro&action=dev_edit&id='.$id.'&gid='.$gid.'&tab=4&apptable=1');
			return;
		}
		if(empty($new_group)){
			alert_and_back("请选择设备组");
			return;
		}
		if(!is_ip($new_ip)){
			alert_and_back('请输入正确的IP地址格式');
			return;
		}
		if($superpassword!=$superpassword2){
			alert_and_back('两次输入的密码不一致');
			return;
		}
		if($superpassword){
			$pwd_ban_word_arr = explode('1', str_replace(' ', '空格', $_CONFIG['PASSWORD_BAN_WORD']));			
			if($pwd_ban_word_arr){
				$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
			}			
			for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
				if($pwd_ban_word_arr[$pi]&&strpos($superpassword, $pwd_ban_word_arr[$pi])!==false){
					alert_and_back('密码中不能包含以下字符:'.addslashes($pwd_ban_word_str).' 请重新输入');
					return;
				}
			}
		}

		if($id == 0 ) {
			if(0 == $this->server_set->select_count("device_ip = '$new_ip' ")) {
					$new_dev = new server();
					$new_dev->set_data('device_ip',$new_ip);
					$new_dev->set_data('hostname',$new_hostname);
					$new_dev->set_data('asset_id',$asset_id);
					$new_dev->set_data('ipv6',$ipv6);
					$new_dev->set_data('login_method',$new_method);
					$new_dev->set_data('device_type',$new_devtype);
					$new_dev->set_data('snmpnet',$snmpnet);
					$new_dev->set_data('port',$new_port);
					$new_dev->set_data('groupid',$new_group);
					$new_dev->set_data('superpassword', $this->member_set->udf_encrypt($superpassword));
					$new_dev->set_data('transport', $transport);
					$new_dev->set_data('sshport', $new_sshport);
					$new_dev->set_data('telnetport', $new_telnetport);
					$new_dev->set_data('ftpport', $new_ftpport);
					$new_dev->set_data('snmpkey', $snmpkey);
					$new_dev->set_data('monitor', $monitor);
					$new_dev->set_data('port_monitor_time', $port_monitor_time);
					$new_dev->set_data('port_monitor', $port_monitor);
					$new_dev->set_data('rdpport', $new_rdpport);
					$new_dev->set_data('vncport', $new_vncport);
					$new_dev->set_data('x11port', $new_x11port);
					$new_dev->set_data('asset_name', $asset_name);
					$new_dev->set_data('asset_specification', $asset_specification);
					$new_dev->set_data('asset_department', $asset_department);
					$new_dev->set_data('asset_location', $asset_location);
					$new_dev->set_data('asset_company', $asset_company);
					$new_dev->set_data('asset_start', $asset_start);
					$new_dev->set_data('asset_usedtime', $asset_usedtime);
					$new_dev->set_data('asset_warrantdate', $asset_warrantdate);
					$new_dev->set_data('asset_status', $asset_status);
					$new_dev->set_data('oracle_name', $oracle_name);
					if($interface){
						$new_dev->set_data('interface',1);
					}
					//$this->sgroup_set->insert_user($new_group);
					//$new_dev->set_data('luser',$new_user);
					switch($new_type) {
						case 'mon' :
							$new_dev->set_data('month',$new_freq);
							break;
						case 'week':
							$new_dev->set_data('week',$new_freq);
							break;
						case 'custom':
							$new_dev->set_data('user_define',$new_freq);
						default:
					}


				

					$this->server_set->add($new_dev);
					
					if(mysql_insert_id()&&$new_group){

						$this->sgroup_set->updates($new_group, null);
						if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
							$this->sgroupcache_set->updates($new_group, null);
						}
						/*
						$_gp = array();
						$_g = $this->sgroup_set->select_by_id($new_group);
						$_gp[]=$_g['id'];
						while($_g['ldapid']){
							$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
							$_gp[]=$_g['id'];
						}
						$this->member_set->query("UPDATE servergroup set count=count+1 where id in(".implode(',', $_gp).")");
						*/
					}
					
					$serverResult = $this->server_set->select_all(" groupid=$new_group");
					if($serverResult){
						foreach ($serverResult AS $key => $value){
							$serverIds[] = $value['id'];
						}
					}
					$serverString=implode(",", $serverIds);
					$this->member_set->update('devs', ",".$serverString.",", " mservergroup=$new_group and level=3");
		
					$adminlog = new admin_log();
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
					$adminlog->set_data('action', language('增加设备'));
					$adminlog->set_data('resource', $new_ip);
					$adminlog->set_data('type', 14);
					$this->admin_log_set->add($adminlog);

					$this->appconfig_save($new_ip);
					//$this->server_set->query("UPDATE ".$this->sgroup_set->get_table_name()." a SET count=(select count(*) FROM ".$this->server_set->get_table_name()." b WHERE a.id=b.groupid) where a.id='".$new_group."'");
					$_SESSION['ADDDEV']=null;
					$this->server_set->query("UPDATE ".$this->devpass_set->get_table_name()." SET device_type=".$new_devtype." WHERE device_ip='".$new_ip."'");
					echo '<script language=\'javascript\'>alert(\'添加成功\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
					//alert_and_back('添加成功','admin.php?controller=admin_pro&action=dev_index&gid='.$gid);
			}
			else {
				alert_and_back('添加失败,该设备的IP已存在','admin.php?controller=admin_pro&action=dev_edit&ntype=new');
			}
		}
		else {
				$new_dev = new server();
				$new_dev->set_data('id',$id);
				$old_dev = $this->server_set->select_by_id($id);
				$new_dev->set_data('hostname',$new_hostname);
				$new_dev->set_data('login_method',$old_dev['login_method']);
				$new_dev->set_data('device_type',$new_devtype);
				$new_dev->set_data('port',$old_dev['port']);
				$new_dev->set_data('ipv6',$ipv6);
				$new_dev->set_data('device_ip',$new_ip);
				$new_dev->set_data('asset_id',$asset_id);
				$new_dev->set_data('groupid',$new_group);
				$new_dev->set_data('superpassword', $this->member_set->udf_encrypt($superpassword));
				$new_dev->set_data('transport', $transport);
				$new_dev->set_data('sshport', $new_sshport);
				$new_dev->set_data('snmpkey', $snmpkey);
				$new_dev->set_data('snmpnet',$snmpnet);
				$new_dev->set_data('monitor', $monitor);
				$new_dev->set_data('port_monitor_time', $port_monitor_time);
				$new_dev->set_data('port_monitor', $port_monitor);
				$new_dev->set_data('telnetport', $new_telnetport);
				$new_dev->set_data('ftpport', $new_ftpport);
				$new_dev->set_data('rdpport', $new_rdpport);
				$new_dev->set_data('vncport', $new_vncport);
				$new_dev->set_data('x11port', $new_x11port);
				$new_dev->set_data('asset_name', $asset_name);
				$new_dev->set_data('asset_specification', $asset_specification);
				$new_dev->set_data('asset_department', $asset_department);
				$new_dev->set_data('asset_location', $asset_location);
				$new_dev->set_data('asset_company', $asset_company);
				$new_dev->set_data('asset_start', $asset_start);
				$new_dev->set_data('asset_usedtime', $asset_usedtime);
				$new_dev->set_data('asset_warrantdate', $asset_warrantdate);
				$new_dev->set_data('asset_status', $asset_status);
				$new_dev->set_data('oracle_name', $oracle_name);
				//$this->sgroup_set->insert_user($new_group);
				//$this->sgroup_set->remove_user($old_dev['groupid']);
				$this->devpass_set->update_server($new_dev, $old_dev);
				//$new_dev->set_data('luser',$new_user);
				switch($new_type) {
					case 'mon' :
						$new_dev->set_data('month',$new_freq);
						$new_dev->set_data('week','');
						$new_dev->set_data('user_define','');
						break;
					case 'week':
						$new_dev->set_data('month','');
						$new_dev->set_data('week',$new_freq);
						$new_dev->set_data('user_define','');
						break;
					case 'custom':
						$new_dev->set_data('month','');
						$new_dev->set_data('week','');
						$new_dev->set_data('user_define',$new_freq);
					default:
				}
				$this->server_set->edit($new_dev);

				if(mysql_affected_rows()>0&&$new_group!=$old_dev['groupid']){
					$this->sgroup_set->updates($new_group, $old_dev['groupid']);
					if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
						$this->sgroupcache_set->updates($new_group, $old_dev['groupid']);
					}
					/*
					$_gp = array();
					$_g = $this->sgroup_set->select_by_id($new_group);
					$_gp[]=$_g['id'];
					while($_g['ldapid']){
						$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
						$_gp[]=$_g['id'];
					}
					$this->member_set->query("UPDATE servergroup set count=count+1 where id in(".implode(',', $_gp).")");
					$_gp=null;
					$_gp = array();
					$_g = $this->sgroup_set->select_by_id($old_dev['groupid']);
					$_gp[]=$_g['id'];
					while($_g['ldapid']){
						$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
						$_gp[]=$_g['id'];
					}
					$this->member_set->query("UPDATE servergroup set count=count-1 where id in(".implode(',', $_gp).")");
					*/
				}
				$this->appconfig_save($old_dev['device_ip']);
				$adminlog = new admin_log();
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('action', '修改设备');
				$adminlog->set_data('resource', $new_ip);
				$adminlog->set_data('type', 14);
				$this->admin_log_set->add($adminlog);
				//$this->server_set->query("UPDATE ".$this->sgroup_set->get_table_name()." a SET count=(select count(*) FROM ".$this->server_set->get_table_name()." b WHERE a.id=b.groupid) where a.id='".$new_group."'");
				$_SESSION['ADDDEV']=null;
				$this->server_set->query("UPDATE ".$this->devpass_set->get_table_name()." SET device_type=".$new_devtype.",hostname='".$new_hostname."' WHERE device_ip='".$new_ip."'");
				echo '<script language=\'javascript\'>alert(\'修改成功\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
				//exit;
				//alert_and_back('修改成功','admin.php?controller=admin_pro&action=dev_index&gid='.$gid);
		}
	}

	function app_config_del(){
		$devid = get_request('devid');
		$id = get_request('id');
		$this->snmp_app_config_set->delete($id);
		alert_and_back('删除成功',"admin.php?controller=admin_pro&action=dev_edit&id=".$devid."&apptable=1");
	}

	function devbatchadd() {		
		global $_CONFIG;
		$id = get_request('id');
		$gid = get_request('gid');
		$allmethod =  $this->tem_set->select_all("device_type = ''");
		$alltype = $this->tem_set->select_all("login_method = ''");
		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)",'username','ASC');
		
		$num = count($allmem);
		for($i=0;$i<$num;$i++) {
			$allmem[$i]['username'] = ($allmem[$i]['username']);
		}
		
		require_once('./include/select_sgroup_ajax.inc.php');

		$this->assign('allmethod',$allmethod);
		$this->assign('allpasses',$allmem);
		$this->assign('allgroup',$allgroup);
		$this->assign('alltype',$alltype);
		$this->assign("gid", $gid);
		$this->assign('title',language("管理设备"));
		$this->assign("_config", $_CONFIG);
		$this->display('devbatchadd.tpl');
	}
	
	function batchdevsave(){
		global $_CONFIG;
		$groupid = $_POST['groupid'];
		for($i=0; $i<count($_POST['address']); $i++){
			if(empty($_POST['address'][$i])){
				continue;
			}
			if(!is_ip($_POST['address'][$i])){
				$error[]=$_POST['address'][$i].':地址格式不正确\n';
				continue;
			}
			if(empty($groupid )){
				$error[]=$_POST['address'][$i].':没有选择设备组\n';
				continue;
			}
			if(0 == $this->server_set->select_count("device_ip = '".$_POST['address'][$i]."' ")) {
					$new_dev = new server();
					$new_dev->set_data('device_ip',$_POST['address'][$i]);
					$new_dev->set_data('hostname',$_POST['hostname'][$i]);
					$new_dev->set_data('device_type',$_POST['type_id'][$i]);
					$new_dev->set_data('login_method',0);
					$new_dev->set_data('groupid',$groupid );
					if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101){
						//$new_dev->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
					}
					$new_dev->set_data('sshport','22');
					$new_dev->set_data('telnetport', '23');
					$new_dev->set_data('ftpport', '21');
					$new_dev->set_data('rdpport','3389');
					$new_dev->set_data('vncport','5900');
					$new_dev->set_data('month','1');
					$new_dev->set_data('port','0');
					//$this->sgroup_set->insert_user($groupid);
					
					$this->server_set->add($new_dev);
					if(mysql_insert_id()){
						$this->sgroup_set->updates($groupid, null);
						if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
							$this->sgroupcache_set->updates($groupid, null);
						}
					}
					$serverResult = $this->server_set->select_all(" groupid=".$groupid);
					if($serverResult){
						foreach ($serverResult AS $key => $value){
							$serverIds[] = $value['id'];
						}
					}
					if($serverIds)
					$serverString=implode(",", $serverIds);
					$this->member_set->update('devs', ",".$serverString.",", " mservergroup=".$groupid." and level=3");
		
					$adminlog = new admin_log();
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
					$adminlog->set_data('action', language('增加设备'));
					$adminlog->set_data('resource', $_POST['address'][$i]);
					$adminlog->set_data('type', 14);
					$this->admin_log_set->add($adminlog);

				

					$succeed[]=$_POST['address'][$i];					
			}
			else {
				$error[]=$_POST['address'][$i].':地址已经存在\n';
			}
		}
		if($succeed){
			$msg = '成功添加设备:'.implode(',',$succeed);
			if($error){
				$msg .= '\n添加失败的设备:\n'.implode('\n',$error).'\n';
			}
			echo '<script language=\'javascript\'>alert("'.$msg.'");window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
			//alert_and_back($msg,'admin.php?controller=admin_pro&action=dev_index');
		}else{
			alert_and_back('添加失败:\n'.implode('\n',$error).'\n');
		}
	}

	function devbatchedit() {		
		global $_CONFIG;
		$id = get_request('id');
		$gid = get_request('gid');
		$allmethod =  $this->tem_set->select_all("device_type = ''");
		$alltype = $this->tem_set->select_all("login_method = ''");
		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)",'username','ASC');
		
		$num = count($allmem);
		for($i=0;$i<$num;$i++) {
			$allmem[$i]['username'] = ($allmem[$i]['username']);
		}
		if(!$_POST['chk_member'] && !$_GET['chk_member'] && !$_GET['sid']){
			alert_and_back('没有选择设备\n');
			exit;
		}
		
		require_once('./include/select_sgroup_ajax.inc.php');

		if($_POST['chk_member'])
		$alldev = $this->server_set->select_all("id IN(".implode(',', $_POST['chk_member']).")", 'device_ip', 'asc');
		if($_GET['chk_member'])
		$alldev = $this->server_set->select_all("id IN(".implode(',', $_GET['chk_member']).")", 'device_ip', 'asc');
		if($_GET['sid'])
		$alldev = $this->server_set->select_all("id IN(".implode(',', $_GET['sid']).")", 'device_ip', 'asc');

		$this->assign('allmethod',$allmethod);
		$this->assign('allpasses',$allmem);
		$this->assign('allgroup',$allgroup);
		$this->assign('alltype',$alltype);
		$this->assign('devs',$alldev);
		$this->assign("gid", $gid);
		$this->assign('title',language("管理设备"));
		$this->assign("_config", $_CONFIG);
		$this->display('devbatchedit.tpl');
	}
	
	function dobatchdevsave(){
		global $_CONFIG;
		$gid = get_request('gid');
		$groupid = get_request('groupid', 1, 0);
		$ldapid1 = get_request('ldapid1_',1,0);
		$ldapid2 = get_request('ldapid2_',1,0);
		$ldapid3 = get_request('ldapid3_',1,0);
		$ldapid4 = get_request('ldapid4_',1,0);
		$ldapid5 = get_request('ldapid5_',1,0);
		if(empty($groupid)){
			for($i=5; $i>=1; $i--){
				if(${'ldapid'.$i}){
					$groupid = ${'ldapid'.$i};
					break;
				}
			}
		}
		if(empty($groupid)){
			alert_and_back('没有选择设备组\n','admin.php?controller=admin_pro&action=devbatchedit&gid='.$gid.'&sid[]='.implode('&sid[]=', $_POST['sid']));
			exit;
		}

		for($i=0; $i<count($_POST['sid']); $i++){
			$old_dev = $this->server_set->select_by_id($_POST['sid'][$i]);
			$new_dev = new server();
			//$new_dev->set_data('device_ip',$_POST['address'][$i]);
			$new_dev->set_data('hostname',$_POST['hostname'][$i]);
			$new_dev->set_data('device_type',$_POST['type_id'][$i]);
			$new_dev->set_data('groupid',$groupid);
			if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101){
				//$new_dev->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
			}		
			$new_dev->set_data('id',$_POST['sid'][$i]);
			$this->server_set->edit($new_dev);
			
			$this->server_set->query("UPDATE ".$this->devpass_set->get_table_name()." SET device_type=".$_POST['type_id'][$i]." WHERE device_ip='".$old_dev['device_ip']."'");
			
			$serverResult = $this->server_set->select_all(" groupid=".$groupid);
			if($serverResult){
				foreach ($serverResult AS $key => $value){
					$serverIds[] = $value['id'];
				}
			}
			if($serverIds)
			$serverString=implode(",", $serverIds);
			$this->member_set->update('devs', ",".$serverString.",", " mservergroup=".$groupid." and level=3");

			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('action', language('修改设备'));
			$adminlog->set_data('resource', $old_dev['device_ip']);
			$adminlog->set_data('type', 14);
			$this->admin_log_set->add($adminlog);

			$succeed[]=$old_dev['device_ip'];		
		}
		if($succeed){
			$msg = '成功编辑设备:'.implode(',',$succeed);
			//alert_and_back($msg,'admin.php?controller=admin_pro&action=dev_index');
			echo '<script language=\'javascript\'>alert("'.$msg.'");window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
		}else{
			alert_and_back('编辑失败:\n','admin.php?controller=admin_pro&action=devbatchedit&gid='.$gid.'&sid[]='.implode('&sid[]=', $_POST['sid']));
		}
	}

	function devbatch_edit(){
		$ips = get_request('ips', 0, 1);
		$this->assign("ips", $ips);
		$this->display("devbatch_edit.tpl");
	}

	function devbatch_save(){
		global $_CONFIG;
		$ips = get_request('ips',1,1);
		$new_type = get_request('stra_type',1,1);
		$new_freq = get_request('freq',1,1);
		$snmpnet = get_request('snmpnet',1,0);
		$sshport = get_request('sshport',1,0);
		$telnetport = get_request('telnetport',1,0);
		$ftpport = get_request('ftpport',1,0);
		$rdpport = get_request('rdpport',1,0);
		$vncport = get_request('vncport',1,0);
		$monitor = get_request('monitor',1,0);
		$snmpkey = get_request('snmpkey',1,1);

		$sql = "UPDATE ".$this->server_set->get_table_name()." SET sshport='".$sshport."',telnetport='".$telnetport."',ftpport='".$ftpport."',rdpport='".$rdpport."',vncport='".$vncport."',monitor='".$monitor."',snmpkey='".$snmpkey."',snmpnet='".$snmpnet."'";
		switch($new_type) {
			case 'mon' :
				$sql.='month="'.$new_freq.'"';
				$sql.='week=""';
				$sql.='user_define=""';
				break;
			case 'week':
				$sql.='week="'.$new_freq.'"';
				$sql.='month=""';
				$sql.='user_define=""';
				break;
			case 'custom':
				$sql.='user_define="'.$new_freq.'"';
				$sql.='week=""';
				$sql.='month=""';
			default:
		}
		$ips_ = explode(',', $ips);
		$ips = implode("','", $ips_);
		$sql .= " WHERE device_ip IN('".$ips."')";
		$this->server_set->query($sql);
		alert_and_close('操作成功');
			
	}

	function devpassbatchedit(){
		$ips = get_request('ips', 0, 1);
		$username = get_request('username', 0, 1);
		$this->assign("ips", $ips);
		$this->assign("username", $username);
		$this->display("devpassbatch_edit.tpl");
	}

	function devpassbatch_save(){
		global $_CONFIG;
		$ips = get_request('ips',1,1);
		$username = get_request('username',1,1);
		$enable = get_request('enable',1,1);
		$auto = get_request('auto',1,1);
		$publickey_auth = get_request('publickey_auth',1,1);

		$sql = "UPDATE ".$this->devpass_set->get_table_name()." SET enable='".($enable=='on' ? 1 : 0)."',automodify='".($auto=='on' ? 1 : 0)."',publickey_auth='".($publickey_auth=='on' ? 1 : 0)."'";
		$ips_ = explode(',', $ips);
		$ips = implode("','", $ips_);
		$sql .= " WHERE device_ip IN('".$ips."') AND username='$username'";
		$this->server_set->query($sql);
		alert_and_close('操作成功');
			
	}

	function devbatchloginlock() {
		$loginlock = get_request('loginlock', 0, 0);
		$uid = get_request('chk_member', 1, 1);
		if($uid){
			$this->member_set->query("update devices set enable=0 where id IN(".implode(',', $uid).")");
		}
		alert_and_back('操作成功');
	}

	function get_eth0_ip() {
		//var_dump(PHP_EOL);echo strlen('\r\n');
		//$filename = '/etc/sysconfig/network-scripts/ifcfg-eth0';
		//$filename = './controller/ifcfg-eth0';	
		//$networkfile = './controller/network';	
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['IFGETH0'];
		//$networkfile = $_CONFIG['CONFIGFILE']['NETWORK'];
		$serverfile = $_CONFIG['CONFIGFILE']['SERVERCONF'];
		
		$return=array();
		if(file_exists($filename))
		{
			$lines = file($filename);
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtoupper($lines[$ii]), "IPADDR"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['IPADDR']['value'] = $tmp[1];
					$network['IPADDR']['file'] = $filename;
				}
				if(strstr(strtoupper($lines[$ii]), "NETMASK"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['NETMASK']['value'] = $tmp[1];
					$network['NETMASK']['file'] = $filename;
				}
				if(strstr(strtoupper($lines[$ii]), "GATEWAY"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['GATEWAY']['value'] = $tmp[1];
					$network['GATEWAY']['file'] = $filename;
				}
			}
		}
		else
		{
			//alert_and_back('配置文件不存在');
		}
		$return['eth0'] = trim($network['IPADDR']['value']);
		unset($lines);
		if(file_exists($serverfile))
		{
			$lines2 = file($serverfile) or die(error());
			for($ii=0; $ii<count($lines2); $ii++)
			{
								//echo $lines2[$ii];
				if(strstr($lines2[$ii], "server"))
				{
					$tmp = explode(" ", $lines2[$ii]);//print_r($tmp);
					$return['server'] = trim($tmp[1]);
				}
				
			}
		}
		
		//echo $lines[1]=str_replace("\r\n","\n",$lines[1]);
		//echo $lines[1];
		//var_dump(strstr($lines[1],"\n"));
		//exit;
		
		return $return;
	}
	
	

	function appconfig_save($device_ip){
		for($i=0; $i<count($_SESSION['dev_edit_appconfig']); $i++){
			$appconfig = new snmp_app_config();
			$appconfig->set_data('device_ip', $device_ip);
			$appconfig->set_data('app_name', $_SESSION['dev_edit_appconfig'][$i]['app_name']);
			$appconfig->set_data('username', $_SESSION['dev_edit_appconfig'][$i]['username']);
			$appconfig->set_data('password', $_SESSION['dev_edit_appconfig'][$i]['password']);
			$appconfig->set_data('enable', $_SESSION['dev_edit_appconfig'][$i]['enable']);
			$appconfig->set_data('desc', $_SESSION['dev_edit_appconfig'][$i]['desc']);
			$appconfig->set_data('port', $_SESSION['dev_edit_appconfig'][$i]['port']);
			if($_SESSION['dev_edit_appconfig'][$i]['seq']){
				$appconfig->set_data('seq', $_SESSION['dev_edit_appconfig'][$i]['seq']);
				$this->snmp_app_config_set->edit($appconfig);
			}else{
				$this->snmp_app_config_set->add($appconfig);
			}
		}
		$_SESSION['dev_edit_appconfig']=null;
	}

	function server_detect(){
		$ip = get_request('ip', 0, 1);
		$serverinfo = $this->server_set->select_all("device_ip='$ip'");
		$serverinfo = $serverinfo[0];
		if($serverinfo['monitor']!=1){
			alert_and_back('该设备不支持');
			exit;
		}
		if(empty($serverinfo['snmpkey'])){
			alert_and_back('该设备没有通讯字符串');
			exit;
		}
		$cmd = "sudo /home/wuxiaolong/3_status/snmpint_init.pl $ip ".$serverinfo['snmpkey'];
		exec($cmd, $out);
		alert_and_back('操作已提交');
	}

	function dev_del() {
		$id = get_request('id');
		$gid = get_request('gid');
		$id_arr = array();
		if($id){
			$id_arr[]=$id;
		}else{
			$id_arr = $_POST['chk_member'];
		}
		for($i=0; $i<count($id_arr); $i++){
			$id = $id_arr[$i];
			$old_dev = $this->server_set->select_by_id($id);
			if(	$this->appdevice_set->select_count("device_ip = '".$old_dev['device_ip']."'") > 0) {
				$error[] = '设备:\"'.$old_dev['device_ip'].'\"删除失败,该设备还有应用用户';
				continue;
				//echo '<script language=\'javascript\'>alert("删除成功");window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
				//exit;
				//alert_and_back('删除成功','admin.php?controller=admin_pro&action=dev_index&gid='.$gid);
			}
			$this->sgroup_set->updates(null, $old_dev['groupid']);
			if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
				$this->sgroupcache_set->updates(null, $old_dev['groupid']);
			}
			/*
			$_gp = array();
			$_g = $this->sgroup_set->select_by_id($old_dev['groupid']);
			$_gp[]=$_g['id'];
			while($_g['ldapid']){
				$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
				$_gp[]=$_g['id'];
			}
			$this->member_set->query("UPDATE servergroup set count=count-1 where id in(".implode(',', $_gp).")");
			*/
			$_POST['chk_member']=array($old_dev['device_ip']);
			$this->luser_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".implode("','", $_POST['chk_member'])."'))");
			$this->lgroup_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".implode("','", $_POST['chk_member'])."'))");
			$this->resgroup_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".implode("','", $_POST['chk_member'])."'))");
			$this->devpass_set->delete_all("device_ip IN('".implode("','", $_POST['chk_member'])."')");
			$this->server_set->delete_all("device_ip IN('".implode("','", $_POST['chk_member'])."')");
			$this->sshkey_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".implode("','", $_POST['chk_member'])."'))");
/*
			if(	0 == $this->devpass_set->select_count("device_ip = '".$old_dev['device_ip']."' AND hostname = '".$old_dev['hostname']."'")) {
				$this->devpass_set->delete_all("device_ip='".$old_dev['device_ip']."' AND hostname='".$old_dev['hostname']."'");
				$this->server_set->delete($id);
				$this->sshkey_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".$old_dev['device_ip']."'))");
				
				$this->sshkey_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".$old_dev['device_ip']."'))");
				
				$adminlog = new admin_log();
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('action', language('删除'));
				$adminlog->set_data('resource', $old_dev['device_ip']);
				$this->admin_log_set->add($adminlog);
				$this->sgroup_set->remove_user($old_dev['groupid']);
				
				//echo '<script language=\'javascript\'>alert("删除成功");window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
				//exit;
				//alert_and_back('删除成功','admin.php?controller=admin_pro&action=dev_index&gid='.$gid);
			}
			else {
				$error[] = '设备:\"'.$old_dev['device_ip'].'\"删除失败,该设备还有用户';
				//alert_and_back('删除失败,该设备还有用户','admin.php?controller=admin_pro&action=dev_index&gid='.$gid);
			}
*/
		}
		if($_GET['frombatchpriorityedit']){
			if($error)
			alert_and_back("部分设备删除失败\n'.implode('\n',$error).'", "admin.php?controller=admin_pro&action=batchserverpriorityedit");
			else
			alert_and_back("删除成功", "admin.php?controller=admin_pro&action=batchserverpriorityedit");
		}else{
		if($error)
			echo '<script language=\'javascript\'>alert("部分设备删除失败\n'.implode('\n',$error).'");window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
			else
			echo '<script language=\'javascript\'>alert("删除成功");window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
		}
	}
	
	function insertrandom($ip, $device_ip, $username, $luser, $time, $code){
		global $dbcharset, $_CONFIG, $dbuser, $dbpwd,$dbhost;
		if($_CONFIG['RANDOM_DB']=='0'){
			$ip="localhost";
		}else if($_CONFIG['RANDOM_DB']=='1'){
			$ip = $dbhost;
		}
		$lblink = @mysql_connect($ip, $dbuser, _encrypt($dbpwd, 'D', 'freesvr' ));
		if(!$lblink){
			return false;
		}
		$flag = @mysql_select_db('audit_sec',$lblink);
		if(!$flag){
			return false;
		}
		@mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary", $lblink);
		$sql = "INSERT INTO random SET device_ip='".$device_ip."', username='".$username."', luser='".$luser."', time='".$time."', code='".$code."', inputusername='".$_SESSION['LOGIN_USERNAME']."', inputpassword=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? "udf_encrypt('".($_SESSION['LOGIN_PASSWORD'])."')" : "AES_ENCRYPT('".($_SESSION['LOGIN_PASSWORD'])."','".$_CONFIG['PASSWORD_KEY']."')").", logincommit='".intval($_SESSION['COMMITID'])."'";
		$flag = @mysql_query($sql, $lblink);
		@mysql_close($lblink);
		$_SESSION['LOGIN_USERNAME']=null;
		$_SESSION['LOGIN_PASSWORD']=null;
		$_SESSION['COMMITID']=null;
		return $flag;
	}

	function generate_sms_code(){
		$smscode = genRandomDigitalString(6);
		$this->member_set->query("UPDATE member SET randomcode='".$smscode."' WHERE uid=".$_SESSION['ADMIN_UID']);
		$m = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$rs='True';
		$url = 'http://10.14.12.83:11080/gwsp_web_interface/jsp/third/sendTask.jsp?content='.urlencode(iconv("UTF-8", "GBK", '堡垒机登录短信验证码')).$smscode.'&mobile='.$m['mobilenum'].'&customerId=014&pwd=e10adc3949ba59abbe56e057f20f883e';
		$c = file_get_contents($url);
	
		$xml = new DOMDocument();
		$flag = $xml->loadXML($c);
		$rs = $xml->getElementsByTagName('op_code');
		//var_dump($rs->item(0)->nodeValue);
		if(strtolower($rs->item(0)->nodeValue)=='y'){
			echo '发送成功';
			exit;
		}else{
			$rs = $xml->getElementsByTagName('op_info');
			echo $rs->item(0)->nodeValue;
			exit;
		}
		$url = 'http://192.168.4.71:8080/smsServer/service.action?branch_no=10&password=010&depart_no=10001&message_type=1&batch_no=4324&priority=1&sp_no=955589903&mobile_type=1&mobile_tel='.$m['mobilenum'].'&message='.urlencode(iconv("UTF-8", "GBK", '堡垒机登录短信验证码:')).$smscode.'';
		$c = file_get_contents($url);
		if($c==0) 
		echo '发送成功';
		else
		echo '发送失败,请重试或联系管理员';

	}

	function showsmsauth(){
		$this->assign("devicesid", $_SESSION['LOGIN_ID']);
		$this->assign("url", urlencode($_SESSION['LOGIN_URL']));
		$this->display('smsauth.tpl');
	}

	function dosmsauth(){
		$id = get_request('id', 1, 1);
		$username = get_request('username', 1, 1);
		$smscode = get_request('smscode', 1, 1);
		$url = urldecode(get_request('url', 1, 1));
		$user = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		if($user['randomcode']!=$smscode){			
			alert_and_back('短信随机码错误');
			exit;
		}
		$_SESSION['SMSAUTHDEVICESIDS'][]=$id;
		//echo '<script language=\'javascript\'>window.opener.location.href="'.$url.'";window.close();</script>';
		echo '<script language=\'javascript\'>window.parent.document.getElementById("hide").src="'.$url.'";'."\n".'window.parent.closeWindow();</script>';
		exit;
	}

	function showtwoauth(){
		$this->assign("users", $_SESSION['TWOAUTH']);
		$this->assign("devicesid", $_SESSION['TWOAUTH_ID']);
		$this->assign("url", urlencode($_SESSION['TWOAUTH_URL']));
		$this->display('twoauth.tpl');
	}

	function dotwoauth(){
		global $_CONFIG;
		$id = get_request('id', 1, 1);
		$username = get_request('username', 1, 1);
		$password = htmlspecialchars_decode(get_request('password', 1, 1));
		$url = urldecode(get_request('url', 1, 1));
		$dev = $this->devpass_set->select_by_id($id);
		$approve = $this->login4approve_set->select_all("username='".$dev['username']."' AND ip='".$dev['device_ip']."' AND webuser='".$_SESSION['ADMIN_USERNAME']."' AND login_method='".$dev['login_method']."'");
		$approve = $approve[0];//var_dump($approve);
		if(!$approve['approved']){			
			$user = $this->member_set->select_all("username='$username'");
			if($this->member_set->udf_decrypt($user[0]['password'])!=$password){
				alert_and_back('密码错误');
				exit;
			}
		}
		$_SESSION['AUTHDEVICESIDS'][]=$id;
		//echo '<script language=\'javascript\'>window.opener.location.href="'.$url.'";window.close();</script>';
		echo '<script language=\'javascript\'>window.parent.loadurl("'.$url.'");'.'window.parent.closeWindow();</script>';
		exit;
	}

	function showcommit(){
		$this->assign("devicesid", $_SESSION['LOGIN_ID']);
		$this->assign("url", urlencode($_SESSION['LOGIN_URL']));
		$this->display('commit.tpl');
	}

	function docommit(){
		$id = get_request('id', 1, 1);
		$prelogincommit = get_request('prelogincommit', 1, 1);
		$url = urldecode(get_request('url', 1, 1));
		$rdptype = get_request('rdptype', 1, 1);
		$logincommit = new logincommit();
		$logincommit->set_data('prelogincommit', $prelogincommit);
		$logincommit->set_data('devicesid', $id);
		$logincommit->set_data('uid', $_SESSION['ADMIN_UID']);
		$this->logincommit_set->add($logincommit);
		$_SESSION['COMMITDEVICESIDS'][]=$id;
		$_SESSION['COMMITID']=mysql_insert_id();
		$dev = $this->devpass_set->select_by_id($id);
		$tem = $this->tem_set->select_by_id($dev['login_method']);
		if((strtolower($tem['login_method']) == 'rdp'||strtolower($tem['login_method']) == 'vnc')&&$rdptype=='activex'){
			echo '<script language=\'javascript\'>window.location.href="'.$url.'";</script>';
		}else{
			echo '<script language=\'javascript\'>window.parent.loadurl("'.$url.'");'.'window.parent.closeWindow();</script>';
		}
		exit;
	}

	function editvncport(){
		$dev = $this->devpass_set->select_by_id($_SESSION['LOGIN_ID']);
		$this->assign("port", $dev['port']);
		$this->assign("devicesid", $_SESSION['LOGIN_ID']);
		$this->assign("url", urlencode($_SESSION['LOGIN_URL']));
		$this->display('editvncport.tpl');
	}

	function doeditvncport(){
		$id = get_request('id', 1, 1);
		$vncport = get_request('vncport', 1, 1);
		$url = urldecode(get_request('url', 1, 1));
		$rdptype = get_request('rdptype', 1, 1);
		$_SESSION['EDITVNCPORTDEVICESIDS'][]=$id;
		$newdev = new devpass();
		$newdev->set_data('port', $vncport);
		$newdev->set_data("id", $id);
		$this->devpass_set->edit($newdev);
		$dev = $this->devpass_set->select_by_id($id);
		$tem = $this->tem_set->select_by_id($dev['login_method']);
		if($_SESSION['LOGINRDPTYPE']=='activex'){
			echo '<script language=\'javascript\'>window.location.href="'.$url.'";</script>';
		}else{
			echo '<script language=\'javascript\'>window.parent.loadurl("'.$url.'");window.parent.closeWindow();</script>';
		}
		exit;
	}

	function showdesc(){
		$id = get_request('id');
		$appdeviceid = get_request('appdeviceid');
		if($id){
			$devinfo = $this->devpass_set->select_by_id($id);
		}elseif($appdeviceid){
			$devinfo = $this->appdevice_set->select_by_id($appdeviceid);
		}
		$this->assign('devinfo', $devinfo);
		$this->assign('id', $id);
		$this->assign('appdeviceid', $appdeviceid);
		$this->display('devdesc.tpl');
	}

	function dodevdesc(){
		$id = get_request('id', 1, 0);
		$appdeviceid = get_request('appdeviceid', 1, 0);
		$desc = get_request('desc', 1, 1);
		if($id){
			$devpass = new devpass();
			$devpass->set_data('desc', $desc);
			$devpass->set_data('id', $id);
			$this->devpass_set->edit($devpass);
		}elseif($appdeviceid){
			$appdevpass = new appdevice();
			$appdevpass->set_data('desc', $desc);
			$appdevpass->set_data('id', $appdeviceid);
			$this->appdevice_set->edit($appdevpass);
		}
		echo '<script language=\'javascript\'>alert(\'操作成功\');window.parent.closeWindow();window.parent.location.reload();</script>';
		exit;
	}

	function showinputauth(){
		global $_CONFIG;
		$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$_COOKIE['inputauth']=unserialize($_COOKIE['inputauth']);
		if($member['passwordsave']){
			$this->assign("passwordsave", 0);
			$users = $this->passwordsave_set->select_all("devicesid='".$_SESSION['LOGIN_ID']."' AND memberid='".$_SESSION['ADMIN_UID']."'", "username", "asc");
			for($i=0; $i<count($users); $i++){
				$users[$i]['password']=$this->member_set->udf_decrypt($users[$i]['password']);
				for($j=0; $j<count($_COOKIE['inputauth']); $j++){
					if($_COOKIE['inputauth'][$j]['devicesid']==$users[$i]['devicesid']&&$_COOKIE['inputauth'][$j]['username']==$users[$i]['username']&&$_COOKIE['inputauth'][$j]['memberid']==$users[$i]['memberid']){
						$found = true;
						$this->assign("passwordsave", $users[$i]['id']);
						$this->assign("username", $users[$i]['username']);						
						$this->assign("password", $users[$i]['password']);
						$users[$i]['selected'] = "selected";
					}
				}
			}
			$this->assign("showusers", 1);
			$this->assign("users", $users);
		}
		$this->assign("devicesid", $_SESSION['LOGIN_ID']);
		$this->assign("url", urlencode($_SESSION['LOGIN_URL']));
		$this->assign("saveednameit", $_COOKIE['saveednameit']);
		$this->assign("saveedpwdit", $_COOKIE['saveedpwdit']);
		$this->display('inputauth.tpl');
	}

	function doinputauth(){
		global $_CONFIG;
		$id = get_request('id', 1, 1);
		$username = get_request('username', 1, 1);
		$password = htmlspecialchars_decode(get_request('password', 1, 1));
		$saveednameit = get_request('saveednameit', 1, 1);
		$saveedpwdit = get_request('saveedpwdit', 1, 1);
		$passwordsave = get_request('passwordsave', 1, 1);
		$url = urldecode(get_request('url', 1, 1));
		$rdptype = get_request('rdptype', 1, 1);
		$rdptype = get_request('rdptype', 1, 1);
		$actions = get_request('actions', 1, 1);
		if($actions=='删除'){
			if($passwordsave>0){
				$this->passwordsave_set->delete($passwordsave);
			}
		}else{
			$_COOKIE['inputauth']=unserialize($_COOKIE['inputauth']);
			$found = 0;
			for($i=0; $i<count($_COOKIE['inputauth']); $i++){
				if($_COOKIE['inputauth'][$i]['devicesid']==$id&&$_COOKIE['inputauth'][$i]['memberid']==$_SESSION['ADMIN_UID']){
					$found = 1;
					$_COOKIE['inputauth'][$i]['username']=$username;
				}
			}
			if(!$found){
				$_COOKIE['inputauth'][]=array('devicesid'=>$id, 'username'=>$username, 'memberid'=>$_SESSION['ADMIN_UID']);
			}
			setcookie("inputauth", serialize($_COOKIE['inputauth']), time()+3600*24*365*100, '/', '', 1);
			$_SESSION['LOGIN_USERNAME']=$username;
			$_SESSION['LOGIN_PASSWORD']=$password;		
			$_SESSION['INPUTDEVICESIDS'][]=$id;
			//echo '<script language=\'javascript\'>window.opener.location.href="'.$url.'";window.close();</script>';
			$dev = $this->devpass_set->select_by_id($id);
			$tem = $this->tem_set->select_by_id($dev['login_method']);
			if($saveednameit||$saveedpwdit){
				$ps = new passwordsave();
				$ps->set_data('devicesid', $id);
				$ps->set_data('memberid', $_SESSION['ADMIN_UID']);
				$ps->set_data('username', $saveednameit ? $username : '');
				$ps->set_data('password', $saveedpwdit ? $this->member_set->udf_encrypt($password) : '');
				if($passwordsave>0&&$this->passwordsave_set->select_count("username='".$username."' AND memberid='".$_SESSION['ADMIN_UID']."' AND devicesid='".$id."' AND id!='".$passwordsave."'")==0){				
					$ps->set_data('id', $passwordsave);
					$this->passwordsave_set->edit($ps);
				}else{
					$this->passwordsave_set->add($ps);
				}
			}
		}
		setcookie("saveednameit", $saveednameit, time()+3600*24*365*100, '/', '', 1);
		setcookie("saveedpwdit", $saveedpwdit, time()+3600*24*365*100, '/', '', 1);
		if((strtolower($tem['login_method']) == 'rdp'||strtolower($tem['login_method']) == 'vnc')&&$rdptype=='activex'){
			echo '<script language=\'javascript\'>window.location.href="'.$url.'";</script>';
		}else{
			echo '<script language=\'javascript\'>window.parent.loadurl("'.$url.'");window.parent.closeWindow();</script>';
		}
		exit;
	}

	function dev_login() {
		global $_CONFIG;
		header("Cache-control:no-cache,no-store,must-revalidate"); 
		header("Pragma:no-cache"); 
		header("Expires:0"); 
		$a = $this->get_eth0_ip();
		$server = $a['server'];
		$selectedip = get_request('selectedip', 0, 1);
		$appdeviceid = get_request('appdeviceid', 0, 1);
		$app_act = get_request('app_act', 0, 1);
		$rdpclipauth_up = get_request('rdpclipauth', 0, 1);
		$rdpclipauth_down = get_request('rdpclipauth_down', 0, 1);
		$rdpdiskauth_up = get_request('rdpdiskauth', 0, 1);
		$rdpdiskauth_down = get_request('rdpdiskauth_down', 0, 1);
		$consoleauth = get_request('consoleauth', 0, 1);
		$bydomain = get_request('bydomain', 0, 1);
		$this->assign("activex_version", $_CONFIG['ACTIVEX_VERSION']);
		if(($msiepos=strpos($_SERVER['HTTP_USER_AGENT'], "Windows NT"))>0){
			$this->assign("windows_version", floatval(substr($_SERVER['HTTP_USER_AGENT'], $msiepos+10, strpos($_SERVER['HTTP_USER_AGENT'], ";", $msiepos+1)-$msiepos-10)));
		}
		setcookie("bydomain", $bydomain, time()+3600*24*365*100, '/', '', 1);

		setcookie("rdpdiskauth_up", $rdpdiskauth_up, time()+3600*24*365*100, '/', '', 1);
		//$_SERVER['REMOTE_ADDR']='2';
		
		$this->assign("vpnip", $server);
		$this->assign("rdpdiskauth_up", $rdpdiskauth_up);
		$this->assign("rdpclipauth_up", $rdpclipauth_up);
		$this->assign("rdpdiskauth_down", $rdpdiskauth_down);
		$this->assign("rdpclipauth_down", $rdpclipauth_down);
		$this->assign("console", ($consoleauth==1 ? 'TRUE' : 'FALSE'));
		$user = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$this->assign("member", $user);

		$id = get_request('id');
		$screen = get_request('screen', 0 ,1);
		$logintool = get_request('logintool', 0 ,1);
		$type = get_request('type', 0 ,1);
		$_SESSION['LOGINRDPTYPE']=$rdptype = get_request('rdptype', 0, 1);
		if(empty($_SESSION['AUTHDEVICESIDS'])){ 
			$_SESSION['AUTHDEVICESIDS']=array(); 
		}
		if(empty($_SESSION['COMMITDEVICESIDS'])){ 
			$_SESSION['COMMITDEVICESIDS']=array(); 
		}
		if(empty($_SESSION['INPUTDEVICESIDS'])){ 
			$_SESSION['INPUTDEVICESIDS']=array(); 
		}
		if(empty($_SESSION['SMSAUTHDEVICESIDS'])){ 
			$_SESSION['SMSAUTHDEVICESIDS']=array(); 
		}
		if(empty($_SESSION['EDITVNCPORTDEVICESIDS'])){ 
			$_SESSION['EDITVNCPORTDEVICESIDS']=array(); 
		}
		$dev = $this->devpass_set->select_by_id($id);
		$dev_type = $this->tem_set->select_by_id($dev['device_type']);
		$tem = $this->tem_set->select_by_id($dev['login_method']);
		$blankuser = $this->setting_set->select_all("sname='blankuser'");
		$blankuser = $blankuser[0]['svalue'];

		if($bydomain){
			$_domain_ip = gethostbyname($dev['hostname']);//var_dump($_domain_ip);
			if(is_ip($_domain_ip)){
				$dev['device_ip']=$_domain_ip;
				$this->server_set->query("UPDATE ".$this->server_set->get_table_name()." SET device_ip='".$_domain_ip."' WHERE hostname='".$dev['hostname']."'");
				$this->server_set->query("UPDATE ".$this->devpass_set->get_table_name()." SET device_ip='".$_domain_ip."' WHERE hostname='".$dev['hostname']."'");
			}else{
				//alert_and_back('域名"'.$dev['hostname'].'"无法解析');
				echo('alert(\'域名"'.$dev['hostname'].'"无法解析\');');
				exit;
			}
		}

		if($_row = $this->luser_set->select_all(" memberid=".$_SESSION['ADMIN_UID']." AND devicesid=".$id)){
		}else if($_row = $this->luser_set->base_select("select a.* from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$id.") t on a.resourceid=t.id left join member on a.memberid=member.uid where t.id and member.uid=".$_SESSION['ADMIN_UID']." and t.devicesid")){
		}else if($_row = $this->luser_set->base_select("select a.* from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.memberid=".$_SESSION['ADMIN_UID']." AND devices.id=".$id."")){
		}else if($_row = $this->lgroup_set->select_all(" groupid=".$_SESSION['ADMIN_GROUP']." AND devicesid=".$id)){
		}else if($_row = $this->luser_set->base_select("select a.* from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$id.") t on a.resourceid=t.id left join member on a.groupid=member.groupid where t.id and member.groupid=".$_SESSION['ADMIN_GROUP']." and t.devicesid")){
		}else if($_row = $this->luser_set->base_select("select a.* from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$_SESSION['ADMIN_GROUP']." AND devices.id=".$id."")){
		}

		if(!in_array($id,$_SESSION['AUTHDEVICESIDS'])){
				/*$twoauth_1 = $this->member_set->base_select("SELECT twoauth FROM ".$this->luser_resourcegrp_set->get_table_name()." WHERE memberid='".$user['uid']."' AND resourceid IN(SELECT b.id FROM ".$this->resgroup_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.groupname=b.groupname AND b.devicesid=0 WHERE a.devicesid='$id') UNION SELECT twoauth FROM ".$this->lgroup_resourcegrp_set->get_table_name()." WHERE groupid='".$user['groupid']."' AND resourceid IN(SELECT c.id FROM ".$this->resgroup_set->get_table_name()." c LEFT JOIN ".$this->resgroup_set->get_table_name()." d ON c.groupname=d.groupname AND d.devicesid=0 WHERE c.devicesid='$id')");
				$twoauth_arr=array(0);
				for($ii=0; $ii<count($twoauth_1); $ii++){
					$twoauth_arr[]=$twoauth_1[$ii]['twoauth'];
				}
				
				$twoauth = $this->member_set->select_all("uid IN(".(implode(",",$twoauth_arr)).") OR uid IN(SELECT twoauth FROM ".$this->luser_set->get_table_name()." WHERE memberid='".$user['uid']."' AND devicesid='$id') OR uid IN(SELECT twoauth FROM ".$this->lgroup_set->get_table_name()." WHERE groupid='".$user['groupid']."' AND devicesid='$id')");//var_dump($twoauth);
				if(!empty($twoauth)){
					$approve = $this->login4approve_set->select_all("username='".$dev['username']."' AND ip='".$dev['device_ip']."' AND webuser='".$_SESSION['ADMIN_USERNAME']."' AND login_method='".$dev['login_method']."' and approved < 2");
					$approve = $approve[0];//var_dump($approve);
					if(!$approve['approved']){
						if(empty($approve)){
							$login4approve = new login4approve();
							$login4approve->set_data('username', $dev['username']);
							$login4approve->set_data('ip', $dev['device_ip']);
							$login4approve->set_data('login_method', $dev['login_method']);
							$login4approve->set_data('approveuser', $twoauth[0]['username']);
							$login4approve->set_data('applytime', date('Y-m-d H:i:s'));
							$login4approve->set_data('webuser', $_SESSION['ADMIN_USERNAME']);
							$this->login4approve_set->add($login4approve);
						}
						echo "<script language=\'javascript\'>alert('已经提交审批')</script>";
						exit;
					}else{
						$objapprove = new login4approve();
						$objapprove->set_data('id', $approve['id']);
						$objapprove->set_data('logintime', date('Y-m-d H:i:s'));
						$objapprove->set_data('approved', 2);
						$this->login4approve_set->edit($objapprove);
						//$this->login4approve_set->delete_all("username='".$dev['username']."' AND ip='".$dev['device_ip']."' AND webuser='".$_SESSION['ADMIN_USERNAME']."' AND login_method='".$dev['login_method']."'");
					}
					
				}
				*/
			if($_row[0]['twoauth']){
				$workflow = new workflow();
				$workflow->set_data('devicesid', $id);
				$workflow->set_data('contant', 2);
				$workflow->set_data('memberid', $_SESSION['ADMIN_UID']);
				$workflow->set_data('dateline', date('Y-m-d H:i:s'));
				if(empty($id)){
					echo('alert("系统错误");');
					exit;
				}
				
				if($this->workflow_set->select_count("memberid=".$_SESSION['ADMIN_UID']." AND devicesid=$id AND `status`<4 AND islogin=0")){
					echo('alert("已经提交过申请,请等待审批结束");');
					exit;
				}else{
					$_wf = $this->workflow_set->select_all("memberid=".$_SESSION['ADMIN_UID']." AND devicesid=$id AND `status`=4 AND islogin=0");
					if(empty($_wf)){
						$this->workflow_set->add($workflow);
						$sid = mysql_insert_id();
						$i=1;
						while($i<5){//var_dump($row[0]['wf_user'.$i]);
							if(empty($_row[0]['wf_user'.$i])) break;
							$workflow_log = new workflow_log();
							$workflow_log->set_data("wid", $sid);
							$workflow_log->set_data("member", $_row[0]['wf_user'.$i]);
							$workflow_log->set_data("apply_status", 0);
							$this->workflow_log_set->add($workflow_log);
							$i++;
						}
						echo('alert("提交申请成功,请等待审批完成");');
						exit;
					}else{
						$workflow->set_data('islogin', 1);
						$_SESSION['AUTHDEVICESIDS'][] = $id;
						$workflow->set_data('sid', $_wf[0]['sid']);
						$this->workflow_set->edit($workflow);
					}
				}
			}
		}
		

		$_SESSION['LOGIN_ID']=$id;
		$_SESSION['LOGIN_URL']="admin.php?".$_SERVER['QUERY_STRING'];
		if(strtolower($tem['login_method']) == 'vnc'){
			if(!in_array($id,$_SESSION['EDITVNCPORTDEVICESIDS'])){
				if($rdptype=='activex'){
					$this->assign("port", $dev['port']);
					$this->assign("rdptype", $rdptype);
					$this->assign("devicesid", $_SESSION['LOGIN_ID']);
					$this->assign("url", urlencode($_SESSION['LOGIN_URL']));
					$this->display('editvncport.tpl');
				}else{
					echo "window.loadurl('admin.php?controller=admin_pro&action=editvncport&".time()."')";
				}
				exit;
			}
		}
		if($dev['logincommit']){
			if(!in_array($id,$_SESSION['COMMITDEVICESIDS'])){
				if((strtolower($tem['login_method']) == 'rdp'||strtolower($tem['login_method']) == 'vnc')&&$rdptype=='activex'){
					$this->assign("rdptype", $rdptype);
					$this->assign("devicesid", $_SESSION['LOGIN_ID']);
					$this->assign("url", urlencode($_SESSION['LOGIN_URL']));
					$this->display('webcommit.tpl');
				}else{
					echo "window.loadurl('admin.php?controller=admin_pro&action=showcommit&".time()."')";
				}
				//echo "<script language=\'javascript\'>window.open('admin.php?controller=admin_pro&action=showcommit', 'newwindow', 'height=130, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');</script>";
				/*$this->assign('url', 'admin.php?controller=admin_pro&action=showcommit');
				$this->display('checkdevlogin.tpl');*/
				exit;
			}
		}//var_dump($dev['entrust_username']);
		if($dev['entrust_username']==0){
			if(!in_array($id,$_SESSION['INPUTDEVICESIDS'])){
				//$_continue = (strtolower($tem['login_method']) == 'ftp'||strtolower($tem['login_method']) == 'sftp'||$blankuser);
				$_continue = ($blankuser || (strtolower($tem['login_method']) == 'ftp'||(strtolower($tem['login_method']) == 'ssh'&&($logintool=='winscp'||$logintool=='flashxp'||$logintool=='xftp'))));
				//var_dump(strtolower($tem['login_method']));var_dump($logintool);
				if($_continue){
					if((strtolower($tem['login_method']) == 'rdp'||strtolower($tem['login_method']) == 'vnc')&&$rdptype=='activex'){
						$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
						$_COOKIE['inputauth']=unserialize($_COOKIE['inputauth']);
						if($member['passwordsave']){
							$users = $this->passwordsave_set->select_all("devicesid='".$_SESSION['LOGIN_ID']."' AND memberid='".$_SESSION['ADMIN_UID']."'", "username", "asc");
							for($i=0; $i<count($users); $i++){
								$users[$i]['password']=$this->member_set->udf_decrypt($users[$i]['password']);
								for($j=0; $j<count($_COOKIE['inputauth']); $j++){
									if($_COOKIE['inputauth'][$j]['devicesid']==$users[$i]['devicesid']&&$_COOKIE['inputauth'][$j]['username']==$users[$i]['username']&&$_COOKIE['inputauth'][$j]['memberid']==$users[$i]['memberid']){
										$found = true;
										$this->assign("passwordsave", $users[$i]['id']);
										$this->assign("username", $users[$i]['username']);						
										$this->assign("password", $users[$i]['password']);
										$users[$i]['selected'] = "selected";
									}
								}
							}
							$this->assign("showusers", 1);
							$this->assign("users", $users);
						}
						$this->assign("rdptype", $rdptype);
						$this->assign("devicesid", $_SESSION['LOGIN_ID']);
						$this->assign("url", urlencode($_SESSION['LOGIN_URL']));
						$this->assign("saveedit", $_COOKIE['saveedit']);
						$this->display('webinputauth.tpl');
					}else{
						echo "window.loadurl('admin.php?controller=admin_pro&action=showinputauth&".time()."')";
					}
					//echo "<script language=\'javascript\'>window.open('admin.php?controller=admin_pro&action=showinputauth', 'newwindow', 'height=130, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');</script>";
					/*$this->assign('url', 'admin.php?controller=admin_pro&action=showinputauth');
					$this->display('checkdevlogin.tpl');*/
					exit;
				}
			}
		}

		
		if($_row[0]['smsalert']){
			if(!in_array($id,$_SESSION['SMSAUTHDEVICESIDS'])){
				echo "window.loadurl('admin.php?controller=admin_pro&action=showsmsauth&".time()."')";
				exit;
			}
		}

		$dynamic_pwd = $this->radkey_set->get_ran_radkey($_SESSION['ADMIN_USERNAME']);
		$this->assign("dynamic_pwd",$dynamic_pwd);
		$this->assign("app_act",$app_act);
		$this->assign("entrust_password", $dev['entrust_password']);
		$this->assign("entrust_username", $dev['entrust_username']);
		if($type=='gateway' || $type=='fort' ){
			$this->assign("dynamic_pwd",'');
		}
		$tem[login_method] = ($tem[login_method]=='ssh' && $dev['sftp']==1&&$logintool=='winscp' ? 'sftp' : $tem[login_method]);
		$this->assign('login_method', $tem[login_method]);
		if($_CONFIG['APP_HOST']=='127.0.0.1'){
			$_CONFIG['APP_HOST']=$_SERVER['HTTP_HOST'];
		}
		if(empty($selectedip)){
			//echo "SELECT ip FROM ".$this->loadbalance_set->get_table_name()." WHERE sid=(SELECT loadbalance FROM ".$this->sgroup_set->get_table_name()." WHERE id=(SELECT groupid FROM ".$this->server_set->get_table_name()." WHERE device_ip='".$dev['device_ip']."') LIMIT 1)";
			$servergroup = $this->sgroup_set->base_select("SELECT ip FROM ".$this->loadbalance_set->get_table_name()." WHERE sid=(SELECT loadbalance FROM ".$this->sgroup_set->get_table_name()." WHERE id=(SELECT groupid FROM ".$this->server_set->get_table_name()." WHERE device_ip='".$dev['device_ip']."') LIMIT 1)");//var_dump($servergroup );
			if(!empty($servergroup)){
				$selectedip = $servergroup[0]['ip'];
			}else{
				$eth0tmp = explode(":", $_SERVER["HTTP_HOST"]);
				$selectedip = $eth0tmp[0];
			}
		}
		if($tem[login_method]=='ftp' or $tem[login_method]=='sftp' or $tem[login_method]=='scp' ){
			$_SESSION['AUTHDEVICESIDS']=null;
			$_SESSION['COMMITDEVICESIDS']=null;
			$_SESSION['INPUTDEVICESIDS']=null;
			$_SESSION['LOGIN_ID']=null;
			$_SESSION['SMSAUTHDEVICESIDS']=null;
			$this->assign('serveradd',$_SERVER['SERVER_NAME']);
			
			$user['password']=$this->member_set->udf_decrypt($user['password']);
			$this->assign('username',$user['username'].'--'.$dev[username]);
			$this->assign('password',$user['password']);
			/*
			if($type=='gateway'){
				$this->assign('username',$dev['username']);
				$this->assign('password',$dev['cur_password']);
			}*/
		
			$this->assign('port',$dev['port']);
			$this->assign('ip',$dev['device_ip']);
			$this->assign('dusername',$dev['username']);
			$this->assign("loginmethod", $tem[login_method]);
			$this->assign("sid", $id);
			$this->assign("proxy_addr", $selectedip);
			$this->assign('winscp', 1);
			
			$str = genRandomString(8);
			/*$random = new random();
			$random->set_data('device_ip', $dev['device_ip']);
			$random->set_data('username', $user['username']);
			$random->set_data('luser', $dev['username']);
			$random->set_data('time', date('Y-m-d H:i:s'));
			$random->set_data('code', $str);
			$this->random_set->add($random);
			*/
			if(!$this->insertrandom($selectedip, $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
				echo('alert("请重新选择IP");');
				exit;
			}
			$this->assign('username',$user['username'].'--'.$dev[username].'--'.$str);
			$this->assign('password',$str);
			$this->assign('sid',$id.'--'.$str);
			$this->assign("logintool",$logintool);
			
			$this->display('devlogin.tpl');
		}elseif($tem['login_method'] == 'RDP' || $tem['login_method'] == 'vnc' || $tem['login_method'] == 'X11' || $tem['login_method'] == 'RDP2008' ) {
			/*
			$this->assign('port',$dev['port']);
			$this->assign('ip',$dev['device_ip']);
			$this->display('rdplogin.tpl');
			*/
			$logined = get_request("logined");
			if(!$logined){
				$l_where="addr like '%".$dev['device_ip']."%'";
				if(!empty($dev['username'])){
					$l_where .= " AND user='".$dev['username']."'";
				}
				if($tem['login_method'] == 'RDP'){
					$run_sessions = $this->rdp_set->select_all($l_where." AND LOGIN_TEMPLATE=8 and rdp_runnig=1");
				}elseif($tem['login_method'] == 'vnc'){
					$run_sessions = $this->rdp_set->select_all($l_where." AND LOGIN_TEMPLATE=21 and rdp_runnig=1");
				}elseif($tem['login_method'] == 'X11'){
					$run_sessions = $this->rdp_set->select_all($l_where." AND LOGIN_TEMPLATE=22 and rdp_runnig=1");
				}
				$str = "";
				$run_users = "";
				if(!empty($run_sessions)&&$_CONFIG['rdprunning']){
					if(empty($username)){
						$run_users .= "目标设备以下用户已经登录,点确定将会断开已存在的连接".'\n';
						for($i=0; $i<count($run_sessions); $i++){
							$run_users.=$run_sessions[$i]['cli_addr']."  ".$run_sessions[$i]['user'].'\n';
						}
					}else{
						$run_users="用户已经从".$run_sessions[$i]['cli_addr']."登录, 点确定将会断开已存在连接";
					}
					if($rdptype=='activex'){
						prompt($run_users, "admin.php?".$_SERVER['QUERY_STRING'].'&logined=1', "");
					}else{
						prompt($run_users, "admin.php?".$_SERVER['QUERY_STRING'].'&logined=1', "", 1);
					}
					exit;
					//echo '<script type="text/javascript">alert("'.$run_users.'")</script>';
				}
			}
			$_SESSION['AUTHDEVICESIDS']=null;
			$_SESSION['COMMITDEVICESIDS']=null;
			$_SESSION['INPUTDEVICESIDS']=null;
			$_SESSION['LOGIN_ID']=null;
			$_SESSION['SMSAUTHDEVICESIDS']=null;
			$_SESSION['EDITVNCPORTDEVICESIDS']=null;

			$user['password']=$this->member_set->udf_decrypt($user['password']);
			$this->assign("screen", $screen);
			$this->assign('port', $dev['port']);
			$this->assign('ip',$dev['device_ip']);
			$this->assign('dusername',$dev['username']);
			$this->assign('username',$user['username'].'--'.$dev[id]);
			$this->assign('password',$user['password']);
			$this->assign('localhost', $selectedip);
			$this->assign("sid", $id);
			$this->assign("rdparg", get_request("rdparg", 0, 1));
			if($rdptype=='activex'){
				
				$str = genRandomString(8);
				
				if(!$this->insertrandom($selectedip, $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
					echo('alert("请重新选择IP");');
					exit;
				}
				$this->assign('username',$user['username'].'--'.$dev[id].'--'.$str);
				$this->assign('password',$str.'--');
				$this->assign('sid',$id.'--'.$str);
				
			
				$this->display('rdplogin_activex.tpl');
			}else{
				$str = genRandomString(8);
				
				if(!$this->insertrandom($selectedip, $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
					echo('alert("请重新选择IP");');
					exit;
				}
				$this->assign('username',$user['username'].'--'.$dev[id].'--'.$str);
				$this->assign('password',$str);
				$this->assign('sid',$id.'--'.$str);
				
				
				$this->display('rdplogin_mstsc.tpl');
			}
		}elseif(strtolower($tem['login_method']) == 'web' or strtolower($tem['login_method']) == 'oracle' or strtolower($tem['login_method']) == 'sybase' or strtolower($tem['login_method']) == 'db2' or strtolower($tem['login_method']) == 'apppub'){
			$_SESSION['AUTHDEVICESIDS']=null;
			$_SESSION['COMMITDEVICESIDS']=null;
			$_SESSION['INPUTDEVICESIDS']=null;
			$_SESSION['LOGIN_ID']=null;
			$_SESSION['SMSAUTHDEVICESIDS']=null;

			$user['password']=$this->member_set->udf_decrypt($user['password']);
			$this->assign("screen", $screen);
			$this->assign('port',$dev['port']);
			$this->assign('ip',$dev['device_ip']);
			$this->assign('dusername',$dev['username']);
			$this->assign('username',$user['username'].'--'.$dev[id]);
			$this->assign('password',$user['password']);
			$this->assign('localhost', $selectedip);
			$this->assign("sid", $id.'--'.$str);
			$this->assign("id", $id);

			if($rdptype=='activex'){
				$this->assign('password',$user['username'].'--'.$_CONFIG[$tem['login_method'].'_AUTORUN'].' '.$id);
				$this->assign('password',$str.'--');
				if(strtolower($tem['login_method']) == 'apppub'){
					$this->assign('password',$user['password'].'--');
					$__pos = strrpos($_CONFIG[$tem['login_method'].'_AUTORUN'], '\\');
					$this->assign('domain',$_CONFIG[$tem['login_method'].'_AUTORUN'].' '.$_SESSION['ADMIN_UID'].(empty($appdeviceid) ? '' : '-'.$appdeviceid).' '.$dev['device_ip'].(empty($_CONFIG['RDPREPLAYIP']) ? ' '.$_CONFIG['APP_HOST'] : ' '.$_CONFIG['RDPREPLAYIP']).' 59827');
					$this->assign('workdir',substr($_CONFIG[$tem['login_method'].'_AUTORUN'], 0, $__pos ));
				}
				$str = genRandomString(8);
			
				if(!$this->insertrandom($selectedip, $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
					//alert_and_back('请重新选择IP');
					//exit;
				}
					$this->assign('username',$user['username'].'--'.$dev[id].'--'.$str);
				$this->assign("random", $str);	
				
				$this->display('rdplogin_activex.tpl');
			}else{
				$this->assign("autorun", ($_CONFIG[$tem['login_method'].'_AUTORUN']));
				
				$wins = $this->winservers_set->select_all("1=1");
				if(strtolower($tem['login_method']) == 'web'){
					$str = genRandomString(8);
				
					if(!$this->insertrandom($selectedip,  $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
						echo('alert("请重新选择IP");');
						exit;
					}
					
					$this->assign('ip',$wins[0]['IP']);
					$this->assign("sid", $id.'--'.$str);
					$this->assign('username',$user['username'].'--'.$dev[id].'--'.$str);
					$this->assign('password',$str.'--');
				}elseif(strtolower($tem['login_method']) == 'apppub'){
					$str = genRandomString(8);
					
					if(!$this->insertrandom($selectedip, $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
						echo('alert("请重新选择IP");');
						exit;
					}
					//$this->assign('autorun',($_CONFIG[$tem['login_method'].'_AUTORUN']).' '.$_SESSION['ADMIN_UID'].($appdeviceid>0 ? '-'.$appdeviceid : '').' '.$dev['device_ip'].(empty($_CONFIG['RDPREPLAYIP']) ? ' '.$_CONFIG['APP_HOST'] : ' '.$_CONFIG['RDPREPLAYIP']).' 59827');
					//var_dump(getBrowserVer());
					if(getBrowser()=='ie'&&getBrowserVer()==8){
						$autorun = urlencode(addcslashes(('"'.$dev['device_ip'].'" "'.$user['username'].'" "'.$user['password'].'" "'.$_CONFIG[$tem['login_method'].'_AUTORUN'].'"').' "'.$_SESSION['ADMIN_UID'].($appdeviceid>0 ? '-'.$appdeviceid : '').' '.$dev['device_ip'].(empty($_CONFIG['RDPREPLAYIP']) ? ' '.$_CONFIG['APP_HOST'] : ' '.$_CONFIG['RDPREPLAYIP']).' '.$_SERVER['REMOTE_ADDR'].'"','"'));
					}else{
						$autorun = urlencode((('"'.$dev['device_ip'].'" "'.$user['username'].'" "'.$user['password'].'" "'.$_CONFIG[$tem['login_method'].'_AUTORUN'].'"').' "'.$_SESSION['ADMIN_UID'].($appdeviceid>0 ? '-'.$appdeviceid : '').' '.$dev['device_ip'].(empty($_CONFIG['RDPREPLAYIP']) ? ' '.$_CONFIG['APP_HOST'] : ' '.$_CONFIG['RDPREPLAYIP']).' '.$_SERVER['REMOTE_ADDR'].'"'));
					}
					$this->assign('autorun', $autorun);
					$this->assign("apppub", 1);
					$this->assign("sid", $id.'--'.$str);
					$this->assign('username',$user['username'].'--'.$dev[id].'--'.$str);
					$this->assign('password',$str.'--');
					$this->assign('host', $dev['device_ip']);
					$this->assign('port',5000);
					$this->assign('username', urlencode($user['username']));
					$this->assign('password', urlencode($user['password']));
					$this->assign('path', urlencode(addslashes($_CONFIG[$tem['login_method'].'_AUTORUN'])));
					$this->assign('param', $_SESSION['ADMIN_UID'].($appdeviceid>0 ? '-'.$appdeviceid : '').' '.$dev['device_ip'].(empty($_CONFIG['RDPREPLAYIP']) ? ' '.$_CONFIG['APP_HOST'] : ' '.$_CONFIG['RDPREPLAYIP']).' '.$_SERVER['REMOTE_ADDR']);
					$this->assign("rdpclientversion", $_CONFIG['RdpClientVersion']);
				}
				$this->display('WebSysbaseOraclelogin_mstsc.tpl');
			}			
		}
		else/*if($type=='fort' || $dev_type['device_type'] == 'linux')*/ {
			$_SESSION['AUTHDEVICESIDS']=null;
			$_SESSION['COMMITDEVICESIDS']=null;
			$_SESSION['INPUTDEVICESIDS']=null;
			$_SESSION['LOGIN_ID']=null;
			$_SESSION['SMSAUTHDEVICESIDS']=null;

			$this->assign('serveradd',$_SERVER['SERVER_NAME']);
			$user['password']=$this->member_set->udf_decrypt($user['password']);
			$this->assign('username',$user['username'].'--'.$dev[username]);	
			$this->assign('dusername',$dev['username']);		
			$this->assign('password',$user['password']);
			$this->assign('port',$dev['port']);
			$this->assign('ip',$dev['device_ip']);
			$this->assign('dusername',$dev['username']);
			$this->assign("loginmethod", (($logintool=='securecrt'&&$tem[login_method]=='ssh') ? 'ssh2' : ($tem[login_method]=='telnet' or $tem[login_method]=='rlogin') ? 'ssh': $tem[login_method] ) );
			if($login_method=='ssh1' or$login_method=='ssh' or $login_method=='telnet' or $login_method=='rlogin'){
				$this->assign('port','22');
			}
			
			$this->assign("cid", $user[uid]);
			$this->assign("sid", $id);
			
			$this->assign("proxy_addr", $selectedip);

			$this->assign("logintool", $logintool);
			
			$str = genRandomString(8);
		
			if(!$this->insertrandom($selectedip, $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
						echo('alert("请重新选择IP");');
					exit;
			}
			$this->assign('username',$user['username'].'--'.$dev[username].'--'.$str);
			$this->assign('sid',$id.'--'.$str);
			$this->assign('password',$str);
			$this->assign('webusername',$user['username'].'--'.$id.'--'.$str);
			$this->assign('crttab',$user['crttab']);	
			
			$this->display('devlogin.tpl');
		}
	}
	
	function gateone(){
		$host = get_request("host", 0, 1);
		$port = get_request("port", 0, 1);
		$username = get_request("username", 0, 1);
		$password = get_request("password", 0, 1);
		$this->assign("host", $host);	
		$this->assign("port", $port);	
		$this->assign("username", $username);	
		$this->assign("password", $password);	
		$this->display("gateone.tpl");
	}

	function cutoff(){
		global $_CONFIG;
		$sid = get_request('id');
		$url = get_request('loginurl', 0, 1);
		$pass = $this->devpass_set->select_by_id($sid);
		$tem = $this->tem_set->select_by_id($pass['login_method']);
		//$cmd='sudo '.$_CONFIG['RDP_CUTOFF'].' localhost S'.$session['threadid'];
		$l_where="addr like '%".$pass['device_ip']."%'";
		if(!empty($pass['username'])){
			$l_where .= " AND user='".$pass['username']."'";
		}
		if($tem['login_method'] == 'RDP'){
			$run_sessions = $this->rdp_set->select_all($l_where." AND (LOGIN_TEMPLATE=8 or LOGIN_TEMPLATE=14 or LOGIN_TEMPLATE=22) and rdp_runnig=1");
		}elseif($tem['login_method'] == 'vnc'){
			$run_sessions = $this->rdp_set->select_all($l_where." AND LOGIN_TEMPLATE=21 and rdp_runnig=1");
		}
		for($i=0; $i<count($run_sessions); $i++){
			$sid = $run_sessions[$i]['sid'];
			$threadid = $run_sessions[$i]['threadid'];
			$cmd = "sudo /bin/kill -9 ".$threadid;
			exec($cmd, $out, $return);
			$this->rdp_set->query("UPDATE ".$this->rdp_set->get_table_name()." SET rdp_runnig=0, end=NOW() WHERE sid=$sid");
		}
		go_url("admin.php?".urldecode($url));
	}

	function get_devgroup_child_for_interface($sgroup, $level, $_groupid, $groupindex){
		$count=$sgroup['count']=$this->server_set->select_count('groupid='.$sgroup['id']);
		$mcount=$sgroup['mcount']=$this->member_set->select_count('groupid='.$sgroup['id']);
		if(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101)&&!in_array($sgroup['id'], $_SESSION['ADMIN_MUSERGROUP_IDS'])){
			$count = 0;
			$mcount = 0;
		}
		if($_SESSION['ADMIN_MSERVERGROUP']==$sgroup['id']){//
			$mcount-=1;
		}
		$subgroup = $this->sgroup_set->select_all("ldapid=".$sgroup['id'].(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? " AND id IN(".implode(',', array_merge($_SESSION['ADMIN_MUSERGROUP_IDS'],$_SESSION['ADMIN_MSERVERGROUP_PARENT_IDS'])).")" : "" ).($_groupid ? ' and id IN('.implode(',', $_groupid).')' : ''), "groupname", "ASC");
		for($j=0; $j<count($subgroup); $j++){
			if($_SESSION['ADMIN_MSERVERGROUP']==$subgroup[$j]['id']){
				$subgroup[$j]['mcount']-=1;
			}
			switch($subgroup[$j]['attribute']){
				case '1':
					$attribute = '用户';
					break;
				case '2':
					$attribute = '主机';
					break;
				default:
					$attribute = '全部';
 
			}
			$_subchild=$this->get_devgroup_child($subgroup[$j], $level+1, $_groupid, $groupindex.'_'.$j);
			$count+=$_subchild['count'];
			$mcount+=$_subchild['mcount'];
			$subgroup[$j]['childs']=$_subchild;
		}
		$groupstr .= "</TBODY>";
		$sgroup['count']=$count;
		$sgroup['mcount']=$mcount;
		return array('groupstr'=>$groupstr, 'count'=>$sgroup['count'], 'mcount'=>$sgroup['mcount'], 'childrenct'=>count($subgroup));
	}
	
	function get_devgroup_child($sgroup, $level, $_groupid, $groupindex){
		$count=$sgroup['count']=$this->server_set->select_count('groupid='.$sgroup['id']);
		$mcount=$sgroup['mcount']=$this->member_set->select_count('groupid='.$sgroup['id']);
		if(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101)&&!in_array($sgroup['id'], $_SESSION['ADMIN_MUSERGROUP_IDS'])){
			$count = 0;
			$mcount = 0;
		}
		if($_SESSION['ADMIN_MSERVERGROUP']==$sgroup['id']){//
			$mcount-=1;
		}
		$subgroup = $this->sgroup_set->select_all("ldapid=".$sgroup['id'].(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? " AND id IN(".implode(',', array_merge($_SESSION['ADMIN_MUSERGROUP_IDS'],$_SESSION['ADMIN_MSERVERGROUP_PARENT_IDS'])).")" : "" ).($_groupid ? ' and id IN('.implode(',', $_groupid).')' : ''), "groupname", "ASC");
		for($j=0; $j<count($subgroup); $j++){
			if($_SESSION['ADMIN_MSERVERGROUP']==$subgroup[$j]['id']){
				$subgroup[$j]['mcount']-=1;
			}
			switch($subgroup[$j]['attribute']){
				case '1':
					$attribute = '用户';
					break;
				case '2':
					$attribute = '主机';
					break;
				default:
					$attribute = '全部';
	
			}
			$_subchild=$this->get_devgroup_child($subgroup[$j], $level+1, $_groupid, $groupindex.'_'.$j);
			$count+=$_subchild['count'];
			$mcount+=$_subchild['mcount'];
			$groupstr .= '<TBODY name="ldap'.'_'.$groupindex.'"  id="ldap'.'_'.$groupindex."_".$j.'" style="DISPLAY: none">
							<tr '.($j%2==0 ? 'bgcolor="f7f7f7"' : '' ).'>
							<td class=td25 width="20">&nbsp;</TD>
							<td onClick="toggle_group(\'ldap'.'_'.$groupindex."_".$j.'\', $(\'a_ldap'.'_'.$groupindex."_".$j.'\'),'.$sgroup['id'].','.$level.')">'.str_repeat('&nbsp;&nbsp;',$level).($_subchild['childrenct']>0 ? '<span class="td25"><A id=a_ldap'.'_'.$groupindex."_".$j.' href="javascript:;">[+]</A></span>' : '').'<a href="admin.php?controller=admin_pro&action=dev_index&gid='.$subgroup[$j]['id'].'">&nbsp;'.$subgroup[$j]['groupname'].'</a></td>
							<td class=td25 width="20"><a href="admin.php?controller=admin_pro&action=dev_index&gid='.$subgroup[$j]['id'].'">&nbsp;'.$subgroup[$j]['id'].'</a></TD>
							<td>'.$attribute.'</td>
							<td><a href="admin.php?controller=admin_pro&action=dev_index&gid='.$subgroup[$j]['id'].'&from=dir">'.$subgroup[$j]['count'].'</a></td>
							<td><a href="admin.php?controller=admin_member&gid='.$subgroup[$j]['id'].'&from=dir">'.$subgroup[$j]['mcount'].'</a></td>
							<td>'.$subgroup[$j]['description'].'</td>
							<td>'.(($_SESSION['ADMIN_LEVEL'] == 1 or $_SESSION['ADMIN_LEVEL'] == 3 or $_SESSION['ADMIN_LEVEL'] == 21 or $_SESSION['ADMIN_LEVEL'] == 101) ? '
							<img src="'.substr($this->smarty->template_dir[0],strlen(ROOT)).'/images/edit_ico.gif" width=16 height="16" hspace="5" border="0" align="absmiddle"><a href="admin.php?controller=admin_pro&action=devgroup_edit&id='.$subgroup[$j]['id'].'" >编辑</a> |
							<img src="'.substr($this->smarty->template_dir[0],strlen(ROOT)).'/images/delete_ico.gif" width=16 height="16" hspace="5" border="0" align="absmiddle"><a href="#" onClick="if(!confirm(\'您确定要删除？\')) {return false;} else { location.href=\'admin.php?controller=admin_pro&action=dev_group_del&id='.$subgroup[$j]['id'].'\';}">删除</a>
							' : '').'</td></tr>';
			$groupstr .= $_subchild['groupstr'];
		}
		$groupstr .= "</TBODY>";
		$sgroup['count']=$count;
		$sgroup['mcount']=$mcount;
		return array('groupstr'=>$groupstr, 'count'=>$sgroup['count'], 'mcount'=>$sgroup['mcount'], 'childrenct'=>count($subgroup));
	}

	function get_devgroup_child2($sgroup, $level, $_groupid, $groupindex){
		//$count=$sgroup['count']=$this->server_set->select_count('groupid='.$sgroup['id']);
		//$mcount=$sgroup['mcount']=$this->member_set->select_count('groupid='.$sgroup['id']);
		if(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101)&&!in_array($sgroup['id'], $_SESSION['ADMIN_MUSERGROUP_IDS'])){
			$count = 0;
			$mcount = 0;
		}
		if($_SESSION['ADMIN_MSERVERGROUP']==$sgroup['id']){//
			//$mcount-=1;
		}
		$subgroup = $this->sgroup_set->select_all("ldapid=".$sgroup['id'].(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? " AND id IN(".implode(',', array_merge($_SESSION['ADMIN_MUSERGROUP_IDS'],$_SESSION['ADMIN_MSERVERGROUP_PARENT_IDS'])).")" : "" ).($_groupid ? ' and id IN('.implode(',', $_groupid).')' : ''), "groupname", "ASC");
		for($j=0; $j<count($subgroup); $j++){
			if($_SESSION['ADMIN_MSERVERGROUP']==$subgroup[$j]['id']){
				//$subgroup[$j]['mcount']-=1;
			}
			switch($subgroup[$j]['attribute']){
				case '1':
					$attribute = '用户';
					break;
				case '2':
					$attribute = '主机';
					break;
				default:
					$attribute = '全部';
 
			}
			//$_subchild=$this->get_devgroup_child2($subgroup[$j], $level+1, $_groupid, $groupindex.'_'.$j);
			//$count+=$_subchild['count'];
			//$mcount+=$_subchild['mcount'];
			$groupstr .= '<TBODY name="ldap'.'_'.$groupindex.'"  id="ldap'.'_'.$groupindex."_".$j.'" style="DISPLAY: none">					
							<tr '.($j%2==0 ? 'bgcolor="f7f7f7"' : '' ).'>
							<td class=td25 width="20">&nbsp;</TD>
							<td onClick="toggle_group(\'ldap'.'_'.$groupindex."_".$j.'\', $(\'a_ldap'.'_'.$groupindex."_".$j.'\'))">'.str_repeat('&nbsp;&nbsp;',$level).($_subchild['childrenct']>0 ? '<span class="td25"><A id=a_ldap'.'_'.$groupindex."_".$j.' href="javascript:;">[+]</A></span>' : '').'<a href="admin.php?controller=admin_pro&action=dev_index&gid='.$subgroup[$j]['id'].'">&nbsp;'.$subgroup[$j]['groupname'].'</a></td>
							<td class=td25 width="20"><a href="admin.php?controller=admin_pro&action=dev_index&gid='.$subgroup[$j]['id'].'">&nbsp;'.$subgroup[$j]['id'].'</a></TD>
							<td>'.$attribute.'</td>
							<td><a href="admin.php?controller=admin_pro&action=dev_index&gid='.$subgroup[$j]['id'].'&from=dir">'.$subgroup[$j]['count'].'</a></td>
							<td><a href="admin.php?controller=admin_member&gid='.$subgroup[$j]['id'].'&from=dir">'.$subgroup[$j]['mcount'].'</a></td>
							<td>'.$subgroup[$j]['description'].'</td>
							<td>'.(($_SESSION['ADMIN_LEVEL'] == 1 or $_SESSION['ADMIN_LEVEL'] == 3 or $_SESSION['ADMIN_LEVEL'] == 21 or $_SESSION['ADMIN_LEVEL'] == 101) ? '
							<img src="'.substr($this->smarty->template_dir[0],strlen(ROOT)).'/images/edit_ico.gif" width=16 height="16" hspace="5" border="0" align="absmiddle"><a href="admin.php?controller=admin_pro&action=devgroup_edit&id='.$subgroup[$j]['id'].'" >编辑</a> | 
							<img src="'.substr($this->smarty->template_dir[0],strlen(ROOT)).'/images/delete_ico.gif" width=16 height="16" hspace="5" border="0" align="absmiddle"><a href="#" onClick="if(!confirm(\'您确定要删除？\')) {return false;} else { location.href=\'admin.php?controller=admin_pro&action=dev_group_del&id='.$subgroup[$j]['id'].'\';}">删除</a> 
							' : '').'</td></tr>';
			$groupstr .= $_subchild['groupstr'];
		}
		$groupstr .= "</TBODY>";
		//$sgroup['count']=$count;
		//$sgroup['mcount']=$mcount;
		return array('groupstr'=>$groupstr, 'count'=>$sgroup['count'], 'mcount'=>$sgroup['mcount'], 'childrenct'=>count($subgroup));
	}
	

	function dev_group($interface=false) {
		global $_CONFIG;
		$back = get_request('back');
		if($back){
			//if(strpos($_SERVER['HTTP_REFERER'], 'devgroup_edit')>0)
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$level = get_request('level');
		$ldapid = get_request('ldapid');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$groupname = get_request('groupname', 0, 1);
		
		$where = '1=1';
		if(empty($orderby1)){
			$orderby1 = 'convert(groupname using gbk)';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		if(!empty($groupname)){
			$where .= " AND groupname like '%".$groupname."%'";
		}
		if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			$where .= ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0 ' : '')." AND (id IN (".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).") or id IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_PARENT_IDS']).")) ";
		}
		if($_CONFIG['LDAP']){
			$_where = '1';
			if(!empty($groupname)){
				$search=1;
				$search_array_ids = array();
				$groupid = $this->sgroup_set->select_all($where." ");
				$__parent = array();
				for($i=0; $i<count($groupid); $i++){
					$_groupid[]=$groupid[$i]['id'];
					$_tmpgroup=$groupid[$i];
					if(!in_array($_tmpgroup['ldapid'], $__parent))
					while($_tmpgroup['ldapid']){
						$_tmpgroup = $this->sgroup_set->select_by_id($_tmpgroup['ldapid']);
						$__parent[]=$_groupid[]=$_tmpgroup['id'];
					}
				}
				$_SESSION['dev_group_index']['_groupid']=$_groupid;
				$_where .= ' AND id IN('.($_groupid ? implode(',', $_groupid) : '0').')';
			}
			if(empty($ldapid)){
				$_where .= " AND ldapid=0 ";//." AND ".$where;
			}else{
				$_where .= " AND ldapid=".$ldapid;//." AND ".$where;
			}
			$row_num = $this->sgroup_set->select_count($_where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			if($_SESSION['ADMIN_LEVEL']==1){
				if(!$_SESSION['ADMIN_SEARCHCACHE']){
					$this->sgroup_set->query("call upgroups(".$_SESSION['ADMIN_UID'].")");
				}
				$alldev = $this->sgroup_set->base_select("SELECT * FROM ".$this->sgroup_set->get_table_name()." WHERE ".$_where." ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
			}elseif(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101)&&!in_array($id, $_SESSION['ADMIN_MUSERGROUP_IDS'])){
				if(!$_SESSION['ADMIN_SEARCHCACHE']){
					$this->sgroup_set->query("call updpgroups(".$_SESSION['ADMIN_UID'].")");
				}
				$count = 0;
				$mcount = 0;
				$alldev = $this->sgroup_set->base_select("select *,groupid id from servergroup_cache where ldapid=0 and memberid=".$_SESSION['ADMIN_UID']);
			}
			for($i=0; $i<count($alldev); $i++){
				if($interface){
					$subchild = $this->get_devgroup_child_for_interface($alldev[$i], 2, $_groupid, $i);
					$alldev[$i]['childs']=$subchild;
				}else{
					//$subchild = $this->get_devgroup_child2($alldev[$i], 2, $_groupid, $i);
					$alldev[$i]['groupstr']=$subchild['groupstr'];
				}
					//$alldev[$i]['count']=$subchild['count'];
					//$alldev[$i]['mcount']=$subchild['mcount'];
					
					$alldev[$i]['childrenct']=(strpos($alldev[$i]['child'],',')!==false ? 1 : 0);
					//var_dump($alldev[$i]['childrenct']);
			}
				//echo '<pre>';var_dump($alldev[$i]);echo '</pre>';
			
			if($interface){
				return $alldev;
			}

		}else{
			$row_num = $this->sgroup_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			//$alldev = $this->sgroup_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
			$alldev = $this->sgroup_set->base_select("SELECT * FROM ".$this->sgroup_set->get_table_name()." WHERE ".$where. " ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
			if($interface){
				return $alldev;
			}
		}
		//echo '<pre>';var_dump($alldev);echo '</pre>';
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('title', language('设备组列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('ldapid', $ldapid);
		$this->assign('ldapinfo', $this->sgroup_set->select_by_id($ldapid));
		$this->assign('curr_url', $curr_url);
		$this->assign('_config', $_CONFIG);
		$this->assign('groupname', $groupname);
		$this->display('dev_group_index.tpl');
	}
	
	
	function userdev_group() {
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'GroupName';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		$where = '1=1';
		if($_SESSION['ADMIN_LEVEL']==0){
			$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
			$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
			$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID'].")";
			$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP'].")";
		
			$alldevid = $this->member_set->base_select($sql);
			$alldevsid = array();
			for($i=0; $i<count($alldevid); $i++){
				$alldevsid[]=$alldevid[$i]['devicesid'];
			}
			if($alldevsid){
				//$where .= " AND id IN";
			}else{
				$where .= " AND 0" ;
			}
		}
		if(empty($alldevsid)){
			$alldevsid = array(0);
		}
		$sql = "SELECT sg.*,t.sct FROM ".$this->sgroup_set->get_table_name()." sg LEFT JOIN (SELECT s.groupid,count(*) sct FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ".$this->server_set->get_table_name()." s ON d.device_ip=s.device_ip WHERE d.id IN(".implode(',',$alldevsid).") group by s.groupid ) t ON sg.id=t.groupid Where $where AND t.sct > 0 ORDER BY sg.groupname ASC";

		$row_num = $this->sgroup_set->select_count("id IN (SELECT s.groupid FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ".$this->server_set->get_table_name()." s ON d.device_ip=s.device_ip WHERE d.id IN(".implode(',',$alldevsid).") group by s.groupid )");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->sgroup_set->base_select($sql);

		$this->assign('title', language('服务器组列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('userdev_group_index.tpl');
	}
	
	function servergroup_bind(){
		$id = get_request("id");
		$sessionluser = 'SERVERGROUP_USER';
		$sessionlgroup = 'SERVERGROUP_GROUP';
		$usergroup = $this->usergroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		$this->assign('usergroup', $usergroup);

		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''),'username','ASC');
		$_SESSION[$sessionluser] = $this->luser_devgrp_set->select_all('serversid='.$id);
		$_SESSION[$sessionlgroup] = $this->lgroup_devgrp_set->select_all('serversid='.$id);
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			$allbind[$i] = $_SESSION[$sessionluser][$i]['memberid'];
		}
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			$allgroup[$i] = $_SESSION[$sessionlgroup][$i]['groupid'];
		}
		$num = count($allmem);
		for($i=0;$i<$num;$i++) {
			if(count($allbind)==0) {
				break;
			}
			for($j=0;$j<count($allbind);$j++) {
				if($allmem[$i]['uid'] == $allbind[$j] ) {
					//array_shift($allbind);
					$allmem[$i]['check'] = 'checked';
					break;
				}
			}
		}
		//$allgroup = explode(',',trim($old_pass['lgroup'],','));
		$groupnum = count($usergroup);
		for($i=0;$i<$groupnum;$i++) {
			if(count($allgroup)==0) {
				break;
			}
			for($j=0;$j<count($allgroup);$j++) {
				if($usergroup[$i]['id'] == $allgroup[$j] ) {
					//array_shift($allgroup);
					$usergroup[$i]['check'] = 'checked';
					break;
				}
			}
		}
		$this->assign("id", $id);
		$this->assign("sessionlgroup", $sessionlgroup);
		$this->assign("sessionluser", $sessionluser);
		$this->assign("allmem", $allmem);
		$this->assign("usergroup", $usergroup);
		$this->display('servergroup_bind.tpl');
	}

	function resourcegroup_bind($fromedit=null){
		global $_CONFIG;
		$id = get_request("id");
		$webuser = get_request('webuser',0,1);
		$webgroup = get_request('webgroup',0,1);
		$fromdevpriority = get_request("fromdevpriority");
		$sessionluser = 'RESOURCEGROUP_USER';
		$sessionlgroup = 'RESOURCEGROUP_GROUP';	

		require_once('./include/select_sgroup_ajax.inc.php');
		if($ori_g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_all("id IN(".(is_array($ori_g_id)?implode(',', $ori_g_id): $ori_g_id).")");
			$__tmpgid = $ori_g_id;
			for($i=0; $i<count($_tmpgid); $i++){
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$_tmpgid[$i]['id']." or groupid IN(".$_tmpgid[$i]['child'].")");
				for($i=0; $i<count($allips); $i++){
					$cronreport_alltmpip[]=$allips[$i]['device_ip'];
				}
				$__tmpgid .= ','.$_tmpgid[$i]['child'];
			}
			$wheremember = ' AND groupid IN('.$__tmpgid.')';
			$wheregroup = ' AND id IN('.$__tmpgid.')';
		}

		$ginfo = $this->resgroup_set->select_by_id($id);
		$usergroup = $this->usergroup_set->select_all((empty($webgroup) ? '' : " groupname like '%$webgroup%' AND " ).'(select count(0) FROM '.$this->member_set->get_table_name().' where groupid='.$this->usergroup_set->get_table_name().'.id) >0 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : '').$wheregroup,'GroupName', 'ASC');		
		$this->assign('usergroup', $usergroup);

		$allmem = $this->member_set->select_all(" level!=11 ".(empty($webuser) ? '' : " AND username like '%$webuser%' " )." ".$wheremember." AND uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''),'username','ASC');
		$_SESSION[$sessionluser] = $this->luser_resourcegrp_set->select_all('resourceid='.$id);
		$_SESSION[$sessionlgroup] = $this->lgroup_resourcegrp_set->select_all('resourceid='.$id);
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			$allbind[$i] = $_SESSION[$sessionluser][$i]['memberid'];
			$aclpolicy = $this->restrictpolicy_set->select_all("memberid='".$_SESSION[$sessionluser][$i]['memberid']."' AND resourceid='".$_SESSION[$sessionluser][$i]['resourceid']."'");
			if($aclpolicy){
				$_SESSION[$sessionluser][$i]['restrictacl']=$aclpolicy[0]['aclid'];
			}
		}
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			$allgroup[$i] = $_SESSION[$sessionlgroup][$i]['groupid'];
			$aclpolicy = $this->restrictpolicy_set->select_all("usergroupid='".$_SESSION[$sessionlgroup][$i]['groupid']."' AND resourceid='".$_SESSION[$sessionlgroup][$i]['resourceid']."'");
			if($aclpolicy){
				$_SESSION[$sessionlgroup][$i]['restrictacl']=$aclpolicy[0]['aclid'];
			}
		}
		$binded = 0;
		$num = count($allmem);
		for($i=0;$i<$num;$i++) {
			if(count($allbind)==0) {
				break;
			}
			for($j=0;$j<count($allbind);$j++) {
				if($allmem[$i]['uid'] == $allbind[$j] ) {
					//array_shift($allbind);
					$allmem[$i]['check'] = 'checked';
					$binded++;
					break;
				}
			}
		}
		//$allgroup = explode(',',trim($old_pass['lgroup'],','));
		$groupnum = count($usergroup);
		for($i=0;$i<$groupnum;$i++) {
			if(count($allgroup)==0) {
				break;
			}
			for($j=0;$j<count($allgroup);$j++) {
				if($usergroup[$i]['id'] == $allgroup[$j] ) {
					//array_shift($allgroup);
					$usergroup[$i]['check'] = 'checked';
					$binded++;
					break;
				}
			}
		}
		$ginfo['devicesct']=$binded;
		$this->assign("id", $id);
		$this->assign("sessionlgroup", $sessionlgroup);
		$this->assign("sessionluser", $sessionluser);
		$this->assign("allmem", $allmem);
		$this->assign("ginfo", $ginfo);
		$this->assign("fromdevpriority", $fromdevpriority);
		$this->assign("usergroup", $usergroup);
		if(empty($fromedit))
		$this->display('resourcegroup_bind.tpl');
	}
	
	function servergroup_bindsave(){
		$sid = get_request("id");
		$sessionluser = get_request('sessionluser', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);

		$passcount = $this->member_set->select_count('1 = 1');
		$new_user = ',';
		$j = 0;
		for($i = 0;$i<$passcount;$i++) {
			if(0 != get_request("Check$i",1,0)) {
				$new_userid[] = get_request("Check$i",1,0);
				$j++;
			}
		}
		
		$new_group = ',';
		$j = 0;
		$gcount = $this->usergroup_set->select_count();
		for($i = 0;$i<$gcount;$i++) {
			if(0 != get_request("Group$i",1,0)) {
				$new_groupid[] = get_request("Group$i",1,0);
				$j++;
			}
		}
		$this->servergroup_luser_group_save($sessionluser, $sessionlgroup, $sid, $new_userid, $new_groupid);
		alert_and_back('操作成功','admin.php?controller=admin_pro&action=dev_group');
	}

	function resourcegroup_bindsave($id=null, $change=false){
		$sid = get_request("id");
		if(empty($sid)) $sid=$id;
		$sessionluser = get_request('sessionluser', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);

		$passcount = $this->member_set->select_count('1 = 1');
		$new_user = ',';
		$j = 0;
		for($i = 0;$i<$passcount;$i++) {
			if(0 != get_request("Check$i",1,0)) {
				$new_userid[] = get_request("Check$i",1,0);
				$j++;
			}
		}
		
		$new_group = ',';
		$j = 0;
		$gcount = $this->usergroup_set->select_count();
		for($i = 0;$i<$gcount;$i++) {
			if(0 != get_request("Group$i",1,0)) {
				$new_groupid[] = get_request("Group$i",1,0);
				$j++;
			}
		}
		if($change){
			if($new_userid)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where uid IN(".implode(',', $new_userid).")");
			if($new_groupid)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid IN(".implode(',', $new_groupid).")");
		}
		$this->resourcegroup_luser_group_save($sessionluser, $sessionlgroup, $sid, $new_userid, $new_groupid);
		if(empty($id))
		alert_and_back('操作成功','admin.php?controller=admin_pro&action=resource_group&back=1');
	}
	
	private function servergroup_luser_group_save($sessionluser, $sessionlgroup, $sid, $newuser, $newgroup){
		$user[]=0;
		$group[]=0;
		if(empty($newuser)){
			$newuser[0]=0;
		}		
		if(empty($newgroup)){
			$newgroup[0]=0;
		}
		$this->luser_devgrp_set->query("DELETE FROM ".$this->luser_devgrp_set->get_table_name()." WHERE memberid NOT IN(".implode(',', $newuser).") AND serversid=$sid");
		$this->lgroup_devgrp_set->query("DELETE FROM ".$this->lgroup_devgrp_set->get_table_name()." WHERE groupid NOT IN(".implode(',', $newgroup).") AND serversid=$sid");

		
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if(in_array($_SESSION[$sessionluser][$i]['memberid'], $newuser)){
				$luser = new luser_devgrp();
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);				
				$luser->set_data('rdpclipauth_up', $_SESSION[$sessionluser][$i]['rdpclipauth_up']);
				$luser->set_data('rdpdiskauth_up', $_SESSION[$sessionluser][$i]['rdpdiskauth_up']);				
				$luser->set_data('rdpclipauth_down', $_SESSION[$sessionluser][$i]['rdpclipauth_down']);
				$luser->set_data('rdpdiskauth_down', $_SESSION[$sessionluser][$i]['rdpdiskauth_down']);	
				$luser->set_data('sourceip', $_SESSION[$sessionluser][$i]['sourceip']);
				$luser->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
				$luser->set_data('serversid', $_SESSION[$sessionluser][$i]['serversid']);
				$luser->set_data('forbidden_commands_groups', $_SESSION[$sessionluser][$i]['forbidden_commands_groups']);		
				if($_SESSION[$sessionluser][$i]['id']){
					$luser->set_data('id', $_SESSION[$sessionluser][$i]['id']);
					$this->luser_devgrp_set->edit($luser);
				}else{
					$this->luser_devgrp_set->add($luser);
				}

				$user[] = $_SESSION[$sessionluser][$i]['memberid'];
			}
		}
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if(in_array($_SESSION[$sessionlgroup][$i]['groupid'], $newgroup)){
				$lgroup = new lgroup_devgrp();
				$lgroup->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
				$lgroup->set_data('rdpclipauth_up', $_SESSION[$sessionlgroup][$i]['rdpclipauth_up']);
				$lgroup->set_data('rdpdiskauth_up', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_up']);	
				$lgroup->set_data('rdpclipauth_down', $_SESSION[$sessionlgroup][$i]['rdpclipauth_down']);
				$lgroup->set_data('rdpdiskauth_down', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_down']);	
				$lgroup->set_data('sourceip', $_SESSION[$sessionlgroup][$i]['sourceip']);
				$lgroup->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
				$lgroup->set_data('serversid', $_SESSION[$sessionlgroup][$i]['serversid']);	
				$lgroup->set_data('forbidden_commands_groups', $_SESSION[$sessionlgroup][$i]['forbidden_commands_groups']);		
				
				if($_SESSION[$sessionlgroup][$i]['id']){
					$lgroup->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
					$this->lgroup_devgrp_set->edit($lgroup);
				}else{
					$this->lgroup_devgrp_set->add($lgroup);
				}
				$group[] = $_SESSION[$sessionlgroup][$i]['groupid'];
			}
		}
		if($newuser)
		$u = array_diff($newuser, $user);
		if($newgroup)
		$g = array_diff($newgroup, $group);
		
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		
		if($u)
		foreach($u AS $key => $value){
			$luser = new luser_devgrp();
			$luser->set_data('weektime', $dp['weektime']);
			$luser->set_data('sourceip', $dp['sourceip']);
			$luser->set_data('rdpclipauth_up', $dp['rdpclipauth_up']);
			$luser->set_data('rdpdiskauth_up', $dp['rdpdiskauth_up']);	
			$luser->set_data('rdpclipauth_down', $dp['rdpclipauth_down']);
			$luser->set_data('rdpdiskauth_down', $dp['rdpdiskauth_down']);					
			$luser->set_data('memberid', $value);
			$luser->set_data('serversid', $sid);
			$this->luser_devgrp_set->add($luser);

		}
		if($g)
		foreach($g AS $key => $value){
			$lgroup = new lgroup_devgrp();
			$lgroup->set_data('weektime', $dp['weektime']);
			$lgroup->set_data('sourceip', $dp['sourceip']);
			$lgroup->set_data('rdpclipauth_up', $dp['rdpclipauth_up']);
			$lgroup->set_data('rdpdiskauth_up', $dp['rdpdiskauth_up']);	
			$lgroup->set_data('rdpclipauth_down', $dp['rdpclipauth_down']);
			$lgroup->set_data('rdpdiskauth_down', $dp['rdpdiskauth_down']);	
			$lgroup->set_data('groupid', $value);
			$lgroup->set_data('serversid', $sid);
			$this->lgroup_devgrp_set->add($lgroup);
		}

		unset($_SESSION[$sessionluser]);
		unset($_SESSION[$sessionlgroup]);
	} 

	private function resourcegroup_luser_group_save($sessionluser, $sessionlgroup, $sid, $newuser, $newgroup){
		$user[]=0;
		$group[]=0;
		
		$servergrp = $this->resgroup_set->select_by_id($sid);
		$allusers = $this->luser_resourcegrp_set->select_all("resourceid='$sid'");
		for($i=0; $i<count($allusers); $i++){
			$alluserid[] = $allusers[$i]['memberid'];
		}
		$added = $newuser;
		if($alluserid&&$newuser){
			$added = array_diff($newuser, $alluserid);
			$removed = array_diff($alluserid, $newuser);
		}
		if(empty($newuser)){
			$removed = $alluserid;
		}

		if($added)
		foreach($added AS $k=>$v){
			$member = $this->member_set->select_by_id($v);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('luser', $member['username']);
			$adminlog->set_data('action', language('系统用户组绑定运维用户'));
			$adminlog->set_data('resource', $servergrp['groupname']);
			$adminlog->set_data('type', 1);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
			if($member)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where uid=".$member['uid']);
		}
		if($removed)
		foreach($removed AS $k=>$v){
			$member = $this->member_set->select_by_id($v);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('luser', $member['username']);
			$adminlog->set_data('action', language('系统用户组解绑运维用户'));
			$adminlog->set_data('resource', $servergrp['groupname']);
			$adminlog->set_data('type', 1);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
			if($member)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where uid=".$member['uid']);
		}
		$allgroups = $this->lgroup_resourcegrp_set->select_all("resourceid='$sid'");
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
			$adminlog->set_data('action', language('系统用户组绑定资源组'));
			$adminlog->set_data('resource', $servergrp['groupname']);
			$adminlog->set_data('type', 2);
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
			$adminlog->set_data('action', language('系统用户组解绑资源组'));
			$adminlog->set_data('resource', $servergrp['groupname']);
			$adminlog->set_data('type', 2);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
			if($ugroup)
				$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid=".$ugroup['id']);
		}

		if(empty($newuser)){
			$newuser[0]=0;
		}		
		if(empty($newgroup)){
			$newgroup[0]=0;
		}

		$this->luser_resourcegrp_set->query("DELETE FROM ".$this->luser_resourcegrp_set->get_table_name()." WHERE memberid NOT IN(".implode(',', $newuser).") AND resourceid=$sid");
		$this->lgroup_resourcegrp_set->query("DELETE FROM ".$this->lgroup_resourcegrp_set->get_table_name()." WHERE groupid NOT IN(".implode(',', $newgroup).") AND resourceid=$sid");
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if(in_array($_SESSION[$sessionluser][$i]['memberid'], $newuser)){
				$luser = new luser_resourcegrp();
				$luser->set_data('syslogalert', $_SESSION[$sessionluser][$i]['syslogalert']);
				$luser->set_data('mailalert', $_SESSION[$sessionluser][$i]['mailalert']);
				$luser->set_data('autosu', $_SESSION[$sessionluser][$i]['autosu']);
				$luser->set_data('loginlock', $_SESSION[$sessionluser][$i]['loginlock']);
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);
				$luser->set_data('twoauth', $_SESSION[$sessionluser][$i]['twoauth']);
				$luser->set_data('rdpclipauth_up', $_SESSION[$sessionluser][$i]['rdpclipauth_up']);
				$luser->set_data('rdpdiskauth_up', $_SESSION[$sessionluser][$i]['rdpdiskauth_up']);
				$luser->set_data('rdpclipauth_down', $_SESSION[$sessionluser][$i]['rdpclipauth_down']);
				$luser->set_data('rdpdiskauth_down', $_SESSION[$sessionluser][$i]['rdpdiskauth_down']);
				$luser->set_data('sourceip', $_SESSION[$sessionluser][$i]['sourceip']);
				$luser->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
				$luser->set_data('resourceid', $_SESSION[$sessionluser][$i]['resourceid']);
				$luser->set_data('forbidden_commands_groups', $_SESSION[$sessionluser][$i]['forbidden_commands_groups']);
				$luser->set_data('smsalert', $_SESSION[$sessionluser][$i]['smsalert']);
				$luser->set_data('workflow', $_SESSION[$sessionluser][$i]['workflow']);
				$luser->set_data('wf_user1', $_SESSION[$sessionluser][$i]['wf_user1']);
				$luser->set_data('wf_user2', $_SESSION[$sessionluser][$i]['wf_user2']);
				$luser->set_data('wf_user3', $_SESSION[$sessionluser][$i]['wf_user3']);
				$luser->set_data('wf_user4', $_SESSION[$sessionluser][$i]['wf_user4']);
				$luser->set_data('wf_user5', $_SESSION[$sessionluser][$i]['wf_user5']);
				$this->restrictpolicy_set->delete_all("memberid='".$_SESSION[$sessionluser][$i]['memberid']."' and resourceid='".$_SESSION[$sessionluser][$i]['resourceid']."'");
				if($_SESSION[$sessionluser][$i]['restrictacl']){
					$restrictpolicy = new restrictpolicy();
					$restrictpolicy->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
					$restrictpolicy->set_data('resourceid', $_SESSION[$sessionluser][$i]['resourceid']);
					$restrictpolicy->set_data('aclid', $_SESSION[$sessionluser][$i]['restrictacl']);
					$this->restrictpolicy_set->add($restrictpolicy);
				}

				if($_SESSION[$sessionluser][$i]['id']){
					$luser->set_data('id', $_SESSION[$sessionluser][$i]['id']);
					$this->luser_resourcegrp_set->edit($luser);
				}else{
					$this->luser_resourcegrp_set->add($luser);
				}
				$user[] = $_SESSION[$sessionluser][$i]['memberid'];

				$this->update_userpriority_cache($_SESSION[$sessionluser][$i]['memberid']);
			}
		}
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if(in_array($_SESSION[$sessionlgroup][$i]['groupid'], $newgroup)){
				$lgroup = new lgroup_resourcegrp();
				$lgroup->set_data('syslogalert', $_SESSION[$sessionlgroup][$i]['syslogalert']);
				$lgroup->set_data('mailalert', $_SESSION[$sessionlgroup][$i]['mailalert']);
				$lgroup->set_data('autosu', $_SESSION[$sessionlgroup][$i]['autosu']);
				$lgroup->set_data('loginlock', $_SESSION[$sessionlgroup][$i]['loginlock']);
				$lgroup->set_data('rdpclipauth_up', $_SESSION[$sessionlgroup][$i]['rdpclipauth_up']);
				$lgroup->set_data('rdpdiskauth_up', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_up']);
				$lgroup->set_data('rdpclipauth_down', $_SESSION[$sessionlgroup][$i]['rdpclipauth_down']);
				$lgroup->set_data('rdpdiskauth_down', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_down']);
				$lgroup->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
				$lgroup->set_data('twoauth', $_SESSION[$sessionlgroup][$i]['twoauth']);
				$lgroup->set_data('sourceip', $_SESSION[$sessionlgroup][$i]['sourceip']);
				$lgroup->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
				$lgroup->set_data('resourceid',$_SESSION[$sessionlgroup][$i]['resourceid']);
				$lgroup->set_data('forbidden_commands_groups', $_SESSION[$sessionlgroup][$i]['forbidden_commands_groups']);
				$lgroup->set_data('smsalert', $_SESSION[$sessionlgroup][$i]['smsalert']);
				$lgroup->set_data('workflow', $_SESSION[$sessionlgroup][$i]['workflow']);
				$lgroup->set_data('wf_user1', $_SESSION[$sessionlgroup][$i]['wf_user1']);
				$lgroup->set_data('wf_user2', $_SESSION[$sessionlgroup][$i]['wf_user2']);
				$lgroup->set_data('wf_user3', $_SESSION[$sessionlgroup][$i]['wf_user3']);
				$lgroup->set_data('wf_user4', $_SESSION[$sessionlgroup][$i]['wf_user4']);
				$lgroup->set_data('wf_user5', $_SESSION[$sessionlgroup][$i]['wf_user5']);
				$this->restrictpolicy_set->delete_all("usergroupid='".$_SESSION[$sessionlgroup][$i]['groupid']."' and resourceid='".$_SESSION[$sessionlgroup][$i]['resourceid']."'");
				if($_SESSION[$sessionlgroup][$i]['restrictacl']){
					$restrictpolicy = new restrictpolicy();
					$restrictpolicy->set_data('usergroupid', $_SESSION[$sessionlgroup][$i]['groupid']);
					$restrictpolicy->set_data('resourceid', $_SESSION[$sessionlgroup][$i]['resourceid']);
					$restrictpolicy->set_data('aclid', $_SESSION[$sessionlgroup][$i]['restrictacl']);
					$this->restrictpolicy_set->add($restrictpolicy);
				}
				
				if($_SESSION[$sessionlgroup][$i]['id']){
					$lgroup->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
					$this->lgroup_resourcegrp_set->edit($lgroup);
				}else{
					$this->lgroup_resourcegrp_set->add($lgroup);
				}
				$group[] = $_SESSION[$sessionlgroup][$i]['groupid'];

				$tmpusers = $this->member_set->select_all("groupid='".$_SESSION[$sessionlgroup][$i]['groupid']."'");
				for($ti=0; $ti<count($tmpusers); $ti++){
					$this->update_userpriority_cache($tmpusers[$ti]['uid']);
				}
			}
		}
		if($newuser)
		$u = array_diff($newuser, $user);
		if($newgroup)
		$g = array_diff($newgroup, $group);
		
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		
		if($u)
		foreach($u AS $key => $value){
			$luser = new luser_resourcegrp();
			$luser->set_data('syslogalert', $dp['syslogalert']);
			$luser->set_data('mailalert', $dp['mailalert']);
			$luser->set_data('autosu', $dp['autosu']);
			$luser->set_data('loginlock', $dp['loginlock']);
			$luser->set_data('weektime', $dp['weektime']);
			$luser->set_data('sourceip', $dp['sourceip']);
			$luser->set_data('rdpclipauth_up', $dp['rdpclipauth_up']);
			$luser->set_data('rdpdiskauth_up', $dp['rdpdiskauth_up']);	
			$luser->set_data('rdpclipauth_down', $dp['rdpclipauth_down']);
			$luser->set_data('rdpdiskauth_down', $dp['rdpdiskauth_down']);	
			$luser->set_data('memberid', $value);
			$luser->set_data('resourceid', $sid);
			$this->luser_resourcegrp_set->add($luser);
			$this->update_userpriority_cache($value);
		}
		if($g)
		foreach($g AS $key => $value){
			$lgroup = new lgroup_resourcegrp();
			$lgroup->set_data('syslogalert', $dp['syslogalert']);
			$lgroup->set_data('mailalert', $dp['mailalert']);
			$lgroup->set_data('autosu', $dp['autosu']);
			$lgroup->set_data('loginlock', $dp['loginlock']);
			$lgroup->set_data('weektime', $dp['weektime']);
			$lgroup->set_data('sourceip', $dp['sourceip']);
			$lgroup->set_data('rdpclipauth_up', $dp['rdpclipauth_up']);
			$lgroup->set_data('rdpdiskauth_up', $dp['rdpdiskauth_up']);	
			$lgroup->set_data('rdpclipauth_down', $dp['rdpclipauth_down']);
			$lgroup->set_data('rdpdiskauth_down', $dp['rdpdiskauth_down']);	
			$lgroup->set_data('groupid', $value);
			$lgroup->set_data('resourceid', $sid);
			$this->lgroup_resourcegrp_set->add($lgroup);
			$tmpusers = $this->member_set->select_all("groupid='".$value."'");
			for($ti=0; $ti<count($tmpusers); $ti++){
				$this->update_userpriority_cache($tmpusers[$ti]['uid']);
			}
		}

		unset($_SESSION[$sessionluser]);
		unset($_SESSION[$sessionlgroup]);
	} 

	function servergroup_seluser(){
		$sid = get_request('sid');
		$uid = get_request('uid');
		$sessionluser= get_request('sessionluser', 0, 1);
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
				if($_SESSION[$sessionluser][$i]['memberid']==$uid&&$_SESSION[$sessionluser][$i]['serversid']==$sid){
					$luser[0] = $_SESSION[$sessionluser][$i];	
					break;
				}
			}
		if(empty($luser)){
			$luser = $this->luser_devgrp_set->select_all('memberid='.$uid.' AND serversid='.$sid);
		}
		if(empty($luser)){
			$luser = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1', 'gname','asc');
		$this->assign('title', language('设置'));
		$this->assign("luser", $luser[0]);
		$this->assign("weektime", $weektime);
		$this->assign("allforbiddengroup", $allforbiddengroup);
		$this->assign("sourceip", $sourceip);
		$this->assign("uid", $uid);
		$this->assign("sid", $sid);
		$this->assign('sessionluser', $sessionluser);
		$this->display('servergroup_seluser.tpl');
	}
	
	function servergroup_seluser_save(){
		$sid = get_request('sid', 1, 0);
		$uid = get_request('uid', 1, 0);
		$id = get_request('id', 1, 0);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$forbidden_commands_groups = get_request('forbidden_commands_groups', 1, 1);
		$sessionluser = get_request('sessionluser', 1, 1);

		if($id)
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if($_SESSION[$sessionluser][$i]['id']==$id){
				$_SESSION[$sessionluser][$i]['weektime'] = $weektime;
				$_SESSION[$sessionluser][$i]['sourceip'] = $sourceip;
				$_SESSION[$sessionluser][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
				
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
				if($_SESSION[$sessionluser][$i]['memberid']==$uid&&$_SESSION[$sessionluser][$i]['serversid']==$sid){
					$_SESSION[$sessionluser][$i]['weektime'] = $weektime;
					$_SESSION[$sessionluser][$i]['sourceip'] = $sourceip;
					$_SESSION[$sessionluser][$i]['memberid'] = $uid;
					$_SESSION[$sessionluser][$i]['serversid'] = $sid;
					$_SESSION[$sessionluser][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
					
					$found = 1;
				}
			}
			if($found==0){
				$len = count($_SESSION[$sessionluser]);
				$_SESSION[$sessionluser][$len]['memberid'] = $uid;
				$_SESSION[$sessionluser][$len]['serversid'] = $sid;
				$_SESSION[$sessionluser][$len]['weektime'] = $weektime;
				$_SESSION[$sessionluser][$len]['sourceip'] = $sourceip;
				$_SESSION[$sessionluser][$len]['forbidden_commands_groups'] = $forbidden_commands_groups;
				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionluser]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}
	
	function servergroup_selgroup(){
		$sid = get_request('sid');
		$gid = get_request('gid');
		$sessionlgroup= get_request('sessionlgroup', 0, 1);
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['serversid']==$sid){
					$lgroup[0] = $_SESSION[$sessionlgroup][$i];	
					break;
				}
			}
		if(empty($lgroup)){
			$lgroup = $this->lgroup_devgrp_set->select_all('groupid='.$gid.' AND serversid='.$sid);
		}
		if(empty($lgroup)){
			$lgroup = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1', 'gname','asc');
		$this->assign('title', language('设置'));
		$this->assign("lgroup", $lgroup[0]);
		$this->assign("weektime", $weektime);
		$this->assign("sourceip", $sourceip);
		$this->assign("allforbiddengroup", $allforbiddengroup);
		$this->assign("gid", $gid);
		$this->assign("sid", $sid);		
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->display('servergroup_selgroup.tpl');
	}
	
	function servergroup_selgroup_save(){
		$sid = get_request('sid', 1, 0);
		$gid = get_request('gid', 1, 0);
		$id = get_request('id', 1, 0);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		$forbidden_commands_groups = get_request('forbidden_commands_groups', 1, 1);
		
		if($id)
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if($_SESSION[$sessionlgroup][$i]['id']==$id){
				$_SESSION[$sessionlgroup][$i]['weektime'] = $weektime;
				$_SESSION[$sessionlgroup][$i]['sourceip'] = $sourceip;
				$_SESSION[$sessionlgroup][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['serversid']==$sid){
					$_SESSION[$sessionlgroup][$i]['weektime'] = $weektime;
					$_SESSION[$sessionlgroup][$i]['sourceip'] = $sourceip;
					$_SESSION[$sessionlgroup][$i]['groupid'] = $gid;
					$_SESSION[$sessionlgroup][$i]['serversid'] = $sid;
					$_SESSION[$sessionlgroup][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
					
					$found = 1;
				}
			}
			if($found==0){
				$len = count($_SESSION[$sessionlgroup]);
				$_SESSION[$sessionlgroup][$len]['groupid'] = $gid;
				$_SESSION[$sessionlgroup][$len]['serversid'] = $sid;
				$_SESSION[$sessionlgroup][$len]['weektime'] = $weektime;
				$_SESSION[$sessionlgroup][$len]['sourceip'] = $sourceip;
				$_SESSION[$sessionlgroup][$len]['forbidden_commands_groups'] = $forbidden_commands_groups;
				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionlgroup]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}

	function devgroup_edit() {
		global $_CONFIG;
		$id = get_request("id",0,1);
		$ldapid = get_request("ldapid",0,1);
		$this->assign('title', language('添加节点'));
		$loadbalance = $this->loadbalance_set->select_all();	
		$thissgroup = $this->sgroup_set->select_by_id($id);
		$this->assign("sgroup", $sgroup);
		$groupid=$thissgroup['ldapid'];
		require_once('./include/select_sgroup_ajax.inc.php');		
		
		$msgroup = $this->sgroup_set->select_by_id($_SESSION['ADMIN_MSERVERGROUP']);
		$this->assign("msgroup", $msgroup);
		$this->assign("loadbalances", $loadbalance);
		$this->assign("sgroup", $thissgroup);
		$this->assign("ldapid", $ldapid);
		$this->assign("allsgroup", $allsgroup);
		$this->assign("_config", $_CONFIG);
		$this->display('devgroup_edit.tpl');
	}

	function dev_group_save($interface=false) {
		global $_CONFIG;
		$id = get_request("id",0,1);
		$new_name = get_request("groupname",1,1);
		$loadbalance = get_request('loadbalance',1,0);
		$description = get_request("description",1,1);
		$ldapid = get_request('ldapid');
		$levelx = get_request('levelx',1,0);
		$attribute = get_request('attribute',1,0);
		if(empty($new_name)){
			alert_and_back('请输入名称','admin.php?controller=admin_pro&action=dev_group');
			return;
		}
		
		$selectedldapid = $_POST['groupid'];
		if($selectedldapid&&$id){
			$selectedldap = $this->sgroup_set->select_by_id($id);
			if($selectedldap){
				$selected_child = explode(',', $selectedldap['child']);
				if($id==$selected_child|| is_array($selected_child)&&in_array($selectedldapid, $selected_child)){
					alert_and_back('不能移动到自己或自己子目录');
					//echo 'a';
					return;
				}
			}
		}
		if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			if(!in_array($selectedldapid,$_SESSION['ADMIN_MSERVERGROUP_IDS'])){
				alert_and_back('请选择有权限管理的目录');
				return;
			}
		}
		//exit;
		if($_POST['groupid']){
			$exists_count = $this->sgroup_set->select_by_id($_POST['groupid']);
			$exists_count = $this->sgroup_set->select_count("groupname = '$new_name' and id in(".$exists_count['child'].") and id!='$id'");
		}else{
			$exists_count = $this->sgroup_set->select_count("groupname = '$new_name' and id!='$id' and ldapid=0");
		}
		if(0==$exists_count) {
			$new_group = new sgroup();
			$new_group->set_data('groupname',$new_name);
			$new_group->set_data('attribute',$attribute);
			$new_group->set_data('loadbalance',$loadbalance);
			$new_group->set_data('description',$description);
			$new_group->set_data('level',$levelx);
			$new_group->set_data('ldapid',$selectedldapid);
			if($interface){
				$new_group->set_data('interface',1);
			}
			if($id){
				$old = $this->sgroup_set->select_by_id($id);
				if($attribute!=0&&$old['attribute']!=$attribute){
					if($old['attribute']==1&&$this->member_set->select_count("groupid=".$id)>0){
						alert_and_back('该目录下已有用户，请先将用户移出');
						return;
					}elseif($old['attribute']==2&&$this->server_set->select_count("groupid=".$id)>0){
						alert_and_back('该目录下已有设备，请先将设备移出');
						return;
					}elseif($old['attribute']==0){
						if($attribute==2&&$this->member_set->select_count("groupid=".$id)>0){
							alert_and_back('该目录下已有用户，请先将用户移出');
							return;
						}elseif($attribute==1&&$this->server_set->select_count("groupid=".$id)>0){
							alert_and_back('该目录下已有设备，请先将设备移出');
							return;
						}
					}
				}
				$new_group->set_data('id',$id);
				$this->sgroup_set->edit($new_group);
				if($selectedldapid!=$old['ldapid']){
					$this->sgroup_set->update($selectedldapid,$old);
					$this->sgroup_set->updates($selectedldapid,$old['ldapid'],$old['count']);
					$this->sgroup_set->updatem($selectedldapid,$old['ldapid'],$old['mcount']);
					if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
						$this->sgroupcache_set->update($selectedldapid,$old, $_SESSION['ADMIN_UID']);
						$this->sgroupcache_set->updates($selectedldapid,$old['ldapid'],$old['count']);
						$this->sgroupcache_set->updatem($selectedldapid,$old['ldapid'],$old['mcount']);
					}
					/*$_g['ldapid'] = $selectedldapid;
					while($_g['ldapid']){
						$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
						$_gg = $this->sgroup_set->select_all("ldapid=".$_g['id']);
						$_gp=$_g['id'].',';
						for($i=0; $i<count($_gg); $i++){
							$_gp.=$_gg[$i]['child'].',';
						}
						$this->member_set->query("UPDATE servergroup set child='".substr($_gp,0,strlen($_gp)-1)."' where id=".$_g['id']);
					}
					$_g = $old;
					while($_g['ldapid']){
						$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
						$_gg = $this->sgroup_set->select_all("ldapid=".$_g['id']);
						$_gp=$_g['id'].',';
						for($i=0; $i<count($_gg); $i++){
							$_gp.=$_gg[$i]['child'].',';
						}
						$this->member_set->query("UPDATE servergroup set child='".substr($_gp,0,strlen($_gp)-1)."' where id=".$_g['id']);
					}*/
				}
				
				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('编辑资源组'));
				$adminlog->set_data('lgroup', $new_name);
				$adminlog->set_data('type', 12);
				$this->admin_log_set->add($adminlog);
				alert_and_back('编辑成功','admin.php?controller=admin_index&actions=dev_group&ldapid='.$ldapid.'&back=1', 0, 1);
				//exit;
			}else{

				$this->sgroup_set->add($new_group);
				$id = mysql_insert_id();
				$new_group = new sgroup();
				$new_group->set_data('child',$id);
				$new_group->set_data('id',$id);
				$this->sgroup_set->edit($new_group);
				if($id){
					$this->sgroup_set->query("insert ignore into servergroup_cache(memberid, groupid, groupname, ldapid, count, mcount,child) select distinct ".$_SESSION['ADMIN_UID'].", id, groupname,ldapid, count,mcount,id from servergroup sg where id=".$id);
					$this->sgroup_set->update($selectedldapid,null);
					if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
						$this->sgroupcache_set->update($selectedldapid,null, $_SESSION['ADMIN_UID']);
					}
					/*
					$_g = $this->sgroup_set->select_by_id($id);
					while($_g['ldapid']){
						$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
						$_gg = $this->sgroup_set->select_all("ldapid=".$_g['id']);
						$_gp=$_g['id'].',';
						for($i=0; $i<count($_gg); $i++){
							$_gp.=$_gg[$i]['child'].',';
						}
						$this->member_set->query("UPDATE servergroup set child='".substr($_gp,0,strlen($_gp)-1)."' where id=".$_g['id']);
					}*/
				}
				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('添加资源组'));
				$adminlog->set_data('lgroup', $new_name);
				$adminlog->set_data('type', 12);
				$this->admin_log_set->add($adminlog);
				alert_and_back('添加成功','admin.php?controller=admin_index&actions=dev_group&ldapid='.$ldapid.'&back=1', 0, 1);
				return $id;
				//exit;
			}
			
		}
		else {
				alert_and_back('添加失败,该设备组已存在','admin.php?controller=admin_pro&action=dev_group'.'&back=1');
		}
	}

	function dev_group_del() {
		global $_CONFIG;
		$id = get_request('id');
		$from = get_request('from', 0, 1);
		$old_group = $this->sgroup_set->select_by_id($id);
		if(	 0 == $this->server_set->select_count("groupid IN(".($old_group['child'] ? $old_group['child'] : $old_group['id']).") ") && 0 == $this->member_set->select_count("groupid IN(".($old_group['child'] ? $old_group['child'] : $old_group['id']).") ") ) {
			$gid = $this->sgroup_set->select_all("id='$id' ".($_CONFIG['LDAP'] ? "or id IN(".($old_group['child'] ? $old_group['child'] : $old_group['id']).") " : ''));
			for($i=0; $i<count($gid); $i++){
				$groupinfo = $this->sgroup_set->select_by_id($gid[$i]['id']);
				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('删除资源组'));
				$adminlog->set_data('lgroup', $groupinfo['groupname']);
				$adminlog->set_data('type', 12);
				$this->admin_log_set->add($adminlog);
				$this->sgroup_set->delete($gid[$i]['id']);
				$this->sgroupcache_set->delete_all("groupid=".$gid[$i]['id']);

				$this->sgroup_set->update($groupinfo['ldapid'],null);
				if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
					$this->sgroupcache_set->update($groupinfo['ldapid'],null, $_SESSION['ADMIN_UID']);
				}
				/*
				$_g = $groupinfo;
				while($_g['ldapid']){
					$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
					$_gg = $this->sgroup_set->select_all("ldapid=".$_g['id']);
					$_gp=$_g['id'].',';
					for($ii=0; $ii<count($_gg); $ii++){
						$_gp.=$_gg[$ii]['child'].',';
					}
					$this->member_set->query("UPDATE servergroup set child='".substr($_gp,0,strlen($_gp)-1)."' where id=".$_g['id']);
				}*/
			}
			$this->server_set->delete_all("groupid='$id' or groupid IN(".($old_group['child'] ? $old_group['child'] : $old_group['id']).") ");
			$this->member_set->delete_all("groupid='$id' or groupid IN(".($old_group['child'] ? $old_group['child'] : $old_group['id']).") ");
			if($from=='usergroup'){
				alert_and_back('删除成功','admin.php?controller=admin_index&actions=usergroup', 0, 1);
			}else{
				alert_and_back('删除成功','admin.php?controller=admin_index&actions=dev_group', 0, 1);
			}
		}
		else {
			alert_and_back('删除失败,该组还有设备或用户','admin.php?controller=admin_pro&action=dev_group');
		}
	}

	function groupbatchadd(){
		global $_CONFIG;
		$groupidname="groupid";
		require_once('./include/select_sgroup_ajax.inc.php');
		$loadbalance = $this->loadbalance_set->select_all();
		$this->assign("loadbalances", $loadbalance);
		$this->display("groupbatchadd.tpl");
	}

	function groupbatchsave(){
		$error=array();
		for($i=0; $i<20; $i++){
			if(empty($_POST['groupname_'.$i])){
				break;
			}
			if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
				if(!in_array($_POST['groupid'.$i.'1'],$_SESSION['ADMIN_MSERVERGROUP_IDS'])){
					//alert_and_back('请选择有权限管理的目录');
					$error[]='组名"'.$_POST['groupname_'.$i].'",请选择有权限管理的目录';
					continue;
				}
			}
			if($_POST['groupid'.$i]){
				$exists_count = $this->sgroup_set->select_by_id($_POST['groupid'.$i]);
				$exists_count = $this->sgroup_set->select_count("groupname = '".$_POST['groupname_'.$i]."' and id in(".$exists_count['child'].") and id!='$id'");
			}else{
				$exists_count = $this->sgroup_set->select_count("groupname = '".$_POST['groupname_'.$i]."' and id!='0' and ldapid=0");
			}
			if($exists_count>0){				
				$error[]='组名"'.$_POST['groupname_'.$i].'"重复';
				continue;
			}
			$new_group = new sgroup();
			$new_group->set_data('groupname',$_POST['groupname_'.$i]);
			$new_group->set_data('loadbalance',$_POST['loadbalance_'.$i]);
			$new_group->set_data('description',$_POST['description_'.$i]);
			$new_group->set_data('ldapid',$_POST['groupid'.$i]);
			$this->sgroup_set->add($new_group);
			$id=mysql_insert_id();
			if($id>0){
				$new_group = new sgroup();
				$new_group->set_data("child", $id);
				$new_group->set_data("id", $id);
				$this->sgroup_set->edit($new_group);
				$this->sgroup_set->update($_POST['groupid'.$i], null);
				if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
					$this->sgroupcache_set->update($_POST['groupid'.$i], null);
				}
			}
		}
		$msg='操作成功';
		if($error){
			$msg = '\n添加失败的组:\n'.implode('\n',$error).'\n';
		}
		alert_and_back($msg, 'admin.php?controller=admin_pro&action=dev_group');
	}
	
	function dev_delfromgroup(){
		$id = get_request('id');
		$dev = $this->server_set->select_by_id($id);
		$server = new server();
		$server->set_data("id", $id);
		$server->set_data("groupid", 0);
		$this->server_set->edit($server);
		//$this->sgroup_set->remove_user($dev['groupid']);
		echo '<script language=\'javascript\'>window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$dev['groupid'].'";</script>';
			//exit;
		//alert_and_back('删除成功','admin.php?controller=admin_pro&action=dev_index&gid='.$dev['groupid']);
	}

	function pass_edit() {
		global $_CONFIG;
		$id = get_request('id');
		$ip = get_request('ip',0,1);
		$gid = get_request('gid',0,1);
		$groupid=$g_id = get_request('g_id',0,1);
		$webuser = get_request('webuser',0,1);
		$webgroup = get_request('webgroup',0,1);	
		$fromdevpriority = get_request('fromdevpriority');		
		$serverid = get_request('serverid');
		$accountlinux = get_request('accountlinux');
		$accountusername = get_request('user',0,1);
		$sessionluser = 'PASSEDIT_LUSER';
		$sessionlgroup = 'PASSEDIT_LGROUP';	
		require_once('./include/select_sgroup_ajax.inc.php');
		if($ori_g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_all("id IN(".(is_array($ori_g_id)?implode(',', $ori_g_id): $ori_g_id).")");
			$__tmpgid = $ori_g_id;
			for($i=0; $i<count($_tmpgid); $i++){
				$__tmpgid .= ','.$_tmpgid[$i]['child'];
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
				for($i=0; $i<count($allips); $i++){
					$cronreport_alltmpip[]=$allips[$i]['device_ip'];
				}
			}
			$wheremember = ' AND groupid IN('.$__tmpgid.')';
			$wheregroup = ' AND id IN('.$__tmpgid.')';
		}
		$this->assign('ip',$ip);
		$this->assign('serverid',$serverid);
		$where = "device_type = ''";
		//$allmem = $this->member_set->select_all('level = 0'.($_SESSION['ADMIN_LEVEL']==3 ? ' AND groupid=(SELECT musergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : ''),'username','ASC');
		
		$allradiusmem = $this->member_set->select_all("level=11".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''),'username','ASC');
		$where .= " AND login_method IN('ssh','RDP','telnet','ftp','ssh1','vnc','x11','rlogin','apppub')";
		$allmethod =  $this->tem_set->select_all($where,'','ASC');	
		
		$device = $this->server_set->select_all("id=$serverid");

		for($i=0; $i<count($allradiusmem); $i++){
			if($this->devpass_set->select_count("device_ip='".$device[0]['device_ip']."' and username='".$allradiusmem[$i]['username']."'")>0){
				$allradiusmem[$i]['check']='checked';
			}
		}
//echo '<pre>';print_r($_SESSION);echo '</pre>';
		$this->assign('allradiusmem',$allradiusmem);
		$this->assign('servergroup',$servergroup);
		$this->assign('gid',$gid);
		$this->assign('usergroup', $usergroup);
		$this->assign('title',language("修改"));
		$this->assign('sessionluser', $sessionluser);
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->assign('fromdevpriority', $fromdevpriority);
		$this->assign('webuser', $webuser);
		$this->assign('webgroup', $webgroup);
		$this->display('pass_edit.tpl');
	}

	function pass_save($interface=false) {
		global $_CONFIG;
		$id = get_request('id');
		$serverid = get_request('serverid');
		$fromdevpriority = get_request('fromdevpriority');
		$ip = get_request('ip',0,1);
		$gid = get_request('gid',0,1);
		
		
		$passcount = $this->member_set->select_count('1 = 1');
		$allmember = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)");
		$server = $this->server_set->select_by_id($serverid);
		$new_user = ',';
		$j = 0;
		for($i = 0;$i<$passcount;$i++) {
			if(0 != get_request("Check$i",1,0)) {
				$new_user .= get_request("Check$i",1,0).',';
				$new_userid[] = get_request("Check$i",1,0);
				$j++;
			}
		}
		if($j>20) {
			//alert_and_back(language('绑定的用户不能超过')."20");
			//exit(0);
		}
		for($i=0; $i<count($new_userid); $i++){
			$user = $this->member_set->select_by_id($new_userid[$i]);
			if($user&&$this->devpass_set->select_count("device_ip='".$ip."' and username='".$user['username']."'")==0){
				$new_pass = new devpass();
				$new_pass->set_data('device_ip',$ip);
				$new_pass->set_data('hostname',$server['hostname']);
				$new_pass->set_data('device_type',$server['device_type']);
				$new_pass->set_data('username',$user['username']);
				$this->devpass_set->add($new_pass);
				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('修改系统用户'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', empty($new_name) ? '空用户' : $new_name);
				$adminlog->set_data('type', 13);
				$this->admin_log_set->add($adminlog);
			}
			
		}	
		
		
		alert_and_back('修改成功',(get_request('from',0,1)!='passview' ? "admin.php?controller=admin_pro&action=devpass_index&ip=$ip&serverid=".$serverid."&gid=".$gid : 'admin.php?controller=admin_index&action=main'));
		return $id;
	}
	function pass_del() {
		$id = get_request('id');
		if(empty($id)){
			$id=$_POST['id'];
		}
		$this->devpass_set->delete($id);
		
				
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=dev_index');
	}
	private function luser_group_save($sessionluser, $sessionlgroup, $sid, $newuser, $alluser, $newgroup,$allgroup, $no=0){
		global $_CONFIG;
		$user[]=0;
		$group[]=0;
		$release[0]=0;		
		if(empty($newuser)){
			$newuser[0]=0;
			$release = $alluser;
		}else{
			$release = array_diff($alluser, $newuser);
		}
		
		if(!empty($release)){
			$usernames = $this->member_set->select_all(" uid IN (SELECT memberid FROM luser WHERE memberid IN (".implode(',', $release).") AND devicesid=$sid)");				
			
			for($i=0; $i<count($usernames); $i++){
				$adminlog = new admin_log();
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('luser', $usernames[$i]['username']);
				$adminlog->set_data('action', language('系统用户解绑运维用户'));
				$adminlog->set_data('resource', $_GET['ip']);
				$adminlog->set_data('resource_user', empty($new_name) ? '空用户' : $new_name);
				$adminlog->set_data('type', 5);
				$this->admin_log_set->add($adminlog);
				unset($adminlog);
				$oldmember = new member();
				$oldmember->set_data("cachechange", 1);
				$oldmember->set_data("uid", $usernames[$i]['uid']);
				$this->member_set->edit($oldmember);
			}
		}
		if(!empty($newuser)){
			$usernames = $this->member_set->select_all(" uid NOT IN (SELECT memberid FROM luser WHERE memberid IN (".implode(',', $newuser).") AND devicesid=$sid)AND uid IN(".implode(',', $newuser).")");
			for($i=0; $i<count($usernames); $i++){
				$adminlog = new admin_log();
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('luser', $usernames[$i]['username']);
				$adminlog->set_data('action', language('系统用户绑定运维用户'));
				$adminlog->set_data('resource', $_GET['ip']);
				$adminlog->set_data('resource_user', empty($new_name) ? '空用户' : $new_name);
				$adminlog->set_data('type', 5);
				$this->admin_log_set->add($adminlog);
				unset($adminlog);
				$oldmember = new member();
				$oldmember->set_data("cachechange", 1);
				$oldmember->set_data("uid", $usernames[$i]['uid']);
				$this->member_set->edit($oldmember);
			}
		}
		if(! empty($release))
		$this->luser_set->query("delete FROM ".$this->luser_set->get_table_name()." WHERE memberid IN(".implode(',',$release).") AND devicesid=$sid");
		
		$release[0]=0;		
		if(empty($newgroup)){
			$newgroup[0]=0;
			$release = $allgroup;
		}else{
			$release = array_diff($allgroup, $newgroup);
		}
		if(!empty($release)){
			$usernames = $this->usergroup_set->select_all(" id IN (SELECT groupid FROM lgroup WHERE groupid IN (".implode(',', $release).")AND devicesid=$sid)  ");	
			
			for($i=0; $i<count($usernames); $i++){
				$adminlog = new admin_log();
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('lgroup', $usernames[$i]['groupname']);
				$adminlog->set_data('action', language('系统用户解绑资源组'));
				$adminlog->set_data('resource', $_GET['ip']);
				$adminlog->set_data('resource_user', empty($new_name) ? '空用户' : $new_name);
				$adminlog->set_data('type', 6);
				$this->admin_log_set->add($adminlog);
				unset($adminlog);
				if(is_numeric($usernames[$i]['id']))
				$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid=".$usernames[$i]['id']);
			}
		}
		if(!empty($newgroup)){
			$usernames = $this->usergroup_set->select_all(" id NOT IN (SELECT groupid FROM lgroup WHERE groupid IN (".implode(',', $newgroup).")AND devicesid=$sid) AND id IN(".implode(',', $newgroup).")");
			for($i=0; $i<count($usernames); $i++){
				$adminlog = new admin_log();
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('lgroup', $usernames[$i]['groupname']);
				$adminlog->set_data('action', language('系统用户绑定资源组'));
				$adminlog->set_data('resource', $_GET['ip']);
				$adminlog->set_data('resource_user', empty($new_name) ? '空用户' : $new_name);
				$adminlog->set_data('type', 6);
				$this->admin_log_set->add($adminlog);
				unset($adminlog);
				if(is_numeric($usernames[$i]['id']))
					$this->usergroup_set->query("UPDATE member set cachechange=1 where groupid=".$usernames[$i]['id']);
			}
		}
		if(!empty($release))
		$this->lgroup_set->query("delete FROM ".$this->lgroup_set->get_table_name()." WHERE groupid IN(".implode(',',$release).") AND devicesid=$sid");

		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if(in_array($_SESSION[$sessionluser][$i]['memberid'], $newuser)){
				$luser = new luser();
				$luser->set_data('syslogalert', $_SESSION[$sessionluser][$i]['syslogalert']);
				$luser->set_data('mailalert', $_SESSION[$sessionluser][$i]['mailalert']);
				$luser->set_data('autosu', $_SESSION[$sessionluser][$i]['autosu']);
				$luser->set_data('loginlock', $_SESSION[$sessionluser][$i]['loginlock']);
				$luser->set_data('rdpdiskauth_up', $_SESSION[$sessionluser][$i]['rdpdiskauth_up']);
				$luser->set_data('rdpclipauth_up', $_SESSION[$sessionluser][$i]['rdpclipauth_up']);
				$luser->set_data('rdpdiskauth_down', $_SESSION[$sessionluser][$i]['rdpdiskauth_down']);
				$luser->set_data('rdpclipauth_down', $_SESSION[$sessionluser][$i]['rdpclipauth_down']);
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);
				$luser->set_data('sourceip', $_SESSION[$sessionluser][$i]['sourceip']);
				$luser->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
				$luser->set_data('twoauth', $_SESSION[$sessionluser][$i]['twoauth']);
				if($_SESSION[$sessionluser][$i]['sshkeyname']){
					$this->sshkey_set->delete_all("memberid='".$_SESSION[$sessionluser][$i]['memberid']."' and devicesid='$sid'");
					$newsshkey = new sshkey();
					$newsshkey->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
					$newsshkey->set_data('devicesid', $sid);
					$newsshkey->set_data('sshkeyname', $_SESSION[$sessionluser][$i]['sshkeyname']);
					$this->sshkey_set->add($newsshkey);

				}
				
				$this->restrictpolicy_set->delete_all("memberid='".$_SESSION[$sessionluser][$i]['memberid']."' and devicesid='$sid'");
				if($_SESSION[$sessionluser][$i]['restrictacl']){
					$restrictpolicy = new restrictpolicy();
					$restrictpolicy->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
					$restrictpolicy->set_data('devicesid', $sid);
					$restrictpolicy->set_data('aclid', $_SESSION[$sessionluser][$i]['restrictacl']);
					$this->restrictpolicy_set->add($restrictpolicy);
				}
				$luser->set_data('devicesid', $sid);
				$luser->set_data('forbidden_commands_groups', $_SESSION[$sessionluser][$i]['forbidden_commands_groups']);
				$luser->set_data('smsalert', $_SESSION[$sessionluser][$i]['smsalert']);
				$luser->set_data('workflow', $_SESSION[$sessionluser][$i]['workflow']);
				$luser->set_data('wf_user1', $_SESSION[$sessionluser][$i]['wf_user1']);
				$luser->set_data('wf_user2', $_SESSION[$sessionluser][$i]['wf_user2']);
				$luser->set_data('wf_user3', $_SESSION[$sessionluser][$i]['wf_user3']);
				$luser->set_data('wf_user4', $_SESSION[$sessionluser][$i]['wf_user4']);
				$luser->set_data('wf_user5', $_SESSION[$sessionluser][$i]['wf_user5']);

				$member = $this->member_set->select_by_id($_SESSION[$sessionluser][$i]['memberid']);
				$device = $this->devpass_set->select_by_id($sid);
				
				if($_SESSION[$sessionluser][$i]['id']){
					$luser->set_data('id', $_SESSION[$sessionluser][$i]['id']);
					$this->luser_set->edit($luser);
				}else{
					$this->luser_set->add($luser);
				}
				$user[] = $_SESSION[$sessionluser][$i]['memberid'];
				$this->update_userpriority_cache($_SESSION[$sessionluser][$i]['memberid']);
			}
		}
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if(in_array($_SESSION[$sessionlgroup][$i]['groupid'], $newgroup)){
				$lgroup = new lgroup();
				$lgroup->set_data('syslogalert', $_SESSION[$sessionlgroup][$i]['syslogalert']);
				$lgroup->set_data('mailalert', $_SESSION[$sessionlgroup][$i]['mailalert']);
				$lgroup->set_data('autosu', $_SESSION[$sessionlgroup][$i]['autosu']);
				$lgroup->set_data('loginlock', $_SESSION[$sessionlgroup][$i]['loginlock']);
				$lgroup->set_data('rdpdiskauth_up', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_up']);
				$lgroup->set_data('rdpclipauth_up', $_SESSION[$sessionlgroup][$i]['rdpclipauth_up']);
				$lgroup->set_data('rdpdiskauth_down', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_down']);
				$lgroup->set_data('rdpclipauth_down', $_SESSION[$sessionlgroup][$i]['rdpclipauth_down']);
				$lgroup->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
				$lgroup->set_data('sourceip', $_SESSION[$sessionlgroup][$i]['sourceip']);
				$lgroup->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
				$lgroup->set_data('twoauth', $_SESSION[$sessionlgroup][$i]['twoauth']);
				$lgroup->set_data('smsalert', $_SESSION[$sessionlgroup][$i]['smsalert']);
				$lgroup->set_data('workflow', $_SESSION[$sessionlgroup][$i]['workflow']);
				$lgroup->set_data('wf_user1', $_SESSION[$sessionlgroup][$i]['wf_user1']);
				$lgroup->set_data('wf_user2', $_SESSION[$sessionlgroup][$i]['wf_user2']);
				$lgroup->set_data('wf_user3', $_SESSION[$sessionlgroup][$i]['wf_user3']);
				$lgroup->set_data('wf_user4', $_SESSION[$sessionlgroup][$i]['wf_user4']);
				$lgroup->set_data('wf_user5', $_SESSION[$sessionlgroup][$i]['wf_user5']);
				$lgroup->set_data('devicesid', $sid);	
				$lgroup->set_data('forbidden_commands_groups', $_SESSION[$sessionlgroup][$i]['forbidden_commands_groups']);		

				$this->restrictpolicy_set->delete_all("usergroupid='".$_SESSION[$sessionlgroup][$i]['groupid']."' and devicesid='$sid'");
				if($_SESSION[$sessionlgroup][$i]['restrictacl']){
					$restrictpolicy = new restrictpolicy();
					$restrictpolicy->set_data('usergroupid', $_SESSION[$sessionlgroup][$i]['groupid']);
					$restrictpolicy->set_data('devicesid', $sid);
					$restrictpolicy->set_data('aclid', $_SESSION[$sessionlgroup][$i]['restrictacl']);
					$this->restrictpolicy_set->add($restrictpolicy);
				}
				
				if($_SESSION[$sessionlgroup][$i]['id']){
					$lgroup->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
					$this->lgroup_set->edit($lgroup);
				}else{
					$this->lgroup_set->add($lgroup);
				}
				$group[] = $_SESSION[$sessionlgroup][$i]['groupid'];
				$tmpusers = $this->member_set->select_all("groupid='".$_SESSION[$sessionlgroup][$i]['groupid']."'");
				for($ti=0; $ti<count($tmpusers); $ti++){
					$this->update_userpriority_cache($tmpusers[$ti]['uid']);
				}
			}
		}
		if($newuser)
		$u = array_diff($newuser, $user);
		if($newgroup)
		$g = array_diff($newgroup, $group);
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		if($u)
		foreach($u AS $key => $value){
			$luser = new luser();
			$luser->set_data('syslogalert', $dp['syslogalert']);
			$luser->set_data('mailalert', $dp['mailalert']);
			$luser->set_data('autosu', $dp['autosu']);
			$luser->set_data('loginlock', $dp['loginlock']);
			$luser->set_data('weektime', $dp['weektime']);
			$luser->set_data('sourceip', $dp['sourceip']);
			$luser->set_data('rdpclipauth_up', $dp['rdpclipauth_up']);
			$luser->set_data('rdpdiskauth_up', $dp['rdpdiskauth_up']);	
			$luser->set_data('rdpclipauth_down', $dp['rdpclipauth_down']);
			$luser->set_data('rdpdiskauth_down', $dp['rdpdiskauth_down']);	
			$luser->set_data('memberid', $value);
			$luser->set_data('devicesid', $sid);
			$member = $this->member_set->select_by_id($value);
			$device = $this->devpass_set->select_by_id($sid);
			
			$this->luser_set->add($luser);
			$this->update_userpriority_cache($value);
		}
		
		if($g)
		foreach($g AS $key => $value){
			$lgroup = new lgroup();
			$lgroup->set_data('syslogalert', $dp['syslogalert']);
			$lgroup->set_data('mailalert', $dp['mailalert']);
			$lgroup->set_data('autosu', $dp['autosu']);
			$lgroup->set_data('loginlock', $dp['loginlock']);
			$lgroup->set_data('weektime', $dp['weektime']);
			$lgroup->set_data('sourceip', $dp['sourceip']);
			$lgroup->set_data('rdpclipauth_up', $dp['rdpclipauth_up']);
			$lgroup->set_data('rdpdiskauth_up', $dp['rdpdiskauth_up']);	
			$lgroup->set_data('rdpclipauth_down', $dp['rdpclipauth_down']);
			$lgroup->set_data('rdpdiskauth_down', $dp['rdpdiskauth_down']);	
			$lgroup->set_data('groupid', $value);
			$lgroup->set_data('devicesid', $sid);
			$this->lgroup_set->add($lgroup);
			$tmpusers = $this->member_set->select_all("groupid='".$value."'");
			for($ti=0; $ti<count($tmpusers); $ti++){
				$this->update_userpriority_cache($tmpusers[$ti]['uid']);
			}
		}
		if($no==0){
			unset($_SESSION[$sessionluser]);
			unset($_SESSION[$sessionlgroup]);
		}

	} 


	
	function passedit_seluser(){
		$sid = get_request('sid');
		$uid = get_request('uid');
		$sessionluser= get_request('sessionluser', 0, 1);
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if($_SESSION[$sessionluser][$i]['memberid']==$uid&&$_SESSION[$sessionluser][$i]['devicesid']==$sid){
				$luser[0] = $_SESSION[$sessionluser][$i];
				$bindedsshkey[0]=array('sshkeyname'=>$_SESSION[$sessionluser][$i]['sshkeyname']);
				break;
			}
		}
		if(empty($luser)){
			$luser = $this->luser_set->select_all('memberid='.$uid.' AND devicesid='.$sid);
			$bindedsshkey = $this->sshkey_set->select_all("memberid='$uid' AND devicesid='$sid'");
			$aclpolicy = $this->restrictpolicy_set->select_all("memberid=$uid AND devicesid=$sid");
			if($aclpolicy){
				$luser[0]['restrictacl']=$aclpolicy[0]['aclid'];
			}
		}
		if(empty($luser)){
			$luser = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$sshkeynames = $this->sshkeyname_set->select_all("1", "sshkeyname", "asc");

		$weektime = $this->weektime_set->select_all(($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : '1'));
		$sourceip = $this->sourceip_set->select_all(" sourceip=''".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''));
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''), 'gname','asc');		
		$webusers = $this->member_set->select_all('1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'username', 'asc');
		
		$acl = $this->restrictacl_set->select_all('1=1', 'aclname', 'ASC');
		$this->assign('acl', $acl);
		$this->assign('title', language('设置'));
		$this->assign("luser", $luser[0]);
		$this->assign("weektime", $weektime);
		$this->assign("webusers", $webusers);
		$this->assign("allforbiddengroup", $allforbiddengroup);
		$this->assign("sourceip", $sourceip);
		$this->assign("uid", $uid);
		$this->assign("sid", $sid);
		$this->assign('sessionluser', $sessionluser);
		$this->assign('sshkeynames', $sshkeynames);
		$this->assign('bindedsshkey', $bindedsshkey[0]);
		$this->display('passedit_seluser.tpl');
	}


	function passedit_seluser_save(){
		global $_CONFIG;
		$sid = get_request('sid', 1, 0);
		$uid = get_request('uid', 1, 0);
		$id = get_request('id', 1, 0);
		$twoauth = get_request('twoauth', 1, 1);
		$autosu = get_request('autosu', 1, 1);
		$rdpclipauth_up = get_request('rdpclipauth_up', 1, 1);
		$rdpdiskauth_up = get_request('rdpdiskauth_up', 1, 1);
		$rdpclipauth_down = get_request('rdpclipauth_down', 1, 1);
		$rdpdiskauth_down = get_request('rdpdiskauth_down', 1, 1);
		$sshkeyname = get_request('sshkeyname', 1, 1);
		$syslogalert = get_request('syslogalert', 1, 1);
		$mailalert = get_request('mailalert', 1, 1);
		$loginlock = get_request('loginlock', 1, 1);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$sessionluser = get_request('sessionluser', 1, 1);
		$forbidden_commands_groups = get_request('forbidden_commands_groups', 1, 1);
		$smsalert = get_request('smsalert', 1, 1);
		$workflow = get_request('workflow', 1, 1);
		$wf_user1 = get_request('wf_user1', 1, 0);
		$wf_user2 = get_request('wf_user2', 1, 0);
		$wf_user3 = get_request('wf_user3', 1, 0);
		$wf_user4 = get_request('wf_user4', 1, 0);
		$wf_user5 = get_request('wf_user5', 1, 0);
		$restrictacl = get_request('restrictacl', 1, 0);
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
		if($workflow == 'on') {
			$workflow = 1;
		}
		else {
			$workflow = 0;
		}
		if($smsalert == 'on') {
			$smsalert = 1;
		}
		else {
			$smsalert = 0;
		}
		if($twoauth == 'on') {
			$twoauth = 1;
		}
		else {
			$twoauth = 0;
		}

		$member = $this->member_set->select_by_id($uid);
		$device = $this->devpass_set->select_by_id($sid);
		if($id)
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if($_SESSION[$sessionluser][$i]['id']==$id){
				$_SESSION[$sessionluser][$i]['autosu'] = $autosu;
				$_SESSION[$sessionluser][$i]['syslogalert'] = $syslogalert;
				$_SESSION[$sessionluser][$i]['mailalert'] = $mailalert;
				$_SESSION[$sessionluser][$i]['loginlock'] = $loginlock;
				$_SESSION[$sessionluser][$i]['rdpclipauth_up'] = $rdpclipauth_up;
				$_SESSION[$sessionluser][$i]['rdpdiskauth_up'] = $rdpdiskauth_up;
				$_SESSION[$sessionluser][$i]['rdpclipauth_down'] = $rdpclipauth_down;
				$_SESSION[$sessionluser][$i]['rdpdiskauth_down'] = $rdpdiskauth_down;
				$_SESSION[$sessionluser][$i]['twoauth'] = $twoauth;
				$_SESSION[$sessionluser][$i]['weektime'] = $weektime;
				$_SESSION[$sessionluser][$i]['sourceip'] = $sourceip;
				$_SESSION[$sessionluser][$i]['sshprivatekey'] = $sshprivatekey;
				$_SESSION[$sessionluser][$i]['sshkeyname'] = $sshkeyname;
				$_SESSION[$sessionluser][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
				$_SESSION[$sessionluser][$i]['smsalert'] = $smsalert;
				$_SESSION[$sessionluser][$i]['restrictacl'] = $restrictacl;
				$_SESSION[$sessionluser][$i]['workflow'] = $workflow;
				$_SESSION[$sessionluser][$i]['wf_user1'] = $wf_user1;
				$_SESSION[$sessionluser][$i]['wf_user2'] = $wf_user2;
				$_SESSION[$sessionluser][$i]['wf_user3'] = $wf_user3;
				$_SESSION[$sessionluser][$i]['wf_user4'] = $wf_user4;
				$_SESSION[$sessionluser][$i]['wf_user5'] = $wf_user5;
				$luser = new luser();
				$luser->set_data('syslogalert', $_SESSION[$sessionluser][$i]['syslogalert']);
				$luser->set_data('mailalert', $_SESSION[$sessionluser][$i]['mailalert']);
				$luser->set_data('autosu', $_SESSION[$sessionluser][$i]['autosu']);
				$luser->set_data('loginlock', $_SESSION[$sessionluser][$i]['loginlock']);
				$luser->set_data('rdpdiskauth_up', $_SESSION[$sessionluser][$i]['rdpdiskauth_up']);
				$luser->set_data('rdpclipauth_up', $_SESSION[$sessionluser][$i]['rdpclipauth_up']);
				$luser->set_data('rdpdiskauth_down', $_SESSION[$sessionluser][$i]['rdpdiskauth_down']);
				$luser->set_data('rdpclipauth_down', $_SESSION[$sessionluser][$i]['rdpclipauth_down']);
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);
				$luser->set_data('sourceip', $_SESSION[$sessionluser][$i]['sourceip']);
				$luser->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
				$luser->set_data('twoauth', $_SESSION[$sessionluser][$i]['twoauth']);
				if($_SESSION[$sessionluser][$i]['sshkeyname']){
					$this->sshkey_set->delete_all("memberid='".$_SESSION[$sessionluser][$i]['memberid']."' and devicesid='$sid'");
					$newsshkey = new sshkey();
					$newsshkey->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
					$newsshkey->set_data('devicesid', $sid);
					$newsshkey->set_data('sshkeyname', $_SESSION[$sessionluser][$i]['sshkeyname']);
					$this->sshkey_set->add($newsshkey);

				}
				$this->restrictpolicy_set->delete_all("memberid='".$_SESSION[$sessionluser][$i]['memberid']."' and devicesid='$sid'");
				if($_SESSION[$sessionluser][$i]['restrictacl']){
					$restrictpolicy = new restrictpolicy();
					$restrictpolicy->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
					$restrictpolicy->set_data('devicesid', $sid);
					$restrictpolicy->set_data('aclid', $_SESSION[$sessionluser][$i]['restrictacl']);
					$this->restrictpolicy_set->add($restrictpolicy);
				}
				$luser->set_data('forbidden_commands_groups', $_SESSION[$sessionluser][$i]['forbidden_commands_groups']);
				$luser->set_data('smsalert', $_SESSION[$sessionluser][$i]['smsalert']);
				$luser->set_data('workflow', $_SESSION[$sessionluser][$i]['workflow']);
				$luser->set_data('wf_user1', $_SESSION[$sessionluser][$i]['wf_user1']);
				$luser->set_data('wf_user2', $_SESSION[$sessionluser][$i]['wf_user2']);
				$luser->set_data('wf_user3', $_SESSION[$sessionluser][$i]['wf_user3']);
				$luser->set_data('wf_user4', $_SESSION[$sessionluser][$i]['wf_user4']);
				$luser->set_data('wf_user5', $_SESSION[$sessionluser][$i]['wf_user5']);
				$luser->set_data('id', $id);
				$this->luser_set->edit($luser);
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
				if($_SESSION[$sessionluser][$i]['memberid']==$uid&&$_SESSION[$sessionluser][$i]['devicesid']==$sid){
					$_SESSION[$sessionluser][$i]['autosu'] = $autosu;
					$_SESSION[$sessionluser][$i]['syslogalert'] = $syslogalert;
					$_SESSION[$sessionluser][$i]['mailalert'] = $mailalert;
					$_SESSION[$sessionluser][$i]['loginlock'] = $loginlock;
					$_SESSION[$sessionluser][$i]['rdpclipauth_up'] = $rdpclipauth_up;
					$_SESSION[$sessionluser][$i]['rdpdiskauth_up'] = $rdpdiskauth_up;
					$_SESSION[$sessionluser][$i]['rdpclipauth_down'] = $rdpclipauth_down;
					$_SESSION[$sessionluser][$i]['rdpdiskauth_down'] = $rdpdiskauth_down;
					$_SESSION[$sessionluser][$i]['twoauth'] = $twoauth;
					$_SESSION[$sessionluser][$i]['weektime'] = $weektime;
					$_SESSION[$sessionluser][$i]['sourceip'] = $sourceip;
					$_SESSION[$sessionluser][$i]['memberid'] = $uid;
					$_SESSION[$sessionluser][$i]['devicesid'] = $sid;
					$_SESSION[$sessionluser][$i]['sshprivatekey'] = $sshprivatekey;
					$_SESSION[$sessionluser][$i]['sshkeyname'] = $sshkeyname;
					$_SESSION[$sessionluser][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
					$_SESSION[$sessionluser][$i]['smsalert'] = $smsalert;
					$_SESSION[$sessionluser][$i]['restrictacl'] = $restrictacl;
					$_SESSION[$sessionluser][$i]['workflow'] = $workflow;
					$_SESSION[$sessionluser][$i]['wf_user1'] = $wf_user1;
					$_SESSION[$sessionluser][$i]['wf_user2'] = $wf_user2;
					$_SESSION[$sessionluser][$i]['wf_user3'] = $wf_user3;
					$_SESSION[$sessionluser][$i]['wf_user4'] = $wf_user4;
					$_SESSION[$sessionluser][$i]['wf_user5'] = $wf_user5;
					
					
					$found = 1;
				}
			}
			if($found==0){
				$len = count($_SESSION[$sessionluser]);
				$_SESSION[$sessionluser][$len]['memberid'] = $uid;
				$_SESSION[$sessionluser][$len]['devicesid'] = $sid;
				$_SESSION[$sessionluser][$len]['autosu'] = $autosu;
				$_SESSION[$sessionluser][$len]['syslogalert'] = $syslogalert;
				$_SESSION[$sessionluser][$len]['mailalert'] = $mailalert;
				$_SESSION[$sessionluser][$len]['loginlock'] = $loginlock;
				$_SESSION[$sessionluser][$len]['rdpclipauth_up'] = $rdpclipauth_up;
				$_SESSION[$sessionluser][$len]['rdpdiskauth_up'] = $rdpdiskauth_up;
				$_SESSION[$sessionluser][$len]['rdpclipauth_down'] = $rdpclipauth_down;
				$_SESSION[$sessionluser][$len]['rdpdiskauth_down'] = $rdpdiskauth_down;
				$_SESSION[$sessionluser][$len]['twoauth'] = $twoauth;
				$_SESSION[$sessionluser][$len]['weektime'] = $weektime;
				$_SESSION[$sessionluser][$len]['sourceip'] = $sourceip;
				$_SESSION[$sessionluser][$len]['sshprivatekey'] = $sshprivatekey;
				$_SESSION[$sessionluser][$len]['sshkeyname'] = $sshkeyname;
				$_SESSION[$sessionluser][$len]['forbidden_commands_groups'] = $forbidden_commands_groups;
				$_SESSION[$sessionluser][$len]['smsalert'] = $smsalert;
				$_SESSION[$sessionluser][$len]['restrictacl'] = $restrictacl;
				$_SESSION[$sessionluser][$len]['workflow'] = $workflow;
				$_SESSION[$sessionluser][$len]['wf_user1'] = $wf_user1;
				$_SESSION[$sessionluser][$len]['wf_user2'] = $wf_user2;
				$_SESSION[$sessionluser][$len]['wf_user3'] = $wf_user3;
				$_SESSION[$sessionluser][$len]['wf_user4'] = $wf_user4;
				$_SESSION[$sessionluser][$len]['wf_user5'] = $wf_user5;
				
			}
		}
		//var_dump($_POST);
		//echo '<pre>';var_dump($_SESSION[$sessionluser]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}

	function resourcegrp_seluser(){
		$sid = get_request('sid');
		$uid = get_request('uid');
		$sessionluser= get_request('sessionluser', 0, 1);
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if($_SESSION[$sessionluser][$i]['memberid']==$uid&&$_SESSION[$sessionluser][$i]['resourceid']==$sid){
				$luser[0] = $_SESSION[$sessionluser][$i];	
				break;
			}
		}
		if(empty($luser)){
			$luser = $this->luser_resourcegrp_set->select_all('memberid='.$uid.' AND resourceid='.$sid);
			$aclpolicy = $this->restrictpolicy_set->select_all("memberid=$uid AND resourceid=$sid");
			if($aclpolicy){
				$luser[0]['restrictacl']=$aclpolicy[0]['aclid'];
			}
		}
		if(empty($luser)){
			$luser = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all(($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : '1'));
		$sourceip = $this->sourceip_set->select_all(" sourceip=''".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''));
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''), 'gname','asc');		
		$webusers = $this->member_set->select_all('1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND groupid  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'username', 'asc');
		$acl = $this->restrictacl_set->select_all('1=1', 'aclname', 'ASC');
		$this->assign('acl', $acl);
		$this->assign('title', language('设置'));
		$this->assign("luser", $luser[0]);
		$this->assign("weektime", $weektime);
		$this->assign("allforbiddengroup", $allforbiddengroup);
		$this->assign("sourceip", $sourceip);
		$this->assign("uid", $uid);
		$this->assign("sid", $sid);
		$this->assign("webusers", $webusers);
		$this->assign('sessionluser', $sessionluser);
		$this->display('resourcegrp_seluser.tpl');
	}
	

	function resourcegrp_seluser_save(){
		$sid = get_request('sid', 1, 0);
		$uid = get_request('uid', 1, 0);
		$twoauth = get_request('twoauth', 1, 1);
		$id = get_request('id', 1, 0);
		$autosu = get_request('autosu', 1, 1);
		$syslogalert = get_request('syslogalert', 1, 1);
		$mailalert = get_request('mailalert', 1, 1);
		$loginlock = get_request('loginlock', 1, 1);
		$rdpclipauth_up = get_request('rdpclipauth_up', 1, 1);
		$rdpdiskauth_up = get_request('rdpdiskauth_up', 1, 1);
		$rdpclipauth_down = get_request('rdpclipauth_down', 1, 1);
		$rdpdiskauth_down = get_request('rdpdiskauth_down', 1, 1);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$forbidden_commands_groups = get_request('forbidden_commands_groups', 1, 1);
		$sessionluser = get_request('sessionluser', 1, 1);
		$smsalert = get_request('smsalert', 1, 1);
		$workflow = get_request('workflow', 1, 1);
		$wf_user1 = get_request('wf_user1', 1, 0);
		$wf_user2 = get_request('wf_user2', 1, 0);
		$wf_user3 = get_request('wf_user3', 1, 0);
		$wf_user4 = get_request('wf_user4', 1, 0);
		$wf_user5 = get_request('wf_user5', 1, 0);
		$restrictacl = get_request('restrictacl', 1, 0);

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
		if($workflow == 'on') {
			$workflow = 1;
		}
		else {
			$workflow = 0;
		}
		if($smsalert == 'on') {
			$smsalert = 1;
		}
		else {
			$smsalert = 0;
		}
		if($twoauth == 'on') {
			$twoauth = 1;
		}
		else {
			$twoauth = 0;
		}

		if($id)
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if($_SESSION[$sessionluser][$i]['id']==$id){
				$_SESSION[$sessionluser][$i]['autosu'] = $autosu;
				$_SESSION[$sessionluser][$i]['syslogalert'] = $syslogalert;
				$_SESSION[$sessionluser][$i]['mailalert'] = $mailalert;
				$_SESSION[$sessionluser][$i]['loginlock'] = $loginlock;
				$_SESSION[$sessionluser][$i]['rdpclipauth_up'] = $rdpclipauth_up;
				$_SESSION[$sessionluser][$i]['rdpdiskauth_up'] = $rdpdiskauth_up;
				$_SESSION[$sessionluser][$i]['rdpclipauth_down'] = $rdpclipauth_down;
				$_SESSION[$sessionluser][$i]['rdpdiskauth_down'] = $rdpdiskauth_down;
				$_SESSION[$sessionluser][$i]['weektime'] = $weektime;
				$_SESSION[$sessionluser][$i]['twoauth'] = $twoauth;
				$_SESSION[$sessionluser][$i]['sourceip'] = $sourceip;
				$_SESSION[$sessionluser][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
				$_SESSION[$sessionluser][$i]['smsalert'] = $smsalert;
				$_SESSION[$sessionluser][$i]['workflow'] = $workflow;
				$_SESSION[$sessionluser][$i]['wf_user1'] = $wf_user1;
				$_SESSION[$sessionluser][$i]['wf_user2'] = $wf_user2;
				$_SESSION[$sessionluser][$i]['wf_user3'] = $wf_user3;
				$_SESSION[$sessionluser][$i]['wf_user4'] = $wf_user4;
				$_SESSION[$sessionluser][$i]['wf_user5'] = $wf_user5;
				$_SESSION[$sessionluser][$i]['restrictacl'] = $restrictacl;
				
				$luser = new luser_resourcegrp();
				$luser->set_data('syslogalert', $_SESSION[$sessionluser][$i]['syslogalert']);
				$luser->set_data('mailalert', $_SESSION[$sessionluser][$i]['mailalert']);
				$luser->set_data('autosu', $_SESSION[$sessionluser][$i]['autosu']);
				$luser->set_data('loginlock', $_SESSION[$sessionluser][$i]['loginlock']);
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);
				$luser->set_data('twoauth', $_SESSION[$sessionluser][$i]['twoauth']);
				$luser->set_data('rdpclipauth_up', $_SESSION[$sessionluser][$i]['rdpclipauth_up']);
				$luser->set_data('rdpdiskauth_up', $_SESSION[$sessionluser][$i]['rdpdiskauth_up']);
				$luser->set_data('rdpclipauth_down', $_SESSION[$sessionluser][$i]['rdpclipauth_down']);
				$luser->set_data('rdpdiskauth_down', $_SESSION[$sessionluser][$i]['rdpdiskauth_down']);
				$luser->set_data('sourceip', $_SESSION[$sessionluser][$i]['sourceip']);
				$luser->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
				$luser->set_data('resourceid', $_SESSION[$sessionluser][$i]['resourceid']);
				$luser->set_data('forbidden_commands_groups', $_SESSION[$sessionluser][$i]['forbidden_commands_groups']);
				$luser->set_data('smsalert', $_SESSION[$sessionluser][$i]['smsalert']);
				$luser->set_data('workflow', $_SESSION[$sessionluser][$i]['workflow']);
				$luser->set_data('wf_user1', $_SESSION[$sessionluser][$i]['wf_user1']);
				$luser->set_data('wf_user2', $_SESSION[$sessionluser][$i]['wf_user2']);
				$luser->set_data('wf_user3', $_SESSION[$sessionluser][$i]['wf_user3']);
				$luser->set_data('wf_user4', $_SESSION[$sessionluser][$i]['wf_user4']);
				$luser->set_data('wf_user5', $_SESSION[$sessionluser][$i]['wf_user5']);
				$this->restrictpolicy_set->delete_all("memberid='".$_SESSION[$sessionluser][$i]['memberid']."' and resourceid='".$_SESSION[$sessionluser][$i]['resourceid']."'");
				if($_SESSION[$sessionluser][$i]['restrictacl']){
					$restrictpolicy = new restrictpolicy();
					$restrictpolicy->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
					$restrictpolicy->set_data('resourceid', $_SESSION[$sessionluser][$i]['resourceid']);
					$restrictpolicy->set_data('aclid', $_SESSION[$sessionluser][$i]['restrictacl']);
					$this->restrictpolicy_set->add($restrictpolicy);
				}
				$luser->set_data('id', $_SESSION[$sessionluser][$i]['id']);
				$this->luser_resourcegrp_set->edit($luser);
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
				if($_SESSION[$sessionluser][$i]['memberid']==$uid&&$_SESSION[$sessionluser][$i]['resourceid']==$sid){
					$_SESSION[$sessionluser][$i]['autosu'] = $autosu;
					$_SESSION[$sessionluser][$i]['syslogalert'] = $syslogalert;
					$_SESSION[$sessionluser][$i]['mailalert'] = $mailalert;
					$_SESSION[$sessionluser][$i]['loginlock'] = $loginlock;
					$_SESSION[$sessionluser][$i]['rdpclipauth_up'] = $rdpclipauth_up;
					$_SESSION[$sessionluser][$i]['rdpdiskauth_up'] = $rdpdiskauth_up;
					$_SESSION[$sessionluser][$i]['rdpclipauth_down'] = $rdpclipauth_down;
					$_SESSION[$sessionluser][$i]['rdpdiskauth_down'] = $rdpdiskauth_down;
					$_SESSION[$sessionluser][$i]['weektime'] = $weektime;
					$_SESSION[$sessionluser][$i]['twoauth'] = $twoauth;
					$_SESSION[$sessionluser][$i]['sourceip'] = $sourceip;
					$_SESSION[$sessionluser][$i]['memberid'] = $uid;
					$_SESSION[$sessionluser][$i]['devicesid'] = $sid;
					$_SESSION[$sessionluser][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
					$_SESSION[$sessionluser][$i]['smsalert'] = $smsalert;
					$_SESSION[$sessionluser][$i]['workflow'] = $workflow;
					$_SESSION[$sessionluser][$i]['wf_user1'] = $wf_user1;
					$_SESSION[$sessionluser][$i]['wf_user2'] = $wf_user2;
					$_SESSION[$sessionluser][$i]['wf_user3'] = $wf_user3;
					$_SESSION[$sessionluser][$i]['wf_user4'] = $wf_user4;
					$_SESSION[$sessionluser][$i]['wf_user5'] = $wf_user5;
					$_SESSION[$sessionluser][$i]['restrictacl'] = $restrictacl;
					
					$found = 1;
				}
			}
			if($found==0){
				$len = count($_SESSION[$sessionluser]);
				$_SESSION[$sessionluser][$len]['memberid'] = $uid;
				$_SESSION[$sessionluser][$len]['resourceid'] = $sid;
				$_SESSION[$sessionluser][$len]['autosu'] = $autosu;
				$_SESSION[$sessionluser][$len]['syslogalert'] = $syslogalert;
				$_SESSION[$sessionluser][$len]['mailalert'] = $mailalert;
				$_SESSION[$sessionluser][$len]['loginlock'] = $loginlock;
				$_SESSION[$sessionluser][$len]['rdpclipauth_up'] = $rdpclipauth_up;
				$_SESSION[$sessionluser][$len]['rdpdiskauth_up'] = $rdpdiskauth_up;
				$_SESSION[$sessionluser][$len]['rdpclipauth_down'] = $rdpclipauth_down;
				$_SESSION[$sessionluser][$len]['rdpdiskauth_down'] = $rdpdiskauth_down;
				$_SESSION[$sessionluser][$len]['weektime'] = $weektime;
				$_SESSION[$sessionluser][$len]['twoauth'] = $twoauth;
				$_SESSION[$sessionluser][$len]['sourceip'] = $sourceip;
				$_SESSION[$sessionluser][$len]['forbidden_commands_groups'] = $forbidden_commands_groups;
				$_SESSION[$sessionluser][$len]['smsalert'] = $smsalert;
				$_SESSION[$sessionluser][$len]['workflow'] = $workflow;
				$_SESSION[$sessionluser][$len]['wf_user1'] = $wf_user1;
				$_SESSION[$sessionluser][$len]['wf_user2'] = $wf_user2;
				$_SESSION[$sessionluser][$len]['wf_user3'] = $wf_user3;
				$_SESSION[$sessionluser][$len]['wf_user4'] = $wf_user4;
				$_SESSION[$sessionluser][$len]['wf_user5'] = $wf_user5;
				$_SESSION[$sessionluser][$len]['restrictacl'] = $restrictacl;
				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionluser]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}
	
	function passedit_selgroup(){
		$sid = get_request('sid');
		$gid = get_request('gid');
		$sessionlgroup= get_request('sessionlgroup', 0, 1);
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['devicesid']==$sid){
					$lgroup[0] = $_SESSION[$sessionlgroup][$i];	
					break;
				}
			}
		if(empty($lgroup)){
			$lgroup = $this->lgroup_set->select_all('groupid='.$gid.' AND devicesid='.$sid);			
			$aclpolicy = $this->restrictpolicy_set->select_all("usergroupid=$gid AND devicesid=$sid");
			if($aclpolicy){
				$lgroup[0]['restrictacl']=$aclpolicy[0]['aclid'];
			}
		}
		if(empty($lgroup)){
			$lgroup = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}

		$weektime = $this->weektime_set->select_all(($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : '1'));
		$sourceip = $this->sourceip_set->select_all(" sourceip=''".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''));
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''), 'gname','asc');		
		$webusers = $this->member_set->select_all('1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'username', 'asc');
		
		$acl = $this->restrictacl_set->select_all('1=1', 'aclname', 'ASC');
		$this->assign('acl', $acl);
		$this->assign('title', language('设置'));
		$this->assign("lgroup", $lgroup[0]);
		$this->assign("weektime", $weektime);
		$this->assign("webusers", $webusers);
		$this->assign("sourceip", $sourceip);
		$this->assign("allforbiddengroup", $allforbiddengroup);
		$this->assign("gid", $gid);
		$this->assign("sid", $sid);		
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->display('passedit_selgroup.tpl');
	}

	function resourcegrp_selgroup(){
		$sid = get_request('sid');
		$gid = get_request('gid');
		$sessionlgroup= get_request('sessionlgroup', 0, 1);
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['resourceid']==$sid){
					$lgroup[0] = $_SESSION[$sessionlgroup][$i];	
					break;
				}
			}
		if(empty($lgroup)){
			$lgroup = $this->lgroup_resourcegrp_set->select_all('groupid='.$gid.' AND resourceid='.$sid);		
			$aclpolicy = $this->restrictpolicy_set->select_all("usergroupid=$gid AND resourceid=$sid");
			if($aclpolicy){
				$lgroup[0]['restrictacl']=$aclpolicy[0]['aclid'];
			}
		}
		if(empty($lgroup)){
			$lgroup = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all(($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : '1'));
		$sourceip = $this->sourceip_set->select_all(" sourceip=''".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''));
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''), 'gname','asc');		
		$webusers = $this->member_set->select_all('1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'username', 'asc');
		$acl = $this->restrictacl_set->select_all('1=1', 'aclname', 'ASC');
		$this->assign('acl', $acl);

		$this->assign('title', language('设置'));
		$this->assign("lgroup", $lgroup[0]);
		$this->assign("weektime", $weektime);
		$this->assign("sourceip", $sourceip);
		$this->assign("allforbiddengroup", $allforbiddengroup);
		$this->assign("gid", $gid);
		$this->assign("sid", $sid);		
		$this->assign("webusers", $webusers);		
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->display('resourcegrp_selgroup.tpl');
	}

	function passedit_selgroup_save(){
		$sid = get_request('sid', 1, 0);
		$gid = get_request('gid', 1, 0);
		$twoauth = get_request('twoauth', 1, 1);
		$id = get_request('id', 1, 0);
		$autosu = get_request('autosu', 1, 1);
		$syslogalert = get_request('syslogalert', 1, 1);
		$mailalert = get_request('mailalert', 1, 1);
		$loginlock = get_request('loginlock', 1, 1);
		$rdpclipauth_up = get_request('rdpclipauth_up', 1, 1);
		$rdpdiskauth_up = get_request('rdpdiskauth_up', 1, 1);
		$rdpclipauth_down = get_request('rdpclipauth_down', 1, 1);
		$rdpdiskauth_down = get_request('rdpdiskauth_down', 1, 1);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		$forbidden_commands_groups = get_request('forbidden_commands_groups', 1, 1);
		$smsalert = get_request('smsalert', 1, 1);
		$workflow = get_request('workflow', 1, 1);
		$wf_user1 = get_request('wf_user1', 1, 0);
		$wf_user2 = get_request('wf_user2', 1, 0);
		$wf_user3 = get_request('wf_user3', 1, 0);
		$wf_user4 = get_request('wf_user4', 1, 0);
		$wf_user5 = get_request('wf_user5', 1, 0);
		$restrictacl = get_request('restrictacl', 1, 0);
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
		if($workflow == 'on') {
			$workflow = 1;
		}
		else {
			$workflow = 0;
		}
		if($smsalert == 'on') {
			$smsalert = 1;
		}
		else {
			$smsalert = 0;
		}
		if($twoauth == 'on') {
			$twoauth = 1;
		}
		else {
			$twoauth = 0;
		}
		if($id)
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if($_SESSION[$sessionlgroup][$i]['id']==$id){
				$_SESSION[$sessionlgroup][$i]['autosu'] = $autosu;
				$_SESSION[$sessionlgroup][$i]['syslogalert'] = $syslogalert;
				$_SESSION[$sessionlgroup][$i]['mailalert'] = $mailalert;
				$_SESSION[$sessionlgroup][$i]['loginlock'] = $loginlock;
				$_SESSION[$sessionlgroup][$i]['rdpclipauth_up'] = $rdpclipauth_up;
				$_SESSION[$sessionlgroup][$i]['rdpdiskauth_up'] = $rdpdiskauth_up;
				$_SESSION[$sessionlgroup][$i]['rdpclipauth_down'] = $rdpclipauth_down;
				$_SESSION[$sessionlgroup][$i]['rdpdiskauth_down'] = $rdpdiskauth_down;
				$_SESSION[$sessionlgroup][$i]['weektime'] = $weektime;
				$_SESSION[$sessionlgroup][$i]['sourceip'] = $sourceip;
				$_SESSION[$sessionlgroup][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
				$_SESSION[$sessionlgroup][$i]['twoauth'] = $twoauth;
				$_SESSION[$sessionlgroup][$i]['smsalert'] = $smsalert;
				$_SESSION[$sessionlgroup][$i]['workflow'] = $workflow;
				$_SESSION[$sessionlgroup][$i]['wf_user1'] = $wf_user1;
				$_SESSION[$sessionlgroup][$i]['wf_user2'] = $wf_user2;
				$_SESSION[$sessionlgroup][$i]['wf_user3'] = $wf_user3;
				$_SESSION[$sessionlgroup][$i]['wf_user4'] = $wf_user4;
				$_SESSION[$sessionlgroup][$i]['wf_user5'] = $wf_user5;
				$_SESSION[$sessionlgroup][$i]['restrictacl'] = $restrictacl;

				$lgroup = new lgroup();
				$lgroup->set_data('syslogalert', $_SESSION[$sessionlgroup][$i]['syslogalert']);
				$lgroup->set_data('mailalert', $_SESSION[$sessionlgroup][$i]['mailalert']);
				$lgroup->set_data('autosu', $_SESSION[$sessionlgroup][$i]['autosu']);
				$lgroup->set_data('loginlock', $_SESSION[$sessionlgroup][$i]['loginlock']);
				$lgroup->set_data('rdpdiskauth_up', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_up']);
				$lgroup->set_data('rdpclipauth_up', $_SESSION[$sessionlgroup][$i]['rdpclipauth_up']);
				$lgroup->set_data('rdpdiskauth_down', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_down']);
				$lgroup->set_data('rdpclipauth_down', $_SESSION[$sessionlgroup][$i]['rdpclipauth_down']);
				$lgroup->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
				$lgroup->set_data('sourceip', $_SESSION[$sessionlgroup][$i]['sourceip']);
				$lgroup->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
				$lgroup->set_data('twoauth', $_SESSION[$sessionlgroup][$i]['twoauth']);
				$lgroup->set_data('smsalert', $_SESSION[$sessionlgroup][$i]['smsalert']);
				$lgroup->set_data('workflow', $_SESSION[$sessionlgroup][$i]['workflow']);
				$lgroup->set_data('wf_user1', $_SESSION[$sessionlgroup][$i]['wf_user1']);
				$lgroup->set_data('wf_user2', $_SESSION[$sessionlgroup][$i]['wf_user2']);
				$lgroup->set_data('wf_user3', $_SESSION[$sessionlgroup][$i]['wf_user3']);
				$lgroup->set_data('wf_user4', $_SESSION[$sessionlgroup][$i]['wf_user4']);
				$lgroup->set_data('wf_user5', $_SESSION[$sessionlgroup][$i]['wf_user5']);
				$lgroup->set_data('forbidden_commands_groups', $_SESSION[$sessionlgroup][$i]['forbidden_commands_groups']);
				$lgroup->set_data('id', $id);	
				$this->restrictpolicy_set->delete_all("usergroupid='".$_SESSION[$sessionlgroup][$i]['groupid']."' and devicesid='$sid'");
				if($_SESSION[$sessionlgroup][$i]['restrictacl']){
					$restrictpolicy = new restrictpolicy();
					$restrictpolicy->set_data('usergroupid', $_SESSION[$sessionlgroup][$i]['groupid']);
					$restrictpolicy->set_data('devicesid', $sid);
					$restrictpolicy->set_data('aclid', $_SESSION[$sessionlgroup][$i]['restrictacl']);
					$this->restrictpolicy_set->add($restrictpolicy);
				}
				$this->lgroup_set->edit($lgroup);
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['devicesid']==$sid){
					$_SESSION[$sessionlgroup][$i]['autosu'] = $autosu;
					$_SESSION[$sessionlgroup][$i]['syslogalert'] = $syslogalert;
					$_SESSION[$sessionlgroup][$i]['mailalert'] = $mailalert;
					$_SESSION[$sessionlgroup][$i]['loginlock'] = $loginlock;
					$_SESSION[$sessionlgroup][$i]['rdpclipauth_up'] = $rdpclipauth_up;
					$_SESSION[$sessionlgroup][$i]['rdpdiskauth_up'] = $rdpdiskauth_up;
					$_SESSION[$sessionlgroup][$i]['rdpclipauth_down'] = $rdpclipauth_down;
					$_SESSION[$sessionlgroup][$i]['rdpdiskauth_down'] = $rdpdiskauth_down;
					$_SESSION[$sessionlgroup][$i]['weektime'] = $weektime;
					$_SESSION[$sessionlgroup][$i]['sourceip'] = $sourceip;
					$_SESSION[$sessionlgroup][$i]['groupid'] = $gid;
					$_SESSION[$sessionlgroup][$i]['devicesid'] = $sid;
					$_SESSION[$sessionlgroup][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
					$_SESSION[$sessionlgroup][$i]['twoauth'] = $twoauth;
					$_SESSION[$sessionlgroup][$i]['smsalert'] = $smsalert;
					$_SESSION[$sessionlgroup][$i]['workflow'] = $workflow;
					$_SESSION[$sessionlgroup][$i]['wf_user1'] = $wf_user1;
					$_SESSION[$sessionlgroup][$i]['wf_user2'] = $wf_user2;
					$_SESSION[$sessionlgroup][$i]['wf_user3'] = $wf_user3;
					$_SESSION[$sessionlgroup][$i]['wf_user4'] = $wf_user4;
					$_SESSION[$sessionlgroup][$i]['wf_user5'] = $wf_user5;
					$_SESSION[$sessionlgroup][$i]['restrictacl'] = $restrictacl;
					
					$found = 1;
				}
			}
			if($found==0){
				$len = count($_SESSION[$sessionlgroup]);
				$_SESSION[$sessionlgroup][$len]['groupid'] = $gid;
				$_SESSION[$sessionlgroup][$len]['devicesid'] = $sid;
				$_SESSION[$sessionlgroup][$len]['autosu'] = $autosu;
				$_SESSION[$sessionlgroup][$len]['syslogalert'] = $syslogalert;
				$_SESSION[$sessionlgroup][$len]['mailalert'] = $mailalert;
				$_SESSION[$sessionlgroup][$len]['loginlock'] = $loginlock;
				$_SESSION[$sessionlgroup][$len]['rdpclipauth_up'] = $rdpclipauth_up;
				$_SESSION[$sessionlgroup][$len]['rdpdiskauth_up'] = $rdpdiskauth_up;
				$_SESSION[$sessionlgroup][$len]['rdpclipauth_down'] = $rdpclipauth_down;
				$_SESSION[$sessionlgroup][$len]['rdpdiskauth_down'] = $rdpdiskauth_down;
				$_SESSION[$sessionlgroup][$len]['weektime'] = $weektime;
				$_SESSION[$sessionlgroup][$len]['sourceip'] = $sourceip;
				$_SESSION[$sessionlgroup][$len]['forbidden_commands_groups'] = $forbidden_commands_groups;
				$_SESSION[$sessionlgroup][$len]['twoauth'] = $twoauth;
				$_SESSION[$sessionlgroup][$len]['smsalert'] = $smsalert;
				$_SESSION[$sessionlgroup][$len]['workflow'] = $workflow;
				$_SESSION[$sessionlgroup][$len]['wf_user1'] = $wf_user1;
				$_SESSION[$sessionlgroup][$len]['wf_user2'] = $wf_user2;
				$_SESSION[$sessionlgroup][$len]['wf_user3'] = $wf_user3;
				$_SESSION[$sessionlgroup][$len]['wf_user4'] = $wf_user4;
				$_SESSION[$sessionlgroup][$len]['wf_user5'] = $wf_user5;
				$_SESSION[$sessionlgroup][$len]['restrictacl'] = $restrictacl;
				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionlgroup]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}	

	function resourcegrp_selgroup_save(){
		$sid = get_request('sid', 1, 0);
		$gid = get_request('gid', 1, 0);
		$twoauth = get_request('twoauth', 1, 1);
		$id = get_request('id', 1, 0);
		$autosu = get_request('autosu', 1, 1);
		$syslogalert = get_request('syslogalert', 1, 1);
		$mailalert = get_request('mailalert', 1, 1);
		$loginlock = get_request('loginlock', 1, 1);
		$rdpclipauth_up = get_request('rdpclipauth_up', 1, 1);
		$rdpdiskauth_up = get_request('rdpdiskauth_up', 1, 1);
		$rdpclipauth_down = get_request('rdpclipauth_down', 1, 1);
		$rdpdiskauth_down = get_request('rdpdiskauth_down', 1, 1);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		$forbidden_commands_groups = get_request('forbidden_commands_groups', 1, 1);
		$smsalert = get_request('smsalert', 1, 1);
		$workflow = get_request('workflow', 1, 1);
		$wf_user1 = get_request('wf_user1', 1, 0);
		$wf_user2 = get_request('wf_user2', 1, 0);
		$wf_user3 = get_request('wf_user3', 1, 0);
		$wf_user4 = get_request('wf_user4', 1, 0);
		$wf_user5 = get_request('wf_user5', 1, 0);
		$restrictacl = get_request('restrictacl', 1, 0);

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
		if($workflow == 'on') {
			$workflow = 1;
		}
		else {
			$workflow = 0;
		}
		if($smsalert == 'on') {
			$smsalert = 1;
		}
		else {
			$smsalert = 0;
		}
		if($twoauth == 'on') {
			$twoauth = 1;
		}
		else {
			$twoauth = 0;
		}

		if($id)
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if($_SESSION[$sessionlgroup][$i]['id']==$id){
				$_SESSION[$sessionlgroup][$i]['autosu'] = $autosu;
				$_SESSION[$sessionlgroup][$i]['syslogalert'] = $syslogalert;
				$_SESSION[$sessionlgroup][$i]['mailalert'] = $mailalert;
				$_SESSION[$sessionlgroup][$i]['loginlock'] = $loginlock;
				$_SESSION[$sessionlgroup][$i]['rdpclipauth_up'] = $rdpclipauth_up;
				$_SESSION[$sessionlgroup][$i]['rdpdiskauth_up'] = $rdpdiskauth_up;
				$_SESSION[$sessionlgroup][$i]['rdpclipauth_down'] = $rdpclipauth_down;
				$_SESSION[$sessionlgroup][$i]['rdpdiskauth_down'] = $rdpdiskauth_down;
				$_SESSION[$sessionlgroup][$i]['weektime'] = $weektime;
				$_SESSION[$sessionlgroup][$i]['twoauth'] = $twoauth;
				$_SESSION[$sessionlgroup][$i]['sourceip'] = $sourceip;
				$_SESSION[$sessionlgroup][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
				$_SESSION[$sessionlgroup][$i]['smsalert'] = $smsalert;
				$_SESSION[$sessionlgroup][$i]['workflow'] = $workflow;
				$_SESSION[$sessionlgroup][$i]['wf_user1'] = $wf_user1;
				$_SESSION[$sessionlgroup][$i]['wf_user2'] = $wf_user2;
				$_SESSION[$sessionlgroup][$i]['wf_user3'] = $wf_user3;
				$_SESSION[$sessionlgroup][$i]['wf_user4'] = $wf_user4;
				$_SESSION[$sessionlgroup][$i]['wf_user5'] = $wf_user5;
				$_SESSION[$sessionlgroup][$i]['restrictacl'] = $restrictacl;

				$lgroup = new lgroup_resourcegrp();
				$lgroup->set_data('syslogalert', $_SESSION[$sessionlgroup][$i]['syslogalert']);
				$lgroup->set_data('mailalert', $_SESSION[$sessionlgroup][$i]['mailalert']);
				$lgroup->set_data('autosu', $_SESSION[$sessionlgroup][$i]['autosu']);
				$lgroup->set_data('loginlock', $_SESSION[$sessionlgroup][$i]['loginlock']);
				$lgroup->set_data('rdpclipauth_up', $_SESSION[$sessionlgroup][$i]['rdpclipauth_up']);
				$lgroup->set_data('rdpdiskauth_up', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_up']);
				$lgroup->set_data('rdpclipauth_down', $_SESSION[$sessionlgroup][$i]['rdpclipauth_down']);
				$lgroup->set_data('rdpdiskauth_down', $_SESSION[$sessionlgroup][$i]['rdpdiskauth_down']);
				$lgroup->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
				$lgroup->set_data('twoauth', $_SESSION[$sessionlgroup][$i]['twoauth']);
				$lgroup->set_data('sourceip', $_SESSION[$sessionlgroup][$i]['sourceip']);
				$lgroup->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
				$lgroup->set_data('resourceid',$_SESSION[$sessionlgroup][$i]['resourceid']);
				$lgroup->set_data('forbidden_commands_groups', $_SESSION[$sessionlgroup][$i]['forbidden_commands_groups']);
				$lgroup->set_data('smsalert', $_SESSION[$sessionlgroup][$i]['smsalert']);
				$lgroup->set_data('workflow', $_SESSION[$sessionlgroup][$i]['workflow']);
				$lgroup->set_data('wf_user1', $_SESSION[$sessionlgroup][$i]['wf_user1']);
				$lgroup->set_data('wf_user2', $_SESSION[$sessionlgroup][$i]['wf_user2']);
				$lgroup->set_data('wf_user3', $_SESSION[$sessionlgroup][$i]['wf_user3']);
				$lgroup->set_data('wf_user4', $_SESSION[$sessionlgroup][$i]['wf_user4']);
				$lgroup->set_data('wf_user5', $_SESSION[$sessionlgroup][$i]['wf_user5']);
				$lgroup->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
				$this->restrictpolicy_set->delete_all("usergroupid='".$_SESSION[$sessionlgroup][$i]['groupid']."' and resourceid='$sid'");
				if($_SESSION[$sessionlgroup][$i]['restrictacl']){
					$restrictpolicy = new restrictpolicy();
					$restrictpolicy->set_data('usergroupid', $_SESSION[$sessionlgroup][$i]['groupid']);
					$restrictpolicy->set_data('resourceid', $sid);
					$restrictpolicy->set_data('aclid', $_SESSION[$sessionlgroup][$i]['restrictacl']);
					$this->restrictpolicy_set->add($restrictpolicy);
				}
				$this->lgroup_resourcegrp_set->edit($lgroup);
			}
		}
		else{
			$found = 0;
			for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['resourceid']==$sid){
					$_SESSION[$sessionlgroup][$i]['autosu'] = $autosu;
					$_SESSION[$sessionlgroup][$i]['syslogalert'] = $syslogalert;
					$_SESSION[$sessionlgroup][$i]['mailalert'] = $mailalert;
					$_SESSION[$sessionlgroup][$i]['loginlock'] = $loginlock;
					$_SESSION[$sessionlgroup][$i]['rdpclipauth_up'] = $rdpclipauth_up;
					$_SESSION[$sessionlgroup][$i]['rdpdiskauth_up'] = $rdpdiskauth_up;
					$_SESSION[$sessionlgroup][$i]['rdpclipauth_down'] = $rdpclipauth_down;
					$_SESSION[$sessionlgroup][$i]['rdpdiskauth_down'] = $rdpdiskauth_down;
					$_SESSION[$sessionlgroup][$i]['weektime'] = $weektime;
					$_SESSION[$sessionlgroup][$i]['twoauth'] = $twoauth;
					$_SESSION[$sessionlgroup][$i]['sourceip'] = $sourceip;
					$_SESSION[$sessionlgroup][$i]['groupid'] = $gid;
					$_SESSION[$sessionlgroup][$i]['resourceid'] = $sid;
					$_SESSION[$sessionlgroup][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
					$_SESSION[$sessionlgroup][$i]['smsalert'] = $smsalert;
					$_SESSION[$sessionlgroup][$i]['workflow'] = $workflow;
					$_SESSION[$sessionlgroup][$i]['wf_user1'] = $wf_user1;
					$_SESSION[$sessionlgroup][$i]['wf_user2'] = $wf_user2;
					$_SESSION[$sessionlgroup][$i]['wf_user3'] = $wf_user3;
					$_SESSION[$sessionlgroup][$i]['wf_user4'] = $wf_user4;
					$_SESSION[$sessionlgroup][$i]['wf_user5'] = $wf_user5;
					$_SESSION[$sessionlgroup][$i]['restrictacl'] = $restrictacl;
					
					$found = 1;
				}
			}
			if($found==0){
				$len = count($_SESSION[$sessionlgroup]);
				$_SESSION[$sessionlgroup][$len]['groupid'] = $gid;
				$_SESSION[$sessionlgroup][$len]['resourceid'] = $sid;
				$_SESSION[$sessionlgroup][$len]['autosu'] = $autosu;
				$_SESSION[$sessionlgroup][$len]['syslogalert'] = $syslogalert;
				$_SESSION[$sessionlgroup][$len]['mailalert'] = $mailalert;
				$_SESSION[$sessionlgroup][$len]['loginlock'] = $loginlock;
				$_SESSION[$sessionlgroup][$len]['rdpclipauth_up'] = $rdpclipauth_up;
				$_SESSION[$sessionlgroup][$len]['rdpdiskauth_up'] = $rdpdiskauth_up;
				$_SESSION[$sessionlgroup][$len]['rdpclipauth_down'] = $rdpclipauth_down;
				$_SESSION[$sessionlgroup][$len]['rdpdiskauth_down'] = $rdpdiskauth_down;
				$_SESSION[$sessionlgroup][$len]['weektime'] = $weektime;
				$_SESSION[$sessionlgroup][$len]['twoauth'] = $twoauth;
				$_SESSION[$sessionlgroup][$len]['sourceip'] = $sourceip;
				$_SESSION[$sessionlgroup][$len]['forbidden_commands_groups'] = $forbidden_commands_groups;
				$_SESSION[$sessionlgroup][$len]['smsalert'] = $smsalert;
				$_SESSION[$sessionlgroup][$len]['workflow'] = $workflow;
				$_SESSION[$sessionlgroup][$len]['wf_user1'] = $wf_user1;
				$_SESSION[$sessionlgroup][$len]['wf_user2'] = $wf_user2;
				$_SESSION[$sessionlgroup][$len]['wf_user3'] = $wf_user3;
				$_SESSION[$sessionlgroup][$len]['wf_user4'] = $wf_user4;
				$_SESSION[$sessionlgroup][$len]['wf_user5'] = $wf_user5;
				$_SESSION[$sessionlgroup][$len]['restrictacl'] = $restrictacl;
				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionlgroup]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}


	
	function devpass_index($interface=false) { 
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$ip = get_request('ip',0,1);
		$gid = get_request('gid',0,1);
		$serverid = get_request('serverid');
		$name = get_request('name',0,1);
		$derive = get_request('derive',0,1);
		

		$where = '1=1';
		$server = $this->server_set->select_by_id($serverid);
		$ip = $server['device_ip'];
		$hostname = $server['hostname'];
		if($ip == '') {
			$ip = get_request('ip',1,1);
			if($ip != '') {
				$where .= " and device_ip LIKE '%$ip%'";
			}elseif(get_request('ip',0,1)!=""){
				$where .= " and device_ip LIKE '%".get_request('ip',0,1)."%'";
			}
		}
		else {
			$where .= " and device_ip='$ip'";
		}
		if($derive==1){
			$this->derive_pass($where);
			exit;
		}elseif($derive==3){
			$this->export_pass($where);
			exit;
		}
		$row_num = $this->devpass_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->devpass_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where);
		$alltem = $this->tem_set->select_all();
		for($i=0;$i<$row_num;$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}elseif($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
			}
			if($alldev[$i]['radiususer']){
				$alldev[$i]['radiususer_is_in_member'] = $this->member_set->select_count("username='".$alldev[$i]['username']."'");
			}
			if($interface) {
				$alldev[$i]['cur_password']='';
				$alldev[$i]['old_password']='';
				$alldev[$i]['new_password']='';
			}
		}
		if($interface){
			return $alldev;
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		$this->assign('curr_url', $curr_url);
		$this->assign('ip',$ip);
		$this->assign('gid', $gid);
		$this->assign('serverid', $serverid);
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('devpass_index.tpl');
	}

	function accountlinux_index() { 
		$page_num = get_request('page');
		$ip = get_request('ip',0,1);
		$gid = get_request('gid',0,1);
		$serverid = get_request('serverid');
		$name = get_request('name',0,1);
		
		$derive = get_request('derive',0,1);
		$where = '1=1';
		$server = $this->server_set->select_by_id($serverid);
		$ip = $server['device_ip'];
		$hostname = $server['hostname'];
		if($ip == '') {
			$ip = get_request('ip',1,1);
			if($ip != '') {
				$where .= " and ip LIKE '%$ip%'";
			}elseif(get_request('ip',0,1)!=""){
				$where .= " and ip LIKE '%".get_request('ip',0,1)."%'";
			}
		}
		else {
			$where .= " and ip='$ip'";
		}
		if($derive==1){
			$this->derive_pass($where);
			exit;
		}elseif($derive==3){
			$this->export_pass($where);
			exit;
		}
		$row_num = $this->account_linuxusers_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->account_linuxusers_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, 'ip','asc');
		$alltem = $this->tem_set->select_all();
		for($i=0;$i<$row_num;$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}elseif($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
			}
			if($alldev[$i]['radiususer']){
				$alldev[$i]['radiususer_is_in_member'] = $this->member_set->select_count("username='".$alldev[$i]['username']."'");
			}
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		$this->assign('curr_url', $curr_url);
		$this->assign('ip',$ip);
		$this->assign('gid', $gid);
		$this->assign('serverid', $serverid);
		$this->assign('server', $server);
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('account_linuxusers_index.tpl');
	}

	function accountlinux_edit() { 
		$ip = get_request('ip', 0, 1);
		$this->assign('ip', $ip);
		$this->display('accountlinux_edit.tpl');
	}

	function accountlinux_save() { 
		$ip = get_request('ip', 0, 1);
		$username = get_request('username', 1, 1);
		$pwd = get_request('pwd', 1, 1);
		$repwd = get_request('repwd', 1, 1);
		if($pwd!=$repwd){
			alert_and_back('两次输入的密码不一致');
			exit;
		}
		echo $cmd = "sudo /opt/freesvr/audit/sbin/createuser $username $pwd $ip ";
		exec($cmd, $out,  $return);
		if(intval($return)==0){
			echo '<script language=\'javascript\'>window.opener.location.reload()</script>';
			alert_and_close('创建成功',"admin.php?controller=admin_pro&action=dev_edit&ip=".$ip."&accounttable=1");
		}elseif(intval($return)==1){
			alert_and_back('创建失败',"admin.php?controller=admin_pro&action=dev_edit&ip=".$ip."&accounttable=1");
		}elseif(intval($return)==2){
			alert_and_back('密码错误',"admin.php?controller=admin_pro&action=dev_edit&ip=".$ip."&accounttable=1");
		}else{
			alert_and_back('创建失败',"admin.php?controller=admin_pro&action=dev_edit&ip=".$ip."&accounttable=1");
		}
	}

	function accountlinux_del() { 
		$id = get_request('id', 0, 1);
		if($id){
			$_POST['chk_member'][]=$id;
		}
		$msg = array();
		for($i=0; $i<count($_POST['chk_member']); $i++){
			$ac = $this->account_linuxusers_set->select_by_id($_POST['chk_member'][$i]);
			$username = $ac['user'];
			$ip = $ac['ip'];
			if($this->devpass_set->select_count("device_ip='$ip' and username='$username'")>0){
				$msg[]="账号$username已经绑定，请先删除\n";
				continue;
			}
			$cmd = "sudo /opt/freesvr/audit/sbin/deluser $username $ip ";
			exec($cmd, $out,  $return);
			if(intval($return)==0){			
				$this->account_linuxusers_set->delete($_POST['chk_member'][$i]);
				$msg[]="账号$username,删除成功";
				continue;
			}elseif(intval($return)==1){
				$msg[]="账号$username,删除失败";
				continue;
			}elseif(intval($return)==2){
				$msg[]="账号$username,密码错误";
				continue;
			}else{
				$msg[]="账号$username,删除失败";
				continue;
			}
		}
		alert_and_back(implode('\n',$msg));
	}

	function accountlinux2devices(){
		$serverid = get_request('serverid');
		$server = $this->server_set->select_by_id($serverid);
		if(empty($server)){
			alert_and_back('系统错误');
			exit;
		}
		for($i=0; $i<count($_POST['chk_member']); $i++){		
			$account = $this->account_linuxusers_set->select_by_id($_POST['chk_member'][$i]);
			if(empty($account)){
				continue;
			}

			if(0 == $this->devpass_set->select_count("username = '".$account['user']."' and device_ip='".$server['device_ip']."' and port='".$server['port']."' and hostname='".$server['hostname']."' and login_method='3'")) {
				$new_pass = new devpass();
				$new_pass->set_data('username',$account['user']);
				$new_pass->set_data('cur_password','');
				$new_pass->set_data('login_method',3);
				$new_pass->set_data('port',$server['port']);
				$new_pass->set_data('device_type',$server['device_type']);
				$new_pass->set_data('device_ip',$server['device_ip']);
				$new_pass->set_data('hostname',$server['hostname']);
				if($nolimit == 'on') {
					$new_pass->set_data('limit_time','9999-00-00');
				}
				else {
					if($limit_time != '') {
						$new_pass->set_data('limit_time',$limit_time);
					}
					else {
						$new_pass->set_data('limit_time','0000-00-00');
					}
				}
				
				$this->devpass_set->add($new_pass);
				$id = mysql_insert_id();

				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('添加系统用户'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
				$adminlog->set_data('type', 13);
				$this->admin_log_set->add($adminlog);				
				unset($adminlog);											

				$succeed[]=$account['user'];
				//alert_and_back('添加成功',"admin.php?controller=admin_pro&action=devpass_index&ip=$ip&serverid=".$serverid."&gid=".$gid);
				}
			else {
				//alert_and_back('添加失败,该用户已存在','admin.php?controller=admin_pro&action=pass_edit&ntype=new&ip='.$ip.'&serverid='.$serverid."&gid=".$gid);
				$error[]=$account['user'].':帐户已经存在\n';
				continue;
			}
		}

		if($succeed){
			$msg = '成功添加用户:'.implode(',',$succeed);
			if($error){
				$msg .= '\n添加失败的用户:\n'.implode('\n',$error).'\n';
			}
			alert_and_back($msg,"admin.php?controller=admin_pro&action=dev_edit&ip=".$server['device_ip']."&id=".$serverid."&tab=0&accounttable=1");
		}else{
			alert_and_back('全部添加失败',"admin.php?controller=admin_pro&action=dev_edit&ip=".$server['device_ip']."&id=".$serverid."&tab=0&accounttable=1");
		}

	}

	function accountlinux_listacct() { 
		$ip = get_request('ip', 0, 1);
		$id = get_request('id');
		$cmd = "sudo /opt/freesvr/audit/sbin/listacct $ip ";
		exec($cmd, $out,  $return);
		if(intval($return)==0){			
			alert_and_back('同步成功',"admin.php?controller=admin_pro&action=dev_edit&ip=".$ip."&id=$id&accounttable=1");
		}elseif(intval($return)==1){
			alert_and_back('同步失败',"admin.php?controller=admin_pro&action=dev_edit&ip=".$ip."&id=$id&accounttable=1");
		}elseif(intval($return)==2){
			alert_and_back('密码错误',"admin.php?controller=admin_pro&action=dev_edit&ip=".$ip."&id=$id&accounttable=1");
		}else{
			alert_and_back('同步失败',"admin.php?controller=admin_pro&action=dev_edit&ip=".$ip."&id=$id&accounttable=1");
		}
	}


	function viewradiusbind() { 
		$page_num = get_request('page');
		$radiususer = get_request('uid');
		$gid = get_request('gid',0,1);
		$serverid = get_request('serverid');
		$name = get_request('name',0,1);
		$derive = get_request('derive',0,1);
		$where = ' radiususer='.$radiususer;
		$server = $this->server_set->select_by_id($serverid);
		$ip = $server['device_ip'];
		$hostname = $server['hostname'];
		if($ip == '') {
			$ip = get_request('ip',1,1);
			if($ip != '') {
				$where .= " and device_ip LIKE '%$ip%'";
			}elseif(get_request('ip',0,1)!=""){
				$where .= " and device_ip LIKE '%".get_request('ip',0,1)."%'";
			}
		}
		else {
			$where .= " and device_ip='$ip'";
		}

		if($derive==1){
			$this->derive_pass($where);
			exit;
		}elseif($derive==3){
			$this->export_pass($where);
			exit;
		}
		//echo $where;
		$row_num = $this->devpass_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->devpass_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where);
		$alltem = $this->tem_set->select_all();
		for($i=0;$i<$row_num;$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}elseif($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
			}
			if($alldev[$i]['radiususer']){
				$alldev[$i]['radiususer_is_in_member'] = $this->member_set->select_count("username='".$alldev[$i]['username']."'");
			}
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		$this->assign('curr_url', $curr_url);
		$this->assign('ip',$ip);
		$this->assign('gid', $gid);
		$this->assign('serverid', $serverid);
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('devpass_radius_index.tpl');
	}

	function derive_pass($where){
		
		$alldev = $this->devpass_set->select_all($where);
		$str = language("主机名")."\t".language("IP")."\t".language("系统")."\t".language("系统用户")."\t".language("登录方式")." \t". language("主账号")."\t\n";
		$id=1;
		@unlink(ROOT.'tmp/DeviceUserList.xls');
		$handle = @fopen(ROOT . 'tmp/DeviceUserList.xls', 'w');
		if($alldev){
			$alltem = $this->tem_set->select_all();
			$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
			foreach ($alldev AS $report){	
				for($i=0;$i<count($alldev);$i++) {
					foreach($alltem as $tem) {
						if($report['login_method'] == $tem['id']) {
							$report['login_method'] = $tem['login_method'];
						}elseif($report['device_type'] == $tem['id']) {
							$report['device_type'] = $tem['device_type'];
						}
					}
				}
				
				$str .= $report['hostname']."\t".$report['device_ip']."\t".$report['device_type']."\t".($report['username']==""  ? '空用户' : $report['username'])."\t".$report['login_method']."\t".($report['master_user'] ? '是':'否');
				$str .= "\n";
			}
			
			if(!$handle){
				alert_and_back('写入文件出错,请检查文件权限');
				exit;
			}
		}
		$str = mb_convert_encoding($str, "GBK", "UTF-8");
		fwrite($handle, $str);
		fclose($handle);
		go_url("tmp/DeviceUserList.xls?c=" . rand());
		exit;
	}

	function export_pass($where='1=1'){
		global $_CONFIG;
		set_time_limit(0);
		if(strpos($where, " device_ip")!==false)
		$where = str_replace(" device_ip", " d.device_ip", $where); 
		$alldev = $this->devpass_set->base_select("SELECT d.*,servers.groupname,servers.sgldapid sgroupldapid, servers.sglevel sgrouplevel,servers.groupid FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN (SELECT sg.GroupName,s.device_ip,s.groupid,sg.ldapid sgldapid,sg.level sglevel FROM ".$this->server_set->get_table_name()." s LEFT JOIN ".$this->sgroup_set->get_table_name()." sg ON s.groupid=sg.id) servers ON d.device_ip = servers.device_ip WHERE servers.device_ip and d.id AND $where order by servers.groupname ASC, servers.device_ip ASC, d.username ASC");


		$str = language("主机名").",".language("IP").",".($_CONFIG['LDAP']&&0 ? language("一级目录").",".language("二级目录")."," : '').language("服务器组").",".language("系统类型").",".language("系统用户").",".language("当前密码")." ,".language("堡垒机用户认证")."\n";
		
		$id=1;
		if($alldev){
			$alltem = $this->tem_set->select_all();
			foreach ($alldev AS $report){	
				foreach($alltem as $tem) {
					if($report['login_method'] == $tem['id']) {
						$report['login_method'] = $tem['login_method'];
					}elseif($report['device_type'] == $tem['id']) {
						$report['device_type'] = $tem['device_type'];
					}
				}
				if(strpos($report['hostname'], '"')){
					//$report['hostname'] = str_replace('"', '"""',$report['hostname']);
				}
				if(strpos($report['hostname'], ',')){
					$report['hostname'] = '"'.$report['hostname'].'"';
				}
				if(strpos($report['groupname'], '"')){
					//$report['groupname'] = str_replace('"', '"""', $report['groupname']);
				}
				if(strpos($report['hostname'], ',')){
					//$report['groupname'] = '"'.$report['groupname'].'"';
				}
				if(strpos($report['username'], '"')){
					//$report['username'] = str_replace('"', '"""', $report['username']);
				}
				if(strpos($report['username'], ',')){
					$report['username'] = '"'.$report['username'].'"';
				}
				if(strpos($report['old_password'], '"')){
					//$report['old_password'] = str_replace('"', '"""', $report['old_password']);
				}
				if(strpos($report['old_password'], ',')){
					$report['old_password'] = '"'.$report['old_password'].'"';
				}
				if(strpos($report['current_password'], '"')){
					//$report['current_password'] = str_replace('"', '"""', $report['current_password']);
				}
				if(strpos($report['current_password'], ',')){
					$report['current_password'] = '"'.$report['current_password'].'"';
				}

				$_groups = $this->sgroup_set->select_all("groupname=(select groupname from ".$this->sgroup_set->get_table_name()." WHERE id=".$report['groupid'].")");
				if(count($_groups)>1){
					$report['groupname']=$_groups[0]['groupname'].'(('.$report['groupid'].'))';
				}elseif($_groups){
					$report['groupname']=$_groups[0]['groupname'];
				}

				$str .= $report['hostname'].",".$report['device_ip'].",".($_CONFIG['LDAP']&&0 ? $report['sgroupparentparent'].",".$report['sgroupparent']."," : '').$report['groupname'].",".$report['device_type'].",".($report['username']==""  ? '空用户' : $report['username']).",".$this->server_set->udf_encrypt($this->server_set->udf_decrypt($report['cur_password']),1).",".$report['radiususer'];
				$str .= "\n";
			}
		}

		$str = iconv("UTF-8", "GBK", $str);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=audit-devices-".date('Ymd').".csv"); 
		echo $str;
		exit;
	}

	function devimport(){
		$this->display("devimport.tpl");
	}

	function testNode($ldap1, $ldap2, $group){
		if($group){
			if($group['ldapid']==$ldap1['id']&&empty($ldap2)){
				return true;
			}
			if($group['ldapid']==$ldap2['id']&&$ldap2['ldapid']==$ldap1['id']){
				return true;
			}
			if(empty($group['ldapid'])&&empty($ldap1)&&empty($ldap2)){
				return true;
			}
		}else{
			if($ldap2&&$ldap2['ldapid']==$ldap1['id']){
				return true;
			}else if($ldap1){
				return true;
			}else if(empty($ldap1)&&empty($ldap2)){
				return true;
			}
		}
		return false;
	}
	
	function dodevimport(){
		global $_CONFIG;
		set_time_limit(0);
		setlocale(LC_ALL, 'zh_CN');
		$encrypt = get_request('encrypt', 1, 1);
		if($_FILES['devfile']['error']==1 or $_FILES['devfile']['error']==2){
			alert_and_back("上传得文件超过系统限制");
			exit;
		}
		if(!is_uploaded_file($_FILES['devfile']['tmp_name']))
		{
			alert_and_back("请上传文件");
			exit;
		}
		//echo $_FILES['devfile']['tmp_name'];
		if (($handle = fopen($_FILES['devfile']['tmp_name'], "r")) !== FALSE) {
			while(($lines[] = fgetcsv($handle))!==false);
		}else{
			alert_and_back("打开文件失败");
			exit;
		}
		$_ldap = (iconv("GBK", "UTF-8", trim($lines[0][0]))!='主机名' || iconv("GBK", "UTF-8", trim($lines[0][1]))!='IP' || iconv("GBK", "UTF-8", trim($lines[0][2]))!='一级目录' || iconv("GBK", "UTF-8", trim($lines[0][5]))!='系统类型'|| iconv("GBK", "UTF-8", trim($lines[0][6]))!='系统用户');
		$_no_ldap = (iconv("GBK", "UTF-8", trim($lines[0][0]))!='主机名' || iconv("GBK", "UTF-8", trim($lines[0][1]))!='IP' || iconv("GBK", "UTF-8", trim($lines[0][3]))!='系统类型'|| iconv("GBK", "UTF-8", trim($lines[0][4]))!='系统用户');
		if($_CONFIG['LDAP']&&0 ? $_ldap : $_no_ldap){
			alert_and_back("文件有问题，请上传正确的文件");
			exit;
		}
		//echo '<pre>';print_r($lines);echo '</pre>';exit;
		$j=0;
		$importfile = $_CONFIG['IMPORTFILEPATH'].'/'.time().'.'.$_FILES['devfile']['name'];
		if(move_uploaded_file($_FILES['devfile']['tmp_name'], $importfile)){
			$importlog = new importlog();
			$importlog->set_data('file', $importfile);
			$importlog->set_data('type', 'devices');
			$this->importlog_set->add($importlog);
		}else{
			//echo '<script language=\'javascript\'>导入文件备份失败，请联系管理员</script>';
		}
		$_mgroup = $this->sgroup_set->select_by_id($_SESSION['ADMIN_MSERVERGROUP']);
		for($i=1; $i<count($lines); $i++){
			$is_add_group=false;
			$groupid=0;
			$ldapid2 = 0;
			$ldapid1 = 0;
			$groupid = 0;
			$_ldapid1info = null;
			$_ldapid2info = null;
			$_groupinfo = null;

			if(empty($lines[$i])){
				continue;
			}
			$linearr = $lines[$i];	
			for($ii=0; $ii<count($linearr); $ii++){
				$linearr[$ii]=iconv("GBK", "UTF-8", $linearr[$ii]);
			}
			$index_i=0;
			$hostname=trim($linearr[$index_i++]);
			$device_ip=trim($linearr[$index_i++]);
			if($_CONFIG['LDAP']&&0){
				$groupparentparent=trim($linearr[$index_i++]);
				$groupparent=trim($linearr[$index_i++]);
			}
			$groupname=trim($linearr[$index_i++]);
			$device_type=trim($linearr[$index_i++]);
			$username=addslashes(trim(($linearr[$index_i]=='空用户' ? '' : $linearr[$index_i] )));
			$index_i++;
			$current_password=trim($linearr[$index_i++]);
			$radiususer=trim($linearr[$index_i++]);
			$sgldapid = 0;
			$sglevel =0; 
			if(empty($device_ip)){
				continue;
			}
			if(!is_ip($device_ip)){
				$error[]=$device_ip.'-'.$username.':IP格式错误\n';
				continue;
			}
			if(empty($groupparentparent) && empty($groupparent) && empty($groupname)){
				$error[]=$device_ip.'-'.$username.':没有设备组\n';
				continue;
			}
			if($radiususer&&$this->member_set->select_count("uid='".$radiususer."'")<=0){
				$error[]=$device_ip.'-'.$username.':RADIUS不存在\n';
				continue;
			}
			if(preg_match("/[\\r\\n]/", $hostname)||preg_match("/[\\r\\n]/", $device_ip)||preg_match("/[\\r\\n]/", $groupname)||preg_match("/[\\r\\n]/", $device_type)||preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $login_method)||preg_match("/[\\r\\n]/", $current_password)||preg_match("/[\\r\\n]/", $port)||preg_match("/[\\r\\n]/", $limit_time)||preg_match("/[\\r\\n]/", $auto)||preg_match("/[\\r\\n]/", $master_user)||preg_match("/[\\r\\n]/", $entrust_password)||preg_match("/[\\r\\n]/", $radiususer)){
				$error[]=$username.':'.'用户信息中含有回车符';
				continue;
			}
			$alltem = $this->tem_set->select_all();
			foreach($alltem as $tem) {
				if($login_method&&strtolower($login_method) == strtolower($tem['login_method'])) {
					$login_method = $tem['id'];
				}
				if($device_type&&strtolower($device_type) == strtolower($tem['device_type'])) {
					$device_type = $tem['id'];
				}
			}
			if(strpos($groupname,'((')===false){
				if($this->sgroup_set->select_count("groupname='".$groupname."'")>1){
					$error[]=$device_ip.' '.(empty($username) ? '空用户' : $username).' '.':'.'有重复组请输入组ID';
					continue;
				}
				$_group = $this->sgroup_set->select_all("groupname='".$groupname."'");
				$groupid=$_group[0]['id'];
			}else{				
				$groupid=substr($groupname, strpos($groupname,'((')+2, strpos($groupname,'))')-strpos($groupname,'((')-2);
			}
			if(empty($groupid)){
				$error[]=$device_ip.' '.(empty($username) ? '空用户' : $username).' '.':'.'组不存在';
				continue;
			}
			if($_CONFIG['LDAP']&&0){
				if(!$this->testNode($_ldapid1info, $_ldapid2info, $_groupinfo)){
					$error[]=$groupparentparent.'-'.$groupparent.'-'.$groupname.':'.'目录结构不正确';
					continue;
				}
			}
			if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
				if($_CONFIG['LDAP']&&0){
					if($ldapid1&&empty($ldapid2)&&empty($groupid)&&$this->sgroup_set->select_count("locate(',".$ldapid1.",',child) AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0&&$this->sgroup_set->select_count("locate('".$ldapid1.",',child) AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0&&$this->sgroup_set->select_count("locate(',".$ldapid1."',child) AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0&&$this->sgroup_set->select_count("child='".$ldapid1."' AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0){
						$error[]=$groupparentparent.':'.'目录不在权限范围内';
						continue;
					}
					if($ldapid2&&empty($groupid)&&$this->sgroup_set->select_count("locate(',".$ldapid2.",',child) AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0&&$this->sgroup_set->select_count("locate('".$ldapid2.",',child) AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0&&$this->sgroup_set->select_count("locate(',".$ldapid2."',child) AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0&&$this->sgroup_set->select_count("child='".$ldapid1."' AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0){
						$error[]=$groupparent.':'.'目录不在权限范围内';
						continue;
					}
					if($groupid&&$this->sgroup_set->select_count("locate(',".$groupid.",',child) AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0&&$this->sgroup_set->select_count("locate('".$groupid.",',child) AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0&&$this->sgroup_set->select_count("locate(',".$groupid."',child) AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0&&$this->sgroup_set->select_count("child='".$groupid."' AND id=".$_SESSION['ADMIN_MSERVERGROUP'])==0){
						$error[]=$groupname.':'.'目录不在权限范围内';
						continue;
					}
					
					if(!($_mgroup['level']==1&&$_mgroup['id']==$ldapid1 || $_mgroup['level']==2&&$_mgroup['id']==$ldapid2 || $_mgroup['level']==0&&$_mgroup['id']==$groupid)){
						$error[]=$groupparentparent.'-'.$groupparent.'-'.$groupname.':'.'目录不在权限范围内';
						continue;
					}
				}

				$servertmp = $this->server_set->select_all("device_ip='".$device_ip."'");
				$servertmp = $servertmp[0];
				if($this->sgroup_set->select_count("locate(',".$groupid.",',child) AND id IN(".$_SESSION['ADMIN_MSERVERGROUP'].")")==0&&$this->sgroup_set->select_count("locate('".$groupid.",',child) AND id IN(".$_SESSION['ADMIN_MSERVERGROUP'].")")==0&&$this->sgroup_set->select_count("locate(',".$groupid."',child) AND id IN(".$_SESSION['ADMIN_MSERVERGROUP'].")")==0&&$this->sgroup_set->select_count("child='".$groupid."' AND id IN(".$_SESSION['ADMIN_MSERVERGROUP'].")")==0){
					$error[]=$device_ip.':'.'没有该目录权限';
					continue;
				}
			}

			$is_add_group = false;
			if($_CONFIG['LDAP']&&0){
				if(empty($ldapid1)&&!empty($groupparentparent)){
					$newgroup = new sgroup();
					$newgroup->set_data("groupname", $groupparentparent);
					$newgroup->set_data("count", 0);
					$newgroup->set_data("description", '');
					$newgroup->set_data('ldapid' , 0);
					$newgroup->set_data('level', 1);
					$this->sgroup_set->add($newgroup);
					$ldapid1 = mysql_insert_id();
					$is_add_group = true;
				}			
				if(empty($ldapid2)&&!empty($groupparent)){
					$newgroup = new sgroup();
					$newgroup->set_data("groupname", $groupparent);
					$newgroup->set_data("count", 0);
					$newgroup->set_data("description", '');
					$newgroup->set_data('ldapid' , intval($ldapid1));
					$newgroup->set_data('level', 2);
					$this->sgroup_set->add($newgroup);
					$ldapid2 = mysql_insert_id();
					$is_add_group = true;
				}
			}
			if(empty($groupid)&&!empty($groupname)&&0){
				$newgroup = new sgroup();
				$newgroup->set_data("groupname", $groupname);
				$newgroup->set_data("count", 0);
				$newgroup->set_data("description", '');
				$newgroup->set_data('level', 0);
				if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
					$newgroup->set_data('ldapid', $_SESSION['ADMIN_MSERVERGROUP']);
				}
				$this->sgroup_set->add($newgroup);
				$groupid = mysql_insert_id();
				$is_add_group = true;
			}

			if($is_add_group){
				/*
				$member = new member_set();
				$member->query("create table if not exists sgrouptmp(id int(11) not null default 0, pid int(11) not null default 0, count int(11) not null default 0, mcount int(11) not null default 0,level tinyint(1) not null default 0)");
				$member->query("truncate table sgrouptmp");
				$member->query("insert into sgrouptmp(id, pid, level) select id,id,level FROM servergroup union select id,ldapid,level FROM servergroup WHERE level=0 and id>0 and ldapid>0 union select id,ldapid,level FROM servergroup WHERE level=2 union select c.id,a.id,c.level FROM servergroup a left join servergroup b on a.id=b.ldapid left join servergroup c on b.id=c.ldapid where c.id>0 and a.id>0");
				$member->query("update sgrouptmp set count=(select count(*) from servers where sgrouptmp.id=groupid)");
				$member->query("update sgrouptmp set mcount=(select count(*) from member where sgrouptmp.id=groupid)");
				$member->query("UPDATE servergroup s SET count=(SELECT sum(count) FROM sgrouptmp WHERE pid=s.id)");
				$member->query("UPDATE servergroup s SET mcount=(SELECT sum(mcount) FROM sgrouptmp WHERE pid=s.id)");
				$member->query("UPDATE servergroup s SET child=(SELECT group_concat(id) FROM sgrouptmp WHERE pid=s.id )");
				*/
				$sgroupset = new sgroup_set();
				$sgroupset->updatechild();
				$group_set = new usergroup_set();
				$usergroup = $group_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND id IN(SELECT id FROM sgrouptmp WHERE pid='.$_SESSION['ADMIN_MUSERGROUP'].')') : ''),'GroupName', 'ASC');
				$_SESSION['ADMIN_MUSERGROUP_IDS'] = array(-1);
				for($ii=0; $ii<count($usergroup); $ii++){
					$_SESSION['ADMIN_MUSERGROUP_IDS'][]=$usergroup[$ii]['id'];
				}
				$sgroup_set = new sgroup_set();
				$sgroup = $sgroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : ' AND id IN(SELECT id FROM sgrouptmp WHERE pid='.$_SESSION['ADMIN_MSERVERGROUP'].')') : ''),'GroupName', 'ASC');
				$_SESSION['ADMIN_MSERVERGROUP_IDS'] = array(-1);
				for($ii=0; $ii<count($sgroup); $ii++){
					$_SESSION['ADMIN_MSERVERGROUP_IDS'][]=$sgroup[$ii]['id'];
				}
			}
		
			$limit_time = ($limit_time=='永不过期' ? '9999-00-00' : $limit_time);
			//$enable = ($enable=='是' ? 1 : 0);
			$auto = ($auto=='是' ? 1 : 0);
			$master_user = ($master_user=='是' ? 1 : 0);
			$entrust_password = ($entrust_password=='是' ? 1 : 0);
			//$radiususer = ($radiususer=='是' ? 1 : 0);

			$insertservers = "INSERT INTO ".$this->server_set->get_table_name()."(device_ip,hostname,device_type,groupid) values";
			$insertserverslen = strlen($insertservers);
			$insertdevices = "INSERT INTO ".$this->devpass_set->get_table_name()."(device_ip,login_method,device_type,hostname,username,cur_password,port,limit_time,automodify,master_user,entrust_password,radiususer,sftp, publickey_auth) values";
			$insertdeviceslen = strlen($insertdevices);

			$groupid = !empty($groupid) ? $groupid : (!empty($ldapid2) ? $ldapid2 : $ldapid1);

			$server = $this->server_set->select_all("device_ip='".$device_ip."'");
			if(empty($server)){
				$insertservers .= "('".$device_ip."','".$hostname."','".$device_type."','".$groupid."'),";
			}else{
				$new_dev = new server();
				$new_dev->set_data('id',$server[0]['id']);
				$new_dev->set_data('hostname',$hostname);
				$new_dev->set_data('login_method',$login_method);
				$new_dev->set_data('device_type',$device_type);
				$new_dev->set_data('port',$port);
				$new_dev->set_data('groupid',$groupid);
				//$new_dev->set_data('superpassword', $this->member_set->udf_encrypt(addslashes($current_password)));
				$this->server_set->edit($new_dev);
			}
			$devpass = $this->devpass_set->select_all("username = '".$username."' and device_ip='".$device_ip."' and login_method='".$login_method."' and port='".$port."'");
			if(empty($devpass)){
				$row_num = $this->devpass_set->select_count(" device_ip='".$device_ip."' AND hostname='".$hostname."' AND master_user=1");
				if($row_num>0){
					$master_user=0;
				}
				if($encrypt){
					$old_password=empty($old_password) ? '' : $this->devpass_set->udf_encrypt(addslashes($old_password));
					$current_password=empty($current_password) ? '' : $this->devpass_set->udf_encrypt(addslashes($current_password));
				}else{
					$old_password=$this->member_set->udf_encrypt($this->member_set->udf_decrypt(addslashes($old_password)),1);
					$current_password=$this->member_set->udf_encrypt($this->member_set->udf_decrypt(addslashes($current_password)),1);
				}
				$insertdevices.="('".$device_ip."','".$login_method."','".$device_type."','".$hostname."','".$username."','".$current_password."','".$port."','".$limit_time."','".$auto."','".$master_user."','".$entrust_password."','".$radiususer."','".$sftp."','".$publickey_auth."'),";
			}else{
				$new_pass = new devpass();
				$new_pass->set_data('id',$devpass[0]['id']);
				$new_pass->set_data('cur_password',$this->member_set->udf_decrypt(addslashes($current_password)),1);
				if($encrypt){
					$new_pass->set_data('cur_password',$this->member_set->udf_encrypt(addslashes($current_password)));
				}
				$new_pass->set_data('port',$port);
				$new_pass->set_data('hostname',$hostname);
				$new_pass->set_data('automodify',$auto);
				$new_pass->set_data('master_user',$master_user);
				$new_pass->set_data('entrust_password',$entrust_password);
				$new_pass->set_data('limit_time',$limit_time);
				$new_pass->set_data('radiususer',$radiususer);	
				$new_pass->set_data('device_type',$device_type);
				$new_pass->set_data('sftp',$sftp);
				$new_pass->set_data('publickey_auth',$publickey_auth);
				$new_pass->set_data('entrust_username',$entrust_username);
				$this->devpass_set->edit($new_pass);
			}

			if(strlen($insertservers)>$insertserverslen){
				//echo substr($insertservers,0,strlen($insertservers)-1);
				$this->server_set->query(substr($insertservers,0,strlen($insertservers)-1));
			}
			echo '<br />';
			if(strlen($insertdevices)>$insertdeviceslen){
				//echo substr($insertdevices,0,strlen($insertdevices)-1);
				$this->devpass_set->query(substr($insertdevices,0,strlen($insertdevices)-1));	
			}
		}
		$this->devpass_set->query("UPDATE ".$this->devpass_set->get_table_name()." a SET hostname=(SELECT hostname FROM ".$this->server_set->get_table_name()." b WHERE a.device_ip=b.device_ip)");
		if($error){
			$msg = '\n添加失败的用户:\n'.implode('\n',$error).'\n';
			//alert_and_back($msg, "admin.php?controller=admin_pro&action=dev_index");
			echo '<script language=\'javascript\'>alert("'.$msg.'");window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
		}else{
			//alert_and_back('导入成功', "admin.php?controller=admin_pro&action=dev_index");
			echo '<script language=\'javascript\'>alert("导入成功");window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server&gid='.$gid.'";</script>';
		}
		
	}

	function devpass_edit() {
		$id = get_request('id');
		$dev = $this->devpass_set->select_by_id($id);
		$this->assign('IP',$dev['device_ip']);
		$this->assign('hostname',$dev['hostname']);
		$this->assign('username',$dev['username']);
		$this->assign('email',$dev['user_email']);
		$tem = $this->tem_set->select_by_id($dev['template_id']);
		$this->assign('login_method',$tem['device_type'].'/'.$tem['login_method']);
		$this->assign('oldpass',$dev['old_password']);
		//$this->assign('curpass',($dev['cur_password']));
		$this->assign('update_time',$dev['last_update_Time']);
		$this->assign('id',$id);
		$this->assign('title',language('设备详细信息'));
		$this->display('dev_view.tpl');
	}

	function dev_checkpass() {
		$this->assign('title',language('请输入管理员用户名密码'));
		$id = get_request('id');
		$this->assign('id',$id);
		$this->display('checkpass.tpl');
	}

	function dev_viewpass() {
		global $_CONFIG;
		$id = get_request('id');
		$username = (get_request("username", 1, 1));
		$password = htmlspecialchars_decode(get_request("password", 1, 1));
		if($_SESSION['ADMIN_LEVEL'] == 0) {
			$result = $this->member_set->select_all("`username` = '$username' AND `password` = '".$this->member_set->udf_encrypt($password)."' AND level = 10");
		}
		else {
			$result = $this->member_set->select_all("`username` = '$username' AND `password` = '".$this->member_set->udf_encrypt($password)."'");
			if($result[0]['level']==0) {
				$member = $this->member_set->select_all(" username='$username'");	
				$luser = $this->luser_set->select_all(" devicesid=$id AND memberid=".$member[0]['uid']);
				if(empty($luser)){
					$luser = $this->lgroup_set->select_all(" groupid=".$member[0]['groupid']." AND  groupid=$id ");
				}
				if (empty($luser)) {
					alert_and_back('该托管用户和此用户没有绑定');
					exit(0);
				}
			}
		}
		
		if(!$result) {
			alert_and_back('用户名或密码错误,请重试');
		}else if($result[0]['level']!=0&&$result[0]['level']!=1){
			alert_and_back('权限不允许');
		}
		else {
			$dev = $this->devpass_set->select_by_id($id);
			$this->assign('IP',$dev['device_ip']);
			$this->assign('hostname',$dev['hostname']);
			$this->assign('username',$dev['username']);
			$tem = $this->tem_set->select_by_id($dev['login_method']);
			$this->assign('login_method',$tem['login_method']);		
			$tem = $this->tem_set->select_by_id($dev['device_type']);
			$this->assign('device_type',$tem['device_type']);

			$this->assign('oldpass',($this->member_set->udf_decrypt($dev['old_password'])));
			$this->assign('curpass',($this->member_set->udf_decrypt($dev['cur_password'])));
			$this->assign('update_time',$dev['last_update_time']);
			$this->assign('id',$id);
			$this->assign('title',language('设备详细信息'));
			$this->display('dev_show.tpl');
		}
	}
	function devpass_del() {
		$id = get_request('id')!=0 ? array(get_request('id')) : 0;
		$gid= get_request('gid');
		$serverid = get_request('serverid');
		if(empty($id)){
			$id = get_request('chk_member', 1, 1);
		}
		$ip = get_request('ip', 0, 1);
		
		for($i=0; $i<count($id); $i++){
			$dev = $this->devpass_set->select_by_id($id[$i]);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);				
			$adminlog->set_data('action', language('删除系统用户'));
			$adminlog->set_data('resource', $dev['device_ip']);
			$adminlog->set_data('resource_user', $dev['username']);
			$adminlog->set_data('type', 13);
			$this->admin_log_set->add($adminlog);
		}
		unset($adminlog);
		$this->luser_set->delete_all(' devicesid IN ('.implode(',',$id).')');
		$this->lgroup_set->delete_all(' devicesid IN ('.implode(',',$id).')');
		$this->resgroup_set->delete_all(' devicesid IN ('.implode(',',$id).')');
		$this->devpass_set->delete($id);
		if(get_request('from',0,1)=='dev_priority_search'){
			alert_and_back('删除成功');
			exit;
		}
		if(get_request('frombatchdevicepriorityedit')){
			alert_and_back('删除成功','admin.php?controller=admin_pro&action=batchdevicepriorityedit');
		}
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=devpass_index&ip='.$ip.'&serverid='.$serverid."&gid=".$gid);
	}

	function logs_index() {
		$page_num = get_request('page');
		$ip = get_request("ip", 0, 1);
		$derive = get_request("derive", 0, 1);
		$start_time = get_request("start_time", 0, 1);
		$end_time = get_request("end_time", 0, 1);
		$success = get_request("success", 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'time';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		$where = '1=1';
		
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$where .= " AND device_ip IN (SELECT device_ip FROM servers WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS'])."))";
		}
		if($ip){
			$where .= "  AND device_ip like '%".$ip."%'";
		}
		if($start_time){
			$where .= " AND time >='".$start_time."'";
		}
		if($end_time){
			$where .= " AND time <='".$end_time."'";
		}
		if($success){
			$where .= " AND update_success_flag='".$success."'";
		}
		if($derive==1){
			$reports = $this->logs_set->select_all($where);
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .= language("序号")."\t".language("服务器地址")."\t".language("用户名")."\t".language("上次修改结果")."\t".language("时间")."\t\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['device_ip']."\t".$report['username']."\t".$report['update_success_flag']."\t".$report['time'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=LogIndex.csv"); 
			echo iconv("UTF-8", "GBK", $str);
			exit();
		}
		$row_num = $this->logs_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllog = $this->logs_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('curr_url', $curr_url);

		$this->assign('title', language('日志列表'));
		$this->assign('alllog', $alllog);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('logs_index.tpl');
	}

	function logs_statistic() {
		$page_num = get_request('page');
		$derive = get_request('derive');
		$start_time = get_request("start_time", 0, 1);
		$end_time = get_request("end_time", 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'a.device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = '1=1';
		
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$where .= " AND a.device_ip IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
		}
		if($start_time){
			$where .= " AND time >='".$start_time."'";
		}
		if($end_time){
			$where .= " AND time <='".$end_time."'";
		}
		$sql = "SELECT a.device_ip,b.hostname,a.username,max(time) start,min(time) end,count(*) ct,sum(if(update_success_flag='YES',1,0)) success,sum(if(update_success_flag='NO',1,0)) fail from ".$this->logs_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.device_ip=b.device_ip WHERE $where GROUP BY a.device_ip,a.username ";
		$sql .= "ORDER BY $orderby1 $orderby2,username ASC";
		if($derive==1){
			
			$reports = $this->sessions_set->base_select($sql);
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .= language("序号")."\t".language("服务器地址")."\t".language("主机名")."\t".language("用户")."\t".language("开始时间")."\t".language("结束时间")."\t".language("改密次数")."\t".language("成功")."\t".language("失败")."\t\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['device_ip']."\t".$report['hostname']."\t".$report['username']."\t".$report['start']."\t".$report['end']."\t".$report['ct']."\t".$report['success']."\t".$report['fail'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=LogIndex.csv"); 
			echo iconv("UTF-8", "GBK", $str);
			exit();
		}
		$row_num = $this->logs_set->base_select("select count(*) num from ($sql) t");
		$row_num = $row_num[0]['num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllog = $this->logs_set->base_select($sql." LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage ");

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('curr_url', $curr_url);

		$this->assign('title', language('日志列表'));
		$this->assign('alllog', $alllog);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('logs_statistic.tpl');
	}

	function last_changepwd() {
		$page_num = get_request('page');		
		$where = ' 1=1';
		
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$where .= " AND device_ip IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
			}else{
				$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND username IN ('".implode("','", $alltmpuser)."')";
			}
		}
		
		
		$row_num = $this->logs_set->base_select('SELECT max(id) AS count FROM '.$this->logs_set->get_table_name().' GROUP BY username');
		$row_num = count($row_num);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllog = $this->logs_set->base_select("SELECT l.* FROM ".$this->logs_set->get_table_name()." l,(SELECT max(id) as id FROM ".$this->logs_set->get_table_name()." GROUP BY username) l2 where l.id=l2.id ORDER BY username LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage", $where);
		//print_r($alllog);
		$this->assign('title', language('日志列表'));
		$this->assign('alllog', $alllog);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('last_changepwd.tpl');
	}
	
	function passwordcheck() {
		$page_num = get_request('page');	
		$ip = get_request("ip", 1, 1);
		$username = get_request("username", 1, 1);
		$passwordtry = get_request("passwordtry", 1, 1);	
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = ' passwordtry IS NOT NULL';
		if($ip){
			$where .= "  AND device_ip like '%".$ip."%'";
		}
		if($username){
			$where .= "  AND username like '%".$username."%'";
		}
		if($passwordtry != ''){
			$where .= "  AND passwordtry='".$passwordtry."'";
		}
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$where .= " AND device_ip IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
		}
		
		
		$row_num = $this->devpass_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->devpass_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		
		$alltem = $this->tem_set->select_all();

		for($i=0;$i<$row_num;$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
				elseif($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}
			}
			switch ($alldev[$i]['passwordtry']){
				case '0':
					$alldev[$i]['passwordtry']=language('登录正常');
					break;
				case '1':
					$alldev[$i]['passwordtry']=language('密码错误');
					break;
				case '2':
					$alldev[$i]['passwordtry']=language('无法连接');
					break;
			}
		}
		//print_r($alldev);
		$this->assign('title', language('密码检验'));
		$this->assign('alllog', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('passwordcheck.tpl');
	}
	
	function logs_del() {
		$id = get_request('id');
		if(empty($id)){
			$id = $_POST['chk_member'];
		}
		$this->logs_set->delete($id);
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=logs_index');

	}

	function encrypt($code) {
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
	
	function sourceip(){
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'groupname';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$where = 'sourceip=\'\'';
		if($_SESSION['ADMIN_LEVEL']!=1){
			$where .= " AND creatorid=".$_SESSION['ADMIN_UID'];
		}
		if($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			$where .= ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))';
		}
		$row_num = $this->sourceip_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$s = $this->sourceip_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$this->assign('title', language('来源IP列表'));
		$this->assign('s', $s);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('sourceip.tpl');
	}
	
	function sourceip_list(){
		$page_num = get_request('page');
		$groupname = get_request('groupname', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'sid';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		$where = ' groupname=\''.$groupname.'\' AND sourceip!=\'\'';
		$row_num = $this->sourceip_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$s = $this->sourceip_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$this->assign('title', language('来源IP列表'));
		$this->assign('s', $s);
		$this->assign("groupname", $groupname);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('sourceip_list.tpl');
	}
	
	function sourceip_edit(){
		$sid = get_request("sid");
		$sip = $this->sourceip_set->select_by_id($sid);
		$this->assign("title", language('添加来源IP组'));
		$this->assign("sip", $sip);
		$this->display('sourceip_edit.tpl');
	}
	
	function sourceip_delete(){
		$error = array();
		for($i=0; $i<count($_POST['chk_gid']); $i++){
			$groupname = $_POST['chk_gid'][$i];
			$a = $this->sourceip_set->base_select("select sum(num) b FROM (SELECT count(*) as num FROM luser where sourceip='".$groupname."' 
			UNION SELECT count(*) as num FROM lgroup where sourceip='".$groupname."' 
			UNION SELECT count(*) as num FROM luser_devgrp where sourceip='".$groupname."' 
			UNION SELECT count(*) as num FROM luser where sourceip='".$groupname."') t");
			if($a[0]['b']>0){
				$error[] = $groupname.":该组已被绑定,不能删除";
				continue;
			}
			$this->sourceip_set->query("DELETE FROM ".$this->sourceip_set->get_table_name()." WHERE groupname='$groupname'");
		}
		if($error){
			alert_and_back('删除失败:\n'.implode('\n', $error),'admin.php?controller=admin_pro&action=sourceip');
			exit;
		}
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=sourceip');
	}
	
	function sourceiplist_delete(){
		$sid = get_request("sid");
		$groupname = get_request("groupname", 0, 1);
		if(empty($sid)){
			$this->sourceip_set->delete($_POST['chk_gid']);
		}else{			
			$this->sourceip_set->delete($sid);
		}
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=sourceip_list&groupname='.$groupname);
	}

	function sourceip_list_edit(){
		$sid = get_request("sid");
		$groupname = get_request("groupname", 0, 1);
		$ginfo = $this->sourceip_set->select_all("groupname='".$groupname."'");
		$ginfo = $ginfo[0];
		$sip = $this->sourceip_set->select_by_id($sid);
		$sip['ip_mask'] = explode('/', $sip['sourceip']); 
		$this->assign("title", language('添加来源IP组'));
		$this->assign("sourceip", $sip);
		$this->assign("groupname", $groupname);
		$this->assign("masksize", $ginfo['ipv6'] ? 129 : 33);
		$this->display('sourceip_list_edit.tpl');
	}
	
	function sourceiplist_save(){
		$groupname = get_request("groupname", 0, 1);
		$sid = get_request("sid");
		$ginfo = $this->sourceip_set->select_all("groupname='".$groupname."'");
		$ginfo = $ginfo[0];
		if($sid){
			$ip = get_request("ip", 1, 1);
			$netmask = get_request("netmask", 1, 1);			
			if(!$ginfo['ipv6']&&!is_ip($ip)||$ginfo['ipv6']&&!validateIPv6($ip)){
				alert_and_back('IP格式不正确');
				exit;
			}
			$sourceip = new sourceip();
			$sourceip->set_data('sid', $sid);
			$sourceip->set_data('groupname', $groupname);
			$sourceip->set_data('sourceip', $ip.'/'.$netmask);
			$this->sourceip_set->edit($sourceip);
		}else{
			if(empty($groupname)){
				alert_and_back('系统错误,请重新打开');
				exit;
			}
			$error = array();
			for($i=0; $i<count($_POST['ip']); $i++){
				if(empty($_POST['ip'][$i])){
					continue;
				}
				if(!$ginfo['ipv6']&&!is_ip($_POST['ip'][$i])||$ginfo['ipv6']&&!validateIPv6($_POST['ip'][$i])){
					$error[]=($_POST['ip'][$i].':IP格式不正确');
					continue;
				}
				$sourceip = new sourceip();
				$sourceip->set_data('groupname', $groupname);
				$sourceip->set_data('sourceip', $_POST['ip'][$i].'/'.$_POST['netmask'][$i]);
				$this->sourceip_set->add($sourceip);
			}
			if($error){
				alert_and_back('添加失败:\n'.implode('\n', $error),'admin.php?controller=admin_pro&action=sourceip_list&groupname='.$groupname);
			}
		}
		alert_and_back('操作成功','admin.php?controller=admin_pro&action=sourceip_list&groupname='.$groupname);
	}
	
	function sourceip_save(){
		$sid = get_request("sid");
		$groupname = get_request("groupname", 1, 1);
		$description = get_request("description", 1, 1);
		$ipv6 = get_request("ipv6", 1, 0);
		if(empty($groupname)){
			alert_and_back('请填写组名');
			exit;
		}
		$allgp = $this->sourceip_set->select_all('groupname="'.$groupname.'" AND sid!='.$sid);
		if(!empty($allgp)){
			alert_and_back('该组名已经存在');
			exit;
		}
		$sourceip = new sourceip();
		$sourceip->set_data('groupname', $groupname);
		$sourceip->set_data('description', $description);
		$sourceip->set_data('sourceip', $sip);
		$sourceip->set_data('creatorid', $_SESSION['ADMIN_UID']);
		if($sid){
			$sourceip->set_data("sid", $sid);
			$this->sourceip_set->edit($sourceip);
			alert_and_back('修改成功','admin.php?controller=admin_pro&action=sourceip');
			exit;
		}
		$sourceip->set_data('ipv6', $ipv6);
		$this->sourceip_set->add($sourceip);
		alert_and_back('添加成功','admin.php?controller=admin_pro&action=sourceip');
	}

	function showpasswordkey(){
		global $_CONFIG;
		$id = get_request('id');
		if($_POST['submit']){
			if($this->member_set->select_count("username='password' AND password=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? "udf_encrypt('".($_POST['password'])."')" : "AES_ENCRYPT('".($_POST['password'])."'").",'".$_CONFIG['PASSWORD_KEY']."')")>0&&$this->member_set->select_count("username='audit' AND password=udf_encrypt('".$_POST['audit']."')")>0){
				$this->assign('p', $this->passwordkey_set->select_by_id($id));
			}else{
				alert_and_back('密码不正确');
				exit;
			}
		}
		$this->assign('id', $id);
		$this->display("showpasswordkey.tpl");
	}
	
	function passwordkey(){
		$page_num = get_request('page',0,1);
		$where = '1=1';
		$row_num = $this->passwordkey_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$s = $this->passwordkey_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, 'key_date', 'DESC');

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('密码密钥列表'));
		$this->assign('allsession', $s);
		$this->assign("groupname", $groupname);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('passwordkey_list.tpl');
	}

	function passwordkey_edit(){
		$key_str = get_request('key_str', 0, 1);
		$passkey = $this->passwordkey_set->select_by_id($key_str);
		$this->assign("passkey", $passkey);
		$this->display("passwordkey_edit.tpl");
	}

	function passwordkey_save(){
		$key_str = get_request('key_str', 1, 1);
		$zip_file = get_request('zip_file', 1, 1);
		if($this->passwordkey_set->select_count("key_str='$key_str'")>0){
			alert_and_back("密钥已经存在");
			exit;
		}
		$passwordkey = new passwordkey();
		$passwordkey->set_data("key_str", $key_str);
		$passwordkey->set_data("zip_file", $zip_file);
		$passwordkey->set_data("key_email", 0);
		$passwordkey->set_data("zip_email", 0);
		$passwordkey->set_data("key_date", date('Y-m-d H:i:s'));
		$this->passwordkey_set->add($passwordkey);
		alert_and_back("保存成功", 'admin.php?controller=admin_pro&action=passwordkey');
		exit;
	}

	function deletepasswordkey(){
		$p = get_request('id',0,1);
		if(empty($p)){
			$ps = $_POST['chk_member'];
		}else{
			$ps[]=$p;
		}
		$this->passwordkey_set->delete($ps);
		alert_and_back("删除成功");
		exit;
	}

	function list_active_change(){
		$page_num = get_request('page',0,1);
		$cmd = get_request('cmd', 0, 1);
		$where = 'active_change=2';
		$row_num = $this->devpass_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->devpass_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, 'device_ip', 'ASC');

		$alltem = $this->tem_set->select_all();
		for($i=0; $i<count($alldev); $i++){
			foreach($alltem as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
				elseif($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}
			}
		}

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('密码密钥列表'));
		$this->assign('allsession', $alldev);
		$this->assign("groupname", $groupname);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('cmd', urlencode($cmd));
		$this->display('list_active_change.tpl');
	}

	function list_freesvrpwd_log(){	
		$exists = array();
		$ct = countLines('/opt/freesvr/audit/passwd/log/freesvr_passwd.log');
		echo '监控日志:'.'<br>';
		while(1){
			$ct2 = countLines('/opt/freesvr/audit/passwd/log/freesvr_passwd.log');
			if($ct2>$ct){
				exec('tail -n '.($ct2-$ct).' /opt/freesvr/audit/passwd/log/freesvr_passwd.log', $out);
				for($i=0; $i<count($out); $i++){
					echo nl2br(htmlspecialchars($out[$i]));echo '<br />';
				}
				$ct = $ct2;
				echo '<script language=\'javascript\'>document.body.scrollTop=document.body.scrollHeight;</script>';
				flush();
			}
			sleep(2);
		}
	}

	function lac_save(){
		global $_CONFIG;
		foreach($_POST AS $key => $v){
			$tmp = explode('_', $key);
			if(substr($key, 0, 5)=='save_'&&count($tmp)>1){
				$sql = "UPDATE ".$this->devpass_set->get_table_name()." SET new_password=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? "udf_encrypt('".($_POST['new_password_'.$tmp[1]])."')" : "AES_ENCRYPT('".($_POST['new_password_'.$tmp[1]])."','".$_CONFIG['PASSWORD_KEY']."')").", active_change='".($_POST['active_change_'.$tmp[1]])."' WHERE id='".$_POST['id_'.$tmp[1]]."'";
				$this->devpass_set->query($sql);
				alert_and_back('操作成功');				
			}
		}
	}

	function lac_save2(){
		$cmd = urldecode(get_request('cmd', 0, 1));
		$cmd = str_replace(' -c ', '', $cmd);		
		exec($cmd, $out);
		alert_and_back('操作成功', 'admin.php?controller=admin_pro&action=passwordedit');				
	}
	
	function passwordedit(){
		global $_CONFIG;
		$group = get_request('group', 1, 1);
		$pwdpolicy = get_request('pwdpolicy', 1, 0);
		$password = htmlspecialchars_decode(get_request('password', 1, 1));
		$server = get_request('server', 1, 1);
		$username = get_request('device', 1, 1);
		$ac = get_request('ac', 1, 1);
		$time = get_request('f_rangeStart', 1, 1);
		
		require_once('./include/select_sgroup_ajax.inc.php');
		if($ac == 'doit'){
			$cmd = 'sudo '.$_CONFIG['EDITPASSWORD2'].' -c ';
			if(((empty($server)||$server==99999999) && (empty($username)||$username==99999999)) && $group!=99999999 && $group){
				$cmd .= ' -g '.$group;
			}
			if($password){
				$cmd .= ' -p '.$password;
			}
			if($pwdpolicy){
				$cmd .= ' -f ';
			}
			if($server!=99999999&&$server){
				$cmd .= ' -s '.$server;
			}
			if($username!=99999999&&$username){
				$cmd .= ' -u '.$username;
			}
			
			//echo $cmd;exit;
			if($time=='立即执行'){
				exec($cmd, $out);
?>

<style>
.black_overlay{ display: none; position: absolute; top: 0%; left: 0%; width: 100%; height: 100%;background-color: f7f7f7; z-index:1001; -moz-opacity: 0.8; opacity:.80; filter: alpha(opacity=80); }
.white_content { position: absolute; top: 20%; left: 35%; padding: 1px; z-index:1003; overflow: auto; }
</style>
<div id="fade" class="black_overlay"></div> 
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
function showImg(wTitle, c)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=200;
	var wHeight=240;
	var bWidth=parseInt(w=window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth);
	var bHeight=parseInt(window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight)+20;
	bHeight=700+20;
	var back=document.createElement("div");
	back.id="back";
	var styleStr="top:0px;left:0px;position:absolute;width:"+bWidth+"px;height:"+bHeight+"px;z-index:1002;";
	//styleStr+=(isIe)?"filter:alpha(opacity=0);":"opacity:0;";
	back.style.cssText=styleStr;
	document.body.appendChild(back);
	var mesW=document.createElement("div");
	mesW.id="mesWindow";
	mesW.className="mesWindow";
	mesW.innerHTML='<div id="light" class="white_content" style="text-align: center;">'+c+"</div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
	
	document.getElementById('fade').style.display='block'
	return false;
}
showImg('',"<img src='template/admin/images/loading1.gif'  >");
</script>
<?php
flush();
while(1){
	$cmd2 = "ps -ef | grep /opt/freesvr/audit/passwd/sbin/freesvr-passwd";
	exec($cmd2, $out2);
	$found = 0;
	for($i=0; $i<count($out2); $i++){
		$out2[$i]=trim($out2[$i]);
		$tmp = preg_split('/\s+/',$out2[$i]);
		if($tmp[7]=='/opt/freesvr/audit/passwd/sbin/freesvr-passwd'){
			$found = 1;
			break;
		}
	}
	if(empty($found)){
?>
<script language="JavaScript">  
	closeWindow();
   // window.open("admin.php?controller=admin_pro&action=list_active_change&cmd=<?=urlencode($cmd)?>", 'newwindow', 'height=460, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');
</script>  
<?php  
	flush();
	$_GET['cmd'] = urlencode($cmd);
	go_url("admin.php?controller=admin_pro&action=list_active_change&cmd=".urlencode($cmd));
	exit;
	}
   sleep(2);
}
			}else{
				file_put_contents(ROOT.'/tmp/changepassword', $cmd);
				$time=substr($time,0,strrpos(':', $time));
				$time=str_replace('-', '', $time);
				$time=str_replace(':', '', $time);
				exec('at -t '.$time.' -f '.ROOT.'/tmp/changepassword', $out);
			}
			alert_and_back('修改请求发送成功，请查看日志验证', 'admin.php?controller=admin_pro&action=passwordedit');
		}
		$this->assign("logined_user_level", 1);
		$allgroup = $this->sgroup_set->select_all('attribute!=1', 'groupname', 'asc');
		$this->assign("allgroup", $allgroup);
		$this->assign("allsgroup", $allgroup);
		$server = $this->server_set->select_all();
		$this->assign("server", $server);
		$devices = $this->devpass_set->base_select("SELECT * FROM devices GROUP BY device_ip,username");
		$this->assign("devices", $devices);
		$config = $this->setting_set->select_all(" sname='password_policy'");
		$pwdconfig = unserialize($config[0]['svalue']);		
		$this->assign("pwdconfig_pwdstrong1", intval($pwdconfig['pwdstrong1']));
		$this->assign("pwdconfig_pwdstrong2", intval($pwdconfig['pwdstrong2']));
		$this->assign("pwdconfig_pwdstrong3", intval($pwdconfig['pwdstrong3']));
		$this->assign("pwdconfig_pwdstrong4", intval($pwdconfig['pwdstrong4']));
		$this->assign("pwdconfig_login_pwd_length", intval($pwdconfig['login_pwd_length']));
		$this->assign("pwdconfig_password_ban_word", addslashes($_CONFIG['PASSWORD_BAN_WORD']));
		$this->assign("_config", $_CONFIG);
		$this->display('editpassword.tpl');
	}

	function password_cron(){
		global $_CONFIG;
		$chpwdservice = get_request('chpwdservice', 1, 1);
		$accountservice = get_request('accountservice', 1, 1);
		$uploadservice = get_request('uploadservice', 1, 1);
		$pwduploadservice = get_request('pwduploadservice', 1, 1);
		$ac = get_request('ac', 1, 1);

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
			$puminute = get_request('puminute', 1, 1);
			$puhour = get_request('puhour', 1, 1);
			$puday = get_request('puday', 1, 1);
			$puweek = get_request('puweek', 1, 1);
			//
			$change = 0;
			$account = 0;
			$priority = 0;
			$pwd = 0;

			$linestmp = @file($_CONFIG['NTPNAGIOS']);//echo '<pre>';print_r($linestmp);echo '</pre>';
			for($ii=0; $ii<count($linestmp); $ii++)
			{				
				if(strlen(trim($linestmp[$ii]))==0)
				{
					continue;
				}
				if(strstr(strtolower($linestmp[$ii]), "sudo /opt/freesvr/audit/passwd/sbin/freesvr-passwd"))
				{
					$change=1;
					if($chpwdservice){
						$linestmp[$ii]="$minute $hour $day * $week sudo /opt/freesvr/audit/passwd/sbin/freesvr-passwd -f\n";
					}else{
						$linestmp[$ii]="#$minute $hour $day * $week sudo /opt/freesvr/audit/passwd/sbin/freesvr-passwd\n";
					}
				}
				if(strstr(strtolower($linestmp[$ii]), "sudo /opt/freesvr/audit/sbin/listacct"))
				{
					$account=1;
					if($accountservice){
						$linestmp[$ii]="$uminute $uhour $uday * $uweek sudo /opt/freesvr/audit/sbin/listacct > /tmp/acct.log\n";
					}else{
						$linestmp[$ii]="#$uminute $uhour $uday * $uweek sudo /opt/freesvr/audit/sbin/listacct > /tmp/acct.log\n";
					}
				}
				if(strstr(strtolower($linestmp[$ii]), "sudo /home/wuxiaolong/5_backup/backup_csv.pl"))
				{
					$priority =1;
					if($uploadservice){
						$linestmp[$ii]="$pminute $phour $pday * $pweek sudo /home/wuxiaolong/5_backup/backup_csv.pl\n";
					}else{
						$linestmp[$ii]="#$pminute $phour $pday * $pweek sudo /home/wuxiaolong/5_backup/backup_csv.pl\n";
					}
				}
				if(strstr(strtolower($linestmp[$ii]), "sudo /home/wuxiaolong/5_backup/backup_passwd.pl"))
				{
					$pwd=1;
					if($pwduploadservice){
						$linestmp[$ii]="$puminute $puhour $puday * $puweek sudo /home/wuxiaolong/5_backup/backup_passwd.pl\n";
					}else{
						$linestmp[$ii]="#$puminute $puhour $puday * $puweek sudo /home/wuxiaolong/5_backup/backup_passwd.pl\n";
					}
				}
				//echo $linestmp[$ii];echo '<br>';
			}
			if($change==0){
				if($chpwdservice){
					$linestmp[$ii++]="$minute $hour $day * $week sudo /opt/freesvr/audit/passwd/sbin/freesvr-passwd -f\n";
				}else{
					$linestmp[$ii++]="#minute $hour $day * $week sudo /opt/freesvr/audit/passwd/sbin/freesvr-passwd\n";
				}
			}
			if($account==0){
				if($accountservice){
					$linestmp[$ii++]="$uminute $uhour $uday * $uweek sudo /opt/freesvr/audit/sbin/listacct > /tmp/acct.log\n";
				}else{
					$linestmp[$ii++]="#$uminute $uhour $uday * $uweek sudo /opt/freesvr/audit/sbin/listacct > /tmp/acct.log\n";
				}
			}
			if($priority==0){
				if($uploadservice){
					$linestmp[$ii++]="$pminute $phour $pday * $pweek sudo /home/wuxiaolong/5_backup/backup_csv.pl\n";
				}else{
					$linestmp[$ii++]="#$pminute $phour $pday * $pweek sudo /home/wuxiaolong/5_backup/backup_csv.pl\n";
				}
			}
			if($pwd==0){
				if($pwduploadservice){
					$linestmp[$ii++]="$puminute $puhour $puday * $puweek sudo /home/wuxiaolong/5_backup/backup_passwd.pl\n";
				}else{
					$linestmp[$ii++]="#$puminute $puhour $puday * $puweek sudo /home/wuxiaolong/5_backup/backup_passwd.pl\n";
				}
			}
			$this->Array2File($linestmp,$_CONFIG['NTPNAGIOS']);
			alert_and_back('修改成功', 'admin.php?controller=admin_pro&action=password_cron');
		}

		$linestmp = @file($_CONFIG['NTPNAGIOS']);		
		//echo '<pre>';print_r($linestmp);echo '</pre>';
		for($ii=0; $ii<count($linestmp); $ii++)
		{			
			if(strlen(trim($linestmp[$ii]))==0)
			{
				continue;
			}
			if(strstr(strtolower($linestmp[$ii]), "/opt/freesvr/audit/passwd/sbin/freesvr-passwd")){
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
			}elseif(strstr(strtolower($linestmp[$ii]), "/opt/freesvr/audit/sbin/listacct")){
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
			}elseif(strstr(strtolower($linestmp[$ii]), "/home/wuxiaolong/5_backup/backup_csv.pl")){
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
			}elseif(strstr(strtolower($linestmp[$ii]), "/home/wuxiaolong/5_backup/backup_passwd.pl")){
				if(substr($linestmp[$ii], 0, 1)=="#"){
					$pwduploadservice = 0;
				}else{
					$pwduploadservice = 1;
					$linestmp[$ii]=trim($linestmp[$ii]);
					$tmp = preg_split("/[\s]+/", $linestmp[$ii]);
					$this->assign("puminute", $tmp[0]);
					$this->assign("puhour", $tmp[1]);
					$this->assign("puday", $tmp[2]);
					$this->assign("puweek", $tmp[4]);
				}
			}
			$jj++;
		}
		$this->assign("uploadservice", $uploadservice);
		$this->assign("pwduploadservice", $pwduploadservice);
		$this->assign("chpwdservice", $chpwdservice);
		$this->assign("accountservice", $accountservice);
		$this->display('password_cron.tpl');
	}

	function showpwddownauth(){
		$this->display('pwddownauth.tpl');
	}

	function dopwddownauth(){
		global $_CONFIG;
		$password = htmlspecialchars_decode(get_request('password', 1, 1));
		$m = $this->member_set->select_all("username='admin'");
		if($this->member_set->udf_decrypt($m[0]['password'])==$password){
			$alldev = $this->devpass_set->base_select("SELECT devices.*,c.groupname,b.id serverid FROM ".$this->devpass_set->get_table_name()." devices LEFT JOIN ".$this->server_set->get_table_name()." b ON devices.device_ip=b.device_ip LEFT JOIN ".$this->sgroup_set->get_table_name()." c ON b.groupid=c.id ".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? (empty($_SESSION['ADMIN_MSERVERGROUP']) ? ' WHERE 0' : ' WHERE 1 AND  (b.groupid='.$_SESSION['ADMIN_MSERVERGROUP']." or b.groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") ") : '')." ORDER BY device_ip asc ");
			$alltem = $this->tem_set->select_all();
			$row_num = count($alldev);
			for($i=0;$i<$row_num;$i++) {
				foreach($alltem as $tem) {
					if($alldev[$i]['login_method'] == $tem['id']) {
						$alldev[$i]['login_method'] = $tem['login_method'];
					}
					elseif($alldev[$i]['device_type'] == $tem['id']) {
						$alldev[$i]['device_type'] = $tem['device_type'];
					}
				}
			}
			$str = language("设备IP").",".language("主机名").",".language("服务器组").",".language("用户名").",".language("登陆协议").",".language("当前密码").",".language("旧密码").",\n";
			$id=1;
			foreach ($alldev AS $report){
				$str .= $report['device_ip'].",".$report['hostname'].",".$report['groupname'].",".$report['username'].",".$report['login_method'].",".$this->member_set->udf_decrypt($report['cur_password']).",".$this->member_set->udf_decrypt($report['old_password']).",";
				$str .= "\n";
			}
			
			$str = iconv("UTF-8", "GBK", $str);
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=DevicesPassword.csv"); 
			echo $str;
			/*
			$filename = "tmp/".$_SESSION['ADMIN_UID']."_".time().".csv";
			$this->String2File(iconv("UTF-8", "GBK", $str), $filename);
			go_url($filename);*/
			exit();
		}else{
			echo '<script language=\'javascript\'>alert("密码不正确");</script>';
		}
		exit;
	}

	function dev_priority_search(){
		global $_CONFIG;
		$back = get_request('back');
		$derive = get_request('derive');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$ip = get_request('ip',1,1) ? get_request('ip',1,1) : get_request('ip',0,1);
		$s_user = get_request('s_user',1,1) ? get_request('s_user',1,1) : get_request('s_user',0,1);
		$user = get_request('user',1,1) ? get_request('user',1,1) : get_request('user',0,1);
		$type='luser';
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$where = "1";
		if($ip){
			$where .= " AND devices.device_ip like '%$ip%'";
		}
		if($s_user){
			$where .= " AND devices.username like '%$s_user%'";
		}
		if($user){
			$where .= " AND member.username like '%$user%'";
		}

		if($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$alltmpip=array(0);
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
					$where .= " AND devices.device_ip IN ('".implode("','", $alltmpip)."')";
				}else{
					$alltmpuser=array(0);
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND member.username IN ('".implode("','", $alltmpuser)."')";
				}
			}
		}
		
		$sql  = "select SQL_CALC_FOUND_ROWS tt.*,sg.groupname,s.hostname,lt.login_method from (select distinct 1 orderby,0 resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,luser.devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,luser.forbidden_commands_groups,luser.weektime,luser.sourceip,luser.autosu,luser.syslogalert,luser.mailalert,luser.loginlock from luser left join member on luser.memberid=member.uid left join devices on luser.devicesid=devices.id where member.uid and luser.devicesid AND $where";		
		$sql .= " union select distinct 2 orderby, a.resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
		$sql .= " union select distinct 2 orderby, a.resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,devices.id devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where";
		$sql .= " union select distinct 3 orderby, 0, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,lgroup.devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,lgroup.forbidden_commands_groups,lgroup.weektime,lgroup.sourceip,lgroup.autosu,lgroup.syslogalert,lgroup.mailalert,lgroup.loginlock from lgroup left join member on lgroup.groupid=member.groupid left join devices on lgroup.devicesid=devices.id where member.uid and lgroup.devicesid AND $where";
		$sql .= " union select distinct 4 orderby, a.resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where ";
		$sql .= " union select distinct 4 orderby, a.resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,devices.id devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where ";
		$sql .= ") tt left join login_template lt on tt.lmethod=lt.id left join servers s on tt.device_ip=s.device_ip left join servergroup sg on sg.id=s.groupid group by tt.uid,tt.devicesid";
		
		if($derive==1){
			$reports = $this->server_set->base_select($sql);
			//$reports=$this->systempriority_data($reports);
			$str = language("序号")."\t".(($type == 'luser') ? '运维账号'."\t".'别名' : '运维组')."\t".language("设备IP")."\t".language("系统用户")." \t".language("黑名单")." \t".language("周组策略 ")." \t".language("来源IP")." \t".language("自动为超级用户")." \t".language("SYSLOG告警")." \t".language("Mail告警")." \t".language("账号锁定")."\t".(($type == 'luser') ? '上次登录'." \t" : '').language("协议")."\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){
				$str .= ($id++)."\t".(($type == 'luser') ? $report['webuser']."\t".$report['webrealname'] :$report['gname'])."\t".$report['device_ip'].'('.$report['hostname'].')'."\t".$report['username']."\t".$report['forbidden_commands_groups']."\t".$report['policyname']."\t".$report['sourceip']."\t".($report['autosu'] ? '是' : '否')."\t".($report['syslogalert'] ? '是' : '否')."\t".($report['mailalert'] ? '是' : '否')."\t".($report['loginlock'] ? '是' : '否')."\t".(($type == 'luser') ? $report['lastdate']." \t" : '').$report['login_method'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemPriorityReport.xls"); 
			echo iconv("UTF-8", "GBK", $str);
			exit();
		}else if($derive==4){
			$reports = $this->sessions_set->base_select($sql);
			//$reports=$this->systempriority_data($reports);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维账号'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','设备IP'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','黑名单'), iconv('UTF-8','GBK','周组策略'), iconv('UTF-8','GBK','来源IP'), iconv('UTF-8','GBK','自动为超级用户'), iconv('UTF-8','GBK','SYSLOG告警'), iconv('UTF-8','GBK','Mail告警'), iconv('UTF-8','GBK','账号锁定'), iconv('UTF-8','GBK','上次登录'), iconv('UTF-8','GBK','协议'));
			$w = array(10, 14, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 14);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, iconv('UTF-8','GBK',$report['webuser']), iconv('UTF-8','GBK',$report['webrealname']), iconv('UTF-8','GBK',$report['device_ip'].'('.$report['hostname'].')'), iconv('UTF-8','GBK',$report['username']), iconv('UTF-8','GBK',$report['forbidden_commands_groups']), iconv('UTF-8','GBK',$report['policyname']), iconv('UTF-8','GBK',$report['sourceip']), iconv('UTF-8','GBK',($report['autosu'] ? '是' : '否')), iconv('UTF-8','GBK',($report['syslogalert'] ? '是' : '否')), iconv('UTF-8','GBK',($report['mailalert'] ? '是' : '否')), iconv('UTF-8','GBK',($report['loginlock'] ? '是' : '否')), iconv('UTF-8','GBK',$report['lastdate']), iconv('UTF-8','GBK',$report['login_method'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			//$reports=$this->systempriority_data($reports);
			ob_start();
			$this->assign('alldev', $reports);
			$this->assign('type', $type);
			$this->assign('ip', $ip);
			$this->assign('s_user', $s_user);
			$this->assign('user', $user);
			$this->assign('group', $group);
			$this->display('systempriority_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemPriorityReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			//$reports=$this->systempriority_data($reports);
			ob_start();$this->assign('alldev', $reports);
			$this->assign('type', $type);
			$this->assign('ip', $ip);
			$this->assign('s_user', $s_user);
			$this->assign('user', $user);
			$this->assign('group', $group);
			$this->display('systempriority_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=SystemPriorityReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
		
		/*if($page_num==1||empty($page_num)){
			$row_num = $this->server_set->base_select("select count(*) ct FROM ($sql)t");
			$_SESSION['dev_priority_search_num']=$row_num = $row_num[0]['ct'];
		}
		else
			$row_num = $_SESSION['dev_priority_search_num'];*/
		if($page_num==1||empty($page_num)){
			$row_num=10000000;
		}elseif($_SESSION['dev_priority_search_num']){
			$row_num = $_SESSION['dev_priority_search_num'];
		}
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " ORDER BY $orderby1 $orderby2, device_ip ASC, username ASC, webuser ASC LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$alldev = $this->server_set->base_select($sql);
		$_rows = $this->server_set->base_select("SELECT FOUND_ROWS() row_num");
		$_SESSION['dev_priority_search_num']=$row_num = $_rows[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		//$alldev=$this->systempriority_data($alldev);
		
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		//echo '<pre>';print_r($alldev);echo '</pre>';
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('type', $type);
		$this->assign('curr_url', $curr_url);
		$this->assign('ip', $ip);
		$this->assign('s_user', $s_user);
		$this->assign('user', $user);
		$this->assign('group', $group);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('dev_priority_search.tpl');
	}

	function systempriority_data($alldev){
		$num = count($alldev);
		$lm = $this->tem_set->select_all();		
		for($i=0; $i<$num; $i++){
			foreach($lm as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}elseif($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}
			}
			
			$rowsql = "select 1 orderby,a.memberid,0 groupid,a.devicesid,0 resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from luser a where memberid=".$alldev[$i]['uid']." AND devicesid=".$alldev[$i]['devicesid'];	
			$rowsql .= " UNION select 2 orderby,a.memberid,0,0,a.resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['devicesid'].") t on a.resourceid=t.id left join member on a.memberid=member.uid where t.id and member.uid=".$alldev[$i]['uid']." and t.devicesid";
			$rowsql .= " UNION select 2 orderby,a.memberid,0,0,a.resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.memberid=".$alldev[$i]['uid']." AND devices.id=".$alldev[$i]['devicesid'];
			$rowsql .= " UNION select 3 orderby,0,a.groupid,a.devicesid,0,a.forbidden_commands_groups,a.sourceip,a.weektime from lgroup a where groupid=".$alldev[$i]['groupid']." AND devicesid=".$alldev[$i]['devicesid'];
			$rowsql .= " UNION select 4 orderby,0,a.groupid,0,a.resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['devicesid'].") t on a.resourceid=t.id left join member on a.groupid=member.groupid where t.id and member.uid=".$alldev[$i]['uid']." and t.devicesid";
			$rowsql .= " UNION select 4 orderby,0,a.groupid,0,a.resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$alldev[$i]['groupid']." AND devices.id=".$alldev[$i]['devicesid'];
			$rowsql .= " order by orderby asc limit 1";
			$row = $this->luser_set->base_select($rowsql);
			/*if($row = $this->luser_set->select_all(" memberid=".$alldev[$i]['uid']." AND devicesid=".$alldev[$i]['devicesid'])){
				$alldev[$i]['orderby'] = 1;
			}else if($row = $this->luser_set->base_select("select a.* from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['devicesid'].") t on a.resourceid=t.id left join member on a.memberid=member.uid where t.id and member.uid=".$alldev[$i]['uid']." and t.devicesid")){
				$alldev[$i]['orderby'] = 2;
			}else if($row = $this->luser_set->base_select("select a.* from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.memberid=".$alldev[$i]['uid']." AND devices.id=".$alldev[$i]['devicesid']."")){
				$alldev[$i]['orderby'] = 2;
			}else if($row = $this->lgroup_set->select_all(" groupid=".$alldev[$i]['groupid']." AND devicesid=".$alldev[$i]['devicesid'])){
				$alldev[$i]['orderby'] = 3;
			}else if($row = $this->luser_set->base_select("select a.* from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['devicesid'].") t on a.resourceid=t.id left join member on a.groupid=member.groupid where t.id and member.uid=".$alldev[$i]['uid']." and t.devicesid")){
				$alldev[$i]['orderby'] = 4;
			}else if($row = $this->luser_set->base_select("select a.* from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$alldev[$i]['groupid']." AND devices.id=".$alldev[$i]['devicesid']."")){
				$alldev[$i]['orderby'] = 4;
			}*/
			if(is_array($row[0]))
			$alldev[$i] = array_merge($alldev[$i], $row[0]);
			//var_dump($alldev[$i]);echo '<br>';echo '<br>';
		}
		return $alldev;
	}
	
	function app_priority_search(){
		global $_CONFIG;
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$device_ip = get_request('device_ip',1,1) ? get_request('device_ip',1,1) : get_request('device_ip',0,1);
		$appserverip = get_request('appserverip',1,1) ? get_request('appserverip',1,1) : get_request('appserverip',0,1);
		$s_user = get_request('s_user',1,1) ? get_request('s_user',1,1) : get_request('s_user',0,1);
		$user = get_request('user',1,1) ? get_request('user',1,1) : get_request('user',0,1);
		$group = get_request('group',1,1) ? get_request('group',1,1) : get_request('group',0,1);
		$appname = get_request('appname',1,1) ? get_request('appname',1,1) : get_request('appname',0,1);
		$type = get_request('type', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'appserverip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$where = "1";

		if(empty($type)){
			$type='luser';
		}
		if($device_ip != '') {
			$where .= " AND appdevices.device_ip LIKE '%$device_ip%'";
		}

		if($appname != '') {
			$where .= " AND pub.name LIKE '%$appname%'";
		}
		if($s_user != '') {
			$where .= " AND username= '$s_user'";
		}
		if($user != '') {				
			$member = $this->member_set->select_all(" username='".$user."'");
			$member = $member[0];
			if(empty($member)){
				alert_and_back('该用户不存在 ','admin.php?controller=admin_pro&action=app_priority_search');
				exit;
			}
			$where .= " AND member.uid=".$member['uid'];
		}
		if($appserverip != '') {
			$where .= " AND apppub.appserverip LIKE '%$appserverip%'";
		}

		if($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$alltmpip = array(0);
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
					if($alltmpip)
					$where .= "  AND appdevices.device_ip IN ('".implode("','", $alltmpip)."')";
				}else{
					$alltmpuser = array(0);
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND member.username IN ('".implode("','", $alltmpuser)."')";
				}
			}
		}

		$sql  = "select SQL_CALC_FOUND_ROWS distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,appmember.appdeviceid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.apppubid,appdevices.device_ip from appmember left join member on appmember.memberid=member.uid left join appdevices on appmember.appdeviceid=appdevices.id left join apppub on appdevices.apppubid=apppub.id where member.uid and appmember.appdeviceid AND $where";		
		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.appdevicesid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.apppubid,appdevices.device_ip from luser_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid>0 ) t on a.appresourceid=t.id left join member on a.memberid=member.uid left join appdevices on t.appdevicesid=appdevices.id left join apppub on appdevices.apppubid=apppub.id where t.id and member.uid and t.appdevicesid AND $where";

		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,appdevices.id appdeviceid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.apppubid,appdevices.device_ip from luser_appresourcegrp a left join (select a.id,b.groupid,b.username from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid  left join member on a.memberid=member.uid left join appdevices on s.device_ip=appdevices.device_ip left join apppub on appdevices.apppubid=apppub.id where t.id and appdevices.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) AND $where";

		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,appgroup.appdeviceid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.apppubid,appdevices.device_ip from appgroup left join member on appgroup.groupid=member.groupid left join appdevices on appgroup.appdeviceid=appdevices.id left join apppub on appdevices.apppubid=apppub.id where member.uid and appgroup.appdeviceid AND $where";
		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.appdevicesid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.apppubid,appdevices.device_ip from lgroup_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid>0 ) t on a.appresourceid=t.id left join member on a.groupid=member.groupid left join appdevices on t.appdevicesid=appdevices.id left join apppub on appdevices.apppubid=apppub.id where t.id and member.uid and t.appdevicesid AND $where";

		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,appdevices.id appdeviceid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.apppubid,appdevices.device_ip from lgroup_appresourcegrp a left join (select a.id,b.groupid,b.username from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid  left join member on a.groupid=member.groupid left join appdevices on s.device_ip=appdevices.device_ip left join apppub on appdevices.apppubid=apppub.id where t.id and appdevices.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) AND $where";

		if($page_num==1||empty($page_num)){
			$row_num=10000000;
		}elseif($_SESSION['app_priority_search_num']){
			$row_num = $_SESSION['app_priority_search_num'];
		}
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " ORDER BY $orderby1 $orderby2, appserverip ASC, username ASC, webuser ASC LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$alldev = $this->server_set->base_select($sql);
		$_rows = $this->server_set->base_select("SELECT FOUND_ROWS() row_num");
		$_SESSION['app_priority_search_num']=$row_num = $_rows[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev=$this->apppriority_data($alldev);

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		//echo '<pre>';print_r($alldev);echo '</pre>';
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('type', $type);
		$this->assign('ip', $ip);
		$this->assign('s_user', $s_user);
		$this->assign('user', $user);
		$this->assign('curr_url', $curr_url);
		$this->assign('group', $group);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('app_priority_search.tpl');
	}

	function apppriority_data($alldev){
		$num = count($alldev);
		for($i=0; $i<$num; $i++){
			$rowsql = "select 1 orderby,a.memberid,0 groupid,a.appdeviceid,0 appresourceid from appmember a where memberid=".$alldev[$i]['uid']." AND appdeviceid=".$alldev[$i]['appdeviceid'];			
			$rowsql .= " UNION select 2 orderby,a.memberid,0 groupid,0,a.appresourceid from luser_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 AND b.appdevicesid=".$alldev[$i]['appdeviceid'].") t on a.appresourceid=t.id left join member on a.memberid=member.uid where t.id and member.uid=".$alldev[$i]['uid']." and t.appdevicesid";
			$rowsql .= " UNION select 2 orderby,a.memberid,0 groupid,0,a.appresourceid from ".$this->luser_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.memberid=".$alldev[$i]['uid']." AND appdevices.id=".$alldev[$i]['appdeviceid'];
			$rowsql .= " UNION select 3 orderby,0,a.groupid ,a.appdeviceid,0 appresourceid from appgroup a where groupid=".$alldev[$i]['groupid']." AND appdeviceid=".$alldev[$i]['appdeviceid'];
			$rowsql .= " UNION select 4 orderby,0,a.groupid ,0,a.appresourceid from lgroup_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 AND b.appdevicesid=".$alldev[$i]['appdeviceid'].") t on a.appresourceid=t.id left join member on a.groupid=member.groupid where t.id and member.uid=".$alldev[$i]['uid']." and t.appdevicesid";
			$rowsql .= " UNION select 4 orderby,0,a.groupid ,0,a.appresourceid from ".$this->lgroup_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.groupid=".$alldev[$i]['groupid']." AND appdevices.id=".$alldev[$i]['appdeviceid'];
			$rowsql .= " order by orderby asc limit 1";
			$row = $this->appmember_set->base_select($rowsql);
			/*if($alldev[$i]['groupid']){
				$usergroup = $this->usergroup_set->select_by_id($alldev[$i]['groupid']);
				$alldev[$i]['usergroup'] = $usergroup['GroupName'];
			}
			if($row = $this->appmember_set->select_all(" memberid=".$alldev[$i]['uid']." AND appdeviceid=".$alldev[$i]['appdeviceid'])){
				$alldev[$i]['orderby']=1;
			}else if($row = $this->appmember_set->base_select("select a.* from luser_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 AND b.appdevicesid=".$alldev[$i]['appdeviceid'].") t on a.appresourceid=t.id left join member on a.memberid=member.uid where t.id and member.uid=".$alldev[$i]['uid']." and t.appdevicesid")){				
				$alldev[$i]['orderby']=2;
			}else if($row = $this->luser_set->base_select("select a.* from ".$this->luser_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.memberid=".$alldev[$i]['uid']." AND appdevices.id=".$alldev[$i]['appdeviceid']."")){
				$alldev[$i]['orderby'] = 2;
			}else if($row = $this->appgroup_set->select_all(" groupid=".$alldev[$i]['groupid']." AND appdeviceid=".$alldev[$i]['appdeviceid'])){
				$alldev[$i]['orderby']=3;
			}else if($row = $this->appmember_set->base_select("select a.* from lgroup_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 AND b.appdevicesid=".$alldev[$i]['appdeviceid'].") t on a.appresourceid=t.id left join member on a.groupid=member.groupid where t.id and member.uid=".$alldev[$i]['uid']." and t.appdevicesid")){
				$alldev[$i]['orderby']=4;
			}else if($row = $this->luser_set->base_select("select a.* from ".$this->lgroup_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.groupid=".$alldev[$i]['groupid']." AND appdevices.id=".$alldev[$i]['appdeviceid']."")){
				$alldev[$i]['orderby'] = 4;
			}*/
			if(is_array($row[0]))
			$alldev[$i] = array_merge($alldev[$i], $row[0]);
			//var_dump($alldev[$i]);echo '<br>';echo '<br>';
		}
		return $alldev;
	}

	function sshpublickey() {
		$page_num = get_request('page');
		$this->assign('title', 'SSH公钥'.language("列表"));
		
		$row_num = $this->sshpublickey_set->select_count('memberid='.$_SESSION['ADMIN_UID']);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		//$allkeys = $key_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);
		$allkeys = $this->sshpublickey_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, 'memberid='.$_SESSION['ADMIN_UID']);

		$this->assign('allkeys', $allkeys);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('sshpublickey_list.tpl');
	}
	
	
	function importsshpublickey(){
		$this->display("importsshpublickey.tpl");
	}
	
	function dosshpublickey(){
		global $_CONFIG;
		//var_dump($_FILES);
		if($_FILES['publickey']['error']==1 or $_FILES['publickey']['error']==2){
			alert_and_back("上传得文件超过系统限制");
			exit;
		}
		if(!is_uploaded_file($_FILES['publickey']['tmp_name']))
		{
			alert_and_back("请上传公钥文件");
			exit;
		}
		if($_FILES['privatekey']['error']==1 or $_FILES['privatekey']['error']==2){
			alert_and_back("上传得文件超过系统限制");
			exit;
		}
		if(!is_uploaded_file($_FILES['privatekey']['tmp_name']))
		{
			alert_and_back("请上传私钥文件");
			exit;
		}
		$publickeylines = file($_FILES['publickey']['tmp_name']);
		if(count($publickeylines)>1){
			alert_and_back("公钥文件行数应该为1");
			exit;
		}
		
		if($_FILES['privatekey']['size']>3096){
			alert_and_back("私钥文件超过3KB");
			exit;
		}
		if($_FILES['publickey']['size']>512){
			alert_and_back("公钥文件超过0.5KB");
			exit;
		}
				
		$filename = $_CONFIG['SSHPUBLICKEY'];
		$lines = file($filename);
		//var_dump($lines);
		if(in_array($publickeylines[0], $lines)){
			alert_and_back( "文件内容已经存在");
			exit;
		}

		if ($handle = opendir($_CONFIG['SSHPRIVATEKEYDIR'])) {
			$found = 0;
			/* 这是正确地遍历目录方法 */
			while (false !== ($file = readdir($handle))) {
				if($_FILES['privatekey']['name']==$file){
					alert_and_back("私钥文件名存在");
					exit;
				}
			}
			
			$newfile = $_CONFIG['SSHPRIVATEKEYDIR'].'/'.$_FILES['privatekey']['name'];
			if(!move_uploaded_file($_FILES['privatekey']['tmp_name'],$newfile)){
				alert_and_back("移动私钥文件失败");
				exit;
			}
			closedir($handle);
		}
		
		if (is_writable($filename)) {	    
		    if (!$handle = fopen($filename, 'a+')) {
				@unlinke($newfile);
		         alert_and_back( "不能打开文件 $filename");
		         exit;
		    }
		    if (fwrite($handle, $publickeylines[0]."\n") === FALSE) {
				@unlinke($newfile);
		        alert_and_back( "不能写入到文件 $filename");
		        exit;
		    }		
		    fclose($handle);
	
		} else {
			@unlinke($newfile);
		    alert_and_back("文件 $filename 不可写");
		    exit;
		}

		
		$line = count(file($filename));
		//print_r($lines);
		$sshpublickey = new sshpublickey();
		$sshpublickey->set_data('line', $line);
		$sshpublickey->set_data('privatekey', $newfile);
		$sshpublickey->set_data('memberid', $_SESSION['ADMIN_UID']);
		$this->sshpublickey_set->add($sshpublickey);
		
		alert_and_back('导入成功', "admin.php?controller=admin_pro&action=sshpublickey");
	}
	
	function sshkeys_delete(){
		global $_CONFIG;
		$id = get_request('id');
		global $_CONFIG;
		$info = $this->sshpublickey_set->select_by_id($id);
		$lines = @file($_CONFIG['SSHPUBLICKEY']);
		for($i=$info['line']-1; $i>0; $i--){
			$lines[$i]=$lines[$i-1];
		}
		array_shift($lines);
		$b=$this->Array2File($lines, $_CONFIG['SSHPUBLICKEY']);
		if(!$b){
			exit;
		}
		$this->sshpublickey_set->delete($id);
		@unlink($info['privatekey']);
		$this->sshpublickey_set->query('UPDATE sshpublickey SET line=line-1 WHERE line>'.$info['line']);
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=sshpublickey');
		exit;
	}
	
	
	function resource_group($interface=false) {
		global $_CONFIG;
		$back = get_request('back');
		if($back){
			//if(strpos($_SERVER['HTTP_REFERER'], 'devgroup_edit')>0)
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$groupname = get_request('groupname', 0, 1);
		$username = get_request('username', 0, 1);
		$groupid = get_request('group', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'groupname';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$where = 'devicesid=0';
		$this->resgroup_set->query("delete from luser_resourcegrp where resourceid not in(select id from resourcegroup where devicesid=0)");
		$this->resgroup_set->query("delete from lgroup_resourcegrp where resourceid not in(select id from resourcegroup where devicesid=0)");
		$groupidname = 'agroupid';
		require_once('./include/select_sgroup_ajax.inc.php');

		$tmpgroup = $this->resgroup_set->select_all($where);
		for($i=0; $i<count($tmpgroup); $i++){
			$_tmpgroup[] = $tmpgroup[$i]['groupname'];
		}
		if($_tmpgroup){
			$this->resgroup_set->delete_all(" groupname NOT IN('".implode("','", $_tmpgroup)."')");
		}
		
		if($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			$where .= ' AND user="'.$_SESSION['ADMIN_USERNAME'].'"';
		}
		if(!empty($groupname)){
			$where .= " AND groupname like '%".$groupname."%'";
		}		
		if($username){
			$where .= ' AND id IN(select resourceid FROM '.$this->luser_resourcegrp_set->get_table_name().' WHERE memberid='.$username.' UNION select resourceid FROM '.$this->lgroup_resourcegrp_set->get_table_name().' WHERE groupid=(select groupid from '.$this->member_set->get_table_name().' where uid='.intval($username).'))';
		}elseif($groupid){
			$where .= ' AND id IN(select resourceid FROM '.$this->lgroup_resourcegrp_set->get_table_name().' WHERE groupid IN('.$groupid.'))';
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$row_num = $this->resgroup_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->resgroup_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		if($interface){
			return $alldev;
		}
		$groups = $this->sgroup_set->select_all("attribute!=2", 'groupname', 'asc');
		$users = $this->member_set->select_all("1", 'username', 'asc');
		$this->assign('title', language('资源组列表'));
		$this->assign('alldev', $alldev);
		$this->assign('groups', $groups);
		$this->assign('users', $users);
		$this->assign('username', $username);
		$this->assign('group', $group);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('resource_group_index.tpl');
	}
	
	function userresource_group() {
		$page_num = get_request('page');
		$where = 'devicesid=0 AND id IN(SELECT resourceid FROM '.$this->luser_resourcegrp_set->get_table_name().' WHERE memberid='.$_SESSION['ADMIN_UID'].' )';
	
		$row_num = $this->resgroup_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->resgroup_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, 'gname', 'ASC');

		$this->assign('title', language('资源组组列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('userresource_group_index.tpl');
	}
	
	function resource_group_edit() {
		global $_CONFIG;
		$uid = get_request('uid');
		$gname = get_request('gname',0,1);
		$desc = get_request('desc',0,1);
		$hostname = get_request('hostname',0,1);
		$username = get_request('username',0,1);
		$lm = get_request('lm');
		$groupid = get_request('groupid');
		$ldapid1 = get_request('ldapid1');
		$ldapid2 = get_request('ldapid2');
		$ip = get_request('ip', 0, 1);
		$where = '1=1';
		
		if($ip){
			$where .= " AND s.device_ip like '%$ip%'";
		}
		if($hostname){
			$where .= " AND s.hostname like '%$hostname%'";
		}if($username){
			$where .= " AND d.username like '%$username%'";
		}
		
		
		$uinfo = $this->member_set->select_by_id($uid);
		$allmethod =  $this->tem_set->select_all("device_type = ''",'','ASC');	
		//$res = $this->resgroup_set->select_all("groupname='$gname' and devicesid!=0");
		
		$res = $this->devpass_set->base_select("SELECT d.* FROM servers d LEFT JOIN (SELECT distinct device_ip FROM ".$this->devpass_set->get_table_name()." WHERE username='".$uinfo['username']."') t ON d.device_ip=t.device_ip WHERE 1 AND t.device_ip IS NOT NULL AND d.id IS NOT NULL ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).'))' : '')." ORDER BY device_ip");

		
		require_once('./include/select_sgroup_ajax.inc.php');
		if($ori_g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_all("id IN(".(is_array($ori_g_id)?implode(',', $ori_g_id): $ori_g_id).")");
			$__tmpgid = $ori_g_id;
			for($i=0; $i<count($_tmpgid); $i++){
				$__tmpgid .= ','.$_tmpgid[$i]['child'];
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$__tmpgid.")");
				for($i=0; $i<count($allips); $i++){
					$cronreport_alltmpip[]=$allips[$i]['device_ip'];
				}
			}
			$where .= ' AND s.groupid IN('.$__tmpgid.')';
		}

		//$resources = $this->devpass_set->base_select("SELECT d.*,l.login_method lmname,if(entrust_password=1,'托密','不托密') as ep FROM devices d LEFT JOIN (SELECT distinct devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname='".$ginfo['groupname']."' and devicesid!=0) t ON d.id=t.devicesid LEFT JOIN login_template l ON d.login_method=l.id LEFT JOIN (SELECT * FROM servers WHERE 1 ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).')) )' : '').")s ON d.device_ip=s.device_ip  WHERE $where AND t.devicesid IS NULL AND s.id IS NOT NULL AND NOT EXISTS(SELECT id FROM ".$this->resgroup_set->get_table_name()." WHERE groupid=s.groupid AND IF(username='0', 1, username=d.username))"." ORDER BY device_ip");
		$resources = $this->devpass_set->base_select("SELECT d.* FROM servers d LEFT JOIN (SELECT distinct device_ip FROM ".$this->devpass_set->get_table_name()." WHERE username='".$uinfo['username']."') t ON d.device_ip=t.device_ip  WHERE 1 AND t.device_ip IS NULL AND d.id IS NOT NULL ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).'))' : '')." ORDER BY device_ip");

		$login_method = $this->tem_set->select_all();
		$where = "attribute!=1";
		if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			if($_SESSION['ADMIN_MSERVERGROUP']){
				$where .= " AND id IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") ";
			}else{
				$where .= " AND 0";
			}
		}
		//$allgroup = $this->sgroup_set->select_all($where,'groupname', 'asc');
		//echo '<pre>';print_r($resources);echo '</pre>';
		if($gname) $ginfo['groupname']=$gname;
		if($desc) $ginfo['desc']=$desc;
		$this->assign("res", $res);
		$this->assign("res2", $res2);
		$this->assign("resource", $resources);
		$this->assign("uinfo", $uinfo);
		$this->assign("groupid", intval($groupid));
		//$this->assign("allgroup", $allgroup);
		$this->assign("allmethod", $allmethod);
		$this->assign("ip", $ip);
		$this->assign("hostname", $hostname);
		$this->assign("username", $username);
		$this->assign("lm", $lm);
		$this->assign("gname", $gname);
		$this->assign("_config", $_CONFIG);
		$this->resourcegroup_bind(1);
		$this->display('resource_group_edit.tpl');
	}
	
	
	function resource_group_save($interface=false) {
		$gname = get_request('gname', 1, 1);
		$desc = get_request('desc', 1, 1);
		$oldgname = get_request('oldgname', 1, 1);
		$createuser = get_request('createuser', 1, 1);
		$uid = get_request("uid",1,0);
		$selected = get_request('secend', 1, 1);
		$groupid = get_request('groupid', 1, 1);
		$sessionluser = get_request('sessionluser', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		$where = "1=1";

		$user = $this->member_set->select_by_id($uid);
		for($i=0; $i<count($_POST['secend']); $i++){
			$selected_arr = explode('_', $_POST['secend'][$i]);
			if($selected_arr[0]=='groupid'){
				$_tmpgid = $this->sgroup_set->select_by_id($selected_arr[1]);
				$_servers = $this->server_set->select_all("groupid IN(".$_tmpgid['child'].")");
				for($j=0; $j<count($_servers); $j++){
					$_POST['secend'][]=$_servers[$j]['id'];
				}
			}else{
				$device = $this->server_set->select_by_id($_POST['secend'][$i]);
				if($device&&$this->devpass_set->select_count("device_ip='".$device['device_ip']."' and username='".$user['username']."'")==0){
					$new_pass = new devpass();
					$new_pass->set_data('device_ip',$device['device_ip']);
					$new_pass->set_data('hostname',$device['hostname']);
					$new_pass->set_data('device_type',$device['device_type']);
					$new_pass->set_data('username',$user['username']);
					$this->devpass_set->add($new_pass);
					$adminlog = new admin_log();	
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
					$adminlog->set_data('action', language('修改系统用户'));
					$adminlog->set_data('resource', $ip);
					$adminlog->set_data('resource_user', empty($new_name) ? '空用户' : $new_name);
					$adminlog->set_data('type', 13);
					$this->admin_log_set->add($adminlog);
				}
			}
			
			
		}	
		alert_and_back("操作成功".$msg,'admin.php?controller=admin_member&back=1');
		return $gid;
	}

	function resource_group_import(){
		$this->display("resourcegroupimport.tpl");
	}

	function resource_group_doimport(){		
		setlocale(LC_ALL, 'zh_CN');
		global $_CONFIG;
		if(is_uploaded_file($_FILES['devfile']['tmp_name']))
		{
			if($_FILES['devfile']['error']==1 or $_FILES['devfile']['error']==2){
				alert_and_back("上传得文件超过系统限制");
				exit;
			}
			//echo $_FILES['devfile']['tmp_name'];
			
			if (($handle = fopen($_FILES['devfile']['tmp_name'], "r")) !== FALSE) {
				while(($lines[] = fgetcsv($handle))!==false);
			}else{
				alert_and_back("打开文件失败");
				exit;
			}
			//var_dump($lines);
			/*if(iconv("GBK", "UTF-8", trim($lines[0][0]))!='主机名' || iconv("GBK", "UTF-8", trim($lines[0][1]))!='IP' || iconv("GBK", "UTF-8", trim($lines[0][2]))!='服务器组' || iconv("GBK", "UTF-8", trim($lines[0][3]))!='系统类型'|| iconv("GBK", "UTF-8", trim($lines[0][4]))!='系统用户'){
				alert_and_back("文件有问题，请上传正确的文件");
				exit;
			}*/
			//echo '<pre>';print_r($lines);echo '</pre>';exit;
			$importfile = $_CONFIG['IMPORTFILEPATH'].'/'.time().'.'.$_FILES['devfile']['name'];
			if(move_uploaded_file($_FILES['devfile']['tmp_name'], $importfile)){
				$importlog = new importlog();
				$importlog->set_data('file', $importfile);
				$importlog->set_data('type', 'resourcegroup');
				$this->importlog_set->add($importlog);
			}else{
				//echo '<script language=\'javascript\'>导入文件备份失败，请联系管理员</script>';
			}
			$j=0;
			for($i=1; $i<count($lines); $i++){
				if(empty($lines[$i])){
					continue;
				}
				$linearr = $lines[$i];	//var_dump($linearr);
				for($ii=0; $ii<count($linearr); $ii++){
					$linearr[$ii]=iconv("GBK", "UTF-8", $linearr[$ii]);
				}//var_dump($linearr);
				$device_ip=trim($linearr[0]);
				$username=trim($linearr[1]);
				if($username=='空用户'){
					$username = '';
				}
				$login_method=trim($linearr[2]);
				$port=trim($linearr[3]);
				$gname=trim($linearr[4]);
				$sgroupname=trim($linearr[5]);
				$sgusername=trim($linearr[6]);
				if(empty($gname)){
					continue;
				}
				if(preg_match("/[\\r\\n]/", $device_ip)||preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $lmethod)||preg_match("/[\\r\\n]/", $port)){
					$error[]=$device_ip.':'.'用户信息中含有回车符'.'\n';
					continue;
				}
				$group_exist = $this->resgroup_set->select_count("groupname='$gname'");
				if($group_exist<=0){
					$resourcegroup = new resgroup();
					if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
						$resourcegroup->set_data('user',$_SESSION['ADMIN_USERNAME']);
					}
					$resourcegroup->set_data('groupname',$gname);
					$resourcegroup->set_data('devicesid',0);
					$resourcegroup->set_data('user',$_SESSION['ADMIN_USERNAME']);
					$this->resgroup_set->add($resourcegroup);
					unset($resourcegroup);
				}

				if(!empty($sgroupname)){
					if(strpos($sgroupname,'((')===false){
						if($this->sgroup_set->select_count("groupname='".$sgroupname."'")>1){
							$error[]=$gname.' '.($sgroupname).' '.':'.'有重复组请输入组ID';
							continue;
						}
						$_group = $this->sgroup_set->select_all("groupname='".$sgroupname."'");
						$groupid=$_group[0]['id'];
					}else{				
						$groupid=substr($sgroupname, strpos($sgroupname,'((')+2, strpos($sgroupname,'))')-strpos($sgroupname,'((')-2);
					}
					$group = $this->usergroup_set->select_by_id($groupid);
					if(empty($group)){
						$error[]='资源组'.$groupid.'不存在';
						continue;
					}
					$dev = $this->resgroup_set->select_all("devicesid=-1 and groupid='$groupid' and username='$sgusername' and groupname='$gname'");
					if(empty($dev)){
						$resourcegroup = new resgroup();
						$resourcegroup->set_data('groupname',$gname);
						$resourcegroup->set_data('devicesid',-1);
						$resourcegroup->set_data('groupid',$groupid);
						$resourcegroup->set_data('username',$sgusername);
						$resourcegroup->set_data('user',$_SESSION['ADMIN_USERNAME']);
						$this->resgroup_set->add($resourcegroup);
					}
					continue;
				}

				$alltem = $this->tem_set->select_all();
				$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
				foreach($alltem as $tem) {
					if($login_method&&strtolower($login_method) == strtolower($tem['login_method'])) {
						$login_method = $tem['id'];
					}
				}
				
				
				//echo "device_ip='$device_ip' and login_method='$login_method' and username='$username' and port='$port'";
				if(empty($login_method)&&empty($username)&&empty($port)){
					$dev = $this->devpass_set->select_all("device_ip='$device_ip'");
					for($m=0; $m<count($dev); $m++){						
						$resourcegroup = new resgroup();
						$resourcegroup->set_data('groupname',$gname);
						$resourcegroup->set_data('devicesid',$dev[$m]['id']);
						$resourcegroup->set_data('user',$_SESSION['ADMIN_USERNAME']);
						$this->resgroup_set->add($resourcegroup);
						unset($resourcegroup);
					}
				}elseif($device_ip){
					$dev = $this->devpass_set->select_all("device_ip='$device_ip' and login_method='$login_method' and username='$username' and port='$port'");
					if($dev){
						$resourcegroup = new resgroup();
						$resourcegroup->set_data('groupname',$gname);
						$resourcegroup->set_data('devicesid',$dev[0]['id']);
						$resourcegroup->set_data('user',$_SESSION['ADMIN_USERNAME']);
						if($this->resgroup_set->select_count("groupname='".$gname."' AND devicesid='".$dev[0]['id']."' AND user='".$_SESSION['ADMIN_USERNAME']."'")>0)
							continue;
						$this->resgroup_set->add($resourcegroup);
						unset($resourcegroup);
					}
				}
			}
		}else{
			alert_and_back("请上传文件");
			exit;
		}

		alert_and_back("操作成功",'admin.php?controller=admin_pro&action=resource_group');
	}

	function export_resourcegroup(){
		set_time_limit(0);
		global $_CONFIG;
		if(strpos($where, "d.device_ip")===false)
		$where = str_replace("device_ip", "d.device_ip", $where);
		$alldev = $this->devpass_set->base_select("SELECT a.*,b.device_ip,b.username dusername,b.login_method,b.port FROM ".$this->resgroup_set->get_table_name()." a LEFT JOIN ".$this->devpass_set->get_table_name()." b ON a.devicesid = b.id WHERE a.devicesid!=0 order by groupname ASC,b.device_ip ASC");

		$str = language("IP").",".language("用户名").",".language("协议").",".language("端口").",".language("组名").",".language("运维组名").",".language("组用户名")."\n";
		
		$id=1;
		if($alldev){
			$alltem = $this->tem_set->select_all();
			foreach ($alldev AS $report){	
				foreach($alltem as $tem) {
					if($report['login_method'] == $tem['id']) {
						$report['login_method'] = $tem['login_method'];
					}
				}
				if(strpos($report['username'], '"')){
					//$report['username'] = str_replace('"', '"""', $report['username']);
				}
				if($report['devicesid']=='-1'){
					if($_CONFIG['LDAP']){
						$_groups = $this->sgroup_set->select_all("groupname=(select groupname from ".$this->sgroup_set->get_table_name()." WHERE id=".$report['groupid'].")");
						if(count($_groups)>1){
							$report['groupid']=$_groups[0]['groupname'].'(('.$report['groupid'].'))';
						}elseif($_groups){
							$report['groupid']=$_groups[0]['groupname'];
						}
					}
					$str .= ",,,,".$report['groupname'].','.$report['groupid'].','.$report['username'];
				}else{
					$str .= $report['device_ip'].",".($report['dusername']==""  ? '空用户' : $report['dusername']).",".$report['login_method'].",".$report['port'].",".$report['groupname'].',,';
				}
				$str .= "\n";
			}
		}
		$str = iconv("UTF-8", "GBK", $str);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=audit-resourcegroup-".date('Ymd').".csv"); 
		echo $str;
		exit;
	}

	function resource_group_del() {
		$gname = urldecode(get_request('gname', 0, 1));
		$ginfo = $this->resgroup_set->select_all("groupname='$gname' and devicesid=0");
		$this->luser_resourcegrp_set->delete_all("resourceid=".$ginfo[0]['id']);
		$this->lgroup_resourcegrp_set->delete_all("resourceid=".$ginfo[0]['id']);
		$this->resgroup_set->delete_all("groupname='$gname'");

		alert_and_back("操作成功",'admin.php?controller=admin_pro&action=resource_group');
	}

	function export_resourcegroup_priorty(){
		set_time_limit(0);
		$alldev = $this->devpass_set->base_select("select a.groupname,group_concat(distinct d.username) users,group_concat(distinct c.groupid) groups from resourcegroup a left join luser_resourcegrp b on a.id=b.resourceid left join lgroup_resourcegrp c on a.id=c.resourceid left join member d on b.memberid=d.uid group by a.groupname order by a.groupname ASC");

		$str = language("组名").",".language("用户").",".language("用户组")."\n";
		$id=1;
		for($i=0; $i<count($alldev); $i++){
			if($alldev[$i]['groups']){
				$grouparr = explode(',', $alldev[$i]['groups']);
				for($j=0; $j<count($grouparr); $j++){
					$_groups = $this->sgroup_set->select_all("groupname=(select groupname from ".$this->sgroup_set->get_table_name()." WHERE id=".$grouparr[$j].")");
					if(count($_groups)>1){
						$grouparr[$j]=$_groups[0]['groupname'].'(('.$grouparr[$j]['id'].'))';
					}elseif($_groups){
						$grouparr[$j]=$_groups[0]['groupname'];
					}
				}
				$alldev[$i]['groups']=implode(',', $grouparr);
			}
			$str.=$alldev[$i]['groupname'].',"'.$alldev[$i]['users'].'","'.$alldev[$i]['groups']."\"\n";
		}
		$str = iconv("UTF-8", "GBK", $str);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=audit-resourcegroup-".date('Ymd')."-prioryty.csv"); 
		echo $str;
		exit;
	}

	function resource_group_import_priorty(){		
		$this->display("resourcegroupimportpriority.tpl");
	}

	function resource_group_doimport_priority(){
		global $_CONFIG;
		setlocale(LC_ALL, 'zh_CN');
		if(is_uploaded_file($_FILES['devfile']['tmp_name']))
		{
			if($_FILES['devfile']['error']==1 or $_FILES['devfile']['error']==2){
				alert_and_back("上传得文件超过系统限制");
				exit;
			}
			//echo $_FILES['devfile']['tmp_name'];
			
			if (($handle = fopen($_FILES['devfile']['tmp_name'], "r")) !== FALSE) {
				while(($lines[] = fgetcsv($handle))!==false);
			}else{
				alert_and_back("打开文件失败");
				exit;
			}
			//var_dump($lines);
			/*if(iconv("GBK", "UTF-8", trim($lines[0][0]))!='主机名' || iconv("GBK", "UTF-8", trim($lines[0][1]))!='IP' || iconv("GBK", "UTF-8", trim($lines[0][2]))!='服务器组' || iconv("GBK", "UTF-8", trim($lines[0][3]))!='系统类型'|| iconv("GBK", "UTF-8", trim($lines[0][4]))!='系统用户'){
				alert_and_back("文件有问题，请上传正确的文件");
				exit;
			}*/
			//echo '<pre>';print_r($lines);echo '</pre>';exit;
			$importfile = $_CONFIG['IMPORTFILEPATH'].'/'.time().'.'.$_FILES['devfile']['name'];
			if(move_uploaded_file($_FILES['devfile']['tmp_name'], $importfile)){
				$importlog = new importlog();
				$importlog->set_data('file', $importfile);
				$importlog->set_data('type', 'resourcegroup_priority');
				$this->importlog_set->add($importlog);
			}else{
				//echo '<script language=\'javascript\'>导入文件备份失败，请联系管理员</script>';
			}
			$j=0;
			for($i=1; $i<count($lines); $i++){
				if(empty($lines[$i])){
					continue;
				}
				$linearr = $lines[$i];	//var_dump($linearr);
				for($ii=0; $ii<count($linearr); $ii++){
					$linearr[$ii]=iconv("GBK", "UTF-8", $linearr[$ii]);
				}//var_dump($linearr);
				$groupname=trim($linearr[0]);
				$users=trim($linearr[1]);
				$groups=trim($linearr[2]);
				if(empty($groupname)){
					continue;
				}
				if(preg_match("/[\\r\\n]/", $groupname)||preg_match("/[\\r\\n]/", $users)||preg_match("/[\\r\\n]/", $groups)){
					$error[]=$device_ip.':'.'用户信息中含有回车符'.'\n';
					continue;
				}
				$resgroup = $this->resgroup_set->select_all("groupname='".$groupname."' and devicesid=0");
				if(empty($resgroup)){
					$error[]=$groupname.':'.'资源组不存在'.'\n';
					continue;
				}
				$this->resgroup_set->query("delete from ".$this->luser_resourcegrp_set->get_table_name()." where resourceid=".$resgroup[0]['id']);
				$this->resgroup_set->query("delete from ".$this->lgroup_resourcegrp_set->get_table_name()." where resourceid=".$resgroup[0]['id']);
				if($users){
					$usertmp = explode(',',$users);
					for($ii=0; $ii<count($usertmp); $ii++){
						$_member = $this->member_set->select_all("username='".$usertmp[$ii]."'");
						$luser_resourcegrp = new luser_resourcegrp();
						$luser_resourcegrp->set_data('resourceid', $resgroup[0]['id']);
						$luser_resourcegrp->set_data('memberid', $_member[0]['uid']);
						$this->luser_resourcegrp_set->add($luser_resourcegrp);
					}
				}
				if($groups){
					$grouptmp = explode(',',$groups);
					for($ii=0; $ii<count($grouptmp); $ii++){
						if(strpos($grouptmp[$ii],'((')===false){
							if($this->sgroup_set->select_count("groupname='".$grouptmp[$ii]."'")>1){
								$error[]=$device_ip.' '.(empty($username) ? '空用户' : $username).' '.':'.'有重复组请输入组ID';
								continue;
							}
							$_group = $this->sgroup_set->select_all("groupname='".$grouptmp[$ii]."'");
							$grouptmp[$ii]=$_group[0]['id'];
						}else{				
							$grouptmp[$ii]=substr($grouptmp[$ii], strpos($grouptmp[$ii],'((')+2, strpos($grouptmp[$ii],'))')-strpos($grouptmp[$ii],'((')-2);
						}						
						$lgroup_resourcegrp = new lgroup_resourcegrp();
						$lgroup_resourcegrp->set_data('resourceid', $resgroup[0]['id']);
						$lgroup_resourcegrp->set_data('groupid', $grouptmp[$ii]);
						$this->lgroup_resourcegrp_set->add($lgroup_resourcegrp);
					}
				}
			}
		}else{
			alert_and_back("请上传文件");
			exit;
		}
		alert_and_back("操作成功",'admin.php?controller=admin_pro&action=resource_group');
	}


	function change_device_pwd(){
		$sid = get_request('sid');
		$ac = get_request('ac', 1, 1);
		if($ac=='change'){
			$oldpwd = htmlspecialchars_decode(get_request('oldpwd', 1, 1));
			$newpwd = htmlspecialchars_decode(get_request('newpwd', 1, 1));
			$newpwdc = htmlspecialchars_decode(get_request('newpwdc', 1, 1));
			$olddevpass = $this->devpass_set->select_by_id($sid);
			if($olddevpass['cur_password']!=$oldpwd){
				alert_and_back("当前密码不正确");
				exit;
			}elseif($newpwd!=$newpwdc){
				alert_and_back("输入的两个新密码不同");
				exit;
			}
			$devpass = new devpass();
			$devpass->set_data('id', $sid);
			$devpass->set_data('old_password',$olddevpass['cur_password']);
			$devpass->set_data('cur_password',$newpwd);
			$this->devpass_set->edit($devpass);

			alert_and_close('修改成功');
			exit;
		}
		$this->assign("id", $sid);
		$this->display('change_device_pwd.tpl');
	}

	function pass_batchedit() {
		$id = get_request('id');
		$ip = get_request('ip',0,1);
		$gid = get_request('gid',0,1);
		$serverid = get_request('serverid');
		
		$this->assign('ip',$ip);
		$this->assign('serverid',$serverid);
		$where = "device_type = '' AND login_method IN('ssh','RDP','telnet','ftp','ssh1','vnc','x11','rlogin','apppub')";
		$allmethod =  $this->tem_set->select_all($where,'','ASC');	
		
		$device = $this->server_set->select_all("id=$serverid");

		$this->assign('sshport',$device[0]['sshport'] ? $device[0]['sshport'] : '22');
		$this->assign('telnetport',$device[0]['telnetport']? $device[0]['telnetport'] : '23');
		$this->assign('ftpport',$device[0]['ftpport']? $device[0]['ftpport'] : '21');
		$this->assign('rdpport',$device[0]['rdpport']? $device[0]['rdpport'] : '3389');
		$this->assign('vncport',$device[0]['vncport']? $device[0]['vncport'] : '5900');
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		$this->assign('entrust_password',$dp['entrust_password']);

				
//echo '<pre>';print_r($_SESSION);echo '</pre>';
		$this->assign("allmethod", $allmethod);
		$this->assign('gid',$gid);
		$this->assign('title',language("修改"));
		$this->display('pass_batchedit.tpl');
	}

	function pass_batchsave() {
		global $_CONFIG;
		$id = get_request('id');
		$serverid = get_request('serverid');
		$ip = get_request('ip',0,1);
		$gid = get_request('gid',0,1);
		$server = $this->server_set->select_by_id($serverid);
		for($i=0; $i<count($_POST['username']); $i++){		
			$new_name = $_POST['username'][$i];
			if(empty($new_name)){
				continue;
			}
			$new_password=$_POST['password'][$i];
			$new_password_confirm=$_POST['confirm_password'][$i];
			
			$port = $_POST['port'][$i];
			$login_method = $_POST['l_id'][$i];
			$nolimit = $_POST['nolimit'][$i];
			$limit_time = $_POST['limit_time'][$i];
			if($new_password!=$new_password_confirm){
				$error[]=$new_name.':两次输入的密码不一致\n';
				continue;
			}			
					
			if(0 == $this->devpass_set->select_count("username = '$new_name' and device_ip='$ip' and port='$port' and hostname='".$server['hostname']."' and login_method='$login_method'")) {
				$new_pass = new devpass();
				$new_pass->set_data('username',$new_name);
				$new_pass->set_data('cur_password',$this->devpass_set->udf_encrypt($new_password));
				$new_pass->set_data('login_method',$login_method);
				$new_pass->set_data('port',$port);
				$new_pass->set_data('device_type',$server['device_type']);
				$new_pass->set_data('device_ip',$server['device_ip']);
				$new_pass->set_data('hostname',$server['hostname']);
				$new_pass->set_data('enable',1);
				if($nolimit == 'on') {
					$new_pass->set_data('limit_time','9999-00-00');
				}
				else {
					if($limit_time != '') {
						$new_pass->set_data('limit_time',$limit_time);
					}
					else {
						$new_pass->set_data('limit_time','0000-00-00');
					}
				}
				
				$this->devpass_set->add($new_pass);
				$id = mysql_insert_id();

				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('添加系统用户'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
				$adminlog->set_data('type', 13);
				$this->admin_log_set->add($adminlog);				
				unset($adminlog);											

				$succeed[]=$new_name;
				//alert_and_back('添加成功',"admin.php?controller=admin_pro&action=devpass_index&ip=$ip&serverid=".$serverid."&gid=".$gid);
				}
			else {
				//alert_and_back('添加失败,该用户已存在','admin.php?controller=admin_pro&action=pass_edit&ntype=new&ip='.$ip.'&serverid='.$serverid."&gid=".$gid);
				$error[]=$new_name.':帐户已经存在\n';
				continue;
			}
		}

		if($succeed){
			$msg = '成功添加用户:'.implode(',',$succeed);
			if($error){
				$msg .= '\n添加失败的用户:\n'.implode('\n',$error).'\n';
			}
			alert_and_back($msg,"admin.php?controller=admin_pro&action=devpass_index&ip=$ip&serverid=".$serverid."&gid=".$gid);
		}else{
			alert_and_back('添加失败:\n'.implode('\n',$error).'\n');
		}

	}

	function systemtype(){
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'device_type';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = 'login_method="" and device_type!=""';
		if($_SESSION['ADMIN_LEVEL']!=1){
			//$where .= " AND creatorid=".$_SESSION['ADMIN_UID'];
		}
		$row_num = $this->tem_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$weektime = $this->tem_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$this->assign('title', language('周组策略列表'));
		$this->assign('weektime', $weektime);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('systemtype.tpl');
	}
	
	function systemtype_edit(){
		$sid = get_request("id");
		$wt = $this->tem_set->select_by_id($sid);
		$this->assign("title", language('添加周组策略'));
		$this->assign("wt", $wt);
		$this->display('systemtype_edit.tpl');
	}
	
	function delete_systemtype(){
		$id = get_request("id");
		
		$this->tem_set->delete($id);
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=systemtype');
	}
	
	function systemtype_save(){
		$id = get_request("id");
		$name = get_request("device_type", 1, 1);
		$sucommand = get_request("sucommand", 1, 1);
		$snmp_system = get_request("snmp_system", 1, 0);
		
		$allgp = $this->tem_set->select_all('device_type="'.$name.'" and id!='.$id);
		if(!empty($allgp)){
			alert_and_back('该名已经存在');
			exit;
		}
		
		$tem = new tem();
		$tem->set_data('login_method', "");
		$tem->set_data('device_type', $name);
		$tem->set_data('sucommand', $sucommand);
		$tem->set_data('snmp_system', $snmp_system);
		$tem->set_data('creatorid', $_SESSION['ADMIN_UID']);
		if($id){
			$tem->set_data("id", $id);
			$this->tem_set->edit($tem);
			alert_and_back('修改成功','admin.php?controller=admin_pro&action=systemtype');
			exit;
		}
		
		$this->tem_set->add($tem);
		alert_and_back('添加成功','admin.php?controller=admin_pro&action=systemtype');
	}

	

	function sshkey(){
		global $_CONFIG;
		$page_num = get_request('page');
		$username = trim(get_request('username', 0, 1));
		$dusername = trim(get_request('dusername', 0, 1));
		$ip = trim(get_request('ip', 0, 1));
		$where = "a.id";
		if($username){
			$where .= " AND u.username like '%".$username."%'";
		}
		if($dusername){
			$where .= " AND d.username like '%".$dusername."%'";
		}
		if($ip){
			$where .= " AND d.device_ip like '%".$ip."%'";
		}
		$row_num = $this->sshkey_set->base_select("SELECT COUNT(*) row_num FROM ".$this->sshkeyname_set->get_table_name()." a LEFT JOIN ".$this->sshkey_set->get_table_name()." b ON a.sshkeyname=b.sshkeyname LEFT JOIN ".$this->devpass_set->get_table_name()." d ON b.devicesid=d.id LEFT JOIN ".$this->member_set->get_table_name()." u ON b.devicesid=u.uid WHERE $where group by a.sshkeyname");
		$row_num = $row_num[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sshdevices = $this->sshkey_set->base_select("SELECT a.* FROM ".$this->sshkeyname_set->get_table_name()." a LEFT JOIN ".$this->sshkey_set->get_table_name()." b ON a.sshkeyname=b.sshkeyname LEFT JOIN ".$this->devpass_set->get_table_name()." d ON b.devicesid=d.id LEFT JOIN ".$this->member_set->get_table_name()." u ON b.devicesid=u.uid WHERE $where  group by a.sshkeyname ORDER BY a.sshkeyname ASC LIMIT ".$newpager->intStartPosition.", ".$newpager->intItemsPerPage);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		for($i=0; $i<count($sshdevices); $i++){
			if(file_exists($sshdevices[$i]['sshprivatekey'])){
				$sshdevices[$i]['private_key_file'] = 1;
			}else{
				$sshdevices[$i]['private_key_file'] = 0;
			}
			if(file_exists($sshdevices[$i]['sshpublickey'])){
				$sshdevices[$i]['public_key_file'] = 1;
			}else{
				$sshdevices[$i]['public_key_file'] = 0;
			}
		}

		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$this->assign("sshdevices", $sshdevices);
		$this->assign("sshpublickeydir", $_CONFIG['PASSEDITSSHPULICKEY']);

		$this->display('sshkey.tpl');
	}



	function sshkey_edit(){
		global $_CONFIG;
		$id = get_request('id');
		$sshkey = $this->sshkeyname_set->select_by_id($id);
		$sshkey['keypassword'] = $this->sshkey_set->udf_decrypt($sshkey['keypassword']);
		if(file_exists($sshkey['sshprivatekey'])){
			$sshkey['sshprivatekey_exists']=1;
		}
		if(file_exists($sshkey['sshpublickey'])){
			$sshkey['sshpublickey_exists']=1;
		}
		$this->assign("sshkey", $sshkey);
		$this->display('sshkey_edit.tpl');
	}

	function sshkey_save(){
		global $_CONFIG;
		$id = get_request('id');
		$name = get_request('sshkeyname',1,1);
		$desc = get_request('desc',1,1);
		$keypassword = get_request('keypassword',1,1);
		$password = htmlspecialchars_decode(get_request('password',1,1));
		$password_confirm = htmlspecialchars_decode(get_request('password_confirm',1,1));
		if($password_confirm!=$password){
			alert_and_back('两次输入的密码不一致');
			exit;
		}elseif($this->sshkeyname_set->select_count("sshkeyname='$name' AND id!='".intval($id)."'")>0){
			alert_and_back('名称:'.$name.'已经存在');
			exit;
		}
		$filename = $_CONFIG['CONFIGFILE']['CNF'];
		
		$lines = @file($filename);
		if(!empty($lines))
		{
				
			for($ii=0; $ii<count($lines); $ii++)
			{
		
				if(strstr(strtolower($lines[$ii]), "global-server"))
				{
					$tmp = preg_split("/=/", $lines[$ii]);
					$globalip = trim($tmp[1]);
				}
			}
		}
		$sshkeyname = new sshkeyname();
		$sshkeyname->set_data("sshkeyname", $name);
		$sshkeyname->set_data("desc", $desc);
		$sshkeyname->set_data("globalip", $globalip);
		$sshkeyname->set_data("keypassword", $this->sshkey_set->udf_encrypt($password));
		if($_POST['upload']){
			//$sshprivatekey = $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$_member['username'].'_'.$_sshkey['devicesid'].'.pvt';
			$sshprivatekey = $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.time().'.pvt';
			if(is_uploaded_file($_FILES['key']['tmp_name'])){
				if(!move_uploaded_file($_FILES['key']['tmp_name'], $sshprivatekey)){
					alert_and_back('上传私钥文件失败');
					exit;
				}
				$sshkeyname->set_data("sshprivatekey", $sshprivatekey);
				$sshkeyname->set_data("md5sum", md5_file($sshprivatekey));
			}

			//$sshpublickey = $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$_member['username'].'_'.$_sshkey['devicesid'].'.pub';
			$sshpublickey = $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.time().'.pub';
			if(is_uploaded_file($_FILES['pkey']['tmp_name'])){
				if(!move_uploaded_file($_FILES['pkey']['tmp_name'], $sshpublickey)){
					alert_and_back('上传公钥文件失败');
					exit;
				}
				$sshkeyname->set_data("sshpublickey", $sshpublickey);
			}			
		}
		if($id){			
			$sshkeyname->set_data("id", $id);
			$this->sshkeyname_set->edit($sshkeyname);
		}else{
			$this->sshkeyname_set->add($sshkeyname);
			$id = mysql_insert_id();
		}
		$sshkeyname2 = new sshkeyname();
		$sshkeyname2->set_data("sshkeyname", $name);
		$sshkeyname2->set_data("id", $id);
		if(@file_exists($sshprivatekey)&&@copy($sshprivatekey, $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt')){
			@unlink($sshprivatekey);
			$sshkeyname2->set_data("sshprivatekey", $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt');
			$sshkeyname2->set_data("md5sum", md5_file($_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt'));
		}
		if(@file_exists($sshpublickey)&&@copy($sshpublickey, $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub')){
			@unlink($sshpublickey);
			$sshkeyname2->set_data("sshpublickey", $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub');
		}		
		$this->sshkeyname_set->edit($sshkeyname2);
		
		if(@file_exists($_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt')){
			@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt');
		}
		if(@file_exists($_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub')){
			@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub');
		}
		
		alert_and_back('操作成功','admin.php?controller=admin_pro&action=sshkey');
	}

	function sshkey_delete(){
		$id = get_request('id');
		if(empty($id)){
			$id = $_POST['chk_member'];
			if($this->sshkey_set->select_count("sshkeyname in('".implode('\',\'', $id)."')")>0){
				alert_and_back('请先删除绑定设备','admin.php?controller=admin_pro&action=sshkey');
				exit;
			}
			//$this->sshkey_set->delete_all("id IN(".(empty($id) ? '0' : implode(',', $id)).")");
		}else{
			if($this->sshkey_set->select_count("sshkeyname='".$id."'")>0){
				alert_and_back('请先删除绑定设备','admin.php?controller=admin_pro&action=sshkey');
				exit;
			}
			$sshkeyname = $this->sshkeyname_set->select_by_id($id);
			//$this->sshkey_set->delete_all("sshkeyname='".$sshkeyname['sshkeyname']."'");
		}
		$this->sshkeyname_set->delete($id);
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=sshkey');
	}

	

	function sshkey_list() {
		global $_CONFIG;
		$keynameid = get_request('id');
		$groupid = get_request('groupid');
		$ip = get_request('ip', 0, 1);
		$username = get_request('username', 0, 1);
		$where = '1=1';
		if($groupid){
			$where .= " AND s.groupid=".$groupid;
		}
		if($ip){
			$where .= " AND d.device_ip like '%$ip%'";
		}
		if($username){
			$where .= " AND d.username like '%$username%'";
		}
		$ginfo = $this->sshkeyname_set->select_by_id($keynameid);

		require_once('./include/select_sgroup_ajax.inc.php');
		if($ori_g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_all("id IN(".(is_array($ori_g_id)?implode(',', $ori_g_id): $ori_g_id).")");
			$__tmpgid = $ori_g_id;
			for($i=0; $i<count($_tmpgid); $i++){
				$__tmpgid .= ','.$_tmpgid[$i]['child'];
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$__tmpgid.")");
				for($i=0; $i<count($allips); $i++){
					$cronreport_alltmpip[]=$allips[$i]['device_ip'];
				}
			}
			if($cronreport_alltmpip)
			$where .= " AND d.device_ip IN ('".implode("','", $cronreport_alltmpip)."')";
		}

		$sql = "SELECT d.id devicesid,IFNULL(d.username, '空用户') username, d.device_ip,lt.login_method lmname FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN login_template lt ON d.login_method=lt.id  LEFT JOIN servers s ON d.device_ip=s.device_ip WHERE $where AND d.publickey_auth=1 and (d.login_method=3 or d.login_method=7)  AND d.id NOT IN(SELECT devicesid FROM ".$this->sshkey_set->get_table_name()." ) ".($_SESSION['ADMIN_LEVEL']==3 ? ' and d.device_ip IN(SELECT device_ip FROM servers WHERE groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).'))' : '')." ORDER BY d.device_ip asc , d.username ASC";
		$resources = $this->sshkey_set->base_select($sql);

		$sql = "SELECT d.id devicesid,IFNULL(d.username, '空用户') username, d.device_ip,lt.login_method lmname FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN login_template lt ON d.login_method=lt.id  LEFT JOIN servers s ON d.device_ip=s.device_ip WHERE 1 AND d.publickey_auth=1 and (d.login_method=3 or d.login_method=7) AND d.id IN(SELECT devicesid FROM ".$this->sshkey_set->get_table_name()." WHERE sshkeyname='".$ginfo['id']."') ".(($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) ? ' and d.device_ip IN(SELECT device_ip FROM servers WHERE groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).'))' : '')." ORDER BY d.device_ip asc , d.username ASC";
		$res = $this->sshkey_set->base_select($sql);

	
		$allgroup = $this->sgroup_set->select_all((($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) ? ' id IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).')' : '1=1'), 'groupname', 'asc');
		//echo '<pre>';print_r($resources);echo '</pre>';
		$this->assign("res", $res);
		$this->assign("resource", $resources);
		$this->assign("lm", $login_method);
		$this->assign("ginfo", $ginfo);
		$this->assign("groupid", $groupid);
		$this->assign("allgroup", $allgroup);
		$this->display('sshkey_list.tpl');
	}

	function sshkey_list_save() {
		global $_CONFIG;
		$gid = get_request("id",1,0);
		$selected = get_request('secend', 1, 1);
		$groupid = get_request('groupid', 1, 1);
		$keynameid = get_request("id");

		$where = "1=1";		
		$ginfo = $this->sshkeyname_set->select_by_id($keynameid);

		if($groupid){
			$where .= " AND devicesid IN(SELECT d.id FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ".$this->server_set->get_table_name()." s ON d.device_ip=s.device_ip WHERE s.groupid='$groupid')";
		}
		
		$this->sshkey_set->delete_all("sshkeyname='".$ginfo['id']."' and devicesid!=0 and $where");

		for($i=0; $i<count($selected); $i++){			
			$sshkey = new sshkey();
			$lm = explode("_", $selected[$i]);
			$minfo = $this->member_set->select_by_id($lm[1]);
			//$sshprivatekey = $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$minfo['username'].'_'.$lm[0].'.pvt';
			//$sshpublickey = $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$minfo['username'].'_'.$lm[0].'.pub';				
			
			if(file_exists($sshprivatekey)){
				//unlink($sshprivatekey);
				//copy($ginfo['sshprivatekey'], $sshprivatekey);
				$sshkey->set_data('sshprivatekey',$ginfo['sshprivatekey']);
			}
			if(file_exists($sshpublickey)){
				//unlink($sshpublickey);
				//copy($ginfo['sshpublickey'], $sshpublickey);
				$sshkey->set_data('sshpublickey',$ginfo['sshpublickey']);
			}
			$sshkey->set_data('sshkeyname',$ginfo['id']);
			$sshkey->set_data('devicesid',$lm[0]);
			$sshkey->set_data('memberid',$lm[1]);
			$this->sshkey_set->add($sshkey);
			unset($sshkey);
		}

		alert_and_back("操作成功",'admin.php?controller=admin_pro&action=sshkey&id='.$ginfo['id']);
	}

	function sshkey_synchronise(){
		$sql = "INSERT IGNORE INTO ".$this->sshkey_set->get_table_name()."(memberid,devicesid) SELECT memberid,devicesid FROM ".$this->luser_set->get_table_name()." l LEFT JOIN ".$this->devpass_set->get_table_name()." d ON l.devicesid=d.id WHERE d.publickey_auth=1 and (d.login_method=3 or d.login_method=7)";
		$this->sshkey_set->query($sql);
		alert_and_back('同步成功','admin.php?controller=admin_pro&action=sshkey');
	}

	function sshkey_import(){
		$this->display('importsshkey.tpl');
	}

	function sshkey_doimport(){
		global $_CONFIG;
		if(is_uploaded_file($_FILES['sshkey']['tmp_name'])&&substr($_FILES['sshkey']['name'], strrpos($_FILES['sshkey']['name'], '.'))=='.zip'){
			exec("rm -rf tmp/pvt/*");
			exec("unzip -oj ".$_FILES['sshkey']['tmp_name']." -d tmp/pvt");
			$filename = $_CONFIG['CONFIGFILE']['CNF'];
			
			$lines = @file($filename);
			if(!empty($lines))
			{
			
				for($ii=0; $ii<count($lines); $ii++)
				{
			
					if(strstr(strtolower($lines[$ii]), "global-server"))
					{
						$tmp = preg_split("/=/", $lines[$ii]);
						$globalip = trim($tmp[1]);
					}
				}
			}
			unset($lines);
			$err = array();
			if (($handle = @fopen('tmp/pvt/sshkey.csv', "r")) !== FALSE) {
				while(($lines[] = fgetcsv($handle))!==false);
			}else{
				alert_and_back("打开文件sshkey.csv失败");
				exit;
			}
			$importfile = $_CONFIG['IMPORTFILEPATH'].'/'.time().'.'.$_FILES['sshkey']['name'];
			if(move_uploaded_file($_FILES['sshkey']['tmp_name'], $importfile)){
				$importlog = new importlog();
				$importlog->set_data('file', $importfile);
				$importlog->set_data('type', 'sshkey');
				$this->importlog_set->add($importlog);
			}else{
				//echo '<script language=\'javascript\'>导入文件备份失败，请联系管理员</script>';
			}
			array_shift($lines);
			//echo '<pre>';var_dump($lines);echo '</pre>';
			for($i=0; $i<count($lines); $i++){
				if(empty($lines[$i][0])) continue;
				$exist_name = $this->sshkeyname_set->select_all("sshkeyname='".$lines[$i][0]."'");
				$sshprivatekey=$_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$lines[$i][2];
				$sshpublickey=$_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$lines[$i][1];
				if($exist_name){
					if($lines[$i][1]&&!file_exists('tmp/pvt/'.$lines[$i][1])){
						$err[]='文件'.$lines[$i][0].'不存在\n';
						continue;
					}
					if($lines[$i][2]&&!file_exists('tmp/pvt/'.$lines[$i][2])){
						$err[]='文件'.$lines[$i][0].'不存在\n';
						continue;
					}
					@unlink($exist_name[0]['sshpublickey']);
					@unlink($exist_name[0]['sshprivatekey']);
					if($lines[$i][1]&&!copy('tmp/pvt/'.$lines[$i][1], $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$lines[$i][1])){
						$err[]='文件'.$lines[$i][1].'移动失败，请重新上传\n';
						continue;
					}				
					if($lines[$i][1]&&@file_exists($_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$lines[$i][1])){
						@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPULICKEY_NEW'].$lines[$i][1]);
					}
					if($lines[$i][2]&&!copy('tmp/pvt/'.$lines[$i][2], $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$lines[$i][2])){
						$err[]='文件'.$lines[$i][2].'移动失败，请重新上传\n';
						continue;
					}				
					if($lines[$i][2]&&@file_exists($_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$lines[$i][2])){
						@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].$lines[$i][2]);
					}
					$skname = new sshkeyname();
					$skname->set_data('sshkeyname', $lines[$i][0]);
					$skname->set_data('globalip', $globalip);
					if($lines[$i][1]){
						$skname->set_data('sshpublickey', $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$lines[$i][1]);
					}
					if($lines[$i][2]){
						$skname->set_data('sshprivatekey', $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$lines[$i][2]);
						$skname->set_data("md5sum", md5_file($_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$lines[$i][2]));
					}
					$skname->set_data('keypassword', $this->sshkeyname_set->udf_encrypt($lines[$i][3]));
					$skname->set_data('desc', $lines[$i][4]);
					$skname->set_data('id', $exist_name[0]['id']);
					$this->sshkeyname_set->edit($skname);
					$id = $exist_name[0]['id'];
				}else{
					if($lines[$i][1]&&!file_exists('tmp/pvt/'.$lines[$i][1])){
						$err[]='文件'.$lines[$i][1].'不存在\n';
						continue;
					}
					if($lines[$i][2]&&!file_exists('tmp/pvt/'.$lines[$i][2])){
						$err[]='文件'.$lines[$i][2].'不存在\n';
						continue;
					}
					/*
					if($lines[$i][1]&&file_exists($_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$lines[$i][1])){
						$err[]='文件'.$lines[$i][1].'已经存在\n';
						continue;
					}
					if($lines[$i][2]&&file_exists($_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$lines[$i][2])){
						$err[]='文件'.$lines[$i][2].'已经存在\n';
						continue;
					}
					*/
					if($lines[$i][1]&&!copy('tmp/pvt/'.$lines[$i][1], $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$lines[$i][1])){
						$err[]='文件'.$lines[$i][1].'移动失败，请重新上传\n';
						continue;
					}				
					if($lines[$i][1]&&@file_exists($_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$lines[$i][1])){
						@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPULICKEY_NEW'].$lines[$i][1]);
					}
					if($lines[$i][2]&&!copy('tmp/pvt/'.$lines[$i][2], $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$lines[$i][2])){
						$err[]='文件'.$lines[$i][2].'移动失败，请重新上传\n';
						continue;
					}				
					if($lines[$i][2]&&@file_exists($_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$lines[$i][2])){
						@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].$lines[$i][2]);
					}
					$skname = new sshkeyname();
					$skname->set_data('sshkeyname', $lines[$i][0]);
					$skname->set_data('globalip', $globalip);
					if($lines[$i][1])
					$skname->set_data('sshpublickey', $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$lines[$i][1]);
					if($lines[$i][2])
					$skname->set_data('sshprivatekey', $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$lines[$i][2]);
					$skname->set_data('keypassword', $this->sshkeyname_set->udf_encrypt($lines[$i][3]));
					$skname->set_data('desc', $lines[$i][4]);
					$this->sshkeyname_set->add($skname);
					$id = mysql_insert_id();
				}
				$sshkeyname2 = new sshkeyname();
				$sshkeyname2->set_data("id", $id);
				if(@file_exists($sshprivatekey)&&@copy($sshprivatekey, $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt')){
					@unlink($sshprivatekey);
					$sshkeyname2->set_data("sshprivatekey", $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt');
					$sshkeyname2->set_data("md5sum", md5_file($_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt'));
					
				}
				if(@file_exists($sshpublickey)&&@copy($sshpublickey, $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub')){
					@unlink($sshpublickey);
					$sshkeyname2->set_data("sshpublickey", $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub');
				}		
				$this->sshkeyname_set->edit($sshkeyname2);
			}
			//var_dump($err);exit;
			/*
			for($i=0; $i<count($files); $i++){
				$filearr = explode('_', basename($files[$i],'.pvt'));
				if(count($filearr)!=5||($filearr[4]!='key'&&$filearr[4]!='pubkey')){
					$err[]=substr($files[$i], strlen('tmp/pvt')).':文件格式不正确\n';
					continue;
				}
				if(!($m = $this->member_set->select_all("username='".$filearr[0]."'"))){
					$err[]=substr($files[$i], strlen('tmp/pvt')).':用户名不存在\n';
					continue;
				}
				if(!($d = $this->devpass_set->select_all("device_ip='".$filearr[1]."' and port='".$filearr[2]."' and username='".$filearr[3]."'"))){
					$err[]=substr($files[$i], strlen('tmp/pvt')).':设备不存在\n';
					continue;
				}
				$s = $this->sshkey_set->select_all("memberid='".$m[0]['uid']."' and devicesid='".$d[0]['id']."'");
				$sshkey = new sshkey();
				$sshkey->set_data('memberid', $m[0]['uid']);
				$sshkey->set_data('devicesid', $d[0]['id']);	

				if($filearr[4]=='key'){//var_dump($_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.basename($files[$i],'.pvt'));
					if(!copy($files[$i], $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.basename($files[$i],'.pvt'))){
						$err[]=substr($files[$i], strlen('tmp/pvt')).':文件移动失败，请重新上传\n';
						continue;
					}
					if(@file_exists($_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.basename($files[$i],'.pvt'))){
						@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.basename($files[$i],'.pvt'));
					}
					$sshkey->set_data('sshprivatekey', $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.basename($files[$i],'.pvt'));
				}else{
					if(!copy($files[$i], $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.basename($files[$i],'.pub'))){
						$err[]=substr($files[$i], strlen('tmp/pub')).':文件移动失败，请重新上传\n';
						continue;
					}				
					if(@file_exists($_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.basename($files[$i],'.pub'))){
						@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPULICKEY_NEW'].basename($files[$i],'.pub'));
					}
					$sshkey->set_data('sshpublickey', $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.basename($files[$i],'.pub'));
				}
				if($s){
					$sshkey->set_data('id', $s[0]['id']);
					$this->sshkey_set->edit($sshkey);
				}else{
					$this->sshkey_set->add($sshkey);
				}
			}*/
			if($err){
				alert_and_back('部分上传失败:\n'.implode(" ", $err));
			}else{
				alert_and_back("全部上传成功");
			}
		}else{
			alert_and_back('请上传zip打包的文件');
		}
	}

	function sshkey_export(){
		global $_CONFIG;
		exec("rm -rf tmp/zipphp.php");
		exec("rm -rf tmp/pvt/*");
		exec("cp -r ".$_CONFIG['PASSEDITSSHPRIVATEKEY_NEW']."/* tmp/pvt/");
		exec("cp -r ".$_CONFIG['PASSEDITSSHPULICKEY_NEW']."/* tmp/pvt/");

		exec("rm -f tmp/pvt.zip");
		//exec("zip -q -r -D tmp/".$_SESSION['ADMIN_USERNAME'].".zip ".$root);

		$phpstr = "<?php\r\nsession_start();\r\nexec(\"zip -q -r -D pvt.zip pvt\");\r\nHeader('Location: pvt.zip');\r\nexit();\r\n?>\r\n";
		if(!file_exists("tmp/zipphp.php"))
			$this->Array2File(array($phpstr), "tmp/zipphp.php");
		go_url("tmp/zipphp.php");
	}

	function sshkey_new(){
		global $_CONFIG;
		$page_num = get_request('page');
		$username = trim(get_request('username', 0, 1));
		$dusername = trim(get_request('dusername', 0, 1));
		$ip = trim(get_request('ip', 0, 1));
		$where = "1=1";
		if($username){
			$where .= " AND u.username like '%".$username."%'";
		}
		if($dusername){
			$where .= " AND d.username like '%".$dusername."%'";
		}
		if($ip){
			$where .= " AND d.device_ip like '%".$ip."%'";
		}
		$row_num = $this->sshkey_set->base_select("SELECT COUNT(*) row_num FROM ".$this->sshkey_set->get_table_name()." WHERE $where ");
		$row_num = $row_num[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sshdevices = $this->sshkey_set->base_select("SELECT a.id,a.memberid,a.devicesid,a.sshkeyname,m.username webuser,d.device_ip,d.port,d.username,s.sshprivatekey,s.sshpublickey FROM ".$this->sshkey_set->get_table_name()." a left join sshkeyname s on a.sshkeyname=s.id left join ".$this->member_set->get_table_name()." m ON a.memberid=m.uid left join ".$this->devpass_set->get_table_name()." d ON a.devicesid=d.id WHERE $where ORDER BY device_ip ASC LIMIT ".$newpager->intStartPosition.", ".$newpager->intItemsPerPage);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		for($i=0; $i<count($sshdevices); $i++){
			if(file_exists($sshdevices[$i]['sshprivatekey'])&&$sshdevices[$i]['sshprivatekey']){
				$sshdevices[$i]['private_key_file'] = 1;
			}else{
				$sshdevices[$i]['private_key_file'] = 0;
			}
			if(file_exists($sshdevices[$i]['sshpublickey'])&&$sshdevices[$i]['sshpublickey']){
				$sshdevices[$i]['public_key_file'] = 1;
			}else{
				$sshdevices[$i]['public_key_file'] = 0;
			}
		}

		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$this->assign("sshdevices", $sshdevices);
		$this->assign("sshpublickeydir", $_CONFIG['PASSEDITSSHPULICKEY']);

		$this->display('sshkey_new.tpl');
	}

	function applogin() {
		$gid = get_request('id');
		$password = htmlspecialchars_decode(get_request('password',0,1));
		$username = get_request('username',0,1);
		$pwhere = 'username=""';
		$uwhere = 'password=""';
		
		if($password){
			$pwhere .= " AND password like '%$password%'";
		}
		if($username){
			$uwhere .= " AND username like '%$username%'";
		}
		
		//$res = $this->resgroup_set->select_all("groupname='$gname' and devicesid!=0");
		$usernames = $this->applogin_set->select_all($uwhere);
		$passwords = $this->applogin_set->select_all($pwhere);
		$this->assign("usernames", $usernames);
		$this->assign("passwords", $passwords);
		$this->display('applogin.tpl');
	}

	function applogin_save(){
		$password = htmlspecialchars_decode(get_request('password',0,1));
		$username = get_request('username',0,1);
		$uid = get_request('uid');
		if($password&&$this->applogin_set->select_count("password='".$password."' AND uid!='".$uid."'")){
			 alert_and_back('密码重复');
			 exit;
		}
		if($username&&$this->applogin_set->select_count("username='".$username."' AND uid!='".$uid."'")){
			 alert_and_back('用户名重复');
			 exit;
		}
		$objapplogin = new applogin();
		$objapplogin->set_data("username", $username);		
		$objapplogin->set_data("password", $password);
		if($uid){
			$objapplogin->set_data("uid", $uid);	
			$this->applogin_set->edit($objapplogin);
		}else{
			$this->applogin_set->add($objapplogin);
		}
		alert_and_back('操作成功');
	    exit;
	}

	function delapplogin(){
		$password = htmlspecialchars_decode(get_request('password',0,1));
		$username = get_request('username',0,1);
		if($password){
			$where = " password='$password'";
		}else{
			$where .= " username='$username'";
		}
		$this->applogin_set->delete_all($where);
		alert_and_back('操作成功');
	    exit;
	}

	function test_port(){
		$devicesid = get_request('devicesid');
		$ip = get_request("ip", 0, 1);
		$port = get_request("port");
		exec("sudo /opt/freesvr/audit/bin/scripts/3_status/test_port.pl $ip $port", $out, $return);
		if($devicesid){
			$d = $this->devpass_set->select_by_id($devicesid);
			$tem = $this->tem_set->select_by_id($d['login_method']);
			$loginapproved = $this->login4approve_set->select_all("webuser='".$_SESSION['ADMIN_USERNAME']."' AND ip='".$d['device_ip']."' AND username='".$d['username']."' AND login_method='".$d['login_method']."'");
			$strloginapprove = '';
			switch($loginapproved[0]['approved']){
				case 0:
					$strloginapprove = '未审核';
					break;
				case 1:
					$strloginapprove = '已审核';
					break;
				case 2:
					$strloginapprove = '已登录';
					break;
				default:
					$strloginapprove = '已登录';
					break;
			}
			$this->assign('strloginapprove', $strloginapprove);
			$d['login_method']=$tem['login_method'];
			$this->assign('login_method', $d['login_method']);
			if($_SESSION['ADMIN_LEVEL']==10 or $_SESSION['ADMIN_LEVEL']==101){
				$dev=$d;
				$dev['device_ip']=$d['device_ip'];
				$dev['port']=$d['port'];
				$dev['login_method']=$d['login_method'];
				$dev['result']=($return==1 ? '<font color="green">连接成功</font>' : '<font color="red">连接不成功</font>');
				$dev['forbidden_commands_groups'] = (empty($dev['forbidden_commands_groups']) ? '无' : $dev['forbidden_commands_groups']);
				$dev['weektime'] = (empty($dev['weektime']) ? '无' : $dev['weektime']);
				$dev['sourceip'] = (empty($dev['sourceip']) ? '无' : $dev['sourceip']);
				$dev['twoauth'] = (empty($dev['twoauth']) ? '无' : $twoauth['username'].'('.$twoauth['realname'].')');
				$dev['username'] = (empty($d['username']) ? '空用户' : $d['username']);
			}elseif($dev=$this->luser_set->select_all('memberid='.$_SESSION['ADMIN_UID'].' AND devicesid='.$devicesid)){
				$dev=$dev[0];
				$twoauth = $this->member_set->select_by_id($dev['twoauth']);
				$dev['device_ip']=$d['device_ip'];
				$dev['port']=$d['port'];
				$dev['login_method']=$d['login_method'];
				$dev['result']=($return==1 ? '<font color="green">连接成功</font>' : '<font color="red">连接不成功</font>');
				$dev['forbidden_commands_groups'] = (empty($dev['forbidden_commands_groups']) ? '无' : $dev['forbidden_commands_groups']);
				$dev['weektime'] = (empty($dev['weektime']) ? '无' : $dev['weektime']);
				$dev['sourceip'] = (empty($dev['sourceip']) ? '无' : $dev['sourceip']);
				$dev['twoauth'] = (empty($dev['twoauth']) ? '无' : $twoauth['username'].'('.$twoauth['realname'].')');
				$dev['username'] = (empty($d['username']) ? '空用户' : $d['username']);
			}elseif($dev=$this->luser_resourcegrp_set->select_all('memberid='.$_SESSION['ADMIN_UID'].' AND resourceid IN (SELECT a.id FROM resourcegroup a LEFT JOIN resourcegroup b ON a.groupname=b.groupname WHERE a.devicesid=0 and b.devicesid='.$devicesid.')')){
				$dev=$dev[0];
				$twoauth = $this->member_set->select_by_id($dev['twoauth']);
				$dev['device_ip']=$d['device_ip'];
				$dev['port']=$d['port'];
				$dev['login_method']=$d['login_method'];
				$dev['result']=($return==1 ? '<font color="green">连接成功</font>' : '<font color="red">连接不成功</font>');
				$dev['forbidden_commands_groups'] = (empty($dev['forbidden_commands_groups']) ? '无' : $dev['forbidden_commands_groups']);
				$dev['weektime'] = (empty($dev['weektime']) ? '无' : $dev['weektime']);
				$dev['sourceip'] = (empty($dev['sourceip']) ? '无' : $dev['sourceip']);
				$dev['twoauth'] = (empty($dev['twoauth']) ? '无' : $twoauth['username'].'('.$twoauth['realname'].')');
				$dev['username'] = (empty($d['username']) ? '空用户' : $d['username']);
			}elseif($dev=$this->luser_resourcegrp_set->select_all('memberid='.$_SESSION['ADMIN_UID'].' AND resourceid IN (SELECT a.id FROM resourcegroup a LEFT JOIN resourcegroup b ON a.groupname=b.groupname left join servers s ON b.groupid=s.groupid  WHERE a.devicesid=0 and b.devicesid=-1 and s.device_ip="'.$ip.'")')){
				$dev=$dev[0];
				$twoauth = $this->member_set->select_by_id($dev['twoauth']);
				$dev['device_ip']=$d['device_ip'];
				$dev['port']=$d['port'];
				$dev['login_method']=$d['login_method'];
				$dev['result']=($return==1 ? '<font color="green">连接成功</font>' : '<font color="red">连接不成功</font>');
				$dev['forbidden_commands_groups'] = (empty($dev['forbidden_commands_groups']) ? '无' : $dev['forbidden_commands_groups']);
				$dev['weektime'] = (empty($dev['weektime']) ? '无' : $dev['weektime']);
				$dev['sourceip'] = (empty($dev['sourceip']) ? '无' : $dev['sourceip']);
				$dev['twoauth'] = (empty($dev['twoauth']) ? '无' : $twoauth['username'].'('.$twoauth['realname'].')');
				$dev['username'] = (empty($d['username']) ? '空用户' : $d['username']);
			}else{
				if($_SESSION['ADMIN_GROUP']){
					if($dev=$this->lgroup_set->select_all('groupid='.$_SESSION['ADMIN_GROUP'].' AND devicesid='.$devicesid)){
						$dev=$dev[0];
						$twoauth = $this->member_set->select_by_id($dev['twoauth']);
						$dev['device_ip']=$d['device_ip'];
						$dev['port']=$d['port'];
						$dev['login_method']=$d['login_method'];
						$dev['result']=($return==1 ? '<font color="green">连接成功</font>' : '<font color="red">连接不成功</font>');
						$dev['forbidden_commands_groups'] = (empty($dev['forbidden_commands_groups']) ? '无' : $dev['forbidden_commands_groups']);
						$dev['weektime'] = (empty($dev['weektime']) ? '无' : $dev['weektime']);
						$dev['sourceip'] = (empty($dev['sourceip']) ? '无' : $dev['sourceip']);
						$dev['twoauth'] = (empty($dev['twoauth']) ? '无' : $twoauth['username'].'('.$twoauth['realname'].')');
						$dev['username'] = (empty($d['username']) ? '空用户' : $d['username']);
					}elseif($dev=$this->lgroup_resourcegrp_set->select_all('groupid='.$_SESSION['ADMIN_GROUP'].' AND resourceid IN (SELECT a.id FROM resourcegroup a LEFT JOIN resourcegroup b ON a.groupname=b.groupname WHERE a.devicesid=0 and b.devicesid='.$devicesid.')')){
						$dev=$dev[0];
						$twoauth = $this->member_set->select_by_id($dev['twoauth']);
						$dev['device_ip']=$d['device_ip'];
						$dev['port']=$d['port'];
						$dev['login_method']=$d['login_method'];
						$dev['result']=($return==1 ? '<font color="green">连接成功</font>' : '<font color="red">连接不成功</font>');
						$dev['forbidden_commands_groups'] = (empty($dev['forbidden_commands_groups']) ? '无' : $dev['forbidden_commands_groups']);
						$dev['weektime'] = (empty($dev['weektime']) ? '无' : $dev['weektime']);
						$dev['sourceip'] = (empty($dev['sourceip']) ? '无' : $dev['sourceip']);
						$dev['twoauth'] = (empty($dev['twoauth']) ? '无' : $twoauth['username'].'('.$twoauth['realname'].')');
						$dev['username'] = (empty($d['username']) ? '空用户' : $d['username']);
					}elseif($dev=$this->lgroup_resourcegrp_set->select_all('groupid='.$_SESSION['ADMIN_GROUP'].' AND resourceid IN (SELECT a.id FROM resourcegroup a LEFT JOIN resourcegroup b ON a.groupname=b.groupname left join servers s ON b.groupid=s.groupid  WHERE a.devicesid=0 and b.devicesid=-1 and s.device_ip="'.$ip.'")')){
						$dev=$dev[0];
						$twoauth = $this->member_set->select_by_id($dev['twoauth']);
						$dev['device_ip']=$d['device_ip'];
						$dev['port']=$d['port'];
						$dev['login_method']=$d['login_method'];
						$dev['result']=($return==1 ? '<font color="green">连接成功</font>' : '<font color="red">连接不成功</font>');
						$dev['forbidden_commands_groups'] = (empty($dev['forbidden_commands_groups']) ? '无' : $dev['forbidden_commands_groups']);
						$dev['weektime'] = (empty($dev['weektime']) ? '无' : $dev['weektime']);
						$dev['sourceip'] = (empty($dev['sourceip']) ? '无' : $dev['sourceip']);
						$dev['twoauth'] = (empty($dev['twoauth']) ? '无' : $twoauth['username'].'('.$twoauth['realname'].')');
						$dev['username'] = (empty($d['username']) ? '空用户' : $d['username']);
					}

				}
			}
			$this->assign("c", $dev);
			$this->display('test_port.tpl');
		}else{
			if($return==1){
				alert_and_back('连接成功');
				exit;
			}else{
				alert_and_back('连接不成功');
				exit;
			}
		}
	}

	function async_account(){
		$ip = get_request('ip', 0, 1);
		echo $cmd = "async ".$ip." 8888";
		$rs = asyncAccount($cmd);var_dump($rs);
		$rs = str_replace("\r", "", $rs);
		$rs = str_replace("\n", "", $rs);
		//var_dump($rs);
		if($rs < 0){
			echo '连接服务器失败';
			//alert_and_back('连接服务器失败');
		}elseif(substr($rs, 0, 1) == 0){
			echo '操作失败:'.substr($rs, 2);
			//alert_and_back('操作失败:'.substr($rs, 2));
		}elseif(substr($rs, 0, 1) == 1){
			echo '操作成功:'.substr($rs, 2);
			//alert_and_back('操作成功:'.substr($rs, 2));
		}
	}

	function async_config(){
		$ip = get_request('ip', 0, 1);
		$cmd = "async ".$ip." 8888 3";
		$rs = asyncAccount($cmd);
		$rs = str_replace("\r", "", $rs);
		$rs = str_replace("\n", "", $rs);
		if($rs < 0){
			echo '连接服务器失败';
			//alert_and_back('连接服务器失败');
		}elseif(substr($rs, 0, 1) == 0){
			echo '操作失败:'.substr($rs, 2);
			//alert_and_back('操作失败:'.substr($rs, 2));
		}elseif(substr($rs, 0, 1) == 1){
			echo '操作成功:'.substr($rs, 2);
			//alert_and_back('操作成功:'.substr($rs, 2));
		}
	}

	function update_userpriority_cache($uid){return ;
		$uid = intval($uid);
		$user = $this->member_set->select_by_id($uid);
		$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$uid.($force_fit ? " AND devicesid IN(select d.id  FROM devices d left join servers s ON d.device_ip=s.device_ip where s.id IN(".implode(',',$servers_arr).")) " : " AND 1 ");
		$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".intval($user['groupid']).($force_fit ? " AND devicesid IN(select d.id FROM devices d left join servers s ON d.device_ip=s.device_ip where s.id IN(".implode(',',$servers_arr)."))  " : " AND 1 ");
		$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$uid." AND ".($force_fit ? "a.resourceid IN(".implode(',', $resources_arr).")" : '1=1').")";
		$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".intval($user['groupid'])." AND ".($force_fit ? "a.resourceid IN(".implode(',', $resources_arr).")" : '1=1').")";
		$alldevid = $this->member_set->base_select($sql);
		$alldevsid = array();
		for($i=0; $i<count($alldevid); $i++){
			$alldevsid[]=$alldevid[$i]['devicesid'];
		}
		if(empty($alldevsid)){
			$alldevsid[]=0;
		}
		//$where .=" AND devices.id IN(".implode(',', $alldevsid).")";
		if($gid){
			if($logintype!='_apppub'){
				$where .= " AND servers.groupid='$gid'";
			}
		}
		
		if($resgroup){
			$where .= ' AND devices.id IN(SELECT devicesid FROM resourcegroup WHERE devicesid!=0 AND groupname="'.$resgroup.'" )';
		}

		if($force_fit&&is_array($servers_arr)){
			//$where .= " AND servers.id IN(".implode(',',$servers_arr).")";
		}
		
		$where2 = $where ." AND devices.id IN(".implode(',', $alldevsid).")";
		$this->server_set->query("DELETE FROM devices_cache WHERE memberid='".$uid."'");
		$this->server_set->query("DELETE FROM devices_group_cache WHERE memberid='".$uid."'");

		$alldev = $this->server_set->query("INSERT INTO devices_cache(  `memberid`, `devicesid` ,  `device_ip`,  `login_method`,  `hostname`,  `username`,  `old_password`,  `cur_password`,  `last_update_time` ,  `port`,  `device_type` ,  `enable` ,  `limit_time`,  `automodify`,  `luser` ,  `master_user` ,  `log_tab` ,  `passwordtry` ,  `changesure` ,  `lgroup` ,  `autosu` ,  `entrust_password`,  `change_password` ,  `entrust_username` ,  `publickey_auth`,  `radiususer` ,  `encoding`,  `sshprivatekey`,  `sshpublickey`,  `sftp` ,  `first_prompt`, `groupid`, `desc`) SELECT  ".$uid.", devices.`id` ,devices.`device_ip`,devices.`login_method`,devices.`hostname`,devices.`username`,devices.`old_password`,devices.`cur_password`,devices.`last_update_time` ,devices.`port`,devices.`device_type` ,devices.`enable` ,devices.`limit_time`,devices.`automodify`,devices.`luser` ,devices.`master_user` ,devices.`log_tab` ,devices.`passwordtry` ,devices.`changesure` ,devices.`lgroup` ,devices.`autosu` ,devices.`entrust_password`,devices.`change_password` ,devices.`entrust_username` ,devices.`publickey_auth`,devices.`radiususer` ,devices.`encoding`,devices.`sshprivatekey`,devices.`sshpublickey`,devices.`sftp` ,devices.`first_prompt`,servers.`groupid`, devices.desc FROM `devices` LEFT JOIN ($sql) d ON devices.id=d.devicesid LEFT JOIN servers ON devices.device_ip=servers.device_ip AND devices.hostname=servers.hostname WHERE d.devicesid IS NOT NULL $groupby ORDER BY devices.device_ip ASC");

		$this->server_set->query("INSERT INTO devices_group_cache(memberid, groupid, groupname, ct, ldapid) SELECT ".$uid.",sg.id, sg.groupname,t.sct,sg.ldapid FROM servergroup sg LEFT JOIN (SELECT s.groupid,count(*) sct FROM devices d LEFT JOIN (SELECT devicesid FROM luser WHERE memberid=".$uid." UNION SELECT devicesid FROM lgroup WHERE groupid=".intval($user['groupid'])." UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM luser_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.memberid=".$uid.") UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM lgroup_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.groupid=".intval($user['groupid']).")) dd ON d.id=dd.devicesid LEFT JOIN servers s ON d.device_ip=s.device_ip WHERE dd.devicesid IS NOT NULL and d.login_method!=26 group by s.groupid ) t ON sg.id=t.groupid Where 1=1 AND t.sct > 0 ORDER BY sg.groupname ASC");
	}

	function autofind(){
		if($_POST['ip']){
			set_time_limit(0);
			loading_start();
			@exec("sudo /home/wuxiaolong/servers_nmap/servers_nmap.pl ".$_POST['ip']);
			loading_end();
			go_url("admin.php?controller=admin_pro&action=displayautofind");
			exit;
		}
		$this->display("autofind.tpl");
	}

	function displayautofind(){
		global $_CONFIG;
		require_once('./include/select_sgroup_ajax.inc.php');
		if($ori_g_id){
			$_tmpgid = $this->sgroup_set->select_all("id IN(".(is_array($ori_g_id)?implode(',', $ori_g_id): $ori_g_id).")");
			$__tmpgid = $ori_g_id;
			for($i=0; $i<count($_tmpgid); $i++){
				$__tmpgid .= ','.$_tmpgid[$i]['child'];
			}
			$where .= ' AND s.groupid IN('.$__tmpgid.')';
		}

		$servers = $this->servers_nmap_set->base_select("SELECT a.id,a.ip,a.scan_time,b.device_type FROM ".$this->servers_nmap_set->get_table_name()." a LEFT JOIN ".$this->tem_set->get_table_name()." b ON a.device_type=b.id ORDER BY inet_aton(a.ip) ASC");
		$this->assign("servers", $servers);
		$this->assign("allgroup", $allgroup);
		$this->assign("_config", $_CONFIG);
		$this->display("displayautofind.tpl");
	}

	function displayautofind_save(){
		//echo '<pre>';var_dump($_POST);echo '</pre>';
		for($i=0; $i<count($_POST['id']); $i++){
			$s = $this->servers_nmap_set->select_by_id($_POST['id'][$i]);
			if(in_array($s['ip'], $_POST['ips'])){
				if(empty($_POST['groupid'.$i])){
					$error[]=$s['ip'].':没有选择组\n';
					continue;
				}
				if($this->server_set->select_count("device_ip='".$s['ip']."'")<=0){
					$server = new server();
					$server->set_data('device_ip', $s['ip']);
					$server->set_data('device_type', $s['device_type']);
					$server->set_data('hostname', $_POST['hostname'][$i]);
					$server->set_data('groupid', $_POST['groupid'.$i]);
					$this->server_set->add($server);
					$this->servers_nmap_set->delete($s['id']);
				}else{
					$error[]=$s['ip'].':地址已经存在\n';
				}
			}
		}
		//var_dump($error);
		//exit;
		if($error){
			alert_and_close('部分添加失败:\n'.implode('\n',$error).'\n');
		}else{
			alert_and_close('导入成功');
		}
	}

	function xzuser(){
		//$usergroup = $this->usergroup_set->select_all("1 ".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		//$this->assign('allsgroup', $usergroup);
		require('./include/select_sgroup_ajax.inc.php');
		$allmembers = $this->member_set->select_all();
		$this->assign('allmem',$allmembers);
		$this->display("xzuser.tpl");
	}

	function batchserverpriorityedit(){
		global $_CONFIG;
		$groupidname = 'sgroupid';
		$$groupidname = $_GET['sgroupid'];
		require_once('./include/select_sgroup_ajax.inc.php');
		$prefgroupid=get_request('prefgroupid');
		$device_ip=get_request('device_ip', 0, 1);

		//var_dump($_POST);
		$where = '1';
		if($sgroupid){
			$_tmpgid = $this->sgroup_set->select_by_id($sgroupid);
			$where .= ' AND groupid IN('.$_tmpgid['child'].')';
		}
		if($prefgroupid){
			if($_GET['ip'])
			$_SESSION['BATCHPRIORITYEDIT']['GROUP'][$prefgroupid]=$_GET['ip'];
		}else{
			if($_GET['ip'])
			$_SESSION['BATCHPRIORITYEDIT']['ALL']=$_GET['ip'];
		}
		if($device_ip){
			$where .= " AND device_ip like '%$device_ip%'";
		}
		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			if(empty($_SESSION['ADMIN_MUSERGROUP'])){
				alert_and_back('没有可管理的组','admin.php?controller=admin_session');
				exit;
			}
			$where .= "  AND groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).") AND uid!=".$_SESSION['ADMIN_UID'];
		}
		$device_types = $this->tem_set->select_all("device_type!=''");
		$allservers = $this->server_set->select_all($where, 'INET_ATON(device_ip)', 'asc');
		$this->assign("allservers", $allservers);
		$this->assign("device_types", $device_types);
		$this->assign("type", $type);
		$this->assign("_config", $_CONFIG);
		$this->assign('servergroup', $fgroupid);
		$this->assign('device_ip', $device_ip);
		$this->display('batchserverpriorityedit.tpl');
	}

	function batchserverpriorityeditsave(){
		global $_CONFIG;
		//var_dump($_POST);
		$groupid = intval($_POST['groupid']);
		
		for($i=0; $i<count($_POST['enable']); $i++){
			switch($_POST['enable'][$i]){
				case 'usergroup':
					$set .='groupid='.$groupid.',';
					break;
				case 'device_type':
					$set .='device_type='.get_request('device_type', 1, 0).',';
					break;
				case 'stra_type':
					$new_freq = get_request('freq', 1, 1);
					$new_type = get_request('stra_type', 1, 1);
					switch($new_type) {
						case 'mon' :
							$set.='month="'.$new_freq.'",';
							$set.='week="",';
							$set.='user_define="",';
							break;
						case 'week':
							$set.='week="'.$new_freq.'",';
							$set.='month="",';
							$set.='user_define="",';
							break;
						case 'custom':
							$set.='user_define="'.$new_freq.'",';
							$set.='week="",';
							$set.='month="",';
						default:
					}
					break;
				case 'superpassword':
					if(get_request('superpassword',1,1)!=get_request('superpassword2',1,1)){
						alert('两次输入的密码不一致!');
						exit;
					}
					$set .="superpassword=".(!$_CONFIG['PASSWORD_ENCRYPT_TYPE'] ? "udf_encrypt('".get_request('superpassword',1,1)."')" : "AES_ENCRYPT('".get_request('superpassword',1,1)."'").",'".$_CONFIG['PASSWORD_KEY']."'),";
					break;
				case 'sshport':
					$set .='sshport="'.get_request('sshport',1,0).'",';
					break;
				case 'telnetport':
					$set .='telnetport="'.get_request('telnetport',1,0).'",';
					break;
				case 'rdpport':
					$set .='rdpport="'.get_request('rdpport',1,0).'",';
					break;
				case 'vncport':
					$set .='vncport="'.get_request('vncport',1,0).'",';
					break;
				case 'ftpport':
					$set .='ftpport="'.get_request('ftpport',1,0).'",';
					break;
				case 'x11port':
					$set .='x11port="'.get_request('x11port',1,0).'",';
					break;
			}
		}
		$set=substr($set,0,strlen($set)-1);
		//var_dump($set);exit;
		//$_POST['uid']=array(0);
		$uids=array();
		if($_POST['fgroupid']||$_POST['secend']){
			if($_POST['fgroupid']){
				$_SESSION['BATCHPRIORITYEDIT']['GROUP'][$_POST['fgroupid']]=$_POST['secend'];
				foreach($_SESSION['BATCHPRIORITYEDIT']['GROUP'] AS $k => $v){
					if($v)
					$uids=array_merge($uids, $v);
				}
			}else{
				$uids=$_POST['secend'];
			}
			if($_POST['submit']=='批量导出'){
				$this->export_pass("servers.device_ip IN(\"".implode('","', $uids)."\")");
			}elseif($_POST['submit']=='批量删除'){
				$_GET['frombatchpriorityedit']=1;
				$serverids = $this->server_set->select_all("device_ip IN(\"".implode('","', $uids)."\")");
				for($iii=0; $iii<count($serverids); $iii++){
					$sids[]=$serverids[$iii]['id'];
				}
				$_POST['chk_member']=$sids;
				$this->dev_del();
			}else{
				$this->member_set->query("UPDATE servers set $set WHERE device_ip IN(\"".implode('","', $uids)."\")");
				alert_and_back('操作成功','admin.php?controller=admin_pro&action=batchserverpriorityedit');
			}
		}else{
			alert_and_back('请选择用户');
		}
	}

	function batchdevicepriorityedit(){
		global $_CONFIG;
		$groupidname = 'sgroupid';
		$$groupidname = $_GET['sgroupid'];
		require_once('./include/select_sgroup_ajax.inc.php');
		$prefgroupid=get_request('prefgroupid');
		$username=get_request('username', 0, 1);

		//var_dump($_POST);
		$where = '1';
		if($sgroupid){
			$_tmpgid = $this->sgroup_set->select_by_id($sgroupid);
			$where .= ' AND device_ip IN(select device_ip from servers where groupid IN('.$_tmpgid['child'].'))';
		}
		if($prefgroupid){
			if($_GET['ip'])
			$_SESSION['BATCHPRIORITYEDIT']['GROUP'][$prefgroupid]=$_GET['ip'];
		}else{
			if($_GET['ip'])
			$_SESSION['BATCHPRIORITYEDIT']['ALL']=$_GET['ip'];
		}
		if($username){
			$where .= " AND username like '%$username%'";
		}
		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			if(empty($_SESSION['ADMIN_MUSERGROUP'])){
				alert_and_back('没有可管理的组','admin.php?controller=admin_session');
				exit;
			}
			$where .= ' AND device_ip IN(select device_ip from servers where groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).'))';
			//$where .= "  AND groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).") AND uid!=".$_SESSION['ADMIN_UID'];
		}
		$alldevices = $this->devpass_set->select_all($where, 'INET_ATON(device_ip)', 'asc');
		$where = " login_method IN('ssh','RDP','telnet','ftp','ssh1','vnc','x11','rlogin','apppub')";
		$allmethod =  $this->tem_set->select_all($where,'','ASC');	
		$allmembers = $this->member_set->select_all('1', 'username', 'asc');
		for($i=0; $i<count($alldevices); $i++){
			for($j=0; $j<count($allmethod); $j++){
				if($alldevices[$i]['login_method']==$allmethod[$j]['id']){
					$alldevices[$i]['lmethod']=$allmethod[$j]['login_method'];
				}
			}
		}
		$this->assign('sshport',$device[0]['sshport'] ? $device[0]['sshport'] : '22');
		$this->assign('telnetport',$device[0]['telnetport']? $device[0]['telnetport'] : '23');
		$this->assign('ftpport',$device[0]['ftpport']? $device[0]['ftpport'] : '21');
		$this->assign('rdpport',$device[0]['rdpport']? $device[0]['rdpport'] : '3389');
		$this->assign('vncport',$device[0]['vncport']? $device[0]['vncport'] : '5901');
		$this->assign('x11port',$device[0]['x11port']? $device[0]['x11port'] : '3389');
		$this->assign('allmembers',$allmembers);
		$this->assign("alldevices", $alldevices);
		$this->assign("allmethod", $allmethod);
		$this->assign("device_types", $device_types);
		$this->assign("type", $type);
		$this->assign("_config", $_CONFIG);
		$this->assign('servergroup', $fgroupid);
		$this->assign('device_ip', $device_ip);
		$this->display('batchdevicepriorityedit.tpl');
	}

	function batchdevicepriorityeditsave(){
		//var_dump($_POST);
		$groupid = intval($_POST['groupid']);
		$alltem = $this->tem_set->select_all();
		for($i=0; $i<count($_POST['enable']); $i++){
			switch($_POST['enable'][$i]){
				case 'l_id':
					$sftp = get_request('sftp',1,0);
					$login_method = get_request('l_id',1,0);
					$set .='login_method='.$login_method.',';
					$set .='sftp='.$sftp.',';
					foreach($alltem as $tem) {
						if($login_method == $tem['id']&&strtolower($tem['login_method'])=='web') {
							$logintab = new logintab();
							$logintab->set_data("url", $weburl);
							$logintab->set_data("userID", $webuser);
							$logintab->set_data("pwdID", $webpwd);
							$this->logintab_set->add($logintab);
							$logintabid = mysql_insert_id();
							$set .='log_tab='.$logintabid.',';					
						}
					}	
					break;
				case 'port':
					$port = get_request('port',1,0);
					$set .='port='.$port.',';
					break;
				case 'limit_time':
					$nolimit = get_request('nolimit',1,0);
					$limit_time = get_request('limit_time',1,1);
					if($nolimit ) {
						$set .='limit_time="9999-00-00",';
					}
					else {
						if($limit_time != '') {
							$set .='limit_time="'.$limit_time.'",';
						}
						else {
							$set .='limit_time="0000-00-00",';
						}
					}
					break;
				case 'encoding':
					$set .='encoding="'.get_request('encoding',1,0).'",';
					break;
				case 'commanduser':
					$set .='commanduser="'.get_request('commanduser',1,0).'",';
					break;
				case 'mode':
					$set .='mode="'.get_request('mode',1,0).'",';
					break;
				case 'enable':
					$set .='enable="'.get_request('enable',1,0).'",';
					break;
				case 'automp':
					$set .='automodify="'.get_request('auto',1,0).'",';
					break;
				case 'automp2':
					$set .='master_user="'.get_request('automu',1,0).'",';
					break;
				case 'su_passwd':
					$set .='su_passwd="'.get_request('su_passwd',1,0).'",';
					break;
				case 'entrust_password':
					$set .='entrust_password="'.get_request('entrust_password',1,0).'",';
					break;
				case 'logincommit':
					$set .='logincommit="'.get_request('logincommit',1,0).'",';
					break;
				case 'publickey_auth':
					$set .='publickey_auth="'.get_request('publickey_auth',1,0).'",';
					break;
				case 'ipv6enable':
					$set .='ipv6enable="'.get_request('ipv6enable',1,0).'",';
					break;
				case 'key_input':
					$set .='key_input="'.get_request('key_input',1,0).'",';
					break;
				case 'fastpath_input':
					$set .='fastpath_input="'.get_request('fastpath_input',1,0).'",';
					break;
				case 'fastpath_output':
					$set .='fastpath_output="'.get_request('fastpath_output',1,0).'",';
					break;
			}
		}
		$set=substr($set,0,strlen($set)-1);
		//var_dump($set);exit;
		//$_POST['uid']=array(0);
		$uids=array();
		if($_POST['fgroupid']||$_POST['secend']){
			if($_POST['fgroupid']){
				$_SESSION['BATCHPRIORITYEDIT']['GROUP'][$_POST['fgroupid']]=$_POST['secend'];
				foreach($_SESSION['BATCHPRIORITYEDIT']['GROUP'] AS $k => $v){
					if($v)
					$uids=array_merge($uids, $v);
				}
			}else{
				$uids=$_POST['secend'];
			}
			if($_POST['submit']=='批量导出'){
				$this->export_pass("d.id IN(".implode(',', $uids).")");
			}elseif($_POST['submit']=='批量删除'){
				$_GET['frombatchdevicepriorityedit']=1;
				$_POST['chk_member']=$uids;
				$this->devpass_del();
			}else{
				$this->member_set->query("UPDATE devices set $set WHERE id IN(".implode(',', $uids).")");
				alert_and_back('操作成功','admin.php?controller=admin_pro&action=batchdevicepriorityedit');
			}
		}else{
			alert_and_back('请选择用户');
		}
	}
	
	function sshkey_sync(){
		exec('/home/wuxiaolong/sshkeyname/sshkeyname.pl');
		alert_and_back('操作成功');
		
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
