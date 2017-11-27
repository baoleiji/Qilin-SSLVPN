<?php /* Smarty version 3.1.27, created on 2017-01-01 13:03:53
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/member_edit_self.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:59199045258688db903ed30_95796385%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf57b9fa4714bb078ab533fac44971ea417695c9' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/member_edit_self.tpl',
      1 => 1483247030,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '59199045258688db903ed30_95796385',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'msg' => 0,
    'pwdshould' => 0,
    'member' => 0,
    'pwdremain' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58688db90ff8c6_06262029',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58688db90ff8c6_06262029')) {
function content_58688db90ff8c6_06262029 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '59199045258688db903ed30_95796385';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['language']->value['Master'];
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 language="javascript">
	function check_add_user(){
		return(true);
	}
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
	  <tr>
		<td class="">
			<form method="post" name="add_user" action="admin.php?controller=admin_member&action=save_self" enctype="multipart/form-data">
			 <input type="password" style="display:none"/> 	<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
<tr><th colspan="3" class="list_bg"></th></tr>
				<?php if ($_smarty_tpl->tpl_vars['msg']->value) {?>
					<tr bgcolor="red">
						<td>提示：</td>
						<td><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</td>
					</tr>
				<?php }?>
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%">原密码：</td>
						<td><input type="password" name="oripassword" class="input_shorttext"> <?php echo $_smarty_tpl->tpl_vars['pwdshould']->value;?>
</td>
					</tr>
					<tr>
						<td align="right" width="33%"><?php echo $_smarty_tpl->tpl_vars['language']->value['Password'];?>
：</td>
						<td><input type="password" name="password1" class="input_shorttext"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%"><?php echo $_smarty_tpl->tpl_vars['language']->value['Commitpassword'];?>
：</td>
						<td><input type="password" name="password2" class="input_shorttext"></td>
					</tr>
					<tr>
						<td align="right" width="33%"><?php echo $_smarty_tpl->tpl_vars['language']->value['Mailbox'];?>
：</td>
						<td><input type="text" name="email" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['member']->value['email'];?>
"></td>
					</tr>
					<tr>
						<td align="right" width="33%">密码有效期：</td>
						<td><?php echo $_smarty_tpl->tpl_vars['pwdremain']->value;?>
</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%">登录提示：</td>
						<td><input type="checkbox" name="login_tip" value="1" <?php if ($_smarty_tpl->tpl_vars['member']->value['login_tip']) {?>checked<?php }?>></td>
					</tr>
					
				 <tr>
						<td align="right" width="33%">显示目录：</td>
						<td><input type="checkbox" name="ldap" value="1" <?php if ($_smarty_tpl->tpl_vars['member']->value['ldap']) {?>checked<?php }?>></td>
					</tr>
                </TR>
				
				<tr bgcolor="f7f7f7">
						<td align="right" width="33%">客户端IP</td>
						<td><?php echo $_smarty_tpl->tpl_vars['member']->value['websourceip'];?>

						</td>
					</tr>
					<?php if ($_SESSION['ADMIN_LEVEL']) {?>
					<tr bgcolor="">
						<td align="right" width="33%">显示行数：</td>
						<td>
						<input type="text" name="rows" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['member']->value['rows'];?>
">
						</td>
					</tr>
					<?php }?>
					<tr >
						<td  align="center" colspan=2><input  type="submit" value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Commit'];?>
" class="an_02"></td>
					</tr>
				</table>
			</form>
			
		</td>
	  </tr>
	</table>
</body>
</html>


<?php }
}
?>