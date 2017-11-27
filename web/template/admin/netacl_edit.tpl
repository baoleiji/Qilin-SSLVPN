<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$language.device}}</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
		<form name="f1" method=post OnSubmit='return check();' action="admin.php?controller=admin_auto&action=net_save&type={{$type}}&id={{$id}}">
		<td width="33%" align=left>
		网段IP		
		</td>
		<td width="67%">
		<input type=text name="addr" size=35 value="{{$addr}}"  {{if $admin_level==0}}disabled = "true"{{/if}}>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		子网掩码		
		</td>
		<td width="67%">
		<input type=text name="netmask" size=35 value="{{$netmask}}"  {{if $admin_level==0}}disabled = "true"{{/if}}>

	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		连接{{$language.LoginMethod}}		
		</td>
		<td width="67%">
		<select  class="wbk"  name="conn_type"  {{if $admin_level==0}}disabled = "true"{{/if}}>
			<option value='n/a'>n/a</option>
			<option value='telnet' {{if $conn_type=='telnet'}}selected{{/if}}>telnet</option>
			<option value='ssh' {{if $conn_type=='ssh'}}selected{{/if}}>ssh</option>
		</select>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		{{$language.LocalUsername}}		
		</td>
		<td width="67%">
		<input type=text name="lusername" size=10 value="{{$lusername}}"  {{if $admin_level==0}}disabled = "true"{{/if}}>
	  </td>
	</tr>
	{{if $admin_level == 0}}
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		远程{{$language.Username}}		
		</td>
		<td width="67%">
		<input type=text name="rusername" size=10 value="{{$rusername}}" >
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		{{$language.Password}}		
		</td>
		<td width="67%">
		<input type=text name="password" size=10 value="{{$password}}" >
	  </td>
	  </tr>
	  {{else}}
		<input type=hidden name="rusername" size=10 value="{{$rusername}}" >
		<input type=hidden name="password" size=10 value="{{$password}}" >
	 {{/if}}
		<tr>
			<td colspan="2" align="center"><input type="submit"  value="{{$language.Save}}" class="an_02"></td>
		</tr>

	</table>
</form>

		</table>
	</td>
  </tr>
</table>


<script language="javascript">
<!--
function check()
{
   if(f1.lusername.value=='') {
	alert('{{$language.LocalUser}}{{$language.User}}不能为空');
	return false;
   }
   if(!checkIP(f1.addr.value)) {
	alert('请{{$language.Input}}正确格式的IP');
	return false;
   }
   return true;

}//end check
// -->

function checkIP(ip)
{
	var ips = ip.split('.');
	if(ips.length==4 && ips[0]>=0 && ips[0]<256 && ips[1]>=0 && ips[1]<256 && ips[2]>=0 && ips[2]<256 && ips[3]>=0 && ips[3]<256)
		return ture;
	else
		return false;
}

function checknum(num)
{

	if( isDigit(num) && num > 0 && num < 65535)
		return ture;
	else
		return false;

}

function isDigit(s)
{
var patrn=/^[0-9]{1,20}$/;
if (!patrn.exec(s)) return false;
return true;
}

</script>
</body>
</html>


