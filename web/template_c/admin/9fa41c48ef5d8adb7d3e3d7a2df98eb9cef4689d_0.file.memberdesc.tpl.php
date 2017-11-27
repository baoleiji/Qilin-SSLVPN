<?php /* Smarty version 3.1.27, created on 2017-01-01 11:50:07
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/memberdesc.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:183099798658687c6f965656_70863561%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9fa41c48ef5d8adb7d3e3d7a2df98eb9cef4689d' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/memberdesc.tpl',
      1 => 1483242602,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183099798658687c6f965656_70863561',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'uid' => 0,
    'orderby2' => 0,
    's' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58687c6fb02d92_49405455',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58687c6fb02d92_49405455')) {
function content_58687c6fb02d92_49405455 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '183099798658687c6f965656_70863561';
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
</ul><span class="back_img"><A href="admin.php?controller=admin_member&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>


  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_member&action=memberdesc_delete&uid=<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
" method="post">
                <TBODY>
                  <TR>
			
                    <th class="list_bg" width="5%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=id&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >选</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=membername&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >用户名</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=optime&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >时间</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=action&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >动作</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=prideptid&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >过去部门</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=curdeptid&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >现在部门</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=pripostid&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >过去职位</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=curpostid&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >现在职位</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=desc&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >描述</a></TD>
					<th class="list_bg" width="10%">操作</TD>
                  </TR>

            </tr>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['s']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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

				<td width="5%"><input type="checkbox" name="chk_gid[]" value="<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
"></td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['membername'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['optime'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['action'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['prideptname'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['curdeptname'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pripostname'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['curpostname'];?>
</td>
				  <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['desc'];?>
</td>
				<td style="TEXT-ALIGN: left;"><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=memberdesc_edit&id=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" >编辑</a>
				</td> 
			</tr>
			<?php endfor; endif; ?>
	          <tr>
	           <td  colspan="5" align="left">
		          <input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_gid[]')e.checked=this.form.select_all.checked;}" value="checkbox">全选&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除所选');if(chk_form()) document.ip_list.action='admin.php?controller=admin_member&action=memberdesc_delete'; else return false;" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp; 
					<input type="button" name="submit" onclick="location='admin.php?controller=admin_member&action=memberdesc_edit&uid=<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
'" value=" 增加 " class="an_02" />
		   		</td>
				<td  colspan="5" align="right">
		   			共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
个记录  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&action=memberdesc&page='+this.value;">页
		   </td>
		   		</tr>
	           
		</TBODY>
              </TABLE></form>	</td>
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

<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>