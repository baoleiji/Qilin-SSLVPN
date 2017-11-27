<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.ReportLine}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script type="text/javascript">
var timetype_id = '';
function changetype(sid){
timetype_id=sid;
document.getElementById(sid).checked=true;
}
function searchit(){
	document.report.action = "admin.php?controller=admin_reports";
	document.report.action += "&timetype="+document.getElementById(timetype_id).value;
	document.report.action += "&month="+document.report.month.value;
	document.report.action += "&week="+document.report.week.value;
	document.report.action += "&f_rangeStart="+document.report.f_rangeStart.value;
	document.report.submit();
	return true;
}
</script>
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
<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports">统计报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
  <tr>
  <td class="main_content">
    
<form action="{{$curr_url}}" method="post" name="report" >
<input type="radio" id="timetype1" onclick="changetype('timetype1')" name="timetype" value="month" >{{$language.Month}}({{$language.Format}}:2010-09)：<input onclick="changetype('timetype1')" type="text" class="wbk" name="month" id="month" />
<input type="radio"  id="timetype2" name="timetype" onclick="changetype('timetype2')" value="week" >按周：<select  class="wbk"  onclick="changetype('timetype2')" name="week" id="week">
<option value="1">上一周</option>
<option value="2">上二周</option>
<option value="3">上三周</option>
<option value="4">上四周</option>
 <input type="radio" id="timetype3" name="timetype" onclick="changetype('timetype3')" value="day" >按{{$language.day}}：<input onclick="changetype('timetype3')" type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" /><input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger"  class="wbk" value="{{$language.Edittime}}">
    &nbsp;&nbsp;<select  class="wbk"  name="types" id="types"  class="wbk">
		
		<option value='user'>{{$language.User}}</option>
		<option value='logintype'>{{$language.Loginmode}}</option>
	  </select>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
	  
</form> 
	  </td>
  </tr>
  <script type="text/javascript">
                  new Calendar({
                          inputField: "f_rangeStart",
                          dateFormat: "%Y-%m-%d",
                          trigger: "f_rangeStart_trigger",
                          bottomBar: false,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });
                
                </script>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  bgcolor="d9ecfa" width="5%">{{$language.Time}}</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">{{$language.Logintimes}}</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">{{$language.Commandsnumber}}</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="5%">{{$language.Sessiontype}}</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">{{$language.LoginUser}}</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">{{$language.LocalUsername}}</th>
						
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td>{{$allsession[t].startym}}</td>
						<td>{{$allsession[t].loginnum}}</td>
						<td>{{$allsession[t].cmdnum}}</td>
						<td>{{$allsession[t].type}}</td>
						<td>{{$allsession[t].user}}({{$allsession[t].realname}})</td>
						<td>{{$allsession[t].luser}}</td>
						
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <!--当前数据表: {{$now_table_name}}-->   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2"  target="hide"><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1"></a>{{/if}}
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
<script type="text/javascript">
function doit(){
var timetp = document.getElementsByTagName("input");
var qs = '';
for(var i=0; i<timetp.length; i++){
	if(timetp[i].name=='timetype'&&timetp[i].checked){
		qs = 'timetype='+timetp[i].value;
		if(timetp[i].value=='month'){
			qs += '&month='+document.getElementById('month').value;
		}else if(timetp[i].value=='week'){
			qs += '&week='+document.getElementById('week').options[document.getElementById('week').selectedIndex].value;
		}else if(timetp[i].value=='day'){
			qs += '&f_rangeStart='+document.getElementById('f_rangeStart').value;
		}
	}
}
qs += '&types='+document.getElementById('types').options[document.getElementById('types').selectedIndex].value;
document.report.action="admin.php?controller=admin_reports&"+qs;
return true;
}
</script>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


