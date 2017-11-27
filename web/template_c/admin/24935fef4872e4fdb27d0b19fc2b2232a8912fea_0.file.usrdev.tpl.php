<?php /* Smarty version 3.1.27, created on 2016-12-04 20:51:51
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/usrdev.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:23553677258441167dd5b26_56993173%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24935fef4872e4fdb27d0b19fc2b2232a8912fea' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/usrdev.tpl',
      1 => 1476112010,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23553677258441167dd5b26_56993173',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'logintype' => 0,
    'gid' => 0,
    'curr_url' => 0,
    'sip' => 0,
    'hostname' => 0,
    'admin_level' => 0,
    'appservers' => 0,
    'localip' => 0,
    'lb' => 0,
    'member' => 0,
    'rdpdiskauth_up' => 0,
    'bydomain' => 0,
    'orderby2' => 0,
    'type' => 0,
    'alldev' => 0,
    'windows_version' => 0,
    'language' => 0,
    'i' => 0,
    'appmember' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
    'logindebug' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_584411682665f7_53514580',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_584411682665f7_53514580')) {
function content_584411682665f7_53514580 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once '/opt/freesvr/web/htdocs/freesvr/audit/dep10/smarty/plugins/modifier.truncate_cn.php';

$_smarty_tpl->properties['nocache_hash'] = '23553677258441167dd5b26_56993173';
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
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/launchprogram.js"><?php echo '</script'; ?>
>
</head>
<?php echo '<script'; ?>
>
function webssh(t,title,url){
//document.write(url);
//return;
	if(t==1){
		window.parent.webssh(title,url);
	}else{
		window.open(url);
	}
}

function getSmsCode(){
	$.get('admin.php?controller=admin_pro&action=generate_sms_code', {"1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		alert(data);
	});
}

function userlogin(aid,tid){
	tid = document.getElementById(tid);
	aid = document.getElementById(aid);
	aid.href=aid.href + "&logintool=" + tid.options[tid.options.selectedIndex].value;
}

function search(){
	var form = document.f1;
	form.action += "&sip="+form.sip.value;
	form.action += "&hostname=" + encodeURIComponent(form.hostname.value);
	<?php if ($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub') {?>
		tid = document.getElementById('appserverip');
		form.action += "&appserverip=" + tid.options[tid.options.selectedIndex].value;
	<?php }?>
	form.submit();
	return true;
}

function windows_version(){
	var pos = navigator.appVersion.indexOf("Windows NT");
	if(pos > 0){
		return parseFloat(navigator.appVersion.substring(pos+10, navigator.appVersion.indexOf(";",pos)));
	}
}

var OSVersion = windows_version();
function checkieNT52(obj){
	return true;
	if(OSVersion==5.2&&obj.checked){
		alert('Windows2003不支持剪切板');
		obj.checked=false;
	}
}

var isIe=(document.all)?true:false;

function closeWindow()
{
	if(document.getElementById('back')!=null)
	{
		document.getElementById('back').parentNode.removeChild(document.getElementById('back'));
	}
	if(document.getElementById('mesWindow')!=null)
	{
		document.getElementById('mesWindow').parentNode.removeChild(document.getElementById('mesWindow'));
	}
	document.getElementById('fade').style.display='none';
}

function showImg(wTitle, c)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=200;
	var wHeight=240;
	var bWidth=parseInt(w=window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth);
	var bHeight=parseInt(window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight)+20;
	bHeight=700+20;
	var back=document.createElement("div");
	back.id="back";
	var styleStr="top:0px;left:0px;position:absolute;width:"+bWidth+"px;height:"+bHeight+"px;z-index:1002;";
	//styleStr+=(isIe)?"filter:alpha(opacity=0);":"opacity:0;";
	back.style.cssText=styleStr;
	document.body.appendChild(back);
	var mesW=document.createElement("div");
	mesW.id="mesWindow";
	mesW.className="mesWindow";
	mesW.innerHTML='<div id="light" class="white_content" style="height:240px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#eeeeee" align="right" height="25"><a href="javascript:void(0)" onclick="closeWindow()">关闭</a></td></tr></table>'+c+"</div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
	
	document.getElementById('fade').style.display='block'
	return false;
}
function changeuser(u){
	if(u==0){
		document.getElementById('passwordsave').value=-1;		
		document.getElementById('username').value='';
		document.getElementById('password').value='';

	}else if(u!=0){
		var u1 = u.substring(0, u.indexOf('_'));
		var u2 = u.substring(u.indexOf('_')+1);
		var username = u2.split('.,?');
		document.getElementById('passwordsave').value=u1;
		document.getElementById('username').value=username[0];
		document.getElementById('password').value=username[1];
	}
}

function loadurl(url){
	if(url=="") return ;
	$.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		if(data.substring(0,10)=='freesvr://'){
			launcher(data);
		}else if(data.substring(0,15)=='window.loadurl(' || data.substring(0,11)=='if(confirm('){
			eval(data);
		}else{
			showImg('',data);
		}
	});
}

function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}
<?php echo '</script'; ?>
>
<body>
<div id="fade" class="black_overlay"></div> 
<?php if ($_SESSION['ADMIN_LEVEL'] == 0 || $_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
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
<?php if ($_SESSION['ADMIN_LEVEL'] == 0) {?>
<li class=<?php if ($_GET['logintype']) {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype']) {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&all=1">设备列表</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype']) {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != '_apppub' && $_GET['logintype'] != 'apppub') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != '_apppub' && $_GET['logintype'] != 'apppub') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=_apppub&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">应用列表</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != '_apppub' && $_GET['logintype'] != 'apppub') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'ssh') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'ssh') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ssh&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">SSH设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'ssh') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'telnet') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'telnet') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=telnet&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">TELNET设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'telnet') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'rdp') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'rdp') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=rdp&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">RDP设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'rdp') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'vnc') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'vnc') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=vnc&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">VNC设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'vnc') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'ftp') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'ftp') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ftp&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">FTP设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'ftp') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<li class=<?php if ($_GET['logintype'] != 'x11') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'x11') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=x11">X11设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'x11') {?>3<?php }?>.jpg" align="absmiddle"/></li>

<li class=me_b><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow">运维流程</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>

<?php } elseif ($_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
<?php if ($_SESSION['ADMIN_LEVEL'] == 10) {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>

<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php }?>
<?php }?>
</ul>
</div></td></tr>

<?php }?>

	
<?php if ($_SESSION['ADMIN_LEVEL'] != 0 && $_SESSION['ADMIN_LEVEL'] != 10 && $_SESSION['ADMIN_LEVEL'] != 101) {?>
  <tr>
    <td  class="hui_bj"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</td>
          
          
          <td width="2"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/main_right.gif" width="2" height="31"></td>
        </tr>

      </table></td>
  </tr>
  <?php }?>
   <tr>
    <td class="main_content">
<form  name="f1" action="<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
" method="post" name="report" onsubmit="return search();" >
IP：<input type="text" class="wbk" id="sip" name="sip" value="<?php echo $_smarty_tpl->tpl_vars['sip']->value;?>
" style="width:80px;">&nbsp;主机名：<input type="text" class="wbk" id="hostname" name="hostname" value="<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
" style="width:80px;">

<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 0) {?>
<?php if ($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub') {?>
&nbsp;应用发布服务器：<select  class="wbk"  id="appserverip" name="appserverip" style="width:80px;">
  <option value="">未指定</option>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['l'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['l']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['name'] = 'l';
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['appservers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
<option value="<?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['appserverip'];?>
"><?php echo $_smarty_tpl->tpl_vars['appservers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['appserverip'];?>
</option>
<?php endfor; endif; ?>
</select>&nbsp;
<?php } else { ?>
 &nbsp;负载均衡：<select  class="wbk"  id="lb" name="lb" style="width:80px;">
  <option value="">未指定</option>
<option value="<?php echo $_smarty_tpl->tpl_vars['localip']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['localip']->value;?>
</option>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['l'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['l']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['name'] = 'l';
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['lb']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
<option value="<?php echo $_smarty_tpl->tpl_vars['lb']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['ip'];?>
"><?php echo $_smarty_tpl->tpl_vars['lb']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['ip'];?>
</option>
<?php endfor; endif; ?>
</select>&nbsp;
<?php }?>
<span id="slogin_template" style="display:none">登录方式：<select  class="wbk"  id="app_act" style="width:80px;">
					<option value="applet">applet</option>
					<option value="activeX">activeX</option>
					</select></span>
<?php }?>&nbsp;<input type="submit" height="35" align="middle" value=" 确定 " border="0" class="bnnew2"/><?php if ($_SESSION['ADMIN_LEVEL'] == 0) {?>&nbsp;磁盘映射:<input type="checkbox" name="rdpdiskauth_" id="rdpdiskauth_" <?php if (!$_smarty_tpl->tpl_vars['member']->value['rdpdiskauth_up']) {?>disabled<?php }?> <?php if ($_smarty_tpl->tpl_vars['rdpdiskauth_up']->value) {?>checked<?php }?> value="1"  />&nbsp;剪切版:<input type="checkbox" name="rdpclipauth_" id="rdpclipauth_" <?php if (!$_smarty_tpl->tpl_vars['member']->value['rdpclipauth_up']) {?>disabled<?php }?>  onclick="checkieNT52(this)" <?php if ($_smarty_tpl->tpl_vars['member']->value['rdpclipauth_up']) {?>checked<?php }?> value="1"  />&nbsp;本地:<input type="checkbox" name="consoleauth_" id="consoleauth_" <?php if (!$_smarty_tpl->tpl_vars['member']->value['rdplocal']) {?>disabled<?php } else {
if ($_smarty_tpl->tpl_vars['member']->value['rdplocalcheck']) {?>checked<?php }
}?>  />&nbsp;<select  class="wbk"  name='fenbianlv' id='fenbianlv' > 
					<option value="3" <?php if ($_smarty_tpl->tpl_vars['member']->value['rdp_screen'] == 3) {?>selected<?php }?>>全屏</option>
					<option value="1" <?php if ($_smarty_tpl->tpl_vars['member']->value['rdp_screen'] == 1) {?>selected<?php }?>>800*600</option>
					<option value="2" <?php if ($_smarty_tpl->tpl_vars['member']->value['rdp_screen'] == 2) {?>selected<?php }?>>1024*768</option>
					</select>&nbsp;
					<?php if (!($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub' || $_smarty_tpl->tpl_vars['logintype']->value == 'rdp' || $_smarty_tpl->tpl_vars['logintype']->value == 'x11' || $_smarty_tpl->tpl_vars['logintype']->value == 'vnc')) {?>
					<select  class="wbk"  name='login_type' id='login_type' > 
					<option value="web" <?php if ($_smarty_tpl->tpl_vars['member']->value['default_appcontrol'] == 0) {?>selected<?php }?>>WEB</option>
					<option value="rdp" <?php if ($_smarty_tpl->tpl_vars['member']->value['default_appcontrol'] == 1) {?>selected<?php }?>>RDP</option>
					</select>&nbsp;
					<?php }?>
					域名连接:<input type="checkbox" name="bydomain" id="bydomain" <?php if ($_smarty_tpl->tpl_vars['bydomain']->value) {?>checked<?php }?> value="1"  /><?php }?>
</form>
	  </td>
  </tr>
  <tr>
	<td class="">
<TABLE border=0 cellSpacing=1 cellPadding=5 width="100%" bgColor=#ffffff valign="top" class="BBtable">
<form name='usrdev' >
                <TBODY>
		<?php if ($_smarty_tpl->tpl_vars['logintype']->value != 'apppub' && $_smarty_tpl->tpl_vars['logintype']->value != '_apppub') {?>		
                  <TR>
					<?php if ($_SESSION['ADMIN_LEVEL'] == 1) {?><th class="list_bg"  width="5%">选</th><?php }?>
					<th class="list_bg"  width="5%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=id&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >ID</a></th>
         			<?php if ($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub') {?>
					 <th class="list_bg"  width="13%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=name&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >应用程序</a></th>
					  <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >目标地址</a></th>
					 <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=appserverip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >应用发布服务</a></th>
					 
					<?php } else { ?>
					<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >服务器地址</a></th>
					<?php }?>
                   <?php if ($_smarty_tpl->tpl_vars['logintype']->value != 'apppub' && $_smarty_tpl->tpl_vars['logintype']->value != '_apppub') {?>
					 <th class="list_bg"  width="20%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=hostname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >主机名</a></th>
					 <?php if ($_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
					 <th class="list_bg"  width="7%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=hostname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >设备组</a></th>
					 <?php }?>
					<?php }?>
					
					<th class="list_bg"  width="10%">主机信息</th>
                    <?php if ($_smarty_tpl->tpl_vars['type']->value != 'fort') {?>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=username&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >登陆用户</a></th>
                    <?php }?>   
					<?php if ($_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
					 <th class="list_bg"  width="7%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=hostname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >系统</a></th>
					 <?php }?>
				    <th class="list_bg"  width="7%"><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&logintype=<?php echo $_GET['logintype'];?>
&orderby1=login_method&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >登录协议</a></th>
					 <?php if ($_SESSION['ADMIN_LEVEL'] != 10 && $_SESSION['ADMIN_LEVEL'] != 101) {?>
					<th class="list_bg"  width="7%">连接检测</th>
					 <?php }?>
					<?php if ($_SESSION['CACTI_CONFIG_ON'] && $_SESSION['LICENSE_KEY_NETMANAGER']) {?>
					<th class="list_bg"  width="4%">状态</th>
					 <?php }?>

                   	<th class="list_bg"  width="20%"><?php if ($_SESSION['ADMIN_LEVEL'] != 0) {?>操作<?php } else { ?>工具<?php }?></th>
                  </TR>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alldev']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
			<tr bgcolor='<?php if (!$_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable']) {?>#cccccc<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['passwordtry'] == 1 || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['passwordtry'] == 2) {?>red<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>' onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if (!$_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable']) {?>#cccccc<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['passwordtry'] == 1 || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['passwordtry'] == 2) {?>red<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>');"><?php if ($_SESSION['ADMIN_LEVEL'] == 1) {?>
				<td><?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'RDP' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'ssh' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'telnet') {?><input type="checkbox" name="session[]" value="<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'];?>
_<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" ><?php }?></td><?php }?>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
</td>
				<?php if ($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub') {?>
				<td></td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appserverip'];?>
</td>
				<?php }?>
				
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
</td>
				<?php if ($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub') {?>					 
				<?php } else { ?>
				<td><span  title="<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['hostname'];?>
" ><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['hostname'];?>
</span></td>
				<?php }?>
				<?php if ($_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['groupname'];?>
</td>
				<?php }?>
				<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showdesc&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
");return false;' target="hide"><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['desc'],15,"...",'');?>
</a></td>
				
				
				<?php if ($_smarty_tpl->tpl_vars['type']->value != 'fort') {?>
				<td><?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'] == '') {?>空用户<?php } else {
echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];
}?></td>
				<?php }?>
				
				<?php if ($_SESSION['ADMIN_LEVEL'] == 10 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_type'];?>
</td>
				<?php }?>
				<td><font style="font-size:12px;" <?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['puttyhong'] == 1) {?>color="red"<?php }?> ><?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'apppub') {?>应用发布<?php } else {
echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'];
}?><font>				
				</td>
				<?php if ($_SESSION['ADMIN_LEVEL'] != 10 && $_SESSION['ADMIN_LEVEL'] != 101) {?>
				<td><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/list_ico2.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=test_port&ip=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
&port=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['port'];?>
&devicesid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
");return false;' target="hide"><font color="<?php if (!$_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['workflow_status']) {?>blue<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['workflow_status'] == 4) {?>green<?php } else { ?>red<?php }?>">检测</font></a></td>
				<?php }?>
				<?php if ($_SESSION['CACTI_CONFIG_ON'] && $_SESSION['LICENSE_KEY_NETMANAGER']) {?>
				<td align=center><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/<?php if (!$_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['monitor']) {?>Gray.gif<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 1) {?>Green.gif<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 2) {?>GreenYellow.gif<?php } else { ?>Red.gif<?php }?>' style="cursor:hand;" onclick="window.open ('admin.php?controller=admin_detail&ip=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];
if (mb_strtolower($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_type'], 'UTF-8') == 'cisco') {?>&action=ciscoindex<?php }?>', 'newwindow', 'height=' + screen.height + ',width=' + screen.width+'top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" ></td>
				<?php }?>
				<td class="td_line" width="30%">
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 0) {?>					
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'RDP' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'X11') {?>					
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable'] && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['twopriority']) {?>
					<a id="a<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
1" onclick="rdpgo(<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
,0,true);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
' ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/mstsc_ico.gif" border=0 title="MSTSC:<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['connections'];?>
"></a>
					<?php if ($_smarty_tpl->tpl_vars['windows_version']->value != '5.2') {?>
					
					<?php }?>					
					<?php } else { ?>
										
					<?php }?>
					
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'ssh1' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'ssh' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'telnet' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'rlogin') {?>	<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable'] && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['twopriority']) {?>
					<a id="x<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" href="admin.php?controller=admin_pro&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&logintool=xshell&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/xshell.png" title="Xshell" border=0></a>&nbsp;&nbsp;&nbsp;
					<a id="p<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" href="admin.php?controller=admin_pro&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&logintool=putty&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/putty_ico.gif" title="PUTTY" border=0></a>&nbsp;&nbsp;&nbsp;
					 <a id="s<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" href="admin.php?controller=admin_pro&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&logintool=securecrt&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" onclick="return goto3(this.id)"  target="hide" ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scrt_ico.gif" title="SECURECRT" border=0></a>
					 <?php } else { ?>
					 <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/putty_ico.gif" title="PUTTY" border=0>&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scrt_ico.gif"  title="SECURECRT" border=0>
					<?php }?>
					<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'ftp' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'sftp') {?>
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable'] && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['twopriority']) {?>
					<a id="c<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=xftp&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/xftp.png"  title="XFTP" border=0></a>&nbsp;&nbsp;&nbsp;
					<a id="a<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=winscp&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/winscp_ico.gif"  title="WINSCP" border=0></a>&nbsp;&nbsp;&nbsp;
					<a id="b<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=flashxp&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/flashfxp_icon.png" title="FLASHXP" border=0></a>
					<?php } else { ?>
					<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/xftp.png"  title="XFTP" border=0>&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/winscp_ico.gif"  title="WINSCP" border=0>&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/flashfxp_icon.png" title="FLASHXP" border=0>
					<?php }?>
					<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'RDP2008' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'vnc' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'Web' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'Sybase' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'Oracle' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'DB2' || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'apppub') {?>
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable'] && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['twopriority']) {?>
					<a id="a<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
1" onclick="rdpgo(<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
,0,false);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'><font style="font-size:12px;" <?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['puttyhong'] == 1) {?>color="red"<?php }?> ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/mstsc_ico.gif" title="MSTSC" border=0></font></a>&nbsp;&nbsp;&nbsp;
					<?php } else { ?>
					
					<?php }?>	
					<?php }?>			
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'ssh' && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sftp']) {?>
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable'] && $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['twopriority']) {?>
					&nbsp;&nbsp;<a id="c<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=xftp&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/xftp.png"  title="XFTP" border=0></a>
					&nbsp;&nbsp;<a id="a<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=winscp&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/winscp_ico.gif" title="WINSCP" border=0></a>&nbsp;&nbsp;&nbsp;<a id="b<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=flashxp&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/flashfxp_icon.png" title="FLASHXP" border=0></a>
					<?php } else { ?>
					<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/xftp.png"  title="XFTP" border=0>&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/winscp_ico.gif" title="WINSCP" border=0>&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/flashfxp_icon.png" title="FLASHXP" border=0>
					<?php }?>	

					<?php }?>	
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['change_password']) {?>
					<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a  onclick="window.open ('admin.php?controller=admin_pro&action=change_device_pwd&sid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href='#'>修改密码</a>
					<?php }?>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 10 || $_smarty_tpl->tpl_vars['admin_level']->value == 101) {?>
					<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/down.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showpwddownauth");return false;'>下载密码</a>
					| <img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/list_ico2.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=dev_checkpass&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'>查看密码</a>
					| <img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=pass_edit&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&from=passview'>修改</a>
					<?php }?>
</td> 
			</tr>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['tt'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['name'] = 'tt';
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appmember']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total']);
?>
			<tr bgcolor='<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['passwordtry'] == 1 || $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['passwordtry'] == 2) {?>red<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>'>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appmember'][$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appdeviceid'];?>
</td>
				<td><span  title="<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appmember'][$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['name'];?>
" ><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appmember'][$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['name'];?>
</span></td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appmember'][$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['device_ip'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appmember'][$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appserverip'];?>
</td>
				
				<?php if ($_smarty_tpl->tpl_vars['type']->value != 'fort') {?>
				<td><?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'] == '') {?>空用户<?php } else {
echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];
}?></td>
				<?php }?>
				<td><?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['entrust_password']) {?>自动登录<?php } else { ?>手填密码<?php }?></td>
				<td><?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'apppub') {?>应用发布<?php } else {
echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'];
}?></td>
				<td class="td_line" width="30%">
					<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 0) {?>
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'apppub') {?>	
					<?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable']) {?>
					<a id="a<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
0<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appmember'][$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appdeviceid'];?>
1" onclick="rdpgo(<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['appmember'][$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appdeviceid'];?>
,false);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/mstsc_ico.gif" title="MSTSC" border=0></a> | 
<?php } else { ?>
<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/mstsc_ico.gif" title="MSTSC" border=0> <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ie.png" border=0>
<?php }?>
					<?php }?>
					<?php }?>
					
</td> 
			</tr>
			<?php endfor; endif; ?>
			<?php endfor; endif; ?>

			<?php } else { ?>
<style type="text/css">
<!--
#navi{width:auto;}
.ul {
 list-style-type: none;margin:0; padding:0
}
.li {
 float:left;width: 100px;
}

-->
</style>
<tr>
						<th class="list_bg"  width="8%" ><a href='admin.php?controller=admin_index&action=main&orderby1=id&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >ID</a></th>
						<th class="list_bg"  width="12%" ><a href='admin.php?controller=admin_index&action=main&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >服务器IP</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_index&action=main&orderby1=hostname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >主机名</a></th>
						<th class="list_bg"  width="12%" ><a href='admin.php?controller=admin_index&action=main&orderby1=appserverip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >应用发布IP</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_index&action=main&orderby1=desc&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >主机信息</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_index&action=main&orderby1=name&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >应用名称</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_index&action=main&orderby1=name&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >程序名称</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_index&action=main&orderby1=name&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
' >用户名</a></th>
						<th class="list_bg"  width="24%" ><?php echo $_smarty_tpl->tpl_vars['language']->value['Operate'];
echo $_smarty_tpl->tpl_vars['language']->value['Link'];?>
</th>
					</tr>
					<?php $_smarty_tpl->tpl_vars["i"] = new Smarty_Variable(1, null, 0);?>
			<?php if ($_GET['page'] < 1 || !$_GET['page']) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alldev']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
			<tr <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->tpl_vars['i']->value++%2 == 0) {?>f7f7f7<?php }?>');">
			<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
</td>
				
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
</td>
				
				<td><span  title="<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['hostname'];?>
" ><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['hostname'];?>
</span></td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
</td>
				<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showdesc&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
");return false;' target="hide"><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['desc'],15,"...",'');?>
</a></td>
				<td>桌面</td>
				<td></td>
				<td></td>
				<td><a id="a<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
2"  href="#" onclick="return rdpOne(<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
, 0, false);" target="_blank"><img  src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/windows.jpg"  width=16 height='16' ></a></td>
			</tr>
			<?php endfor; endif; ?>
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['tt'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['name'] = 'tt';
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['appmember']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total']);
?>
			<tr <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?> onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->tpl_vars['i']->value++%2 == 0) {?>f7f7f7<?php }?>');">
			<td><?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appdeviceid'];?>
</td>
			<td><?php echo addslashes($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['device_ip']);?>
</td>
			<td><?php echo addslashes($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['hostname']);?>
</td>
			<td ><?php echo addslashes($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appserverip']);?>
</td>
			<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showdesc&appdeviceid=<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appdeviceid'];?>
");return false;' target="hide"><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['desc'],15,"...",'');?>
</a></td>
			<td><?php echo addslashes($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['name']);?>
</td>
			<td><?php echo addslashes($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appprogramname']);?>
</td>
			<td><?php if ($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['username'] == '') {?>空用户<?php } else {
echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['username'];
}?></td>
			<td><a  id="a<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['devid'];?>
0<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appdeviceid'];?>
2" href="#" onclick="return rdpOne(<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['devid'];?>
, <?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appdeviceid'];?>
, false);" target="_blank">
<img src="upload/<?php if ($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['icon']) {
echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['icon'];
} else { ?>nopic.jpg<?php }?>"  width=16 height='16'  id="img_<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['devid'];?>
0<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appdeviceid'];?>
" onmouseover="popit('img_<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['devid'];?>
0<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appdeviceid'];?>
', '<?php echo addslashes($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['name']);?>
', '<?php echo addslashes($_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['path']);?>
', '<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['appserverip'];?>
', '<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['device_ip'];?>
', '<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['url'];?>
')" onmouseout="closeit()" title="<?php echo $_smarty_tpl->tpl_vars['appmember']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['name'];?>
">
			</td>
			</tr>
			<?php endfor; endif; ?>

			<?php }?>
                <tr>
<?php if ($_smarty_tpl->tpl_vars['logintype']->value != 'apppub' && $_smarty_tpl->tpl_vars['logintype']->value != '_apppub') {?>

				<td colspan="3">
				<?php if ($_SESSION['ADMIN_LEVEL'] == 1) {?>
				<input type="checkbox" name="select_all" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.usrdev.elements[i];if(e.name=='session[]')e.checked=document.usrdev.select_all.checked;}" >&nbsp;&nbsp;<input type="button" value="登录选中" onclick="multidevlogin()" class="an_06">
				<?php }?>
				</td>
<?php }?>
	           <td colspan="10" align="right">
		   			<?php if ($_SESSION['ADMIN_LEVEL'] == 10) {?><input type="button"  value="密码打印" onClick="alert('未发现可驱动的密码打印机');" class="an_06"><?php }?>&nbsp;&nbsp;&nbsp;共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
个记录  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php if ($_smarty_tpl->tpl_vars['logintype']->value != 'apppub') {
echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
个记录/页<?php }?>  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&page='+this.value;return false;}">页
		   </td>
		</tr>
		</TBODY>
              </TABLE>
	</td>
  </tr>
  </form>
</table>

<?php echo '<script'; ?>
 language="javascript">

function multidevlogin(){
	var elms = document.getElementsByTagName("input");
	for(var i=0; i<elms.length; i++){
		if(elms[i].name.substring(0,7)=='session'&&elms[i].checked){
			var args = elms[i].value.split("_");
			var url = '';
			if(args[0]=='RDP'){
				var consoleauth = document.getElementById('consoleauth_').checked ? '1' : '0';
				var fenbian = document.getElementById('fenbianlv').options[document.getElementById('fenbianlv').selectedIndex].value;
				var hid = document.getElementById('hide');
				var lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
				var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
				var rdpclipauth = document.getElementById('rdpclipauth_').checked ? '1' : '0';
				var rdpdiskauth = document.getElementById('rdpdiskauth_').checked ? '1' : '0';
				var bydomain = document.getElementById('bydomain').checked ? '1' : '0';
				url='admin.php?controller=admin_pro&action=dev_login&id='+args[1]+'&screen='+fenbian+'&selectedip='+lbip+'&app_act='+app_act+'&rdparg=0&appdeviceid=0&rdpclipauth='+rdpclipauth+'&rdpdiskauth='+rdpdiskauth+'&bydomain='+bydomain;
				url +='&consoleauth='+consoleauth;			
			}else{
				var lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
				var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
				var bydomain = document.getElementById('bydomain').checked ? '1' : '0';
				var url = "admin.php?controller=admin_pro&action=dev_login&id="+args[1]+"&logintool=securecrt&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
"+'&selectedip='+lbip+'&app_act='+app_act+'&bydomain='+bydomain+'&'+Math.round(new Date().getTime()/1000);
			}
			$.get(url, {Action:"get",Name:"lulu"}, function (data, textStatus){
				this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
				if(data.substring(0,10)=='freesvr://'){
					launcher(data);
				}else{
					eval(data);
				}
			});
			/*
			var ifr = document.createElement("IFRAME");  
			document.body.appendChild(ifr);  
			ifr.height=0;
			ifr.width=0;
			ifr.src = url;  
			*/
		}
	}
}

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
function rdpgo(iid,appdeviceid,isrdp){	
	if(isrdp){
		var consoleauth = document.getElementById('consoleauth_').checked ? '1' : '0';
	}
	var fenbian = document.getElementById('fenbianlv').options[document.getElementById('fenbianlv').selectedIndex].value;
	var hid = document.getElementById('hide');
	var lbip = '';
	<?php if (!($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub')) {?>
	lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	<?php }?>
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var rdpclipauth = document.getElementById('rdpclipauth_').checked ? '1' : '0';
	var rdpdiskauth = document.getElementById('rdpdiskauth_').checked ? '1' : '0';
	var bydomain = document.getElementById('bydomain').checked ? '1' : '0';
	
	var weburl='admin.php?controller=admin_pro&action=dev_login&id='+iid+'&screen='+fenbian+'&selectedip='+lbip+'&app_act='+app_act+'&rdparg=0&appdeviceid='+appdeviceid+'&rdpclipauth='+rdpclipauth+'&rdpdiskauth='+rdpdiskauth+'&bydomain='+bydomain;
	if(isrdp){
		weburl +='&consoleauth='+consoleauth;
	}
	var url =weburl+'&'+Math.round(new Date().getTime()/1000);;
//alert(hid.src);
	$.get(url, {Action:"get",Name:"lulu"}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		if(data.substring(0,10)=='freesvr://'){
			launcher(data);
		}else{
			eval(data);
		}
	});
	return false;	
}
function rdpgo2(iid,appdeviceid,isrdp){
	if(isrdp){		
		if(appdeviceid>0){
			var aid = 'a'+iid+"0"+appdeviceid+'2';			
		}else{
			var aid = 'a'+iid+'2';
		}		
		var consoleauth = document.getElementById('consoleauth_').checked ? '1' : '0';
	}else{		
		if(appdeviceid>0){
			var aid = 'a'+iid+"0"+appdeviceid+'2';
		}else{
			var aid = 'a'+iid+'2';
		}
	}
	var fenbian = document.getElementById('fenbianlv').options[document.getElementById('fenbianlv').selectedIndex].value;
	var hid = document.getElementById('hide');
	var lbip = '';
	<?php if (!($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub')) {?>
		lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	<?php }?>
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var rdpclipauth = document.getElementById('rdpclipauth_').checked ? '1' : '0';
	var rdpdiskauth = document.getElementById('rdpdiskauth_').checked ? '1' : '0';
	var bydomain = document.getElementById('bydomain').checked ? '1' : '0';
	
	document.getElementById(aid).href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id='+iid+'&screen='+fenbian+'&selectedip='+lbip+'&app_act='+app_act+'&rdparg=0&appdeviceid='+appdeviceid+'&rdpclipauth='+rdpclipauth+'&rdpdiskauth='+rdpdiskauth+'&bydomain='+bydomain;
	if(isrdp){
		document.getElementById(aid).href+='&consoleauth='+consoleauth;
	}
	document.getElementById(aid).href+='&'+Math.round(new Date().getTime()/1000);
	//alert(hid.src);
	<?php if ($_smarty_tpl->tpl_vars['logindebug']->value) {?>
		window.open(document.getElementById(aid).href);
	<?php }?>
	return true;	
}

function goto3(iid){
	var idnumber = iid.substring(1);
	var lbip = '';
	<?php if (!($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub')) {?>
	lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	<?php }?>
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var bydomain = document.getElementById('bydomain').checked ? '1' : '0';
	var url =document.getElementById(iid).href+'&selectedip='+lbip+'&app_act='+app_act+'&bydomain='+bydomain+'&'+Math.round(new Date().getTime()/1000);
	$.get(url, {Action:"get",Name:"lulu"}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		if(data.substring(0,10)=='freesvr://'){
			launcher(data);
		}else{
			eval(data);
		}
	});
	return false;	
}
<?php if ($_smarty_tpl->tpl_vars['member']->value['default_control'] == 0) {?>
if(navigator.userAgent.indexOf("MSIE")>0) {
    document.getElementById('app_act').options.selectedIndex = 1;
}
<?php } elseif ($_smarty_tpl->tpl_vars['member']->value['default_control'] == 1) {?>
document.getElementById('app_act').options.selectedIndex = 0;
<?php } elseif ($_smarty_tpl->tpl_vars['member']->value['default_control'] == 2) {?>
document.getElementById('app_act').options.selectedIndex = 1;
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['logintype']->value == 'apppub' || $_smarty_tpl->tpl_vars['logintype']->value == '_apppub') {?>
window.parent.menu.document.getElementById('devtreetable').style.display = 'none';
window.parent.menu.document.getElementById('apptreetable').style.display = '';
<?php } else { ?>
window.parent.menu.document.getElementById('devtreetable').style.display = '';
window.parent.menu.document.getElementById('apptreetable').style.display = 'none';
<?php }?>

function rdpOne(devid, appdeviceid, isrdp){
	var logintype = document.getElementById('login_type');
	if(logintype!=undefined&&logintype.options[logintype.options.selectedIndex].value=='web'){
		if(appdeviceid>0){
			return rdpgo2(devid, appdeviceid,isrdp);
		}else{
			return rdpgo2(devid, 0, false);
		}

	}else{
		if(appdeviceid>0){
			return rdpgo(devid, appdeviceid,isrdp);
		}else{
			return rdpgo(devid, 0, isrdp);
		}
		
	}
}

function mousePosition(ev){
    if(ev.pageX || ev.pageY){
        return {x:ev.pageX, y:ev.pageY};
    }
    return {
        x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
        y:ev.clientY + document.body.scrollTop  - document.body.clientTop
    };
}

function popit(id, program, path, appserverip, device_ip, url){
	//easyDialog.close();
	var e = window.event || arguments.callee.caller.arguments[0];
	var ev = mousePosition(e);
	document.getElementById('pop_programname').innerHTML=program;

	document.getElementById('pop_path').innerHTML=path;
	document.getElementById('pop_appserverip').innerHTML=appserverip;
	document.getElementById('pop_device_ip').innerHTML=device_ip;
	document.getElementById('pop_url').innerHTML=url;
	var classname='hide_box'
	pageWidth = document.documentElement.offsetWidth;
	pageHight = document.documentElement.offsetHeight;
	divWidth = jQuery("." + classname).width();
	divHight = jQuery("." + classname).height();
	if (ev.x + divWidth/2 < pageWidth) {
		pagex = ev.x-divWidth/2;
	} else {
		pagex = ev.x - divWidth;
	}
	pagey = ev.y ;
	//alert(document.getElementById('testBox').style.display);
	jQuery("." + classname).css("position", "absolute").css("top", pagey + "px").css("left", pagex + "px").show();

}

function closeit(){
	document.getElementById('testBox').style.display='none';
}

<?php echo '</script'; ?>
>
<style>
.hide_box{width:350;color:#fff;color:#444;background:#fff;box-shadow:1px 2px 2px #555;display:none;}
.hide_box h4{height:26px;line-height:26px;overflow:hidden;background:#0884C4;color:#fff;padding:0 10px;border:1px solid #0884C4;font-size:14px;border-bottom:1px solid #0884C4;}
.hide_box h4 a{width:14px;line-height:13px;_line-height:15px;height:13px;font-family:arial;overflow:hidden;display:block;background:#fff;color:#c77405;float:right;text-align:center;text-decoration:none;margin-top:7px;font-size:14px;font-weight:normal;border-radius:2px;_font-size:12px;}
.hide_box p{font-size:13px;border:1px solid #ccc;}
</style>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.7.2.min.js"><?php echo '</script'; ?>
>
<div class="hide_box" id="testBox">
	<h4><a href="javascript:void(0);" onclick="closeit();" title="关闭窗口">&times;</a>提示</h4>
	<p align="left"><b>程序名称：</b><span id="pop_programname"></span><br />
	<b>程序路径：</b><span id="pop_path"></span><br />
	<b>应用服务器：</b><span id="pop_appserverip"></span><br />
	<b>目标服务器IP：</b><span id="pop_device_ip"></span><br />
	<b>URL：</b><span id="pop_url"></span></p>
</div>
</body>
<iframe id="hide" name="hide" height="0"  frameborder="0" scrolling="no"></iframe>
<input style="width:0;height:0;display:none" id="protocol" value="" />
</html>



<?php }
}
?>