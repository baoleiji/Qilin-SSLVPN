<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/launchprogram.js"></script>
</head>
<script>
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
	{{if  $logintype eq 'apppub' or $logintype eq '_apppub'}}
		tid = document.getElementById('appserverip');
		form.action += "&appserverip=" + tid.options[tid.options.selectedIndex].value;
	{{/if}}
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
</script>
<body>
<div id="fade" class="black_overlay"></div> 
{{if $smarty.session.ADMIN_LEVEL eq 0 || $smarty.session.ADMIN_LEVEL eq 10 || $smarty.session.ADMIN_LEVEL eq 101}}
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
{{if $smarty.session.ADMIN_LEVEL eq 0}}
<li class={{if $smarty.get.logintype }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&all=1">设备列表</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne '_apppub' and $smarty.get.logintype ne 'apppub' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne '_apppub' and $smarty.get.logintype ne 'apppub'}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=_apppub&gid={{$gid}}">应用列表</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne '_apppub' and $smarty.get.logintype ne 'apppub'}}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'ssh' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'ssh' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ssh&gid={{$gid}}">SSH设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'ssh' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'telnet' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'telnet' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=telnet&gid={{$gid}}">TELNET设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'telnet' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'rdp' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'rdp' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=rdp&gid={{$gid}}">RDP设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'rdp' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'vnc' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'vnc' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=vnc&gid={{$gid}}">VNC设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'vnc' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'ftp' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'ftp' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ftp&gid={{$gid}}">FTP设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'ftp' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'x11' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'x11' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=x11">X11设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'x11' }}3{{/if}}.jpg" align="absmiddle"/></li>

<li class=me_b><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow">运维流程</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

{{elseif $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
{{/if}}
</ul>
</div></td></tr>

{{/if}}

	
{{if $smarty.session.ADMIN_LEVEL ne 0 && $smarty.session.ADMIN_LEVEL ne 10 && $smarty.session.ADMIN_LEVEL ne 101}}
  <tr>
    <td  class="hui_bj">{{$title}}</td>
          
          
          <td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
        </tr>

      </table></td>
  </tr>
  {{/if}}
   <tr>
    <td class="main_content">
<form  name="f1" action="{{$curr_url}}" method="post" name="report" onsubmit="return search();" >
IP：<input type="text" class="wbk" id="sip" name="sip" value="{{$sip}}" style="width:80px;">&nbsp;主机名：<input type="text" class="wbk" id="hostname" name="hostname" value="{{$hostname}}" style="width:80px;">

{{if $admin_level == 0}}
{{if  $logintype eq 'apppub' or $logintype eq '_apppub'}}
&nbsp;应用发布服务器：<select  class="wbk"  id="appserverip" name="appserverip" style="width:80px;">
  <option value="">未指定</option>
{{section name=l loop=$appservers}}
<option value="{{$appservers[l].appserverip}}">{{$appservers[l].appserverip}}</option>
{{/section}}
</select>&nbsp;
{{else}}
 &nbsp;负载均衡：<select  class="wbk"  id="lb" name="lb" style="width:80px;">
  <option value="">未指定</option>
<option value="{{$localip}}">{{$localip}}</option>
{{section name=l loop=$lb}}
<option value="{{$lb[l].ip}}">{{$lb[l].ip}}</option>
{{/section}}
</select>&nbsp;
{{/if}}
<span id="slogin_template" style="display:none">登录方式：<select  class="wbk"  id="app_act" style="width:80px;">
					<option value="applet">applet</option>
					<option value="activeX">activeX</option>
					</select></span>
{{/if}}&nbsp;<input type="submit" height="35" align="middle" value=" 确定 " border="0" class="bnnew2"/>{{if $smarty.session.ADMIN_LEVEL eq 0}}&nbsp;磁盘映射:<input type="checkbox" name="rdpdiskauth_" id="rdpdiskauth_" {{if !$member.rdpdiskauth_up}}disabled{{/if}} {{if $rdpdiskauth_up}}checked{{/if}} value="1"  />&nbsp;剪切版:<input type="checkbox" name="rdpclipauth_" id="rdpclipauth_" {{if !$member.rdpclipauth_up }}disabled{{/if}}  onclick="checkieNT52(this)" {{if $member.rdpclipauth_up }}checked{{/if}} value="1"  />&nbsp;本地:<input type="checkbox" name="consoleauth_" id="consoleauth_" {{if !$member.rdplocal}}disabled{{else}}{{if $member.rdplocalcheck }}checked{{/if}}{{/if}}  />&nbsp;<select  class="wbk"  name='fenbianlv' id='fenbianlv' > 
					<option value="3" {{if $member.rdp_screen eq 3}}selected{{/if}}>全屏</option>
					<option value="1" {{if $member.rdp_screen eq 1}}selected{{/if}}>800*600</option>
					<option value="2" {{if $member.rdp_screen eq 2}}selected{{/if}}>1024*768</option>
					</select>&nbsp;
					{{if !($logintype eq 'apppub' or $logintype eq '_apppub' or $logintype eq 'rdp' or $logintype eq 'x11' or $logintype eq 'vnc')}}
					<select  class="wbk"  name='login_type' id='login_type' > 
					<option value="web" {{if $member.default_appcontrol eq 0}}selected{{/if}}>WEB</option>
					<option value="rdp" {{if $member.default_appcontrol eq 1}}selected{{/if}}>RDP</option>
					</select>&nbsp;
					{{/if}}
					域名连接:<input type="checkbox" name="bydomain" id="bydomain" {{if $bydomain}}checked{{/if}} value="1"  />{{/if}}
</form>
	  </td>
  </tr>
  <tr>
	<td class="">
<TABLE border=0 cellSpacing=1 cellPadding=5 width="100%" bgColor=#ffffff valign="top" class="BBtable">
<form name='usrdev' >
                <TBODY>
		{{if  $logintype ne 'apppub' and $logintype ne '_apppub'}}		
                  <TR>
					{{if $smarty.session.ADMIN_LEVEL eq 1}}<th class="list_bg"  width="5%">选</th>{{/if}}
					<th class="list_bg"  width="5%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=id&orderby2={{$orderby2}}" >ID</a></th>
         			{{if  $logintype eq 'apppub' or $logintype eq '_apppub'}}
					 <th class="list_bg"  width="13%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=name&orderby2={{$orderby2}}" >应用程序</a></th>
					  <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=device_ip&orderby2={{$orderby2}}" >目标地址</a></th>
					 <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=appserverip&orderby2={{$orderby2}}" >应用发布服务</a></th>
					 
					{{else}}
					<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=device_ip&orderby2={{$orderby2}}" >服务器地址</a></th>
					{{/if}}
                   {{if  $logintype ne 'apppub' && $logintype ne '_apppub'}}
					 <th class="list_bg"  width="20%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=hostname&orderby2={{$orderby2}}" >主机名</a></th>
					 {{if $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}
					 <th class="list_bg"  width="7%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=hostname&orderby2={{$orderby2}}" >设备组</a></th>
					 {{/if}}
					{{/if}}
					
					<th class="list_bg"  width="10%">主机信息</th>
                    {{if $type ne 'fort' }}
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=username&orderby2={{$orderby2}}" >登陆用户</a></th>
                    {{/if}}   
					{{if $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}
					 <th class="list_bg"  width="7%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=hostname&orderby2={{$orderby2}}" >系统</a></th>
					 {{/if}}
				    <th class="list_bg"  width="7%"><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&logintype={{$smarty.get.logintype}}&orderby1=login_method&orderby2={{$orderby2}}" >登录协议</a></th>
					 {{if $smarty.session.ADMIN_LEVEL ne 10 and $smarty.session.ADMIN_LEVEL ne 101}}
					<th class="list_bg"  width="7%">连接检测</th>
					 {{/if}}
					{{if $smarty.session.CACTI_CONFIG_ON and $smarty.session.LICENSE_KEY_NETMANAGER}}
					<th class="list_bg"  width="4%">状态</th>
					 {{/if}}

                   	<th class="list_bg"  width="20%">{{if $smarty.session.ADMIN_LEVEL ne 0}}操作{{else}}工具{{/if}}</th>
                  </TR>
			{{section name=t loop=$alldev}}
			<tr bgcolor='{{if !$alldev[t].enable }}#cccccc{{elseif $alldev[t].passwordtry eq 1 or $alldev[t].passwordtry eq 2}}red{{elseif $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}' onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if !$alldev[t].enable }}#cccccc{{elseif $alldev[t].passwordtry eq 1 or $alldev[t].passwordtry eq 2}}red{{elseif $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}');">{{if $smarty.session.ADMIN_LEVEL eq 1}}
				<td>{{if $alldev[t].login_method eq 'RDP' or $alldev[t].login_method eq 'ssh' or $alldev[t].login_method eq 'telnet'}}<input type="checkbox" name="session[]" value="{{$alldev[t].login_method}}_{{$alldev[t].id}}" >{{/if}}</td>{{/if}}
				<td>{{$alldev[t].id}}</td>
				{{if  $logintype eq 'apppub' or $logintype eq '_apppub'}}
				<td></td>
				<td>{{$alldev[t].appserverip}}</td>
				{{/if}}
				
				<td>{{$alldev[t].device_ip}}</td>
				{{if  $logintype eq 'apppub' or $logintype eq '_apppub'}}					 
				{{else}}
				<td><span  title="{{$alldev[t].hostname}}" >{{$alldev[t].hostname}}</span></td>
				{{/if}}
				{{if $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}
				<td>{{$alldev[t].groupname}}</td>
				{{/if}}
				<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showdesc&id={{$alldev[t].id}}");return false;' target="hide"><img src='{{$template_root}}/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'>{{$alldev[t].desc|truncate_cn:15:"...":""}}</a></td>
				
				
				{{if $type ne 'fort'}}
				<td>{{if $alldev[t].username eq ''}}空用户{{else}}{{$alldev[t].username}}{{/if}}</td>
				{{/if}}
				
				{{if $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}
				<td>{{$alldev[t].device_type}}</td>
				{{/if}}
				<td><font style="font-size:12px;" {{if $alldev[t].puttyhong eq 1}}color="red"{{/if}} >{{if $alldev[t].login_method eq 'apppub' }}应用发布{{else}}{{$alldev[t].login_method}}{{/if}}<font>				
				</td>
				{{if $smarty.session.ADMIN_LEVEL ne 10 and $smarty.session.ADMIN_LEVEL ne 101}}
				<td><img src='{{$template_root}}/images/list_ico2.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=test_port&ip={{$alldev[t].device_ip}}&port={{$alldev[t].port}}&devicesid={{$alldev[t].id}}");return false;' target="hide"><font color="{{if !$alldev[t].workflow_status}}blue{{elseif $alldev[t].workflow_status eq 4}}green{{else}}red{{/if}}">检测</font></a></td>
				{{/if}}
				{{if $smarty.session.CACTI_CONFIG_ON and $smarty.session.LICENSE_KEY_NETMANAGER}}
				<td align=center><img src='{{$template_root}}/images/{{if !$alldev[t].monitor}}Gray.gif{{elseif $alldev[t].status eq 1}}Green.gif{{elseif $alldev[t].status eq 2}}GreenYellow.gif{{else}}Red.gif{{/if}}' style="cursor:hand;" onclick="window.open ('admin.php?controller=admin_detail&ip={{$alldev[t].device_ip}}{{if $alldev[t].device_type|lower eq 'cisco' }}&action=ciscoindex{{/if}}', 'newwindow', 'height=' + screen.height + ',width=' + screen.width+'top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" ></td>
				{{/if}}
				<td class="td_line" width="30%">
					{{if $admin_level == 0}}					
					{{if  $alldev[t].login_method eq 'RDP' or $alldev[t].login_method eq 'X11'}}					
					{{if $alldev[t].enable and $alldev[t].twopriority}}
					<a id="a{{$alldev[t].id}}1" onclick="rdpgo({{$alldev[t].id}},0,true);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id={{$alldev[t].id}}' ><img src="{{$template_root}}/images/mstsc_ico.gif" border=0 title="MSTSC:{{$alldev[t].connections}}"></a>
					{{if  $windows_version ne '5.2'}}
					{{*&nbsp;&nbsp;&nbsp;<a id="a{{$alldev[t].id}}2" onclick="rdpgo2({{$alldev[t].id}},0,true)" href='#' target="_blank"><img src="{{$template_root}}/images/ie_ico.png" title="ACTIVEX" border=0></a>*}}
					{{/if}}					
					{{else}}
					{{*<img src="{{$template_root}}/images/mstsc_ico.gif" border=0 title="MSTSC:{{$alldev[t].connections}}">&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/ie_ico.png" title="ACTIVEX" border=0>*}}					
					{{/if}}
					
					{{/if}}
					{{if $alldev[t].login_method eq 'ssh1' or $alldev[t].login_method eq 'ssh' or $alldev[t].login_method eq 'telnet' or $alldev[t].login_method eq 'rlogin'}}	{{if $alldev[t].enable and $alldev[t].twopriority}}
					<a id="x{{$alldev[t].id}}" href="admin.php?controller=admin_pro&action=dev_login&id={{$alldev[t].id}}&logintool=xshell&type={{$type}}" onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/xshell.png" title="Xshell" border=0></a>&nbsp;&nbsp;&nbsp;
					<a id="p{{$alldev[t].id}}" href="admin.php?controller=admin_pro&action=dev_login&id={{$alldev[t].id}}&logintool=putty&type={{$type}}" onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/putty_ico.gif" title="PUTTY" border=0></a>&nbsp;&nbsp;&nbsp;
					 <a id="s{{$alldev[t].id}}" href="admin.php?controller=admin_pro&action=dev_login&id={{$alldev[t].id}}&logintool=securecrt&type={{$type}}" onclick="return goto3(this.id)"  target="hide" ><img src="{{$template_root}}/images/scrt_ico.gif" title="SECURECRT" border=0></a>
					 {{else}}
					 <img src="{{$template_root}}/images/putty_ico.gif" title="PUTTY" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/scrt_ico.gif"  title="SECURECRT" border=0>
					{{/if}}
					{{elseif $alldev[t].login_method eq 'ftp' or $alldev[t].login_method eq 'sftp'}}
					{{if $alldev[t].enable and $alldev[t].twopriority}}
					<a id="c{{$alldev[t].id}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=xftp&id={{$alldev[t].id}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/xftp.png"  title="XFTP" border=0></a>&nbsp;&nbsp;&nbsp;
					<a id="a{{$alldev[t].id}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=winscp&id={{$alldev[t].id}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/winscp_ico.gif"  title="WINSCP" border=0></a>&nbsp;&nbsp;&nbsp;
					<a id="b{{$alldev[t].id}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=flashxp&id={{$alldev[t].id}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/flashfxp_icon.png" title="FLASHXP" border=0></a>
					{{else}}
					<img src="{{$template_root}}/images/xftp.png"  title="XFTP" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/winscp_ico.gif"  title="WINSCP" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/flashfxp_icon.png" title="FLASHXP" border=0>
					{{/if}}
					{{elseif $alldev[t].login_method eq 'RDP2008' or $alldev[t].login_method eq 'vnc' or $alldev[t].login_method eq 'Web' or $alldev[t].login_method eq 'Sybase' or $alldev[t].login_method eq 'Oracle' or $alldev[t].login_method eq 'DB2' or $alldev[t].login_method eq 'apppub'}}
					{{if $alldev[t].enable and $alldev[t].twopriority}}
					<a id="a{{$alldev[t].id}}1" onclick="rdpgo({{$alldev[t].id}},0,false);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id={{$alldev[t].id}}'><font style="font-size:12px;" {{if $alldev[t].puttyhong eq 1}}color="red"{{/if}} ><img src="{{$template_root}}/images/mstsc_ico.gif" title="MSTSC" border=0></font></a>&nbsp;&nbsp;&nbsp;
					{{*{{if  $windows_version ne '5.2'}}
					<a id="a{{$alldev[t].id}}2" onclick="rdpgo2({{$alldev[t].id}},0,false)" href='#' target="_blank"><img src="{{$template_root}}/images/ie_ico.png" title="ACTIVEX" border=0></a>
{{/if}}					*}}{{else}}
					{{*<img src="{{$template_root}}/images/mstsc_ico.gif" title="MSTSC" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/ie_ico.png" title="ACTIVEX" border=0>*}}
					{{/if}}	
					{{/if}}			
					{{if $alldev[t].login_method eq 'ssh' and $alldev[t].sftp }}
					{{if $alldev[t].enable and $alldev[t].twopriority}}
					&nbsp;&nbsp;<a id="c{{$alldev[t].id}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=xftp&id={{$alldev[t].id}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/xftp.png"  title="XFTP" border=0></a>
					&nbsp;&nbsp;<a id="a{{$alldev[t].id}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=winscp&id={{$alldev[t].id}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/winscp_ico.gif" title="WINSCP" border=0></a>&nbsp;&nbsp;&nbsp;<a id="b{{$alldev[t].id}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=flashxp&id={{$alldev[t].id}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/flashfxp_icon.png" title="FLASHXP" border=0></a>
					{{else}}
					<img src="{{$template_root}}/images/xftp.png"  title="XFTP" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/winscp_ico.gif" title="WINSCP" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/flashfxp_icon.png" title="FLASHXP" border=0>
					{{/if}}	

					{{/if}}	
					{{if $alldev[t].change_password}}
					<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a  onclick="window.open ('admin.php?controller=admin_pro&action=change_device_pwd&sid={{$alldev[t].id}}', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href='#'>修改密码</a>
					{{/if}}
					{{/if}}
					{{if $admin_level == 10 or $admin_level == 101}}
					<img src='{{$template_root}}/images/down.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showpwddownauth");return false;'>下载密码</a>
					| <img src='{{$template_root}}/images/list_ico2.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=dev_checkpass&id={{$alldev[t].id}}'>查看密码</a>
					| <img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=pass_edit&gid={{$gid}}&id={{$alldev[t].id}}&from=passview'>修改</a>
					{{/if}}
{{*
					<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=dev_edit&id={{$alldev[t].id}}{{if $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 101}}&from=passworduser'>修改</a>
					
					<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=bind_user&id={{$alldev[t].id}}'>设置用户</a>
					<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_del&id={{$alldev[t].id}}';}">删除</a>
				*}}</td> 
			</tr>
			{{section name=tt loop=$alldev[t].appmember}}
			<tr bgcolor='{{if $alldev[t].passwordtry eq 1 or $alldev[t].passwordtry eq 2}}red{{elseif $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}'>
				<td>{{$alldev[t].appmember[tt].appdeviceid}}</td>
				<td><span  title="{{$alldev[t].appmember[tt].name}}" >{{$alldev[t].appmember[tt].name}}</span></td>
				<td>{{$alldev[t].appmember[tt].device_ip}}</td>
				<td>{{$alldev[t].appmember[tt].appserverip}}</td>
				
				{{if $type ne 'fort'}}
				<td>{{if $alldev[t].username eq ''}}空用户{{else}}{{$alldev[t].username}}{{/if}}</td>
				{{/if}}
				<td>{{if $alldev[t].entrust_password}}自动登录{{else}}手填密码{{/if}}</td>
				<td>{{if $alldev[t].login_method eq 'apppub' }}应用发布{{else}}{{$alldev[t].login_method}}{{/if}}</td>
				<td class="td_line" width="30%">
					{{if $admin_level == 0}}
					{{if $alldev[t].login_method eq 'apppub'}}	
					{{if $alldev[t].enable }}
					<a id="a{{$alldev[t].id}}0{{$alldev[t].appmember[tt].appdeviceid}}1" onclick="rdpgo({{$alldev[t].id}},{{$alldev[t].appmember[tt].appdeviceid}},false);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id={{$alldev[t].id}}'><img src="{{$template_root}}/images/mstsc_ico.gif" title="MSTSC" border=0></a> | {{*<a id="a{{$alldev[t].id}}0{{$alldev[t].appmember[tt].appdeviceid}}2" onclick="rdpgo2({{$alldev[t].id}},{{$alldev[t].appmember[tt].appdeviceid}},false);" href='#' target="_blank"><img src="{{$template_root}}/images/ie_ico.png"  title="ACTIVEX" border=0></a>*}}
{{else}}
<img src="{{$template_root}}/images/mstsc_ico.gif" title="MSTSC" border=0> <img src="{{$template_root}}/images/ie.png" border=0>
{{/if}}
					{{/if}}
					{{/if}}
					
</td> 
			</tr>
			{{/section}}
			{{/section}}

			{{else}}
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
						<th class="list_bg"  width="8%" ><a href='admin.php?controller=admin_index&action=main&orderby1=id&orderby2={{$orderby2}}' >ID</a></th>
						<th class="list_bg"  width="12%" ><a href='admin.php?controller=admin_index&action=main&orderby1=device_ip&orderby2={{$orderby2}}' >服务器IP</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_index&action=main&orderby1=hostname&orderby2={{$orderby2}}' >主机名</a></th>
						<th class="list_bg"  width="12%" ><a href='admin.php?controller=admin_index&action=main&orderby1=appserverip&orderby2={{$orderby2}}' >应用发布IP</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_index&action=main&orderby1=desc&orderby2={{$orderby2}}' >主机信息</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_index&action=main&orderby1=name&orderby2={{$orderby2}}' >应用名称</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_index&action=main&orderby1=name&orderby2={{$orderby2}}' >程序名称</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_index&action=main&orderby1=name&orderby2={{$orderby2}}' >用户名</a></th>
						<th class="list_bg"  width="24%" >{{$language.Operate}}{{$language.Link}}</th>
					</tr>
					{{assign var="i" value=1}}
			{{if $smarty.get.page <1 or !$smarty.get.page}}
			{{section name=t loop=$alldev}}
			<tr {{if $i % 2 == 0}}bgcolor="f7f7f7"{{/if}} onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $i++ % 2 == 0}}f7f7f7{{/if}}');">
			<td>{{$alldev[t].id}}</td>
				
				<td>{{$alldev[t].device_ip}}</td>
				
				<td><span  title="{{$alldev[t].hostname}}" >{{$alldev[t].hostname}}</span></td>
				<td>{{$alldev[t].device_ip}}</td>
				<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showdesc&id={{$alldev[t].id}}");return false;' target="hide"><img src='{{$template_root}}/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'>{{$alldev[t].desc|truncate_cn:15:"...":""}}</a></td>
				<td>桌面</td>
				<td></td>
				<td></td>
				<td><a id="a{{$i}}2"  href="#" onclick="return rdpOne({{$alldev[t].id}}, 0, false);" target="_blank"><img  src="{{$template_root}}/images/windows.jpg"  width=16 height='16' ></a></td>
			</tr>
			{{/section}}
			{{/if}}
			{{section name=tt loop=$appmember}}
			<tr {{if $i % 2 == 0}}bgcolor="f7f7f7"{{/if}} onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $i++ % 2 == 0}}f7f7f7{{/if}}');">
			<td>{{$appmember[tt].appdeviceid}}</td>
			<td>{{$appmember[tt].device_ip|addslashes}}</td>
			<td>{{$appmember[tt].hostname|addslashes}}</td>
			<td >{{$appmember[tt].appserverip|addslashes}}</td>
			<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showdesc&appdeviceid={{$appmember[tt].appdeviceid}}");return false;' target="hide"><img src='{{$template_root}}/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'>{{$appmember[tt].desc|truncate_cn:15:"...":""}}</a></td>
			<td>{{$appmember[tt].name|addslashes}}</td>
			<td>{{$appmember[tt].appprogramname|addslashes}}</td>
			<td>{{if $appmember[tt].username eq ''}}空用户{{else}}{{$appmember[tt].username}}{{/if}}</td>
			<td><a  id="a{{$appmember[tt].devid}}0{{$appmember[tt].appdeviceid}}2" href="#" onclick="return rdpOne({{$appmember[tt].devid}}, {{$appmember[tt].appdeviceid}}, false);" target="_blank">
<img src="upload/{{if $appmember[tt].icon}}{{$appmember[tt].icon}}{{else}}nopic.jpg{{/if}}"  width=16 height='16'  id="img_{{$appmember[tt].devid}}0{{$appmember[tt].appdeviceid}}" onmouseover="popit('img_{{$appmember[tt].devid}}0{{$appmember[tt].appdeviceid}}', '{{$appmember[tt].name|addslashes}}', '{{$appmember[tt].path|addslashes}}', '{{$appmember[tt].appserverip}}', '{{$appmember[tt].device_ip}}', '{{$appmember[tt].url}}')" onmouseout="closeit()" title="{{$appmember[tt].name}}">
			</td>
			</tr>
			{{/section}}
{{*

			{{if $alldev[t].device_ip eq $appserverip || $logintype eq '_apppub'}}
			<td align="center" class="" background="{{$template_root}}/images/tubiao_bg.jpg">
<table border="0" width="100%"><tr>{{if !$smarty.get.gid}}{{if $logintype ne '_apppub'}}<td style="width:140px;text-align:center;border:0px" ><a id="a{{$alldev[t].id}}2"  href="#" onclick="return rdpOne({{$alldev[t].id}}, 0, false);" target="_blank"><img src="{{$template_root}}/images/windows.jpg" width='32' height='32' ><br>桌面</a></li>
{{/if}}{{/if}}
				{{assign var="i" value=1}}
					{{section name=tt loop=$alldev[t].appmember}}
					<td style="width:140px;text-align:center;border:0px">
<a  id="a{{$alldev[t].id}}0{{$alldev[t].appmember[tt].appdeviceid}}2" href="#" onclick="return rdpOne({{$alldev[t].id}}, {{$alldev[t].appmember[tt].appdeviceid}}, false);" target="_blank">
<img src="upload/{{if $alldev[t].appmember[tt].icon}}{{$alldev[t].appmember[tt].icon}}{{else}}nopic.jpg{{/if}}" width="32" height="32"  id="img_{{$alldev[t].id}}0{{$alldev[t].appmember[tt].appdeviceid}}" onmouseover="popit('img_{{$alldev[t].id}}0{{$alldev[t].appmember[tt].appdeviceid}}', '{{$alldev[t].appmember[tt].name|addslashes}}', '{{$alldev[t].appmember[tt].path|addslashes}}', '{{$alldev[t].appmember[tt].appserverip}}', '{{$alldev[t].appmember[tt].device_ip}}', '{{$alldev[t].appmember[tt].url}}')" onmouseout="closeit()" title="{{$alldev[t].appmember[tt].name}}">
<br><span style="display:block;width:100px;text-align:center;margin-left:20px;">{{$alldev[t].appmember[tt].name}}</span></a>
					
					</td>
					{{if ($i++)%7 eq 0}}
					</tr><tr>
					{{/if}}
					{{/section}}
					{{if ($i++)%7 ne 0}}
					{{math equation=8-$i assign=m}}
					{{section name=x loop=$m}}
					<td style="border:1px"></td>
					{{/section}}
					</tr><tr>
					{{/if}}
					</tr></table>
			</td>
			</tr>
			{{/if}}
			{{/section}}
*}}
			{{/if}}
                <tr>
{{if  $logintype ne 'apppub' and $logintype ne '_apppub'}}

				<td colspan="3">
				{{if $smarty.session.ADMIN_LEVEL eq 1}}
				<input type="checkbox" name="select_all" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.usrdev.elements[i];if(e.name=='session[]')e.checked=document.usrdev.select_all.checked;}" >&nbsp;&nbsp;<input type="button" value="登录选中" onclick="multidevlogin()" class="an_06">
				{{/if}}
				</td>
{{/if}}
	           <td colspan="10" align="right">
		   			{{if $smarty.session.ADMIN_LEVEL eq 10}}<input type="button"  value="密码打印" onClick="alert('未发现可驱动的密码打印机');" class="an_06">{{/if}}&nbsp;&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{if $logintype ne 'apppub'}}{{$items_per_page}}个记录/页{{/if}}  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='{{$curr_url}}&page='+this.value;return false;}">页
		   </td>
		</tr>
		</TBODY>
              </TABLE>
	</td>
  </tr>
  </form>
</table>

<script language="javascript">

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
				var url = "admin.php?controller=admin_pro&action=dev_login&id="+args[1]+"&logintool=securecrt&type={{$type}}"+'&selectedip='+lbip+'&app_act='+app_act+'&bydomain='+bydomain+'&'+Math.round(new Date().getTime()/1000);
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
	{{if  !($logintype eq 'apppub' or $logintype eq '_apppub')}}
	lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	{{/if}}
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
	{{if  !($logintype eq 'apppub' or $logintype eq '_apppub')}}
		lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	{{/if}}
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
	{{if $logindebug}}
		window.open(document.getElementById(aid).href);
	{{/if}}
	return true;	
}

function goto3(iid){
	var idnumber = iid.substring(1);
	var lbip = '';
	{{if  !($logintype eq 'apppub' or $logintype eq '_apppub')}}
	lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	{{/if}}
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
{{if $member.default_control eq 0}}
if(navigator.userAgent.indexOf("MSIE")>0) {
    document.getElementById('app_act').options.selectedIndex = 1;
}
{{elseif $member.default_control eq 1}}
document.getElementById('app_act').options.selectedIndex = 0;
{{elseif $member.default_control eq 2}}
document.getElementById('app_act').options.selectedIndex = 1;
{{/if}}

{{if $logintype eq 'apppub' or $logintype eq '_apppub'}}
window.parent.menu.document.getElementById('devtreetable').style.display = 'none';
window.parent.menu.document.getElementById('apptreetable').style.display = '';
{{else}}
window.parent.menu.document.getElementById('devtreetable').style.display = '';
window.parent.menu.document.getElementById('apptreetable').style.display = 'none';
{{/if}}

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

</script>
<style>
.hide_box{width:350;color:#fff;color:#444;background:#fff;box-shadow:1px 2px 2px #555;display:none;}
.hide_box h4{height:26px;line-height:26px;overflow:hidden;background:#0884C4;color:#fff;padding:0 10px;border:1px solid #0884C4;font-size:14px;border-bottom:1px solid #0884C4;}
.hide_box h4 a{width:14px;line-height:13px;_line-height:15px;height:13px;font-family:arial;overflow:hidden;display:block;background:#fff;color:#c77405;float:right;text-align:center;text-decoration:none;margin-top:7px;font-size:14px;font-weight:normal;border-radius:2px;_font-size:12px;}
.hide_box p{font-size:13px;border:1px solid #ccc;}
</style>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.7.2.min.js"></script>
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



