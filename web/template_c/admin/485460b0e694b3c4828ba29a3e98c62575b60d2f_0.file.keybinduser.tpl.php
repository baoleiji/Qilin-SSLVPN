<?php /* Smarty version 3.1.27, created on 2016-12-19 23:00:32
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/keybinduser.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:6198138315857f6105350d9_43008537%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '485460b0e694b3c4828ba29a3e98c62575b60d2f' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/keybinduser.tpl',
      1 => 1474793216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6198138315857f6105350d9_43008537',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'allmem' => 0,
    'keyid' => 0,
    'key' => 0,
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5857f6105bc786_41303798',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5857f6105bc786_41303798')) {
function content_5857f6105bc786_41303798 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '6198138315857f6105350d9_43008537';
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

</head>
 <SCRIPT language=javascript src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/selectdate.js"></SCRIPT>
 <style>
 .operate {
	width: 60px; height: 20px; padding-top:5px; padding-bottom:5px;
}

.operate_common{
	position: absolute; top: 0px; left: 0px;  background-color: #FFFFFF; visibility: hidden; margin-bottom:8px; overflow: hidden; border: 1px solid #92B7E5; 
}
 </style>
<?php echo '<script'; ?>
>

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

function checkAll(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,5)=='Check'){
			targets[j].checked=c;
		}
	}
}
function reload(p1,p2,check){
	window.location=window.location+'&'+(check ? p1 : p2);
}


var menuTimer = null;

function show_menu(obj1,obj2,state,location,keyid){ 
    var btn=document.getElementById(obj1);
    var obj=document.getElementById(obj2);
    var h=btn.offsetHeight;
    var w=btn.offsetWidth;
    var x=btn.offsetLeft;
    var y=btn.offsetTop;
    obj.innerHTML=keyid;
   /* obj.onmouseover =function(){
        show_menu(obj1,obj2,'show',location,keyid);
    }*/
    obj.onmouseout =function(){
        show_menu(obj1,obj2,'hide',location);
    }
    
    while(btn=btn.offsetParent){y+=btn.offsetTop;x+=btn.offsetLeft;}
    
    var hh=obj.offsetHeight;
    var ww=obj.offsetWidth;
    var xx=obj.offsetLeft;
    var yy=obj.offsetTop;
    var obj2state=state.toLowerCase();
    var obj2location=location.toLowerCase();
    
    var showx,showy;

    if(obj2location=="left" || obj2location=="top" || obj2location=="right" || obj2location=="bottom"){
        if(obj2location=="left"){showx=x-ww;showy=y;}
        if(obj2location=="top"){showx=x;showy=y-hh;}
        if(obj2location=="right"){showx=x+w;showy=y;}
        if(obj2location=="bottom"){showx=x;showy=y+h;}
    }else{ 
        showx=xx;showy=yy;
    }
    obj.style.left=showx+"px";
    obj.style.top=showy+"px";
    if(state =="hide"){
        menuTimer =setTimeout("_hide_menu('"+ obj2 +"')", 1);
    }else{
        clearTimeout(menuTimer);
        obj.style.visibility ="visible";
    }
}
function _hide_menu(id){
    document.getElementById(id).style.visibility ="hidden";
}

<?php echo '</script'; ?>
>
<body>

<div id="opdiv" class="operate operate_common">

</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=keys_index">动态令牌</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action=keys_index&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_member&action=keybinduser_save&keyid=<?php echo $_smarty_tpl->tpl_vars['keyid']->value;?>
">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top  class="BBtable">
		
	  <tr bgcolor="f7f7f7"><td></td><td>key:<?php echo $_smarty_tpl->tpl_vars['key']->value['keyid'];?>
</td></tr>
		<tr>
		<td width="15%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['bind'];
echo $_smarty_tpl->tpl_vars['language']->value['User'];?>

		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' <?php if ($_GET['binduser'] == 1) {?>checked<?php }?> value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' <?php if ($_GET['binduser'] == 2) {?>checked<?php }?> value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll(this.checked);"></td></tr>
	  </table>
		</td>
		<td width="85%">
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
		<?php if (!$_GET['binduser'] || ($_GET['binduser'] == 2 && !$_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['binded']) || ($_GET['binduser'] == 1 && $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['binded'])) {?>
		<td width="180"><input type="checkbox" name='Check<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['g']['index'];?>
' value='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['uid'];?>
'  <?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['check'];?>
><?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['binded']) {?><font color="red"><?php }
echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['username'];?>
(<?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname']) {
echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['realname'];
} else { ?>未设置<?php }?>)<?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['binded']) {?></font><?php }?></td><?php if (($_smarty_tpl->getVariable('smarty')->value['section']['g']['index']+1)%5 == 0) {?></tr><tr><?php }?>
		<?php }?>
		<?php endfor; endif; ?>
		</tr></table>
	  </td>
	  </tr>
	 
	<tr><td></td><td><input type=submit  value="<?php echo $_smarty_tpl->tpl_vars['language']->value['Save'];?>
" class="an_02"></td></tr></table>
</form>
	</td>
  </tr>
</table>
 
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>