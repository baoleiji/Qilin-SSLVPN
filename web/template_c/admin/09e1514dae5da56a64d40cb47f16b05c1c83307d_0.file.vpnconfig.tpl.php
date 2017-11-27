<?php /* Smarty version 3.1.27, created on 2016-12-31 19:46:02
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/vpnconfig.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:163778104958679a7a5737f5_27010998%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09e1514dae5da56a64d40cb47f16b05c1c83307d' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/vpnconfig.tpl',
      1 => 1474793222,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '163778104958679a7a5737f5_27010998',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'trnumber' => 0,
    'vpnconfig' => 0,
    'addr' => 0,
    'key' => 0,
    'udf' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58679a7a654749_63289514',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58679a7a654749_63289514')) {
function content_58679a7a654749_63289514 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '163778104958679a7a5737f5_27010998';
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
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=vpnconfig">VPN配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>

  
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_eth&action=vpnconfig_save">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>开放端口:</td>
		<td align=left>
		<input type="text" class="wbk" name="port" value="<?php echo $_smarty_tpl->tpl_vars['vpnconfig']->value['port'];?>
" />
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>IP地址池:</td>
		<td align=left>
		<input type="text" class="wbk" name="server1" value="<?php echo $_smarty_tpl->tpl_vars['vpnconfig']->value['server1'];?>
" />&nbsp;&nbsp;<input type="text" class="wbk" name="server2" value="<?php echo $_smarty_tpl->tpl_vars['vpnconfig']->value['server2'];?>
" />
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>最大连接:</td>
		<td align=left>
		<input type="text" class="wbk" name="max_clients" value="<?php echo $_smarty_tpl->tpl_vars['vpnconfig']->value['max_clients'];?>
" />
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>连接检测:</td>
		<td align=left>
		<input type="text" class="wbk" name="keepalive1" value="<?php echo $_smarty_tpl->tpl_vars['vpnconfig']->value['keepalive1'];?>
" />&nbsp;&nbsp;<input type="text" class="wbk" name="keepalive2" value="<?php echo $_smarty_tpl->tpl_vars['vpnconfig']->value['keepalive2'];?>
" />
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td>
		地址		
		</td>
		<td width="67%">
		<input type=text name="addr" size=35 value="<?php echo $_smarty_tpl->tpl_vars['addr']->value;?>
" >
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td>
		Key		
		</td>
		<td width="67%">
		<input type=text name="key" size=35 value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" >
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>启用压缩:</td>
		<td align=left>
		<select name="comp_lzo" id="comp_lzo">
		<option value="yes" <?php if ($_smarty_tpl->tpl_vars['vpnconfig']->value['comp_lzo'] == 1) {?>selected<?php }?>>是</option>
		<option value="no" <?php if ($_smarty_tpl->tpl_vars['vpnconfig']->value['comp_lzo'] == 0) {?>selected<?php }?>>否</option>
		</select>
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>终端互访:</td>
		<td align=left>
		<select name="client_to_client" id="client_to_client">
		<option value="yes" <?php if ($_smarty_tpl->tpl_vars['vpnconfig']->value['client_to_client'] == 1) {?>selected<?php }?>>是</option>
		<option value="no" <?php if ($_smarty_tpl->tpl_vars['vpnconfig']->value['client_to_client'] == 0) {?>selected<?php }?>>否</option>
		</select>
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
			<td  align="center" colspan=2><input type="submit"  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
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
   if(document.getElementById("encrypt").options[document.getElementById("encrypt").options.selectedIndex].value!='<?php echo $_smarty_tpl->tpl_vars['udf']->value['encrypt'];?>
'){
		if(confirm("所有的密码将被转换,请注意要先备份!")==false){
			return false;
		}
   }
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