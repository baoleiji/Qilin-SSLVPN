<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有{{$language.select}}任何{{$language.User}}！");
		return false;
	}
	function searchit(){
		document.search.action = "admin.php?controller=admin_reports&action=admin_log";
		document.search.action += "&f_rangeStart="+document.search.f_rangeStart.value;
		document.search.action += "&f_rangeEnd="+document.search.f_rangeEnd.value;
		document.search.action += "&administrator="+document.search.administrator.value;
		document.search.action += "&luser="+document.search.luser.value;
		document.search.action += "&resource_user="+document.search.resource_user.value;
		document.search.action += "&actions="+document.search.actions.value;
		document.search.action += "&resource="+document.search.resource.value;
		document.search.submit();
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
   <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=systemaccount">系统账号</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=appaccount">应用账号</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1 or  $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=admin_log">变更报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
			<tr><td class="main_content" >
			<form name ='search' action='admin.php?controller=admin_log&action=adminlog' method=post>
管理员:<input  type="text" class="wbk" name="administrator" size="13" id="administrator"   />&nbsp;&nbsp;
运维用户:<input  type="text" class="wbk" name="luser" size="13" id="luser"   />&nbsp;&nbsp;
资源用户:<input  type="text" class="wbk" name="resource_user" size="13" id="resource_user"   />&nbsp;&nbsp;
操作:<select name="actions" id="actions"  >
<option value=""></option>
<option value="add">增加</option>
<option value="del">删除</option>
<option value="edit">编辑</option>
</select>
&nbsp;&nbsp;
资源:<input  type="text" class="wbk" name="resource" size="13" id="resource"   />&nbsp;&nbsp;
{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="{{$f_rangeStart|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">


 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="{{$f_rangeEnd|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="wbk">
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
	<tr>
		<td>	
			<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  width="8%">序号</th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=admin_log&orderby1=administrator&orderby2={{$orderby2}}" >{{$language.Administrator}}</a></th>
						<th class="list_bg"  width="15%"><a href="admin.php?controller=admin_reports&action=admin_log&orderby1=action&orderby2={{$orderby2}}" >{{$language.Operate}}</a></th>
						<th class="list_bg"  width="50%"><a href="admin.php?controller=admin_reports&action=admin_log&orderby1=resource&orderby2={{$orderby2}}" >操作对象</a></th>
						<th class="list_bg"  width="5%"><a href="admin.php?controller=admin_reports&action=admin_log&orderby1=result&orderby2={{$orderby2}}" >结果</a></th>
						<th class="list_bg"  ><a href="admin.php?controller=admin_log&action=adminlog&orderby1=optime&orderby2={{$orderby2}}" >{{$language.OperateTime}}</a></th>
					</tr>
					<form name="member_list" action="admin.php?controller=admin_reports&action=admin_log" method="post">
					{{section name=t loop=$allmember}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td>{{$smarty.section.t.index+1}}</td>
						<td>{{$allmember[t].administrator}}</td>
						<td>{{$allmember[t].action}}</td>
						<td>{{if $allmember[t].type eq 1}}系统用户组：{{$allmember[t].resource}},运维用户:{{$allmember[t].luser}}
							{{elseif $allmember[t].type eq 2}}系统用户组：{{$allmember[t].resource}},资源组:{{$allmember[t].lgroup}}
							{{elseif $allmember[t].type eq 3}}应用用户组：{{$allmember[t].resource}},运维用户:{{$allmember[t].luser}}
							{{elseif $allmember[t].type eq 4}}应用用户组：{{$allmember[t].resource}},资源组:{{$allmember[t].lgroup}}
							{{elseif $allmember[t].type eq 5}}设备：{{$allmember[t].resource}}，设备用户：{{$allmember[t].resource_user}},运维用户:{{$allmember[t].luser}}
							{{elseif $allmember[t].type eq 6}}设备：{{$allmember[t].resource}}，设备用户：{{$allmember[t].resource_user}},资源组:{{$allmember[t].lgroup}}
							{{elseif $allmember[t].type eq 7}}应用名称：{{$allmember[t].resource}},运维用户:{{$allmember[t].luser}}
							{{elseif $allmember[t].type eq 8}}应用名称：{{$allmember[t].resource}},资源组:{{$allmember[t].lgroup}}
							{{elseif $allmember[t].type eq 11}}运维用户:{{$allmember[t].luser}}
							{{elseif $allmember[t].type eq 12}}资源组:{{$allmember[t].lgroup}}
							{{elseif $allmember[t].type eq 13}}设备：{{$allmember[t].resource}}，设备用户：{{$allmember[t].resource_user}}
							{{elseif $allmember[t].type eq 14}}设备：{{$allmember[t].resource}}
							{{elseif $allmember[t].type eq 15}}日志类型:{{$allmember[t].resource}}
							
							{{/if}}
						</td>
						<td>{{$allmember[t].result}}</td>
						<td>{{$allmember[t].optime}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="9" align="right">
							{{$language.all}}{{$total}}个{{$language.User}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}个{{$language.User}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&page='+this.value;">{{$language.page}}  导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2" ><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a> <a href="{{$curr_url}}&derive=4" ><img src="{{$template_root}}/images/pdf.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1"></a>{{/if}}
						</td>
					</tr>
					
					</form>
					
				</table>
		</td>
	  </tr>
	</table>
	
</body>
</html>


