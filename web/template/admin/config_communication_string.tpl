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
    <td  class="hui_bj">{{$language.AuthServiceConfigure}}</td>
  </tr>
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="50%">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_eth&action=comm_string_save">
	
	<tr bgcolor="f7f7f7"><td>字符串:</td>
		<td align=left>
		<input type="text" class="wbk" name="secret" value="{{$sshconfig.secret}}" />	
		</td>		
	</tr>
	<tr><td>{{$language.Status}}:</td>
		<td align=left>
		{{if $sshconfig.status eq 1}}<font color="green">正常</font>{{else}}<font color="red">{{$language.Failed}}</font>{{/if}}	 
		|
		{{if $sshconfig.status eq 1}}<a href="admin.php?controller=admin_eth&action=comm_string_chstatus&ac=restart">{{$language.Restart}}</a>{{/if}}
		{{if $sshconfig.status eq 0}}<a href="admin.php?controller=admin_eth&action=comm_string_chstatus&ac=start">{{$language.Start}}</a>{{/if}}
		{{if $sshconfig.status eq 1}}<a href="admin.php?controller=admin_eth&action=comm_string_chstatus&ac=stop">{{$language.Stop}}</a>{{/if}}
			
		</td>		
	</tr>

	<tr bgcolor="f7f7f7">
			<td></td><td align="left"><input type="submit"  value="{{$language.Save}}" class="an_02"></td>
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


