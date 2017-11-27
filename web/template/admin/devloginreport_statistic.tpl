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
	document.search.action = "{{$curr_url}}";
	document.search.action += "&f_rangeStart="+document.search.f_rangeStart.value;
	document.search.action += "&f_rangeEnd="+document.search.f_rangeEnd.value;
	document.search.action += "&usergroup="+document.search.usergroup.value;
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
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="#">系统登录报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search_diy">自定义报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_reports&action={{if $smarty.get.dateinterval eq 'diy'}}report_search_diy{{else}}report_search{{/if}}&back=1"><IMG src="./template/admin/images/back1.png" width="80" height="25" border="0"></A></span>
</div></td></tr>



  <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="search" >
运维组：<select name='usergroup' id="usergroup" style="width:150px">
			<option value="">所有组</option>
			{{section name=g loop=$usergroup}}
			<option value="{{$usergroup[g].groupname}}">{{$usergroup[g].groupname}}</option>
			{{/section}}
		</select>
{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="{{$f_rangeStart|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">


 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="{{$f_rangeEnd|date_format:'%Y-%m-%d'}}" />
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
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">序号</th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=device_ip&orderby2={{$orderby2}}" >运维用户</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=device_ip&orderby2={{$orderby2}}" >别名</a></th>	
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=device_ip&orderby2={{$orderby2}}" >运维组</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=protocol&orderby2={{$orderby2}}" >服务器IP</a></th>	
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=local_user&orderby2={{$orderby2}}" >主机名</a></th>						
						<th class="list_bg"   width="5%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=fort_user&orderby2={{$orderby2}}" >协议</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=protocol&orderby2={{$orderby2}}" >系统用户</a></th>	
						<th class="list_bg"   width="7%"><a href="admin.php?controller=admin_reports&action=commandreport&orderby1=fort_user&orderby2={{$orderby2}}" >登录次数</a></th>
						<th class="list_bg"  >开始日期</th>
						<th class="list_bg"  >结束日期</th>
					
					</tr>
					{{section name=t loop=$reports}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="10%">{{$smarty.section.t.index+1}}</td>
						<td width="10%">{{$reports[t].luser}}</td>
						<td width="10%">{{$reports[t].realname}}</td>
						<td width="10%">{{$reports[t].groupname}}</td>
						<td width="10%">{{$reports[t].device_ip}}</td>
						<td width="10%">{{$reports[t].hostname}}</td>
						<td width="5%">{{$reports[t].type}}</td>
						<td width="10%">{{$reports[t].user}}</td>
						<td width="7%">{{$reports[t].ct}}</td>
						<td width="10%">{{$reports[t].mstart|date_format:'%Y-%m-%d'}}</td>
						<td width="10%">{{$reports[t].mend|date_format:'%Y-%m-%d'}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <!--当前数据表: {{$now_table_name}}-->   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2" ><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a>  <a href="{{$curr_url}}&derive=4" ><img src="{{$template_root}}/images/pdf.png" border=0></a>{{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1"></a>{{/if}}
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


