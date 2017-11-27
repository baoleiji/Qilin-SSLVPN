<?php /* Smarty version 3.1.27, created on 2017-01-01 16:30:47
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/config_ftp.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:20126806615868be37a46ac9_61990631%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1df11d6fa3bcaaf24fbafd1fcae63334cad8b70' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/config_ftp.tpl',
      1 => 1483259444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20126806615868be37a46ac9_61990631',
  'variables' => 
  array (
    'template_root' => 0,
    'allmem' => 0,
    'current_time' => 0,
    'sshconfig' => 0,
    'eth0' => 0,
    'ldap' => 0,
    'Certificate' => 0,
    'diskfull' => 0,
    'dpwdtime' => 0,
    'loginauthtype' => 0,
    'accept' => 0,
    'fingersecserver' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5868be37abbc02_56151925',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5868be37abbc02_56151925')) {
function content_5868be37abbc02_56151925 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '20126806615868be37a46ac9_61990631';
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">


 
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
	
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=keyedit">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>证书修改:</td>
		<td align=left>
		<input type="text" class="wbk" name="eth0" value="<?php echo $_smarty_tpl->tpl_vars['eth0']->value;?>
" /></td>
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
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=dpwdtime_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>动态密码及时间显示:</td>
		<td align=left>
		<input type="checkbox" class="" name="dpwdtime" value="1" <?php if ($_smarty_tpl->tpl_vars['dpwdtime']->value) {?>checked<?php }?> /></td>
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
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=accept_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>显示告知信息:</td>
		<td align=left>
		<input type="checkbox" class="" name="accept" value="1" <?php if ($_smarty_tpl->tpl_vars['accept']->value) {?>checked<?php }?> /></td>
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