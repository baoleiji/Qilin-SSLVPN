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
</head>
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "{{$template_root}}/images/date";
var apppub = new Array();
{{section name=ap loop=$apppubs}}
apppub[{{$smarty.section.ap.index}}] = new Array();
apppub[{{$smarty.section.ap.index}}]['ip'] = '{{$apppubs[ap].ip}}';
apppub[{{$smarty.section.ap.index}}]['apps']=new Array();
{{section name=ap2 loop=$apppubs[ap].apps}}
apppub[{{$smarty.section.ap.index}}]['apps'][{{$smarty.section.ap2.index}}]=new Array();
apppub[{{$smarty.section.ap.index}}]['apps'][{{$smarty.section.ap2.index}}]['id']='{{$apppubs[ap].apps[ap2].id}}';
apppub[{{$smarty.section.ap.index}}]['apps'][{{$smarty.section.ap2.index}}]['name']='{{$apppubs[ap].apps[ap2].name}}';
apppub[{{$smarty.section.ap.index}}]['apps'][{{$smarty.section.ap2.index}}]['url']='{{$apppubs[ap].apps[ap2].url}}';

{{/section}}
{{/section}}

</SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "{{$template_root}}/images/date";
var appprogram = new Array();
{{section name=pp loop=$appprogram}}
appprogram[{{$appprogram[pp].id}}]='{{$appprogram[pp].path|addslashes}}';
{{/section}}
function setappaddress(value){
	var name = document.getElementById('autologinflag').options[document.getElementById('autologinflag').options.selectedIndex].text.toLowerCase();

	document.getElementById('url').style.display='';
	document.getElementById('mysqlport').style.display='none';
	document.getElementById('troracle_auth').style.display='none';
	document.getElementById('entrust_password_tr').style.display='';
	document.getElementById('oracle_name_tr').style.display='none';		
	if(name=='ie'||name=='ie6'||name=='ie7'||name=='ie8'||name=='ie9'||name=='ie10'||name=='ie11'||appprogram[value].indexOf('iexplore.exe')>0){
		document.getElementById('url').style.display='';
		document.getElementById('entrust_password_tr').style.display='';
	}else if(name=='toad' || name=='plsql'){
		document.getElementById('troracle_auth').style.display='';
		if(name=='plsql'){		
			document.getElementById('entrust_password_tr').style.display='';
			document.getElementById('oracle_name_tr').style.display='';		
		}
	}else if(name=='navicat'){
		document.getElementById('url').style.display='none';
	document.getElementById('mysqlport').style.display='';
	}
	window.parent.reinitIframe();
	document.getElementById('path').value=appprogram[value];
	document.getElementById('path').readonly=true;

}

var AllServers = new Array();
var i=0;
{{section name=kk loop=$servers}}
AllServers[i++]='{{$servers[kk].device_ip}}';
{{/section}}
var AllMember = new Array();
i=0;
{{section name=kk loop=$allmem}}
AllMember[{{$smarty.section.kk.index}}] = new Array();
AllMember[{{$smarty.section.kk.index}}]['username']='{{$allmem[kk].username}}';
AllMember[{{$smarty.section.kk.index}}]['realname']='{{$allmem[kk].realname}}';
AllMember[{{$smarty.section.kk.index}}]['uid']='{{$allmem[kk].uid}}';
AllMember[{{$smarty.section.kk.index}}]['groupid']='{{$allmem[kk].groupid}}';
AllMember[{{$smarty.section.kk.index}}]['check']='{{$allmem[kk].check}}';
{{/section}}
function filter(){
	var filterStr = document.getElementById('filtertext').value;
	var appserver = document.getElementById('device_ip');
	appserver.options.length=1;
	for(var i=0; i<AllServers.length;i++){
		if(filterStr.length==0 || AllServers[i].indexOf(filterStr) >= 0){
			appserver.options[appserver.options.length++] = new Option(AllServers[i],AllServers[i]);
		}
	}
}

function searchit(){
	var url = "admin.php?controller=admin_config&action=apppub_edit&&id={{$apppubid}}&appserverip={{$appserverip}}";
	url += "&webuser="+document.f1.elements.webuser.value;
	url += "&webgroup="+document.f1.elements.webgroup.value;
	{{if $_config.LDAP}}
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	{{else}}
	for(var i=1; true; i++){
		var obj=document.getElementById('groupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	{{/if}}
	url += "&groupid="+gid;
	{{/if}}
	window.location=url;
	return false;
}
</SCRIPT>

<script>

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var allserver = new Array();

var i=0;
{{section name=au loop=$alluser}}
alluser[i++]={uid:{{$alluser[au].uid}},username:'{{$alluser[au].username}}',realname:'{{$alluser[au].realname}}',groupid:{{$alluser[au].groupid}},level:{{$alluser[au].level}}};
{{/section}}
var i=0;
{{section name=as loop=$allserver}}
allserver[i++]={hostname:'{{$allserver[as].hostname}}',device_ip:'{{$allserver[as].device_ip}}',groupid:{{$allserver[as].groupid}}};
{{/section}}

</script>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	{{if $smarty.get.device_ip eq ''}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appserver_list">应用发布</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 3}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appprogram_list">应用程序</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appicon_list">应用图标</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	{{else}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $from eq 'dir'}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{/if}}
	{{if $from eq 'dir'}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller={{if $fromapp eq 'search'}}admin_pro&action=app_priority_search{{else}}admin_config&action=apppub_list{{if $smarty.get.device_ip eq ''}}&ip={{$appserverip}}{{/if}}&device_ip={{$smarty.get.device_ip}}{{/if}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" >
	
          <tr>
            <td align="center">
    <form name="f1" method=post action="admin.php?controller=admin_config&action=apppub_save&id={{$apppubid}}&appserverip={{$appserverip}}&device_ip={{$smarty.get.device_ip}}">
<input type="password" name="hiddenpassword" id="hiddenpassword" style="display:none"/>	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<TR>
	<td></td>
	<TD colspan="1" align="left">
	
		{{include file="select_sgroup_ajax.tpl" }}    运维用户<input type="text" class="wbk" name="webuser" value="{{$webuser}}">
	资源组<input type="text" class="wbk" name="webgroup" value="{{$webgroup}}">
	&nbsp;&nbsp;<input  type="button" value=" 搜索 " onclick="searchit();" class="bnnew2">
	</TD>
  </TR>
	{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>应用名称</td>
		<td><input type="text" name="name" value="{{$pp.name}}" /></td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>用户名</td>
		<td><input type="text" name="username" value="{{$p.username}}" /></td>
	</tr>
	
		{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>密码</td>
		<td><input type="password" name="password" value="{{$p.cur_password}}" /></td>
	  </tr>
	   {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>确认密码</td>
		<td><input type="password" name="repassword" value="{{$p.cur_password}}" /></td>
	  </tr>
	 
	   {{assign var="trnumber" value=$trnumber+1}}
	  <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>服务器列表</td>
		<td>
		<input type="text" class="wbk" size="10" id="filtertext" onChange="filter();" />
                  <select  class="wbk"  name="device_ip" id="device_ip">
						{{if $smarty.get.device_ip eq ''}}
                      <OPTION value="">{{$language.nobind}}</OPTION>
					  {{/if}}
                     	{{section name=k loop=$servers}}
							{{if ($smarty.get.device_ip ne '' and $smarty.get.device_ip eq $servers[k].device_ip) or $smarty.get.device_ip eq ''}}
							<option value="{{$servers[k].device_ip}}" {{if $servers[k].device_ip == $p.device_ip}}selected{{/if}}>{{$servers[k].device_ip}}</option>
							{{/if}}
						{{/section}}
                  </SELECT>
		</td>
	</tr>
	{{if $appserverip eq ''}}
	 {{assign var="trnumber" value=$trnumber+1}}
	  <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>应用发布服务器</td>
		<td>
		  <select  class="wbk"  name="appserverip" id="appserverip">
				{{section name=ka loop=$appserverips}}
					<option value="{{$appserverips[ka].appserverip}}" {{if $appserverips[ka].appserverip == $s.appserverip}}selected{{/if}}>{{$appserverips[ka].appserverip}}</option>
				{{/section}}
		  </SELECT>
		</td>
	</tr>
	{{/if}}
	{{assign var="trnumber" value=$trnumber+1}}
	  <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>程序列表</td>
		<td>
			<select  class="wbk" id="autologinflag"  onchange="setappaddress(this.value)" name="autologinflag" >
			<option value="" >请选择</option>
			{{section name=p loop=$appprogram}}
			<option value="{{$appprogram[p].id}}" id="program_{{$appprogram[p].name}}" {{if $pp.appprogramname eq $appprogram[p].name}}selected{{/if}} >{{$appprogram[p].name}} </option>
			{{/section}}
			</select>
		</td>
	  </tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="troracle_auth"  style="display:none">
		<td width="10%" align=right>ORACLE认证</td>
		<td>
			<select  class="wbk" id="oracle_auth"  name="oracle_auth" >
			<option value="Normal" {{if $p.oracle_auth eq 'Normal'}}selected{{/if}}>Normal</option>
			<option value="SYSDBA" {{if $p.oracle_auth eq 'SYSDBA'}}selected{{/if}}>SYSDBA</option>
			<option value="SYSOPER" {{if $p.oracle_auth eq 'SYSOPER'}}selected{{/if}}>SYSOPER</option>
			</select>
		</td>
	  </tr>
		{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>程序地址</td>
		<td><input type="text" size="100" id="path" name="path" value="{{$pp.path}}" /></td>
	  </tr>
	   {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="url" >
		<td width="10%" align=right>URL</td>
		<td><input type="text" size="100" name="url" value="{{$pp.url}}" /></td>
	  </tr>
	  {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="mysqlport" >
		<td width="10%" align=right>MySQL端口</td>
		<td><input type="text" size="100" name="navicat_port" value="{{$p.navicat_port}}" /></td>
	  </tr>
	   {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="entrust_password_tr" >
		<td width="10%" align=right>自动登录</td>
		<td><input type="checkbox" name="entrust_password" value="1" {{if !$apppubid or $p.entrust_password}}checked{{/if}} /></td>
	  </tr>
	   {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="oracle_name_tr" style="display:none">
		<td width="10%" align=right>实例名称</td>
		<td><input type="text" size="30" name="oracle_name" value="{{$p.oracle_name}}" /></td>
	  </tr>
	  {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>描述</td>
		<td><textarea name="description" cols="50" rows="5">{{$pp.description}}</textarea></td>
	  </tr>
	   {{assign var="trnumber" value=$trnumber+1}}
	  <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>是否允许密码自动修改</td>
		<td><input type="checkbox" name="change_password" value="1" {{if $p.change_password}}checked{{/if}} /></td>
	</tr>
	  {{assign var="trnumber" value=$trnumber+1}}
	  <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right>激活</td>
		<td><input type="checkbox" name="enable" value="1" {{if $p.enable}}checked{{/if}} /></td>
	</tr>
	  {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	  <td width="10%" align="right"  valign=top>绑定分组
	  <table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' {{if $smarty.get.bindgroup eq 1}}checked{{/if}} onclick="reload('bindgroup=1','bindgroup=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' {{if $smarty.get.bindgroup eq 2}}checked{{/if}} onclick="reload('bindgroup=2','bindgroup=0',this.checked);"></td></tr>
	  </table></td>
	  <td >
	  <table><tr >
	  {{section name=u loop=$usergroup}}
	  {{if !$smarty.get.bindgroup or ($smarty.get.bindgroup eq 2 and $usergroup[u].check eq '') or ($smarty.get.bindgroup eq 1 and $usergroup[u].check eq 'checked')}}
		<td width="180"><input type="checkbox" name='group[]' value='{{$usergroup[u].id}}'  {{$usergroup[u].check}}>{{*<a onclick="window.open ('admin.php?controller=admin_config&action=apppubedit_selgroup&gid={{$usergroup[u].id}}&apppubid={{$p.id}}&sessionlgroup={{$sessionlgroup}}', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" >*}}{{$usergroup[u].groupname}}{{*</a>*}}</td>{{if ($smarty.section.u.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/if}}
		{{/section}}
	</tr></table>
	  </td>
	  </tr>
	 
<td></td><td></td></tr>
		 {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%" align=right  valign=top>
		绑定用户
		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' {{if $smarty.get.binduser eq 1}}checked{{/if}} value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' {{if $smarty.get.binduser eq 2}}checked{{/if}} value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll(this.checked);"></td></tr>
	  </table>
		</td>
		<td>
		<table><tr >
		{{section name=g loop=$allmem}}
		{{if !$smarty.get.binduser or ($smarty.get.binduser eq 2 and $allmem[g].check eq '') or ($smarty.get.binduser eq 1 and $allmem[g].check eq 'checked')}}
		<td width="180"><input type="checkbox" name='member[]' id="uid_{{$allmem[g].uid}}" value='{{$allmem[g].uid}}'  {{$allmem[g].check}}>{{*<a onclick="window.open ('admin.php?controller=admin_config&action=apppubedit_seluser&memberid={{$allmem[g].uid}}&apppubid={{$p.id}}&sessionluser={{$sessionluser}}', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" >*}}{{$allmem[g].username}}({{if $allmem[g].realname}}{{$allmem[g].realname}}{{else}}未设置{{/if}}){{*</a>*}}</td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
	 
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td></td><td><input type="hidden" name="ac" value="new" />
<input type="hidden" name="id" value="{{$p.id}}" />
<input type=submit  value="保存修改" class="an_02"></td></tr>
	</table>
<br>
<input type="hidden" name="sessionlgroup" value="{{$sessionlgroup}}" />
<input type="hidden" name="sessionluser" value="{{$sessionluser}}" />
</form>
	</td>
  </tr>
</table>
<script type="text/javascript">
function checkAll(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,6)=='member'){
			targets[j].checked=c;
		}
	}
}
function reload(p1,p2,check){
	window.location=window.location+'&'+(check ? p1 : p2);
}
/*if(document.getElementById('program_IE').selected||(document.getElementById('program_IE6')!=undefined&&document.getElementById('program_IE6').selected)||(document.getElementById('program_IE7')!=undefined&&document.getElementById('program_IE7').selected)||(document.getElementById('program_IE8')!=undefined&&document.getElementById('program_IE8').selected)||(document.getElementById('program_IE9')!=undefined&&document.getElementById('program_IE9').selected)||(document.getElementById('program_IE10')!=undefined&&document.getElementById('program_IE10').selected)||(document.getElementById('program_IE11')!=undefined&&document.getElementById('program_IE11').selected)){
	document.getElementById('url').style.display='';
}*/

document.getElementById('mysqlport').style.display='none';
var appid = document.getElementById('autologinflag').options[document.getElementById('autologinflag').options.selectedIndex].value;

if(/^[0-9]+$/.test(appid)&&appprogram[appid].indexOf('iexplore.exe')>0){
	document.getElementById('url').style.display='';
	document.getElementById('mysqlport').style.display='none';
}else if(appprogram[appid].indexOf('navicat')>0){
	document.getElementById('mysqlport').style.display='';
	document.getElementById('url').style.display='none';
}
if((document.getElementById('program_TOAD')!=undefined&&document.getElementById('program_TOAD').selected) || (document.getElementById('program_PLSQL')!=undefined&&document.getElementById('program_PLSQL').selected) ){
	document.getElementById('troracle_auth').style.display='';
	if(document.getElementById('program_PLSQL').selected){
		document.getElementById('entrust_password_tr').style.display='';
		document.getElementById('oracle_name_tr').style.display='';		
	}
	window.parent.reinitIframe();
}
if(document.getElementById('program_IE')!=undefined&&document.getElementById('program_IE').selected){
	document.getElementById('entrust_password_tr').style.display='';
	window.parent.reinitIframe();
}
</script>

<script>

{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
</body>

<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>