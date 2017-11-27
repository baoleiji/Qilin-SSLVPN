<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HTML><HEAD>
<TITLE>详细信息</TITLE> 
<META http-equiv="Content-Type" content="text/html; charset=utf-8"> <LINK href="{{$template_root}}/cssjs/liye.css" 
rel="stylesheet" type="text/css"> 
<META name="GENERATOR" content="MSHTML 11.00.9600.17801"> 
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
	var rightmainsrc = document.getElementById('rightmain').contentWindow.window.location.href;
	var pos = rightmainsrc.indexOf('&type=');
	if(pos>=0){
		rightmainsrc = rightmainsrc.substring(pos+6);
		pos =  rightmainsrc.indexOf('&');
		rightmainsrc = rightmainsrc.substring(0, pos);
		//window.open('admin.php?controller=admin_index&action=getdocument&ip={{$ip}}&type='+rightmainsrc+'&doctype='+t);
		$.get('admin.php?controller=admin_index&action=getdocument&ip={{$ip}}&type='+rightmainsrc+'&doctype='+t, {"1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
			this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
			//alert(data);
			document.getElementById('documentlist').innerHTML = data;
		});
	}
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
<BODY>
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
                <TD width="104" align="center" id="ciscotab" background="{{$template_root}}/images/bq.gif"><STRONG><A 
                  title="系统状态" class="ly" style="cursor: hand;" href="admin.php?controller=admin_detail&amp;ip={{$ip}}&amp;os=host">系统状态</A>
                  						 </STRONG></TD>
                <TD width="104" align="center" class="diline" id="interfaceViewTab" 
                background="{{$template_root}}/images/bq.gif"><STRONG><A title="接口一览" 
                  class="ly" style="cursor: hand;" href="admin.php?controller=admin_detail&amp;action=cisco_interface&amp;ip={{$ip}}&amp;os=host">接口一览</A>
                  							 </STRONG></TD>
                <TD width="104" align="center" class="diline" id="interfaceViewTab" 
                background="{{$template_root}}/images/bq.gif"><STRONG><A title="参数配置" 
                  class="ly" style="cursor: hand;" href="admin.php?controller=admin_detail&amp;action=parameters&amp;ip={{$ip}}&amp;os=host">参数配置</A>
                  							 </STRONG></TD>
                <TD width="104" align="center" class="diline" id="interfaceViewTab" 
                background="{{$template_root}}/images/bq.gif"><STRONG><A title="备份管理" 
                  class="ly" style="cursor: hand;" href="admin.php?controller=admin_detail&amp;action=status_backup&amp;ip={{$ip}}&amp;from=status">备份管理</A>
                  							 </STRONG></TD>
                <TD width="104" align="center" class="diline" id="interfaceViewTab" 
                background="{{$template_root}}/images/bq.gif"><STRONG><A title="自动脚步" 
                  class="ly" style="cursor: hand;" href="admin.php?controller=admin_detail&amp;action=status_autorun&amp;ip={{$ip}}&amp;from=status">自动脚步</A>
                  							 </STRONG></TD>
                <TD align="middle" class="diline">
                  <TABLE width="100%" border="0" cellspacing="0" 
                    cellpadding="0"><TBODY>
                    <TR>
                      <TD 
align="right">
         <ul class="menu">
            <li>
            	<a target="_blank" href="#" class="tablink" onclick="return false;">文档下载</a>
                <ul id='documentlist'>
                </ul>
            </li>
        </ul>
       </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD align="middle" class="full-lan" valign="top">
            <TABLE width="100%" id="detailInfo" border="0" cellspacing="0" 
            cellpadding="0">
              <TBODY>
              <TR>
                <TD width="235" valign="top"><IFRAME name="iframe2" width="245" 
                  height="586" src="admin.php?controller=admin_detail&action=hostleftmenu&ip={{$ip}}" frameborder="0" 
                  marginwidth="0" marginheight="0" scrolling="No"></IFRAME></TD>
                <TD valign="top"><IFRAME name="rightmain" width="100%" height="586" 
                  id="rightmain" src="admin.php?controller=admin_detail&action=hostview&ip={{$ip}}" frameborder="0" 
                  marginwidth="0" 
          marginheight="0"></IFRAME></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
    <TD width="14" 
  background="{{$template_root}}/images/mid_right2.gif">&nbsp;</TD></TR></TBODY></TABLE>
  <script >
  iframe = document.getElementById('rightmain');
  if (iframe.attachEvent){
    iframe.attachEvent("onload", function(){
		getdocument('pdf');
        //alert("Local iframe is now loaded.");
    });
} else {
    iframe.onload = function(){
		getdocument('pdf');
        //alert("Local iframe is now loaded.");
    };
}
  </script>
<TABLE width="1000" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD width="34" valign="top"><IMG width="34" height="20" src="{{$template_root}}/images/bottom_left2.gif"></TD>
    <TD width="936" background="{{$template_root}}/images/bottom_mid2.gif">&nbsp;</TD>
    <TD width="30" valign="top"><IMG width="30" height="20" src="{{$template_root}}/images/bottom_right2.gif"></TD></TR></TBODY></TABLE></DIV></BODY></HTML>
