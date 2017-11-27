<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
//echo '<pre>';var_dump($_POST);echo '</pre>';exit;
if($_SERVER['HTTPS']!='on'&&$_GET['action']!='synchronization_ad_users'&&$_GET['action']!='docronreports'){
	header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	exit;
}

$time_start = getmicrotime(); 

function getmicrotime() {
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec);
}

require_once('./include/global.func.php');
require_once('./include/common.inc.php');
require_once(ROOT . './include/email.php');
require_once(ROOT . './controller/c_base.class.php');

header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
session_cache_limiter("no-cache");
session_start();
ob_start();
$settingobj = new setting_set();		
//$logintimeout = $setting->select_all(" sname='logintimeout'");
/*$setting = $settingobj->select_all(" sname='password_policy'");
$pwdconfig = unserialize($setting[0]['svalue']);
$priority_cache = $settingobj->select_all("sname='priority_cache'");
$_CONFIG['priority_cache'] = $priority_cache[0]['svalue'];
$ldap = $settingobj->select_all("sname='ldap'");
$_CONFIG['LDAP'] = $ldap[0]['svalue'];
$Certificate = $settingobj->select_all("sname='Certificate'");
$_CONFIG['Certificate'] = $Certificate[0]['svalue'];
$Async = $settingobj->select_all("sname='Async'");
$_CONFIG['Async'] = $Async[0]['svalue'];
$rdpinput = $settingobj->select_all("sname='RdpInput'");
$_CONFIG['rdpinput'] = $rdpinput[0]['svalue'];
$rdprunning = $settingobj->select_all("sname='RdpRunning'");
$_CONFIG['rdprunning'] = $rdprunning[0]['svalue'];
$rdptolocal = $settingobj->select_all("sname='RdpToLocal'");
$_CONFIG['RDPAUTH_TO_LOCALAUTH'] = $rdptolocal[0]['svalue'];
$rdpauthtips = $settingobj->select_all("sname='rdpauthtips'");
$_CONFIG['RDPAUTH_TO_LOCALAUTH_TIPS'] = $rdpauthtips[0]['svalue'];
$loginwrongtips = $settingobj->select_all("sname='loginwrongtips'");
$_CONFIG['WEBLOGINWRONGTIP'] = $loginwrongtips[0]['svalue'];
$asyncoutpass = $settingobj->select_all("sname='AsyncoutPass'");
$_CONFIG['AsyncoutPass'] = $asyncoutpass[0]['svalue'];*/

$where = "sname='password_policy' ";
$where .= " or sname='priority_cache' ";
$where .= " or sname='ldap' ";
$where .= " or sname='Certificate' ";
$where .= " or sname='Async' ";
$where .= " or sname='RdpInput' ";
$where .= " or sname='RdpRunning' ";
$where .= " or sname='RdpToLocal' ";
$where .= " or sname='rdpauthtips' ";
$where .= " or sname='loginwrongtips' ";
$where .= " or sname='AsyncoutPass' ";
$where .= " or sname='PASSWORD_ENCRYPT_TYPE' ";
$where .= " or sname='ACCEPT' ";
$where .= " or sname='WorkFlowAdmin' ";
$where .= " or sname='RdpClientVersion' ";
$where .= " or sname='RDPPLAYIP' ";
$where .= " or sname='FingerSecServer' ";
$settings = $settingobj->select_all($where);
for($i=0; $i<count($settings); $i++){
	switch ($settings[$i]['sname']){
		case 'password_policy':
			$pwdconfig = unserialize($settings[$i]['svalue']);
			break;
		case 'priority_cache':
			$_CONFIG['priority_cache'] = $settings[$i]['svalue'];
			break;
		case 'ldap':
			$_CONFIG['LDAP'] = $settings[$i]['svalue'];
			break;
		case 'Certificate':
			$_CONFIG['Certificate'] = $settings[$i]['svalue'];
			break;
		case 'Async':
			$_CONFIG['Async'] = $settings[$i]['svalue'];
			break;
		case 'RdpInput':
			$_CONFIG['rdpinput'] = $settings[$i]['svalue'];
			break;
		case 'RdpRunning':
			$_CONFIG['rdprunning'] = $settings[$i]['svalue'];
			break;
		case 'RdpToLocal':
			$_CONFIG['RDPAUTH_TO_LOCALAUTH'] = $settings[$i]['svalue'];
			break;
		case 'rdpauthtips':
			$_CONFIG['RDPAUTH_TO_LOCALAUTH_TIPS'] = $settings[$i]['svalue'];
			break;
		case 'loginwrongtips':
			$_CONFIG['WEBLOGINWRONGTIP'] = $settings[$i]['svalue'];
			break;
		case 'AsyncoutPass':
			$_CONFIG['AsyncoutPass'] = $settings[$i]['svalue'];
			break;
		case 'PASSWORD_ENCRYPT_TYPE':
			$_CONFIG['PASSWORD_ENCRYPT_TYPE'] = $settings[$i]['svalue'];
			break;
		case 'ACCEPT':
			$_CONFIG['ACCEPT'] = $settings[$i]['svalue'];
			break;
		case 'WorkFlowAdmin':
			$_CONFIG['WorkFlowAdmin'] = explode(',', $settings[$i]['svalue']);
			break;
		case 'RdpClientVersion':
			$_CONFIG['RdpClientVersion'] = explode(',', $settings[$i]['svalue']);
			break;
		case 'RDPPLAYIP':
			$_CONFIG['RDPPLAYIP'] = $settings[$i]['svalue'];
			break;
		case 'FingerSecServer':
			$_CONFIG['fingersecserver'] = $settings[$i]['svalue'];
			break;
	}
}


$PasswordKey = $settingobj->base_select("SELECT udf_decrypt(svalue) AS pass FROM setting WHERE  sname='PasswordKey'");
$_CONFIG['PASSWORD_KEY'] = $PasswordKey[0]['pass'];

$member = new member_set();	
$minfo = $member->select_all("username='".$_SESSION['ADMIN_USERNAME']."'");
$minfo=$minfo[0];
$_CONFIG['site']['items_per_page']=$minfo['rows'];
ob_end_clean();	
//var_dump(isset($_SESSION["ADMIN_LOGINED"]));
//var_dump(empty($minfo['webportal']) && (time()-$_SESSION['startonlinetime'] > $pwdconfig['logintimeout']*60));
//var_dump((!empty($minfo['webportal'])&&$minfo['webportallogin']+(empty($minfo['webportaltime']) ? 24*60 : $minfo['webportaltime'])*60<time()));
$sessionexpired = (empty($minfo['webportal']) && (time()-$_SESSION['startonlinetime'] > $pwdconfig['logintimeout']*60) || (!empty($minfo['webportal'])&&$minfo['webportallogin']<time()));
$cologinauth = (($minfo['usbkey']&&$minfo['usbkeystatus']==11) || $minfo['authtype']&&($minfo['radiusauth']||$minfo['ldapauth']||$minfo['adauth']||intval($minfo['auth'])==2));

if($_GET['controller']=='admin_interface'&&$_CONFIG['interfacesn_on']&&($_POST['sn']==$_CONFIG['interfacesn'] or $_GET['action']=='getQrcode'&&$_GET['sn']==$_CONFIG['interfacesn'])){
	$minfo = $member->select_all("username='admin'");
	$_SESSION['ADMIN_LOGINED'] = true;
	$_SESSION['ADMIN_USERNAME'] =  'admin';
	$_SESSION['ADMIN_LEVEL'] = $minfo[0]['level'];
	$_SESSION['ADMIN_UID'] = $minfo[0]['uid'];
	$_SESSION['ADMIN_GROUP'] = (int)$minfo[0]['groupid'];
	$_SESSION['ADMIN_FLIST'] = unserialize($minfo[0]['flist']);
	$_SESSION['ADMIN_LASTDATE'] = $minfo[0]['lastdate'];
	$_SESSION['ADMIN_IP'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['ADMIN_MUSERGROUP'] = $minfo[0]['musergroup'];
	$_SESSION['ADMIN_MUSERGROUPTYPE'] = $minfo[0]['musergrouptype'];
	$_SESSION['ADMIN_MSERVERGROUP'] = $minfo[0]['mservergroup'];
	$_SESSION['ADMIN_LOGINDATE'] = date('Y-m-d H:i:s');
	$_SESSION['LOGIN_RADIUS_TO_LOCAL'] = 0;
	$minfo = $minfo[0];

}else if($_GET['controller']=='admin_commonuser'){
	$username=$_POST['username'];
	$password=$_POST['password'];
	$minfo = $member->select_all("username='".$username."'");
	if($_GET['action']=='check'){
		$minfo[0]['password']=$member->udf_decrypt($minfo[0]['password']);
		$result['result']=($minfo&&$password== $minfo[0]['password']? 1 : 0);
		$result['msg']=$result['result'] ? 'login success!' : 'username and password does not match!';
		$result['data']=$minfo[0];
		echo json_encode($result);
		exit;
	}elseif($minfo&&$password==$member->udf_decrypt($minfo[0]['password'])){
		$_SESSION['ADMIN_LOGINED'] = true;
		$_SESSION['ADMIN_USERNAME'] =  $minfo[0]['username'];
		$_SESSION['ADMIN_LEVEL'] = $minfo[0]['level'];
		$_SESSION['ADMIN_UID'] = $minfo[0]['uid'];
		$_SESSION['ADMIN_GROUP'] = (int)$minfo[0]['groupid'];
		$_SESSION['ADMIN_FLIST'] = unserialize($minfo[0]['flist']);
		$_SESSION['ADMIN_LASTDATE'] = $minfo[0]['lastdate'];
		$_SESSION['ADMIN_IP'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['ADMIN_MUSERGROUP'] = $minfo[0]['musergroup'];
		$_SESSION['ADMIN_MUSERGROUPTYPE'] = $minfo[0]['musergrouptype'];
		$_SESSION['ADMIN_MSERVERGROUP'] = $minfo[0]['mservergroup'];
		$_SESSION['ADMIN_LOGINDATE'] = date('Y-m-d H:i:s');
		$_SESSION['LOGIN_RADIUS_TO_LOCAL'] = 0;
		$minfo = $minfo[0];
	}else{
		$result['result']=0;
		$result['msg']='username and password does not match!';
		$result['data']=array();
		echo json_encode($result);
		exit;
	}
}else if(isset($_SESSION["ADMIN_LOGINED"]) && $sessionexpired &&!( $cologinauth&&empty($_SESSION['USER_MULTI_LOGIN_VALIDATED']))){
	session_destroy();
	$ref = get_request('ref', 0, 1);
	if(empty($ref)){
		$ref = $_SERVER["QUERY_STRING"]; 
	}
	if(strstr($ref,"login") || strstr($ref,"ref")){
		$ref='';
	}
	go_url("admin.php?controller=admin_index&action=login&ref=".urlencode($ref), 1);
	exit;
}else if(isset($_SESSION["ADMIN_LOGINED"])){
	$_SESSION['startonlinetime'] = time();
	$_SESSION['sess_user_id']=1;
}
if(isset($_GET['controller'])) {
	$controller = 'c_' . $_GET['controller'];
}
else {
	$controller = 'c_admin_index';
}

if(!empty($_GET['action'])) {
	$action = $_GET['action'];
}
else {
	$action = 'index';
}
$language = array('en','cn');
define("LANGUAGE", 'cn');
require_once(ROOT . './include/language_cn.php');
if(in_array(LANGUAGE,$language)){
	require_once(ROOT . './include/language_'.LANGUAGE.'.php');
}
if($_SESSION['ADMIN_UID']){
	ob_start();
	$_SESSION['ADMIN_LEVEL'] = $minfo['level'];					
	$_SESSION['ADMIN_UID'] = $minfo['uid'];					
	$_SESSION['ADMIN_FREESVRDEBUG'] = $minfo['freesvrdebug'];	
	$_CONFIG['DB_DEBUG']=($minfo['dbdebug']||$_CONFIG['DB_DEBUG']);	
	$_CONFIG['LOGIN_DEBUG'] = ($minfo['logindebug']||$_CONFIG['LOGIN_DEBUG']);			
	$_SESSION['ADMIN_SEARCHCACHE'] = $minfo['searchcache'];
	$_SESSION['ADMIN_GROUP'] = (int)$minfo['groupid'];
	$_SESSION['ADMIN_MSERVERGROUP'] = $minfo['mservergroup'];
	$_SESSION['ADMIN_MUSERGROUP'] = $minfo['musergroup'];	
	$_SESSION['ADMIN_MUSERGROUPTYPE'] = (int)$minfo['musergrouptype'];
	if(isset($_SESSION['ADMIN_CHROLE_LEVEL'])){
		$_SESSION['ADMIN_LEVEL'] = $_SESSION['ADMIN_CHROLE_LEVEL'];
	}
	ob_end_clean();		
	//var_dump($_SESSION['logintype']);
	if(!isset($_SESSION['JUSTLOGINSHOWPWDEDIT'])&&($minfo['searchcache']&&$minfo['cachechange'])&&$action!='menu'&&!($controller=='c_admin_index'&&($action=='index' || $action=='changerole'))&&$action!='save_self'&&$action!='logout'&&$action!='doqrcode'&&$action!='doaccept'&&$action!='get_sms'&&$action!='jiekouyanz'&&$action!='login_tip'&&$action!='get_user_login_fristauth'&&$_SESSION['authtype']=='localauth'){
		//$controller = 'c_admin_member';
		//$action = 'edit_self';
		echo '<script>if(confirm("权限已更新，请更新缓存")) window.location="admin.php?controller=admin_index&action=do_devices_cache";</script>';
		$_SESSION['JUSTLOGINSHOWPWDEDIT']='on';
	}

	

	if(!isset($_SESSION['JUSTLOGINSHOWPWDEDIT'])&&((time()-$minfo['lastdateChpwd'])/(24*3600) > ($pwdconfig['pwdexpired']-$pwdconfig['pwdahead'])||$minfo['forceeditpassword'])&&$action!='menu'&&!($controller=='c_admin_index'&&($action=='index' || $action=='changerole'))&&$action!='save_self'&&$action!='logout'&&$action!='doqrcode'&&$action!='doaccept'&&$action!='get_sms'&&$action!='jiekouyanz'&&$action!='login_tip'&&$action!='get_user_login_fristauth'&&$_SESSION['authtype']=='localauth'){
			$controller = 'c_admin_member';
			$action = 'edit_self';
			$_GET['msg']='changepwd';
			$_SESSION['JUSTLOGINSHOWPWDEDIT']='on';
	}
	
	if(((time()-$minfo['lastdateChpwd'])/(24*3600) > ($pwdconfig['pwdexpired']/*-$pwdconfig['pwdahead']*/)||$minfo['forceeditpassword'])&&$action!='menu'&&!($controller=='c_admin_index'&&($action=='index' || $action=='changerole'))&&$action!='save_self'&&$action!='logout'&&$action!='doqrcode'&&$action!='doaccept'&&$action!='get_sms'&&$action!='jiekouyanz'&&$action!='login_tip'&&$action!='get_user_login_fristauth'&&$_SESSION['authtype']=='localauth'){
			$controller = 'c_admin_member';
			$action = 'edit_self';
			$_GET['msg']='changepwd';
	}

	if(empty($_SESSION['USER_LOGIN_ACCEPT'])&&$_CONFIG['ACCEPT']&&$_SESSION['ADMIN_LEVEL']==0&&$action!='menu'&&$action!='logout'&&$action!='doqrcode'&&$action!='doaccept'&&$action!='get_sms'&&$action!='jiekouyanz'&&$action!='login_tip'&&$action!='get_user_login_fristauth'&&$action!='save_self'){
			$controller = 'c_admin_index';
			$action = 'accept';
	}

	$pwdremain = round($pwdconfig['pwdexpired'] - (time()-$minfo['lastdateChpwd'])/(24*3600),0);
	$_CONFIG['PWD_REMAIN_DAYS'] = $pwdremain >=0 ? $pwdremain.'天' : '<font color="red">已过期</font>';

	$cologinauth = (($minfo['usbkey']&&$minfo['usbkeystatus']==11) || $minfo['authtype']&&($minfo['radiusauth']||$minfo['ldapauth']||$minfo['adauth']||intval($minfo['auth'])==2));
	if($cologinauth&&empty($_SESSION['USER_MULTI_LOGIN_VALIDATED'])&&$action!='menu'&&$action!='logout'&&$action!='doqrcode'&&$action!='doaccept'&&$action!='get_sms'&&$action!='jiekouyanz'&&$action!='login_tip'&&$action!='get_user_login_fristauth'&&$action!='save_self'){
			$controller = 'c_admin_index';
			$action = 'qrcode';
	}

	

	//$member->query("drop table if exists sgrouptmp");
	
	$group_set = new usergroup_set();
	$_SESSION['ADMIN_MSERVERGROUP_IDS'] = array(-1);
	$_SESSION['ADMIN_MSERVERGROUP_PARENT_IDS'] = array(-1);
	if(($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101)&&$_SESSION['ADMIN_MSERVERGROUP']){
		$_mservergroup=explode(',', $_SESSION['ADMIN_MSERVERGROUP']);
		for($i=0; $i<count($_mservergroup); $i++){
			$msgroup = $group_set->select_by_id($_mservergroup[$i]);
			$_SESSION['ADMIN_MSERVERGROUP_IDS']=array_merge(explode(',', $msgroup['child']), $_SESSION['ADMIN_MSERVERGROUP_IDS']);
			while($msgroup['ldapid']){
				$msgroup = $group_set->select_by_id($msgroup['ldapid']);
				$_SESSION['ADMIN_MSERVERGROUP_PARENT_IDS'][] = $msgroup['id']; 
			}
		}

	}
	$_SESSION['ADMIN_MUSERGROUP_IDS'] =$_SESSION['ADMIN_MSERVERGROUP_IDS'];
	if($_GET['orderby1']&&strpos($_GET['orderby1'], ';')!==false){
		$_GET['orderby1'] = '';
	}
	if($_GET['orderby2']&&strpos($_GET['orderby2'], ';')!==false){
		$_GET['orderby2'] = '';
	}
}
if(file_exists(ROOT ."./controller/$controller.class.php")) {
	require_once(ROOT ."./controller/$controller.class.php");	
	
	if((!isset($_SESSION["ADMIN_LOGINED"]) || $_SESSION["ADMIN_LOGINED"] == false) && ($action != 'login_user_field' && $action != 'login' && $action !='chklogin' && $action != 'getpwd'&& $action != 'docronreports'&& $action != 'synchronization_ad_users'&&$action!='get_user_login_fristauth'&& $action != 'get_sms'&&$action!='jiekouyanz')) {
		//go_url("admin.php?controller=admin_index&action=login");
		go_url("admin.php?controller=admin_index&action=login", 1);
	}
	else {
		require_once('include/priority.php');
		//权限控制
		if(!isset($_SESSION["ADMIN_LEVEL"]) || $_SESSION["ADMIN_LEVEL"] != 1) {
			$nopower = false;
			if($controller == 'c_admin_backup' && $_SESSION["ADMIN_LEVEL"]!=10  ) {
				$nopower = true;	
			}
			else if($controller == 'c_admin_session' && $_SESSION["ADMIN_LEVEL"]!=2) {
				if($action == 'del_command' || $action == 'del_session' || $action == 'delete') {
					$nopower = true;
				}	
			}
			else if($controller == 'c_admin_member' && $_SESSION["ADMIN_LEVEL"]!=3&& $_SESSION["ADMIN_LEVEL"]!=21&& $_SESSION["ADMIN_LEVEL"]!=101&& $_SESSION["ADMIN_LEVEL"]!=4) {
				if($action != 'edit_self' && $action != 'save_self'&& $action != 'userdisk'&& $action != 'login4approve'&& $action != 'dologin4approve'&& $action != 'dellogin4approve') {
					$nopower = true;
				}
			}
			else if($controller == 'c_admin_facility') {
				if($action == 'add' || $action == 'delete' || $action == 'edit' || $action == 'cover') {
					$nopower = true;
				}
			}
			else if($controller == 'c_admin_auto') {
				if($action == 'user_del' || $action == 'net_del') {
					$nopower = true;
				}
			}
			
			if($nopower) {
				die('没有权限');
			}
		}
		//Smarty初始化
		$smarty = new Smarty; 
		$smarty->template_dir = ROOT . "./template/admin";
		$smarty->compile_dir = ROOT . "./template_c/admin";
		$smarty->cache_dir = './template_cache/admin';
		$smarty->left_delimiter = "{{"; 
		$smarty->right_delimiter = "}}";
		$smarty->setCaching(0);
		$smarty->assign('template_root', './template/admin');
		
		$_SESSION['CACTI_CONFIG_ON']=$_CONFIG['CACTI_ON'];
		$_SESSION['LOG_CONFIG_ON']=$_CONFIG['LOG_ON'];
		$_SESSION['DBAUDIT_CONFIG_ON']=$_CONFIG['DBAUDIT_ON'];
		$_SESSION['AUDIT']=$_CONFIG['AUDIT'];


		$log_db_file = @file(ROOT."/include/db_connect.inc.php");
		for($i=0; $i<count($log_db_file); $i++){
			if(strpos($log_db_file[$i], "\$dbname")!==false){
				$log_db_file[$i] = trim($log_db_file[$i]);
				$log_db_file[$i] = trim(substr($log_db_file[$i], strpos($log_db_file[$i], "=")+1));
				$log_db_file[$i] = trim(substr($log_db_file[$i], 1, strlen($log_db_file[$i])-2));
				$log_db_file[$i] = substr($log_db_file[$i], 0, strlen($log_db_file[$i])-1);
				define("LOG_DBNAME", $log_db_file[$i]);
				break;
			}
		}

		$log_db_file = @file(ROOT."/dbaudit/include/db_connect.inc.php");
		for($i=0; $i<count($log_db_file); $i++){
			if(strpos($log_db_file[$i], "\$dbname")!==false){
				$log_db_file[$i] = trim($log_db_file[$i]);
				$log_db_file[$i] = trim(substr($log_db_file[$i], strpos($log_db_file[$i], "=")+1));
				$log_db_file[$i] = trim(substr($log_db_file[$i], 1, strlen($log_db_file[$i])-2));
				$log_db_file[$i] = substr($log_db_file[$i], 0, strlen($log_db_file[$i])-1);
				define("DBAUDIT_DBNAME", $log_db_file[$i]);
				break;
			}
		}
		
		$member   = new member_set();
		
		
		//设置语言
		//print_r($$_CONFIG['site']['Language']);
		//var_dump($_COOKIE['LANGUAGE']);
		$smarty->assign("language", ${LANGUAGE});
		//设置语言结束
		//创建控制器
		$newcontroller = new $controller();

		$newcontroller->init($smarty, $_CONFIG);
		//执行控制器的方法的
		
		if(method_exists($newcontroller, $action)) {
			if(isset($_SESSION["ADMIN_LEVEL"])) {
				$newcontroller->assign('admin_level', $_SESSION['ADMIN_LEVEL']);
			}
			$ref = get_request('ref', 0, 1);
			//echo urldecode($ref);
			if(strstr($ref,"login") || strstr($ref,"ref")){
				$ref='';
			}
			$sgroupset = new sgroup_set();
			if($controller='c_admin_pro'&&(in_array($action, array('dev_group')))){
				//$sgroupset->upgroups();
			}
			$newcontroller->assign("ref", urldecode($ref));
			$newcontroller->$action();

			$update_group_cache = ($controller='c_admin_member'&&(in_array($action, array('save','delete','batchadd_save','domemberimport')))||$controller='c_admin_pro'&&(in_array($action, array('dev_save','dev_del','batchdevsave','dodevimport','groupadddev_save','dev_group_save'))));
			if($update_group_cache){
				/*$member->query("create table if not exists sgrouptmp(id int(11) not null default 0, pid int(11) not null default 0, count int(11) not null default 0, mcount int(11) not null default 0,level tinyint(1) not null default 0)");
				$member->query("truncate table sgrouptmp");
				$member->query("insert into sgrouptmp(id, pid, level) select id,id,level FROM servergroup union select id,ldapid,level FROM servergroup WHERE level=0 and id>0 and ldapid>0 union select id,ldapid,level FROM servergroup WHERE level=2 union select id,ldapid,level FROM servergroup WHERE level=3 union select id,ldapid,level FROM servergroup WHERE level=4 union select id,ldapid,level FROM servergroup WHERE level=5 union select c.id,a.id,c.level FROM servergroup a left join servergroup b on a.id=b.ldapid left join servergroup c on b.id=c.ldapid where c.id>0 and a.id>0 union select d.id,a.id,d.level FROM servergroup a left join servergroup b on a.id=b.ldapid left join servergroup c on b.id=c.ldapid left join servergroup d on c.id=d.ldapid where d.id>0 and a.id>0 union select e.id,a.id,e.level FROM servergroup a left join servergroup b on a.id=b.ldapid left join servergroup c on b.id=c.ldapid left join servergroup d on c.id=d.ldapid left join servergroup e on d.id=e.ldapid where e.id>0 and a.id>0 union select f.id,a.id,f.level FROM servergroup a left join servergroup b on a.id=b.ldapid left join servergroup c on b.id=c.ldapid left join servergroup d on c.id=d.ldapid left join servergroup e on d.id=e.ldapid left join servergroup f on e.id=f.ldapid where f.id>0 and a.id>0");				
				$member->query("update sgrouptmp set count=(select count(*) from servers where sgrouptmp.id=groupid)");
				$member->query("update sgrouptmp set mcount=(select count(*) from member where sgrouptmp.id=groupid)");
				$member->query("UPDATE servergroup s SET count=(SELECT sum(count) FROM sgrouptmp WHERE pid=s.id)");
				$member->query("UPDATE servergroup s SET mcount=(SELECT sum(mcount) FROM sgrouptmp WHERE pid=s.id)");
				$member->query("UPDATE servergroup s SET child=(SELECT group_concat(id) FROM sgrouptmp WHERE pid=s.id )");
				
				
				//$sgroupset->updatechild();
				$sgroupset->upgroups();*/ 
			}

		}
		else {
			echo "无效的操作2";
		}
	}
}
else {
	echo "无效的操作";
}

$time_end = getmicrotime(); 
/*if($action!='menu'&&($controller!='c_admin_index'|| $controller='c_admin_index'&&$action!='index'))
printf ("[页面执行时间: %.2f秒]",($time_end - $time_start)); 
*/
?>
