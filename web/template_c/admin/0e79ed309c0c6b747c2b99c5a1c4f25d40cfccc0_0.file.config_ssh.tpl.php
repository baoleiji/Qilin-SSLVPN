<?php /* Smarty version 3.1.27, created on 2016-12-04 00:07:37
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/config_ssh.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:20892069575842edc9077095_18013799%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e79ed309c0c6b747c2b99c5a1c4f25d40cfccc0' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/config_ssh.tpl',
      1 => 1480504545,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20892069575842edc9077095_18013799',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'sshconfig' => 0,
    'ldaps' => 0,
    'ads' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5842edc90f4058_68620773',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5842edc90f4058_68620773')) {
function content_5842edc90f4058_68620773 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '20892069575842edc9077095_18013799';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['language']->value['Master'];
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />

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
    <li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=config_ssh">认证配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=config_ftp">系统参数</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=login_times">密码策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=ha">高可用性</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=syslog_mail_alarm">告警配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=status_warning">告警参数</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=loadbalance">负载均衡</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>




  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ssh_save">
<tr><th colspan="6" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td colspan="6" width="30%"  align=center>
		认证模式：
		<select  class="wbk"  name="radiusauth" >
		<option value="yes" <?php if ($_smarty_tpl->tpl_vars['sshconfig']->value['radiusauth'] == 'yes') {?>selected<?php }?>>开启</option>
		<option value="no"  <?php if ($_smarty_tpl->tpl_vars['sshconfig']->value['radiusauth'] == 'no') {?>selected<?php }?>>关闭</option>
		</select>
		</td>
		
	</tr>
	<tr><td align="right" width="12%">Radius主:</td>		
	<td width="10%">
		<input type="text" class="wbk" name="address" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['address'];?>
" />	
		</td>		
	<td align="right" width="12%">Radius主端口:</td>		
	<td width="5%">
		<input type="text" class="wbk" name="port" size=10 value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['port'];?>
" />	</td>		
	<td align="right" width="12%">
		Radius主key:</td>		
	<td>
		<input type="text" class="wbk" name="secret" size=15 value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['secret'];?>
" />	
		</td>		
	</tr>
	
	<tr bgcolor="f7f7f7"><td align="right">Radius从:</td>		
	<td>
		<input type="text" class="wbk" name="slaveaddress" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['slaveaddress'];?>
" />	
		</td>
<td align="right">Radius从端口:</td>		
	<td>
		<input type="text" class="wbk" name="slaveport" size=10 value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['slaveport'];?>
" />	</td>		
	<td align="right">
		Radius从key:</td>		
	<td>
		<input type="text" class="wbk" name="slavesecret" size=15 value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['slavesecret'];?>
" />	
		</td>
		
	</tr>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['l'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['l']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['name'] = 'l';
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ldaps']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total']);
?>
<tr><td align="right">LDAP服务器:</td>		
	<td>
		<input type="text" class="wbk" id="ldapip_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['l']['index'];?>
" name="ldapip[]" value="<?php echo $_smarty_tpl->tpl_vars['ldaps']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['address'];?>
" />	
		</td>
<td align="right">LDAP服务器端口:</td>		
	<td>
		<input type="text" class="wbk" name="ldapport[]" size=10 value="<?php echo $_smarty_tpl->tpl_vars['ldaps']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['port'];?>
" />	</td>		
	<td align="right">
		LDAP服务器DC:</td>		
	<td>
		<input type="text" class="wbk" name="ldapdomain[]" size=15 value="<?php echo $_smarty_tpl->tpl_vars['ldaps']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['domain'];?>
" />	&nbsp;&nbsp;透明登录:<input type="checkbox" value="1" name="transpant[]" <?php if ($_smarty_tpl->tpl_vars['ldaps']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['transpant']) {?>checked<?php }?> />&nbsp;&nbsp;<input type="button" onclick="document.getElementById('ldapip_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['l']['index'];?>
').value='';document.f1.submit();"  value="删除" class="an_02">&nbsp;&nbsp;<input type="button" onclick="window.open ('admin.php?controller=admin_config&action=ldapusers&id=<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['l']['index'];?>
', 'newwindow', 'height=500, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');"  value="导入账号" class="an_02">&nbsp;&nbsp;<input type="button" onclick="window.open ('admin.php?controller=admin_config&action=ldapimportconfig&adserverindex=<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['a']['index'];?>
', 'newwindow', 'height=500, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');"  value="导入策略" class="an_02">
		</td>
		
	</tr>
<?php endfor; endif; ?>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['a'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['a']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['name'] = 'a';
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ads']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
	<tr bgcolor="f7f7f7"><td align="right">AD 服务器:</td>		
	<td>
		<input type="text" class="wbk" id="adip_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['a']['index'];?>
" name="adip[]" value="<?php echo $_smarty_tpl->tpl_vars['ads']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['address'];?>
" />	
		</td>
<td align="right"> AD 服务器端口:</td>		
	<td>
		<input type="text" class="wbk" name="adport[]" size=10 value="<?php echo $_smarty_tpl->tpl_vars['ads']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['port'];?>
" />	</td>		
	<td align="right">
		 AD域 :</td>		
	<td>
		<input type="text" class="wbk" name="addomain[]" size=15 value="<?php echo $_smarty_tpl->tpl_vars['ads']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['domain'];?>
" />	&nbsp;&nbsp;<input type="button" onclick="document.getElementById('adip_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['a']['index'];?>
').value='';document.f1.submit();"  value="删除" class="an_02">&nbsp;&nbsp;<input type="button" onclick="window.open ('admin.php?controller=admin_config&action=adusers&id=<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['a']['index'];?>
', 'newwindow', 'height=500, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');"  value="导入账号" class="an_02">&nbsp;&nbsp;<input type="button" onclick="window.open ('admin.php?controller=admin_config&action=adimportconfig&adserverindex=<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['a']['index'];?>
', 'newwindow', 'height=500, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');"  value="导入策略" class="an_02">
		</td>		
	</tr>
<?php endfor; endif; ?>

	<tr>
			<td  align="center" colspan=6><input type="button" onclick="window.location='admin.php?controller=admin_config&action=addldapserver'"  value="添加条目" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td>
		</tr>

	</table>
</form>

		</table>
	</td>
  </tr>
</table>


<?php echo '<script'; ?>
 language="javascript">
<!--
function check()
{
/*
   if(!checkIP(f1.ip.value) && f1.netmask.value != '32' ) {
	alert('地址为<?php echo $_smarty_tpl->tpl_vars['language']->value['HostName'];?>
时，掩码应为32');
	return false;
   }   
   if(checkIP(f1.ip.value) && !checknum(f1.netmask.value)) {
	alert('请<?php echo $_smarty_tpl->tpl_vars['language']->value['Input'];?>
正确掩码');
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

<?php echo '</script'; ?>
>
</body>
</html>


<?php }
}
?>