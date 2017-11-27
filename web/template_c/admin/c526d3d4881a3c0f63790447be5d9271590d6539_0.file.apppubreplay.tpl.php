<?php /* Smarty version 3.1.27, created on 2016-12-14 22:56:54
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/apppubreplay.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:141949292958515db6ef1b10_64800793%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c526d3d4881a3c0f63790447be5d9271590d6539' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/apppubreplay.tpl',
      1 => 1474793223,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '141949292958515db6ef1b10_64800793',
  'variables' => 
  array (
    'autorun' => 0,
    'host' => 0,
    'port' => 0,
    'username' => 0,
    'password' => 0,
    'path' => 0,
    'param' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58515db6f355c4_40421888',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58515db6f355c4_40421888')) {
function content_58515db6f355c4_40421888 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '141949292958515db6ef1b10_64800793';
?>
freesvr://"&action=StartMstscAutoRunReplay&autorun=<?php echo $_smarty_tpl->tpl_vars['autorun']->value;?>
&host=<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
&port=<?php echo $_smarty_tpl->tpl_vars['port']->value;?>
&username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;?>
&path=<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
&param=<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
&debug=<?php echo $_SESSION['ADMIN_FREESVRDEBUG'];?>
&"<?php }
}
?>