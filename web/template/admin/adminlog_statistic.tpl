<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
		document.search.action = "{{$curr_url}}";
		document.search.action += "&luser="+document.search.luser.value;
		document.search.action += "&operation="+document.search.operation.value;
		document.search.action += "&operation="+document.search.operation.value;
		document.search.action += "&administrator="+document.search.administrator.value;
		document.search.action += "&resource_user="+document.search.resource_user.value;
		document.search.action += "&resource="+document.search.resource.value;
		document.search.action += "&start="+document.search.start.value;
		document.search.action += "&end="+document.search.end.value;
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
 
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="#">系统操作</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search_diy">自定义报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_reports&action={{if $smarty.get.dateinterval eq 'diy'}}report_search_diy{{else}}report_search{{/if}}&back=1"><IMG src="./template/admin/images/back1.png" width="80" height="25" border="0"></A></span>
</div></td></tr>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  
	  
	  <tr>
		<td class="" >
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" >
			<tr><td>
			<form name ='search' action='admin.php?controller=admin_log&action=adminlog' method=post>
			{{$language.WebUser}}{{$language.User}}：<input type="text" class="wbk" name="luser">
			{{$language.Operate}}：<input type="text" class="wbk" name="operation">
			{{$language.Administrator}}：<input type="text" class="wbk" name="administrator">&nbsp;&nbsp;
			资源：<input type="text" class="wbk" name="resource">&nbsp;&nbsp;
			资源用户：<input type="text" class="wbk" name="resource_user">&nbsp;&nbsp;
			{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="{{$f_rangeStart}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">
 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="{{$f_rangeEnd}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="wbk">&nbsp;&nbsp;
 <input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
			</form>
			</td></tr>
	<tr>
		<td>	
			<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  width="8%">{{$language.select}}</th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_log&action=adminlog&orderby1=administrator&orderby2={{$orderby2}}" >{{$language.Administrator}}</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_log&action=adminlog&orderby1=luser&orderby2={{$orderby2}}" >{{$language.WebUser}}{{$language.User}}</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_log&action=adminlog&orderby1=action&orderby2={{$orderby2}}" >{{$language.Operate}}</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_log&action=admin_log&orderby1=resource&orderby2={{$orderby2}}" >资源</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_log&action=admin_log&orderby1=resource_user&orderby2={{$orderby2}}" >资源{{$language.User}}</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_log&action=admin_log&orderby1=result&orderby2={{$orderby2}}" >结果</a></th>
						<th class="list_bg"  ><a href="admin.php?controller=admin_log&action=adminlog&orderby1=optime&orderby2={{$orderby2}}" >{{$language.OperateTime}}</a></th>
					</tr>
					<form name="member_list" action="admin.php?controller=admin_log&action=delete_adminlog" method="post">
					{{section name=t loop=$allmember}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="chk_member[]" value="{{$allmember[t].id}}"></td>
						<td>{{$allmember[t].administrator}}</td>
						<td>{{$allmember[t].luser}}</td>
						<td>{{$allmember[t].action}}</td>
						<td>{{$allmember[t].resource}}</td>
						<td>{{$allmember[t].resource_user}}</td>
						<td>{{$allmember[t].result}}</td>
						<td>{{$allmember[t].optime}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="4" align="left">
						</td>
						<td colspan="4" align="right">
							{{$language.all}}{{$total}}个{{$language.User}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}个{{$language.User}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&page='+this.value;">{{$language.page}}
						</td>
					</tr>
					
					</form>
					
				</table>
			  </td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	
</body>
</html>


