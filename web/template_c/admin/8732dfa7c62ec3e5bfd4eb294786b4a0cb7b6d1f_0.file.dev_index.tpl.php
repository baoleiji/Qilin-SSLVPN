<?php /* Smarty version 3.1.27, created on 2017-01-01 11:54:05
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/dev_index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:133611099958687d5d5db0f1_49922520%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8732dfa7c62ec3e5bfd4eb294786b4a0cb7b6d1f' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/dev_index.tpl',
      1 => 1483242839,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '133611099958687d5d5db0f1_49922520',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'orderby2' => 0,
    'gid' => 0,
    'alldev' => 0,
    'from' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
    'curr_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58687d5d77fea4_62687154',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58687d5d77fea4_62687154')) {
function content_58687d5d77fea4_62687154 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '133611099958687d5d5db0f1_49922520';
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
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/global.functions.js"><?php echo '</script'; ?>
>
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
<?php echo '<script'; ?>
>
function searchit(){
	document.f1.action = "admin.php?controller=admin_pro&action=dev_index";
	document.f1.action += "&ip="+document.f1.ip.value;
	document.f1.action += "&hostname="+encodeURIComponent(document.f1.hostname.value);
	return true;
}

function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}
<?php echo '</script'; ?>
>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
	<td class="" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_pro&action=dev_index' method=post>
					IP<input type="text" class="wbk" name="ip">
					主机名<input type="text" class="wbk" name="hostname">
					&nbsp;&nbsp;<input  type="submit" value=" 搜索 " onclick="return searchit();" class="bnnew2">&nbsp;&nbsp;显示空目录<input type="checkbox" id="showemptydir" name="showemptydir" onclick="window.parent.menu.window.showNodeCount0(this.checked)"  />&nbsp;&nbsp;&nbsp;&nbsp;目录截取<input type="checkbox" name="showemptydir" onclick="window.parent.menu.window.showLongTitle(this.checked)" checked />

					</form>
					</TD>
                  </TR>
				  </table></td></tr>
                  <TR><td>
				  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
				  <form name="member_list" action="admin.php?controller=admin_pro&action=dev_del" method="post">
				  <tr>
				  <th class="list_bg"  width="1%">选</th>
                    <th class="list_bg"  width="15%"><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">服务器地址</a></th>
                    <th class="list_bg" width="20%"><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=hostname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">主机名</a></th>
					
                    <th class="list_bg"  width="10%"><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=device_type&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">系统</a></th>
                    <th class="list_bg" width="20%"><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=groupid&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">设备组</a></th>
					<?php if ($_SESSION['CACTI_CONFIG_ON'] && $_SESSION['LICENSE_KEY_NETMANAGER']) {?>
					<th class="list_bg" width="10%">状态</th>
					<?php }?>
					<th class="list_bg"  width="">操作</TD>
                  </TR>
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
			<tr  <?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['ct'] > 0 || ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['asset_warrantdate'] != '0000-00-00 00:00:00' && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['warrantdays'] < 0)) {?>bgcolor="red" <?php } elseif (($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['asset_warrantdate'] != '0000-00-00 00:00:00' && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['warrantdays'] < 30)) {?>bgcolor="yellow"<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>   onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['ct'] > 0 || ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['asset_warrantdate'] != '0000-00-00 00:00:00' && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['warrantdays'] < 0)) {?>red<?php } elseif (($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['asset_warrantdate'] != '0000-00-00 00:00:00' && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['warrantdays'] < 30)) {?>yellow<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>');">
				<td><input type="checkbox" name="chk_member[]" value="<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
</td>
				<td><span  title="<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['hostname'];?>
" ><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['hostname'];?>
</span></td>
				
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_type'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['groupname'];?>
</td>
				<?php if ($_SESSION['CACTI_CONFIG_ON'] && $_SESSION['LICENSE_KEY_NETMANAGER']) {?>
				<td align=center><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/<?php if (!$_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['monitor']) {?>Gray.gif<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 1) {?>Green.gif<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 2) {?>GreenYellow.gif<?php } else { ?>Red.gif<?php }?>' style="cursor:hand;" onclick="window.open ('admin.php?controller=admin_detail&ip=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];
if (mb_strtolower($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_type'], 'UTF-8') == 'cisco') {?>&action=ciscoindex<?php }?>', 'newwindow', 'height=' + screen.height + ',width=' + screen.width+'top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" ></td>
				<?php }?>
				<td>
				
					<?php if ($_SESSION['ADMIN_LEVEL'] == 1 || $_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 4) {?><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=dev_edit&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'>修改</a>
					
					| <img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/left_dot1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=devpass_index&ip=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'>用户(<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['userct']) {
echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['userct'];
} else { ?>0<?php }?>)</a>
										
					<?php }?>
					<?php if ($_SESSION['ADMIN_LEVEL'] == 1 || $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101 || $_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 4) {?>
					
					| <img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_del&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
';}">删除</a>
					<?php }?>
					
				</td> 
			</tr>
			<?php endfor; endif; ?>
			
                <tr>

	           <td  colspan="4" align="left">
			  <input name="select_all" id="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.member_list.elements[i];if(e.name=='chk_member[]')e.checked=document.member_list.select_all.checked;}" value="checkbox">&nbsp;&nbsp; <?php if ($_SESSION['ADMIN_LEVEL'] == 1 || $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 4) {?>
			   <input type="button"  value="添加" onClick="location.href='admin.php?controller=admin_pro&action=dev_edit&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'" class="an_02">
			   &nbsp;&nbsp;<input type="button"  value="批量添加" onClick="location.href='admin.php?controller=admin_pro&action=devbatchadd&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'" class="an_02">
			   &nbsp;&nbsp;<input type="submit"  value="批量删除" onClick="return my_confirm('删除所选');" class="an_02">
			   &nbsp;&nbsp;<input type="submit"  value="批量修改" onClick="document.member_list.action='admin.php?controller=admin_pro&action=batchserverpriorityedit&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
';" class="an_02">
			   &nbsp;&nbsp;<input type="button"  value="导入" onClick="location.href='admin.php?controller=admin_pro&action=devimport&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'" class="an_02">		
				<?php if ($_smarty_tpl->tpl_vars['gid']->value) {?>
				<?php if ($_SESSION['ADMIN_LEVEL'] != 3 && $_SESSION['ADMIN_LEVEL'] != 21 && $_SESSION['ADMIN_LEVEL'] != 101) {?>
				&nbsp;&nbsp;
				
				<input type="button"  value="添加已有资源" onClick="location.href='admin.php?controller=admin_pro&action=groupadddev&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&from=<?php echo $_smarty_tpl->tpl_vars['from']->value;?>
'" class="an_06">
				<?php }?>
				<?php }?>
				<?php }?>
				<input  type="button"  value="导出" onClick="export1()" class="an_02">		
			   &nbsp;&nbsp;<input type="button"  value="自动发现" onClick="window.open('admin.php?controller=admin_pro&action=autofind')" class="an_02">				
		   </td>

		    <td  colspan="3" align="right">
		   			&nbsp&nbsp;&nbsp;共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
个记录  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&page='+this.value;">页&nbsp;&nbsp;&nbsp;
		   </td>
                </tr>
            </form>
		</TBODY>
              </TABLE>
	</td>
  </tr>
</table>

<?php echo '<script'; ?>
 language="javascript">

window.parent.menu.window.showNodeCount0(false);
window.parent.menu.window.showLongTitle(true);

function export1(){
	var t = new Date().getTime();
	document.getElementById('hide').src='<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&derive=3&'+t;
}
function my_confirm(str){
	if(!confirm(str + "？"))
	{
		return false;
	}
	return true;
}
window.parent.menu.document.getElementById('_tree').style.display='';
window.parent.menu.document.getElementById('devtree').style.display='';
window.parent.menu.document.getElementById('mtree').style.display='none';
window.parent.menu.cururl='devtree';
<?php echo '</script'; ?>
>
</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>