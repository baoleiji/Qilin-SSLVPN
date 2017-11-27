<?php /* Smarty version 3.1.27, created on 2017-09-25 23:39:00
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/certs.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:117809369959c92314bf2132_57141499%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '870a9f2741c5401d0a858ef31f7ceb678d302a97' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/certs.tpl',
      1 => 1503840689,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '117809369959c92314bf2132_57141499',
  'variables' => 
  array (
    'template_root' => 0,
    'Certificate' => 0,
    'orderby2' => 0,
    'ip' => 0,
    'dns' => 0,
    'command_num' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_59c92314c5fd18_69181652',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_59c92314c5fd18_69181652')) {
function content_59c92314c5fd18_69181652 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '117809369959c92314bf2132_57141499';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
</head>

<body>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=certificate_save">
<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>是否开启证书认证:</td>
		<td align=left>
		<select name="Certificate" id="Certificate" >
		<option value="0" <?php if ($_smarty_tpl->tpl_vars['Certificate']->value == 0) {?>selected<?php }?>>否</option>
		<option value="2" <?php if ($_smarty_tpl->tpl_vars['Certificate']->value == 2) {?>selected<?php }?>>是</option>
		</select>
		 </td>
		<td><input type="submit" onclick="return certificate();" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=loadbalance">
	
<tr>
				<th class="list_bg"  width="20%">IP／域名</th>
				<th class="list_bg"  width="20%"><a href="admin.php?controller=admin_config&action=loadbalance&orderby1=ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >类型</a></th>
				<th class="list_bg"  width="15%">操作</th>
			</tr>
			
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ip']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
				<td><?php echo $_smarty_tpl->tpl_vars['ip']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']];?>
</td>
				<td>IP地址</td>
				<td>
				<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_config&action=certs_edit&ip=<?php echo urlencode($_smarty_tpl->tpl_vars['ip']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]);?>
">编辑</a>
				 | <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_config&action=certs_del&ip=<?php echo urlencode($_smarty_tpl->tpl_vars['ip']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]);?>
">删除</a>
				</td>
			</tr>
			<?php endfor; endif; ?>

			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['m'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['m']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['name'] = 'm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['dns']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total']);
?>
			<tr <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['m']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
				<td><?php echo $_smarty_tpl->tpl_vars['dns']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']];?>
</td>
				<td>主机名</td>
				<td>
				<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_config&action=certs_edit&dns=<?php echo urlencode($_smarty_tpl->tpl_vars['dns']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]);?>
">编辑</a>
				 | <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_config&action=certs_del&dns=<?php echo urlencode($_smarty_tpl->tpl_vars['dns']->value[$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]);?>
">删除</a>
				</td>
			</tr>
			<?php endfor; endif; ?>
			
			<tr>
				<td colspan="2" align="center">
					<input type="button" onclick="window.location='admin.php?controller=admin_config&action=certs_edit'"  name="add" value="添&nbsp;&nbsp;加" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="document.getElementById('hide').src='admin.php?controller=admin_config&action=keyedit'"  name="add" value="服务器证书签名" class="an_06">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="if(confirm('<?php if ($_smarty_tpl->tpl_vars['Certificate']->value) {?>证书重置会复位删除所有用户证书，必须关闭证书认证后才能继续<?php } else { ?>证书重置会复位删除所有用户证书，并且重新生成根证书<?php }?>')) document.getElementById('hide').src='admin.php?controller=admin_config&action=certsreset';"  name="add" value="证书重置" class="an_02">
						
				</td><input type="hidden" name="ac" value="delete" />
			</form>
			<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=loadbalance">

				<td colspan="2" align="right">
					共<?php echo $_smarty_tpl->tpl_vars['command_num']->value;?>
执行命令  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_config&action=loadbalance&page='+this.value;">页
				
				</td>
				</form>
			
			</tr>
			
			

		</table>
	</td>
  </tr>
</table>

<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>



<?php }
}
?>