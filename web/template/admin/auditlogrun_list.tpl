<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function searchit(){
	document.search.action = "admin.php?controller=admin_auditlog&action=runlist";
	document.search.action += "&addr="+document.search.ip.value;
	document.search.action += "&name="+document.search.name.value;
	document.search.action += "&servername="+document.search.servername.value;
	document.search.action += "&start1="+document.search.f_rangeStart.value;
	document.search.action += "&start2="+document.search.f_rangeEnd.value;
	
	//alert(document.search.action);
	//return false;
	return true;
}
</script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_auditlog">备份日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_auditlog&action=runlist">巡检日志</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>

  <tr>
    <td class="main_content">
<form action="admin.php?controller=admin_auditlog&action=runlist" method="post" name="search" >
名称：<input type="text" class="wbk" name="name" size="13" />
服务器地址：<input type="text" class="wbk" name="ip"  size="13" />
服务器名称：<input type="text" class="wbk" name="servername" size="13" />
开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="" class="wbk"/>
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">

 结束日期：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd" value="" class="wbk"/>
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk">
	  &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
</form> 					
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");


</script>
					</td>
  </tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
<th class="list_bg" width="5%"><a href="admin.php?controller=admin_auditlog&orderby1=name&orderby2={{$orderby2}}">服务器IP</a></th>
					
<th class="list_bg" width="5%"><a href="admin.php?controller=admin_auditlog&action=runlist&orderby1=servername&orderby2={{$orderby2}}">服务器名称</a></th>
<th class="list_bg" width="5%"><a href="admin.php?controller=admin_auditlog&action=runlist&orderby1=serverip&orderby2={{$orderby2}}">模板名称</a></th>
<th class="list_bg" width="10%"><a href="admin.php?controller=admin_auditlog&action=runlist&orderby1=checktime&orderby2={{$orderby2}}">时间</a></th>
<th class="list_bg" width="4%"><a href="admin.php?controller=admin_auditlog&action=runlist&orderby1=command&orderby2={{$orderby2}}">命令</a></th>			
						<th class="list_bg" width="13%">操作</th>
						
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>

					

						<td><a href="admin.php?controller=admin_auditlog&action=runlist&addr={{$allsession[t].serverip}}">{{$allsession[t].serverip}}</a></td>
						
						<td><a href="admin.php?controller=admin_auditlog&action=runlist&name={{$allsession[t].servername}}">{{$allsession[t].servername}}</a></td>
							<td>{{$allsession[t].name}}</td>
						<td><a href="admin.php?controller=admin_auditlog&action=runlist&time={{$allsession[t].backuptime}}">{{$allsession[t].checktime}}</a></td>
						<td><a href="admin.php?controller=admin_auditlog&action=runlist&status={{$allsession[t].statuts}}">{{if $allsession[t].command}}是{{else}}否{{/if}}</a></td>						
						
						<td style="TEXT-ALIGN: left;"><img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="#" onclick=window.open("admin.php?controller=admin_auditlog&action=download2&sid={{$allsession[t].id}}&start_page=1")>查看</a>
						</td>
					</tr>						

					{{/section}}
					<tr>
						<td colspan="12" align="right">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <!--当前数据表: {{$now_table_name}}--> 
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
</table>

<iframe name="hide" height="0" frameborder="0" scrolling="no" id="hide"></iframe>
</body>
</html>


