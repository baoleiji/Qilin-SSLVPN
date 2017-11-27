<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Black}}{{$language.group}}{{$language.List}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
</head>
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
<script type="text/javascript">
function searchit(){
	document.search.action = "admin.php?controller=admin_reports&action=cmdlistreport";
	document.search.action += "&username="+document.search.username.value;
	document.search.action += "&ip="+document.search.ip.value;
	document.search.action += "&start="+document.search.f_rangeStart.value;
	document.search.action += "&end="+document.search.f_rangeEnd.value;
	//alert(document.search.action);
	//return false;
	return true;
}
<!--
function openwin() {
window.open ("admin.php?controller=admin_reports&action=cmdlistreport_users", "newwindow", "height=400, width=800, toolbar=no, menubar=no, scrollbars=auto, resizable=yes, location=no, status=no")
}
function openwin2() {
window.open ("admin.php?controller=admin_reports&action=cmdlistreport_ips", "newwindow1", "height=400, width=800, toolbar=no, menubar=no, scrollbars=auto, resizable=yes, location=no, status=no")
}
function openwin3() {
window.open ("admin.php?controller=admin_reports&action=cmdlistreport_cmds", "newwindow2", "height=400, width=800, toolbar=no, menubar=no, scrollbars=auto, resizable=yes, location=no, status=no")
}
//-->
</script>
<body>



	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=commandreport">命令总计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cmdcachereport">命令统计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cmdlistreport">命令列表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=appreport&number=2">应用报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=sftpreport&number=3">SFTP{{$language.Command}}{{$language.report}}</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=ftpreport&number=6">FTP{{$language.Command}}{{$language.report}}</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
 <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="search" >
运维用户：<select name='username' id="usergroup">
			<option value="">所有用户</option>
			{{section name=g loop=$users}}
			<option value="{{$users[g].username}}">{{$users[g].username}}</option>
			{{/section}}
		</select>
	 &nbsp;&nbsp;<INPUT height="35" align="middle" class="wbk" onclick="openwin()"  type="button" border="0" value="选择">&nbsp;&nbsp;
设备：<select name='ip' id="usergroup">
			<option value="">所有设备</option>
			{{section name=s loop=$servers}}
			<option value="{{$servers[s].device_ip}}">{{$servers[s].device_ip}}</option>
			{{/section}}
		</select>
		&nbsp;&nbsp;<INPUT height="35" align="middle" class="wbk" onclick="openwin2()"  type="button" border="0" value="选择">&nbsp;&nbsp;
      <INPUT height="35" align="middle" class="wbk" onclick="openwin3()"  type="button" border="0" value="命令列表">&nbsp;&nbsp;
{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="16" id="f_rangeStart" value="{{$f_rangeStart|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">


 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="16" id="f_rangeEnd"  value="{{$f_rangeEnd|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="wbk">
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
   <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");
</script>
</form> 
	  </td>
  </tr>
  <tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_reports&action=del_cmdlistreport" method="post">
			<tr>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdlistreport&orderby1=luser&gid={{$gid}}&orderby2={{$orderby2}}" >运维用户</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdlistreport&orderby1=addr&gid={{$gid}}&orderby2={{$orderby2}}" >设备IP</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdlistreport&orderby1=at&gid={{$gid}}&orderby2={{$orderby2}}" >执行时间</a></th>
				<th class="list_bg"  width=""><a href="admin.php?controller=admin_reports&action=cmdlistreport&orderby1=cmd&gid={{$gid}}&orderby2={{$orderby2}}" >命令</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdlistreport&orderby1=dangerlevel&gid={{$gid}}&orderby2={{$orderby2}}" >级别</a></th>			
			</tr>
			{{section name=t loop=$allcommand}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$allcommand[t].luser}}</td>
				<td>{{$allcommand[t].addr}}</td>				
				<td>{{$allcommand[t].at}}</td>				
				<td>{{$allcommand[t].cmd}}</td>				
				<td>{{if !$allcommand[t].dangerlevel}}正常{{elseif $allcommand[t].dangerlevel eq 1}}危险{{elseif $allcommand[t].dangerlevel eq 2}}严重{{elseif $allcommand[t].dangerlevel eq 3}}警告{{elseif $allcommand[t].dangerlevel eq 4}}复核{{/if}}</td>
			</tr>
			{{/section}}
			
			
			<tr>
			<td align="left" colspan="1">

			<input type="hidden" name="add" value="new" >
			</td>
				<td colspan="6" align="right">
					{{$language.all}}{{$command_num}}{{$language.Command}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_reports&action=cmdlistreport&page='+this.value;">{{$language.page}}<!--当前数据表: {{$now_table_name}}-->   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2" target="hide"><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" target="hide"><img src="{{$template_root}}/images/word.png" border=0></a>  <a href="{{$curr_url}}&derive=4" target="hide"><img src="{{$template_root}}/images/pdf.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1" target="hide"></a>{{/if}}
				</td>
			</tr>
			</form>
		</table>
	</td>
  </tr>
</table>


</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


