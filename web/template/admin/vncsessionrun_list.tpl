<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/launchprogram.js"></script>
</head>
<script>
function searchit(){
	var url = "admin.php?controller=admin_vncrun";
	url += "&addr="+document.search.elements.ip.value;
	url += "&user="+document.search.elements.username.value;
	url += "&luser="+document.search.elements.luser.value;
	url += "&start1="+document.search.elements.f_rangeStart.value;
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
	document.search.submit();
	//alert(document.search.elements.action);
	//return false;
	return true;
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

<body>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=gateway_running_list">SSH 实时监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=gateway_running_telnet">Telnet 实时监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_rdprun">RDP实时监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_vncrun">VNC实时监控</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_apppubrun">应用发布实时监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>


   <tr>
    <td class="main_content"><form action="admin.php?controller=admin_vncrun" method="post" name="search" >
				
		{{include file="select_sgroup_ajax.tpl" }}          服务器地址：<input type="text" name="ip"  size="13" align="top" class="wbk"/>
&nbsp;堡垒机用户：<input type="text" name="luser" size="13" class="wbk"/>
&nbsp;系统用户：<input type="text" name="username" size="13" class="wbk"/>
&nbsp;开始日期：<input type="text"  name="f_rangeStart" size="13" id="f_rangeStart" value="" class="wbk"/> 
<input type="button" onClick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
&nbsp;<select  class="wbk"  id="app_act" style="display:none"><option value="applet" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'applet'}}selected{{/if}}>applet</option><option value="activeX" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'activeX'}}selected{{/if}}>activeX</option></select>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
 <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");


</script></form></td>
  </tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"  width="10%">运维用户</th>
						<th class="list_bg"  width="10%">真实姓名</th>
				<th class="list_bg"  width="10%">系统用户</th>
				<th class="list_bg"  width="10%">来源地址</th>
				<th class="list_bg"  width="10%">目标地址</th>
				<th class="list_bg"  width="10%">开始时间</th>
						<th class="list_bg"   width="13%">操作</th>
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 1}}bgcolor="red"{{elseif $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}  onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $allsession[t].dangerous > 1}}red{{elseif $allsession[t].dangerous > 0}}yellow{{elseif $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}');">

					<td><a href="admin.php?controller=admin_vncrun&user={{$allsession[t].user}}">{{$allsession[t].luser}}</a></td>
					<td><a href="admin.php?controller=admin_vncrun&realname={{$allsession[t].realname|urlencode}}">{{$allsession[t].realname}}</a></td>
					<td><a href="admin.php?controller=admin_vncrun&luser={{$allsession[t].luser}}">{{$allsession[t].user}}</a></td>
					<td><a href="admin.php?controller=admin_vncrun&addr={{$allsession[t].cli_addr}}">{{$allsession[t].cli_addr}}</a></td>					
					<td><a href="admin.php?controller=admin_vncrun&addr={{$allsession[t].addr}}">{{$allsession[t].addr}}</a></td>					
					<td>{{$allsession[t].start}}</td>
					
					<td style="TEXT-ALIGN: left;"><img src="{{$template_root}}/images/036.gif" width="16" height="16" align="absmiddle">
					<a  id="p_{{$allsession[t]['sid']}}"  onclick="return go('{{$curr_url}}&mstsc=1&sid={{$allsession[t]['sid']}}','p_{{$allsession[t]['sid']}}')" href="#" target="hide">监控</a>{{*&nbsp;<img src="{{$template_root}}/images/ie.png" width="16" height="16" align="absmiddle"><a href='{{$curr_url}}&activex=1&sid={{$allsession[t]['sid']}}' target="_blank">ACTIVEX</a>&nbsp;*}}| <img src="{{$template_root}}/images/disconnect.png" width="16" height="16" align="absmiddle">
					<a href="admin.php?controller=admin_vncrun&action=cutoff&sid={{$allsession[t]['sid']}}" >断开</a>

						
						{{if $admin_level == 2}} | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_vncrun&action=del_session&sid={{$allsession[t]['sid']}}">删除</a>{{/if}}</td>
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
<iframe id="hide" name="hide" height="0" frameborder="0" scrolling="no"></iframe>
<input style="width:0;height:0;display:none" id="protocol" value="" />
</body>
</html>


