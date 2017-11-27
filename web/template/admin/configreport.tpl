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
	document.search.action = "admin.php?controller=admin_reports&action=configreport";
	document.search.action += "&template="+document.search.template.options[document.search.template.options.selectedIndex].value;
	document.search.action += "&subject="+document.search.subject.value;
	document.search.action += "&f_rangeStart="+document.search.f_rangeStart.value;
	document.search.action += "&f_rangeEnd="+document.search.f_rangeEnd.value;
	document.search.submit();
	//alert(document.search.action);
	//return false;
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
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=configreport">报表配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	 <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cronreports">报表自动生成配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	 <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=downloadcronreport">下载报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
   <tr>
    <td class="main_content">
<form action="admin.php?controller=admin_reports&action=configreport" method="post" name="search" >
标题：<input type="text" class="wbk" name="subject" />
模板：<select  class="wbk"  name="template" id="template">
				{{section name=t loop=$templates}}
				<option value="{{$templates[t].name}}" {{if $configreport.template eq $templates[t].name}}selected{{/if}} >{{$templates[t].title}}</option>
				{{/section}}
				</select>
开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="" class="wbk"/>
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
 结束日期：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd" value="" class="wbk"/>
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk">
	&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
</form> 
	  </td>
  </tr>
<script type="text/javascript">
	var cal = Calendar.setup({
		onSelect: function(cal) { cal.hide() },
		showTime: true
	});
	cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
	cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");
</script>
  
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		 <form name="member_list" action="admin.php?controller=admin_reports&action=configreport_delete" method="post" >
					<tr>
					<th class="list_bg"  bgcolor="d9ecfa" width="3%">选</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="8%"><a href="admin.php?controller=admin_reports&action=configreport&orderby1=subject&orderby2={{$orderby2}}" >标题</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="8%"><a href="admin.php?controller=admin_reports&action=configreport&orderby1=createtime&orderby2={{$orderby2}}" >时间</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="8%"><a href="admin.php?controller=admin_reports&action=configreport&orderby1=cycle&orderby2={{$orderby2}}" >周期</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="15%"><a href="admin.php?controller=admin_reports&action=configreport&orderby1=template&orderby2={{$orderby2}}" >模板</a></th>	
						<th class="list_bg"  bgcolor="d9ecfa" width="20%">操作</th>
					</tr>
					{{section name=t loop=$alllog}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="chk_member[]" value="{{$alllog[t].id}}"></td>
						<td><a href="admin.php?controller=admin_reports&action=configreport&subject={{$alllog[t].subject}}">{{$alllog[t].subject}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=configreport&createtime={{$alllog[t].createtime}}">{{$alllog[t].createtime}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=configreport&cycle={{$alllog[t].cycle}}">{{$alllog[t].cyclename}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=configreport&template={{$alllog[t].template}}">{{$alllog[t].templatename}}</a></td>						
						<td>
						<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_reports&action=configreport_edit&id={{$alllog[t].id}}'>{{$language.Edit}}</a>

						| <img src='{{$template_root}}/images/ico2.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_reports&action=configreport&view=1&id={{$alllog[t].id}}&from=configreport'>查看</a>
						
						| <img src='{{$template_root}}/images/doc_excel_csv.png' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_reports&action=configreport&derive=1&id={{$alllog[t].id}}" target="hide">导出</a>
						</td>
					</tr>
					{{/section}}
					<tr>
					<td colspan="3" align="left"><input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除选中的');if(chk_form()) document.member_list.action='admin.php?controller=admin_pro&action=devpass_del&ip={{$alldev[0].device_ip}}&serverid={{$serverid}}'; else return false;" class="an_02">&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.location='admin.php?controller=admin_reports&action=configreport_edit'"  value=" 添加 "  class="an_02">
					</td>
					<td colspan="12" align="right">
						{{$language.all}}{{$log_num}}{{$language.item}}{{$language.Log}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}}
					</td>
					</tr>
				</form>
				</table>
	</td>
  </tr>
</table>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


