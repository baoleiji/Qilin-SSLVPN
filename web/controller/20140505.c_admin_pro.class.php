<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_pro extends c_base {
	function dev_index() {
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
			$where .= " AND (servers.groupid = $gid OR servers.groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=$gid) ) OR servers.groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=$gid) )";
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
			$where .= " AND servers.groupid>0 AND servers.groupid = (SELECT mservergroup FROM ".$this->member_set->get_table_name()." WHERE uid=".$_SESSION['ADMIN_UID'].") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=(SELECT mservergroup FROM ".$this->member_set->get_table_name()." WHERE uid=".$_SESSION['ADMIN_UID'].")) or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=(SELECT mservergroup FROM ".$this->member_set->get_table_name()." WHERE uid=".$_SESSION['ADMIN_UID']."))) ";
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
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$this->assign('nowseconds', mktime());
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('gid', $gid);
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
			$where .= " AND servers.groupid>0 AND servers.groupid = (SELECT mservergroup FROM ".$this->member_set->get_table_name()." WHERE uid=".$_SESSION['ADMIN_UID'].")";
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
		$newpager = new my_pager($row_num, $page_num, 50, 'page');
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

		$this->assign('nowseconds', mktime());
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
			$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
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
					if($allgroup)
					foreach($allgroup as $groupt){
						if($groupt[id]==$report[groupid]){
							$report[groupname]=$groupt[groupname];
							break;
						}
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
		$str = mb_convert_encoding($str, "GB2312", "UTF-8");
		fwrite($handle, $str);
		fclose($handle);
		go_url("tmp/ReportList.xls?c=" . rand());
		exit;
	}
	
	function groupadddev(){
		$gid = get_request("gid");
		$alldev = $this->server_set->select_all(' id NOT IN (SELECT id FROM '.$this->server_set->get_table_name().' WHERE groupid='.$gid.')');
		$this->assign("gid", $gid);
		$this->assign("title", language("增加设备"));
		$this->assign("alldev", $alldev);
		$this->assign('groupinfo', $this->sgroup_set->select_by_id($gid));
		$this->display('groupadddev.tpl');
	}
	
	function groupadddev_save(){
		$gid = get_request("gid");
		$this->server_set->query("UPDATE ".$this->server_set->get_table_name()." SET groupid=".$gid." WHERE id IN (".implode(',', $_POST['id']).")");
		alert_and_back('添加成功','admin.php?controller=admin_pro&action=dev_index&gid='.$gid);
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
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		$page_num = get_request('page');
		$id = get_request('id');
		$gid = get_request('gid');
		$tab = get_request('tab');
		$appconfigedit = get_request('appconfigedit');
		$appconfigid = get_request('appconfigid');

		$allmethod =  $this->tem_set->select_all("device_type = ''");
		$alltype = $this->tem_set->select_all("login_method = ''", 'device_type', 'asc');
		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)",'username','ASC');
		$allgroup = $this->sgroup_set->select_all(empty($_SESSION['ADMIN_MSERVERGROUP']) ? '1=1' : 'id='.$_SESSION['ADMIN_MSERVERGROUP']." or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].") or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].")) ",'groupname', 'asc');
		$num = count($allmem);
		for($i=0;$i<$num;$i++) {
			$allmem[$i]['username'] = ($allmem[$i]['username']);
		}
		if($appconfigid){
			$appconfig = $this->snmp_app_config_set->select_by_id($appconfigid);
			$this->assign("appconfig1", $appconfig);
		}

		$allsgroup = $this->sgroup_set->select_all(empty($_SESSION['ADMIN_MSERVERGROUP']) ? '1=1' : 'id='.$_SESSION['ADMIN_MSERVERGROUP']." or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].") or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].")) ",'groupname', 'asc', 'groupname', 'asc');			
		$this->assign('allsgroup',$allsgroup);
		
		if($gid){
			$sgroup = $this->sgroup_set->select_by_id($gid);
			if($sgroup['level']==1){
				$this->assign('ldapid1', $gid);
				$this->assign('ldapid2', 0);
				$this->assign('servergroup', 0);
			}elseif($sgroup['level']==2){
				$this->assign('ldapid1', $sgroup['ldapid']);
				$this->assign('ldapid2', $gid);
				$this->assign('servergroup', 0);
			}else{
				$this->assign('servergroup', $gid);
				$sgroup = $this->sgroup_set->select_by_id($sgroup['ldapid']);
				if($sgroup['level']==1){
					$this->assign('ldapid1', $sgroup['id']);
					$this->assign('ldapid2', 0);
				}elseif($sgroup['level']==2){
					$this->assign('ldapid1', $sgroup['ldapid']);
					$this->assign('ldapid2', $sgroup['id']);
				}
			}
			$this->assign('sgroup',$sgroup);
		}
		if($id != 0) {
			$this->assign('id',$id);
			$old_dev = $this->server_set->select_by_id($id);
			if($tab!=4){
				$_SESSION['dev_edit_appconfig']=$this->snmp_app_config_set->select_all("device_ip='".$old_dev['device_ip']."'", "app_name", "ASC");
			}
			if($old_dev['groupid']){
				$sgroup = $this->sgroup_set->select_by_id($old_dev['groupid']);		
				if($sgroup['level']==1){
					$this->assign('ldapid1', $old_dev['groupid']);
					$this->assign('ldapid2', 0);
					$this->assign('servergroup', 0);
				}elseif($sgroup['level']==2){
					$this->assign('ldapid1', $sgroup['ldapid']);
					$this->assign('ldapid2', $old_dev['groupid']);
					$this->assign('servergroup', 0);
				}else{
					$this->assign('servergroup', $old_dev['groupid']);
					$sgroup1 = $this->sgroup_set->select_by_id($sgroup['ldapid']);
					if($sgroup1['level']==1){
						$this->assign('ldapid1', $sgroup1['id']);
						$this->assign('ldapid2', 0);
					}elseif($sgroup1['level']==2){
						$this->assign('ldapid1', $sgroup1['ldapid']);
						$this->assign('ldapid2', $sgroup1['id']);
					}
				}
				$this->assign('sgroup',$sgroup);
			}
			$_SERVER['QUERY_STRING'] .= "&tab=0";
			$where = "ip='".$old_dev['device_ip']."'";
			$row_num = $this->account_linuxusers_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
			$this->assign('vncport',$old_dev['vncport']? $old_dev['vncport'] : '3389');
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
		$this->assign('appconfigid',$appconfigid);
		$this->assign('allmethod',$allmethod);
		$this->assign('allpasses',$allmem);
		$this->assign('allgroup',$allgroup);
		$this->assign('alltype',$alltype);
		$this->assign('alldev',$alldev);
		$this->assign('gid',$gid);
		$this->assign('loadbalanceips',$loadbalanceips);
		$this->assign('appconfig', $_SESSION['dev_edit_appconfig']);
		$this->assign('title',language("管理设备"));
		$this->display('dev_edit.tpl');
	}


	function devbatchadd() {		
		
		$id = get_request('id');
		$gid = get_request('gid');
		$allmethod =  $this->tem_set->select_all("device_type = ''");
		$alltype = $this->tem_set->select_all("login_method = ''");
		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)",'username','ASC');
		$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		$num = count($allmem);
		for($i=0;$i<$num;$i++) {
			$allmem[$i]['username'] = ($allmem[$i]['username']);
		}
			
		$this->assign('allmethod',$allmethod);
		$this->assign('allpasses',$allmem);
		$this->assign('allgroup',$allgroup);
		$this->assign('alltype',$alltype);
		$this->assign("gid", $gid);
		$this->assign('title',language("管理设备"));
		$this->display('devbatchadd.tpl');
	}
	
	function batchdevsave(){
		global $_CONFIG;

		for($i=0; $i<count($_POST['address']); $i++){
			if(empty($_POST['address'][$i])){
				continue;
			}
			if(!is_ip($_POST['address'][$i])){
				$error[]=$_POST['address'][$i].':地址格式不正确\n';
				continue;
			}
			if(0 == $this->server_set->select_count("device_ip = '".$_POST['address'][$i]."' ")) {
					$new_dev = new server();
					$new_dev->set_data('device_ip',$_POST['address'][$i]);
					$new_dev->set_data('hostname',$_POST['hostname'][$i]);
					$new_dev->set_data('device_type',$_POST['type_id'][$i]);
					$new_dev->set_data('login_method',0);
					$new_dev->set_data('groupid',$_POST['g_id'][$i]);
					if($_SESSION['ADMIN_LEVEL']==3){
						$newmember->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
					}
					$new_dev->set_data('sshport','22');
					$new_dev->set_data('telnetport', '23');
					$new_dev->set_data('ftpport', '21');
					$new_dev->set_data('rdpport','3389');
					$new_dev->set_data('vncport','3389');
					$new_dev->set_data('month','1');
					$new_dev->set_data('port','0');
					$this->sgroup_set->insert_user($_POST['g_id'][$i]);
					
					$this->server_set->add($new_dev);
					
					$serverResult = $this->server_set->select_all(" groupid=".$_POST['g_id'][$i]);
					if($serverResult){
						foreach ($serverResult AS $key => $value){
							$serverIds[] = $value['id'];
						}
					}
					$serverString=implode(",", $serverIds);
					$this->member_set->update('devs', ",".$serverString.",", " mservergroup=".$_POST['g_id'][$i]." and level=3");
		
					$adminlog = new admin_log();
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
					$adminlog->set_data('action', language('增加'));
					$adminlog->set_data('resource', $_POST['address'][$i]);
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
			alert_and_back($msg,'admin.php?controller=admin_pro&action=dev_index');
		}else{
			alert_and_back('添加失败:\n'.implode('\n',$error).'\n');
		}
	}

	function devbatchedit(){
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
	
	function dev_save() {
		global $_CONFIG;
		$new_ip = get_request('IP',1,1);
		$new_hostname = get_request('hostname',1,1);
		$new_method = get_request('l_id',1,0);
		$new_devtype = get_request('type_id',1,0);
		$ipv6 = get_request('ipv6',1,0);
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
		$superpassword = get_request('superpassword',1,1);
		$superpassword2 = get_request('superpassword2',1,1);
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
		$app_get = get_request('app_get',1,1);
		$apache_type = get_request('apache_type',1,1);
		$mysql_type = get_request('mysql_type',1,1);
		$url = get_request('url',1,1);
		$username = get_request('username',1,1);
		$password = get_request('password',1,1);
		$port = get_request('port',1,1);
		$enable = get_request('enable',1,1);
		
		/*
		$new_user = ',';
		for($i=1;$i<6;$i++) {
			$new_user .= get_request("user$i",1,0).',';
		}
		*/
		$new_group = get_request('g_id',1,0);
		$ldapid1 = get_request('ldapid1',1,0);
		$ldapid2 = get_request('ldapid2',1,0);
		if(empty($new_group)){
			if($ldapid2){
				$new_group = $ldapid2;
			}else if($ldapid1){
				$new_group = $ldapid1;
			}
		}
		
		$id = get_request('id');
		$apcid = get_request('appconfigid');
		if($doappconfigedit){
			$found = 0;
			for($i=0; $i<count($_SESSION['dev_edit_appconfig']); $i++){
				if($_SESSION['dev_edit_appconfig'][$i]['seq']==$apcid || $_SESSION['dev_edit_appconfig'][$i]['app_name'] == $app_name){					
					$_SESSION['dev_edit_appconfig'][$i]['app_get'] = $app_get;
					$_SESSION['dev_edit_appconfig'][$i]['url'] = $url;
					$_SESSION['dev_edit_appconfig'][$i]['app_type'] = ${$app_name.'_type'};
					$_SESSION['dev_edit_appconfig'][$i]['username'] = $username;
					$_SESSION['dev_edit_appconfig'][$i]['password'] = $password;
					$_SESSION['dev_edit_appconfig'][$i]['port'] = $port;
					$_SESSION['dev_edit_appconfig'][$i]['enable'] = $enable;
					$found = 1;
				}
			}
			if($found==0){
				$len = count($_SESSION['dev_edit_appconfig']);
				$_SESSION['dev_edit_appconfig'][$len]['app_name'] = $app_name;
				$_SESSION['dev_edit_appconfig'][$len]['app_get'] = $app_get;
				$_SESSION['dev_edit_appconfig'][$len]['url'] = $url;
				$_SESSION['dev_edit_appconfig'][$len]['app_type'] = ${$app_name.'_type'};
				$_SESSION['dev_edit_appconfig'][$len]['username'] = $username;
				$_SESSION['dev_edit_appconfig'][$len]['password'] = $password;
				$_SESSION['dev_edit_appconfig'][$len]['port'] = $port;
				$_SESSION['dev_edit_appconfig'][$len]['enable'] = $enable;				
			}
			alert_and_back('已记录','admin.php?controller=admin_pro&action=dev_edit&id='.$id.'&gid='.$gid.'&tab=4');
			exit;
		}
		if(!is_ip($new_ip)){
			alert_and_back('请输入正确的IP地址格式');
			exit;
		}
		if($superpassword!=$superpassword2){
			alert_and_back('两次输入的密码不一致');
			exit;
		}
		if($superpassword){
			$pwd_ban_word_arr = explode('1', $_CONFIG['PASSWORD_BAN_WORD']);			
			if($pwd_ban_word_arr){
				$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
			}			
			for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
				if($pwd_ban_word_arr[$pi]&&strpos($superpassword, $pwd_ban_word_arr[$pi])!==false){
					alert_and_back('密码中不能包含以下字符:'.addslashes($pwd_ban_word_str).' 请重新输入');
					exit;
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
					if($_SESSION['ADMIN_LEVEL']==3){
						$new_dev->set_data("groupid", $_SESSION['ADMIN_MSERVERGROUP']);
					}

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
					$adminlog->set_data('action', language('增加'));
					$adminlog->set_data('resource', $new_ip);
					$this->admin_log_set->add($adminlog);

					$this->appconfig_save($new_ip);
					$this->server_set->query("UPDATE ".$this->sgroup_set->get_table_name()." a SET count=(select count(*) FROM ".$this->server_set->get_table_name()." b WHERE a.id=b.groupid) where a.id='".$new_group."'");
					echo '<script>window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=dev_server";</script>';
					alert_and_back('添加成功','admin.php?controller=admin_pro&action=dev_index');
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
				if($_SESSION['ADMIN_LEVEL']==3){
					$new_dev->set_data("groupid", $_SESSION['ADMIN_MSERVERGROUP']);
				}
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

				
				$this->appconfig_save($old_dev['device_ip']);
				$adminlog = new admin_log();
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('action', '修改');
				$adminlog->set_data('resource', $new_ip);
				$this->admin_log_set->add($adminlog);
				$this->server_set->query("UPDATE ".$this->sgroup_set->get_table_name()." a SET count=(select count(*) FROM ".$this->server_set->get_table_name()." b WHERE a.id=b.groupid) where a.id='".$new_group."'");
				alert_and_back('修改成功','admin.php?controller=admin_pro&action=dev_index');
		}
	}

	function appconfig_save($device_ip){
		for($i=0; $i<count($_SESSION['dev_edit_appconfig']); $i++){
			$appconfig = new snmp_app_config();
			$appconfig->set_data('device_ip', $device_ip);
			$appconfig->set_data('app_name', $_SESSION['dev_edit_appconfig'][$i]['app_name']);
			$appconfig->set_data('app_get', $_SESSION['dev_edit_appconfig'][$i]['app_get']);
			$appconfig->set_data('url', $_SESSION['dev_edit_appconfig'][$i]['url']);
			//$appconfig->set_data('app_type', $_SESSION['dev_edit_appconfig'][$i]['app_type']);
			$appconfig->set_data('username', $_SESSION['dev_edit_appconfig'][$i]['username']);
			$appconfig->set_data('password', $_SESSION['dev_edit_appconfig'][$i]['password']);
			$appconfig->set_data('port', $_SESSION['dev_edit_appconfig'][$i]['port']);
			$appconfig->set_data('enable', $_SESSION['dev_edit_appconfig'][$i]['enable']);
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
		$old_dev = $this->server_set->select_by_id($id);
		if(	 0 == $this->devpass_set->select_count("device_ip = '".$old_dev['device_ip']."' AND hostname = '".$old_dev['hostname']."'")) {
			$this->devpass_set->delete_all("device_ip='".$old_dev['device_ip']."' AND hostname='".$old_dev['hostname']."'");
			$this->server_set->delete($id);
			$this->sshkey_set->delete_all("devicesid IN(select id from ".$this->devpass_set->get_table_name()." WHERE device_ip IN('".$old_dev['device_ip']."'))");
			
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('action', language('删除'));
			$adminlog->set_data('resource', $old_dev['device_ip']);
			$this->admin_log_set->add($adminlog);
			$this->sgroup_set->remove_user($old_dev['groupid']);
			
			
			alert_and_back('删除成功','admin.php?controller=admin_pro&action=dev_index&gid='.$gid);
		}
		else {
			alert_and_back('删除失败,该设备还有用户','admin.php?controller=admin_pro&action=dev_index&gid='.$gid);
		}
	}
	
	function insertrandom($ip, $device_ip, $username, $luser, $time, $code){
		global $dbcharset, $_CONFIG;
		if($_CONFIG['RANDOM_DB']=='0'){
			$ip="127.0.0.1";
		}

		$lblink = @mysql_connect($ip, 'freesvr', 'freesvr');
		if(!$lblink){
			return false;
		}
		$flag = @mysql_select_db('audit_sec',$lblink);
		if(!$flag){
			return false;
		}
		@mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary", $lblink);
		$sql = "INSERT INTO random SET device_ip='".$device_ip."', username='".$username."', luser='".$luser."', time='".$time."', code='".$code."', inputusername='".$_SESSION['LOGIN_USERNAME']."', inputpassword=udf_encrypt('".$_SESSION['LOGIN_PASSWORD']."'), logincommit='".$_SESSION['COMMITID']."'";
		$flag = @mysql_query($sql, $lblink);
		@mysql_close($lblink);
		$_SESSION['LOGIN_USERNAME']=null;
		$_SESSION['LOGIN_PASSWORD']=null;
		$_SESSION['COMMITID']=null;
		return $flag;
	}

	function showtwoauth(){
		$this->assign("users", $_SESSION['TWOAUTH']);
		$this->assign("devicesid", $_SESSION['TWOAUTH_ID']);
		$this->assign("url", urlencode($_SESSION['TWOAUTH_URL']));
		$this->display('twoauth.tpl');
	}

	function dotwoauth(){
		$id = get_request('id', 1, 1);
		$username = get_request('username', 1, 1);
		$password = get_request('password', 1, 1);
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
		//echo '<script>window.opener.location.href="'.$url.'";window.close();</script>';
		echo '<script>window.parent.document.getElementById("hide").src="'.$url.'";'."\n".'window.parent.closeWindow();</script>';
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
		if(strtolower($tem['login_method']) == 'rdp'&&$rdptype=='activex'){
			echo '<script>window.location.href="'.$url.'";</script>';
		}else{
			echo '<script>window.parent.document.getElementById("hide").src="'.$url.'";'."\n".'window.parent.closeWindow();</script>';
		}
		exit;
	}

	function showdesc(){
		$id = get_request('id');
		$devinfo = $this->devpass_set->select_by_id($id);
		$this->assign('devinfo', $devinfo);
		$this->assign('id', $id);
		$this->display('devdesc.tpl');
	}

	function dodevdesc(){
		$id = get_request('id', 1, 0);
		$desc = get_request('desc', 1, 1);
		$devpass = new devpass();
		$devpass->set_data('desc', $desc);
		$devpass->set_data('id', $id);
		$this->devpass_set->edit($devpass);
		echo '<script>alert(\'操作成功\');window.parent.closeWindow();window.parent.location.reload();</script>';
		exit;
	}

	function showinputauth(){
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
		$this->assign("saveedit", $_COOKIE['saveedit']);
		$this->display('inputauth.tpl');
	}

	function doinputauth(){
		$id = get_request('id', 1, 1);
		$username = get_request('username', 1, 1);
		$password = get_request('password', 1, 1);
		$saveedit = get_request('saveedit', 1, 1);
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
			setcookie("inputauth", serialize($_COOKIE['inputauth']), time()+3600*24*365*100);
			$_SESSION['LOGIN_USERNAME']=$username;
			$_SESSION['LOGIN_PASSWORD']=$password;		
			$_SESSION['INPUTDEVICESIDS'][]=$id;
			//echo '<script>window.opener.location.href="'.$url.'";window.close();</script>';
			$dev = $this->devpass_set->select_by_id($id);
			$tem = $this->tem_set->select_by_id($dev['login_method']);
			if($saveedit){
				$ps = new passwordsave();
				$ps->set_data('devicesid', $id);
				$ps->set_data('memberid', $_SESSION['ADMIN_UID']);
				$ps->set_data('username', $username);
				$ps->set_data('password', $this->member_set->udf_encrypt($password));
				if($passwordsave>0&&$this->passwordsave_set->select_count("username='".$username."' AND memberid='".$_SESSION['ADMIN_UID']."' AND devicesid='".$id."' AND id!='".$passwordsave."'")==0){				
					$ps->set_data('id', $passwordsave);
					$this->passwordsave_set->edit($ps);
				}else{
					$this->passwordsave_set->add($ps);
				}
			}
		}
		setcookie("saveedit", $saveedit, time()+3600*24*365*100);
		if(strtolower($tem['login_method']) == 'rdp'&&$rdptype=='activex'){
			echo '<script>window.location.href="'.$url.'";</script>';
		}else{
			echo '<script>window.parent.document.getElementById("hide").src="'.$url.'";'."\n".'window.parent.closeWindow();</script>';
		}
		exit;
	}

	function dev_login() {
		global $_CONFIG;
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
		$this->assign("activex_version", $_CONFIG['ACTIVEX_VERSION']);
		if(($msiepos=strpos($_SERVER['HTTP_USER_AGENT'], "Windows NT"))>0){
			$this->assign("windows_version", floatval(substr($_SERVER['HTTP_USER_AGENT'], $msiepos+10, strpos($_SERVER['HTTP_USER_AGENT'], ";", $msiepos+1)-$msiepos-10)));
		}
		
		
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
		$rdptype = get_request('rdptype', 0, 1);
		if(empty($_SESSION['AUTHDEVICESIDS'])){ 
			$_SESSION['AUTHDEVICESIDS']=array(); 
		}
		if(empty($_SESSION['COMMITDEVICESIDS'])){ 
			$_SESSION['COMMITDEVICESIDS']=array(); 
		}
		if(empty($_SESSION['INPUTDEVICESIDS'])){ 
			$_SESSION['INPUTDEVICESIDS']=array(); 
		}
		$dev = $this->devpass_set->select_by_id($id);
		$dev_type = $this->tem_set->select_by_id($dev['device_type']);
		$tem = $this->tem_set->select_by_id($dev['login_method']);

		if(!in_array($id,$_SESSION['AUTHDEVICESIDS'])){
				$twoauth_1 = $this->member_set->select_all("SELECT twoauth FROM ".$this->luser_resourcegrp_set->get_table_name()." WHERE memberid='".$user['uid']."' AND resourceid IN(SELECT b.id FROM ".$this->resgroup_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.groupname=b.groupname AND b.devicesid=0 WHERE a.devicesid='$id') UNION SELECT twoauth FROM ".$this->lgroup_resourcegrp_set->get_table_name()." WHERE groupid='".$user['groupid']."' AND resourceid IN(SELECT c.id FROM ".$this->resgroup_set->get_table_name()." c LEFT JOIN ".$this->resgroup_set->get_table_name()." d ON c.groupname=d.groupname AND d.devicesid=0 WHERE c.devicesid='$id')");
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
						/*
						$_SESSION['TWOAUTH']=$twoauth;
						$_SESSION['TWOAUTH_ID']=$id;
						$_SESSION['TWOAUTH_URL']="admin.php?".$_SERVER['QUERY_STRING'];
						echo "<script>window.open('admin.php?controller=admin_pro&action=showtwoauth', 'newwindow', 'height=130, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');</script>";
						*/
						echo "<script>alert('已经提交审批')</script>";
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
		}
		

		$_SESSION['LOGIN_ID']=$id;
		$_SESSION['LOGIN_URL']="admin.php?".$_SERVER['QUERY_STRING'];
		if($dev['logincommit']){
			if(!in_array($id,$_SESSION['COMMITDEVICESIDS'])){
				if(strtolower($tem['login_method']) == 'rdp'&&$rdptype=='activex'){
					$this->assign("rdptype", $rdptype);
					$this->assign("devicesid", $_SESSION['LOGIN_ID']);
					$this->assign("url", urlencode($_SESSION['LOGIN_URL']));
					$this->display('webcommit.tpl');
				}else{
					echo "<script>window.parent.loadurl('admin.php?controller=admin_pro&action=showcommit&".mktime()."');</script>";
				}
				//echo "<script>window.open('admin.php?controller=admin_pro&action=showcommit', 'newwindow', 'height=130, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');</script>";
				/*$this->assign('url', 'admin.php?controller=admin_pro&action=showcommit');
				$this->display('checkdevlogin.tpl');*/
				exit;
			}
		}//var_dump($dev['entrust_username']);
		if($dev['entrust_username']==0){
			if(!in_array($id,$_SESSION['INPUTDEVICESIDS'])){
				if(strtolower($tem['login_method']) == 'rdp'&&$rdptype=='activex'){
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
					echo "<script>window.parent.loadurl('admin.php?controller=admin_pro&action=showinputauth&".mktime()."');</script>";
				}
				//echo "<script>window.open('admin.php?controller=admin_pro&action=showinputauth', 'newwindow', 'height=130, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');</script>";
				/*$this->assign('url', 'admin.php?controller=admin_pro&action=showinputauth');
				$this->display('checkdevlogin.tpl');*/
				exit;
			}
		}

		$_SESSION['AUTHDEVICESIDS']=null;
		$_SESSION['COMMITDEVICESIDS']=null;
		$_SESSION['INPUTDEVICESIDS']=null;
		$_SESSION['LOGIN_ID']=null;


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
				alert_and_back('请重新选择IP');
				exit;
			}
			$this->assign('username',$user['username'].'--'.$dev[username].'--'.$str);
			$this->assign('password',$str);
			$this->assign('sid',$id.'--'.$str);
			
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
					$run_sessions = $this->rdp_set->select_all($l_where." AND (LOGIN_TEMPLATE=8 or LOGIN_TEMPLATE=14 or LOGIN_TEMPLATE=22) and rdp_runnig=1");
				}elseif($tem['login_method'] == 'vnc'){
					$run_sessions = $this->rdp_set->select_all($l_where." AND LOGIN_TEMPLATE=21 and rdp_runnig=1");
				}
				$str = "";
				$run_users = "";
				if(!empty($run_sessions)){
					if(empty($username)){
						$run_users .= "目标设备以下用户已经登录,点确定将会断开已存在的连接".'\n';
						for($i=0; $i<count($run_sessions); $i++){
							$run_users.=$run_sessions[$i]['cli_addr']."  ".$run_sessions[$i]['user'].'\n';
						}
					}else{
						$run_users="用户已经从".$run_sessions[$i]['cli_addr']."登录, 点确定将会断开已存在连接";
					}
					prompt($run_users, "admin.php?controller=admin_pro&action=cutoff&id=$id&loginurl=".urlencode($_SERVER['QUERY_STRING']), "admin.php?controller=admin_pro&action=dev_login&id=$id&logined=1&loginurl=".urlencode($_SERVER['QUERY_STRING']));
					exit;
				}
			}
			
			$user['password']=$this->member_set->udf_decrypt($user['password']);
			$this->assign("screen", $screen);
			$this->assign('port',$dev['port']);
			$this->assign('ip',$dev['device_ip']);
			$this->assign('username',$user['username'].'--'.$dev[id]);
			$this->assign('password',$user['password']);
			$this->assign('localhost', $selectedip);
			$this->assign("sid", $id);
			$this->assign("rdparg", get_request("rdparg", 0, 1));
			if($rdptype=='activex'){
				
				$str = genRandomString(8);
				
				if(!$this->insertrandom($selectedip, $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
					alert_and_back('请重新选择IP');
					exit;
				}
				$this->assign('username',$user['username'].'--'.$dev[id].'--'.$str);
				$this->assign('password',$str.'--');
				$this->assign('sid',$id.'--'.$str);
				
			
				$this->display('rdplogin_activex.tpl');
			}else{
				$str = genRandomString(8);
				
				if(!$this->insertrandom($selectedip, $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
					alert_and_back('请重新选择IP');
					exit;
				}
				$this->assign('username',$user['username'].'--'.$dev[id].'--'.$str);
				$this->assign('password',$str);
				$this->assign('sid',$id.'--'.$str);
				
				
				$this->display('rdplogin_mstsc.tpl');
			}
		}elseif(strtolower($tem['login_method']) == 'web' or strtolower($tem['login_method']) == 'oracle' or strtolower($tem['login_method']) == 'sybase' or strtolower($tem['login_method']) == 'db2' or strtolower($tem['login_method']) == 'apppub'){
			$user['password']=$this->member_set->udf_decrypt($user['password']);
			$this->assign("screen", $screen);
			$this->assign('port',$dev['port']);
			$this->assign('ip',$dev['device_ip']);
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
					$this->assign('domain',$_CONFIG[$tem['login_method'].'_AUTORUN'].' '.$_SESSION['ADMIN_UID'].(empty($appdeviceid) ? '' : '-'.$appdeviceid).' '.$dev['device_ip'].' '.$_CONFIG['APP_HOST'].' 59827');
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
				$this->assign("autorun", $_CONFIG[$tem['login_method'].'_AUTORUN']);
				
				$wins = $this->winservers_set->select_all("1=1");
				if(strtolower($tem['login_method']) == 'web'){
					$str = genRandomString(8);
				
					if(!$this->insertrandom($selectedip,  $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
						alert_and_back('请重新选择IP');
						exit;
					}
					
					$this->assign('ip',$wins[0]['IP']);
					$this->assign("sid", $id.'--'.$str);
					$this->assign('username',$user['username'].'--'.$dev[id].'--'.$str);
					$this->assign('password',$str.'--');
				}elseif(strtolower($tem['login_method']) == 'apppub'){
					$str = genRandomString(8);
					
					if(!$this->insertrandom($selectedip, $dev['device_ip'], $user['username'], $dev['username'], date('Y-m-d H:i:s'), $str)){
						alert_and_back('请重新选择IP');
						exit;
					}
					$this->assign('autorun',$_CONFIG[$tem['login_method'].'_AUTORUN'].' '.$_SESSION['ADMIN_UID'].($appdeviceid>0 ? '-'.$appdeviceid : '').' '.$dev['device_ip'].' '.$_CONFIG['APP_HOST'].' 59827');
					$this->assign("apppub", 1);
					$this->assign("sid", $id.'--'.$str);
					$this->assign('username',$user['username'].'--'.$dev[id].'--'.$str);
					$this->assign('password',$str.'--');
				}
				$this->display('WebSysbaseOraclelogin_mstsc.tpl');
			}			
		}
		else/*if($type=='fort' || $dev_type['device_type'] == 'linux')*/ {
			$this->assign('serveradd',$_SERVER['SERVER_NAME']);
			$user['password']=$this->member_set->udf_decrypt($user['password']);
			$this->assign('username',$user['username'].'--'.$dev[username]);			
			$this->assign('password',$user['password']);
			$this->assign('port',$dev['port']);
			$this->assign('ip',$dev['device_ip']);
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
						alert_and_back('请重新选择IP');
						exit;
			}
			$this->assign('username',$user['username'].'--'.$dev[username].'--'.$str);
			$this->assign('sid',$id.'--'.$str);
			$this->assign('password',$str);
			
			$this->display('devlogin.tpl');
		}
		
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

	

	function dev_group() {
		$back = get_request('back');
		if($back){
			if(strpos($_SERVER['HTTP_REFERER'], 'devgroup_edit')>0)
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
			$orderby1 = 'groupname';
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
		if($ldapid){
			$where .= " AND ldapid='$ldapid'";
		}else{
			//$where .= " AND ldapid=0";
		}
		
		$this->sgroup_set->query("UPDATE servergroup s SET count=(SELECT COUNT(*) FROM servers WHERE groupid=s.id)");

		if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			$where .= " AND (id=(SELECT mservergroup FROM ".$this->member_set->get_table_name()." WHERE uid=".$_SESSION['ADMIN_UID'].") or id IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")) ";
		}

		$row_num = $this->sgroup_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
		$alldev = $this->sgroup_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
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
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		$usergroup = $this->usergroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 ? ' AND id=(SELECT musergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : ''),'GroupName', 'ASC');
		
		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3 ? ' AND groupid=(SELECT musergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : ''),'username','ASC');
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

	function resourcegroup_bind(){
		$id = get_request("id");
		$fromdevpriority = get_request("fromdevpriority");
		$sessionluser = 'RESOURCEGROUP_USER';
		$sessionlgroup = 'RESOURCEGROUP_GROUP';		
		$ginfo = $this->resgroup_set->select_by_id($id);
		$usergroup = $this->usergroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 ? ' AND id=(SELECT musergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : ''),'GroupName', 'ASC');
		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3 ? ' AND groupid=(SELECT musergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : ''),'username','ASC');
		$_SESSION[$sessionluser] = $this->luser_resourcegrp_set->select_all('resourceid='.$id);
		$_SESSION[$sessionlgroup] = $this->lgroup_resourcegrp_set->select_all('resourceid='.$id);
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			$allbind[$i] = $_SESSION[$sessionluser][$i]['memberid'];
		}
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			$allgroup[$i] = $_SESSION[$sessionlgroup][$i]['groupid'];
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

	function resourcegroup_bindsave(){
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
		$this->resourcegroup_luser_group_save($sessionluser, $sessionlgroup, $sid, $new_userid, $new_groupid);
		alert_and_back('操作成功','admin.php?controller=admin_pro&action=resource_group');
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
		if(empty($newgroup)){
			$removed = $alluserid;
		}
		for($i=0; $i<count($added); $i++){
			$member = $this->member_set->select_by_id($added[$i]);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('luser', $member['username']);
			$adminlog->set_data('action', language('绑定'));
			$adminlog->set_data('resource', $servergrp['groupname']);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
		}
		for($i=0; $i<count($removed); $i++){
			$member = $this->member_set->select_by_id($removed[$i]);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('luser', $member['username']);
			$adminlog->set_data('action', language('解绑'));
			$adminlog->set_data('resource', $servergrp['groupname']);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
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
		for($i=0; $i<count($added); $i++){
			$ugroup = $this->usergroup_set->select_by_id($added[$i]);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('luser', $ugroup['groupname']);
			$adminlog->set_data('action', language('绑定'));
			$adminlog->set_data('resource', $servergrp['groupname']);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
		}
		for($i=0; $i<count($removed); $i++){
			$ugroup = $this->usergroup_set->select_by_id($removed[$i]);
			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('lgroup', $ugroup['groupname']);
			$adminlog->set_data('action', language('解绑'));
			$adminlog->set_data('resource', $servergrp['groupname']);
			$this->admin_log_set->add($adminlog);
			unset($adminlog);
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
				if($_SESSION[$sessionluser][$i]['id']){
					$luser->set_data('id', $_SESSION[$sessionluser][$i]['id']);
					$this->luser_resourcegrp_set->edit($luser);
				}else{
					$this->luser_resourcegrp_set->add($luser);
				}
				$user[] = $_SESSION[$sessionluser][$i]['memberid'];

				
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
				
				if($_SESSION[$sessionlgroup][$i]['id']){
					$lgroup->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
					$this->lgroup_resourcegrp_set->edit($lgroup);
				}else{
					$this->lgroup_resourcegrp_set->add($lgroup);
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
		$id = get_request("id",0,1);
		$ldapid = get_request("ldapid",0,1);
		$this->assign('title', language('添加节点'));
		$loadbalance = $this->loadbalance_set->select_all();
		if(empty($id)){
			$sgroups = $this->sgroup_set->select_by_id($ldapid);
			if($sgroups['level']==1){
				$this->assign("ldapid1", $sgroups['id']);
				$this->assign("ldapid2", 0);
			}elseif($sgroups['level']==2){
				$this->assign("ldapid1", $sgroups['ldapid']);
				$this->assign("ldapid2", $ldapid);
			}
		}else{
			$sgroup = $this->sgroup_set->select_by_id($id);
			if($sgroup['level']==1){
				$this->assign("sgroup", array('ldapid'=>$id));
			}elseif($sgroup['level']==2){
				$this->assign("ldapid1", $sgroup['ldapid']);
				$this->assign("ldapid2", $id);
			}else{
				$sgroup1 = $this->sgroup_set->select_by_id($sgroup['ldapid']);
				if($sgroup1['level']==1){
					$this->assign('ldapid1', $sgroup1['id']);
					$this->assign('ldapid2', 0);
				}elseif($sgroup1['level']==2){
					$this->assign('ldapid1', $sgroup1['ldapid']);
					$this->assign('ldapid2', $sgroup1['id']);
				}else{
					$this->assign('ldapid1', 0);
					$this->assign('ldapid2', 0);
				}
			}
		}
		$allsgroup = $this->sgroup_set->select_all('level>0', 'groupname', 'asc');
		$this->assign("loadbalances", $loadbalance);
		$this->assign("sgroup", $sgroup);
		$this->assign("ldapid", $ldapid);
		$this->assign("allsgroup", $allsgroup);
		$this->display('devgroup_edit.tpl');
	}

	function dev_group_save() {
		$id = get_request("id",0,1);
		$new_name = get_request("groupname",1,1);
		$loadbalance = get_request('loadbalance',1,0);
		$description = get_request("description",1,1);
		$ldapid1 = get_request('ldapid1',1,0);
		$ldapid2 = get_request('ldapid2',1,0);
		$levelx = get_request('levelx_',1,0);
		if(empty($new_name)){
			alert_and_back('请输入名称','admin.php?controller=admin_pro&action=dev_group');
			exit;
		}
		if(0 == $this->sgroup_set->select_count("groupname = '$new_name' and id!='$id'")) {
			$new_group = new sgroup();
			$new_group->set_data('groupname',$new_name);
			$new_group->set_data('loadbalance',$loadbalance);
			$new_group->set_data('description',$description);
			if($ldapid2){
				$new_group->set_data('level',0);
				$new_group->set_data('ldapid',$ldapid2);
			}elseif($ldapid1){
				$new_group->set_data('level',0);
				$new_group->set_data('ldapid',$ldapid1);
				if($levelx==2){
					$new_group->set_data('level',2);
					$new_group->set_data('ldapid',$ldapid1);
				}
			}else{
				$new_group->set_data('level',0);
				$new_group->set_data('ldapid',0);
				if($levelx==1){
					$new_group->set_data('level',1);
					$new_group->set_data('ldapid',0);
				}
			}
			if($id){
				$new_group->set_data('id',$id);
				$this->sgroup_set->edit($new_group);
				alert_and_back('编辑成功','admin.php?controller=admin_index&actions=dev_group', 0, 1);
				exit;
			}else{
				$this->sgroup_set->add($new_group);
				alert_and_back('添加成功','admin.php?controller=admin_index&actions=dev_group', 0, 1);
				exit;
			}
			
		}
		else {
				alert_and_back('添加失败,该设备组已存在','admin.php?controller=admin_pro&action=dev_group');
		}
	}

	function dev_group_del() {
		$id = get_request('id');
		if(	 0 == $this->server_set->select_count("groupid = $id ")) {
			$gid = $this->sgroup_set->select_all("id='$id' or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$id.") or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$id.")) ");
			for($i=0; $i<count($gid); $i++){
				$this->sgroup_set->delete($gid[$i]['id']);
			}
			$this->server_set->delete_all("id='$id' or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$id.") or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$id.")) ");
			alert_and_back('删除成功','admin.php?controller=admin_index&actions=dev_group', 0, 1);
		}
		else {
			alert_and_back('删除失败,该组还有服务器','admin.php?controller=admin_pro&action=dev_group');
		}
	}

	
	
	function dev_delfromgroup(){
		$id = get_request('id');
		$dev = $this->server_set->select_by_id($id);
		$server = new server();
		$server->set_data("id", $id);
		$server->set_data("groupid", 0);
		$this->server_set->edit($server);
		$this->sgroup_set->remove_user($dev['groupid']);
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=dev_index&gid='.$dev['groupid']);
	}

	function pass_edit() {
		$id = get_request('id');
		$ip = get_request('ip',0,1);
		$gid = get_request('gid',0,1);
		$fromdevpriority = get_request('fromdevpriority');		
		$serverid = get_request('serverid');
		$accountlinux = get_request('accountlinux');
		$accountusername = get_request('user',0,1);
		$sessionluser = 'PASSEDIT_LUSER';
		$sessionlgroup = 'PASSEDIT_LGROUP';
		if($accountlinux){
			if($this->devpass_set->select_count("device_ip='$ip' and username='$accountusername'")>0){
				alert_and_back('该账号已经绑定');
				exit;
			}
			$this->assign('username',$accountusername);
		}

		$usergroup = $this->usergroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 ? ' AND id=(SELECT musergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : ''),'GroupName', 'ASC');
		
		$this->assign('ip',$ip);
		$this->assign('serverid',$serverid);
		$where = "device_type = ''";
		//$allmem = $this->member_set->select_all('level = 0'.($_SESSION['ADMIN_LEVEL']==3 ? ' AND groupid=(SELECT musergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : ''),'username','ASC');
		$allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3 ? ' AND groupid=(SELECT musergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : ''),'username','ASC');
		$allradiusmem = $this->member_set->select_all("level=11".($_SESSION['ADMIN_LEVEL']==3 ? ' AND groupid=(SELECT musergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : ''),'username','ASC');
		$where .= " AND login_method IN('ssh','RDP','telnet','ftp','ssh1','vnc','x11','rlogin','apppub')";
		$allmethod =  $this->tem_set->select_all($where,'','ASC');	
		
		$device = $this->server_set->select_all("id=$serverid");
		$allmembers = $this->member_set->select_all();
		$this->assign('allmembers',$allmembers);

		$this->assign('sshport',$device[0]['sshport'] ? $device[0]['sshport'] : '22');
		$this->assign('telnetport',$device[0]['telnetport']? $device[0]['telnetport'] : '23');
		$this->assign('ftpport',$device[0]['ftpport']? $device[0]['ftpport'] : '21');
		$this->assign('rdpport',$device[0]['rdpport']? $device[0]['rdpport'] : '3389');
		$this->assign('vncport',$device[0]['vncport']? $device[0]['vncport'] : '5901');
		$this->assign('x11port',$device[0]['x11port']? $device[0]['x11port'] : '3389');
			
		$devicetype =  $this->tem_set->select_by_id($device[0][device_type]);

		$this->assign("devicetype", $devicetype[device_type]);

		
		
		$num = count($allmem);
		$groupnum = count($usergroup);
		for($i=0;$i<$num;$i++) {
			$allmem[$i]['username'] = ($allmem[$i]['username']);
		}
		$_SESSION[$sessionluser] = $this->luser_set->select_all('devicesid='.$id);
		$_SESSION[$sessionlgroup] = $this->lgroup_set->select_all('devicesid='.$id);
		
		if($id != 0) {
			
			$this->assign('id',$id);
			$old_pass = $this->devpass_set->select_by_id($id);
			$old_pass['cur_password']=$this->member_set->udf_decrypt($old_pass['cur_password']);
			$this->assign('username',$old_pass['username']);
			$this->assign('password',$old_pass['cur_password']);
			$this->assign('auto',$old_pass['automodify']);
			$this->assign('master_user',$old_pass['master_user']);intval($old_pass['master_user']);
			$this->assign('enable',$old_pass['enable']);
			$this->assign('autosu',$old_pass['autosu']);
			$this->assign('logincommit',$old_pass['logincommit']);
			$this->assign('radiususer',$old_pass['radiususer']);
			$this->assign('port', $old_pass['port']);
			$this->assign('entrust_password', $old_pass['entrust_password']);
			$this->assign('encoding', $old_pass['encoding']);
			$this->assign('entrust_username', $old_pass['entrust_username']);
			$this->assign('change_password', $old_pass['change_password']);
			$this->assign('publickey_auth', $old_pass['publickey_auth']);
			$this->assign('commanduser', $old_pass['commanduser']);
			$this->assign('sftp', $old_pass['sftp']);
			$this->assign('mode', $old_pass['mode']);
			$this->assign('l_id', $old_pass['login_method']);
			$time = explode('-',$old_pass['limit_time']);
			if($time[0] == '9999') {
				$this->assign('nolimit',1);
			}
			else {
				$this->assign('nolimit',0);
				$this->assign('limit_time',$old_pass['limit_time']);
			}
			//$allbind = explode(',',trim($old_pass['luser'],','));
			for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
					$allbind[$i] = $_SESSION[$sessionluser][$i]['memberid'];
			}
			for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				$allgroup[$i] = $_SESSION[$sessionlgroup][$i]['groupid'];
			}
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
			
			if($old_pass['log_tab']){
				$logtab = $this->logintab_set->select_by_id($old_pass['log_tab']);
				$this->assign('logtab', $logtab);
			}
			

		}else{
			$this->assign('enable',1);
			$this->assign('nolimit',1);
			$this->assign('autologin',1);
			$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
			$dp = $dp[0];
			$this->assign('entrust_password',$dp['entrust_password']);
		}
				
//echo '<pre>';print_r($_SESSION);echo '</pre>';
		$this->assign("allmethod", $allmethod);
		$this->assign('allmem',$allmem);
		$this->assign('allradiusmem',$allradiusmem);
		$this->assign('gid',$gid);
		$this->assign('usergroup', $usergroup);
		$this->assign('title',language("修改"));
		$this->assign('sessionluser', $sessionluser);
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->assign('fromdevpriority', $fromdevpriority);
		$this->display('pass_edit.tpl');
	}

	function pass_save() {
		global $_CONFIG;
		$id = get_request('id');
		$serverid = get_request('serverid');
		$fromdevpriority = get_request('fromdevpriority');
		$ip = get_request('ip',0,1);
		$enable = get_request('enable',1,1);
		$limit_time = get_request('limit_time',1,1);
		$auto = get_request('auto',1,1);
		$autosu = get_request('autosu',1,1);
		$automu = get_request('automu',1,1);
		$publickey_auth = get_request('publickey_auth',1,1);
		$nolimit = get_request('nolimit',1,1);
		$new_name = get_request('username',1,1);
		$new_password = get_request('password',1,1);
		$new_password_confirm = get_request('password_confirm',1,1);
		$login_method = get_request('l_id',1,1);
		$port = get_request('port',1,1);
		$sftp = get_request('sftp',1,1);
		$autologin = get_request('autologin', 1, 1);
		$logincommit = get_request('logincommit', 1, 1);
		$entrust_password = get_request('entrust_password', 1, 1);
		$entrust_username = get_request('entrust_username', 1, 1);
		$encoding = get_request('encoding',1,0);
		$logtab = get_request('logtab',1,0);
		$mode = get_request('mode',1,0);
		$commanduser = get_request('commanduser',1,0);
		$weburl = get_request('weburl',1,1);
		$webuser = get_request('webuser',1,1);
		$webpwd = get_request('webpwd',1,1);
		$memberselect = get_request('memberselect',1,1);
		$radiususer = get_request('radiususer',1,1);

		$sessionluser = get_request('sessionluser', 1, 1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
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
			if($allmember[$i]['uid'])
			$alluserid[]=$allmember[$i]['uid'];
		}
		if($j>20) {
			//alert_and_back(language('绑定的用户不能超过')."20");
			//exit(0);
		}
		$new_group = ',';
		$j = 0;
		$gcount = $this->usergroup_set->select_count();
		$allgroup = $this->usergroup_set->select_all();
		for($i = 0;$i<$gcount;$i++) {
			if(0 != get_request("Group$i",1,0)) {
				$new_group .= get_request("Group$i",1,0).',';
				$new_groupid[] = get_request("Group$i",1,0);
				$j++;
			}
			$allgroupid[]=$allgroup[$i]['id'];
		}

		if($automu == 'on') {
			$devs = $this->devpass_set->select_count(" device_ip='$ip' AND hostname='".$server['hostname']."' AND master_user=1 AND id!='$id'");
			if($devs>=1){
				alert_and_back("主账号多于一个");
				exit;
			}			
		}
		if($new_password!=$new_password_confirm){
			alert_and_back("两次输入的密码不对");
			exit;
		}

		
				
		if($id == 0) {
			if(0 == $this->devpass_set->select_count("username = '$new_name' and device_ip='$ip' and port='$port' and hostname='".$server['hostname']."' and login_method='$login_method'")) {
				$new_pass = new devpass();
				$new_pass->set_data('commanduser',$commanduser);
				$new_pass->set_data('username',$new_name);
				$new_pass->set_data('cur_password',$this->member_set->udf_encrypt($new_password));
				$new_pass->set_data('login_method',$login_method);
				$new_pass->set_data('port',$port);
				//$device = $this->server_set->select_all("device_ip = '$ip'");
				//$new_pass->set_data('login_method',$device[0]['login_method']);
				$new_pass->set_data('device_type',$server['device_type']);
				$new_pass->set_data('device_ip',$server['device_ip']);
				$new_pass->set_data('hostname',$server['hostname']);
				//$new_pass->set_data('port',$device[0]['port']);
				$new_pass->set_data('luser',$new_user);
				$new_pass->set_data('mode',$mode);
				$new_pass->set_data("lgroup", $new_group);
				if($enable == 'on') {
					$new_pass->set_data('enable',1);
				}
				else {
					$new_pass->set_data('enable',0);
				}
				if($auto == 'on') {
					$new_pass->set_data('automodify',1);
				}
				else {
					$new_pass->set_data('automodify',0);
				}
				if($logincommit == 'on') {
					$new_pass->set_data('logincommit',1);
				}
				else {
					$new_pass->set_data('logincommit',0);
				}
				if($autosu == 'on') {
					$new_pass->set_data('autosu',1);
				}
				else {
					$new_pass->set_data('autosu',0);
				}
				if($radiususer == 'on') {
					$allmembers = $this->member_set->select_all('level=11');
					for($i=0; $i<count($allmembers); $i++){
						if($allmembers[$i]['uid']==$memberselect){
							$new_pass->set_data('username',$allmembers[$i]['username']);
							$new_pass->set_data('cur_password',$allmembers[$i]['password']);
						}
					}
					$new_pass->set_data('radiususer',$memberselect);
				}
				else {
					$new_pass->set_data('radiususer',0);
				}
				if($automu == 'on') {
					$new_pass->set_data('master_user',1);
				}
				else {
					$new_pass->set_data('master_user',0);
				}
				if($sftp == 'on') {
					$new_pass->set_data('sftp',1);
				}
				else {
					$new_pass->set_data('sftp',0);
				}
				if($entrust_password == 'on') {
					$new_pass->set_data('entrust_password',1);
				}
				else {
					$new_pass->set_data('entrust_password',0);
				}
				if($entrust_username == 'on') {
					$new_pass->set_data('entrust_username',0);
				}
				else {
					$new_pass->set_data('entrust_username',1);
				}
				if($publickey_auth == 'on') {
					$new_pass->set_data('publickey_auth',1);
				}
				else {
					$new_pass->set_data('publickey_auth',0);
				}
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
				$alltem = $this->tem_set->select_all();
				foreach($alltem as $tem) {
					if($login_method == $tem['id']&&strtolower($tem['login_method'])=='web') {
						$logintab = new logintab();
						$logintab->set_data("url", $weburl);
						$logintab->set_data("userID", $webuser);
						$logintab->set_data("pwdID", $webpwd);
						$this->logintab_set->add($logintab);
						$logintabid = mysql_insert_id();
						$new_pass->set_data("log_tab", $logintabid);
					}
				}			
				
				$new_pass->set_data('encoding',$encoding);

				$this->devpass_set->add($new_pass);
				$id = mysql_insert_id();

				$this->luser_group_save($sessionluser, $sessionlgroup, $id, $new_userid,$alluserid, $new_groupid,$allgroupid, 1);

				
				
				unset($_SESSION[$sessionluser]);
				unset($_SESSION[$sessionlgroup]);
			
				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('添加'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
				$this->admin_log_set->add($adminlog);				
				unset($adminlog);											
				if($new_userid)
				$usernames = $this->member_set->select_all(" uid IN (".implode(',', $new_userid).")");
				for($i=0; $i<count($usernames); $i++){
					$adminlog = new admin_log();
					$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
					$adminlog->set_data('luser', $usernames[$i]['username']);
					$adminlog->set_data('action', language('绑定'));
					$adminlog->set_data('resource', $ip);
					$adminlog->set_data('resource_user', $new_name);
					$this->admin_log_set->add($adminlog);
					unset($adminlog);
				}
				
				alert_and_back('添加成功',"admin.php?controller=admin_pro&action=devpass_index&ip=$ip&serverid=".$serverid."&gid=".$gid);
				}
			else {
				alert_and_back('添加失败,该用户已存在','admin.php?controller=admin_pro&action=pass_edit&ntype=new&ip='.$ip.'&serverid='.$serverid."&gid=".$gid);
			}
		}
		else {
				
				$new_pass = new devpass();
				$new_pass->set_data('id',$id);
				$new_pass->set_data('commanduser',$commanduser);
				$new_pass->set_data('cur_password',$this->member_set->udf_encrypt($new_password));
				if($old_pass['cur_password']!=$this->member_set->udf_encrypt($new_password)){
					$new_pass->set_data('old_password',$old_pass['cur_password']);
				}
				$new_pass->set_data('login_method',$login_method);
				$new_pass->set_data("lgroup", $new_group);
				$new_pass->set_data('port',$port);
				$new_pass->set_data('luser',$new_user);
				$new_pass->set_data('mode',$mode);
				if($enable == 'on') {
					$new_pass->set_data('enable',1);
				}
				else {
					$new_pass->set_data('enable',0);
				}
				if($auto == 'on') {
					$new_pass->set_data('automodify',1);
				}
				else {
					$new_pass->set_data('automodify',0);
				}
				if($logincommit == 'on') {
					$new_pass->set_data('logincommit',1);
				}
				else {
					$new_pass->set_data('logincommit',0);
				}
				if($sftp == 'on') {
					$new_pass->set_data('sftp',1);
				}
				else {
					$new_pass->set_data('sftp',0);
				}
				if($autosu == 'on') {
					$new_pass->set_data('autosu',1);
				}
				else {
					$new_pass->set_data('autosu',0);
				}
				if($automu == 'on') {
					$new_pass->set_data('master_user',1);
				}
				else {
					$new_pass->set_data('master_user',0);
				}
				if($publickey_auth == 'on') {
					$new_pass->set_data('publickey_auth',1);
				}
				else {
					$new_pass->set_data('publickey_auth',0);
				}
				if($change_password == 'on') {
					$new_pass->set_data('change_password',1);
				}
				else {
					$new_pass->set_data('change_password',0);
				}
				if($entrust_password == 'on') {
					$new_pass->set_data('entrust_password',1);
				}
				else {
					$new_pass->set_data('entrust_password',0);
				}
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
				
				
				$alltem = $this->tem_set->select_all();
				foreach($alltem as $tem) {
					if($login_method == $tem['id']&&strtolower($tem['login_method'])=='web') {
						$logintab = new logintab();
						$logintab->set_data("id", $logtab);
						$logintab->set_data("url", $weburl);
						$logintab->set_data("userID", $webuser);
						$logintab->set_data("pwdID", $webpwd);
						$this->logintab_set->edit($logintab);
					}
				}
				$new_pass->set_data('encoding',$encoding);
				$this->devpass_set->edit($new_pass);
				$this->luser_group_save($sessionluser, $sessionlgroup, $id, $new_userid,$alluserid, $new_groupid,$allgroupid);

				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('修改'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
				$this->admin_log_set->add($adminlog);
				
				alert_and_back('修改成功',"admin.php?controller=admin_pro&action=devpass_index&ip=$ip&serverid=".$serverid."&gid=".$gid);
		}
	}
	function pass_del() {
		$id = get_request('id');
		
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
				$adminlog->set_data('action', language('解绑'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
				$this->admin_log_set->add($adminlog);
				unset($adminlog);
			}
		}
		if(!empty($newuser)){
			$usernames = $this->member_set->select_all(" uid NOT IN (SELECT memberid FROM luser WHERE memberid IN (".implode(',', $newuser).") AND devicesid=$sid)AND uid IN(".implode(',', $newuser).")");
			for($i=0; $i<count($usernames); $i++){
				$adminlog = new admin_log();
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('luser', $usernames[$i]['username']);
				$adminlog->set_data('action', language('绑定'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
				$this->admin_log_set->add($adminlog);
				unset($adminlog);
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
				$adminlog->set_data('action', language('解绑'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
				$this->admin_log_set->add($adminlog);
				unset($adminlog);
			}
		}
		if(!empty($newgroup)){
			$usernames = $this->usergroup_set->select_all(" id NOT IN (SELECT groupid FROM lgroup WHERE groupid IN (".implode(',', $newgroup).")AND devicesid=$sid AND groupid is not null) AND id IN(".implode(',', $newgroup).")");
			for($i=0; $i<count($usernames); $i++){
				$adminlog = new admin_log();
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('lgroup', $usernames[$i]['groupname']);
				$adminlog->set_data('action', language('绑定'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
				$this->admin_log_set->add($adminlog);
				unset($adminlog);
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
				$luser->set_data('devicesid', $sid);
				$luser->set_data('forbidden_commands_groups', $_SESSION[$sessionluser][$i]['forbidden_commands_groups']);

				$member = $this->member_set->select_by_id($_SESSION[$sessionluser][$i]['memberid']);
				$device = $this->devpass_set->select_by_id($sid);
				
				if($_SESSION[$sessionluser][$i]['id']){
					$luser->set_data('id', $_SESSION[$sessionluser][$i]['id']);
					$this->luser_set->edit($luser);
				}else{
					$this->luser_set->add($luser);
				}
				$user[] = $_SESSION[$sessionluser][$i]['memberid'];
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
				$lgroup->set_data('devicesid', $sid);	
				$lgroup->set_data('forbidden_commands_groups', $_SESSION[$sessionlgroup][$i]['forbidden_commands_groups']);		
				
				if($_SESSION[$sessionlgroup][$i]['id']){
					$lgroup->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
					$this->lgroup_set->edit($lgroup);
				}else{
					$this->lgroup_set->add($lgroup);
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
					break;
				}
			}
		if(empty($luser)){
			$luser = $this->luser_set->select_all('memberid='.$uid.' AND devicesid='.$sid);
		}
		if(empty($luser)){
			$luser = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1', 'gname','asc');		
		$webusers = $this->member_set->select_all('1', 'username', 'asc');
		$this->assign('title', language('设置'));
		$this->assign("luser", $luser[0]);
		$this->assign("weektime", $weektime);
		$this->assign("webusers", $webusers);
		$this->assign("allforbiddengroup", $allforbiddengroup);
		$this->assign("sourceip", $sourceip);
		$this->assign("uid", $uid);
		$this->assign("sid", $sid);
		$this->assign('sessionluser', $sessionluser);
		$this->display('passedit_seluser.tpl');
	}


	function passedit_seluser_save(){
		global $_CONFIG;
		$sid = get_request('sid', 1, 0);
		$uid = get_request('uid', 1, 0);
		$id = get_request('id', 1, 0);
		$twoauth = get_request('twoauth', 1, 0);
		$autosu = get_request('autosu', 1, 1);
		$rdpclipauth_up = get_request('rdpclipauth_up', 1, 1);
		$rdpdiskauth_up = get_request('rdpdiskauth_up', 1, 1);
		$rdpclipauth_down = get_request('rdpclipauth_down', 1, 1);
		$rdpdiskauth_down = get_request('rdpdiskauth_down', 1, 1);
		$syslogalert = get_request('syslogalert', 1, 1);
		$mailalert = get_request('mailalert', 1, 1);
		$loginlock = get_request('loginlock', 1, 1);
		$weektime = get_request('weektime', 1, 1);
		$sourceip = get_request('sourceip', 1, 1);
		$forbidden_commands_groups = get_request('forbidden_commands_groups', 1, 1);
		$sessionluser = get_request('sessionluser', 1, 1);
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
				$_SESSION[$sessionluser][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
				
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
					$_SESSION[$sessionluser][$i]['forbidden_commands_groups'] = $forbidden_commands_groups;
					
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
				$_SESSION[$sessionluser][$len]['forbidden_commands_groups'] = $forbidden_commands_groups;
				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionluser]);echo '</pre>';
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
		}
		if(empty($luser)){
			$luser = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1', 'gname','asc');
		$webusers = $this->member_set->select_all('1', 'username', 'asc');
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
		$twoauth = get_request('twoauth', 1, 0);
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
		}
		if(empty($lgroup)){
			$lgroup = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1', 'gname','asc');
		$webusers = $this->member_set->select_all('1', 'username', 'asc');
		
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
		$sessionlgroup= get_request('sessionlgroup', 0, 1);//var_dump($sid);var_dump($gid);var_dump($_SESSION[$sessionlgroup]);
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
				if($_SESSION[$sessionlgroup][$i]['groupid']==$gid&&$_SESSION[$sessionlgroup][$i]['resourceid']==$sid){
					$lgroup[0] = $_SESSION[$sessionlgroup][$i];	
					break;
				}
			}
		if(empty($lgroup)){
			$lgroup = $this->lgroup_resourcegrp_set->select_all('groupid='.$gid.' AND resourceid='.$sid);
		}
		if(empty($lgroup)){
			$lgroup = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		}
		$weektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$allforbiddengroup = $this->forbiddengps_set->select_all('1=1', 'gname','asc');
		$webusers = $this->member_set->select_all('1', 'username', 'asc');
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
		$twoauth = get_request('twoauth', 1, 0);
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
				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionlgroup]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}	

	function resourcegrp_selgroup_save(){
		$sid = get_request('sid', 1, 0);
		$gid = get_request('gid', 1, 0);
		$twoauth = get_request('twoauth', 1, 0);
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
				
			}
		}
		//echo '<pre>';print_r($_SESSION[$sessionlgroup]);echo '</pre>';
		alert_and_close('已记录，请回到前页继续编辑');
		//unset($_SESSION['PASSEDIT_LUSER']);
	}


	
	function devpass_index() { 
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
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		echo $cmd = "/opt/freesvr/audit/sbin/createuser $username $pwd $ip ";
		exec($cmd, $out,  $return);
		if(intval($return)==0){
			echo '<script>window.opener.location.reload()</script>';
			alert_and_close('创建成功');
		}elseif(intval($return)==1){
			alert_and_back('创建失败');
		}elseif(intval($return)==2){
			alert_and_back('密码错误');
		}else{
			alert_and_back('创建失败');
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
			$cmd = "/opt/freesvr/audit/sbin/deluser $username $ip ";
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
				$adminlog->set_data('action', language('添加'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
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
			alert_and_back($msg,"admin.php?controller=admin_pro&action=dev_edit&ip=".$server['device_ip']."&id=".$serverid."&tab=0");
		}else{
			alert_and_back('添加失败:\n'.implode('\n',$error).'\n',"admin.php?controller=admin_pro&action=dev_edit&ip=".$server['device_ip']."&id=".$serverid."&tab=0");
		}

	}

	function accountlinux_listacct() { 
		$ip = get_request('ip', 0, 1);
		$cmd = "/opt/freesvr/audit/sbin/listacct $ip ";
		exec($cmd, $out,  $return);
		if(intval($return)==0){			
			alert_and_back('同步成功');
		}elseif(intval($return)==1){
			alert_and_back('同步失败');
		}elseif(intval($return)==2){
			alert_and_back('密码错误');
		}else{
			alert_and_back('同步失败');
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
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		$str = mb_convert_encoding($str, "GB2312", "UTF-8");
		fwrite($handle, $str);
		fclose($handle);
		go_url("tmp/DeviceUserList.xls?c=" . rand());
		exit;
	}

	function export_pass($where='1=1'){
		set_time_limit(0);
		if(strpos($where, "d.device_ip")===false)
		$where = str_replace("device_ip", "d.device_ip", $where);
		$alldev = $this->devpass_set->base_select("SELECT d.*,servers.groupname,servers.sgldapid sgroupldapid, servers.sglevel sgrouplevel FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN (SELECT sg.GroupName,s.device_ip,s.groupid,sg.ldapid sgldapid,sg.level sglevel FROM ".$this->server_set->get_table_name()." s LEFT JOIN ".$this->sgroup_set->get_table_name()." sg ON s.groupid=sg.id) servers ON d.device_ip = servers.device_ip WHERE $where order by servers.groupname ASC, servers.device_ip ASC, d.username ASC");


		$str = language("主机名").",".language("IP").",".language("服务器组").",".language("上级节点").",".language("服务器组类型(服务器组 一级节点 二级节点)").",".language("系统类型").",".language("系统用户").",".language("登录方式")." ,".language("当前密码")." ,".language("端口")." ,".language("过期时间")." ,".language("自动修改密码")." ,".language("主账号")." ,".language("自动登录")." ,".language("堡垒机用户认证")." ,".language("SFTP")."\n";
		
		$id=1;
		if($alldev){
			$alltem = $this->tem_set->select_all();
			$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
			foreach ($alldev AS $report){	
				foreach($alltem as $tem) {
					if($report['login_method'] == $tem['id']) {
						$report['login_method'] = $tem['login_method'];
					}elseif($report['device_type'] == $tem['id']) {
						$report['device_type'] = $tem['device_type'];
					}
				}
				for($i=0; $i<count($allgroup); $i++){
					if($report['sgroupldapid']==$allgroup[$i]['id']){
						$report['sgroupparent']=$allgroup[$i]['groupname'];
					}
				}
				switch($report['sgrouplevel']){
					case 0:
						$report['sgrouplevestr']='服务器组';
					break;
					case 1:
						$report['sgrouplevestr']='一级节点';
					break;
					case 2:
						$report['sgrouplevestr']='二级节点';
					break;
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
					$report['groupname'] = '"'.$report['groupname'].'"';
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

				$str .= $report['hostname'].",".$report['device_ip'].",".$report['groupname'].",".$report['sgroupparent'].",".$report['sgrouplevestr'].",".$report['device_type'].",".($report['username']==""  ? '空用户' : $report['username']).",".$report['login_method'].",".$report['cur_password'].",".$report['port'].",".($report['limit_time']=='9999-00-00' ? '永不过期' : $report['limit_time']).",".($report['auto']? '是':'否').",".($report['master_user']? '是':'否').",".($report['entrust_password']? '是':'否').",".($report['radiususer']? '是':'否').",".($report['sftp']? '是':'否');
				$str .= "\n";
			}
		}
		$str = iconv("UTF-8", "GB2312", $str);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=audit-devices-".date('Ymd').".csv"); 
		echo $str;
		exit;
	}

	function devimport(){
		$this->display("devimport.tpl");
	}
	
	function dodevimport(){
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
		if(iconv("GB2312", "UTF-8", trim($lines[0][0]))!='主机名' || iconv("GB2312", "UTF-8", trim($lines[0][1]))!='IP' || iconv("GB2312", "UTF-8", trim($lines[0][2]))!='服务器组' || iconv("GB2312", "UTF-8", trim($lines[0][5]))!='系统类型'|| iconv("GB2312", "UTF-8", trim($lines[0][6]))!='系统用户'){
			alert_and_back("文件有问题，请上传正确的文件");
			exit;
		}
		//echo '<pre>';print_r($lines);echo '</pre>';exit;
		$j=0;
		for($i=1; $i<count($lines); $i++){
			if(empty($lines[$i])){
				continue;
			}
			$linearr = $lines[$i];	
			for($ii=0; $ii<count($linearr); $ii++){
				$linearr[$ii]=iconv("GB2312", "UTF-8", $linearr[$ii]);
			}
			$hostname=trim($linearr[0]);
			$device_ip=trim($linearr[1]);
			$groupname=trim($linearr[2]);
			$groupparent=trim($linearr[3]);
			$grouplevel=trim($linearr[4]);
			$device_type=trim($linearr[5]);
			$username=trim(($linearr[6]=='空用户' ? '' : $linearr[6] ));
			$login_method=trim($linearr[7]);
			$current_password=trim($linearr[8]);
			$port=intval($linearr[9]);
			$limit_time=trim($linearr[10]);
			$auto=trim($linearr[11]);
			$master_user=trim($linearr[12]);
			$entrust_password=trim($linearr[13]);
			$radiususer=trim($linearr[14]);
			$sftp=trim(($linearr[15]=='是' ? 1 : 0 ));
			$entrust_username=trim((empty($username)&&empty($current_password) ? 0 : 1 ));
			$sgldapid = 0;
			$sglevel =0; 
			if(empty($device_ip)){
				continue;
			}
			if(preg_match("/[\\r\\n]/", $hostname)||preg_match("/[\\r\\n]/", $device_ip)||preg_match("/[\\r\\n]/", $groupname)||preg_match("/[\\r\\n]/", $device_type)||preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $login_method)||preg_match("/[\\r\\n]/", $current_password)||preg_match("/[\\r\\n]/", $port)||preg_match("/[\\r\\n]/", $limit_time)||preg_match("/[\\r\\n]/", $auto)||preg_match("/[\\r\\n]/", $master_user)||preg_match("/[\\r\\n]/", $entrust_password)||preg_match("/[\\r\\n]/", $radiususer)){
				$error[]=$username.':'.'用户信息中含有回车符'.'\n';
				continue;
			}
			$alltem = $this->tem_set->select_all();
			$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
			foreach($alltem as $tem) {
				if($login_method&&strtolower($login_method) == strtolower($tem['login_method'])) {
					$login_method = $tem['id'];
				}
				if($device_type&&strtolower($device_type) == strtolower($tem['device_type'])) {
					$device_type = $tem['id'];
				}
			}
			for($ii=0; $ii<count($allgroup); $ii++){
				if($allgroup[$ii]['groupname']==$groupparent){
					$sgldapid=$allgroup[$ii]['id'];
					break;
				}
			}
			if(empty($sgldapid)&&!empty($groupparent)){
				$newgroup = new sgroup();
				$newgroup->set_data("groupname", $groupparent);
				$newgroup->set_data("count", 0);
				$newgroup->set_data("description", '');
				$newgroup->set_data('ldapid' , 0);
				$newgroup->set_data('level', 1);
				$this->sgroup_set->add($newgroup);
				$sgldapid = mysql_insert_id();
			}
			switch($grouplevel){
				case '服务器组':
					$sglevel = 0;
				break;
				case '一级节点':
					$sglevel = 1;
				break;
				case '二级节点':
					$sglevel = 2;
				break;
			}
			if(empty($login_method)){
				$error[]=$device_ip.' '.(empty($username) ? '空用户' : $username).' '.':'.'登录方式不能识别'.'\n';
				continue;
			}
			$limit_time = ($limit_time=='永不过期' ? '9999-00-00' : $limit_time);
			//$enable = ($enable=='是' ? 1 : 0);
			$auto = ($auto=='是' ? 1 : 0);
			$master_user = ($master_user=='是' ? 1 : 0);
			$entrust_password = ($entrust_password=='是' ? 1 : 0);
			$radiususer = ($radiususer=='是' ? 1 : 0);

			$group = $this->sgroup_set->select_all("groupname='".$groupname."'", 'groupname', 'asc');
			$groupid=$group[0]['id'];
			if(empty($group)&&!empty($groupname)){
				$newgroup = new sgroup();
				$newgroup->set_data("groupname", $groupname);
				$newgroup->set_data("count", 0);
				$newgroup->set_data("description", '');
				$newgroup->set_data('ldapid' , $sgldapid);
				$newgroup->set_data('level', $sglevel);
				$this->sgroup_set->add($newgroup);
				$groupid = mysql_insert_id();
			}else if($group){
				$newgroup = new sgroup();
				$newgroup->set_data('id', $group[0]['id']);
				$newgroup->set_data('ldapid' , $sgldapid);
				$newgroup->set_data('level', $sglevel);
				$this->sgroup_set->edit($newgroup);
			}

			$insertservers = "INSERT INTO ".$this->server_set->get_table_name()."(device_ip,hostname,device_type,groupid) values";
			$insertserverslen = strlen($insertservers);
			$insertdevices = "INSERT INTO ".$this->devpass_set->get_table_name()."(device_ip,login_method,device_type,hostname,username,cur_password,port,limit_time,automodify,master_user,entrust_password,radiususer,sftp, entrust_username) values";
			$insertdeviceslen = strlen($insertdevices);

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
				if($_SESSION['ADMIN_LEVEL']==3){
					$newmember->set_data("groupid", $_SESSION['ADMIN_MUSERGROUP']);
				}
				$new_dev->set_data('superpassword', $this->member_set->udf_encrypt($current_password));
				$this->server_set->edit($new_dev);
			}
			$devpass = $this->devpass_set->select_all("username = '".$username."' and device_ip='".$device_ip."' and login_method='".$login_method."'");
			if(empty($devpass)){
				$devs = $this->devpass_set->select_count(" device_ip='".$device_ip."' AND hostname='".$hostname."' AND master_user=1");
				if($devs['row_num']>0){
					$master_user=0;
				}
				if($encrypt){
					$old_password=empty($old_password) ? '' : $this->devpass_set->udf_encrypt($old_password);
					$current_password=empty($current_password) ? '' : $this->devpass_set->udf_encrypt($current_password);
				}
				$insertdevices.="('".$device_ip."','".$login_method."','".$device_type."','".$hostname."','".$username."','".$current_password."','".$port."','".$limit_time."','".$auto."','".$master_user."','".$entrust_password."','".$radiususer."','".$sftp."','".$entrust_username."'),";
			}else{
				$new_pass = new devpass();
				$new_pass->set_data('id',$devpass[0]['id']);
				$new_pass->set_data('cur_password',$current_password);
				if($encrypt){
					$new_pass->set_data('cur_password',$this->member_set->udf_encrypt($current_password));
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
			alert_and_back($msg, "admin.php?controller=admin_pro&action=dev_index");
		}else{
			alert_and_back('导入成功', "admin.php?controller=admin_pro&action=dev_index");
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
		$id = get_request('id');
		$username = (get_request("username", 1, 1));
		$password = get_request("password", 1, 1);
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

			$this->assign('oldpass',$this->member_set->udf_decrypt($dev['old_password']));
			$this->assign('curpass',$this->member_set->udf_decrypt($dev['cur_password']));
			$this->assign('update_time',$dev['last_update_Time']);
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
			$adminlog->set_data('action', language('删除'));
			$adminlog->set_data('resource', $dev['device_ip']);
			$adminlog->set_data('resource_user', $dev['username']);
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
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=devpass_index&ip='.$ip.'&serverid='.$serverid."&gid=".$gid);
	}

	function logs_index() {
		$page_num = get_request('page');
		$ip = get_request("ip", 1, 1);
		$start_time = get_request("start_time", 1, 1);
		$end_time = get_request("end_time", 1, 1);
		$success = get_request("success", 1, 1);
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
			$where .= " AND device_ip IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
		}
		if($ip){
			$where .= "  AND device_ip='".$ip."'";
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
		$row_num = $this->logs_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
		$alllog = $this->logs_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);

		$this->assign('title', language('日志列表'));
		$this->assign('alllog', $alllog);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('logs_index.tpl');
	}

	function last_changepwd() {
		$page_num = get_request('page');		
		$where = ' 1=1';
		
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$where .= " AND device_ip IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
		}
		
		
		$row_num = $this->logs_set->base_select('SELECT max(id) AS count FROM '.$this->logs_set->get_table_name().' GROUP BY username');
		$row_num = count($row_num);
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
			$where .= "  AND device_ip='".$ip."'";
		}
		if($username){
			$where .= "  AND username='".$username."'";
		}
		if($passwordtry != ''){
			$where .= "  AND passwordtry='".$passwordtry."'";
		}
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$where .= " AND device_ip IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
		}
		
		
		$row_num = $this->devpass_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		$row_num = $this->sourceip_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		$groupname = get_request("groupname", 0 , 1);
		$a = $this->sourceip_set->base_select("select sum(num) b FROM (SELECT count(*) as num FROM luser where sourceip='".$groupname."' 
		UNION SELECT count(*) as num FROM lgroup where sourceip='".$groupname."' 
		UNION SELECT count(*) as num FROM luser_devgrp where sourceip='".$groupname."' 
		UNION SELECT count(*) as num FROM luser where sourceip='".$groupname."') t");
		if($a[0]['b']>0){
			alert_and_back('该组已被绑定,不能删除');
			exit;
		}
		$this->sourceip_set->query("DELETE FROM ".$this->sourceip_set->get_table_name()." WHERE groupname='$groupname'");
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=sourceip');
	}
	
	function sourceiplist_delete(){
		$sid = get_request("sid");
		$sip = $this->sourceip_set->select_by_id($sid);
		$this->sourceip_set->delete($sid);
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=sourceip_list&groupname='.$sip['groupname']);
	}
	
	function sourceiplist_save(){
		$groupname = get_request("groupname", 0, 1);
		$ip = get_request("ip", 1, 1);
		if(empty($groupname)){
			alert_and_back('系统错误,请重新打开');
			exit;
		}
		$iparr = explode('/', $ip);
		if(!is_ip($iparr[0])||(!is_numeric($iparr[1])&&!is_ip($iparr[1]))){
			alert_and_back('请按照例子来写');
			exit;
		}
		$sourceip = new sourceip();
		$sourceip->set_data('groupname', $groupname);
		$sourceip->set_data('sourceip', $ip);
		$this->sourceip_set->add($sourceip);
		alert_and_back('添加成功','admin.php?controller=admin_pro&action=sourceip_list&groupname='.$groupname);
	}
	
	function sourceip_save(){
		$sid = get_request("sid");
		$groupname = get_request("groupname", 1, 1);
		if(empty($groupname)){
			alert_and_back('请填写组名');
			exit;
		}
		$allgp = $this->sourceip_set->select_all('groupname="'.$groupname.'"');
		if(!empty($allgp)){
			alert_and_back('该组名已经存在');
			exit;
		}
		$sourceip = new sourceip();
		$sourceip->set_data('groupname', $groupname);
		$sourceip->set_data('sourceip', $sip);
		$sourceip->set_data('creatorid', $_SESSION['ADMIN_UID']);
		if($sid){
			$sourceip->set_data("sid", $sid);
			$this->sourceip_set->edit($sourceip);
			alert_and_back('修改成功');
			exit;
		}
		$this->sourceip_set->add($sourceip);
		alert_and_back('添加成功','admin.php?controller=admin_pro&action=sourceip');
	}
	
	function passwordkey(){
		$page_num = get_request('page',0,1);
		$where = '1=1';
		$row_num = $this->passwordkey_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
	
	function passwordedit(){
		global $_CONFIG;
		$group = get_request('group', 1, 1);
		$pwdpolicy = get_request('pwdpolicy', 1, 0);
		$password = get_request('password', 1, 1);
		$server = get_request('server', 1, 1);
		$username = get_request('device', 1, 1);
		$ac = get_request('ac', 1, 1);
		$time = get_request('f_rangeStart', 1, 1);
		if($ac == 'doit'){
			$cmd = 'sudo '.$_CONFIG['EDITPASSWORD2'];
			if(((empty($server)||$server==99999999) && (empty($username)||$username==99999999)) && $group!=99999999){
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
			
			//echo $cmd;
			if($time=='立即执行'){
				exec($cmd, $out);
			}else{
				file_put_contents(ROOT.'/tmp/changepassword', $cmd);
				$time=substr($time,0,strrpos(':', $time));
				$time=str_replace('-', '', $time);
				$time=str_replace(':', '', $time);
				exec('at -t '.$time.' -f '.ROOT.'/tmp/changepassword', $out);
			}
			alert_and_back('修改请求发送成功，请查看日志验证', 'admin.php?controller=admin_pro&action=passwordedit');
		}
		$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		$this->assign("allgroup", $allgroup);
		$server = $this->server_set->select_all();
		$this->assign("server", $server);
		$devices = $this->devpass_set->base_select("SELECT * FROM devices GROUP BY device_ip,username");
		$this->assign("devices", $devices);
		$this->display('editpassword.tpl');
	}

	function password_cron(){
		global $_CONFIG;
		$chpwdservice = get_request('chpwdservice', 1, 1);
		$accountservice = get_request('accountservice', 1, 1);
		$uploadservice = get_request('uploadservice', 1, 1);
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
			//
			$linestmp = @file($_CONFIG['NTPNAGIOS']);//echo '<pre>';print_r($linestmp);echo '</pre>';
			for($ii=0; $ii<count($linestmp); $ii++)
			{				
				if(strlen(trim($linestmp[$ii]))==0)
				{
					continue;
				}
				if(strstr(strtolower($linestmp[$ii]), "/opt/freesvr/audit/passwd/sbin/freesvr-passwd"))
				{
					if($chpwdservice){
						$linestmp[$ii]="$minute $hour $day * $week /opt/freesvr/audit/passwd/sbin/freesvr-passwd\n";
					}else{
						$linestmp[$ii]="#/opt/freesvr/audit/passwd/sbin/freesvr-passwd\n";
					}
				}
				if(strstr(strtolower($linestmp[$ii]), "/opt/freesvr/audit/sbin/listacct"))
				{
					if($accountservice){
						$linestmp[$ii]="$uminute $uhour $uday * $uweek /opt/freesvr/audit/sbin/listacct > /tmp/acct.log\n";
					}else{
						$linestmp[$ii]="#$uminute $uhour $uday * $uweek /opt/freesvr/audit/sbin/listacct > /tmp/acct.log\n";
					}
				}
				if(strstr(strtolower($linestmp[$ii]), "/home/wuxiaolong/5_backup/backup_csv.pl"))
				{
					if($uploadservice){
						$linestmp[$ii]="$pminute $phour $pday * $pweek /home/wuxiaolong/5_backup/backup_csv.pl\n";
					}else{
						$linestmp[$ii]="#$pminute $phour $pday * $pweek /home/wuxiaolong/5_backup/backup_csv.pl\n";
					}
				}
				//echo $linestmp[$ii];echo '<br>';
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
			}
			$jj++;
		}
		$this->assign("uploadservice", $uploadservice);
		$this->assign("chpwdservice", $chpwdservice);
		$this->assign("accountservice", $accountservice);
		$this->display('password_cron.tpl');
	}
	
	function dev_priority_search() {
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
		$ip = get_request('ip',1,1) ? get_request('ip',1,1) : get_request('ip',0,1);
		$s_user = get_request('s_user',1,1) ? get_request('s_user',1,1) : get_request('s_user',0,1);
		$user = get_request('user',1,1) ? get_request('user',1,1) : get_request('user',0,1);
		$resgrp = get_request('resourcegrp',1,1) ? get_request('resourcegrp',1,1) : get_request('resourcegrp',0,1);
		$group = get_request('group',1,1) ? get_request('group',1,1) : get_request('group',0,1);
		$type = get_request('type', 0, 1);
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

		if(empty($type)){
			$type='luser';
		}
		if($ip != '') {
			$where .= " AND device_ip LIKE '%$ip%'";
		}

		if($s_user != '') {
			$where .= " AND username= '$s_user'";
		}
		if($user != '') {				
			$member = $this->member_set->select_all(" username='".$user."'");
			$member = $member[0];
			if(empty($member)){
				alert_and_back('该用户不存在 ','admin.php?controller=admin_pro&action=dev_priority_search');
				exit;
			}
			$whereuid = " AND uid=".$member['uid'];
		}
		if($group != '') {			
			$groupinfo = $this->usergroup_set->select_all(" GroupName='".$group."'");
			$groupinfo= $groupinfo[0];
			if(empty($groupinfo)){
				alert_and_back('该组不存在 ','admin.php?controller=admin_pro&action=dev_priority_search');
				exit;
			}
			$wheregid = " AND groupid=".(int)$groupinfo['id'];
		}
		
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$where .= " AND id IN ($_SESSION[DEVS])";
		}
		
		$tem = $this->tem_set->select_by_id($dev['template_id']);
		$this->assign('login_method',$tem['device_type'].'/'.$tem['login_method']);
		$search = $ip.$user.$s_user.$group;
		if(!empty($search)){
			if($type=='luser'){
				
				$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE 1=1 ";
				if($member['uid']){
					$sql .= " AND memberid=".$member['uid'];
				}
				$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE 1=1 ";
				if($member['uid']){
					$sql .= " AND  a.memberid=".$member['uid'];
				}
				$sql .= ")";
				$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()."  WHERE 1=1 ";			
				if($member['uid']){
					$sql .= " AND  groupid=".$member['groupid'];
				}
				$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE 1=1 ";
				if($member['uid']){
					$sql .= " AND  a.groupid=".$member['groupid'];
				}
				$sql .= ")";
				if($user){
					$alldevid = $this->member_set->base_select("$sql");
				}elseif($s_user){
					$alldevid = $this->member_set->base_select("SELECT t.devicesid FROM devices d LEFT JOIN ($sql) t ON d.id=t.devicesid WHERE username like '%$s_user%'");
				}elseif($ip){
					$alldevid = $this->member_set->base_select("SELECT t.devicesid FROM devices d LEFT JOIN ($sql) t ON d.id=t.devicesid WHERE device_ip like '%$ip%'");
				}
				for($i=0; $i<count($alldevid); $i++){
					if($alldevid[$i]['devicesid'])
					$alldevsid[]=$alldevid[$i]['devicesid'];
				}
				if(empty($alldevsid)){
					$alldevsid[0]=0;
				}
				$sql = " SELECT *,if(luid,1,if(ludid,2,if(lgid,3,4))) AS orderby FROM (
							SELECT id,device_ip,hostname,username,login_method FROM devices WHERE id IN(".implode(',', $alldevsid).") ".$where.")ds ";
				$sql .= "	LEFT JOIN (
								SELECT '1' as l11,l1.id luid,l1.devicesid ludevicesid,l1.weektime lupolicyname,l1.forbidden_commands_groups lufcg,l1.sourceip lusourceip,l1.syslogalert lusyslogalert, l1.mailalert lumailalert, l1.loginlock luloginlock,l1.autosu luautosu,m.username luname,m.uid,m.groupid lugroupid FROM luser l1 
								LEFT JOIN member m ON l1.memberid=m.uid  WHERE m.uid IS NOT NULL ".$whereuid." 
							) lu ON ds.id=lu.ludevicesid ";
				$sql .= "	LEFT JOIN (
								SELECT '2' as l12,l2.id ludid,r.devicesid luddevicesid, l2.resourceid luresourceid,l2.weektime ludpolicyname,l2.forbidden_commands_groups ludfcg,l2.sourceip ludsourceip,l2.syslogalert ludsyslogalert, l2.mailalert ludmailalert, l2.loginlock ludloginlock,l2.autosu ludautosu,m.username ludname FROM ( 
										SELECT ra.id,ra.groupname,rb.devicesid FROM resourcegroup ra 
										LEFT JOIN resourcegroup rb on ra.groupname=rb.groupname where ra.devicesid=0 and rb.devicesid!=0 ".(!empty($resgrp) ? ' AND ra.groupname="'.$resgrp.'"' : '')."
								) r 
								LEFT JOIN luser_resourcegrp l2 ON r.id=l2.resourceid LEFT JOIN member m ON l2.memberid=m.uid  WHERE m.uid IS NOT NULL AND r.devicesid  IN(".implode(',', $alldevsid).") ".$whereuid."
							) lud ON ds.id=lud.luddevicesid ";
				$sql .= "	LEFT JOIN (
								SELECT '3' as l13,l3.id lgid,l3.devicesid lgdevicesid,l3.groupid lggroupid,l3.weektime lgpolicyname,l3.forbidden_commands_groups lgfcg,l3.sourceip lgsourceip,l3.syslogalert lgsyslogalert, l3.mailalert lgmailalert, l3.loginlock lgloginlock,l3.autosu lgautosu,ug.GroupName lgname FROM lgroup l3  
								LEFT JOIN usergroup ug ON l3.groupid=ug.id  WHERE ug.id IS NOT NULL AND l3.devicesid IN(".implode(',', $alldevsid).")
							) lg ON ds.id=lg.lgdevicesid ";
				$sql .= "	LEFT JOIN (
								SELECT '4' as l14,l4.id lgdid,r.devicesid lgddevicesid,l4.resourceid lgresourceid,l4.weektime lgdpolicyname,l4.forbidden_commands_groups lgdfcg,l4.sourceip ldgsourceip,l4.syslogalert ldgsyslogalert, l4.mailalert ldgmailalert, l4.loginlock ldgloginlock,l4.autosu ldgautosu,ug.GroupName lgdname,l4.groupid ldgresgrpid FROM( 
									SELECT ra.id,ra.groupname,rb.devicesid FROM resourcegroup ra 
										LEFT JOIN resourcegroup rb on ra.groupname=rb.groupname where ra.devicesid=0 and rb.devicesid!=0 ".(!empty($resgrp) ? ' AND ra.groupname="'.$resgrp.'"' : '')."
								) r 
								LEFT JOIN lgroup_resourcegrp l4 ON r.id=l4.resourceid 
								LEFT JOIN usergroup ug ON l4.groupid=ug.id  WHERE ug.id IS NOT NULL AND r.devicesid IN(".implode(',', $alldevsid).")
							) lgd ON ds.id=lgd.lgddevicesid ";
				if($member['groupid']){
					$sql .= " AND ".$member['groupid']."=lgd.ldgresgrpid";
				}

			}elseif($type=='lgroup'){
				$sql .= " SELECT devicesid FROM ".$this->lgroup_set->get_table_name()."  WHERE 1=1 ";			
				if($groupinfo['id']){
					$sql .= " AND  groupid=".$groupinfo['id'];
				}
				$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE 1=1 ";
				if($groupinfo['id']){
					$sql .= " AND  a.groupid=".$groupinfo['id'];
				}
				$sql .= ")";
				$alldevid = $this->member_set->base_select($sql);
				for($i=0; $i<count($alldevid); $i++){
					$alldevsid[]=$alldevid[$i]['devicesid'];
				}
				if(empty($alldevsid)){
					$alldevsid[0]=0;
				}
				$sql = " SELECT *,if(lgid,1,2) AS orderby  FROM (
							SELECT d.*,s.groupid FROM  (
								SELECT id,device_ip,username,login_method FROM devices WHERE id IN(".implode(',', $alldevsid).") ".$where." "."
							) d 
						 LEFT JOIN servers s ON d.device_ip=s.device_ip
						 ) ds ";
				$sql .= "LEFT JOIN (
							SELECT l3.id lgid,l3.devicesid lgdevicesid,l3.weektime lgpolicyname,l3.forbidden_commands_groups lgfcg,l3.sourceip lgsourceip,l3.syslogalert lgsyslogalert, l3.mailalert lgmailalert, l3.loginlock lgloginlock,l3.autosu lgautosu,l3.groupid groupid3,ug.GroupName lgname FROM lgroup l3  
							LEFT JOIN usergroup ug ON l3.groupid=ug.id WHERE ug.id IS NOT NULL ".$wheregid."
						 ) lg ON ds.id=lg.lgdevicesid ";
				$sql .= "LEFT JOIN (
							SELECT l4.id lgdid,r.devicesid lgddevicesid,l4.weektime lgdpolicyname,l4.forbidden_commands_groups lgdfcg,l4.sourceip lgdsourceip,l4.syslogalert lgdsyslogalert, l4.mailalert lgdmailalert, l4.loginlock lgdloginlock,l4.autosu lgdautosu,l4.groupid groupid4,ug.GroupName lgdname FROM ( 
								SELECT ra.id,ra.groupname,rb.devicesid FROM resourcegroup ra 
										LEFT JOIN resourcegroup rb on ra.groupname=rb.groupname where ra.devicesid=0 and rb.devicesid!=0 
								) r 
							LEFT JOIN lgroup_resourcegrp l4 ON r.id = l4.resourceid
							LEFT JOIN usergroup ug ON l4.groupid=ug.id WHERE ug.id IS NOT NULL ".$wheregid."
						 ) lgd ON ds.id=lgd.lgddevicesid ";

			}

			$result = $this->server_set->query("SELECT count(*) AS row_num ".substr($sql, strpos($sql, "FROM")));
			$row = mysql_fetch_assoc($result);
			$row_num=$row['row_num'];
			
			$newpager = new my_pager($row_num, $page_num, 20, 'page');
			//$alldev = $this->server_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);
			
			$sql = "$sql ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
			$alldev = $this->server_set->base_select($sql);
		}else{
			$newpager = new my_pager($row_num, $page_num, 20, 'page');
		}
		/*$result = $this->server_set->query("SELECT count(*) AS row_num FROM (".$sql.") t ");
		$row = mysql_fetch_assoc($result);
		$row_num=$row['row_num'];
		
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
		//$alldev = $this->server_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);
		
		$sql = "$sql ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$alldev = $this->server_set->base_select($sql);*/
		
		$alltem = $this->tem_set->select_all();
		$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		$num = count($alldev);
		for($i=0;$i<$num;$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
				elseif($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}
			}
			$servergroup = $this->server_set->select_all("device_ip='".$alldev[$i]['device_ip']."'");
			$alldev[$i]['groupid'] = $servergroup[0]['groupid'];
			if($allgroup)
			foreach($allgroup as $groupt){
				if($groupt[id]==$alldev[$i][groupid]){//var_dump($groupt);
					$alldev[$i][groupname]=$groupt[groupname];
					if($groupt[ldapid]){
						foreach($allgroup as $groupt1){							
							if($groupt1[id]==$groupt[ldapid]){
								$alldev[$i][groupnamep1]=$groupt1[groupname];
								if($groupt1[ldapid]){
									foreach($allgroup as $groupt2){							
										if($groupt2[id]==$groupt1[ldapid]){
											$alldev[$i][groupnamep2]=$groupt2[groupname];
											break;
										}
									}
								}
								break;
								break;
							}
						}
					}
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
			if($type=='luser'){
				if($alldev[$i]['luid']){
					$alldev[$i]['webuser']=$alldev[$i]['luname'];
					$alldev[$i]['policyname']=$alldev[$i]['lupolicyname'];
					$alldev[$i]['forbidden_commands_groups']=$alldev[$i]['lufcg'];
					$alldev[$i]['sourceip']=$alldev[$i]['lusourceip'];
					$alldev[$i]['syslogalert']=$alldev[$i]['lusyslogalert'];
					$alldev[$i]['mailalert']=$alldev[$i]['lumailalert'];
					$alldev[$i]['loginlock']=$alldev[$i]['luloginlock'];
					$alldev[$i]['autosu']=$alldev[$i]['luautosu'];
				}elseif($alldev[$i]['ludid']){
					$alldev[$i]['webuser']=$alldev[$i]['ludname'];
					$alldev[$i]['policyname']=$alldev[$i]['ludpolicyname'];
					$alldev[$i]['forbidden_commands_groups']=$alldev[$i]['ludfcg'];
					$alldev[$i]['sourceip']=$alldev[$i]['ludsourceip'];
					$alldev[$i]['syslogalert']=$alldev[$i]['ludsyslogalert'];
					$alldev[$i]['mailalert']=$alldev[$i]['ludmailalert'];
					$alldev[$i]['loginlock']=$alldev[$i]['ludloginlock'];
					$alldev[$i]['autosu']=$alldev[$i]['ludautosu'];
				}elseif($alldev[$i]['lgid']){
					$alldev[$i]['webuser']=$alldev[$i]['lgname'].'('.language('运维组').')';
					$alldev[$i]['policyname']=$alldev[$i]['lgpolicyname'];
					$alldev[$i]['forbidden_commands_groups']=$alldev[$i]['lgfcg'];
					$alldev[$i]['sourceip']=$alldev[$i]['lgsourceip'];
					$alldev[$i]['syslogalert']=$alldev[$i]['lgsyslogalert'];
					$alldev[$i]['mailalert']=$alldev[$i]['lgmailalert'];
					$alldev[$i]['loginlock']=$alldev[$i]['lgloginlock'];
					$alldev[$i]['autosu']=$alldev[$i]['lgautosu'];
				}elseif($alldev[$i]['lgdid']){
					$alldev[$i]['webuser']=$alldev[$i]['lgdname'].'('.language('运维组').')';
					$alldev[$i]['policyname']=$alldev[$i]['lgdpolicyname'];
					$alldev[$i]['forbidden_commands_groups']=$alldev[$i]['lgdfcg'];
					$alldev[$i]['sourceip']=$alldev[$i]['ldgsourceip'];
					$alldev[$i]['syslogalert']=$alldev[$i]['ldgsyslogalert'];
					$alldev[$i]['mailalert']=$alldev[$i]['ldgmailalert'];
					$alldev[$i]['loginlock']=$alldev[$i]['ldgloginlock'];
					$alldev[$i]['autosu']=$alldev[$i]['ldgautosu'];
				}
			}elseif($type=='lgroup'){
				if($alldev[$i]['lgid']){
					$alldev[$i]['gname']=$alldev[$i]['lgname'];
					$alldev[$i]['policyname']=$alldev[$i]['lgpolicyname'];
					$alldev[$i]['forbidden_commands_groups']=$alldev[$i]['lgfcg'];
					$alldev[$i]['sourceip']=$alldev[$i]['lgsourceip'];
					$alldev[$i]['syslogalert']=$alldev[$i]['lgsyslogalert'];
					$alldev[$i]['mailalert']=$alldev[$i]['lgmailalert'];
					$alldev[$i]['loginlock']=$alldev[$i]['lgloginlock'];
					$alldev[$i]['autosu']=$alldev[$i]['lgautosu'];
				}elseif($alldev[$i]['lgdid']){
					$alldev[$i]['gname']=$alldev[$i]['lgdname'];
					$alldev[$i]['policyname']=$alldev[$i]['lgdpolicyname'];
					$alldev[$i]['forbidden_commands_groups']=$alldev[$i]['lgdfcg'];
					$alldev[$i]['sourceip']=$alldev[$i]['lgdsourceip'];
					$alldev[$i]['syslogalert']=$alldev[$i]['lgdsyslogalert'];
					$alldev[$i]['mailalert']=$alldev[$i]['lgdmailalert'];
					$alldev[$i]['loginlock']=$alldev[$i]['lgdloginlock'];
					$alldev[$i]['autosu']=$alldev[$i]['lggautosu'];
				}
			}
			if(empty($alldev[$i]['webuser'])){
				$alldev[$i]['webuser']='NULL';
			}
			if(empty($alldev[$i]['gname'])){
				$alldev[$i]['gname']='NULL';
			}
			if(empty($alldev[$i]['groupname'])){
				$alldev[$i]['groupname']='NULL';
			}
			if(empty($alldev[$i]['policyname'])){
				$alldev[$i]['policyname']='NULL';
			}
			if(empty($alldev[$i]['sourceip'])){
				$alldev[$i]['sourceip']='NULL';
			}
			if(empty($alldev[$i]['forbidden_commands_groups'])){
				$alldev[$i]['forbidden_commands_groups']='NULL';
			}else{
				$fb=$this->forbiddengps_set->select_all("gname='".$alldev[$i]['forbidden_commands_groups']."'");
				if(!empty($fb)){
					$alldev[$i]['forbidden_commands_groups'].='('.($fb[0]['black_or_white']==1 ? '白' : ($fb[0]['black_or_white']==3 ? '授权' : '黑')).')';
				}
			}
			if(empty($alldev[$i]['lastdate'])){
				$alldev[$i]['lastdate']='NULL';
			}
			if(empty($alldev[$i]['device_ip'])){
				$alldev[$i]['device_ip']='NULL';
			}
			if(empty($alldev[$i]['username'])){
				$alldev[$i]['username']='NULL';
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
		//echo '<pre>';print_r($alldev);echo '</pre>';
		$resourcegrp = $this->resgroup_set->select_all("devicesid=0");
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('type', $type);
		$this->assign('ip', $ip);
		$this->assign('s_user', $s_user);
		$this->assign('user', $user);
		$this->assign('group', $group);
		$this->assign('resourcegrp', $resourcegrp);
		$this->assign('curr_url', $curr_url);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('dev_priority_search.tpl');
	}

	function app_priority_search() {
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

		if(empty($type)){
			$type='luser';
		}
		if($appserverip != '') {
			$where .= " AND pub.appserverip LIKE '%$appserverip%'";
		}

		if($appname != '') {
			$where .= " AND pub.name LIKE '%$appname%'";
		}

		if($device_ip != '') {
			$where .= " AND d.device_ip LIKE '%$device_ip%'";
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
			$whereuid = " AND uid=".$member['uid'];
		}
		if($group != '') {			
			$groupinfo = $this->usergroup_set->select_all(" GroupName='".$group."'");
			$groupinfo= $groupinfo[0];
			if(empty($groupinfo)){
				alert_and_back('该组不存在 ','admin.php?controller=admin_pro&action=app_priority_search');
				exit;
			}
			$wheregid = " AND groupid=".(int)$groupinfo['id'];
		}
		
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$where .= " AND id IN ($_SESSION[DEVS])";
		}
		
		$tem = $this->tem_set->select_by_id($dev['template_id']);
		$this->assign('login_method',$tem['device_type'].'/'.$tem['login_method']);
		if($type=='luser'){
			
			$sql = "SELECT appdeviceid FROM ".$this->appmember_set->get_table_name()." WHERE 1=1 ";
			if($member['uid']){
				$sql .= " AND memberid=".$member['uid'];
			}
			$sql .= " UNION select appdevicesid FROM appresourcegroup WHERE appgroupname IN(select ag.appgroupname FROM luser_appresourcegrp la LEFT JOIN appresourcegroup ag ON la.appresourceid=ag.id WHERE 1";
			if($member['uid']){
				$sql .= " AND memberid=".$member['uid'];
			}
			$sql .= ")";
			
			$sql .= " UNION SELECT appdeviceid FROM ".$this->appgroup_set->get_table_name()."  WHERE 1=1 ";			
			if($member['uid']){
				$sql .= " AND  groupid=".$member['groupid'];
			}
			
			$alldevid = $this->member_set->base_select($sql);
			for($i=0; $i<count($alldevid); $i++){
				$alldevsid[]=$alldevid[$i]['appdeviceid'];
			}
			if(empty($alldevsid)){
				$alldevsid[0]=0;
			}
			$sql ="";
			$sql = " SELECT *,if(luid,1,if(luruid,2,if(lgid,3,4))) AS orderby FROM (
						SELECT d.id,d.username,d.change_password,d.enable,d.device_ip,pub.id apppubid,pub.appserverip,pub.name appname FROM appdevices d LEFT JOIN apppub pub ON d.apppubid=pub.id WHERE d.id IN(".implode(',', $alldevsid).") ".$where."
						)ds ";
			$sql .= "	LEFT JOIN (
							SELECT '1' as l11,l1.id luid,l1.appdeviceid ludevicesid,m.username luname,m.uid,m.groupid lugroupid FROM appmember l1 
							LEFT JOIN member m ON l1.memberid=m.uid  WHERE m.uid IS NOT NULL ".$whereuid." 
						) lu ON ds.id=lu.ludevicesid ";
			$sql .= "	LEFT JOIN (
							SELECT '2' as l12,l2.appresourceid lurid,l2.appdevicesid lurdevicesid,m.username lurname,m.uid luruid,m.groupid lurgroupid FROM (select ag.appdevicesid,la.memberid,la.appresourceid FROM (SELECT a.id,b.appdevicesid FROM appresourcegroup a LEFT JOIN appresourcegroup b ON a.appgroupname=b.appgroupname WHERE a.appdevicesid=0 AND b.appdevicesid!=0) ag LEFT JOIN luser_appresourcegrp la  ON la.appresourceid=ag.id) l2 
							LEFT JOIN member m ON l2.memberid=m.uid  WHERE m.uid IS NOT NULL ".$whereuid." 
						) lur ON ds.id=lur.lurdevicesid ";
			
			$sql .= "	LEFT JOIN (
							SELECT '3' as l13,l3.id lgid,l3.appdeviceid lgdevicesid, ug.GroupName lgname FROM appgroup l3  
							LEFT JOIN usergroup ug ON l3.groupid=ug.id  WHERE ug.id IS NOT NULL
						) lg ON ds.id=lg.lgdevicesid ";

		}elseif($type=='lgroup'){
			$sql .= " SELECT appdeviceid FROM ".$this->appgroup_set->get_table_name()."  WHERE 1=1 ";			
			if($groupinfo['id']){
				$sql .= " AND  groupid=".$groupinfo['id'];
			}
			$alldevid = $this->member_set->base_select($sql);
			for($i=0; $i<count($alldevid); $i++){
				$alldevsid[]=$alldevid[$i]['appdeviceid'];
			}
			if(empty($alldevsid)){
				$alldevsid[0]=0;
			}
			$sql = " SELECT *,if(lgid,1,2) AS orderby  FROM (
						SELECT d.*,pub.appserverip,pub.name appname FROM  (
							SELECT id,username,change_password,enable,apppubid FROM appdevices WHERE id IN(".implode(',', $alldevsid).") ".$where." "."
						) d 
					 LEFT JOIN apppub pub ON d.apppubid=pub.id
					 ) ds ";
			$sql .= "LEFT JOIN (
						SELECT l3.id lgid,l3.appdeviceid lgdevicesid,l3.groupid groupid3,ug.GroupName lgname FROM appgroup l3  
						LEFT JOIN usergroup ug ON l3.groupid=ug.id WHERE ug.id IS NOT NULL ".$wheregid."
					 ) lg ON ds.id=lg.lgdevicesid ";
			$sql .= "	LEFT JOIN (
							SELECT l2.id lgrid,l2.appdevicesid lgrdevicesid,l2.groupid groupid2,ug.GroupName lgrname FROM (select ag.appdevicesid,la.groupid,la.id FROM (SELECT a.id,b.appdevicesid FROM appresourcegroup a LEFT JOIN appresourcegroup b ON a.appgroupname=b.appgroupname WHERE a.appdevicesid=0 AND b.appdevicesid!=0) ag LEFT JOIN lgroup_appresourcegrp la  ON la.appresourceid=ag.id) l2 
							LEFT JOIN usergroup ug ON l2.groupid=ug.id WHERE ug.id IS NOT NULL ".$wheregid." 
						) lur ON ds.id=lur.lgrdevicesid ";

		}
		$result = $this->server_set->query("SELECT count(*) AS row_num FROM (".$sql.") t ");
		$row = mysql_fetch_assoc($result);
		$row_num=$row['row_num'];
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
		//$alldev = $this->server_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);
		
		$sql = "$sql ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$alldev = $this->server_set->base_select($sql);
		
		$alltem = $this->tem_set->select_all();
		$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		$num = count($alldev);
		for($i=0;$i<$num;$i++) {
			
			if($allgroup)
			foreach($allgroup as $groupt){
				if($groupt[id]==$alldev[$i][groupid]){
					$alldev[$i][groupname]=$groupt[groupname];
					break;
				}
			}
			if($type=='luser'){
				if($alldev[$i]['luid']){
					$alldev[$i]['webuser']=$alldev[$i]['luname'];
				}elseif($alldev[$i]['lurid']){
					$alldev[$i]['webuser']=$alldev[$i]['lurname'];
				}elseif($alldev[$i]['ludid']){
					$alldev[$i]['webuser']=$alldev[$i]['ludname'];
				}elseif($alldev[$i]['lgid']){
					$alldev[$i]['webuser']=$alldev[$i]['lgname'].'('.language('运维组').')';
				}elseif($alldev[$i]['lgdid']){
					$alldev[$i]['webuser']=$alldev[$i]['lgdname'].'('.language('运维组').')';
				}
			}elseif($type=='lgroup'){
				if($alldev[$i]['lgid']){
					$alldev[$i]['gname']=$alldev[$i]['lgname'];
				}elseif($alldev[$i]['lgdid']){
					$alldev[$i]['gname']=$alldev[$i]['lgdname'];
				}
			}
			if(empty($alldev[$i]['webuser'])){
				$alldev[$i]['webuser']='NULL';
			}
			if(empty($alldev[$i]['gname'])){
				$alldev[$i]['gname']='NULL';
			}
			if(empty($alldev[$i]['groupname'])){
				$alldev[$i]['groupname']='NULL';
			}
			if(empty($alldev[$i]['device_ip'])){
				$alldev[$i]['device_ip']='NULL';
			}
			if(empty($alldev[$i]['username'])){
				$alldev[$i]['username']='NULL';
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
	
	
	function sshpublickey() {
		$page_num = get_request('page');
		$this->assign('title', 'SSH公钥'.language("列表"));
		
		$row_num = $this->sshpublickey_set->select_count('memberid='.$_SESSION['ADMIN_UID']);
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
	
	
	function resource_group() {
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$groupname = get_request('groupname', 0, 1);
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
		if($_SESSION['ADMIN_LEVEL']==3){
			$where .= ' AND user="'.$_SESSION['ADMIN_USERNAME'].'"';
		}
		if(!empty($groupname)){
			$where .= " AND groupname like '%".$groupname."%'";
		}

		$row_num = $this->resgroup_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
		$alldev = $this->resgroup_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);

		$this->assign('title', language('资源组列表'));
		$this->assign('alldev', $alldev);
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
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		$gid = get_request('id');
		$gname = get_request('gname',0,1);
		$hostname = get_request('hostname',0,1);
		$username = get_request('username',0,1);
		$lm = get_request('lm');
		$groupid = get_request('groupid');
		$ldapid1 = get_request('ldapid1');
		$ldapid2 = get_request('ldapid2');
		$ip = get_request('ip', 0, 1);
		$where = '1=1';
		if($groupid){
			$where .= " AND s.groupid=".$groupid;
		}else if($ldapid2){
			$where .= " AND (s.groupid=$ldapid2 or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid='".$ldapid2."'))";
		}else if($ldapid1){
			$where .= " AND (s.groupid=$ldapid1 or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid='".$ldapid1."') or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid='".$ldapid1."')))";
		}
		if($ip){
			$where .= " AND s.device_ip like '%$ip%'";
		}
		if($hostname){
			$where .= " AND s.hostname like '%$hostname%'";
		}if($username){
			$where .= " AND d.username like '%$username%'";
		}
		if($lm){
			$where .= " AND l.id='$lm'";
		}
		
		$ginfo = $this->resgroup_set->select_by_id($gid);
		$allmethod =  $this->tem_set->select_all("device_type = ''",'','ASC');	
		//$res = $this->resgroup_set->select_all("groupname='$gname' and devicesid!=0");
		
		$resources = $this->devpass_set->base_select("SELECT d.*,l.login_method lmname,if(entrust_password=1,'托密','不托密') as ep FROM devices d LEFT JOIN (SELECT distinct devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname='".$ginfo['groupname']."' and devicesid!=0) t ON d.id=t.devicesid LEFT JOIN login_template l ON d.login_method=l.id   LEFT JOIN servers s ON d.device_ip=s.device_ip  WHERE $where AND t.devicesid IS NULL ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND s.device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP'].' or groupid IN(SELECT id FROM '.$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].')) )' : '')." ORDER BY device_ip");
		
		$res = $this->devpass_set->base_select("SELECT d.*,l.login_method lmname,if(entrust_password=1,'托密','不托密') as ep FROM devices d LEFT JOIN (SELECT distinct devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname='".$ginfo['groupname']."' and devicesid!=0) t ON d.id=t.devicesid LEFT JOIN login_template l ON d.login_method=l.id    LEFT JOIN servers s ON d.device_ip=s.device_ip  WHERE 1 AND t.devicesid IS NOT NULL ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND s.device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP'].' or groupid IN(SELECT id FROM '.$this->sgroup_set->get_table_name().' WHERE ldapid='.$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].')) )' : '')." ORDER BY device_ip");
		
		$login_method = $this->tem_set->select_all();
		$where = "1";
		if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			$where .= " AND (id=".$_SESSION['ADMIN_MSERVERGROUP']." or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].") or id IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP']."))) ";
		}
		$allgroup = $this->sgroup_set->select_all($where,'groupname', 'asc');
		//echo '<pre>';print_r($resources);echo '</pre>';
		if($gname) $ginfo['groupname']=$gname;
		$this->assign("res", $res);
		$this->assign("resource", $resources);
		$this->assign("ginfo", $ginfo);
		$this->assign("groupid", $groupid);
		$this->assign("allgroup", $allgroup);
		$this->assign("allmethod", $allmethod);
		$this->assign("ip", $ip);
		$this->assign("hostname", $hostname);
		$this->assign("username", $username);
		$this->display('resource_group_edit.tpl');
	}
	
	
	function resource_group_save() {
		$gname = get_request('gname', 1, 1);
		$desc = get_request('desc', 1, 1);
		$oldgname = get_request('oldgname', 1, 1);
		$gid = get_request("id",1,0);
		$selected = get_request('secend', 1, 1);
		$groupid = get_request('groupid', 1, 1);
		$where = "1=1";
		if($groupid){
			$where .= " AND devicesid IN(SELECT d.id FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ".$this->server_set->get_table_name()." s ON d.device_ip=s.device_ip WHERE s.groupid='$groupid')";
		}
		if($gname==""){
			alert_and_back("组名不能为空");
			exit;
		}elseif($this->resgroup_set->select_count("groupname='$gname' and id!=$gid and devicesid=0") >0){
			alert_and_back("组名已经存在");
			exit;
		}elseif(empty($gid)){
			$resourcegroup = new resgroup();
			$resourcegroup->set_data('groupname',$gname);
			$resourcegroup->set_data('desc',$desc);
			$resourcegroup->set_data('devicesid',0);
			$resourcegroup->set_data('user',$_SESSION['ADMIN_USERNAME']);
			$this->resgroup_set->add($resourcegroup);
			unset($resourcegroup);
		}
		if($gid){
			$this->resgroup_set->delete_all("groupname='$oldgname' and devicesid!=0 and $where");
			$resourcegroup = new resgroup();
			$resourcegroup->set_data('id',$gid);
			$resourcegroup->set_data('groupname',$gname);
			$resourcegroup->set_data('desc',$desc);
			$this->resgroup_set->edit($resourcegroup);
			unset($resourcegroup);
		}
		if(empty($selected)){
			$selected[]=0;
		}

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
			/*if(iconv("GB2312", "UTF-8", trim($lines[0][0]))!='主机名' || iconv("GB2312", "UTF-8", trim($lines[0][1]))!='IP' || iconv("GB2312", "UTF-8", trim($lines[0][2]))!='服务器组' || iconv("GB2312", "UTF-8", trim($lines[0][3]))!='系统类型'|| iconv("GB2312", "UTF-8", trim($lines[0][4]))!='系统用户'){
				alert_and_back("文件有问题，请上传正确的文件");
				exit;
			}*/
			//echo '<pre>';print_r($lines);echo '</pre>';exit;
			$j=0;
			for($i=1; $i<count($lines); $i++){
				if(empty($lines[$i])){
					continue;
				}
				$linearr = $lines[$i];	
				for($ii=0; $ii<count($linearr); $ii++){
					$linearr[$ii]=iconv("GB2312", "UTF-8", $linearr[$ii]);
				}
				$device_ip=trim($linearr[0]);
				$username=trim($linearr[1]);
				$login_method=trim($linearr[2]);
				$port=trim($linearr[3]);
				if(empty($device_ip)){
					continue;
				}
				if(preg_match("/[\\r\\n]/", $device_ip)||preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $lmethod)||preg_match("/[\\r\\n]/", $port)){
					$error[]=$device_ip.':'.'用户信息中含有回车符'.'\n';
					continue;
				}
				$alltem = $this->tem_set->select_all();
				$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
				foreach($alltem as $tem) {
					if($login_method&&strtolower($login_method) == strtolower($tem['login_method'])) {
						$login_method = $tem['id'];
					}
				}
				if(empty($login_method)){
					$error[]=$device_ip.' '.(empty($username) ? '空用户' : $username).' '.':'.'登录方式不能识别'.'\n';
					continue;
				}
				//echo "device_ip='$device_ip' and login_method='$login_method' and username='$username' and port='$port'";
				$dev = $this->devpass_set->select_all("device_ip='$device_ip' and login_method='$login_method' and username='$username' and port='$port'");
				if($dev&&!in_array($dev[0]['id'], $selected)){
					$selected[]=$dev[0]['id'];
				}
			}
		}

		for($i=0; $i<count($selected); $i++){
			if(empty($selected[$i])){
				continue;
			}
			$resourcegroup = new resgroup();
			$resourcegroup->set_data('groupname',$gname);
			$resourcegroup->set_data('devicesid',$selected[$i]);
			$resourcegroup->set_data('user',$_SESSION['ADMIN_USERNAME']);
			$this->resgroup_set->add($resourcegroup);
			unset($resourcegroup);
		}

		alert_and_back("操作成功",'admin.php?controller=admin_pro&action=resource_group');
	}

	function resource_group_import(){
		$this->display("resourcegroupimport.tpl");
	}

	function resource_group_doimport(){		
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
			/*if(iconv("GB2312", "UTF-8", trim($lines[0][0]))!='主机名' || iconv("GB2312", "UTF-8", trim($lines[0][1]))!='IP' || iconv("GB2312", "UTF-8", trim($lines[0][2]))!='服务器组' || iconv("GB2312", "UTF-8", trim($lines[0][3]))!='系统类型'|| iconv("GB2312", "UTF-8", trim($lines[0][4]))!='系统用户'){
				alert_and_back("文件有问题，请上传正确的文件");
				exit;
			}*/
			//echo '<pre>';print_r($lines);echo '</pre>';exit;
			$j=0;
			for($i=1; $i<count($lines); $i++){
				if(empty($lines[$i])){
					continue;
				}
				$linearr = $lines[$i];	//var_dump($linearr);
				for($ii=0; $ii<count($linearr); $ii++){
					$linearr[$ii]=iconv("GB2312", "UTF-8", $linearr[$ii]);
				}//var_dump($linearr);
				$device_ip=trim($linearr[0]);
				$username=trim($linearr[1]);
				if($username=='空用户'){
					$username = '';
				}
				$login_method=trim($linearr[2]);
				$port=trim($linearr[3]);
				$gname=trim($linearr[4]);
				if(empty($device_ip) || empty($gname)){
					continue;
				}
				if(preg_match("/[\\r\\n]/", $device_ip)||preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $lmethod)||preg_match("/[\\r\\n]/", $port)){
					$error[]=$device_ip.':'.'用户信息中含有回车符'.'\n';
					continue;
				}
				$alltem = $this->tem_set->select_all();
				$allgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
				foreach($alltem as $tem) {
					if($login_method&&strtolower($login_method) == strtolower($tem['login_method'])) {
						$login_method = $tem['id'];
					}
				}
				
				$group_exist = $this->resgroup_set->select_count("groupname='$gname'");
				if($group_exist<=0){
					$resourcegroup = new resgroup();
					$resourcegroup->set_data('groupname',$gname);
					$resourcegroup->set_data('devicesid',0);
					$resourcegroup->set_data('user',$_SESSION['ADMIN_USERNAME']);
					$this->resgroup_set->add($resourcegroup);
					unset($resourcegroup);
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
				}else{
					$dev = $this->devpass_set->select_all("device_ip='$device_ip' and login_method='$login_method' and username='$username' and port='$port'");
					if($dev){
						$resourcegroup = new resgroup();
						$resourcegroup->set_data('groupname',$gname);
						$resourcegroup->set_data('devicesid',$dev[0]['id']);
						$resourcegroup->set_data('user',$_SESSION['ADMIN_USERNAME']);
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
		if(strpos($where, "d.device_ip")===false)
		$where = str_replace("device_ip", "d.device_ip", $where);
		$alldev = $this->devpass_set->base_select("SELECT a.*,b.device_ip,b.username,b.login_method,b.port FROM ".$this->resgroup_set->get_table_name()." a LEFT JOIN ".$this->devpass_set->get_table_name()." b ON a.devicesid = b.id WHERE a.devicesid!=0 order by groupname ASC,b.device_ip ASC");

		$str = language("IP").",".language("用户名").",".language("协议").",".language("端口").",".language("组名")."\n";
		
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

				$str .= $report['device_ip'].",".($report['username']==""  ? '空用户' : $report['username']).",".$report['login_method'].",".$report['port'].",".$report['groupname'];
				$str .= "\n";
			}
		}
		$str = iconv("UTF-8", "GB2312", $str);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=audit-resourcegroup-".date('Ymd').".csv"); 
		echo $str;
		exit;
	}

	function resource_group_del() {
		$gname = get_request('gname', 0, 1);
		$ginfo = $this->resgroup_set->select_all("groupname='$gname' and devicesid=0");
		$this->luser_resourcegrp_set->delete_all("resourceid=".$ginfo[0]['id']);
		$this->lgroup_resourcegrp_set->delete_all("resourceid=".$ginfo[0]['id']);
		$this->resgroup_set->delete_all("groupname='$gname'");

		alert_and_back("操作成功",'admin.php?controller=admin_pro&action=resource_group');
	}


	function change_device_pwd(){
		$sid = get_request('sid');
		$ac = get_request('ac', 1, 1);
		if($ac=='change'){
			$oldpwd = get_request('oldpwd', 1, 1);
			$newpwd = get_request('newpwd', 1, 1);
			$newpwdc = get_request('newpwdc', 1, 1);
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
		$where = "device_type = ''";
		$allmethod =  $this->tem_set->select_all($where,'','ASC');	
		
		$device = $this->server_set->select_all("id=$serverid");

		$this->assign('sshport',$device[0]['sshport'] ? $device[0]['sshport'] : '22');
		$this->assign('telnetport',$device[0]['telnetport']? $device[0]['telnetport'] : '23');
		$this->assign('ftpport',$device[0]['ftpport']? $device[0]['ftpport'] : '21');
		$this->assign('rdpport',$device[0]['rdpport']? $device[0]['rdpport'] : '3389');
		$this->assign('vncport',$device[0]['vncport']? $device[0]['vncport'] : '3389');
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
				$new_pass->set_data('cur_password',$new_password);
				$new_pass->set_data('login_method',$login_method);
				$new_pass->set_data('port',$port);
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
				$adminlog->set_data('action', language('添加'));
				$adminlog->set_data('resource', $ip);
				$adminlog->set_data('resource_user', $new_name);
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
			$where .= " AND creatorid=".$_SESSION['ADMIN_UID'];
		}
		$row_num = $this->tem_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
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
		$row_num = $this->sshkey_set->base_select("SELECT COUNT(*) row_num FROM ".$this->sshkeyname_set->get_table_name()." WHERE $where ");
		$row_num = $row_num[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, 20, 'page');
		$sshdevices = $this->sshkey_set->base_select("SELECT * FROM ".$this->sshkeyname_set->get_table_name()." WHERE $where ORDER BY sshkeyname ASC LIMIT ".$newpager->intStartPosition.", ".$newpager->intItemsPerPage);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		for($i=0; $i<count($sshdevices); $i++){
			$sshprivatekey = $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$sshdevices[$i]['username'].'_'.$sshdevices[$i]['devicesid'].'.pvt';
			if(file_exists($sshprivatekey)&&$sshdevices[$i]['sshprivatekey']){
				$sshdevices[$i]['private_key_file'] = 1;
			}else{
				$sshdevices[$i]['private_key_file'] = 0;
			}
			$sshpublickey = $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$sshdevices[$i]['username'].'_'.$sshdevices[$i]['devicesid'].'.pub';
			if(file_exists($sshpublickey)&&$sshdevices[$i]['sshpublickey']){
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
		$password = get_request('password',1,1);
		$password_confirm = get_request('password_confirm',1,1);
		if($password_confirm!=$password){
			alert_and_back('两次输入的密码不一致');
			exit;
		}elseif($this->sshkeyname_set->select_count("sshkeyname='$name' AND id!='".intval($id)."'")>0){
			alert_and_back('名称:'.$name.'已经存在');
			exit;
		}
		$sshkeyname = new sshkeyname();
		$sshkeyname->set_data("sshkeyname", $name);
		$sshkeyname->set_data("desc", $desc);
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
		if(@file_exists($_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt')){
			@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt');
		}
		if(@file_exists($_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub')){
			@exec("chmod 600 ".$_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub');
		}
		if(@file_exists($sshprivatekey)&&@copy($sshprivatekey, $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt')){
			@unlink($sshprivatekey);
			$sshkeyname2->set_data("sshprivatekey", $_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'].'/'.$id.'.pvt');
		}
		if(@file_exists($sshpublickey)&&@copy($sshpublickey, $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub')){
			@unlink($sshpublickey);
			$sshkeyname2->set_data("sshpublickey", $_CONFIG['PASSEDITSSHPULICKEY_NEW'].'/'.$id.'.pub');
		}		
		$this->sshkeyname_set->edit($sshkeyname2);
		
		alert_and_back('操作成功','admin.php?controller=admin_pro&action=sshkey');
	}

	function sshkey_delete(){
		$id = get_request('id');
		if(empty($id)){
			$id = $_POST['chk_member'];
			$this->sshkey_set->delete_all("sshkeyname IN(SELECT sshkeyname FROM ".$this->sshkeyname_set->get_table_name()." WHERE id IN(".(empty($id) ? '0' : implode(',', $id))."))");
		}else{
			$sshkeyname = $this->sshkeyname_set->select_by_id($id);
		}
		$this->sshkeyname_set->delete($id);
		alert_and_back('删除成功','admin.php?controller=admin_pro&action=sshkey');
	}

	function sshkey_list() {
		$keynameid = get_request('id');
		$groupid = get_request('groupid');
		$where = '1=1';
		if($groupid){
			$where .= " AND s.groupid=".$groupid;
		}
		$ginfo = $this->sshkeyname_set->select_by_id($keynameid);

		$sql = "SELECT l.memberid,l.devicesid,IFNULL(d.username, '空用户') username,u.username uname, d.device_ip,lt.login_method lmname FROM ".$this->luser_set->get_table_name()." l LEFT JOIN ".$this->devpass_set->get_table_name()." d ON l.devicesid=d.id LEFT JOIN ".$this->member_set->get_table_name()." u ON l.memberid=u.uid LEFT JOIN login_template lt ON d.login_method=lt.id  LEFT JOIN servers s ON d.device_ip=s.device_ip WHERE $where AND d.publickey_auth=1 and (d.login_method=3 or d.login_method=7)  AND concat(d.id,'_',l.memberid) NOT IN(SELECT concat(devicesid,'_',memberid) FROM ".$this->sshkey_set->get_table_name()." WHERE sshkeyname='".$ginfo['sshkeyname']."') ".($_SESSION['ADMIN_LEVEL']==3 ? ' and d.device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP'].')' : '')."";
		$resources = $this->sshkey_set->base_select($sql);

		$sql = "SELECT l.memberid,l.devicesid,IFNULL(d.username, '空用户') username,u.username uname, d.device_ip,lt.login_method lmname FROM ".$this->luser_set->get_table_name()." l LEFT JOIN ".$this->devpass_set->get_table_name()." d ON l.devicesid=d.id LEFT JOIN ".$this->member_set->get_table_name()." u ON l.memberid=u.uid LEFT JOIN login_template lt ON d.login_method=lt.id  LEFT JOIN servers s ON d.device_ip=s.device_ip WHERE $where AND d.publickey_auth=1 and (d.login_method=3 or d.login_method=7) AND concat(d.id,'_',l.memberid) IN(SELECT concat(devicesid,'_',memberid) FROM ".$this->sshkey_set->get_table_name()." WHERE sshkeyname='".$ginfo['sshkeyname']."') ".($_SESSION['ADMIN_LEVEL']==3 ? ' and d.device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP'].')' : '')."";
		$res = $this->sshkey_set->base_select($sql);

	
		$allgroup = $this->sgroup_set->select_all(($_SESSION['ADMIN_LEVEL']==3 ? ' and device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP'].')' : '1=1'), 'groupname', 'asc');
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
		
		$this->sshkey_set->delete_all("sshkeyname='".$ginfo['sshkeyname']."' and devicesid!=0 and $where");

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
			$sshkey->set_data('sshkeyname',$ginfo['sshkeyname']);
			$sshkey->set_data('devicesid',$lm[0]);
			$sshkey->set_data('memberid',$lm[1]);
			$this->sshkey_set->add($sshkey);
			unset($sshkey);
		}

		alert_and_back("操作成功",'admin.php?controller=admin_pro&action=sshkey_list&id='.$ginfo['id']);
	}

	function sshkey_synchronise(){
		$sql = "INSERT IGNORE INTO ".$this->sshkey_set->get_table_name()."(memberid,devicesid) SELECT memberid,devicesid FROM ".$this->luser_set->get_table_name()." l LEFT JOIN ".$this->devpass_set->get_table_name()." d ON l.devicesid=d.id WHERE d.publickey_auth=1 and (d.login_method=3 or d.login_method=7)";
		$this->sshkey_set->query($sql);
		alert_and_back('同步成功','admin.php?controller=admin_pro&action=sshkey');
	}

	function applogin() {
		$gid = get_request('id');
		$password = get_request('password',0,1);
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
		$password = get_request('password',0,1);
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
		$password = get_request('password',0,1);
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
			if($dev=$this->luser_set->select_all('memberid='.$_SESSION['ADMIN_UID'].' AND devicesid='.$devicesid)){
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
