<?php /* Smarty version 3.1.27, created on 2016-12-24 21:59:40
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/pass_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1915506333585e7f4cf0a254_55983602%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0561329effe2c8444e70be6cca527d6f162ccb4f' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/pass_edit.tpl',
      1 => 1482587660,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1915506333585e7f4cf0a254_55983602',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'allradiusmem' => 0,
    'allmem' => 0,
    'radiususer' => 0,
    'id' => 0,
    'ip' => 0,
    'serverid' => 0,
    'gid' => 0,
    '_config' => 0,
    'from' => 0,
    'fromdevpriority' => 0,
    'webuser' => 0,
    'webgroup' => 0,
    'trnumber' => 0,
    'language' => 0,
    'username' => 0,
    'entrust_username' => 0,
    'password' => 0,
    'allmethod' => 0,
    'l_id' => 0,
    'sftp' => 0,
    'port' => 0,
    'sshport' => 0,
    'limit_time' => 0,
    'nolimit' => 0,
    'encoding' => 0,
    'allmembers' => 0,
    'commanduser' => 0,
    'mode' => 0,
    'enable' => 0,
    'auto' => 0,
    'master_user' => 0,
    'su_passwd' => 0,
    'entrust_password' => 0,
    'logincommit' => 0,
    'publickey_auth' => 0,
    'keys' => 0,
    'pubkey' => 0,
    'ipv6enable' => 0,
    'dipv6enable' => 0,
    'key_input' => 0,
    'fastpath_input' => 0,
    'fastpath_output' => 0,
    'usergroup' => 0,
    'sessionlgroup' => 0,
    'sessionluser' => 0,
    'logtab' => 0,
    'telnetport' => 0,
    'ftpport' => 0,
    'rdpport' => 0,
    'vncport' => 0,
    'x11port' => 0,
    'devicetype' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_585e7f4d445d56_70524455',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_585e7f4d445d56_70524455')) {
function content_585e7f4d445d56_70524455 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1915506333585e7f4cf0a254_55983602';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 src="./template/admin/cssjs/global.functions.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/_ajaxdtree.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 language="javascript">
function check_add_user(){
	return(true);
}

var AllRadiusMember = new Array();
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['name'] = 'kk';
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allradiusmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total']);
?>
AllRadiusMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
] = new Array();
AllRadiusMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['username']='<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['username'];?>
';
AllRadiusMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['uid']='<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['uid'];?>
';
<?php endfor; endif; ?>

var AllMember = new Array();
i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['name'] = 'kk';
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total']);
?>
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
] = new Array();
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['username']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['username'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['realname']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['realname'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['uid']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['uid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['groupid']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['groupid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['check']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['check'];?>
';
<?php endfor; endif; ?>

function filter(){
	var filterStr = document.getElementById('username').value;
	var usbkeyid = document.getElementById('memberselect');
	usbkeyid.options.length=1;
	for(var i=0; i<AllRadiusMember.length;i++){
		if(filterStr.length==0 || AllRadiusMember[i]['username'].indexOf(filterStr) >= 0){
			usbkeyid.options[usbkeyid.options.length++] = new Option(AllRadiusMember[i]['username'],AllRadiusMember[i]['uid']);
		}
	}
}

function change_for_user_auth(){
	<?php if ($_smarty_tpl->tpl_vars['radiususer']->value) {?>
	 document.getElementById('fort_user_auth').checked=true;
	 <?php }?>
	var change_user_auth = document.getElementById('fort_user_auth').checked;
	if(change_user_auth){
		document.getElementById('username').readOnly  = true;
		document.getElementById('password_confirm').readOnly  = true;
		document.getElementById('password').readOnly  = true;
		<?php if (empty($_smarty_tpl->tpl_vars['id']->value)) {?>document.getElementById('memberselect').style.display='';<?php }?>		
	}else{
		document.getElementById('username').readOnly  = false;
		document.getElementById('password_confirm').readOnly  = false;
		document.getElementById('password').readOnly  = false;
		document.getElementById('memberselect').style.display='none';
	}
}

function usernameselect(){
	document.getElementById('username').value = (document.getElementById('memberselect').options.selectedIndex==0 ? document.getElementById('username').value : document.getElementById('memberselect').options[document.getElementById('memberselect').options.selectedIndex].text);
}

function temptyuser(check){
	if(check){
		document.getElementById('username').value='';
		//document.getElementById('password').value='';
		//document.getElementById('password_confirm').value='';
		document.getElementById('automp').checked=false;
		document.getElementById('automp2').checked=false;
		document.getElementById('publickey_auth').checked=false;
		document.getElementById('autotr').style.display='none';
		document.getElementById('publickey_authtr').style.display='none';
		document.getElementById('automutr').style.display='none';
	}else{
		document.getElementById('autotr').style.display='';
		if(document.getElementById("ssh").selected==true)
		document.getElementById('publickey_authtr').style.display='';
		document.getElementById('automutr').style.display='';
	}
}

function searchit(){
	var url = "admin.php?controller=admin_pro&action=pass_edit&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&from=<?php echo $_GET['from'];?>
";
	url += "&webuser="+document.f1.elements.webuser.value;
	url += "&webgroup="+document.f1.elements.webgroup.value;
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['TREEMODE']) {?>
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	<?php } else { ?>
	for(var i=1; true; i++){
		var obj=document.getElementById('groupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	<?php }?>
	url += "&g_id="+gid;
	<?php }?>
	window.location.href= url;
	return false;
}

<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
var foundparent = false;
var servergroup = new Array();
<?php }?>
<?php echo '</script'; ?>
>
<style type="text/css">
a {
    color: #003499;
    text-decoration: none;
} 
a:hover {
    color: #000000;
    text-decoration: underline;
}
</style>
</head>
 <SCRIPT language=javascript src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/selectdate.js"></SCRIPT>

<body onbeforeunload="saveTitle(event)">


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu" style="width:1100px;">
<ul>
<?php if ($_SESSION['ADMIN_LEVEL'] == 10) {?>
<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php } elseif ($_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
<?php } else { ?>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php if ($_smarty_tpl->tpl_vars['from']->value == 'dir') {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php } else { ?>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['from']->value == 'dir') {?>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php } else { ?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php if ($_SESSION['ADMIN_LEVEL'] == 1) {?>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
<?php }?>
</ul><span class="back_img"><A href="admin.php?<?php if ($_GET['from'] == 'passview') {?>controller=admin_index&action=main<?php } else { ?>controller=admin_pro&action=<?php if ($_smarty_tpl->tpl_vars['fromdevpriority']->value) {?>dev_priority_search<?php } else { ?>devpass_index&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;
}
}?>&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
<tr>
	<td class="">
    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#ffffff" class="BBtable" >
	<TR>
	<TD colspan="3" height="33" class="main_content">
	<form name ='f1' action='admin.php?controller=admin_pro&action=pass_edit' method=post>
	资源组：<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
&nbsp;&nbsp;&nbsp;&nbsp;运维用户过滤<input type="text" class="wbk" name="webuser" value="<?php echo $_smarty_tpl->tpl_vars['webuser']->value;?>
">
	资源组<input type="text" class="wbk" name="webgroup" value="<?php echo $_smarty_tpl->tpl_vars['webgroup']->value;?>
">
	&nbsp;&nbsp;<input  type="button" value=" 提交 " onClick="return searchit();" class="bnnew2">
	</form>
	</TD>
  </TR>

<form name="f2" method=post action="admin.php?controller=admin_pro&action=pass_save&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&from=<?php echo $_GET['from'];?>
" enctype="multipart/form-data" onsubmit="javascript:saveAccount=false;">
	<input type="password" name="hiddenpassword" id="hiddenpassword" style="display:none"/> <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="usernametr">
		<td width="20%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['Username'];?>

		</td>
		<td width="80%">
		<input type=text name="username" id="username" size=35 value="<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
"  onchange="filter();" >&nbsp;&nbsp;
			<select  class="wbk"  id="memberselect" name="memberselect" style="display:none" onchange="usernameselect();">
				<OPTION value="">请选择</OPTION>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allradiusmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total']);
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'] == $_smarty_tpl->tpl_vars['radiususer']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['username'];?>
</option>
				<?php endfor; endif; ?>
			</SELECT> &nbsp;&nbsp;<input type="checkbox" name="entrust_username" value="on" <?php if ($_smarty_tpl->tpl_vars['id']->value && $_smarty_tpl->tpl_vars['entrust_username']->value == 0) {?>checked<?php }?> onclick="temptyuser(this.checked);">空用户
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="originalpasswordtr">
		<td width="20%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['originalpassword'];?>

		</td>
		<td width="80%">
		<input type=password name="password" id="password" size=35 value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['password']->value);?>
" >&nbsp;&nbsp;<span >RADIUS用户认证：<input type="checkbox" name="radiususer" id="fort_user_auth" <?php if ($_smarty_tpl->tpl_vars['radiususer']->value) {?> checked <?php }?> value="on" onclick="change_for_user_auth();" /></span>
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>  id="originalpassword2tr">
		<td width="20%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['Inputoriginalpasswordagain'];?>

		</td>
		<td width="80%">
		<input type=password name="password_confirm" id="password_confirm" size=35 value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['password']->value);?>
" >
	  </td>
	</tr>

	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="loginmodetr">
		<td width="20%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['Loginmode'];?>
	
		</td>
		<td width="80%">
				<select  class="wbk"  name="l_id" onchange="changeport(1)">
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['g'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['g']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['name'] = 'g';
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmethod']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total']);
?>
			<OPTION id ="<?php echo $_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['login_method'];?>
" VALUE="<?php echo $_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'] == $_smarty_tpl->tpl_vars['l_id']->value) {?>selected<?php }?>><?php if ($_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['login_method'] == 'apppub') {?>应用发布<?php } else {
echo $_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['login_method'];
}?></option>
		<?php endfor; endif; ?>
		</select>
		<span id="sftp_tr">是否支持sftp传输:<INPUT id="sftp" <?php if ($_smarty_tpl->tpl_vars['sftp']->value == 1) {?> checked <?php }?> type=checkbox name=sftp value="on"> </span>
	  </td>
	</tr>

	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>  id="porttr">
	  		<td width="20%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['port'];?>
	
		</td>
		<td width="80%">
		<input type=text name="port" id="port" size=4 value="<?php if ($_smarty_tpl->tpl_vars['port']->value) {
echo $_smarty_tpl->tpl_vars['port']->value;
} else {
echo $_smarty_tpl->tpl_vars['sshport']->value;
}?>" >
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="expiretr">
		<td width="20%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['Expiretime'];?>

		</td>
       <TD width="80%"><INPUT value="<?php echo $_smarty_tpl->tpl_vars['limit_time']->value;?>
" id="limit_time" name="limit_time">
                      <IMG onClick="getDatePicker('limit_time', event)" 
                                src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/time.gif"> <?php echo $_smarty_tpl->tpl_vars['language']->value['clicktoselectdate'];
echo $_smarty_tpl->tpl_vars['language']->value['or'];
echo $_smarty_tpl->tpl_vars['language']->value['select'];?>
 <?php echo $_smarty_tpl->tpl_vars['language']->value['AlwaysValid'];?>
<INPUT <?php if ($_smarty_tpl->tpl_vars['nolimit']->value == 1) {?> checked <?php }?> type=checkbox name="nolimit">  
                                </TD>
	</tr>
    <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="loginmodetr">
		<td width="20%" align=right>
		用户终端
		</td>
		<td width="80%">
		<select  class="wbk"  name="encoding" >
			<OPTION VALUE="0" <?php if (!$_smarty_tpl->tpl_vars['encoding']->value) {?>selected<?php }?>>默认</option>
			<OPTION VALUE="1" <?php if ($_smarty_tpl->tpl_vars['encoding']->value) {?>selected<?php }?>>GB2312</option>
		</select>
		
	  </td>
	</tr>
	
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="loginmodetr">
		<td width="20%" align=right>
		命令授权用户
		</td>
		<td width="80%">
		<select  class="wbk"  name="commanduser" >
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['m'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['m']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['name'] = 'm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmembers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total']);
?>
		<?php if ($_smarty_tpl->tpl_vars['allmembers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['username'] == 'admin') {?>
			<OPTION VALUE="<?php echo $_smarty_tpl->tpl_vars['allmembers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['allmembers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['uid'] == $_smarty_tpl->tpl_vars['commanduser']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['allmembers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['username'];?>
</option>
		<?php }?>
		<?php endfor; endif; ?>
		</select>
		
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="rdpmode">
		<td width="20%" align=right>
		RDP加密模式
		</td>
		<td width="80%">
		<select  class="wbk"  name="mode" >
			<OPTION VALUE="0" <?php if (!$_smarty_tpl->tpl_vars['mode']->value) {?>selected<?php }?>>自动</option>
			<OPTION VALUE="1" <?php if ($_smarty_tpl->tpl_vars['mode']->value == 1) {?>selected<?php }?>>RDP加密</option>
			<OPTION VALUE="2" <?php if ($_smarty_tpl->tpl_vars['mode']->value == 2) {?>selected<?php }?>>SSL加密</option>
		</select>
		
	  </td>
	</tr>
	
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> >
		<TD width="20%" align=right>启用 </TD>
                  <TD width="80%"><INPUT id="enable" <?php if ($_smarty_tpl->tpl_vars['enable']->value == 1) {?> checked <?php }?> type=checkbox name=enable value="on">                  </TD>
                </TR>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="autotr">
		<TD width="20%" align=right><?php echo $_smarty_tpl->tpl_vars['language']->value['automaticallyeditpassword'];?>
 </TD>
                  <TD width="80%"><INPUT id="automp" <?php if ($_smarty_tpl->tpl_vars['auto']->value == 1) {?> checked <?php }?> type=checkbox name=auto value="on">                  </TD>
                </TR>
	
          <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="automutr">
		<TD width="20%" align=right><?php echo $_smarty_tpl->tpl_vars['language']->value['masteraccountforeditingpassword'];?>
 </TD>
                  <TD width="80%"><INPUT id="automp2" <?php if ($_smarty_tpl->tpl_vars['master_user']->value == 1) {?> checked <?php }?> type=checkbox name=automu value="on">                  </TD>
                </TR>    
		<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="su_passwdtr" >
		<TD width="20%" align=right>改密时su为超级用户: </TD>
                  <TD width="80%"><INPUT id="su_passwd" <?php if ($_smarty_tpl->tpl_vars['su_passwd']->value == 1) {?> checked <?php }?> <?php if (!$_smarty_tpl->tpl_vars['id']->value && $_smarty_tpl->tpl_vars['su_passwd']->value) {?>checked<?php }?> type=checkbox name=su_passwd value="on">  
                </TR>    
           <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="entrust_passwordtr" >
		<TD width="20%" align=right>自动登录: </TD>
                  <TD width="80%"><INPUT id="entrust_password" <?php if ($_smarty_tpl->tpl_vars['entrust_password']->value == 1) {?> checked <?php }?> type=checkbox name=entrust_password value="on">                  </TD>
                </TR>    	
	 <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="logincommittr" >
		<TD width="20%" align=right>操作记录: </TD>
                  <TD width="80%"><INPUT id="logincommit" <?php if ($_smarty_tpl->tpl_vars['logincommit']->value == 1) {?> checked <?php }?> type=checkbox name=logincommit value="on">                  </TD>
                </TR>    
	 <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="publickey_authtr" >
		<TD width="20%" align=right>ssh认证方式: </TD>
                  <TD width="80%">
				  <select  class="wbk"  name="publickey_auth" onchange="changessh(this.value)">
					<OPTION VALUE="0" <?php if ($_smarty_tpl->tpl_vars['publickey_auth']->value == 0) {?> selected <?php }?>>用户名密码</option>
					<OPTION VALUE="1" <?php if ($_smarty_tpl->tpl_vars['publickey_auth']->value == 1) {?> selected <?php }?>>托管公私钥</option>
					<OPTION VALUE="2" <?php if ($_smarty_tpl->tpl_vars['publickey_auth']->value == 2) {?> selected <?php }?>>透传公私钥</option>
				</select>&nbsp;&nbsp;&nbsp;公私钥
				<select  class="wbk" id="publickey" name="publickey" <?php if ($_smarty_tpl->tpl_vars['publickey_auth']->value != 1) {?>disabled<?php }?>>
				<OPTION VALUE="0">无</option>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['p'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['p']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['name'] = 'p';
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['keys']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total']);
?>
					<OPTION VALUE="<?php echo $_smarty_tpl->tpl_vars['keys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['keys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p']['index']]['id'] == $_smarty_tpl->tpl_vars['pubkey']->value) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['keys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p']['index']]['sshkeyname'];?>
</option>
				<?php endfor; endif; ?>
				</select>
                </TR>    
     <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="ipv6tr" >
		<TD width="20%" align=right>IPV6优先: </TD>
                  <TD width="80%"><INPUT id="ipv6enable" <?php if ($_smarty_tpl->tpl_vars['ipv6enable']->value == 1) {?> checked <?php }?> <?php if (!$_smarty_tpl->tpl_vars['id']->value && $_smarty_tpl->tpl_vars['dipv6enable']->value) {?>checked<?php }?> type=checkbox name=ipv6enable value="on">  
                </TR>    
 <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="keyboardtr" >
		<TD width="20%" align=right>键盘记录: </TD>
                  <TD width="80%"><INPUT id="key_input" <?php if ($_smarty_tpl->tpl_vars['key_input']->value == 1) {?> checked <?php }?> <?php if (!$_smarty_tpl->tpl_vars['id']->value || $_smarty_tpl->tpl_vars['key_input']->value) {?>checked<?php }?> type=checkbox name=key_input value="on">  
                </TR>    
				 <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="forwardtr" >
		<TD width="20%" align=right>进向加速: </TD>
                  <TD width="80%"><INPUT id="fastpath_input" <?php if ($_smarty_tpl->tpl_vars['fastpath_input']->value == 1) {?> checked <?php }?> <?php if (!$_smarty_tpl->tpl_vars['id']->value && $_smarty_tpl->tpl_vars['fastpath_input']->value) {?>checked<?php }?> type=checkbox name=fastpath_input value="on">  
                </TR>    
				 <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="outforwardtr" >
		<TD width="20%" align=right>出向加速: </TD>
                  <TD width="80%"><INPUT id="fastpath_output" <?php if ($_smarty_tpl->tpl_vars['fastpath_output']->value == 1) {?> checked <?php }?> <?php if (!$_smarty_tpl->tpl_vars['id']->value && $_smarty_tpl->tpl_vars['fastpath_output']->value) {?>checked<?php }?> type=checkbox name=fastpath_output value="on">  
                </TR>    
				
         <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	  <td width="20%" align="right"  valign=top><?php echo $_smarty_tpl->tpl_vars['language']->value['bind'];
echo $_smarty_tpl->tpl_vars['language']->value['group'];?>

	  <table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' <?php if ($_GET['bindgroup'] == 1) {?>checked<?php }?> onclick="reload('bindgroup=1','bindgroup=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' <?php if ($_GET['bindgroup'] == 2) {?>checked<?php }?> onclick="reload('bindgroup=2','bindgroup=0',this.checked);"></td></tr>
	  </table>
	  </td>
	  <td >
	  <table>
	<tr>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['u'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['u']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['name'] = 'u';
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['usergroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total']);
?>
		<?php if (!$_GET['bindgroup'] || ($_GET['bindgroup'] == 2 && $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['check'] == '') || ($_GET['bindgroup'] == 1 && $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['check'] == 'checked')) {?>
		<td width="180"><input type="checkbox" name='Group<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['u']['index'];?>
' value='<?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['id'];?>
'  <?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['check'];?>
><a onclick="setSave();window.open ('admin.php?controller=admin_pro&action=passedit_selgroup&gid=<?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['id'];?>
&sid=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&sessionlgroup=<?php echo $_smarty_tpl->tpl_vars['sessionlgroup']->value;?>
', 'newwindow', 'height=550, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;"  href="#" target="_blank" ><?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['groupname'];?>
</a></td><?php if (($_smarty_tpl->getVariable('smarty')->value['section']['u']['index']+1)%5 == 0) {?></tr><tr><?php }?>
		<?php }?>
		<?php endfor; endif; ?>
	</tr></table>
	  </td>
	  </tr>
	  <tr><td></td><td></td></tr>
		<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="20%" align=right  valign=top>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['bind'];
echo $_smarty_tpl->tpl_vars['language']->value['User'];?>

		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' <?php if ($_GET['binduser'] == 1) {?>checked<?php }?> value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' <?php if ($_GET['binduser'] == 2) {?>checked<?php }?> value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll(this.checked);"></td></tr>
	  </table>
		</td>
		<td width="80%">
		<table><tr >
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['g'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['g']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['name'] = 'g';
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total']);
?>
		<?php if (!$_GET['binduser'] || ($_GET['binduser'] == 2 && $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'] == '') || ($_GET['binduser'] == 1 && $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'] == 'checked')) {?>
		<td width="180"><input type="checkbox" id="uid_<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
" name='Check<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['g']['index'];?>
' value='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
'  <?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'];?>
><a onclick="setSave();window.open ('admin.php?controller=admin_pro&action=passedit_seluser&uid=<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
&sid=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&sessionluser=<?php echo $_smarty_tpl->tpl_vars['sessionluser']->value;?>
', 'newwindow', 'height=550, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" ><?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['binded']) {?><font color="red"><?php }
echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['username'];?>
(<?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname']) {
echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname'];
} else { ?>未设置<?php }?>)<?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['binded']) {?></font><?php }?></a></td><?php if (($_smarty_tpl->getVariable('smarty')->value['section']['g']['index']+1)%5 == 0) {?></tr><tr><?php }?>
		<?php }?>
		<?php endfor; endif; ?>
		</tr></table>
	  </td>
	  </tr>
	 
	<tr><td></td><td><input type=submit  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02" >&nbsp;&nbsp;&nbsp;&nbsp;<input type=button  value="检测" onclick="test_port();" class="an_02"></td></tr></table>
<input type="hidden" name="logtab" value="<?php echo $_smarty_tpl->tpl_vars['logtab']->value['id'];?>
" />
<input type="hidden" name="sessionlgroup" value="<?php echo $_smarty_tpl->tpl_vars['sessionlgroup']->value;?>
" />
<input type="hidden" name="sessionluser" value="<?php echo $_smarty_tpl->tpl_vars['sessionluser']->value;?>
" />
</form>
	</td>
  </tr>
  <tr><td colspan="2" height="25"></td></tr>
</table>
 <SCRIPT type=text/javascript>
var siteUrl = "<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/date";
function test_port(){
	var port = document.getElementById('port').value;
	if(!/[0-9]+/.test(port)){
		alert('端口请输入数字');
		return ;
	}
	document.getElementById('hide').src='admin.php?controller=admin_pro&action=test_port&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&port='+port;
	//alert(document.getElementById('hide').src);
}
function changeport(cp) {
	if(document.getElementById("ssh").selected==true)  {	
		//appset('');
		
		document.getElementById("autotr").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='';
		document.getElementById("sftp_tr").style.display='';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['sshport']->value;?>
;
	}
	if(document.getElementById("telnet").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['telnetport']->value;?>
;
	}
	if(document.getElementById("ftp").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='none';
		document.getElementById("automutr").style.display='none';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['ftpport']->value;?>
;
	}
	if(document.getElementById("sftp").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='none';
		document.getElementById("automutr").style.display='none';
		document.getElementById("entrust_password").style.display='block';
		document.getElementById("publickey_authtr").style.display='block';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['sshport']->value;?>
;
	}
	if(document.getElementById("RDP").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='';
		document.getElementById("rdpmode").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['rdpport']->value;?>
;
	}
	if(document.getElementById("vnc").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['vncport']->value;?>
;
	}
	if(document.getElementById("X11").selected==true)  {
		//appset('');
		document.getElementById('username').value  = 'root';
		document.getElementById('password_confirm').value  = 'baoleiji';
		document.getElementById('password').value  = 'baoleiji';
		document.getElementById("autotr").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['x11port']->value;?>
;
	}
	if(document.getElementById("rlogin").selected==true)  {
	//appset('');
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';//alert(document.getElementById("sftp_tr").style.display);
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['rdpport']->value;?>
;
	}
	if(document.getElementById("ssh1").selected==true)  {
		//appset('');
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='block';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['sshport']->value;?>
;
	}
	if(document.getElementById("apppub").selected==true)  {
		//appset('none');
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['rdpport']->value;?>
;
	}
	/*if(document.getElementById("Web").selected==true)  {
		//appset('');
		
		document.getElementById("webmethod1").style.display='';
		document.getElementById("webmethod2").style.display='';
		document.getElementById("webmethod3").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = 3389;
	}
	if(document.getElementById("Oracle").selected==true)  {
		appset('');
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['sshport']->value;?>
;
	}
	if(document.getElementById("Sybase").selected==true)  {
	document.getElementById("publickey_authtr").style.display='none';
	document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
	//appset('');
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['sshport']->value;?>
;
	}
	if(document.getElementById("DB2").selected==true)  {;
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['sshport']->value;?>
;
	}
	if(document.getElementById("RDP2008").selected==true)  {
	//appset('');
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['rdpport']->value;?>
;
	}
	if(document.getElementById("replay").selected==true)  {
	//appset('');
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['rdpport']->value;?>
;
	}*/
	
	
}
function appset(enable){
	document.getElementById("usernametr").style.display=enable;
	document.getElementById("originalpasswordtr").style.display=enable;
	document.getElementById("originalpassword2tr").style.display=enable;
	document.getElementById("porttr").style.display=enable;
	document.getElementById("expiretr").style.display=enable;
	document.getElementById("autotr").style.display=enable;
	document.getElementById("automutr").style.display=enable;
	document.getElementById("entrust_passwordtr").style.display=enable;
}

function checkAll(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,5)=='Check'){
			targets[j].checked=c;
		}
	}
}

<?php if (!$_smarty_tpl->tpl_vars['id']->value) {?>
<?php if ($_smarty_tpl->tpl_vars['devicetype']->value == 'windows' || $_smarty_tpl->tpl_vars['devicetype']->value == 'Win2008' || $_smarty_tpl->tpl_vars['devicetype']->value == 'Windows 2008') {?>
document.getElementById("RDP").selected=true;
document.getElementById('port').value = <?php echo $_smarty_tpl->tpl_vars['rdpport']->value;?>
;
<?php } elseif ($_smarty_tpl->tpl_vars['devicetype']->value == 'linux') {?>
document.getElementById("ssh").selected=true;
<?php } elseif ($_smarty_tpl->tpl_vars['devicetype']->value == 'unix') {?>
document.getElementById("telnet").selected=true;
<?php }?>
<?php } else { ?>
if(document.getElementById("ssh").selected==true)
document.getElementById("sftp_tr").style.display='';
<?php }?>

function privatekey_set(){
}
function changessh(v){
	if(v==1) document.getElementById('publickey').disabled=false;
	else document.getElementById('publickey').disabled=true;
}
<?php if ($_smarty_tpl->tpl_vars['entrust_username']->value == 0 && $_smarty_tpl->tpl_vars['id']->value) {?>
temptyuser(true);
<?php }?>
change_for_user_auth();
usernameselect();
changeport(0);
changessh(<?php if ($_smarty_tpl->tpl_vars['publickey_auth']->value) {
echo $_smarty_tpl->tpl_vars['publickey_auth']->value;
} else { ?>0<?php }?>);

var saveAccount = false;
function saveTitle(e){
	if(saveAccount){
		//alert("绑定信息需要点击'保存修改'才能存盘");
		return  e.returnValue='绑定信息需要点击 保存修改 才能存盘,你真的要不保存离开吗？';
		
	}
	return true;
}
function setSave(){
	saveAccount=true;
}
function reload(p1,p2,check){
	window.location=window.location+'&'+(check ? p1 : p2);
}

<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>
</SCRIPT>
</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>