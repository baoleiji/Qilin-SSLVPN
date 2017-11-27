<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script>
function searchit(){
		document.search.action = "admin.php?controller=admin_session&action=search_html_log";
		document.search.action += "&ssh_or_rdp="+document.getElementById('ssh_or_rdp').options[document.getElementById('ssh_or_rdp').options.selectedIndex].value;
		document.search.action += "&content="+document.getElementById('content').value;
		document.search.action += "&ip="+document.getElementById('ip').value;
		document.search.action += "&remote_user="+document.getElementById('remote_user').value;
		document.search.action += "&radius_user="+document.getElementById('radius_user').value;
		document.search.action += "&start_date="+document.getElementById('f_rangeStart').value;
		document.search.action += "&end_date="+document.getElementById('f_rangeEnd').value;
		document.search.submit();
		//alert(document.search.action);
		//return false;
		return true;
	}
</script>
</head>

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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=search">会话搜索</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=search_html_log">内容搜索</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
	
  
  <tr>
    <td class="main_content">
<form name ='search' action='admin.php?controller=admin_session&action=search_html_log' method=post>
					<select name="ssh_or_rdp" id="ssh_or_rdp" >
					<option value="ssh" {{if $ssh_or_rdp eq 'ssh'}}selected{{/if}}>SSH/Telnet</option>
					<option value="rdp" {{if $ssh_or_rdp eq 'rdp'}}selected{{/if}}>RDP</option>
					</select>
					{{$language.Content}}<input type="text" class="wbk" size="13" name="content" id="content">
					IP<input type="text" class="wbk" name="ip" id="ip" size="13">
					运维用户<input type="text" class="wbk" size="8" name="radius_user" id="radius_user">
					本地用户<input type="text" class="wbk" size="8" name="remote_user" id="remote_user">
					
	 
	  <input type="hidden" name="ac" value="1" />

     {{$language.Starttime}}：<input type="text" class="wbk" name="start_date" size="13" id="f_rangeStart" value="{{$f_rangeStart}}" />
 <input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="bnnew2">
 {{$language.Endtime}}：
<input  type="text" class="wbk" name="end_date" size="13" id="f_rangeEnd"  value="{{$f_rangeEnd}}" />
 <input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="bnnew2">
 <select  class="wbk"  id="app_act" style="display:none"><option value="applet" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'applet'}}selected{{/if}}>applet</option><option value="activeX" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'activeX'}}selected{{/if}}>activeX</option></select>&nbsp;&nbsp;<script language="javascript">
function go(url,iid){
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var hid = document.getElementById('hide');
	document.getElementById(iid).href=url+'&app_act='+app_act;
	//alert(hid.src);
	{{if $logindebug}}
	window.open(document.getElementById(iid).href);
	{{/if}}
	return true;	
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
</script><input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
</form> 
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
  <tr>
	<td class="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">

                <TBODY>
				
  

					</TD>
                  </TR>
                  <TR>
                    <th class="list_bg" >{{$language.Session}}id</TD>
                    <th class="list_bg" >ip</TD>
                    <th class="list_bg" >本地用户</TD>
                    <th class="list_bg" >运维用户</TD>
                    <th class="list_bg" >{{$language.SessionDate}}</TD>
					{{if $ssh_or_rdp ne 'rdp'}}
                    <th class="list_bg" >{{$language.Log}}{{$language.File}}</TD>
                    <th class="list_bg" >{{$language.rows}}</TD>
					{{else}}
					<th class="list_bg" >操作</TD>
					{{/if}}
                  </TR>

            </tr>
			{{section name=t loop=$alllog}}
			<tr {{if $alllog[t].ct > 0 }}bgcolor="red" {{/if}}>
				<td>{{$alllog[t]['sid']}}</td>
				<td>{{$alllog[t].device_ip}}</td>
				<td>{{$alllog[t].user}}</td>
				<td>{{$alllog[t].luser}}</td>
				<td>{{$alllog[t].start}}</td>				
				{{if $ssh_or_rdp ne 'rdp'}}
				<td><a href="admin.php?controller=admin_session&action=search_html_log_download&file={{$alllog[t].logfile}}&start_page=1&line={{$alllog[t].line_num}}" target="_blank">{{$alllog[t].logfile}}</a></td>
				<td>{{$alllog[t].line_num}}</td>
				{{else}}
				<td><a  id="p_{{$alllog[t].id}}" onClick="return go('admin.php?controller=admin_rdp&mstsc=1&sid={{$alllog[t]['sid']}}','p_{{$alllog[t].id}}')" href="#" target="hide">回放</a>&nbsp;| <img src="{{$template_root}}/images/ie.png" width="16" height="16" align="absmiddle">
					<a href='admin.php?controller=admin_rdp&activex=1&sid={{$alllog[t]['sid']}}' target="_blank">ACTIVEX</a>
					
						&nbsp;| <img src="{{$template_root}}/images/input.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_rdp&activex=1&sid={{$alllog[t]['sid']}}&action=inputview" target="_blank">录入</a></TD>
				{{/if}}
				
			</tr>
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
		</TBODY>
              </TABLE>
	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


