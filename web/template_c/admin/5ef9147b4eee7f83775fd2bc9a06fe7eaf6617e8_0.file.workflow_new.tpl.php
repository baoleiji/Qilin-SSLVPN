<?php /* Smarty version 3.1.27, created on 2016-12-04 21:25:11
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/workflow_new.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:164827161258441937a293a5_56256867%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ef9147b4eee7f83775fd2bc9a06fe7eaf6617e8' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/workflow_new.tpl',
      1 => 1480857909,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '164827161258441937a293a5_56256867',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    '_config' => 0,
    'userpriority' => 0,
    'gid' => 0,
    'sip' => 0,
    'dev' => 0,
    'methods' => 0,
    'member' => 0,
    'wfcontant' => 0,
    'language' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58441937b4ef01_55431534',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58441937b4ef01_55431534')) {
function content_58441937b4ef01_55431534 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '164827161258441937a293a5_56256867';
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
 src="./template/admin/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/cn.js"><?php echo '</script'; ?>
>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
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
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_workflow&action=workflow_new_save&sid=<?php echo $_smarty_tpl->tpl_vars['sip']->value['sid'];?>
">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		设备IP	
		</td>
		<td width="67%">
		<input type="text" name="device_ip" value="<?php echo $_smarty_tpl->tpl_vars['dev']->value['device_ip'];?>
" />
	  </td>
	</tr>	
	<tr bgcolor="">
		<td width="33%" align=right>
		用户名
		</td>
		<td width="67%">
		<input type="text" name="username" value="<?php echo $_smarty_tpl->tpl_vars['dev']->value['username'];?>
" />
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		登录方式
		</td>
		<td width="67%">
		<select name="login_method" id="login_method">
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['a'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['a']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['name'] = 'a';
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['methods']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['methods']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['dev']->value['login_template'] == $_smarty_tpl->tpl_vars['methods']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['id']) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['methods']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['login_method'];?>
</option>
		<?php endfor; endif; ?>
		</select>
	  </td>
	</tr>
	<tr bgcolor="">
		<td width="33%" align=right>
		端口
		</td>
		<td width="67%">
		<input type="text" name="port" value="<?php echo $_smarty_tpl->tpl_vars['dev']->value['port'];?>
" />
	  </td>
	</tr>
	<tr bgcolor="">
		<td width="33%" align=right>
		使用截止时间
		</td>
		<td width="67%">
		<INPUT value="<?php if ($_smarty_tpl->tpl_vars['member']->value['end_time'] != '2037-01-01 00:00:00') {
echo $_smarty_tpl->tpl_vars['member']->value['end_time'];
}?>" id="deadline" name="deadline" onFocus="setday(this)">&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
  <?php echo '<script'; ?>
 type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeEnd_trigger", "deadline", "%Y-%m-%d %H:%M:%S");


<?php echo '</script'; ?>
>
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