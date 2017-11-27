<?php /* Smarty version 3.1.27, created on 2017-05-16 11:00:41
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/pass_edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:907130125591a6b591c2480_62880282%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd55148f41665f81a57c66b8cb832ff0f5b0b86e' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/pass_edit.tpl',
      1 => 1483373577,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '907130125591a6b591c2480_62880282',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'allradiusmem' => 0,
    'id' => 0,
    'ip' => 0,
    'serverid' => 0,
    'gid' => 0,
    '_config' => 0,
    'fromdevpriority' => 0,
    'webuser' => 0,
    'webgroup' => 0,
    'trnumber' => 0,
    'language' => 0,
    'logtab' => 0,
    'sessionlgroup' => 0,
    'sessionluser' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_591a6b5927eb25_01853313',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_591a6b5927eb25_01853313')) {
function content_591a6b5927eb25_01853313 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '907130125591a6b591c2480_62880282';
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
 language="javascript">
function check_add_user(){
	return(true);
}

var AllMember = new Array();
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['name'] = 'kk';
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allradiusmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
]['username']='<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['username'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['realname']='<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['realname'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['uid']='<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['uid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['groupid']='<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['groupid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['check']='<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['check'];?>
';
<?php endfor; endif; ?>


function filter(){
	var filterStr = document.getElementById('username').value;
	var usbkeyid = document.getElementById('memberselect');
	usbkeyid.options.length=1;
	for(var i=0; i<AllRadiusMember.length;i++){
		if(filterStr.length==0 || AllRadiusMember[i]['username'].indexOf(filterStr) >= 0){
			usbkeyid.options[usbkeyid.options.length++] = new Option(AllRadiusMember[i]['username'],AllRadiusMember[i]['uid']);
		}
	}
}

function change_for_user_auth(){
}

function usernameselect(){
}
function temptyuser(check){
}

function searchit(){
	var url = "admin.php?controller=admin_pro&action=pass_edit&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&from=<?php echo $_GET['from'];?>
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
	url += "&g_id="+gid;
	<?php }?>
	window.location.href= url;
	return false;
}

<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
var foundparent = false;
var servergroup = new Array();
<?php }?>
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

<body onbeforeunload="saveTitle(event)">


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu" style="width:1100px;">
<ul>
</ul><span class="back_img"><A href="admin.php?<?php if ($_GET['from'] == 'passview') {?>controller=admin_index&action=main<?php } else { ?>controller=admin_pro&action=<?php if ($_smarty_tpl->tpl_vars['fromdevpriority']->value) {?>dev_priority_search<?php } else { ?>devpass_index&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;
}
}?>&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
<tr>
	<td class="">
    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#ffffff" class="BBtable" >
	<TR>
	<TD colspan="3" height="33" class="main_content">
	<form name ='f1' action='admin.php?controller=admin_pro&action=pass_edit' method=post>
	资源组：<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
&nbsp;&nbsp;&nbsp;&nbsp;运维用户过滤<input type="text" class="wbk" name="webuser" value="<?php echo $_smarty_tpl->tpl_vars['webuser']->value;?>
">
	资源组<input type="text" class="wbk" name="webgroup" value="<?php echo $_smarty_tpl->tpl_vars['webgroup']->value;?>
">
	&nbsp;&nbsp;<input  type="button" value=" 提交 " onClick="return searchit();" class="bnnew2">
	</form>
	</TD>
  </TR>

<form name="f2" method=post action="admin.php?controller=admin_pro&action=pass_save&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&from=<?php echo $_GET['from'];?>
" enctype="multipart/form-data" onsubmit="javascript:saveAccount=false;">
	<input type="password" name="hiddenpassword" id="hiddenpassword" style="display:none"/> <?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
	
		
	<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="20%" align=right  valign=top>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];?>

		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' <?php if ($_GET['binduser'] == 1) {?>checked<?php }?> value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' <?php if ($_GET['binduser'] == 2) {?>checked<?php }?> value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll(this.checked);"></td></tr>
	  </table>
		</td>
		<td width="80%">
		<table><tr >
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['g'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['g']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['name'] = 'g';
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allradiusmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
		<?php if (!$_GET['binduser'] || ($_GET['binduser'] == 2 && $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'] == '') || ($_GET['binduser'] == 1 && $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'] == 'checked')) {?>
		<td width="180"><input type="checkbox" id="uid_<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
" name='Check<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['g']['index'];?>
' value='<?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
'  <?php echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'];?>
><a href="#" target="_blank" ><?php if ($_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['binded']) {?><font color="red"><?php }
echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['username'];?>
(<?php if ($_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname']) {
echo $_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname'];
} else { ?>未设置<?php }?>)<?php if ($_smarty_tpl->tpl_vars['allradiusmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['binded']) {?></font><?php }?></a></td><?php if (($_smarty_tpl->getVariable('smarty')->value['section']['g']['index']+1)%5 == 0) {?></tr><tr><?php }?>
		<?php }?>
		<?php endfor; endif; ?>
		</tr></table>
	  </td>
	  </tr>
	 
	<tr><td></td><td><input type=submit  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02" >&nbsp;&nbsp;&nbsp;&nbsp;<input type=button  value="检测" onclick="test_port();" class="an_02"></td></tr></table>
<input type="hidden" name="logtab" value="<?php echo $_smarty_tpl->tpl_vars['logtab']->value['id'];?>
" />
<input type="hidden" name="sessionlgroup" value="<?php echo $_smarty_tpl->tpl_vars['sessionlgroup']->value;?>
" />
<input type="hidden" name="sessionluser" value="<?php echo $_smarty_tpl->tpl_vars['sessionluser']->value;?>
" />
</form>
	</td>
  </tr>
  <tr><td colspan="2" height="25"></td></tr>
</table>
 <SCRIPT type=text/javascript>
var siteUrl = "<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/date";
function test_port(){
	var port = document.getElementById('port').value;
	if(!/[0-9]+/.test(port)){
		alert('端口请输入数字');
		return ;
	}
	document.getElementById('hide').src='admin.php?controller=admin_pro&action=test_port&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&port='+port;
	//alert(document.getElementById('hide').src);
}
function changeport(cp) {
	
}
function appset(enable){
	document.getElementById("usernametr").style.display=enable;
	document.getElementById("originalpasswordtr").style.display=enable;
	document.getElementById("originalpassword2tr").style.display=enable;
	document.getElementById("porttr").style.display=enable;
	document.getElementById("expiretr").style.display=enable;
	document.getElementById("autotr").style.display=enable;
	document.getElementById("automutr").style.display=enable;
	document.getElementById("entrust_passwordtr").style.display=enable;
}

function checkAll(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,5)=='Check'){
			targets[j].checked=c;
		}
	}
}


function privatekey_set(){
}
function changessh(v){
}


var saveAccount = false;
function saveTitle(e){
	if(saveAccount){
		//alert("绑定信息需要点击'保存修改'才能存盘");
		return  e.returnValue='绑定信息需要点击 保存修改 才能存盘,你真的要不保存离开吗？';
		
	}
	return true;
}
function setSave(){
	saveAccount=true;
}
function reload(p1,p2,check){
	window.location=window.location+'&'+(check ? p1 : p2);
}

<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>
</SCRIPT>
</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>