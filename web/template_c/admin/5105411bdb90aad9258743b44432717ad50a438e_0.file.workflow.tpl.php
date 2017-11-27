<?php /* Smarty version 3.1.27, created on 2016-12-04 21:34:17
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/workflow.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:212040923258441b59581a42_70448870%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5105411bdb90aad9258743b44432717ad50a438e' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/workflow.tpl',
      1 => 1480858453,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212040923258441b59581a42_70448870',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'backupdb_id' => 0,
    'gid' => 0,
    'curr_url' => 0,
    'admin_level' => 0,
    'localip' => 0,
    'lb' => 0,
    'member' => 0,
    'rdpdiskauth_up' => 0,
    'orderby2' => 0,
    's' => 0,
    'windows_version' => 0,
    'type' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
    'logindebug' => 0,
    'logintype' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_58441b597702a8_86386324',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_58441b597702a8_86386324')) {
function content_58441b597702a8_86386324 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once '/opt/freesvr/web/htdocs/freesvr/audit/dep10/smarty/plugins/modifier.truncate_cn.php';

$_smarty_tpl->properties['nocache_hash'] = '212040923258441b59581a42_70448870';
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
 src="./template/admin/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/cn.js"><?php echo '</script'; ?>
>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<?php echo '<script'; ?>
 type="text/javascript">
function search_session(){
	var url = "admin.php?controller=admin_workflow&action=search_sessions&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
&wid="+document.getElementById('wid').value;
	url += "&start="+document.getElementById('f_rangeStart').value;
	url += "&end="+document.getElementById('f_rangeEnd').value;
	//document.getElementById('search').submit();
	closeWindow();
	loadurl(url, 600);
	//alert(document.search.action);
	//return false;
	return true;
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

function showImg(wTitle, c, width)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=400;
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
	mesW.innerHTML='<div id="light" class="white_content" style="height:240px;width:'+width+'px"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#eeeeee" align="right" height="25"><a href="javascript:void(0)" onclick="closeWindow()">关闭</a></td></tr></table>'+c+"</div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
	
	document.getElementById('fade').style.display='block'
	return false;
}
function loadurl(url,width){
	$.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		showImg('',data,width);
		if(width==600){
			var cal = Calendar.setup({
				onSelect: function(cal) { cal.hide() },
				showTime: true
			});
			cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
			cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");		
		}
	});
}
<?php echo '</script'; ?>
>
</head>

<body>
<div id="fade" class="black_overlay"></div> 
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
<?php if ($_GET['logintype'] != 'apppub') {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&all=1">设备列表</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
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

<li class=<?php if ($_GET['logintype'] != '_apppub') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != '_apppub') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=_apppub&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">应用</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != '_apppub') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<?php } else { ?>
<li class=<?php if ($_GET['logintype'] != 'apppub') {?>"me_b"<?php } else { ?>"me_a"<?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1<?php if ($_GET['logintype'] != 'apppub') {?>1<?php }?>.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=apppub&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
">应用发布设备</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3<?php if ($_GET['logintype'] != 'apppub') {?>3<?php }?>.jpg" align="absmiddle"/></li>
<?php }?>
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
<?php }
}?>
<li class=me_a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow">运维流程</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>

	 <tr>
    <td class="main_content">
<form  name="f1" action="<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
" method="post" name="report" onsubmit="return search();" >
<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 0) {?>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;负载均衡：<select  class="wbk"  id="lb" name="lb" >
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
</select>&nbsp;&nbsp;&nbsp;&nbsp;<span id="slogin_template" style="display:none">登录方式：<select  class="wbk"  id="app_act" >
					<option value="applet">applet</option>
					<option value="activeX">activeX</option>
					</select></span>
<?php }?>&nbsp;&nbsp;<input type="submit" height="35" align="middle" value=" 确定 " border="0" class="bnnew2"/><?php if ($_SESSION['ADMIN_LEVEL'] == 0) {?>&nbsp;&nbsp;&nbsp;&nbsp;磁盘映射:<input type="checkbox" name="rdpdiskauth_" id="rdpdiskauth_" <?php if (!$_smarty_tpl->tpl_vars['member']->value['rdpdiskauth_up']) {?>disabled<?php }?> <?php if ($_smarty_tpl->tpl_vars['rdpdiskauth_up']->value) {?>checked<?php }?> value="1"  />&nbsp;&nbsp;&nbsp;&nbsp;剪切版:<input type="checkbox" name="rdpclipauth_" id="rdpclipauth_" <?php if (!$_smarty_tpl->tpl_vars['member']->value['rdpclipauth_up']) {?>disabled<?php }?>  onclick="checkieNT52(this)" <?php if ($_smarty_tpl->tpl_vars['member']->value['rdpclipauth_up']) {?>checked<?php }?> value="1"  />&nbsp;&nbsp;&nbsp;&nbsp;本地:<input type="checkbox" name="consoleauth_" id="consoleauth_" <?php if (!$_smarty_tpl->tpl_vars['member']->value['rdplocal']) {?>disabled<?php }?> value="1"  />&nbsp;&nbsp;<select  class="wbk"  name='fenbianlv' id='fenbianlv' > 
					<option value="3" <?php if ($_smarty_tpl->tpl_vars['member']->value['rdp_screen'] == 3) {?>selected<?php }?>>全屏</option>
					<option value="1" <?php if ($_smarty_tpl->tpl_vars['member']->value['rdp_screen'] == 1) {?>selected<?php }?>>800*600</option>
					<option value="2" <?php if ($_smarty_tpl->tpl_vars['member']->value['rdp_screen'] == 2) {?>selected<?php }?>>1024*768</option>
					</select>&nbsp;&nbsp;<select  class="wbk"  name='login_type' id='login_type' > 
					<option value="web" <?php if ($_smarty_tpl->tpl_vars['member']->value['default_appcontrol'] == 0) {?>selected<?php }?>>WEB</option>
					<option value="rdp" <?php if ($_smarty_tpl->tpl_vars['member']->value['default_appcontrol'] == 1) {?>selected<?php }?>>RDP</option>
					</select><?php }?>
</form>
	  </td>
  </tr>
 
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_workflow&action=workflow_delete" method="post">
                <TBODY>
                  <TR>
			
                    <th class="list_bg" width="5%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=groupname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >选</a></TD>
                    <th class="list_bg" width="10%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=dateline&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >申请时间</a></TD>
					<th class="list_bg" width="10%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=dateline&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >结束时间</a></TD>
                    <th class="list_bg" width="8%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=device_ip&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >设备IP</a></TD>
                    <th class="list_bg" width="8%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=username&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >用户名</a></TD>
                    <th class="list_bg" width="8%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=login_template.login_method&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >登录方式</a></TD>
                    <th class="list_bg" width="8%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=name&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >操作内容</a></TD>
                    <th class="list_bg" width="10%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=status&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >状态</a></TD>
                    <th class="list_bg" width="20%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=desc&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" >描述</a></TD>
					<th class="list_bg" width="15%">操作</TD>
                  </TR>

            </tr>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['s']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
			<tr  <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
				<td width="5%"><?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 0) {?><input type="checkbox" name="chk_gid[]" value="<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
"><?php }?></td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dateline'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['deadline'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'];?>
</td>
				 <td> <?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['name'];?>
</td>
				 <td> <a href='#' onclick='loadurl("admin.php?controller=admin_workflow&action=show_workflow_log&wid=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
", 600);return false;'><?php if (!$_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status']) {?>未审批<?php } elseif ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 1) {?>关单<?php } elseif ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 2) {?>驳回<?php } elseif ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 3) {?>审批中<?php } elseif ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 4) {?>审批完成<?php }?></a></td>
				  <td> <span title="<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['desc'];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['desc'],"20","...");?>
</span></td>
				<td style="TEXT-ALIGN: left;">
				<?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] < 4) {?>
				<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_workflow&action=workflow_edit&sid=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" ><?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['status'] == 2) {?>重新申请<?php } else { ?>编辑<?php }?></a>
				<?php } else { ?>
				<?php if ($_smarty_tpl->tpl_vars['admin_level']->value == 0) {?>	
					<?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'RDP' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'X11') {?>					<?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable']) {?>
					<a id="a<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
1" onclick="rdpgo(<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
,0,true);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
'><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/mstsc_ico.gif" border=0 title="MSTSC"></a><?php if ($_smarty_tpl->tpl_vars['windows_version']->value != '5.2') {?>&nbsp;&nbsp;&nbsp;<a id="a<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
2" onclick="rdpgo2(<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
,0,true)" href='#' target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ie_ico.png" title="ACTIVEX" border=0></a><?php }?>					<?php } else { ?>
					(<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'];?>
<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ie_ico.png" title="ACTIVEX" border=0>					<?php }?>
				
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'ssh1' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'ssh' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'telnet' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'rlogin') {?>	<?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable']) {?>
					<a id="p<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
" href="admin.php?controller=admin_pro&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
&logintool=putty&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/putty_ico.gif" title="PUTTY" border=0></a>&nbsp;&nbsp;&nbsp;
			
					 <a id="s<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
" href="admin.php?controller=admin_pro&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
&logintool=securecrt&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" onclick="return goto3(this.id)"  target="hide" ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scrt_ico.gif" title="SECURECRT" border=0></a></a>
					 <?php } else { ?>
					 <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/putty_ico.gif" title="PUTTY" border=0>&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scrt_ico.gif"  title="SECURECRT" border=0>
					<?php }?>
					<?php } elseif ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'ftp' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'sftp') {?>
					<?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable']) {?>
					<a id="a<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=winscp&id=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/winscp_ico.gif"  title="WINSCP" border=0></a>&nbsp;&nbsp;&nbsp;<a id="b<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=flashxp&id=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/flashfxp_icon.png" title="FLASHXP" border=0></a>
					<?php } else { ?>
					<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/winscp_ico.gif"  title="WINSCP" border=0>&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/flashfxp_icon.png" title="FLASHXP" border=0>
					<?php }?>
					<?php } elseif ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'RDP2008' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'vnc' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'Web' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'Sybase' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'Oracle' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'DB2' || $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'apppub') {?>
					<?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable']) {?>
					<a id="a<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
1" onclick="rdpgo(<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
,0,false);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
'><font style="font-size:12px;" <?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['puttyhong'] == 1) {?>color="red"<?php }?> ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/mstsc_ico.gif" title="MSTSC" border=0></font></a> <?php if ($_smarty_tpl->tpl_vars['windows_version']->value != '5.2') {?><a id="a<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
2" onclick="rdpgo2(<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
,0,false)" href='#' target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ie_ico.png" title="ACTIVEX" border=0></a>
					
<?php }?>					<?php } else { ?>
					<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/mstsc_ico.gif" title="MSTSC" border=0>&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ie_ico.png" title="ACTIVEX" border=0>
					<?php }?>	
					<?php }?>			
					<?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['login_method'] == 'ssh' && $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sftp']) {?>
					<?php if ($_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['enable']) {?>
					&nbsp;&nbsp;&nbsp;<a id="a<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=winscp&id=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/winscp_ico.gif" title="WINSCP" border=0></a>&nbsp;&nbsp;&nbsp;<a id="b<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
" href='admin.php?controller=admin_pro&action=dev_login&logintool=flashxp&id=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['devicesid'];?>
'  onclick="return goto3(this.id)" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/flashfxp_icon.png" title="FLASHXP" border=0></a>
					<?php } else { ?>
					<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/winscp_ico.gif" title="WINSCP" border=0>&nbsp;&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/flashfxp_icon.png" title="FLASHXP" border=0>
					<?php }?>	
				
					<?php }?>
					
					<?php }?>
					
					 | 
					 <img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='#' onclick='loadurl("admin.php?controller=admin_workflow&action=search_sessions&wid=<?php echo $_smarty_tpl->tpl_vars['s']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
", 600);return false;' >关单</a>
				<?php }?>
				</td> 
			</tr>
			<?php endfor; endif; ?>
	          <tr>
	           <td  colspan="4" align="left">
		          <input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_gid[]')e.checked=this.form.select_all.checked;}" value="checkbox">全选&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除所选IP');if(chk_form()) document.ip_list.action='admin.php?controller=admin_workflow&action=workflow_delete'; else return false;" class="an_02">&nbsp;&nbsp;
					<input type="button" name="submit" onclick="location='admin.php?controller=admin_workflow&action=workflow_edit'" value="登录审批" class="an_02" />&nbsp;&nbsp;<input type="button" name="submit" onclick="location='admin.php?controller=admin_workflow&action=workflow_new'" value="权限审批" class="an_02" />
		   		</td>
				<td  colspan="7" align="right">
		   			共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
个记录  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_workflow&action=dev_group_index&page='+this.value;">页
		   </td>
		   		</tr>
	           
		</TBODY>
              </TABLE></form>	</td>
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

<?php echo '</script'; ?>
>
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
				url='admin.php?controller=admin_pro&action=dev_login&id='+args[1]+'&screen='+fenbian+'&selectedip='+lbip+'&app_act='+app_act+'&rdparg=0&appdeviceid=0&rdpclipauth='+rdpclipauth+'&rdpdiskauth='+rdpdiskauth;
				url +='&consoleauth='+consoleauth;			
			}else{
				var lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
				var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
				var url = "admin.php?controller=admin_pro&action=dev_login&id="+args[1]+"&logintool=securecrt&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
"+'&selectedip='+lbip+'&app_act='+app_act+'&'+Math.round(new Date().getTime()/1000);
			}
			var ifr = document.createElement("IFRAME");  
			document.body.appendChild(ifr);  
			ifr.height=0;
			ifr.width=0;
			ifr.src = url;  
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
	var lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var rdpclipauth = document.getElementById('rdpclipauth_').checked ? '1' : '0';
	var rdpdiskauth = document.getElementById('rdpdiskauth_').checked ? '1' : '0';
	
	var weburl='admin.php?controller=admin_pro&action=dev_login&id='+iid+'&screen='+fenbian+'&selectedip='+lbip+'&app_act='+app_act+'&rdparg=0&appdeviceid='+appdeviceid+'&rdpclipauth='+rdpclipauth+'&rdpdiskauth='+rdpdiskauth;
	if(isrdp){
		weburl +='&consoleauth='+consoleauth;
	}
	document.getElementById('hide').src=weburl+'&'+Math.round(new Date().getTime()/1000);;
//alert(hid.src);
	<?php if ($_smarty_tpl->tpl_vars['logindebug']->value) {?>
	window.open(document.getElementById('hide').src,'','rdp');
	<?php }?>
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
	var lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var rdpclipauth = document.getElementById('rdpclipauth_').checked ? '1' : '0';
	var rdpdiskauth = document.getElementById('rdpdiskauth_').checked ? '1' : '0';
	
	document.getElementById(aid).href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id='+iid+'&screen='+fenbian+'&selectedip='+lbip+'&app_act='+app_act+'&rdparg=0&appdeviceid='+appdeviceid+'&rdpclipauth='+rdpclipauth+'&rdpdiskauth='+rdpdiskauth;
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
	var lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	if(!lbip){
		//alert('请选择负载均衡');
		//return false;
	}
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	document.getElementById(iid).href=document.getElementById(iid).href+'&selectedip='+lbip+'&app_act='+app_act+'&'+Math.round(new Date().getTime()/1000);
	<?php if ($_smarty_tpl->tpl_vars['logindebug']->value) {?>
		window.open(document.getElementById(iid).href);
	<?php }?>
		return true;
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

<?php if ($_smarty_tpl->tpl_vars['logintype']->value == 'apppub') {?>

<?php }?>

function rdpOne(devid, appdeviceid, isrdp){
	var logintype = document.getElementById('login_type');
	if(logintype.options[logintype.options.selectedIndex].value=='web'){
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
</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>