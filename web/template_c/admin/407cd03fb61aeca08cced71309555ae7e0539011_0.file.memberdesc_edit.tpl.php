<?php /* Smarty version 3.1.27, created on 2017-01-01 15:34:16
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/memberdesc_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:16105386095868b0f8cd0f33_31002490%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '407cd03fb61aeca08cced71309555ae7e0539011' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/memberdesc_edit.tpl',
      1 => 1483242602,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16105386095868b0f8cd0f33_31002490',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'uid' => 0,
    'sip' => 0,
    'workdept' => 0,
    'workpost' => 0,
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5868b0f8d68d09_08107172',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5868b0f8d68d09_08107172')) {
function content_5868b0f8d68d09_08107172 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '16105386095868b0f8cd0f33_31002490';
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
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/Calendarandtime.js"><?php echo '</script'; ?>
>
</head>

<body>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action=memberdesc&uid=<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_member&action=memberdesc_save&uid=<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
&id=<?php echo $_smarty_tpl->tpl_vars['sip']->value['id'];?>
">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		动作
		</td>
		<td width="67%">
		<select name="action" >
		<option value="入职" <?php if ($_smarty_tpl->tpl_vars['sip']->value['action'] == '入职') {?>selected<?php }?>>入职</option>
		<option value="转正" <?php if ($_smarty_tpl->tpl_vars['sip']->value['action'] == '转正') {?>selected<?php }?>>转正</option>
		<option value="转岗" <?php if ($_smarty_tpl->tpl_vars['sip']->value['action'] == '转岗') {?>selected<?php }?>>转岗</option>
		<option value="离职" <?php if ($_smarty_tpl->tpl_vars['sip']->value['action'] == '离职') {?>selected<?php }?>>离职</option>
		<option value="其它" <?php if ($_smarty_tpl->tpl_vars['sip']->value['action'] == '其它') {?>selected<?php }?>>其它</option>
		</section>
	  </td>
	</tr>
	<tr bgcolor="">
		<td width="33%" align=right>
		过去部门
		</td>
		<td width="67%">
		<select name="prideptid" >
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pd'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['name'] = 'pd';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['workdept']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['workdept']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pd']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['sip']->value['prideptid'] == $_smarty_tpl->tpl_vars['workdept']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pd']['index']]['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['workdept']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pd']['index']]['title'];?>
</option>
		<?php endfor; endif; ?>
		</section>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		现在部门
		</td>
		<td width="67%">
		<select name="curdeptid" >
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['cd'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['name'] = 'cd';
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['workdept']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['workdept']->value[$_smarty_tpl->getVariable('smarty')->value['section']['cd']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['sip']->value['curdeptid'] == $_smarty_tpl->tpl_vars['workdept']->value[$_smarty_tpl->getVariable('smarty')->value['section']['cd']['index']]['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['workdept']->value[$_smarty_tpl->getVariable('smarty')->value['section']['cd']['index']]['title'];?>
</option>
		<?php endfor; endif; ?>
		</section>
	  </td>
	</tr>
	<tr bgcolor="">
		<td width="33%" align=right>
		过去职位
		</td>
		<td width="67%">
		<select name="pripostid" >
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pd'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['name'] = 'pd';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['workpost']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pd']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['workpost']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pd']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['sip']->value['pripostid'] == $_smarty_tpl->tpl_vars['workpost']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pd']['index']]['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['workpost']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pd']['index']]['title'];?>
</option>
		<?php endfor; endif; ?>
		</section>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		现在职位
		</td>
		<td width="67%">
		<select name="curpostid" >
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['cd'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['name'] = 'cd';
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['workpost']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['cd']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['workpost']->value[$_smarty_tpl->getVariable('smarty')->value['section']['cd']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['sip']->value['curpostid'] == $_smarty_tpl->tpl_vars['workpost']->value[$_smarty_tpl->getVariable('smarty')->value['section']['cd']['index']]['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['workpost']->value[$_smarty_tpl->getVariable('smarty')->value['section']['cd']['index']]['title'];?>
</option>
		<?php endfor; endif; ?>
		</section>
	  </td>
	</tr>
	<tr bgcolor="">
	<td width="33%" align=right valign="top">
		描述
		</td>
		<td width="67%">
		<textarea cols="37" rows="10"  name="desc"><?php echo $_smarty_tpl->tpl_vars['sip']->value['desc'];?>
</textarea>
	  </td>
	</tr>	
	<tr bgcolor="f7f7f7"><td></td><td><input type=submit  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td></tr></table>

</form>
	</td>
  </tr>
</table>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>