<?php /* Smarty version 3.1.27, created on 2016-12-04 20:09:03
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/resourcegroup_bind.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:18782881765844075f4eb2c2_11471783%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d064190f56632a343630c6a7c916439f2cf98d2' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/resourcegroup_bind.tpl',
      1 => 1474793220,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18782881765844075f4eb2c2_11471783',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'id' => 0,
    '_config' => 0,
    'allmem' => 0,
    'fromdevpriority' => 0,
    'webuser' => 0,
    'webgroup' => 0,
    'ginfo' => 0,
    'language' => 0,
    'usergroup' => 0,
    'sessionlgroup' => 0,
    'sessionluser' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5844075f5bc3f0_49686652',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5844075f5bc3f0_49686652')) {
function content_5844075f5bc3f0_49686652 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '18782881765844075f4eb2c2_11471783';
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
 src="./template/admin/cssjs/global.functions.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/_ajaxdtree.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/dtree.css" rel="stylesheet" type="text/css" />
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
	var url = "admin.php?controller=admin_pro&action=resourcegroup_bind&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
";
	url += "&webuser="+document.f1.elements.webuser.value;
	url += "&webgroup="+document.f1.elements.webgroup.value;
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['TREEMODE']) {?>
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	<?php } else { ?>
	for(var i=1; true; i++){
		var obj=document.getElementById('groupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	<?php }?>
	url += "&groupid="+gid;
	<?php }?>
	window.location=url;
	return false;
}

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var allserver = new Array();
var i=0;

var AllMember = new Array();
i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['name'] = 'kk';
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total']);
?>
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
] = new Array();
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['username']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['username'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['realname']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['realname'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['uid']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['uid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['groupid']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['groupid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['check']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['check'];?>
';
<?php endfor; endif; ?>
<?php echo '</script'; ?>
>
</head>
 <SCRIPT language=javascript src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/selectdate.js"></SCRIPT>

<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=resource_group">系统用户组</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_app&action=app_group">应用用户组</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_priority_search">系统权限</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=app_priority_search">应用权限</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=<?php if ($_smarty_tpl->tpl_vars['fromdevpriority']->value) {?>dev_priority_search<?php } else { ?>resource_group<?php }?>&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_pro&action=resourcegroup_bindsave&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top  class="BBtable">
			<tr><th colspan="3" class="list_bg"></th></tr>
			<TR>
	<td></td>
	<TD colspan="1" align="left">
	
		<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
         运维用户<input type="text" class="wbk" name="webuser" value="<?php echo $_smarty_tpl->tpl_vars['webuser']->value;?>
">
	资源组<input type="text" class="wbk" name="webgroup" value="<?php echo $_smarty_tpl->tpl_vars['webgroup']->value;?>
">
	&nbsp;&nbsp;<input  type="button" value=" 搜索 " onclick="searchit();" class="bnnew2">
	</TD>
  </TR>
			 <tr><td align="right">组名</td><td><?php echo $_smarty_tpl->tpl_vars['ginfo']->value['groupname'];?>
</td></tr>
	  <tr><td align="right">已授权资源数</td><td><?php echo $_smarty_tpl->tpl_vars['ginfo']->value['devicesct'];?>
</td></tr>
	  <tr><td align="right">描述</td><td><?php echo $_smarty_tpl->tpl_vars['ginfo']->value['desc'];?>
</td></tr>
         <tr>
	  <td width="10%" align="right" valign=top>授权<?php echo $_smarty_tpl->tpl_vars['language']->value['group'];?>

	  <table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' <?php if ($_GET['bindgroup'] == 1) {?>checked<?php }?> onclick="reload('bindgroup=1','bindgroup=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' <?php if ($_GET['bindgroup'] == 2) {?>checked<?php }?> onclick="reload('bindgroup=2','bindgroup=0',this.checked);"></td></tr>
	  </table></td>
	  <td >
	  <table><tr>
	  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['u'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['u']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['name'] = 'u';
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['usergroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total']);
?>
	  <?php if (!$_GET['bindgroup'] || ($_GET['bindgroup'] == 2 && $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['check'] == '') || ($_GET['bindgroup'] == 1 && $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['check'] == 'checked')) {?>
		<td width="180"><input type="checkbox" name='Group<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['u']['index'];?>
' value='<?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['id'];?>
'  <?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['check'];?>
><a onclick="window.open ('admin.php?controller=admin_pro&action=resourcegrp_selgroup&gid=<?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['id'];?>
&sid=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&sessionlgroup=<?php echo $_smarty_tpl->tpl_vars['sessionlgroup']->value;?>
', 'newwindow', 'height=600, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;"  href="#" target="_blank" ><?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['groupname'];?>
</a></td><?php if (($_smarty_tpl->getVariable('smarty')->value['section']['u']['index']+1)%5 == 0) {?></tr><tr><?php }?>
		<?php }?>
		<?php endfor; endif; ?>
		</tr></table>
	  </td>
	  </tr>
	  <tr><td></td><td></td></tr>
		<tr>
		<td align=right valign=top>
		授权<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];?>

		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' <?php if ($_GET['binduser'] == 1) {?>checked<?php }?> value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' <?php if ($_GET['binduser'] == 2) {?>checked<?php }?> value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll1(this.checked);"></td></tr>
	  </table>
		</td>
		<td>
		<table><tr>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['g'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['g']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['name'] = 'g';
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
		<?php if (!$_GET['binduser'] || ($_GET['binduser'] == 2 && $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'] == '') || ($_GET['binduser'] == 1 && $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'] == 'checked')) {?>
		<td width="180"><input type="checkbox" name='Check<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['g']['index'];?>
' value='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
'  <?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'];?>
><a onclick="window.open ('admin.php?controller=admin_pro&action=resourcegrp_seluser&uid=<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
&sid=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&sessionluser=<?php echo $_smarty_tpl->tpl_vars['sessionluser']->value;?>
', 'newwindow', 'height=600, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" ><?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['username'];?>
(<?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname']) {
echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname'];
} else { ?>未设置<?php }?>)</a></td><?php if (($_smarty_tpl->getVariable('smarty')->value['section']['g']['index']+1)%5 == 0) {?></tr><tr><?php }?>
		<?php }?>
		<?php endfor; endif; ?>
		</tr></table>
	  </td>
	  </tr>
	 
	<tr><td></td><td><input type=submit  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td></tr></table>
<input type="hidden" name="sessionlgroup" value="<?php echo $_smarty_tpl->tpl_vars['sessionlgroup']->value;?>
" />
<input type="hidden" name="sessionluser" value="<?php echo $_smarty_tpl->tpl_vars['sessionluser']->value;?>
" />
</form>
	</td>
  </tr>
</table>

<?php echo '<script'; ?>
>
function checkAll1(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,5)=='Check'){
			targets[j].checked=c;
		}
	}
}
function reload(p1,p2,check){
	window.location=window.location+'&'+(check ? p1 : p2);
}
<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>
<?php echo '</script'; ?>
>
</body>
</html>



<?php }
}
?>