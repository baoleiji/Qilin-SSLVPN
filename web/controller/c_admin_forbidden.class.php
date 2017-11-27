<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_forbidden extends c_base {
	
	function dangerlist() {
		$page_num = get_request('page');

		$row_num = $this->dangercmd_set->select_count("1 = 1");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->dangercmd_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);

		$this->assign("allcommand",$allcommand);

		$this->display("dangercmd_list.tpl");
	}

	function forbidden_groups_list($interface=false) {
		$page_num = get_request('page');
		$add = get_request('add', 1,1);
		$gname = get_request('gname', 1,1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'gname';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = "1=1";
		if($_SESSION['ADMIN_LEVEL']!=1){
			$where .= " AND creatorid=".$_SESSION['ADMIN_UID'];
		}
		if($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			$where .= ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))';
		}
		
		$row_num = $this->forbiddengps_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->forbiddengps_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		if($interface){
			return $allcommand;
		}
		$this->assign("allcommand",$allcommand);

		$this->display("forbiddengps_list.tpl");
	}
	
	function forbiddengps_edit(){
		$id=get_request('id');
		$forbiddengps = $this->forbiddengps_set->select_by_id($id);
		$this->assign("forbiddengps", $forbiddengps);
		$this->display("addforbiddengroup.tpl");
	}

	function forbiddengps_save($interface=false){
		$id = get_request('id');
		$add = get_request('add', 1,1);
		$desc = get_request('description', 1,1);
		$gname = get_request('gname', 1,1);
		$black_or_white = get_request('black_or_white', 1,1);
		if($add == 'new'){
			if(empty($gname)){
				alert_and_back('请输入名称');
				return;	
			}
			if(!preg_match('/^[0-9_a-zA-Z]+$/',$gname)){
				alert_and_back('组名应为数字下划线和字母的组合');
				return;	
			}
			$a = $this->forbiddengps_set->select_all("gname='".$gname."' and gid!=$id");
			if(!empty($a[0])){
				alert_and_back('名称已经存在');
				return;
			}
			$forbiddengps = new forbiddengps();
			$forbiddengps->set_data('black_or_white', $black_or_white);
			$forbiddengps->set_data('desc', $desc);
			$forbiddengps->set_data('creatorid', $_SESSION['ADMIN_UID']);
			if($interface){
				$resourcegroup->set_data('interface',1);
			}
			if($id){
				$forbiddengps->set_data('gid', $id);
				$this->forbiddengps_set->edit($forbiddengps);
			}else{
				$forbiddengps->set_data('gname', $gname);
				$this->forbiddengps_set->add($forbiddengps);
			}
			

			alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=forbidden_groups_list');
			return;
		}
	}


	function forbiddengps_cmd($interface=false) {
		$page_num = get_request('page');
		$gid = get_request('gid');
		$ginfo = $this->forbiddengps_set->select_by_id($gid);
		$add = get_request('add', 1,1);
		$cmd = get_request('cmd', 0,1);
		$level = get_request('level', 1,1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'cmd';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$where = '1';

		if($cmd){
			$where .= " cmd like '%$cmd%'";
		}

		$row_num = $this->forbiddengpscommand_set->select_count("1 = 1 AND gid='".$ginfo['gname']."'".' and '.$where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("gid", $gid);
		$this->assign("ginfo", $ginfo);
		
		$allcommand =  $this->forbiddengpscommand_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"1 = 1 AND gid='".$ginfo['gname']."'".' and '.$where, $orderby1, $orderby2);
		if($interface){
			return $allcommand;
		}
		$this->assign("allcommand",$allcommand);

		$this->display("forbiddengps_cmd.tpl");
	}

	function forbiddengps_cmd_edit(){
		$gid = get_request('gid');
		$cid = get_request('cid');
		$cmdinfo = $this->forbiddengpscommand_set->select_by_id($cid);
		$ginfo = $this->forbiddengps_set->select_by_id($gid);
		$this->assign("gid", $gid);
		$this->assign("ginfo", $ginfo);
		$this->assign("cmdinfo", $cmdinfo);
		$this->assign("regex", (strpos($cmdinfo['cmd'],'\S*\s+')===false ? 0 : 1));
		$this->display("addforbiddengroup_command.tpl");
	}

	function forbiddengps_cmd_save(){
		$add = get_request('add', 1,1);
		$level = get_request('level', 1,1);
		$gid = get_request('gid', 1,1);
		$cmd = get_request('cmd', 1,1);		
		$toauthorize = get_request('toauthorize', 1,0);		
		$cid  =  get_request('cid');
		$ginfo = $this->forbiddengps_set->select_by_id($gid);
		if($add == 'new'){
			if($cmd==""&&$_POST['cmd_0']==""){
				alert_and_back('命令不能为空');
				return;
			}			
			if($cid){
				$forbiddengpscommand = new forbiddengpscommand();
				$forbiddengpscommand->set_data('cmd', $cmd);
				$forbiddengpscommand->set_data('level', $level);
				$forbiddengpscommand->set_data('gid', $ginfo['gname']);
				$forbiddengpscommand->set_data('cid', $cid);
				$forbiddengpscommand->set_data('toauthorize', $toauthorize);
				$this->forbiddengpscommand_set->edit($forbiddengpscommand);
			}else{
				for($i=0; $i<10; $i++){
					if(empty($_POST['cmd_'.$i])) continue;
					$_POST['cmd_'.$i]=trim($_POST['cmd_'.$i]);
					if($_POST['regex_'.$i]=='on'){
						//$_POST['cmd_'.$i]=str_replace(' ','\S*\s+',$_POST['cmd_'.$i]).'\S*';
					}
					$forbiddengpscommand = new forbiddengpscommand();
					$forbiddengpscommand->set_data('cmd', daddslashes($_POST['cmd_'.$i]));
					$forbiddengpscommand->set_data('level', $_POST['level_'.$i]);
					$forbiddengpscommand->set_data('gid', $ginfo['gname']);
					$forbiddengpscommand->set_data('toauthorize', $_POST['toauthorize_'.$i]);
					$this->forbiddengpscommand_set->add($forbiddengpscommand);
				}
			}
			alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=forbiddengps_cmd&gid='.$gid);			
		}
	}

	function forbiddengps_cmd_export($where='1=1'){
		global $_CONFIG;
		set_time_limit(0);		
		$gid = get_request('gid');
		$ginfo = $this->forbiddengps_set->select_by_id($gid);
		if(strpos($where, "d.device_ip")===false)
		$where = str_replace("device_ip", "d.device_ip", $where);
		$alldev = $this->forbiddengpscommand_set->select_all("1 = 1 AND gid='".$ginfo['gname']."'".' and '.$where);
		$str = language("命令").",".language("级别").",".language("组名")."\n";
		
		$id=1;
		if($alldev){
			foreach ($alldev AS $report){
				switch($report['level']){
					case '1':
						$report['level']='断开连接';
						break;
					case '2':
						$report['level']='命令监控';
						break;
					case '3':
						$report['level']='命令授权';
						break;
					default:
						$report['level']='命令阻断';
						break;
				}
				$str .= $report['cmd'].",".$report['level'].",".$report['gid'];
				$str .= "\n";
			}
		}
		$str = iconv("UTF-8", "GBK", $str);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=audit-forbiddengps-cmd-".date('Ymd').".csv"); 
		echo $str;
		return;
	}

	function forbiddengps_cmd_import(){
		$gid = get_request('gid');
		$this->assign("gid", $gid);
		$this->display('forbiddengps_cmd_import.tpl');
	}

	function forbiddengps_cmd_doimport(){
		global $_CONFIG;
		$gid = get_request('gid');
		set_time_limit(0);
		setlocale(LC_ALL, 'zh_CN');
		if($_FILES['devfile']['error']==1 or $_FILES['devfile']['error']==2){
			alert_and_back("上传得文件超过系统限制");
			return;
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
		$_ldap = (iconv("GBK", "UTF-8", trim($lines[0][0]))!='命令' || iconv("GBK", "UTF-8", trim($lines[0][1]))!='级别' || iconv("GBK", "UTF-8", trim($lines[0][2]))!='组名');
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
			$importlog->set_data('type', 'forbiddengps_cmd');
			$this->importlog_set->add($importlog);
		}else{
			//echo '<script>导入文件备份失败，请联系管理员</script>';
		}
		$ginfo = $this->forbiddengps_set->select_by_id($gid);
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
			$cmd=trim($linearr[$index_i++]);
			$level=trim($linearr[$index_i++]);
			switch($level){
				case '断开连接':
					$_level=1;
					break;
				case '命令监控':
					$_level=2;
					break;
				case '命令授权':
					$_level=3;
					break;
				case '命令阻断':
					$_level=0;
					break;
				default:
					$error[]=$cmd.':命令级别"'.$level.'"不正确\n';
					continue;
					break;
			}
			$gname=trim($linearr[$index_i++]);
			if(preg_match("/[\\r\\n]/", $hostname)||preg_match("/[\\r\\n]/", $device_ip)||preg_match("/[\\r\\n]/", $groupname)||preg_match("/[\\r\\n]/", $device_type)||preg_match("/[\\r\\n]/", $username)||preg_match("/[\\r\\n]/", $login_method)||preg_match("/[\\r\\n]/", $current_password)||preg_match("/[\\r\\n]/", $port)||preg_match("/[\\r\\n]/", $limit_time)||preg_match("/[\\r\\n]/", $auto)||preg_match("/[\\r\\n]/", $master_user)||preg_match("/[\\r\\n]/", $entrust_password)||preg_match("/[\\r\\n]/", $radiususer)){
				$error[]=$username.':'.'用户信息中含有回车符';
				continue;
			}
			$insertdevices = "INSERT INTO ".$this->forbiddengpscommand_set->get_table_name()."(cmd,level,gid) values";
			$insertdeviceslen=strlen($insertdevices);
			$devpass = $this->forbiddengpscommand_set->select_all("cmd = '".$cmd."' and gid='".$gname."'");
			if(empty($devpass)){
				$insertdevices.="('".$cmd."','".$_level."','".$gname."'),";
			}else{
				$new_pass = new forbiddengpscommand();
				$new_pass->set_data('cid',$devpass[0]['cid']);
				$new_pass->set_data('cmd',$cmd);
				$new_pass->set_data('gid',$gname);
				$this->forbiddengpscommand_set->edit($new_pass);
			}
			if(strlen($insertdevices)>$insertdeviceslen){
				//echo substr($insertservers,0,strlen($insertservers)-1);
				$this->server_set->query(substr($insertdevices,0,strlen($insertdevices)-1));
			}
		}
		if($error){
			$msg = '\n添加失败的用户:\n'.implode('\n',$error).'\n';
			alert_and_back($msg, "admin.php?controller=admin_forbidden&action=forbiddengps_cmd&gid=".$gid);
		}else{
			alert_and_back('导入成功', "admin.php?controller=admin_forbidden&action=forbiddengps_cmd&gid=".$gid);
		}
		
	}

	function forbiddengps_user() {
		$page_num = get_request('page');
		$gid = get_request('gid');
		$ginfo = $this->forbiddengps_set->select_by_id($gid);
		
		$add = get_request('add', 1,1);
		$cmd = get_request('cmd', 1,1);
		$level = get_request('level', 1,1);
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
		
		$row_num = $this->luser_set->base_select("SELECT count(*) ct FROM (select forbidden_commands_groups,weektime,devicesid,memberid from luser WHERE forbidden_commands_groups='".$ginfo['gname']."' union select forbidden_commands_groups,weektime, c.devicesid,memberid from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid!=0) c on a.resourceid=c.id WHERE a.forbidden_commands_groups='".$ginfo['gname']."') l LEFT JOIN member u ON l.memberid=u.uid LEFT JOIN devices d ON l.devicesid=d.id");
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("gid", $gid);

		
		
		$allcommand =  $this->luser_set->base_select("SELECT l.*,u.username,d.device_ip,d.hostname,d.device_ip,d.username sysuser FROM (select forbidden_commands_groups,weektime,devicesid,memberid from luser WHERE forbidden_commands_groups='".$ginfo['gname']."' union select forbidden_commands_groups,weektime, c.devicesid,memberid from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid!=0) c on a.resourceid=c.id WHERE a.forbidden_commands_groups='".$ginfo['gname']."') l LEFT JOIN member u ON l.memberid=u.uid LEFT JOIN devices d ON l.devicesid=d.id  ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");

		$this->assign("allcommand",$allcommand);

		$this->display("forbiddengps_user.tpl");
	}
	
	function forbiddengps_group() {
		$page_num = get_request('page');
		$gid = get_request('gid');
		$ginfo = $this->forbiddengps_set->select_by_id($gid);
		
		$add = get_request('add', 1,1);
		$cmd = get_request('cmd', 1,1);
		$level = get_request('level', 1,1);
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
		
		$row_num = $this->lgroup_set->select_count("forbidden_commands_groups='".$ginfo['gname']."'");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("gid", $gid);
		
		$allcommand =  $this->lgroup_set->base_select("SELECT l.*,u.GroupName,d.device_ip FROM lgroup l LEFT JOIN servergroup u ON l.groupid=u.id LEFT JOIN devices d ON l.devicesid=d.id WHERE l.forbidden_commands_groups='".$ginfo['gname']."' ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");

		$this->assign("allcommand",$allcommand);

		$this->display("forbiddengps_group.tpl");
	}
	
	function protect_group() {
		$uid = get_request('uid');
		$f_gid = get_request("f_gid");
		$weektime = get_request('weektime',0,1);
		$member = $this->member_set->select_by_id($uid);
		$alldevgroup = $this->sgroup_set->select_all('1=1', 'groupname', 'asc');
		$allpass = $this->forbiddengpsuser_set->select_all(" radius_user='".$member['username']."'");
		$s_dev = array();
		$alltem = $this->tem_set->select_all();
		if(!empty($allpass))
		foreach($allpass as $pass) {
			if($pass['device_ip'] != $ip) {
				$s_dev[] = $pass;
				$ip = $pass['device_ip'];
			}
		}
		$num = count($allpass);
		for($ii=0; $ii<$num; $ii++){
			foreach($alltem as $tem) {
					if($allpass[$ii]['login_method'] == $tem['id']) {
						$allpass[$ii]['login_method'] = $tem['login_method'];
					}
				
				}
		}
		$this->assign('weektime',$weektime);
		$this->assign('title',language('选择要绑定的设备'));
		$this->assign('id',$uid);
		$this->assign('f_gid',$f_gid);
		$this->assign('username',$member['username']);
		$this->assign('s_dev',$s_dev);
		$this->assign('alldevgroup',$alldevgroup);
		$this->assign('allpass',$allpass);
		$this->display('forbidden_group_user.tpl');
	}
	function protect_dev() {
		$uid = get_request('uid');
		$g_id = get_request('g_id');
		$f_gid = get_request('f_gid');
		$weektime = get_request('weektime',0,1);
		$member = $this->member_set->select_by_id($uid);
		if($g_id){
		$alldev = $this->server_set->select_all("groupid = $g_id");
		if(count($alldev) == 0) {
			alert_and_back('该设备组没有设备',"admin.php?controller=admin_forbidden&action=protect_group&uid=$uid&f_gid=$f_gid&weektime=$weektime");
			exit(0);
		}
		}
		$allpass = $this->devpass_set->select_all(" luser like '%,$uid,%'");
		$ip = '';
		$s_dev = array();
		if(!empty($allpass))
		foreach($allpass as $pass) {
			if($pass['device_ip'] != $ip) {
				$s_dev[] = $pass;
				$ip = $pass['device_ip'];
			}
		}
		$this->assign('title',language('选择要绑定的设备'));
		$this->assign('weektime',$weektime);
		$this->assign('id',$uid);
		$this->assign('g_id',$g_id);
		$this->assign('f_gid',$f_gid);
		$this->assign('username',$member['username']);
		$this->assign('s_dev',$s_dev);
		$this->assign('alldev',$alldev);
		$this->assign('allpass',$allpass);
		$this->display('forbiddengps_dev_user1.tpl');
	}
	function protect_edit() {
		$uid = get_request('uid');
		$ip = get_request('ip',0,1);
		$g_id = get_request('g_id');
		$f_gid = get_request('f_gid');
		$weektime = get_request('weektime',0,1);
		$member = $this->member_set->select_by_id($uid);
		$group = $this->forbiddengps_set->select_by_id($f_gid);
		if($ip == '') {
			$ip = get_request('ip',1,1);
		}
		$allpass = $this->devpass_set->select_all(" device_ip = '$ip'");
		//echo '<pre>';print_r($allpass);echo '</pre>';
		$num = count($allpass);
		if($num == 0) {
			alert_and_back('该设备还没有用户或IP输入错误',"admin.php?controller=admin_forbidden&action=protect_dev&uid=$uid&g_id=$g_id&f_gid=$f_gid&weektime=$weektime");
			exit(0);
		}
		$devuser=$this->forbiddengpsuser_set->select_all(" radius_user='$member[username]' AND addr='$ip' AND gid=(select gname from ".$this->forbiddengps_set->get_table_name()." WHERE gid=$f_gid)");
		if(count($devuser)){
			alert_and_back('该设备,用户和组已经被邦定',"admin.php?controller=admin_forbidden&action=protect_dev&uid=$uid&g_id=$g_id&f_gid=$f_gid&weektime=$weektime");
			exit(0);
		}
		$allpassuser = array();
		for($ii=0; $ii < $num ; $ii++){
			if(in_array($allpass[$ii][username],$allpassuser))
				continue;
			$allpassuser[]=$allpass[$ii][username];
			$allpasstmp[]=$allpass[$ii];
		}
		$allpass=$allpasstmp;
		for($j=0;$j<$num;$j++) {
			$pos = strpos($allpass[$j]['luser'], ','.$uid.',');
			if ($pos === false) {
				;
			}
			else {
				$allpass[$j]['check'] = 'checked';
			}
		}
		$this->assign('weektime',$weektime);
		$this->assign('title',language('绑定托管用户'));
		$this->assign('ip',$ip);
		$this->assign('id',$uid);
		$this->assign('f_gid',$f_gid);
		$this->assign('username',$member['username']);
		$this->assign("gname", $group['gname']);
		$this->assign('allpass',$allpass);
		$this->display('forbiddengps_dev_user.tpl');
	}
	function protect_save() {
		$id = get_request('id');
		$ip = get_request('ip',0,1);
		$f_gid = get_request('f_gid');
		$weektime = get_request('weektime',0,1);
		$devpass = '';
		
		$member = $this->member_set->select_by_id($id);
		$group = $this->forbiddengps_set->select_by_id($f_gid);
		$forbiddengpsuser = new forbiddengpsuser();
		$forbiddengpsuser->set_data('addr', $ip);
		$forbiddengpsuser->set_data('radius_user', $member['username']);
		$forbiddengpsuser->set_data('gid', $group['gname']);
		$forbiddengpsuser->set_data('weektime', $weektime);
		$this->forbiddengpsuser_set->add($forbiddengpsuser);
		alert_and_back('操作成功',"admin.php?controller=admin_forbidden&action=forbiddengps_user&gid=$f_gid");
		
	}
	function forbiddengps_alluser(){
		$gid= get_request("gid");
		$allmem = $this->member_set->select_all('1 = 1');
		$weektime = $this->weektime_set->select_all();
		$this->assign("weektime", $weektime);
		$this->assign("gid", $gid);
		$this->assign("allmem", $allmem);
		$this->display("forbiddengps_alluser.tpl");
	}
	function del_forbiddengps_cmd() {
		$cid = get_request('cid');
		$gid = get_request('gid');
		if(empty($cid)){
			$cid = $_POST['chk_gid'];
		}
		$this->forbiddengpscommand_set->delete($cid);
		alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=forbiddengps_cmd&gid='.$gid);

	}
	function del_forbiddengps_user() {
		$id = get_request('id');
		$gid = get_request('gid');
		$this->forbiddengpsuser_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=forbiddengps_user&gid='.$gid);

	}
	function delete_all_gid() {
		$id = get_request('chk_gid', 1, 1);
		if($id){
			$this->forbiddengpscommand_set->query("DELETE FROM ".$this->forbiddengpscommand_set->get_table_name()." WHERE gid IN(SELECT gname FROM ".$this->forbiddengps_set->get_table_name()." WHERE gid IN(".(is_array($id) ? implode(',',$id) : $id)."))");
			$this->forbiddengps_set->delete($id);
		}
		
		alert_and_back('成功删除所选组','admin.php?controller=admin_forbidden&action=forbidden_groups_list');
	}
	function del_forbiddengps() {
		$gid = $_GET['gid'];
		if(is_array($gid)){
			for($i=0; $i<count($gid); $i++){
				$ginfo = $this->forbiddengps_set->select_by_id($gid[$i]);
				if($this->luser_set->select_count("forbidden_commands_groups=(select gname from forbidden_groups where gid=".$gid[$i].")") >0
						|| $this->lgroup_set->select_count("forbidden_commands_groups=(select gname from forbidden_groups where gid=".$gid[$i].")")>0
						|| $this->luser_resourcegrp_set->select_count("forbidden_commands_groups=(select gname from forbidden_groups where gid=".$gid[$i].")")>0
						|| $this->lgroup_resourcegrp_set->select_count("forbidden_commands_groups=(select gname from forbidden_groups where gid=".$gid[$i].")")>0
						){
							$error[]=$ginfo['gname'];
							continue ;
				}
				$this->forbiddengpscommand_set->query("DELETE FROM ".$this->forbiddengpscommand_set->get_table_name()." WHERE gid IN(SELECT gname FROM ".$this->forbiddengps_set->get_table_name()." WHERE gid IN(".$gid[$i]."))");
				$this->forbiddengps_set->delete($gid);
			}
			if($error){
				alert_and_back('组:'.implode(',', $error).'已经绑定，请先删除绑定');
			}
		}else{
			if($this->luser_set->select_count("forbidden_commands_groups=(select gname from forbidden_groups where gid=".$gid.")") >0
					|| $this->lgroup_set->select_count("forbidden_commands_groups=(select gname from forbidden_groups where gid=".$gid.")")>0
					|| $this->luser_resourcegrp_set->select_count("forbidden_commands_groups=(select gname from forbidden_groups where gid=".$gid.")")>0
					|| $this->lgroup_resourcegrp_set->select_count("forbidden_commands_groups=(select gname from forbidden_groups where gid=".$gid.")")>0
					){
				alert_and_back('已经绑定，请先删除绑定');
				return ;
			}
			$this->forbiddengpscommand_set->query("DELETE FROM ".$this->forbiddengpscommand_set->get_table_name()." WHERE gid IN(SELECT gname FROM ".$this->forbiddengps_set->get_table_name()." WHERE gid IN(".$gid."))");
			$this->forbiddengps_set->delete($gid);
		}
		
		
		alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=forbidden_groups_list');

	}
	
	function add_cmd() {
		$cmd = trim(get_request('cmd',1,1));
		if ($cmd != "") {
			$level = get_request('level',1,0);
			$dangercmd = new dangercmd();
			$dangercmd->set_data('cmd',$cmd);
			$dangercmd->set_data('level',$level);
			$this->dangercmd_set->add($dangercmd);
			alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=dangerlist');

		}
		else
		{
			alert_and_back('操作失败','admin.php?controller=admin_forbidden&action=dangerlist');
		}
	}
	
	
	function del_dangercmd() {
		$id = get_request('id');
		$this->dangercmd_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=dangerlist');

	}
	


function forbiddencms_edit() {
		$id = get_request('id');
		$ac = get_request('ac',1, 1);
		$addr = get_request('addr', 1, 1);
		$cmd = get_request('cmd', 1, 1);
		$radius_user = get_request('radius_user', 1, 1);
		$this->assign('ip',$ip);
		if($ac=='new'){
			$forbiddencmds = new forbiddencmds();
			$forbiddencmds->set_data("addr", $addr);
			$forbiddencmds->set_data("cmd", $cmd);
			$forbiddencmds->set_data("radius_user", $radius_user);
			$this->forbiddencmds_set->add($forbiddencmds);
			alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=forbidden_commands_list');
		}
		
		//$allmem = $this->member_set->select_all('level = 0');
$allmem = $this->member_set->select_all('1 = 1','username','ASC');
		$alladdrtmp = $this->devpass_set->select_all(' 1=1 ');
		$num = count($alladdrtmp);
		$alladdr = array();
		for($ii=0; $ii<$num; $ii++){
			if(!in_array($alladdrtmp[$ii][device_ip], $alladdr)){
				$alladdr[]=$alladdrtmp[$ii][device_ip];
			}
		}
		
		$this->assign("alladdr", $alladdr);
		$this->assign('allmem',$allmem);

		$this->assign('title',language("管理用户"));
		$this->display('forbiddencmds_edit.tpl');
	}
	function oraclemonitor() {
		$page_num = get_request('page');
		$ac = get_request('ac',1, 1);
		$addr = get_request('addr', 1, 1);
		$cmd = get_request('cmd', 1, 1);
		
		if($ac=='new'){
			if(empty($cmd)){
				alert_and_back('命令不能为空');
				exit;
			}			
			$db_forbiddencmds = new db_forbiddencmds();
			$db_forbiddencmds->set_data("addr", $addr);
			$db_forbiddencmds->set_data("cmd", $cmd);
			$this->db_forbiddencmds_set->add($db_forbiddencmds);
			alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=oraclemonitor');
		}

		$row_num = $this->db_forbiddencmds_set->select_count("1 = 1");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->db_forbiddencmds_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);

		$this->assign("allcommand",$allcommand);

		$this->display("db_forbiddencmd_list.tpl");
	}
	function db_forbiddencms_edit(){
		$alladdrtmp = $this->devpass_set->select_all(' 1=1 ');
		$num = count($alladdrtmp);
		$alladdr = array();
		for($ii=0; $ii<$num; $ii++){
			if(!in_array($alladdrtmp[$ii][device_ip], $alladdr)){
				$alladdr[]=$alladdrtmp[$ii][device_ip];
			}
		}		
		$this->assign("alladdr", $alladdr);
		$this->display("db_forbiddencmds_edit.tpl");
	}
	function db_del_forbidden_cmd() {
		$cid = get_request('cid');
		$gid = get_request('gid');
		$this->db_forbiddencmds_set->delete($cid);
		alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=oraclemonitor');

	}

	function from_cmdgroup(){
		$gid = get_request('gid');
		$group = $this->forbiddengps_set->select_by_id($gid);
		$allexistcommand = $this->forbiddengpscommand_set->select_all("1 = 1 AND gid='".$group['gname']."'");
		$sql = 'SELECT a.* ,b.cmd FROM '.$this->cmdgroup_set->get_table_name().' a LEFT JOIN (SELECT cmd FROM '.$this->forbiddengpscommand_set->get_table_name().' WHERE gid="'.$group['gname'].'") b  ON a.commands=b.cmd WHERE commands!=""';
		$allcommand =  $this->cmdgroup_set->base_select($sql);
		for($i=0; $i<count($allcommand); $i++){
			$cmdgroup[$allcommand[$i]['groupname']][]=$allcommand[$i];
		}

		$this->assign("cmdgroup",$cmdgroup);
		$this->assign("group",$group);
		$this->assign("allexistcommand",$allexistcommand);
		$this->display('forbiddengps_cmd_from_cmdgroup.tpl');
	}

	function from_cmdgroup_save(){
		//var_dump($_POST);
		$black_or_white = get_request('level', 1,0);
		if($_POST){
			$this->forbiddengpscommand_set->delete_all("cmd IN(SELECT commands FROM ".$this->cmdgroup_set->get_table_name().") and gid='".$_POST['gid']."'");
			$insert_sql = "INSERT INTO ".$this->forbiddengpscommand_set->get_table_name()." (cmd, level, gid) SELECT commands,";
			$cid = array();
			foreach($_POST AS $key => $v){
				if(substr(trim($key),0,3)=='cmd'){
					//$insert_sql .= "('".$v."','".$black_or_white."','".$_POST['gid']."'),";
					$cid[] = $v;
				}
			}
			if(!empty($cid)){
				$insert_sql .= " $black_or_white, '".$_POST['gid']."' FROM ".$this->cmdgroup_set->get_table_name()." WHERE id IN(".implode(',', $cid).")";
				$this->forbiddengpscommand_set->query($insert_sql);
			}
		}
		alert_and_close('操作成功');
	}

	function cmdgroup_list() {
		$page_num = get_request('page');
		$add = get_request('add', 1,1);
		$gname = get_request('gname', 1,1);
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

		
		
		$row_num = $this->cmdgroup_set->select_count("commands=''");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$allcommand =  $this->cmdgroup_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, "commands=''", $orderby1, $orderby2);

		$this->assign("allcommand",$allcommand);

		$this->display("cmdgroup_list.tpl");
	}
	
	function cmdgroup_edit(){
		$this->display("addcmdgroup.tpl");
	}

	function cmdgroup_save(){
		$add = get_request('add', 1,1);
		$gname = get_request('gname', 1,1);
		if($add == 'new'){
			if(empty($gname)){
				alert_and_back('请输入名称');
				exit;	
			}
			$a = $this->cmdgroup_set->select_all("groupname='".$gname."'");
			if(!empty($a[0])){
				alert_and_back('名称已经存在');
				exit;
			}
			$cmdgroup = new cmdgroup();
			$cmdgroup->set_data('groupname', $gname);
			$this->cmdgroup_set->add($cmdgroup);
			alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=cmdgroup_list');
			exit;
		}
	}

	function del_cmdgroup() {
		$cid = get_request('cid');
		$gid = get_request('gid',0,1);//var_dump($_POST);
		if($_POST['chk_gid']){
			$this->cmdgroup_set->delete_all("groupname IN(\"".implode('","', $_POST['chk_gid'])."\")");

		}else{
			$this->cmdgroup_set->delete_all("groupname='".$gid."'");

		}
		alert_and_back('操作成功');
			exit;
	}

	function del_cmdgroup_cmd() {
		$id = get_request('id');
		if(empty($id)){
			$id = $_POST['chk_member'];
		}
		$this->cmdgroup_set->delete($id);
		alert_and_back('操作成功');

	}


	function cmdgroup_cmd() {
		$page_num = get_request('page');
		$gid = get_request('gid',0,1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'commands';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		$where = "1 = 1 AND groupname='".$gid."' and commands!=''";
		$row_num = $this->cmdgroup_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("gid", $gid);
		
		$allcommand =  $this->cmdgroup_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"$where", $orderby1, $orderby2);

		$this->assign("allcommand",$allcommand);

		$this->display("cmdgroup_cmd.tpl");
	}

	function cmdgroup_cmd_edit(){
		$gid = get_request('gid',0,1);
		$this->assign("gid", $gid);
		$this->display("addcmdgroup_command.tpl");
	}

	function cmdgroup_cmd_save(){
		$add = get_request('add', 1,1);
		$level = get_request('level', 1,1);
		$gid = get_request('gid', 0,1);
		//$commands = get_request('commands', 1,1);		
		if($add == 'new'){
			for($i=0; $i<count($_POST['commands']); $i++){
				if($_POST['commands'][$i]==""){
					continue;
					exit;
				}
				$cmdgroup = new cmdgroup();
				$cmdgroup->set_data('commands', $_POST['commands'][$i]);
				$cmdgroup->set_data('groupname', $gid);
				$this->cmdgroup_set->add($cmdgroup);
				$cmdgroup = null;
			}
			alert_and_back('操作成功','admin.php?controller=admin_forbidden&action=cmdgroup_cmd&gid='.$gid);
			
		}
	}
}
?>
