<?php /* Smarty version 3.1.27, created on 2017-05-07 08:29:17
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/syslog_mail_alarm.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:721344962590e6a5d142d28_45233893%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15baecca00e70d54582c32ae17b6e1a0b55df4a3' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/syslog_mail_alarm.tpl',
      1 => 1483243795,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '721344962590e6a5d142d28_45233893',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'alarm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_590e6a5d1c45e3_48957041',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_590e6a5d1c45e3_48957041')) {
function content_590e6a5d1c45e3_48957041 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '721344962590e6a5d142d28_45233893';
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=syslog_mail_alarm">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7"><td align="right"><?php echo $_smarty_tpl->tpl_vars['language']->value['StartupMailAlert'];?>
:</td>
		<td align=left>&nbsp;
		<input type="radio" name="Mail_Alarm" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['Mail_Alarm'] == '1') {?>checked<?php }?> value="1" /><?php echo $_smarty_tpl->tpl_vars['language']->value['Startup'];?>
 <input type="radio" name="Mail_Alarm" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['Mail_Alarm'] == '0') {?>checked<?php }?> value="0" /><?php echo $_smarty_tpl->tpl_vars['language']->value['Shutdown'];?>

		</td>
		
	</tr>
	<tr><td align="right"><?php echo $_smarty_tpl->tpl_vars['language']->value['MailServer'];?>
:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="Mailserver" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['MailServer'];?>
" />
		&nbsp;&nbsp;&nbsp;&nbsp;端口：<input type="text" class="wbk" name="mailport" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['mailport'];?>
" />
		&nbsp;&nbsp;&nbsp;&nbsp;SSL：<input type="checkbox" class="wbk" name="sslmail" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['sslmail']) {?>checked<?php }?> />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right"><?php echo $_smarty_tpl->tpl_vars['language']->value['EmailAccount'];?>
:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="account" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['account'];?>
" />
		</td>
		
	</tr>
	<tr><td align="right"><?php echo $_smarty_tpl->tpl_vars['language']->value['AccountPassword'];?>
:</td>
		<td align=left>&nbsp;
		<input type="password" name="password" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['password'];?>
" />
		</td>
		
	</tr>

	<tr bgcolor="f7f7f7"><td align="right">认证邮件告警:</td>
		<td align=left>&nbsp;
		<select  class="wbk"  name="mailalarm" >
		<option value="yes" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['mailalarm'] == 'yes') {?>selected<?php }?>>是</option>
		<option value="no" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['mailalarm'] == 'no') {?>selected<?php }?>>否</option>
		</select>&nbsp;打开认证告警邮件，如果告警邮件过多可能造成邮件堵塞，修改后请到系统管理中重启认证服务
		</td>
		
	</tr>
	
	<tr><td align="right"><?php echo $_smarty_tpl->tpl_vars['language']->value['StartupsyslogAlert'];?>
:</td>
		<td align=left>&nbsp;
		<input type="radio" name="syslog_alarm" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['Syslog_Alarm'] == '1') {?>checked<?php }?> value="1" /><?php echo $_smarty_tpl->tpl_vars['language']->value['Startup'];?>
 <input type="radio" name="syslog_alarm" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['Syslog_Alarm'] == '0') {?>checked<?php }?> value="0" /><?php echo $_smarty_tpl->tpl_vars['language']->value['Shutdown'];?>

		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">syslog<?php echo $_smarty_tpl->tpl_vars['language']->value['Server'];?>
:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="syslogserver" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['syslogserver'];?>
" />
		</td>
		
	</tr>
	<tr><td align="right">syslog<?php echo $_smarty_tpl->tpl_vars['language']->value['port'];?>
:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="syslogport" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['syslogport'];?>
" />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">syslog<?php echo $_smarty_tpl->tpl_vars['language']->value['device'];?>
:</td>
		<td align=left>&nbsp;
		<select  class="wbk"  name="syslog_facility" >
		<option value="local0" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['syslog_facility'] == 'local0') {?>selected<?php }?>>local0</option>
		<option value="local1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['syslog_facility'] == 'local1') {?>selected<?php }?>>local1</option>
		<option value="local2" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['syslog_facility'] == 'local2') {?>selected<?php }?>>local2</option>
		<option value="local3" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['syslog_facility'] == 'local3') {?>selected<?php }?>>local3</option>
		<option value="local4" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['syslog_facility'] == 'local4') {?>selected<?php }?>>local4</option>
		<option value="local5" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['syslog_facility'] == 'local5') {?>selected<?php }?>>local5</option>
		<option value="local6" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['syslog_facility'] == 'local6') {?>selected<?php }?>>local6</option>
		<option value="local7" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['syslog_facility'] == 'local7') {?>selected<?php }?>>local7</option>
		</select>
		</td>
		
	</tr>
	<tr>
			<td colspan="2" align="center"><input type="submit"  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td>
		</tr>

	</table>
	<input type="hidden" name="ac" value="<?php if ($_smarty_tpl->tpl_vars['alarm']->value['uid']) {?>edit<?php } else { ?>new<?php }?>" />
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