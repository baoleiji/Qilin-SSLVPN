<?php /* Smarty version 3.1.27, created on 2017-05-16 16:00:27
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/route.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:615218775591ab19b1d4313_07508058%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a6eb4297bc4e53d49b7d1868b6c9d282134a4a1' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/route.tpl',
      1 => 1483239516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '615218775591ab19b1d4313_07508058',
  'variables' => 
  array (
    'template_root' => 0,
    'route' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_591ab19b2223e0_83307510',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_591ab19b2223e0_83307510')) {
function content_591ab19b2223e0_83307510 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '615218775591ab19b1d4313_07508058';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
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
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=ifcfgeth">网络配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=config_route">静态路由</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=ping">PING</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
  <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=tracepath">TRACE</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>

 
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	
	<tr>
		<th class="list_bg" align=center>序号</th>
		<th class="list_bg" align=center>网段</th>
		<th class="list_bg" align=center>掩码</th>
		<th class="list_bg" align=center>网关</th>
		<th class="list_bg" align=center>操作</th>
	</tr>
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['r'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['r']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['name'] = 'r';
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['route']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total']);
?>
	<form action='admin.php?controller=admin_eth&action=route_save' method='post'>
	<tr <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['r']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td align=center><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['r']['index']+1;?>
</td>
		<td align=center><input name='section' value='<?php echo $_smarty_tpl->tpl_vars['route']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['section'];?>
'></td>
		<td align=center><input name='netmask' value='<?php echo $_smarty_tpl->tpl_vars['route']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['netmask'];?>
'></td>
		<td align=center><input name='gateway' value='<?php echo $_smarty_tpl->tpl_vars['route']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['gateway'];?>
'></td>
		<td align=center><input type="submit" name="delete" value='删除' class="an_02"></td>
		
	</tr>
	<input type="hidden" name="sectionold" value="<?php echo $_smarty_tpl->tpl_vars['route']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['section'];?>
">
	<input type="hidden" name="netmaskold" value="<?php echo $_smarty_tpl->tpl_vars['route']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['netmask'];?>
">
	<input type="hidden" name="gatewayold" value="<?php echo $_smarty_tpl->tpl_vars['route']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['gateway'];?>
">
	</form>
	<?php endfor; endif; ?>
	<form action='admin.php?controller=admin_eth&action=route_add2' method='post'>
	<tr bgcolor="f7f7f7">
		<td align=center>增加</td>
		<td align=center><input name='section' value=''></td>
		<td align=center><input name='netmask' value=''></td>
		<td align=center><input name='gateway' value=''></td>
		<td align=center><input type='submit' value='增加' class="an_02"></td>
		
	</tr>
	</form>
	</table>


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

<?php echo '</script'; ?>
>
</body>
</html>



<?php }
}
?>