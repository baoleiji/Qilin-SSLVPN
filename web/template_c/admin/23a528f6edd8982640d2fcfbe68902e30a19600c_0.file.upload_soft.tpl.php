<?php /* Smarty version 3.1.27, created on 2017-09-24 16:42:53
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/upload_soft.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:75446296859c7700d1cd020_62575454%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23a528f6edd8982640d2fcfbe68902e30a19600c' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/upload_soft.tpl',
      1 => 1483239516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '75446296859c7700d1cd020_62575454',
  'variables' => 
  array (
    'site_title' => 0,
    'template_root' => 0,
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_59c7700d201055_26064066',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_59c7700d201055_26064066')) {
function content_59c7700d201055_26064066 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '75446296859c7700d1cd020_62575454';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['site_title']->value;?>
</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
>
function resto()
{
 if(document.getElementById('filesql').value=='' ){
   alert("<?php echo $_smarty_tpl->tpl_vars['language']->value['UploadFile'];?>
");
   return false;
  }
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
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=tool_list">工具下载</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_index&action=tool_list&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%"  class="BBtable">
		 <tr><th colspan="3" class="list_bg"></th></tr>
		<tr><td>
			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_index&action=upload_tool" method="post">
			<div align="center">文件：<input name="key" id="filesql" type="file" /></div>
			<div align="center"><input name="submit" type="submit" onclick="return resto();"  value="提交" / class="an_02"></div>
			<input type="hidden" name="ac" value="upload" />
			</form></td></tr>
		</table>
	</td>
  </tr>
</table>
</body>
</html>


<?php }
}
?>