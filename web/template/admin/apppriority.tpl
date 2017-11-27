<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
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
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=systempriority_search">系统权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=apppriority_search">应用权限</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
   <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=systemaccount">系统账号</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=appaccount">应用账号</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1 or  $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=admin_log">变更报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
	
  <tr>
	<td class="">
<TABLE border=0 cellSpacing=1 cellPadding=5 width="100%" bgColor=#ffffff valign="top" class="BBtable">
                <TBODY>
				
                  <TR>
                    <th class="list_bg" >序号</th>
					{{if $type eq 'luser'}}
                    <th class="list_bg"  width="12%"><a href="admin.php?controller=admin_reports&action=apppriority&orderby1=webuser&orderby2={{$orderby2}}" >运维用户</a></th>    
					<th class="list_bg"  width="12%"><a href="admin.php?controller=admin_reports&action=apppriority&orderby1=webrealname&orderby2={{$orderby2}}" >别名</a></th> 
					{{elseif $type eq 'lgroup'}}
					<th class="list_bg"  width="12%"><a href="admin.php?controller=admin_reports&action=apppriority&orderby1=gname&orderby2={{$orderby2}}" >{{$language.UserGroup}}</a></th>{{/if}}
					{{if $type eq 'luser'}}<th class="list_bg" >运维组</th>{{/if}}
					<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=apppriority&orderby1=device_ip&orderby2={{$orderby2}}" >设备IP</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=apppriority&orderby1=appserverip&orderby2={{$orderby2}}" >应用发布IP</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_reports&action=apppriority&orderby1=appname&orderby2={{$orderby2}}" >应用名称</a></th> 
                    <th class="list_bg"  width="12%"><a href="admin.php?controller=admin_reports&action=apppriority&orderby1=username&orderby2={{$orderby2}}" >应用用户名</a></th>  
					<th class="list_bg"  width="9%"><a href="admin.php?controller=admin_reports&action=apppriority&orderby1=change_password&orderby2={{$orderby2}}" >自动修改密码</a></th>
					<th class="list_bg"  width="6%"><a href="admin.php?controller=admin_reports&action=apppriority&orderby1=enable&orderby2={{$orderby2}}" >激活</a></th>
                  </TR>

            </tr>
			<form name="member_list" action="admin.php?controller=admin_config&action=appdevice_delete" method="post">
			{{section name=t loop=$alldev}}
			<tr {{if $alldev[t].ct > 0 }}bgcolor="red" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$smarty.section.t.index+1}}</td>
				{{if $type eq 'luser'}}
				<td>{{$alldev[t].webuser}}</td>				
				<td>{{$alldev[t].webrealname}}</td>
				{{elseif $type eq 'lgroup'}}<td>{{$alldev[t].gname}}</td>{{/if}}
				{{if $type eq 'luser'}}<td>{{$alldev[t].usergroup}}</td>{{/if}}
				<td>{{$alldev[t].device_ip}}</td>
				<td>{{$alldev[t].appserverip}}</td>
				<td>{{$alldev[t].appname}}</td>
				<td>{{$alldev[t].username}}</td>
				<td>{{if $alldev[t].change_password}}是{{else}}否{{/if}}</td>
				<td>{{if $alldev[t].enable}}是{{else}}否{{/if}}</td>
				
			</tr>
			{{/section}}
			
                <tr>
				<td colspan="2"></td>
	           <td  colspan="8" align="right">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&page='+this.value;">{{$language.page}}</a>   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2" ><img src="{{$template_root}}/images/html.png" border=0></a> <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a>  <a href="{{$curr_url}}&derive=4" ><img src="{{$template_root}}/images/pdf.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1"></a>{{/if}}
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


