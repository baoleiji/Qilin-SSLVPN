<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.LoingReport}}{{$language.List}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script type="text/javascript">
 
function searchit(){
	document.report.action = "admin.php?controller=admin_status&action=day_count";
	document.report.action += "&f_rangeStart="+document.report.f_rangeStart.value;
	document.report.action += "&f_rangeEnd="+document.report.f_rangeEnd.value;
	document.report.submit();
	return false;
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
<ul>{{*
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2}}	
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=day_count">天报</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
{{/if}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=week_count">周报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=month_count">月报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}*}}
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=reportgraph">图形</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_log">同步日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=system_alert">系统告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=maillog">系统邮件</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=aduserlog">账号同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>

 
  <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="report" >
{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="{{$f_rangeStart}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">


 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="{{$f_rangeEnd}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="wbk">
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
     &nbsp;&nbsp;
	 
</form> 
	  </td>
  </tr>
  <script type="text/javascript">
                  new Calendar({
                          inputField: "f_rangeStart",
                          dateFormat: "%Y-%m-%d",
                          trigger: "f_rangeStart_trigger",
                          bottomBar: false,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });
                  new Calendar({
                      inputField: "f_rangeEnd",
                      dateFormat: "%Y-%m-%d",
                      trigger: "f_rangeEnd_trigger",
                      bottomBar: false,
                      onSelect: function() {
                              var date = Calendar.intToDate(this.selection.get());
                             
                              this.hide();
                      }
              });
                </script>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"   width="8%">日期</th>
						<th class="list_bg"   width="7%">SSH并发数</th>
						<th class="list_bg"   width="7%">telnet并发数</th>
						<th class="list_bg"   width="8%">图形会话并发数</th>
						<th class="list_bg"   width="8%">FTP会话并发数</th>
						<th class="list_bg"   width="7%">数据库并发数</th>
						<th class="list_bg"   width="8%">系统CPU利用率</th>
						<th class="list_bg"   width="7%">内存利用率</th>
						<th class="list_bg"   width="7%">空间利用率</th>
						<th class="list_bg"   width="7%">硬盘利用率</th>
						<th class="list_bg"   width="7%">net_eth0_in</th>
						<th class="list_bg"   width="7%">net_eth0_out</th>
						<th class="list_bg"   width="7%">net_eth1_in</th>
						<th class="list_bg"   width="7%">net_eth1_out</th>
					</tr>
					{{section name=t loop=$all}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td>{{$all[t].date}}</td>
						 <td>{{$all[t].ssh_conn}}</td>
						 <td>{{$all[t].telnet_conn}}</td>
						 <td>{{$all[t].graph_conn}}</td>
						 <td>{{$all[t].ftp_conn}}</td>
						 <td>{{$all[t].db_conn}}</td>
						  <td>{{$all[t].cpu}}</td>
						 <td>{{$all[t].memory}}</td>
						 <td>{{$all[t].swap}}</td>
						 <td>{{$all[t].disk}}</td>
						 <td>{{$all[t].net_eth0_in}}</td>
						 <td>{{$all[t].net_eth0_out}}</td>
						 <td>{{$all[t].net_eth1_in}}</td>
						 <td>{{$all[t].net_eth1_out}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="14" align="right">
							{{$language.all}}{{$num}}条记录 {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} 
 
						</td>
					</tr>
				</table>
	</td>
  </tr>
 
</table>
 
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


