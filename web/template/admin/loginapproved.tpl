<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
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

</script>
<script>
	function searchit(){
		document.search.action = "admin.php?controller=admin_reports&action=loginapproved";
		document.search.action += "&webuser="+document.search.webuser.value;
		document.search.action += "&usergroup="+document.search.usergroup.value;
		document.search.action += "&ip="+document.search.ip.value;
		document.search.action += "&start="+document.search.f_rangeStart.value;
		document.search.submit();
		return true;
	}
	
</script>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=loginacct">授权明细</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    {{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 101}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=logintims">登录统计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=loginfailed">登录尝试</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=devloginreport">系统登录报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=apploginreport">应用登录报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_approve">流程审批</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
</ul>
</div></td></tr>
<body>
	
 <TR>
<TD >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
<form name ='search' action='admin.php?controller=admin_member' method=post onsubmit="return searchit();">
  <tr>
    <td >
</td>
    <td >	
					用户名：<input type="text" name="webuser" size="13" class="wbk"/>
运维组：<select name='usergroup' id="usergroup" style="width:150px">
			<option value="">所有组</option>
			{{section name=g loop=$usergroup}}
			<option value="{{$usergroup[g].id}}">{{$usergroup[g].groupname}}</option>
			{{/section}}
		</select>
ip：<input type="text" name="ip" size="13" class="wbk"/>
系统用户名：<input type="text" name="username" size="13" class="wbk"/>
开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="10" id="f_rangeStart" value="" class="wbk"/>
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
					&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>

					</td>
  </tr>
   <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d");
//cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");


</script>
</form>	
</table>
</TD>
                  </TR>
	  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	<form name="member_list" action="admin.php?controller=admin_member&action=delete_all" method="post">
					<tr>
						<th class="list_bg"  width="3%" >{{$language.select}}</th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=webuser&orderby2={{$orderby2}}' >用户名</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=realname&orderby2={{$orderby2}}' >别名</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=groupname&orderby2={{$orderby2}}' >运维组</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=ip&orderby2={{$orderby2}}' >服务器IP</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=username&orderby2={{$orderby2}}' >系统用户名</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=login_method&orderby2={{$orderby2}}' >登录协议</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=applytime&orderby2={{$orderby2}}' >申请时间</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=approvetime&orderby2={{$orderby2}}' >审批时间</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=approveuser&orderby2={{$orderby2}}' >申请人</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_reports&action=loginapproved&orderby1=logintime&orderby2={{$orderby2}}' >登录时间</a></th>
					</tr>
					{{section name=t loop=$approves}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td>{{if ($smarty.session.ADMIN_LEVEL eq 4 and (!$approves[t].level or $approves[t].level == 3)) or ($smarty.session.ADMIN_LEVEL eq 1) or ($smarty.session.ADMIN_LEVEL eq 3)}}{{if $approves[t].level != 10 and $approves[t].level != 2 and $approves[t].level != 1}}<input type="checkbox" name="chk_member[]" value="{{$approves[t].uid}}">{{/if}}{{/if}}</td>			
						<td>{{$approves[t].webuser}}</td>
						<td>{{$approves[t].realname}}</td>
						<td>{{$approves[t].groupname}}</td>
						<td>{{$approves[t].ip}}</td>
						<td>{{$approves[t].username}}</td>
						<td>{{$approves[t].login_method}}</td>
						<td>{{$approves[t].applytime}}</td>
						<td>{{$approves[t].approvetime}}</td>
						<td>{{$approves[t].approveuser}}</td>
						<td>{{$approves[t].logintime}}</td>
					</tr>
					{{/section}}
					
					<tr>
						<td colspan="1" align="left">
							
						</td></form><form name="pageto" action="#" method="post">
						<td colspan="10" align="right">
							{{$language.all}}{{$total}}个{{$language.User}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}个/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='admin.php?controller=admin_member&page='+this.value;return false;}else this.value=this.value;">{{$language.page}}{{if !$str}}&nbsp;&nbsp;<a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExcelExporttoExcel}}Excel</a> <a href="{{$curr_url}}&derive=2" target="hide">导出到HTML</a>  <a href="{{$curr_url}}&derive=3" >导出到DOC</a>  <a href="{{$curr_url}}&derive=4" >导出到PDF</a>{{/if}}
							
						</td></form>
					</tr>
					
				
		  
					<tr>
						
					</tr>
				</table>
			
	  </table>
		</td>
	  </tr>
	</table>
	<iframe name="hide" height="0" frameborder="0" scrolling="no" id="hide"></iframe>

</body>
</html>


