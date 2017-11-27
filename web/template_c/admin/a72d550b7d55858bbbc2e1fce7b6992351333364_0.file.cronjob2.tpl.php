<?php /* Smarty version 3.1.27, created on 2016-12-08 14:02:14
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/cronjob2.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:7670764815848f7660a04e3_03098151%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a72d550b7d55858bbbc2e1fce7b6992351333364' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/cronjob2.tpl',
      1 => 1481176929,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7670764815848f7660a04e3_03098151',
  'variables' => 
  array (
    'template_root' => 0,
    'allgroup' => 0,
    'server' => 0,
    'devices' => 0,
    'chpwdservice' => 0,
    'minute' => 0,
    'hour' => 0,
    'day' => 0,
    'week' => 0,
    'accountservice' => 0,
    'uminute' => 0,
    'uhour' => 0,
    'uday' => 0,
    'uweek' => 0,
    'uploadservice' => 0,
    'pminute' => 0,
    'phour' => 0,
    'pday' => 0,
    'pweek' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5848f766200744_85081771',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5848f766200744_85081771')) {
function content_5848f766200744_85081771 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '7670764815848f7660a04e3_03098151';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" >
var group = new Array();
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['g'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['g']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['name'] = 'g';
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allgroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
group[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['g']['index'];?>
] = new Array();
group[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['g']['index'];?>
]['name']='<?php echo $_smarty_tpl->tpl_vars['allgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['groupname'];?>
'
group[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['g']['index'];?>
]['id']='<?php echo $_smarty_tpl->tpl_vars['allgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
'
<?php endfor; endif; ?>
var server = new Array();
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['s'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['s']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['name'] = 's';
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['server']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
server[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['s']['index'];?>
] = new Array();
server[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['s']['index'];?>
]['device_ip']='<?php echo $_smarty_tpl->tpl_vars['server']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['device_ip'];?>
'
server[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['s']['index'];?>
]['group']='<?php echo $_smarty_tpl->tpl_vars['server']->value[$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['groupid'];?>
'
<?php endfor; endif; ?>
var devices = new Array();
j=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['d'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['d']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['name'] = 'd';
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['devices']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total']);
?>
<?php if ($_smarty_tpl->tpl_vars['devices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['d']['index']]['username']) {?>
devices[j] = new Array();
devices[j]['username']='<?php echo $_smarty_tpl->tpl_vars['devices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['d']['index']]['username'];?>
'
devices[j]['device_ip']='<?php echo $_smarty_tpl->tpl_vars['devices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['d']['index']]['device_ip'];?>
'
j++;
<?php }?>
<?php endfor; endif; ?>
function changesg(selected_group){
	for(var j=0; j<group.length; j++){
		if(selected_group==group[j]['name']){
			selected_group=group[j]['id'];
			break;
		}
	}
	var iid=document.getElementById("server");
	iid.options.length=0;
	iid.options[iid.options.length] = new Option('所有设备','99999999');
	for(var i=0; i<server.length; i++){
		if(selected_group==server[i]['group']){
			iid.options[iid.options.length] = new Option(server[i]['device_ip'],server[i]['device_ip']);
		}else if(selected_group==1000){
			iid.options[iid.options.length] = new Option(server[i]['device_ip'],server[i]['device_ip']);
		}
	}
}

function changes(selected_server){
	var iid=document.getElementById("device");
	iid.options.length=0;
	iid.options[iid.options.length] = new Option('所有用户','99999999');
	for(var i=0; i<devices.length; i++){
		if(selected_server==devices[i]['device_ip']){
			iid.options[iid.options.length] = new Option(devices[i]['username'],devices[i]['username']);
		}
	}
}
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/cn.js"><?php echo '</script'; ?>
>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
</head>

<body>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<?php if ($_SESSION['ADMIN_LEVEL'] == 1) {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=serverstatus">服务状态</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=latest">系统状态</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup">配置备份</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting">数据同步</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=upgrade">软件升级</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=cronjob">定时任务</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=changelogo">图标上传</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=notice">系统通知</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php } else { ?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php if ($_SESSION['ADMIN_LEVEL'] == 10) {?>
<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php }?>
<?php if ($_SESSION['ADMIN_LEVEL'] != 10 && $_SESSION['ADMIN_LEVEL'] != 101) {?>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">设备目录</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }
}?>
</ul>
</div></td></tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_backup&action=cronjob">
	<tr><td>审计文件备份:</td>
		<td align=left>
		<input type="checkbox" class="wbk" name="chpwdservice" value="1" <?php if ($_smarty_tpl->tpl_vars['chpwdservice']->value) {?>checked<?php }?> />
		</td>		
	</tr>
	<tr bgcolor="f7f7f7"><td>审计文件备份调度:</td>
		<td align=left>
		分钟:<select name="minute" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['minute']->value == '*') {?>selected<?php }?>>*</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['m'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['m']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['name'] = 'm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'] = is_array($_loop=60) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
		<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['m']['index'];?>
" <?php if ($_smarty_tpl->tpl_vars['minute']->value != '*' && $_smarty_tpl->tpl_vars['minute']->value == $_smarty_tpl->getVariable('smarty')->value['section']['m']['index']) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['m']['index'];?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		小时:<select name="hour" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['hour']->value == '*') {?>selected<?php }?>>*</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['h'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['h']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['name'] = 'h';
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['loop'] = is_array($_loop=24) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total']);
?>
		<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['h']['index'];?>
" <?php if ($_smarty_tpl->tpl_vars['hour']->value != '*' && $_smarty_tpl->tpl_vars['hour']->value == $_smarty_tpl->getVariable('smarty')->value['section']['h']['index']) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['h']['index'];?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		天:<select name="day" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['day']->value == '*') {?>selected<?php }?>>*</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['d'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['d']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['name'] = 'd';
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['loop'] = is_array($_loop=31) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['d']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['d']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['d']['total']);
?>
		<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['d']['index']+1;?>
" <?php if ($_smarty_tpl->tpl_vars['day']->value != '*' && $_smarty_tpl->tpl_vars['day']->value == $_smarty_tpl->getVariable('smarty')->value['section']['d']['index']+1) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['d']['index']+1;?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		周:<select name="week" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['week']->value == '*') {?>selected<?php }?>>*</option>
		<option value="0" <?php if ($_smarty_tpl->tpl_vars['week']->value == '0') {?>selected<?php }?>>日</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['week']->value == '1') {?>selected<?php }?>>一</option>
		<option value="2" <?php if ($_smarty_tpl->tpl_vars['week']->value == '2') {?>selected<?php }?>>二</option>
		<option value="3" <?php if ($_smarty_tpl->tpl_vars['week']->value == '3') {?>selected<?php }?>>三</option>
		<option value="4" <?php if ($_smarty_tpl->tpl_vars['week']->value == '4') {?>selected<?php }?>>四</option>
		<option value="5" <?php if ($_smarty_tpl->tpl_vars['week']->value == '5') {?>selected<?php }?>>五</option>
		<option value="6" <?php if ($_smarty_tpl->tpl_vars['week']->value == '6') {?>selected<?php }?>>六</option>
		</select>
		</td>		
	</tr>
	<tr><td>主从服务器备份:</td>
		<td align=left>
		<input type="checkbox" class="wbk" name="accountservice" value="1" <?php if ($_smarty_tpl->tpl_vars['accountservice']->value) {?>checked<?php }?> />
		</td>		
	</tr>
	<tr bgcolor="f7f7f7"><td>主从服务器备份调度:</td>
		<td align=left>
		分钟:<select name="uminute" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['uminute']->value == '*') {?>selected<?php }?>>*</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['um'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['um']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['name'] = 'um';
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['loop'] = is_array($_loop=60) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['um']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['um']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['um']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['um']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['um']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['um']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['um']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['um']['total']);
?>
		<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['um']['index'];?>
" <?php if ($_smarty_tpl->tpl_vars['uminute']->value != '*' && $_smarty_tpl->tpl_vars['uminute']->value == $_smarty_tpl->getVariable('smarty')->value['section']['um']['index']) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['um']['index'];?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		小时:<select name="uhour" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['uhour']->value == '*') {?>selected<?php }?>>*</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['uh'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['uh']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['name'] = 'uh';
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['loop'] = is_array($_loop=24) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['uh']['total']);
?>
		<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['uh']['index'];?>
" <?php if ($_smarty_tpl->tpl_vars['uhour']->value != '*' && $_smarty_tpl->tpl_vars['uhour']->value == $_smarty_tpl->getVariable('smarty')->value['section']['uh']['index']) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['uh']['index'];?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		天:<select name="uday" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['uday']->value == '*') {?>selected<?php }?>>*</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ud'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ud']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['name'] = 'ud';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['loop'] = is_array($_loop=31) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ud']['total']);
?>
		<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ud']['index']+1;?>
" <?php if ($_smarty_tpl->tpl_vars['uday']->value != '*' && $_smarty_tpl->tpl_vars['uday']->value == $_smarty_tpl->getVariable('smarty')->value['section']['ud']['index']+1) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ud']['index']+1;?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		周:<select name="uweek" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['uweek']->value == '*') {?>selected<?php }?>>*</option>
		<option value="0" <?php if ($_smarty_tpl->tpl_vars['uweek']->value == '0') {?>selected<?php }?>>日</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['uweek']->value == '1') {?>selected<?php }?>>一</option>
		<option value="2" <?php if ($_smarty_tpl->tpl_vars['uweek']->value == '2') {?>selected<?php }?>>二</option>
		<option value="3" <?php if ($_smarty_tpl->tpl_vars['uweek']->value == '3') {?>selected<?php }?>>三</option>
		<option value="4" <?php if ($_smarty_tpl->tpl_vars['uweek']->value == '4') {?>selected<?php }?>>四</option>
		<option value="5" <?php if ($_smarty_tpl->tpl_vars['uweek']->value == '5') {?>selected<?php }?>>五</option>
		<option value="6" <?php if ($_smarty_tpl->tpl_vars['uweek']->value == '6') {?>selected<?php }?>>六</option>
		</select>
		</td>		
	</tr>
	<tr><td>自动删除服务:</td>
		<td align=left>
		<input type="checkbox" class="wbk" name="uploadservice" value="1" <?php if ($_smarty_tpl->tpl_vars['uploadservice']->value) {?>checked<?php }?> />
		</td>		
	</tr>
	<tr bgcolor="f7f7f7"><td>自动删除服务调度:</td>
		<td align=left>
		分钟:<select name="pminute" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['pminute']->value == '*') {?>selected<?php }?>>*</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pm'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pm']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['name'] = 'pm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['loop'] = is_array($_loop=60) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pm']['total']);
?>
		<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pm']['index'];?>
" <?php if ($_smarty_tpl->tpl_vars['pminute']->value != '*' && $_smarty_tpl->tpl_vars['pminute']->value == $_smarty_tpl->getVariable('smarty')->value['section']['pm']['index']) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pm']['index'];?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		小时:<select name="phour" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['phour']->value == '*') {?>selected<?php }?>>*</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ph'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ph']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['name'] = 'ph';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['loop'] = is_array($_loop=24) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ph']['total']);
?>
		<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ph']['index'];?>
" <?php if ($_smarty_tpl->tpl_vars['phour']->value != '*' && $_smarty_tpl->tpl_vars['phour']->value == $_smarty_tpl->getVariable('smarty')->value['section']['ph']['index']) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ph']['index'];?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		天:<select name="pday" >
		<option value="*" <?php if ('pday' == '*') {?>selected<?php }?>>*</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pd'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['name'] = 'pd';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop'] = is_array($_loop=31) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total']);
?>
		<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pd']['index']+1;?>
" <?php if ($_smarty_tpl->tpl_vars['pday']->value != '*' && $_smarty_tpl->tpl_vars['pday']->value == $_smarty_tpl->getVariable('smarty')->value['section']['pd']['index']+1) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pd']['index']+1;?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		周:<select name="pweek" >
		<option value="*" <?php if ($_smarty_tpl->tpl_vars['pweek']->value == '*') {?>selected<?php }?>>*</option>
		<option value="0" <?php if ($_smarty_tpl->tpl_vars['pweek']->value == '0') {?>selected<?php }?>>日</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['pweek']->value == '1') {?>selected<?php }?>>一</option>
		<option value="2" <?php if ($_smarty_tpl->tpl_vars['pweek']->value == '2') {?>selected<?php }?>>二</option>
		<option value="3" <?php if ($_smarty_tpl->tpl_vars['pweek']->value == '3') {?>selected<?php }?>>三</option>
		<option value="4" <?php if ($_smarty_tpl->tpl_vars['pweek']->value == '4') {?>selected<?php }?>>四</option>
		<option value="5" <?php if ($_smarty_tpl->tpl_vars['pweek']->value == '5') {?>selected<?php }?>>五</option>
		<option value="6" <?php if ($_smarty_tpl->tpl_vars['pweek']->value == '6') {?>selected<?php }?>>六</option>
		</select>
		</td>		
	</tr>
	<tr>
			<td></td><td align="left"><input type="submit"  value="保存修改" class="an_02"></td>
		</tr>

	</table>
	<input type="hidden" name="ac" value="doit" />
</form>

		</table>
	</td>
  </tr>
</table>
  <?php echo '<script'; ?>
 type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");


<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 language="javascript">
<!--
function check()
{
/*
   if(!checkIP(f1.ip.value) && f1.netmask.value != '32' ) {
	alert('地址为主机名时，掩码应为32');
	return false;
   }   
   if(checkIP(f1.ip.value) && !checknum(f1.netmask.value)) {
	alert('请录入正确掩码');
	return false;
   }
*/
   return true;

}//end check
// -->

function checkIP(ip)
{
	var ips = ip.split('.');
	if(ips.length==4 && ips[0]>=0 && ips[0]<256 && ips[1]>=0 && ips[1]<256 && ips[2]>=0 && ips[2]<256 && ips[3]>=0 && ips[3]<256)
		return ture;
	else
		return false;
}

function checknum(num)
{

	if( isDigit(num) && num > 0 && num < 65535)
		return ture;
	else
		return false;

}

function isDigit(s)
{
var patrn=/^[0-9]{1,20}$/;
if (!patrn.exec(s)) return false;
return true;
}
changesg(document.getElementById('group').options[document.getElementById('group').options.selectedIndex].value);
<?php echo '</script'; ?>
>
</body>
</html>



<?php }
}
?>