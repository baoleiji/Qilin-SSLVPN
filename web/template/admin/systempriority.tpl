<html>
<head>
<title>{{$title}}</title>
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=systempriority_search">系统权限</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=apppriority_search">应用权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
   <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=systemaccount">系统账号</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=appaccount">应用账号</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1 or  $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=admin_log">变更报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
	
 
  

  <tr>
	<td class="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">

                <TBODY>
				
                  <TR>
					<th class="list_bg" >序号</TD>
					{{if $type eq 'luser'}}
                    <th class="list_bg"  width="12%"><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=webuser&orderby2={{$orderby2}}" >运维用户</a></TD>
					 <th class="list_bg"  width="12%"><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=webrealname&orderby2={{$orderby2}}" >别名</a></TD>
					{{elseif $type eq 'lgroup'}}
					<th class="list_bg"  width="12%"><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=gname&orderby2={{$orderby2}}" >{{$language.UserGroup}}</a></TD>
					{{/if}}
					{{if $type eq 'luser'}}<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=usergroup&orderby2={{$orderby2}}" >运维组</a></TD>{{/if}}
                    <th class="list_bg" ><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=device_ip&orderby2={{$orderby2}}" >{{$language.device}}IP</a></TD>
                    <th class="list_bg"  width="12%"><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=username&orderby2={{$orderby2}}" >{{$language.System}}{{$language.User}}</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=forbidden_commands_groups&orderby2={{$orderby2}}" >{{$language.Black}}</a></TD>
					<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=sourceip&orderby2={{$orderby2}}" >来源IPv4</a></TD>
					<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=sourceipv6&orderby2={{$orderby2}}" >来源IPv6</a></TD>
					<th class="list_bg" width="9%"><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=autosu&orderby2={{$orderby2}}" >自动为超级用户</a></TD>
					<th class="list_bg" width="9%"><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=syslogalert&orderby2={{$orderby2}}" >SYSLOG告警</a></TD>					
					<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=mailalert&orderby2={{$orderby2}}" >Mail告警</a></TD>
					<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=loginlock&orderby2={{$orderby2}}" >账号锁定</a></TD>
					{{if $type eq 'user'}}<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=lastdate&orderby2={{$orderby2}}" >{{$language.Logintime}}</TD>{{/if}}
					<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=systempriority&orderby1=login_method&orderby2={{$orderby2}}" >协议</a></TD>
                  </TR>

            </tr>
			<form name="member_list" action="admin.php?controller=admin_pro&action=devpass_del&ip={{$alldev[0].device_ip}}&serverid={{$serverid}}&gid={{$gid}}" method="post">
			{{section name=t loop=$alldev}}
			<tr {{if $alldev[t].ct > 0 }}bgcolor="red" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$smarty.section.t.index+1}}</td>
				{{if $type eq 'luser'}}
				<td>{{$alldev[t].webuser}}</td>
				<td>{{$alldev[t].webrealname}}</td>
				{{elseif $type eq 'lgroup'}}
				<td>{{$alldev[t].gname}}</td>
				{{/if}}
				{{if $type eq 'luser'}}<td>{{$alldev[t].usergroup}}</td>{{/if}}
				<td>{{$alldev[t].device_ip}}</td>
				<td>{{$alldev[t].username}}</td>
				<td>{{$alldev[t].forbidden_commands_groups}}</td>
				<td>{{$alldev[t].sourceip}}</td>
				<td>{{$alldev[t].sourceipv6}}</td>
				<td>{{if $alldev[t].autosu}}是{{else}}否{{/if}}</td>
				<td>{{if $alldev[t].syslogalert}}是{{else}}否{{/if}}</td>
				<td>{{if $alldev[t].mailalert}}是{{else}}否{{/if}}</td>
				<td>{{if $alldev[t].loginlock}}是{{else}}否{{/if}}</td>
				{{if $type eq 'user'}}<td>{{$alldev[t].lastdate}}</td>{{/if}}
				<td>{{$alldev[t].login_method}}</td>
				
			</tr>
			{{/section}}			
                <tr>				
	           <td  colspan="14" align="right">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&page='+this.value;">{{$language.page}}  导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2" ><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a>  <a href="{{$curr_url}}&derive=4" ><img src="{{$template_root}}/images/pdf.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1"></a>{{/if}}
		   </td>
		</tr>
		</form>
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


