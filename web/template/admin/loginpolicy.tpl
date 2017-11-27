<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有{{$language.select}}任何{{$language.User}}！");
		return false;
	}

</script>
<script>
	function searchit(){
		document.search.action = "admin.php?controller=admin_member";
		document.search.action += "&username="+document.search.username.value;
		document.search.submit();
		return true;
	}
	
	function changeuser(){
		if(document.getElementById('groups').style.display=='none'){
			document.getElementById('groups').style.display=''
			document.getElementById('users').style.display='none'
		}else{
			document.getElementById('users').style.display=''
			document.getElementById('groups').style.display='none'
		}
	}

	function changeserver(){
		if(document.getElementById('resources').style.display=='none'){
			document.getElementById('resources').style.display=''
			document.getElementById('servers').style.display='none'
		}else{
			document.getElementById('servers').style.display=''
			document.getElementById('resources').style.display='none'
		}
	}

	function newit(){
		if(document.getElementById('groups').style.display=='none'){
			document.getElementById('groups').disabled=true;
		}else{
			document.getElementById('users').disabled=true;
		}
		if(document.getElementById('resources').style.display=='none'){
			document.getElementById('resources').disabled=true;
		}else{
			document.getElementById('servers').disabled=true;
		}
	}
</script>
</head>
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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=app_priority_search">应用权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
<body>
	
 <TR>
<TD >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
<form  action='admin.php?controller=admin_ipacl&action=loginpolicy' method=post >
  <tr>
    <td >
</td>
    <td >	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 用户/运维组 " onclick="changeuser();" />&nbsp;&nbsp;&nbsp;&nbsp;
					<select name="users" id="users" >
					<option value="99999999" >所有</option>
					{{section name=u loop=$users}}
					<option value="{{$users[u].uid}}" >{{$users[u].username}}</option>
					{{/section}}
					</select>
					<select name="groups" id="groups" style="display:none">
					<option value="99999999" >所有</option>
					{{section name=g loop=$groups}}
					{{if $groups[g].attribute!=2 and $groups[g].level eq 0}}
					<option value="{{$groups[g].id}}" >{{$groups[g].groupname}}</option>
					{{/if}}
					{{/section}}
					</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" value=" 设备/资源组 " onclick="changeserver();" />
					<select name="servers" id="servers" >
					<option value="99999999" >所有</option>
					{{section name=s loop=$servers}}
					<option value="{{$servers[s].id}}" >{{$servers[s].device_ip}}</option>
					{{/section}}
					</select>
					<select name="resources" id="resources" style="display:none">
					<option value="99999999" >所有</option>
					{{section name=sg loop=$resources}}
					<option value="{{$resources[sg].id}}" >{{$resources[sg].groupname}}</option>
					{{/section}}
					</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" value=" 规则 "  />
					<select name="restrictacl" id="restrictacl" >
					<option value="" >所有</option>
					{{section name=a loop=$acl}}
					<option value="{{$acl[a].id}}" >{{$acl[a].aclname}}</option>
					{{/section}}
					</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="submit" height="35" align="middle" onClick="return newit();" border="0" value=" 新建 " class="bnnew2"/>

					</td>
  </tr>
  <input type="hidden" name="ac" value="doinsert" />
</form>	
</table>
</TD>
                  </TR>
	  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	<form name="member_list" action="admin.php?controller=admin_member&action=delete_all" method="post">
					<tr>
						<th class="list_bg"  width="3%" >{{$language.select}}</th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_ipacl&action=loginpolicy&orderby1=username&orderby2={{$orderby2}}' >用户名</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_ipacl&action=loginpolicy&orderby1=groupname&orderby2={{$orderby2}}' >运维组名</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_ipacl&action=loginpolicy&orderby1=device_ip&orderby2={{$orderby2}}' >设备</a></th>
						<th class="list_bg"  width="6%" ><a href='admin.php?controller=admin_ipacl&action=loginpolicy&orderby1=resourceid&orderby2={{$orderby2}}' >资源组</a></th>
						<th class="list_bg"  width="6%" ><a href='admin.php?controller=admin_ipacl&action=loginpolicy&orderby1=aclname&orderby2={{$orderby2}}' >规则名</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_ipacl&action=loginpolicy&orderby1=lifetime&orderby2={{$orderby2}}' >访问日期区间</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_ipacl&action=loginpolicy&orderby1=lifetime&orderby2={{$orderby2}}' >运行时间</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_ipacl&action=loginpolicy&orderby1=ip&orderby2={{$orderby2}}' >客户ip</a></th>
						<th class="list_bg"  width="10%" >{{$language.Operate}}{{$language.Link}}</th>
					</tr>
					{{section name=t loop=$respolicy}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="chk_member[]" value="{{$respolicy[t].rid}}"></td>
						<td>{{if $respolicy[t].memberid eq '99999999'}}所有{{else}}{{$respolicy[t].username}}{{/if}}</td>
						<td>{{if $respolicy[t].usergroupid eq '99999999'}}所有{{else}}{{$respolicy[t].groupname}}{{/if}}</td>
						<td>{{if $respolicy[t].serverid eq '99999999'}}所有{{else}}{{$respolicy[t].device_ip}}{{/if}}</td>
						<td>{{if $respolicy[t].resourceid eq '99999999'}}所有{{else}}{{$respolicy[t].resname}}{{/if}}</td>
						<td>{{$respolicy[t].aclname}}</td>
						<td>{{$respolicy[t].year}}年{{$respolicy[t].year}}月{{$respolicy[t].month}}日星期{{$respolicy[t].day}}时间{{$respolicy[t].time}}</td>
						<td>{{$respolicy[t].lifetime}}</td>
						<td>{{$respolicy[t].ip}}</td>
						<td>	
						<img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_ipacl&action=loginpolicy_edit&id={{$respolicy[t].rid}}">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_ipacl&action=delete_policy&id={{$respolicy[t].rid}}">{{$language.Delete}}</a>			
						</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="4" align="left">
							<input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除" onClick="my_confirm('{{$language.DeleteUsers}}');if(chk_form()) document.member_list.action='admin.php?controller=admin_ipacl&action=delete_policy'; else return false;" class="an_02">
						</td>
						<td colspan="7" align="right">
							{{$language.all}}{{$total}}个{{$language.User}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}个{{$language.User}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&page='+this.value;">{{$language.page}}
						</td>
					</tr>
					
				
		  </form>
					<tr>
						
					</tr>
				</table>
			
	  </table>
		</td>
	  </tr>
	</table>
	<iframe name="hide" height="0" frameborder="0" scrolling="no" id="hide"></iframe>

</body>
</html>


