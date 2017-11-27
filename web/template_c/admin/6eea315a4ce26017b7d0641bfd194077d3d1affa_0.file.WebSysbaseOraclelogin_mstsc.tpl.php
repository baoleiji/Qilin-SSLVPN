<?php /* Smarty version 3.1.27, created on 2016-12-14 22:50:53
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/WebSysbaseOraclelogin_mstsc.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:69312976558515c4dd148a9_19320255%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6eea315a4ce26017b7d0641bfd194077d3d1affa' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/WebSysbaseOraclelogin_mstsc.tpl',
      1 => 1481167480,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69312976558515c4dd148a9_19320255',
  'variables' => 
  array (
    'autorun' => 0,
    'host' => 0,
    'port' => 0,
    'username' => 0,
    'password' => 0,
    'path' => 0,
    'param' => 0,
    'member' => 0,
    'rdpclientversion' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58515c4dd53b90_47932728',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58515c4dd53b90_47932728')) {
function content_58515c4dd53b90_47932728 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '69312976558515c4dd148a9_19320255';
?>
freesvr://\"&action=StartMstscAutoRun&autorun=<?php echo $_smarty_tpl->tpl_vars['autorun']->value;?>
&host=<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
&port=<?php echo $_smarty_tpl->tpl_vars['port']->value;?>
&username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;?>
&path=<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
&param=<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
&&debug=<?php echo $_SESSION['ADMIN_FREESVRDEBUG'];?>
&sshport=<?php echo $_smarty_tpl->tpl_vars['member']->value['sshport'];?>
&rdpport=<?php echo $_smarty_tpl->tpl_vars['member']->value['rdpport'];?>
&rdpclientversion=<?php echo $_smarty_tpl->tpl_vars['rdpclientversion']->value;?>
&\"


<?php }
}
?>