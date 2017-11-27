<?php /* Smarty version 3.1.27, created on 2016-12-31 18:28:47
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/forbiddengps_cmd.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1576564315867885f31af60_47684750%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f9a6d33d1f59dc1ea2f828e16e14a8f1fee673f9' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/forbiddengps_cmd.tpl',
      1 => 1483180101,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1576564315867885f31af60_47684750',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'gid' => 0,
    'orderby2' => 0,
    'ginfo' => 0,
    'allcommand' => 0,
    'command_num' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5867885f50ae72_57817772',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5867885f50ae72_57817772')) {
function content_5867885f50ae72_57817772 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1576564315867885f31af60_47684750';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['language']->value['Black'];
echo $_smarty_tpl->tpl_vars['language']->value['group'];
echo $_smarty_tpl->tpl_vars['language']->value['List'];?>
</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
<?php echo '<script'; ?>
>
	function searchit(){
		document.search.action = "admin.php?controller=admin_forbidden&action=forbiddengps_cmd&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
";
		document.search.action += "&cmd="+document.search.cmd.value;
		document.search.submit();
		return true;
	}
	
<?php echo '</script'; ?>
>
<body>



	<table width="100%" border="0" cellspacing="0" cellpadding="0">

 <tr><td valign="middle" class="hui_bj"><div class="menu">
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
</ul><span class="back_img"><A href="admin.php?controller=admin_forbidden&action=forbidden_groups_list&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
<form name ='search' action='admin.php?controller=admin_member' method=post onsubmit="return searchit();">
  <tr>
    <td >	
					命令：<input type="text" name="cmd" size="13" class="wbk"/>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>

					</td>
  </tr>
</form>	
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_forbidden&action=del_forbiddengps_cmd&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
" method="post">
			<tr>
				<th class="list_bg"  width="3%">选择</th>
				<th class="list_bg"  width="35%"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&orderby1=cmd&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['language']->value['Command'];?>
</a></th>
				<?php if (!$_smarty_tpl->tpl_vars['ginfo']->value['black_or_white']) {?>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&orderby1=level&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >级别</a></th>
				<?php }?>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&orderby1=toauthorize&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >授权</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&orderby1=gid&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['language']->value['groupname'];?>
</a></th>
				<th class="list_bg"><?php echo $_smarty_tpl->tpl_vars['language']->value['Operate'];?>
</th>
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
				<td><input type="checkbox" name="chk_gid[]" value="<?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cid'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cmd'];?>
</td>
				<?php if (!$_smarty_tpl->tpl_vars['ginfo']->value['black_or_white']) {?>
				<td><?php if ($_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 1) {?>断开连接<?php } elseif ($_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 2) {?>命令监控<?php } elseif ($_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 3) {?>命令授权<?php } else { ?>命令阻断<?php }?></td>
				<?php }?>
				<td><?php if ($_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['toauthorize'] == 1) {?>Admin授权<?php } elseif ($_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['toauthorize'] == 2) {?>分组管理员授权<?php } elseif ($_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['toauthorize'] == 3) {?>双人授权<?php } else { ?>不授权<?php }?></td>
				<td><?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['gid'];?>
</td>
				<td>
				<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd_edit&cid=<?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cid'];?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">编辑</a>
				| <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_forbidden&action=del_forbiddengps_cmd&cid=<?php echo $_smarty_tpl->tpl_vars['allcommand']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cid'];?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['Delete'];?>
</a>				
				</td>
			</tr>
			<?php endfor; endif; ?>
			
			
			<tr>
			<td align="left" colspan="3"><input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_gid[]')e.checked=this.form.select_all.checked;}" value="checkbox">全选&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除所选IP');if(chk_form()) document.ip_list.action='admin.php?controller=admin_config&action=delete_all_ip'; else return false;" class="an_02">&nbsp;&nbsp;
			<input type="button"  onclick="window.location='admin.php?controller=admin_forbidden&action=forbiddengps_cmd_edit&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'" name="submit"  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Add'];?>
" class="an_02">&nbsp;&nbsp;<input type="button"  onclick="window.open ('admin.php?controller=admin_forbidden&action=from_cmdgroup&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" name="submit"  value="从模版添加" class="an_06">
			&nbsp;&nbsp;<input type="button"  value="导出" onClick="location.href='admin.php?controller=admin_forbidden&action=forbiddengps_cmd_export&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'" class="an_02">&nbsp;&nbsp;<input type="button"  value="导入" onClick="location.href='admin.php?controller=admin_forbidden&action=forbiddengps_cmd_import&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'" class="an_02">
			<input type="hidden" name="add" value="new" >
			</td>
				<td colspan="<?php if (!$_smarty_tpl->tpl_vars['ginfo']->value['black_or_white']) {?>4<?php } else { ?>3<?php }?>" align="right">
					<?php echo $_smarty_tpl->tpl_vars['language']->value['all'];
echo $_smarty_tpl->tpl_vars['command_num']->value;
echo $_smarty_tpl->tpl_vars['language']->value['Command'];?>
  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Page'];?>
：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;
echo $_smarty_tpl->tpl_vars['language']->value['item'];
echo $_smarty_tpl->tpl_vars['language']->value['Log'];?>
/<?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Goto'];?>
<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_forbidden&action=dangerlist&page='+this.value;"><?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>

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