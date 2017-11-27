<?php /* Smarty version 3.1.27, created on 2017-09-24 16:42:45
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/tools_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:139429494259c770054e4bc9_46306271%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09f7033e5d0a73d78638cdc81feec156f33912b2' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/tools_list.tpl',
      1 => 1483239516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '139429494259c770054e4bc9_46306271',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'usbkeyshow' => 0,
    'language' => 0,
    'allTools' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_59c7700554ad15_51198586',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_59c7700554ad15_51198586')) {
function content_59c7700554ad15_51198586 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '139429494259c770054e4bc9_46306271';
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

	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=tool_list">工具下载</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
  <?php if ($_smarty_tpl->tpl_vars['usbkeyshow']->value == 1) {?>
  <tr>
  	<td class="">
  	
  		<a href="admin.php?controller=admin_index&action=download_usbkeyfile" >口令证书下载</a>
  	
  	</td>
  </tr>
  <?php }?>
  <tr>
	<td class=""><TABLE border=0 cellSpacing=1 cellPadding=5 
                                width="100%" bgColor=#ffffff valign="top" class="BBtable">

                <TBODY>
                  <TR>

					<th class="list_bg" ><?php echo $_smarty_tpl->tpl_vars['language']->value['ToolsName'];?>
</TD>
					<th class="list_bg" ><?php echo $_smarty_tpl->tpl_vars['language']->value['Operate'];?>
</TD>
                  </TR>

            </tr>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allTools']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
 <td> <?php echo $_smarty_tpl->tpl_vars['allTools']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['name'];?>
</td>
				<td>									
				<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/down.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_index&action=tool_down&name=<?php echo urlencode($_smarty_tpl->tpl_vars['allTools']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['name']);?>
'><?php echo $_smarty_tpl->tpl_vars['language']->value['Download'];?>
</a><?php if ($_SESSION['ADMIN_USERNAME'] == 'admin') {?> | <img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_index&action=tool_delete&name=<?php echo urlencode($_smarty_tpl->tpl_vars['allTools']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['name']);?>
'>删除</a><?php }?>
				</td> 
			</tr>
			<?php endfor; endif; ?>
<tr><td  align="left"><?php if ($_SESSION['ADMIN_USERNAME'] == 'admin') {?><input type="button" onclick="window.location='admin.php?controller=admin_index&action=upload_tool'"  name="add" value="上传文件" class="an_02"><?php }?></td>
		<td  colspan="5" align="right">
			<?php echo $_smarty_tpl->tpl_vars['language']->value['all'];
echo $_smarty_tpl->tpl_vars['total']->value;
echo $_smarty_tpl->tpl_vars['language']->value['Recorder'];?>
  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Page'];?>
：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;
echo $_smarty_tpl->tpl_vars['language']->value['Recorder'];?>
/<?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Goto'];?>
<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&action=keys_index&page='+this.value;"><?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
		</TBODY>
              </TABLE>

	</td>
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