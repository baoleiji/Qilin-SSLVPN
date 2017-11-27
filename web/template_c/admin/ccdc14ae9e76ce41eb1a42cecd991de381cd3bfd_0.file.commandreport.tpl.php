<?php /* Smarty version 3.1.27, created on 2016-12-04 21:08:25
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/commandreport.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:37628820858441549b60442_13720901%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ccdc14ae9e76ce41eb1a42cecd991de381cd3bfd' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/commandreport.tpl',
      1 => 1474793223,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '37628820858441549b60442_13720901',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    '_config' => 0,
    'alluser' => 0,
    'allserver' => 0,
    'curr_url' => 0,
    'f_rangeStart' => 0,
    'f_rangeEnd' => 0,
    'orderby2' => 0,
    'reports' => 0,
    'session_num' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
    'now_table_name' => 0,
    'admin_level' => 0,
    'table_list' => 0,
    'data' => 0,
    'info' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58441549c36fe9_77141804',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58441549c36fe9_77141804')) {
function content_58441549c36fe9_77141804 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/opt/freesvr/web/htdocs/freesvr/audit/dep10/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '37628820858441549b60442_13720901';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>Audit<?php echo $_smarty_tpl->tpl_vars['language']->value['List'];?>
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
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/border-radius.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jscal2.css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/cn.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
function changetype(sid){
document.getElementById(sid).checked=true;
}
function searchit(){
	var url = "admin.php?controller=admin_reports&action=commandreport";
	url += "&f_rangeStart="+document.search.elements.f_rangeStart.value;
	url += "&f_rangeEnd="+document.search.elements.f_rangeEnd.value;
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
	document.search.action=url;
	//alert(document.search.elements.action);
	//return false;
	return true;
}
<?php echo '</script'; ?>
>

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
 <?php if ($_GET['from'] == 'configreport') {?>
<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=configreport">报表配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cronreports">报表自动生成配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=downloadcronreport">下载报表</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php } else { ?>

	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=commandreport">命令总计</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cmdcachereport">命令统计</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cmdlistreport">命令列表</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=appreport&number=2">应用报表</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=sftpreport&number=3">SFTP<?php echo $_smarty_tpl->tpl_vars['language']->value['Command'];
echo $_smarty_tpl->tpl_vars['language']->value['report'];?>
</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=ftpreport&number=6">FTP<?php echo $_smarty_tpl->tpl_vars['language']->value['Command'];
echo $_smarty_tpl->tpl_vars['language']->value['report'];?>
</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php }?>
</ul><?php if ($_GET['from'] == 'configreport') {?><span class="back_img"><A href="admin.php?controller=admin_reports&action=configreport"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" width="80" height="30" border="0"></A></span><?php }?>
</div></td></tr>



  <tr>
    <td class="main_content">
<form action="<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
" method="post" name="search" >

		<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
          
<?php echo $_smarty_tpl->tpl_vars['language']->value['Starttime'];?>
：<input type="text" class="wbk"  name="f_rangeStart" size="16" id="f_rangeStart" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['f_rangeStart']->value,'%Y-%m-%d');?>
" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Edittime'];?>
"  class="wbk">


 <?php echo $_smarty_tpl->tpl_vars['language']->value['Endtime'];?>
：
<input  type="text" class="wbk" name="f_rangeEnd" size="16" id="f_rangeEnd"  value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['f_rangeEnd']->value,'%Y-%m-%d');?>
" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Edittime'];?>
"  class="wbk">
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
</form> 
	  </td>
  </tr>
  <?php echo '<script'; ?>
 type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: false
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d");
<?php echo '</script'; ?>
>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=luser&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >堡垒机用户</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=realname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >别名</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=groupname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >运维组</a></th>						
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=user&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >系统用户</a></th>						
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >登录主机</a></th>
						
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=ct&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >命令次数</a></th>
						<th class="list_bg"  ><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=mstart&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >开始日期</a></th>
						<th class="list_bg"  ><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=mend&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >结束日期</a></th>
					
					</tr>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['reports']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
						<td width="10%"><?php echo $_smarty_tpl->tpl_vars['reports']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
</td>
						<td width="10%"><?php echo $_smarty_tpl->tpl_vars['reports']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname'];?>
</td>
						<td width="10%"><?php echo $_smarty_tpl->tpl_vars['reports']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['groupname'];?>
</td>
						<td width="10%"><?php echo $_smarty_tpl->tpl_vars['reports']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['user'];?>
</td>
						<td width="10%"><?php echo $_smarty_tpl->tpl_vars['reports']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
</td>
						<td width="10%"><?php echo $_smarty_tpl->tpl_vars['reports']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['ct'];?>
</td>
						<td width="10%"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['reports']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['mstart'],'%Y-%m-%d');?>
</td>
						<td width="10%"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['reports']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['mend'],'%Y-%m-%d');?>
</td>
					</tr>
					<?php endfor; endif; ?>
					<tr>
						<td colspan="12" align="right">
							<?php echo $_smarty_tpl->tpl_vars['language']->value['all'];
echo $_smarty_tpl->tpl_vars['session_num']->value;
echo $_smarty_tpl->tpl_vars['language']->value['Session'];?>
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
 <!--当前数据表: <?php echo $_smarty_tpl->tpl_vars['now_table_name']->value;?>
-->   导出：<a href="<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&derive=1" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/excel.png" border=0></a>  <a href="<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&derive=2" ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/html.png" border=0></a>  <a href="<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&derive=3" ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/word.png" border=0></a>  <a href="<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&derive=4" ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/pdf.png" border=0></a> <?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 1) {?><a href="<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&delete=1"></a><?php }?>
						<!--
						<select  class="wbk"  name="table_name">
						<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['table_list']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
						<option value="<?php echo $_smarty_tpl->tpl_vars['table_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']];?>
" <?php if ($_smarty_tpl->tpl_vars['table_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']] == $_smarty_tpl->tpl_vars['now_table_name']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['table_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']];?>
</option>
						<?php endfor; endif; ?>
						</select>
						-->
						</td>
					</tr>
				</table>
	</td>
  </tr>
  <?php if ($_smarty_tpl->tpl_vars['data']->value) {?>
  <tr><td class="main_content"><img src="include/pChart/graphgenerate.php?<?php echo $_smarty_tpl->tpl_vars['data']->value;
echo $_smarty_tpl->tpl_vars['info']->value;?>
graphtype=pie"</td></tr>
  <tr><td class="main_content"><img src="include/pChart/graphgenerate.php?<?php echo $_smarty_tpl->tpl_vars['data']->value;
echo $_smarty_tpl->tpl_vars['info']->value;?>
graphtype=bar"</td></tr>
  <?php }?>
</table>
<?php echo '<script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>
<?php echo '</script'; ?>
>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


<?php }
}
?>