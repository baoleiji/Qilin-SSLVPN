<?php /* Smarty version 3.1.27, created on 2017-05-16 11:34:09
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/dev_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:176661874591a73319dd0f1_65152773%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a844f984193ed1ddead662bce0aa1873b86723e' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/dev_edit.tpl',
      1 => 1494905553,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '176661874591a73319dd0f1_65152773',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'id' => 0,
    'gid' => 0,
    'appconfigedit' => 0,
    'appconfig1' => 0,
    'trnumber' => 0,
    'hostname' => 0,
    'alltype' => 0,
    'type_id' => 0,
    'IP' => 0,
    'ipv6' => 0,
    'asset_status' => 0,
    'asset_name' => 0,
    'asset_specification' => 0,
    'asset_department' => 0,
    'asset_location' => 0,
    'asset_company' => 0,
    'asset_start' => 0,
    'asset_usedtime' => 0,
    'asset_warrantdate' => 0,
    'caction' => 0,
    'monitor' => 0,
    'tab' => 0,
    '_config' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_591a7331a95946_89787499',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_591a7331a95946_89787499')) {
function content_591a7331a95946_89787499 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '176661874591a73319dd0f1_65152773';
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
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/global.functions.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/cn.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/global.functions.js"><?php echo '</script'; ?>
>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/_ajaxdtree.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/dtree.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php echo '<script'; ?>
>



function change_option(number,index){
 for (var i = 0; i <= number; i++) {
      document.getElementById('current' + i).className = '';
      document.getElementById('content' + i).style.display = 'none';
 }
  document.getElementById('current' + index).className = 'current';
  document.getElementById('content' + index).style.display = 'block';
  if(index==1 || index==2 || index==3){
	document.getElementById('finalsubmit').style.display = 'block';
  }else{
	document.getElementById('finalsubmit').style.display = 'none';
  }
  return false;
}
<?php echo '</script'; ?>
>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller=<?php if ($_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>admin_index&action=main<?php } else {
if ($_GET['appconfigedit']) {?>admin_pro&action=dev_edit&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&apptable=1<?php } else { ?>admin_pro&action=dev_index&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;
}
}?>&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>

   
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=dev_save&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&appconfigedit=<?php echo $_smarty_tpl->tpl_vars['appconfigedit']->value;?>
&appconfigid=<?php echo $_smarty_tpl->tpl_vars['appconfig1']->value['seq'];?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">
		<input type="password" name="hiddenpassword" id="hiddenpassword" style="display:none"/>	 <DIV style="WIDTH:100%" id=navbar>
 <?php if (!$_smarty_tpl->tpl_vars['appconfigedit']->value) {?>
				 <div id="content1" class="content">
				   <div class="contentMain">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<TR>
      <TD height="27" colspan="4" class="tb_t_bg">基本信息</TD>
    </TR>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="15%" align=right>
		主机名		
		</td>
		<td width="35%">
		<input type=text name="hostname" size=35 value="<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
" >
	  </td>
	  <td width="15%" align=right>
			系统类型  </td>
		<td width="35%"><select  class="wbk"  name="type_id">
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['g'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['g']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['name'] = 'g';
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alltype']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
			<OPTION VALUE="<?php echo $_smarty_tpl->tpl_vars['alltype']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['alltype']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'] == $_smarty_tpl->tpl_vars['type_id']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['alltype']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['device_type'];?>
</option>
		<?php endfor; endif; ?>
		</select>
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="15%" align=right>
		IPv4地址
		</td>
		<td width="35%">
		<input type=text name="IP" size=35 value="<?php echo $_smarty_tpl->tpl_vars['IP']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['id']->value) {?>readonly<?php }?>>
	  </td>
	  <td width="15%" align=right>
			IPv6 </td>
		<td width="35%"><input type=text name="ipv6" size=35 value="<?php echo $_smarty_tpl->tpl_vars['ipv6']->value;?>
" >
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		
	  <td width="15%" align=right>
		设备组
		</td>
		<td width="35%" >
		<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
 
			
		</td>
		 <td width="15%" align=right>
			使用状况 </td>
		<td width="35%"><input type=text name="asset_status" size=35 value="<?php echo $_smarty_tpl->tpl_vars['asset_status']->value;?>
" >
	  </td>
	</tr>

	</table> </div>
				 </div>
				 <div id="content2" class="content" >
				   <div class="contentMain">
				   <table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
				  
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="15%" align=right>
		固定资产名称	
		</td>
		<td width="35%">
		<input type=text name="asset_name" size=35 value="<?php echo $_smarty_tpl->tpl_vars['asset_name']->value;?>
" >
	  </td>
	  <td width="15%" align=right>
		规格型号	
		</td>
		<td width="35%">
		<input type=text name="asset_specification" size=35 value="<?php echo $_smarty_tpl->tpl_vars['asset_specification']->value;?>
" >
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="15%" align=right>
		部门名称	
		</td>
		<td width="35%">
		<input type=text name="asset_department" size=35 value="<?php echo $_smarty_tpl->tpl_vars['asset_department']->value;?>
" >
	  </td>
	  <td width="15%" align=right>
		存放地点	
		</td>
		<td width="35%">
		<input type=text name="asset_location" size=35 value="<?php echo $_smarty_tpl->tpl_vars['asset_location']->value;?>
" >
	  </td>
	</tr>
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="15%" align=right>
		支持厂商	
		</td>
		<td width="35%">
		<input type=text name="asset_company" size=35 value="<?php echo $_smarty_tpl->tpl_vars['asset_company']->value;?>
" >
	  </td>
	  <td width="15%" align=right>
		开始使用日期	
		</td>
		<td width="35%">
		<input type=text name="asset_start" id="asset_start" size=35 value="<?php echo $_smarty_tpl->tpl_vars['asset_start']->value;?>
" >&nbsp;&nbsp;<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk"> 

	  </td>
	</tr>	
	<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="15%" align=right>
		使用年限	
		</td>
		<td width="35%">
		<input type=text name="asset_usedtime" size=35 value="<?php echo $_smarty_tpl->tpl_vars['asset_usedtime']->value;?>
" >
	  </td>
	  <td width="15%" align=right>
		保修日期	
		</td>
		<td width="35%">
		<input type=text name="asset_warrantdate" id="asset_warrantdate" size=35 value="<?php echo $_smarty_tpl->tpl_vars['asset_warrantdate']->value;?>
" >&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
	  </td>
	</tr>
	
</table>
 </div>
</div>
<?php if ($_smarty_tpl->tpl_vars['caction']->value) {?>
 <div id="content3" class="content" >
				   <div class="contentMain">
				
 </div>
				 </div>
<?php }?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['caction']->value) {?>
		<?php if (!$_smarty_tpl->tpl_vars['appconfigedit']->value) {?>
		
<?php echo '</script'; ?>
>
<?php }
}?>

 <?php if (!$_smarty_tpl->tpl_vars['appconfigedit']->value) {?>

	<tr id="finalsubmit"><td align="center"><?php if ($_smarty_tpl->tpl_vars['id']->value && $_smarty_tpl->tpl_vars['monitor']->value == 1) {
if (!$_smarty_tpl->tpl_vars['appconfigedit']->value) {?><input type=button <?php if (!$_smarty_tpl->tpl_vars['id']->value) {?>readonly<?php }?> onclick="admin.php?controller=admin_pro&action=server_detect&ip=<?php echo $_smarty_tpl->tpl_vars['IP']->value;?>
"  value="硬件检测" class="an_02"><?php }
}?>&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit  value="保存修改" class="an_02" onclick="save();return true;"></td></tr></table>

</form>
<?php }?>
	</td>
  </tr>
</table>
  <?php echo '<script'; ?>
 type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection: 'up'
});
cal.manageFields("f_rangeStart_trigger", "asset_start", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "asset_warrantdate", "%Y-%m-%d %H:%M:%S");


<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="javascript">
function save(){
	if(document.getElementById('accounttable').style.display!='none'){
		document.f1.elements.action += "&accounttable=1";
	}
	if(document.getElementById('apptable').style.display!='none'){
		document.f1.elements.action += "&apptable=1";
	}
}
function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

function changeport() {
	if(document.getElementById("ssh").selected==true)  {
		f1.port.value = 22;
	}
	if(document.getElementById("telnet").selected==true)  {
		f1.port.value = 23;
	}
}

<?php if ($_SESSION['ADMIN_LEVEL'] == 3 && $_SESSION['ADMIN_MSERVERGROUP']) {?>
var ug = document.getElementById('servergroup');
for(var i=0; i<ug.options.length; i++){
	if(ug.options[i].value==<?php echo $_SESSION['ADMIN_MSERVERGROUP'];?>
){
		ug.selectedIndex=i;
		ug.onchange = function(){ug.selectedIndex=i;}
		break;
	}
}
<?php }?>

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

function opentable(id){
	if(document.getElementById(id).style.display=='none'){
		document.getElementById(id+"_img").src='template/admin/cssjs/img/nolines_minus.gif'
		document.getElementById(id).style.display=''
	}else{
		document.getElementById(id+"_img").src='template/admin/cssjs/img/nolines_plus.gif'
		document.getElementById(id).style.display='none'
	}
    window.parent.reinitIframe();
}
<?php if ($_GET['accounttable']) {?>
opentable('accounttable');
<?php }?>
<?php if ($_GET['apptable']) {?>
opentable('apptable');
<?php }?>


//change_option(<?php if ($_SESSION['CACTI_CONFIG_ON']) {?>4<?php } else { ?>2<?php }?>,<?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
);
<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>

<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>