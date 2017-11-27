<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
			if(e.name == 'id[]' && e.checked == true)
				return true;
		}
		alert("您没有{{$language.select}}任何{{$language.User}}！");
		return false;
	}
</script>
<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
     <li class="me_{{if $smarty.session.RADIUSUSERLIST}}b{{else}}a{{/if}}"><img src="{{$template_root}}/images/an1{{if $smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an3{{if $smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_{{if $smarty.session.RADIUSUSERLIST}}a{{else}}b{{/if}}"><img src="{{$template_root}}/images/an1{{if !$smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an3{{if !$smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action=usergroup&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="main_content" align="center" width="100%">
	<form name="member_list" action="admin.php?controller=admin_member&action=protect_group_delete" method="post">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  width="3%">{{$language.select}}</th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=protect_group&uid={{$id}}&orderby1=device_ip&orderby2={{$orderby2}}" >{{$language.Host}}IP</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=protect_group&uid={{$id}}&orderby1=hostname&orderby2={{$orderby2}}" >{{$language.HostName}}</a></th>
						<th class="list_bg"  width="15%"><a href="admin.php?controller=admin_member&action=protect_group&uid={{$id}}&orderby1=username&orderby2={{$orderby2}}" >{{$language.LocalUser}}{{$language.User}}</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=protect_group&uid={{$id}}&orderby1=login_method&orderby2={{$orderby2}}" >{{$language.Loginmode}}</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=protect_group&uid={{$id}}&orderby1=forbidden_commands_groups&orderby2={{$orderby2}}" >{{$language.Black}}</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=protect_group&uid={{$id}}&orderby1=weektime&orderby2={{$orderby2}}" >{{$language.WeekTimepolicy}}</a></th>
						<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=protect_group&uid={{$id}}&orderby1=sourceip&orderby2={{$orderby2}}" >{{$language.SourceIP}}</a></th>
						<th class="list_bg"  width="10%">{{$language.Operate}}</th>
					</tr>
					{{section name=t loop=$allpass}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="id[]" value="{{$allpass[t].lid}}"></td>
						<td><a href="admin.php?controller=admin_pro&action=devpass_index&ip={{$allpass[t].device_ip}}">{{$allpass[t].device_ip}}</a></td>
						<td>{{$allpass[t].hostname}}</td>
						<td>{{$allpass[t].username}}</td>
						<td>{{$allpass[t].login_method}}</td>
						<td>{{if $allpass[t].forbidden_commands_groups}}{{$allpass[t].forbidden_commands_groups}}{{else}}无设置{{/if}}</td>
						<td>{{if $allpass[t].weektime}}{{$allpass[t].weektime}}{{else}}无设置{{/if}}</td>
						<td>{{if $allpass[t].sourceip}}{{$allpass[t].sourceip}}{{else}}无设置{{/if}}</td>		
						<td><img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_member&action=protect_edit&ip={{$allpass[t].device_ip}}&uid={{$id}}&g_id={{$allpass[t].groupid}}'>{{$language.Edit}}</a></td>					
										
					</tr>
					{{/section}}
					<tr>
						<td colspan="9" align="left">
							<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='id[]')e.checked=this.form.select_all.checked;}" value="checkbox">{{$language.Selectall}}&nbsp;&nbsp;<input type="submit"  value="{{$language.Deletedevices}}" onclick="my_confirm('{{$language.IPDeleteIPs}}');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&action=protect_group_delete&type=luser'; else return false;" class="an_02">
&nbsp;&nbsp;<input type="button"  value="{{$language.Add}}" onclick="javascript:f1table.style.display=''" class="an_02">						</td>
					</tr>
				<input type="hidden" name="uid" value="{{$id}}" />
				</table>
			</form>
			
			</td></tr>
			<tr><td width="100%" align="center">
	<table id="f1table"  style="display:none"  border=0 width=100% cellpadding=1 cellspacing=1 bgcolor="#FFFFFF" valign=top>

	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_member&action=protect_edit&uid={{$id}}">
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.InputthedeviceIP}}
		</td>
		<td width="67%">
			<input name="ip" type="text" class="wbk"><input type=submit class=btn1 value="{{$language.Input}}">
	  </td>
	</tr>

	<tr>
		<td width="33%" align=right>
		{{$language.select}}{{$language.DeviceGroup}}
		</td>
		<td width="67%">&nbsp;</td>
		
</tr>
		{{section name=g loop=$alldevgroup}}
		<tr {{if $smarty.section.g.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td align=right>
			<input type="radio" name="controller" value="{{$alldevgroup[g].id}}" onClick="location.href='admin.php?controller=admin_member&action=protect_dev&g_id={{$alldevgroup[g].id}}&uid={{$id}}'">
		</td>
		<td>
			{{$alldevgroup[g].groupname}}
		</td>
		</tr>
		{{/section}}
		</table>
	  </td>
	</tr>
	
<br>

</form>
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


