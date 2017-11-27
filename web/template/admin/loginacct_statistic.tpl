<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
</head>
<script type="text/javascript">
function searchit(){
	document.search.action = "{{$curr_url}}";
	document.search.action += "&protocol="+document.search.protocol.options[document.search.protocol.options.selectedIndex].value;
	document.search.action += "&from="+document.search.from.value;
	document.search.action += "&serverip="+document.search.serverip.value;
	document.search.action += "&audituser="+document.search.audituser.value;
	document.search.action += "&systemuser="+document.search.systemuser.value;
	document.search.action += "&f_rangeStart="+document.search.f_rangeStart.value;
	document.search.action += "&usergroup="+document.search.usergroup.value;
	//alert(document.search.action);
	//return false;
	return true;
}
</script>
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
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="#">授权明细</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search_diy">自定义报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_reports&action={{if $smarty.get.dateinterval eq 'diy'}}report_search_diy{{else}}report_search{{/if}}&back=1"><IMG src="./template/admin/images/back1.png" width="80" height="25" border="0"></A></span>
</div></td></tr>


 
   <tr>
    <td class="main_content">
<form action="admin.php?controller=admin_reports&action=loginacct" method="post" name="search" >
登录协议：<select  class="wbk"  name="protocol" >
<option value="" ></option>
{{section name=p loop=$alltem}}
<option value="{{$alltem[p].login_method}}">{{$alltem[p].login_method}}</option>
{{/section}}
</select>
来源地址：<input type="text" class="wbk" size="13" name="from" />
主机地址：<input type="text" class="wbk" size="13" name="serverip" />
运维用户：<input type="text" class="wbk" size="8" name="audituser" />
运维组：<select name='usergroup' id="usergroup" style="width:150px">
			<option value="">所有组</option>
			{{section name=g loop=$usergroup}}
			<option value="{{$usergroup[g].groupname}}">{{$usergroup[g].groupname}}</option>
			{{/section}}
		</select>
系统用户：<input type="text" class="wbk" size="8" name="systemuser" />
开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="10" id="f_rangeStart" value="" class="wbk"/>
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">

&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
<!-- 结束日期：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd" value="" class="wbk"/>
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk">

     &nbsp;&nbsp;状态：<select  class="wbk"  name="authenticationstatus" >
     <option value="" ></option>
     <option value="1">成功</option>
     <option value="0">失败</option>
     </select>
	  -->
</form> 
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
  
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"   width="8%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=sourceip&orderby2={{$orderby2}}" >{{$language.SourceAddress}}</a></th>
						<th class="list_bg"   width="8%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=auditip&orderby2={{$orderby2}}" >审计系统</a></th>
						<th class="list_bg"   width="8%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=serverip&orderby2={{$orderby2}}" >{{$language.Ipaddress}}</a></th>
						<th class="list_bg"   width="8%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=portocol&orderby2={{$orderby2}}" >登录协议</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=time&orderby2={{$orderby2}}" >时间</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=audituser&orderby2={{$orderby2}}" >运维账号</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=audituser&orderby2={{$orderby2}}" >别名</a></th>
						<th class="list_bg"   width="8%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=audituser&orderby2={{$orderby2}}" >运维组</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=systemuser&orderby2={{$orderby2}}" >系统用户</a></th>						
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=authenticationstatus&orderby2={{$orderby2}}" >状态</a></th>
						<th class="list_bg"   width=""><a href="admin.php?controller=admin_reports&action=loginacct&orderby1=failreason&orderby2={{$orderby2}}" >出错原因</a></th>
					</tr>
					{{section name=t loop=$alllog}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	
						<td><a href="admin.php?controller=admin_reports&action=loginacct&from={{$alllog[t].sourceip}}">{{$alllog[t].sourceip}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=loginacct&auditip={{$alllog[t].auditip}}">{{$alllog[t].auditip}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=loginacct&serverip={{$alllog[t].serverip}}">{{$alllog[t].serverip}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=loginacct&protocol={{$alllog[t].portocol}}">{{$alllog[t].portocol}}</a></td>
						<td>{{$alllog[t].time|date_format:'%Y-%m-%d %H:%M'}}</td>
						<td><a href="admin.php?controller=admin_reports&action=loginacct&audituser={{$alllog[t].audituser}}">{{$alllog[t].audituser}}</a></td>	
						<td><a href="admin.php?controller=admin_reports&action=loginacct&audituser={{$alllog[t].audituser}}">{{$alllog[t].realname}}</a></td>	
						<td><a href="admin.php?controller=admin_reports&action=loginacct&systemuser={{$alllog[t].systemuser}}">{{$alllog[t].groupname}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=loginacct&systemuser={{$alllog[t].systemuser}}">{{$alllog[t].systemuser}}</a></td>
						<td>{{if $alllog[t].authenticationstatus}}成功{{else}}失败{{/if}}</td>
						<td>{{$alllog[t].failreason}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							{{$language.all}}{{$log_num}}{{$language.item}}{{$language.Log}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <!--当前数据表: {{$now_table_name}}-->{{if !$str}}<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a> <a href="{{$curr_url}}&derive=2" target="hide"><img src="{{$template_root}}/images/html.png" border=0></a> <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a><a href="{{$curr_url}}&derive=4" ><img src="{{$template_root}}/images/pdf.png" border=0></a>{{/if}}   
						</td>
					</tr>
					{{if 0&&$str}}
					<tr><td colspan="12" align="right">{{$language.ExcelExporttoExcel}}Excel:{{$str}} </td></tr>
					<tr><td colspan="12" align="right">导出到HTML:{{$strhtml}}</td></tr>
					<tr><td colspan="12" align="right">导出到DOC:{{$strdoc}}</td></tr>
					{{/if}}
				</table>
	</td>
  </tr>
</table>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


