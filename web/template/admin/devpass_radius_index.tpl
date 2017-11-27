<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
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
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	 <li class="me_{{if $smarty.session.RADIUSUSERLIST}}b{{else}}a{{/if}}"><img src="{{$template_root}}/images/an1{{if $smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an3{{if $smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_{{if $smarty.session.RADIUSUSERLIST}}a{{else}}b{{/if}}"><img src="{{$template_root}}/images/an1{{if !$smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an3{{if !$smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action=radiususer&gid={{$gid}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>{{*
			           <td  colspan="6">
		   			<form action="admin.php?controller=admin_pro&action=devpass_index" method="post" >
					{{$language.IPAddress}}<input type="text" class="wbk" name="ip"/>
					{{$language.Username}}<input type="text" class="wbk" name="name"/>
					<input type="submit" class="button" value="{{$language.Search}}">
					</form>
		   </td>*}}
		   		  <form name="member_list" action="admin.php?controller=admin_pro&action=devpass_index" method="post" >
		   
                  <TR>
                  <th class="list_bg"  width="3%">{{$language.select}}</th>
                    <th class="list_bg" >{{$language.HostName}}</TD>
                    <th class="list_bg" >IP</TD>
                    <th class="list_bg" >{{$language.System}}</TD>
					<th class="list_bg" >{{$language.System}}{{$language.User}}</TD>
                    <th class="list_bg" >{{$language.Loginmode}}</TD>
                    <th class="list_bg" >{{$language.Master}}账号</TD>
					<th class="list_bg" >{{$language.Operate}}</TD>
                  </TR>

            </tr>
			{{section name=t loop=$alldev}}
			<tr {{if !$alldev[t].radiususer_is_in_member and $alldev[t].radiususer}}bgcolor='red'{{/if}}>
			<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].id}}"></td>
				<td>{{$alldev[t].hostname}}</td>
				<td>{{$alldev[t].device_ip}}</td>
				<td>{{$alldev[t].device_type}}</td>
				<td>{{if !$alldev[t].username}}空{{$language.User}}{{else}}{{$alldev[t].username}}{{/if}}{{if $smarty.session.ADMIN_LEVEL eq 10}}(<a href='admin.php?controller=admin_pro&action=dev_checkpass&id={{$alldev[t].id}}'>查看</a>){{/if}}</td>				
				<td>{{$alldev[t].login_method}}</td>
				<td>{{if $alldev[t].master_user}}{{$language.Yes}}{{else}}{{$language.No}}{{/if}}</td>
				<td>
				{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 4}}
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=pass_edit&id={{$alldev[t].id}}&ip={{$ip}}&serverid={{$serverid}}'>{{$language.Edit}}</a>

				<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('{{$language.Delete_sure_}}？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=devpass_del&id={{$alldev[t].id}}&ip={{$alldev[t].device_ip}}&serverid={{$serverid}}&gid={{$gid}}';}">{{$language.Delete}}</a>
				{{/if}}
				</td> 
			</tr>
			{{/section}}
			<tr>
	           <td  colspan="4" align="left">
				<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="{{$language.UsersDelete}}" onclick="my_confirm('{{$language.DeleteUsers}}');if(chk_form()) document.member_list.action='admin.php?controller=admin_pro&action=devpass_del&from=dev_priority_search'; else return false;" class="an_06">&nbsp;&nbsp;<input type="button"  value="{{$language.Add}}{{$language.new}}{{$language.User}}" onClick="location.href='admin.php?controller=admin_pro&action=pass_edit&ip={{$ip}}&serverid={{$serverid}}&gid={{$gid}}'"  class="an_06">&nbsp;&nbsp;<input type="button"  value="批量添加用户" onClick="location.href='admin.php?controller=admin_pro&action=pass_batchedit&ip={{$ip}}&serverid={{$serverid}}&gid={{$gid}}'" class="an_06">
		   </td>
              
	           <td  colspan="4" align="right">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&serverid={{$serverid}}&page='+this.value;">{{$language.page}}&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}  导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>{{/if}}&nbsp&nbsp;&nbsp;<input type="button"  value="导出该主机下的用户" onClick="location.href='{{$curr_url}}&derive=3'" class="an_06">
		   </td>
		</tr>
		</form>
		</TBODY>
              </TABLE>	</td>
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



