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
    <td  class="hui_bj">Radius地址{{$language.Configure}}</td>
  </tr>
  <tr>
    <td class="main_content">VPN  &nbsp;&nbsp;&nbsp;<input type="button"  value="认证配置" onclick="javascript:document.location='admin.php?controller=admin_eth&action=config_ssh';" class="an_02">&nbsp;&nbsp;&nbsp;
	{{*<input type="button"  value="ftp" onclick="javascript:document.location='admin.php?controller=admin_eth&action=config_ftp';" class="an_02">&nbsp;&nbsp;&nbsp;
	<input type="button"  value="telnet" onclick="javascript:document.location='admin.php?controller=admin_eth&action=config_telnet';" class="an_02">&nbsp;&nbsp;&nbsp;*}}
    <input type="button"  value="VPN" onclick="javascript:document.location='admin.php?controller=admin_eth&action=show_radius';" class="an_02">&nbsp;&nbsp;&nbsp;
    {{*<input type="button"  value="RDP" onclick="javascript:document.location='admin.php?controller=admin_eth&action=config_rdp';" class="an_02">&nbsp;&nbsp;&nbsp;
        <input type="button"  value="Radius" onclick="javascript:document.location='admin.php?controller=admin_config&action=radius';" class="an_02">&nbsp;&nbsp;&nbsp;*}}
            <input type="button"  value="{{$language.LoginTimeout}}" onclick="javascript:document.location='admin.php?controller=admin_config&action=logintimeout';" class="an_02">&nbsp;&nbsp;&nbsp;
    
     </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">Radius地址{{$language.Configure}}</td>
  </tr>
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_eth&action=radius_save">
<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		地址		
		</td>
		<td width="67%">
		<input type=text name="addr" size=35 value="{{$addr}}" >
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		Key		
		</td>
		<td width="67%">
		<input type=text name="key" size=35 value="{{$key}}" >
	  </td>
	</tr>

	
	<tr>
			<td colspan="2" align="center"><input type="submit"  value="{{$language.Save}}"></td>
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


