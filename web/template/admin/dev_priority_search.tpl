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
   <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=resource_group">系统用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_app&action=app_group">应用用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_priority_search">系统权限</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=app_priority_search">应用权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
	
 
   <tr>
    <td class="main_content">
<form name ='f1' action='admin.php?controller=admin_pro&action=dev_priority_search&type=luser' method=post>
					{{$language.4AUsername}}{{$language.User}}<input type="text" class="wbk" name="user">
					{{$language.device}}IP<input type="text" class="wbk" name="ip">
					{{$language.System}}{{$language.User}}<input type="text" class="wbk" name="s_user">
					<input type="button" height="35" align="middle" onClick="return search();" value=" 确定 " border="0" class="bnnew2"/>
					</form>
</td>
  </tr>{{*
   <tr>
    <td class="main_content">
<form name ='f2' action='admin.php?controller=admin_pro&action=dev_priority_search&type=lgroup' method=post>
					{{$language.UserGroup}}&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="wbk" name="group">
					{{$language.device}}IP<input type="text" class="wbk" name="ip">
					{{$language.System}}{{$language.User}}<input type="text" class="wbk" name="s_user">	
&nbsp;&nbsp;<input type="button" height="35" align="middle" onClick="return search2();" value=" 确定 " border="0" class="bnnew2"/>
					</form></td>
  </tr>
*}}
  <tr>
	<td class="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
<script type="text/javascript">
function search(){
	var form = document.f1;
	form.action += "&ip="+form.elements.ip.value+"&s_user="+form.elements.s_user.value+"&user="+form.elements.user.value
	form.submit();
	return true;
}
function search2(){
	var form = document.f2;
	form.action += "&ip="+form.elements.ip.value+"&s_user="+form.elements.s_user.value+"&group="+form.elements.group.value;
	form.submit();
	return true;
}
</script>
                <TBODY>
				
                  <TR>
                    <th class="list_bg" >{{if $type eq 'luser'}}<a href="admin.php?controller=admin_pro&action=dev_priority_search&orderby1=username&orderby2={{$orderby2}}" >运维账号</a>{{elseif $type eq 'lgroup'}}<a href="admin.php?controller=admin_pro&action=dev_group&orderby1=gname&orderby2={{$orderby2}}" >{{$language.UserGroup}}{{/if}}</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=dev_priority_search&orderby1=device_ip&orderby2={{$orderby2}}" >设备目录</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=dev_priority_search&orderby1=device_ip&orderby2={{$orderby2}}" >{{$language.device}}IP</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=dev_priority_search&orderby1=device_ip&orderby2={{$orderby2}}" >主机名</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=dev_priority_search&orderby1=username&orderby2={{$orderby2}}" >{{$language.System}}{{$language.User}}</a></TD>
					<th class="list_bg" >协议</TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=dev_priority_search&orderby1=forbidden_commands_groups&orderby2={{$orderby2}}" >黑白名单</a></TD>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=dev_priority_search&orderby1=weektime&orderby2={{$orderby2}}" >{{$language.WeekTimepolicy}}</a></TD>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=dev_priority_search&orderby1=loginlock&orderby2={{$orderby2}}" >账号锁定</a></TD>
					{{if $type eq 'user'}}<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=dev_priority_search&orderby1=lastdate&orderby2={{$orderby2}}" >{{$language.Logintime}}</a></TD>{{/if}}
					<th class="list_bg" >{{$language.Operate}}</TD>
                  </TR>

            </tr>
			<form name="member_list" action="admin.php?controller=admin_pro&action=devpass_del&ip={{$alldev[0].device_ip}}&serverid={{$serverid}}&gid={{$gid}}" method="post">
			{{section name=t loop=$alldev}}
			<tr {{if $alldev[t].ct > 0 }}bgcolor="red" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{if $type eq 'luser'}}{{$alldev[t].webuser}}{{elseif $type eq 'lgroup'}}{{$alldev[t].gname}}{{/if}}</td>
				<td>{{$alldev[t].groupname}}</td>
				<td>{{$alldev[t].device_ip}}</td>
				<td>{{$alldev[t].hostname}}</td>
				<td>{{$alldev[t].username}}</td>
				<td>{{$alldev[t].login_method}}</td>
				<td>{{$alldev[t].forbidden_commands_groups}}</td>
				<td>{{$alldev[t].policyname}}</td>
				<td>{{if $alldev[t].loginlock}}是{{else}}否{{/if}}</td>
				{{if $type eq 'user'}}<td>{{$alldev[t].lastdate}}</td>{{/if}}
				<td style="TEXT-ALIGN: left;"><img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="{{if $alldev[t].orderby eq '1' or $alldev[t].orderby eq '3'}}admin.php?controller=admin_pro&action=pass_edit&id={{$alldev[t].devicesid}}&ip={{$alldev[t].device_ip}}{{elseif $alldev[t].orderby eq '2' or $alldev[t].orderby eq '4'}}admin.php?controller=admin_pro&action=resourcegroup_bind&id={{$alldev[t].resourceid}}{{/if}}&fromdevpriority=1">{{$language.Edit}}</a></td>
				
			</tr>
			{{/section}}
			
                <tr>
				
	           <td  colspan="12" align="right">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='{{$curr_url}}&page='+this.value;return false;}">{{$language.page}}   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2"  target="hide"><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a>
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


