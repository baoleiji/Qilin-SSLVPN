<?php /* Smarty version 3.1.27, created on 2017-01-01 18:46:42
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/menu.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:19476170865868de12a0e6f3_55754281%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed52cf2cc2b54f7b9b1a260d349d455861c31ebc' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/menu.tpl',
      1 => 1483267598,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19476170865868de12a0e6f3_55754281',
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
    'allsgroup' => 0,
    '_config' => 0,
    'language' => 0,
    'amdin_level' => 0,
    'login_tip' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5868de12b18080_79912502',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5868de12b18080_79912502')) {
function content_5868de12b18080_79912502 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once '/opt/freesvr/web/htdocs/freesvr/audit/otp/smarty/plugins/modifier.truncate_cn.php';

$_smarty_tpl->properties['nocache_hash'] = '19476170865868de12a0e6f3_55754281';
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
/images/group.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member" target="main" id="membermenu" onclick="return jumpto(this)">用户管理</a></td>
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
</table>
</div>
</td></tr>

<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/group.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_pro&action=dev_index" target="main" id="devmenu" onclick="return jumpto(this)">设备管理</a></td>
                    </tr>  

<tr id="_tree"><td>     
<div style=" width:180px; overflow-x:auto;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
/images/hammer_screwdriver.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_pro&action=dev_group" target="main" onclick="return jumpto(this)">目录管理</a></td>
                    </tr>	
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/hammer_screwdriver.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_pro&action=systemtype" target="main" onclick="return jumpto(this)">系统类型</a></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/key.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member&action=keys_index" target="main" onclick="return jumpto(this)">动态令牌</a></td>
                    </tr>
					
					 <?php }?>
                </table></td>
              </tr>
			  <?php }?>


			<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1) {?>
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('configure');" class="anniu"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1_4.png" width="18" height="21" style="vertical-align:middle"/> 系统管理</td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="configure" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/cog.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=config_ftp" target="main" id="configure1" onclick="return jumpto(this)">系统配置</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=login_times" target="main" onclick="return jumpto(this)">密码策略</a></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=syslog_mail_alarm" target="main" onclick="return jumpto(this)">告警配置</a></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=status_warning" target="main" onclick="return jumpto(this)">告警参数</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/application_double.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=serverstatus" target="main" id="serverstatus" onclick="return jumpto(this)">服务状态</a></td>
                    </tr>
                </table></td>
              </tr>
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
					
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ico9.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member&action=edit_self" target="main" id="OwnInformation" onclick="return jumpto(this)"><?php echo $_smarty_tpl->tpl_vars['language']->value['OwnInformation'];?>
</a></td>
                    </tr>
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
		if((obj.id=='membermenu' || obj.id=='devmenu')&&selectedItem==obj){
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
show_box('other');
//jumpto(document.getElementById('devlist2'));
//document.getElementById('devlist2').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_index&action=main';
//ddev.s(0);

<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 11) {?>
show_box('other');
jumpto(document.getElementById('OwnInformation'));
document.getElementById('OwnInformation').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('OwnInformation').href;
<?php } elseif ($_smarty_tpl->tpl_vars['admin_level']->value == 3 || $_smarty_tpl->tpl_vars['amdin_level']->value == 1) {?>
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_status&action=latest';
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