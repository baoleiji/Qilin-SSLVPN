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
	document.f1.action = "admin.php?controller=admin_thold&action=interface_thold";
	document.f1.action += "&ip="+document.f1.ip.value;
	document.location=document.f1.action;
	return true;
}
var isIe=(document.all)?true:false;
//设置select的可见状态
function setSelectState(state)
{
	var objl=document.getElementsByTagName('select');
	for(var i=0;i<objl.length;i++)
	{
		objl[i].style.visibility=state;
	}
}
function mousePosition(ev)
{
	if(ev.pageX || ev.pageY)
	{
		return {x:ev.pageX, y:ev.pageY};
	}
	return {
		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,y:ev.clientY + document.body.scrollTop - document.body.clientTop
	};
}
//弹出方法
function showImg(wTitle, ev ,id)
{
	closeWindow();
	var pos = mousePosition(ev);
	var wWidth=500;
	var bHeight=600;
	var bWidth=parseInt(document.documentElement.scrollWidth);
	var bHeight=parseInt(document.documentElement.scrollHeight);
	if(isIe){
		setSelectState('hidden');
	}
	var back=document.createElement("div");
	back.id="back";
	var styleStr="top:0px;left:0px;position:absolute;width:"+bWidth+"px;height:"+bHeight+"px;";
	styleStr+=(isIe)?"filter:alpha(opacity=0);":"opacity:0;";
	back.style.cssText=styleStr;
	document.body.appendChild(back);
	var mesW=document.createElement("div");
	mesW.id="mesWindow";
	mesW.className="mesWindow";
	mesW.innerHTML="<div onclick='closeWindow();'><div class='mesWindowTop'><table width='100%' height='100%' ><tr><td>"+wTitle+"</td></tr></table></div><div class='mesWindowContent' id='mesWindowContent'><img src='graph_image.php?graph_width=400&graph_height=100&local_graph_id="+id+"&<?=mktime()?>' border=0 ></div><div class='mesWindowBottom'></div></div>";
	styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	window.parent.document.getElementById("frame_content").height=pos.y+1000;
	window.parent.parent.document.getElementById("main").height=pos.y+1000;	
	return false;
}


//关闭窗口
function closeWindow()
{
	if(document.getElementById('back')!=null)
	{
		document.getElementById('back').parentNode.removeChild(document.getElementById('back'));
	}
	if(document.getElementById('mesWindow')!=null)
	{
		document.getElementById('mesWindow').parentNode.removeChild(document.getElementById('mesWindow'));
	}
	if(isIe){
		setSelectState('');
	}
	window.parent.reinitIframe();
}
document.onclick=function(){
	var pos = mousePosition(event);
	if(event.srcElement['tagName']!='A'&&event.srcElement['tagName']!='IMG'&&event.srcElement['tagName']!='FONT'){
		closeWindow();
	}
}
</script>
</HEAD>
<BODY style="float:center">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
	{{if $smarty.get.from ne 'hostview'}}
             <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold">系统阈值列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=snmp_interface_policy">接口阈值列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=status_thold">主机配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=interface_thold">网络配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=app_thold">应用配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=dns_thold">DNS配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
<tr>
	<td align="left" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_pro&action=dev_index' method=post onkeyup="keyup(event.keyCode);"  onsubmit="return false;">
					IP<input type="text" class="wbk" name="ip">
					&nbsp;&nbsp;<input  type="submit" value="高级搜索" onclick="return searchit();" class="bnnew2">
					</form>
					</TD>
                  </TR>
				  </table></td></tr>{{/if}}
      <tr  >
        <td class="">

		  <TABLE class=BBtable{{if $smarty.get.from eq 'hostview'}}1{{/if}} cellSpacing=0 cellPadding=0 width="100%"             align=center>
              <TBODY>
              <TR>
				<TD width="1%" class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"></td>
				{{if $smarty.get.from ne 'hostview'}}
                <TD width="5%" class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=device_ip&orderby2={{$orderby2}}">主机</a></TD>
				{{/if}}
				<TD width="6%" class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=port_describe&orderby2={{$orderby2}}">端口名称</a></TD>
				{{*
				<TD width="6%" class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=enable&orderby2={{$orderby2}}">是否采集</a></TD>
				 <TD width="8%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=traffic_RRD&orderby2={{$orderby2}}">是否记流量rrd</a></TD>
				<TD width="8%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=packet_RRD&orderby2={{$orderby2}}">是否记包rrd</a></TD>
				<TD width="8%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=err_packet_RRD&orderby2={{$orderby2}}">是否记错包rrd</a></TD>
				*}}
                <TD width="7%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=traffic_in&orderby2={{$orderby2}}">流量入</a></TD>
                <TD width="7%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=traffic_out&orderby2={{$orderby2}}">流量出</a></TD>
                <TD width="7%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=packet_in_thold&orderby2={{$orderby2}}">入包速率</a></TD>
                <TD width="7%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=packet_out_thold&orderby2={{$orderby2}}">出包速率</a></TD>
				 <TD width="7%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=packet_in_thold&orderby2={{$orderby2}}">入错包速率</a></TD>
                <TD width="7%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}"><a href = "admin.php?controller=admin_thold&action=interface_thold&orderby1=packet_out_thold&orderby2={{$orderby2}}">出错包速率</a></TD>
				<TD width="9%"  class="list_bg{{if $smarty.get.from eq 'hostview'}}1{{/if}}">操作</TD>
              </TR>
			<form action="" method="post" name="member_list">
			{{section name=g loop=$tholdlist}}
			<TR bgcolor="f7f7f7">
			<TD class="">{{if $smarty.session.ADMIN_LEVEL }}<input type="checkbox" name="chk_member[]" value="{{$tholdlist[g].id}}">{{/if}}</TD>
			{{if $smarty.get.from ne 'hostview'}}
			<TD class="">{{$tholdlist[g].device_ip}}</TD>
			{{/if}}
			<TD class="" style="text-align:left">{{$tholdlist[g].port_describe}}</TD>
			{{*
			<TD class="" style="text-align:left"><input type=checkbox name="enable{{$tholdlist[g].id}}" value="1" {{if $tholdlist[g].enable}}checked{{/if}} /></TD>
			<TD class="" style="text-align:left"><input type=checkbox name="traffic_RRD{{$tholdlist[g].id}}" value="1" {{if $tholdlist[g].traffic_RRD}}checked{{/if}} /></TD>
			<TD class="" style="text-align:left"><input type=checkbox name="packet_RRD{{$tholdlist[g].id}}" value="1" {{if $tholdlist[g].packet_RRD}}checked{{/if}} /></TD>
			<TD class="" style="text-align:left"><input type=checkbox name="err_packet_RRD{{$tholdlist[g].id}}" value="1" {{if $tholdlist[g].err_packet_RRD}}checked{{/if}} /></TD>
			*}}
			<TD class="" style="text-align:left"><input type=text name="traffic_in_lowvalue[]" size="6" value="{{$tholdlist[g].traffic_in_lowvalue}}" />-<br><input type=text name="traffic_in_highvalue[]" size="6" value="{{$tholdlist[g].traffic_in_highvalue}}" /></TD>
			<TD class="" style="text-align:left"><input type=text name="traffic_out_lowvalue[]" size="6" value="{{$tholdlist[g].traffic_out_lowvalue}}" />-<br><input type=text name="traffic_out_highvalue[]" size="6" value="{{$tholdlist[g].traffic_out_highvalue}}" /></TD>
			<TD class="" style="text-align:left"><input type=text name="packet_in_lowvalue[]" size="6" value="{{$tholdlist[g].packet_in_lowvalue}}" />-<br><input type=text name="packet_in_highvalue[]" size="6" value="{{$tholdlist[g].packet_in_highvalue}}" /></TD>
			<TD class="" style="text-align:left"><input type=text name="packet_out_lowvalue[]" size="6" value="{{$tholdlist[g].packet_out_lowvalue}}" />-<br><input type=text name="packet_out_highvalue[]" size="6" value="{{$tholdlist[g].packet_out_highvalue}}" /></TD>
			<TD class="" style="text-align:left"><input type=text name="err_packet_in_lowvalue[]" size="6" value="{{$tholdlist[g].err_packet_in_lowvalue}}" />-<br><input type=text name="err_packet_in_highvalue[]" size="6" value="{{$tholdlist[g].err_packet_in_highvalue}}" /></TD>
			<TD class="" style="text-align:left"><input type=text name="err_packet_out_lowvalue[]" size="6" value="{{$tholdlist[g].err_packet_out_lowvalue}}" />-<br><input type=text name="err_packet_out_highvalue[]" size="6" value="{{$tholdlist[g].err_packet_out_highvalue}}" /></TD>
			<TD class="" style="text-align:left">{{if $smarty.session.ADMIN_LEVEL }}<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_thold&action=interface_thold_edit&id={{$tholdlist[g].id}}&from={{$smarty.get.from}}'>修改</a>&nbsp; | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_thold&action=interface_thold_delete&id={{$tholdlist[g].id}}&from={{$smarty.get.from}}">{{$language.Delete}}</a>{{/if}}</TD>
			</TR>
			<input type="hidden" name="seq[]" value="{{$tholdlist[g].id}}" />
			{{/section}}
			<tr><td colspan="2">{{if $smarty.session.ADMIN_LEVEL }}<input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.member_list.elements[i];if(e.name=='chk_member[]')e.checked=document.member_list.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除" onClick="if(confirm('确定删除?')){document.member_list.action='admin.php?controller=admin_thold&action=interface_thold_delete'; }" class="an_02">&nbsp;&nbsp;{{/if}}</td><td colspan="12" align="right">{{if $smarty.session.ADMIN_LEVEL }}<input type="submit" name="edit" value="修改" class="an_02">{{/if}}&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_thold&action=interface_thold&page='+this.value;">页&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}<a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExportresulttoExcel}}</a>{{/if}}</td></tr>
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

