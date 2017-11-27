<?php /* Smarty version 3.1.27, created on 2017-01-02 16:42:56
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/usersbylevel.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:342313053586a12908df8d6_17452997%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb5327514804e800d47aa2df23869044e08cff3c' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/usersbylevel.tpl',
      1 => 1483239516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '342313053586a12908df8d6_17452997',
  'variables' => 
  array (
    'members' => 0,
    'language' => 0,
    'url' => 0,
    'devicesid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_586a129096a039_87608176',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_586a129096a039_87608176')) {
function content_586a129096a039_87608176 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '342313053586a12908df8d6_17452997';
?>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD align="center">
          <form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_pro&action=docommit" target="hide">
            <TABLE width="90%" bgcolor="#ffffff" border="0" cellspacing="1" 
            cellpadding="5" valign="top" class="BBtable">
              <TBODY>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['m'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['m']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['name'] = 'm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['members']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total']);
?>
              <TR <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['m']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                <TD align="left" width="35%">
				<?php if ($_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['level'] == 0) {?>运维<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];
} elseif ($_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['level'] == 1) {
echo $_smarty_tpl->tpl_vars['language']->value['Administrator'];
} elseif ($_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['level'] == 3) {?>部门<?php echo $_smarty_tpl->tpl_vars['language']->value['Administrator'];
} elseif ($_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['level'] == 4) {?>配置<?php echo $_smarty_tpl->tpl_vars['language']->value['Administrator'];
} elseif ($_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['level'] == 10) {
echo $_smarty_tpl->tpl_vars['language']->value['Password'];
echo $_smarty_tpl->tpl_vars['language']->value['Administrator'];
} elseif ($_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['level'] == 21) {?>部门审计员<?php } elseif ($_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['level'] == 101) {?>部门密码员<?php } else {
echo $_smarty_tpl->tpl_vars['language']->value['auditadministrator'];
}?>
				</TD>
				<td align="left"><?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['count'];?>
</td>
				</TR>
            <?php endfor; endif; ?>
			</TBODY></TABLE>
           <input type="hidden" name="url" value="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" />
	<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['devicesid']->value;?>
" />
      </FORM></TD></TR></TBODY></TABLE></TR></TBODY></TABLE><?php }
}
?>