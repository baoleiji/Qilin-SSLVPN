<?php /* Smarty version 3.1.27, created on 2016-12-31 19:43:45
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/autobackup_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:384324993586799f1e4b0b5_97166493%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '968449c220e8f0904b282a137a994c7174e2e906' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/autobackup_list.tpl',
      1 => 1474793221,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '384324993586799f1e4b0b5_97166493',
  'variables' => 
  array (
    'template_root' => 0,
    'from' => 0,
    'ip' => 0,
    'orderby2' => 0,
    'word' => 0,
    'alldev' => 0,
    'type' => 0,
    'language' => 0,
    'command_num' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
    'alldevgroup' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_586799f1f2b883_31947905',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_586799f1f2b883_31947905')) {
function content_586799f1f2b883_31947905 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '384324993586799f1e4b0b5_97166493';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if ($_smarty_tpl->tpl_vars['from']->value != 'status') {?>
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<?php if ($_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php if ($_SESSION['ADMIN_LEVEL'] == 10) {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php }?>
<?php } else { ?>
	<?php if ($_GET['type'] == 'run') {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=run">巡检帐号</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php } else { ?>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	
	<?php }?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autotemplate">巡检管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=detail_config">巡检检测</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autorun_result">检测结果</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php }?>
</ul>
</div></td></tr>
<?php }?>
  <tr><td><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_autorun&action=autobackup_delete&type=<?php echo $_GET['type'];?>
"><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
		
			<tr>
			<?php if ($_smarty_tpl->tpl_vars['from']->value != 'status') {?>
				<th class="list_bg"  width="3%">选</th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=name&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >名称</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >说明</a></th>
				<th class="list_bg"  width="5%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=upload&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >间隔</a></th>
				<th class="list_bg"  width="">操作</th>
			<?php } else { ?>
				<td class="list_bg1"  width="3%">选</td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=name&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >名称</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >服务器IP</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=hostname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >服务器名称</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=username&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['word']->value;?>
账号</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=desc&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['word']->value;?>
内容</a></td>
				<td class="list_bg1"  width="5%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=su&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >SUDO</a></td>
				<td class="list_bg1"  width="5%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=period&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >周期</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=lastruntime&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >上次<?php echo $_smarty_tpl->tpl_vars['word']->value;?>
时间</a></td>
				<td class="list_bg1"  width="5%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=<?php echo $_GET['type'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&orderby1=upload&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >状态</a></td>
				<td class="list_bg1"  width="">操作</td>
			<?php }?>
			</tr>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alldev']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
			<td><input type="checkbox" name="chk_member[]" value="<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
"></td>
				<td width="20%"><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['name'];?>
</td>
				<td width="20%"><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['desc'];?>
</td>
				<td width="20%"><?php if ($_GET['type'] == 'run') {
echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['period'];
} else {
echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['interval'];
}?></td>
				<td style="TEXT-ALIGN: left;"><img src='./template/admin/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_autorun&action=autobackup_save_backup&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&devicesid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['deviceid'];?>
&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&from=<?php echo $_smarty_tpl->tpl_vars['from']->value;?>
'>修改</a>
				</td>
			</tr>
			<?php endfor; endif; ?>
			
			<tr>
				<td  colspan="3" align="left">	<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value=" 删除 " onclick="my_confirm('<?php echo $_smarty_tpl->tpl_vars['language']->value['DeleteUsers'];?>
');if(chk_form()) document.f1.action='admin.php?controller=admin_autorun&action=autobackup_delete&from=<?php echo $_smarty_tpl->tpl_vars['from']->value;?>
'; else return false;" class="an_02">
				&nbsp;&nbsp;
				<input type="button" onclick="javascript:window.location='admin.php?controller=admin_autorun&action=autobackup_save_backup&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&from=<?php echo $_smarty_tpl->tpl_vars['from']->value;?>
'"  value=" 增加 "  class="an_02">
				
				</td>
			
				<td colspan="10" align="right">
					共<?php echo $_smarty_tpl->tpl_vars['command_num']->value;?>
执行命令  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_session&action=dangerlist&page='+this.value;">页
				</td>
			</tr>
			</table>
			</form>
			<table  width="100%" >
			<tr><td  colspan="10" width="100%" align="center">
	<table id="f1table"  style="display:none"  border=0 width=100% cellpadding=1 cellspacing=1 bgcolor="#FFFFFF" class="BBtable" valign=top>

	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_autorun&action=autobackup_edit&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['InputthedeviceIP'];?>

		</td>
		<td width="67%">
			<input name="ip" type="text" class="wbk"><input type=submit class=btn1 value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Input'];?>
">
	  </td>
	</tr>

	<tr>
		<td width="33%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['select'];
echo $_smarty_tpl->tpl_vars['language']->value['DeviceGroup'];?>

		</td>
		<td width="67%">&nbsp;</td>
		
</tr>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['g'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['g']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['name'] = 'g';
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alldevgroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total']);
?>
		<tr <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['g']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td align=right>
			<input type="radio" name="controller" value="<?php echo $_smarty_tpl->tpl_vars['alldevgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
" onClick="location.href='admin.php?controller=admin_autorun&action=autobackup_dev&g_id=<?php echo $_smarty_tpl->tpl_vars['alldevgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
'">
		</td>
		<td>
			<?php echo $_smarty_tpl->tpl_vars['alldevgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['groupname'];?>

		</td>
		</tr>
		<?php endfor; endif; ?>
		</table>
	  </td>
	</tr>
	
<br>

</form>
</table>
<?php echo '<script'; ?>
 type="text/javascript">
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('ldaptree').style.display='none';
<?php echo '</script'; ?>
>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>