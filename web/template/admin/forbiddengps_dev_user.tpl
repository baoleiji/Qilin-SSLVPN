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
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_forbidden&action=protect_save&id={{$id}}&ip={{$ip}}&f_gid={{$f_gid}}&weektime={{$weektime}}">
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Username}}
		</td>
		<td width="67%">
		{{$username}}
	  </td>
	</tr>
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.bindingdevice}}
		</td>
		<td width="67%">
		{{$language.HostName}}{{$allpass[0].hostname}}，{{$language.IPAddress}}{{$allpass[0].device_ip}}
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.groupname}}
		</td>
		<td width="67%">
		{{$gname}}
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Time}}{{$language.List}}
		</td>
		<td width="67%">
		{{$weektime}}
	  </td>
	</tr>
	</table>
<br>
<input type=submit  value="{{$language.Save}}" class="an_02">

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


