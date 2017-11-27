<?php /* Smarty version 3.1.27, created on 2017-01-01 12:03:52
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/systemtype_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:92241695258687fa88c0103_39100067%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a791941c05f221e412281b2cae467476cd44cbc0' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/systemtype_edit.tpl',
      1 => 1483243421,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92241695258687fa88c0103_39100067',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'wt' => 0,
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58687fa88faab9_48295868',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58687fa88faab9_48295868')) {
function content_58687fa88faab9_48295868 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '92241695258687fa88c0103_39100067';
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
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
</head>
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
<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=systemtype&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
 
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
          <form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=systemtype_save&id=<?php echo $_smarty_tpl->tpl_vars['wt']->value['id'];?>
">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		系统类型
		</td>
		<td width="67%">
		<input type=text name="device_type" size=35 value="<?php echo $_smarty_tpl->tpl_vars['wt']->value['device_type'];?>
" >
	  </td>
	<tr bgcolor="">
		<td width="33%" align=right>
		超级用户切换命令
		</td>
		<td width="67%">
		<input type=text name="sucommand" size=35 value="<?php echo $_smarty_tpl->tpl_vars['wt']->value['sucommand'];?>
" >
	  </td>
	 </tr>
	 <tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		主机/网络
		</td>
		<td width="67%">
		<select name="snmp_system" >
		<option value="0" <?php if (!$_smarty_tpl->tpl_vars['wt']->value['snmp_system']) {?>selected<?php }?>>主机</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['wt']->value['snmp_system'] == 1) {?>selected<?php }?>>网络</option>
		</select>
	  </td>
	 </tr>

	<tr bgcolor="f7f7f7"><td align="center" colspan=2><input type=submit  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td></tr>


	</form>
</table>
<?php echo '<script'; ?>
>
function banit(number, ban){
	document.getElementById('start'+number).value='00:00:00';
	if(ban){		
		document.getElementById('end'+number).value='00:00:00';
	}else{
		document.getElementById('end'+number).value='23:59:59';
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