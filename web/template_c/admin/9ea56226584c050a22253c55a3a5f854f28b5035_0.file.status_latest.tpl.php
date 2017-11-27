<?php /* Smarty version 3.1.27, created on 2017-05-07 08:26:19
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/status_latest.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:537389070590e69abb9b1a2_25200552%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ea56226584c050a22253c55a3a5f854f28b5035' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/status_latest.tpl',
      1 => 1483371534,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '537389070590e69abb9b1a2_25200552',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'latest' => 0,
    'ha' => 0,
    'version' => 0,
    'uptime' => 0,
    'sn' => 0,
    'vpnonline' => 0,
    'cpu' => 0,
    'info' => 0,
    'disk' => 0,
    'memory' => 0,
    'swap' => 0,
    'logindebug' => 0,
    'member' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_590e69abc29a00_30795249',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_590e69abc29a00_30795249')) {
function content_590e69abc29a00_30795249 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '537389070590e69abb9b1a2_25200552';
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
)&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="25">软件版本</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['version']->value;?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="25">运行时间</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['uptime']->value;?>
</td>
                  </tr>

				  <tr bgcolor="#f7f7f7">
                    <td height="25">序列号</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['sn']->value;?>
</td>
                  </tr>
                   <tr>
                    <td height="25">VPN并发</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['vpnonline']->value;?>
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
                    <td height="25">用户数量</td>
                    <td><a href="#" onclick="loadurl('admin.php?controller=admin_member&action=showUsersByLevel');return false;" ><?php echo $_smarty_tpl->tpl_vars['latest']->value[0]['memberct'];?>
</a></td>
                  </tr>
                  <tr>
                    <td height="25">绑定用户</td>
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