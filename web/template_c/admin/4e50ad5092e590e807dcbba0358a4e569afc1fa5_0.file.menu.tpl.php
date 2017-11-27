<?php /* Smarty version 3.1.27, created on 2016-12-04 00:05:53
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/menu.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5910718785842ed618bfc35_75713487%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e50ad5092e590e807dcbba0358a4e569afc1fa5' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/menu.tpl',
      1 => 1480493598,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5910718785842ed618bfc35_75713487',
  'variables' => 
  array (
    'site_title' => 0,
    'template_root' => 0,
    'Year' => 0,
    'Month' => 0,
    'Day' => 0,
    'Week' => 0,
    'username' => 0,
    'user' => 0,
    'admin_level' => 0,
    'sgroups' => 0,
    'sgroup' => 0,
    'member' => 0,
    'appservers' => 0,
    'cacti_on' => 0,
    'netmanageenable' => 0,
    'allsgroup' => 0,
    '_config' => 0,
    'appenable' => 0,
    'xunjianbackup' => 0,
    'language' => 0,
    'logenable' => 0,
    'amdin_level' => 0,
    'login_tip' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5842ed61ae2534_11625954',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5842ed61ae2534_11625954')) {
function content_5842ed61ae2534_11625954 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once '/opt/freesvr/web/htdocs/freesvr/audit/dep10/smarty/plugins/modifier.truncate_cn.php';

$_smarty_tpl->properties['nocache_hash'] = '5910718785842ed618bfc35_75713487';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->tpl_vars['site_title']->value;?>
</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 >

function showNodeCount0(check){
	var els = document.getElementsByTagName('div');
	for(var i=0; i<els.length; i++){
		if($(els[i]).attr("class")=='dTreeNode'&&$(els[i]).attr("count")==0){
			$(els[i]).css("display",check ? "" : "none");
		}
	}
}

function showLongTitle(check){return ;
	var els = document.getElementsByTagName('a');
	for(var i=0; i<els.length; i++){
		if($(els[i]).attr("class")=='node'){
			if(check){
				$(els[i])[0].innerText = $(els[i]).attr("shorttitle");
			}else{
				$(els[i])[0].innerText = $(els[i]).attr("longtitle");
			}
		}
	}
}
<?php echo '</script'; ?>
>
<body>
<table width="213" height="500" border="0" cellpadding="0" cellspacing="0"  class="zuo_bj" >
      <tr>
        <td height="42" colspan="2" align="center" valign="middle" class="hui_bj"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/yw_53.jpg" width="16" height="13" align="absmiddle" /> <?php echo $_smarty_tpl->tpl_vars['Year']->value;?>
年<?php echo $_smarty_tpl->tpl_vars['Month']->value;?>
月<?php echo $_smarty_tpl->tpl_vars['Day']->value;?>
日 星期<?php echo $_smarty_tpl->tpl_vars['Week']->value;?>
&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td width="209" height="606" align="center" valign="top">
			<table width="189" height="117" border="0" cellpadding="0" cellspacing="0" class="sy">
				<tr>
				  <td height="29" colspan="2" align="left">&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/yw_47.jpg" width="22" height="22" align="absmiddle" />&nbsp;<strong class="bd">管理首页</strong></td>
				</tr>
				<tr>
				  <td width="87" align="center" valign="middle"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/yw_43.jpg" width="67" height="62" /></td>
				  <td width="98" align="left" valign="middle"><?php echo $_smarty_tpl->tpl_vars['username']->value;?>
<br />(<?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['user']->value['realname'],"10","...");?>
)<br />
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 0) {?>普通用户<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 1) {?>管理员<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 3) {?>部门管理员<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 4) {?>配置管理员<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 10) {?>密码管理员<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 21) {?>部门审计员<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 101) {?>部门密码员<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 11) {?>RADIUS用户<?php }?></td>
				</tr>
			</table>
            <br />
            <table width="178"  border="0" cellpadding="0" cellspacing="0" id="audit_menu">

			<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 0) {?>
			  <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('password');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_5.png" width="18" height="21" style="vertical-align:middle"/> 设备管理</td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="password" style="display:none" >
				<table width="178"  border="0" cellpadding="0" cellspacing="2">
					
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01">
					  
<div style=" width:180px; overflow-x:auto;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="devtreetable"><tr><td>

<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/dtree.js"><?php echo '</script'; ?>
>
<div class="dtree" >
	<?php echo '<script'; ?>
 type="text/javascript">
		<?php if ($_smarty_tpl->tpl_vars['user']->value['ldap']) {?>
		ddev = new dTree('ddev');
		ddev.icon['folder'] = 'template/admin/cssjs/img/pcgroup.gif';
		ddev.icon['folderOpen'] = 'template/admin/cssjs/img/pcgroup.gif';
		ddev.icon['node'] = 'template/admin/cssjs/img/pc.gif';		
		ddev.config['noshorttitle']=false;
		var i=0;
		ddev.add(0,-1,'设备组','admin.php?controller=admin_index&action=main&all=1','','main');
		//ddev.add(10000,0,'所有主机','admin.php?controller=admin_pro&action=dev_index','','main');
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ag'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['name'] = 'ag';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['sgroups']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total']);
?>
			<?php if ($_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['count'] > 0) {?>
			ddev.add(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['id'];?>
,<?php if (!$_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['ldapid']) {?>0<?php } else {
echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['ldapid'];
}?>,'<?php if ($_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['level'] == 1) {
echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];
} elseif ($_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['level'] == 2) {
echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];
} else {
echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];
}?>(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['count'];?>
)','admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['count'];?>
)','main','template/admin/cssjs/img/servergroup.png','template/admin/cssjs/img/servergroup.png',null,<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['count'];?>
,'<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['count'];?>
)','<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['count'];?>
)');
			<?php }?>
		<?php endfor; endif; ?>	
		document.write(ddev);		
		ddev.s(0);
		<?php } else { ?>
		d = new dTree('d');
		d.icon['folder'] = 'template/admin/cssjs/img/pcgroup.gif';
		d.icon['folderOpen'] = 'template/admin/cssjs/img/pcgroup.gif';
		d.icon['node'] = 'template/admin/cssjs/img/servergroup.png';
		d.config['noshorttitle']=false;
		//d.icon['node'] = 'template/admin/cssjs/img/pc.gif';
		var i=0;
		d.add(0,-1,'设备组','admin.php?controller=admin_index&action=main&all=1','','main');
		//d.add(10000,0,'所有主机','admin.php?controller=admin_index&action=main','','main');
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ug'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ug']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['name'] = 'ug';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['sgroups']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ug']['total']);
?>
			<?php if ($_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['count'] > 0 && $_smarty_tpl->tpl_vars['sgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['level'] == 0) {?>
			d.add(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['id'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['count'];?>
)','admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['count'];?>
)','main',null,null,null,<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['count'];?>
,'<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['count'];?>
)','<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['sgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ug']['index']]['count'];?>
)');
			<?php }?>
		<?php endfor; endif; ?>
		document.write(d);		
		d.s(0);
		<?php }?>
	<?php echo '</script'; ?>
>
</div>
					  </td>
                    </tr> 
					</table>
					<table width="178"  border="0" cellpadding="0" cellspacing="2" id="apptreetable" style="display:none;">
		     <tr>
                      <td height="25" align="left" bgcolor="52A1D4"><?php echo $_smarty_tpl->tpl_vars['member']->value['apphost'];?>

<div class="dtree" >
	<?php echo '<script'; ?>
 type="text/javascript">
		dapp = new dTree('dapp');
		dapp.icon['folder'] = 'template/admin/cssjs/img/servergroup.png';
		dapp.icon['folderOpen'] = 'template/admin/cssjs/img/servergroup.png';
		dapp.icon['node'] = 'template/admin/cssjs/img/servergroup.png';
		dapp.config['noshorttitle']=false;
		var i=0;
		dapp.add(0,-1,'应用发布','admin.php?controller=admin_index&action=main&logintype=apppub','','main');
		<?php if ($_smarty_tpl->tpl_vars['user']->value['apphost']) {?>
		
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ap'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['name'] = 'ap';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['appservers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total']);
?>
			dapp.add(<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']+1;?>
,0,'<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['hostname'];?>
(<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['count'];?>
)','admin.php?controller=admin_index&action=main&logintype=apppub&appserverip=<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appserverip'];?>
','<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['hostname'];?>
(<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['count'];?>
)','main',null,null,null,1);
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['apg'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['apg']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['name'] = 'apg';
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appsgroups']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['apg']['total']);
?>
				dapp.add(<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']+1;
echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appsgroups'][$_smarty_tpl->getVariable('smarty')->value['section']['apg']['index']]['id'];?>
,<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']+1;
if ($_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appsgroups'][$_smarty_tpl->getVariable('smarty')->value['section']['apg']['index']]['ldapid']) {
echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appsgroups'][$_smarty_tpl->getVariable('smarty')->value['section']['apg']['index']]['ldapid'];
}?>,'<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appsgroups'][$_smarty_tpl->getVariable('smarty')->value['section']['apg']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appsgroups'][$_smarty_tpl->getVariable('smarty')->value['section']['apg']['index']]['count'];?>
)','admin.php?controller=admin_index&action=main&logintype=apppub&appserverip=<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appserverip'];?>
&gid=<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appsgroups'][$_smarty_tpl->getVariable('smarty')->value['section']['apg']['index']]['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appsgroups'][$_smarty_tpl->getVariable('smarty')->value['section']['apg']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['appsgroups'][$_smarty_tpl->getVariable('smarty')->value['section']['apg']['index']]['count'];?>
)','main',null,null,null,1);		
			<?php endfor; endif; ?>
			
		<?php endfor; endif; ?>
		<?php }?>
		document.write(dapp);	
		
		//dapp.s(1);
	<?php echo '</script'; ?>
>
</div>
		      </td>
                    </tr> 
					</table>
					</div>
					</td>
					</tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/list_ico18.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_index&action=createrdpfile" target="main" id='devlist3' onclick="return jumpto(this)">列表导出</a></td>
                    </tr> 
					<?php if ($_smarty_tpl->tpl_vars['cacti_on']->value && $_smarty_tpl->tpl_vars['netmanageenable']->value) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/cog.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_monitor&action=index" target="main" id="configure1" onclick="return jumpto(this)">监控信息</a></td>
                    </tr>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['user']->value['allowchange']) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/wall_disable.png" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_index&action=chpwd" target="main" onclick="return jumpto(this)">密码修改</a></td>
                    </tr> 
					<?php }?>
                </table></td>
              </tr>


			  <?php }?>





			<?php if ($_smarty_tpl->tpl_vars['admin_level']->value != 10 && $_smarty_tpl->tpl_vars['admin_level']->value != 101 && $_smarty_tpl->tpl_vars['admin_level']->value != 4 && $_smarty_tpl->tpl_vars['admin_level']->value != 11) {?>
              <tr>
                <td align="left" class="anniu" onclick="javascript:show_box('audit');"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_1.png"  style="vertical-align:middle"/> 运维审计</td>
              </tr>
              <tr >
                <td align="left" valign="top" id="audit" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tb_86.jpg" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_session" target="main" id="sshaudit" onclick="return jumpto(this)">操作审计</a></td>
                    </tr>
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1 || $_smarty_tpl->tpl_vars['admin_level']->value == 2 || $_smarty_tpl->tpl_vars['admin_level']->value == 3 || $_smarty_tpl->tpl_vars['admin_level']->value == 21 || $_smarty_tpl->tpl_vars['admin_level']->value == 31) {?>
                   
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tb_93.jpg" width="18" height="18"  align="absmiddle"/> <a href="admin.php?controller=admin_apppub" target="main" onclick="return jumpto(this)">应用审计</a></td>
                    </tr>
					
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1 || $_smarty_tpl->tpl_vars['admin_level']->value == 2 || $_smarty_tpl->tpl_vars['admin_level']->value == 3 || $_smarty_tpl->tpl_vars['admin_level']->value == 21 || $_smarty_tpl->tpl_vars['admin_level']->value == 31) {?>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tb_98.jpg" width="18" height="16"  align="absmiddle"/> <a href="admin.php?controller=admin_session&action=gateway_running_list" target="main" onclick="return jumpto(this)">实时监控</a></td>
                    </tr>
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value != 3) {?>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot20.gif" width="18" height="16"  align="absmiddle"/> <a href="admin.php?controller=admin_session&action=search" target="main" onclick="return jumpto(this)">审计查询</a></td>
                    </tr>
					<?php }?>
					<?php }?>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 2) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tb_101.jpg" width="18" height="16"  align="absmiddle"/> <a href="admin.php?controller=admin_session&action=batch_del" target="main" onclick="return jumpto(this)">日志删除</a></td>
                    </tr>
					<?php }?>
                </table></td>
              </tr>
			  <?php }?>
			 <?php if ($_smarty_tpl->tpl_vars['admin_level']->value != 10 && $_smarty_tpl->tpl_vars['admin_level']->value != 4 && $_smarty_tpl->tpl_vars['admin_level']->value != 0 && $_smarty_tpl->tpl_vars['admin_level']->value != 21 && $_smarty_tpl->tpl_vars['admin_level']->value != 101 && $_smarty_tpl->tpl_vars['admin_level']->value != 11) {?>
              <tr >
                <td align="left" valign="middle" onclick="javascript:show_box('report');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_2.png" width="18" height="18" style="vertical-align:middle"/> 报表统计</td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="report" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value != 0) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/chart_line.gif"   align="absmiddle"/> <a href="admin.php?controller=admin_reports&action=systempriority_search" target="main" onclick="return jumpto(this)">系统权限</a></td>
                    </tr>  
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot1.gif"   align="absmiddle"/> <a href="admin.php?controller=admin_reports&action=loginacct" target="main" onclick="return jumpto(this)">登录报表</a></td>
                    </tr>  
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot2.gif" align="absmiddle"/> <a href="admin.php?controller=admin_reports&action=commandreport" target="main" onclick="return jumpto(this)">操作报表</a></td>
                    </tr>  
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot3.gif" align="absmiddle"/> <a href="admin.php?controller=admin_reports&action=dangercmdreport" target="main" onclick="return jumpto(this)">告警报表</a></td>
                    </tr>  
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01">
					  <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot4.gif" width="16" height="16"  align="absmiddle"/> <a href="admin.php?controller=admin_reports&action=reportgraph" id="statisticreport" target="main" onclick="return jumpto(this)">图形输出</a></td>
                    </tr>  
					
					<?php } else { ?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/chart_curve.gif"   align="absmiddle"/> <a href="admin.php?controller=admin_reports&action=loginacct" target="main" onclick="return jumpto(this)">授权明细</a></td>
                    </tr>  
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 2) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/chart_pie.gif"  align="absmiddle"/> <a href="admin.php?controller=admin_log&action=adminlog" target="main" onclick="return jumpto(this)">系统操作</a></td>
                    </tr>  
					
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1) {?>
					
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot5.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_reports&action=configreport" target="main" onclick="return jumpto(this)">报表配置</a></td>
                    </tr> 
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot5.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_reports&action=report_search" target="main" onclick="return jumpto(this)">定期报表</a></td>
                    </tr> 
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot6.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_backup&action=backup_log" target="main" onclick="return jumpto(this)">系统状态</a></td>
                    </tr>  
					<?php }?>
                </table></td>
              </tr>
			  <?php }?>
			


			<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1 || $_smarty_tpl->tpl_vars['admin_level']->value == 3 || $_smarty_tpl->tpl_vars['admin_level']->value == 4) {?>
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('resource');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_3.png" width="18" height="15" style="vertical-align:middle"/> 资源管理</td>
              </tr>
			  <tr >
                <td align="left" valign="top" id="resource" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value != 10) {?>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/group.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member" target="main" id="membermenu" onclick="return jumpto(this)">资产管理</a></td>
                    </tr>  
<tr id="_tree"><td>     
<div style=" width:180px; overflow-x:auto;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr id="mtree" style="display:none">
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/_ajaxdtree.js"><?php echo '</script'; ?>
>
<div class="dtree" id="mddevtree" >
	<?php echo '<script'; ?>
 type="text/javascript">
		mddev = new dTree('mddev','mddevtree');
		mddev.icon['folder'] = 'template/admin/cssjs/img/pcgroup.gif';
		mddev.icon['folderOpen'] = 'template/admin/cssjs/img/pcgroup.gif';
		mddev.icon['node'] = 'template/admin/cssjs/img/pc.gif';
		mddev.config['menu']=1;
		var i=0;
		mddev.add(0,-1,'',1,'目录','admin.php?controller=admin_member&all=1','','main',null,null,null);
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ag'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['name'] = 'ag';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allsgroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total']);
?>
			mddev.add(<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['id'];?>
,<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP'] == 0) {?>0<?php } else {
echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['ldapid'];
}?>,'<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['id'];?>
',<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['mcount'];?>
,'<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['mcount'];?>
)','admin.php?controller=admin_member&ldapid=<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['mcount'];?>
)','main','template/admin/cssjs/img/servergroup.png','template/admin/cssjs/img/servergroup.png',null);
		<?php endfor; endif; ?>
		mddev.show();
		mddev.s(0);
	<?php echo '</script'; ?>
>
</div>

					  </td>
                    </tr> 


<tr id="devtree" style="display:none">
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01">
<div class="dtree" id="ddevtree">
	<?php echo '<script'; ?>
 type="text/javascript">
		ddev = new dTree('ddev','ddevtree');
		ddev.icon['folder'] = 'template/admin/cssjs/img/pcgroup.gif';
		ddev.icon['folderOpen'] = 'template/admin/cssjs/img/pcgroup.gif';
		ddev.icon['node'] = 'template/admin/cssjs/img/pc.gif';
		ddev.config['menu']=2;
		var i=0;
		ddev.add(0,-1,'',1,'设备组','admin.php?controller=admin_pro&action=dev_index&all=1','','main',null,null,null,1,'设备组','设备组');
		//ddev.add(10000,0,'所有主机','admin.php?controller=admin_pro&action=dev_index','','main');
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ag'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['name'] = 'ag';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allsgroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ag']['total']);
?>
			ddev.add(<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['id'];?>
,<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP'] == 0) {?>0<?php } else {
echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['ldapid'];
}?>,'<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['id'];?>
',<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['count'];?>
,'<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['count'];?>
)','admin.php?controller=admin_pro&action=dev_index&gid=<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['groupname'];?>
(<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ag']['index']]['count'];?>
)','main','template/admin/cssjs/img/servergroup.png','template/admin/cssjs/img/servergroup.png',null);
		<?php endfor; endif; ?>
		ddev.show();	
		ddev.s(0);
	<?php echo '</script'; ?>
>
</div>

					  </td>
                    </tr> 
</table>
</div>
</td></tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot19.gif" width="18" height="21"  align="absmiddle"/> <a href="<?php if ($_smarty_tpl->tpl_vars['appenable']->value) {?>admin.php?controller=admin_config&action=appserver_list<?php } else { ?>#<?php }?>" target="main" onclick="<?php if (!$_smarty_tpl->tpl_vars['appenable']->value) {?>alert('Licenses不包含应用发布');return false;<?php }?>return jumpto(this)">应用发布</a></td>
                    </tr>
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value != 4) {?>
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 3 || $_smarty_tpl->tpl_vars['admin_level']->value == 21 || $_smarty_tpl->tpl_vars['admin_level']->value == 101) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/hammer_screwdriver.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_pro&action=sourceip" target="main" onclick="return jumpto(this)">策略管理</a></td>
                    </tr>	
					<?php } else { ?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/hammer_screwdriver.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=default_policy" target="main" onclick="return jumpto(this)">策略设置</a></td>
                    </tr>	
					<?php }?>
					<?php }?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot19.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_pro&action=resource_group" target="main" onclick="return jumpto(this)">授权权限</a></td>
                    </tr>
					<?php if ($_smarty_tpl->tpl_vars['xunjianbackup']->value) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot19.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_autorun&action=autobackup_list" target="main" onclick="return jumpto(this)">巡检备份</a></td>
                    </tr>
					<?php }?>
					 <?php }?>
                </table></td>
              </tr>
			  <?php }?>

			<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 10 || $_smarty_tpl->tpl_vars['admin_level']->value == 101) {?>
			  <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('password');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_4.png" width="18" height="21" style="vertical-align:middle"/> <?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 10 || $_smarty_tpl->tpl_vars['admin_level']->value == 101) {
echo $_smarty_tpl->tpl_vars['language']->value['Password'];
echo $_smarty_tpl->tpl_vars['language']->value['manage'];
} else {
echo $_smarty_tpl->tpl_vars['language']->value['device'];
echo $_smarty_tpl->tpl_vars['language']->value['manage'];
}?></td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="password" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 10 || $_smarty_tpl->tpl_vars['admin_level']->value == 101) {?>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/wall.png"  width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_index&action=main" id='passlist' target="main" onclick="return jumpto(this)"><?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 10 || $_smarty_tpl->tpl_vars['admin_level']->value == 101) {?>密码管理<?php } else {
echo $_smarty_tpl->tpl_vars['language']->value['DevicesList'];
}?></a></td>
                    </tr>
					 <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/wall.png"  width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_pro&action=logs_index" id='passlist' target="main" onclick="return jumpto(this)">改密报表</a></td>
                    </tr>
					<?php }?>
                </table></td>
              </tr>

			
			  <?php }?>


			<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1) {?>
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('configure');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_4.png" width="18" height="21" style="vertical-align:middle"/> 系统配置</td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="configure" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/cog.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=config_ssh" target="main" id="configure1" onclick="return jumpto(this)">参数配置</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=ifcfgeth" target="main" onclick="return jumpto(this)"><?php echo $_smarty_tpl->tpl_vars['language']->value['Network'];?>
</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/application_double.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=serverstatus" target="main" id="serverstatus" onclick="return jumpto(this)">系统管理</a></td>
                    </tr>
                </table></td>
              </tr>
			  <?php }?>
			<?php if ($_smarty_tpl->tpl_vars['cacti_on']->value && $_smarty_tpl->tpl_vars['netmanageenable']->value) {?>
			  <?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1) {?>
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('monitor');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_4.png" width="18" height="21" style="vertical-align:middle"/> 网管监控</td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="monitor" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/cog.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_monitor&action=index" target="main" id="configure1" onclick="return jumpto(this)">监控信息</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/cog.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_monitor&action=apache_monitor" target="main" id="configure1" onclick="return jumpto(this)">应用监控</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_thold" target="main" onclick="return jumpto(this)">阈值配置</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/application_double.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_thold&action=snmp_alert" target="main" id="monitor_conf" onclick="return jumpto(this)">配置管理</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot1.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_reports&action=host_reports" target="main" id="monitor_report" onclick="return jumpto(this)">报表管理</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot3.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_thold&action=snmp_status_warning_log" target="main" id="monitor_alert" onclick="return jumpto(this)">告警统计</a></td>
                    </tr>
                </table></td>
              </tr>
			  <?php }?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['_config']->value['LOG_ON'] && $_smarty_tpl->tpl_vars['logenable']->value) {?>
			  <?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1) {?>
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('log');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_2.png" width="18" height="21" style="vertical-align:middle"/> 日志管理</td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="log" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/cog.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_search&action=index" target="main" id="configure1" onclick="return jumpto(this)">日志查看</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/cog.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_systemNew" target="main" id="configure1" onclick="return jumpto(this)">告警配置</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_slaveserver" target="main" onclick="return jumpto(this)">日志配置</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/application_double.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_countlogs" target="main" id="monitor_conf" onclick="return jumpto(this)">报表分析</a></td>
                    </tr>
                </table></td>
              </tr>
			  <?php }?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1) {?>
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('vpn');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_5.png" width="18" height="19" style="vertical-align:middle"/> VPN</td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="vpn" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot8.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=vpnconfig" target="main" onclick="return jumpto(this)">VPN配置</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot9.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=vpn_list" target="main" onclick="return jumpto(this)">VPN策略</a></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_dot10.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=route_list" target="main" onclick="return jumpto(this)"><?php echo $_smarty_tpl->tpl_vars['language']->value['VpnRouter'];?>
</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ico9.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_vpnlog&action=online" target="main" onclick="return jumpto(this)">在线用户</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/doc_table.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_vpnlog" target="main" onclick="return jumpto(this)">VPN LOG</a></td>
                    </tr>
                </table></td>
              </tr>
			
			<?php }?>
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('other');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_6.png" width="18" height="19" style="vertical-align:middle"/> 其它</td>
              </tr>

			   <tr>
                <td align="left" valign="top"  id="other" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
					<?php if ($_smarty_tpl->tpl_vars['amdin_level']->value == 1) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/key.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member&action=keys_index" target="main" onclick="return jumpto(this)">动态令牌</a></td>
                    </tr>
					<?php }?>  
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ico9.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member&action=edit_self" target="main" id="OwnInformation" onclick="return jumpto(this)"><?php echo $_smarty_tpl->tpl_vars['language']->value['OwnInformation'];?>
</a></td>
                    </tr>
					<?php if ($_smarty_tpl->tpl_vars['amdin_level']->value == 1) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/list_ico4.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_index&action=license" target="main" onclick="return jumpto(this)">License</a></td>
                    </tr>
					<?php }?>  
					<?php if ($_smarty_tpl->tpl_vars['amdin_level']->value == 0) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/drive_disk.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member&action=userdisk" target="main" onclick="return jumpto(this)">网络硬盘</a></td>
                    </tr>
					<?php if ($_smarty_tpl->tpl_vars['amdin_level']->value == 1) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ico5.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_pro&action=sshpublickey" target="main" onclick="return jumpto(this)">私钥管理</a></td>
                    </tr>
					<?php }?>
					<?php }?> 
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value != 10 && $_smarty_tpl->tpl_vars['admin_level']->value != 2 && $_smarty_tpl->tpl_vars['admin_level']->value != 11) {?>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/down.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_index&action=tool_list" target="main" onclick="return jumpto(this)">工具下载</a></td>
                    </tr>
					<?php }?>
                </table></td>
              </tr>
          </table>
		  </td>
       
      </tr>
    </table>
	
	<?php echo '<script'; ?>
>
	var openid="";
	var cururl = "";
	function show_box(box_id){
		<?php if ($_SESSION['ADMIN_LEVEL'] == 1) {?>
		document.getElementById('_tree').style.display='none';
		document.getElementById('devtree').style.display='none';
		document.getElementById('mtree').style.display='none';
		<?php }?>
		if(openid!=""&&openid!=box_id)
		document.getElementById(openid).style.display = "none";
		openid=box_id
		if(document.getElementById(box_id).style.display != "block"){
			document.getElementById(box_id).style.display = "block";
		} else {
			document.getElementById(box_id).style.display = "none";
		}
	}

	var selectedItem = '';
	function jumpto(obj){
		if(obj.id=='membermenu'&&selectedItem==obj){
			if(document.getElementById(cururl).style.display=='none'){
				document.getElementById(cururl).style.display='';
			}else{
				document.getElementById(cururl).style.display='none';
			}
			return false;
		}	
		<?php if ($_SESSION['ADMIN_LEVEL'] == 1) {?>
		document.getElementById('_tree').style.display='none';
		document.getElementById('mtree').style.display='none';
		document.getElementById('devtree').style.display='none';
		<?php }?>
		if(selectedItem)
		selectedItem.parentNode.className='zcd01';
		obj.parentNode.className = "zcd";
		selectedItem = obj;
		return true;
	}

<?php if ($_GET['actions'] == 'dev_group') {?>
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_pro&action=dev_group&ldapid=<?php echo $_GET['ldapid'];?>
&back=<?php echo $_GET['back'];?>
'+'&'+Math.round(new Date().getTime()/1000);
<?php } elseif ($_GET['actions'] == 'dev_server') {?>
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_pro&action=dev_index&gid=<?php echo $_GET['gid'];?>
&back=<?php echo $_GET['back'];?>
'+'&'+Math.round(new Date().getTime()/1000);
<?php } elseif ($_GET['actions'] == 'member') {?>
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_member&ldapid=<?php echo $_GET['ldapid'];?>
&gid=<?php echo $_GET['gid'];?>
&back=<?php echo $_GET['back'];?>
'+'&'+Math.round(new Date().getTime()/1000);
<?php } elseif ($_GET['actions'] == 'radiusmember') {?>
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_member&action=radiususer&ldapid=<?php echo $_GET['ldapid'];?>
&gid=<?php echo $_GET['gid'];?>
&back=<?php echo $_GET['back'];?>
'+'&'+Math.round(new Date().getTime()/1000);
<?php } elseif ($_GET['actions'] == 'usergroup') {?>
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_member&action=usergroup&ldapid=<?php echo $_GET['ldapid'];?>
&back=<?php echo $_GET['back'];?>
'+'&'+Math.round(new Date().getTime()/1000);
<?php } elseif ($_GET['actions'] == 'config_ftp') {?>
show_box('configure');
jumpto(document.getElementById('configure1'));
document.getElementById('configure1').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_config&action=config_ftp'+'&'+Math.round(new Date().getTime()/1000);
<?php } elseif ($_GET['actions'] == 'ldap') {?>
show_box('configure');
jumpto(document.getElementById('configure1'));
document.getElementById('configure1').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_config&action=config_ssh'+'&'+Math.round(new Date().getTime()/1000);

<?php } elseif ($_smarty_tpl->tpl_vars['amdin_level']->value == 10 || $_smarty_tpl->tpl_vars['amdin_level']->value == 101) {?>
show_box('password');
jumpto(document.getElementById('passlist'));
document.getElementById('passlist').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('passlist').href;
<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 0) {?>
show_box('password');
//jumpto(document.getElementById('devlist2'));
//document.getElementById('devlist2').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_index&action=main';
//ddev.s(0);

<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 11) {?>
show_box('other');
jumpto(document.getElementById('OwnInformation'));
document.getElementById('OwnInformation').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('OwnInformation').href;
<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 3) {?>
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('membermenu').href;
<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 4) {?>
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('membermenu').href;
<?php } elseif ($_smarty_tpl->tpl_vars['amdin_level']->value == 2 || $_smarty_tpl->tpl_vars['amdin_level']->value == 21) {?>
show_box('audit');
jumpto(document.getElementById('sshaudit'));
document.getElementById('sshaudit').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('sshaudit').href;
<?php } elseif ($_smarty_tpl->tpl_vars['amdin_level']->value == 1) {?>
show_box('configure');
jumpto(document.getElementById('serverstatus'));
document.getElementById('serverstatus').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_status&action=latest';
<?php }?> 
<?php if ($_smarty_tpl->tpl_vars['login_tip']->value == 1) {?>
window.open ('admin.php?controller=admin_index&action=login_tip', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');
<?php }?>


<?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
?>