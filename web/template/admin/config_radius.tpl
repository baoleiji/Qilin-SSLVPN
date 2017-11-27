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
    <td  class="hui_bj">Radius{{$language.Configure}}</td>
  </tr>
  <tr>
    <td class="main_content">Radius  &nbsp;&nbsp;&nbsp;<input type="button"  value="ssh" onclick="javascript:document.location='admin.php?controller=admin_config&action=config_ssh';" class="an_02">&nbsp;&nbsp;&nbsp;
	<input type="button"  value="ftp" onclick="javascript:document.location='admin.php?controller=admin_config&action=config_ftp';" class="an_02">&nbsp;&nbsp;&nbsp;
	<input type="button"  value="telnet" onclick="javascript:document.location='admin.php?controller=admin_config&action=config_telnet';" class="an_02">&nbsp;&nbsp;&nbsp;
    <input type="button"  value="VPN" onclick="javascript:document.location='admin.php?controller=admin_config&action=show_radius';" class="an_02">&nbsp;&nbsp;&nbsp;
    <input type="button"  value="RDP" onclick="javascript:document.location='admin.php?controller=admin_config&action=config_rdp';" class="an_02">&nbsp;&nbsp;&nbsp;
        <input type="button"  value="Radius" onclick="javascript:document.location='admin.php?controller=admin_config&action=radius';" class="an_02">&nbsp;&nbsp;&nbsp;
     <input type="button"  value="{{$language.LoginTimeout}}" onclick="javascript:document.location='admin.php?controller=admin_config&action=logintimeout';" class="an_02">&nbsp;&nbsp;&nbsp;
     </td>
  </tr>
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="50%">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=radius_save">
	<tr bgcolor="f7f7f7">
		<td colspan="2"  align=center>
		Radius{{$language.Configure}}	
		</td>
		
	</tr>
	 
	<tr><td>{{$language.Yes}}{{$language.No}}{{$language.Startup}}radius:</td>
		<td align=left>
		<input type="radio" name="radius_on" {{if $radius.radius_on eq 'yes'}}checked{{/if}} value="yes" />{{$language.Startup}} <input type="radio" name="radius_on" {{if $radius.radius_on eq 'no'}}checked{{/if}} value="no" />{{$language.Shutdown}}
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td>radius地址:</td>
		<td align=left>
		<input type="text" class="wbk" name="radius_server" value="{{$radius.radius_server}}" />
		</td>
		
	</tr>
	<tr><td>radius key:</td>
		<td align=left>
		<input type="text" class="wbk" name="radius_key" value="{{$radius.radius_key}}" />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7">
			<td></td><td align="left"><input type="submit"  value="{{$language.Save}}"></td>
		</tr>

	</table>
	<input type="hidden" name="times_id" value="{{$loginsetting.1['sid']}}" />
	<input type="hidden" name="length_id" value="{{$loginsetting.0['sid']}}" />
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


