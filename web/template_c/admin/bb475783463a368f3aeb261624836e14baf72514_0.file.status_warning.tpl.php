<?php /* Smarty version 3.1.27, created on 2017-01-01 16:30:11
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/status_warning.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5434393405868be13165c72_35963824%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb475783463a368f3aeb261624836e14baf72514' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/status_warning.tpl',
      1 => 1483259393,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5434393405868be13165c72_35963824',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'trnumber' => 0,
    'alarm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5868be132266c0_63636677',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5868be132266c0_63636677')) {
function content_5868be132266c0_63636677 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '5434393405868be13165c72_35963824';
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
  <tr><td><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=status_warning">
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">

	<tr><th colspan="3" class="list_bg"></th></tr>
<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	<td align="right">CPU告警阀值:</td>
		<td align=left>&nbsp;
		下限:<input type="text" class="wbk" name="cpu_lowvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['cpu_lowvalue'];?>
" />&nbsp;&nbsp;&nbsp;上限:<input type="text" class="wbk" name="cpu_highvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['cpu_highvalue'];?>
" />&nbsp;&nbsp;&nbsp;邮件告警:<input type="checkbox" class="wbk" name="cpu_mail_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['cpu_mail_alarm']) {?> checked<?php }?>/>&nbsp;&nbsp;&nbsp;短信告警:<input type="checkbox" class="wbk" name="cpu_sms_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['cpu_sms_alarm']) {?> checked<?php }?>/>&nbsp;&nbsp;&nbsp;发送间隔:<input type="text" class="wbk" name="cpu_send_interval" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['cpu_send_interval'];?>
" />
		</td>
</tr>	
<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	<td align="right">内存告警阀值:</td>
		<td align=left>&nbsp;
		下限:<input type="text" class="wbk" name="memory_lowvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['memory_lowvalue'];?>
" />&nbsp;&nbsp;&nbsp;上限:<input type="text" class="wbk" name="memory_highvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['memory_highvalue'];?>
" />&nbsp;&nbsp;&nbsp;邮件告警:<input type="checkbox" class="wbk" name="memory_mail_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['memory_mail_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;短信告警:<input type="checkbox" class="wbk" name="memory_sms_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['memory_sms_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;发送间隔:<input type="text" class="wbk" name="memory_send_interval" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['memory_send_interval'];?>
" />
		</td>
</tr>
<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	<td align="right">SWAP告警阀值:</td>
		<td align=left>&nbsp;		
		下限:<input type="text" class="wbk" name="swap_lowvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['swap_lowvalue'];?>
" />&nbsp;&nbsp;&nbsp;上限:<input type="text" class="wbk" name="swap_highvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['swap_highvalue'];?>
" />&nbsp;&nbsp;&nbsp;邮件告警:<input type="checkbox" class="wbk" name="swap_mail_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['swap_mail_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;短信告警:<input type="checkbox" class="wbk" name="swap_sms_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['swap_sms_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;发送间隔:<input type="text" class="wbk" name="swap_send_interval" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['swap_send_interval'];?>
" />
		</td>
</tr>
<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	<td align="right">硬盘告警阀值:</td>
		<td align=left>&nbsp;		
		下限:<input type="text" class="wbk" name="disk_lowvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['disk_lowvalue'];?>
" />&nbsp;&nbsp;&nbsp;上限:<input type="text" class="wbk" name="disk_highvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['disk_highvalue'];?>
" />&nbsp;&nbsp;&nbsp;邮件告警:<input type="checkbox" class="wbk" name="disk_mail_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['disk_mail_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;短信告警:<input type="checkbox" class="wbk" name="disk_sms_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['disk_sms_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;发送间隔:<input type="text" class="wbk" name="disk_send_interval" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['disk_send_interval'];?>
" />
		</td>
</tr>
<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	<td align="right">DB告警阀值:</td>
		<td align=left>&nbsp;
		下限:<input type="text" class="wbk" name="db_lowvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['db_lowvalue'];?>
" />&nbsp;&nbsp;&nbsp;上限:<input type="text" class="wbk" name="db_highvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['db_highvalue'];?>
" />&nbsp;&nbsp;&nbsp;邮件告警:<input type="checkbox" class="wbk" name="db_mail_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['db_mail_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;短信告警:<input type="checkbox" class="wbk" name="db_sms_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['db_sms_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;发送间隔:<input type="text" class="wbk" name="db_send_interval" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['db_send_interval'];?>
" />
		</td>
</tr>
<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	<td align="right">mysql连接数告警阀值:</td>
		<td align=left>&nbsp;
		下限:<input type="text" class="wbk" name="mysql_lowvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['mysql_lowvalue'];?>
" />&nbsp;&nbsp;&nbsp;上限:<input type="text" class="wbk" name="mysql_highvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['mysql_highvalue'];?>
" />&nbsp;&nbsp;&nbsp;邮件告警:<input type="checkbox" class="wbk" name="mysql_mail_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['mysql_mail_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;短信告警:<input type="checkbox" class="wbk" name="mysql_sms_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['mysql_sms_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;发送间隔:<input type="text" class="wbk" name="mysql_send_interval" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['mysql_send_interval'];?>
" />
		</td>
</tr>
<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	<td align="right">http连接数告警阀值:</td>
		<td align=left>&nbsp;
		下限:<input type="text" class="wbk" name="http_lowvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['http_lowvalue'];?>
" />&nbsp;&nbsp;&nbsp;上限:<input type="text" class="wbk" name="http_highvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['http_highvalue'];?>
" />&nbsp;&nbsp;&nbsp;邮件告警:<input type="checkbox" class="wbk" name="http_mail_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['http_mail_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;短信告警:<input type="checkbox" class="wbk" name="http_sms_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['http_sms_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;发送间隔:<input type="text" class="wbk" name="http_send_interval" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['http_send_interval'];?>
" />
		</td>
</tr>
<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	<td align="right">tcp连接数告警阀值:</td>
		<td align=left>&nbsp;
		下限:<input type="text" class="wbk" name="tcp_lowvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['tcp_lowvalue'];?>
" />&nbsp;&nbsp;&nbsp;上限:<input type="text" class="wbk" name="tcp_highvalue" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['tcp_highvalue'];?>
" />&nbsp;&nbsp;&nbsp;邮件告警:<input type="checkbox" class="wbk" name="tcp_mail_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['tcp_mail_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;短信告警:<input type="checkbox" class="wbk" name="tcp_sms_alarm" value="1" <?php if ($_smarty_tpl->tpl_vars['alarm']->value['tcp_sms_alarm']) {?> checked<?php }?> />&nbsp;&nbsp;&nbsp;发送间隔:<input type="text" class="wbk" name="tcp_send_interval" value="<?php echo $_smarty_tpl->tpl_vars['alarm']->value['tcp_send_interval'];?>
" />
		</td>
</tr>
	<tr bgcolor="f7f7f7">
			<td colspan="2" align="center"><input type="submit"  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td>
		</tr>

	</table>
	<input type="hidden" name="ac" value="<?php if ($_smarty_tpl->tpl_vars['alarm']->value) {?>edit<?php } else { ?>new<?php }?>" />
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