<?php /* Smarty version 3.1.27, created on 2017-08-25 17:42:41
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/vpn_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1334620866599ff111ad7300_40701759%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8c51b5aa3afa8f1dc00123e562677d78886af7e' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/vpn_edit.tpl',
      1 => 1503654155,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1334620866599ff111ad7300_40701759',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'trnumber' => 0,
    'p' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_599ff111b29797_57550142',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_599ff111b29797_57550142')) {
function content_599ff111b29797_57550142 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1334620866599ff111ad7300_40701759';
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
 <SCRIPT language=javascript src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/selectdate.js"></SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/date";
</SCRIPT>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=vpn_list">VPN -策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_eth&action=vpn_list&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
    <form name="f1" method=post action="admin.php?controller=admin_eth&action=vpn_add">
		<tr><th colspan="3" class="list_bg"></th></tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>来源地址</td>
		<td width="67%"><input type="text" name="s_addr" size="40" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['s_addr'];?>
" />例如:192.168.1.0/255.255.255.0</td>
	</tr>
	
		<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>目标地址</td>
		<td width="67%"><input type="text"  name="d_addr" size="40" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['d_addr'];?>
" />例如:172.16.1.0/255.255.255.0</td>
	  </tr>
	 <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>映射地址</td>
		<td width="67%"><input type="text"  name="p_addr" size="40" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['p_addr'];?>
" />例如:10.100.1.1</td>
	  </tr>
		 	 
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
					<td  align="center" colspan=2><input type="hidden" name="ac" value="<?php if ($_smarty_tpl->tpl_vars['p']->value['sid']) {?>modify<?php } else { ?>new<?php }?>" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['sid'];?>
" />
<input type=submit  value="保存修改" class="an_02">
	</td>
  </tr>
</form>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>