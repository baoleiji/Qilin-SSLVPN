<?php /* Smarty version 3.1.27, created on 2016-12-31 19:43:18
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/autochange_pwd.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1508250164586799d64ff2c9_86590738%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '943b6f057bc3b366aecf99c545f491c7e718d41a' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/autochange_pwd.tpl',
      1 => 1474793222,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1508250164586799d64ff2c9_86590738',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'defaultp' => 0,
    'trnumber' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_586799d65881e6_19300631',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_586799d65881e6_19300631')) {
function content_586799d65881e6_19300631 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1508250164586799d64ff2c9_86590738';
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
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=autochange_pwd">自动改密</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
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
</ul>
</div></td></tr>
	

  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="5"  class="BBtable">
          <form name="f1" method=post action="admin.php?controller=admin_config&action=autochange_pwd&id=<?php echo $_smarty_tpl->tpl_vars['defaultp']->value['id'];?>
">
	<tr><th colspan="3" class="list_bg"></th></tr>
<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
					
		<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                  <TD width="33%" align=right>最小长度 </TD>
                  <TD><input type="text" class="wbk" name="minlen" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['defaultp']->value['minlen'];?>
">
				  </TD>
                </TR>
				 <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
                <TR>
                  <TD width="33%" align=right>最少字母数 </TD>
                  <TD><input type="text" class="wbk" name="minalpha" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['defaultp']->value['minalpha'];?>
">                
				  </TD>
                </TR>
               <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                  <TD width="33%" align=right>最少其它字符数 </TD>
                  <TD><input type="text" class="wbk" name="minother" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['defaultp']->value['minother'];?>
">                
				  </TD>
                </TR>
                <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
						<td align=right>与旧口令最少不同字符</td>
						<td><input type="text" class="wbk" name="mindiff" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['defaultp']->value['mindiff'];?>
"></td>
					</tr>
					<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
                  <TD  align=right>密码最大重复字符数 </TD>
                  <TD><input type="text" class="wbk" name="maxrepeats" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['defaultp']->value['maxrepeats'];?>
">               
				  </TD>
                </TR>
               <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<TD width="33%" align=right>记录旧密码时间 </TD>
                  <TD width="67%"><input type="text" class="wbk" name="histexpire" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['defaultp']->value['histexpire'];?>
">单位：天</TD>
                </TR>    
				<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<TD width="33%" align=right>记录旧密码次数 </TD>
                  <TD width="67%"><input type="text" class="wbk" name="histsize" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['defaultp']->value['histsize'];?>
">                  </TD>
                </TR>    
                </div></td></tr>
				  <TR >
<tr>
<td align="center" colspan=2>
<input type="hidden" name="ac" value="<?php if ($_smarty_tpl->tpl_vars['defaultp']->value) {?>edit<?php } else { ?>new<?php }?>" />
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