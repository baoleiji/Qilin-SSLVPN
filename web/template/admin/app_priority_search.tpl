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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=resource_group">系统用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_app&action=app_group">应用用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_priority_search">系统权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=app_priority_search">应用权限</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
	
  
   <tr>
    <td class="main_content">
<form name ='f1' action='admin.php?controller=admin_pro&action=app_priority_search&type=luser' method=post>
					{{$language.4AUsername}}{{$language.User}}<input type="text" class="wbk" name="user">
					{{$language.device}}IP<input type="text" class="wbk" name="device_ip">
					应用发布IP<input type="text" class="wbk" name="appserverip">
					应用名称<input type="text" class="wbk" name="appname">
					{{$language.System}}{{$language.User}}<input type="text" class="wbk" name="s_user">&nbsp;&nbsp;<input type="button" height="35" align="middle" onClick="return search();" border="0" value=" 确定 " class="bnnew2"/>
					</form>
</td>
  </tr>
   
  <tr>
	<td class="">
<TABLE border=0 cellSpacing=1 cellPadding=5 width="100%" bgColor=#ffffff valign="top" class="BBtable">
<script type="text/javascript">
function search(){
var form = document.f1;
form.action += "&device_ip="+form.device_ip.value+"&s_user="+form.s_user.value+"&user="+form.user.value+"&appserverip="+form.appserverip.value+"&appname="+form.appname.value
form.submit();
return true;

}
function search2(){
var form = document.f2;
form.action += "&device_ip="+form.device_ip.value+"&s_user="+form.s_user.value+"&group="+form.group.value+"&appserverip="+form.appserverip.value
form.submit();
return true;
}
</script>
                <TBODY>
				
                  <TR>
                    <th class="list_bg" >&nbsp;</th>
                    <th class="list_bg" >{{if $type eq 'luser'}}<a href="admin.php?controller=admin_pro&action=app_priority_search&orderby1=webuser&orderby2={{$orderby2}}" >运维账号</a>{{elseif $type eq 'lgroup'}}<a href="admin.php?controller=admin_pro&action=dev_group&orderby1=gname&orderby2={{$orderby2}}" >{{$language.UserGroup}}{{/if}}</a></th>                    
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=app_priority_search&orderby1=device_ip&orderby2={{$orderby2}}" >设备IP</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=app_priority_search&orderby1=appserverip&orderby2={{$orderby2}}" >应用发布IP</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=app_priority_search&orderby1=appname&orderby2={{$orderby2}}" >应用名称</a></th> 
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=app_priority_search&orderby1=username&orderby2={{$orderby2}}" >应用用户名</a></th>  
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=app_priority_search&orderby1=change_password&orderby2={{$orderby2}}" >自动修改密码</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=app_priority_search&orderby1=enable&orderby2={{$orderby2}}" >激活</a></th>
					<th class="list_bg" >{{$language.Operate}}</th>
                  </TR>

            </tr>
			<form name="member_list" action="admin.php?controller=admin_config&action=appdevice_delete" method="post">
			{{section name=t loop=$alldev}}
			<tr {{if $alldev[t].ct > 0 }}bgcolor="red" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].id}}" /></td>
				<td>{{if $type eq 'luser'}}{{$alldev[t].webuser}}{{elseif $type eq 'lgroup'}}{{$alldev[t].gname}}{{/if}}</td>				
				<td>{{$alldev[t].device_ip}}</td>
				<td>{{$alldev[t].appserverip}}</td>
				<td>{{$alldev[t].appname}}</td>
				<td>{{$alldev[t].username}}</td>
				<td>{{if $alldev[t].change_password}}是{{else}}否{{/if}}</td>
				<td>{{if $alldev[t].enable}}是{{else}}否{{/if}}</td>
				<td style="TEXT-ALIGN: left;"><img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller={{if $alldev[t].orderby eq 1 or $alldev[t].orderby eq 3}}admin_config&action=apppub_edit&id={{$alldev[t].apppubid}}&appserverip={{$alldev[t].appserverip}}{{elseif $alldev[t].orderby eq 2 or $alldev[t].orderby eq 4}}admin_app&action=appresourcegroup_bind&id={{$alldev[t].appresourceid}}{{/if}}&from=search">{{$language.Edit}}</a></td>
				
			</tr>
			{{/section}}
			
                <tr>
				<td colspan="2"><input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">{{$language.select}}{{$language.this}}{{$language.page}}{{$language.displayed}}的{{$language.All}}&nbsp;&nbsp;<input type="submit"  value="{{$language.UsersDelete}}" onClick="my_confirm('{{$language.DeleteUsers}}');if(chk_form()) document.member_list.action='admin.php?controller=admin_config&action=appdevice_delete'; else return false;" class="an_06"></td>
	           <td  colspan="8" align="right">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='{{$curr_url}}&page='+this.value;return false;}">{{$language.page}}
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


