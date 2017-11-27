<?php /* Smarty version 3.1.27, created on 2016-12-05 23:37:13
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/workflow_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:864304050584589a96adfc4_08122965%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '362bdfe2b8b6765861ece68948b857ea72a5e16f' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/workflow_edit.tpl',
      1 => 1474793220,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '864304050584589a96adfc4_08122965',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    '_config' => 0,
    'userpriority' => 0,
    'gid' => 0,
    'sip' => 0,
    'servers' => 0,
    'wfcontant' => 0,
    'language' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_584589a97e17c3_40590811',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_584589a97e17c3_40590811')) {
function content_584589a97e17c3_40590811 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '864304050584589a96adfc4_08122965';
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
 type="text/javascript">
<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();

<?php }?>

var servers = new Array();
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['s'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['s']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['name'] = 's';
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['userpriority']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total']);
?>
servers[servers.length]={id: <?php echo $_smarty_tpl->tpl_vars['userpriority']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['id'];?>
, device_ip: '<?php echo $_smarty_tpl->tpl_vars['userpriority']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['device_ip'];?>
', username: '<?php if (!$_smarty_tpl->tpl_vars['userpriority']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['username']) {?>空用户<?php } else {
echo $_smarty_tpl->tpl_vars['userpriority']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['username'];
}?>', login_method: '<?php echo $_smarty_tpl->tpl_vars['userpriority']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['login_method'];?>
', groupid: '<?php echo $_smarty_tpl->tpl_vars['userpriority']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['groupid'];?>
'};
<?php endfor; endif; ?>

function changegroup(group,defaultip){
	var s = document.getElementById('ip');
	var d = document.getElementById('devicesid');
	s.options.length=0;
	d.options.length=0;
	s.options[s.options.length] = new Option('', '请选择');
	for(var i=0; i<servers.length; i++){
		if(servers[i].groupid==group){
			var found = false;
			for(var j=0; j<s.options.length; j++){
				if(s.options[j].value==servers[i].device_ip){
					found = true;
					break;
				}					
			}
			if(!found){
				if(defaultip==servers[i].device_ip){
					s.options[s.options.length] = new Option(servers[i].device_ip, servers[i].device_ip, true, true);
				}else{
					s.options[s.options.length] = new Option(servers[i].device_ip, servers[i].device_ip);
				}				
			}
		}
	}
}

function changeip(ip,defaultuser){
	var s = document.getElementById('username');
	var d = document.getElementById('devicesid');
	s.options.length=0;
	d.options.length=0;
	s.options[s.options.length] = new Option('', '请选择');
	for(var i=0; i<servers.length; i++){
		if(servers[i].device_ip==ip){
			var found = false;
			for(var j=0; j<s.options.length; j++){
				if(s.options[j].value==servers[i].username){
					found = true;
					break;
				}					
			}
			if(!found){
				if(defaultuser==servers[i].username){
					s.options[s.options.length] = new Option(servers[i].username, servers[i].username, true, true);
				}else{
					s.options[s.options.length] = new Option(servers[i].username, servers[i].username);
				}				
			}
		}
	}
}

function changeuser(user,defaultsid){
	var d = document.getElementById('devicesid');
	var _ip = document.getElementById('ip').options[document.getElementById('ip').options.selectedIndex].value;
	d.options.length=0;
	d.options[d.options.length] = new Option('', '请选择');
	for(var i=0; i<servers.length; i++){
		if(servers[i].device_ip==_ip && servers[i].username==user){
			if(defaultsid==servers[i].id){
				d.options[d.options.length] = new Option(servers[i].login_method, servers[i].id, true, true);
			}else{
				d.options[d.options.length] = new Option(servers[i].login_method, servers[i].id);
			}
		}
	}
}
<?php echo '</script'; ?>
>
</head>

<body>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<?php if ($_SESSION['ADMIN_LEVEL'] == 0) {?>
<?php if ($_GET['logintype'] != 'apppub') {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&all=1">设备列表</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'ssh') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'ssh') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ssh&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">SSH设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'ssh') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'telnet') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'telnet') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=telnet&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">TELNET设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'telnet') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'rdp') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'rdp') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=rdp&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">RDP设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'rdp') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'vnc') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'vnc') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=vnc&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">VNC设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'vnc') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'ftp') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'ftp') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ftp&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">FTP设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'ftp') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'x11') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'x11') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=x11">X11设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'x11') {?>3<?php }?>.jpg" align="absmiddle"/></li>

<li class=<?php if ($_GET['logintype'] != '_apppub') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != '_apppub') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=_apppub&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">应用</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != '_apppub') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<?php } else { ?>
<li class=<?php if ($_GET['logintype'] != 'apppub') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'apppub') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=apppub&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">应用发布设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'apppub') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<?php }?>
<?php } elseif ($_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php if ($_SESSION['ADMIN_LEVEL'] == 10) {?>
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
<?php }
}?>
<li class=me_a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow">运维流程</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_workflow&action=workflow&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_workflow&action=workflow_save&sid=<?php echo $_smarty_tpl->tpl_vars['sip']->value['sid'];?>
">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<tr >
	<td align=right>目录</td><td>

		<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
     
	</td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		设备IP	
		</td>
		<td width="67%">
		<?php if (!$_smarty_tpl->tpl_vars['sip']->value['status'] || $_smarty_tpl->tpl_vars['sip']->value['status'] == 2) {?>
		<select name="ip" id="ip" onchange="changeip(this.value,'')" >
		<option value="">请选择</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['s'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['s']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['name'] = 's';
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['servers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['servers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']];?>
" <?php if ($_smarty_tpl->tpl_vars['servers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']] == $_smarty_tpl->tpl_vars['sip']->value['device_ip']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['servers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']];?>
</option>
		<?php endfor; endif; ?>
		</select>
		<?php } else { ?>
		<?php echo $_smarty_tpl->tpl_vars['sip']->value['device_ip'];?>

		<?php }?>
	  </td>
	</tr>	
	<tr bgcolor="">
		<td width="33%" align=right>
		用户名
		</td>
		<td width="67%">
		<?php if (!$_smarty_tpl->tpl_vars['sip']->value['status'] || $_smarty_tpl->tpl_vars['sip']->value['status'] == 2) {?>
		<select name="username" id="username" onchange="changeuser(this.value,'')">
		</select>
		<?php } else { ?>
		<?php if (!$_smarty_tpl->tpl_vars['sip']->value['username']) {?>空用户<?php } else {
echo $_smarty_tpl->tpl_vars['sip']->value['username'];
}?>
		<?php }?>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		登录方式
		</td>
		<td width="67%">
		<?php if (!$_smarty_tpl->tpl_vars['sip']->value['status'] || $_smarty_tpl->tpl_vars['sip']->value['status'] == 2) {?>
		<select name="devicesid" id="devicesid">
		</select>
		<?php } else { ?>
		<?php echo $_smarty_tpl->tpl_vars['sip']->value['login_method'];?>

		<input type="hidden" name=devicesid value="<?php echo $_smarty_tpl->tpl_vars['sip']->value['devicesid'];?>
" />
		<?php }?>
	  </td>
	</tr>
	<tr bgcolor="">
		<td width="33%" align=right>
		操作内容
		</td>
		<td width="67%">
		<?php if (!$_smarty_tpl->tpl_vars['sip']->value['status'] || $_smarty_tpl->tpl_vars['sip']->value['status'] == 2) {?>
		<select name="wfcontant">
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['wf'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['wf']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['name'] = 'wf';
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['wfcontant']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['wf']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['wfcontant']->value[$_smarty_tpl->getVariable('smarty')->value['section']['wf']['index']]['sid'];?>
" <?php if ($_smarty_tpl->tpl_vars['sip']->value['contant'] == $_smarty_tpl->tpl_vars['wfcontant']->value[$_smarty_tpl->getVariable('smarty')->value['section']['wf']['index']]['sid']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['wfcontant']->value[$_smarty_tpl->getVariable('smarty')->value['section']['wf']['index']]['name'];?>
</option>
		<?php endfor; endif; ?>
		</select>
		<?php } else { ?>
		<?php echo $_smarty_tpl->tpl_vars['sip']->value['name'];?>

		<input type="hidden" name=wfcontant value="<?php echo $_smarty_tpl->tpl_vars['sip']->value['contant'];?>
" />
		<?php }?>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
	<td width="33%" align=right valign="top">
		描述
		</td>
		<td width="67%">
		<textarea cols="37" rows="10"  name="desc"><?php echo $_smarty_tpl->tpl_vars['sip']->value['desc'];?>
</textarea>
	  </td>
	</tr>	
	<tr bgcolor="f7f7f7"><td></td><td><input type=submit  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td></tr></table>

</form>
	</td>
  </tr>
</table>
<?php echo '<script'; ?>
>

<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>
<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>