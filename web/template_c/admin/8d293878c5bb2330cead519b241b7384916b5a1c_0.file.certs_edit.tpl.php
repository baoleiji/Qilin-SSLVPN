<?php /* Smarty version 3.1.27, created on 2017-08-27 21:31:35
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/certs_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:126524577459a2c9b75a4410_13723491%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d293878c5bb2330cead519b241b7384916b5a1c' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/certs_edit.tpl',
      1 => 1503840644,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126524577459a2c9b75a4410_13723491',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'trnumber' => 0,
    'ip' => 0,
    'dns' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_59a2c9b75eda03_78019803',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_59a2c9b75eda03_78019803')) {
function content_59a2c9b75eda03_78019803 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '126524577459a2c9b75a4410_13723491';
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


	<table width="100%" border="0" cellspacing="0" cellpadding="0" >

<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
<form name="f1" method=post action="admin.php?controller=admin_config&action=certs_save">

          <tr><th colspan="3" class="list_bg"></th></tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?><tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>类型</td>
		<td width="67%">
			<select name="type" style="width: 120px;">
			<option value="0" <?php if ($_smarty_tpl->tpl_vars['ip']->value) {?>selected<?php }?>>IP 地址</option>
			<option value="1" <?php if ($_smarty_tpl->tpl_vars['dns']->value) {?>selected<?php }?>>主机名</option>
			</select>
		</td>
	  </tr>
	
		<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>IP</td>
		<td width="67%"><input type="text" name="ip" value="<?php echo $_smarty_tpl->tpl_vars['ip']->value;
echo $_smarty_tpl->tpl_vars['dns']->value;?>
" /></td>
	</tr>
		 	 
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
					<td  align="center" colspan=2>
<input type="hidden" name="oldip" value="<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
" />
<input type="hidden" name="olddns" value="<?php echo $_smarty_tpl->tpl_vars['dns']->value;?>
" />
<input type=submit  value="保存修改" class="an_02">

	</td>
  </tr></form>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>