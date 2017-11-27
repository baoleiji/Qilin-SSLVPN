<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/launchprogram.js"></script>
<script type="text/javascript">
function searchit(){
	var url = "admin.php?controller=admin_x11&backupdb_id={{$backupdb_id}}";
	url += "&addr="+document.search.elements.ip.value;
	url += "&luser="+document.search.elements.user.value;
	url += "&start1="+document.search.elements.f_rangeStart.value;
	url += "&start2="+document.search.elements.f_rangeEnd.value;
	{{if $_config.LDAP}}
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	{{else}}
	for(var i=1; true; i++){
		var obj=document.getElementById('groupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	{{/if}}
	url += "&groupid="+gid;
	{{/if}}
	
	//alert(document.search.elements.action);
	//return false;
	return true;
}

var isIe=(document.all)?true:false;

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
	document.getElementById('fade').style.display='none';
}

function showImg(wTitle, c)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=240;
	var wHeight=300;
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
	mesW.id="mesWindow";
	mesW.className="mesWindow";
	mesW.innerHTML='<div id="light" class="white_content" style="height:230px;width:32%"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#eeeeee" align="right" height="25"><a href="javascript:void(0)" onclick="closeWindow()">关闭</a></td></tr></table>'+c+"</div>";
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
		showImg('',data);
	});
}
function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}
</script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#F1F1F1"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&backupdb_id={{$backupdb_id}}">Telnet/SSH</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_sftp&backupdb_id={{$backupdb_id}}">SFTP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_scp&backupdb_id={{$backupdb_id}}">SCP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ftp&backupdb_id={{$backupdb_id}}">FTP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
{{if $smarty.session.ADMIN_LEVEL ne 0}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_as400&backupdb_id={{$backupdb_id}}">AS400</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
{{/if}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_rdp&backupdb_id={{$backupdb_id}}">RDP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_vnc&backupdb_id={{$backupdb_id}}">VNC</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>   
{{if $backupdb_id}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_apppub&backupdb_id={{$backupdb_id}}">应用发布</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_x11&backupdb_id={{$backupdb_id}}">X11</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_approve">流程审批</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
</ul>
</div></td></tr>
  <tr>
         <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content"><form action="admin.php?controller=admin_x11&backupdb_id={{$backupdb_id}}" method="post" name="search" >
  <tr>
    <td></td>
    <td>
{{include file="select_sgroup_ajax.tpl" }}          
&nbsp;设备地址：<input type="text" class="wbk" name="ip"  size="13" />
运维用户：<input type="text" class="wbk" name="user" size="13" />
&nbsp; 
开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value=""/>
 <input type="button" onClick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">

 结束日期：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd" value=""/>
 <input type="button" onClick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk">
	  

  <select  class="wbk"  id="app_act" style="display:none"><option value="applet" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'applet'}}selected{{/if}}>applet</option><option value="activeX" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'activeX'}}selected{{/if}}>activeX</option></select>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
  </td>
  </tr></form>
</table>
				
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");


</script>
					</td>
  </tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"   width="9%"><a href="admin.php?controller=admin_x11&orderby1=cli_addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">来源地址</a></th>
						<th class="list_bg"   width="9%"><a href="admin.php?controller=admin_x11&orderby1=addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">设备地址</a></th>
						
						<th class="list_bg"   width="6%"><a href="admin.php?controller=admin_x11&orderby1=luser&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">运维</a></th>
						<th class="list_bg"   width="6%"><a href="admin.php?controller=admin_x11&orderby1=realname&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">真实姓名</a></th>
						<th class="list_bg"   width="7%"><a href="admin.php?controller=admin_x11&orderby1=user&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">本地</a></th>
						<th class="list_bg"   width="11%"><a href="admin.php?controller=admin_x11&orderby1=start&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">开始时间</a></th>
						<th class="list_bg"   width="11%"><a href="admin.php?controller=admin_x11&orderby1=end&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">结束时间</a></th>
						<th class="list_bg"   width="5%"><a href="admin.php?controller=admin_x11&orderby1=filesize&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">文件(K)</a></th>
						<th class="list_bg"   width="">详细信息</th>
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 1}}bgcolor="red"{{elseif $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}} onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $allsession[t].dangerous > 1}}red{{elseif $allsession[t].dangerous > 0}}yellow{{elseif $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}');">

										<td><a href="admin.php?controller=admin_x11&srcaddr={{$allsession[t].cli_addr}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].cli_addr}}</a></td>
					
					<td><a href="admin.php?controller=admin_x11&addr={{$allsession[t].addr}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].addr}}</a></td>
					
					<td><a href="admin.php?controller=admin_x11&luser={{$allsession[t].luser}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].luser}}</a></td>
					<td><a href="admin.php?controller=admin_x11&realname={{$allsession[t].realname|urlencode}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].realname}}</a></td>
					<td><a href="admin.php?controller=admin_x11&user={{$allsession[t].user}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].user}}</a></td>
					<td>{{$allsession[t].start}}</ td>
					<td>{{$allsession[t].end}}</td>
					<td>{{if $allsession[t].filesize ge 1000}} {{$allsession[t].filesize/1000|string_format:'%.1f'}}{{else}}{{$allsession[t].filesize/1000}}{{/if}}</td>
					<td style="TEXT-ALIGN: left;">{{if !$backupdb_id}}<img src="{{$template_root}}/images/replay.gif" width="16" height="16" align="absmiddle">
					<a  id="p_{{$allsession[t]['sid']}}" onClick="return go('{{$curr_url}}&mstsc=1&sid={{$allsession[t]['sid']}}','p_{{$allsession[t]['sid']}}')" href="#" target="hide">回放</a>&nbsp;
					
						&nbsp;| <img src="{{$template_root}}/images/input.gif" width="16" height="16" align="absmiddle"><a href="{{$curr_url}}&activex=1&sid={{$allsession[t]['sid']}}&action=inputview" target="_blank">录入</a>
						&nbsp;| <img src="{{$template_root}}/images/mouse.png" width="16" height="16" align="absmiddle"><a href="{{$curr_url}}&activex=1&sid={{$allsession[t]['sid']}}&action=rdpmouse" >鼠标</a>{{else}}<img src="{{$template_root}}/images/file.gif" width="16" height="16" align="absmiddle"> <a href="#" onclick='window.open("admin.php?controller=admin_x11&action=download&sid={{$allsession[t]['sid']}}&start_page=1&command={{$command}}&backupdb_id={{$backupdb_id}}");return false;'>{{$language.File}}</a>&nbsp;&nbsp;{{/if}} 
						&nbsp;&nbsp;<img src="{{$template_root}}/images/1-1.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_session&desc={{$allsession[t].desc}}&action=logindesc&type=x11&sessionid={{$allsession[t]['sid']}}" target="hide" ><font style="color:{{if $allsession[t].desc}}red{{else}}black{{/if}}">备注</font></a>
						{{if $allsession[t].logincommit}}&nbsp;&nbsp;<img src="{{$template_root}}/images/1-1.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_session&commit={{$allsession[t].logincommit}}&action=logincommit&type=rdp" target="hide" >说明</a>{{/if}}
						 | <img src="{{$template_root}}/images/down.gif" width="16" height="16" align="absmiddle"> <a href="admin.php?controller=admin_rdp&action=downloadplayfile&sid={{$allsession[t]['sid']}}"  target="hide">录像下载</a>
						{{if 0}} | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_x11&action=del_session&sid={{$allsession[t]['sid']}}">删除</a>{{/if}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							共{{$session_num}}条会话  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">页 <!--当前数据表: {{$now_table_name}}--> 
						<!--
						<select  class="wbk"  name="table_name">
						{{section name=t loop=$table_list}}
						<option value="{{$table_list[t]}}" {{if $table_list[t] == $now_table_name}}selected{{/if}}>{{$table_list[t]}}</option>
						{{/section}}
						</select>
						-->
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table>
<script language="javascript">
function go(url,iid){
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var hid = document.getElementById('hide');
	url=url+'&app_act='+app_act;
	$.get(url, {Action:"get",Name:"lulu"}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		if(data.substring(0,10)=='freesvr://'){
			launcher(data);
		}else{
			eval(data);
		}
	});
	return false;
}
{{if $member.default_control eq 0}}
	if(navigator.userAgent.indexOf("MSIE")>0) {
		document.getElementById('app_act').options.selectedIndex = 1;
	}
	{{elseif $member.default_control eq 1}}
		document.getElementById('app_act').options.selectedIndex = 0;
	{{elseif $member.default_control eq 2}}
		document.getElementById('app_act').options.selectedIndex = 1;
{{/if}}
</script>

<script>
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
<iframe id="hide" name="hide" height="0"  frameborder="0" scrolling="no"></iframe>
<input style="width:0;height:0;display:none" id="protocol" value="" />
</body>
</html>


