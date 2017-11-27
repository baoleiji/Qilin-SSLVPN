<?php /* Smarty version 3.1.27, created on 2017-08-25 08:36:08
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/config_login.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:635973632599f70f831dbf3_19899557%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4c0bffbf4f67b7ede3434dee6214e81002d5d9e' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/config_login.tpl',
      1 => 1483243763,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '635973632599f70f831dbf3_19899557',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'trnumber' => 0,
    'loginsetting' => 0,
    'udf' => 0,
    'sid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_599f70f83e1cf3_15910289',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_599f70f83e1cf3_15910289')) {
function content_599f70f83e1cf3_15910289 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '635973632599f70f831dbf3_19899557';
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
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=login_save">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td><?php echo $_smarty_tpl->tpl_vars['language']->value['Minimumpasswordlength'];?>
:</td>
		<td align=left>
		<input type="text" class="wbk" name="login_pwd_length" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['login_pwd_length'];?>
" />
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>错误登陆锁定:</td>
		<td align=left>
		<input type="text" class="wbk" name="login_times" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['login_times'];?>
" />
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>错误登陆锁定时间:</td>
		<td align=left>
		<input type="text" class="wbk" name="login_times_last" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['login_times_last'];?>
" />分钟
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td><?php echo $_smarty_tpl->tpl_vars['language']->value['Time'];
echo $_smarty_tpl->tpl_vars['language']->value['Set'];?>
:</td>
		<td align=left>
		<input type="text" class="wbk" name="logintimeout" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['logintimeout'];?>
" /><?php echo $_smarty_tpl->tpl_vars['language']->value['minutes'];?>

		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>自动密码:自动生成的密码长度</td>
		<td align=left>
		<input type="text" class="wbk" name="pwdautolength" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['pwdautolength'];?>
" />
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>记忆旧密码次数</td>
		<td align=left>
		<input type="text" class="wbk" name="oldpassnumber" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['oldpassnumber'];?>
" />
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>密码最大重复字符数</td>
		<td align=left>
		<input type="text" class="wbk" name="repeatnumber" value="<?php if (!$_smarty_tpl->tpl_vars['loginsetting']->value['repeatnumber']) {?>0<?php } else {
echo $_smarty_tpl->tpl_vars['loginsetting']->value['repeatnumber'];
}?>" /> 0为不限制
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>密码强度:</td>
		<td align=left>
		包含<input type="text" name="pwdstrong1" size="3" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['pwdstrong1'];?>
" />个数字
		包含<input type="text" name="pwdstrong2" size="3" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['pwdstrong2'];?>
" />个小写字母
		包含<input type="text" name="pwdstrong3" size="3" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['pwdstrong3'];?>
" />个大写字母
		包含<input type="text" name="pwdstrong4" size="3" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['pwdstrong4'];?>
" />个特殊字符
		</td>
		
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>密码有效期:</td>
		<td align=left>
		密码有效期：<input type="text" class="wbk" name="pwdexpired" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['pwdexpired'];?>
" />,
		提前<input type="text" class="wbk" name="pwdahead" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['pwdahead'];?>
" />天提醒用户注意
		</td>
		
	</tr>

	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>相同用户允许同时登录的最大值:</td>
		<td align=left>
		<input type="text" class="wbk" name="onlinecountmax" value="<?php echo $_smarty_tpl->tpl_vars['loginsetting']->value['onlinecountmax'];?>
" />
		</td>
		
	</tr>

	
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>认证调试:</td>
		<td align=left>
		<select name="debug" >
		<option value="yes" <?php if ($_smarty_tpl->tpl_vars['udf']->value['debug'] == 'yes') {?>selected<?php }?>>打开</option>
		<option value="no" <?php if ($_smarty_tpl->tpl_vars['udf']->value['debug'] == 'no') {?>selected<?php }?>>关闭</option>
		</select>
		</td>
		
	</tr>

	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>密码存贮:</td>
		<td align=left> 
			<?php if ($_smarty_tpl->tpl_vars['udf']->value['encrypt'] == 'yes') {?>加密<?php } else { ?>明文<?php }?>
		</td>
		
	</tr>


	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>><td>令牌漂移:</td>
		<td align=left>
		
		<select name="nr_minute" >
		<option value="15" <?php if ($_smarty_tpl->tpl_vars['udf']->value['nr_minute'] == '15') {?>selected<?php }?>>15</option>
		
		</select>
		</td>
		
	</tr>

	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
			<td  align="center" colspan=2><input type="submit"  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td>
		</tr>

	</table>
	<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['sid']->value;?>
" />
	<input type="hidden" name="encrypt2" value="<?php echo $_smarty_tpl->tpl_vars['udf']->value['encrypt'];?>
" />
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