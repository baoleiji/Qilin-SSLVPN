<?php /* Smarty version 3.1.27, created on 2016-12-12 17:37:25
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/appdevice_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1117879734584e6fd51eb688_55288761%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bd1d4eca3b56808bc036f80bf07cdb10ff1b1dd4' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/appdevice_edit.tpl',
      1 => 1474793223,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1117879734584e6fd51eb688_55288761',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'apppubs' => 0,
    'appprogram' => 0,
    'servers' => 0,
    'allmem' => 0,
    'apppubid' => 0,
    'appserverip' => 0,
    '_config' => 0,
    'alluser' => 0,
    'allserver' => 0,
    'from' => 0,
    'fromapp' => 0,
    'webuser' => 0,
    'webgroup' => 0,
    'trnumber' => 0,
    'pp' => 0,
    'p' => 0,
    'language' => 0,
    'appserverips' => 0,
    's' => 0,
    'usergroup' => 0,
    'sessionlgroup' => 0,
    'sessionluser' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_584e6fd53f6b11_43347948',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_584e6fd53f6b11_43347948')) {
function content_584e6fd53f6b11_43347948 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1117879734584e6fd51eb688_55288761';
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
 src="./template/admin/cssjs/global.functions.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/_ajaxdtree.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/dtree.css" rel="stylesheet" type="text/css" />
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
 <SCRIPT language=javascript src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/selectdate.js"></SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/date";
var apppub = new Array();
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ap'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['name'] = 'ap';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['apppubs']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ap']['total']);
?>
apppub[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index'];?>
] = new Array();
apppub[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index'];?>
]['ip'] = '<?php echo $_smarty_tpl->tpl_vars['apppubs']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['ip'];?>
';
apppub[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index'];?>
]['apps']=new Array();
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ap2'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['name'] = 'ap2';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['apppubs']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['apps']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ap2']['total']);
?>
apppub[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index'];?>
]['apps'][<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap2']['index'];?>
]=new Array();
apppub[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index'];?>
]['apps'][<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap2']['index'];?>
]['id']='<?php echo $_smarty_tpl->tpl_vars['apppubs']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['apps'][$_smarty_tpl->getVariable('smarty')->value['section']['ap2']['index']]['id'];?>
';
apppub[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index'];?>
]['apps'][<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap2']['index'];?>
]['name']='<?php echo $_smarty_tpl->tpl_vars['apppubs']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['apps'][$_smarty_tpl->getVariable('smarty')->value['section']['ap2']['index']]['name'];?>
';
apppub[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap']['index'];?>
]['apps'][<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['ap2']['index'];?>
]['url']='<?php echo $_smarty_tpl->tpl_vars['apppubs']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ap']['index']]['apps'][$_smarty_tpl->getVariable('smarty')->value['section']['ap2']['index']]['url'];?>
';

<?php endfor; endif; ?>
<?php endfor; endif; ?>

</SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/date";
var appprogram = new Array();
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pp'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['name'] = 'pp';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['appprogram']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total']);
?>
appprogram[<?php echo $_smarty_tpl->tpl_vars['appprogram']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['id'];?>
]='<?php echo addslashes($_smarty_tpl->tpl_vars['appprogram']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['path']);?>
';
<?php endfor; endif; ?>
function setappaddress(value){
	var name = document.getElementById('autologinflag').options[document.getElementById('autologinflag').options.selectedIndex].text.toLowerCase();
	document.getElementById('url').style.display='';
	document.getElementById('troracle_auth').style.display='none';
	document.getElementById('entrust_password_tr').style.display='';
	document.getElementById('oracle_name_tr').style.display='none';		
	if(name=='ie'||name=='ie6'||name=='ie7'||name=='ie8'||name=='ie9'||name=='ie10'||name=='ie11'||appprogram[value].indexOf('iexplore.exe')>0){
		document.getElementById('url').style.display='';
		document.getElementById('entrust_password_tr').style.display='';
	}else if(name=='toad' || name=='plsql'){
		document.getElementById('troracle_auth').style.display='';
		if(name=='plsql'){		
			document.getElementById('entrust_password_tr').style.display='';
			document.getElementById('oracle_name_tr').style.display='';		
		}
	}
	window.parent.reinitIframe();
	document.getElementById('path').value=appprogram[value];
	document.getElementById('path').readonly=true;

}

var AllServers = new Array();
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['name'] = 'kk';
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['servers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total']);
?>
AllServers[i++]='<?php echo $_smarty_tpl->tpl_vars['servers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['device_ip'];?>
';
<?php endfor; endif; ?>
var AllMember = new Array();
i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['name'] = 'kk';
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total']);
?>
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
] = new Array();
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['username']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['username'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['realname']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['realname'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['uid']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['uid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['groupid']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['groupid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['check']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['check'];?>
';
<?php endfor; endif; ?>
function filter(){
	var filterStr = document.getElementById('filtertext').value;
	var appserver = document.getElementById('device_ip');
	appserver.options.length=1;
	for(var i=0; i<AllServers.length;i++){
		if(filterStr.length==0 || AllServers[i].indexOf(filterStr) >= 0){
			appserver.options[appserver.options.length++] = new Option(AllServers[i],AllServers[i]);
		}
	}
}

function searchit(){
	var url = "admin.php?controller=admin_config&action=apppub_edit&&id=<?php echo $_smarty_tpl->tpl_vars['apppubid']->value;?>
&appserverip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
";
	url += "&webuser="+document.f1.elements.webuser.value;
	url += "&webgroup="+document.f1.elements.webgroup.value;
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['TREEMODE']) {?>
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	<?php } else { ?>
	for(var i=1; true; i++){
		var obj=document.getElementById('groupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	<?php }?>
	url += "&groupid="+gid;
	<?php }?>
	window.location=url;
	return false;
}
</SCRIPT>

<?php echo '<script'; ?>
>

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var allserver = new Array();

var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['au'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['au']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['name'] = 'au';
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alluser']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['au']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['au']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['au']['total']);
?>
alluser[i++]={uid:<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['uid'];?>
,username:'<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['username'];?>
',realname:'<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['realname'];?>
',groupid:<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['groupid'];?>
,level:<?php echo $_smarty_tpl->tpl_vars['alluser']->value[$_smarty_tpl->getVariable('smarty')->value['section']['au']['index']]['level'];?>
};
<?php endfor; endif; ?>
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['as'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['as']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['name'] = 'as';
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allserver']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['as']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['as']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['as']['total']);
?>
allserver[i++]={hostname:'<?php echo $_smarty_tpl->tpl_vars['allserver']->value[$_smarty_tpl->getVariable('smarty')->value['section']['as']['index']]['hostname'];?>
',device_ip:'<?php echo $_smarty_tpl->tpl_vars['allserver']->value[$_smarty_tpl->getVariable('smarty')->value['section']['as']['index']]['device_ip'];?>
',groupid:<?php echo $_smarty_tpl->tpl_vars['allserver']->value[$_smarty_tpl->getVariable('smarty')->value['section']['as']['index']]['groupid'];?>
};
<?php endfor; endif; ?>

<?php echo '</script'; ?>
>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<?php if ($_GET['device_ip'] == '') {?>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appserver_list">应用发布</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php if ($_SESSION['ADMIN_LEVEL'] != 3) {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appprogram_list">应用程序</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appicon_list">应用图标</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
	<?php } else { ?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php if ($_smarty_tpl->tpl_vars['from']->value == 'dir') {?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php } else { ?>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['from']->value == 'dir') {?>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<?php } else { ?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<?php }?>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
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
	<?php }?>
</ul><span class="back_img"><A href="admin.php?controller=<?php if ($_smarty_tpl->tpl_vars['fromapp']->value == 'search') {?>admin_pro&action=app_priority_search<?php } else { ?>admin_config&action=apppub_list<?php if ($_GET['device_ip'] == '') {?>&ip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;
}?>&device_ip=<?php echo $_GET['device_ip'];
}?>&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" >
	
          <tr>
            <td align="center">
    <form name="f1" method=post action="admin.php?controller=admin_config&action=apppub_save&id=<?php echo $_smarty_tpl->tpl_vars['apppubid']->value;?>
&appserverip=<?php echo $_smarty_tpl->tpl_vars['appserverip']->value;?>
&device_ip=<?php echo $_GET['device_ip'];?>
">
<input type="password" name="hiddenpassword" id="hiddenpassword" style="display:none"/>	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<TR>
	<td></td>
	<TD colspan="1" align="left">
	
		<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
    运维用户<input type="text" class="wbk" name="webuser" value="<?php echo $_smarty_tpl->tpl_vars['webuser']->value;?>
">
	资源组<input type="text" class="wbk" name="webgroup" value="<?php echo $_smarty_tpl->tpl_vars['webgroup']->value;?>
">
	&nbsp;&nbsp;<input  type="button" value=" 搜索 " onclick="searchit();" class="bnnew2">
	</TD>
  </TR>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>应用名称</td>
		<td><input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['pp']->value['name'];?>
" /></td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>用户名</td>
		<td><input type="text" name="username" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['username'];?>
" /></td>
	</tr>
	
		<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>密码</td>
		<td><input type="password" name="password" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['cur_password'];?>
" /></td>
	  </tr>
	   <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>确认密码</td>
		<td><input type="password" name="repassword" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['cur_password'];?>
" /></td>
	  </tr>
	 
	   <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	  <tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>服务器列表</td>
		<td>
		<input type="text" class="wbk" size="10" id="filtertext" onChange="filter();" />
                  <select  class="wbk"  name="device_ip" id="device_ip">
						<?php if ($_GET['device_ip'] == '') {?>
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['nobind'];?>
</OPTION>
					  <?php }?>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['servers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total']);
?>
							<?php if (($_GET['device_ip'] != '' && $_GET['device_ip'] == $_smarty_tpl->tpl_vars['servers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['device_ip']) || $_GET['device_ip'] == '') {?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['servers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['device_ip'];?>
" <?php if ($_smarty_tpl->tpl_vars['servers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['device_ip'] == $_smarty_tpl->tpl_vars['p']->value['device_ip']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['servers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['device_ip'];?>
</option>
							<?php }?>
						<?php endfor; endif; ?>
                  </SELECT>
		</td>
	</tr>
	<?php if ($_smarty_tpl->tpl_vars['appserverip']->value == '') {?>
	 <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	  <tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>应用发布服务器</td>
		<td>
		  <select  class="wbk"  name="appserverip" id="appserverip">
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ka'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ka']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['name'] = 'ka';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['appserverips']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ka']['total']);
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['appserverips']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ka']['index']]['appserverip'];?>
" <?php if ($_smarty_tpl->tpl_vars['appserverips']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ka']['index']]['appserverip'] == $_smarty_tpl->tpl_vars['s']->value['appserverip']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['appserverips']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ka']['index']]['appserverip'];?>
</option>
				<?php endfor; endif; ?>
		  </SELECT>
		</td>
	</tr>
	<?php }?>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	  <tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>程序列表</td>
		<td>
			<select  class="wbk" id="autologinflag"  onchange="setappaddress(this.value)" name="autologinflag" >
			<option value="" >请选择</option>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['p'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['p']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['name'] = 'p';
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['appprogram']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total']);
?>
			<option value="<?php echo $_smarty_tpl->tpl_vars['appprogram']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p']['index']]['id'];?>
" id="program_<?php echo $_smarty_tpl->tpl_vars['appprogram']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p']['index']]['name'];?>
" <?php if ($_smarty_tpl->tpl_vars['pp']->value['appprogramname'] == $_smarty_tpl->tpl_vars['appprogram']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p']['index']]['name']) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['appprogram']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p']['index']]['name'];?>
 </option>
			<?php endfor; endif; ?>
			</select>
		</td>
	  </tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="troracle_auth"  style="display:none">
		<td width="10%" align=right>ORACLE认证</td>
		<td>
			<select  class="wbk" id="oracle_auth"  name="oracle_auth" >
			<option value="Normal" <?php if ($_smarty_tpl->tpl_vars['p']->value['oracle_auth'] == 'Normal') {?>selected<?php }?>>Normal</option>
			<option value="SYSDBA" <?php if ($_smarty_tpl->tpl_vars['p']->value['oracle_auth'] == 'SYSDBA') {?>selected<?php }?>>SYSDBA</option>
			<option value="SYSOPER" <?php if ($_smarty_tpl->tpl_vars['p']->value['oracle_auth'] == 'SYSOPER') {?>selected<?php }?>>SYSOPER</option>
			</select>
		</td>
	  </tr>
		<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>程序地址</td>
		<td><input type="text" size="100" id="path" name="path" value="<?php echo $_smarty_tpl->tpl_vars['pp']->value['path'];?>
" /></td>
	  </tr>
	   <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="url" >
		<td width="10%" align=right>URL</td>
		<td><input type="text" size="100" name="url" value="<?php echo $_smarty_tpl->tpl_vars['pp']->value['url'];?>
" /></td>
	  </tr>
	   <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="entrust_password_tr" >
		<td width="10%" align=right>自动登录</td>
		<td><input type="checkbox" name="entrust_password" value="1" <?php if (!$_smarty_tpl->tpl_vars['apppubid']->value || $_smarty_tpl->tpl_vars['p']->value['entrust_password']) {?>checked<?php }?> /></td>
	  </tr>
	   <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="oracle_name_tr" style="display:none">
		<td width="10%" align=right>实例名称</td>
		<td><input type="text" size="30" name="oracle_name" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['oracle_name'];?>
" /></td>
	  </tr>
	  <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>描述</td>
		<td><textarea name="description" cols="50" rows="5"><?php echo $_smarty_tpl->tpl_vars['pp']->value['description'];?>
</textarea></td>
	  </tr>
	   <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	  <tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>是否允许密码自动修改</td>
		<td><input type="checkbox" name="change_password" value="1" <?php if ($_smarty_tpl->tpl_vars['p']->value['change_password']) {?>checked<?php }?> /></td>
	</tr>
	  <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	  <tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right>激活</td>
		<td><input type="checkbox" name="enable" value="1" <?php if ($_smarty_tpl->tpl_vars['p']->value['enable']) {?>checked<?php }?> /></td>
	</tr>
	  <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
	  <td width="10%" align="right"  valign=top>绑定分组
	  <table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' <?php if ($_GET['bindgroup'] == 1) {?>checked<?php }?> onclick="reload('bindgroup=1','bindgroup=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' <?php if ($_GET['bindgroup'] == 2) {?>checked<?php }?> onclick="reload('bindgroup=2','bindgroup=0',this.checked);"></td></tr>
	  </table></td>
	  <td >
	  <table><tr >
	  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['u'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['u']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['name'] = 'u';
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['usergroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total']);
?>
	  <?php if (!$_GET['bindgroup'] || ($_GET['bindgroup'] == 2 && $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['check'] == '') || ($_GET['bindgroup'] == 1 && $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['check'] == 'checked')) {?>
		<td width="180"><input type="checkbox" name='group[]' value='<?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['id'];?>
'  <?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['check'];?>
><?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['groupname'];?>
</td><?php if (($_smarty_tpl->getVariable('smarty')->value['section']['u']['index']+1)%5 == 0) {?></tr><tr><?php }?>
		<?php }?>
		<?php endfor; endif; ?>
	</tr></table>
	  </td>
	  </tr>
	 
<td></td><td></td></tr>
		 <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="10%" align=right  valign=top>
		绑定用户
		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' <?php if ($_GET['binduser'] == 1) {?>checked<?php }?> value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' <?php if ($_GET['binduser'] == 2) {?>checked<?php }?> value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll(this.checked);"></td></tr>
	  </table>
		</td>
		<td>
		<table><tr >
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['g'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['g']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['name'] = 'g';
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total']);
?>
		<?php if (!$_GET['binduser'] || ($_GET['binduser'] == 2 && $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'] == '') || ($_GET['binduser'] == 1 && $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'] == 'checked')) {?>
		<td width="180"><input type="checkbox" name='member[]' id="uid_<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
" value='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
'  <?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'];?>
><?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['username'];?>
(<?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname']) {
echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname'];
} else { ?>未设置<?php }?>)</td><?php if (($_smarty_tpl->getVariable('smarty')->value['section']['g']['index']+1)%5 == 0) {?></tr><tr><?php }?>
		<?php }?>
		<?php endfor; endif; ?>
		</tr></table>
	  </td>
	  </tr>
	 
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
					<td></td><td><input type="hidden" name="ac" value="new" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
" />
<input type=submit  value="保存修改" class="an_02"></td></tr>
	</table>
<br>
<input type="hidden" name="sessionlgroup" value="<?php echo $_smarty_tpl->tpl_vars['sessionlgroup']->value;?>
" />
<input type="hidden" name="sessionluser" value="<?php echo $_smarty_tpl->tpl_vars['sessionluser']->value;?>
" />
</form>
	</td>
  </tr>
</table>
<?php echo '<script'; ?>
>
function checkAll(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,6)=='member'){
			targets[j].checked=c;
		}
	}
}
function reload(p1,p2,check){
	window.location=window.location+'&'+(check ? p1 : p2);
}
/*if(document.getElementById('program_IE').selected||(document.getElementById('program_IE6')!=undefined&&document.getElementById('program_IE6').selected)||(document.getElementById('program_IE7')!=undefined&&document.getElementById('program_IE7').selected)||(document.getElementById('program_IE8')!=undefined&&document.getElementById('program_IE8').selected)||(document.getElementById('program_IE9')!=undefined&&document.getElementById('program_IE9').selected)||(document.getElementById('program_IE10')!=undefined&&document.getElementById('program_IE10').selected)||(document.getElementById('program_IE11')!=undefined&&document.getElementById('program_IE11').selected)){
	document.getElementById('url').style.display='';
}*/
var appid = document.getElementById('autologinflag').options[document.getElementById('autologinflag').options.selectedIndex].value;
if(/^[0-9]+$/.test(appid)&&appprogram[appid].indexOf('iexplore.exe')>0){
	document.getElementById('url').style.display='';
}
if((document.getElementById('program_TOAD')!=undefined&&document.getElementById('program_TOAD').selected) || (document.getElementById('program_PLSQL')!=undefined&&document.getElementById('program_PLSQL').selected) ){
	document.getElementById('troracle_auth').style.display='';
	if(document.getElementById('program_PLSQL').selected){
		document.getElementById('entrust_password_tr').style.display='';
		document.getElementById('oracle_name_tr').style.display='';		
	}
	window.parent.reinitIframe();
}
if(document.getElementById('program_IE')!=undefined&&document.getElementById('program_IE').selected){
	document.getElementById('entrust_password_tr').style.display='';
	window.parent.reinitIframe();
}
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>

<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>
<?php echo '</script'; ?>
>
</body>

<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html><?php }
}
?>