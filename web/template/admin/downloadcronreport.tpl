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
	document.search.action = "admin.php?controller=admin_reports&action=downloadcronreport";
	document.search.action += "&subject="+document.search.subject.options[document.search.subject.options.selectedIndex].value;
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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=configreport">报表配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	 <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cronreports">报表自动生成配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	 <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=downloadcronreport">下载报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
   <tr>
    <td class="main_content">
<form action="admin.php?controller=admin_reports&action=downloadcronreport" method="post" name="search" >
模板：<select  class="wbk"  name="subject" id="subject">
				{{section name=t loop=$templates}}
				<option value="{{$templates[t].title}}" {{if $configreport.template eq $templates[t].title}}selected{{/if}} >{{$templates[t].title}}</option>
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
		 <form name="member_list" action="admin.php?controller=admin_reports&action=crontabreportsdelete" method="post" >
					<tr>
					<th class="list_bg"  bgcolor="d9ecfa" width="3%">选</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="8%"><a href="admin.php?controller=admin_reports&action=downloadcronreport&orderby1=title&orderby2={{$orderby2}}" >标题</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="20%"><a href="admin.php?controller=admin_reports&action=downloadcronreport&orderby1=filepath&orderby2={{$orderby2}}" >路径</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%"><a href="admin.php?controller=admin_reports&action=downloadcronreport&orderby1=start&orderby2={{$orderby2}}" >开始</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%"><a href="admin.php?controller=admin_reports&action=downloadcronreport&orderby1=end&orderby2={{$orderby2}}" >结束</a></th>	
						<th class="list_bg"  bgcolor="d9ecfa" width="5%">操作</th>
					</tr>
					{{section name=t loop=$alllog}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="chk_member[]" value="{{$alllog[t].id}}"></td>
						<td><a href="admin.php?controller=admin_reports&action=downloadcronreport&subject={{$alllog[t].title}}">{{$alllog[t].title}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=downloadcronreport&createtime={{$alllog[t].filepath}}">{{$alllog[t].filepath}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=downloadcronreport&cycle={{$alllog[t].start}}">{{$alllog[t].start}}</a></td>
						<td><a href="admin.php?controller=admin_reports&action=downloadcronreport&template={{$alllog[t].end}}">{{$alllog[t].end}}</a></td>						
						<td>
						<img src='{{$template_root}}/images/ie.png' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_reports&action=downloadcronreport&derive=1&id={{$alllog[t].id}}" target="hide">下载</a>
						</td>
					</tr>
					{{/section}}
					<tr>
					<td colspan="3" align="left"><input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除选中的');if(chk_form()) document.member_list.action='admin.php?controller=admin_reports&action=crontabreportsdelete'; else return false;" class="an_02">
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


