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
	document.search.action = "admin.php?controller=admin_reports&action=reportaudit";
	document.search.action += "&f_rangeStart="+document.search.f_rangeStart.value;
	document.search.action += "&f_rangeEnd="+document.search.f_rangeEnd.value;
	document.search.action += "&number="+{{$number}};
	//alert(document.search.action);
	//return false;
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
<ul>
 

	<li class={{if $number ne 1}}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $number ne 1}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=reportaudit">{{$language.User}}{{$language.LoingReport}}</a><img src="{{$template_root}}/images/an3{{if $number ne 1}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class={{if $number ne 2}}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $number ne 2}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=reportaudit&number=2">运行{{$language.Command}}{{$language.report}}</a><img src="{{$template_root}}/images/an3{{if $number ne 2}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class={{if $number ne 3}}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $number ne 3}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=reportaudit&number=3">FTP/SFTP{{$language.Command}}{{$language.report}}</a><img src="{{$template_root}}/images/an3{{if $number ne 3}}3{{/if}}.jpg" align="absmiddle"/></li>
	
	<li class={{if $number ne 6}}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $number ne 6}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=reportaudit&number=6">应用报表</a><img src="{{$template_root}}/images/an3{{if $number ne 6}}3{{/if}}.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>



  <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="search" >
{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="{{$f_rangeStart}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">


 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="{{$f_rangeEnd}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="wbk">
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
</form> 
	  </td>
  </tr>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: false
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d");
</script>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
					{{if $number lt 6}}
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=reportaudit&number={{$number}}&orderby1=device_ip&orderby2={{$orderby2}}" >{{$language.DeviceAddress}}</a></th>
						
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=reportaudit&number={{$number}}&orderby1=protocol&orderby2={{$orderby2}}" >{{$language.protocol}}</a></th>						
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=reportaudit&number={{$number}}&orderby1=local_user&orderby2={{$orderby2}}" >{{$language.LocalUser}}{{$language.User}}</a></th>
						
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=reportaudit&number={{$number}}&orderby1=fort_user&orderby2={{$orderby2}}" >{{$language.WebUser}}{{$language.User}}</a></th>
						<th class="list_bg"  >{{if $number eq 3}}{{$language.fileoperate}}{{else}}{{$language.Command}}{{/if}}</th>
						<th class="list_bg"   width="8%">{{if $number == 1 or $number==6}}{{$language.Logintimes}}{{else}}{{$language.times}}{{/if}}</th>
					{{elseif $number eq 6}}
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=reportaudit&number={{$number}}&orderby1=serverip&orderby2={{$orderby2}}" >{{$language.DeviceAddress}}</a></th>						
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=reportaudit&number={{$number}}&orderby1=username&orderby2={{$orderby2}}" >{{$language.WebUser}}{{$language.User}}</a></th>
						<th class="list_bg"  >应用</th>
						<th class="list_bg"   width="8%"><a href="admin.php?controller=admin_reports&action=reportaudit&number={{$number}}&orderby1=ct&orderby2={{$orderby2}}" >{{$language.Logintimes}}</a></th>
					{{/if}}
					</tr>
					{{section name=t loop=$reports}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="10%">{{$reports[t].device_ip}}</td>
								
						{{if $number lt 6}}
						<td width="10%">{{$reports[t].protocol}}</td>
						<td width="10%">{{$reports[t].local_user}}</td>
						<td width="10%">{{$reports[t].fort_user}}</td>
						<td >{{if $number eq 2}}{{$reports[t].commands}}{{elseif $number eq 3}}{{$reports[t].file_operation}}{{elseif $number eq 4 or $number eq 5}}{{$reports[t].sql_cmd}}{{else}}{{$reports[t].commands}}{{/if}}</td>
						<td width="8%">{{if $number eq 2 or $number eq 4 or $number eq 5}}{{$reports[t].cmd_times}}{{elseif $number eq 3}}{{$reports[t].operation_times}}{{else}}{{$reports[t].login_times}}{{/if}}</td>
						{{elseif $number eq 6}}
						<td width="10%">{{$reports[t].username}}</td>
						<td width="10%">{{$reports[t].apppath}}</td>
						<td width="10%">{{$reports[t].ct}}</td>
						{{/if}}										
						
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <!--当前数据表: {{$now_table_name}}-->   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2" >  <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a><img src="{{$template_root}}/images/html.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1"></a>{{/if}}
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


