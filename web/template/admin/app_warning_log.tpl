<?php
//define("SEPARATE_PAGE",true);
require_once('dataprocess.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>OSSIM框架</TITLE>
<META content="text/html; charset=UTF-8" http-equiv=Content-Type>
<META content=no-cache http-equiv=Pragma>
<link href="template/admin/all_purpose_style.css" type="text/css" rel="stylesheet">
<STYLE>HTML {
	MARGIN: 0px; HEIGHT: 100%; FONT-SIZE: 12px
}
BODY {
	MARGIN: 0px; HEIGHT: 100%; FONT-SIZE: 12px
}
.mesWindow {
	BORDER-BOTTOM: #666 1px solid; BORDER-LEFT: #666 1px solid; BACKGROUND: #fff; BORDER-TOP: #666 1px solid; BORDER-RIGHT: #666 1px solid
}
.mesWindowTop {
	BORDER-BOTTOM: #eee 1px solid; TEXT-ALIGN: left; PADDING-BOTTOM: 3px; PADDING-LEFT: 3px; PADDING-RIGHT: 3px; MARGIN-LEFT: 4px; FONT-SIZE: 12px; FONT-WEIGHT: bold; PADDING-TOP: 3px
}
.mesWindowContent {
	MARGIN: 4px; FONT-SIZE: 12px
}
.mesWindow .close {
	BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; WIDTH: 28px; BACKGROUND: #fff; HEIGHT: 15px; BORDER-TOP: medium none; CURSOR: pointer; BORDER-RIGHT: medium none; TEXT-DECORATION: underline
}
</STYLE>
<script>
function keyup(keycode){
	if(keycode==13){
		searchit();
	}
}
function searchit(){
	document.f1.action = "admin.php?controller=admin_thold&action=app_warning_log";
	document.f1.action += "&ip="+document.f1.ip.value;
	document.location=document.f1.action;
	return true;
}
</script>
</HEAD>
<BODY style="float:center">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
{{if $smarty.get.from ne 'hostview'}}
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
             <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=snmp_status_warning_log">系统告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=snmp_interface_log">流量告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=app_warning_log">应用告警</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>

</ul>
</div></td></tr>

<tr>
	<td align="left" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_pro&action=dev_index' method=post onkeyup="keyup(event.keyCode);"  onsubmit="return false;">
					IP<input type="text" class="wbk" name="ip">
					&nbsp;&nbsp;<input  type="submit" value=" 搜 索 " onclick="return searchit();" class="bnnew2">
					</form>
					</TD>
                  </TR>
				  </table></td></tr>{{/if}}
      <tr  >
        <td class="">

		  <TABLE class=BBtable{{if $smarty.get.from eq 'hostview'}}1{{/if}} cellSpacing=0 cellPadding=0 width="100%"             align=center>
              <TBODY>
              <TR>
                <TD width="10%" class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=app_warning_log&orderby1=device_ip&orderby2={{$orderby2}}&from={{$smarty.get.from}}&ip={{$smarty.get.ip}}">设备IP</a></TD>
				<TD width="10%" class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=app_warning_log&orderby1=datetime&orderby2={{$orderby2}}&from={{$smarty.get.from}}&ip={{$smarty.get.ip}}">时间</a></TD>
                <TD width="10%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=app_warning_log&orderby1=app_name&orderby2={{$orderby2}}&from={{$smarty.get.from}}&ip={{$smarty.get.ip}}">应用名称</a></TD>
                <TD width="15%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=app_warning_log&orderby1=app_type&orderby2={{$orderby2}}&from={{$smarty.get.from}}&ip={{$smarty.get.ip}}">类型</a></TD>
                <TD width="10%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=app_warning_log&orderby1=cur_val&orderby2={{$orderby2}}&from={{$smarty.get.from}}&ip={{$smarty.get.ip}}">当前值</a></TD>
                <TD width=""  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=app_warning_log&orderby1=context&orderby2={{$orderby2}}&from={{$smarty.get.from}}&ip={{$smarty.get.ip}}">告警内容</a></TD>
              </TR>
			<form action="" method="post">
			{{section name=g loop=$tholdlist}}
			<TR bgcolor="f7f7f7">
			<TD class="">{{$tholdlist[g].device_ip}}</TD>
			<TD class="" style="text-align:left">{{$tholdlist[g].datetime}}</TD>
			<TD class="" style="text-align:left">{{$tholdlist[g].app_name}}</TD>
			<TD class="" style="text-align:left">{{if $tholdlist[g].app_name eq 'apache'}}{{if $tholdlist[g].app_type eq 'cpu load'}}系统占用{{elseif $tholdlist[g].app_type eq 'request rate'}}请求速率{{elseif $tholdlist[g].app_type eq 'traffic rate'}}每秒流量 KB/s{{elseif $tholdlist[g].app_type eq 'process num'}}当前进行数{{elseif $tholdlist[g].app_type eq 'busy process'}}正在处理请求{{else}}未定义{{/if}}{{elseif $tholdlist[g].app_name eq 'mysql'}}{{if $tholdlist[g].app_type eq 'questions rate'}}查询速率{{elseif $tholdlist[g].app_type eq 'open tables'}}打开表数{{elseif $tholdlist[g].app_type eq 'open files'}}打开文件数{{elseif $tholdlist[g].app_type eq 'threads'}}连接数{{else}}未定义{{/if}}{{elseif $tholdlist[g].app_name eq 'tomcat'}}{{if $tholdlist[g].app_type eq 'traffic rate'}}每秒流量 KB/s{{elseif $tholdlist[g].app_type eq 'cpu load'}}CPU平均占用率 %{{elseif $tholdlist[g].app_type eq 'request rate'}}每秒请求数量{{elseif $tholdlist[g].app_type eq 'memory usage'}}当前jvm内存使用率{{elseif $tholdlist[g].app_type eq 'busy thread'}}当前工作线程数{{else}}未定义{{/if}}{{elseif $tholdlist[g].app_name eq 'nginx'}}{{if $tholdlist[g].app_type eq 'request rate'}}nginx 请求率（点击率）{{elseif $tholdlist[g].app_type eq 'connect num'}}nginx 连接数（并发数）{{else}}未定义{{/if}}{{/if}}</TD>
			<TD class="" style="text-align:left">{{$tholdlist[g].cur_val}}</TD>
			<TD class="" style="text-align:left">{{$tholdlist[g].context}}</TD>	
			</TR>
			{{/section}}
			<tr><td colspan="7" align="right">&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_thold&action=status_thold&page='+this.value;">页&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}<a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExportresulttoExcel}}</a>{{/if}}</td></tr>
			</form>
			</TBODY>
		</TABLE>
  
    
		  </td>
      </tr>
	  <tr><td cellpadding="3" height="15" align="right"></td></tr>
    </table></td>
  </tr>
  <tr><td height="10"></td></tr>
</table>



</BODY></HTML>

