<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/launchprogram.js"></script>

<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script type="text/javascript">
function search_session(){
	var url = "admin.php?controller=admin_workflow&action=search_sessions&backupdb_id={{$backupdb_id}}&wid="+document.getElementById('wid').value;
	url += "&start="+document.getElementById('f_rangeStart').value;
	url += "&end="+document.getElementById('f_rangeEnd').value;
	//document.getElementById('search').submit();
	closeWindow();
	loadurl(url, 600);
	//alert(document.search.action);
	//return false;
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
{{if $smarty.session.ADMIN_LEVEL eq 0}}
{{if $smarty.get.logintype ne 'apppub' }}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&all=1">设备列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'ssh' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'ssh' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ssh&gid={{$gid}}">SSH设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'ssh' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'telnet' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'telnet' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=telnet&gid={{$gid}}">TELNET设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'telnet' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'rdp' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'rdp' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=rdp&gid={{$gid}}">RDP设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'rdp' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'vnc' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'vnc' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=vnc&gid={{$gid}}">VNC设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'vnc' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'ftp' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'ftp' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ftp&gid={{$gid}}">FTP设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'ftp' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'x11' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'x11' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=x11">X11设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'x11' }}3{{/if}}.jpg" align="absmiddle"/></li>

<li class={{if $smarty.get.logintype ne '_apppub' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne '_apppub' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=_apppub&gid={{$gid}}">应用</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne '_apppub' }}3{{/if}}.jpg" align="absmiddle"/></li>
{{else}}
<li class={{if $smarty.get.logintype ne 'apppub' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'apppub' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=apppub&gid={{$gid}}">应用发布设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'apppub' }}3{{/if}}.jpg" align="absmiddle"/></li>
{{/if}}
{{elseif $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}{{/if}}
<li class=me_a><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow">运维流程</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>

	 <tr>
    <td class="main_content">
<form  name="f1" action="{{$curr_url}}" method="post" name="report" onsubmit="return search();" >
{{if $admin_level == 0}}
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;负载均衡：<select  class="wbk"  id="lb" name="lb" >
  <option value="">未指定</option>
<option value="{{$localip}}">{{$localip}}</option>
{{section name=l loop=$lb}}
<option value="{{$lb[l].ip}}">{{$lb[l].ip}}</option>
{{/section}}
</select>&nbsp;&nbsp;&nbsp;&nbsp;<span id="slogin_template" style="display:none">登录方式：<select  class="wbk"  id="app_act" >
					<option value="applet">applet</option>
					<option value="activeX">activeX</option>
					</select></span>
{{/if}}&nbsp;&nbsp;<input type="submit" height="35" align="middle" value=" 确定 " border="0" class="bnnew2"/>{{if $smarty.session.ADMIN_LEVEL eq 0}}&nbsp;&nbsp;&nbsp;&nbsp;磁盘映射:<input type="checkbox" name="rdpdiskauth_" id="rdpdiskauth_" {{if !$member.rdpdiskauth_up}}disabled{{/if}} {{if $rdpdiskauth_up}}checked{{/if}} value="1"  />&nbsp;&nbsp;&nbsp;&nbsp;剪切版:<input type="checkbox" name="rdpclipauth_" id="rdpclipauth_" {{if !$member.rdpclipauth_up }}disabled{{/if}}  onclick="checkieNT52(this)" {{if $member.rdpclipauth_up }}checked{{/if}} value="1"  />&nbsp;&nbsp;&nbsp;&nbsp;本地:<input type="checkbox" name="consoleauth_" id="consoleauth_" {{if !$member.rdplocal}}disabled{{/if}} value="1"  />&nbsp;&nbsp;<select  class="wbk"  name='fenbianlv' id='fenbianlv' > 
					<option value="3" {{if $member.rdp_screen eq 3}}selected{{/if}}>全屏</option>
					<option value="1" {{if $member.rdp_screen eq 1}}selected{{/if}}>800*600</option>
					<option value="2" {{if $member.rdp_screen eq 2}}selected{{/if}}>1024*768</option>
					</select>&nbsp;&nbsp;<select  class="wbk"  name='login_type' id='login_type' > 
					<option value="web" {{if $member.default_appcontrol eq 0}}selected{{/if}}>WEB</option>
					<option value="rdp" {{if $member.default_appcontrol eq 1}}selected{{/if}}>RDP</option>
					</select>
					
					域名连接:<input type="checkbox" name="bydomain" id="bydomain" {{if $bydomain}}checked{{/if}} value="1"  />{{/if}}
</form>
	  </td>
  </tr>
 
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_workflow&action=workflow_delete" method="post">
                <TBODY>
                  <TR>
			
                    <th class="list_bg" width="5%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=groupname&orderby2={{$orderby2}}" >选</a></TD>
                    <th class="list_bg" width="10%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=dateline&orderby2={{$orderby2}}" >申请时间</a></TD>
					<th class="list_bg" width="10%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=dateline&orderby2={{$orderby2}}" >结束时间</a></TD>
                    <th class="list_bg" width="8%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=device_ip&orderby2={{$orderby2}}" >设备IP</a></TD>
                    <th class="list_bg" width="8%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=username&orderby2={{$orderby2}}" >用户名</a></TD>
                    <th class="list_bg" width="8%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=login_template.login_method&orderby2={{$orderby2}}" >登录方式</a></TD>
                    <th class="list_bg" width="8%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=name&orderby2={{$orderby2}}" >操作内容</a></TD>
                    <th class="list_bg" width="10%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=status&orderby2={{$orderby2}}" >状态</a></TD>
                    <th class="list_bg" width="20%"><a href="admin.php?controller=admin_workflow&action=workflow&orderby1=desc&orderby2={{$orderby2}}" >描述</a></TD>
					<th class="list_bg" width="15%">操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$s}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td width="5%">{{if $s[t].status eq 0}}<input type="checkbox" name="chk_gid[]" value="{{$s[t]['sid']}}">{{/if}}</td>
				 <td> {{$s[t].dateline}}</td>
				 <td> {{$s[t].deadline}}</td>
				 <td> {{$s[t].device_ip}}</td>
				 <td> {{$s[t].username}}</td>
				 <td> {{$s[t].login_method}}</td>
				 <td> {{$s[t].name}}</td>
				 <td> <a href='#' onclick='loadurl("admin.php?controller=admin_workflow&action=show_workflow_log&wid={{$s[t]['sid']}}", 600);return false;'>{{if !$s[t].status}}未审批{{elseif $s[t].status eq 1}}关单{{elseif $s[t].status eq 2}}驳回{{elseif $s[t].status eq 3}}审批中{{elseif $s[t].status eq 4}}审批完成{{/if}}</a></td>
				  <td> <span title="{{$s[t].desc}}">{{$s[t].desc|truncate_cn:"20":"..."}}</span></td>
				<td style="TEXT-ALIGN: left;">
				{{if $s[t].status lt 4}}
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_workflow&action=workflow_edit&sid={{$s[t]['sid']}}" >{{if $s[t].status eq 2}}重新申请{{else}}编辑{{/if}}</a>
				{{else}}
				{{if $admin_level == 0}}	
					{{if  $s[t].login_method eq 'RDP' or $s[t].login_method eq 'X11'}}					{{if $s[t].enable}}
					<a id="a{{$s[t].devicesid}}1" onclick="rdpgo({{$s[t].devicesid}},0,true);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id={{$s[t].devicesid}}'><img src="{{$template_root}}/images/mstsc_ico.gif" border=0 title="MSTSC"></a>{{if  $windows_version ne '5.2'}}&nbsp;&nbsp;&nbsp;<a id="a{{$s[t].devicesid}}2" onclick="rdpgo2({{$s[t].devicesid}},0,true)" href='#' target="_blank"><img src="{{$template_root}}/images/ie_ico.png" title="ACTIVEX" border=0></a>{{/if}}					{{else}}
					({{$s[t].login_method}}<img src="{{$template_root}}/images/ie_ico.png" title="ACTIVEX" border=0>					{{/if}}
				
					{{/if}}
					{{if $s[t].login_method eq 'ssh1' or $s[t].login_method eq 'ssh' or $s[t].login_method eq 'telnet' or $s[t].login_method eq 'rlogin'}}	{{if $s[t].enable }}
					<a id="p{{$s[t].devicesid}}" href="admin.php?controller=admin_pro&action=dev_login&id={{$s[t].devicesid}}&logintool=putty&type={{$type}}" onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/putty_ico.gif" title="PUTTY" border=0></a>&nbsp;&nbsp;&nbsp;
			
					 <a id="s{{$s[t].devicesid}}" href="admin.php?controller=admin_pro&action=dev_login&id={{$s[t].devicesid}}&logintool=securecrt&type={{$type}}" onclick="return goto3(this.id)"  target="hide" ><img src="{{$template_root}}/images/scrt_ico.gif" title="SECURECRT" border=0></a></a>
					 {{else}}
					 <img src="{{$template_root}}/images/putty_ico.gif" title="PUTTY" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/scrt_ico.gif"  title="SECURECRT" border=0>
					{{/if}}
					{{elseif $s[t].login_method eq 'ftp' or $s[t].login_method eq 'sftp'}}
					{{if $s[t].enable }}
					<a id="a{{$s[t].devicesid}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=winscp&id={{$s[t].devicesid}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/winscp_ico.gif"  title="WINSCP" border=0></a>&nbsp;&nbsp;&nbsp;<a id="b{{$s[t].devicesid}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=flashxp&id={{$s[t].devicesid}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/flashfxp_icon.png" title="FLASHXP" border=0></a>
					{{else}}
					<img src="{{$template_root}}/images/winscp_ico.gif"  title="WINSCP" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/flashfxp_icon.png" title="FLASHXP" border=0>
					{{/if}}
					{{elseif $s[t].login_method eq 'RDP2008' or $s[t].login_method eq 'vnc' or $s[t].login_method eq 'Web' or $s[t].login_method eq 'Sybase' or $s[t].login_method eq 'Oracle' or $s[t].login_method eq 'DB2' or $s[t].login_method eq 'apppub'}}
					{{if $s[t].enable }}
					<a id="a{{$s[t].devicesid}}1" onclick="rdpgo({{$s[t].devicesid}},0,false);return false;" href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id={{$s[t].devicesid}}'><font style="font-size:12px;" {{if $s[t].puttyhong eq 1}}color="red"{{/if}} ><img src="{{$template_root}}/images/mstsc_ico.gif" title="MSTSC" border=0></font></a> {{if  $windows_version ne '5.2'}}<a id="a{{$s[t].devicesid}}2" onclick="rdpgo2({{$s[t].devicesid}},0,false)" href='#' target="_blank"><img src="{{$template_root}}/images/ie_ico.png" title="ACTIVEX" border=0></a>
					
{{/if}}					{{else}}
					<img src="{{$template_root}}/images/mstsc_ico.gif" title="MSTSC" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/ie_ico.png" title="ACTIVEX" border=0>
					{{/if}}	
					{{/if}}			
					{{if $s[t].login_method eq 'ssh' and $s[t].sftp }}
					{{if $s[t].enable }}
					&nbsp;&nbsp;&nbsp;<a id="a{{$s[t].devicesid}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=winscp&id={{$s[t].devicesid}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/winscp_ico.gif" title="WINSCP" border=0></a>&nbsp;&nbsp;&nbsp;<a id="b{{$s[t].devicesid}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=flashxp&id={{$s[t].devicesid}}'  onclick="return goto3(this.id)" target="hide"><img src="{{$template_root}}/images/flashfxp_icon.png" title="FLASHXP" border=0></a>
					{{else}}
					<img src="{{$template_root}}/images/winscp_ico.gif" title="WINSCP" border=0>&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/flashfxp_icon.png" title="FLASHXP" border=0>
					{{/if}}	
				
					{{/if}}
					
					{{/if}}
					
					 | 
					 <img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='#' onclick='loadurl("admin.php?controller=admin_workflow&action=search_sessions&wid={{$s[t]['sid']}}", 600);return false;' >关单</a>
				{{/if}}
				</td> 
			</tr>
			{{/section}}
	          <tr>
	           <td  colspan="4" align="left">
		          <input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_gid[]')e.checked=this.form.select_all.checked;}" value="checkbox">全选&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除所选IP');if(chk_form()) document.ip_list.action='admin.php?controller=admin_workflow&action=workflow_delete'; else return false;" class="an_02">&nbsp;&nbsp;
					<input type="button" name="submit" onclick="location='admin.php?controller=admin_workflow&action=workflow_edit'" value="登录审批" class="an_02" />&nbsp;&nbsp;<input type="button" name="submit" onclick="location='admin.php?controller=admin_workflow&action=workflow_new'" value="权限审批" class="an_02" />
		   		</td>
				<td  colspan="7" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_workflow&action=dev_group_index&page='+this.value;">页
		   </td>
		   		</tr>
	           
		</TBODY>
              </TABLE></form>	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
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
</script>
</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


