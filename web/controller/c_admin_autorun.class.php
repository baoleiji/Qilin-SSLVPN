<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_autorun extends c_base {
	function autobackup_list() {
		$page_num = get_request('page');
		$ip = get_request('ip',0,1);
		$type = get_request('type',0,1);
		$from = get_request('from',0,1);
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

		$where ="1=1";
		if($ip){
			$where .= " AND device_ip='$ip'";
		}
		if($type=='run'){
			$row_num = $this->autorun_index_set->base_select("SELECT count(*) num FROM ".$this->autorun_index_set->get_table_name()." a LEFT JOIN ".$this->devpass_set->get_table_name()." d ON a.deviceid=d.id WHERE $where");
			$row_num = $row_num[0]['num'];
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$alldev = $this->autorun_index_set->base_select("SELECT d.device_ip,d.hostname,d.username,d.login_method,a.* FROM ".$this->autorun_index_set->get_table_name()." a LEFT JOIN ".$this->devpass_set->get_table_name()." d ON a.deviceid=d.id WHERE $where ORDER BY `$orderby1` $orderby2 Limit ".$newpager->intStartPosition.",". $newpager->intItemsPerPage );
			$this->assign("word", "巡检");
		}else{
			$row_num = $this->autobackup_index_set->base_select("SELECT count(*) num FROM ".$this->autobackup_index_set->get_table_name()." a LEFT JOIN ".$this->devpass_set->get_table_name()." d ON a.deviceid=d.id WHERE $where");
			$row_num = $row_num[0]['num'];
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$alldev = $this->autobackup_index_set->base_select("SELECT d.device_ip,d.hostname,d.username,d.login_method,a.* FROM ".$this->autobackup_index_set->get_table_name()." a LEFT JOIN ".$this->devpass_set->get_table_name()." d ON a.deviceid=d.id WHERE $where ORDER BY `$orderby1` $orderby2 Limit ".$newpager->intStartPosition.",". $newpager->intItemsPerPage );
			$this->assign("word", "备份");
		}
		$alldevgroup = $this->sgroup_set->select_all();
		$this->assign('title', language('备份列表'));
		$this->assign("alldev", $alldev);
		$this->assign("type", $type);
		$this->assign("from", $from);
		$this->assign("ip", $ip);
		$this->assign("alldevgroup", $alldevgroup);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('autobackup_list.tpl');
	}

	function autobackup_delete(){
		$type=get_request('type',0,1);
		$ip = get_request('ip',0,1);
		$from = get_request('from',0,1);
		if($type=='run'){
			if($_POST['chk_member']){
				$this->autorun_index_devices_set->delete_all('autorun_id in ('.implode(',',$_POST['chk_member']).')');
				$this->autorun_index_set->delete_all('id in ('.implode(',',$_POST['chk_member']).')');
			}
		}else{
			if($_POST['chk_member']){
				$this->autobackup_index_devices_set->delete_all('autobackup_id in ('.implode(',',$_POST['chk_member']).')');
				$this->autobackup_index_set->delete_all('id in ('.implode(',',$_POST['chk_member']).')');
			}
		}
		alert_and_back('操作成功',"admin.php?controller=admin_autorun&action=autobackup_list&type=$type&ip=$ip&from=$from");
	}

	function autobackup_dev() {
		$uid = get_request('uid');
		$g_id = get_request('g_id');
		$type = get_request('type', 0, 1);	
		
		$alldev = $this->server_set->select_all("groupid = $g_id");
		if(count($alldev) == 0) {
			alert_and_back('该设备组没有设备',"admin.php?controller=admin_autorun&action=autobackup_list&type=$type");
			exit(0);
		}
			
		$this->assign("type", $type);
		$this->assign('title',language('选择要绑定的设备'));
		$this->assign('id',$uid);
		$this->assign('g_id',$g_id);
		$this->assign('s_dev',$s_dev);
		$this->assign('alldev',$alldev);
		$this->assign('type', $type);
		$this->display('autobackup_dev.tpl');
	}

	function autobackup_edit() {
		$uid = get_request('uid');
		$ip = get_request('ip',0,1);
		$g_id = get_request('g_id');
		$type = get_request('type', 0, 1);
		if($ip == '') {
			$ip = get_request('ip',1,1);
		}
		if($type=='run'){
			$allpass = $this->devpass_set->select_all(" device_ip = '$ip' and id NOT IN(select deviceid from ".$this->autorun_index_set->get_table_name()." where deviceid is not null)",'username', 'ASC');		
		}else{
			$allpass = $this->devpass_set->select_all(" device_ip = '$ip' and id NOT IN(select deviceid from ".$this->autobackup_index_set->get_table_name()." where deviceid is not null)",'username', 'ASC');
		}
		$alltem = $this->tem_set->select_all();
		//echo '<pre>';print_r($allpass);echo '</pre>';
		$num = count($allpass);
		if($num == 0) {
			//alert_and_back('该设备还没有用户或IP输入错误',"admin.php?controller=admin_autorun&action=autobackup_dev&uid=$uid&g_id=$g_id&type=$type");
			//exit(0);
		}
		for($i=0; $i<count($allpass); $i++){
			for($j=0; $j<count($alltem); $j++){
				if($allpass[$i]['login_method']==$alltem[$j]['id']){
					$allpass[$i]['lmname']= $alltem[$j]['login_method'];
				}
			}
		}
		
		$this->assign('title',language('绑定托管用户'));
		$this->assign('ip',$ip);
		$this->assign('id',$uid);
		
		$this->assign('type', $type);
		$this->assign('allpass',$allpass);
		$this->display('autobackup_save.tpl');
	}

	function autobackup_save(){
		global $_CONFIG;
		$gid = get_request('id');
		$gname = get_request('gname',0,1);
		$hostname = get_request('hostname',0,1);
		$username = get_request('username',0,1);
		$lm = get_request('lm');
		$ip = get_request('ip', 0, 1);
		$type = get_request('type', 0, 1);
		$where = '1=1';
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

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$alltmpip = array(0);
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$where .= " AND s.groupid IN (".$_tmpgid['child'].")";
		}
		
		$allmethod =  $this->tem_set->select_all("device_type = ''",'','ASC');	
		//$res = $this->resgroup_set->select_all("groupname='$gname' and devicesid!=0");
		if($type=='run'){
			$this->autorun_index_devices_set->delete_all("autorun_id=0");
			$ginfo = $this->autorun_index_set->select_by_id($gid);
			$ginfo['id'] = intval($ginfo['id']);
			$resources = $this->devpass_set->base_select("SELECT d.*,l.login_method lmname,if(entrust_password=1,'托密','不托密') as ep FROM devices d LEFT JOIN (SELECT distinct devicesid FROM ".$this->autorun_index_devices_set->get_table_name()." WHERE autorun_id='".$ginfo['id']."' and devicesid!=0) t ON d.id=t.devicesid LEFT JOIN login_template l ON d.login_method=l.id LEFT JOIN (SELECT * FROM servers WHERE 1 ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).') or id IN('.$_ldapid1.','. $_ldapid2.'))' : '').")s ON d.device_ip=s.device_ip  WHERE $where AND (d.login_method=3 or d.login_method=5) AND t.devicesid IS NULL AND s.id IS NOT NULL "." ORDER BY device_ip");
		
			$res = $this->devpass_set->base_select("SELECT d.*,l.login_method lmname,if(entrust_password=1,'托密','不托密') as ep FROM devices d LEFT JOIN (SELECT distinct devicesid FROM ".$this->autorun_index_devices_set->get_table_name()." WHERE autorun_id='".$ginfo['id']."' and devicesid!=0) t ON d.id=t.devicesid LEFT JOIN login_template l ON d.login_method=l.id LEFT JOIN (SELECT * FROM servers WHERE 1 ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).') or id IN('.$_ldapid1.','. $_ldapid2.'))' : '').") s ON d.device_ip=s.device_ip  WHERE 1 AND (d.login_method=3 or d.login_method=5) AND t.devicesid IS NOT NULL AND s.id IS NOT NULL "." ORDER BY device_ip");
		}else{
			$this->autobackup_index_devices_set->delete_all("autobackup_id=0");
			$ginfo = $this->autobackup_index_set->select_by_id($gid);
			$ginfo['id'] = intval($ginfo['id']);
			$resources = $this->devpass_set->base_select("SELECT d.*,l.login_method lmname,if(entrust_password=1,'托密','不托密') as ep FROM devices d LEFT JOIN (SELECT distinct devicesid FROM ".$this->autobackup_index_devices_set->get_table_name()." WHERE autobackup_id='".$ginfo['id']."' and devicesid!=0) t ON d.id=t.devicesid LEFT JOIN login_template l ON d.login_method=l.id LEFT JOIN (SELECT * FROM servers WHERE 1 ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).') or id IN('.$_ldapid1.','. $_ldapid2.'))' : '').")s ON d.device_ip=s.device_ip  WHERE $where AND s.device_type=11 AND t.devicesid IS NULL AND s.id IS NOT NULL "." ORDER BY device_ip");
		
			$res = $this->devpass_set->base_select("SELECT d.*,l.login_method lmname,if(entrust_password=1,'托密','不托密') as ep FROM devices d LEFT JOIN (SELECT distinct devicesid FROM ".$this->autobackup_index_devices_set->get_table_name()." WHERE autobackup_id='".$ginfo['id']."' and devicesid!=0) t ON d.id=t.devicesid LEFT JOIN login_template l ON d.login_method=l.id LEFT JOIN (SELECT * FROM servers WHERE 1 ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND (groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).') or id IN('.$_ldapid1.','. $_ldapid2.'))' : '').") s ON d.device_ip=s.device_ip  WHERE 1 AND s.device_type=11 AND t.devicesid IS NOT NULL AND s.id IS NOT NULL "." ORDER BY device_ip");
		}
		
		$login_method = $this->tem_set->select_all();
		$where = "1";
		if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			if($_SESSION['ADMIN_MSERVERGROUP']){
				$where .= " AND (id IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")) ";
			}else{
				$where .= " AND 0";
			}
		}
		$allgroup = $this->sgroup_set->select_all($where,'groupname', 'asc');
		//echo '<pre>';print_r($resources);echo '</pre>';
		if($gname) $ginfo['groupname']=$gname;
		$this->assign("res", $res);
		$this->assign("resource", $resources);
		$this->assign("ginfo", $ginfo);
		$this->assign("groupid", intval($groupid));
		$this->assign("allgroup", $allgroup);
		$this->assign("allmethod", $allmethod);
		$this->assign("ip", $ip);
		$this->assign("hostname", $hostname);
		$this->assign("username", $username);
		$this->assign("lm", $lm);
		$this->assign("gname", $gname);
		$this->assign("_config", $_CONFIG);
		$this->display('autobackup_save2.tpl');
	}

	function autobackup_dosave(){
		$type = get_request('type', 0, 1);
		$gid = get_request("id",1,0);
		$selected = get_request('secend', 1, 1);
		$groupid = get_request('groupid', 1, 1);
		$where = "1=1";
		
		if(empty($selected)){
			$selected[]=0;
		}
		if($type!='run'){
			$this->autobackup_index_devices_set->delete_all("autobackup_id='".$gid."'");
			for($i=0; $i<count($selected); $i++){
				if(empty($selected[$i])){
					continue;
				}			
				$resourcegroup = new autobackup_index_devices();
				$resourcegroup->set_data('autobackup_id',$gid);
				$resourcegroup->set_data('devicesid',$selected[$i]);
				$this->autobackup_index_devices_set->add($resourcegroup);
				unset($resourcegroup);
			}
		}else{
			$this->autorun_index_devices_set->delete_all("autorun_id='".$gid."'");
			for($i=0; $i<count($selected); $i++){
				if(empty($selected[$i])){
					continue;
				}			
				$resourcegroup = new autorun_index_devices();
				$resourcegroup->set_data('autorun_id',$gid);
				$resourcegroup->set_data('devicesid',$selected[$i]);
				$this->autorun_index_devices_set->add($resourcegroup);
				unset($resourcegroup);
			}


		}
		alert_and_back("操作成功",'admin.php?controller=admin_autorun&action=autotemplate&type='.$type);
	}


	function autobackup_save_backup() {
		global $_CONFIG;
		$devicesid = get_request('devicesid');
		$id = get_request('id');
		$ip = get_request('ip',0,1);
		$type = get_request('type', 0, 1);
		$ip = get_request('ip',0,1);
		$from = get_request('from',0,1);

		$allservers = $this->server_set->select_all("1".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? (empty($_SESSION['ADMIN_MSERVERGROUP']) ? ' 0' : " AND servers.groupid>0 or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") ") : ''));

		$alldevices = $this->devpass_set->base_select("SELECT d.*,l.login_method lmname,if(entrust_password=1,'托密','不托密') as ep FROM devices d LEFT JOIN login_template l ON d.login_method=l.id  WHERE 1 ".($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? (empty($_SESSION['ADMIN_MSERVERGROUP']) ? ' AND 0' : "").' AND device_ip IN(SELECT device_ip FROM servers WHERE groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).'))' : '')." ORDER BY device_ip");

				
		$devpass = $this->devpass_set->select_by_id($devicesid);
		$method = $this->tem_set->select_by_id($devpass['login_method']);
		if($type=='run'){
			$auto = $this->autorun_index_set->select_by_id($id);
		}else{
			$auto = $this->autobackup_index_set->select_by_id($id);
		}
		if($ip&&$from=='status'){
			$devpass['device_ip'] = $ip;
		}
		if($devpass['device_ip']){
			$serverip = $this->server_set->select_all("device_ip='".$devpass['device_ip']."'");
			$_GET['groupid'] = $serverip[0]['groupid'];
			require_once('./include/select_sgroup_ajax.inc.php');
			$sgroup = $this->sgroup_set->select_by_id($serverip[0]['groupid']);
			$this->assign('sgroup',$sgroup);
			$this->assign('serverip',$serverip[0]);
		}else{
			require_once('./include/select_sgroup_ajax.inc.php');
		}

		$templates = $this->autotemplate_set->select_all();
		$this->assign('templates',$templates);
		$this->assign('allsgroup',$allsgroup);
		$this->assign('allserver',$allservers);
		$this->assign('alldevices',$alldevices);
		$devpass['lm']=$method['login_method'];
		$this->assign("devpass", $devpass);
		$this->assign("auto", $auto);
		$this->assign('type', $type);
		$this->assign("id", $id);
		$this->assign("ip", $ip);
		$this->assign("from", $from);
		$this->display('autobackup_save.tpl');
	}



	function autobackup_dosave_backup() {
		global $_CONFIG;
		$id = get_request('id');
		$deviceid = get_request('deviceid', 1, 0);
		$period = get_request('period', 1, 0);
		$su = get_request('su', 1, 0);
		$scriptpath = get_request('scriptpath', 1, 1);
		$localpath = get_request('localpath', 1, 1);
		$name = get_request('name', 1, 1);
		$desc = get_request('desc', 1, 1);
		$type = get_request('type', 0, 1);
		$running = get_request('running', 1, 1);
		$startup = get_request('startup', 1, 1);
		$ip = get_request('ip',0,1);
		$from = get_request('from',0,1);
		if($running=='on'){
			$running = 1;
		}
		if($startup=='on'){
			$startup = 1;
		}
		$devpass = $this->devpass_set->select_by_id($deviceid);
		if(empty($name)){
			alert_and_back('请输入名称');
			exit;
		}
		if($type=='run'){
			$filedir = $_CONFIG['AUTORUNDIR'];
			$autobackup = new autobackup_index();
			if($this->autorun_index_set->select_count("name='$name' and id!='$id'")>0){
				alert_and_back('名称已经存在');
				exit;
			}
		}else{
			$filedir = $_CONFIG['AUTOBACKUPDIR'];
			
			$autobackup = new autorun_index();
			if($this->autobackup_index_set->select_count("name='$name' and id!='$id'")>0){
				alert_and_back('名称已经存在');
				exit;
			}
		}
		$autobackup->set_data("deviceid", $deviceid);
		$autobackup->set_data("name", $name);
		$autobackup->set_data("desc", $desc);
		$autobackup->set_data("su", $su);
		$autobackup->set_data("lastruntime", date('Y-m-d H:i:s'));
		if($id){
			$autobackup->set_data("id", $id);
			
			if($type=='run'){
				$autobackup->set_data("period", $period);
				$autobackup->set_data("localpath", $localpath);
				$autobackup->set_data("scriptpath", $scriptpath);
				$this->autorun_index_set->edit($autobackup);
			}else{
				$autobackup->set_data("startup", $startup);
				$autobackup->set_data("running", $running);
				$autobackup->set_data("interval", $period);
				$autobackup->set_data("scriptpath", $scriptpath);
				$this->autobackup_index_set->edit($autobackup);
			}
		}else{
			
			if($type=='run'){
				if(empty($scriptpath)){
					alert_and_back('请选择脚本');
					exit;
				}				
				$autobackup->set_data("period", $period);
				$autobackup->set_data("localpath", $localpath);
				$autobackup->set_data("scriptpath", $scriptpath);
				$this->autorun_index_set->add($autobackup);
			}else{
				$autobackup->set_data("startup", $startup);
				$autobackup->set_data("running", $running);
				$autobackup->set_data("interval", $period);
				$autobackup->set_data("scriptpath", $scriptpath);
				$this->autobackup_index_set->add($autobackup);
			}
		}
		
		alert_and_back('操作成功',"admin.php?controller=admin_autorun&action=autobackup_list&type=$type&ip=$ip&from=$from");
	}


	function autotemplate() {
		$page_num = get_request('page');
		$ip = get_request('ip',0,1);
		$type = get_request('type',0,1);
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

		$where ="1=1";
		$total_page = $this->autorun_index_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$alldev = $this->autorun_index_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);


		$this->assign('title', language('备份列表'));
		$this->assign("alldev", $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('autotemplate.tpl');
	}

	function viewfile() {
		header("Content-Type:text/html;charset=GB2312");
		$sid = get_request('id');
		$type = get_request('type',0,1);
		$start_page=$_GET["start_page"];
		if(!defined($sid))
		{
			$sid=$_GET["sid"];
		}
		if($type=='run'){
			$auto = $this->autorun_index_set->select_by_id($sid);
		}else{
			$auto = $this->autobackup_index_set->select_by_id($sid);
		}
		$logfile = $auto['scriptpath'];
		$tarname=substr($sessions['lastruntime'],0,7).".tar.gz";
		if(!$sessions) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			//die();
		}
		if($logfile == NULL) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			die('no logfile');

		}
		if(!file_exists($logfile)) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			die('file not exists');
		}
		$next_page=$start_page+500;
		$pre_page=$start_page-500;
		if(empty($start_page)){
			$start_page = 1;
			$pre_page = 1;
		}
		$buffer_array=array();
		$total_line=array();
		$buffer_array = getFileLines($logfile, $start_page, $next_page-1) ;
		//$tmp1 = exec("sed -n '$start_page,$next_page p' $logfile",$buffer_array,$return);
		//$tmp2 = exec("cat $logfile | wc -l",$total_line,$return);
		//print "<font color=red size=4px>Replay file run: display -s  $replayfile</font><br>";
		//print "<font color=blue size=4px>From line $start_page To line $next_page &nbsp &nbsp Totally $total_line[0] lines<br>Logfilename: $logfile</font><br><br>";
		if($start_page>500)
		{
			print "<a href=\"admin.php?controller=admin_autorun&action=viewfile&type=$type&sid=$sid&start_page=$pre_page\">pre page<br></a>";
		}

		if(count($buffer_array)==500)
		{
			print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_autorun&action=viewfile&type=$type&sid=$sid&start_page=$next_page\">next page</a><br>";
		}
		
		foreach($buffer_array as $tmp)
		{
			echo $tmp." <br>";
		}
	}

	function autotemplate_del(){
		$id=get_request('id',0,1);
		if($id){
			$template = $this->autorun_index_set->select_by_id($id);
			if($this->autorun_index_devices_set->select_count("autorun_id='$id'")>0){
				alert_and_back('已被绑定，请先删除绑定');
				exit;
			}
			if(file_exists($template['scriptpath'])){
				@unlink($template['scriptpath']);
			}
			$this->autotempate_autorun_set->delete_all("autotemplate_id='".$id."'");
			$this->autotemplate_set->delete($id);
		}elseif(empty($id)){
			if($_POST['chk_member']){
				$template = $this->autorun_index_set->select_all('id in ('.implode(',',$_POST['chk_member']).')');
				for($i=0; $i<count($template); $i++){
					if($this->autorun_index_devices_set->select_count("autorun_id='$id'")>0){
						alert_and_back($template[$i]['scriptpath'].' 已被绑定，请先删除绑定');
						exit;
					}
					if(file_exists($template[$i]['scriptpath'])){
						@unlink($template[$i]['scriptpath']);
					}
				}
				$this->autorun_index_set->delete_all('id in ('.implode(',',$_POST['chk_member']).')');
			}
			
		}
		alert_and_back('操作成功',"admin.php?controller=admin_autorun&action=autotemplate");
	}

	function autotemplate_edit() {
		$id = get_request('id');
		$auto = $this->autorun_index_set->select_by_id($id);
		$_binded = $this->autorun_index_devices_set->select_all("autorun_id='".$id."'");
		for($i=0; $i<count($_binded); $i++){
			$binded[] = $_binded[$i]['autorun_id'];
		}

		$autobackup = $this->autorun_index_set->select_all('1', 'name', 'asc');
		for($i=0; $i<count($autobackup); $i++){
			if($binded&&in_array($autobackup[$i]['id'], $binded)){
				$autobackup[$i]['check']='checked';
			}
		}
		$this->assign('title',language('巡检模板'));
		$this->assign('id',$id);
		$this->assign('auto',$auto);
		$this->assign('autobackup',$autobackup);
		$this->display('autotemplate_edit.tpl');
	}

	function autotemplate_save() {
		global $_CONFIG;
		$id = get_request('id');
		$scriptpath = get_request('scriptpath', 1, 1);
		$name = get_request('name', 1, 1);
		$period = get_request('period', 1, 1);
		$desc = get_request('desc', 1, 1);
		if(empty($name)){
			alert_and_back('请输入名称');
			exit;
		}
		$filedir = $_CONFIG['AUTOTEMPLATEDIR'];
		$autotemplate = new autorun_index();
		if($this->autorun_index_set->select_count("name='$name' and id!='$id'")>0){
			alert_and_back('名称已经存在');
			exit;
		}
		$autotemplate->set_data("desc", $desc);
		$autotemplate->set_data("name", $name);
		$autotemplate->set_data("period", $period);
		if($id){
			$autotemplate->set_data("id", $id);
			$filename = $filedir."/".$_FILES['scriptpath']['name'];
			
			if(is_uploaded_file($_FILES['scriptpath']['tmp_name'])){				
				if(file_exists($filename)){
					alert_and_back('脚本已经存在，请先删除');
					exit;
				}elseif(!move_uploaded_file($_FILES['scriptpath']['tmp_name'], $filename)){
					alert_and_back('上传脚本失败');
					exit;
				}				
				$autotemplate->set_data("scriptpath", $filename);
			}
			$this->autorun_index_set->edit($autotemplate);
			
		}else{
			if(!is_uploaded_file($_FILES['scriptpath']['tmp_name'])){
				alert_and_back('请上传脚本');
				exit;
			}
			$filename = $filedir."/".$_FILES['scriptpath']['name'];
			$autotemplate->set_data("scriptpath", $filename);
			$this->autorun_index_set->add($autotemplate);
			$id = mysql_insert_id();
			if(file_exists($filename)){
				alert_and_back('脚本已经存在，请先删除');
				exit;
			}elseif(!move_uploaded_file($_FILES['scriptpath']['tmp_name'], $filename)){
				alert_and_back('上传脚本失败');
				exit;
			}
			
		}
		
		alert_and_back('操作成功',"admin.php?controller=admin_autorun&action=autotemplate");
	}

	function viewtemplate() {
		header("Content-Type:text/html;charset=GB2312");
		$id = get_request('id');
		$start_page=$_GET["start_page"];
		
		$sessions = $this->autorun_index_set->select_by_id($id);
		$logfile = $sessions['scriptpath'];

		if($logfile == NULL) {
			die();
		}
		if(!file_exists($logfile)) {
			die();
		}
		echo  (file_get_contents($logfile));
		
	}


	function detail_config() {
		$page_num = get_request('page');
		$ip = get_request('ip',0,1);
		$type = get_request('type',0,1);
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

		$where ="1=1";
		$total_page = $this->detail_config_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$alldev = $this->detail_config_set->base_select("SELECT a.*,b.name FROM ".$this->detail_config_set->get_table_name()." a LEFT JOIN ".$this->autorun_index_set->get_table_name()." b ON a.autorun_index_id=b.id ORDER BY b.name ASC LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		//$alldev = $this->detail_config_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);
		

		$this->assign('title', language('备份列表'));
		$this->assign("alldev", $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('detail_config.tpl');
	}

	function detail_config_del(){
		$id=get_request('id',0,1);
		if($id){
			$this->detail_config_set->delete($id);
		}elseif(empty($id)){
			if($_POST['chk_member']){
				$this->detail_config_set->delete_all('id in ('.implode(',',$_POST['chk_member']).')');
			}
			
		}
		alert_and_back('操作成功',"admin.php?controller=admin_autorun&action=detail_config");
	}

	function detail_config_edit() {
		$id = get_request('id');
		$auto = $this->detail_config_set->select_by_id($id);
		$autobackup = $this->autorun_index_set->select_all('1', 'name', 'asc');
		$this->assign('title',language('巡检模板'));
		$this->assign('id',$id);
		$this->assign('auto',$auto);
		$this->assign('autobackup',$autobackup);
		$this->display('detail_config_edit.tpl');
	}

	function detail_config_save() {
		global $_CONFIG;
		$id = get_request('id');
		$autorun_index_id = get_request('autorun_index_id', 1, 0);
		$action = get_request('action', 1, 1);
		$line_number = get_request('line_number', 1, 1);
		$regex = get_request('regex', 1, 1);
		$low_value = get_request('low_value', 1, 0);
		$high_value = get_request('high_value', 1, 0);

		$detail_config = new detail_config();

		$detail_config->set_data("autorun_index_id", $autorun_index_id);
		$detail_config->set_data("action", $action);
		$detail_config->set_data("line_number", $line_number);
		$detail_config->set_data("regex", $regex);
		$detail_config->set_data("low_value", $low_value);
		$detail_config->set_data("high_value", $high_value);
		if($id){
			$detail_config->set_data("id", $id);
			$this->detail_config_set->edit($detail_config);
			
		}else{
			$this->detail_config_set->add($detail_config);
			$id = mysql_insert_id();
		}
		alert_and_back('操作成功',"admin.php?controller=admin_autorun&action=detail_config");
	}

	function autorun_result() {
		global $_CONFIG;
		$page_num = get_request('page');
		$ip = get_request('ip',0,1);
		$type = get_request('type',0,1);
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
		
		$where = 'b.id is not null and s.id is not null';
		if($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				$alltmpip = array(0);
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
				for($i=0; $i<count($allips); $i++){
					$alltmpip[]=$allips[$i]['device_ip'];
				}
				if($alltmpip)
				$where .= "  AND b.device_ip IN ('".implode("','", $alltmpip)."')";
			}
		}

		$total_page = $this->detail_config_set->base_select( "SELECT COUNT(*) ct FROM ".$this->autorun_index_set->get_table_name()." a LEFT JOIN ".$this->autorun_index_devices_set->get_table_name()." aa ON a.id=aa.autorun_id LEFT JOIN ".$this->devpass_set->get_table_name()." b ON aa.devicesid=b.id LEFT JOIN ".$this->server_set->get_table_name()." s ON b.device_ip=s.device_ip WHERE $where");
		$total_page = $total_page[0]['ct'];
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$alldev = $this->detail_config_set->base_select("SELECT b.device_ip,s.hostname,b.username,a.name,a.scriptpath,a.id,b.id deviceid FROM ".$this->autorun_index_set->get_table_name()." a LEFT JOIN ".$this->autorun_index_devices_set->get_table_name()." aa ON a.id=aa.autorun_id LEFT JOIN ".$this->devpass_set->get_table_name()." b ON aa.devicesid=b.id LEFT JOIN ".$this->server_set->get_table_name()." s ON b.device_ip=s.device_ip WHERE $where ORDER BY b.device_ip ASC,b.username ASC,a.name ASC LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		//$alldev = $this->detail_config_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);
		

		$this->assign('title', language('备份列表'));
		$this->assign("alldev", $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('autorun_result.tpl');
	}

	function auto_result() {
		$page_num = get_request('page');
		$device_id = get_request('device_id');
		$autorun_index_id = get_request('autorun_index_id');
		$autotemplate_id = get_request('autotemplate_id');
		$ip = get_request('ip',0,1);
		$type = get_request('type',0,1);
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

		$where =" device_id=$device_id and autorun_index_id=$autorun_index_id ";
		if($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				$alltmpip = array(0);
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
				for($i=0; $i<count($allips); $i++){
					$alltmpip[]=$allips[$i]['device_ip'];
				}
				if($alltmpip)
				$where .= "  AND b.device_ip IN ('".implode("','", $alltmpip)."')";
			}
		}
		$total_page = $this->autorun_result_set->select_count( "SELECT COUNT(*) ct FROM ".$this->autorun_result_set->get_table_name()." a LEFT JOIN ".$this->devpass_set->get_table_name()." b ON a.device_id=b.id LEFT JOIN ".$this->autorun_index_set->get_table_name()." aa ON a.autorun_index_id=aa.id LEFT JOIN ".$this->server_set->get_table_name()." s ON b.device_ip=s.device_ip WHERE $where");
		$total_page = $total_page[0]['ct'];
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$alldev = $this->detail_config_set->base_select("SELECT b.device_ip,s.hostname,b.username,a.id,a.device_id,a.datetime,a.result,aa.name,aa.scriptpath FROM ".$this->autorun_result_set->get_table_name()." a LEFT JOIN ".$this->devpass_set->get_table_name()." b ON a.device_id=b.id LEFT JOIN ".$this->autorun_index_set->get_table_name()." aa ON a.autorun_index_id=aa.id LEFT JOIN ".$this->server_set->get_table_name()." s ON b.device_ip=s.device_ip WHERE $where ORDER BY b.device_ip ASC LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		//$alldev = $this->autorun_result_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);

		$this->assign('title', language('备份列表'));
		$this->assign("alldev", $alldev);
		$this->assign("autotemplate", $autotemplate);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('autorun_index_id', $autorun_index_id);
		$this->display('autoresult.tpl');
	}

	function auto_result_detail() {
		$page_num = get_request('page');
		$id = get_request('id');
		$device_id = get_request('device_id');
		$autorun_index_id = get_request('autorun_index_id');
		$autotemplate_id = get_request('autotemplate_id');
		$ip = get_request('ip',0,1);
		$type = get_request('type',0,1);
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

		$where =" autorun_result_id=$id ";
		$total_page = $this->autorun_result_detail_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$alldev = $this->detail_config_set->base_select("SELECT a.* FROM ".$this->autorun_result_detail_set->get_table_name()." a WHERE $where ORDER BY a.datetime DESC LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		//$alldev = $this->autorun_result_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where,$orderby,$orderby2);
		$autotemplate = $this->autotemplate_set->select_by_id($autotemplate_id);
		$device = $this->devpass_set->select_by_id($device_id);
		$server = $this->server_set->select_all("device_ip='".$device['device_ip']."'");
		$server = $server[0];

		$this->assign('title', language('备份列表'));
		$this->assign("alldev", $alldev);
		$this->assign("autotemplate", $autotemplate);
		$this->assign("device", $device);
		$this->assign("server", $server);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("autorun_index_id", $autorun_index_id);
		$this->display('autoresult_detail.tpl');
	}

	function auto_result_file() {
		header("Content-Type:text/html;charset=GB2312");
		$sid = get_request('id');
		$type = get_request('type',0,1);
		$start_page=$_GET["start_page"];
		$auto = $this->autorun_result_set->select_by_id($sid);
		$logfile = $auto['output_file'];

		$tarname=substr($sessions['lastruntime'],0,7).".tar.gz";
		if(!$sessions) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			//die();
		}
		if($logfile == NULL) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			die('no logfile');

		}
		if(!file_exists($logfile)) {
			//echo("log file backuped,please look up for it in the backup tar package<br>
			//logfile name:$logfile<br>
			//backup tar package:$tarname<br>");
			die('file not exists');
		}
		$next_page=$start_page+500;
		$pre_page=$start_page-500;
		if(empty($start_page)){
			$start_page = 1;
			$pre_page = 1;
		}
		$buffer_array=array();
		$total_line=array();
		$buffer_array = getFileLines($logfile, $start_page, $next_page-1) ;
		//$tmp1 = exec("sed -n '$start_page,$next_page p' $logfile",$buffer_array,$return);
		//$tmp2 = exec("cat $logfile | wc -l",$total_line,$return);
		//print "<font color=red size=4px>Replay file run: display -s  $replayfile</font><br>";
		//print "<font color=blue size=4px>From line $start_page To line $next_page &nbsp &nbsp Totally $total_line[0] lines<br>Logfilename: $logfile</font><br><br>";
		if($start_page>500)
		{
			print "<a href=\"admin.php?controller=admin_autorun&action=auto_result_file&type=$type&id=$sid&start_page=$pre_page\">pre page<br></a>";
		}

		if(count($buffer_array)==500)
		{
			print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_autorun&action=auto_result_file&type=$type&id=$sid&start_page=$next_page\">next page</a><br>";
		}
		
		foreach($buffer_array as $tmp)
		{
			echo $tmp." <br>";
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
