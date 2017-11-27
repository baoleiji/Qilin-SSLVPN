<?php /* Smarty version 3.1.27, created on 2017-05-16 12:54:34
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/devgroup_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1183207742591a860a9acb85_69008764%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c08ea06d1752f714e253959d8b5cf17894100c3d' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/devgroup_edit.tpl',
      1 => 1483243361,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1183207742591a860a9acb85_69008764',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'allsgroup' => 0,
    'sgroup' => 0,
    'ldapid' => 0,
    'loadbalances' => 0,
    'ldapid1' => 0,
    'ldapid2' => 0,
    'ldapid3' => 0,
    'ldapid4' => 0,
    'ldapid5' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_591a860aa1a902_64618436',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_591a860aa1a902_64618436')) {
function content_591a860aa1a902_64618436 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1183207742591a860a9acb85_69008764';
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
<?php echo '<script'; ?>
>
var servergroup = new Array();
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['a'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['a']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['name'] = 'a';
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allsgroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total']);
?>
<?php if ($_smarty_tpl->tpl_vars['sgroup']->value['id'] != $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['id']) {?>
servergroup[i++]={id:<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['id'];?>
,name:'<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['groupname'];?>
',ldapid:<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['ldapid'];?>
,level:<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['level'];?>
};
<?php }?>
<?php endfor; endif; ?>
<?php echo '</script'; ?>
>
<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=dev_group&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>

            <td align="center">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=dev_group_save&id=<?php echo $_smarty_tpl->tpl_vars['sgroup']->value['id'];?>
&ldapid=<?php echo $_smarty_tpl->tpl_vars['ldapid']->value;?>
">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="2" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		节点名
		</td>
		<td width="67%">
		<input type = text name="groupname" value="<?php echo $_smarty_tpl->tpl_vars['sgroup']->value['groupname'];?>
">
	  </td>
	</tr>
	<tr>
		<td width="33%" align=right>
		负载均衡	
		</td>
		<td width="67%">
				<select  class="wbk"  name="loadbalance">
				<OPTION VALUE="0">无</option>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['l'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['l']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['name'] = 'l';
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['loadbalances']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total']);
?>
			<OPTION VALUE="<?php echo $_smarty_tpl->tpl_vars['loadbalances']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['sid'];?>
" <?php if ($_smarty_tpl->tpl_vars['loadbalances']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']][sid] == $_smarty_tpl->tpl_vars['sgroup']->value['loadbalance']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['loadbalances']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['ip'];?>
</option>
		<?php endfor; endif; ?>
		</select>
	  </td>
	</tr>
	<tr>
		<td width="33%" align=right>
		所属目录
		</td>
		<td width="67%">
		<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

	  </td>
	</tr>
	<tr bgcolor="f7f7f7" id="attributeid" style="display:none">
		<td width="33%" align=right>
		属性	
		</td>
		<td width="67%">
				<select  class="wbk"  name="attribute">
				<OPTION VALUE="0" <?php if (!$_smarty_tpl->tpl_vars['sgroup']->value['attribute']) {?>selected<?php }?>>全部</option>
				<OPTION VALUE="1" <?php if (1 == $_smarty_tpl->tpl_vars['sgroup']->value['attribute']) {?>selected<?php }?>>用户</option>
				<OPTION VALUE="2" <?php if (2 == $_smarty_tpl->tpl_vars['sgroup']->value['attribute']) {?>selected<?php }?>>主机</option>
				</select>
	  </td>
	</tr>
	<tr>
		<td width="33%" align=right valign="top">
		描述
		</td>
		<td width="67%">
		<textarea cols="30" rows="10"  name="description"><?php echo $_smarty_tpl->tpl_vars['sgroup']->value['description'];?>
</textarea>
	  </td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit"  value=" 确    认 " class="an_06"></td>
	</tr>
	</table>
<br>
<input type="hidden" name="levelx" id="levelxid" value="<?php echo $_smarty_tpl->tpl_vars['sgroup']->value['level'];?>
" />
<input type="hidden" name="ldapid" id="ldapid" value="<?php echo $_smarty_tpl->tpl_vars['ldapid']->value;?>
" />
<input type="hidden" name="ldapid1" id="ldapid1id" value="<?php echo $_smarty_tpl->tpl_vars['ldapid1']->value;?>
" />
<input type="hidden" name="ldapid2" id="ldapid2id" value="<?php echo $_smarty_tpl->tpl_vars['ldapid2']->value;?>
" />
<input type="hidden" name="ldapid3" id="ldapid3id" value="<?php echo $_smarty_tpl->tpl_vars['ldapid3']->value;?>
" />
<input type="hidden" name="ldapid4" id="ldapid4id" value="<?php echo $_smarty_tpl->tpl_vars['ldapid4']->value;?>
" />
<input type="hidden" name="ldapid5" id="ldapid5id" value="<?php echo $_smarty_tpl->tpl_vars['ldapid5']->value;?>
" />
</form>
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


function check(){
}
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>