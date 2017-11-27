<?php /* Smarty version 3.1.27, created on 2016-12-04 20:06:51
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/sshkey.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1031451336584406db7c3782_85707948%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3552eea93b527b8e35cdbf3c5f6fb8762eed2ef2' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/sshkey.tpl',
      1 => 1477707552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1031451336584406db7c3782_85707948',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'orderby2' => 0,
    'sshdevices' => 0,
    'language' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_584406db83b689_51988131',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_584406db83b689_51988131')) {
function content_584406db83b689_51988131 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1031451336584406db7c3782_85707948';
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
</head>

<body>
<?php echo '<script'; ?>
>
	function searchit(){
		document.search.action = "admin.php?controller=admin_pro&action=sshkey";
		document.search.action += "&username="+document.search.username.value;
		document.search.action += "&ip="+document.search.ip.value;
		document.search.action += "&dusername="+document.search.dusername.value;
		document.search.submit();
		return true;
	}
	
<?php echo '</script'; ?>
>
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
</ul>
</div></td></tr>
	
   <TR>
<TD >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
<form name ='search' action='admin.php?controller=admin_pro&action=sshkey' method=post onsubmit="return searchit();">
  <tr>
    <td >
</td>
    <td >	
					堡垒机用户：<input type="text" name="username" size="13" class="wbk"/>&nbsp;&nbsp; 设备IP：<input type="text" name="ip" size="13" class="wbk"/>&nbsp;&nbsp;系统用户：<input type="text" name="dusername" size="13" class="wbk"/>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>

					</td>
  </tr>
</form>	
</table>
</TD>
                  </TR>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>
				  
                  <TR>
					<th class="list_bg" width="30">&nbsp;</th>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=sshkey&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >名称</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=sshkey&orderby1=dusername&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >描述</a></th>					
					<th class="list_bg" >公钥</th>
					<th class="list_bg" >私钥</th>
					<th class="list_bg" >GLOBAL IP</th>
					<th class="list_bg" >私钥MD5</th>
					<th class="list_bg" >操作</th>
                  </TR>

            </tr>
			<form name="a" action="admin.php?controller=admin_pro&action=sshkey_delete" method="POST" >
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['sshdevices']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
			<tr  <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
				<td width="1%"><input type="checkbox" name="chk_member[]" value="<?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
"></td>	
				<td> <a href='admin.php?controller=admin_pro&action=sshkey&device_ip=<?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
'><?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sshkeyname'];?>
</a></td>
				<td> <a href='admin.php?controller=admin_pro&action=sshkey&hostname=<?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['hostname'];?>
'><?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['desc'];?>
</a></td>
				<td><?php if ($_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['public_key_file']) {?>已上传<?php } else { ?><font color='red'>未上传</font><?php }?></td>	
				<td><?php if ($_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['private_key_file']) {?>已上传<?php } else { ?><font color='red'>未上传</font><?php }?></td>
				<td><?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['globalip'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['md5sum'];?>
</td>
				<td> <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href='admin.php?controller=admin_pro&action=sshkey_edit&id=<?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'>编辑上传</a> | &nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/left_dot1.gif" width="16" height="16" align="absmiddle"><a href='admin.php?controller=admin_pro&action=sshkey_list&id=<?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'>绑定</a> | &nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif" width="16" height="16" align="absmiddle"><a href='admin.php?controller=admin_pro&action=sshkey_delete&id=<?php echo $_smarty_tpl->tpl_vars['sshdevices']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'>删除</a></td>
			</tr>
			<?php endfor; endif; ?>
			<tr>
	           <td  colspan="5" align="left">
				<input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除" onClick="my_confirm('<?php echo $_smarty_tpl->tpl_vars['language']->value['DeleteUsers'];?>
');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&action=delete_all'; else return false;" class="an_02">&nbsp;&nbsp;<input type="button" value="添加" onclick="document.location='admin.php?controller=admin_pro&action=sshkey_edit'"  class="an_02" />&nbsp;&nbsp;<input type="button" value="导入" onclick="document.location='admin.php?controller=admin_pro&action=sshkey_import'"  class="an_02" />&nbsp;&nbsp;<input type="button" value="查看所有key" onclick="document.location='admin.php?controller=admin_pro&action=sshkey_new'"  class="an_06" />&nbsp;&nbsp;&nbsp;<input type="button" value="同步" onclick="document.getElementById('hide').src='admin.php?controller=admin_pro&action=sshkey_sync'"  class="an_02" />
		   </td>
               
	           <td  colspan="5" align="right">
		   			共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
个记录  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=sshkey&page='+this.value;">页
		   </td>
		</tr>
			</form>
		</TBODY>
              </TABLE>	</td>
  </tr>
</table>

<?php echo '<script'; ?>
 language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('ldaptree').style.display='none';
<?php echo '</script'; ?>
>
</body>
<iframe id="hide" name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>