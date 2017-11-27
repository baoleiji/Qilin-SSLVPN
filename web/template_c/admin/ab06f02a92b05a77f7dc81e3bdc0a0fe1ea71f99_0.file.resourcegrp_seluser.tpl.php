<?php /* Smarty version 3.1.27, created on 2016-12-04 20:09:07
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/resourcegrp_seluser.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:100126621358440763a80ff1_01034174%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab06f02a92b05a77f7dc81e3bdc0a0fe1ea71f99' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/resourcegrp_seluser.tpl',
      1 => 1474793222,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '100126621358440763a80ff1_01034174',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'trnumber' => 0,
    'language' => 0,
    'luser' => 0,
    'allforbiddengroup' => 0,
    'acl' => 0,
    'webusers' => 0,
    'uid' => 0,
    'sid' => 0,
    'sessionluser' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58440763b6ee18_66304390',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58440763b6ee18_66304390')) {
function content_58440763b6ee18_66304390 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '100126621358440763a80ff1_01034174';
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
 <FORM name="f1" onSubmit="return check()" action="admin.php?controller=admin_pro&action=resourcegrp_seluser_save" 
            method="post">

              <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" valign="top"  class="BBtable">
                <TBODY>
				<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD colspan="2" class="list_bg">设置</TD>
                  </TR>
                  <TR id="autosutr"  <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right"><?php echo $_smarty_tpl->tpl_vars['language']->value['automaticallyloginassuperadministrator'];?>
</TD>
                    <TD><INPUT id="autosu" <?php if ($_smarty_tpl->tpl_vars['luser']->value['autosu'] == 1) {?> checked <?php }?> type=checkbox name=autosu value="on">                      </TD>
                  </TR>
                  <TR id="autosutr" <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right"><?php echo $_smarty_tpl->tpl_vars['language']->value['syslogAlertwhenloginin'];?>
</TD>
                    <TD><INPUT id="syslogalert" <?php if ($_smarty_tpl->tpl_vars['luser']->value['syslogalert'] == 1) {?> checked <?php }?> type=checkbox name=syslogalert value="on">                  </TD>
                  </TR>
                  <TR id="autosutr"  <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right"><?php echo $_smarty_tpl->tpl_vars['language']->value['mailalertwhenloginin'];?>
</TD>
                    <TD><INPUT id="mailalert" <?php if ($_smarty_tpl->tpl_vars['luser']->value['mailalert'] == 1) {?> checked <?php }?> type=checkbox name=mailalert value="on">              </TD>
                  </TR>
                  <TR id="autosutr" <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right"><?php echo $_smarty_tpl->tpl_vars['language']->value['accountlocked'];?>
 </TD>
                    <TD><INPUT id="loginlock" <?php if ($_smarty_tpl->tpl_vars['luser']->value['loginlock'] == 1) {?> checked <?php }?> type=checkbox name=loginlock value="on">                    </TD>
                  </TR>
				  
                  <TR <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right">命令权限 </TD>
                    <TD><select  class="wbk"  name=forbidden_commands_groups>
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['no'];?>
</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['f'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['f']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['name'] = 'f';
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allforbiddengroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['f']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['f']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['f']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['f']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['f']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['f']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['f']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['f']['total']);
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['allforbiddengroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f']['index']]['gname'];?>
" <?php if ($_smarty_tpl->tpl_vars['allforbiddengroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f']['index']]['gname'] == $_smarty_tpl->tpl_vars['luser']->value['forbidden_commands_groups']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['allforbiddengroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f']['index']]['gname'];?>
(<?php if ($_smarty_tpl->tpl_vars['allforbiddengroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f']['index']]['black_or_white'] == 1) {?>白名单<?php } elseif ($_smarty_tpl->tpl_vars['allforbiddengroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f']['index']]['black_or_white'] == 3) {?>授权命令<?php } else { ?>黑名单<?php }?>)</option>
			<?php endfor; endif; ?>
                  </SELECT>      </TD>
                  </TR>
				  <TR <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right">登录规则 </TD>
                    <TD><select name="restrictacl" id="restrictacl" >
					<option value="" >所有</option>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['a'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['a']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['name'] = 'a';
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['acl']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total']);
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['acl']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['luser']->value['restrictacl'] == $_smarty_tpl->tpl_vars['acl']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['acl']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['aclname'];?>
</option>
					<?php endfor; endif; ?>
					</select> </TD>
                  </TR>
				  <TR  <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right">双人授权 </TD>
                    <TD><INPUT id="twoauth" <?php if ($_smarty_tpl->tpl_vars['luser']->value['twoauth'] == 1) {?> checked <?php }?> type=checkbox onclick="checktwo(this.checked);" name=twoauth value="on">      </TD>
                  </TR>
				   <TR bgcolor="" id="wf_2" <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right">登录短信告警</TD>
                    <TD><INPUT id="smsalert" <?php if ($_smarty_tpl->tpl_vars['luser']->value['smsalert'] == 1) {?> checked <?php }?> type=checkbox name=smsalert value="on">           </TD>
                  </TR>
				  <TR bgcolor="" id="wf_2" <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right">流程审批</TD>
                    <TD><INPUT id="workflow" onclick="sworkflow(this.checked);" <?php if ($_smarty_tpl->tpl_vars['luser']->value['workflow'] == 1) {?> checked <?php }?> type=checkbox name=workflow value="on">           </TD>
                  </TR>
				  <TR  <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id=tr_wf_user1>
                    <TD width="50%" align="right">审批人一 </TD>
                    <TD><select  class="wbk"  name=wf_user1 id=wf_user1 >
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['no'];?>
</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['w'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['w']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['name'] = 'w';
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['webusers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total']);
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'] == $_smarty_tpl->tpl_vars['luser']->value['wf_user1']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['username'];?>
</option>
			<?php endfor; endif; ?>
                  </SELECT>       </TD>
                  </TR>
				  <TR id=tr_wf_user2 <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right">审批人二 </TD>
                    <TD><select  class="wbk"  name=wf_user2 id=wf_user2>
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['no'];?>
</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['w'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['w']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['name'] = 'w';
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['webusers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total']);
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'] == $_smarty_tpl->tpl_vars['luser']->value['wf_user2']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['username'];?>
</option>
			<?php endfor; endif; ?>
                  </SELECT>       </TD>
                  </TR>
				  <TR  <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id=tr_wf_user3>
                    <TD width="50%" align="right">审批人三 </TD>
                    <TD><select  class="wbk"  name=wf_user3 id=wf_user3>
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['no'];?>
</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['w'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['w']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['name'] = 'w';
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['webusers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total']);
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'] == $_smarty_tpl->tpl_vars['luser']->value['wf_user3']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['username'];?>
</option>
			<?php endfor; endif; ?>
                  </SELECT>       </TD>
                  </TR>
				  <TR id=tr_wf_user4 <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                    <TD width="50%" align="right">审批人四 </TD>
                    <TD><select  class="wbk"  name=wf_user4 id=wf_user4>
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['no'];?>
</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['w'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['w']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['name'] = 'w';
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['webusers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total']);
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'] == $_smarty_tpl->tpl_vars['luser']->value['wf_user4']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['username'];?>
</option>
			<?php endfor; endif; ?>
                  </SELECT>       </TD>
                  </TR>
				  <TR  <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id=tr_wf_user5>
                    <TD width="50%" align="right">审批人五 </TD>
                    <TD><select  class="wbk"  name=wf_user5 id=wf_user5>
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['no'];?>
</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['w'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['w']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['name'] = 'w';
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['webusers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['w']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['w']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['w']['total']);
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['uid'] == $_smarty_tpl->tpl_vars['luser']->value['wf_user5']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['webusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['w']['index']]['username'];?>
</option>
			<?php endfor; endif; ?>
                  </SELECT>       </TD>
                  </TR>
                  <TR>
                    <TD colspan="2" align="center"><INPUT class="an_02" type="submit" value="保存修改"></TD>
                  </TR>
                </TBODY>
              </TABLE>
          <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['luser']->value['id'];?>
" />
<input type="hidden" name="uid" value="<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
" />
<input type="hidden" name="sid" value="<?php echo $_smarty_tpl->tpl_vars['sid']->value;?>
" />
<input type="hidden" name="sessionluser" value="<?php echo $_smarty_tpl->tpl_vars['sessionluser']->value;?>
" /></FORM>


<?php echo '<script'; ?>
>
function sworkflow(checked){
	if(checked){
		for(var i=1; i<=5; i++){
			document.getElementById('tr_wf_user'+i).style.display = '';
		}
	}else{
		for(var i=1; i<=5; i++){
			document.getElementById('tr_wf_user'+i).style.display = 'none';
		}
	}
}
var success = true;
function checkwfuser(user, b){
	success = true;
	checkwfuser1(user,b);
	return success;
}
function checkwfuser1(user, b){
	if(document.getElementById('wf_user'+user).options[document.getElementById('wf_user'+user).options.selectedIndex].value > 0){
		b = true;
		if(user-1>0){
			if(checkwfuser1(user-1, b)==false&&b){
				success = false;
				alert('请选择流程批准人'+(user-1));
				return false;
			}
		}
		return true;
	}
	if(user-1>0&&b==false){
		checkwfuser1(user-1, b);
	}
	return false;
}
function checktwo(c){
  if(c){
	document.getElementById('workflow').checked = true;
	sworkflow(true);
  }
}
sworkflow(<?php if (!$_smarty_tpl->tpl_vars['luser']->value['workflow']) {?>false<?php } else { ?>true<?php }?>);
<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>