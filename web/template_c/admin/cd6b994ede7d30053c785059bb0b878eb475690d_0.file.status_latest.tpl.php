<?php /* Smarty version 3.1.27, created on 2016-12-04 12:03:54
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/status_latest.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1541175980584395aae60e75_02177041%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cd6b994ede7d30053c785059bb0b878eb475690d' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/status_latest.tpl',
      1 => 1477708162,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1541175980584395aae60e75_02177041',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'latest' => 0,
    'ha' => 0,
    'uptime' => 0,
    'version' => 0,
    'sn' => 0,
    'cpu' => 0,
    'info' => 0,
    'disk' => 0,
    'memory' => 0,
    'swap' => 0,
    'ssh' => 0,
    'telnets' => 0,
    'sshcommand_num' => 0,
    'sshpage_list' => 0,
    'sshcurr_page' => 0,
    'sshtotal_page' => 0,
    'sshitems_per_page' => 0,
    'telnetcommand_num' => 0,
    'telnetpage_list' => 0,
    'telnetcurr_page' => 0,
    'telnettotal_page' => 0,
    'telnetitems_per_page' => 0,
    'rdprun' => 0,
    'rdprunsession_num' => 0,
    'rdprunpage_list' => 0,
    'rdpruncurr_page' => 0,
    'rdpruntotal_page' => 0,
    'rdprunitems_per_page' => 0,
    'vncrun' => 0,
    'vncrunsession_num' => 0,
    'vncrunpage_list' => 0,
    'vncruncurr_page' => 0,
    'vncruntotal_page' => 0,
    'vncrunitems_per_page' => 0,
    'apppubrun' => 0,
    'apppubrunsession_num' => 0,
    'apppubrunpage_list' => 0,
    'apppubruncurr_page' => 0,
    'apppubruntotal_page' => 0,
    'apppubrunitems_per_page' => 0,
    'onlineusers' => 0,
    'command_num' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
    'logindebug' => 0,
    'member' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_584395ab1165b6_33932766',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_584395ab1165b6_33932766')) {
function content_584395ab1165b6_33932766 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1541175980584395aae60e75_02177041';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['language']->value['Master'];
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 src="./template/admin/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/cn.js"><?php echo '</script'; ?>
>
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
<?php echo '<script'; ?>
 src="./template/admin/cssjs/jquery-1.7.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/launchprogram.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/highcharts.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/exporting.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="JavaScript">
var chart;
	/*$(document).ready(function() {

		var cpu = <?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['cpu'];?>
;
		var memory = <?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['memory'];?>
;
		var disk = <?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['disk'];?>
;
		var swap = <?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['swap'];?>
;
		
//		alert(cpu);
		
	 	var arr = getArray(cpu);
		getPie('cpu','cpu',arr);
		var arr = getArray(memory);
		getPie('memory','memory',arr);
		var arr = getArray(disk);
		getPie('disk','disk',arr);
		var arr = getArray(swap);
		getPie('swap','swap',arr);
		

	});*/
	
	function getArray(param){
		var tmp = new Array();
		var o = new Object();
		var o1 = new Object();
		o.name = "利用率";
		o.num = parseInt(param);
		o1.name = "未利用率";
		o1.num = 100-parseInt(param);
		tmp.push(o1);
		tmp.push(o);
		
		return tmp;
	}

	function getPie(divid,title,arr){
            var data = new Array();
            for(var i=0; i<arr.length;i++){
                    var o = new Object();
                    o.y =  arr[i].num ;
                    o.name = arr[i].name;
                                                
                    data[i] =  o;
              }
	
		chart = new Highcharts.Chart({
					chart: {
						renderTo: divid,
						plotBorderWidth: null,
						marginRight: 0,
						marginLeft: 0,
						marginTop: 0,
						marginBottom: 0,
						plotShadow: false

					},
					title: {
						text: ''
					},
					exporting: { 
			            enabled: false  //设置导出按钮不可用 
			        }, 
					tooltip: {
						formatter: function() {
							return   this.point.name+":"+this.y+"%";
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								formatter: function() {
									return  this.point.name+":<br>"+this.y;
									//return  this.y;
								}
							},
							showInLegend: false
						}
					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: data
					}]
				});
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

function showImg(wTitle, ev ,id)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=600;
	var wHeight=600;
	var bWidth=parseInt(w=window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth);
	var bHeight=parseInt(window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight)+20;
	bHeight=700+20;
	if(isIe){
		setSelectState('hidden');
	}
	var back=document.createElement("div");
	back.id="back";
	var styleStr="top:0px;left:0px;position:absolute;background:#666;width:"+bWidth+"px;height:"+bHeight+"px;";
	styleStr+=(isIe)?"filter:alpha(opacity=0);":"opacity:0;";
	back.style.cssText=styleStr;
	document.body.appendChild(back);
	var mesW=document.createElement("div");
	mesW.id="mesWindow";
	mesW.className="mesWindow";
	mesW.innerHTML="<div><img id=\"1d\" src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1d.gif' onClick=\"reloadimg();\" style=\"cursor:hand;\" alt=\"最近1天\">&nbsp; <img id=\"7d\" src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/7d.gif' onClick=\"reloadimg('week');\" style=\"cursor:hand;\" alt=\"最近7天\">&nbsp; <img id=\"30d\" src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/30d.gif' onClick=\"reloadimg('month');\" style=\"cursor:hand;\" alt=\"最近30天\">&nbsp; <img id=\"365d\" src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/365d.gif' onClick=\"reloadimg('year');\" style=\"cursor:hand;\" alt=\"最近365天\"><div style=\"float:right\"><img id=\"f_rangeStart_trigger\" name=\"f_rangeStart_trigger\" src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/period.gif' style=\"cursor:hand;\" alt=\"自定义时间段\" title=\"自定义时间段\"><input type=\"hidden\"  name=\"f_rangeStart\" size=\"13\" id=\"f_rangeStart\" value=\"\" class=\"wbk\"/></div>&nbsp;&nbsp;<div onclick='closeWindow();'><div class='mesWindowContent' id='mesWindowContent'><img id='zoomGraphImage'  src='admin.php?controller=admin_monitor&action=status_image&type=localstatus&id="+id+"&"+parseInt(10000*Math.random())+"' border=0 ></div><div class='mesWindowBottom'></div></div></div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;		
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
	if(document.getElementById('_mesWindow')!=null)
	{
		document.getElementById('_mesWindow').parentNode.removeChild(document.getElementById('_mesWindow'));
	}
	if(isIe){
		setSelectState('');
	}
	document.getElementById('fade').style.display='none'
	window.parent.reinitIframe();
}
document.onclick=function(){
	var pos = mousePosition(event);
	if(event.srcElement['tagName']!='A'&&event.srcElement['tagName']!='IMG'&&event.srcElement['tagName']!='FONT'){
		closeWindow();
	}
}

function reloadimg(duration){
	var img = document.getElementById("zoomGraphImage");
	img.src=img.src+"&duration="+duration+"&"+parseInt(10000*Math.random());
}

function showAuditUser(wTitle, c)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=260;
	var wHeight=400;
	var bWidth=parseInt(w=window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth);
	var bHeight=parseInt(window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight)+20;
	bHeight=700+20;
	var back=document.createElement("div");
	back.id="back";
	var styleStr="top:0px;left:0px;position:absolute;width:"+bWidth+"px;height:"+bHeight+"px;z-index:1002;";
	//styleStr+=(isIe)?"filter:alpha(opacity=0);":"opacity:0;";
	back.style.cssText=styleStr;
	document.body.appendChild(back);
	var mesW=document.createElement("div");
	mesW.id="_mesWindow";
	mesW.className="_mesWindow";
	mesW.innerHTML='<div id="light" class="white_content" style="height:330px;" ><table width="96%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#eeeeee" align="left" height="25"><a href="javascript:void(0)" onclick="closeWindow()">关闭</a></td></tr></table>'+c+"</div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
	
	document.getElementById('fade').style.display='block'
	return false;
}

function loadurl(url){
	$.get(url, {Action:"get",Name:"lulu"}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		showAuditUser('',data);
	});
}

function change_option(number,index){
 for (var i = 1; i <= number; i++) {
      document.getElementById('current' + i).className = '';
      document.getElementById('content' + i).style.display = 'none';
 }
  document.getElementById('current' + index).className = 'current1';
  document.getElementById('content' + index).style.display = 'block';

  window.parent.reinitIframe();
  return false;
}
function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}
<?php echo '</script'; ?>
>
</head>
<body>
<div id="fade" class="black_overlay"></div> 
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
<td width="84%" align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=serverstatus">服务状态</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=latest">系统状态</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup">配置备份</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting">数据同步</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=upgrade">软件升级</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=cronjob">定时任务</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=changelogo">图标上传</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=notice">系统通知</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
 <tr><td>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="10" bgcolor="#FFFFFF">
  <tr>
    <td width="40%" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#7cb9f2 1px solid;" height=330>
      <tr>
       


              <TH class=list_bg borderColor=white><A  href="#">系统状态</A></TH>
            </TR>
            <TR>
              <TD><table border=0 cellSpacing=3 cellPadding=6 width="100%"  height=336>
                  <tr bgcolor="#f7f7f7">
                    <td height="25">系统状态</td>
                    <td>双机(<?php echo $_smarty_tpl->tpl_vars['ha']->value;?>
)&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['uptime']->value;?>
</td>
                  </tr>
                  <tr>
                    <td height="25">软件版本</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['version']->value;?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;序列号:<?php echo $_smarty_tpl->tpl_vars['sn']->value;?>
</td>
                  </tr>
                  <tr bgcolor="#f7f7f7">
                    <td height="25">SSH连接并发</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['ssh_conn_a'];?>
</td>
                  </tr>
                  <tr>
                    <td height="25">Telnet连接并发</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['telnet_conn_a'];?>
</td>
                  </tr>
                  <tr bgcolor="#f7f7f7">
                    <td height="25">图形会话并发</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['graph_conn_a'];?>
</td>
                  </tr>
                  <tr>
                    <td height="25">FTP会话并发</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['ftp_conn_a'];?>
</td>
                  </tr>
				  <tr>
                    <td height="25">MySQL并发</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['mysql_conn_a'];?>
</td>
                  </tr>
				  <tr bgcolor="#f7f7f7">
                    <td height="25">HTTP并发</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['http_conn_a'];?>
</td>
                  </tr>
                  <tr>
                    <td height="25">设备总数</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['serverct'];?>
</td>
                  </tr>
                  <tr bgcolor="#f7f7f7">
                    <td height="25">主账号数</td>
                    <td><a href="#" onclick="loadurl('admin.php?controller=admin_member&action=showUsersByLevel');return false;" ><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['memberct'];?>
</a></td>
                  </tr>
                  <tr>
                    <td height="25">从账号数</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['devpassct'];?>
</td>
                  </tr>
              </table></TD>
            </TR>    </table></td>
    <td valign="top">
    <TABLE  border=0 cellSpacing=0 style="border:#7cb9f2 1px solid;" cellPadding=5 width="100%"  height=366>
      <TBODY>
        <TR>
          <TH width="40%" class=list_bg>CPU利用率</TH>
          <TH width="40%" class=list_bg>硬盘利用率</TH>
           </TR>
        <TR align="center" bgColor=#FFFFFF>
          <TD>         <p><img style="cursor:hand;" onclick="showImg('cpu利用率',event,'<?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['cpu_seq'];?>
');return false;" src="include/pChart/graphgenerate2.php?data[]=<?php echo $_smarty_tpl->tpl_vars['cpu']->value['used'];?>
&data[]=<?php echo $_smarty_tpl->tpl_vars['cpu']->value['unused'];?>
&<?php echo $_smarty_tpl->tpl_vars['info']->value;?>
&graphtype=pie"></p>
            </TD>
          <TD><img style="cursor:hand;" onclick="showImg('硬盘利用率',event,'<?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['disk_seq'];?>
');return false;" src="include/pChart/graphgenerate2.php?data[]=<?php echo $_smarty_tpl->tpl_vars['disk']->value['used'];?>
&data[]=<?php echo $_smarty_tpl->tpl_vars['disk']->value['unused'];?>
&<?php echo $_smarty_tpl->tpl_vars['info']->value;?>
&graphtype=pie"></TD>
           </TR>
        <TR>
          <TH class=list_bg>内存利用率</TH>
          <TH class=list_bg>SWAP利用率</TH>
           </TR>
        <TR align="center" bgColor=#FFFFFF>
          <TD><img style="cursor:hand;" onclick="showImg('内存利用率',event,'<?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['memory_seq'];?>
');return false;" src="include/pChart/graphgenerate2.php?data[]=<?php echo $_smarty_tpl->tpl_vars['memory']->value['used'];?>
&data[]=<?php echo $_smarty_tpl->tpl_vars['memory']->value['unused'];?>
&<?php echo $_smarty_tpl->tpl_vars['info']->value;?>
&graphtype=pie">        </TD>
          <TD><img style="cursor:hand;" onclick="showImg('SWAP利用率',event,'<?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['swap_seq'];?>
');return false;" src="include/pChart/graphgenerate2.php?data[]=<?php echo $_smarty_tpl->tpl_vars['swap']->value['used'];?>
&data[]=<?php echo $_smarty_tpl->tpl_vars['swap']->value['unused'];?>
&<?php echo $_smarty_tpl->tpl_vars['info']->value;?>
&graphtype=pie"></TD>
         </TR>
      </TBODY>
    </TABLE></td>
  </tr>
 <tr><td colspan="2">
     <DIV id="navbar1" style="width: 100%;">
            <DIV id="header1">
            <UL>
              <LI id="current1"><A onClick="return change_option(6,1);return false;"  href="#">SSH实时监控</A></LI>
              <LI id="current2"><A onClick="return change_option(6,2);return false;"  href="#">Telnet实时监控</A></LI>
              <LI id="current3"><A onClick="return change_option(6,3);return false;"  href="#">RDP实时监控</A></LI>
              <LI id="current4"><A onClick="return change_option(6,4);return false;"  href="#">VNC实时监控</A></LI>
              <LI id="current5"><A onClick="return change_option(6,5);return false;"  href="#">应用发布实时监控</A></LI>
              <LI id="current6"><A onClick="return change_option(6,6);return false;"  href="#">WEB</A></LI></UL></DIV>
            <div id="tabbottom" > 
            <DIV class="content1" id="content1">
            <DIV class="contentMain1">
               <table border=0 cellSpacing=3 cellPadding=6 width="100%">
                  <tr>               
				<th class="list_bg"  width="8%">运维用户</th>
				<th class="list_bg"  width="8%">真实姓名</th>
				<th class="list_bg"  width="8%">系统用户</th>
				<th class="list_bg"  width="10%">来源地址</th>
				<th class="list_bg"  width="10%">目标地址</th>
				<th class="list_bg"  width="10%">开始时间</th>
				<th class="list_bg"  width="10%">堡垒机</th>
				<th class="list_bg"  width="10%">操作</th>
			</tr>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ssh']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total']);
?>
			<tr <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?> onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>');">
				<td><?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['user'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cli_addr'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['addr'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['start'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['baoleiip'];?>
</td>
				<td><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_session&action=cut_running&pid=<?php if ($_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['type'] == 'telnet') {
echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pid'];
} else {
echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pid'];?>
.<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];
}?>" >断开</a>
				| <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ico2.gif" width="16" height="16" align="absmiddle"><a  id="p_<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" href="#" onClick="return go('admin.php?controller=admin_session&action=monitor&luser=<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
&tool=putty.Putty&ltype=<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['type'];?>
&pid=<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pid'];?>
.<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
&type=gateway','p_<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
')" target="hide" >putty</a> | <a  id="c_<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" href="#" onClick="return go('admin.php?controller=admin_session&action=monitor&luser=<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
&tool=securecrt.SecureCRT&pid=<?php if ($_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['type'] == 'telnet') {
echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pid'];
} else {
echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pid'];?>
.<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];
}?>&type=gateway','c_<?php echo $_smarty_tpl->tpl_vars['ssh']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
')" target="hide" >CRT</a>
				</td>
			</tr>
			<?php endfor; endif; ?>
			<tr>
				<td colspan="7" align="right">
					共<?php echo $_smarty_tpl->tpl_vars['sshcommand_num']->value;?>
条  <?php echo $_smarty_tpl->tpl_vars['sshpage_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['sshcurr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['sshtotal_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['sshitems_per_page']->value;?>
条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_status&action=latest&item=1&page='+this.value;">页
				</td>
			</tr>
                </table>
            </DIV></DIV>
            <DIV class="content1" id="content2" style="display: none;">
            <DIV class="contentMain1">
            <TABLE width="100%" class="BBtable" bgcolor="#ffffff" border="0" 
            cellspacing="1" cellpadding="5" align="center" >
              <TBODY>
			  <tr>
				<th class="list_bg"  width="8%">运维用户</th>
				<th class="list_bg"  width="8%">真实姓名</th>
				<th class="list_bg"  width="8%">系统用户</th>
				<th class="list_bg"  width="10%">来源地址</th>
				<th class="list_bg"  width="10%">目标地址</th>
				<th class="list_bg"  width="10%">开始时间</th>
				<th class="list_bg"  width="10%">堡垒机</th>
				<th class="list_bg"  width="10%">操作</th>
			</tr>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['telnets']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total']);
?>
              <tr <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?> onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>');">
				<td><?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['user'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cli_addr'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['addr'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['start'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['baoleiip'];?>
</td>
				<td><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_session&action=cut_running&pid=<?php if ($_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['type'] == 'telnet') {
echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pid'];
} else {
echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pid'];?>
.<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];
}?>">断开</a>
				| <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/ico2.gif" width="16" height="16" align="absmiddle"><a  id="p_<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" href="#" onClick="return go('admin.php?controller=admin_session&action=monitor&luser=<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
&tool=putty.Putty&ltype=<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['type'];?>
&pid=<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pid'];?>
.<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
&type=gateway','p_<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
')" target="hide" >putty</a> | <a  id="c_<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" href="#" onClick="return go('admin.php?controller=admin_session&action=monitor&luser=<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
&tool=securecrt.SecureCRT&pid=<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['pid'];?>
.<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
&type=gateway','c_<?php echo $_smarty_tpl->tpl_vars['telnets']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
')" target="hide" >CRT</a>
				</td>
			</tr>
			<?php endfor; endif; ?>
			<tr>
				<td colspan="7" align="right">
					共<?php echo $_smarty_tpl->tpl_vars['telnetcommand_num']->value;?>
条  <?php echo $_smarty_tpl->tpl_vars['telnetpage_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['telnetcurr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['telnettotal_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['telnetitems_per_page']->value;?>
条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_status&action=latest&item=2&page='+this.value;">页
				</td>
			</tr>
			</TBODY></TABLE></DIV></DIV>
            <DIV class="content1" id="content3" style="display: none;">
            <DIV class="contentMain1">
             <TABLE width="100%" class="BBtable" bgcolor="#ffffff" border="0" 
            cellspacing="1" cellpadding="5" align="center" >
              <TBODY>
             <tr>
				<th class="list_bg"  width="10%">运维用户</th>
				<th class="list_bg"  width="10%">真实姓名</th>
				<th class="list_bg"  width="10%">系统用户</th>
				<th class="list_bg"  width="10%">来源地址</th>
				<th class="list_bg"  width="10%">目标地址</th>
				<th class="list_bg"  width="10%">开始时间</th>
				<th class="list_bg"  width="10%">操作</th>
					</tr>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['rdprun']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total']);
?>
					<tr <?php if ($_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 1) {?>bgcolor="red"<?php } elseif ($_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 0) {?>bgcolor="yellow" <?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?> onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 1) {?>red<?php } elseif ($_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 0) {?>yellow<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>');">

					<td><?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['user'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cli_addr'];?>
</td>					
					<td><?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['addr'];?>
</td>					
					<td><?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['start'];?>
</td>
					<td><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/disconnect.png" width="16" height="16" align="absmiddle">
					<a href="admin.php?controller=admin_rdprun&action=cutoff&sid=<?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" >断开</a> | <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/036.gif" width="16" height="16" align="absmiddle"><a id="p_rdp_<?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" onclick="return go('admin.php?controller=admin_rdprun&mstsc=1&sid=<?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
','p_rdp_<?php echo $_smarty_tpl->tpl_vars['rdprun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
')" href="#" target="hide">监控</a></td>
					</tr>
					<?php endfor; endif; ?>
					<tr>
				<td colspan="7" align="right">
					共<?php echo $_smarty_tpl->tpl_vars['rdprunsession_num']->value;?>
条  <?php echo $_smarty_tpl->tpl_vars['rdprunpage_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['rdpruncurr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['rdpruntotal_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['rdprunitems_per_page']->value;?>
条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_status&action=latest&item=3&page='+this.value;">页
				</td>
			</tr>
					</TBODY></TABLE>
                
                </DIV></DIV>
            <DIV class="content1" id="content4" style="display: none;">
            <DIV class="contentMain1">
             <TABLE width="100%" class="BBtable" bgcolor="#ffffff" border="0" 
            cellspacing="1" cellpadding="5" align="center" >
              <TBODY>
              <tr>
						<th class="list_bg"  width="10%">运维用户</th>
						<th class="list_bg"  width="10%">真实姓名</th>
				<th class="list_bg"  width="10%">系统用户</th>
				<th class="list_bg"  width="10%">来源地址</th>
				<th class="list_bg"  width="10%">目标地址</th>
				<th class="list_bg"  width="10%">开始时间</th>
				<th class="list_bg"  width="10%">操作</th>
					</tr>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['vncrun']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total']);
?>
					<tr <?php if ($_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 1) {?>bgcolor="red"<?php } elseif ($_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 0) {?>bgcolor="yellow" <?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 1) {?>red<?php } elseif ($_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 0) {?>yellow<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>');">

					<td><?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['user'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cli_addr'];?>
</td>					
					<td><?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['addr'];?>
</td>					
					<td><?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['start'];?>
</td>
					<td><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/disconnect.png" width="16" height="16" align="absmiddle">
					<a href="admin.php?controller=admin_vncrun&action=cutoff&sid=<?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" >断开</a> | <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/036.gif" width="16" height="16" align="absmiddle"><a id="p_vnc_<?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" onclick="return go('admin.php?controller=admin_vncrun&mstsc=1&sid=<?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
','p_vnc_<?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
')" href="#" target="hide">监控</a></td>
					</tr>
					<?php endfor; endif; ?>
					<tr>
				<td colspan="7" align="right">
					共<?php echo $_smarty_tpl->tpl_vars['vncrunsession_num']->value;?>
条  <?php echo $_smarty_tpl->tpl_vars['vncrunpage_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['vncruncurr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['vncruntotal_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['vncrunitems_per_page']->value;?>
条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_status&action=latest&item=4&page='+this.value;">页
				</td>
			</tr>
					</TBODY></TABLE>
                </DIV></DIV>
                <DIV class="content1" id="content5" style="display: none;">
            <DIV class="contentMain1">
             <TABLE width="100%" class="BBtable" bgcolor="#ffffff" border="0" 
            cellspacing="1" cellpadding="5" align="center" >
              <TBODY>
              <tr>
						<th class="list_bg"   width="7%">来源地址</th>
						<th class="list_bg"   width="10%">设备地址</th>
						
						<th class="list_bg"   width="7%">堡垒</th>
						<th class="list_bg"   width="7%">真实姓名</th>
						<th class="list_bg"   width="7%">本地</th>
						<th class="list_bg"   width="9%">开始时间</th>
						<th class="list_bg"   width="9%">结束时间</th>
						<th class="list_bg"   width="5%">流量(K)</th>
						<th class="list_bg"  width="10%">操作</th>
					</tr>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['apppubrun']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total']);
?>
					<tr <?php if ($_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 1) {?>bgcolor="red"<?php } elseif ($_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 0) {?>bgcolor="yellow" <?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 1) {?>red<?php } elseif ($_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 0) {?>yellow<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>');">

										<td><a href="admin.php?controller=admin_apppubrun&cli_addr=<?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cli_addr'];?>
"><?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cli_addr'];?>
</a></td>
					
					<td><a href="admin.php?controller=admin_apppubrun&addr=<?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['addr'];?>
"><?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['addr'];?>
</a></td>
					
					<td><a href="admin.php?controller=admin_apppubrun&luser=<?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
"><?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['luser'];?>
</a></td>
					
					<td><a href="admin.php?controller=admin_apppubrun&realname=<?php echo urlencode($_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname']);?>
"><?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname'];?>
</a></td>
					<td><a href="admin.php?controller=admin_apppubrun&user=<?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['user'];?>
"><?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['user'];?>
</a></td>
					<td><?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['start'];?>
</ td>
					<td><?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['end'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['filesize'] >= 1000) {?> <?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['filesize']/sprintf('%.1f',1000);
} else {
echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['filesize']/1000;
}?></td>
					<td><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/disconnect.png" width="16" height="16" align="absmiddle">
					<a href="admin.php?controller=admin_vncrun&action=cutoff&sid=<?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" >断开</a> | <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/036.gif" width="16" height="16" align="absmiddle"><a id="p_apppub_<?php echo $_smarty_tpl->tpl_vars['vncrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
" onclick="return go('admin.php?controller=admin_vncrun&mstsc=1&sid=<?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
','p_apppub_<?php echo $_smarty_tpl->tpl_vars['apppubrun']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
')" href="#" target="hide">监控</a>
					</td>
					</tr>
					<?php endfor; endif; ?>
					<tr>
				<td colspan="7" align="right">
					共<?php echo $_smarty_tpl->tpl_vars['apppubrunsession_num']->value;?>
条  <?php echo $_smarty_tpl->tpl_vars['apppubrunpage_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['apppubruncurr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['apppubruntotal_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['apppubrunitems_per_page']->value;?>
条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_status&action=latest&item=5&page='+this.value;">页
				</td>
			</tr>
					</TBODY></TABLE>
                </DIV></DIV>
                
              <DIV class="content1" id="content6" style="display: none;">
                          <DIV class="contentMain1">
               <TABLE width="100%" class="BBtable" bgcolor="#ffffff" border="0" 
            cellspacing="1" cellpadding="5" align="center" >
              <TBODY>
              <tr>
                            <td align="center" valign="middle"  bgcolor="f7f7f7" class="list_bg"><font size="-1"><b>在线用户名 </b></font></td>
                            <td align="center" valign="middle"  bgcolor="f7f7f7" class="list_bg"><font size="-1"><b>等级 </b></font></td>
                            <td align="center" valign="middle"  bgcolor="f7f7f7" class="list_bg"><font size="-1"><b>登录时间</b></font></td>
                            <td align="center" valign="middle"  bgcolor="f7f7f7" class="list_bg"><font size="-1"><b>最近活动时间</b></font></td>
                            <td align="center" valign="middle"  bgcolor="f7f7f7" class="list_bg"><font size="-1"><b>来访IP </b></font></td>
                          </tr>
                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['u'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['u']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['name'] = 'u';
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['onlineusers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['u']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['u']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['u']['total']);
?>
                          <tr <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['u']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?> >
                            <td align="center" valign="middle" style="height:40px;"><font size="-1"><?php echo $_smarty_tpl->tpl_vars['onlineusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['username'];?>
</font></td>
                            <td align="center" valign="middle" style="height:40px;"><font size="-1"><?php echo $_smarty_tpl->tpl_vars['onlineusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['levelstr'];?>
</font></td>
                            <td align="center" valign="middle" style="height:40px;"><font size="-1"><?php echo $_smarty_tpl->tpl_vars['onlineusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['logindate'];?>
</font></td>
                            <td align="center" valign="middle" style="height:40px;"><font size="-1"><?php echo $_smarty_tpl->tpl_vars['onlineusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['lastactime'];?>
</font></td>
                            <td align="center" valign="middle" style="height:40px;"><font size="-1"><?php echo $_smarty_tpl->tpl_vars['onlineusers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['u']['index']]['ip'];?>
</font></td>
                          </tr>
                        <?php endfor; endif; ?>
						<tr>
				<td colspan="7" align="right">
					共<?php echo $_smarty_tpl->tpl_vars['command_num']->value;?>
条  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_status&action=latest&page='+this.value;">页
				</td>
			</tr>
               </TBODY></TABLE>
                
                
                </DIV></DIV>
                </DIV>
                
                
                                </DIV>
                                  </td></tr>
</table><select  class="wbk"  id="app_act" style="display:none"><option value="applet" <?php if ($_SESSION['ADMIN_DEFAULT_CONTROL'] == 'applet') {?>selected<?php }?>>applet</option><option value="activeX" <?php if ($_SESSION['ADMIN_DEFAULT_CONTROL'] == 'activeX') {?>selected<?php }?>>activeX</option></select>
<?php echo '<script'; ?>
 language="javascript">
function go(url,iid){
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var hid = document.getElementById('hide');
	//document.getElementById(iid).href=url+'&app_act='+app_act;
	url+'&app_act='+app_act;
	$.get(url, {Action:"get",Name:"lulu"}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		if(data.substring(0,10)=='freesvr://'){
			launcher(data);
		}else{
			eval(data);
		}
	});
	//alert(hid.src);
	<?php if ($_smarty_tpl->tpl_vars['logindebug']->value) {?>
	window.open(document.getElementById(iid).href);
	<?php }?>
	return true;	
}
	<?php if ($_smarty_tpl->tpl_vars['member']->value['default_control'] == 0) {?>
	if(navigator.userAgent.indexOf("MSIE")>0) {
	    document.getElementById('app_act').options.selectedIndex = 1;
	}
	<?php } elseif ($_smarty_tpl->tpl_vars['member']->value['default_control'] == 1) {?>
	document.getElementById('app_act').options.selectedIndex = 0;
	<?php } elseif ($_smarty_tpl->tpl_vars['member']->value['default_control'] == 2) {?>
	document.getElementById('app_act').options.selectedIndex = 1;
	<?php }?>
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
change_option(6,<?php if ($_GET['item']) {
echo $_GET['item'];
} else { ?>1<?php }?>);
<?php echo '</script'; ?>
>
<iframe id="hide" name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</BODY></HTML>
<?php }
}
?>