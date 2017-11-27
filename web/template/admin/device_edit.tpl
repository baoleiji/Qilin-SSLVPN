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
		<form name="f1" method=post OnSubmit='return check();' action="admin.php?controller=admin_compare&action=device_save&type={{$type}}&id={{$id}}">
		<td width="33%" align=left>
		{{$language.DeviceAddress}}		
		</td>
		<td width="67%">
		<input type=text name="ip" size=35 value="{{$equipip}}" >
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		{{$language.port}}		
		</td>
		<td width="67%">
		<input type=text name="port" size=10 value="{{$port}}" >
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		连接{{$language.LoginMethod}}		
		</td>
		<td width="67%">
		<select  class="wbk"  name="conn_type">
			<option value='telnet' {{if $conn_type=='telnet'}}selected{{/if}}>telnet</option>
			<option value='ssh' {{if $conn_type=='ssh'}}selected{{/if}}>ssh</option>
		</select>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		{{$language.Server}}{{$language.LoginMethod}}		
		</td>
		<td width="67%">
		<select  class="wbk"  name="dev_type">
			<option value='linux' {{if $dev_type=='linux'}}selected{{/if}}>linux</option>
			<option value='huawei' {{if $dev_type=='huawei'}}selected{{/if}}>huawei</option>
			<option value='cisco' {{if $dev_type=='cisco'}}selected{{/if}}>cisco</option>
		</select>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		{{$language.Username}}		
		</td>
		<td width="67%">
		<input type=text name="username" size=10 value="{{$username}}" >{{$language.LoginMethod}}为cisco可空
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		{{$language.Password}}		
		</td>
		<td width="67%">
		<input type=text name="password" size=10 value="{{$password}}" >
	  </td>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		特权{{$language.Password}}		
		</td>
		<td width="67%">
		<input type=text name="enable_pass" size=10 value="{{$enable_pass}}" >
	  </td>
	  </tr>
	  <tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		{{$language.select}}模板		
		</td>
		<td width="67%">
		<select  class="wbk"  name="template">
			<option value="0">n/a</option>
			{{section name=t loop=$template}}
				<option value="{{$template[t].id}}" {{if $oldtemplate == $template[t].id}}selected{{/if}}>{{$template[t].name}}</option>
			{{/section}}
		</select>非linux{{$language.Server}}为n/a
	  </td>
	</tr>
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
/*
   if(!checkIP(f1.ip.value) && f1.netmask.value != '32' ) {
	alert('地址为{{$language.HostName}}时，掩码应为32');
	return false;
   }   
   if(checkIP(f1.ip.value) && !checknum(f1.netmask.value)) {
	alert('请{{$language.Input}}正确掩码');
	return false;
   }
*/
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


