<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
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
	var url = "admin.php?controller=admin_session&backupdb_id={{$backupdb_id}}";
	url += "&addr="+document.search.elements.ip.value;
	url += "&luser="+document.search.elements.luser.value;
	url += "&start1="+document.search.elements.f_rangeStart.value;
	url += "&start2="+document.search.elements.f_rangeEnd.value;
	{{if $_config.LDAP}}
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	{{else}}
	for(var i=0; true; i++){
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
	document.search.action = url;
	document.search.submit();
	//alert(document.search.elements.action);
	//return false;
	return true;
}

function filter1(){
	if(document.getElementById('filtercheck').checked){
		document.location=document.location+'&filter=1';
	}else{
		document.location=document.location+'&filter=0';
	}
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
	if(document.getElementById('light')!=null)
	{
		document.getElementById('light').parentNode.removeChild(document.getElementById('light'));
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

<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />

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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F1F1F1">
  <tr><td valign="middle" class="hui_bj" align="left">
  <div class="menu">
<ul>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&backupdb_id={{$backupdb_id}}">Telnet/SSH</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_x11&backupdb_id={{$backupdb_id}}">X11</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_approve">流程审批</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
</ul>
</div></td></tr>

  <tr>
    <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content"><form action="admin.php?controller=admin_session&backupdb_id={{$backupdb_id}}" method="post" name="search" >
  <tr>
    <td></td>
    <td>
{{include file="select_sgroup_ajax.tpl" }}          
&nbsp;设备地址：<input type="text" name="ip"  size="13" align="top" class="wbk"/>
&nbsp;运维用户：<input type="text" name="luser" size="13" class="wbk"/>
&nbsp;
		开始日期：<input type="text"  name="f_rangeStart" size="13" id="f_rangeStart" value="" class="wbk"/> 
<input type="button" onClick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
&nbsp;结束日期：<input  type="text" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="" class="wbk"/> 
<input type="button" onClick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
&nbsp;<select  class="wbk"  id="app_act" style="display:none"><option value="applet" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'applet'}}selected{{/if}}>applet</option><option value="activeX" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'activeX'}}selected{{/if}}>activeX</option></select>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>&nbsp;&nbsp;<input id="filtercheck" type="checkbox" onclick="filter1();" name="filter" value="1" {{if $filter}}checked{{/if}} >过滤
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
	
					<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=cli_addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.SourceAddress}}</a></th>
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.DeviceAddress}}</a></th>
						
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=type&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.LoginMethod}}</a></th>
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=luser&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.4AUsername}}</a></th>
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=realname&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">真实姓名</a></th>
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=user&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.LocalUser}}</a></th>
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=start&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.StartTime}}</a></th>
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=end&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.EndTime}}</a></th>
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=s_bytes&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">文件(K)</a></th>
						<th class="list_bg">{{$language.Detail}}</th>
						
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].cmd_danger eq 2}}bgcolor="red"{{elseif $allsession[t].cmd_danger eq 3}}bgcolor="yellow"{{elseif $allsession[t].cmd_danger eq 4}}bgcolor="#0373BF"{{elseif $allsession[t].cmd_danger eq 1}}bgcolor="orange" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}} onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $allsession[t].cmd_danger eq 2}}red{{elseif $allsession[t].cmd_danger eq 3}}yellow{{elseif $allsession[t].cmd_danger eq 4}}#0373BF{{elseif $allsession[t].cmd_danger eq 1}}orange {{elseif $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}');">

												<td><a href="admin.php?controller=admin_session&srcaddr={{$allsession[t].cli_addr}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].cli_addr}}</a></td>
						
						<td><a href="admin.php?controller=admin_session&addr={{$allsession[t].addr}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].addr}}</a></td>
						<td><a href="admin.php?controller=admin_session&type={{$allsession[t].type}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].type}}</a></td>
						<td><a href="admin.php?controller=admin_session&luser={{$allsession[t].luser}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].luser}}</a></td>
						<td><a href="admin.php?controller=admin_session&realname={{$allsession[t].realname|urlencode}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].realname}}</a></td>
						<td><a href="admin.php?controller=admin_session&user={{$allsession[t].user}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].user}}</a></td>
						<td>{{$allsession[t].start}}</ td>
						<td>{{$allsession[t].end}}</td>
						<td>{{$allsession[t].s_bytes|string_format:'%.1f'}}</td>
						<td style="TEXT-ALIGN: left;">{{if !$backupdb_id}}<img src="{{$template_root}}/images/replay.gif" width="16" height="16" align="absmiddle"> {{$language.Replay}}(<a href="#" onClick="window.open('admin.php?controller=admin_session&action=replay&sid={{$allsession[t]['sid']}}','','menubar=no,toolbar=no,resizable=yes,height=700,width=700')"><!--Web--></a><a id="p_{{$allsession[t]['sid']}}" onClick="return go('admin.php?controller=admin_session&action=replay&sid={{$allsession[t]['sid']}}&tool=putty.Putty','p_{{$allsession[t]['sid']}}')" href="#" target="hide" >putty</a> | <a  id="c_{{$allsession[t]['sid']}}" onClick="return go('admin.php?controller=admin_session&action=replay&sid={{$allsession[t]['sid']}}&tool=securecrt.SecureCRT','c_{{$allsession[t]['sid']}}');" href="#" target="hide" >CRT</a>) &nbsp;{{/if}}<img src="{{$template_root}}/images/file.gif" width="16" height="16" align="absmiddle"> <a href="#" onclick='window.open("admin.php?controller=admin_session&action=download&sid={{$allsession[t]['sid']}}&start_page=1&command={{$command}}&backupdb_id={{$backupdb_id}}");return false;'>{{$language.File}}</a>&nbsp;&nbsp;<img src="{{$template_root}}/images/cmd.png" width="16" height="16" align="absmiddle"> <a href="admin.php?controller=admin_session&action=view&sid={{$allsession[t]['sid']}}&command={{$command}}&backupdb_id={{$backupdb_id}}">命令(条数:{{$allsession[t].total_cmd}})</a>
						&nbsp;&nbsp;<img src="{{$template_root}}/images/1-1.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_session&desc={{$allsession[t].desc}}&action=logindesc&type=ssh&sessionid={{$allsession[t]['sid']}}" target="hide" ><font style="color:{{if $allsession[t].desc}}red{{else}}black{{/if}}">备注</font></a>
						{{if $allsession[t].logincommit}}&nbsp;&nbsp;<img src="{{$template_root}}/images/1-1.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_session&commit={{$allsession[t].logincommit}}&action=logincommit&type=ssh" target="hide" >说明</a>{{/if}}
						 | <img src="{{$template_root}}/images/down.gif" width="16" height="16" align="absmiddle"> <a href="admin.php?controller=admin_session&action=downloadfile&sid={{$allsession[t]['sid']}}"  target="hide">录像下载</a>
						{{if 0}} |&nbsp;&nbsp;<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"> <a href="admin.php?controller=admin_session&action=del_session&sid={{$allsession[t]['sid']}}">{{$language.Delete}}</a>{{/if}}
						{{if $allsession[t].sub_sid}}
						&nbsp;&nbsp;<img src="{{$template_root}}/images/subsession.gif" width="16" height="16" align="absmiddle"> <a href="admin.php?controller=admin_session&action=view&sid={{$allsession[t]['sid']}}&startcid={{$allsession[t].sub_sid}}">子会话</a>
						{{/if}}						</td>
					</tr>
						{{section name=g loop=$allsession[t].sub}}
							
							<tr {{if $smarty.section.g.index % 2 == 0}}bgcolor="ffffff"{{/if}}>
									<td>子{{$language.Session}}</td>
									<td >{{$allsession[t].sub[g].addr}}</td>
									<td colspan=5>{{$allsession[t].sub[g].type}}</td>
									<td style="TEXT-ALIGN: left;"><img src="{{$template_root}}/images/ico2.gif" width="16" height="16" align="absmiddle"><a href="#" onClick="window.open('admin.php?controller=admin_session&action=replay&sid={{$allsession[t]['sid']}}&cid={{$allsession[t].sub[g].parent_cmd}}','','menubar=no,toolbar=no,resizable=yes,height=700,width=700')">{{$language.Replay}}</a><img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_session&action=view&sid={{$allsession[t]['sid']}}&cid={{$allsession[t].sub[g].parent_cmd}}">{{$language.View}}</a>{{if $admin_level == 2}} | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_session&action=del_session&sid={{$allsession[t]['sid']}}">{{$language.Delete}}</a>{{/if}}</td>
		  </tr>
						{{/section}}

					{{/section}}
					<tr>
						<td height="45" colspan="12" align="right" bgcolor="#FFFFFF">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}
							  <input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;" class="wbk">
							  {{$language.page}}&nbsp;  
						  <!--当前数据表: {{$now_table_name}}--> 
						<!--
						<select  class="wbk"  name="table_name">
						{{section name=t loop=$table_list}}
						<option value="{{$table_list[t]}}" {{if $table_list[t] == $now_table_name}}selected{{/if}}>{{$table_list[t]}}</option>
						{{/section}}
						</select>
						-->					  </td>
					</tr>
				</table>
	</td>
  </tr>
</table></td>
<script language="javascript">
function go(url,iid){
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var hid = document.getElementById('hide');
	url = url+'&app_act='+app_act;
	$.get(url, {Action:"get",Name:"lulu"}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		if(data.substring(0,10)=='freesvr://'){
			launcher(data);
		}/*else if(data.substring(0,30)=="<script language='javascript'>"){
			data = data.substring(30);
			data = data.substring(0,data.length-9);
			eval(data);
		}*/else{
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
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
<iframe id="hide" name="hide" height="0"  frameborder="0" scrolling="no"></iframe>
<input style="width:0;height:0;display:none" id="protocol" value="" />
</body>
</html>


