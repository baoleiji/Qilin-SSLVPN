<?php /* Smarty version 3.1.27, created on 2016-12-08 14:03:17
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/cronreport.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:10361911965848f7a53420d1_25921912%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf08c43101bdc82895b3b53d60867a85a16c7c6e' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/cronreport.tpl',
      1 => 1481176994,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10361911965848f7a53420d1_25921912',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'orderby2' => 0,
    'alllog' => 0,
    'alldev' => 0,
    'serverid' => 0,
    'log_num' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
    'curr_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5848f7a53b5ae9_83352656',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5848f7a53b5ae9_83352656')) {
function content_5848f7a53b5ae9_83352656 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '10361911965848f7a53420d1_25921912';
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
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/border-radius.css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/cn.js"><?php echo '</script'; ?>
>
</head>
<?php echo '<script'; ?>
 type="text/javascript">
function searchit(){
	document.search.action = "admin.php?controller=admin_reports&action=configreport";
	document.search.action += "&template="+document.search.template.options[document.search.template.options.selectedIndex].value;
	document.search.action += "&subject="+document.search.subject.value;
	document.search.action += "&f_rangeStart="+document.search.f_rangeStart.value;
	document.search.action += "&f_rangeEnd="+document.search.f_rangeEnd.value;
	document.search.submit();
	//alert(document.search.action);
	//return false;
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
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=configreport">报表配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	 <li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cronreports">报表自动生成配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	 <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=downloadcronreport">下载报表</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
 
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		 <form name="member_list" action="admin.php?controller=admin_reports&action=cronreport_del" method="post" >
					<tr>
					<th class="list_bg"  bgcolor="d9ecfa" width="3%">选</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="8%"><a href="admin.php?controller=admin_reports&action=cronreport&orderby1=subject&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >报表模板</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="8%"><a href="admin.php?controller=admin_reports&action=cronreport&orderby1=applytime&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >时间</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="20%">操作</th>
					</tr>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alllog']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
						<td><input type="checkbox" name="chk_member[]" value="<?php echo $_smarty_tpl->tpl_vars['alllog']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
"></td>
						<td><a href="admin.php?controller=admin_reports&action=configreport&subject=<?php echo $_smarty_tpl->tpl_vars['alllog']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['template'];?>
"><?php echo $_smarty_tpl->tpl_vars['alllog']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['template'];?>
</a></td>
						<td><a href="admin.php?controller=admin_reports&action=configreport&createtime=<?php echo $_smarty_tpl->tpl_vars['alllog']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['applytime'];?>
"><?php echo $_smarty_tpl->tpl_vars['alllog']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['applytime'];?>
</a></td>					
						<td>
						<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_reports&action=cronreport_edit&id=<?php echo $_smarty_tpl->tpl_vars['alllog']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['language']->value['Edit'];?>
</a>

						| <img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_reports&action=cronreport_del&id=<?php echo $_smarty_tpl->tpl_vars['alllog']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'>删除</a>
						
						</td>
					</tr>
					<?php endfor; endif; ?>
					<tr>
					<td colspan="3" align="left"><input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除选中的');if(chk_form()) document.member_list.action='admin.php?controller=admin_pro&action=devpass_del&ip=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[0]['device_ip'];?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
'; else return false;" class="an_02">&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.location='admin.php?controller=admin_reports&action=cronreport_edit'"  value=" 添加 "  class="an_02">
					</td>
					<td colspan="12" align="right">
						<?php echo $_smarty_tpl->tpl_vars['language']->value['all'];
echo $_smarty_tpl->tpl_vars['log_num']->value;
echo $_smarty_tpl->tpl_vars['language']->value['item'];
echo $_smarty_tpl->tpl_vars['language']->value['Log'];?>
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
<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&page='+this.value;"><?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>

					</td>
					</tr>
				</form>
				</table>
	</td>
  </tr>
</table>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


<?php }
}
?>