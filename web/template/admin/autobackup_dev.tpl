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
   {{if $smarty.get.type eq 'run'}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=run">巡检帐号</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autotemplate">巡检管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=detail_config">巡检检测</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autorun_result">检测结果</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
  <script>
  
  </script>
	<td class="" align="center">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_autorun&action=autobackup_edit&type={{$type}}">
	<tr><th colspan="3" class="list_bg"></th></tr>
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.InputthedeviceIP}}
		</td>
		<td width="67%">
			<input name="ip" type="text"><input type=submit class=btn1 value="{{$language.Input}}">
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
			<input type="radio" name="controller" value="{{$alldev[g].device_ip}}" onClick="location.href='admin.php?controller=admin_autorun&action=autobackup_edit&ip={{$alldev[g].device_ip}}&g_id={{$g_id}}&type={{$type}}'">
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


