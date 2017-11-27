<?php /* Smarty version 3.1.27, created on 2017-05-16 22:09:16
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/batchserverpriorityedit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:726664685591b080c8638f6_22998867%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96a1af486bbd6d4432eaac3af696c09f64a043b0' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/batchserverpriorityedit.tpl',
      1 => 1483263269,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '726664685591b080c8638f6_22998867',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    '_config' => 0,
    'usergroup' => 0,
    'servergroup' => 0,
    'usersid' => 0,
    'device_ip' => 0,
    'trnumber' => 0,
    'allservers' => 0,
    'language' => 0,
    'device_types' => 0,
    'sourceip' => 0,
    'member' => 0,
    'method' => 0,
    'freq' => 0,
    'superpassword' => 0,
    'id' => 0,
    'sshport' => 0,
    'telnetport' => 0,
    'ftpport' => 0,
    'rdpport' => 0,
    'vncport' => 0,
    'x11port' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_591b080ca34bc7_73408496',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_591b080ca34bc7_73408496')) {
function content_591b080ca34bc7_73408496 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '726664685591b080c8638f6_22998867';
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
<?php echo '<script'; ?>
 src="./template/admin/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/cn.js"><?php echo '</script'; ?>
>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<?php echo '<script'; ?>
 language="javascript">
	function check_add_user(){
		return(true);
	}


<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var i=0;
i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['b'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['b']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['name'] = 'b';
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['usergroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['b']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['b']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['b']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['b']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['b']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['b']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['b']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['b']['total']);
?>
usergroup[i++]={id:<?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['b']['index']]['id'];?>
,name:'<?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['b']['index']]['groupname'];?>
',ldapid:<?php echo $_smarty_tpl->tpl_vars['usergroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['b']['index']]['ldapid'];?>
,level:0};
<?php endfor; endif; ?>

<?php }?>

	/**选中的元素向右移动**/
 	function moveRight()
	{
		
			//得到第一个select对象
		var selectElement = document.getElementById("first");
		var optionElements = selectElement.getElementsByTagName("option");
		var len = optionElements.length;
		var selectElement2 = document.getElementById("secend");

		if(!(selectElement.selectedIndex==-1))   //如果没有选择元素，那么selectedIndex就为-1
		{
			
			//得到第二个select对象
			
	
				// 向右移动
				for(var i=0;i<len ;i++)
				{
					if(selectElement.selectedIndex>=0)
					selectElement2.appendChild(optionElements[selectElement.selectedIndex]);
				}
				changed = true;
		} else
		{
			alert("您还没有选择需要移动的元素！");
		}
	}
	

	
	//移动选中的元素到左边
	function moveLeft()
	{
		//首先得到第二个select对象
		var selectElement = document.getElementById("secend");
		
		var optionElement = selectElement.getElementsByTagName("option");
		var len = optionElement.length;
		var firstSelectElement = document.getElementById("first");
		
		
		//再次得到第一个元素
		if(!(selectElement.selectedIndex==-1))
		{
			
			for(i=0;i<len;i++)
			{
				if(selectElement.selectedIndex>=0)
					firstSelectElement.appendChild(optionElement[selectElement.selectedIndex]);//被选中的那个元素的索引
			}
			changed = true;
		}else
		{
			alert("您还没有选中要移动的项目!");
		}
	}

function enablepri(c, item){
	c=!c;//alert(item);
	switch(item){
		case 'usergroup':
			document.getElementById('groupid1pop').disabled=c;
			document.getElementById('groupid1').disabled=c;
			break;
		case 'device_type':
			document.getElementById('device_type').disabled=c;
			break;
		case 'stra_type':
			document.getElementById('stra_type1').disabled=c;
			document.getElementById('stra_type2').disabled=c;
			document.getElementById('stra_type3').disabled=c;
			document.getElementById('freq').disabled=c;
			break;
		case 'superpassword':
			document.getElementById('superpassword').disabled=c;
			document.getElementById('superpassword2').disabled=c;
			break;
		case 'sshport':
			document.getElementById('sshport').disabled=c;
			break;
		case 'telnetport':
			document.getElementById('telnetport').disabled=c;
			break;
		case 'ftpport':
			document.getElementById('ftpport').disabled=c;
			break;
		case 'rdpport':
			document.getElementById('rdpport').disabled=c;
			break;
		case 'vncport':
			document.getElementById('vncport').disabled=c;
			break;
		case 'x11port':
			document.getElementById('x11port').disabled=c;
			break;
	}
}

var groupid='<?php echo $_smarty_tpl->tpl_vars['servergroup']->value;?>
';
function filteruser(){	
	var username = document.getElementById('username').value;
	var gid=0;
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['TREEMODE']) {?>
	var obj1=document.getElementById('sgroupiddh');	
	gid=obj1.value;
	<?php } else { ?>
	for(var i=1; true; i++){
		var obj=document.getElementById('sgroupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	<?php }?>
	<?php }?>
	prefgroupid=gid;
	var url = 'admin.php?controller=admin_pro&action=batchserverpriorityedit&sgroupid='+gid+"&device_ip="+username;
	var checks = document.getElementById('secend');
	for(var i=0; i<checks.options.length; i++){
		url += '&ip[]='+checks[i].value;
	}
	window.location=url;
}

function checkall(selectID){
	var obj = document.getElementById(selectID);
	var len = obj.options.length;
	for(var i=0; i<len; i++){
		obj.options[i].selected = true;
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
 <SCRIPT language=javascript src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/selectdate.js"></SCRIPT>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu" style="width:1100px;">
<ul> 
</ul><span class="back_img"><A href="admin.php?controller=admin_member&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_pro&action=batchserverpriorityeditsave&chk_member=<?php echo $_smarty_tpl->tpl_vars['usersid']->value;?>
" enctype="multipart/form-data" onsubmit="return confirm('确定操作?');checkall('secend');">
	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr><td colspan="5" align=center><div style="text-align:left;width:500px;">
		<select  class="wbk" onchange="window.location='admin.php?controller=admin_pro&action='+this.value">
			<OPTION VALUE="batchserverpriorityedit" <?php if ($_GET['action'] == 'batchserverpriorityedit') {?>selected<?php }?>>设备</option>
			<OPTION VALUE="batchdevicepriorityedit" <?php if ($_GET['action'] == 'batchdevicepriorityedit') {?>selected<?php }?>>用户</option>
		</select>&nbsp;&nbsp;&nbsp;IP：<input type="text" name="username" id="username" value="<?php echo $_smarty_tpl->tpl_vars['device_ip']->value;?>
" >&nbsp;
		<?php $_smarty_tpl->tpl_vars['select_group_id'] = new Smarty_Variable('sgroupid', null, 0);?>
		<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
 
		&nbsp;<input type="button" onclick="filteruser();" value="提交" ></div></td></tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="loginmodetr">
		<td width="100%" align="center" colspan="2">
		<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th class="list_bg">未选设备</th><th class="list_bg"></th><th class="list_bg">已选设备</th></tr>

	<form name="f1" method=post action="admin.php?controller=admin_pro&action=resource_group_save"  enctype="multipart/form-data" >
	  <tr>
	  <td width="45%" align=right>
		<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" ondblclick="moveRight()">
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ra'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['name'] = 'ra';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allservers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ra']['total']);
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['allservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['device_ip'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['allservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['device_ip'];?>
_<?php echo $_smarty_tpl->tpl_vars['allservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['hostname'];?>
"><?php echo $_smarty_tpl->tpl_vars['allservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['device_ip'];?>
_<?php echo $_smarty_tpl->tpl_vars['allservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ra']['index']]['hostname'];?>
</option>
		<?php endfor; endif; ?>
		</select>
		</td>
		<td width="10%" align="center">
		<div class="select_move_2">
                <input size="30" type="button" value=" 添加--> " onclick="moveRight()"/><br /><br /><br />
                <input size="30" type="button" value=" <--删除 "  onclick="moveLeft()"/><br />
          </div>
         </td>
         <td>
		<select  class="wbk"   style="width:400;height:400;" size="30" id="secend" name="secend[]" multiple="multiple">
   		</select>
	  </td>
	</tr>
	</table>
		</td>
	</tr>
    <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> id="loginmodetr">
		<td width="3%" align="center">
		权限
		</td>
		<td width="97%">
		<table width="100%">
		 <TR bgcolor="#f7f7f7">
            <TD align="left"><input type="checkbox" name="enable[]" value="usergroup" onclick="enablepri(this.checked,'usergroup');" >&nbsp;运维组： </TD>
            <TD colspan="3">
		<?php $_smarty_tpl->tpl_vars['select_group_id'] = new Smarty_Variable('groupid', null, 0);?>
		<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
       </TD>
           
          </TR>
	<TR bgcolor="#f7f7f7">
	 <TD align="left"><input type="checkbox" name="enable[]" value="device_type" onclick="enablepri(this.checked,'device_type');" >&nbsp;设备类型：</TD>
      <TD><select class="wbk"  name=device_type id=device_type>
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['no'];?>
</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['device_types']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
				<option value="<?php echo $_smarty_tpl->tpl_vars['device_types']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['sourceip']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['groupname'] == $_smarty_tpl->tpl_vars['member']->value['sourceip']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['device_types']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_type'];?>
</option>
			<?php endfor; endif; ?>
                  </SELECT>  &nbsp;&nbsp;&nbsp;
      </TD>
      <TD align="left" style="display: none"><input type="checkbox" name="enable[]" value="stra_type" onclick="enablepri(this.checked,'stra_type');" >&nbsp;改密：</TD>
      <TD style="display: none"><input type='radio' name="stra_type" id="stra_type1" value='mon' <?php if ($_smarty_tpl->tpl_vars['method']->value == 'mon' || $_smarty_tpl->tpl_vars['method']->value == '') {?>checked<?php }?>>按月
		
		<input type='radio' name="stra_type" id="stra_type2" value='week' <?php if ($_smarty_tpl->tpl_vars['method']->value == 'week') {?>checked<?php }?>>每周
		
		<input type='radio' name="stra_type" id="stra_type3" value='custom'<?php if ($_smarty_tpl->tpl_vars['method']->value == 'user') {?>checked<?php }?>>自定义<br />
		频率
		<input type=text name="freq" id="freq" size=35 value="<?php if ($_smarty_tpl->tpl_vars['freq']->value) {
echo $_smarty_tpl->tpl_vars['freq']->value;
} else { ?>1<?php }?>" >**
		</TD>
     
    </TR>
	<TR bgcolor="" style="display: none">
      <TD align="left"><input type="checkbox" name="enable[]" value="superpassword" onclick="enablepri(this.checked,'superpassword');" >&nbsp;超级管理员口令:：</TD>
      <TD><input type="password" size=35 name="superpassword" id="superpassword" value="<?php echo $_smarty_tpl->tpl_vars['superpassword']->value;?>
"/></TD>
				  
      <TD align="left">&nbsp;再输一次口令：</TD>
      <TD><input type="password" size=35 name="superpassword2" id="superpassword2" value="<?php echo $_smarty_tpl->tpl_vars['superpassword']->value;?>
"/></TD>
    </TR>

	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> style="display: none">
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="sshport" onclick="enablepri(this.checked,'sshport');" >&nbsp;SSH默认端口：
		</td>
		<td width="35%">
		<input type=text name="sshport" id="sshport" size=35 value="<?php if ($_smarty_tpl->tpl_vars['id']->value) {
echo $_smarty_tpl->tpl_vars['sshport']->value;
} else { ?>22<?php }?>" >
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="telnetport" onclick="enablepri(this.checked,'telnetport');" >&nbsp;TELNET默认端口：	
		</td>
		<td width="35%">
		<input type=text name="telnetport" id="telnetport" size=35 value="<?php if ($_smarty_tpl->tpl_vars['id']->value) {
echo $_smarty_tpl->tpl_vars['telnetport']->value;
} else { ?>23<?php }?>" >
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> style="display: none">
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="ftpport" onclick="enablepri(this.checked,'ftpport');" >&nbsp;FTP默认端口：
		</td>
		<td width="35%">
		<input type=text name="ftpport" id="ftpport" size=35 value="<?php if ($_smarty_tpl->tpl_vars['id']->value) {
echo $_smarty_tpl->tpl_vars['ftpport']->value;
} else { ?>21<?php }?>" >
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="rdpport" onclick="enablepri(this.checked,'rdpport');" >&nbsp;RDP默认端口：
		</td>
		<td width="35%">
		<input type=text name="rdpport" id="rdpport" size=35 value="<?php if ($_smarty_tpl->tpl_vars['id']->value) {
echo $_smarty_tpl->tpl_vars['rdpport']->value;
} else { ?>3389<?php }?>" >
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> style="display: none">
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="vncport" onclick="enablepri(this.checked,'vncport');" >&nbsp;VNC默认端口：
		</td>
		<td width="35%">
		<input type=text name="vncport" id="vncport" size=35 value="<?php if ($_smarty_tpl->tpl_vars['id']->value) {
echo $_smarty_tpl->tpl_vars['vncport']->value;
} else { ?>5900<?php }?>" >
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="x11port" onclick="enablepri(this.checked,'x11port');" >&nbsp;X11默认端口：
		</td>
		<td width="35%">
		<input type=text name="x11port" id="x11port" size=35 value="<?php if ($_smarty_tpl->tpl_vars['id']->value) {
echo $_smarty_tpl->tpl_vars['x11port']->value;
} else { ?>3389<?php }?>" >
	  </td>
	</tr>
		</table>
		
	  </td>
	</tr>
	
	<tr><td colspan="2" align="center"><input type=submit name="submit"  value="批量导出" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name="submit"  value="批量删除" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name="submit"  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td></tr></table>
</form>
	</td>
  </tr>
  <tr><td colspan="2" height="25"></td></tr>
</table>
</body>
<?php echo '<script'; ?>
>
enablepri(false, 'usergroup');
enablepri(false, 'device_type');
enablepri(false, 'superpassword');
enablepri(false, 'stra_type');
enablepri(false, 'sshport');
enablepri(false, 'telnetport');
enablepri(false, 'ftpport');
enablepri(false, 'rdpport');
enablepri(false, 'vncport');
enablepri(false, 'x11port');
<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>
<?php echo '</script'; ?>
>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>