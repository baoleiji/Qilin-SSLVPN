<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="IE=7.0000" http-equiv="X-UA-Compatible">
<title>系统状态</title>	
<meta http-equiv="refresh" content="300">
<LINK rel=stylesheet type=text/css href="{{$template_root}}/all_purpose_style.css">
<script type="text/javascript" src="template/admin/cssjs/jquery-1.4.2.min.js"></script>
<script>
function keyup(keycode){
	if(keycode==13){
		searchit();
	}
}
function searchit(){
	document.f1.action = "admin.php?controller=admin_monitor&action=monitor_status";
	document.f1.action += "&gid="+document.f1.groupid.value;
	document.location=document.f1.action;
	return true;
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD class=hui_bj vAlign=middle>
    <DIV class=menu>
      <UL>
		<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=index">状态监控</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=system_monitor">系统监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=network_monitor">网络监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	</UL></DIV>
    </TD>
  </TR></table>
<table width="100%" height="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
<tbody>

<tr>
	<td align="left" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

		<TBODY>
		 <TR>
			<TD >
			<form name ='f1' action='admin.php?controller=admin_pro&action=dev_index' method=post  onkeyup="keyup(event.keyCode);"  onsubmit="return false;">
			主机组:<select name='groupid'  style="width:150px">
			<option value="0">请选择</option>
			{{section name='g' loop=$group}}
			<option value="{{$group[g].id}}">{{$group[g].groupname}}</option>
			{{/section}}
			</select>
			&nbsp;&nbsp;<input  type="submit" value=" 搜 索 " onclick="return searchit();" class="bnnew2">
			</form>
			</TD>
		  </TR>
		  </table></td></tr>
<tr><td valign="top" >
<style>
.btn{
   background: url(./template/admin/images/fondo_col.gif) 70% 70% repeat-x; font-size: 13px; color: #000000; text-align: center;
}
input.btn:hover
{

   background: #4AC600 url(./template/admin/images/fondo_col.gif) 50% 50% repeat-x; color: #000000;
}
a.info{
    position:relative; /*this is the key*/
    z-index:24;
    color:#000;
    text-decoration:none;
}
a.info:hover{
	z-index:25;
	background-color:#fff;
}
a.info span{
	display: none;
}
a.info:visited {
	color:#000;
}
a.info:hover span{
	display:block;
	position:absolute;
	border:1px solid #000;
	background-color:#ffffcc; color:#000;
	padding: 3px;
}
</style>

<center>最后刷新时间: {{$hms}}(服务器时间)</center><br><center><table border="0" cellspacing="3">

	<script><!--
		window.onerror = null;
		function blink_status(id,color,hilight){
			var hilight = (hilight == null) ? "1" : hilight;
			if(document.getElementById){
				var item = document.getElementById(id);
				if (item == null) {return;}
				if (hilight==1) {
					setTimeout("blink_status('"+ id + "','" + color + "','" + 0 +"')", 1000);
					//item.style.background='#ffffff';
					//item.style.color='#000000';
					if ((item.tagName=="A") || (item.tagName=="FONT")) {
						item.style.background=color;
						item.style.color='#ffffff';
						return;
					}
					item.style.border='1px solid ' + color;
				}else{
					setTimeout("blink_status('"+ id + "','" + color + "','" + 1 +"')", 1000);
					//item.style.background=color;
					//item.style.color='#ffffff';
					if ((item.tagName=="A") || (item.tagName=="FONT")) {
						item.style.color=color;
						item.style.background='none';
						return;
					}
					color='#aaaaaa';
					if (item.tagName=="IMG") {
						color='#ffffff';
					}
					item.style.border='1px solid ' + color;
				}
			}
		}
		//--></script>
<tbody>
<tr><td valign="top"><center>
<table border="0" style="float:left; margin:10px;border:#7cb9f2 1px solid;width:100%" cellpadding="1" cellspacing="0" bgcolor="#eeeeee" class=""><tbody>
	<tr><td>&nbsp;<font size="4" color="#000000"><b></b></font></td></tr>
	<tr><td bgcolor="#cacecf">
		<table border="0" cellspacing="5" bgcolor="#FFFFFF" width="100%" id=""><tbody>
			<tr>
			{{section name=h loop=$servers}}
			<td valign="top"><center><a class="info" href="#" onclick="window.open ('admin.php?controller=admin_detail&ip={{$servers[h].device_ip}}{{if $servers[h].devtypename|lower eq 'cisco' }}&action=ciscoindex{{/if}}', 'newwindow', 'height=' + screen.height + ',width=' + screen.width+'top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;"><img id="status_72" src="./template/admin/images/{{if $servers[h].status eq 0}}red1.gif{{elseif $servers[h].status eq 1}}green1.gif{{elseif $servers[h].status eq 2}}orange.gif{{/if}}" border="0"><br><span><table cellpadding="0" cellspacing="0" width="250px"><tbody><tr><td colspan="2"><b>{{$servers[h].hostname}}</b></td></tr><tr valign="top"><td>状态:</td><td>{{if $servers[h].status eq 0}}宕机{{elseif $servers[h].status eq 1}}正常{{elseif $servers[h].status eq 2}}超值{{/if}}</td></tr><tr valign="top"><td>IP地址:</td><td>{{$servers[h].device_ip}}</td></tr></tbody></table></span>{{$servers[h].hostname}}</a></center></td>
			{{if $smarty.section.h.index+1%10==0}}
			</tr><tr>
			{{/if}}
			{{/section}}			
			
			</tr>			
			</tbody></table></td></tr></tbody></table>
</center></td></tr></tbody></table></center><br><br><br><center><table cellpadding="1" cellspacing="0" bgcolor="#eeeeee"><tbody><tr><td>&nbsp;<font size="3" color="#000000"><b>图例</b></font></td></tr><tr><td bgcolor="#cacecf">
<table cellspacing="10" bgcolor="#FFFFFF" id="legend">
<tbody><tr align="center"><td><img src="./template/admin/images/green1.gif"></td><td><img src="./template/admin/images/blue.gif"></td><td><img src="./template/admin/images/orange.gif"></td><td><img src="./template/admin/images/red1.gif"></td></tr>
<tr valign="top" align="center"><td width="25%">正常</td><td width="25%">正在<br>恢复</td><td width="25%">超过<br>阈值</td><td width="25%">宕机</td></tr></tbody></table></td></tr></tbody></table></center>
</td></tr></tbody></table></body></html>