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
	document.search.action = "admin.php?controller=admin_reports&action=commandreport";
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
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search">定期报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search_diy">自定义报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>



  <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="search" >
运维组：<select name='usergroup' id="usergroup" style="width:150px">
			<option value="">所有组</option>
			{{section name=g loop=$usergroup}}
			<option value="{{$usergroup[g].id}}">{{$usergroup[g].groupname}}</option>
			{{/section}}
		</select>
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
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=report_search_diy&orderby1=m.username&orderby2={{$orderby2}}" >运维用户</a></th>
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=report_search_diy&orderby1=realname&orderby2={{$orderby2}}" >别名</a></th>
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=report_search_diy&orderby1=groupname&orderby2={{$orderby2}}" >运维组</a></th>
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=report_search_diy&orderby1=start&orderby2={{$orderby2}}" >开始时间</a></th>	
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=report_search_diy&orderby1=end&orderby2={{$orderby2}}" >结束时间</a></th>
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=report_search_diy&orderby1=applytime&orderby2={{$orderby2}}" >提交时间</a></th>
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=report_search_diy&orderby1=createtime&orderby2={{$orderby2}}" >生成时间</a></th>
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=report_search_diy&orderby1=status&orderby2={{$orderby2}}" >状态</a></th>
						<th class="list_bg" width="10%">操作</th>
					
					</tr>
					{{section name=t loop=$reports}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="10%">{{$reports[t].username}}</td>
						<td width="10%">{{$reports[t].realname}}</td>
						<td width="10%">{{$reports[t].groupname}}</td>
						<td width="10%">{{$reports[t].start}}</td>
						<td width="10%">{{$reports[t].end}}</td>
						<td width="10%">{{$reports[t].applytime}}</td>
						<td width="10%">{{$reports[t].createtime}}</td>
						<td width="10%">{{if !$reports[t].createtime}}未执行{{elseif $reports[t].status}}成功{{else}}失败{{/if}}</td>
						<td ><img src="{{$template_root}}/images/ico2.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_reports&action=doreport_search&dateinterval=diy&diy_id={{$reports[t]['sid']}}&type={{$reports[t].type}}">查看</a></td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="3"><input type="button"  value="添加" onClick="javascript:document.location='admin.php?controller=admin_reports&action=report_search_diy_edit';" class="an_02"></td>
						<td colspan="9" align="right">&nbsp;&nbsp;&nbsp;&nbsp;{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <!--当前数据表: {{$now_table_name}}-->   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2" ><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a>  <a href="{{$curr_url}}&derive=4" ><img src="{{$template_root}}/images/pdf.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1"></a>{{/if}}
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


