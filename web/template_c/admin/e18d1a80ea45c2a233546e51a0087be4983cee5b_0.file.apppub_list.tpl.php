<?php /* Smarty version 3.1.27, created on 2016-12-12 17:37:21
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/apppub_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:696487962584e6fd1175e47_86345317%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e18d1a80ea45c2a233546e51a0087be4983cee5b' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/apppub_list.tpl',
      1 => 1474793221,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '696487962584e6fd1175e47_86345317',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'appserverip' => 0,
    'from' => 0,
    'orderby2' => 0,
    'apppub' => 0,
    'command_num' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_584e6fd1242047_92898473',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_584e6fd1242047_92898473')) {
function content_584e6fd1242047_92898473 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '696487962584e6fd1175e47_86345317';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['language']->value['SessionsList'];?>
</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
</head>
<?php echo '<script'; ?>
>
function chk_form(){
return true;
}
function searchit(){
	document.f1.action = "admin.php?controller=admin_config&action=apppub_list&ip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
";
	document.f1.action += "&device_ip="+document.f1.device_ip.value;
	document.f1.action += "&hostname="+encodeURIComponent(document.f1.hostname.value);
	document.f1.action += "&program="+encodeURIComponent(document.f1.program.value);
	return true;
}
<?php echo '</script'; ?>
>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <?php if ($_GET['device_ip'] == '') {?>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appserver_list">应用发布</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php if ($_SESSION['ADMIN_LEVEL'] != 3) {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appprogram_list">应用程序</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appicon_list">应用图标</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
	<?php } else { ?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php if ($_smarty_tpl->tpl_vars['from']->value == 'dir') {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php } else { ?>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['from']->value == 'dir') {?>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php } else { ?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php if ($_SESSION['ADMIN_LEVEL'] == 1) {?>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
	<?php }?>
</ul><span class="back_img"><A href="admin.php?controller=<?php if ($_GET['device_ip'] != '') {?>admin_pro&action=dev_index<?php } else { ?>admin_config&action=appserver_list<?php if ($_GET['device_ip'] == '') {?>&ip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;
}?>&device_ip=<?php echo $_GET['device_ip'];
}?>&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
<TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_config&action=apppub_list&ip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
' method=post>
					IP<input type="text" class="wbk" name="device_ip">
					&nbsp;&nbsp;主机名<input type="text" class="wbk" name="hostname">
					&nbsp;&nbsp;程序名称<input type="text" class="wbk" name="program">
					&nbsp;&nbsp;<input  type="submit" value=" 搜索 " onclick="return searchit();" class="bnnew2">

					</form>
					</TD>
                  </TR>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
			<tr>
				<th class="list_bg"  width="3%">#</th>
				<th class="list_bg"  width="15%"><a href="admin.php?controller=admin_config&action=apppub_list&ip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
&orderby1=name&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >应用名称</a></th>
				<th class="list_bg"  width="8%"><a href="admin.php?controller=admin_config&action=apppub_list&ip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
&orderby1=username&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >用户名</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_config&action=apppub_list&ip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >服务器</a></th>
				<th class="list_bg"  width="20%"><a href="admin.php?controller=admin_config&action=apppub_list&ip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
&orderby1=path&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >程序路径</a></th>
				<th class="list_bg"  width="20%"><a href="admin.php?controller=admin_config&action=apppub_list&ip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
&orderby1=description&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >描述</a></th>
				<th class="list_bg"  width="30%"><?php echo $_smarty_tpl->tpl_vars['language']->value['Operate'];?>
</th>
			</tr>
			<form action='#' method='post' name='member_list' >
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['apppub']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
				<td><input type="checkbox" name="chk_member[]" value="<?php echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['name'];?>
</td>
				<td><?php if ($_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username']) {
echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];
} else { ?>空用户<?php }?></td>
				<td><?php echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
</td>
				<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['path'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['description'];?>
</td>
				<td>
				
			<img src='./template/admin/images/left_dot1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_config&action=apppub_edit&id=<?php echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&appserverip=<?php echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appserverip'];?>
&device_ip=<?php echo $_GET['device_ip'];?>
'><?php echo $_smarty_tpl->tpl_vars['language']->value['Edit'];?>
</a>	
				&nbsp;|<img src='./template/admin/images/left_dot1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><?php if ($_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['autologinflag'] == 3) {?><a href='admin.php?controller=admin_app&action=applogin&id=<?php echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appdevicesid'];?>
&appserverip=<?php echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appserverip'];?>
&device_ip=<?php echo $_GET['device_ip'];?>
'>单点登录</a><?php } else { ?>单点登录<?php }?>	
				&nbsp;|&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif" width="16" height="16" align="absmiddle"><a onclick="if(confirm('确定<?php echo $_smarty_tpl->tpl_vars['language']->value['Delete'];?>
吗?')) return true;else return false;" href="admin.php?controller=admin_config&action=apppub_delete&id=<?php echo $_smarty_tpl->tpl_vars['apppub']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&device_ip=<?php echo $_GET['device_ip'];?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['Delete'];?>
</a></td>
			</tr>
			<?php endfor; endif; ?>
			<tr>
				<td colspan="5" align="left">
					<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox"><?php echo $_smarty_tpl->tpl_vars['language']->value['select'];
echo $_smarty_tpl->tpl_vars['language']->value['this'];
echo $_smarty_tpl->tpl_vars['language']->value['page'];
echo $_smarty_tpl->tpl_vars['language']->value['displayed'];?>
的<?php echo $_smarty_tpl->tpl_vars['language']->value['All'];
echo $_smarty_tpl->tpl_vars['language']->value['User'];?>
&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="if(confirm('确定要删除?')) document.member_list.action='admin.php?controller=admin_config&action=apppub_delete&appserverip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
&device_ip=<?php echo $_GET['device_ip'];?>
';else return false;" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="location.href='admin.php?controller=admin_config&action=apppub_edit&appserverip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
&device_ip=<?php echo $_GET['device_ip'];?>
'"  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Add'];?>
" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  value="导入" onClick="javascript: document.location='admin.php?controller=admin_config&action=apppubimport&appserverip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
&device_ip=<?php echo $_GET['device_ip'];?>
';" class="an_02">
					&nbsp;&nbsp;<input type="button"  value="导出" onClick="javascript:document.getElementById('hide').src='admin.php?controller=admin_config&action=apppubexport&appserverip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
';" class="an_02">
				</td>
				<td colspan="5" align="right">
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
<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_config&action=apppub_list&page='+this.value;"><?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>

				</td>
			</tr>
			</form>
		</table>
	</td>
  </tr>
</table>


</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>