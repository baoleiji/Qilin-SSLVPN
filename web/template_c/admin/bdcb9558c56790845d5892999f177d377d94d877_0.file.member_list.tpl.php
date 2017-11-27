<?php /* Smarty version 3.1.27, created on 2016-12-04 00:05:47
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/member_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:10036687745842ed5b13f6d4_07727634%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bdcb9558c56790845d5892999f177d377d94d877' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/member_list.tpl',
      1 => 1474793220,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10036687745842ed5b13f6d4_07727634',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'from' => 0,
    'orderby2' => 0,
    'allmember' => 0,
    'curr_url' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5842ed5b45a602_54215017',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5842ed5b45a602_54215017')) {
function content_5842ed5b45a602_54215017 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '10036687745842ed5b13f6d4_07727634';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['language']->value['Master'];
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有<?php echo $_smarty_tpl->tpl_vars['language']->value['select'];?>
任何<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];?>
！");
		return false;
	}

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
	function searchit(){
		document.search.action = "admin.php?controller=admin_member<?php if ($_SESSION['RADIUSUSERLIST']) {?>&action=radiususer<?php }?>";
		document.search.action += "&username="+document.search.username.value;
		document.search.submit();
		return true;
	}

	function uncheckAll(c){
		document.getElementById('select_all').checked = true;
		for(var i=0;i<document.member_list.elements.length;i++){
			var e=document.member_list.elements[i];
			if(e.name=='chk_member[]'&&!e.checked){
				document.getElementById('select_all').checked = false;
				break;
			}
		}
	}
	
function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}

function batchloginlock(){
	document.member_list.action = "admin.php?controller=admin_member&action=loginlock";
	document.member_list.submit();
	return true;
}

function adconfig(){
	window.location = "admin.php?controller=admin_member&action=adconfig";
}
<?php echo '</script'; ?>
>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<?php if ($_smarty_tpl->tpl_vars['from']->value == 'dir') {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php } else { ?>
    <li class="me_<?php if ($_SESSION['RADIUSUSERLIST']) {?>b<?php } else { ?>a<?php }?>"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_SESSION['RADIUSUSERLIST']) {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_SESSION['RADIUSUSERLIST']) {?>3<?php }?>.jpg" align="absmiddle"/></li>
	<?php }?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
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
	<li class="me_<?php if ($_SESSION['RADIUSUSERLIST']) {?>a<?php } else { ?>b<?php }?>"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if (!$_SESSION['RADIUSUSERLIST']) {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if (!$_SESSION['RADIUSUSERLIST']) {?>3<?php }?>.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php if ($_SESSION['ADMIN_LEVEL'] == 1) {?>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
</ul><?php if ($_smarty_tpl->tpl_vars['from']->value == 'dir') {?><span class="back_img"><A href="admin.php?controller=admin_pro&action=dev_group&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="25" border="0"></A></span><?php }?>
</div></td></tr>
<body>
	
 <TR>
<TD >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
<form name ='search' action='admin.php?controller=admin_member' method=post onsubmit="return searchit();">
  <tr>
    <td >
</td>
    <td >	
					用户名：<input type="text" name="username" size="13" class="wbk"/>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>&nbsp;&nbsp;显示空目录<input type="checkbox" id="showemptydir" name="showemptydir" onclick="window.parent.menu.window.showNodeCount0(this.checked)"  />&nbsp;&nbsp;&nbsp;&nbsp;目录截取<input type="checkbox" name="showemptydir" onclick="window.parent.menu.window.showLongTitle(this.checked)" checked />

					</td>
  </tr>
</form>	
</table>
</TD>
                  </TR>
	  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	<form name="member_list" action="admin.php?controller=admin_member&action=delete_all" method="post">
					<tr>
						<th class="list_bg"  width="3%" ><?php echo $_smarty_tpl->tpl_vars['language']->value['select'];?>
</th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&orderby1=username&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' ><?php echo $_smarty_tpl->tpl_vars['language']->value['Username'];?>
</a></th>
						<th class="list_bg"  width="8%" ><a href='admin.php?controller=admin_member&orderby1=realname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >用户姓名</a></th>
						<th class="list_bg"  width="12%" ><a href='admin.php?controller=admin_member&orderby1=groupname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >运维组</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&orderby1=workcompany&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >工作单位</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_member&orderby1=usbkey&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >令牌状态</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_member&orderby1=start_time&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >生效时间</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_member&orderby1=end_time&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' ><?php echo $_smarty_tpl->tpl_vars['language']->value['EndTime'];?>
</a></th>
						<?php if (!$_SESSION['RADIUSUSERLIST']) {?>
						<th class="list_bg"  width="6%" ><a href='admin.php?controller=admin_member&orderby1=level&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >角色</a></th>
						<?php }?>
						<th class="list_bg"  width="24%" ><?php echo $_smarty_tpl->tpl_vars['language']->value['Operate'];
echo $_smarty_tpl->tpl_vars['language']->value['Link'];?>
</th>
					</tr>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmember']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
					<tr <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?> onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>');">
						<td><?php if (($_SESSION['ADMIN_LEVEL'] == 4 && (!$_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] || $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 3)) || ($_SESSION['ADMIN_LEVEL'] == 1) || ($_SESSION['ADMIN_LEVEL'] == 3)) {
if (($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] != 1 && $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] != 10 && $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] != 2 && $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] != 3 && $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] != 101 && $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] != 21) || ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 1 && $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'] != 'admin')) {
if (!($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'] == 'admin' && $_SESSION['ADMIN_USERNAME'] != 'admin')) {?><input type="checkbox" name="chk_member[]" value="<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['uid'];?>
" onclick="uncheckAll(this.checked);"><?php }
}
}?></td>
						<td><?php if ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['onlinenumber'] > 0) {?><a href='admin.php?controller=admin_member&action=online&username=<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];?>
' ><img  border="0" src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/user_online.gif' title='在线' /></a><?php } else { ?><img border="0" src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/user_offline.gif'  title='离线' /><?php }
echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];?>
</td>
						<td><?php if ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname']) {
echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname'];
} else { ?>未设置<?php }?></td>
						<td><?php if ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['groupname'] == 'null') {?>无<?php } else {
echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['groupname'];
}?></td>
						<td><?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['workcompany'];?>
</td>
						<td><?php if ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['usbkey'] != '') {
echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['usbkey'];
} elseif ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['usbkey_temp'] != '' && $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['usbkeystatus'] == 11) {?>未初始化<?php } elseif ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['usbkey_temp'] == '') {?>未绑定<?php }?></td>
						<td><?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['start_time'];?>
</td>
						<td><?php if ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['end_time'] == '2037-01-01 00:00:00') {
echo $_smarty_tpl->tpl_vars['language']->value['AlwaysValid'];
} else {
echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['end_time'];
}?></td>
						<?php if (!$_SESSION['RADIUSUSERLIST']) {?>
						<td><a href='admin.php?controller=admin_member&level=<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'];?>
' ><?php if ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 0) {?>运维<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];
} elseif ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 1) {
echo $_smarty_tpl->tpl_vars['language']->value['Administrator'];
} elseif ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 3) {?>部门<?php echo $_smarty_tpl->tpl_vars['language']->value['Administrator'];
} elseif ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 4) {?>配置<?php echo $_smarty_tpl->tpl_vars['language']->value['Administrator'];
} elseif ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 10) {
echo $_smarty_tpl->tpl_vars['language']->value['Password'];
echo $_smarty_tpl->tpl_vars['language']->value['Administrator'];
} elseif ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 21) {?>部门审计员<?php } elseif ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 101) {?>部门密码员<?php } else {
echo $_smarty_tpl->tpl_vars['language']->value['auditadministrator'];
}?></a></td>
						<?php }?>
						<td>
						
						<!--<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_dev&action=index&uid=<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['uid'];?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['Edit'];
echo $_smarty_tpl->tpl_vars['language']->value['device'];?>
</a> |-->
						<?php if (($_SESSION['ADMIN_LEVEL'] == 4 && (!$_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] || $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] == 3)) || ($_SESSION['ADMIN_LEVEL'] == 1) || ($_SESSION['ADMIN_LEVEL'] == 3)) {
if (!($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'] == 'admin' && $_SESSION['ADMIN_USERNAME'] != 'admin')) {?>
						<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/<?php if (!$_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable'] || $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['loginlock']) {?>lock.png<?php } else { ?>lock_open.png<?php }?>" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=loginlock&uid=<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['uid'];?>
&enable=<?php if (!(!$_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable'] || $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['loginlock'])) {?>1<?php } else { ?>0<?php }?>"><?php if (!$_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable'] || $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['loginlock']) {?>启用<?php } else { ?>禁用<?php }?></a> |
						<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=edit&uid=<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['uid'];?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['Edit'];?>
</a>  
						|&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/file.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=memberdesc&uid=<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['uid'];?>
">明细</a>
						<?php if ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['downpfx']) {?> | 
						<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/pfx.jpg" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=downloadca&uid=<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['uid'];?>
">证书</a>  
						<?php }?>
						<?php }?>
						<?php if ($_SESSION['RADIUSUSERLIST']) {?><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ico9.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_pro&action=viewradiusbind&uid=<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['uid'];?>
">查看</a>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] != 10 && $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] != 2 && $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['level'] != 1) {?>|&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=delete&uid=<?php echo $_smarty_tpl->tpl_vars['allmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['uid'];?>
" onclick="return confirm('确定删除？')"><?php echo $_smarty_tpl->tpl_vars['language']->value['Delete'];?>
</a><?php }?> 			
						<?php }?>
						</td>
					</tr>
					<?php endfor; endif; ?>
					
					<tr>
						<td colspan="5" align="left">
							<input name="select_all" id="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.member_list.elements[i];if(e.name=='chk_member[]')e.checked=document.member_list.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="button"  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Add'];
echo $_smarty_tpl->tpl_vars['language']->value['User'];?>
" onClick="javascript:document.location='admin.php?controller=admin_member&action=add&gid=<?php echo $_GET['gid'];?>
&ldapid=<?php echo $_GET['ldapid'];?>
';" class="an_02">&nbsp;&nbsp;<input type="submit"  value="删除用户" onClick="my_confirm('<?php echo $_smarty_tpl->tpl_vars['language']->value['DeleteUsers'];?>
');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&action=delete_all'; else return false;" class="an_02">&nbsp;&nbsp;<input type="submit"  value="编辑选中" onClick="javascript:document.member_list.action='admin.php?controller=admin_member&action=batchedit'" class="an_02">&nbsp;&nbsp;<input type="button"  value="批量添加" onClick="javascript:document.location='admin.php?controller=admin_member&action=batchadd&gid=<?php echo $_GET['gid'];?>
&ldapid=<?php echo $_GET['ldapid'];?>
';" class="an_02">&nbsp;&nbsp;<input type="submit"  value="批量编辑" onClick="javascript:document.member_list.action='admin.php?controller=admin_member&action=batchpriorityedit'" class="an_02">
							&nbsp;&nbsp;<input type="button"  value="锁定" onClick="batchloginlock();" class="an_02">&nbsp;&nbsp;<input type="button"  value="AD编辑" onClick="adconfig();" class="an_02">
						</form><form name="pageto" action="#" method="post">
						<td colspan="6" align="right">
						<?php if (!$_SESSION['RADIUSUSERLIST']) {?>
						<input type="button"  value="导入" onClick="javascript: document.location='admin.php?controller=admin_member&action=memberimport';" class="an_02">
							&nbsp;&nbsp;<input type="button"  value="导出" onClick="javascript:document.location='<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&derive=1';" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php }?>
							<?php echo $_smarty_tpl->tpl_vars['language']->value['all'];
echo $_smarty_tpl->tpl_vars['total']->value;?>
个<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];?>
  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Page'];?>
：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
个/<?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Goto'];?>
<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='admin.php?controller=admin_member&page='+this.value;return false;}else this.value=this.value;"><?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>

							
						</td></form>
					</tr>
					
				
		  
					<tr>
						
					</tr>
				</table>
			
	  </table>
		</td>
	  </tr>
	</table>
	<iframe name="hide" height="0" frameborder="0" scrolling="no" id="hide"></iframe>
<?php echo '<script'; ?>
 language="javascript">
window.parent.menu.window.showNodeCount0(false);
window.parent.menu.window.showLongTitle(true);
window.parent.menu.document.getElementById('_tree').style.display='';
window.parent.menu.document.getElementById('mtree').style.display='';
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.cururl='mtree';
<?php echo '</script'; ?>
>
</body>
</html>


<?php }
}
?>