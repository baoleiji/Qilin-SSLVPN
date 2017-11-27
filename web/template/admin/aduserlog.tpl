<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>Audit{{$language.List}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />


<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script type="text/javascript">
function changetype(sid){
document.getElementById(sid).checked=true;
}
function searchit(){
	document.search.action = "admin.php?controller=admin_reports&action=aduserlog";
	document.search.action += "&username="+document.search.username.value;
	document.search.action += "&ldap="+document.search.ldap.value;
	document.search.action += "&start="+document.search.f_rangeStart.value;
	document.search.action += "&end="+document.search.f_rangeEnd.value;
	//alert(document.search.action);
	return true;
}
</script>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>{{*
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2}}	
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=day_count">天报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=week_count">周报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=month_count">月报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}*}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_log">同步日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=system_alert">系统告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=backup_session">双机同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=maillog">系统邮件</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=aduserlog">账号同步</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>



  <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="search" >
用户名：<input type="text" class="wbk"  name="username" size="16" />&nbsp;&nbsp;
目录：
<input  type="text" class="wbk" name="ldap" size="16" />&nbsp;&nbsp;
{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="16" id="f_rangeStart" value="{{$f_rangeStart|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">


 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="16" id="f_rangeEnd"  value="{{$f_rangeEnd|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="wbk">
<input type='submit' value='搜索' onclick="return searchit();" class="an_02" />
</form> 
 <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: false
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d");
</script>
	  </td>
  </tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>                                         
						<th class="list_bg"   width="10%">时间</th>                   
						<th class="list_bg"   width="5%">策略ID</th>
						<th class="list_bg"   width="10%">策略名称</th>
						<th class="list_bg"   width="10%">服务器IP</th>
						<th class="list_bg"   width="10%">同步用户名</th>
						<th class="list_bg"   width="10%">原目录</th>
						<th class="list_bg"   width="10%">新目录</th>
						<th class="list_bg"   width="5%">动作</th>
						<th class="list_bg"   width="5%">操作</th>
					</tr>
					{{section name=t loop=$reports}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="10%">{{$reports[t].time}}</td>
						<td width="10%">{{$reports[t].configid}}</td>
						<td width="10%">{{$reports[t].configname}}</td>
						<td width="10%">{{$reports[t].ip}}</td>
						<td width="10%">{{$reports[t].username}}</td>
						<td width="10%">{{$reports[t].ad}}</td>
						<td width="10%">{{$reports[t].ldap}}</td>
						<td width="5%">{{$reports[t].action}}</td>
						<td><img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_reports&action=aduserlog_del&id={{$alldev[t].id}}';}">删除</a></td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <!--当前数据表: {{$now_table_name}}-->   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2" ><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a>  <a href="{{$curr_url}}&derive=4" ><img src="{{$template_root}}/images/pdf.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1"></a>{{/if}}
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
  {{if $data}}
  <tr><td class="main_content"><img src="include/pChart/graphgenerate.php?{{$data}}{{$info}}graphtype=pie"</td></tr>
  <tr><td class="main_content"><img src="include/pChart/graphgenerate.php?{{$data}}{{$info}}graphtype=bar"</td></tr>
  {{/if}}
</table>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


