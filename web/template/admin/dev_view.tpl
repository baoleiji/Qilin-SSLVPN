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
	<td class="main_content" align='center'>
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=devpass_save&id={{$id}}">
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.IPAddress}}
		</td>
		<td width="67%">
		{{$IP}}
	  </td>
	</tr>
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.HostName}}
		</td>
		<td width="67%">
		{{$hostname}}
	  </td>
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
		邮箱
		</td>
		<td width="67%">
		{{$email}}
	  </td>
	</tr>
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Loginmode}}
		</td>
		<td width="67%">
		{{$login_method}}
	  </td>
	</tr>

	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		原始{{$language.Password}}
		</td>
		<td width="67%">
		<input type=text name="password" size=35 value="{{$oldpass}}" >
	  </td>
	</tr>
	{{*
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		现{{$language.Password}}
		</td>
		<td width="67%">
		{{$curpass}}
	  </td>
	</tr>
	*}}
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		上次{{$language.ChangeTime}}
		</td>
		<td width="67%">
		{{if $update_time == '0000-00-00 00:00:00'}}尚未{{$language.Edit}}{{else}}{{$update_time}}{{/if}}
	  </td>
	</tr>
	</table>
<br><input type='submit'  value="{{$language.Edit}}"  class="an_02">
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


