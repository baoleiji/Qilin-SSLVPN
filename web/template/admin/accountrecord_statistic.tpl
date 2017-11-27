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
		document.search.action = "{{$curr_url}}";
		document.search.action += "&username="+document.search.username.value;
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
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="#">从账号</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search_diy">自定义报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_reports&action={{if $smarty.get.dateinterval eq 'diy'}}report_search_diy{{else}}report_search{{/if}}&back=1"><IMG src="./template/admin/images/back1.png" width="80" height="25" border="0"></A></span>
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
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&orderby1=date&orderby2={{$orderby2}}' >时间</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&orderby1=ip&orderby2={{$orderby2}}' >服务器IP</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&orderby1=user&orderby2={{$orderby2}}' >从帐号</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&orderby1=uid&orderby2={{$orderby2}}' >UID</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&orderby1=gid&orderby2={{$orderby2}}' >GID</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_member&orderby1=home&orderby2={{$orderby2}}' >主目录</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_member&orderby1=action&orderby2={{$orderby2}}' >动作</a></th>
					</tr>
					{{section name=t loop=$approves}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td>{{$approves[t].date}}</td>
						<td>{{$approves[t].ip}}</td>
						<td>{{$approves[t].user}}</td>
						<td>{{$approves[t].uid}}</td>
						<td>{{$approves[t].gid}}</td>
						<td>{{$approves[t].home}}</td>
						<td>{{$approves[t].action}}</td>
					</tr>
					{{/section}}
					
					<tr>
						<td colspan="1" align="left">
							
						</td></form><form name="pageto" action="#" method="post">
						<td colspan="10" align="right">
							{{$language.all}}{{$total}}个{{$language.User}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}个/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='admin.php?controller=admin_member&page='+this.value;return false;}else this.value=this.value;">{{$language.page}}{{if !$str}}&nbsp;&nbsp;<a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExcelExporttoExcel}}Excel</a> <a href="{{$curr_url}}&derive=2" target="hide">导出到HTML</a>  <a href="{{$curr_url}}&derive=3" >导出到DOC</a> <a href="{{$curr_url}}&derive=4" >导出到PDF</a>{{/if}}
							
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


