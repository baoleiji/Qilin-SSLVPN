<?php /* Smarty version 3.1.27, created on 2017-01-01 11:55:01
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/pass_batchedit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:26750784358687d95bb1b14_11219241%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '712d61352849b862f8f9dd692ab75284f2be88cf' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/pass_batchedit.tpl',
      1 => 1483239516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26750784358687d95bb1b14_11219241',
  'variables' => 
  array (
    'template_root' => 0,
    'from' => 0,
    'id' => 0,
    'ip' => 0,
    'serverid' => 0,
    'gid' => 0,
    'allmethod' => 0,
    'l_id' => 0,
    'port' => 0,
    'sshport' => 0,
    'limit_time' => 0,
    'language' => 0,
    'nolimit' => 0,
    'telnetport' => 0,
    'ftpport' => 0,
    'rdpport' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58687d95c4c225_76336759',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58687d95c4c225_76336759')) {
function content_58687d95c4c225_76336759 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '26750784358687d95bb1b14_11219241';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>路由列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
 <SCRIPT language=javascript src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/selectdate.js"></SCRIPT>
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

<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<?php if ($_SESSION['ADMIN_LEVEL'] == 10) {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
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
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="5%" align="center" bgcolor="#E0EDF8"><b>序列</b></th>
			<th class="list_bg"  width="9%" align="center" bgcolor="#E0EDF8"><b>用户名</b></th>
			<th class="list_bg"  width="9%" align="center" bgcolor="#E0EDF8"><b>密码</b></th>
			<th class="list_bg"  width="9%" align="center" bgcolor="#E0EDF8"><b>确认密码</b></th>
			<th class="list_bg"  width="9%" align="center" bgcolor="#E0EDF8"><b>登录方式</b></th>
			<th class="list_bg"  width="5%" align="center" bgcolor="#E0EDF8"><b>端口</b></th>
			<th class="list_bg"  align="center" bgcolor="#E0EDF8"><b>过期时间</b></th>
		</tr>		
		<form name='route' action='admin.php?controller=admin_pro&action=pass_batchsave&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
' method='post'>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=20) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total']);
?>
		
		<tr>
			<td width="3%" class="td_line"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['t']['index']+1;?>
</td>
			<td width="10%" class="td_line"><input type="text" class="wbk" name="username[]" value="" /></td>
			<td width="10%" class="td_line"><input type="password" name="password[]" value="" /></td>
			<td width="10%" class="td_line"><input type="password" name="confirm_password[]" value="" /></td>
			<td width="10%" class="td_line"><select  class="wbk"  name="l_id[]" onchange="changeport(<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['t']['index']+1;?>
)">
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
			<OPTION id ="<?php echo $_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['login_method'];
echo $_smarty_tpl->getVariable('smarty')->value['section']['t']['index']+1;?>
" VALUE="<?php echo $_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'] == $_smarty_tpl->tpl_vars['l_id']->value) {?>selected<?php }?>><?php if ($_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['login_method'] == 'apppub') {?>应用发布<?php } else {
echo $_smarty_tpl->tpl_vars['allmethod']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['login_method'];
}?></option>
		<?php endfor; endif; ?>
		</select></td>
		<td><input type=text name="port[]" id="port<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['t']['index']+1;?>
" size=4 value="<?php if ($_smarty_tpl->tpl_vars['port']->value) {
echo $_smarty_tpl->tpl_vars['port']->value;
} else {
echo $_smarty_tpl->tpl_vars['sshport']->value;
}?>" ></td>
		<td><INPUT value="<?php echo $_smarty_tpl->tpl_vars['limit_time']->value;?>
" id="limit_time<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['t']['index']+1;?>
" name="limit_time[]"><IMG onClick="getDatePicker('limit_time<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['t']['index']+1;?>
', event)" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/time.gif"> <?php echo $_smarty_tpl->tpl_vars['language']->value['clicktoselectdate'];
echo $_smarty_tpl->tpl_vars['language']->value['or'];
echo $_smarty_tpl->tpl_vars['language']->value['select'];?>
 <?php echo $_smarty_tpl->tpl_vars['language']->value['AlwaysValid'];?>
<INPUT <?php if ($_smarty_tpl->tpl_vars['nolimit']->value == 1) {?> checked <?php }?> type=checkbox name="nolimit[]">  </td>
		</tr>
		
		<?php endfor; endif; ?>
		 <tr>
			<td colspan="9" align="center" ><input type='submit'  name="batch" value='确定'  class="an_02"></td>
		  </tr>
		</form>

		</table>
	</td>
  </tr>

</table>

<?php echo '<script'; ?>
 language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
var siteUrl = "<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/date";
function changeport(number) {
	var port = document.getElementById('port'+number);
	if(document.getElementById("ssh"+number).selected==true)  {	
		port.value = <?php echo $_smarty_tpl->tpl_vars['sshport']->value;?>
;
	}
	if(document.getElementById("telnet"+number).selected==true)  {
		port.value = <?php echo $_smarty_tpl->tpl_vars['telnetport']->value;?>
;
	}
	if(document.getElementById("ftp"+number).selected==true)  {
		port.value = <?php echo $_smarty_tpl->tpl_vars['ftpport']->value;?>
;
	}
	if(document.getElementById("RDP"+number).selected==true)  {
		port.value = <?php echo $_smarty_tpl->tpl_vars['rdpport']->value;?>
;
	}
	if(document.getElementById("vnc"+number).selected==true)  {
		port.value = 5901;
	}
	if(document.getElementById("rlogin"+number).selected==true)  {
		port.value = <?php echo $_smarty_tpl->tpl_vars['rdpport']->value;?>
;
	}
	if(document.getElementById("ssh1"+number).selected==true)  {
		port.value = <?php echo $_smarty_tpl->tpl_vars['sshport']->value;?>
;
	}
	if(document.getElementById("apppub"+number).selected==true)  {
		port.value = <?php echo $_smarty_tpl->tpl_vars['rdpport']->value;?>
;
	}
	
}
<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>