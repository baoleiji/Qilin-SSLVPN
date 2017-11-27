<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_member extends c_base {
	function index($radiususer=false, $interface=0) {
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
		$gid = get_request("gid");
		$username = get_request("username", 0, 1);
		$orderby1 = get_request("orderby1", 0, 1);
		$orderby2 = get_request("orderby2", 0, 1);
		$level = get_request("level", 0, 1);
		$from = get_request("from", 0, 1);
		$derive = get_request("derive");
		$ldapid = get_request("ldapid");
		$where = '1';
		if($gid){
			$where .= ' AND groupid='.$gid;
		}
		if($username){
			$where .= " AND username like '%".$username."%'";
		}

		$usergroup = $this->usergroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		

		if($ldapid){
			$ldapidgroup = $this->sgroup_set->select_by_id($ldapid);
			$where .= ' AND groupid IN('.$ldapidgroup['child'].')';
		}

		if(empty($orderby1)){
			$orderby1 = 'username';
		}
		if($orderby1=='groupname') $orderby1= ' convert(b.groupname using gb2312) ';
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			if(empty($_SESSION['ADMIN_MUSERGROUP'])){
				alert_and_back('没有可管理的组','admin.php?controller=admin_session');
				exit;
			}
			$where .= "  AND groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).") AND uid!=".$_SESSION['ADMIN_UID'];
		}
		$_SESSION['RADIUSUSERLIST']=false;
		$wherelevel = " AND (member.level=11 or member.level=1)";	
		$wherelevel_derive = " AND (a.level=11 or a.level=1)";	
		if($derive){
			$this->memberderive($where.$wherelevel_derive);
			exit;
		}

		if($level!=''){
			$where .= ' AND member.level='.$level;
		}
		
		$where .= $wherelevel;
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$row_num = $this->member_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		//$allmember = $this->member_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where, $orderby1, $orderby2);
		//echo "SELECT member.* FROM member left join servergroup b on member.groupid=b.id WHERE $where order by $orderby1 $orderby2 LIMIT ".$newpager->intStartPosition.' ,'.$newpager->intItemsPerPage;
		$allmember = $this->member_set->base_select("SELECT member.*,'' password,b.groupname FROM member left join servergroup b on member.groupid=b.id WHERE $where order by $orderby1 $orderby2 LIMIT ".$newpager->intStartPosition.' ,'.$newpager->intItemsPerPage);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);

		$out = $allmember;
		$config = $this->setting_set->select_all(" sname='password_policy'");
		$pwdconfig = unserialize($config[0]['svalue']);
		
		$eth0 = $this->getServerName();

		

		for($i=0;$i<count($out);$i++) {
			/*for($j=0; $j<count($usergroup); $j++){
				if($usergroup[$j]['id']==$out[$i]['groupid']){
					$out[$i]['groupname']=$usergroup[$j]['groupname'];
					break;
				}
			}*/

			$out[$i]['username'] = $allmember[$i]['username'];
			$out[$i]['onlinenumber'] = get_online_number_by_users($allmember[$i]['username'], $pwdconfig['logintimeout']*60);
			if($out[$i]['username']==$_SESSION['ADMIN_USERNAME']){
				$out[$i]['onlinenumber'] = $out[$i]['onlinenumber'] + 1;
			}
			if($out[$i]['username'].'@'.$eth0['eth0']==$out[$i]['cacn']){
				$out[$i]['downpfx']=1;
			}
		}
		if($interface){
			return $out;
		}
		$this->assign('allmember', $out);
		$this->assign('usergroup', $usergroup);
		$this->assign('eth0', $eth0);
		$this->assign('from', $from);
		
		$this->display('member_list.tpl');
	}

	function radiususer(){
		$this->assign('radiususer', 'radiususer');
		$this->index(true);
	}

	function memberderive($where='1'){
		global $_CONFIG;
		$level = array(
			"0" => '普通用户',
			"1" => '管理员',
			"2" => '审计员',
			"3" => '组管理员',
			"10" => '密码管理员',
			"11" => '认证用户'
		);
		$result = $this->member_set->base_select("SELECT a.*,b.groupname FROM ".$this->member_set->get_table_name()." a LEFT JOIN ".$this->usergroup_set->get_table_name()." b ON a.groupid=b.id WHERE $where and a.level=11 ORDER BY a.username ASC");
		//$handle = @fopen('/tmp/member.xls', 'w');
		
		
		$str = language("用户名").",";
		$str .= language("密码").",";
		if(!$_SESSION['RADIUSUSERLIST']){
			$str .= language("真实姓名").",";
			$str .= language("电子邮箱").",";
			$str .= language("用户权限").",";
			if($_CONFIG['LDAP']&&0){
				$str .= language("一级目录").",";
				$str .= language("二级目录").",";
			}
			$str .= language("组名").",";
			$str .= language("手机号码").",";
			$str .= language("工作单位").",";
			$str .= language("工作部门").",";
			$str .= language("vpn").",";
			$str .= language("vpnip").",";
			$str .= language("USBKEY").",";
			$str .= language("Radius").",";
		}
		$str .= "\n";
		$row = 1;
		if(!empty($result))
		foreach($result as $info) {
			$groupparentparent = '';
			$groupparent = '';
			$ugroup = null;
			$sgroup = null;
			$str .= $info['username'].",";
			$str .= stripslashes($this->server_set->udf_encrypt($this->server_set->udf_decrypt($info['password']),1)).",";
			if(!$_SESSION['RADIUSUSERLIST']){
				if($_CONFIG['LDAP']){
					$_groups = $this->sgroup_set->select_all("groupname=(select groupname from ".$this->sgroup_set->get_table_name()." WHERE id=".$info['groupid'].")");
					if(count($_groups)>1){
						$info['groupid']=$_groups[0]['groupname'].'(('.$info['groupid'].'))';
					}elseif($_groups){
						$info['groupid']=$_groups[0]['groupname'];
					}
				}
				$str .= $info['realname'].",";
				$str .= $info['email'].",";
				$str .= $level[$info['level']].",";
				if($_CONFIG['LDAP']&&0){
					$str .= $groupparentparent.",";
					$str .= $groupparent.",";
				}
				$str .= $info['groupid'].",";
				$str .= $info['mobilenum'].",";
				$str .= $info['workcompany'].",";
				$str .= $info['workdepartment'].",";
				$str .= $info['vpn'].",";
				$str .= $info['vpnip'].",";
				$str .= "'".$info['usbkey']."',";
				$str .= ($info['radiusauth'] ? '是' : '否').",";
			}
			$str .= "\n";		
			
			$row++;
		}
		$str = mb_convert_encoding($str, "GBK", "UTF-8");
		
		//fclose($handle);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=audit-member-".date('Ymd').".csv"); 
		echo $str;
		exit;
	}

	

	function online(){
		$username = get_request('username', 0, 1);
		$config = $this->setting_set->select_all(" sname='password_policy'");
		$pwdconfig = unserialize($config[0]['svalue']);
		$online_users = get_online_users($username, $pwdconfig['logintimeout']*60);
		//var_dump($online_users);
		$this->assign("username", $username);
		$this->assign("current_session_id", session_id());
		$this->assign("online_users", $online_users);
		$this->display('online_member_list.tpl');
	}

	function offline(){
		$ssid = get_request('ssid', 0, 1);
		if(offline_user($ssid)){
			alert_and_back('断开成功');
		}else{
			alert_and_back('断开失败');
		}
	}

	function offline_all(){
		$ssids = $_POST['chk_member'];

		for($i=0; $i<count($ssids); $i++){
			offline_user($ssids[$i]);
		}
		alert_and_back('断开成功');
	}

	function add() {
		global $_CONFIG;
		$gid = get_request('gid');
		$ldapid = get_request('ldapid');
		if($_CONFIG['CREATE_LOG_USER']){
			$this->assign("create_log_user", 1);
		}
		//$allpass = $this->pass_set->select_all();
		
		//$allusbkey = $this->usbkey_set->select_all('keyid not in(select usbkey from member where usbkey is not null)', 'keyid', 'ASC');
		$allusbkey = $this->usbkey_set->base_select('select a.*,ifnull(m.uid,0) bind from radkey a left join member m on a.keyid=m.usbkey group by a.keyid order by a.keyid ASC');
		$usergroup = $this->usergroup_set->select_all('attribute!=2 AND level=0 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		$weektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];	
		$lines = @file($filename);
		$i=0;
		if($lines)
		foreach($lines as $line){
			if(preg_match("/group /",$line)==1) {
				$route = preg_split("/\s{1,}/", $line); 
				$routes[$i]['gname']= $route[1];
				$routes[$i]['start']= $route[2];
				$routes[$i]['end']= $route[3];
				$key1[]=$route[1];
				$i++;
			}
		}
		if(!empty($routes))
		array_multisort($key1,SORT_ASC,$routes);
		
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		$member['netdisksize'] = $dp['netdisksize'];
		$member['default_control'] = $dp['default_control'];
		$member['default_appcontrol'] = '1';
		$member['apphost'] = '1';
		$member['log_priority'] = '-1';
		$member['db_priority'] = '-1';
		$member['start_time'] = date('Y-m-d H:i:s');
		$member['localauth'] = '1';
		$member['webportaltime'] = 0;
		$member['sshport'] = '22';
		$member['rdpport'] = '3389';
		$member['asyncoutpass'] = $_CONFIG['AsyncoutPass'];

		if($_SESSION['MEMBERADDTMP']){
			$member = $_SESSION['MEMBERADDTMP'];
		}
		$this->assign('member', $member);
		$this->assign("logined_user_level", 1);
		$logined_user_level=1;
		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			$adminsgroup = $this->sgroup_set->select_by_id($_SESSION['ADMIN_MSERVERGROUP']);
			$adminsgroup['level']=($adminsgroup['level']==0 ? 6 : $adminsgroup['level']);
			$this->assign("logined_user_level", $adminsgroup['level']);
			$logined_user_level=$adminsgroup['level'];
		}

		$ldapidname = 'ldapid';
		$groupidname = 'groupid';
		require('./include/select_sgroup_ajax.inc.php');
		
		$_mldapid1 = -1;
		$_mldapid2 = -1;
		$_mldapid3 = -1;
		$_mldapid4 = -1;
		$_mldapid5 = -1;
		if($member['mservergroup']||$_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			
			$precl='m';
			$ldapidname = 'mldapid';
			$groupidname = 'mgroupid';
			require('./include/select_sgroup_ajax.inc.php');
		}
		
		$outgroup = array();
		$groupname = '';
		if($acgroups)
		foreach($acgroups as $acgroup) {
			if($acgroup['groupname'] != $groupname) {
				$groupname = $acgroup['groupname'];
				$outgroup[] = $acgroup;
			}
		}
		$this->assign('allusbkey',$allusbkey);
		$this->assign('vpnpool', $routes);
		$this->assign("acgroup",$outgroup);
		$this->assign("allgroup",$allsgroup);
		$this->assign("allpasses",$allpass);		
		$this->assign("sourceip", $sourceip);
		$this->assign("weektime", $weektime);
		$this->assign("usergroup", $usergroup);
		$this->assign('title',language('添加新用户'));

		$config = $this->setting_set->select_all(" sname='password_policy'");
		$loginconfig = $this->setting_set->select_all(" sname='loginconfig'");
		$loginconfig = unserialize($loginconfig[0]['svalue']);
		$this->assign("ldaps", $loginconfig['ldapconfig']);
		$this->assign("ads", $loginconfig['adconfig']);

		$logintype['localauth']=$member['localauth'];
		$logintype['radiusauth']=$member['radiusauth'];
		$logintype['ldapauth']=$member['ldapauth'];
		$logintype['adauth']=$member['adauth'];
		$this->assign("logintype", $logintype);
		//var_dump($config);
		$pwdconfig = unserialize($config[0]['svalue']);		
		$this->assign("pwdconfig_pwdstrong1", intval($pwdconfig['pwdstrong1']));
		$this->assign("pwdconfig_pwdstrong2", intval($pwdconfig['pwdstrong2']));
		$this->assign("pwdconfig_pwdstrong3", intval($pwdconfig['pwdstrong3']));
		$this->assign("pwdconfig_pwdstrong4", intval($pwdconfig['pwdstrong4']));
		$this->assign("pwdconfig_login_pwd_length", intval($pwdconfig['login_pwd_length']));
		$this->assign("pwdconfig_password_ban_word", addslashes($_CONFIG['PASSWORD_BAN_WORD']));
		$this->assign("_config", $_CONFIG);
		exec("sudo /opt/freesvr/audit/sbin/license-print", $out, $return);
		$_o = explode(' ', $out[0]);
		$_p = explode('-', $_o[3]);
		$this->assign("otpenable", $_p[0]);
		$this->assign("vpnenable", $_p[3]);
		$this->display('member_add2.tpl');
	}

	function edit() {
		global $_CONFIG;
		$member = $this->member_set->select_by_id(get_request('uid'));
		$member["password"] = $this->member_set->udf_decrypt($member["password"]);
		
		$allusbkey = $this->usbkey_set->base_select('select a.*,ifnull(m.uid,0) bind from radkey a left join member m on a.keyid=m.usbkey group by a.keyid order by a.keyid ASC');
		$weektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$usergroup = $this->usergroup_set->select_all('1=1 AND level=0 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		
		
		if($_CONFIG['CREATE_LOG_USER']){
			$this->assign("create_log_user", 1);
		}
		$loguser = $this->member_set->base_select("SELECT * FROM ".LOG_DBNAME.".log_user WHERE username='".$member['username']."'");
		if($loguser){
			$this->assign("allowviewlog", 1);
		}
		$this->assign("logined_user_level", 1);
		$logined_user_level=1;
		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			$adminsgroup = $this->sgroup_set->select_by_id($_SESSION['ADMIN_MSERVERGROUP']);
			$adminsgroup['level']=($adminsgroup['level']==0 ? 6 : $adminsgroup['level']);
			$this->assign("logined_user_level", $adminsgroup['level']);
			$logined_user_level=$adminsgroup['level'];
		}
 
		$ldapidname = 'ldapid';
		$groupidname = 'groupid';
		$groupid=$member['groupid'];
		require('./include/select_sgroup_ajax.inc.php');
		
		$precl='m';
		$ldapidname = 'mldapid';
		$groupidname = 'mgroupid';
		$checkbox = 1;
		$mgroupid=$member['mservergroup'];
		require('./include/select_sgroup_ajax.inc.php');

		$outgroup = array();
		$groupname = '';
		if($acgroups)
		foreach($acgroups as $acgroup) {
			if($acgroup['groupname'] != $groupname) {
				$groupname = $acgroup['groupname'];
				$outgroup[] = $acgroup;
			}
		}
		$this->assign("acgroup",$outgroup);
//		$member['flist'] = unserialize($member['flist']);
		//$member["username"] = $member["username"];//print_r($member);
		//echo time($member['end_time']).'--'.time().'--';
		$end_time_arr = explode(' ',$member['end_time']);
		$end_time_ymd = explode('-',$end_time_arr[0]);
		$end_time_time = explode(':',$end_time_arr[1]);
		//echo mktime($end_time_time[0],$end_time_time[1],$end_time_time[2],$end_time_ymd[1],$end_time_ymd[2],$end_time_ymd[0]);
		if($member['end_time'] && mktime($end_time_time[0],$end_time_time[1],$end_time_time[2],$end_time_ymd[1],$end_time_ymd[2],$end_time_ymd[0])<=time()){
			//$member['start_time'] = '2000-01-01 00:00:00';
		}

		$gattr = $this->uattr_set->select_all("UserName = '".$member['username']."' and attribute = '". $_CONFIG['attributes'][2]['name'] ."'");//登陆等级
		$this->assign('priv', substr($gattr[0]['Value'], strpos($gattr[0]['Value'],'=')+1));
		$hattr = $this->uattr_set->select_all("UserName = '".$member['username']."' and attribute = '". $_CONFIG['attributes'][4]['name'] ."'");//登陆等级
		//var_dump($hattr );
		$this->assign('huaweipriv', $hattr[0]['Value']);
		$gattr = $this->uattr_set->select_all("UserName = '".$member['username']."' and attribute = '". $_CONFIG['attributes'][1]['name'] ."'");//登陆等级
		$this->assign('shenmapriv', $gattr[0]['Value']);
		//if(strpos($member['vpnip'],'/'))
		//$member['vpnip']=substr($member['vpnip'],0,strpos($member['vpnip'],'/'));
		$member['vpnip']="";
		$filename = $_CONFIG['CONFIGFILE']['VPNIP'];
		
		$lines = @file($filename);//var_dump($filename);
		if(!empty($lines))
		{			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr($lines[$ii], $member['username'].","))
				{
					$tmp = preg_split("/,/", $lines[$ii]);
					$member['vpnip'] = trim($tmp[1]);
				}
			}
		}

		$this->assign('member', $member);

		$hattr = $this->uattr_set->select_all("UserName = '".$member['username']."' and attribute = 'Login-Service' and value = 'ssh'");//登陆等级
		$this->assign('radiusssh', $hattr[0]['Value']);
		$hattr = $this->uattr_set->select_all("UserName = '".$member['username']."' and attribute = 'Login-Service' and value = 'telnet'");//登陆等级
		$this->assign('radiustelnet', $hattr[0]['Value']);

		if($member['usbkey']){
			$usbkeybind = $this->usbkey_set->select_all("keyid='".$member['usbkey']."'");
			$this->assign("usbkeybind", $usbkeybind[0]);
		}


/*
		$keyid = $this->keys_set->select_all(" UserName = '".$member["username"]."' ");
		if($keyid[0]['pc_id'] !=0) {
			$allusbkey[] = $this->usbkey_set->select_by_id($keyid[0]['pc_id']);
		}
*/		
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];	
		$lines = @file($filename);
		$i=0;
		if($lines)
		foreach($lines as $line){
			if(preg_match("/group /",$line)==1) {
				$route = preg_split("/\s{1,}/", $line); 
				$routes[$i]['gname']= $route[1];
				$routes[$i]['start']= $route[2];
				$routes[$i]['end']= $route[3];
				$key1[]=$route[1];
				$i++;
			}
		}
		if(!empty($routes))
		array_multisort($key1,SORT_ASC,$routes);

		/**/
		$this->assign('ukid', $keyid[0]['pc_id']);
		$this->assign('vpnpool', $routes);
		$this->assign("sourceip", $sourceip);
		$this->assign("weektime", $weektime);
		$this->assign("usergroup", $usergroup);
		$this->assign("allgroup",$allsgroup);
		$this->assign('allusbkey',$allusbkey);
		$this->assign('title',language('编辑用户'));

		$config = $this->setting_set->select_all(" sname='password_policy'");
		$loginconfig = $this->setting_set->select_all(" sname='loginconfig'");
		$loginconfig = unserialize($loginconfig[0]['svalue']);
		$this->assign("ldaps", $loginconfig['ldapconfig']);
		$this->assign("ads", $loginconfig['adconfig']);

		
		$logintype['localauth']=$member['localauth'];
		$logintype['radiusauth']=$member['radiusauth'];
		$logintype['ldapauth']=$member['ldapauth'];
		$logintype['adauth']=$member['adauth'];
		$logintype['fingersecauth']=$member['fingersecauth'];
		$logintype['localfingersecauth']=$member['localfingersecauth'];
		$this->assign("logintype", $logintype);
		//var_dump($config);
		$pwdconfig = unserialize($config[0]['svalue']);
		$pwdshould = '密码中应包含：';
		if($pwdconfig['pwdstrong1']) $pwdshould .= $pwdconfig['pwdstrong1'].'个数字,';
		if($pwdconfig['pwdstrong2']) $pwdshould .= $pwdconfig['pwdstrong2'].'个小写字母,';
		if($pwdconfig['pwdstrong3']) $pwdshould .= $pwdconfig['pwdstrong3'].'个大写字母,';
		if($pwdconfig['pwdstrong4']) $pwdshould .= $pwdconfig['pwdstrong4'].'个特殊字符,';
		if($pwdshould != '密码中应包含：'){
		$this->assign("pwdshould", substr($pwdshould,0,strlen($pwdshould)-1));
		}

		$this->assign("pwdconfig_pwdstrong1", intval($pwdconfig['pwdstrong1']));
		$this->assign("pwdconfig_pwdstrong2", intval($pwdconfig['pwdstrong2']));
		$this->assign("pwdconfig_pwdstrong3", intval($pwdconfig['pwdstrong3']));
		$this->assign("pwdconfig_pwdstrong4", intval($pwdconfig['pwdstrong4']));
		$this->assign("pwdconfig_login_pwd_length", intval($pwdconfig['login_pwd_length']));
		$this->assign("pwdconfig_password_ban_word", addslashes($_CONFIG['PASSWORD_BAN_WORD']));
		$this->assign('_config',$_CONFIG);
		$this->assign("radiususer", $_SESSION['RADIUSUSERLIST'] ? "radiususer" : "");

		exec("sudo /opt/freesvr/audit/sbin/license-print", $out, $return);
		$_o = explode(' ', $out[0]);
		$_p = explode('-', $_o[3]);
		$this->assign("otpenable", $_p[0]);
		$this->assign("vpnenable", $_p[3]);
		//$this->assign("vpnenable", 1);

		//$this->display('member_add2.tpl');
		$this->display('member_add2.tpl');
	}
	
	function edit_self() {
		global $_CONFIG;
		$msg = get_request('msg', 0, 1);
		$keyfile = $_CONFIG['PASSEDITSSHPRIVATEKEY']."/".$_SESSION['ADMIN_USERNAME'];
		if(file_exists($keyfile)){
			$fileinfo = stat($keyfile);
			$filedate = date('Y年m月d日 H时i分', $fileinfo['mtime']);
		}
		$priority_cache = $this->setting_set->select_all("sname='priority_cache'");
		$priority_cache = $priority_cache[0]['svalue'];

		$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$member["password"] = $this->member_set->udf_decrypt($member["password"]);
		$member["username"] = $member["username"];
		$this->assign('msg', empty($msg) ? '' : '请修改密码,密码有效期还剩：'.$_CONFIG['PWD_REMAIN_DAYS']);
		$this->assign('member', $member);
		
		$config = $this->setting_set->select_all(" sname='password_policy'");
		//var_dump($config);
		$pwdconfig = unserialize($config[0]['svalue']);
		$pwdshould = '密码中应包含：';
		if($pwdconfig['pwdstrong1']) $pwdshould .= $pwdconfig['pwdstrong1'].'个数字,';
		if($pwdconfig['pwdstrong2']) $pwdshould .= $pwdconfig['pwdstrong2'].'个小写字母,';
		if($pwdconfig['pwdstrong3']) $pwdshould .= $pwdconfig['pwdstrong3'].'个大写字母,';
		if($pwdconfig['pwdstrong4']) $pwdshould .= $pwdconfig['pwdstrong4'].'个特殊字符,';
		if($pwdshould != '密码中应包含：'){
			$this->assign("pwdshould", substr($pwdshould,0,strlen($pwdshould)-1));
		}
		$logintype['localauth']=$member['localauth'];
		$logintype['radiusauth']=$member['radiusauth'];
		$logintype['ldapauth']=$member['ldapauth'];
		$logintype['adauth']=$member['adauth'];
		$loginconfig = $this->setting_set->select_all(" sname='loginconfig'");
		$loginconfig = unserialize($loginconfig[0]['svalue']);
		$this->assign("ldaps", $loginconfig['ldapconfig']);
		$this->assign("ads", $loginconfig['adconfig']);
		$this->assign("logintype", $logintype);
		$this->assign("filedate", $filedate);
		$this->assign("pwdremain", $_CONFIG['PWD_REMAIN_DAYS']);
		$this->assign("priority_cache", $priority_cache);
		$this->display('member_edit_self.tpl');
	}

	function regenerateqrcode(){
		$uid = get_request('uid');
		$code = '135'.genRandomDigitalString(13);
		$mem = new member();
		$mem->set_data('uid', $uid);
		$mem->set_data('usbkey', $code);
		$mem->set_data('usbkeystatus', 11);
		$mem->set_data('usbkey', '');
		$this->member_set->edit($mem);
		//alert_and_back('操作成功','admin.php?controller=admin_member');
		echo '<script language=\'javascript\'>alert("操作成功");window.parent.document.location="admin.php?controller=admin_member&action=edit&uid='.$uid.'"</script>';
	}

	function generateqrcode(){
		$uid = get_request('uid');
		$code = '135'.genRandomDigitalString(13);
		$mem = new member();
		$mem->set_data('uid', $uid);
		$mem->set_data('usbkey', $code);
		$mem->set_data('usbkeystatus', 11);
		$this->member_set->edit($mem);
		//alert_and_back('操作成功','admin.php?controller=admin_member');
		echo '<script language=\'javascript\'>alert("操作成功");window.parent.document.location="admin.php?controller=admin_member&action=edit&uid='.$uid.'"</script>';
	}

	function cancelqrcode(){
		$uid = get_request('uid');
		$mem = new member();
		$mem->set_data('uid', $uid);
		$mem->set_data('usbkey', '');
		$mem->set_data('usbkeystatus', 0);
		$this->member_set->edit($mem);
		//alert_and_back('操作成功','admin.php?controller=admin_member');		
		echo '<script language=\'javascript\'>alert("操作成功");window.parent.document.location="admin.php?controller=admin_member&action=edit&uid='.$uid.'"</script>';
	}

	function save($interface=false) {
		global $_CONFIG;
		$type = get_request('type', 0, 1);
		$uid = get_request('uid');
		$newmember = new member();
		$_SESSION['MEMBERADDTMP']['password1']=$password1 = htmlspecialchars_decode(get_request('password1', 1, 1));
		$_SESSION['MEMBERADDTMP']['password2']=$password2 = htmlspecialchars_decode(get_request('password2', 1, 1));
		$_SESSION['MEMBERADDTMP']['email']=$email = get_request('email', 1, 1);
		$_SESSION['MEMBERADDTMP']['realname']=$realname  = get_request('realname', 1, 1);
		$_SESSION['MEMBERADDTMP']['acgroup']=$acgroup = get_request('acgroup',1,1);
		$_SESSION['MEMBERADDTMP']['restrictweb']=$restrictweb = get_request('restrictweb',1,1);
		$_SESSION['MEMBERADDTMP']['username']=$uname = get_request('username', 1, 1);
		$_SESSION['MEMBERADDTMP']['usbkey']=$usbkey = get_request('usbkey', 1, 1);
		$_SESSION['MEMBERADDTMP']['usbkeystatus']=$usbkeystatus = get_request('usbkeystatus', 1, 0);
		$_SESSION['MEMBERADDTMP']['usbkeytype']=$usbkeytype = get_request('usbkeytype', 1, 0);
		$_SESSION['MEMBERADDTMP']['ip']=$ip = get_request('ip', 1, 1);
		$_SESSION['MEMBERADDTMP']['limit_time']=$limit_time = get_request('limit_time', 1, 1);
		$_SESSION['MEMBERADDTMP']['vpn']=$vpn = get_request('vpn', 1, 1);
		$_SESSION['MEMBERADDTMP']['level']=$level = get_request('level', 1, 1);
		$_SESSION['MEMBERADDTMP']['log_priority']=$log_priority = get_request('log_priority', 1, 0);
		$_SESSION['MEMBERADDTMP']['db_priority']=$db_priority = get_request('db_priority', 1, 0);
		$_SESSION['MEMBERADDTMP']['auth']=$auth = get_request('auth', 1, 0);
		$_SESSION['MEMBERADDTMP']['localauth']=$localauth = get_request('localauth', 1, 0);
		$_SESSION['MEMBERADDTMP']['radiusauth']=$radiusauth = get_request('radiusauth', 1, 0);
		$_SESSION['MEMBERADDTMP']['ldapauth']=$ldapauth = get_request('ldapauth', 1, 0);
		$_SESSION['MEMBERADDTMP']['adauth']=$adauth = get_request('adauth', 1, 0);
		$_SESSION['MEMBERADDTMP']['authtype']=$authtype = get_request('authtype', 1, 0);
		$_SESSION['MEMBERADDTMP']['nolimit']=$nolimit = get_request('nolimit', 1, 1);
		$_SESSION['MEMBERADDTMP']['sourceip']=$sourceip = get_request('sourceip', 1, 1);
		$_SESSION['MEMBERADDTMP']['sourceipv6']=$sourceipv6 = get_request('sourceipv6', 1, 1);
		$_SESSION['MEMBERADDTMP']['weektime']=$weektime = get_request('weektime', 1, 1);
		$_SESSION['MEMBERADDTMP']['mobilenum']=$mobilenum = get_request('mobilenum', 1, 1);
		$_SESSION['MEMBERADDTMP']['company']=$company = get_request('company', 1, 1);
		$_SESSION['MEMBERADDTMP']['workcompany']=$workcompany = get_request('workcompany', 1, 1);
		$_SESSION['MEMBERADDTMP']['workdepartment']=$workdepartment = get_request('workdepartment', 1, 1);
		$_SESSION['MEMBERADDTMP']['start_time']=$start_time = get_request('start_time', 1, 1);
		$_SESSION['MEMBERADDTMP']['autosetpwd']=$autosetpwd = get_request('autosetpwd', 1, 0);
		$_SESSION['MEMBERADDTMP']['priv']=$priv = get_request('priv', 1, 0);
		$_SESSION['MEMBERADDTMP']['huaweipriv']=$huaweipriv = get_request('huaweipriv', 1, 0);
		$_SESSION['MEMBERADDTMP']['shenmapriv']=$shenmapriv = get_request('shenmapriv', 1, 1);
		$_SESSION['MEMBERADDTMP']['rdpclipauth_up']=$rdpclipauth_up = get_request('rdpclipauth_up', 1, 0);
		$_SESSION['MEMBERADDTMP']['rdpdiskauth_up']=$rdpdiskauth_up = get_request('rdpdiskauth_up', 1, 0);
		$_SESSION['MEMBERADDTMP']['rdpclipauth_down']=$rdpclipauth_down = get_request('rdpclipauth_down', 1, 0);
		$_SESSION['MEMBERADDTMP']['rdpdiskauth_down']=$rdpdiskauth_down = get_request('rdpdiskauth_down', 1, 0);
		$_SESSION['MEMBERADDTMP']['enable']=$enable = get_request('enable', 1, 1);
		$_SESSION['MEMBERADDTMP']['rdpdisk']=$rdpdisk = get_request('rdpdisk', 1, 1);
		$_SESSION['MEMBERADDTMP']['vpnip']=$vpnip = trim(get_request('vpnip', 1, 1));
		//$_SESSION['MEMBERADDTMP']['netdisksize']=$netdisksize = get_request('netdisksize', 1, 1);
		$_SESSION['MEMBERADDTMP']['default_control']=$default_control = get_request('default_control', 1, 0);
		$_SESSION['MEMBERADDTMP']['default_appcontrol']=$default_appcontrol = get_request('default_appcontrol', 1, 0);
		$_SESSION['MEMBERADDTMP']['apphost']=$apphost = get_request('apphost', 1, 1);
		$_SESSION['MEMBERADDTMP']['allowchange']=$allowchange = get_request('allowchange', 1, 1);
		$_SESSION['MEMBERADDTMP']['rdplocal']=$rdplocal = get_request('rdplocal', 1, 1);
		$_SESSION['MEMBERADDTMP']['passwordsave']=$passwordsave = get_request('passwordsave', 1, 1);
		$_SESSION['MEMBERADDTMP']['radius_auth']=$radius_auth = get_request('radius_auth', 1, 1);
		$_SESSION['MEMBERADDTMP']['allowviewlog']=$allowviewlog = get_request('allowviewlog', 1, 1);
		$_SESSION['MEMBERADDTMP']['common_user_pri']=$common_user_pri = get_request('common_user_pri', 1, 1);		
		$_SESSION['MEMBERADDTMP']['passwd_user_pri']=$passwd_user_pri = get_request('passwd_user_pri', 1, 1);		
		$_SESSION['MEMBERADDTMP']['audit_user_pri']=$audit_user_pri = get_request('audit_user_pri', 1, 1);			
		$_SESSION['MEMBERADDTMP']['cacn']=$cacn = get_request('cacn', 1, 1);			
		$_SESSION['MEMBERADDTMP']['radiusssh']=$radiusssh = get_request('radiusssh', 1, 1);			
		$_SESSION['MEMBERADDTMP']['radiustelnet']=$radiustelnet = get_request('radiustelnet', 1, 1);		
		$_SESSION['MEMBERADDTMP']['rdplocalcheck']=$rdplocalcheck = get_request('rdplocalcheck', 1, 1);
		$_SESSION['MEMBERADDTMP']['forceeditpassword']=$forceeditpassword = get_request('forceeditpassword', 1, 1);	
		$_SESSION['MEMBERADDTMP']['firstauth']=$firstauth = get_request('firstauth', 1, 1);	
		$_SESSION['MEMBERADDTMP']['apptoadmingroup']=$apptoadmingroup = get_request('apptoadmingroup', 1, 1);	
		$_SESSION['MEMBERADDTMP']['apptodisk']=$apptodisk = get_request('apptodisk', 1, 1);	
		$_SESSION['MEMBERADDTMP']['groupid']=$groupid = intval($_POST['groupid']);
		$_SESSION['MEMBERADDTMP']['mgroupid']=$mgroupid = ($_POST['mgroupid']);
		$_SESSION['MEMBERADDTMP']['asyncoutpass']=$asyncoutpass = intval($_POST['asyncoutpass']);		
		$_SESSION['MEMBERADDTMP']['webportal']=$webportal = get_request('webportal', 1, 1);			
		$_SESSION['MEMBERADDTMP']['webportaltime']=$webportaltime = intval($_POST['webportaltime']);		
		$_SESSION['MEMBERADDTMP']['freesvrdebug']=$freesvrdebug = get_request('freesvrdebug', 1, 1);				
		$_SESSION['MEMBERADDTMP']['dbdebug']=$dbdebug = get_request('dbdebug', 1, 1);				
		$_SESSION['MEMBERADDTMP']['logindebug']=$logindebug = get_request('logindebug', 1, 1);		
		$_SESSION['MEMBERADDTMP']['ie_hook_flag']=$ie_hook_flag = get_request('ie_hook_flag', 1, 1);		
		$_SESSION['MEMBERADDTMP']['searchcache']=$searchcache = get_request('searchcache', 1, 1);			
		$_SESSION['MEMBERADDTMP']['adou']=$adou = get_request('adou', 1, 1);			
		$_SESSION['MEMBERADDTMP']['groupid']=$groupid = $_POST['groupid'];
		$_SESSION['MEMBERADDTMP']['mgroupid']=$mgroupid = $_POST['mgroupid'];
		$_SESSION['MEMBERADDTMP']['sshport']=$sshport = get_request('sshport', 1, 0);
		$_SESSION['MEMBERADDTMP']['rdpport']=$rdpport = get_request('rdpport', 1, 0);
		$_SESSION['MEMBERADDTMP']['tranportauth']=$tranportauth = get_request('tranportauth', 1, 0);
		$_SESSION['MEMBERADDTMP']['fingersecauth']=$fingersecauth = get_request('fingersecauth', 1, 0);
		$_SESSION['MEMBERADDTMP']['localfingersecauth']=$localfingersecauth = get_request('localfingersecauth', 1, 0);
		if($_SESSION['RADIUSUSERLIST']){
			$enable='on';
		}
		if(empty($nolimit) and empty($limit_time)){
			alert_and_back('请选择过期时间');
			return ;
		}
		if($limit_time && ($start_time > $limit_time)){
			alert_and_back('开始时间应该小于过期时间');
			return;
		}
		if($start_time && !validateDate($start_time)){
			alert_and_back('开始时间输入错误');
			return;
		}
		if($limit_time && !validateDate($limit_time)){
			alert_and_back('过期时间输入错误');
			return;
		}
		
		if(!preg_match('/^[a-zA-Z._\-0-9@]+$/', $uname)){
			$_SESSION['MEMBERADDTMP']['username'] = stripslashes($_SESSION['MEMBERADDTMP']['username']);
			alert_and_back('用户名只能包含下划线、字母、数字，小数点');
			return;
		}
		if($email&&!is_email($email)){
			alert_and_back('Email格式不正确');
			return;
		}
		if($mobilenum&&!is_mobile($mobilenum)){
			alert_and_back('手机号码格式不正确');
			return;
		}
		if(!$_SESSION['RADIUSUSERLIST']&&empty($groupid)){
			alert_and_back('请选择运维组');
			return;
		}
		if($vpnip&&!is_ip($vpnip)){
			alert_and_back('VPN IP格式不正确');
			return;
		}
		if($rdpdisk&&$rdpdisk!='*'&&!preg_match('/^([c-zC-Z]{1}:;)+$/',$rdpdisk)){			
			alert_and_back('RDP磁盘映射只能输入* 或 c: 或 c:;d:等');
			return;
		}
		
		$ha = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$netdisksize = $ha[0]['netdisksize'];
		$newmember->set_data('rdpdiskauth_up', $rdpdiskauth_up);
		$newmember->set_data('rdpclipauth_up', $rdpclipauth_up);
		$newmember->set_data('rdpdiskauth_down', $rdpdiskauth_down);
		$newmember->set_data('rdpclipauth_down', $rdpclipauth_down);
		$newmember->set_data('rdpdisk', $rdpdisk);
		$newmember->set_data('start_time', $start_time);
		$newmember->set_data('cacn', $cacn);
		$newmember->set_data('firstauth', $firstauth);
		$newmember->set_data('asyncoutpass', $asyncoutpass);
		$newmember->set_data('usbkeystatus', $usbkeystatus);
		$newmember->set_data('vpn',$vpn);
		$newmember->set_data('sshport',$sshport);
		$newmember->set_data('rdpport',$rdpport);
		$newmember->set_data('tranportauth',$tranportauth);
		$newmember->set_data('adou',$adou);
		if($nolimit){
			$newmember->set_data('end_time', '2037:1:1 0:0:0');
		}else{
			$newmember->set_data('end_time', $limit_time);
		}
		if($netdisksize){
			$newmember->set_data('netdisksize', $netdisksize);
		}
		if($allowchange == 'on') {
			$newmember->set_data('allowchange',1);
		}
		else {
			$newmember->set_data('allowchange',0);
		}
		if($rdplocal == 'on') {
			$newmember->set_data('rdplocal',1);
		}
		else {
			$newmember->set_data('rdplocal',0);
		}
		if($passwordsave == 'on') {
			$newmember->set_data('passwordsave',1);
		}
		else {
			$newmember->set_data('passwordsave',0);
		}
		if($apphost == 'on') {
			$newmember->set_data('apphost',1);
		}
		else {
			$newmember->set_data('apphost',0);
		}
		if($restrictweb == 'on') {
			$newmember->set_data('restrictweb',1);
		}
		else {
			$newmember->set_data('restrictweb',0);
		}
		if($enable == 'on') {
			$newmember->set_data('enable',1);
		}
		else {
			$newmember->set_data('enable',0);
		}
		if($common_user_pri == 'on') {
			$newmember->set_data('common_user_pri',1);
		}
		else {
			$newmember->set_data('common_user_pri',0);
		}
		if($passwd_user_pri == 'on') {
			$newmember->set_data('passwd_user_pri',1);
		}
		else {
			$newmember->set_data('passwd_user_pri',0);
		}
		if($audit_user_pri == 'on') {
			$newmember->set_data('audit_user_pri',1);
		}
		else {
			$newmember->set_data('audit_user_pri',0);
		}
		
		if($rdplocalcheck == 'on') {
			$rdplocalcheck=1;
			$newmember->set_data('rdplocalcheck',1);
		}
		else {
			$rdplocalcheck=0;
			$newmember->set_data('rdplocalcheck',0);
		}
		if($apptoadmingroup == 'on') {
			$newmember->set_data('apptoadmingroup',1);
		}
		else {
			$newmember->set_data('apptoadmingroup',0);
		}
		if($apptodisk == 'on') {
			$newmember->set_data('apptodisk',1);
		}
		else {
			$newmember->set_data('apptodisk',0);
		}
		if($webportal == 'on') {
			$newmember->set_data('webportal',1);
		}
		else {
			$newmember->set_data('webportal',0);
		}

		if($freesvrdebug == 'on') {
			$newmember->set_data('freesvrdebug',1);
		}
		else {
			$newmember->set_data('freesvrdebug',0);
		}
		if($dbdebug == 'on') {
			$newmember->set_data('dbdebug',1);
		}
		else {
			$newmember->set_data('dbdebug',0);
		}
		if($logindebug == 'on') {
			$newmember->set_data('logindebug',1);
		}
		else {
			$newmember->set_data('logindebug',0);
		}
		if($ie_hook_flag == 'on') {
			$newmember->set_data('ie_hook_flag',1);
		}
		else {
			$newmember->set_data('ie_hook_flag',0);
		}
		if($searchcache == 'on') {
			$newmember->set_data('searchcache',1);
		}
		else {
			$newmember->set_data('searchcache',0);
		}
		
		
		$newmember->set_data('webportaltime', $webportaltime);
		$newmember->set_data('default_control', $default_control);
		$newmember->set_data('default_appcontrol', $default_appcontrol);
		$oldmember = $this->member_set->select_by_id($uid);
		if($oldmember&&empty($password1)&&empty($password2)){
			$emptypassword=1;
			$password1 = $this->member_set->udf_decrypt($oldmember['password']);
			$password2 = $password1;
		}

		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];		
		$lines = @file($filename);
		if(!empty($lines))
		{			
			for($ii=0; $ii<count($lines); $ii++)
			{
				if(strstr(strtolower($lines[$ii]), "server "))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['server1'] = trim($tmp[1]);
					$network['server2'] = trim($tmp[2]);
				}
			}
		}
		if(!empty($vpnip)){
			$vpnipexist = $this->member_set->select_all("vpnip='".$vpnip."' and uid!=$uid");
			if(count($vpnipexist)!=0){
				alert_and_back('vpnip已经分配给用户"'.$vpnipexist[0]['username'].'"使用');
				exit;
			}
			$foundvpnip = 0;
			$filename = $_CONFIG['CONFIGFILE']['VPNIP'];
			$lines = @file($filename);
			if($lines!==false)
			{
				
				for($ii=0; $ii<count($lines); $ii++)
				{
					if(preg_match("/".$uname.",/",$lines[$ii])==1) {
						$foundvpnip = 1;
						$tmp = preg_split("/".$uname.",/", $lines[$ii]);
						$lines[$ii] = $uname.','.$vpnip."\n";
					}
				}
			}else{
				alert_and_back('vpn配置文件不存在或没有权限');
				exit;
			}
			if($foundvpnip==0){
				$lines[$ii]=$uname.','.$vpnip."\n";
			}
			$this->Array2File($lines,$filename);
			unset($lines);
		}
		$newmember->set_data('realname', $realname);
		if(!$_SESSION['RADIUSUSERLIST'])
		if(empty($realname)){
			alert_and_back('真实姓名不能重复且不能为空');
				return;
		}elseif($this->member_set->select_count("realname = '" . $newmember->get_data('realname') . "' AND uid!='$uid' AND level!=11")>0 ) {
			alert_and_back('真实姓名不能重复且不能为空');
				return;
		}
		if(!empty($password1)){			
			
			$config = $this->setting_set->select_all(" sname='password_policy'");
			//var_dump($config);
			$pwdconfig = unserialize($config[0]['svalue']);
			$reg = '';
			//var_dump($pwdconfig);var_dump($password1);
		
			$pwdmsg = '';
			/*if($pwdconfig['pwdstrong1']&&!preg_match('/[0-9]+/', $password1)){
				//alert_and_back('密码中需要包含数字');
				//exit;
				$pwdmsg .= '数字'." ";
			}
			if(!$pwdconfig['pwdstrong1']&&preg_match('/[0-9]+/', $password1)){
				//alert_and_back('密码中不能包含数字');
				//exit;
				$pwdmsgn .= '数字'." ";
			}
			if($pwdconfig['pwdstrong2']&&!preg_match('/[a-zA-Z]+/', $password1)){
				//alert_and_back('密码中需要包含小写字母');
				//exit;
				$pwdmsg .= '字母'." ";
			}
			if(!$pwdconfig['pwdstrong2']&&preg_match('/[a-zA-Z]+/', $password1)){
				//alert_and_back('密码中不能包含小写字母');
				//exit;
				$pwdmsgn .= '字母'." ";
			}
			
			$pwd_replace = preg_replace('/[0-9a-zA-Z]+/','', $password1);
			if($pwdconfig['pwdstrong4']&&strlen($pwd_replace)==0){
				//alert_and_back('密码中需要包含特殊字符');
				//exit;
				$pwdmsg .= '特殊字符'." ";
			}
			if(!$pwdconfig['pwdstrong4']&&strlen($pwd_replace)>0){
				//alert_and_back('密码中不能包含特殊字符');
				//exit;
				$pwdmsgn .= '特殊字符'." ";
			}*/
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
			if(strlen($password1) < $pwdconfig['login_pwd_length']){
				//alert_and_back(language('密码最少长度为').$pwdconfig['login_pwd_length']);
				//exit();
				$pwdmsgl = language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 ';
			}

			$pwd_ban_word_arr = explode('1', $_CONFIG['PASSWORD_BAN_WORD']);
			if($pwd_ban_word_arr){
				$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
			}//var_dump($pwd_ban_word_str);var_dump(str_replace('  ', '空格', $pwd_ban_word_str));
			for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
				if($pwd_ban_word_arr[$pi]&&strpos($password1, $pwd_ban_word_arr[$pi])!==false){
					$pwdmsg2='密码中不能包含以下字符:'.addslashes(str_replace('  ', '空格', $pwd_ban_word_str)).' \n请重新输入';
					break;
				}
			}
			
			if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2) || !empty($pwdmsg3)){
				if($pwdconfig['pwdstrong1'] || $pwdconfig['pwdstrong2'] || $pwdconfig['pwdstrong3'] || $pwdconfig['pwdstrong4']){
					$pwdmsgs .= '密码中需要包含:' .  ($pwdconfig['pwdstrong1'] ? $pwdconfig['pwdstrong1'].'个数字' : '').($pwdconfig['pwdstrong2'] ? $pwdconfig['pwdstrong2'].'个小写字母' : '').($pwdconfig['pwdstrong3'] ? $pwdconfig['pwdstrong3'].'个大写字母' : '').($pwdconfig['pwdstrong4'] ? $pwdconfig['pwdstrong4'].'个特殊字符' : ''). "\\n";
				}
				$pwdmsgs .= $pwdmsg3;
				$pwdmsgs .= language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 '."\\n";
				if(count($pwd_ban_word_str)>0){
					$pwdmsgs .= '密码中不能包含以下字符:'.addslashes(str_replace('  ', '空格', $pwd_ban_word_str)).' \n\n请重新输入';
				}
				alert_and_back($pwdmsgs);
				return;
			}
		}else{
			alert_and_back('请输入密码');
			return;
		}
		if($mgroupid)
		$serverResult = $this->server_set->select_all(" groupid IN($mgroupid)");
		if($serverResult){
			foreach ($serverResult AS $key => $value){
				$serverIds[] = $value['id'];
			}
		}
		if($serverIds)
		$serverString=implode(",", $serverIds);
		$newmember->set_data("devs", ",".$serverString.",");
		if($uid != 0) {
			$flist = get_request('flist', 1, 1);
			$uid = get_request('uid');
			$newmember->set_data('uid',$uid);
			if($password1!=$oldmember[0]['password']){				
				$newmember->set_data("lastdateChpwd", time());
			}
			
			if(empty($autosetpwd)){
				if(!($password1 == "" && $password2 == "")) {
					if($password1 == $password2) {
						if($_CONFIG['crypt']==1){
							$password1 = encrypt($password1);
						}
						$newmember->set_data('password', $password1);
					}
					else {
						alert_and_back('两次输入的密码不一致');
						exit();
					}
				}
			}else{
				$password1 = genRandomPassword(8);
				$newmember->set_data('password', $password1);
			}
			$this->devpass_set->query("UPDATE ".$this->devpass_set->get_table_name()." SET old_password=cur_password,cur_password='".$this->member_set->udf_encrypt($password1)."' WHERE username='".get_request('username', 1, 1)."' AND radiususer!=0");
			$newmember->set_data('flist', serialize($flist));


		}
		else {
			if(empty($autosetpwd)){
				if($password1 == $password2) {
						if($_CONFIG['crypt']==1){
							$password1 = encrypt($password1);
						}
					$newmember->set_data('password', $password1);
					$newmember->set_data('lastdateChpwd', 0);
					
				}
				else {
					alert_and_back('两次输入的密码不一致');
					exit();
				}
			}else{
				$password1 = genRandomPassword(8);
				$newmember->set_data('password', $password1);
				
			}
			
			
		}
		
		$newmember->set_data('username', get_request('username', 1, 1));		
		if($autosetpwd&&empty($email)){
			alert_and_back('由于您设置了随机密码,请输入邮件地址');
			exit;
		}
		$newmember->set_data('email', get_request('email', 1, 1));
		$newmember->set_data('vpnip', $vpnip);
		$newmember->set_data("sourceip", $sourceip);		
		$newmember->set_data("sourceipv6", $sourceipv6);		
		$newmember->set_data("weektime", $weektime);
		$newmember->set_data("mobilenum", $mobilenum);
		$newmember->set_data("company", $company);
		$newmember->set_data("workcompany", $workcompany);
		$newmember->set_data("workdepartment", $workdepartment);
		$newmember->set_data("groupid", $groupid);
		$newmember->set_data("auth", $auth);
		$newmember->set_data("localauth", $localauth);
		$newmember->set_data("radiusauth", $radiusauth);
		$newmember->set_data("ldapauth", $ldapauth);
		$newmember->set_data("adauth", $adauth);
		$newmember->set_data("authtype", $authtype);
		$newmember->set_data("fingersecauth", $fingersecauth);
		$newmember->set_data("localfingersecauth", $localfingersecauth);
		$newmember->set_data("localauth", 1);
		if($forceeditpassword){
			$newmember->set_data("forceeditpassword", 1);
		}else{
			$newmember->set_data("forceeditpassword", 0);
		}

		if($uid != 0) {
			$user = $this->member_set->select_by_id($uid);
			if($user['password']!=$password1){
				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('修改运维用户密码'));
				$adminlog->set_data('luser', $user['username']);
				$adminlog->set_data('type', 11);
				$this->admin_log_set->add($adminlog);
			}
		}

		$this->usbkey_set->query("UPDATE radkey SET isused=1 WHERE keyid='".$usbkey."'");
		$newmember->set_data('usbkey', $usbkey);
		$usbkeybind = $this->usbkey_set->select_all("keyid='".$usbkey."'");
		if($usbkeybind[0]['type']&&$user['usbkey']!=$usbkey){	
			$newmember->set_data('usbkeystatus', 11);
		}

		if(!empty($ip)){
			$ip_arr = explode(".", $ip);
			if(count($ip_arr) <= 4 && $ip_arr[0]=='10' && $ip_arr[1]=='11' && ($ip_arr[2]>=0 && $ip_arr[2]<=255) && ($ip_arr[3]>=1 && $ip_arr[3]<=255) && $ip != '10.11.0.1'){
				if($this->member_set->select_all("ip = '" . $ip . "' AND uid != $uid") != NULL ){
					alert_and_back('该IP已存在,请重新选择');exit;
				}
			}else{
				alert_and_back('IP输入不正确');exit;
			}
		}

		if($rdplocalcheck!=$oldmember['rdplocalcheck']){
			echo '<script language=\'javascript\'>alert("由于更改了默认，需要重启IE")</script>';
		}
		$newmember->set_data('ip', $ip);

		if($newmember->get_errnum() == 0) {
			$whereappserverip = '1';
			if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
				$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
				$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
				$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." )";
				$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." )";	
				$appservers = $this->appmember_set->base_select("SELECT device_ip appserverip,hostname FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ($sql) dd ON d.id=dd.devicesid  WHERE dd.devicesid IS NOT NULL AND login_method=26 GROUP BY device_ip", 'hostname', 'asc');
				$_appservers = array(0);
				for($i=0; $i<count($appservers); $i++){
					$_appservers[]=$appservers[$i]['appserverip'];
				}
				$whereappserverip .= " AND appserverip IN('".implode("','", $_appservers)."')";
			}
			
			if($uid == 0) {
				//$allpasswd = $this->update_user();
				if($this->member_set->select_all("username = '" . $newmember->get_data('username') . "'") == NULL ) {

					
					$newmember->set_data('level', get_request('level', 1, 0));
					if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
						if($newmember->get_data('level')!=0&&$newmember->get_data('level')!=21&&$newmember->get_data('level')!=101){
							$newmember->set_data("level", 0);
						}else{
							$newmember->set_data("level", $newmember->get_data('level'));
						}
					}
					if($_SESSION['RADIUSUSERLIST']){
						$newmember->set_data("level", 11);
					}
					if($interface){
						$newmember->set_data('interface',1);
					}
					/*只有普通用户才有Radius用户,系统用户和密码托管用户*/
					//if($newmember->get_data('level') == 0) {
						$setting34 = $this->setting_set->select_by_id(34);
						$this->luser_set->query("DELETE FROM radcheck WHERE username='".$newmember->get_data('username')."'");		
						$this->luser_set->query("DELETE FROM radreply WHERE UserName='".$newmember->get_data('username')."'");	
						$new_radius = new radius();						
						$new_radius->set_data("UserName",$newmember->get_data('username'));
						$new_radius->set_data("Attribute",'Crypt-Password');
						$new_radius->set_data("email",$newmember->get_data('email'));
						$new_radius->set_data("Value",$setting34['svalue']==1?$newmember->get_data('password'):crypt($newmember->get_data('password'),"\$1\$qY9g/6K4"));
						$this->radius_set->add($new_radius);
						/*
						$new_pro = new pro();
						$new_pro->set_data("username",$this->encryp($newmember->get_data('username')));
						for($i = 1;$i<6;$i++) {
							$new_pro->set_data("user$i",get_request("user$i",1,1));
						}
						$this->pro_set->add($new_pro);
						*/
						$out = '';
						//command("sudo /usr/sbin/useradd ". $newmember->get_data('username'), $out);	
						//command("echo \"".$password1."\" | sudo passwd --stdin " . $newmember->get_data('username'), $out);
					//}
					//else
					//var_dump($newmember->get_data('level')) ;
					if($newmember->get_data('level') == 3 || $newmember->get_data('level') == 21 || $newmember->get_data('level') == 101) {
						$newmember->set_data('mservergroup',$mgroupid);
						$newmember->set_data('musergroup',$mgroupid);
					}
					$newmember->set_data("password", $this->member_set->udf_encrypt($newmember->get_data("password")));
					
					
					$this->member_set->add($newmember);
					$uid = mysql_insert_id();
					if($autosetpwd){
						/*$ha = $this->config_set->base_select("SELECT * FROM alarm LIMIT 1");
						$smtp = new smtp_mail($ha[0]['MailServer'],"25",$ha[0]['account'],$ha[0]['password'], false);
						if(!$smtp->conn) echo '<script language=\'javascript\'>密码发送失败，请联系管理员查看邮箱设置</script>';
						$smtp->send($ha[0]['account'],$newmember->get_data('email'),iconv("UTF-8", "GBK", $_CONFIG['site']['title']." 随机密码"),iconv("UTF-8", "GBK",($newmember->get_data('username')).",你好:\n  你的随机密码是:".$this->member_set->udf_decrypt($newmember->get_data('password'))));
						*/
						$mailsender = new mail_sender();
						$mailsender->set_data('mailto',$newmember->get_data('email'));
						$mailsender->set_data('subject','堡垒机'.$newmember->get_data('username').'用户随机密码');
						$mailsender->set_data('msg','您的堡垒机'.$newmember->get_data('username').'用户密码为'.$this->member_set->udf_decrypt($newmember->get_data('password')).'，请立即登录进行修改');
						$mailsender->set_data('program','前台创建随机用户');
						$this->mail_sender_set->add($mailsender);
						$mid = mysql_insert_id();
						exec('/home/wuxiaolong/mail_sender.pl '.$mid);
						
					}
					if($uid&&$groupid){
						/*
						$_gp = array();
						$_g = $this->sgroup_set->select_by_id($groupid);
						$_gp[]=$_g['id'];
						while($_g['ldapid']){
							$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
							$_gp[]=$_g['id'];
						}
						$this->member_set->query("UPDATE servergroup set mcount=mcount+1 where id in(".implode(',', $_gp).")");
						*/
						$this->sgroup_set->updatem($groupid, null);
						if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
							$this->sgroupcache_set->updatem($groupid, null);
						}
					}
					$passwordlog = new passwordlog();
					$passwordlog->set_data('uid', $uid);
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
					

					$newuattr = new uattr();//添加登陆等级
					$newuattr->set_data('username', $uname);
					$newuattr->set_data('attribute', $_CONFIG['attributes'][2]['name']);
					$newuattr->set_data('value', $_CONFIG['attributes'][2]['default'].$priv);
					$this->uattr_set->add($newuattr);

					$newhuattr = new uattr();//添加登陆等级
					$newhuattr->set_data('username', $uname);
					$newhuattr->set_data('attribute', $_CONFIG['attributes'][4]['name']);
					$newhuattr->set_data('value', $huaweipriv);
					$this->uattr_set->add($newhuattr);

					$oldhuattr = $this->uattr_set->select_all("username = '".$uname."' and attribute = '". $_CONFIG['attributes'][1]['name'] ."'");
					if(empty($oldhuattr)){
						if($shenmapriv){
							$newhuattr = new uattr();//添加登陆等级
							$newhuattr->set_data('username', $uname);
							$newhuattr->set_data('attribute', $_CONFIG['attributes'][1]['name']);
							$newhuattr->set_data('op', $_CONFIG['attributes'][1]['op']);
							$newhuattr->set_data('value',6);
							$this->uattr_set->add($newhuattr);
						}
					}else{
						$newhuattr = new uattr();//修改登陆等级
						$newhuattr->set_data('id', $oldhuattr[0]['id']);
						$newhuattr->set_data('value', 6);
						$this->uattr_set->edit($newhuattr);
						if(empty($shenmapriv)){
							$this->uattr_set->delete($oldhuattr[0]['id']);
						}
					}

					/*if($_CONFIG['CREATE_LOG_USER']){
						if($allowviewlog){
							$this->member_set->query("INSERT INTO ".LOG_DBNAME.".log_user SET username='".$uname."', password='".md5($password1)."', level=0, email='".$email."'");
						}else{
							$this->member_set->query("UPDATE ".LOG_DBNAME.".log_user SET password='".md5($password1)."', level=0, email='".$email."' WHERE username='".$uname."'");
						}
					}*/
					$asyncaccount = "";
					if($_CONFIG['Async']&&!$_SESSION['RADIUSUSERLIST']){
						$appservers = $this->appserver_set->select_all($whereappserverip);
						for($i=0; $i<count($appservers); $i++){
							$cmd = "async ".$appservers[$i]['appserverip']." 8888 ".$newmember->get_data('username')." 1";
							$rs = asyncAccount($cmd);
							if($rs<0||intval(substr($rs, 0, 1))==0){
								$asyncaccount_errorip[] = $appservers[$i]['appserverip'];
							}
						}
					}
					unset($_SESSION['MEMBERADDTMP']);
					if($_SESSION['RADIUSUSERLIST']){
						if($radiusssh){
							$newhuattr = new uattr();//添加登陆等级
							$newhuattr->set_data('username', $uname);
							$newhuattr->set_data('attribute', 'Login-Service');
							$newhuattr->set_data('op', '==');
							$newhuattr->set_data('value', 'ssh');
							$this->uattr_set->add($newhuattr);
						}
						if($radiustelnet){
							$newhuattr = new uattr();//添加登陆等级
							$newhuattr->set_data('username', $uname);
							$newhuattr->set_data('attribute', 'Login-Service');
							$newhuattr->set_data('op', '==');
							$newhuattr->set_data('value', 'telnet');
							$this->uattr_set->add($newhuattr);
						}
						echo '<script language=\'javascript\'>alert(\'成功添加用户'.($asyncaccount_errorip ? ',同步账号到应用发布服务器:'.implode(' ', $asyncaccount_errorip)." 失败 " : '').'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=radiusmember&gid='.$gid.'";</script>';
						return $uid;
						//alert_and_back('成功添加用户', 'admin.php?controller=admin_member&action=radiususer');
					}else{
						echo '<script language=\'javascript\'>alert(\'成功添加用户'.($asyncaccount_errorip ? ',同步账号到应用发布服务器:'.implode(' ', $asyncaccount_errorip)." 失败 " : '').'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=member&gid='.$gid.'";</script>';
						//alert_and_back('成功添加用户', 'admin.php?controller=admin_member');
						return $uid;
					}
					
				}
				else {
					alert_and_back('该用户已存在', NULL, 1);
					return;
				}
			}
			else {
				$user = $this->member_set->select_by_id($uid);

				if(!$emptypassword&&$user['password'] != $this->member_set->udf_encrypt($newmember->get_data("password"))){
					$passlog = $this->passwordlog_set->select_limit(0, intval($pwdconfig['oldpassnumber']), " uid='$uid' and password=md5('$password1')", 'time','DESC');
					if(count($passlog)>0){
						alert_and_back('该密码已经使用过,请重新选择');
						return;
					}
				}
				if($user['usbkey'])
				$this->usbkey_set->query("UPDATE radkey SET isused=0 WHERE keyid='".$user['usbkey']."'");
				/*只有普通用户才有Radius用户*/
				//if($newmember->get_data('level') != 3)
				{
					$setting34 = $this->setting_set->select_by_id(34);
					$old_radius = $this->radius_set->select_all("UserName = '".$user['username']."'");
					$new_radius = new radius();
					$new_radius->set_data("id",$old_radius[0]['id']);
					$new_radius->set_data("email",$newmember->get_data('email'));
					if($newmember->get_data('password') != '') {
 						$new_radius->set_data("Value",$setting34['svalue']==1?$newmember->get_data('password'):crypt($newmember->get_data('password'),"\$1\$qY9g/6K4"));
						//$newmember->set_data('lastdateChpwd', time());
					}						
					$this->radius_set->edit($new_radius);

				}
				$newmember->set_data('level', get_request('level', 1, 0));
				if($user['level'] == 3 || $user['level'] == 21 || $user['level'] == 101) {
					$newmember->set_data('mservergroup',$mgroupid);
					$newmember->set_data('musergroup',$mgroupid);
				}
				if($newmember->get_data('level') == 3 || $newmember->get_data('level') == 21 || $newmember->get_data('level') == 101) {
					$newmember->set_data('mservergroup',$mgroupid);
					$newmember->set_data('musergroup',$mgroupid);
				}elseif($newmember->get_data('level') == 0) {
					$newmember->set_data('mservergroup',0);
					$newmember->set_data('musergroup',0);
				}

				
				if($_SESSION['RADIUSUSERLIST']){
					$newmember->set_data("level", 11);
				}

				$adminlog = new admin_log();
				$adminlog->set_data('luser', $user['username']);
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('action', language('编辑运维用户'));
				$adminlog->set_data('type', 11);
				$this->admin_log_set->add($adminlog);
				if($user['username']=='password'){
						$cmd = "echo \"".$password1."\" | sudo passwd --stdin " . $user['username'];
						command($cmd, $out);	
				}
				
				$newmember->set_data("password", $this->member_set->udf_encrypt($newmember->get_data("password")));
				if($user['password']!=$newmember->get_data("password")){					
					$newmember->set_data('lastdateChpwd', 0);
					$passwordlog = new passwordlog();
					$passwordlog->set_data('uid', $uid);
					$passwordlog->set_data('password', md5($password1));
					$passwordlog->set_data('time', time());
					$this->passwordlog_set->add($passwordlog);
					if($pwdconfig['oldpassnumber']&&($cpnum=$this->passwordlog_set->select_count("uid=".$passwordlog->get_data('uid')))>$pwdconfig['oldpassnumber']){
						
						$this->passwordlog_set->query("DELETE FROM ".$this->passwordlog_set->get_table_name()." WHERE uid=$uid ORDER BY id ASC LIMIT ".($cpnum-$pwdconfig['oldpassnumber']));
					}
				}
				
				$this->member_set->edit($newmember);
				if($groupid!=$user['groupid']){
					$this->sgroup_set->updatem($groupid, $user['groupid']);
					if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
						$this->sgroupcache_set->updatem($groupid, $user['groupid']);
					}
				}
				if($autosetpwd){
					/*$ha = $this->config_set->base_select("SELECT * FROM alarm LIMIT 1");
					$smtp = new smtp_mail($ha[0]['MailServer'],"25",$ha[0]['account'],$this->member_set->udf_decrypt($ha[0]['password']), false);
					if(!$smtp->conn) echo '<script language=\'javascript\'>密码发送失败，请联系管理员查看邮箱设置</script>';
					$smtp->send($ha[0]['account'],$newmember->get_data('email'),$_CONFIG['site']['title']." 随机密码",($user['username']).",你好:\n  你的随机密码是:".$this->member_set->udf_decrypt($newmember->get_data('password')));
					*/
					$mailsender = new mail_sender();
					$mailsender->set_data('mailto',$newmember->get_data('email'));
					$mailsender->set_data('subject','堡垒机'.$newmember->get_data('username').'用户随机密码');
					$mailsender->set_data('msg','您的堡垒机'.$newmember->get_data('username').'用户密码为'.$this->member_set->udf_decrypt($newmember->get_data('password')).'，请立即登录进行修改');
					$mailsender->set_data('program','前台创建随机用户');
					$this->mail_sender_set->add($mailsender);
					$mid = mysql_insert_id();
					exec('/home/wuxiaolong/mail_sender.pl i '.$mid);
						
				}

				$olduattr = $this->uattr_set->select_all("username = '".$user['username']."' and attribute = '". $_CONFIG['attributes'][2]['name'] ."'");
				if(empty($olduattr)){
					$newuattr = new uattr();//添加登陆等级
					$newuattr->set_data('username', $user['username']);
					$newuattr->set_data('attribute', $_CONFIG['attributes'][2]['name']);
					$newuattr->set_data('value',$_CONFIG['attributes'][2]['default'].$priv);
					$this->uattr_set->add($newuattr);
				}else{
					$newuattr = new uattr();//修改登陆等级
					$newuattr->set_data('id', $olduattr[0]['id']);
					$newuattr->set_data('value', $_CONFIG['attributes'][2]['default'].$priv);

					$this->uattr_set->edit($newuattr);
				}
				$oldhuattr = $this->uattr_set->select_all("username = '".$user['username']."' and attribute = '". $_CONFIG['attributes'][1]['name'] ."'");
				if(empty($oldhuattr)){
					if($shenmapriv){
						$newhuattr = new uattr();//添加登陆等级
						$newhuattr->set_data('username', $user['username']);
						$newhuattr->set_data('attribute', $_CONFIG['attributes'][1]['name']);
						$newhuattr->set_data('op', $_CONFIG['attributes'][1]['op']);
						$newhuattr->set_data('value',6);
						$this->uattr_set->add($newhuattr);
					}
				}else{
					$newhuattr = new uattr();//修改登陆等级
					$newhuattr->set_data('id', $oldhuattr[0]['id']);
					$newhuattr->set_data('value', 6);
					$this->uattr_set->edit($newhuattr);
					if(empty($shenmapriv)){
						$this->uattr_set->delete($oldhuattr[0]['id']);
					}
				}
				$oldhuattr = $this->uattr_set->select_all("username = '".$user['username']."' and attribute = '". $_CONFIG['attributes'][4]['name'] ."'");
				if(empty($oldhuattr)){
					$newhuattr = new uattr();//添加登陆等级
					$newhuattr->set_data('username', $user['username']);
					$newhuattr->set_data('attribute', $_CONFIG['attributes'][4]['name']);
					$newhuattr->set_data('value',$huaweipriv);
					$this->uattr_set->add($newhuattr);
				}else{
					$newhuattr = new uattr();//修改登陆等级
					$newhuattr->set_data('id', $oldhuattr[0]['id']);
					$newhuattr->set_data('value', $huaweipriv);

					$this->uattr_set->edit($newhuattr);
				}
				if($_CONFIG['CREATE_LOG_USER']){
					if($allowviewlog){
						$loguser = $this->member_set->base_select("select * from ".LOG_DBNAME.".log_user where username='".$uname."'");
						if(empty($loguser)){
							$this->member_set->query("INSERT INTO ".LOG_DBNAME.".log_user SET username='".$uname."', password='".md5($password1)."', level=0, email='".$email."'");
						}else{
							$this->member_set->query("UPDATE ".LOG_DBNAME.".log_user SET password='".md5($password1)."', level=0, email='".$email."' WHERE username='".$uname."'");
						}
					}else{
						$this->member_set->query("DELETE FROM ".LOG_DBNAME.".log_user WHERE username='".$uname."'");
					}
				}
				$asyncaccount = "";
					if($_CONFIG['Async']&&!$_SESSION['RADIUSUSERLIST']){
						$appservers = $this->appserver_set->select_all($whereappserverip);
						for($i=0; $i<count($appservers); $i++){
							$cmd = "async ".$appservers[$i]['appserverip']." 8888 ".$newmember->get_data('username')." 1";
							$rs = asyncAccount($cmd);
							if($rs<0||intval(substr($rs, 0, 1))==0){
								$asyncaccount_errorip[] = $appservers[$i]['appserverip'];
							}
						}
					}
				unset($_SESSION['MEMBERADDTMP']);
				if($oldmember['level']==11){
					if($radiusssh){
						$oldhuattr = $this->uattr_set->select_all("username = '".$user['username']."' and attribute = 'Login-Service' and value = 'ssh'  ");
						if(empty($oldhuattr)){
							$newhuattr = new uattr();//添加登陆等级
							$newhuattr->set_data('username', $uname);
							$newhuattr->set_data('attribute', 'Login-Service');
							$newhuattr->set_data('op', '==');
							$newhuattr->set_data('value', 'ssh');
							$this->uattr_set->add($newhuattr);
						}
					}else{
						$this->uattr_set->delete_all("username = '".$user['username']."' and attribute = 'Login-Service' and value = 'ssh'  ");
					}
					if($radiustelnet){
						$oldhuattr = $this->uattr_set->select_all("username = '".$user['username']."' and attribute = 'Login-Service' and value = 'telnet'  ");
						if(empty($oldhuattr)){
							$newhuattr = new uattr();//添加登陆等级
							$newhuattr->set_data('username', $uname);
							$newhuattr->set_data('attribute', 'Login-Service');
							$newhuattr->set_data('op', '==');
							$newhuattr->set_data('value', 'telnet');
							$this->uattr_set->add($newhuattr);
						}
					}else{
						$this->uattr_set->delete_all("username = '".$user['username']."' and attribute = 'Login-Service' and value = 'telnet'  ");
					}
					echo '<script language=\'javascript\'>alert(\'成功修改用户'.($asyncaccount_errorip ? ',同步账号到应用发布服务器:'.implode(' ', $asyncaccount_errorip)." 失败 " : '').'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=radiusmember&gid='.$gid.'";</script>';
					//exit;
						
					//alert_and_back('成功编辑用户', 'admin.php?controller=admin_member&action=radiususer');
				}else{
					echo '<script language=\'javascript\'>alert(\'成功修改用户'.($asyncaccount_errorip ? ',同步账号到应用发布服务器:'.implode(' ', $asyncaccount_errorip)." 失败 " : '').'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=member&gid='.$gid.'";</script>';
					//exit;
					//alert_and_back('成功编辑用户', 'admin.php?controller=admin_member');
				}
			}
		}
		else {
			alert_and_back($newmember->get_firsterr(), NULL, 1);
			return;
		}
	}

	
	function batchadd(){
		global $_CONFIG;
		require_once('./include/select_sgroup_ajax.inc.php');

		
		$usergroup = $this->usergroup_set->select_all('level=0 and attribute!=2 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		$this->assign("usergroup", $usergroup);
		$this->assign("_config", $_CONFIG);
		$this->display('batchadd.tpl');
	}

	function batchadd_save($encrypt=0){
		global $_CONFIG;
		$error = null;
		$_POSTS=$_POST;
		$filename = $_CONFIG['CONFIGFILE']['SERVERCONF'];		
		$lines = @file($filename);
		if(!empty($lines))
		{			
			for($ii=0; $ii<count($lines); $ii++)
			{
				if(strstr(strtolower($lines[$ii]), "server "))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);
					$network['server1'] = trim($tmp[1]);
				}
			}
		}
		$groupid = intval($_POST['groupid']);
		
		for($i=0; $i<count($_POSTS['username']); $i++){
			
			$newmember = new member();
			$username = $_POSTS['username'][$i];
			$level = $_POSTS['level'][$i];
			$_error = $_POSTS['error'][$i];
			if($_error){
				$error[]=$username.':'.$_error.'\n';
				continue;
			}
			if(empty($username)){
				continue;
			}
			if($level!=0&&empty($level)&&($username=='admin'||$username=='audit'||$username=='password')){
				$error[]=$username.':'.'只能导入普通用户和RADIUS用户'.'\n';
				continue;
			}
			
			if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
				$exist_member = $this->member_set->select_all("username='$username'");
				if($exist_member&&!in_array($exist_member[0]['groupid'],$_SESSION['ADMIN_MUSERGROUP_IDS'])){
					$error[]=$username.':'.'已经存在'.'\n';
					continue;
				}
				
			}

			$oldmember = $this->member_set->select_all("username='$username'");
			$oldmember = $oldmember[0];
			$password = $_POSTS['password'][$i];
			$confirm_password = $_POSTS['confirm_password'][$i];
			$groupid = (isset($_POSTS['groupid'][$i]) ? $_POSTS['groupid'][$i] : $groupid);
			$mobilenum = $_POSTS['mobilenum'][$i];
			$company = $_POSTS['company'][$i];
			$workcompany = $_POSTS['workcompany'][$i];
			$workdepartment = $_POSTS['workdepartment'][$i];
			$email = $_POSTS['email'][$i];
			$realname = $_POSTS['realname'][$i];
			$vpn = $_POSTS['vpn'][$i];
			$vpnip = $_POSTS['vpnip'][$i];
			$usbkey = $_POSTS['usbkey'][$i];
			$priv = $_POSTS['priv'][$i];
			$huaweipriv = $_POSTS['huaweipriv'][$i];
			$radiusssh = $_POSTS['radiusssh_'.$i];
			$radiustelnet = $_POSTS['radiustelnet_'.$i];
			$localauth = $_POST['localauth'][$i];
			$radiusauth = $_POST['radiusauth'][$i];
			$ldapauth = $_POST['ldapauth'][$i];
			$adauth = $_POST['adauth'][$i];
			$auth = $_POST['auth'][$i];
			$authtype = $_POST['authtype'][$i];
			$firstauth = $_POST['firstauth'][$i];
			$forceeditpassword = $_POST['forceeditpassword'][$i];
			$asyncoutpass = $_POST['asyncoutpass'][$i];
			$tranportauth = $_POST['tranportauth'][$i];

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
			$newmember->set_data('localauth', $localauth);
			$newmember->set_data('radiusauth', $radiusauth);
			$newmember->set_data('ldapauth', $ldapauth);
			$newmember->set_data('adauth', $adauth);
			$newmember->set_data('auth', $auth);
			$newmember->set_data('authtype', $authtype);
			$newmember->set_data('firstauth', $firstauth);
			$newmember->set_data('forceeditpassword', $forceeditpassword);
			$newmember->set_data('asyncoutpass', $asyncoutpass);
			$newmember->set_data('tranportauth', $tranportauth);
			$newmember->set_data('sshport', 22);
			$newmember->set_data('rdpport', 3389);
			if($usbkey){
				$usbkeybind = $this->usbkey_set->select_all("keyid='".$usbkey."'");
				if($usbkeybind[0]['type']&&$oldmember['usbkey']!=$usbkey){	
					$newmember->set_data('usbkeystatus', 11);
				}
			}else{
				$newmember->set_data('usbkeystatus', 11);
			}

			if(!preg_match('/^[a-zA-Z._\-0-9@]+$/', $username)){
				$error[]=$username.':'.'用户名包含大小写字母、数字、下划线、小数点'.'\n';
				continue;
			}
			if($mobilenum&&!is_mobile($mobilenum)){
				$error[]=$username.':'.'手机号码格式不正确'.'\n';
				alert_and_back('手机号码格式不正确');
				continue;
			}
			if($vpnip&&!is_ip($vpnip)){
				$error[]=$username.':'.'VPN IP格式不正确'.'\n';
				alert_and_back('VPN IP格式不正确');
				continue;
			}
			if($rdpdisk&&$rdpdisk!='*'&&!preg_match('/^([c-zC-Z]{1}:;)+$/',$rdpdisk)){	
				$error[]=$username.':'.'RDP磁盘映射只能输入* 或 c: 或 c:;d:等'.'\n';
				alert_and_back('RDP磁盘映射只能输入* 或 c: 或 c:;d:等');
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

				
				$pwd_ban_word_arr = explode('1', $_CONFIG['PASSWORD_BAN_WORD']);			
				if($pwd_ban_word_arr){
					$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
				}
				for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
					if(!empty($pwd_ban_word_arr[$pi]))
					if(strpos($password, $pwd_ban_word_arr[$pi])!==false){
						$pwdmsg2='密码中不能包含以下字符:'.addslashes(str_replace('  ', '空格', $pwd_ban_word_str)).'';
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
						$pwdmsgs .= '密码中不能包含以下字符:'.addslashes(str_replace('  ', '空格', $pwd_ban_word_str));
					}
					$error[]=$username.':'.$pwdmsgs.'\n';
					//alert_and_back($pwdmsgs);
					//exit;
					continue;
				}
			}

			
			if($password == $confirm_password) {
				if($_CONFIG['crypt']==1){
					//$password1 = encrypt($password);
				}
				if($encrypt||get_request('action', 0, 1)=='batchadd_save'){
					$newmember->set_data('password', $this->member_set->udf_encrypt(addslashes($password)));
				}else{
					$newmember->set_data('password', $this->member_set->udf_encrypt($this->member_set->udf_decrypt(addslashes($password),1)));
				}
			}
			else {
				//alert_and_back('两次输入的密码不一致');
				$error[]=$username.':两次输入的密码不一致\n';
				continue;
			}
			
			if($this->member_set->select_count("username!='" . $username . "' and realname = '" . $newmember->get_data('realname') . "' AND level!=11")>0 ) {
				$error[]=$username.":真实名\'$realname\'已经存在".'\n';
				continue;
			}
			$newmember->set_data('username', $username);
			
			$newmember->set_data('level', $level);
			if(isset($groupid)){
				$newmember->set_data("groupid", $groupid);
			}else{
				$newmember->set_data("groupid", $_POST);
			}
			if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ){
				if(!in_array($groupid, $_SESSION['ADMIN_MUSERGROUP_IDS'])){
					$error[]=$username.":不能添加到部门\'".$_POST['groupname'][0]."\'".'\n';
					continue;
				}
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

			if(!$_SESSION['RADIUSUSERLIST']){
				
			}else{
				$newuattr = new uattr();//添加登陆等级
				$newuattr->set_data('username', $newmember->get_data('username'));
				$newuattr->set_data('attribute', $_CONFIG['attributes'][2]['name']);
				$newuattr->set_data('value', $_CONFIG['attributes'][2]['default'].$priv);
				$this->uattr_set->add($newuattr);

				$newhuattr = new uattr();//添加登陆等级
				$newhuattr->set_data('username', $newmember->get_data('username'));
				$newhuattr->set_data('attribute', $_CONFIG['attributes'][4]['name']);
				$newhuattr->set_data('value', $huaweipriv);
				$this->uattr_set->add($newhuattr);

				if($radiusssh){
					$newhuattr = new uattr();//添加登陆等级
					$newhuattr->set_data('username', $newmember->get_data('username'));
					$newhuattr->set_data('attribute', 'Login-Service');
					$newhuattr->set_data('op', '==');
					$newhuattr->set_data('value', 'ssh');
					$this->uattr_set->add($newhuattr);
				}
				if($radiustelnet){
					$newhuattr = new uattr();//添加登陆等级
					$newhuattr->set_data('username', $newmember->get_data('username'));
					$newhuattr->set_data('attribute', 'Login-Service');
					$newhuattr->set_data('op', '==');
					$newhuattr->set_data('value', 'telnet');
					$this->uattr_set->add($newhuattr);
				}
			}

			$this->member_set->add($newmember);
			if(mysql_insert_id()>0){
				$this->sgroup_set->updatem($newmember->get_data('groupid'), null);
				if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
					$this->sgroupcache_set->updatem($newmember->get_data('groupid'), null);
				}
			}
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
			if($_SESSION['RADIUSUSERLIST']){
				echo '<script language=\'javascript\'>alert(\''.$msg.'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=radiusmember&gid='.$gid.'";</script>';
				//alert_and_back($msg,'admin.php?controller=admin_member&action=radiususer');
			}else{
				echo '<script language=\'javascript\'>alert(\''.$msg.'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=member&gid='.$gid.'";</script>';
				//alert_and_back($msg,'admin.php?controller=admin_member');
			}
		}else{
			$msg = '添加失败:\n'.implode('\n',$error).'\n';
			if($_SESSION['RADIUSUSERLIST']){
				echo '<script language=\'javascript\'>alert(\''.$msg.'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=radiusmember&gid='.$gid.'";</script>';
				//alert_and_back('添加失败:\n'.implode('\n',$error).'\n','admin.php?controller=admin_member&action=radiususer');
			}else{
				echo '<script language=\'javascript\'>alert(\''.$msg.'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=member&gid='.$gid.'";</script>';
				//alert_and_back('添加失败:\n'.implode('\n',$error).'\n','admin.php?controller=admin_member');
			}
		}
	}


	function batchedit(){
		//var_dump($_POST);
		global $_CONFIG;
		if(empty($_POST['chk_member'])){
			alert_and_back('请至少选择一个用户');
			exit;
		}
		$users = $this->member_set->select_all("uid IN(".implode(',', $_POST['chk_member']).")");
		for($i=0; $i<count($users); $i++){
			$users[$i]['password']=stripslashes($this->member_set->udf_decrypt($users[$i]['password']));
		}
		$this->assign("users", $users);
		$this->display('batchedit.tpl');
	}

	function batchedit_save(){
		global $_CONFIG;
		$error = null;
		$_POSTS=$_POST;
		//var_dump($_POSTS);
		for($i=0; $i<count($_POSTS['uid']); $i++){
			
			$newmember = new member();
			$uid = $_POSTS['uid'][$i];
			$username = $_POSTS['username'][$i];
			if(empty($uid)){
				continue;
			}
	
			$password = $_POSTS['password'][$i];
			$confirm_password = $_POSTS['confirm_password'][$i];
			$rdpdiskauth_up = $_POSTS['rdpdiskauth_up_'.$_POSTS['uid'][$i]];
			$rdpclipauth_up = $_POSTS['rdpclipauth_up_'.$_POSTS['uid'][$i]];
			$rdpdiskauth_down = $_POSTS['rdpdiskauth_down'];
			$rdpclipauth_down = $_POSTS['rdpclipauth_down'];
			$rdpdisk = $_POSTS['rdpdisk'][$i];
			$limit_time = $_POSTS['limit_time'][$i];
			$newmember->set_data('end_time', $limit_time);
			$newmember->set_data('rdpdiskauth_up', $rdpdiskauth_up);
			$newmember->set_data('rdpclipauth_up', $rdpclipauth_up);
			$newmember->set_data('rdpdiskauth_down', $rdpdiskauth_down);
			$newmember->set_data('rdpclipauth_down', $rdpclipauth_down);
			$newmember->set_data('rdpdisk', $rdpdisk);

			if(!empty($password)){			
				$config = $this->setting_set->select_all(" sname='password_policy'");
				$pwdconfig = unserialize($config[0]['svalue']);
				$reg = '';			
				$pwdmsg = '';
				$pwdmsgl = '';
				$pwdmsg2 = '';
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

				
				$pwd_ban_word_arr = explode('1', $_CONFIG['PASSWORD_BAN_WORD']);			
				if($pwd_ban_word_arr){
					$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
				}			
				for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){					
					if($password&&$pwd_ban_word_arr[$pi]&&strpos($password, $pwd_ban_word_arr[$pi])!==false){
						$pwdmsg2='密码中不能包含以下字符:'.addslashes(str_replace('  ', '空格', $pwd_ban_word_str)).'';
						break;
					}
				}
				$pwdmsgs=null;
				if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2) || !empty($pwdmsg3)){
					$pwdmsgs .= $pwdmsg3;
					if($pwdconfig['pwdstrong1'] || $pwdconfig['pwdstrong2'] || $pwdconfig['pwdstrong3'] || $pwdconfig['pwdstrong4']){
						$pwdmsgs .= '密码中需要包含:' .  ($pwdconfig['pwdstrong1'] ? '数字' : '').($pwdconfig['pwdstrong2'] ? '小写字母' : '').($pwdconfig['pwdstrong3'] ? '大写字母' : '').($pwdconfig['pwdstrong4'] ? '特殊字符' : '');
					}
					$pwdmsgs .= language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 ';
					if(count($pwd_ban_word_str)>0){
						$pwdmsgs .= '密码中不能包含以下字符:'.addslashes(str_replace('  ', '空格', $pwd_ban_word_str));
					}
					$error[]=$username.':'.$pwdmsgs.'\n';
					//alert_and_back($pwdmsgs);
					//exit;
					continue;
				}
			}

			$encrypt=1;
			if($password == $confirm_password) {
				if($_CONFIG['crypt']==1){
					$password1 = encrypt($password);
				}
				if($encrypt){
					$newmember->set_data('password', $this->member_set->udf_encrypt(addslashes($password)));
				}else{
					$newmember->set_data('password', addslashes($password));
				}
			}
			else {
				//alert_and_back('两次输入的密码不一致');
				$error[]=$username.':两次输入的密码不一致\n';
				continue;
			}
			/*只有普通用户才有Radius用户,系统用户和密码托管用户*/
			//if($newmember->get_data('level') == 0) {
			$new_radius = new radius();						
			$new_radius->set_data("UserName",$username);
			$new_radius->set_data("Attribute",'Crypt-Password');
			$new_radius->set_data("Value",crypt($password,"\$1\$qY9g/6K4"));
			
			$succeed[]=$username;
			if(($user=$this->member_set->select_by_id($uid)) != NULL){
				//$error[]=$username.':帐户已经存在\n';
				$radiususer = $this->radius_set->select_all("UserName = '" . $username . "'");
				$new_radius->set_data("id",$radiususer[0]['id']);
				$this->radius_set->edit($new_radius);
				$newmember->set_data('uid', $user['uid']);
				$this->member_set->edit($newmember);
			}
			$passwordlog = new passwordlog();
			$passwordlog->set_data('uid', mysql_insert_id());
			$passwordlog->set_data('password', md5($password1));
			$passwordlog->set_data('time', time());
			$this->passwordlog_set->add($passwordlog);
			//记录日志
			$adminlog = new admin_log();
			$adminlog->set_data('luser', $newmember->get_data('username'));
			$adminlog->set_data('action', language('修改运维用户'));
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('type', 11);
			$this->admin_log_set->add($adminlog);			
		}
		if($succeed)
		$msg = '成功修改用户:'.implode(',',$succeed);
		if($error){
			$msg .= '\n添加失败的用户:\n'.implode('\n',$error).'\n';
		}
		alert_and_back($msg,'admin.php?controller=admin_member');
	}

	function batchpriorityedit(){
		global $_CONFIG;
		$groupidname = 'sgroupid';
		$$groupidname = $_GET['sgroupid'];
		require_once('./include/select_sgroup_ajax.inc.php');
		$prefgroupid=get_request('prefgroupid');
		$username=get_request('username', 0, 1);

		//var_dump($_POST);
		$type = get_request('type', 0, 1) ? get_request('type', 0, 1) : get_request('type', 1, 1);
		if(empty($type)){
			$type = 'rdpdisk';
		}
		$where = '1';
		if($sgroupid){
			$_tmpgid = $this->sgroup_set->select_by_id($sgroupid);
			$where .= ' AND groupid IN('.$_tmpgid['child'].')';
		}
		if($prefgroupid){
			if($_GET['uid'])
			$_SESSION['BATCHPRIORITYEDIT']['GROUP'][$prefgroupid]=$_GET['uid'];
		}else{
			if($_GET['uid'])
			$_SESSION['BATCHPRIORITYEDIT']['ALL']=$_GET['uid'];
		}
		if($username){
			$where .= " AND username like '%$username%'";
		}
		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			if(empty($_SESSION['ADMIN_MUSERGROUP'])){
				alert_and_back('没有可管理的组','admin.php?controller=admin_session');
				exit;
			}
			$where .= "  AND groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).") AND uid!=".$_SESSION['ADMIN_UID'];
		}
		$weektime = $this->weektime_set->select_all();
		$users = $this->member_set->select_all($where, 'username', 'asc');
		for($i=0; $i<count($users); $i++){
			if($fgroupid){
				if($_SESSION['BATCHPRIORITYEDIT']['GROUP'][$fgroupid]){
				if(in_array($users[$i]['uid'], $_SESSION['BATCHPRIORITYEDIT']['GROUP'][$sgroupid])){
					$users[$i]['check']='checked';
				}
				}
			}else{
				if($_SESSION['BATCHPRIORITYEDIT']['ALL'])
				if(in_array($users[$i]['uid'], $_SESSION['BATCHPRIORITYEDIT']['ALL'])){
					$users[$i]['check']='checked';
				}
			}
		}
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$config = $this->setting_set->select_all(" sname='password_policy'");
		$loginconfig = $this->setting_set->select_all(" sname='loginconfig'");
		$loginconfig = unserialize($loginconfig[0]['svalue']);
		$this->assign("ldaps", $loginconfig['ldapconfig']);
		$this->assign("ads", $loginconfig['adconfig']);
		$this->assign("sourceip", $sourceip);
		$this->assign("users", $users);
		$this->assign("weektime", $weektime);
		$this->assign("type", $type);
		$this->assign("_config", $_CONFIG);
		$this->assign("usergroup", $usergroup);
		$this->assign('servergroup', $fgroupid);
		$this->display('batchpriorityedit.tpl');
	}

	function batchpriorityeditsave(){
		//var_dump($_POST);
		$groupid = intval($_POST['groupid']);
		
		for($i=0; $i<count($_POST['enable']); $i++){
			switch($_POST['enable'][$i]){
				case 'usergroup':
					$set .='groupid='.$groupid.',';
					break;
				case 'start_time':
					$set .='start_time="'.get_request('start_time',1,1).'",';
					break;
				case 'limit_time':
					if(get_request('nolimit',1,0)){
						$set .='end_time="2037:1:1 0:0:0",';
					}else{
						$set .='end_time="'.get_request('limit_time',1,1).'",';
					}
					break;
				case 'ipv4':
					$set .='sourceip="'.get_request('sourceip',1,1).'",';
					break;
				case 'ipv6':
					$set .='sourceipv6="'.get_request('sourceipv6',1,1).'",';
					break;
				case 'enable':
					$set .='enable="'.get_request('_enable',1,0).'",';
					break;
				case 'weektime':
					$set .='weektime="'.get_request('weektime',1,1).'",';
					break;
				case 'restrictweb':
					$set .='restrictweb="'.get_request('restrictweb',1,0).'",';
					break;
				case 'apphost':
					$set .='apphost="'.get_request('apphost',1,0).'",';
					break;
				case 'loginauth':
					$set .='localauth="'.get_request('localauth',1,0).'",';
					$set .='radiusauth="'.get_request('radiusauth',1,0).'",';
					$set .='ldapauth="'.get_request('ldapauth',1,0).'",';
					$set .='adauth="'.get_request('adauth',1,0).'",';
					$set .='auth="'.get_request('auth',1,0).'",';
					$set .='authtype="'.get_request('authtype',1,0).'",';
					break;
				case 'rdpclipboard':
					$set .='rdpclipauth_up="'.get_request('rdpclipauth_up',1,0).'",';
					$set .='rdpclipauth_down="'.get_request('rdpclipauth_down',1,0).'",';
					break;
				case 'rdpdiskauth_up':
					$set .='rdpdiskauth_up="'.get_request('rdpdiskauth_up',1,0).'",';
					break;
				case 'rdpdisk':
					$set .='rdpdisk="'.get_request('rdpdisk',1,0).'",';
					break;
				case 'allowchange':
					$set .='allowchange="'.get_request('allowchange',1,0).'",';
					break;
				case 'rdplocal':
					$set .='rdplocal="'.get_request('rdplocal',1,0).'",';
					break;
				case 'passwordsave':
					$set .='passwordsave="'.get_request('passwordsave',1,0).'",';
					break;
				case 'default_control':
					$set .='default_control="'.get_request('default_control',1,0).'",';
					break;
				case 'rdplocalcheck':
					$set .='rdplocalcheck="'.get_request('rdplocalcheck',1,0).'",';
					break;
				case 'default_appcontrol':
					$set .='default_appcontrol="'.get_request('default_appcontrol',1,0).'",';
					break;
				case 'firstauth':
					$set .='firstauth="'.get_request('firstauth',1,1).'",';
					break;
				case 'apptoadmingroup':
					$set .='apptoadmingroup="'.get_request('apptoadmingroup',1,1).'",';
					break;
				case 'apptodisk':
					$set .='apptodisk="'.get_request('apptodisk',1,1).'",';
				case 'webportal':
					$set .='webportal="'.get_request('webportal',1,0).'",';
					$set .='webportaltime="'.get_request('webportaltime',1,0).'",';
					break;
				case 'asyncoutpass':
					$set .='asyncoutpass="'.get_request('asyncoutpass',1,0).'",';
				case 'tranportauth':
					$set .='tranportauth="'.get_request('tranportauth',1,0).'",';
			}
		}
		$set=substr($set,0,strlen($set)-1);
		//var_dump($set);exit;
		//$_POST['uid']=array(0);
		$uids=array();
		if($_POST['fgroupid']||$_POST['uid']){
			if($_POST['fgroupid']){
				$_SESSION['BATCHPRIORITYEDIT']['GROUP'][$_POST['fgroupid']]=$_POST['uid'];
				foreach($_SESSION['BATCHPRIORITYEDIT']['GROUP'] AS $k => $v){
					if($v)
					$uids=array_merge($uids, $v);
				}
			}else{
				$uids=$_POST['uid'];
			}
			if($_POST['submit']=='批量导出'){
				$this->memberderive("uid IN(".implode(',', $uids).")");
			}elseif($_POST['submit']=='批量删除'){
				$_GET['frombatchpriorityedit']=1;
				$_POST['chk_member']=$uids;
				$this->delete_all();
			}elseif($_POST['submit']=='批量锁定'){
				$_GET['frombatchpriorityedit']=1;
				$_POST['chk_member']=$uids;
				$this->loginlock();
			}else{
				$this->member_set->query("UPDATE member set $set WHERE uid IN(".implode(',', $uids).")");
				alert_and_back('操作成功','admin.php?controller=admin_member');
			}
		}else{
			alert_and_back('请选择用户');
		}
	}

	function usergroup() {
		global $_CONFIG;
		$page_num = get_request('page');
		$ldapid = get_request('ldapid');
		$orderby1 = get_request('orderby1',0, 1);
		$orderby2 = get_request('orderby2',0, 1);
		$where = '1=1';
		$whereg = " level=1 ";
		if(empty($orderby1)){
			$orderby1 = 'groupname';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		if($_SESSION['ADMIN_LEVEL']==3 ||$_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			$where .= " AND `id`=(SELECT musergroup FROM ".$this->member_set->get_table_name()." WHERE uid='".$_SESSION['ADMIN_UID']."')";
		}
		if($ldapid){
			$_groupids_a = array($ldapid);
			$_groupids = $this->sgroup_set->select_all("ldapid=".$ldapid);
			for($i=0; $i<count($_groupids); $i++){
				$_groupids_a[] = $_groupids[$i]['id'];
			}
			$where .= ' AND ldapid IN('.implode(',', $_groupids_a).')';
			$whereg .= " AND (id=$ldapid or ldapid=$ldapid)";
			//$where .= " AND ldapid=".$ldapid;
		}
		
		if($_CONFIG['LDAP']){
			
			$row_num2 = $this->sgroup_set->select_count($whereg);
			$newpager2 = new my_pager($row_num2, $page_num, $this->config['site']['items_per_page'], 'page');
			if(($page_num-1)*20<$row_num2)
			$alldev = $this->sgroup_set->select_limit($newpager2->intStartPosition, $newpager2->intItemsPerPage, $whereg, $orderby1, $orderby2);
			for($i=0; $i<count($alldev); $i++){
				$subgroup = $this->sgroup_set->select_all("level=2 and ldapid=".$alldev[$i]['id'], "groupname", "ASC");
				for($j=0; $j<count($subgroup); $j++){				
					$sql = "SELECT a.*,(SELECT COUNT(*) FROM ".$this->member_set->get_table_name()." WHERE groupid=a.id) AS userct FROM ".$this->usergroup_set->get_table_name()." a WHERE ".$where . " AND ldapid=".$subgroup[$j]['id']." ORDER BY $orderby1 $orderby2 ";
					$subservergroup = $this->usergroup_set->base_select($sql);
					$subgroup[$j]['children'] = $subservergroup;
					$subgroup[$j]['children_ct'] = count($subservergroup);
				}
				$alldev[$i]['children']=$subgroup;
				$alldev[$i]['children_ct']=count($subgroup);
			}
			if(count($alldev)<20){
				$where .= " AND ldapid=0";
				$page_num = empty($page_num) ? 1 : $page_num;
				$row_num = $this->usergroup_set->select_count($where);
				$newpager = new my_pager($row_num+$row_num2, $page_num, $this->config['site']['items_per_page'], 'page');
				if($newpager->intStartPosition-$row_num2>0){
					$newpager->intStartPosition = $newpager->intStartPosition-$row_num2;
				}
				$sql = "SELECT a.*,(SELECT COUNT(*) FROM ".$this->member_set->get_table_name()." WHERE groupid=a.id) AS userct FROM ".$this->usergroup_set->get_table_name()." a WHERE ".$where . " ORDER BY $orderby1 $orderby2 LIMIT ".$newpager->intStartPosition.",".( 20-count($alldev));
				$noldapgroup = $this->usergroup_set->base_select($sql);
				//$noldapgroup = $this->usergroup_set->select_limit(, $where, $orderby1, $orderby2);
			}
			$this->assign('allgroup', $alldev);
			$this->assign('noldapgroup', $noldapgroup);
		}else{
			$row_num = $this->usergroup_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$sql = "SELECT a.*,(SELECT COUNT(*) FROM ".$this->member_set->get_table_name()." WHERE groupid=a.id) AS userct FROM ".$this->usergroup_set->get_table_name()." a WHERE ".$where . " ORDER BY $orderby1 $orderby2 LIMIT ".$newpager->intStartPosition.",".$newpager->intItemsPerPage;
			$alldev = $this->usergroup_set->base_select($sql);
			$this->assign('allgroup', $alldev);
		}
		
		$this->assign('title', language('用户组列表'));
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("_config", $_CONFIG);
		$this->display('user_group_index.tpl');
	}

	function usergroup_edit() {
		global $_CONFIG;
		$id = get_request("id",0,1);
		$ldapid = get_request("ldapid",0,1);
		$this->assign('title', language('添加节点'));
		$loadbalance = $this->loadbalance_set->select_all();
		$this->assign("logined_user_level", 1);
		$_ldapid1 = 0;
		$_ldapid2 = 0;
		if(empty($id)){
		}else{
			$sgroups = $this->sgroup_set->select_by_id(($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP'] : ０));
			if($sgroups)
			$this->assign("logined_user_level", $sgroups['level']);
			$sgroup = $this->usergroup_set->select_by_id($id);
			$sgroup1 = $this->sgroup_set->select_by_id($sgroup['ldapid']);
			if($sgroup1['level']==1){
				$this->assign('ldapid1', $sgroup1['id']);
				$this->assign('ldapid2', 0);
				$_ldapid1 = $sgroup1['id'];
				$_ldapid2 = 0;
			}elseif($sgroup1['level']==2){
				$this->assign('ldapid1', $sgroup1['ldapid']);
				$this->assign('ldapid2', $sgroup1['id']);
				$_ldapid1 = $sgroup1['ldapid'];
				$_ldapid2 = $sgroup1['id'];
			}else{
				$this->assign('ldapid1', 0);
				$this->assign('ldapid2', 0);
				$_ldapid1 = 0;
				$_ldapid2 = 0;
			}
		}
		
		if($_SESSION['ADMIN_MUSERGROUPTYPE']){
			$allsgroup = $this->sgroup_set->select_all('level>0 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? (empty($_SESSION['ADMIN_MUSERGROUP']) ? ' AND  0' : ' AND (id='.$_SESSION['ADMIN_MUSERGROUP']." or id IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")) or id IN($_ldapid1, $_ldapid2)) ") : ''), 'groupname', 'asc');
			$msgroup = $this->sgroup_set->select_by_id($_SESSION['ADMIN_MUSERGROUP']);
		}else{
			$allsgroup = $this->sgroup_set->select_all('level>0 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? (empty($_SESSION['ADMIN_MUSERGROUP']) ? ' AND  0' : '  id IN($_ldapid1, $_ldapid2))') : ''), 'groupname', 'asc');
			$msgroup = $this->usergroup_set->select_by_id($_SESSION['ADMIN_MUSERGROUP']);
		}
		if($ldapid){
			$_sgroup = $this->sgroup_set->select_by_id($ldapid);
			if($_sgroup['level']==1){
				$this->assign('ldapid1', $_sgroup['id']);
				$this->assign('ldapid2', 0);
			}elseif($_sgroup['level']==2){
				$this->assign('ldapid1', $_sgroup['ldapid']);
				$this->assign('ldapid2', $_sgroup['id']);
			}
		}
		$this->assign("msgroup", $msgroup);
		$this->assign("loadbalances", $loadbalance);
		$this->assign("sgroup", $sgroup);
		$this->assign("ldapid", $ldapid);
		$this->assign("allsgroup", $allsgroup);
		$this->assign("_config", $_CONFIG);
		$this->display('usergroup_edit.tpl');
	}

	function usergroup_save() {
		global $_CONFIG;
		$id = get_request("id",0,1);
		$new_name = get_request("groupname",1,1);
		$loadbalance = get_request('loadbalance',1,0);
		$description = get_request("description",1,1);
		$ldapid = get_request('ldapid');
		$ldapid1 = get_request('ldapid1',1,0);
		$ldapid2 = get_request('ldapid2',1,0);
		$levelx = get_request('levelx',1,0);
		$levex=0;
		if(empty($new_name)){
			alert_and_back('请输入名称');
			exit;
		}
		$admingroup = $this->sgroup_set->select_by_id($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? $_SESSION['ADMIN_MSERVERGROUP'] : 0);
		if($admingroup&&$admingroup['level']==0){
			alert_and_back('您没有权限创建组');
			exit;
		}
		if(0 == $this->usergroup_set->select_count("groupname = '$new_name' and id!='$id'")) {
			$new_group = new usergroup();
			$new_group->set_data('groupname',$new_name);
			$new_group->set_data('loadbalance',$loadbalance);
			$new_group->set_data('description',$description);
			$new_group->set_data('level',0);
			if($ldapid2){				
				$new_group->set_data('ldapid',$ldapid2);
			}elseif($ldapid1){
				$new_group->set_data('level',0);
				$new_group->set_data('ldapid',$ldapid1);
			}else{
				$new_group->set_data('level',0);
				$new_group->set_data('ldapid',0);
			}
			if($id){
				$new_group->set_data('id',$id);
				$this->usergroup_set->edit($new_group);
				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('编辑资源组'));
				$adminlog->set_data('resource', '用户'.($levex ? '目录' : '组').':'.$new_name);
				$adminlog->set_data('type', 12);		
				$this->admin_log_set->add($adminlog);
				alert_and_back('编辑成功','admin.php?controller=admin_member&action=usergroup&ldapid='.$ldapid);
				exit;
			}else{
				$this->usergroup_set->add($new_group);
				$adminlog = new admin_log();	
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);			
				$adminlog->set_data('action', language('添加资源组'));
				$adminlog->set_data('resource', '用户'.($levex ? '目录' : '组').':'.$new_name);
				$adminlog->set_data('type', 12);
				$this->admin_log_set->add($adminlog);
				echo '<script language=\'javascript\'>alert(\'成功添加\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=usergroup&ldapid='.$ldapid.'";</script>';
				//alert_and_back('添加成功','admin.php?controller=admin_member&action=usergroup&ldapid='.$ldapid);
				exit;
			}
			
		}
		else {
				alert_and_back('添加失败,该设备组已存在','admin.php?controller=admin_member&action=usergroup');
		}
	}
	
	function addgroup(){
		$gname = get_request("gname", 1, 1);
		if(empty($gname)){
			alert_and_back('请输入组名');
			exit;
		}
		$allgp = $this->usergroup_set->select_all('groupname="'.$gname.'"');
		if(!empty($allgp)){
			alert_and_back('该组名已经存在');
			exit;
		}
		
		$group = new usergroup();
		$group->set_data('groupname', $gname);
		$this->usergroup_set->add($group);
		alert_and_back('添加成功');
	}
	
	function delete_usergroup(){
		$gid = get_request("id");
		$this->usergroup_set->delete($gid);
		$this->lgroup_set->query("DELETE FROM lgroup WHERE groupid=".$gid);
		$this->lgroup_set->query("DELETE FROM lgroup_devgrp WHERE groupid=".$gid);
		alert_and_back('删除成功','admin.php?controller=admin_member&action=usergroup');
	}
	
	function delete_user_from_group(){
		$uid = get_request("uid");
		$member = new member();
		$member->set_data('uid', $uid);
		$member->set_data('groupid', 0);
		$this->member_set->edit($member);
		alert_and_back('删除成功');
	}
	
	function groupuser(){
		$gid = get_request("gid");
		$page_num = get_request('page');
		$where = ' groupid='.$gid;
		$row_num = $this->member_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$allmember = $this->member_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where, 'username', "ASC");
		$this->assign("gid", $gid);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);		
		$this->assign('allmember', $allmember);
		$this->display('groupuser.tpl');
	}
	
	function groupadduser(){
		$gid = get_request("gid");
		$allmember = $this->member_set->select_all(' uid NOT IN (SELECT uid FROM '.$this->member_set->get_table_name().' WHERE groupid='.$gid.') and level!=1 and level!=3 and level!=2 and level!=10');
		$this->assign("gid", $gid);
		$this->assign("title", language("增加用户"));
		$this->assign("allmember", $allmember);
		$this->display('groupadduser.tpl');
	}
	
	function groupadduser_save(){
		$gid = get_request("gid");
		$this->member_set->query("UPDATE ".$this->member_set->get_table_name()." SET groupid=".$gid." WHERE uid IN (".implode(',', $_POST['uid']).")");
		alert_and_back('添加成功','admin.php?controller=admin_member&action=groupuser&gid='.$gid);
	}
	
	
	
	function weektime(){
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'policyname';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = '1=1';
		if($_SESSION['ADMIN_LEVEL']!=1){
			$where .= " AND creatorid=".$_SESSION['ADMIN_UID'];
		}
		if($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			$where .= ' AND creatorid IN(SELECT uid FROM member WHERE mservergroup IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))';
		}
		$row_num = $this->weektime_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$weektime = $this->weektime_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$this->assign('title', language('周组策略列表'));
		$this->assign('weektime', $weektime);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('weektime.tpl');
	}
	
	function weektime_edit(){
		$sid = get_request("sid");
		$wt = $this->weektime_set->select_by_id($sid);
		$wt['start_time1']=substr($wt['start_time1'], 0, 5);
		$wt['end_time1']=substr($wt['end_time1'], 0, 5);
		$wt['start_time2']=substr($wt['start_time2'], 0, 5);
		$wt['end_time2']=substr($wt['end_time2'], 0, 5);
		$wt['start_time3']=substr($wt['start_time3'], 0, 5);
		$wt['end_time3']=substr($wt['end_time3'], 0, 5);
		$wt['start_time4']=substr($wt['start_time4'], 0, 5);
		$wt['end_time4']=substr($wt['end_time4'], 0, 5);
		$wt['start_time5']=substr($wt['start_time5'], 0, 5);
		$wt['end_time5']=substr($wt['end_time5'], 0, 5);
		$wt['start_time6']=substr($wt['start_time6'], 0, 5);
		$wt['end_time6']=substr($wt['end_time6'], 0, 5);
		$wt['start_time7']=substr($wt['start_time7'], 0, 5);
		$wt['end_time7']=substr($wt['end_time7'], 0, 5);
		$this->assign("title", language('添加周组策略'));
		$this->assign("wt", $wt);
		$this->display('weektime_edit.tpl');
	}
	
	function delete_weektime(){
		$sid = get_request("sid");
		$weektime = $this->weektime_set->select_by_id($sid);
		$a = $this->weektime_set->base_select("select sum(num) b FROM (SELECT count(*) as num FROM luser where weektime='".$weektime['policyname']."' 
		UNION SELECT count(*) as num FROM lgroup where weektime='".$weektime['policyname']."' 
		UNION SELECT count(*) as num FROM luser_devgrp where weektime='".$weektime['policyname']."' 
		UNION SELECT count(*) as num FROM luser where weektime='".$weektime['policyname']."') t");
		if($a[0]['b']>0){
			alert_and_back('该策略已被绑定,不能删除');
			exit;
		}
		$this->weektime_set->delete($sid);
		alert_and_back('删除成功','admin.php?controller=admin_member&action=weektime');
	}
	
	function weektime_save(){
		$sid = get_request("sid");
		$policyname = get_request("policyname", 1, 1);
		$s1 = get_request("start1", 1, 1);
		$e1 = get_request("end1", 1, 1);
		$s2 = get_request("start2", 1, 1);
		$e2 = get_request("end2", 1, 1);
		$s3 = get_request("start3", 1, 1);
		$e3 = get_request("end3", 1, 1);
		$s4 = get_request("start4", 1, 1);
		$e4 = get_request("end4", 1, 1);
		$s5 = get_request("start5", 1, 1);
		$e5 = get_request("end5", 1, 1);
		$s6 = get_request("start6", 1, 1);
		$e6 = get_request("end6", 1, 1);
		$s7 = get_request("start7", 1, 1);
		$e7 = get_request("end7", 1, 1);
		if(empty($s1)||empty($e1)||empty($s2)||empty($e2)||empty($s3)||empty($e3)||empty($s4)||empty($e4)||empty($s5)||empty($e5)||empty($s6)||empty($e6)||empty($s7)||empty($e7)){
			alert_and_back('请填写完整');
			exit;
		}
		
		$weektime = $this->weektime_set->select_by_id($sid);
		$a = $this->weektime_set->base_select("select sum(num) b FROM (SELECT count(*) as num FROM luser where weektime='".$weektime['policyname']."' 
		UNION SELECT count(*) as num FROM lgroup where weektime='".$weektime['policyname']."' 
		UNION SELECT count(*) as num FROM luser_devgrp where weektime='".$weektime['policyname']."' 
		UNION SELECT count(*) as num FROM luser where weektime='".$weektime['policyname']."') t");
		if($sid&&$policyname!=$weektime['policyname']&&$a[0]['b']>0){
			alert_and_back('该策略已被绑定,不能改名');
			exit;
		}
		
		$allgp = $this->weektime_set->select_all('policyname="'.$policyname.'" and sid!='.$sid);
		if(!empty($allgp)){
			alert_and_back('该策略名已经存在');
			exit;
		}
		
		$weektime = new weektime();
		$weektime->set_data('policyname', $policyname);
		$weektime->set_data('start_time1', $s1);
		$weektime->set_data('end_time1', $e1);
		$weektime->set_data('start_time2', $s2);
		$weektime->set_data('end_time2', $e2);
		$weektime->set_data('start_time3', $s3);
		$weektime->set_data('end_time3', $e3);
		$weektime->set_data('start_time4', $s4);
		$weektime->set_data('end_time4', $e4);
		$weektime->set_data('start_time5', $s5);
		$weektime->set_data('end_time5', $e5);
		$weektime->set_data('start_time6', $s6);
		$weektime->set_data('end_time6', $e6);
		$weektime->set_data('start_time7', $s7);
		$weektime->set_data('end_time7', $e7);
		$weektime->set_data('creatorid', $_SESSION['ADMIN_UID']);
		if($sid){
			$weektime->set_data("sid", $sid);
			$this->weektime_set->edit($weektime);
			alert_and_back('修改成功','admin.php?controller=admin_member&action=weektime');
			exit;
		}
		
		$this->weektime_set->add($weektime);
		alert_and_back('添加成功','admin.php?controller=admin_member&action=weektime');
	}

	
	
	function loginlock() {
		$enable = get_request('enable', 0, 0);
		$uid = get_request('uid');
		if($uid){
			$userinfo = $this->member_set->select_by_id($uid);
			if($userinfo['username'] == 'admin'){
				alert_and_back('管理员不允许被锁');
				exit;
			}
			$member = new member();
			$member->set_data('uid', $uid);
			$member->set_data('enable', ($enable ? 0 : 1));
			$member->set_data('logintimes', 0);
			$member->set_data('loginlock', ($enable ? 1 : 0));
			$this->member_set->edit($member);
		}else{			
			$uid = get_request('chk_member', 1, 1);
			if($uid){
				$this->member_set->query("update member set enable=0 where uid IN(".implode(',', $uid).") and username!='admin'");
			}
		}
		if($_GET['frombatchpriorityedit']){
			alert_and_back('成功锁定用户','admin.php?controller=admin_member&action=batchpriorityedit');
			exit;
		}
		alert_and_back('操作成功');
	}
	


	function delete() {
		global $_CONFIG;
		$uid = get_request('uid');
		$user = $this->member_set->select_by_id($uid);
		if($user['level']==11){
			$bindusers = $this->devpass_set->select_all("radiususer=".$uid);
			for($i=0; $i<count($bindusers); $i++){
				$bindip[]=$bindusers[$i]['device_ip'];
			}
			if(count($bindip)>0){
				alert_and_back('该用户已被下列ip绑定:\n'.implode('\n',$bindip), 'admin.php?controller=admin_member&action=radiususer');
				return ;
			}
		}
		
		$out = "";
		if($user['level'] == 0) {
			command("who | grep ".$user['username'],$out);
			if(count($out)<1 || $out == "" || 1) {
				if($user['username']=='password'){
					$cmd = "sudo /usr/sbin/userdel -r " . $user['username'];
					//echo $cmd;
					command($cmd, $out);	
				}
				$this->radius_set->delete($user['username'],'username');
				$this->member_set->delete($uid);
				$this->sgroup_set->updatem(null, $user['groupid']);
				if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
					$this->sgroupcache_set->updatem(null, $user['groupid']);
				}
				/*$_gp = array();
				$_g = $this->sgroup_set->select_by_id($user['groupid']);
				$_gp[]=$_g['id'];
				while($_g['ldapid']){
					$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
					$_gp[]=$_g['id'];
				}
				$this->member_set->query("UPDATE servergroup set mcount=mcount-1 where id in(".implode(',', $_gp).")");
				*/
				$this->luser_set->delete_all(' memberid='.$uid);
				$this->luser_resourcegrp_set->delete_all(' memberid='.$uid);
				/*
				$keys = $this->keys_set->select_all("UserName = '$user[username]'");
				$this->usbkey_set->release($keys[0]['pc_id']);
				$this->usbkey_set->remove($keys[0][pc_id]);
				*/
				$adminlog = new admin_log();
				$adminlog->set_data('luser', $user['username']);
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('action', language('删除运维用户'));
				$adminlog->set_data('type', 11);
				$this->admin_log_set->add($adminlog);
				$radius = $this->radius_set->select_all("UserName='".$user['username']."'");
				for($i=0; $i<count($radius); $i++){
					$rid[]=$radius[$i]['id'];
				}
				if($rid){
					$this->radius_set->delete($rid);
				}
				$this->luser_set->query("DELETE FROM radcheck WHERE username='".$user['username']."'");		
				$this->luser_set->query("DELETE FROM radreply WHERE UserName='".$user['username']."'");				
				$this->luser_set->query("DELETE FROM luser WHERE memberid=".$user['uid']);
				$this->luser_set->query("DELETE FROM luser_devgrp WHERE memberid=".$user['uid']);
				$this->sgroup_set->query("UPDATE ".$this->sgroup_set->get_table_name()." a SET mcount=(SELECT count(*) FROM ".$this->member_set->get_table_name()." WHERE groupid=a.id)");

				if($user['level']==11){
					echo '<script language=\'javascript\'>alert(\'成功删除用户'.'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=radiusmember&gid='.$gid.'";</script>';
					//alert_and_back('成功删除用户', 'admin.php?controller=admin_member&action=radiususer');
					//exit;
				}else{
					echo '<script language=\'javascript\'>alert(\'成功删除用户'.'\');window.parent.menu.location="admin.php?controller=admin_index&action=menu&actions=member&gid='.$gid.'";</script>';
					//alert_and_back('成功删除用户', 'admin.php?controller=admin_member');
					//exit;
				}
			}
			else {
				if($user['level']==11){
					alert_and_back('用户还在线,无法删除', 'admin.php?controller=admin_member&action=radiususer');
					//exit;
				}else{
					alert_and_back('用户还在线,无法删除', 'admin.php?controller=admin_member');
					//exit;
				}
			}
		}
		else {
				$this->member_set->delete($uid);				
				$this->luser_set->query("DELETE FROM radcheck WHERE username='".$user['username']."'");		
				$this->luser_set->query("DELETE FROM radreply WHERE UserName='".$user['username']."'");	
				$adminlog = new admin_log();
				$adminlog->set_data('luser', $user['username']);
				$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
				$adminlog->set_data('action', language('删除运维用户'));
				$adminlog->set_data('type', 11);
				$this->admin_log_set->add($adminlog);
				$this->sgroup_set->updatem(null, $user['groupid']);
				if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
					$this->sgroupcache_set->updatem(null, $user['groupid']);
				}
				if($user['level']==11){					
					$this->uattr_set->delete_all("username = '".$user['username']."' ");
					alert_and_back('成功删除用户', 'admin.php?controller=admin_member&action=radiususer');
					//exit;
				}else{
					alert_and_back('成功删除用户', 'admin.php?controller=admin_member');
					//exit;
				}
		}
	}
	
	function save_self() {
		global $_CONFIG;
		$newmember = new member();
		$oripassword = htmlspecialchars_decode(get_request('oripassword', 1, 1));
		$password1 = htmlspecialchars_decode(get_request('password1', 1, 1));
		$password2 = htmlspecialchars_decode(get_request('password2', 1, 1));
		$default_control = get_request('default_control', 1, 0);
		$ldap = get_request('ldap', 1, 0);
		$rdp_screen = get_request('rdp_screen', 1, 0);
		$login_tip = get_request('login_tip', 1, 0);
		$rdpdisk = get_request('rdpdisk', 1, 1);
		$appdelay = get_request('appdelay', 1, 1);
		$searchcache = get_request('searchcache', 1, 0);
		$rows = intval(get_request('rows', 1, 0));
		$crttab = get_request('crttab', 1, 0);
		$email = get_request('email', 1, 1);
		$firstauth = get_request('firstauth', 1, 1);
		$sshport = get_request('sshport', 1, 0);
		$rdpport = get_request('rdpport', 1, 0);
		
		$uid = $_SESSION['ADMIN_UID'];
		$user = $this->member_set->select_by_id($uid);
		$newmember->set_data('uid',$uid);		
		$newmember->set_data('rdp_screen', $rdp_screen);
		$newmember->set_data('searchcache', $searchcache);
		$newmember->set_data('login_tip', $login_tip);
		$newmember->set_data('appdelay', $appdelay);
		$newmember->set_data('firstauth', $firstauth);
		$newmember->set_data('crttab', $crttab);
		$newmember->set_data('sshport', $sshport);
		$newmember->set_data('rdpport', $rdpport);

		if($email&&!is_email($email)){
			alert_and_back('Email格式不正确');
			exit();
		}
							
		if(!($password1 == "" && $password2 == "")) {
			
			$config = $this->setting_set->select_all(" sname='password_policy'");
			//var_dump($config);
			$pwdconfig = unserialize($config[0]['svalue']);

			if($password1){
				$passlog = $this->passwordlog_set->select_limit(0, intval($pwdconfig['oldpassnumber']), " uid='$uid' and password=md5('$password1')", 'time','DESC');
				if(count($passlog)>0){
					alert_and_back('改密码已经使用过,请重新选择');
					exit();
				}
			}

			$reg = '';
			//var_dump($pwdconfig);var_dump($password1);
			$pwdmsg = '';
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
			if(strlen($password1) < $pwdconfig['login_pwd_length']){
				//alert_and_back(language('密码最少长度为').$pwdconfig['login_pwd_length']);
				//exit();
				$pwdmsgl = language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 ';
			}

			$pwd_ban_word_arr = explode('1', $_CONFIG['PASSWORD_BAN_WORD']);			
			if($pwd_ban_word_arr){
				$pwd_ban_word_str = implode(' ', $pwd_ban_word_arr);
			}
			for($pi=0; $pi<count($pwd_ban_word_arr); $pi++){
				if($pwd_ban_word_arr[$pi]&&strpos($password1, $pwd_ban_word_arr[$pi])!==false){
					$pwdmsg2='密码中不能包含以下字符:'.addslashes(str_replace('  ', '空格', $pwd_ban_word_str)).' \n请重新输入';
					break;
				}
			}
			if(!empty($pwdmsg) || !empty($pwdmsgl) || !empty($pwdmsg2) || !empty($pwdmsg3)){
				$pwdmsgs .= $pwdmsg3;
				if($pwdconfig['pwdstrong1'] || $pwdconfig['pwdstrong2'] || $pwdconfig['pwdstrong3'] || $pwdconfig['pwdstrong4']){
					$pwdmsgs .= '密码中需要包含:' .  ($pwdconfig['pwdstrong1'] ? $pwdconfig['pwdstrong1'].'个数字' : '').($pwdconfig['pwdstrong2'] ? $pwdconfig['pwdstrong2'].'个小写字母' : '').($pwdconfig['pwdstrong3'] ? $pwdconfig['pwdstrong3'].'个大写字母' : '').($pwdconfig['pwdstrong4'] ? $pwdconfig['pwdstrong4'].'个特殊字符' : ''). "\\n";
				}
				$pwdmsgs .= language('密码最少长度为').$pwdconfig['login_pwd_length'].'位 '."\\n";
				if(count($pwd_ban_word_str)>0){
					$pwdmsgs .= '密码中不能包含以下字符:'.addslashes(str_replace('  ', '空格', $pwd_ban_word_str)).' \n\n请重新输入';
				}
				alert_and_back($pwdmsgs);
				exit;
			}

			if($oripassword!=$this->member_set->udf_decrypt($user['password'])){
				alert_and_back('原密码不正确');
				exit();
			}
			if($oripassword==$password1){
				alert_and_back('不能与原密码相同');
				exit();
			}else{				
				$newmember->set_data('forceeditpassword', 0);
			}
			if($password1 == $password2) {
				if($_CONFIG['crypt']==1){
					$password1 = encrypt($password1);
				}
				$newmember->set_data('password', $this->member_set->udf_encrypt($password1));
				$newmember->set_data('lastdateChpwd', time());
				$this->devpass_set->query("UPDATE ".$this->devpass_set->get_table_name()." SET old_password=cur_password,cur_password='".$this->devpass_set->udf_encrypt('"'.$password1.'"')."' WHERE username='".$user['username']."' AND radiususer=".$uid);

				$whereappserverip = '1';
				if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
					$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
					$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
					$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." )";
					$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." )";	
					$appservers = $this->appmember_set->base_select("SELECT device_ip appserverip,hostname FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ($sql) dd ON d.id=dd.devicesid  WHERE dd.devicesid IS NOT NULL AND login_method=26 GROUP BY device_ip", 'hostname', 'asc');
					$_appservers = array(0);
					for($i=0; $i<count($appservers); $i++){
						$_appservers[]=$appservers[$i]['appserverip'];
					}
					$whereappserverip .= " AND appserverip IN('".implode("','", $_appservers)."')";
				}
				if($_CONFIG['Async']&&$user['level']!=11){
					$appservers = $this->appserver_set->select_all($whereappserverip);
					for($i=0; $i<count($appservers); $i++){
						$cmd = "async ".$appservers[$i]['appserverip']." 8888 ".$_SESSION['ADMIN_USERNAME']." 1";
						//echo '<br />';
						asyncAccount($cmd);
					}
				}
				
				$passwordlog = new passwordlog();
				$passwordlog->set_data('uid', $uid);
				$passwordlog->set_data('password', md5($password1));
				$passwordlog->set_data('time', time());
				$this->passwordlog_set->add($passwordlog);
				if($pwdconfig['oldpassnumber']&&($cpnum=$this->passwordlog_set->select_count("uid=".$passwordlog->get_data('uid')))>$pwdconfig['oldpassnumber']){
					$this->passwordlog_set->query("DELETE FROM ".$this->passwordlog_set->get_table_name()." WHERE uid=$uid ORDER BY id ASC LIMIT ".($cpnum-$pwdconfig['oldpassnumber']));
				}
			}
			else {
				alert_and_back('两次输入的密码不一致');
				exit();
			}

			
		}
		$newmember->set_data('email', $email);
		$newmember->set_data('default_control', $default_control);
		$newmember->set_data('rdpdisk', $rdpdisk);
		
		
		//if($user['level'] == 0 || $_CONFIG["OTHER_MEMBER_RADIUS"]==1) 
		{
			$old_radius = $this->radius_set->select_all("UserName = '".$user['username']."'");
			$new_radius = new radius();
			$new_radius->set_data("id",$old_radius[0]['id']);
			$new_radius->set_data("email",$user['email']);
			if($newmember->get_data('password') != '') {
				$new_radius->set_data("Value",crypt($password1,"\$1\$qY9g/6K4"));
			}						
			$this->radius_set->edit($new_radius);
			

			//$cmd = "echo \"".$password1."\" | sudo passwd --stdin " . $user['username'];
			//echo $cmd;
			//command($cmd, $out);	
		}

		$url =  'admin.php?controller=admin_session&action=index';
		if($_SESSION['ADMIN_LEVEL']==10){
			$url = 'admin.php?controller=admin_index&action=main';
		}elseif($_SESSION['ADMIN_LEVEL']==0){
			$url = 'admin.php?controller=admin_index&action=main';
		}
		
		$newmember->set_data('sshprivatekey', $sshprivatekey);
		$newmember->set_data('sshpublickey', $sshpublickey);

		if($newmember->get_errnum() == 0) {
			

			switch($default_control){
				case 0:
					$default_controls = (strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')||(!strpos($_SERVER['HTTP_USER_AGENT'],'Firefox')&&!strpos($_SERVER['HTTP_USER_AGENT'],'Chrome')&&!strpos($_SERVER['HTTP_USER_AGENT'],'Safari')&&!strpos($_SERVER['HTTP_USER_AGENT'],'Opera')&&!strpos($_SERVER['HTTP_USER_AGENT'],'Opera'))) ? 'activeX' : 'applet';
					break;
				case 1:
					$default_controls = 'applet';
					break;
				case 2:
					$default_controls = 'activeX';
					break;
			}
			$_SESSION['ADMIN_DEFAULT_CONTROL'] = $default_controls;

			$this->member_set->edit($newmember);
			if($searchcache){
				require_once 'controller/c_admin_index.class.php';
				$index = new c_admin_index();
				$index->init($this->smarty, $this->config);
				$index->do_devices_cache(1);
			}
			//exit;
			if($user['level'] == 0) {
				alert_and_back('成功编辑个人信息','admin.php?controller=admin_index',0,1);
			}else{
				alert_and_back('成功编辑个人信息','admin.php?controller=admin_index',0,1);
			}
		}
	}
	
	function delete_all() {
		global $_CONFIG;
		$uid = get_request('chk_member', 1, 1);
		$usernames = $this->member_set->select_all(" uid IN (".implode(',', $uid).")");
		
		for($i=0; $i<count($usernames); $i++){
			$usernames_u[]=$usernames[$i]['username'];
			$this->sgroup_set->updatem(null, $usernames[$i]['groupid']);
			if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
				$this->sgroupcache_set->updatem(null, $usernames[$i]['groupid']);
			}
		}
		if($usernames_u){
			$radius = $this->radius_set->select_all("UserName IN ('".implode("','",$usernames_u)."')");
			
			$this->luser_set->query("DELETE FROM radcheck WHERE username  IN ('".implode("','",$usernames_u)."')");		
			$this->luser_set->query("DELETE FROM radreply WHERE UserName  IN ('".implode("','",$usernames_u)."')");	
			for($i=0; $i<count($radius); $i++){
				$rid[]=$radius[$i]['id'];
			}
			if($rid){
				$this->radius_set->delete($rid);
			}

			$this->member_set->delete($uid);			
			
			$adminlog = new admin_log();
			$adminlog->set_data('luser', implode(',', $usernames_u));
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('action', '删除运维用户');
			$adminlog->set_data('type', 11);
			$this->admin_log_set->add($adminlog);
		}
		if($_GET['frombatchpriorityedit']){
			alert_and_back('成功删除用户','admin.php?controller=admin_member&action=batchpriorityedit');
			exit;
		}
		alert_and_back('成功删除用户');
	}

	function update_user() {
		$out = '';
		command("cat /etc/passwd |cut -f 1 -d :", $out);
		$allpasswd = explode("\n", $out);
		return $allpasswd;
		
	}

	function protect_dev() {
		$uid = get_request('uid');
		$g_id = get_request('g_id');
		$type = get_request('type', 0, 1);
		if($type=='group'){
			$group = $this->usergroup_set->select_by_id($uid);	
			$this->assign('grouporuser',language('组名'));
			$this->assign('name',$group['GroupName']);
			$sql .= " SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$uid;
			//$sql .= " UNION SELECT id FROM ".$this->devpass_set->get_table_name()." WHERE device_ip IN (SELECT b.device_ip FROM ".$this->lgroup_devgrp_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.serversid=b.groupid WHERE a.groupid=".$uid.")";

		}else{
			$member = $this->member_set->select_by_id($uid);	
			$this->assign('grouporuser',language('用户名'));		
			$this->assign('name',$member['username']);
			$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$uid;
			//$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".(int)$member['groupid'];
			//$sql .= " UNION SELECT id FROM ".$this->devpass_set->get_table_name()." WHERE device_ip IN (SELECT b.device_ip FROM ".$this->luser_devgrp_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.serversid=b.groupid WHERE  a.memberid=".$uid.")";
			//$sql .= " UNION SELECT id FROM ".$this->devpass_set->get_table_name()." WHERE device_ip IN (SELECT b.device_ip FROM ".$this->lgroup_devgrp_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.serversid=b.groupid WHERE a.groupid=".(int)$member['groupid'].")";
	
		}
		$alldev = $this->server_set->select_all("groupid = $g_id");
		if(count($alldev) == 0) {
			alert_and_back('该设备组没有设备',"admin.php?controller=admin_member&action=protect_group&uid=$uid");
			exit(0);
		}
			
		$allpass = $this->devpass_set->select_all(" id in (".$sql.")");
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
		$this->assign('id',$uid);
		$this->assign('g_id',$g_id);
		$this->assign('s_dev',$s_dev);
		$this->assign('alldev',$alldev);
		$this->assign('type', $type);
		$this->assign('allpass',$allpass);
		$this->display('dev_user1.tpl');
	}

	function protect_group() {
		
		$type = get_request('type', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);

		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$alldevgroup = $this->sgroup_set->select_all(($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? 'id=(SELECT mservergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : '1=1'), 'groupname', 'asc');
		if($type!='group'){
			$id = get_request('uid');
			$user = $this->member_set->select_by_id($id);
			$this->assign('username',$user['username']);
			$tpl = 'dev_group_user.tpl';
			$sql = "SELECT d.*,u.memberid,u.weektime,u.sourceip,u.forbidden_commands_groups,u.id AS lid FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ".$this->luser_set->get_table_name()." u ON d.id=u.devicesid WHERE u.memberid=$id ORDER BY $orderby1 $orderby2";
		}else{			
			$id = get_request('gid');
			$group = $this->usergroup_set->select_by_id($id);
			$this->assign('groupname',$group['GroupName']);
			$tpl = 'dev_group_group.tpl';
			$sql = "SELECT d.*,u.groupid,u.weektime,u.sourceip,u.forbidden_commands_groups,u.id AS lid FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ".$this->lgroup_set->get_table_name()." u ON d.id=u.devicesid WHERE u.groupid=$id ORDER BY $orderby1 $orderby2";
		}
		
		$allpass = $this->devpass_set->base_select($sql);
		
		$s_dev = array();
		$alltem = $this->tem_set->select_all();
		$allweektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$fcg = $this->forbiddengps_set->select_all('1=1', 'black_or_white','asc');
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
			if(empty($allpass[$ii]['weektime'])){
				$allpass[$ii]['weektime'] = '';
			}
			if(empty($allpass[$ii]['sourceip'])){
				$allpass[$ii]['sourceip'] = '';
			}
			if(empty($allpass[$ii]['forbidden_commands_groups'])){
				$allpass[$ii]['forbidden_commands_groups'] = '';
			}
		}
		$this->assign('title',language('选择要绑定的设备'));
		$this->assign('id',$id);
		$this->assign("type", $type);
		$this->assign('s_dev',$s_dev);
		$this->assign('alldevgroup',$alldevgroup);
		$this->assign('allpass',$allpass);
		$this->display($tpl);
	}
	
	function protect_group_devgrp() {
		$gid = get_request('gid');
		$type = get_request('type', 0, 1);
		
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

		$group = $this->usergroup_set->select_by_id($gid);
		$sql = "SELECT s.*,u.groupid,u.weektime,u.sourceip,u.forbidden_commands_groups,u.id lgid FROM ".$this->sgroup_set->get_table_name()." s LEFT JOIN ".$this->lgroup_devgrp_set->get_table_name()." u ON s.id=u.serversid WHERE u.groupid=$gid ORDER BY $orderby1 $orderby2";

		$allpass = $this->sgroup_set->base_select($sql);
		$allweektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$fcg = $this->forbiddengps_set->select_all('1=1', 'black_or_white','asc');
		
		$num = count($allpass);
		for($ii=0; $ii<$num; $ii++){
			if(empty($allpass[$ii]['weektime'])){
				$allpass[$ii]['weektime'] = '';
			}else
			foreach($allweektime as $tem) {			
				if($allpass[$ii]['weektime'] == $tem['sid']) {
					$allpass[$ii]['weektime'] = $tem['policyname'];
				}
					
			}
			if(empty($allpass[$ii]['sourceip'])){
				$allpass[$ii]['sourceip'] = '';
			}
			if(empty($allpass[$ii]['forbidden_commands_groups'])){
				$allpass[$ii]['forbidden_commands_groups'] = '';
			}
		}
		$this->assign('title',language('选择要绑定的设备'));
		$this->assign('gid',$gid);
		$this->assign('groupname',$group['GroupName']);
		$this->assign('allpass',$allpass);
		$this->display('dev_group_sgroup.tpl');
	}

	function protect_group_resgrp() {
		$gid = get_request('gid');
		$type = get_request('type', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		$group = $this->usergroup_set->select_by_id($gid);
		$sql = "SELECT s.*,u.groupid,u.weektime,u.sourceip,u.forbidden_commands_groups,u.id lgid FROM ".$this->resgroup_set->get_table_name()." s LEFT JOIN ".$this->lgroup_resourcegrp_set->get_table_name()." u ON s.id=u.resourceid WHERE u.groupid=$gid  ORDER BY $orderby1 $orderby2";

		$allpass = $this->sgroup_set->base_select($sql);
		$allweektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$fcg = $this->forbiddengps_set->select_all('1=1', 'black_or_white','asc');
		
		$num = count($allpass);
		for($ii=0; $ii<$num; $ii++){
			if(empty($allpass[$ii]['weektime'])){
				$allpass[$ii]['weektime'] = '';
			}else
			foreach($allweektime as $tem) {			
				if($allpass[$ii]['weektime'] == $tem['sid']) {
					$allpass[$ii]['weektime'] = $tem['policyname'];
				}
					
			}
			if(empty($allpass[$ii]['sourceip'])){
				$allpass[$ii]['sourceip'] = '';
			}
			if(empty($allpass[$ii]['forbidden_commands_groups'])){
				$allpass[$ii]['forbidden_commands_groups'] = '';
			}
		}
		$this->assign('title',language('选择要绑定的设备'));
		$this->assign('gid',$gid);
		$this->assign('groupname',$group['GroupName']);
		$this->assign('allpass',$allpass);
		$this->display('res_group_sgroup.tpl');
	}
	
	function protect_user_devgrp() {
		$uid = get_request('uid');
		$type = get_request('type', 0, 1);
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

		$member = $this->member_set->select_by_id($uid);
		$sql = "SELECT s.*,u.weektime,u.sourceip,u.forbidden_commands_groups,u.id lgid FROM ".$this->sgroup_set->get_table_name()." s LEFT JOIN ".$this->luser_devgrp_set->get_table_name()." u ON s.id=u.serversid WHERE u.memberid=$uid ORDER BY $orderby1 $orderby2";
		
		$allpass = $this->sgroup_set->base_select($sql);
		$allweektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$fcg = $this->forbiddengps_set->select_all('1=1', 'black_or_white','asc');
		
		$num = count($allpass);
		for($ii=0; $ii<$num; $ii++){
		if(empty($allpass[$ii]['weektime'])){
			$allpass[$ii]['weektime'] = '';
		}
		if(empty($allpass[$ii]['sourceip'])){
			$allpass[$ii]['sourceip'] = '';
		}
		if(empty($allpass[$ii]['forbidden_commands_groups'])){
			$allpass[$ii]['forbidden_commands_groups'] = '';
		}
		}
		$this->assign('title',language('选择要绑定的设备'));
		$this->assign('uid',$uid);
		$this->assign('username',$member['username']);
		$this->assign('allpass',$allpass);
		$this->display('dev_user_devgrp.tpl');
	}

	function protect_user_resgrp() {
		$uid = get_request('uid');
		$type = get_request('type', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);

		if(empty($orderby1)){
			$orderby1 = 'u.id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		if($orderby1=='groupname'){
			$orderby1='s.'.$orderby1;
		}
		$this->assign("orderby2", $orderby2);
		$member = $this->member_set->select_by_id($uid);
		$sql = "SELECT s.groupname,u.weektime,u.sourceip,u.forbidden_commands_groups,u.id lgid FROM ".$this->resgroup_set->get_table_name()." s LEFT JOIN ".$this->luser_resourcegrp_set->get_table_name()." u ON s.id=u.resourceid WHERE u.memberid=$uid ORDER BY $orderby1 $orderby2";
		
		$allpass = $this->resgroup_set->base_select($sql);
		$allweektime = $this->weektime_set->select_all();
		$sourceip = $this->sourceip_set->select_all(" sourceip=''");
		$fcg = $this->forbiddengps_set->select_all('1=1', 'black_or_white','asc');
		
		$num = count($allpass);
		for($ii=0; $ii<$num; $ii++){
		if(empty($allpass[$ii]['weektime'])){
			$allpass[$ii]['weektime'] = '';
		}
		if(empty($allpass[$ii]['sourceip'])){
			$allpass[$ii]['sourceip'] = '';
		}
		if(empty($allpass[$ii]['forbidden_commands_groups'])){
			$allpass[$ii]['forbidden_commands_groups'] = '';
		}
		}
		$this->assign('title',language('选择要绑定的设备'));
		$this->assign('uid',$uid);
		$this->assign('username',$member['username']);
		$this->assign('allpass',$allpass);
		$this->display('dev_user_resgrp.tpl');
	}
	
	function protect_user_edit(){
		$uid = get_request("uid");
		$sessionluser = 'PROTECTGROUP_LUSER';
		$member = $this->member_set->select_by_id($uid);
		$alldevgroup = $this->sgroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? 'id=(SELECT mservergroup FROM member WHERE uid='.$_SESSION['ADMIN_UID'].')' : '1=1'), 'groupname', 'ASC');
		$lgroup = $this->luser_devgrp_set->select_all(' memberid='.$uid);
		for($i=0; $i<count($alldevgroup); $i++){
			for($j=0; $j<count($lgroup); $j++){
				if($alldevgroup[$i]['id']==$lgroup[$j]['serversid']&&$lgroup[$j]['memberid']==$uid){
					$alldevgroup[$i]['check']='checked';
				}
			}			
		}
		//echo '<pre>';print_r($alldevgroup);echo '</pre>';
		//echo '<pre>';print_r($lgroup);echo '</pre>';
		$_SESSION[$sessionluser] = $lgroup;
		$this->assign("uid", $uid);
		$this->assign("member", $member);
		$this->assign('sessionluser', $sessionluser);
		$this->assign('alldevgroup', $alldevgroup);
		$this->display('dev_select_userdevgrp.tpl');
	}

	function protect_user_resgrp_edit(){
		$uid = get_request("uid");
		$sessionluser = 'PROTECTGROUP_LUSER_RESOURCEGRP';
		$member = $this->member_set->select_by_id($uid);
		$alldevgroup = $this->resgroup_set->select_all('devicesid=0', 'groupname', 'ASC');
		$lgroup = $this->luser_resourcegrp_set->select_all(' memberid='.$uid);
		for($i=0; $i<count($alldevgroup); $i++){
			for($j=0; $j<count($lgroup); $j++){
				if($alldevgroup[$i]['id']==$lgroup[$j]['resourceid']&&$lgroup[$j]['memberid']==$uid){
					$alldevgroup[$i]['check']='checked';
				}
			}			
		}
		//echo '<pre>';print_r($alldevgroup);echo '</pre>';
		//echo '<pre>';print_r($lgroup);echo '</pre>';
		$_SESSION[$sessionluser] = $lgroup;
		$this->assign("uid", $uid);
		$this->assign("member", $member);
		$this->assign('sessionluser', $sessionluser);
		$this->assign('alldevgroup', $alldevgroup);
		$this->display('dev_select_userresgrp.tpl');
	}
	function protect_user_save(){
		$uid = get_request('uid');
		$sessionluser = get_request('sessionluser', 1, 1);
		$alldevgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		//echo $passcount;
		for($i = 0;$i<count($alldevgroup);$i++) {
			$alldevid[]=$alldevgroup[$i]['id'];
		}
		$lgroup = $this->luser_devgrp_set->select_all(' memberid='.$uid);		

		for($i = 0;$i<count($alldevgroup);$i++) {
			if(0 != get_request("Check$i",1,0)) {
				$idtmp[] = get_request("Check$i",1,0);
			}
		}	
		$this->luser_devgrp_save($sessionluser, $uid, $idtmp, $alldevid);	
	
		alert_and_back('操作成功',"admin.php?controller=admin_member&action=protect_user_devgrp&uid=".$uid);
	}

	function protect_user_resgrp_save(){
		$uid = get_request('uid');
		$sessionluser = get_request('sessionluser', 1, 1);
		$alldevgroup = $this->resgroup_set->select_all('devicesid=0');
		//echo $passcount;
		for($i = 0;$i<count($alldevgroup);$i++) {
			$alldevid[]=$alldevgroup[$i]['id'];
		}
		$lgroup = $this->luser_resourcegrp_set->select_all(' memberid='.$uid);		

		for($i = 0;$i<count($alldevgroup);$i++) {
			if(0 != get_request("Check$i",1,0)) {
				$idtmp[] = get_request("Check$i",1,0);
			}
		}	
		$this->luser_resgrp_save($sessionluser, $uid, $idtmp, $alldevid);	
	
		alert_and_back('操作成功',"admin.php?controller=admin_member&action=protect_user_resgrp&uid=".$uid);
	}
	
	function protect_group_edit(){
		$gid = get_request("gid");
		$sessionlgroup = 'PROTECTGROUP_LGROUP_RESGRP';
		$group = $this->usergroup_set->select_by_id($gid);
		$alldevgroup = $this->sgroup_set->select_all('1=1','groupname', 'ASC');
		$lgroup = $this->lgroup_devgrp_set->select_all(' groupid='.$gid);
		for($i=0; $i<count($alldevgroup); $i++){
			for($j=0; $j<count($lgroup); $j++){
				if($alldevgroup[$i]['id']==$lgroup[$j]['serversid']&&$lgroup[$j]['groupid']==$gid){
					$alldevgroup[$i]['check']='checked';
				}
			}			
		}
		//echo '<pre>';print_r($alldevgroup);echo '</pre>';
		//echo '<pre>';print_r($lgroup);echo '</pre>';
		$_SESSION[$sessionlgroup] = $lgroup;
		$this->assign("gid", $gid);
		$this->assign("group", $group);
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->assign('alldevgroup', $alldevgroup);
		$this->display('dev_group.tpl');
	}

	function protect_group_resgrp_edit(){
		$gid = get_request("gid");
		$sessionlgroup = 'PROTECTGROUP_LGROUP_RESGRP';
		$group = $this->usergroup_set->select_by_id($gid);
		$alldevgroup = $this->resgroup_set->select_all('devicesid=0','groupname', 'ASC');
		$lgroup = $this->lgroup_resourcegrp_set->select_all(' groupid='.$gid);
		for($i=0; $i<count($alldevgroup); $i++){
			for($j=0; $j<count($lgroup); $j++){
				if($alldevgroup[$i]['id']==$lgroup[$j]['resourceid']&&$lgroup[$j]['groupid']==$gid){
					$alldevgroup[$i]['check']='checked';
				}
			}			
		}
		//echo '<pre>';print_r($alldevgroup);echo '</pre>';
		//echo '<pre>';print_r($lgroup);echo '</pre>';
		$_SESSION[$sessionlgroup] = $lgroup;
		$this->assign("gid", $gid);
		$this->assign("group", $group);
		$this->assign('sessionlgroup', $sessionlgroup);
		$this->assign('alldevgroup', $alldevgroup);
		$this->display('resource_group.tpl');
	}

	function protect_group_save(){
		$gid = get_request('gid');
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		$alldevgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		//echo $passcount;
		for($i = 0;$i<count($alldevgroup);$i++) {
			$alldevid[]=$alldevgroup[$i]['id'];
		}
		$lgroup = $this->lgroup_devgrp_set->select_all(' groupid='.$gid);		

		for($i = 0;$i<count($alldevgroup);$i++) {
			if(0 != get_request("Check$i",1,0)) {
				$idtmp[] = get_request("Check$i",1,0);
			}
		}	
		$this->lgroup_devgrp_save($sessionlgroup, $gid, $idtmp, $alldevid);	
		alert_and_back('操作成功',"admin.php?controller=admin_member&action=protect_group_devgrp&gid=".$gid);
	}

	function protect_group_resgrp_save(){
		$gid = get_request('gid');
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		$alldevgroup = $this->resgroup_set->select_all('devicesid=0');
		//echo $passcount;
		for($i = 0;$i<count($alldevgroup);$i++) {
			$alldevid[]=$alldevgroup[$i]['id'];
		}
		$lgroup = $this->lgroup_resourcegrp_set->select_all(' groupid='.$gid);		

		for($i = 0;$i<count($alldevgroup);$i++) {
			if(0 != get_request("Check$i",1,0)) {
				$idtmp[] = get_request("Check$i",1,0);
			}
		}	
		$this->lgroup_resgrp_save($sessionlgroup, $gid, $idtmp, $alldevid);	
		alert_and_back('操作成功',"admin.php?controller=admin_member&action=protect_group_resgrp&gid=".$gid);
	}
	
	private function luser_devgrp_save( $sessionluser, $uid, $bind, $all){
		$user[]=0;
		if(empty($bind)){
			$bind[0]=0;
		}
		$this->luser_devgrp_set->query("delete FROM ".$this->luser_devgrp_set->get_table_name()." WHERE serversid NOT IN(".implode(',',$bind).") AND memberid=$uid");
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if(in_array($_SESSION[$sessionluser][$i]['serversid'], $bind)){
				$luser = new luser_devgrp();			
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);
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
				$user[] = $_SESSION[$sessionluser][$i]['serversid'];
			}
		}
		
		if($bind)
		$u = array_diff($bind, $user);
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		if($u)
		foreach($u AS $key => $value){
			$luser = new luser_devgrp();
			$luser->set_data('weektime', $dp['weektime']);
			$luser->set_data('sourceip', $dp['sourceip']);
			$luser->set_data('memberid', $uid);
			$luser->set_data('serversid', $value);
			$this->luser_devgrp_set->add($luser);
		}
		
		unset($_SESSION[$sessionluser]);
	}

	private function luser_resgrp_save( $sessionluser, $uid, $bind, $all){
		$user[]=0;
		if(empty($bind)){
			$bind[0]=0;
		}
		$this->luser_resourcegrp_set->query("delete FROM ".$this->luser_resourcegrp_set->get_table_name()." WHERE resourceid NOT IN(".implode(',',$bind).") AND memberid=$uid");
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if(in_array($_SESSION[$sessionluser][$i]['resourceid'], $bind)){
				$luser = new luser_resourcegrp();			
				$luser->set_data('syslogalert', $_SESSION[$sessionluser][$i]['syslogalert']);
				$luser->set_data('mailalert', $_SESSION[$sessionluser][$i]['mailalert']);
				$luser->set_data('autosu', $_SESSION[$sessionluser][$i]['autosu']);
				$luser->set_data('loginlock', $_SESSION[$sessionluser][$i]['loginlock']);
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);
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
				$user[] = $_SESSION[$sessionluser][$i]['resourceid'];
			}
		}
		
		if($bind)
		$u = array_diff($bind, $user);
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
			$luser->set_data('memberid', $uid);
			$luser->set_data('resourceid', $value);
			$this->luser_resourcegrp_set->add($luser);
		}
		
		unset($_SESSION[$sessionluser]);
	}
	
	private function lgroup_devgrp_save( $sessionlgroup, $gid, $bind, $all){
		$user[]=0;
		if(empty($bind)){
			$bind[0]=0;
		}
		$this->lgroup_devgrp_set->query("delete FROM ".$this->lgroup_devgrp_set->get_table_name()." WHERE serversid NOT IN(".implode(',',$bind).") AND groupid=$gid");
		
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if(in_array($_SESSION[$sessionlgroup][$i]['serversid'], $bind)){
				$luser = new lgroup_devgrp();			
				$luser->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
				$luser->set_data('sourceip', $_SESSION[$sessionlgroup][$i]['sourceip']);
				$luser->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
				$luser->set_data('serversid', $_SESSION[$sessionlgroup][$i]['serversid']);
				$luser->set_data('forbidden_commands_groups', $_SESSION[$sessionlgroup][$i]['forbidden_commands_groups']);		
				if($_SESSION[$sessionlgroup][$i]['id']){
					$luser->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
					$this->lgroup_devgrp_set->edit($luser);
				}else{
					$this->lgroup_devgrp_set->add($luser);
				}
				$user[] = $_SESSION[$sessionlgroup][$i]['serversid'];
			}
		}
		if($bind)
		$u = array_diff($bind, $user);
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		if($u)
		foreach($u AS $key => $value){
			$luser = new lgroup_devgrp();
			$luser->set_data('weektime', $dp['weektime']);
			$luser->set_data('sourceip', $dp['sourceip']);
			$luser->set_data('groupid', $gid);
			$luser->set_data('serversid', $value);
			$this->lgroup_devgrp_set->add($luser);
		}
		
		unset($_SESSION[$sessionlgroup]);
	}

	private function lgroup_resgrp_save( $sessionlgroup, $gid, $bind, $all){
		$user[]=0;
		if(empty($bind)){
			$bind[0]=0;
		}
		$this->lgroup_resourcegrp_set->query("delete FROM ".$this->lgroup_resourcegrp_set->get_table_name()." WHERE resourceid NOT IN(".implode(',',$bind).") AND groupid=$gid");
		
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if(in_array($_SESSION[$sessionlgroup][$i]['resourceid'], $bind)){
				$lgroup = new lgroup_resourcegrp();			
				$lgroup->set_data('syslogalert', $_SESSION[$sessionlgroup][$i]['syslogalert']);
				$lgroup->set_data('mailalert', $_SESSION[$sessionlgroup][$i]['mailalert']);
				$lgroup->set_data('autosu', $_SESSION[$sessionlgroup][$i]['autosu']);
				$lgroup->set_data('loginlock', $_SESSION[$sessionlgroup][$i]['loginlock']);
				$lgroup->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
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
				$user[] = $_SESSION[$sessionlgroup][$i]['resourceid'];
			}
		}
		if($bind)
		$u = array_diff($bind, $user);
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		if($u)
		foreach($u AS $key => $value){
			$lgroup = new lgroup_resourcegrp();
			$lgroup->set_data('syslogalert', $dp['syslogalert']);
			$lgroup->set_data('mailalert', $dp['mailalert']);
			$lgroup->set_data('autosu', $dp['autosu']);
			$lgroup->set_data('loginlock', $dp['loginlock']);
			$lgroup->set_data('weektime', $dp['weektime']);
			$lgroup->set_data('sourceip', $dp['sourceip']);
			$lgroup->set_data('groupid', $gid);
			$lgroup->set_data('resourceid', $value);
			$this->lgroup_resourcegrp_set->add($lgroup);
		}
		
		unset($_SESSION[$sessionlgroup]);
	}

	function protect_luser_devgrp_delete(){
		$id = get_request('id');
		if(empty($id)){
			$id = get_request('id', 1, 1);
		}
		$this->luser_devgrp_set->delete($id);
		alert_and_back('成功删除');
		
	}

	function protect_luser_resgrp_delete(){
		$id = get_request('id');
		if(empty($id)){
			$id = get_request('id', 1, 1);
		}
		$this->luser_resourcegrp_set->delete($id);
		alert_and_back('成功删除');
		
	}
	
	function protect_lgroup_devgrp_delete(){
		$id = get_request('id');
		if(empty($id)){
			$id = get_request('id', 1, 1);
		}
		$this->lgroup_devgrp_set->delete($id);
		alert_and_back('成功删除');
		
	}

	function protect_lgroup_resgrp_delete(){
		$id = get_request('id');
		if(empty($id)){
			$id = get_request('id', 1, 1);
		}
		$this->lgroup_resourcegrp_set->delete($id);
		alert_and_back('成功删除');
		
	}

	
	function protect_group_delete(){
		$id = get_request('id', 1, 1);
		$uid = get_request('uid', 1, 1);
		$type=get_request('type', 0, 1);
		switch($type){
			case 'luser':
				$this->luser_set->delete($id);
				$url = 'admin.php?controller=admin_member&action=protect_group&uid='.$uid;
				break;
			case 'luser-devgrp':
				$this->luser_devgrp_set->delete($id);
				$url = 'admin.php?controller=admin_member&action=protect_user_devgrp&uid='.$uid;
				break;
			case 'lgroup':
				$this->lgroup_set->delete($id);
				$url = 'admin.php?controller=admin_member&action=protect_group&type=group&gid='.$uid;
				break;			
			case 'lgroup-devgrp':
				$this->lgroup_devgrp_set->delete($id);
				$url = 'admin.php?controller=admin_member&action=protect_group_devgrp&gid='.$uid;
				break;
			case 'luser-resourcegrp':
				$this->luser_resourcegrp_set->delete($id);
				$url = 'admin.php?controller=admin_member&action=protect_user_resgrp_devgrp&uid='.$uid;
				break;
			case 'lgroup-resourcegrp':
				$this->lgroup_resourcegrp_set->delete($id);
				$url = 'admin.php?controller=admin_member&action=protect_group_resgrp&gid='.$uid;
				break;
		}
		alert_and_back('成功删除',$url);
		
	}

	function protect_edit() {
		$uid = get_request('uid');
		$ip = get_request('ip',0,1);
		$g_id = get_request('g_id');
		$member = $this->member_set->select_by_id($uid);
		$sessionluser = 'MEMBER_LUSER';
		if($ip == '') {
			$ip = get_request('ip',1,1);
		}
		$allpass = $this->devpass_set->select_all(" device_ip = '$ip'",'username', 'ASC');
		$alltem = $this->tem_set->select_all();
		//echo '<pre>';print_r($allpass);echo '</pre>';
		$num = count($allpass);
		if($num == 0) {
			alert_and_back('该设备还没有用户或IP输入错误',"admin.php?controller=admin_member&action=protect_dev&uid=$uid&g_id=$g_id");
			exit(0);
		}
		
		$allpassuser = array();
		for($ii=0; $ii < $num ; $ii++){//去掉重复
			if(empty($allpass[$ii][username])){
				$allpass[$ii][username]='空';
			}/*
			if(in_array($allpass[$ii][username],$allpassuser))
				continue;
			$allpassuser[]=$allpass[$ii][username];
			*/
			for($iii=0; $iii<count($alltem); $iii++){
				if($alltem[$iii]['id']==$allpass[$ii][login_method]){
					$allpass[$ii]['lmname'] = $alltem[$iii]['login_method'];
				}
			}
			$allpasstmp[]=$allpass[$ii];
			$allsid[]=$allpass[$ii]['id'];
		}

		$allluser = $this->luser_set->select_all('devicesid IN('.implode(',',$allsid).')');

		$allpass=$allpasstmp;
		for($j=0;$j<$num;$j++) {
			for($jj=0; $jj<count($allluser); $jj++){
				if($allluser[$jj]['memberid']==$uid&&$allluser[$jj]['devicesid']==$allpass[$j]['id']){
					//echo $_SESSION[$sessionluser][$jj]['memberid'];
					$allpass[$j]['check'] = 'checked';
					$_SESSION[$sessionluser][]=$allluser[$jj];
					break;
				}
			}			
		}		
		
		$this->assign('title',language('绑定托管用户'));
		$this->assign('ip',$ip);
		$this->assign('id',$uid);
		$this->assign('username',$member['username']);
		$this->assign("sessionluser", $sessionluser);
		$this->assign('allpass',$allpass);
		$this->assign('server_reference',$_SERVER['HTTP_REFERER']);
		$this->display('dev_user.tpl');
	}
	
	function protect_groupgrp() {
		$uid = get_request('uid');
		$ip = get_request('ip',0,1);
		$g_id = get_request('g_id');
		$group = $this->usergroup_set->select_by_id($uid);
		$alltem = $this->tem_set->select_all();
		$sessionlgroup = 'MEMBER_LGROUP';
		unset($_SESSION[$sessionlgroup]);
		if($ip == '') {
			$ip = get_request('ip',1,1);
		}
		$allpass = $this->devpass_set->select_all(" device_ip = '$ip'",'username', 'ASC');
		//echo '<pre>';print_r($allpass);echo '</pre>';
		$num = count($allpass);
		if($num == 0) {
			alert_and_back('该设备还没有用户或IP输入错误',"admin.php?controller=admin_member&action=protect_dev&uid=$uid&g_id=$g_id&type=group");
			exit(0);
		}
		
		$allpassuser = array();
		for($ii=0; $ii < $num ; $ii++){//去掉重复
			if(empty($allpass[$ii][username])){
				$allpass[$ii][username]='空';
			}/*
			if(in_array($allpass[$ii][username],$allpassuser))
				continue;
			$allpassuser[]=$allpass[$ii][username];
			*/
			for($iii=0; $iii<count($alltem); $iii++){
				if($alltem[$iii]['id']==$allpass[$ii][login_method]){
					$allpass[$ii]['lmname'] = $alltem[$iii]['login_method'];
				}
			}
			$allpasstmp[]=$allpass[$ii];
			$allsid[]=$allpass[$ii]['id'];
		}

		$alllgroup = $this->lgroup_set->select_all('devicesid IN('.implode(',',$allsid).')');

		$allpass=$allpasstmp;
		for($j=0;$j<$num;$j++) {
			for($jj=0; $jj<count($alllgroup); $jj++){
				if($alllgroup[$jj]['groupid']==$uid&&$alllgroup[$jj]['devicesid']==$allpass[$j]['id']){
					//echo $_SESSION[$sessionluser][$jj]['memberid'];
					$allpass[$j]['check'] = 'checked';
					$_SESSION[$sessionlgroup][]=$alllgroup[$jj];
					break;
				}
			}			
		}
		//echo '<pre>';print_r($allpass);echo '</pre>';		
		$this->assign('title',language('绑定托管用户'));
		$this->assign('ip',$ip);
		$this->assign('id',$uid);
		$this->assign('groupname',$group['GroupName']);
		$this->assign("sessionlgroup", $sessionlgroup);
		$this->assign('allpass',$allpass);
		$this->display('dev_user_group.tpl');
	}
	

	function protect_save() {
		$id = get_request('id');
		$ip = get_request('ip',0,1);
		$sessionluser = get_request('sessionluser', 1, 1);
		$devpass = '';
		$passcount = $this->devpass_set->select_count("device_ip = '$ip'");
		//echo $passcount;
		$olddev = $this->devpass_set->select_all("device_ip = '$ip'");
		for($i = 0;$i<$passcount;$i++) {
			$alldevid[]=$olddev[$i]['id'];
		}
		$allluser = $this->luser_set->select_all('devicesid IN('.implode(',',$alldevid).')');		
		
		//echo '<pre>';print_r($olddev);echo '</pre>';	
		for($j=0; $j<count($allluser); $j++){
			if(empty($alldevicebindnum[$allluser[$j]['devicesid']])){
				$alldevicebindnum[$allluser[$j]['devicesid']]=1;
			}else{
				$alldevicebindnum[$allluser[$j]['devicesid']]++;
			}
			$allluserid[] = $allluser[$i]['memberid'];
		}

		for($i = 0;$i<$passcount;$i++) {
			if(0 != get_request("Check$i",1,0)) {				
				$alldevicebindnum[get_request("Check$i",1,0)]++;
				if($alldevicebindnum[get_request("Check$i",1,0)]>20){
					$nopass[]=$olddev[$i]['username'];
				}else{
					$idtmp[] = get_request("Check$i",1,0);
				}
			}
		}		
				
		//print_r($_SESSION[$sessionluser]);print_r($idtmp);print_r($alldevicebindnum);print_r($nopass);
		$this->luser_save($sessionluser, $sessionlgroup, $id, $idtmp, $alldevid);
		if(count($nopass) == 0) {			
			alert_and_back('修改成功', 'admin.php?controller=admin_member&action=protect_group&uid='.$id);			
		}
		else{
			$nopass = implode(',',$nopass);
			alert_and_back(language("以下用户已绑定5个普通用户，绑定失败 ").":$nopass", 'admin.php?controller=admin_member');			
		}
	}
	
	function protect_groupgrp_save() {
		$id = get_request('id');
		$ip = get_request('ip',0,1);
		$sessionlgroup = get_request('sessionlgroup', 1, 1);
		$devpass = '';
		$passcount = $this->devpass_set->select_count("device_ip = '$ip'");
		//echo $passcount;
		$olddev = $this->devpass_set->select_all("device_ip = '$ip'");
		for($i = 0;$i<$passcount;$i++) {
			$alldevid[]=$olddev[$i]['id'];
		}
		$alllgroup = $this->lgroup_set->select_all('devicesid IN('.implode(',',$alldevid).')');		
		
		//echo '<pre>';print_r($olddev);echo '</pre>';	
		for($j=0; $j<count($alllgroup); $j++){
			if(empty($alldevicebindnum[$alllgroup[$j]['devicesid']])){
				$alldevicebindnum[$alllgroup[$j]['devicesid']]=1;
			}else{
				$alldevicebindnum[$alllgroup[$j]['devicesid']]++;
			}
			$allluserid[] = $alllgroup[$i]['memberid'];
		}

		for($i = 0;$i<$passcount;$i++) {
			if(0 != get_request("Check$i",1,0)) {				
				$alldevicebindnum[get_request("Check$i",1,0)]++;
				if($alldevicebindnum[get_request("Check$i",1,0)]>20){
					$nopass[]=$olddev[$i]['username'];
				}else{
					$idtmp[] = get_request("Check$i",1,0);
				}
			}
		}		
		
		//print_r($_SESSION[$sessionlgroup]);print_r($idtmp);print_r($alldevid);
		$this->lgroup_save( $sessionlgroup, $id, $idtmp, $alldevid);
		if(count($nopass) == 0) {			
			alert_and_back('修改成功', 'admin.php?controller=admin_member&action=protect_group&gid='.$id.'&type=group');			
		}
		else{
			$nopass = implode(',',$nopass);
			alert_and_back(language("以下用户已绑定5个普通用户，绑定失败 ").":$nopass", 'admin.php?controller=admin_member&action=usergroup');			
		}
	}
	
	private function luser_save($sessionluser, $sessionlgroup, $uid, $bind, $all){
		global $_CONFIG;
		$user[]=0;
		if(empty($bind)){
			$bind[0]=0;
			$release=$all;
		}else{
			$release = array_diff($all, $bind);
		}
		if(empty($release)){
			$release[]=0;
		}
		$this->luser_set->query("delete FROM ".$this->luser_set->get_table_name()." WHERE devicesid IN(".implode(',',$release).") AND memberid=$uid");
		
		for($i=0; $i<count($_SESSION[$sessionluser]); $i++){
			if(in_array($_SESSION[$sessionluser][$i]['devicesid'], $bind)){
				$luser = new luser();
				$luser->set_data('syslogalert', $_SESSION[$sessionluser][$i]['syslogalert']);
				$luser->set_data('mailalert', $_SESSION[$sessionluser][$i]['mailalert']);
				$luser->set_data('autosu', $_SESSION[$sessionluser][$i]['autosu']);
				$luser->set_data('loginlock', $_SESSION[$sessionluser][$i]['loginlock']);
				$luser->set_data('weektime', $_SESSION[$sessionluser][$i]['weektime']);
				$luser->set_data('sourceip', $_SESSION[$sessionluser][$i]['sourceip']);
				$luser->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
				$luser->set_data('devicesid', $_SESSION[$sessionluser][$i]['devicesid']);
				$luser->set_data('forbidden_commands_groups', $_SESSION[$sessionluser][$i]['forbidden_commands_groups']);
				
				$member = $this->member_set->select_by_id($_SESSION[$sessionluser][$i]['memberid']);
				$device = $this->devpass_set->select_by_id($_SESSION[$sessionluser][$i]['devicesid']);
				$sshprivatekey = $_CONFIG['PASSEDITSSHPRIVATEKEY'].'/'.$member['username'].'--'.$_SESSION[$sessionluser][$i]['devicesid'];
				if($device['publickey_auth']&&!file_exists($sshprivatekey)){				
					alert_and_back('请上传用户:"'.$device['username'].'"的私钥文件');
					exit;
				}
				if($this->sshprivatekey_set->select_count("memberid=".$_SESSION[$sessionluser][$i]['memberid']." and devicesid=".$_SESSION[$sessionluser][$i]['devicesid'])<=0){
					$newsshprivatekey = new sshprivatekey();
					$newsshprivatekey->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
					$newsshprivatekey->set_data('devicesid', $_SESSION[$sessionluser][$i]['devicesid']);
					$newsshprivatekey->set_data('path', $sshprivatekey);
					$this->sshprivatekey_set->add($newsshprivatekey);
				}else{
					$oldsshkey = $this->sshprivatekey_set->select_all("memberid=".$_SESSION[$sessionluser][$i]['memberid']." and devicesid=".$_SESSION[$sessionluser][$i]['devicesid']);
					$newsshprivatekey = new sshprivatekey();
					$newsshprivatekey->set_data('id', $oldsshkey[0]['id']);
					$newsshprivatekey->set_data('memberid', $_SESSION[$sessionluser][$i]['memberid']);
					$newsshprivatekey->set_data('devicesid', $_SESSION[$sessionluser][$i]['devicesid']);
					$newsshprivatekey->set_data('path', $sshprivatekey);
					$this->sshprivatekey_set->edit($newsshprivatekey);
				}
				if($_SESSION[$sessionluser][$i]['id']){
					$luser->set_data('id', $_SESSION[$sessionluser][$i]['id']);
					$this->luser_set->edit($luser);
				}else{
					$this->luser_set->add($luser);
				}
				$user[] = $_SESSION[$sessionluser][$i]['devicesid'];
			}
		}
		if($bind)
		$u = array_diff($bind, $user);
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
			$luser->set_data('memberid', $uid);
			$luser->set_data('devicesid', $value);

			$member = $this->member_set->select_by_id($uid);
			$device = $this->devpass_set->select_by_id($value);
			$sshprivatekey = $_CONFIG['PASSEDITSSHPRIVATEKEY'].'/'.$member['username'].'--'.$value;
			if($device['publickey_auth']&&!file_exists($sshprivatekey)){				
				alert_and_back('请上传用户:"'.$device['username'].'"的私钥文件');
				exit;
			}
			if($this->sshprivatekey_set->select_count("memberid=".$uid." and devicesid=".$value)<=0){
				$newsshprivatekey = new sshprivatekey();
				$newsshprivatekey->set_data('memberid', $uid);
				$newsshprivatekey->set_data('devicesid', $value);
				$newsshprivatekey->set_data('path', $sshprivatekey);
				$this->sshprivatekey_set->add($newsshprivatekey);
			}else{
				$oldsshkey = $this->sshprivatekey_set->select_all("memberid=".$uid." and devicesid=".$value);
				$newsshprivatekey = new sshprivatekey();
				$newsshprivatekey->set_data('id', $oldsshkey[0]['id']);
				$newsshprivatekey->set_data('memberid', $value);
				$newsshprivatekey->set_data('devicesid', $sid);
				$newsshprivatekey->set_data('path', $sshprivatekey);
				$this->sshprivatekey_set->edit($newsshprivatekey);
			}

			$this->luser_set->add($luser);
		}
		
		unset($_SESSION[$sessionluser]);
	} 
	
	private function lgroup_save( $sessionlgroup, $gid, $bind, $all){
		$user[]=0;
		$release[]=0;
		if(empty($bind)){
			$bind[0]=0;
			$release = $all;
		}else{
			$release = array_diff($all, $bind);
		}
		if(empty($release)){
			$release[]=0;
		}
		
		$this->lgroup_set->query("delete FROM ".$this->lgroup_set->get_table_name()." WHERE devicesid IN(".implode(',',$release).") AND groupid=$gid");
		
		for($i=0; $i<count($_SESSION[$sessionlgroup]); $i++){
			if(in_array($_SESSION[$sessionlgroup][$i]['devicesid'], $bind)){
				$luser = new lgroup();
				$luser->set_data('syslogalert', $_SESSION[$sessionlgroup][$i]['syslogalert']);
				$luser->set_data('mailalert', $_SESSION[$sessionlgroup][$i]['mailalert']);
				$luser->set_data('autosu', $_SESSION[$sessionlgroup][$i]['autosu']);
				$luser->set_data('loginlock', $_SESSION[$sessionlgroup][$i]['loginlock']);
				$luser->set_data('weektime', $_SESSION[$sessionlgroup][$i]['weektime']);
				$luser->set_data('sourceip', $_SESSION[$sessionlgroup][$i]['sourceip']);
				$luser->set_data('groupid', $_SESSION[$sessionlgroup][$i]['groupid']);
				$luser->set_data('devicesid', $_SESSION[$sessionlgroup][$i]['devicesid']);
				$luser->set_data('forbidden_commands_groups', $_SESSION[$sessionlgroup][$i]['forbidden_commands_groups']);		
				if($_SESSION[$sessionlgroup][$i]['id']){
					$luser->set_data('id', $_SESSION[$sessionlgroup][$i]['id']);
					$this->lgroup_set->edit($luser);
				}else{
					$this->lgroup_set->add($luser);
				}
				$user[] = $_SESSION[$sessionlgroup][$i]['devicesid'];
			}
		}
		if($bind)
		$u = array_diff($bind, $user);
		$dp = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
		$dp = $dp[0];
		if($u)
		foreach($u AS $key => $value){
			$luser = new lgroup();
			$luser->set_data('syslogalert', $dp['syslogalert']);
			$luser->set_data('mailalert', $dp['mailalert']);
			$luser->set_data('autosu', $dp['autosu']);
			$luser->set_data('loginlock', $dp['loginlock']);
			$luser->set_data('weektime', $dp['weektime']);
			$luser->set_data('sourceip', $dp['sourceip']);
			$luser->set_data('groupid', $gid);
			$luser->set_data('devicesid', $value);
			$this->lgroup_set->add($luser);
		}
		
		unset($_SESSION[$sessionlgroup]);
	} 

	function encryp($code) {
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

	function keys_index($interface=false) {
		$page_num = get_request('page');
		$type = get_request('type');
		$ac = get_request('ac', 1, 1);
		$keyid = get_request('keyid', 1, 1);
		$username = get_request('username', 1, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'keyid';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$this->assign('type', $type);
		$key_set = $this->usbkey_set;
		$this->assign('title', 'usbkey'.language("列表"));
		/*if($ac == 'new'){
			$cmd = 'python /opt/freesvr/audit/bin/md5.py '.$keyid;
			$a = exec($cmd, $output, $return);
			//var_dump($a); 
			//print_r($output);//exit;
			$radkey = $this->radkey_set->select_all("keyid='".$keyid."'");
			$radkeyid = $radkey[0]['id'];
			if(empty($radkey)){
				$newradkey = new radkey();
				$newradkey->set_data('pc_index', $output[0]);
				$newradkey->set_data('keyid', $keyid);
				$newradkey->set_data('isused', '1');
				$newradkey->set_data('limittime', '2019-01-01');
				$this->radkey_set->add($newradkey);
				$radkeyid = mysql_insert_id();
			}else{
				alert_and_close('key id已经存在');
				exit;
			}			
			$cmd = 'cp /tmp/'.$keyid. ' /opt/freesvr/audit/usbkeys/'.$keyid;
			exec($cmd);
			alert_and_close('操作成功');
		}*/
		$where = '1=1';
		if($keyid){
			$where .= " AND keyid like '%".$keyid."%'";
		}

		if($username){
			$where .= " AND username like '%".$username."%'";
		}
		$members = $this->member_set->select_all("level!=11 ", "username", "asc");
		
		$row_num = $key_set->base_select("SELECT count(0) ct FROM ".$key_set->get_table_name().' k LEFT JOIN '.$this->member_set->get_table_name()." m ON k.keyid=m.usbkey WHERE $where");
		$row_num=$row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page', $where);
		//$allkeys = $key_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);
		$sql = "SELECT k.*,GROUP_CONCAT(m.username) username FROM ".$key_set->get_table_name().' k LEFT JOIN '.$this->member_set->get_table_name()." m ON k.keyid=m.usbkey WHERE $where GROUP BY(k.keyid) ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$allkeys = $key_set->base_select($sql);
		if($interface){
			return $allkeys;
		}
		$this->assign('allkeys', $allkeys);
		$this->assign('members', $members);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('keys_list.tpl');
	}
	
	
	function keybinduser(){
		$keyid = get_request('keyid');
		$key = $this->usbkey_set->select_by_id($keyid);
		$keys = $this->usbkey_set->select_all();
		//$members = $this->member_set->select_all("uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)");
		$allmem = $this->member_set->base_select("SELECT a.*,IF(t.id IS NULL, 0, 1) binded,if(a.usbkey='".$key[keyid]."','checked','') `check` FROM member a LEFT JOIN radkey t ON a.usbkey=t.keyid WHERE level!=11 ".(empty($webuser) ? '' : " AND a.username like '%$webuser%' " )." ".$wheremember." AND uid not in (SELECT radiususer FROM ".$this->devpass_set->get_table_name()." WHERE radiususer>0)".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : '')." ORDER BY a.username ASC");
			
		
		$this->assign('keyid', $keyid);
		$this->assign('key', $key);
		$this->assign("allmem", $allmem);	
		$this->display('keybinduser.tpl');
	}
	
	function keybinduser_save(){
		$fromajax = get_request('fromajax');
		$keyid = get_request('keyid');
		$member = get_request('member', 1, 1);
		$key = $this->usbkey_set->select_by_id($keyid);
		$oldusbkeybind = $this->member_set->select_all("usbkey='".$key['keyid']."'");
		$this->usbkey_set->query('UPDATE '.$this->member_set->get_table_name().' SET usbkey="",usbkeystatus=0 WHERE usbkey ="'.$key['keyid'].'"');

		$usbkeybind = $this->usbkey_set->select_all("keyid='".$key['keyid']."'");
		$user = $this->member_set->select_by_id($member);
		$passcount = $this->member_set->select_count('1 = 1');
		for($i = 0;$i<$passcount;$i++) {
			if(0 != get_request("Check$i",1,0)) {
				$new_user .= get_request("Check$i",1,0).',';
				$new_userid[] = get_request("Check$i",1,0);
				$j++;
			}
		}
		if($new_userid)
		$this->usbkey_set->query('UPDATE '.$this->member_set->get_table_name().' SET usbkey="'.$key['keyid'].'",usbkeystatus='.($usbkeybind[0]['type'] ? 11 : 0).' WHERE uid IN('.implode(',', $new_userid).')');
		alert_and_back("绑定成功", 'admin.php?controller=admin_member&action=keybinduser&keyid='.$keyid);
	}
	

	function keys_delete() {
		//$type = get_request('type');
		$id = get_request('id');
		//if($type == 1) {
			$key_set = $this->usbkey_set;
		//}
		//else {
		//	$key_set = $this->wmkey_set;
		//}
		$key_set->delete($id);
		$key_set->remove($id);
		alert_and_back('删除成功', "admin.php?controller=admin_member&action=keys_index");
	}
	
	function create_file_usbkey(){
		$username = get_request('username', 0, 1);
		if(empty($username)){
			alert_and_close('没有用户名');
			exit;
		}
		$cmd = 'python /opt/freesvr/audit/bin/md5.py '.$username;
		$a = exec($cmd, $output, $return);
		//var_dump($a); 
		//print_r($output);//exit;
		$radkey = $this->radkey_set->select_all("keyid='".$username."'");
		$radkeyid = $radkey[0]['id'];
		if(empty($radkey)){
			$newradkey = new radkey();
			$newradkey->set_data('pc_index', $output[0]);
			$newradkey->set_data('keyid', $username);
			$newradkey->set_data('isused', '1');
			$newradkey->set_data('limittime', '2019-01-01');
			$this->radkey_set->add($newradkey);
			$radkeyid = mysql_insert_id();
		}else{
			$newradkey = new radius();
			$newradkey->set_data('id',	$radkeyid);
			$newradkey->set_data('pc_index', $output[0]);
			$this->radkey_set->edit($newradkey);
		}
		$memberinfo = $this->member_set->select_all("username='".$username."'");
		$newmember = new member();
		$newmember->set_data('uid', $memberinfo[0]['uid']);
		$newmember->set_data('usbkey', $radkeyid);
		$newmember->set_data('usbkeystatus', '1');
		$this->member_set->edit($newmember);
		$cmd = 'cp /tmp/'.$username. ' /opt/freesvr/audit/usbkeys/'.$username;
		exec($cmd);
		alert_and_close('操作成功');
		exit;
	}
	
	function importusbkey(){
		$this->display("importusbkey.tpl");
	}
	
	function doimportusbkey(){
		global $_CONFIG;
		if($_FILES['usbkey']['error']==1 or $_FILES['usbkey']['error']==2){
			alert_and_back("上传得文件超过系统限制");
			exit;
		}
		if(!is_uploaded_file($_FILES['usbkey']['tmp_name']))
		{
			alert_and_back("请上传文件");
			exit;
		}
		$lines = file($_FILES['usbkey']['tmp_name']);
		$importfile = $_CONFIG['IMPORTFILEPATH'].'/'.time().'.'.$_FILES['usbkey']['name'];
		if(move_uploaded_file($_FILES['usbkey']['tmp_name'], $importfile)){
			$importlog = new importlog();
			$importlog->set_data('file', $importfile);
			$importlog->set_data('type', 'usbkey');
			$this->importlog_set->add($importlog);
		}else{
			//echo '<script language=\'javascript\'>导入文件备份失败，请联系管理员</script>';
		}
		
		$insertstr = "INSERT INTO ".$this->usbkey_set->get_table_name()."(keyid,isused,limittime,pc_index,type) values";
		$dateA3yearstamp = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y')+3);
		$dateA3year = date('Y-m-d', $dateA3yearstamp);
		$j=0;
		for($i=0; $i<count($lines); $i++){
			if(trim($lines[$i])==""){
				continue;
			}
			$type = 0;
			$linearr = preg_split ("/\s{1,}/",trim($lines[$i]));
			if(count($linearr)>3){
				alert_and_back("文件非法,请重新上传正确的");
				exit;
			}elseif(count($linearr)==3){
				$type = 1;
			}
			if($this->usbkey_set->select_count("keyid='".$linearr[0]."'") > 0){
				$keyexists[]=$linearr[0]."";
				continue;
			}
			if($j!=0){
				$insertstr .=",";
			}
			$j++;
			$insertstr .= "('$linearr[0]','0','$dateA3year','$linearr[1]','$type')";
		}
		if($j&&$this->usbkey_set->query($insertstr)){
			alert_and_back('导入成功', "admin.php?controller=admin_member&action=keys_index&type=1");
		}else{
			alert_and_back('导入失败,请检查文件, 重复的key:\n'.implode(",", $keyexists));
		}
	}

	
	
	function userdisk(){
		//include "include/login_inc.php";
		//include "config/config_inc.php";
		//include "include/fun_inc.php";
		//include "language/$CFG_LANGUAGE"."_inc.php";
		//include "include/class_ftpquota_inc.php";
		require_once(ROOT . './include/class_ftpquota_inc.php');
		global $_CONFIG;
		$CFG_NETDISK_PATH = $_CONFIG['NETDISKPATH'];
		$user  = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$CFG_NETDISK_DEFAULT_QUOTA = $user['netdisksize'];						// MB
		$SG_USERNAME = $_SESSION['ADMIN_USERNAME'];

		$get_Cmd = $_GET['Cmd'];

		// 建立用户目录
		if(!is_dir("$CFG_NETDISK_PATH")) @mkdir("$CFG_NETDISK_PATH");
		if(!is_dir("$CFG_NETDISK_PATH/$SG_USERNAME")) @mkdir("$CFG_NETDISK_PATH/$SG_USERNAME");

		$netdisk_path = "$CFG_NETDISK_PATH/$SG_USERNAME";
		chdir($netdisk_path);

		switch($get_Cmd)
		{
			case 'download':
				$get_filename = $_GET['filename'];
				$get_path = $_GET['path'];
				
				$filename = "$netdisk_path/$get_path/$get_filename";
				if(substr(realpath($filename), 0, strlen($_CONFIG['NETDISKPATH']))!=$_CONFIG['NETDISKPATH']){
					alert_and_back('系统错误');
					exit;
				}
				$stat = @stat($filename);
				$size = $stat['size'];
				
				($FD_ATTACH = @fopen($filename,"r"))	|| die("Error open !filename");
			
				$buff = "";
				while($line = @fread($FD_ATTACH,4096)){
					
					$buff .= $line;
				}
				fclose($FD_ATTACH);
				
				header("Content-type: binary; name=\"$get_filename\"\n");
				header("Accept-Ranges: bytes\n");
				header("Content-Length: $size\n");
				header("Content-Disposition: attachment; filename=\"$get_filename\"\n\n");
				header("Pragma: public"); // for SSL
				header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
				header("Cache-Control: post-check=0, pre-check=0", false);
				//header("Pragma: no-cache");                          // HTTP/1.0 
				echo $buff;
				exit();
				break;
			
			case 'send':
				$get_filename = $_GET['filename'];
				$get_path = $_GET['path'];
				
				$filename = "$netdisk_path/$get_path/$get_filename";
				if(substr(realpath($filename), 0, strlen($_CONFIG['NETDISKPATH']))!=$_CONFIG['NETDISKPATH']){
					alert_and_back('系统错误');
					exit;
				}
				$attach = "$CFG_TEMP/$SG_DOMAIN/$SG_USERNAME/attach/$get_filename";
				$stat = @stat($filename);
				$size = $stat['size'];
				$type = "binary";
				
				if(@copy($filename, $attach)||@copy( $filename, $attach)){
					($FD_ATTACH = @fopen("$CFG_TEMP/$SG_DOMAIN/$SG_USERNAME/list_attach", "a")) || die("Error open !filename");
					fputs($FD_ATTACH, "$get_filename\t$size\t$type\n");
					fclose($FD_ATTACH);		
				}
				
				header("location: send.php");
				break;
				
			case 'mkdir':
				$post_dirname = $_POST['dirname'];
				$post_path = $_POST['path'];
				if(substr(realpath("$netdisk_path/$post_path"), 0, strlen($_CONFIG['NETDISKPATH']))!=$_CONFIG['NETDISKPATH']){
					alert_and_back('系统错误');
					exit;
				}
				@chdir("$netdisk_path/$post_path");
				@mkdir($post_dirname);
				
				header("Location: admin.php?controller=admin_member&action=userdisk&cmd=list&path=$post_path");
				break;
				
			case 'Deldir':
				$get_dir = urldecode($_GET['dir']);
				$post_path = $_POST['path'];
				if(substr(realpath("$netdisk_path/$post_path"), 0, strlen($_CONFIG['NETDISKPATH']))!=$_CONFIG['NETDISKPATH']){
					alert_and_back('系统错误');
					exit;
				}
				@rmdir("$netdisk_path/$post_path/".$get_dir);
				header("Location: admin.php?controller=admin_member&action=userdisk&Cmd=list&path=$post_path");
				break;
					
			case 'Del':
				$get_filename = basename($_GET['filename']);
				$post_path = $_POST['path'];

				
				$file_stat = @stat($netdisk_path ."/$post_path/". $get_filename);
				$size = $file_stat['size'];
				if(substr(realpath("$netdisk_path/$post_path"), 0, strlen($_CONFIG['NETDISKPATH']))!=$_CONFIG['NETDISKPATH']){
					alert_and_back('系统错误');
					exit;
				}
						
				unlink("$netdisk_path/$post_path/".$get_filename);
				
				$ftpquota = new FtpQuota($netdisk_path);
				$ftpquota->decFile($size);
				$ftpquota->close();
				
				header("Location: admin.php?controller=admin_member&action=userdisk&Cmd=list&path=$post_path");
				break;
				
			case 'Add':
				// 处理上传的文件
				$upload 	 = $_FILES['upload']['tmp_name'];
				$upload_name = $_FILES['upload']['name'];
				$upload_size = $_FILES['upload']['size'];
				$upload_type = $_FILES['upload']['type'];

				$post_path = $_POST['path'];
				
				$ftpquota = new FtpQuota($netdisk_path);
				$ftpquota->plusFile($upload_size);
				if($ftpquota->fileTotalsize > $CFG_NETDISK_DEFAULT_QUOTA*1024*1024)
				{
						$ftpquota->decFile($size);
						 echo "<script language=\'javascript\'>" .
						 "alert('空间不够!');" .
						 "document.location='admin.php?controller=admin_member&action=userdisk&Cmd=list&path=$post_path';" .
						 "</script>";
						 exit;				
				}
				$ftpquota->close();		

				$dest = "$netdisk_path/$post_path/". $upload_name;
				if(substr(realpath("$netdisk_path/$post_path"), 0, strlen($_CONFIG['NETDISKPATH']))!=$_CONFIG['NETDISKPATH']){
					alert_and_back('系统错误');
					exit;
				}
				if(is_file($dest))
				{
					$desttmp = $dest.time();
					@copy($upload,$desttmp);
					echo "<script language=\'javascript\'>file=prompt('警告: 网络文件夹已有同名文件,请输入新文件名.','$get_saveas');
					if(file!='null' && file!='none'){
						//alert('admin.php?controller=admin_member&action=userdisk&Cmd=save&File=$desttmp&saveas='+file+'&url=$get_url');
						document.location = 'admin.php?controller=admin_member&action=userdisk&Cmd=save&File=$desttmp&path=$post_path&saveas='+file+'&url=$get_url';
				}
					</script>";
					exit();	
				}
				
				if (($upload<>"none")&&($upload<>"")){
					 
					 // 判断文件是否为正常文件
					 if (is_file($upload)!=1){
						 echo "<script language=\'javascript\'>" .
						 "alert('文件不正常!');" .
						 "document.location='admin.php?controller=admin_member&action=userdisk&Cmd=list&path=$post_path';" .
						 "</script>";
						 exit;	
					  }
					 
					 // 上传文件
					 //$dest = "$netdisk_path/".$post_path ."/". $upload_name;
					 if (@copy($upload, $dest))
					 @unlink($upload);
				}
					
				header("Location: admin.php?controller=admin_member&action=userdisk&Cmd=list&path=$post_path");
				break;
				
			case 'save':
				$get_filename = $_GET['File'];
				$get_saveas   = $_GET['saveas'];
				$get_url = $_GET['url'];
			
				if($_GET['saveas']=='' || $_GET['saveas']=='null' || $_GET['saveas']=='none'){
					$get_saveas = $get_filename;
				}

				//var_dump($get_saveas);
				$dest = "$netdisk_path/". $get_saveas;

				if(substr(realpath($dest = "$netdisk_path/". $get_saveas), 0, strlen($_CONFIG['NETDISKPATH']))!=$_CONFIG['NETDISKPATH']){
					alert_and_back('系统错误');
					exit;
				}
				
				$attach = "$get_filename";
				
				if(is_file($dest))
				{
					echo "<script language=\'javascript\'>file=prompt('警告: 网络文件夹已有同名文件,请输入新文件名.','$get_saveas');
					if(file!='null' && file!='none')
						document.location = 'admin.php?controller=admin_member&action=userdisk&Cmd=save&File=$get_filename&saveas='+file+'&url=$get_url';
					</script>";
					exit();	
				}
				
				
				if(is_file($attach))
				{
					$attach_stat = @stat($attach);
					$ftpquota = new FtpQuota($netdisk_path);
					$ftpquota->plusFile($attach_stat['size']);
					if($ftpquota->fileTotalsize > $CFG_NETDISK_DEFAULT_QUOTA*1024*1024)
					{
							 echo "<script language=\'javascript\'>" .
							 "alert('空间不够!');" .
							 "document.location='admin.php?controller=admin_member&action=userdisk&Cmd=list&path=$post_path';" .
							 "</script>";
							 exit;				
					}
					$ftpquota->close();
					@copy($attach, $dest);

		echo "<script language=\'javascript\'>alert('该附件已经存放到网络文件夹的根目录中');</script>";
				}
				
				echo "<script language=\'javascript\'>document.location='admin.php?controller=admin_member&action=userdisk&Cmd=list&path=$post_path'</script>";
				exit();
				break;		
		}


		// list
		$get_path = $_GET['path'];
		if($get_path=='/') $get_path='';

		$ListOut = '';
		$ListDir = '';
		$totalfile = 0;

		@chdir($netdisk_path ."/" . $get_path);
		$base_path = $netdisk_path ."/" . $get_path;
		$dh = @opendir($base_path);

		if(substr(realpath($netdisk_path ."/" . $get_path), 0, strlen($_CONFIG['NETDISKPATH']))!=$_CONFIG['NETDISKPATH']){
			alert_and_back('系统错误');
			exit;
		}

		if ($dh = @opendir($base_path))
		{
			while (($file = readdir($dh)) !== false)
			{
				$file_type = filetype($base_path ."/". $file);

				$file_stat = @stat($base_path ."/". $file);
		//	    	print_r($file_stat);
				$size = $file_stat['size'];
				if($size>=1024*1024){
					$size = intval($size/(1024*1024)*10)/10;
					$size = $size." MB";
				}elseif($size>=1024) {
					$size = intval($size/(1024)*10)/10;
					$size = $size." KB";
				}else{
					$size = $size."Byte";
				}
				$mtime = date( "Y-m-d H:i:s", $file_stat['mtime']);
				
				$urlfile = urlencode($file);
				
				if($file!='.' && $file!='..')
				{
					if($file_type=='file' && $file!='.ftpquota')
					{
						$totalfile++;
						$type = '';
						$ListOut .= "<TR ALIGN='CENTER' >\n\t".
							"\t<TD><A HREF=\"admin.php?controller=admin_member&action=userdisk&Cmd=download&filename=$file&path=$get_path\">$file</A></TD>\n".
							"\t<TD>$type</TD>\n".
							"\t<TD NOWRAP>$size</TD>\n".
							"\t<TD NOWRAP>$mtime</TD>\n".
							"<TD align=center NOWRAP>".
							"</td><td align=center><A onClick='DelAddr(\"$file\");return false;' href=#>".
							"<IMG src=template/admin/images/trash.gif border=0 ALT='删除' width=14 height=14></A></TD>\n</TR>\n"; 
					}
					if($file_type=='dir')
					{
						$type = '文件夹';
						$size = '';
						$ListDir .= "<TR ALIGN='CENTER' >\n\t".
							"\t<TD><A HREF=\"admin.php?controller=admin_member&action=userdisk&Cmd=list&path=$get_path/$urlfile\">$file</A></TD>\n".
							"\t<TD>$type</TD>\n".
							"\t<TD NOWRAP>$size</TD>\n".
							"\t<TD NOWRAP>$mtime</TD>\n".
							"<TD NOWRAP align=center colspan=2>".
							"<A onClick='Deldir(\"$file\");return false;' href=#>".
							"<IMG src=template/admin/images/trash.gif border=0 ALT='删除' width=14 height=14></A></TD>\n</TR>\n";
					}
				}
			}
			closedir($dh);
		}

		$ListOut = $ListDir . $ListOut;

		$ftpquota = new FtpQuota($netdisk_path);
		$OUT['totalfile'] = $ftpquota->fileTotalNum;
		$OUT['totalsize'] = $ftpquota->fileTotalsize;

		$OUT['totalsize'] = intval($OUT['totalsize']/(1024*1024)*10)/10;
		$OUT['totalsize'] = $OUT['totalsize']."MB";

		$OUT['remain'] = $CFG_NETDISK_DEFAULT_QUOTA*1024*1024 - $ftpquota->fileTotalsize;
		if($OUT['remain']<0) $OUT['remain'] = 0;

		$OUT['remain'] = intval($OUT['remain']/(1024*1024)*10)/10;
			$OUT['remain'] = $OUT['remain']."MB";

		$OUT['pre_path'] = dirname($get_path);
		$OUT['LANG_FILE_DISK_QUOTA'] = $CFG_NETDISK_DEFAULT_QUOTA;

		$OUT['NICKNAME'] = $SG_NICKNAME;                    // 用户姓名
		$OUT['EMAIL']    = "$SG_USERNAME@$SG_DOMAIN";       // 用户email地址
		$OUT['path']     = $get_path;
		$OUT['pathname'] = $OUT['path'];
		if($OUT['pathname']=='') $OUT['pathname'] = '/';
		
		$this->assign("OUT", $OUT);
		$this->assign("ListOut", $ListOut);
		$this->display('userdisk.tpl');
	}

	function memberimport(){
		$this->display("memberimport.tpl");
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
	
	function domemberimport(){
		global $_CONFIG;
		set_time_limit(0);
		setlocale(LC_ALL, 'zh_CN');
		$levels = array(
			"普通用户" => '11',
			"认证用户" => '11',
			/*"管理员" => '1',
			"审计员" => '2',
			"组管理员" => '3',
			"密码管理员" => '10',*/
			'RADIUS用户' => '11'
		);
		$encrypt = get_request("encrypt", 1, 0);
		if($_FILES['devfile']['error']==1 or $_FILES['devfile']['error']==2){
			alert_and_back("上传得文件超过系统限制");
			exit;
		}
		if(!is_uploaded_file($_FILES['devfile']['tmp_name']))
		{
			alert_and_back("请上传文件");
			exit;
		}
		
		if (($handle = fopen($_FILES['devfile']['tmp_name'], "r")) !== FALSE) {
			while(($lines[] = fgetcsv($handle))!==false);
		}else{
			alert_and_back("打开文件失败");
			exit;
		}
		if(!$_SESSION['RADIUSUSERLIST']){
			if(iconv("GBK", "UTF-8", trim($lines[0][0]))!='用户名' || iconv("GBK", "UTF-8", trim($lines[0][1]))!='密码' || iconv("GBK", "UTF-8", trim($lines[0][2]))!='真实姓名' || iconv("GBK", "UTF-8", trim($lines[0][3]))!='电子邮箱'|| iconv("GBK", "UTF-8", trim($lines[0][4]))!='用户权限'){
				alert_and_back("文件有问题，请上传正确的文件");
				exit;
			}
		}else{
			if(iconv("GBK", "UTF-8", trim($lines[0][0]))!='用户名' || iconv("GBK", "UTF-8", trim($lines[0][1]))!='密码'){
				alert_and_back("文件有问题，请上传正确的文件");
				exit;
			}
		}
		$importfile = $_CONFIG['IMPORTFILEPATH'].'/'.time().'.'.$_FILES['devfile']['name'];
		if(move_uploaded_file($_FILES['devfile']['tmp_name'], $importfile)){
			$importlog = new importlog();
			$importlog->set_data('file', $importfile);
			$importlog->set_data('type', 'member');
			$this->importlog_set->add($importlog);
		}else{
			//echo '<script language=\'javascript\'>导入文件备份失败，请联系管理员</script>';
		}
		//var_dump($lines);
		//echo '<pre>';print_r($lines);echo '</pre>';exit;
		unset($_POST);
		$j=0;
		for($i=1; $i<count($lines); $i++){
			if(empty($lines[$i])){
				continue;
			}

			$linearr = $lines[$i];	
			for($ii=0; $ii<count($linearr); $ii++){
				$linearr[$ii]=iconv("GBK", "UTF-8", $linearr[$ii]);
			}//var_dump($linearr);
			$index_i=0;
			if(!$_SESSION['RADIUSUSERLIST']){
				$username=$linearr[$index_i++];
				$password=$linearr[$index_i++];
				$realname=$linearr[$index_i++];
				$email=$linearr[$index_i++];
				$level=(($levels[$linearr[$index_i]]==0 or $levels[$linearr[$index_i]]==11) ? $levels[$linearr[$index_i]] : -1) ;
				if($_CONFIG['LDAP']&&0){
					$groupparentparent=$linearr[$index_i++];
					$groupparent=$linearr[$index_i++];
				}
				$index_i++;
				$groupid=$linearr[$index_i++];
				$mobilenum=$linearr[$index_i++];
				$workcompany=$linearr[$index_i++];
				$workdepartment=$linearr[$index_i++];
				$vpn=$linearr[$index_i++];
				$vpnip=$linearr[$index_i++];
				$usbkey=$linearr[$index_i++];
				$radiusauth=$linearr[$index_i++];
				$radiusauth = ($radiusauth=='是' ? 1 : 0);
			}else{
				$username=$linearr[$index_i++];
				$password=$linearr[$index_i++];
				$level = 11;
				$vpn=0;
			}
			if(empty($username)){
				$_POST['error'][$j]='用户名不能为空';
			}

			if(empty($groupid)){
				$_POST['username'][$j]=$username;
				$_POST['error'][$j]='用户所属目录不能为空';
			}
			if(strpos($groupid,'((')===false){
				if($this->sgroup_set->select_count("groupname='".$groupid."'")>1){
					$error[]=$device_ip.' '.(empty($username) ? '空用户' : $username).' '.':'.'有重复组请输入组ID';
					continue;
				}
				$_group = $this->sgroup_set->select_all("groupname='".$groupid."'");
				$groupid=$_group[0]['id'];
			}else{				
				$groupid=substr($groupid, strpos($groupid,'((')+2, strpos($groupid,'))')-strpos($groupid,'((')-2);
			}
			$group = $this->usergroup_set->select_by_id($groupid);
			if(empty($group)){
				$_POST['error'][$j]='资源组'.$groupid.'不存在';
			}
			$groupppid = 0;
			$grouppid = 0;
			$grouppp = $this->sgroup_set->select_all("groupname='".$groupparentparent."'");
			$groupp = $this->sgroup_set->select_all("groupname='".$groupparent."'");
			$group = $this->usergroup_set->select_all("groupname='".$groupname."'");
			if($_CONFIG['LDAP']&&0){
				if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
					if(!$this->testNode($grouppp[0], $groupp[0], $group[0])){
						$_POST['error'][$j]=$groupparentparent.'-'.$groupparent.'-'.$groupname.','.'目录结构不正确';
						continue;
					}
					if($_SESSION['ADMIN_MUSERGROUPTYPE']){
						$_p_g1 = $this->sgroup_set->select_by_id($_SESSION['ADMIN_MUSERGROUP']);
						if($_p_g1['level']==1&&$_p_g1['id']!=$grouppp[0]['id']){
							$_POST['error'][$j]=$groupparentparent.'-'.$groupparent.'-'.$groupname.','.'越权设定目录';
							continue;
						}
						if($_p_g1['level']==2&&$_p_g1['ldapid']!=$grouppp[0]['id']&&$_p_g1['id']!=$groupp[0]['id']){
							$_POST['error'][$j]=$groupparentparent.'-'.$groupparent.'-'.$groupname.','.'越权设定目录';
							continue;
						}
					}else{
						if($group[0]['id']!=$_SESSION['ADMIN_MUSERGROUP']){
							$_POST['error'][$j]=$groupparentparent.'-'.$groupparent.'-'.$groupname.','.'越权设定目录';
							continue;
						}
					}				
				}
				if(empty($grouppp)&&!empty($groupparentparent)){
					$newgroup = new sgroup();
					$newgroup->set_data("groupname", $groupparentparent);
					$newgroup->set_data("level", 1);
					$this->sgroup_set->add($newgroup);
					$groupppid = mysql_insert_id();
				}

				if(empty($groupp)&&!empty($groupparent)){
					$newgroup = new sgroup();
					$newgroup->set_data("groupname", $groupparent);
					$newgroup->set_data("level", 2);
					$newgroup->set_data("ldapid", $groupppid);
					$this->sgroup_set->add($newgroup);
					$groupppid = mysql_insert_id();
				}
			}
			
			if(empty($group)&&!empty($groupname)&&0){
				$newgroup = new usergroup();
				$newgroup->set_data("groupname", $groupname);
				$newgroup->set_data('ldapid', 0);
				if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
					$newgroup->set_data('ldapid', $_SESSION['ADMIN_MUSERGROUP']);
				}
				$this->usergroup_set->add($newgroup);
				$groupid = mysql_insert_id();
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
			
			$_POST['username'][$j]=$username;
			$_POST['password'][$j]=$password;
			$_POST['confirm_password'][$j]=$password;
			$_POST['level'][$j]=$level;
			$_POST['groupid'][$j]=$groupid;
			$_POST['groupname'][$j]=$groupname;
			$_POST['mobilenum'][$j]=$mobilenum;
			$_POST['workdepartment'][$j]=$workdepartment;
			$_POST['workcompany'][$j]=$workcompany;
			$_POST['email'][$j]=$email;
			$_POST['realname'][$j]=$realname;
			$_POST['vpn'][$j]=$vpn;
			$_POST['vpnip'][$j]=$vpnip;
			$_POST['usbkey'][$j]=trim($usbkey," '");
			$_POST['localauth'][$j]=$localauth;
			$_POST['radiusauth'][$j]=$radiusauth;
			$_POST['ldapauth'][$j]=$ldapauth;
			$_POST['adauth'][$j]=$adauth;
			$_POST['auth'][$j]=$auth;
			$_POST['authtype'][$j]=$authtype;
			$_POST['firstauth'][$j]=$firstauth;
			$_POST['forceeditpassword'][$j]=$forceeditpassword;
			$_POST['asyncoutpass'][$j]=$asyncoutpass;
			$_POST['tranportauth'][$j]=$tranportauth;
			
			$j++;
		}
		$this->batchadd_save($encrypt);
		//exit;
	}
	
	function login4approve() {
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
		$username = get_request("username", 0, 1);
		$orderby1 = get_request("orderby1", 0, 1);
		$orderby2 = get_request("orderby2", 0, 1);
		//$where = 'level < 10 AND level!=2';
		$where = 'approveuser="'.$_SESSION['ADMIN_USERNAME'].'" AND approved < 2';
		

		if(empty($orderby1)){
			$orderby1 = 'applytime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($username){
			$where .= " AND username='".$username."'";
		}


		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$row_num = $this->login4approve_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$allmember = $this->login4approve_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where, $orderby1, $orderby2);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$alltem = $this->tem_set->select_all();
		for($i=0;$i<count($allmember);$i++) {
			foreach($alltem as $tem) {
				if($allmember[$i]['login_method'] == $tem['id']) {
					$allmember[$i]['login_method'] = $tem['login_method'];
				}
			}
		}

		$this->assign('approves', $allmember);
		$this->display('login4approve.tpl');
	}

	function dologin4approve(){
		$id = get_request('id');
		if($id){
			$ids = array($id);
		}else{
			$ids = $_POST['chk_member'];
		}
		for($i=0; $i<count($ids); $i++){
			$approve = new login4approve();
			$approve->set_data('id', $ids[$i]);
			$approve->set_data('approvetime', date('Y-m-d H:i:s'));
			$approve->set_data('approved', 1);
			$this->login4approve_set->edit($approve);
		}
		alert_and_back("操作成功");
		exit;
	}

	function dellogin4approve(){
		$id = get_request('id');
		if($id){
			$ids = array($id);
		}else{
			$ids = $_POST['chk_member'];
		}
		$this->login4approve_set->delete($ids);
		alert_and_back("操作成功");
		exit;
	}

	function showUsersByLevel(){
		$members = $this->member_set->base_select("SELECT COUNT(*) count, level FROM ".$this->member_set->get_table_name()." GROUP BY level");
		$this->assign("members", $members);
		$this->display("usersbylevel.tpl");
	}

	function get_eth0_ip() {
		global $_CONFIG;
		$filename = $_CONFIG['CONFIGFILE']['IFGETH0'];		
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
			}
		}
		else
		{
			//alert_and_back('配置文件不存在');
		}
		$return['eth0'] = trim($network['IPADDR']['value']);
		
		return $return;
	}

	function getServerName(){
		
		global $_CONFIG;
		$filename = '/opt/freesvr/web/conf/extra/httpd-ssl.conf';		
		$return=array();
		if(file_exists($filename))
		{
			$lines = file($filename);
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtoupper($lines[$ii]), "SERVERNAME"))
				{
					$lines[$ii] = trim($lines[$ii]);
					$tmp = preg_split("/\s+/", $lines[$ii]);
					$network['IPADDR']['value'] = $tmp[1];
					$network['IPADDR']['file'] = $filename;
				}
			}
		}
		else
		{
			//alert_and_back('配置文件不存在');
		}
		$return['eth0'] = trim($network['IPADDR']['value']);
		
		return $return;
	}
	
	function createca(){
		global $_CONFIG;
		$Certificate = $this->setting_set->select_all("sname='Certificate'");
		$Certificate = $Certificate[0]['svalue'];
		$uid = get_request('uid');
		$eth0 = $this->getServerName();
		$m = $this->member_set->select_by_id($uid);
		if(empty($m)){
			alert_and_back('系统错误，请重新打开页面');
			exit;
		}
		if(empty($Certificate)){
			alert_and_back('证书未开启，无法生成');
			exit;
		}
		echo $cmd = "sudo /home/wuxiaolong/CACreate/ca.pl ".$m['username']."@".$eth0['eth0']." ".$this->member_set->udf_decrypt($m['password']);
		$r = exec($cmd, $o);
		if($o){
			$new_m = new member();
			$new_m->set_data('uid', $uid);
			$new_m->set_data('cacn', $m['username']."@".$eth0['eth0']);
			$this->member_set->edit($new_m);
		}
		alert_and_back($r."，用户生成证书以后，必须要安装证书才能登录堡垒机", 'admin.php?controller=admin_member&action=edit&uid='.$uid, 0, 1);
	}

	function downloadca(){
		global $_CONFIG;
		$uid = get_request('uid');
		$m = $this->member_set->select_by_id($uid);
		if(empty($m)){
			alert_and_back('系统错误，请重新打开页面');
			exit;
		}
		
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		header("Content-Disposition: attachment;filename=".iconv("UTF-8", "GB2312", $m['username'].'.pfx'));
		echo file_get_contents($_CONFIG['CAFILEPATH']."/".$m['username'].'.pfx');
		exit();
	}

	function workdept(){
		$page_num = get_request('page');
		$type = get_request('type', 0, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$_SESSION['DEPTPOST']= (empty($type) ? ($_SESSION['DEPTPOST'] ? $_SESSION['DEPTPOST'] : 'DEPT') : $type);
		if($_SESSION['DEPTPOST']=="DEPT"){
			$modelset = $this->memberdept_set;
		}else{
			$modelset = $this->memberpost_set;
		}
		$where='1';
		$row_num = $modelset->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$s = $modelset->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$this->assign('title', language('用户属性'));
		$this->assign('s', $s);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('type', $_SESSION['DEPTPOST']);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('workdept.tpl');
	}

	function workdept_edit(){
		if($_SESSION['DEPTPOST']=="DEPT"){
			$modelset = $this->memberdept_set;
		}else{
			$modelset = $this->memberpost_set;
		}
		$sid = get_request("id");
		$sip = $modelset->select_by_id($sid);
		$this->assign("title", language('用户属性'));
		$this->assign("sip", $sip);
		$this->display('workdept_edit.tpl');
	}

	function workdept_save(){
		if($_SESSION['DEPTPOST']=="DEPT"){
			$modelset = $this->memberdept_set;
			$workdept = new memberdept();
		}else{
			$modelset = $this->memberpost_set;
			$workdept = new memberpost();
		}
		$id = get_request("id");
		$title = get_request("title", 1, 1);
		$desc = get_request("desc", 1, 1);
		if(empty($title)){
			alert_and_back('请填写名称');
			exit;
		}
		$allgp = $modelset->select_all('title="'.$title.'" AND id!='.$id);
		if(!empty($allgp)){
			alert_and_back('该名称已经存在');
			exit;
		}
		$workdept->set_data('title', $title);
		$workdept->set_data('desc', $desc);
		if($id){
			$workdept->set_data("id", $id);
			$modelset->edit($workdept);
			alert_and_back('修改成功','admin.php?controller=admin_member&action=workdept');
			exit;
		}
		$modelset->add($workdept);
		alert_and_back('添加成功','admin.php?controller=admin_member&action=workdept');
	}
	
	function workdept_delete(){
		$error = array();
		if($_SESSION['DEPTPOST']=="DEPT"){
			$modelset = $this->memberdept_set;
		}else{
			$modelset = $this->memberpost_set;
		}
		for($i=0; $i<count($_POST['chk_gid']); $i++){
			$id = $_POST['chk_gid'][$i];
			$modelset->query("DELETE FROM ".$modelset->get_table_name()." WHERE id='$id'");
		}
		alert_and_back('删除成功','admin.php?controller=admin_member&action=workdept');
	}

	function memberdesc(){
		$uid = get_request('uid');
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		
		$modelset = $this->memberdesc_set;
		$where="memberid='$uid'";
		$row_num = $modelset->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$s = $modelset->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		for($i=0; $i<count($s); $i++){
			if($s[$i]['prideptid']){
				$_n = $this->memberdept_set->select_by_id($s[$i]['prideptid']);
				$s[$i]['prideptname']=$_n['title'];
			}
			if($s[$i]['curdeptid']){
				$_n = $this->memberdept_set->select_by_id($s[$i]['curdeptid']);
				$s[$i]['curdeptname']=$_n['title'];
			}
			if($s[$i]['pripostid']){
				$_n = $this->memberpost_set->select_by_id($s[$i]['pripostid']);
				$s[$i]['pripostname']=$_n['title'];
			}
			if($s[$i]['curpostid']){
				$_n = $this->memberpost_set->select_by_id($s[$i]['curpostid']);
				$s[$i]['curpostname']=$_n['title'];
			}
		}
		$this->assign('title', language('用户属性'));
		$this->assign('s', $s);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('uid', $uid);
		$this->assign('type', $_SESSION['DEPTPOST']);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('memberdesc.tpl');
	}

	function memberdesc_edit(){
		$modelset = $this->memberdesc_set;
		$sid = get_request("id");
		$uid = get_request("uid");
		$sip = $modelset->select_by_id($sid);
		$workdept = $this->memberdept_set->select_all();
		$workpost = $this->memberpost_set->select_all();
		$this->assign("title", language('用户属性'));
		$this->assign("sip", $sip);
		$this->assign('uid', ($uid ? $uid : $sip['memberid']));
		$this->assign("workdept", $workdept);
		$this->assign("workpost", $workpost);
		$this->display('memberdesc_edit.tpl');
	}

	function memberdesc_save(){
		$modelset = $this->memberdesc_set;
		$memberdesc = new memberdesc();
		$id = get_request("id");
		$uid = get_request("uid");
		$action = get_request("action", 1, 1);
		$desc = get_request("desc", 1, 1);
		$prideptid = get_request("prideptid", 1, 0);
		$curdeptid = get_request("curdeptid", 1, 0);
		$pripostid = get_request("pripostid", 1, 0);
		$curpostid = get_request("curpostid", 1, 0);
		$memberinfo = $this->member_set->select_by_id($uid);
		$memberdesc->set_data('memberid', $uid);
		$memberdesc->set_data('membername', $memberinfo['username']);
		$memberdesc->set_data('action', $action);
		$memberdesc->set_data('prideptid', $prideptid);
		$memberdesc->set_data('curdeptid', $curdeptid);
		$memberdesc->set_data('pripostid', $pripostid);
		$memberdesc->set_data('curpostid', $curpostid);
		$memberdesc->set_data('optime', date('Y-m-d H:i:s'));
		$memberdesc->set_data('desc', $desc);
		if($id){
			$memberdesc->set_data("id", $id);
			$modelset->edit($memberdesc);
			alert_and_back('修改成功','admin.php?controller=admin_member&action=memberdesc&uid='.$uid);
			exit;
		}
		$modelset->add($memberdesc);
		alert_and_back('添加成功','admin.php?controller=admin_member&action=memberdesc&uid='.$uid);
	}
	
	function memberdesc_delete(){
		$uid = get_request("uid");
		$error = array();
		$modelset = $this->memberdesc_set;
		for($i=0; $i<count($_POST['chk_gid']); $i++){
			$id = $_POST['chk_gid'][$i];
			$modelset->query("DELETE FROM ".$modelset->get_table_name()." WHERE id='$id'");
		}
		alert_and_back('删除成功','admin.php?controller=admin_member&action=memberdesc&uid='.$uid);
	}

	function adconfig(){
		global $_CONFIG;
		$g_id = get_request('g_id');
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
		if($groupid){
			$this->member_set->query("UPDATE ".$this->member_set->get_table_name()." SET groupid=0 WHERE adou!='' and adou is not null and groupid='".$groupid."'");
			if($_POST['secend'])
			$this->member_set->query("UPDATE ".$this->member_set->get_table_name()." SET groupid='".$groupid."' WHERE uid IN('".implode("','", $_POST['secend'])."')");
			
			alert_and_back('操作成功');
			exit;
		}

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$where .= " AND groupid IN ('".$_tmpgid['child']."')";
		}

		$members = $this->member_set->select_all("adou!='' and adou is not null", "username", "asc");
		$root[0] =array('ous'=>array(),'users'=>array());
		for($i=0; $i<count($members); $i++){
			$pid='';
			$ou_array = unserialize($members[$i]['adou']);
			for($j=0; $j<count($ou_array); $j++){
				$found = 0;
				$level = $j-1;
				for($m=0; $m<count($root[$j]['ous']); $m++){
					if($root[$j]['ous'][$m]['name']==$ou_array[$j]){
						$found = 1;	
						$level = $j;
						$index = $m;
						if($j==count($ou_array)-1){
							$root[$j+1]['users'][]=array('uid'=>$members[$i]['uid'], 'username'=>$members[$i]['username'], 'groupid'=>$members[$i]['groupid'], 'pid'=>$level.'_'.(empty($index) ? 0 : $index));
						}
						continue;
					}
				}
				if(!$found){
					if($j==count($ou_array)-1){
						$root[$j]['ous'][]=array('name'=>$ou_array[$j], 'pid'=>(empty($j) ? 0 : $level.'_'.(empty($index) ? 0 : $index)));
						$root[$j+1]['users'][]=array('uid'=>$members[$i]['uid'], 'username'=>$members[$i]['username'], 'groupid'=>$members[$i]['groupid'], 'pid'=>(empty($j) ? 0 : ($level+1).'_'.(count($root[$j]['ous'])-1)));
					}else{
						$root[$j]['ous'][]=array('name'=>$ou_array[$j], 'pid'=>(empty($j) ? 0 : $level.'_'.(empty($index) ? 0 : $index)));
					}
					$index = count($root[$j]['ous'])-1;
				}
			}
		}
		//echo '<pre>';var_dump($root);echo '</pre>';
		$members=null;
		if($g_id){
			$members = $this->member_set->select_all("adou!='' and adou is not null ".$where, "username", "asc");
		}

		$this->assign("root", $root);
		$this->assign("members", $members);
		$this->display("adconfig.tpl");
	}
	
	function showdesc(){
		$id = get_request('id');
		$devinfo = $this->usbkey_set->select_by_id($id);
		$this->assign('devinfo', $devinfo);
		$this->assign('id', $id);
		$this->display('usbkeydesc.tpl');
	}
	
	function dodevdesc(){
		$id = get_request('id', 1, 0);
		$desc = get_request('desc', 1, 1);
		$newradkey = new radkey();
		$newradkey->set_data('id', $id);
		$newradkey->set_data('desc', $desc);
		$this->usbkey_set->edit($newradkey);
		echo '<script language=\'javascript\'>alert(\'操作成功\');window.parent.closeWindow();window.parent.location.reload();</script>';
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
