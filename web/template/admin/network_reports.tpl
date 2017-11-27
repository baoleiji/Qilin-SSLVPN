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
	document.f1.action = "admin.php?controller=admin_monitor&action=system_monitor";
	document.f1.action += "&ip="+document.f1.ip.value;
	document.f1.action += "&groupid="+document.f1.groupid.value;
	document.location=document.f1.action;
	return true;
}

function changetimetype(id){
	document.getElementById(id).checked = true;
}
</script>
<script type="text/javascript">
function reloadimg(duration){
	var img = document.getElementById("zoomGraphImage");
	img.src=img.src+"&duration="+duration+"&"+parseInt(10000*Math.random());
}
</script>
</HEAD>
<BODY style="float:center">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
       <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=network_reports_policy">报表策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=network_reports">报表输出</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>

</ul>
</div></td></tr>
<tr>
	<td align="left" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

		<TBODY>
		 <TR>
			<TD >
			<form name ='f1' action='admin.php?controller=admin_reports&action=network_reports' method='get' >
<input type="hidden" name="controller" value="admin_reports" />
<input type="hidden" name="action" value="network_reports" />
策略:<select name='group' >
{{section name=g loop=$policy}}
<option value='{{$policy[g].id}}' >{{$policy[g].policyname}}</option>
{{/section}}
</select>&nbsp;&nbsp;&nbsp;&nbsp;
内容:<select name='content' >
<option value='cms' >系统</option>
<option value='disk'>贮存</option>
</select>
<img src="{{$template_root}}/images/lv_dot.gif" border="0">按天:<input type="radio" id="durationday" name="duration" {{if $duration eq 'day'}} checked {{/if}} size="25" value="day"/><input type="text" name="date" id="date" size="25" value="{{$ymd}}"/><input type="button" onclick="changetimetype('durationday')" id="f_date" name="f_date" value="选择时间"> <img src="{{$template_root}}/images/lv_dot.gif" border="0">按周:<input type="radio" id="durationweek" name="duration" {{if $duration eq 'week'}} checked {{/if}} size="25" value="week"/>
<select name='year' onchange="changetimetype('durationweek')">
{{php}} 
for($i=date('Y'); $i>=date('Y')-5; $i--){
	echo '<option value='.$i.' '.($year==$i ? 'selected' : '').'>'.$i.'</option>';
}
{{/php}}
</select>
<select name='month' onchange="changetimetype('durationweek')">
{{php}}
for($i=1; $i<=12; $i++){
	echo '<option value='.$i.' '.($month==$i ? 'selected' : '').'>'.$i.'</option>';
}
{{/php}}
</select>
<select name='week' onchange="changetimetype('durationweek')">
{{php}}
for($i=1; $i<=5; $i++){
	echo '<option value='.$i.' '.($week==$i ? 'selected' : '').'>第'.$i.'周</option>';
}
{{/php}}
</select>

<img src="{{$template_root}}/images/lv_dot.gif" border="0">按月:<input type="radio" id="durationmonth" name="duration" {{if $duration eq 'month'}} checked {{/if}} size="25" value="month"/>
<select name='myear' onchange="changetimetype('durationmonth')">
{{php}}
for($i=date('Y'); $i>=date('Y')-5; $i--){
	echo '<option value='.$i.' '.($year==$i ? 'selected' : '').'>'.$i.'</option>';
}
{{/php}}
</select>
<select name='mmonth' onchange="changetimetype('durationmonth')">
{{php}} 
for($i=1; $i<=12; $i++){
	echo '<option value='.$i.' '.($month==$i ? 'selected' : '').'>'.$i.'</option>';
}
{{/php}}
</select>
<input type="submit" value="提交" />
<script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() }
});
cal.manageFields("f_date", "date", "%Y-%m-%d");
</script>
			</form>
			</TD>
		  </TR>
		  </table></td></tr>
      <tr  >
        <td class="">

		  <TABLE class=BBtable cellSpacing=0 cellPadding=0 width="100%"             align=center>
              <TBODY>
			
			  
              <TR>
                <TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=system_monitor&orderby1=device_ip&orderby2={{$orderby2}}">IP</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=system_monitor&orderby1=device_ip&orderby2={{$orderby2}}">主机名</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=system_monitor&orderby1=device_ip&orderby2={{$orderby2}}">端口号</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=system_monitor&orderby1=device_ip&orderby2={{$orderby2}}">流入</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=system_monitor&orderby1=device_ip&orderby2={{$orderby2}}">流出</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=system_monitor&orderby1=device_ip&orderby2={{$orderby2}}">入包速率</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=system_monitor&orderby1=device_ip&orderby2={{$orderby2}}">出包速率</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=system_monitor&orderby1=device_ip&orderby2={{$orderby2}}">入错包</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=system_monitor&orderby1=device_ip&orderby2={{$orderby2}}">出错包</a></TD>
              </TR>
			{{section name=h loop=$reports}}
		 <TR {{if $smarty.section.h.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD class="">{{$reports[h].device_ip}}</TD>
		<TD class="">{{$reports[h].hostname}}</TD>
		<TD class="" style="text-align:left">{{$reports[h].port_describe}}</TD>
		<TD class="" style="text-align:left">{{$reports[h].avg_ti}}&nbsp;&nbsp;{{$reports[h].max_ti}}&nbsp;&nbsp;{{$reports[h].min_ti}}</TD>
		<TD class="" style="text-align:left">{{$reports[h].avg_to}}&nbsp;&nbsp;{{$reports[h].max_to}}&nbsp;&nbsp;{{$reports[h].min_to}}</TD>
		<TD class="" style="text-align:left">{{$reports[h].avg_pi}}&nbsp;&nbsp;{{$reports[h].max_pi}}&nbsp;&nbsp;{{$reports[h].min_pi}}</TD>
		<TD class="" style="text-align:left">{{$reports[h].avg_po}}&nbsp;&nbsp;{{$reports[h].max_po}}&nbsp;&nbsp;{{$reports[h].min_po}}</TD>
		<TD class="" style="text-align:left">{{$reports[h].avg_epi}}&nbsp;&nbsp;{{$reports[h].max_epi}}&nbsp;&nbsp;{{$reports[h].min_epi}}</TD>
		<TD class="" style="text-align:left">{{$reports[h].avg_epo}}&nbsp;&nbsp;{{$reports[h].max_epo}}&nbsp;&nbsp;{{$reports[h].min_epo}}</TD>
	  </TR>
	{{sectionelse}}
	   <TR>
                  <TD style="MARGIN-TOP: 10px" colspan="9">没有数据</TD>
                </TR>
	{{/section}}
	<tr>
	  <td  colspan="8" align="right">
		   			&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_monitor&action=system_monitor&page='+this.value;">页&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}<a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExportresulttoExcel}}</a>{{/if}}
		   </td>
		   </tr>
		</TBODY></TABLE>
  
    
		  </td>
      </tr>
	  <tr><td cellpadding="3" height="15" align="right"></td></tr>
    </table></td>
  </tr>
  <tr><td height="10"></td></tr>
</table>



</BODY></HTML>

