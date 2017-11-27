<?php /* Smarty version 3.1.27, created on 2017-08-25 08:36:56
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/ifgeth.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1478220728599f712806f1d3_27424051%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1802f027b2211fa563fac563c5d1c1b9a86ab487' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/ifgeth.tpl',
      1 => 1483239516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1478220728599f712806f1d3_27424051',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'files' => 0,
    'systemversion' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_599f71280f8c63_29470441',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_599f71280f8c63_29470441')) {
function content_599f71280f8c63_29470441 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1478220728599f712806f1d3_27424051';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>服务<?php echo $_smarty_tpl->tpl_vars['language']->value['List'];?>
</title>
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
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=ifcfgeth">网络配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=config_route">静态路由</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
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
				<th class="list_bg"  width="10%">网卡名称</th>                            
				<th class="list_bg"  width="10%">启用</th>
				<th class="list_bg"  width="30%">网卡IP</th>
				<th class="list_bg"  width="20%">掩码</th>
				<th class="list_bg"  width="10%">网关</th>
				<th class="list_bg"  width="10%">状态</th>
				<th class="list_bg"  width=""><?php echo $_smarty_tpl->tpl_vars['language']->value['Operate'];?>
</th>
			</tr>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['files']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
				<?php if (!$_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['lo']) {?>
				<tr <?php if ($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['backup']) {?>bgcolor="red"<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
					<td><?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['name'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['ONBOOT'] == 1) {?><font color="green">启用</font><?php } else { ?>禁用<?php }?></ td>
					<td><?php if ($_smarty_tpl->tpl_vars['systemversion']->value == 7) {?>IP1:<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['IPADDR0'];?>
&nbsp;&nbsp;IP2:<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['IPADDR1'];?>
&nbsp;&nbsp;IP3:<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['IPADDR2'];
} else {
echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['IPADDR'];
}?></td>
					<td><?php if ($_smarty_tpl->tpl_vars['systemversion']->value == 7) {?>1:<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['NETMASK0'];?>
&nbsp;&nbsp;2:<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['NETMASK1'];?>
&nbsp;&nbsp;3:<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['NETMASK2'];
} else {
echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['NETMASK'];
}?></td>
					<td><?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['GATEWAY'];?>
</td>
					<td align="center"><?php if ($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['STATUS'] == 'yes') {?><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/Green.gif" ><?php } else { ?><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/hong.gif" ><?php }?></td>
					<td>
					<?php if ($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['lo'] != 1) {?><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a <?php if ($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['br0']) {?>onclick="alert('不能修改,已经绑定到bro');return false;" href="#"<?php } else { ?>href=" admin.php?controller=admin_eth&action=config_eth&file=<?php echo urlencode($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['file']);?>
&name=<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['name'];?>
"<?php }?>>修改</a>
					<?php if ($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['backupfile']) {?>&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_eth&action=eth_del&file=<?php echo urlencode($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['file']);?>
&name=<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['name'];?>
" onclick="return confirm('确定删除？')"><?php echo $_smarty_tpl->tpl_vars['language']->value['Delete'];?>
</a>
					<?php }?>
					<?php }?>
					</td>
				</tr>
				<?php }?>
			<?php endfor; endif; ?>			
		</table>
	</td>
  </tr>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>