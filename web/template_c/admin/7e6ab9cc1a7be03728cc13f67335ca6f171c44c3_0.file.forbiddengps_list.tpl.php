<?php /* Smarty version 3.1.27, created on 2016-12-31 18:23:24
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/forbiddengps_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4208771355867871c24c223_38388266%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e6ab9cc1a7be03728cc13f67335ca6f171c44c3' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/forbiddengps_list.tpl',
      1 => 1483179801,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4208771355867871c24c223_38388266',
  'variables' => 
  array (
    'template_root' => 0,
    'orderby2' => 0,
    'allcommand' => 0,
    'command_num' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5867871c3a5815_11243842',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5867871c3a5815_11243842')) {
function content_5867871c3a5815_11243842 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '4208771355867871c24c223_38388266';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>黑名单分组列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
<?php if ($_SESSION['ADMIN_LEVEL'] != 3 && $_SESSION['ADMIN_LEVEL'] != 21 && $_SESSION['ADMIN_LEVEL'] != 101) {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php if ($_SESSION['ADMIN_LEVEL'] != 3 && $_SESSION['ADMIN_LEVEL'] != 21 && $_SESSION['ADMIN_LEVEL'] != 101) {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=autochange_pwd">自动改密</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=cmdgroup_list">命令组</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
	<?php if ($_SESSION['ADMIN_LEVEL'] != 3 && $_SESSION['ADMIN_LEVEL'] != 21 && $_SESSION['ADMIN_LEVEL'] != 101) {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ipacl">授权策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
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
	
		<table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
			<form name="ip_list" action="admin.php?controller=admin_forbidden&action=delete_all_gid" method="post">
			<tr>
				<th class="list_bg"  width="3%">选择</th>
				<th class="list_bg"  width="15%"><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list&orderby1=gname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >组名</a></th>
				<th class="list_bg"  width="7%"><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list&orderby1=black_or_white&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >类型</a></th>
				<th class="list_bg"  width="20%"><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list&orderby1=desc&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >描述</a></th>
				<th class="list_bg"  width="20%">操作</th>
			</tr>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allcommand']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total']);
?>
			<tr <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
				<td><input type="checkbox" name="chk_gid[]" value="<?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['gid'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['gname'];?>
</td>
				<td><?php if ($_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['black_or_white'] == 1) {?>命令白名单<?php } elseif ($_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['black_or_white'] == 3) {?>授权命令<?php } else { ?>命令黑名单<?php }?></td>
				<td><?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['gname'];?>
</td>
				<td style="TEXT-ALIGN: left;">
				<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_edit&id=<?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['gid'];?>
">编辑</a>
				| <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&gid=<?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['gid'];?>
">命令编辑</a>
				| <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ico8.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_user&gid=<?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['gid'];?>
">用户</a>
				| <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/left_dot1.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_group&gid=<?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['gid'];?>
">运维组</a>
				| <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_forbidden&action=del_forbiddengps&gid=<?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['gid'];?>
">删除</a>
				</td>
			</tr>
			<?php endfor; endif; ?>
			<tr>
				<td colspan="3" align="left">
					<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_gid[]')e.checked=this.form.select_all.checked;}" value="checkbox">全选&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除所选IP');if(chk_form()) document.ip_list.action='admin.php?controller=admin_config&action=delete_all_ip'; else return false;" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input onclick="window.location='admin.php?controller=admin_forbidden&action=forbiddengps_edit'" type="button"  value="增加" class="an_02" />
									</td>	
									
		
			
				<td colspan="2" align="right">
				
					共<?php echo $_smarty_tpl->tpl_vars['command_num']->value;?>
执行命令  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
条日志/页  页 
						</td>
			</tr>
			</form>
			
			
			
		</table>
		
	</td>
  </tr>
</table>


</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>