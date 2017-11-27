<?php /* Smarty version 3.1.27, created on 2017-01-01 13:00:28
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/login.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:149392772158688cecc74c34_37016696%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6fda1d9643ab23e2d5a33124a08bd7515d5e9a2e' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/login.tpl',
      1 => 1483239516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149392772158688cecc74c34_37016696',
  'variables' => 
  array (
    'template_root' => 0,
    'dpwdtime' => 0,
    'datetime' => 0,
    'logintype' => 0,
    'loginauthtype' => 0,
    'Certificate' => 0,
    'memberscount' => 0,
    'nametype' => 0,
    'members' => 0,
    'authtype' => 0,
    'ldaps' => 0,
    'ads' => 0,
    'cacn' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58688cecda2434_26479259',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58688cecda2434_26479259')) {
function content_58688cecda2434_26479259 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '149392772158688cecc74c34_37016696';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>login</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<LINK rel=stylesheet type=text/css href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/all_purpose_style.css">
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<META name=GENERATOR content="MSHTML 9.00.8112.16470">
</HEAD>
<BODY>
<P>&nbsp;</P>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div style=" margin:0 auto; width:634px;">
<TABLE width="634" border=0 align=center cellPadding=0 cellSpacing=0>
      <FORM name="l" id="doAmsForm" action="admin.php?controller=admin_index&amp;action=chklogin&amp;ref=" 
      method="post" target="_top" >  <TBODY>
  <TR>
    <TD align=center><IMG border=0 src="logo/logo1.jpg" 
      width=634 height=73></TD>
  </TR>
  <TR>
    <TD height=251 align=center valign="top" background="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/bottom_bg.jpg"><table width="60%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="180" align="center" valign="middle"><table width="95%" border="0" cellpadding="5" cellspacing="1" bgcolor="a8c6d8" cellpadding="0">
		<?php if ($_smarty_tpl->tpl_vars['dpwdtime']->value) {?>
          <tr>
            <td height="32" bgcolor="dae4e4"><strong> &nbsp;欢迎登陆</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> &nbsp;<?php echo $_smarty_tpl->tpl_vars['datetime']->value;?>
</strong></td>
          </tr>
		  <?php } else { ?>
		  <tr>
              <td height="35" align="center" background="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/dl_bg.jpg"><font style="font-size:14px; font-weight:bold; color:#005d9d;"> 欢迎登陆</font></td>
            </tr>
		  <?php }?>
          <tr>
            <td bgcolor="ffffff"><TABLE width="100%" border="0" cellspacing="1" 
cellpadding="0">
              <TBODY>
                <TR>
                  <TD width="<?php if (!$_smarty_tpl->tpl_vars['logintype']->value['ldapauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['radiusauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['adauth'] || !$_smarty_tpl->tpl_vars['loginauthtype']->value) {?>35<?php } else { ?>30<?php }?>%" height="<?php if ($_smarty_tpl->tpl_vars['dpwdtime']->value) {?>30<?php } else { ?>40<?php }?>" align="right" bgcolor="#edf6f6">用户名：</TD>
                  <TD width="" id="tdusername">
<?php if ($_smarty_tpl->tpl_vars['Certificate']->value == 2 || !$_smarty_tpl->tpl_vars['Certificate']->value) {?>
<?php if ($_smarty_tpl->tpl_vars['memberscount']->value == 0) {?>
<input type="text" name="username" id="username"  onblur="changeusername(this.value,'u');" <?php if ($_smarty_tpl->tpl_vars['nametype']->value == 'realname') {?>disabled='disabled'<?php }?>  style="width: <?php if (!$_smarty_tpl->tpl_vars['logintype']->value['ldapauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['radiusauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['adauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['fingersecauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['localfingersecauth'] || !$_smarty_tpl->tpl_vars['loginauthtype']->value || !$_smarty_tpl->tpl_vars['loginauthtype']->value) {?>155<?php } else { ?>100<?php }?>px;<?php if (!$_smarty_tpl->tpl_vars['dpwdtime']->value) {?>height:24px;<?php }
if ($_smarty_tpl->tpl_vars['nametype']->value == 'realname') {?>display:none<?php }?>">
<input type="text" name="username" id="realname"  onblur="changeusername(this.value,'r');" <?php if ($_smarty_tpl->tpl_vars['nametype']->value == 'username' || !$_smarty_tpl->tpl_vars['nametype']->value) {?>disabled='disabled'<?php }?>  style="width: <?php if (!$_smarty_tpl->tpl_vars['logintype']->value['ldapauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['radiusauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['adauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['fingersecauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['localfingersecauth'] || !$_smarty_tpl->tpl_vars['loginauthtype']->value || !$_smarty_tpl->tpl_vars['loginauthtype']->value) {?>155<?php } else { ?>100<?php }?>px;<?php if (!$_smarty_tpl->tpl_vars['dpwdtime']->value) {?>height:24px;<?php }
if ($_smarty_tpl->tpl_vars['nametype']->value == 'username') {?>display:none<?php }?>">

<?php } else { ?>
<select name='username' id="username"  style="width: <?php if (!$_smarty_tpl->tpl_vars['logintype']->value['ldapauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['radiusauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['adauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['fingersecauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['localfingersecauth'] || !$_smarty_tpl->tpl_vars['loginauthtype']->value || !$_smarty_tpl->tpl_vars['loginauthtype']->value) {?>155<?php } else { ?>200<?php }?>px;<?php if (!$_smarty_tpl->tpl_vars['dpwdtime']->value) {?>height:24px;<?php }?>">
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
<option value='<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['username'];?>
'  <?php if ($_COOKIE['username'] == $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['username']) {?>selected<?php }?>  ><?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['username'];?>
</option>
<?php endfor; endif; ?>
</select>
<select name='username' id="realname" disabled style="width: <?php if (!$_smarty_tpl->tpl_vars['logintype']->value['ldapauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['radiusauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['adauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['fingersecauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['localfingersecauth'] || !$_smarty_tpl->tpl_vars['loginauthtype']->value || !$_smarty_tpl->tpl_vars['loginauthtype']->value) {?>155<?php } else { ?>200<?php }?>px;<?php if (!$_smarty_tpl->tpl_vars['dpwdtime']->value) {?>height:24px;<?php }?>display:none">
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['n'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['n']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['name'] = 'n';
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['members']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total']);
?>
<option value='<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['n']['index']]['realname'];?>
'  <?php if ($_COOKIE['username'] == $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['realname']) {?>selected<?php }?>  ><?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['n']['index']]['realname'];?>
</option>
<?php endfor; endif; ?>
</select>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['loginauthtype']->value) {?>
<?php if (!$_smarty_tpl->tpl_vars['logintype']->value['ldapauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['radiusauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['adauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['fingersecauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['localfingersecauth']) {?>
<input type="hidden" name="authtype" id="authtype" value="localauth">
<?php } else { ?>
<select name='authtype' id="authtype" style="width:95px;<?php if (!$_smarty_tpl->tpl_vars['dpwdtime']->value) {?>height:24px;<?php }?>" onchange="changeauthtype(this.value);">
<option value='localauth' <?php if ($_smarty_tpl->tpl_vars['authtype']->value == 'localauth') {?>selected<?php }?>>本地认证</option>
<?php if ($_smarty_tpl->tpl_vars['logintype']->value['radiusauth']) {?>
<option value='radiusauth' <?php if ($_smarty_tpl->tpl_vars['authtype']->value == 'radiusauth') {?>selected<?php }?>>RADIUS认证</option>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['logintype']->value['ldapauth']) {?>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['l'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['l']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['name'] = 'l';
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ldaps']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total']);
?>
<option value='ldapauth_<?php echo $_smarty_tpl->tpl_vars['ldaps']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['address'];?>
' <?php if ($_smarty_tpl->tpl_vars['authtype']->value == 'ldapauth') {?>selected<?php }?>>LDAP <?php echo $_smarty_tpl->tpl_vars['ldaps']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['domain'];?>
</option>
<?php endfor; endif; ?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['logintype']->value['adauth']) {?>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['a'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['a']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['name'] = 'a';
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ads']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
<option value='adauth_<?php echo $_smarty_tpl->tpl_vars['ads']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['address'];?>
' <?php if ($_smarty_tpl->tpl_vars['authtype']->value == 'adauth') {?>selected<?php }?>>AD <?php echo $_smarty_tpl->tpl_vars['ads']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['domain'];?>
</option>
<?php endfor; endif; ?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['logintype']->value['fingersecauth']) {?>
<option value='fingersecauth' <?php if ($_smarty_tpl->tpl_vars['authtype']->value == 'fingersecauth') {?>selected<?php }?>>指纹认证</option>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['logintype']->value['localfingersecauth']) {?>
<option value='localfingersecauth' <?php if ($_smarty_tpl->tpl_vars['authtype']->value == 'localfingersecauth') {?>selected<?php }?>>本地+指纹认证</option>
<?php }?>
<?php }?>
</select>
<input type="hidden" name="memberscount" id="memberscountid" value="<?php echo $_smarty_tpl->tpl_vars['memberscount']->value;?>
" />
<input type="hidden" name="cacn" id="cacn" value="<?php echo $_smarty_tpl->tpl_vars['cacn']->value;?>
" />
<?php }?>
<?php }?>
                  </TD>
                </TR>
                <TR id="passwordstr">
                  <TD height="<?php if ($_smarty_tpl->tpl_vars['dpwdtime']->value) {?>30<?php } else { ?>40<?php }?>" align="right" 
                      bgcolor="#edf6f6">口&nbsp;令：</TD>
                  <TD><INPUT name="password" id="textfield2" autocomplete="off" style="width: <?php if (!$_smarty_tpl->tpl_vars['logintype']->value['ldapauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['radiusauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['adauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['fingersecauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['localfingersecauth'] || !$_smarty_tpl->tpl_vars['loginauthtype']->value || !$_smarty_tpl->tpl_vars['loginauthtype']->value) {?>155<?php } else { ?>200<?php }?>px;<?php if (!$_smarty_tpl->tpl_vars['dpwdtime']->value) {?>height:24px;<?php }?>" type="password"></TD>
                </TR>
				<?php if ($_smarty_tpl->tpl_vars['dpwdtime']->value) {?>
                <TR id="dongtaitr">
                  <TD height="30" align="right" bgcolor="#edf6f6">动态密码：</TD>
                  <TD><INPUT name="dpassword" autocomplete="off" id="textfield22" style="width: <?php if (!$_smarty_tpl->tpl_vars['logintype']->value['ldapauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['radiusauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['adauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['fingersecauth'] && !$_smarty_tpl->tpl_vars['logintype']->value['localfingersecauth'] || !$_smarty_tpl->tpl_vars['loginauthtype']->value || !$_smarty_tpl->tpl_vars['loginauthtype']->value) {?>155<?php } else { ?>200<?php }?>px; color: rgb(153, 153, 153);" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" type="text" placeholder="令牌用户输入"></TD>
                </TR>
                <TR id="renztr">
                  <TD height="30" align="right" bgcolor="#edf6f6">认证方式：</TD>
                  <TD><INPUT name="nametype" id="radio" onClick="changelogintype('username');" 
                        type="radio" checked="" <?php if ($_smarty_tpl->tpl_vars['nametype']->value == 'username') {?>checked<?php }?> value="username">
                    登录名
                    <INPUT name="nametype" id="radio2" 
                        onclick="changelogintype('realname');" type="radio" <?php if ($_smarty_tpl->tpl_vars['nametype']->value == 'realname') {?>checked<?php }?> 
                        value="realname">
                    别名</TD>
                </TR>
				<?php }?>
				 <tr id="fingertr" style="display:none">
	   <td align='center' colspan="2">
		 <div class="bder" id="fingerDiv">
  <object id='TLFPAPICtrl' name='TLFPAPICtrl' width="98px" height="85px" classid="CLSID:57FA9034-0DC3-4882-A932-DDDA228FEE05" style="padding-top:-40px;" >
	<param name="Token" value="12345678912345678912345678912345" />
	<param name="CtrlType" value="Verify" />
		<embed id="pluginobj" type="application/mozilla-TLFPAPICtrl-plugin" width="98px" height="85px" Token="12345678912345678912345678912345"                  CtrlType="Verify" style="padding-top:-40px;">
		</embed>											
   </object>
</div>
	   </td>
	  </tr>
              </TBODY>
            </TABLE></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="35" align="center">
			<input name="fpdata" type="hidden" id="fpdata" value="" />
		<input name="button" type="submit" class="<?php if (0 && $_smarty_tpl->tpl_vars['dpwdtime']->value) {?>dl_btn1<?php } else { ?>btn1<?php }?>" id="button" value="登 录"></td>
      </tr>
    </table></TD>
  </TR>
  </FORM></TABLE>
  </div>
   <?php if ($_smarty_tpl->tpl_vars['Certificate']->value == 1) {?>
  <OBJECT id="capicom" codeBase="capicom.cab#version=2,0,0,3" classid="clsid:A996E48C-D3DC-4244-89F7-AFA33EC60679" VIEWASTEXT>
</OBJECT>
<?php }?>
  <?php echo '<script'; ?>
 >
 /* <?php if ($_smarty_tpl->tpl_vars['memberscount']->value > 0) {?>
  Members = new Array();
  var i=0;
  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['n'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['n']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['name'] = 'n';
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['members']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['n']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['n']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['n']['total']);
?>
  Members[i++]={username: '<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['n']['index']]['username'];?>
', realname: '<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['n']['index']]['realname'];?>
'};
  <?php endfor; endif; ?>
  <?php }?>*/
  
 function changeauthtype(atype){
	if(atype=="fingersecauth"||atype=="localfingersecauth"){
		document.getElementById('dongtaitr').style.display='none';
		document.getElementById('renztr').style.display='none';
		document.getElementById('fingertr').style.display='';
		document.getElementById('passwordstr').style.display='';
		if(atype=="fingersecauth"){
			document.getElementById('passwordstr').style.display='none';
		}
	}else{
		document.getElementById('fingertr').style.display='none';
		document.getElementById('passwordstr').style.display='';
		document.getElementById('dongtaitr').style.display='';
		document.getElementById('renztr').style.display='';
	}
  }

 function changelogintype(ltype)
  {
	  <?php if ($_smarty_tpl->tpl_vars['Certificate']->value) {?>
    if(ltype=='username'){
		document.getElementById('username').style.display='';
		document.getElementById('username').disabled=false;
		document.getElementById('realname').style.display='none';
		document.getElementById('realname').disabled=true;
	}else{
		document.getElementById('username').style.display='none';
		document.getElementById('username').disabled=true;
		document.getElementById('realname').style.display='';
		document.getElementById('realname').disabled=false;
	}
	  <?php }?>
  }
<?php if ($_smarty_tpl->tpl_vars['Certificate']->value == 1) {?>
function trimStr(str){return str.replace(/(^\s*)|(\s*$)/g,"");}
function getClientID()
{
	var CAPICOM_CURRENT_USER_STORE = 2;
	var CAPICOM_MY_STORE = "my";//读取的目录名称，如果读取个人证书则应该写入变量"my",如果是根证书则是root
	var CAPICOM_STORE_OPEN_READ_WRITE=1;

	var myStore = new ActiveXObject("CAPICOM.Store");

	myStore.Open(CAPICOM_CURRENT_USER_STORE,CAPICOM_MY_STORE,CAPICOM_STORE_OPEN_READ_WRITE); 
	var myStoreCerts = myStore.Certificates;

	// 获取所有my证书的名字
	var info="";
	for(i = 1; i<= myStoreCerts.Count; i++)
	{  
	   var itmp = myStoreCerts.Item(i).subjectname.split(','); //SerialNumber
	   for(var j=0; j<itmp.length; j++){	  
		   var jtmp = itmp[j].split('=');
		   jtmp[0]=trimStr(jtmp[0]);
		   if(jtmp[0]=='CN'){
			info += trimStr(jtmp[1]) + ";";  
		   }
	   }	  	   
	}
	return info;
}

var url="admin.php?controller=admin_index&action=login_user_field&cacn="+getClientID();//alert(url);
  $.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; //在这里this指向的是Ajax请求的选项配置信息，请参考下图
		document.getElementById('tdusername').innerHTML = data;
		memberscount=document.getElementById('memberscountid').value;
	});
<?php } else { ?>
changelogintype('<?php echo $_smarty_tpl->tpl_vars['nametype']->value;?>
')
<?php }?>
 function checkdpwd(){
 	var obj = document.getElementById('textfield22');
 	if(obj==null||obj==undefined||obj.value==''||/^[0-9a-z]+$/.test(obj.value)){
 		return true;
 	}
 	alert('动态密码请输入小写字母或数字');
 	return false;
 }
function changeusername(username,t){
var url="admin.php?controller=admin_index&action=get_user_login_fristauth&username="+username+"&t="+t;//alert(url);
  $.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; //在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//document.getElementById('authtype').options.selectedIndex=
		if(data=='') return ;
		$("#authtype").val(data);
		changeauthtype(data);
	});
}
changeauthtype(document.getElementById('authtype').options[document.getElementById('authtype').options.selectedIndex].value);
  <?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/finger.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 for="TLFPAPICtrl" event="GotFeatureEvent()" language="javascript">hasGotFeatureEvent();<?php echo '</script'; ?>
>
</BODY></HTML>
<?php }
}
?>