<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
var isIe=(document.all)?true:false;

var AllMember = new Array();
i=0;
{{section name=kk loop=$allmem}}
AllMember[{{$smarty.section.kk.index}}] = new Array();
AllMember[{{$smarty.section.kk.index}}]['username']='{{$allmem[kk].username}}';
AllMember[{{$smarty.section.kk.index}}]['realname']='{{$allmem[kk].realname}}';
AllMember[{{$smarty.section.kk.index}}]['uid']='{{$allmem[kk].uid}}';
{{/section}}

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

</script>
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
  <tr><th colspan="3" class="list_bg"></th></tr>
  <form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ntpset">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>NTP设置:({{$current_time}})</td>
		<td align=left>
		NTP服务器:
		<input type="text" class="wbk" name="ntpserver" value="{{$sshconfig.ntpserver}}" />	
		
		</td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ping_save">
	<tr  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>允许Ping:</td>
		<td align=left>
		<input type="checkbox" class="" name="ping" value="on" {{if $sshconfig.ping}}checked{{/if}} />	</td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=snmp_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>SNMP服务开启:</td>
		<td align=left>
		<input type="checkbox" class="" name="snmp" value="on" {{if $sshconfig.snmp}}checked{{/if}} /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=snmpcommunity_save">
	<tr  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>SNMP通讯字符串:</td>
		<td align=left>
		<input type="text" class="wbk" name="community" value="{{$sshconfig.community}}" /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ftp_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>系统时间修改:</td>
		<td align=left>
		<input type="text" class="wbk" name="year" size="4" value="{{$sshconfig.year}}" />年<input type="text" class="wbk" name="month" size="4" value="{{$sshconfig.month}}" />月<input type="text" class="wbk" name="day" size="4" value="{{$sshconfig.day}}" />日<input type="text" class="wbk" name="hour" size="4" value="{{$sshconfig.hour}}" />时<input type="text" class="wbk" name="minute" size="4" value="{{$sshconfig.minute}}" />分<input type="text" class="wbk" name="second" size="4" value="{{$sshconfig.second}}" />秒&nbsp;&nbsp;</td>
		<td><input type="submit" name="settime" class="an_02" value="设定时间"></td>
		
	</tr>
	</form>
	
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=keyedit">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>证书修改:</td>
		<td align=left>
		<input type="text" class="wbk" name="eth0" value="{{$eth0}}" /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ldap_save">
	<tr bgcolor="f7f7f7" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>使用目录结构:</td>
		<td align=left>
		<select name="ldap">
		<option value="0" {{if !$ldap}}selected{{/if}}>否</option>
		<option value="1" {{if $ldap}}selected{{/if}}>是</option>
		</select>
		 </td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=certificate_save">
	<tr bgcolor="" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>是否开启证书认证:</td>
		<td align=left>
		<select name="Certificate" id="Certificate" >
		<option value="0" {{if $Certificate eq 0}}selected{{/if}}>否</option>
		<option value="2" {{if $Certificate eq 2}}selected{{/if}}>是</option>
		</select>
		 </td>
		<td><input type="submit" onclick="return certificate();" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=dpwdtime_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>动态密码及时间显示:</td>
		<td align=left>
		<input type="checkbox" class="" name="dpwdtime" value="1" {{if $dpwdtime}}checked{{/if}} /></td>
		<td><input type="submit" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=accept_save">
	<tr bgcolor="f7f7f7"  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'f7f7f7');"><td>显示告知信息:</td>
		<td align=left>
		<input type="checkbox" class="" name="accept" value="1" {{if $accept}}checked{{/if}} /></td>
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


<script language="javascript">
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
	{{if $Certificate eq 0}}
	if(document.getElementById('Certificate').options[document.getElementById('Certificate').options.selectedIndex].value==2){
		if(confirm('确定要开启认证？')){
			return true;
		}
		return false;
	}
	{{/if}}
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

function changechap(){
	var cp = document.getElementById('chap').options[document.getElementById('chap').options.selectedIndex].value;
	if(cp!={{$chap}}){
		if(cp==0){
			return confirm("用户所有的密码都会被转换为密文")
		}else{
			return confirm("用户所有的密码都会被转换为明文")
		}
	}
	return false;
	
}

</script>
<iframe id="hide" name="hide" height="0"  frameborder="0" scrolling="no"></iframe>
</body>
</html>



