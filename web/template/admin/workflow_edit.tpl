<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
{{if $_config.LDAP}}
var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();

{{/if}}

var servers = new Array();
{{section name=s loop=$userpriority}}
servers[servers.length]={id: {{$userpriority[s].id}}, device_ip: '{{$userpriority[s].device_ip}}', username: '{{if !$userpriority[s].username}}空用户{{else}}{{$userpriority[s].username}}{{/if}}', login_method: '{{$userpriority[s].login_method}}', groupid: '{{$userpriority[s].groupid}}'};
{{/section}}

function changegroup(group,defaultip){
	var s = document.getElementById('ip');
	var d = document.getElementById('devicesid');
	s.options.length=0;
	d.options.length=0;
	s.options[s.options.length] = new Option('', '请选择');
	for(var i=0; i<servers.length; i++){
		if(servers[i].groupid==group){
			var found = false;
			for(var j=0; j<s.options.length; j++){
				if(s.options[j].value==servers[i].device_ip){
					found = true;
					break;
				}					
			}
			if(!found){
				if(defaultip==servers[i].device_ip){
					s.options[s.options.length] = new Option(servers[i].device_ip, servers[i].device_ip, true, true);
				}else{
					s.options[s.options.length] = new Option(servers[i].device_ip, servers[i].device_ip);
				}				
			}
		}
	}
}

function changeip(ip,defaultuser){
	var s = document.getElementById('username');
	var d = document.getElementById('devicesid');
	s.options.length=0;
	d.options.length=0;
	s.options[s.options.length] = new Option('', '请选择');
	for(var i=0; i<servers.length; i++){
		if(servers[i].device_ip==ip){
			var found = false;
			for(var j=0; j<s.options.length; j++){
				if(s.options[j].value==servers[i].username){
					found = true;
					break;
				}					
			}
			if(!found){
				if(defaultuser==servers[i].username){
					s.options[s.options.length] = new Option(servers[i].username, servers[i].username, true, true);
				}else{
					s.options[s.options.length] = new Option(servers[i].username, servers[i].username);
				}				
			}
		}
	}
}

function changeuser(user,defaultsid){
	var d = document.getElementById('devicesid');
	var _ip = document.getElementById('ip').options[document.getElementById('ip').options.selectedIndex].value;
	d.options.length=0;
	d.options[d.options.length] = new Option('', '请选择');
	for(var i=0; i<servers.length; i++){
		if(servers[i].device_ip==_ip && servers[i].username==user){
			if(defaultsid==servers[i].id){
				d.options[d.options.length] = new Option(servers[i].login_method, servers[i].id, true, true);
			}else{
				d.options[d.options.length] = new Option(servers[i].login_method, servers[i].id);
			}
		}
	}
}
</script>
</head>

<body>
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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}{{/if}}
<li class=me_a><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow">运维流程</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_workflow&action=workflow&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_workflow&action=workflow_save&sid={{$sip['sid']}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<tr >
	<td align=right>目录</td><td>

		{{include file="select_sgroup_ajax.tpl" }}     
	</td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		设备IP	
		</td>
		<td width="67%">
		{{if !$sip.status or $sip.status eq 2}}
		<select name="ip" id="ip" onchange="changeip(this.value,'')" >
		<option value="">请选择</option>
		{{section name=s loop=$servers}}
		<option value="{{$servers[s]}}" {{if $servers[s] eq $sip.device_ip}}selected{{/if}}>{{$servers[s]}}</option>
		{{/section}}
		</select>
		{{else}}
		{{$sip.device_ip}}
		{{/if}}
	  </td>
	</tr>	
	<tr bgcolor="">
		<td width="33%" align=right>
		用户名
		</td>
		<td width="67%">
		{{if !$sip.status or $sip.status eq 2}}
		<select name="username" id="username" onchange="changeuser(this.value,'')">
		</select>
		{{else}}
		{{if !$sip.username}}空用户{{else}}{{$sip.username}}{{/if}}
		{{/if}}
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		登录方式
		</td>
		<td width="67%">
		{{if !$sip.status or $sip.status eq 2}}
		<select name="devicesid" id="devicesid">
		</select>
		{{else}}
		{{$sip.login_method}}
		<input type="hidden" name=devicesid value="{{$sip.devicesid}}" />
		{{/if}}
	  </td>
	</tr>
	<tr bgcolor="">
		<td width="33%" align=right>
		操作内容
		</td>
		<td width="67%">
		{{if !$sip.status or $sip.status eq 2}}
		<select name="wfcontant">
		{{section name=wf loop=$wfcontant}}
		<option value="{{$wfcontant[wf]['sid']}}" {{if $sip.contant eq $wfcontant[wf]['sid']}}selected{{/if}}>{{$wfcontant[wf].name}}</option>
		{{/section}}
		</select>
		{{else}}
		{{$sip.name}}
		<input type="hidden" name=wfcontant value="{{$sip.contant}}" />
		{{/if}}
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
	<td width="33%" align=right valign="top">
		描述
		</td>
		<td width="67%">
		<textarea cols="37" rows="10"  name="desc">{{$sip.desc}}</textarea>
	  </td>
	</tr>	
	<tr bgcolor="f7f7f7"><td></td><td><input type=submit  value="{{$language.Save}}" class="an_02"></td></tr></table>

</form>
	</td>
  </tr>
</table>
<script>

{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


