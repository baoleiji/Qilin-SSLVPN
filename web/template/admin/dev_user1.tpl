<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
</ul>
</div></td></tr>
  <tr>
  <script>
  
  </script>
	<td class="main_content" align="center">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_member&action={{if $type ne 'group'}}protect_edit{{else}}protect_groupgrp{{/if}}&uid={{$id}}">
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$grouporuser}}
		</td>
		<td width="67%">
		{{$name}}
	  </td>
	</tr>
	<tr>
		<td width="33%" align=right>
		{{$language.bindeddevice}}
		</td>
		<td width="67%">
		{{section name=t loop=$allpass}}
			<a href="admin.php?controller=admin_pro&action=dev_index&ip={{$allpass[t].device_ip}}">{{$allpass[t].hostname}} : {{$allpass[t].device_ip}} : {{$allpass[t].username}}</a><br>
		{{/section}}
	  </td>
	</tr>
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
		{{$language.select}}{{$language.device}}
		</td>
		<td width="67%">
		<table>
<tr>
		<td>
			#
		</td>
		<td>
			{{$language.HostName}}
		</td>
		<td align="center">
			IP
		</td>

</tr>
		{{section name=g loop=$alldev}}
		<tr {{if $smarty.section.g.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td>
			<input type="radio" name="controller" value="{{$alldev[g].device_ip}}" onClick="location.href='admin.php?controller=admin_member&action={{if $type ne 'group'}}protect_edit{{else}}protect_groupgrp{{/if}}&ip={{$alldev[g].device_ip}}&uid={{$id}}&g_id={{$g_id}}'">
		</td>
		<td>
			{{$alldev[g].hostname}}
		</td>
		<td>
			{{$alldev[g].device_ip}}
		</td>
		</tr>
		{{/section}}
		</table>
	  </td>
	</tr>
	</table>
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


