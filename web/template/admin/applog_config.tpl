<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>OSSIM框架</TITLE>
<META content="text/html; charset=UTF-8" http-equiv=Content-Type>
<META content=no-cache http-equiv=Pragma>
<link href="template/admin/all_purpose_style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
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
	document.f1.action = "admin.php?controller=admin_monitor&action=apache_monitor";
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
	//var pos = mousePosition(ev);
	var wWidth=600;
	var wHeight=600;
	var bWidth=parseInt(document.documentElement.clientWidth);
	var bHeight=parseInt(window.screen.availHeight)+20;
	bHeight=700+20;
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
	mesW.innerHTML="<div><img id=\"1d\" src='{{$template_root}}/images/1d.gif' onClick=\"reloadimg();\" style=\"cursor:hand;\" alt=\"最近1天\">&nbsp; <img id=\"7d\" src='{{$template_root}}/images/7d.gif' onClick=\"reloadimg('week');\" style=\"cursor:hand;\" alt=\"最近7天\">&nbsp; <img id=\"30d\" src='{{$template_root}}/images/30d.gif' onClick=\"reloadimg('month');\" style=\"cursor:hand;\" alt=\"最近30天\">&nbsp; <img id=\"365d\" src='{{$template_root}}/images/365d.gif' onClick=\"reloadimg('year');\" style=\"cursor:hand;\" alt=\"最近365天\"><div style=\"float:right\"><img id=\"f_rangeStart_trigger\" name=\"f_rangeStart_trigger\" src='{{$template_root}}/images/period.gif' style=\"cursor:hand;\" alt=\"自定义时间段\" title=\"自定义时间段\"><input type=\"hidden\"  name=\"f_rangeStart\" size=\"13\" id=\"f_rangeStart\" value=\"\" class=\"wbk\"/></div>&nbsp;&nbsp;<div onclick='closeWindow();'><div class='mesWindowContent' id='mesWindowContent'><img id='zoomGraphImage'  src='admin.php?controller=admin_monitor&action=status_image&type=app&id="+id+"&"+parseInt(10000*Math.random())+"' border=0 ></div><div class='mesWindowBottom'></div></div></div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=pos.y+1000;		
	var cal = Calendar.setup({
    onSelect: function(cal) { 
				cal.hide();
				var img = document.getElementById("zoomGraphImage");
				img.src=img.src+"&duration=&date="+cal.selection.sel[0]+"&"+parseInt(10000*Math.random());
			 },
    showTime: true
});
	cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_systemNew">系统日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_systemNew&action=applog_config">应用日志</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
      <tr  >
        <td class="" width="100%">

		  <TABLE class=BBtable cellSpacing=0 cellPadding=0 width="100%"             align=center>
              <TBODY>
			
			  
              <TR>
                <TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_systemNew&action=applog_config&orderby1=device_ip&orderby2={{$orderby2}}">内容说明</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_systemNew&action=applog_config&orderby1=hostname&orderby2={{$orderby2}}">说明</a></TD>
                <TD width="9%"  class="list_bg"><a href = "admin.php?controller=admin_systemNew&action=applog_config&orderby1=mail_alarm&orderby2={{$orderby2}}">邮件告警</a></TD>
                <TD width="9%"  class="list_bg"><a href = "admin.php?controller=admin_systemNew&action=applog_config&orderby1=sms_alarm&orderby2={{$orderby2}}">短信告警</a></TD>
                <TD width="9%"  class="list_bg"><a href = "#">操作</a></TD>
              </TR>
			{{section name=h loop=$hosts}}
		 <TR {{if $smarty.section.h.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD class="">{{$hosts[h].msg}}</TD>
		<TD class="">{{$hosts[h].instruction}}</TD>
		<TD class="" style="text-align:left">{{if $hosts[h].mail_alarm}}打开{{else}}关闭{{/if}}</TD>
		<TD class="" style="text-align:left">{{if $hosts[h].sms_alarm}}打开{{else}}关闭{{/if}}</TD>
		<TD class="" style="text-align:left"><img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_systemNew&action=applog_config_edit&id={{$hosts[h].id}}'>修改</a> | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_systemNew&action=applog_config_delete&id={{$hosts[h].id}}" onclick="return confirm('确定删除？')">删除</a></TD>		
	  </TR>
	{{sectionelse}}
	   <TR>
                  <TD style="MARGIN-TOP: 10px" colspan="9">没有数据</TD>
                </TR>
	{{/section}}
	<tr><td><input colspan="2" type="button"  value="增加" onClick="javascript:document.location='admin.php?controller=admin_systemNew&action=applog_config_edit';" class="an_02"></td>
	  <td  colspan="4" align="right">
		   			&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_monitor&action=apache_monitor&page='+this.value;">页&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}<a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExportresulttoExcel}}</a>{{/if}}
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

