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
	document.f1.action = "admin.php?controller=admin_monitor&action=mysql_monitor";
	document.f1.action += "&ip="+document.f1.ip.value;
	document.location=document.f1.action;
	return true;
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
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=network_reports_policy">报表策略</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=network_reports">报表输出</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
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
		  </table></td></tr>
      <tr  >
        <td class="" width="100%">

		  <TABLE class=BBtable cellSpacing=0 cellPadding=0 width="100%"             align=center>
              <TBODY>
			
			  
              <TR>
                <TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_reports&action=network_reports_policy&orderby1=policyname&orderby2={{$orderby2}}">策略名称</a></TD>
                <TD width="9%"  class="list_bg">操作</TD>
              </TR>
			{{section name=h loop=$policy}}
		 <TR {{if $smarty.section.h.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD class="">{{$policy[h].policyname}}</TD>
		<TD class="" style="text-align:left"><img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_reports&action=network_reports_policy_edit&id={{$policy[h].id}}'>修改</a>&nbsp;&nbsp;<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_reports&action=network_reports_policy_delete&id={{$policy[h].id}}';}">删除</a></TD>		
	  </TR>
	{{sectionelse}}
	   <TR>
                  <TD style="MARGIN-TOP: 10px" colspan="7">没有数据</TD>
                </TR>
	{{/section}}
	<tr>
	<td  colspan="1" align="left">
				
				<input size="30" type="button"  value="添加新组" onClick="location.href='admin.php?controller=admin_reports&action=network_reports_policy_edit'" class="an_02">
		   </td>
	  <td  colspan="1" align="right">
		   			&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_monitor&action=system_monitor&page='+this.value;">页&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}<a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExportresulttoExcel}}</a>{{/if}}
		   </td>
		   </tr>
		</TBODY></TABLE>
  
    
		  </td>
      </tr>
    </table></td>
  </tr>
</table>



</BODY></HTML>

