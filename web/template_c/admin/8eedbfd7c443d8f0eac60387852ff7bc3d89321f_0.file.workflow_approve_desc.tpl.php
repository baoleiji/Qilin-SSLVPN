<?php /* Smarty version 3.1.27, created on 2016-12-04 21:42:49
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/workflow_approve_desc.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:204885199958441d59f32519_09420975%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8eedbfd7c443d8f0eac60387852ff7bc3d89321f' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/workflow_approve_desc.tpl',
      1 => 1474793220,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '204885199958441d59f32519_09420975',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'wid' => 0,
    'status' => 0,
    'last' => 0,
    'wf' => 0,
    'members' => 0,
    'member' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58441d5a02b914_52564538',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58441d5a02b914_52564538')) {
function content_58441d5a02b914_52564538 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '204885199958441d59f32519_09420975';
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


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_workflow&action=do_workflow_approve&wid=<?php echo $_smarty_tpl->tpl_vars['wid']->value;?>
&status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<?php if ($_smarty_tpl->tpl_vars['last']->value) {?>
	<tr bgcolor="f7f7f7">
                  <TD  width="33%" align=center>操作人： </TD>
				  </tr>
				  <tr>
                  <TD>含有字符<input type="text" class="wbk" size="10" id="filtertext" onchange="filter();" />
                  <select  class="wbk"  name=username id="username" onchange="check_userpriority(<?php echo $_smarty_tpl->tpl_vars['wf']->value['devicesid'];?>
, this.value)">
                      <OPTION value="">请选择</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['members']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total']);
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'] == $_smarty_tpl->tpl_vars['member']->value['usbkey']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['username'];?>
</option>
			<?php endfor; endif; ?>
                  </SELECT>        
				  </TD>
                </TR>
	<?php }?>
                <TR bgcolor="f7f7f7">
                  <TD width="50%" align=center>备注: </TD>
				  </tr>
				  <tr>
                  <TD><textarea cols=55 rows=5 name="description"></textarea>               
				  </TD>
                </TR>            
	<tr><td align=center><input type=submit onclick="<?php if ($_smarty_tpl->tpl_vars['last']->value) {?>return cansubmit()<?php }?>"  value="提交" class="an_02"></td></tr></table>
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