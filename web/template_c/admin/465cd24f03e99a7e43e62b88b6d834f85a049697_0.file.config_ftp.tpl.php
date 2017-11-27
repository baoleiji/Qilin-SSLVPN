<?php /* Smarty version 3.1.27, created on 2016-12-16 00:08:14
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/config_ftp.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:16857835685852bfeee98cf1_88631158%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '465cd24f03e99a7e43e62b88b6d834f85a049697' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/config_ftp.tpl',
      1 => 1481818074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16857835685852bfeee98cf1_88631158',
  'variables' => 
  array (
    'template_root' => 0,
    'allmem' => 0,
    'current_time' => 0,
    'sshconfig' => 0,
    'autodelcycle' => 0,
    'eth0' => 0,
    'logintype' => 0,
    'priority_cache' => 0,
    'blankuser' => 0,
    'ldap' => 0,
    'Certificate' => 0,
    'Async' => 0,
    'rdpinput' => 0,
    'diskfull' => 0,
    'dpwdtime' => 0,
    'rdprunning' => 0,
    'loginauthtype' => 0,
    'radiustolocal' => 0,
    'rdpauthtips' => 0,
    'loginwrongtips' => 0,
    'member' => 0,
    'asyncoutpass' => 0,
    'accept' => 0,
    'member1' => 0,
    'member2' => 0,
    'member3' => 0,
    'member4' => 0,
    'member5' => 0,
    'rdpplayip' => 0,
    'fingersecserver' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5852bfef059ad5_04749879',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5852bfef059ad5_04749879')) {
function content_5852bfef059ad5_04749879 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '16857835685852bfeee98cf1_88631158';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
var isIe=(document.all)?true:false;

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
<?php endfor; endif; ?>

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

function loadurl(url){
	$.get(url, {"1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		showImg('',data);
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
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=config_ssh">认证配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=config_ftp">系统参数</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=login_times">密码策略</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=ha">高可用性</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=syslog_mail_alarm">告警配置</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=status_warning">告警参数</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=loadbalance">负载均衡</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>


 
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ntpset">
		<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>NTP设置:(<?php echo $_smarty_tpl->tpl_vars['current_time']->value;?>
)</td>
		<td align=left>KEY:
		<input type="text" class="wbk" name="ntpkey" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['ntpkey'];?>
" />	
		NTP服务器:
		<input type="text" class="wbk" name="ntpserver" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['ntpserver'];?>
" />	
		
		</td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ftp_save">
	<tr  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>ftp堡垒机备份阈值:</td>
		<td align=left>
		<input type="text" class="wbk" name="ftpbackupsize" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['ftpbackupsize'];?>
" />	
		MB(大于此阈值堡垒机不备份上传下载文件,为0表示所有上传下载文件都不备份)</td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=sftp_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>sftp堡垒机备份阈值:</td>
		<td align=left>
		<input type="text" class="wbk" name="sftpbackupsize" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['sftpbackupsize'];?>
" />	
		MB(大于此阈值堡垒机不备份上传下载文件,为0表示所有上传下载文件都不备份)</td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ping_save">
	<tr  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>允许Ping:</td>
		<td align=left>
		<input type="checkbox" class="" name="ping" value="on" <?php if ($_smarty_tpl->tpl_vars['sshconfig']->value['ping']) {?>checked<?php }?> />	</td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=snmp_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>SNMP服务开启:</td>
		<td align=left>
		<input type="checkbox" class="" name="snmp" value="on" <?php if ($_smarty_tpl->tpl_vars['sshconfig']->value['snmp']) {?>checked<?php }?> /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=snmpcommunity_save">
	<tr  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>SNMP通讯字符串:</td>
		<td align=left>
		<input type="text" class="wbk" name="community" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['community'];?>
" /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ftp_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>系统时间修改:</td>
		<td align=left>
		<input type="text" class="wbk" name="year" size="4" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['year'];?>
" />年<input type="text" class="wbk" name="month" size="4" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['month'];?>
" />月<input type="text" class="wbk" name="day" size="4" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['day'];?>
" />日<input type="text" class="wbk" name="hour" size="4" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['hour'];?>
" />时<input type="text" class="wbk" name="minute" size="4" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['minute'];?>
" />分<input type="text" class="wbk" name="second" size="4" value="<?php echo $_smarty_tpl->tpl_vars['sshconfig']->value['second'];?>
" />秒&nbsp;&nbsp;</td>
		<td><input type="submit" name="settime" class="an_02" value="设定时间"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=autodelete_save">
	<tr  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>自动删除周期:</td>
		<td align=left>
		<input type="text" class="wbk" name="autodelete" value="<?php echo $_smarty_tpl->tpl_vars['autodelcycle']->value;?>
" /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=keyedit">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>证书修改:</td>
		<td align=left>
		<input type="text" class="wbk" name="eth0" value="<?php echo $_smarty_tpl->tpl_vars['eth0']->value;?>
" /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=logintype">
	<tr bgcolor=""  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>登录方式:</td>
		<td align=left>
		Radius:<input type="checkbox" class="wbk" name="radiusauth" <?php if ($_smarty_tpl->tpl_vars['logintype']->value['radiusauth']) {?>checked<?php }?> value="1" /> &nbsp;&nbsp;&nbsp;LDAP:<input type="checkbox" class="wbk" name="ldapauth" <?php if ($_smarty_tpl->tpl_vars['logintype']->value['ldapauth']) {?>checked<?php }?> value="1" /> &nbsp;&nbsp;&nbsp;AD:<input type="checkbox" class="wbk" name="adauth" <?php if ($_smarty_tpl->tpl_vars['logintype']->value['adauth']) {?>checked<?php }?> value="1" />&nbsp;&nbsp;&nbsp;指纹认证:<input type="checkbox" class="wbk" name="fingersecauth" <?php if ($_smarty_tpl->tpl_vars['logintype']->value['fingersecauth']) {?>checked<?php }?> value="1" />&nbsp;&nbsp;&nbsp;本地+指纹认证:<input type="checkbox" class="wbk" name="localfingersecauth" <?php if ($_smarty_tpl->tpl_vars['logintype']->value['localfingersecauth']) {?>checked<?php }?> value="1" /> </td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=priority_cache_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>强制使用权限缓存:</td>
		<td align=left>
		<select name="priority_cache">
		<option value="0" <?php if (!$_smarty_tpl->tpl_vars['priority_cache']->value) {?>selected<?php }?>>否</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['priority_cache']->value) {?>selected<?php }?>>是</option>
		</select>
		 </td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=blankuser_save">
	<tr bgcolor="" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>弹出空用户认证:</td>
		<td align=left>
		<select name="blankuser">
		<option value="0" <?php if (!$_smarty_tpl->tpl_vars['blankuser']->value) {?>selected<?php }?>>否</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['blankuser']->value) {?>selected<?php }?>>是</option>
		</select>
		 </td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ldap_save">
	<tr bgcolor="f7f7f7" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>使用目录结构:</td>
		<td align=left>
		<select name="ldap">
		<option value="0" <?php if (!$_smarty_tpl->tpl_vars['ldap']->value) {?>selected<?php }?>>否</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['ldap']->value) {?>selected<?php }?>>是</option>
		</select>
		 </td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=certificate_save">
	<tr bgcolor="" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>是否开启证书认证:</td>
		<td align=left>
		<select name="Certificate" id="Certificate" >
		<option value="0" <?php if ($_smarty_tpl->tpl_vars['Certificate']->value == 0) {?>selected<?php }?>>否</option>
		<option value="2" <?php if ($_smarty_tpl->tpl_vars['Certificate']->value == 2) {?>selected<?php }?>>是</option>
		</select>
		 </td>
		<td><input type="submit" onclick="return certificate();" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>

	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=async_save">
	<tr bgcolor="f7f7f7" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>是否开启同步服务(Async):</td>
		<td align=left>
		<select name="Async" id="Async" >
		<option value="0" <?php if ($_smarty_tpl->tpl_vars['Async']->value == 0) {?>selected<?php }?>>否</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['Async']->value == 1) {?>selected<?php }?>>是</option>
		</select>
		 </td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=rdpinput_save">
	<tr bgcolor=""  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>是否显示RDP会话的"录入":</td>
		<td align=left>
		<select name="rdpinput" id="rdpinput" >
		<option value="0" <?php if ($_smarty_tpl->tpl_vars['rdpinput']->value == 0) {?>selected<?php }?>>否</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['rdpinput']->value == 1) {?>selected<?php }?>>是</option>
		</select>
		 </td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=diskfull_save">
	<tr bgcolor="f7f7f7" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>存贮无空间时操作:</td>
		<td align=left>
		<select name="diskfull" id="diskfull" >
		<option value="0" <?php if ($_smarty_tpl->tpl_vars['diskfull']->value == 0) {?>selected<?php }?>>覆盖旧文件</option>
		<option value="1" <?php if ($_smarty_tpl->tpl_vars['diskfull']->value == 1) {?>selected<?php }?>>停止操作</option>
		</select>
		 </td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=diskfull_save">
	<tr bgcolor="" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>发送密码文件加密密码:</td>
		<td align=left>
		<a href="#" onclick="loadurl('admin.php?controller=admin_config&action=viewthreepripwd_twopwd');return false;" >查看</a>
		 </td>
		<td><input type="button" onclick="loadurl('admin.php?controller=admin_config&action=threepripwd');" class="an_02" value="密码设置"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=dpwdtime_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>动态密码及时间显示:</td>
		<td align=left>
		<input type="checkbox" class="" name="dpwdtime" value="1" <?php if ($_smarty_tpl->tpl_vars['dpwdtime']->value) {?>checked<?php }?> /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=rdprunning_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>RDP当前连接提示:</td>
		<td align=left>
		<input type="checkbox" class="" name="rdprunning" value="1" <?php if ($_smarty_tpl->tpl_vars['rdprunning']->value) {?>checked<?php }?> /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=loginauthtype_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>首页是否显示登录方式:</td>
		<td align=left>
		<input type="checkbox" class="" name="loginauthtype" value="1" <?php if ($_smarty_tpl->tpl_vars['loginauthtype']->value) {?>checked<?php }?> /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=radiustolocal_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>Radius认证转本地:</td>
		<td align=left>
		<input type="checkbox" class="" name="radiustolocal" value="1" <?php if ($_smarty_tpl->tpl_vars['radiustolocal']->value) {?>checked<?php }?> /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=rrdpauthtips_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>RADIUS登录错误提示:</td>
		<td align=left>
		<input type="text" class="" name="rdpauthtips" value="<?php echo $_smarty_tpl->tpl_vars['rdpauthtips']->value;?>
" size="100" /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=loginwrongtips_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>WEB登录错误提示:</td>
		<td align=left>
		<input type="text" class="" name="loginwrongtips" value="<?php echo $_smarty_tpl->tpl_vars['loginwrongtips']->value;?>
" size="100" /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=asyncoutpass_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>同步外部密码：</td>
		<td align=left>
		<select  class="wbk" id=asyncoutpass name=asyncoutpass>
		<OPTION value="-1" <?php if (-1 == $_smarty_tpl->tpl_vars['member']->value['asyncoutpass']) {?>selected<?php }?>>关闭</OPTION>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['asyn'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['name'] = 'asyn';
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['loop'] = is_array($_loop=11) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['asyn']['total']);
?>
		<OPTION value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['asyn']['index'];?>
" <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['asyn']['index'] == $_smarty_tpl->tpl_vars['asyncoutpass']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['asyn']['index'];?>
</OPTION>
		<?php endfor; endif; ?>
                  </SELECT></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=accept_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>显示告知信息:</td>
		<td align=left>
		<input type="checkbox" class="" name="accept" value="1" <?php if ($_smarty_tpl->tpl_vars['accept']->value) {?>checked<?php }?> /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=workflowadmin_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>权限审批用户:</td>
		<td align=left>
用户1：<input type=text name="username1" id="username1" size=10 value="" placeholder="过滤用户" onchange="filter(1);" >&nbsp;&nbsp;
			<select  class="wbk" style="width:100px;" id="memberselect1" name="memberselect1"  onchange="usernameselect();">
				<OPTION value="">请选择</OPTION>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
					<option value="<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'] == $_smarty_tpl->tpl_vars['member1']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['username'];?>
</option>
				<?php endfor; endif; ?>
			</SELECT> &nbsp;&nbsp;
用户2：<input type=text name="username2" id="username2" size=10 value="" placeholder="过滤用户"  onchange="filter(2);" >&nbsp;&nbsp;
			<select  class="wbk" style="width:100px;" id="memberselect2" name="memberselect2"  onchange="usernameselect();">
				<OPTION value="">请选择</OPTION>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
					<option value="<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'] == $_smarty_tpl->tpl_vars['member2']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['username'];?>
</option>
				<?php endfor; endif; ?>
			</SELECT> &nbsp;&nbsp;
用户3：<input type=text name="username3" id="username3" size=10 value="" placeholder="过滤用户"  onchange="filter(3);" >&nbsp;&nbsp;
			<select  class="wbk" style="width:100px;" id="memberselect3" name="memberselect3"  onchange="usernameselect();">
				<OPTION value="">请选择</OPTION>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
					<option value="<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'] == $_smarty_tpl->tpl_vars['member3']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['username'];?>
</option>
				<?php endfor; endif; ?>
			</SELECT> &nbsp;&nbsp;<br />
用户4：<input type=text name="username4" id="username4" size=10 value="" placeholder="过滤用户"  onchange="filter(4);" >&nbsp;&nbsp;
			<select  class="wbk" style="width:100px;" id="memberselect4" name="memberselect4"  onchange="usernameselect();">
				<OPTION value="">请选择</OPTION>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
					<option value="<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'] == $_smarty_tpl->tpl_vars['member4']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['username'];?>
</option>
				<?php endfor; endif; ?>
			</SELECT> &nbsp;&nbsp;
用户5：<input type=text name="username5" id="username5" size=10 value="" placeholder="过滤用户"  onchange="filter(5);" >&nbsp;&nbsp;
			<select  class="wbk" style="width:100px;" id="memberselect5" name="memberselect5"  onchange="usernameselect();">
				<OPTION value="">请选择</OPTION>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
					<option value="<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'];?>
" <?php if ($_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['uid'] == $_smarty_tpl->tpl_vars['member5']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['username'];?>
</option>
				<?php endfor; endif; ?>
			</SELECT> &nbsp;&nbsp;

</td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=rdpplayip_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>RDP回放IP:</td>
		<td align=left>
		<input type="text" class="" name="rdpplayip" value="<?php echo $_smarty_tpl->tpl_vars['rdpplayip']->value;?>
" /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=fingersecserver_save">
	<tr bgcolor=""><td>指纹认证服务器wsdl地址:</td>
		<td align=left>
		<input type="text" class="wbk" size="100" name="fingersecserver" value="<?php echo $_smarty_tpl->tpl_vars['fingersecserver']->value;?>
" />
		 </td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ftp_save">
	<tr>
			<td  align="center" colspan=3><input name='reset' type="submit" onclick="return confirm('重启系统?')" class="an_02" value="重启系统"> &nbsp;&nbsp;&nbsp;<input name='shutdown' type="submit"  onclick="return confirm('关闭系统?')" value="关闭系统" class="an_02">&nbsp;&nbsp;&nbsp;<input name='clearaccount' type="submit" onclick="return confirm('清除配置?')"  value="清除配置" class="an_02">&nbsp;&nbsp;&nbsp;<input name='correctdata' type="submit" onclick="return confirm('整理数据?')"  value="整理数据" class="an_02"></td>
		</tr>
</form>
	</table>
		</table>
	</td>
  </tr>
</table>


<?php echo '<script'; ?>
 language="javascript">
<!--
function filter(i){
	var filterStr = document.getElementById('username'+i).value;
	var usbkeyid = document.getElementById('memberselect'+i);
	usbkeyid.options.length=1;
	for(var i=0; i<AllMember.length;i++){
		if(filterStr.length==0 || AllMember[i]['username'].indexOf(filterStr) >= 0){
			usbkeyid.options[usbkeyid.options.length++] = new Option(AllMember[i]['username'],AllMember[i]['uid']);
		}
	}
}
function certificate()
{
	<?php if ($_smarty_tpl->tpl_vars['Certificate']->value == 0) {?>
	if(document.getElementById('Certificate').options[document.getElementById('Certificate').options.selectedIndex].value==2){
		if(confirm('确定要开启认证？')){
			return true;
		}
		return false;
	}
	<?php }?>
}

function check()
{
/*
   if(!checkIP(f1.ip.value) && f1.netmask.value != '32' ) {
	alert('地址为主机名时，掩码应为32');
	return false;
   }   
   if(checkIP(f1.ip.value) && !checknum(f1.netmask.value)) {
	alert('请录入正确掩码');
	return false;
   }
*/
   return true;

}//end check
// -->

function checkIP(ip)
{
	var ips = ip.split('.');
	if(ips.length==4 && ips[0]>=0 && ips[0]<256 && ips[1]>=0 && ips[1]<256 && ips[2]>=0 && ips[2]<256 && ips[3]>=0 && ips[3]<256)
		return ture;
	else
		return false;
}

function checknum(num)
{

	if( isDigit(num) && num > 0 && num < 65535)
		return ture;
	else
		return false;

}

function isDigit(s)
{
var patrn=/^[0-9]{1,20}$/;
if (!patrn.exec(s)) return false;
return true;
}

<?php echo '</script'; ?>
>
<iframe id="hide" name="hide" height="0"  frameborder="0" scrolling="no"></iframe>
</body>
</html>



<?php }
}
?>