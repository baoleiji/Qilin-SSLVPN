<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
</head>
<script type="text/javascript">
function searchit(){
	var url = "admin.php?controller=admin_reports&action=loginacct";
	url += "&protocol="+document.search.elements.protocol.options[document.search.elements.protocol.options.selectedIndex].value;
	url += "&from="+document.search.elements.from.value;
	url += "&serverip="+document.search.elements.serverip.value;
	url += "&audituser="+document.search.elements.audituser.value;
	url += "&systemuser="+document.search.elements.systemuser.value;
	url += "&f_rangeStart="+document.search.elements.f_rangeStart.value;
	{{if $_config.LDAP}}
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	{{else}}
	for(var i=1; true; i++){
		var obj=document.getElementById('groupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	{{/if}}
	url += "&groupid="+gid;
	{{/if}}
	document.search.action = url;
	//alert(document.search.elements.action);
	//return false;
	return true;
}
</script>
<script>

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var allserver = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/section}}
var i=0;
{{section name=au loop=$alluser}}
alluser[i++]={uid:{{$alluser[au].uid}},username:'{{$alluser[au].username}}',realname:'{{$alluser[au].realname}}',groupid:{{$alluser[au].groupid}},level:{{$alluser[au].level}}};
{{/section}}
var i=0;
{{section name=as loop=$allserver}}
allserver[i++]={hostname:'{{$allserver[as].hostname}}',device_ip:'{{$allserver[as].device_ip}}',groupid:{{$allserver[as].groupid}}};
{{/section}}

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
 {{if $smarty.get.from eq 'configreport'}}
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=configreport">报表配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cronreports">报表自动生成配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=downloadcronreport">下载报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{else}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=loginacct">授权明细</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 101}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=logintims">登录统计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
    {{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=loginfailed">登录尝试</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=devloginreport">系统登录报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=apploginreport">应用登录报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=workflow_approve">审批报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
</ul>{{if $smarty.get.from eq 'configreport'}}<span class="back_img"><A href="admin.php?controller=admin_reports&action=configreport"><IMG src="{{$template_root}}/images/back1.png" width="80" height="30" border="0"></A></span>{{/if}}
</div></td></tr>


 
   <tr>
    <td class="main_content">
<form action="admin.php?controller=admin_reports&action=loginacct" method="post" name="search" >
{{include file="select_sgroup_ajax.tpl" }} &nbsp;登录协议：<select  class="wbk"  name="protocol" >
<option value="" ></option>
{{section name=p loop=$alltem}}
<option value="{{$alltem[p].login_method}}">{{if $alltem[p].login_method eq 'apppub'}}应用发布{{else}}{{$alltem[p].login_method}}{{/if}}</option>
{{/section}}
</select>
来源地址：<input type="text" class="wbk" size="13" name="from" />
主机地址：<input type="text" class="wbk" size="13" name="serverip" />
运维用户：<input type="text" class="wbk" size="8" name="audituser" />

		         
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
<script>
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


