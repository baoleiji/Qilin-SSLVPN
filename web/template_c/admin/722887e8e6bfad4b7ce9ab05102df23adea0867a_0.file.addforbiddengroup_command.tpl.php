<?php /* Smarty version 3.1.27, created on 2016-12-31 18:31:53
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/addforbiddengroup_command.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:11500446758678919c21d12_83570083%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '722887e8e6bfad4b7ce9ab05102df23adea0867a' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/addforbiddengroup_command.tpl',
      1 => 1483180307,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11500446758678919c21d12_83570083',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'gid' => 0,
    'cmdinfo' => 0,
    'trnumber' => 0,
    'regex' => 0,
    'ginfo' => 0,
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58678919d578e6_57285430',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58678919d578e6_57285430')) {
function content_58678919d578e6_57285430 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '11500446758678919c21d12_83570083';
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
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=autochange_pwd">自动改密</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=cmdgroup_list">命令组</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ipacl">授权策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_contant">申请描述</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php if ($_SESSION['LICENSE_KEY_NETMANAGER'] && $_SESSION['CACTI_CONFIG_ON']) {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=documentlist">文档上传</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
</ul><span class="back_img"><A href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr> 
          <tr>

            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_forbidden&action=forbiddengps_cmd_save&cid=<?php echo $_smarty_tpl->tpl_vars['cmdinfo']->value['cid'];?>
">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
 <tr><th colspan="3" class="list_bg"></th></tr>
 <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['cid']) {?>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>
		命令:
		</td>
		<td width="67%">
		<input type = text name="cmd" id="cmd_0" value="<?php echo $_smarty_tpl->tpl_vars['cmdinfo']->value['cmd'];?>
">&nbsp;&nbsp;<input type="checkbox"  name="regex_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['c']['index'];?>
" <?php if ($_smarty_tpl->tpl_vars['regex']->value) {?>checked<?php }?> onclick="changeRegex(this.checked,0)" value="on">正则
	  </td>
	</tr>
	<?php if ($_smarty_tpl->tpl_vars['ginfo']->value['black_or_white'] == 0) {?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>
		级别:
		</td>
		<td width="67%">				
			<select  class="wbk"  name="level" >
			<option value="1" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['level'] == '1') {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['language']->value['Disconnect'];?>
</option>
			<option value="0" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['level'] == '0') {?>selected<?php }?>>命令阻断</option>
			<option value="2" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['level'] == '2') {?>selected<?php }?>>命令监控</option>
			<option value="3" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['level'] == '3') {?>selected<?php }?>>命令授权</option>
			</select>
	  </td>
	</tr>	
	<?php }?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>
		授权:
		</td>
		<td width="67%">				
			<select  class="wbk"  name="toauthorize" >
			<option value="0" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['toauthorize'] == '0') {?>selected<?php }?>>不授权</option>
			<option value="1" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['toauthorize'] == '1') {?>selected<?php }?>>Admin授权</option>
			<option value="2" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['toauthorize'] == '2') {?>selected<?php }?>>分组管理员授权</option>
			<option value="3" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['toauthorize'] == '3') {?>selected<?php }?>>双人授权</option>
			</select>
	  </td>
	</tr>	
<?php } else { ?>

	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['c'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['c']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['name'] = 'c';
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['loop'] = is_array($_loop=10) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['c']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['c']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['c']['total']);
?>
<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value++%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>
		命令:
		<input type = text name="cmd_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['c']['index'];?>
" id="cmd_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['c']['index'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['cmdinfo']->value['cmd'];?>
">
	  </td>
	  <td width="67%"><input type="checkbox"  name="regex_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['c']['index'];?>
" onclick="changeRegex(this.checked,<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['c']['index'];?>
)" value="on">正则&nbsp;&nbsp;<?php if ($_smarty_tpl->tpl_vars['ginfo']->value['black_or_white'] == 0) {?>				
			<select  class="wbk"  name="level_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['c']['index'];?>
" >
			<option value="1" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['level'] == '1') {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['language']->value['Disconnect'];?>
</option>
			<option value="0" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['level'] == '0') {?>selected<?php }?>>命令阻断</option>
			<option value="2" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['level'] == '2') {?>selected<?php }?>>命令监控</option>
			<option value="3" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['level'] == '3') {?>selected<?php }?>>命令授权</option>
			</select>
			<?php }?>
			<select  class="wbk"  name="toauthorize_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['c']['index'];?>
" >
			<option value="0" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['toauthorize'] == '0') {?>selected<?php }?>>不授权</option>
			<option value="1" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['toauthorize'] == '1') {?>selected<?php }?>>Admin授权</option>
			<option value="2" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['toauthorize'] == '2') {?>selected<?php }?>>分组管理员授权</option>
			<option value="3" <?php if ($_smarty_tpl->tpl_vars['cmdinfo']->value['toauthorize'] == '3') {?>selected<?php }?>>双人授权</option>
			</select>
	  </td>
	</tr>	
<?php endfor; endif; ?>
<?php }?>
	<tr>
		<td align="right"><input type="submit"  value=" 确定 " class="an_02"></td>
		<td></td>
	</tr>
	</table>
<br>
<input type="hidden" name="add" value="new" />
<input type="hidden" name="gid" value="<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
" />
</form>
	</td>
  </tr>
</table>

<?php echo '<script'; ?>
 language="javascript">
function changeRegex(check,i){
    var cmdid = document.getElementById('cmd_'+i);
	var str = cmdid.value;
	if(check){
		while( str.indexOf( " " ) != -1 ) {
			 str=str.replace(" ","\\S*\\s+"); 
		}
		str+="\\S*";
	}else{
		while( str.indexOf( "\\S*\\s+" ) != -1 ) {
			 str=str.replace("\\S*\\s+"," "); 
		}
		if(str.substring(str.length-3)=="\\S*"){
			str = str.substring(0,str.length-3);
		}
	}
	cmdid.value = str;
}
function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

function changeport() {
	if(document.getElementById("ssh").selected==true)  {
		f1.port.value = 22;
	}
	if(document.getElementById("telnet").selected==true)  {
		f1.port.value = 23;
	}
}

document.getElementById("telnet").selected = true;


<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>