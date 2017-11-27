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
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>

<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">设备目录</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=resource_group">系统用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autotemplate">巡检管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
	
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
          <tr>
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_pro&action=servergroup_bindsave&id={{$id}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
			
         <tr>
	  <td width="33%" align="right"  valign=top>{{$language.bind}}{{$language.group}}</td>
	  <td >
	  <table><tr>
	  {{section name=u loop=$usergroup}}
		<td width="150"><input type="checkbox" name='Group{{$smarty.section.u.index}}' value='{{$usergroup[u].id}}'  {{$usergroup[u].check}}><a onclick="window.open ('admin.php?controller=admin_pro&action=servergroup_selgroup&gid={{$usergroup[u].id}}&sid={{$id}}&sessionlgroup={{$sessionlgroup}}', 'newwindow', 'height=230, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;"  href="#" target="_blank" >{{$usergroup[u].groupname}}</a></td>{{if ($smarty.section.u.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
	  <tr><td></td><td></td></tr>
		<tr>
		<td width="33%" align=right  valign=top>
		{{$language.bind}}{{$language.User}}
		</td>
		<td width="67%">
		<table><tr>
		{{section name=g loop=$allmem}}
		<td width="150"><input type="checkbox" name='Check{{$smarty.section.g.index}}' value='{{$allmem[g].uid}}'  {{$allmem[g].check}}><a onclick="window.open ('admin.php?controller=admin_pro&action=servergroup_seluser&uid={{$allmem[g].uid}}&sid={{$id}}&sessionluser={{$sessionluser}}', 'newwindow', 'height=230, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" >{{$allmem[g].username}}({{if $allmem[g].realname}}{{$allmem[g].realname}}{{else}}未设置{{/if}})</a></td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
	 
	<tr><td></td><td><input type=submit  value="{{$language.Save}}" class="an_02"></td></tr></table>
<input type="hidden" name="sessionlgroup" value="{{$sessionlgroup}}" />
<input type="hidden" name="sessionluser" value="{{$sessionluser}}" />
</form>
	</td>
  </tr>
</table>
</body>
</html>



