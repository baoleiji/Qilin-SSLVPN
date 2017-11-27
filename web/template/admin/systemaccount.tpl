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
	document.search.action = "admin.php?controller=admin_reports&action=systemaccount";
	document.search.action += "&device_type="+document.search.device_type.value;
	document.search.action += "&login_method="+document.search.login_method.value;
	document.search.action += "&ip="+document.search.ip.value;
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
 

	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=systempriority_search">系统权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=apppriority_search">应用权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=systemaccount">系统账号</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=appaccount">应用账号</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1 or  $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=admin_log">变更报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>


<tr>
    <td class="main_content">
			<form name ='search' action='admin.php?controller=admin_reports&action=systemaccount' method=post>
			
系统：<select  class="wbk"  name="device_type" onchange="">
			<option value="0" >全部</option>
		{{section name=d loop=$alldevtype}}
			{{if $alldevtype[d].device_type ne ''}}
			<OPTION id ="{{$alldevtype[d].device_type}}" VALUE="{{$alldevtype[d].id}}" {{if $alldevtype[d].id == $device_type}}selected{{/if}}>{{$alldevtype[d].device_type}}</option>
			{{/if}}
		{{/section}}
		</select> &nbsp;&nbsp;
协议：<select  class="wbk"  name="login_method" onchange="">
			<option value="0" >全部</option>
		{{section name=g loop=$alltem}}
			{{if $alltem[g].login_method ne ''}}
			<OPTION id ="{{$alltem[g].login_method}}" VALUE="{{$alltem[g].id}}" {{if $alltem[g].id == $login_method}}selected{{/if}}>{{if $alltem[g].login_method eq 'apppub'}}应用发布{{else}}{{$alltem[g].login_method}}{{/if}}</option>
			{{/if}}
		{{/section}}
		</select> &nbsp;&nbsp;
IP：
<input  type="text" class="wbk" name="ip" size="13"  value="{{$ip}}" />
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: false
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d");
</script>
			</form>
			</td></tr>
  
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
 
					<tr>
						<th class="list_bg" width="10%">序号</th>
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=systemaccount&orderby1=device_ip&orderby2={{$orderby2}}" >服务器IP</a></th>
						
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=systemaccount&orderby1=hostname&orderby2={{$orderby2}}" >主机名</a></th>						
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=systemaccount&orderby1=device_type&orderby2={{$orderby2}}" >系统</a></th>
						
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=systemaccount&orderby1=login_method&orderby2={{$orderby2}}" >协议</a></th>
						<th class="list_bg" width="10%"><a href="admin.php?controller=admin_reports&action=systemaccount&orderby1=username&orderby2={{$orderby2}}" >系统用户</a></th>					
					</tr>
					{{section name=t loop=$reports}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="10%">{{$smarty.section.t.index+1}}</td>
						<td width="10%">{{$reports[t].device_ip}}</td>
						<td width="10%">{{$reports[t].hostname}}</td>
						<td width="10%">{{$reports[t].device_type_name}}</td>
						<td width="10%">{{$reports[t].login_method_name}}</td>
						<td width="10%">{{if $reports[t].username}}{{$reports[t].username}}{{else}}空用户{{/if}}</td>
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


