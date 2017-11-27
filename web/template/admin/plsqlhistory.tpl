<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function searchit(){
	document.search.action = "admin.php?controller=admin_apppub&action=plsqlhistory&backupdb_id={{$backupdb_id}}";
	document.search.action += "&username="+document.search.username.value;
	document.search.action += "&dbname="+document.search.dbname.value;
	document.search.action += "&start1="+document.search.f_rangeStart.value;
	document.search.action += "&start2="+document.search.f_rangeEnd.value;
	
	//alert(document.search.action);
	//return false;
	window.location = document.search.action;
	return true;
}
</script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
</head>

<body>

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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#F1F1F1"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>   
    {{*<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_apppub">Http/Https</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>*}}
	{{if $backupdb_id}}
	 <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&backupdb_id={{$backupdb_id}}">Telnet/SSH</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_sftp&backupdb_id={{$backupdb_id}}">SFTP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_scp&backupdb_id={{$backupdb_id}}">SCP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ftp&backupdb_id={{$backupdb_id}}">FTP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 0}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_as400&backupdb_id={{$backupdb_id}}">AS400</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_rdp&backupdb_id={{$backupdb_id}}">RDP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_vnc&backupdb_id={{$backupdb_id}}">VNC</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>   
	{{/if}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_apppub&backupdb_id={{$backupdb_id}}">应用发布</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
<span class="back_img"><A href="admin.php?controller=admin_apppub&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
   <tr>
     <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content"><form action="admin.php?controller=admin_apppub&backupdb_id={{$backupdb_id}}" method="post" name="search" >
  <tr>
    <td></td>
    <td>
	用户名：<input type="text" class="wbk" name="username"  size="13" />
    实例名：<input type="text" class="wbk" name="dbname"  size="13" />
开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value=""/>
 <input type="button" onClick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">

 结束日期：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd" value=""/>
 <input type="button" onClick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk">
	 <select  class="wbk"  id="app_act" style="display:none"><option value="applet" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'applet'}}selected{{/if}}>applet</option><option value="activeX" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'activeX'}}selected{{/if}}>activeX</option></select>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
 </td>
  </tr></form>
</table>  
					
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");


</script>
					</td>
  </tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
					<th class="list_bg"   width="6%"><a href="admin.php?controller=admin_apppub&orderby1=addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">执行时间</a></th>
						<th class="list_bg"   width="6%"><a href="admin.php?controller=admin_apppub&orderby1=cli_addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">用户名</a></th>
						<th class="list_bg"   width="7%"><a href="admin.php?controller=admin_apppub&orderby1=appname&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">数据库</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_apppub&orderby1=username&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">SQL语句</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_apppub&orderby1=realname&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">运维用户</a></th>
						<th class="list_bg"  width="10%">操作</th>
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 5}}bgcolor="red"{{elseif $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td><a href="admin.php?controller=admin_apppub&addr={{$allsession[t].addr}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].excutetime}}</a></td>
						<td><a href="admin.php?controller=admin_apppub&cli_addr={{$allsession[t].cli_addr}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].username}}</a></td>
						<td><a href="admin.php?controller=admin_apppub&appname={{$allsession[t].appname}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].dbname}}</a></td>
						<td><a href="admin.php?controller=admin_apppub&serverip={{$allsession[t].serverip}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].sqltext}}</a></td>
						<td><a href="admin.php?controller=admin_apppub&serverip={{$allsession[t].serverip}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].webuser}}</a></td>
						<td><img src="{{$template_root}}/images/replay.gif" width="16" height="16" align="absmiddle">
					<a  id="p_{{$smarty.section.t.index+1}}" onClick="return go('admin.php?controller=admin_rdp&mstsc=1&sid={{$sid}}&rdptype=sql&replaystime={{$allsession[t].uexcutetime}}','p_{{$smarty.section.t.index+1}}')" href="#" target="hide">回放</a></td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							共{{$session_num}}条会话  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">页 <!--当前数据表: {{$now_table_name}}--> 
						<!--
						<select  class="wbk"  name="table_name">
						{{section name=t loop=$table_list}}
						<option value="{{$table_list[t]}}" {{if $table_list[t] == $now_table_name}}selected{{/if}}>{{$table_list[t]}}</option>
						{{/section}}
						</select>
						-->
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table>
<select  class="wbk"  id="app_act" style="display:none"><option value="applet" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'applet'}}selected{{/if}}>applet</option><option value="activeX" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'activeX'}}selected{{/if}}>activeX</option></select>
<script language="javascript">
function go(url,iid){
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var hid = document.getElementById('hide');
	document.getElementById(iid).href=url+'&app_act='+app_act;
	//alert(hid.src);
	{{if $logindebug}}
	window.open(document.getElementById(iid).href);
	{{/if}}
	return true;	
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
</script>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>



