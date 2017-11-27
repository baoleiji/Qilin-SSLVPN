<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<TITLE>详细信息</TITLE> 
<META http-equiv="Content-Type" content="text/html; charset=utf-8"> <LINK href="{{$template_root}}/cssjs/liye.css" 
rel="stylesheet" type="text/css"> 
<META name="GENERATOR" content="MSHTML 11.00.9600.17801"> 
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<STYLE>
.tip{width:50px;border:2px solid #ddd;padding:8px;background:#f1f1f1;color:#666;} 
ul,ol,li {list-style:none}
a{text-decoration:none;word-wrap:break-word}
a:hover{text-decoration:underline}
.menu{ width:66px;height:26px;padding:0px;_padding:0px;_width:70px; margin:0px;_overflow:hidden;border:1px solid #8caade; text-align:center; background-color:#d7e4f6；}
.menu a{color:#000;height:16px;line-height:16px;float:left;position:relative}

.menu li{font-size:14px;float:right;position:relative;padding:5px 5px; list-style:none}
.menu li:hover{background-color:#fff;border-bottom:none;padding:5px 5px}
.menu li:hover a{color:#000000;}
.menu li.no_sub:hover{border:1px solid #999999;padding:5px 5px}
.menu ul{width:200px; height:150px;background-color:#fff;border:1px solid #8caade;position:absolute;left:-145px;top:-999em;z-index:99999;padding:5px;display:none; overflow:auto;_left:-185px;}
.menu li:hover ul{top:26px;display:block}
.menu li:hover ul li{font-size:12px;border:none;width:88%;float:left;padding:4px 0 4px 10px; background-image:url(images/pdf.png); background-repeat:no-repeat; padding-left:25px;}
.menu li:hover ul li a{color:#333;text-decoration:none;padding:0}
.menu li:hover ul li a:hover{text-decoration:underline}
/*IE6*/
.menu li.hover{background-color:#f0f0f0;border-bottom:none;padding:5px 5px}
.menu li.hover a{color:#000000}
.menu li.hover ul{top:26px;display:block}
.menu li.hover ul li{border:none;width:88%;float:left;padding:2px 0 4px 10px; background-image:url(images/pdf.png); background-repeat:no-repeat; padding-left:25px;_width:79%;}
.menu li.hover ul li a{height:16px;line-height:16px;font-size:12px;color:#333;text-decoration:none;padding:0;}
.menu li.hover ul li a:hover{text-decoration:underline}
.menu li.no_sub.hover1{border:1px solid #999999;padding:5px 5px}
</style>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/js.js"></script>

<SCRIPT type="text/javascript">
function allreload(){
	window.location.reload();
}

function allclose(){
	window.close();
}


function getdocument(t){
	$.get('admin.php?controller=admin_index&action=getdocument&ip={{$ip}}&type=interface&doctype='+t, {"1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		document.getElementById('documentlist').innerHTML = data;
	});
}

 var tip={$:function(ele){ 
  if(typeof(ele)=="object") 
    return ele; 
  else if(typeof(ele)=="string"||typeof(ele)=="number") 
    return document.getElementById(ele.toString()); 
    return null; 
  }, 
  mousePos:function(e){ 
    var x,y; 
    var e = e||window.event; 
    return{x:e.clientX+document.body.scrollLeft+document.documentElement.scrollLeft, y:e.clientY+document.body.scrollTop+document.documentElement.scrollTop}; 
  }, 
  start:function(obj){ 
    var self = this; 
    var t = self.$("mjs:tip"); 
	var mouse = self.mousePos(obj.event);   
      t.style.left = mouse.x - 25 + 'px'; 
      t.style.top = mouse.y + 10 + 'px'; 
      //t.innerHTML = obj.getAttribute("tips"); 
	  if(t.style.display=='none')
      t.style.display = ''; 
	  else
      t.style.display = 'none'; 
  } 
 } 

</SCRIPT>
 </HEAD> 
<BODY onload=" getdocument('pdf');">
<div id="mjs:tip" class="tip" style="position:absolute;left:0;top:0;display:none;"><a href="#" onclick="getdocument('pdf');return false;" ><img src="{{$template_root}}/images/pdf.png" border=0></a>{{*&nbsp;&nbsp;<a href="#" onclick="getdocument('html');return false;" ><img src="{{$template_root}}/images/html.png" border=0></a>*}}</div> 
<DIV align="center">
<TABLE width="1000" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD width="22" height="32"><IMG width="22" height="35" src="{{$template_root}}/images/top_left2.gif"></TD>
    <TD width="868" align="left" background="{{$template_root}}/images/top_mid2.gif" valign="top">
      <TABLE width="80%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD height="28" align="left" class="ly" 
            valign="bottom"><STRONG>详细信息</STRONG></TD></TR></TBODY></TABLE></TD>
    <TD width="97" align="left" background="{{$template_root}}/images/top_mid2.gif" valign="top">
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD height="31" align="right" valign="bottom"><IMG width="21" 
            height="35" style="cursor: hand;" onClick="allreload()" alt="刷新" 
            src="{{$template_root}}/images/sx.gif" border="0"></TD>
          <TD width="21" height="31" align="right" valign="bottom"><IMG width="21" 
            height="35" style="cursor: hand;" onClick="allclose()" alt="关闭" src="{{$template_root}}/images/close.gif" 
            border="0"></TD></TR></TBODY></TABLE></TD>
    <TD width="13" align="left" valign="top"><IMG width="13" height="35" src="{{$template_root}}/images/top_right52.gif"></TD></TR></TBODY></TABLE>
<TABLE width="1000" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD width="14" background="{{$template_root}}/images/mid_left2.gif">&nbsp;</TD>
    <TD>
      <TABLE width="99%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD align="middle" valign="bottom">
            <TABLE width="100%" height="32" border="0" cellspacing="0" 
            cellpadding="0">
              <TBODY>
              <TR>
                <TD width="104" align="center" class="diline" id="ciscotab" 
                background="{{$template_root}}/images/bq.gif"><STRONG>
				{{if $smarty.get.os eq 'host'}}
				<a href="admin.php?controller=admin_detail&ip={{$ip}}" title="Cisco交换机" class="ly" style="cursor:hand;">主机信息</a>
				{{else}}
				<a href="admin.php?controller=admin_detail&action=ciscoindex&ip={{$ip}}" title="Cisco交换机" class="ly" style="cursor:hand;">{{$server.hostname}}</a>
				{{/if}}
                  										 </STRONG></TD>
                <TD width="104" align="center" id="interfaceViewTab" background="{{$template_root}}/images/bq.gif"><STRONG><A 
                  title="接口一览" class="ly" style="cursor: hand;" onClick="interfaceView('ciscotab')">接口一览</A>
                  							 </STRONG></TD>
				{{if $smarty.get.os eq 'host'}}<td id="interfaceViewTab" width="104" align="center" background="{{$template_root}}/images/bq.gif"  class="diline">
				<strong>
							<a href="admin.php?controller=admin_detail&action=parameters&ip={{$ip}}&os=host" style="cursor:hand;" class="ly" title="参数配置">参数配置</a>
							</strong></td>{{/if}}
					<td id="interfaceViewTab" width="104" align="center" background="{{$template_root}}/images/bq.gif"  class="diline"><strong>
							<a href="admin.php?controller=admin_detail&action=status_backup&ip={{$ip}}&from=status" style="cursor:hand;" class="ly" title="备份管理">备份管理</a>
							</strong></td>
				<td id="interfaceViewTab" width="104" align="center" background="{{$template_root}}/images/bq.gif"  class="diline"><strong>
							<a href="admin.php?controller=admin_detail&action=status_autorun&ip={{$ip}}&from=status" style="cursor:hand;" class="ly" title="自动脚步" >自动脚步</a>
							</strong></td>
                <TD align="right" class="diline">&nbsp;</TD>
                <TD align="right" class="diline">
                  <TABLE width="98%" border="0" cellspacing="0" 
                    cellpadding="0"><TBODY>
                    <TR>
                      <TD align="right">
					 <ul class="menu">
            <li>
            	<a target="_blank" href="#" class="tablink" onclick="return false;">文档下载</a>
                <ul id='documentlist'>
                </ul>
            </li>
        </ul></td><td width="103" align="right">&nbsp;<input type="button" value="接口初始化" onclick="document.getElementById('hide').src='admin.php?controller=admin_pro&action=server_detect&ip={{$ip}}'" />
                  </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD align="middle" class="full-lan" valign="top"><BR>
            <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
              <TBODY>
              <TR>
                <TD align="left" valign="top">
                  <TABLE width="100%" height="40" border="0" cellspacing="0" 
                  cellpadding="0">
                    <TBODY>
                    <TR align="right" valign="middle">
                      <TD width="50%"></TD>
                      <TD align="right"><IMG id="1d" style="cursor: hand;" 
                        onclick="reloadimg('day');" alt="最近1天" src="{{$template_root}}/images/1d.gif">&nbsp; 
                        <IMG id="7d" style="cursor: hand;" onClick="reloadimg('week');" 
                        alt="最近7天" src="{{$template_root}}/images/7d.gif">&nbsp; <IMG id="30d" style="cursor: hand;" 
                        onclick="reloadimg('month');" alt="最近30天" src="{{$template_root}}/images/30d.gif">&nbsp; 
                        <IMG id="365d" style="cursor: hand;" onClick="reloadimg('year');" 
                        alt="最近365天" src="{{$template_root}}/images/365d.gif">&nbsp;&nbsp; <img id="f_rangeStart_trigger" name="f_rangeStart_trigger" src='{{$template_root}}/images/period.gif' style="cursor:hand;" alt="自定义时间段" title="自定义时间段"><input type="hidden"  name="f_rangeStart" size="13" id="f_rangeStart" value="" class="wbk"/>
                        </TD></TR></TBODY></TABLE>
                  <TABLE width="675" align="center" border="0" cellspacing="0" 
                  cellpadding="0">
                    <TBODY>
                    <TR>
                      <TD height="20" align="center">
                        <TABLE cellspacing="0" cellpadding="0">
                          <TBODY>
                          <TR>
                            <TD height="20" 
                              align="center"><STRONG>Loopback0-softwareLoopback-4294967295</STRONG> 
                            </TD></TR>
                          <TR>
                            <TD height="20" align="center" 
                            id="interfacestatus"></TD></TR></TBODY></TABLE></TD></TR>
                    <TR>
                      <TD align="center"><!-- 显示图片 -->         
                        <DIV id="cutDiv">
                        <DIV id="cutDis" style="background: magenta; left: 0px; top: 0px; width: 0px; height: 0px; visibility: visible; position: absolute; z-index: 5; opacity: 0.5; -moz-opacity: 0.5; -khtml-opacity: 0.5;"></DIV>
                        <TABLE>
                          <TBODY>
                          <TR>
                            <TD><IMG name="zoomGraphImage" width="400" height="200" 
                              id="traffic" ondragstart="return false" ondrag="return false" 
                              ondragend="return false" src="{{$template_root}}/images/cpupic.png" 
                              lowsrc="servlet/ImageDisplay?filename=mocha_1372739116781_.png" 
                              imgid="" item=""></TD>
                            <TD><IMG name="zoomGraphImage" width="400" height="200" 
                              id="packet" ondragstart="return false" ondrag="return false" 
                              ondragend="return false" src="{{$template_root}}/images/cpupic.png" 
                              lowsrc="servlet/ImageDisplay?filename=mocha_1372739116781_.png" 
                              imgid="" item=""> </TD></TR></TBODY></TABLE></DIV></TD></TR>
                    <TR>
                      <TD height="20" align="center">当前采集时间:2013-09-05 
                      13:40:00</TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><!--div style="width:922px;height:600px;OVERFLOW-Y:auto"--> 
                      
            <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
              <TBODY>
              <TR>
                <TD align="right"><IMG style="cursor: hand;" onClick="openwindowNoResizeScroll('incConfigMetric.jsp?instanceId=649633404A1F04D7C3FB94A32F746459F3671681',600,400,'setMetricOfView')" 
                  alt="指标配置" 
                src="{{$template_root}}/images/zhibiao.gif">&nbsp;&nbsp;&nbsp;&nbsp;</TD></TR>
              <TR>
                <TD align="left" valign="top">
                  <TABLE width="100%" border="0" cellspacing="0" 
cellpadding="0">
                    <TBODY>
                    <TR>
                      <TD width="19"><IMG width="19" src="{{$template_root}}/images/01a.gif"></TD>
                      <TD width="90" align="center" valign="middle" bgcolor="#ffffff"><SPAN 
                        class="lanzi_x"><NOBR>接口一览</NOBR></SPAN></TD>
                      <TD background="{{$template_root}}/images/02a.gif">&nbsp;</TD>
                      <TD width="23"><IMG width="23" src="{{$template_root}}/images/03a.gif"></TD></TR></TBODY></TABLE>
                  <TABLE width="100%" border="0" cellspacing="0" 
cellpadding="0">
                    <TBODY>
                    <TR>
                      <TD width="10" 
                      background="{{$template_root}}/images/04a.gif">&nbsp;</TD>
                      <TD width="930" align="left" valign="top">
                        <TABLE width="920" bordercolorlight="#d4d4d4" 
                        bordercolordark="#ffffff" bgcolor="#f9f9f9" border="0" 
                        cellspacing="0" cellpadding="0">
                          <TBODY>
                          <TR>
                            <TD width="200" align="center" valign="middle" 
                            bgcolor="#d6e8ff">
                              <TABLE height="22" border="0" cellspacing="0" 
                              cellpadding="0">
                                <TBODY>
                                <TR>
                                <TD align="center" valign="middle" 
                                rowspan="2"><A style="color: black; text-decoration: none;" 
                                href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=port_describe&orderby2=desc"><NOBR><STRONG>接口名称</STRONG></NOBR></A></TD>
                                <TD height="11" align="center" 
                                valign="bottom"><A onClick="showOrderBy('-1', 'asc');return false;" 
                                href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=err_packet_out&orderby2=asc#"><IMG 
                                width="10" height="8" align="absmiddle" src="{{$template_root}}/images/st-paixus.gif" 
                                border="0"></A></TD></TR>
                                <TR>
                                <TD height="11" align="center" valign="top"><A 
                                onclick="showOrderBy('-1', 'desc');return false;" 
                                href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=err_packet_out&orderby2=asc#"><IMG 
                                width="10" height="6" align="absmiddle" src="{{$template_root}}/images/st-paixu.gif" 
                                border="0"></A></TD></TR></TBODY></TABLE></TD>
                            <TD align="center" bgcolor="#d6e8ff"><A 
                              style="color: black; text-decoration: none;" href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=datetime&orderby2=desc"><NOBR><STRONG>采集时间</STRONG></NOBR></A></TD>
                            <TD align="center" bgcolor="#d6e8ff"><A 
                              style="color: black; text-decoration: none;" href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=cur_status&orderby2=desc"><NOBR><STRONG>状态</STRONG></NOBR></A></TD>
                            <TD width="85" height="46" align="center" valign="middle" 
                            bgcolor="#d6e8ff">
                              <TABLE height="22" border="0" 
                              cellspacing="0" cellpadding="0">
                                <TBODY>
                                <TR>
                                <TD align="center" valign="middle" 
                                rowspan="2"><NOBR><STRONG>流量<br>
                                  入速率</STRONG></NOBR></TD>
                                <TD height="11" align="center" 
                                valign="bottom"><A href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=traffic_in&orderby2=desc"><IMG 
                                width="10" height="8" align="absmiddle" src="{{$template_root}}/images/st-paixus.gif" 
                                border="0"></A></TD></TR>
                                <TR>
                                <TD height="11" align="center" valign="top"><A 
                                href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=traffic_in&orderby2=asc"><IMG 
                                width="10" height="6" align="absmiddle" src="{{$template_root}}/images/st-paixu.gif" 
                                border="0"></A></TD></TR></TBODY></TABLE></TD>
                            <TD width="85" height="46" align="center" valign="middle" 
                            bgcolor="#d6e8ff">
                              <TABLE height="22" border="0" 
                              cellspacing="0" cellpadding="0">
                                <TBODY>
                                <TR>
                                <TD align="center" valign="middle" 
                                rowspan="2"><NOBR><STRONG>流量<br>
                                  出速率</STRONG></NOBR></TD>
                                <TD height="11" align="center" 
                                valign="bottom"><A href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=traffic_out&orderby2=desc"><IMG 
                                width="10" height="8" align="absmiddle" src="{{$template_root}}/images/st-paixus.gif" 
                                border="0"></A></TD></TR>
                                <TR>
                                <TD height="11" align="center" valign="top"><A 
                                href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=traffic_out&orderby2=asc"><IMG 
                                width="10" height="6" align="absmiddle" src="{{$template_root}}/images/st-paixu.gif" 
                                border="0"></A></TD></TR></TBODY></TABLE></TD>
                            <TD width="85" height="46" align="center" valign="middle" 
                            bgcolor="#d6e8ff">
                              <TABLE height="22" border="0" 
                              cellspacing="0" cellpadding="0">
                                <TBODY>
                                <TR>
                                <TD align="center" valign="middle" 
                                rowspan="2"><NOBR><STRONG>入包速率<BR>(KBps)</STRONG></NOBR></TD>
                                <TD height="11" align="center" 
                                valign="bottom"><A href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=packet_in&orderby2=desc"><IMG 
                                width="10" height="8" align="absmiddle" src="{{$template_root}}/images/st-paixus.gif" 
                                border="0"></A></TD></TR>
                                <TR>
                                <TD height="11" align="center" valign="top"><A 
                                href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=packet_in&orderby2=asc"><IMG 
                                width="10" height="6" align="absmiddle" src="{{$template_root}}/images/st-paixu.gif" 
                                border="0"></A></TD></TR></TBODY></TABLE></TD>
                            <TD width="85" height="46" align="center" valign="middle" 
                            bgcolor="#d6e8ff">
                              <TABLE height="22" border="0" 
                              cellspacing="0" cellpadding="0">
                                <TBODY>
                                <TR>
                                <TD align="center" valign="middle" 
                                rowspan="2"><NOBR><STRONG>出包速率<BR>(KBps)</STRONG></NOBR></TD>
                                <TD height="11" align="center" 
                                valign="bottom"><A href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=packet_out&orderby2=desc"><IMG 
                                width="10" height="8" align="absmiddle" src="{{$template_root}}/images/st-paixus.gif" 
                                border="0"></A></TD></TR>
                                <TR>
                                <TD height="11" align="center" valign="top"><A 
                                href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=packet_out&orderby2=asc"><IMG 
                                width="10" height="6" align="absmiddle" src="{{$template_root}}/images/st-paixu.gif" 
                                border="0"></A></TD></TR></TBODY></TABLE></TD>
                            <TD width="85" height="46" align="center" valign="middle" 
                            bgcolor="#d6e8ff">
                              <TABLE height="22" border="0" 
                              cellspacing="0" cellpadding="0">
                                <TBODY>
                                <TR>
                                <TD align="center" valign="middle" 
                                rowspan="2"><NOBR><STRONG>入错包<BR>(KBps)</STRONG></NOBR></TD>
                                <TD height="11" align="center" 
                                valign="bottom"><A href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=err_packet_in&orderby2=desc"><IMG 
                                width="10" height="8" align="absmiddle" src="{{$template_root}}/images/st-paixus.gif" 
                                border="0"></A></TD></TR>
                                <TR>
                                <TD height="11" align="center" valign="top"><A 
                                href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=err_packet_in&orderby2=asc"><IMG 
                                width="10" height="6" align="absmiddle" src="{{$template_root}}/images/st-paixu.gif" 
                                border="0"></A></TD></TR></TBODY></TABLE></TD>
                            <TD width="85" height="46" align="center" valign="middle" 
                            bgcolor="#d6e8ff">
                              <TABLE height="22" border="0" 
                              cellspacing="0" cellpadding="0">
                                <TBODY>
                                <TR>
                                <TD align="center" valign="middle" 
                                rowspan="2"><NOBR><STRONG>出错包<BR>(KBps)</STRONG></NOBR></TD>
                                <TD height="11" align="center" 
                                valign="bottom"><A href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=err_packet_out&orderby2=desc"><IMG 
                                width="10" height="8" align="absmiddle" src="{{$template_root}}/images/st-paixus.gif" 
                                border="0"></A></TD></TR>
                                <TR>
                                <TD height="11" align="center" valign="top"><A 
                                href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&orderby1=err_packet_out&orderby2=asc"><IMG 
                                width="10" height="6" align="absmiddle" src="{{$template_root}}/images/st-paixu.gif" 
                                border="0"></A></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
                        <DIV id="leftdiv" style="width: 938px; height: 120px;   z-index:1;   overflow:auto;">
                        <TABLE width="100%" align="center" bordercolorlight="#d4d4d4" 
                        bordercolordark="#ffffff" bgcolor="#f9f9f9" border="1" 
                        cellspacing="0" cellpadding="0">
                          <TBODY>
						 {{section name=i loop=$interfaces}}
                            <tr >
                              <td width="230" title="{{$interfaces[i].port_describe}}" onclick="javascript:showPic({{$interfaces[i].id}}, {{$smarty.section.i.index}})"><nobr><img style="cursor:hand" src='{{$template_root}}/images/Gray.gif'  id="index_{{$smarty.section.i.index}}" /><span style="width:50; overflow: hidden; text-overflow:hidden;"><nobr>&nbsp;{{$interfaces[i].port_describe|truncate:10}}</nobr></span></nobr></td>
                              <td width="120" onclick="javascript:showPic({{$interfaces[i].id}}, {{$smarty.section.i.index}})"><NOBR>&nbsp;{{$interfaces[i].datetime}}</NOBR></td>
                             <td width="98" onclick="javascript:showPic({{$interfaces[i].id}}, {{$smarty.section.i.index}})" id="interfacestatus_{{$smarty.section.i.index}}"><NOBR>&nbsp;{{$interfaces[i].cur_status}}</NOBR></td>
                              <td width="98" height="30" align="center" id="01" style="" onclick="javascript:showPic({{$interfaces[i].id}}, {{$smarty.section.i.index}})"><nobr>&nbsp;{{$interfaces[i].traffic_in}} </nobr> </td>
                              <td width="98" height="30" align="center" id="02" style="" onclick="javascript:showPic({{$interfaces[i].id}}, {{$smarty.section.i.index}})"><nobr> &nbsp;{{$interfaces[i].traffic_out}} </nobr> </td>
                              <td width="98" height="30" align="center" id="03" style="" onclick="javascript:showPic({{$interfaces[i].id}}, {{$smarty.section.i.index}})"><nobr> &nbsp;{{$interfaces[i].packet_in}} </nobr> </td>
                              <td width="98" height="30" align="center" id="04" style="" onclick="javascript:showPic({{$interfaces[i].id}}, {{$smarty.section.i.index}})"><nobr> &nbsp;{{$interfaces[i].packet_out}} </nobr> </td>
                              <td width="98" height="30" align="center" id="05" style="" onclick="javascript:showPic({{$interfaces[i].id}}, {{$smarty.section.i.index}}, 1)"><nobr> &nbsp;{{$interfaces[i].err_packet_in}} </nobr> </td>
							  <td width="98" height="30" align="center" id="05" style="" onclick="javascript:showPic({{$interfaces[i].id}}, {{$smarty.section.i.index}}, 1)"><nobr>&nbsp;{{$interfaces[i].err_packet_out}} </nobr> </td>
                            </tr>
							{{/section}}
						  </TBODY></TABLE>
                        </DIV></TD>
                      <TD width="20" 
                      background="{{$template_root}}/images/05a.gif">&nbsp;</TD>
                    </TR></TBODY></TABLE>
                  <TABLE width="100%" border="0" cellspacing="0" 
cellpadding="0">
                    <TBODY>
                    <TR>
                      <TD width="32" valign="top"><IMG width="32" height="17" 
                        src="{{$template_root}}/images/06a.gif"></TD>
                      <TD background="{{$template_root}}/images/07a.gif">&nbsp;</TD>
                      <TD width="30" valign="top"><IMG width="30" height="17" 
                        src="{{$template_root}}/images/08a.gif"></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
    <TD width="14" 
  background="{{$template_root}}/images/mid_right2.gif">&nbsp;</TD></TR></TBODY></TABLE>
<TABLE width="1000" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD width="34" valign="top"><IMG width="34" height="20" src="{{$template_root}}/images/bottom_left2.gif"></TD>
    <TD background="{{$template_root}}/images/bottom_mid2.gif">&nbsp;</TD>
    <TD width="30" valign="top"><IMG width="30" height="20" src="{{$template_root}}/images/bottom_right2.gif"></TD></TR></TBODY></TABLE></DIV>

 <script >

  </script>
<script type="text/javascript">

function showPic(id, index, showerror){
	var len = {{if $smarty.section.i.total<=0 }}0{{else}}{{$smarty.section.i.total}}{{/if}};
	for(var i=0; i< len; i++){
		document.getElementById('index_'+i).src='{{$template_root}}/images/Gray.gif';
	}
	document.getElementById('index_'+index).src='{{$template_root}}/images/Green.gif';
	document.getElementById('traffic').attributes['imgid'].nodeValue=id;
	document.getElementById('traffic').src="admin.php?controller=admin_monitor&action=interface_image&type=traffic&id="+id+"&"+parseInt(10000*Math.random());
	document.getElementById('interfacestatus').innerHTML = document.getElementById('interfacestatus_'+index).innerHTML;
	if(showerror!=undefined){
		document.getElementById('packet').src="admin.php?controller=admin_monitor&action=interface_image&type=err_packet&id="+id+"&"+parseInt(10000*Math.random());
	}else{
		document.getElementById('packet').src="admin.php?controller=admin_monitor&action=interface_image&type=packet&id="+id+"&"+parseInt(10000*Math.random());
		//document.getElementById('err_packet_img').style.display = 'none';
	}
}


function reloadimg(duration){
	id=document.getElementById('traffic').attributes['imgid'].nodeValue;
	document.getElementById('traffic').src="admin.php?controller=admin_monitor&action=interface_image&type=traffic&id="+id+"&duration="+duration+"&"+parseInt(10000*Math.random());
	document.getElementById('packet').src="admin.php?controller=admin_monitor&action=interface_image&type=packet&id="+id+"&duration="+duration+"&"+parseInt(10000*Math.random());
	//document.getElementById('err_packet').src="admin.php?controller=admin_monitor&action=interface_image&type=err_packet&id="+id+"&duration="+duration+"&"+parseInt(10000*Math.random());
}

showPic({{$interfaces.0.id}},0)

var cal = Calendar.setup({
    onSelect: function(cal) { 
				cal.hide();
				id=document.getElementById('traffic').attributes['imgid'].nodeValue;
				document.getElementById('traffic').src="admin.php?controller=admin_monitor&action=interface_image&type=traffic&id="+id+"&duration=&date="+cal.selection.sel[0]+""+"&"+parseInt(10000*Math.random());
				document.getElementById('packet').src="admin.php?controller=admin_monitor&action=interface_image&type=packet&id="+id+"&duration=&date="+cal.selection.sel[0]+""+"&"+parseInt(10000*Math.random());
				//document.getElementById('err_packet').src="admin.php?controller=admin_monitor&action=interface_image&type=err_packet&id="+id+"&duration=&date="+cal.selection.sel[0]+""+"&"+parseInt(10000*Math.random());
			 },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
</script>
<iframe id="hide" name="hide" height=0 width=0 ></iframe>
 </BODY></HTML>
