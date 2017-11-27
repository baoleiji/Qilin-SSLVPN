<?php /* Smarty version 3.1.27, created on 2016-12-04 20:06:54
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/sshkey_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:144239213584406de531c86_37916668%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f64ebc0687b06c8a85eaf38bc7b430647fe35efa' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/sshkey_list.tpl',
      1 => 1474793216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '144239213584406de531c86_37916668',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'alluser' => 0,
    'allserver' => 0,
    'ginfo' => 0,
    'resource' => 0,
    'res' => 0,
    '_config' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_584406de6587d0_79966317',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_584406de6587d0_79966317')) {
function content_584406de6587d0_79966317 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '144239213584406de531c86_37916668';
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
<?php echo '<script'; ?>
>

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var allserver = new Array();
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['au'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['au']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['name'] = 'au';
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alluser']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total']);
?>
alluser[i++]={uid:<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['uid'];?>
,username:'<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['username'];?>
',realname:'<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['realname'];?>
',groupid:<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['groupid'];?>
,level:<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['level'];?>
};
<?php endfor; endif; ?>
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['as'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['as']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['name'] = 'as';
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allserver']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total']);
?>
allserver[i++]={hostname:'<?php echo $_smarty_tpl->tpl_vars['allserver']->value[$_smarty_tpl->getVariable('smarty')->value['section']['as']['index']]['hostname'];?>
',device_ip:'<?php echo $_smarty_tpl->tpl_vars['allserver']->value[$_smarty_tpl->getVariable('smarty')->value['section']['as']['index']]['device_ip'];?>
',groupid:<?php echo $_smarty_tpl->tpl_vars['allserver']->value[$_smarty_tpl->getVariable('smarty')->value['section']['as']['index']]['groupid'];?>
};
<?php endfor; endif; ?>

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
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
     <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
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
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=sshkey&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
 <style>
.ul{list-style-type:none; margin:0;width:100%; }
.ul li{ width:80px; float:left;}
</style>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>

            <td align="center"><form name="f1" method=post OnSubmit='return checkall("secend")' action="admin.php?controller=admin_pro&action=sshkey_list_save&id=<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['id'];?>
">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=center colspan="3"><div style="text-align:left;width:700px;">
		SSH私钥:<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['sshkeyname'];?>

		
		<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
              &nbsp;&nbsp;&nbsp;IP：<input type="text" name="ip" id="ip" >&nbsp;&nbsp;&nbsp;主账号：<input type="text" name="username" id="username" >&nbsp;&nbsp;&nbsp;<input type="button" onclick="searchip();" value="确定" /></div>
	  </td>
	  </tr><tr>
	  <td width="33%" align=center>
		<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" ondblclick="moveRight()">
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ra'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['name'] = 'ra';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['resource']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['resource']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['devicesid'];?>
_1" title="<?php echo $_smarty_tpl->tpl_vars['resource']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['username'];?>
_<?php echo $_smarty_tpl->tpl_vars['resource']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['uname'];?>
_<?php echo $_smarty_tpl->tpl_vars['resource']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['lmname'];?>
_<?php echo $_smarty_tpl->tpl_vars['resource']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['device_ip'];?>
"><?php echo $_smarty_tpl->tpl_vars['resource']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['username'];?>
_<?php echo $_smarty_tpl->tpl_vars['resource']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['uname'];?>
_<?php echo $_smarty_tpl->tpl_vars['resource']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['lmname'];?>
_<?php echo $_smarty_tpl->tpl_vars['resource']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['device_ip'];?>
</option>
		<?php endfor; endif; ?>
		
		</select>
		</td>
		<td width="10%">
		<div class="select_move_2">
                <input type="button" value="添加-->" onclick="moveRight()"/><br />
                <input type="button" value="<--删除"  onclick="moveLeft()"/><br />
          </div>
         </td>
         <td>
		<select  class="wbk"   style="width:400;height:400;" size="30" id="secend" name="secend[]" multiple="multiple">
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['r'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['r']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['name'] = 'r';
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['res']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['r']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['r']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['r']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['devicesid'];?>
_1" title="<?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['username'];?>
_<?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['uname'];?>
_<?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['lmname'];?>
_<?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['device_ip'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['username'];?>
_<?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['lmname'];?>
_<?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['r']['index']]['device_ip'];?>
</option>
		<?php endfor; endif; ?>
   		</select>
	  </td>
	</tr>
	</table>
<br>
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['id'];?>
">
<input type="hidden" name="oldgname" value="<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['groupname'];?>
">
<input type="submit"  value="保存" class="an_02">
</form>
	</td>
  </tr>
</table>

<?php echo '<script'; ?>
 language="javascript">
var changed = false;
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

function changegroup(value){
	if(changed){
		if(confirm('确定要放弃更改?')){
			window.location='admin.php?controller=admin_pro&action=sshkey_list&groupid='+value+'&gname=<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['groupname'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['id'];?>
';
		}
	}else{
		window.location='admin.php?controller=admin_pro&action=sshkey_list&groupid='+value+'&gname=<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['groupname'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['id'];?>
';
	}
}

function searchip(){
	var ldapid1=0;
	var ldapid2=0;
	var ldapid3=0;
	var ldapid4=0;
	var ldapid5=0;
	var groupid=0;
	var ip = document.getElementById("ip").value;
	var username = document.getElementById("username").value;
	
	groupid=document.getElementById("groupiddh").value;
	if(changed){
		if(confirm('确定要放弃更改?')){
			window.location='admin.php?controller=admin_pro&action=sshkey_list&'+'&groupid='+groupid+'&gname=<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['groupname'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['id'];?>
'+'&ip='+ip+'&username='+username;
		}
	}else{
		window.location='admin.php?controller=admin_pro&action=sshkey_list&'+'&groupid='+groupid+'&gname=<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['groupname'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['ginfo']->value['id'];?>
'+'&ip='+ip+'&username='+username;
	}
}
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" >

	
	/**选中的元素向右移动**/
 	function moveRight()
	{
		
			//得到第一个select对象
		var selectElement = document.getElementById("first");
		var optionElements = selectElement.getElementsByTagName("option");
		var len = optionElements.length;
		var selectElement2 = document.getElementById("secend");

		if(!(selectElement.selectedIndex==-1))   //如果没有选择元素，那么selectedIndex就为-1
		{
			
			//得到第二个select对象
			
	
				// 向右移动
				for(var i=0;i<len ;i++)
				{
					if(selectElement.selectedIndex>=0)
					selectElement2.appendChild(optionElements[selectElement.selectedIndex]);
				}
				changed = true;
		} else
		{
			alert("您还没有选择需要移动的元素！");
		}
	}
	

	
	//移动选中的元素到左边
	function moveLeft()
	{
		//首先得到第二个select对象
		var selectElement = document.getElementById("secend");
		
		var optionElement = selectElement.getElementsByTagName("option");
		var len = optionElement.length;
		var firstSelectElement = document.getElementById("first");
		
		
		//再次得到第一个元素
		if(!(selectElement.selectedIndex==-1))
		{
			
			for(i=0;i<len;i++)
			{
				if(selectElement.selectedIndex>=0)
					firstSelectElement.appendChild(optionElement[selectElement.selectedIndex]);//被选中的那个元素的索引
			}
			changed = true;
		}else
		{
			alert("您还没有选中要移动的项目!");
		}
	}
	
	function checkall(selectID){
		var obj = document.getElementById(selectID);
		var len = obj.options.length;
		for(var i=0; i<len; i++){
			obj.options[i].selected = true;
		}
		return true;
	}

<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>
<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>