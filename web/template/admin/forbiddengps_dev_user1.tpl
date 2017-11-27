<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$title}}</td>
  </tr>
  <tr>
	<td class="main_content" align="center">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_forbidden&action=protect_edit&uid={{$id}}&f_gid={{$f_gid}}&weektime={{$weektime}}">
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Username}}
		</td>
		<td width="67%">
		{{$username}}
	  </td>
	</tr>
	
		<tr>
		<td width="33%" align=right>
		{{$language.InputthedeviceIP}}
		</td>
		<td width="67%">
			<input name="ip" type="text"><input type=submit class=btn1 value="{{$language.Input}}">
	  </td>
	</tr>

	<tr bgcolor="f7f7f7">
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
		<tr>
		<td>
			<input type="radio" name="controller" value="{{$alldev[g].device_ip}}" onClick="location.href='admin.php?controller=admin_forbidden&action=protect_edit&ip={{$alldev[g].device_ip}}&uid={{$id}}&g_id={{$g_id}}&f_gid={{$f_gid}}&weektime={{$weektime}}'">
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


